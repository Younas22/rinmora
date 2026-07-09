<?php

namespace Database\Seeders;

use App\Models\Catalog\Product;
use App\Models\Customers\Address;
use App\Models\Customers\RewardPoint;
use App\Models\Customers\Wishlist;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::customers()->orderBy('id')->get();

        if ($customers->isEmpty()) {
            return;
        }

        $this->enrichCustomers($customers);
        $sixthCustomer = $this->addEmptyStateCustomer();
        $this->seedAddresses($customers);
        $this->seedWishlists($customers);
        $this->seedRewardPoints($customers->push($sixthCustomer));
    }

    protected function enrichCustomers($customers): void
    {
        $tiers = ['bronze', 'silver', 'gold', 'platinum'];
        $cities = [
            ['city' => 'Karachi', 'state' => 'Sindh', 'country' => 'Pakistan'],
            ['city' => 'Lahore', 'state' => 'Punjab', 'country' => 'Pakistan'],
            ['city' => 'Islamabad', 'state' => 'ICT', 'country' => 'Pakistan'],
            ['city' => 'Dubai', 'state' => 'Dubai', 'country' => 'United Arab Emirates'],
            ['city' => 'London', 'state' => '', 'country' => 'United Kingdom'],
        ];

        foreach ($customers as $i => $customer) {
            $customer->update([
                'customer_tier' => $tiers[$i % count($tiers)],
                'status' => $i === 0 ? 'vip' : ($i === 4 ? 'inactive' : 'active'),
                'marketing_emails' => $i % 2 === 0,
                'last_activity' => now()->subDays([0, 1, 2, 5, 10][$i % 5]),
                'address' => ($i + 1).' Clifton Road',
                'city' => $cities[$i % count($cities)]['city'],
                'state' => $cities[$i % count($cities)]['state'],
                'zip_code' => '7'.rand(1000, 9999),
                'country' => $cities[$i % count($cities)]['country'],
            ]);
        }
    }

    protected function addEmptyStateCustomer(): User
    {
        return User::firstOrCreate(
            ['email' => 'empty.state@rinmora.test'],
            [
                'first_name' => 'Zara',
                'last_name' => 'Noor',
                'user_type' => 'user',
                'status' => 'active',
                'customer_tier' => 'bronze',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
    }

    protected function seedAddresses($customers): void
    {
        foreach ($customers as $customer) {
            $shipping = Address::create([
                'user_id' => $customer->id,
                'type' => 'shipping',
                'recipient_name' => $customer->full_name,
                'phone' => $customer->phone,
                'address_line1' => $customer->address ?: '123 Main St',
                'city' => $customer->city ?: 'Karachi',
                'state' => $customer->state,
                'zip' => $customer->zip_code,
                'country' => $customer->country ?: 'Pakistan',
                'is_default' => true,
            ]);

            if ($customer->id % 2 === 0) {
                Address::create([
                    'user_id' => $customer->id,
                    'type' => 'billing',
                    'recipient_name' => $customer->full_name,
                    'phone' => $customer->phone,
                    'address_line1' => $customer->address ?: '123 Main St',
                    'city' => $customer->city ?: 'Karachi',
                    'state' => $customer->state,
                    'zip' => $customer->zip_code,
                    'country' => $customer->country ?: 'Pakistan',
                    'is_default' => true,
                ]);
            }
        }
    }

    protected function seedWishlists($customers): void
    {
        $products = Product::orderBy('id')->get();
        if ($products->isEmpty()) {
            return;
        }

        // Weight the first few products so they get multiple saves (a
        // believable Popularity spread), then sprinkle a few more.
        $popular = $products->take(3);
        foreach ($popular as $product) {
            foreach ($customers->take(4) as $customer) {
                Wishlist::firstOrCreate(['user_id' => $customer->id, 'product_id' => $product->id]);
            }
        }

        foreach ($customers as $i => $customer) {
            $product = $products[($i + 3) % $products->count()];
            Wishlist::firstOrCreate(['user_id' => $customer->id, 'product_id' => $product->id]);
        }

        // Make sure at least one out-of-stock product is wishlisted, if one exists.
        $outOfStock = $products->firstWhere('quantity', '<=', 0);
        if ($outOfStock) {
            Wishlist::firstOrCreate(['user_id' => $customers->first()->id, 'product_id' => $outOfStock->id]);
        }
    }

    protected function seedRewardPoints($customers): void
    {
        foreach ($customers as $i => $customer) {
            $balance = $i === $customers->count() - 1 ? 0 : rand(200, 9800);

            RewardPoint::updateOrCreate(
                ['user_id' => $customer->id],
                [
                    'points_balance' => $balance,
                    'lifetime_earned' => $balance + rand(0, 3000),
                    'redeemed' => rand(0, 1500),
                    'expiring_soon' => $i % 3 === 0 ? rand(100, 600) : 0,
                    'expires_at' => $i % 3 === 0 ? now()->addDays(30) : null,
                ]
            );
        }
    }
}
