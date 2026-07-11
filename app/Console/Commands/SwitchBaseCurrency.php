<?php

namespace App\Console\Commands;

use App\Models\Catalog\Product;
use App\Models\Catalog\ProductVariant;
use App\Models\Currency;
use App\Models\Sales\ShippingMethod;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SwitchBaseCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:switch-base-currency {code : The currency code to make the new base (e.g. PKR)} {--dry-run : Preview the changes without saving} {--force : Skip the confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-base the store on a different currency: converts all catalog/config prices (products, variants, shipping rates, free-shipping threshold) into the new currency, and recomputes every exchange rate relative to it. Historical order/payment/refund records are left untouched, since they reflect what was actually charged at the time.';

    public function handle(): int
    {
        $code = strtoupper($this->argument('code'));
        $dryRun = (bool) $this->option('dry-run');

        $newBase = Currency::where('code', $code)->first();

        if (! $newBase) {
            $this->error("No currency found with code {$code}.");

            return self::FAILURE;
        }

        $oldBase = Currency::where('is_base', true)->first();

        if (! $oldBase) {
            $this->error('No current base currency found.');

            return self::FAILURE;
        }

        if ($oldBase->id === $newBase->id) {
            $this->info("{$code} is already the base currency. Nothing to do.");

            return self::SUCCESS;
        }

        // newBase->exchange_rate is currently expressed relative to the OLD base
        // (e.g. PKR = 278.5 means 1 old-base-unit = 278.5 PKR). That's exactly the
        // factor needed to convert every stored amount from the old base into the
        // new one.
        $factor = (float) $newBase->exchange_rate;

        $this->info("Converting all catalog/config prices from {$oldBase->code} to {$code} (factor: {$factor})...");

        $productCount = Product::count();
        $variantCount = ProductVariant::whereNotNull('price')->count();
        $methodCount = ShippingMethod::whereNotNull('rate')->count();
        $threshold = (float) Setting::getValue('free_shipping_threshold', 'shipping', '0');

        $this->table(
            ['What', 'Count / Value'],
            [
                ['Products', $productCount],
                ['Variants with price override', $variantCount],
                ['Shipping methods with a rate', $methodCount],
                ['Free shipping threshold (before)', number_format($threshold, 2)." {$oldBase->code}"],
                ['Free shipping threshold (after)', number_format($threshold * $factor, 2)." {$code}"],
            ]
        );

        if ($dryRun) {
            $this->warn('Dry run only — no changes were saved. Remove --dry-run to apply.');

            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm("This will permanently rewrite prices for {$productCount} products, {$variantCount} variant overrides, {$methodCount} shipping methods, and the free-shipping threshold. Historical orders/payments are NOT touched. Continue?")) {
            $this->warn('Cancelled.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($factor, $newBase, $oldBase, $code) {
            Product::query()->update([
                'price' => DB::raw("price * {$factor}"),
                'compare_at_price' => DB::raw("compare_at_price * {$factor}"),
                'cost_per_item' => DB::raw("cost_per_item * {$factor}"),
            ]);

            ProductVariant::whereNotNull('price')->update([
                'price' => DB::raw("price * {$factor}"),
            ]);

            ShippingMethod::whereNotNull('rate')->update([
                'rate' => DB::raw("rate * {$factor}"),
            ]);

            $threshold = (float) Setting::getValue('free_shipping_threshold', 'shipping', '0');
            Setting::setValue('free_shipping_threshold', (string) round($threshold * $factor, 2), 'shipping');

            // Re-express every currency's exchange_rate relative to the new base.
            foreach (Currency::all() as $currency) {
                if ($currency->id === $newBase->id) {
                    $currency->update(['exchange_rate' => 1, 'is_base' => true]);
                } elseif ($currency->id === $oldBase->id) {
                    $currency->update(['exchange_rate' => round(1 / $factor, 6), 'is_base' => false]);
                } else {
                    $currency->update(['exchange_rate' => round((float) $currency->exchange_rate / $factor, 6), 'is_base' => false]);
                }
            }

            Currency::forgetActiveCache();
        });

        $this->info("Done. {$code} is now the base currency.");

        return self::SUCCESS;
    }
}
