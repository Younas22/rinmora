<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CheckoutUnavailableItemsException;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Mail\AdminNewOrderNotificationMail;
use App\Mail\CustomerOrderConfirmationMail;
use App\Models\Catalog\Product;
use App\Models\Sales\BankAccount;
use App\Models\Sales\Order;
use App\Models\Sales\PaymentGateway;
use App\Models\Sales\ShippingMethod;
use App\Models\Sales\ShippingZone;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StorefrontCheckoutController extends Controller
{
    public function __construct(protected ImageUploadService $images)
    {
    }

    public function options()
    {
        $paymentMethods = PaymentGateway::enabled()
            ->whereIn('code', ['cod', 'bank_transfer'])
            ->orderBy('sort_order')
            ->get(['code', 'name'])
            ->map(fn (PaymentGateway $gateway) => [
                'code' => $gateway->code,
                'name' => $gateway->name,
            ]);

        $bankAccounts = BankAccount::active()
            ->orderBy('sort_order')
            ->get(['id', 'bank_name', 'account_title', 'account_number', 'iban']);

        $shippingMethods = ShippingMethod::whereHas('zone', fn ($q) => $q->where('is_active', true))
            ->with('zone:id,name')
            ->orderBy('zone_id')
            ->orderBy('sort_order')
            ->get()
            ->map(fn (ShippingMethod $method) => [
                'id' => $method->id,
                'zone_name' => $method->zone->name,
                'name' => $method->name,
                'delivery_time' => $method->delivery_time,
                'rate' => $method->rate !== null ? (float) $method->rate : 0.0,
            ]);

        return response()->json([
            'payment_methods' => $paymentMethods,
            'bank_accounts' => $bankAccounts,
            'shipping_methods' => $shippingMethods,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:255',

            'shipping_name' => 'required|string|max:255',
            'shipping_address_line1' => 'required|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_zip' => 'nullable|string|max:255',
            'shipping_country' => 'required|string|max:255',
            'shipping_phone' => 'nullable|string|max:255',

            'billing_same_as_shipping' => 'nullable|boolean',
            'billing_name' => 'nullable|string|max:255',
            'billing_address_line1' => 'nullable|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_zip' => 'nullable|string|max:255',
            'billing_country' => 'nullable|string|max:255',
            'billing_phone' => 'nullable|string|max:255',

            'shipping_method_id' => 'required|exists:sales_shipping_methods,id',
            'payment_method' => 'required|in:cod,bank_transfer',
            'note' => 'nullable|string',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.variant_id' => 'nullable|integer',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $data['billing_same_as_shipping'] = $request->boolean('billing_same_as_shipping', true);

        try {
            $order = DB::transaction(function () use ($data, $request) {
                $productIds = collect($data['items'])->pluck('product_id')->unique();
                $products = Product::with('variants')->whereIn('id', $productIds)->get()->keyBy('id');

                $unavailable = [];
                $lines = [];

                foreach ($data['items'] as $line) {
                    $product = $products->get($line['product_id']);

                    if (! $product || $product->status !== 'active' || ! $product->is_visible) {
                        $unavailable[] = ['product_id' => $line['product_id'], 'variant_id' => $line['variant_id'] ?? null, 'reason' => 'not_found'];

                        continue;
                    }

                    $variant = ! empty($line['variant_id']) ? $product->variants->firstWhere('id', $line['variant_id']) : null;
                    $quantityAvailable = $variant ? $variant->quantity : $product->quantity;

                    if ($quantityAvailable < $line['qty']) {
                        $unavailable[] = ['product_id' => $product->id, 'variant_id' => $variant?->id, 'reason' => 'out_of_stock'];

                        continue;
                    }

                    $unitPrice = $variant?->price !== null ? (float) $variant->price : (float) $product->price;

                    $lines[] = [
                        'product' => $product,
                        'variant' => $variant,
                        'unit_price' => $unitPrice,
                        'qty' => (int) $line['qty'],
                        'line_total' => $unitPrice * (int) $line['qty'],
                    ];
                }

                if (! empty($unavailable)) {
                    throw new CheckoutUnavailableItemsException($unavailable);
                }

                $shippingMethod = ShippingMethod::findOrFail($data['shipping_method_id']);
                $subtotal = collect($lines)->sum('line_total');
                $shippingAmount = $shippingMethod->rate !== null ? (float) $shippingMethod->rate : 0.0;
                $total = $subtotal + $shippingAmount;

                $user = $request->user('sanctum');

                $order = Order::create([
                    'user_id' => $user?->id,
                    'customer_name' => $data['customer_name'],
                    'customer_email' => $data['customer_email'],
                    'customer_phone' => $data['customer_phone'] ?? null,
                    'shipping_name' => $data['shipping_name'],
                    'shipping_address_line1' => $data['shipping_address_line1'],
                    'shipping_address_line2' => $data['shipping_address_line2'] ?? null,
                    'shipping_city' => $data['shipping_city'],
                    'shipping_state' => $data['shipping_state'] ?? null,
                    'shipping_zip' => $data['shipping_zip'] ?? null,
                    'shipping_country' => $data['shipping_country'],
                    'shipping_phone' => $data['shipping_phone'] ?? null,
                    'billing_same_as_shipping' => $data['billing_same_as_shipping'],
                    'billing_name' => $data['billing_name'] ?? null,
                    'billing_address_line1' => $data['billing_address_line1'] ?? null,
                    'billing_address_line2' => $data['billing_address_line2'] ?? null,
                    'billing_city' => $data['billing_city'] ?? null,
                    'billing_state' => $data['billing_state'] ?? null,
                    'billing_zip' => $data['billing_zip'] ?? null,
                    'billing_country' => $data['billing_country'] ?? null,
                    'billing_phone' => $data['billing_phone'] ?? null,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'subtotal' => $subtotal,
                    'shipping_amount' => $shippingAmount,
                    'discount_amount' => 0,
                    'tax_amount' => 0,
                    'total' => $total,
                    'customer_note' => $data['note'] ?? null,
                ]);

                foreach ($lines as $line) {
                    $order->items()->create([
                        'product_id' => $line['product']->id,
                        'variant_id' => $line['variant']?->id,
                        'product_name' => $line['product']->name,
                        'variant_label' => $line['variant']?->label,
                        'sku' => $line['variant']?->sku ?? $line['product']->sku,
                        'unit_price' => $line['unit_price'],
                        'quantity' => $line['qty'],
                        'line_total' => $line['line_total'],
                        'weight' => $line['product']->weight,
                    ]);

                    $line['variant']?->decrement('quantity', $line['qty']);
                    $line['product']->decrement('quantity', $line['qty']);

                    $line['product']->inventoryMovements()->create([
                        'variant_id' => $line['variant']?->id,
                        'type' => 'remove',
                        'quantity_change' => -$line['qty'],
                        'reason' => 'order_placed',
                        'notes' => "Order {$order->order_number}",
                        'user_id' => $user?->id,
                    ]);
                }

                $order->events()->create([
                    'title' => 'Order Placed',
                    'created_by' => $user?->id,
                ]);

                $gateway = PaymentGateway::where('code', $data['payment_method'])->first();

                $order->payments()->create([
                    'gateway_id' => $gateway?->id,
                    'transaction_ref' => $order->order_number.'-'.strtoupper(Str::random(6)),
                    'status' => 'pending',
                    'amount' => $total,
                ]);

                return $order;
            });
        } catch (CheckoutUnavailableItemsException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'unavailable_items' => $e->items,
            ], 422);
        }

        $this->sendOrderEmails($order);

        return response()->json([
            'order_number' => $order->order_number,
            'total' => (float) $order->total,
        ], 201);
    }

    public function show(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product.coverImage', 'items.product.images', 'latestPayment.gateway'])
            ->first();

        if (! $order || ! $this->authorizeOrderAccess($request, $order)) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return new OrderResource($order);
    }

    public function uploadPaymentProof(Request $request, string $orderNumber)
    {
        $order = Order::with('latestPayment')->where('order_number', $orderNumber)->first();

        if (! $order || ! $this->authorizeOrderAccess($request, $order)) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $request->validate([
            'screenshot' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $payment = $order->latestPayment;

        if (! $payment) {
            return response()->json(['message' => 'This order has no payment record.'], 422);
        }

        $stored = $this->images->storeRaw($request->file('screenshot'), "payments/{$order->order_number}");
        $payment->update(['proof_path' => $stored['path']]);

        return response()->json(['proof_url' => $payment->fresh()->proof_url]);
    }

    protected function authorizeOrderAccess(Request $request, Order $order): bool
    {
        $user = $request->user('sanctum');

        if ($user && $order->user_id === $user->id) {
            return true;
        }

        $email = $request->query('email') ?? $request->input('email');

        return $email && strcasecmp($email, $order->customer_email) === 0;
    }

    protected function sendOrderEmails(Order $order): void
    {
        $order->load('latestPayment.gateway');
        $bankAccounts = BankAccount::active()->orderBy('sort_order')->get();

        try {
            Mail::to($order->customer_email)->send(new CustomerOrderConfirmationMail($order, $bankAccounts));
            Mail::to(config('mail.from.address'))->send(new AdminNewOrderNotificationMail($order));
        } catch (\Throwable $e) {
            Log::warning('Failed to send order emails: '.$e->getMessage());
        }
    }
}
