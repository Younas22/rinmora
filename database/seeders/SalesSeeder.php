<?php

namespace Database\Seeders;

use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use App\Models\Sales\PaymentGateway;
use App\Models\Sales\Payment;
use App\Models\Sales\Refund;
use App\Models\Sales\ShippingZone;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPaymentGateways();
        $this->seedShippingZones();
        $this->seedFreeShippingSetting();
        $this->seedDemoOrders();
    }

    protected function seedPaymentGateways(): void
    {
        $gateways = [
            ['code' => 'stripe', 'name' => 'Stripe', 'icon_class' => 'fa-brands fa-cc-stripe text-[#635BFF]', 'is_enabled' => true, 'is_connected' => true, 'sort_order' => 1],
            ['code' => 'paypal', 'name' => 'PayPal', 'icon_class' => 'fa-brands fa-cc-paypal text-[#003087]', 'is_enabled' => true, 'is_connected' => true, 'sort_order' => 2],
            ['code' => 'cod', 'name' => 'Cash on Delivery', 'icon_class' => 'fa-solid fa-money-bill-wave text-success', 'is_enabled' => true, 'is_connected' => true, 'sort_order' => 3],
            ['code' => 'apple_pay', 'name' => 'Apple Pay', 'icon_class' => 'fa-brands fa-apple-pay', 'is_enabled' => false, 'is_connected' => false, 'sort_order' => 4],
            ['code' => 'google_pay', 'name' => 'Google Pay', 'icon_class' => 'fa-brands fa-google-pay', 'is_enabled' => false, 'is_connected' => false, 'sort_order' => 5],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::updateOrCreate(['code' => $gateway['code']], $gateway);
        }
    }

    protected function seedShippingZones(): void
    {
        $zones = [
            [
                'name' => 'United States & Canada', 'countries' => 'United States, Canada', 'is_active' => true, 'sort_order' => 1,
                'methods' => [
                    ['name' => 'Standard Shipping', 'delivery_time' => '3-5 days', 'rate' => null],
                    ['name' => 'Express Shipping', 'delivery_time' => '1-2 days', 'rate' => 15.00],
                    ['name' => 'Same Day Delivery', 'delivery_time' => 'Same day', 'rate' => 25.00],
                ],
            ],
            [
                'name' => 'United Kingdom & Europe', 'countries' => 'United Kingdom, EU countries', 'is_active' => true, 'sort_order' => 2,
                'methods' => [
                    ['name' => 'Standard Shipping', 'delivery_time' => '5-8 days', 'rate' => 9.00],
                    ['name' => 'Express Shipping', 'delivery_time' => '2-3 days', 'rate' => 22.00],
                ],
            ],
            [
                'name' => 'Middle East (UAE, KSA)', 'countries' => 'United Arab Emirates, Saudi Arabia', 'is_active' => true, 'sort_order' => 3,
                'methods' => [
                    ['name' => 'Standard Shipping', 'delivery_time' => '4-6 days', 'rate' => 12.00],
                    ['name' => 'Express Shipping', 'delivery_time' => '2 days', 'rate' => 28.00],
                ],
            ],
            [
                'name' => 'Rest of World', 'countries' => 'All other countries', 'is_active' => false, 'sort_order' => 4,
                'methods' => [
                    ['name' => 'Standard International', 'delivery_time' => '10-18 days', 'rate' => 18.00],
                ],
            ],
        ];

        foreach ($zones as $zoneData) {
            $methods = $zoneData['methods'];
            unset($zoneData['methods']);

            $zone = ShippingZone::updateOrCreate(['name' => $zoneData['name']], $zoneData);

            foreach ($methods as $i => $method) {
                $zone->methods()->updateOrCreate(['name' => $method['name']], $method + ['sort_order' => $i]);
            }
        }
    }

    protected function seedFreeShippingSetting(): void
    {
        Setting::setValue('free_shipping_enabled', '1', 'shipping');
        Setting::setValue('free_shipping_threshold', '75.00', 'shipping');
    }

    protected function seedDemoOrders(): void
    {
        if (Order::count() > 0) {
            return;
        }

        $customers = User::customers()->get();
        $products = Product::where('quantity', '>', 5)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            return;
        }

        $stripe = PaymentGateway::where('code', 'stripe')->first();
        $paypal = PaymentGateway::where('code', 'paypal')->first();
        $cod = PaymentGateway::where('code', 'cod')->first();

        $plans = [
            ['status' => 'pending', 'payment_status' => 'pending'],
            ['status' => 'processing', 'payment_status' => 'paid'],
            ['status' => 'packed', 'payment_status' => 'paid'],
            ['status' => 'shipped', 'payment_status' => 'paid'],
            ['status' => 'delivered', 'payment_status' => 'paid'],
            ['status' => 'delivered', 'payment_status' => 'paid'],
            ['status' => 'cancelled', 'payment_status' => 'pending'],
            ['status' => 'returned', 'payment_status' => 'paid'],
            ['status' => 'refunded', 'payment_status' => 'refunded'],
        ];

        $txnSeq = 88211;

        foreach ($plans as $i => $plan) {
            $customer = $customers[$i % $customers->count()];
            $itemCount = rand(1, 2);
            $orderProducts = $products->random(min($itemCount, $products->count()));

            $subtotal = 0;
            $lineItems = [];
            foreach ($orderProducts as $product) {
                $qty = rand(1, 2);
                $lineTotal = (float) $product->price * $qty;
                $subtotal += $lineTotal;
                $lineItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'unit_price' => $product->price,
                    'quantity' => $qty,
                    'line_total' => $lineTotal,
                    'weight' => $product->weight,
                ];
            }

            $shippingAmount = 9.00;
            $taxAmount = round($subtotal * 0.05, 2);
            $total = $subtotal + $shippingAmount + $taxAmount;

            $order = Order::create([
                'user_id' => $customer->id,
                'customer_name' => trim($customer->first_name.' '.$customer->last_name) ?: $customer->email,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone,
                'shipping_name' => trim($customer->first_name.' '.$customer->last_name) ?: $customer->email,
                'shipping_address_line1' => $customer->address ?: '123 Clifton Road',
                'shipping_city' => $customer->city ?: 'Karachi',
                'shipping_state' => $customer->state,
                'shipping_zip' => $customer->zip_code,
                'shipping_country' => $customer->country ?: 'Pakistan',
                'shipping_phone' => $customer->phone,
                'status' => $plan['status'],
                'payment_status' => $plan['payment_status'],
                'subtotal' => $subtotal,
                'shipping_amount' => $shippingAmount,
                'tax_amount' => $taxAmount,
                'total' => $total,
            ]);

            foreach ($lineItems as $item) {
                $order->items()->create($item);
            }

            $events = [['title' => 'Order Placed']];
            if (in_array($plan['status'], ['processing', 'packed', 'shipped', 'delivered', 'returned', 'refunded'], true)) {
                $events[] = ['title' => 'Payment Confirmed', 'description' => 'Card ending 4821'];
            }
            if (in_array($plan['status'], ['packed', 'shipped', 'delivered', 'returned', 'refunded'], true)) {
                $events[] = ['title' => 'Order Packed'];
            }
            if (in_array($plan['status'], ['shipped', 'delivered', 'returned', 'refunded'], true)) {
                $events[] = ['title' => 'Order Shipped', 'description' => 'TCS Express · TRK-88213'.$i];
            }
            if (in_array($plan['status'], ['delivered', 'returned'], true)) {
                $events[] = ['title' => 'Order Delivered', 'description' => 'Signed by '.$customer->first_name];
            }
            if ($plan['status'] === 'cancelled') {
                $events[] = ['title' => 'Order Cancelled'];
            }
            if ($plan['status'] === 'returned') {
                $events[] = ['title' => 'Order Returned'];
            }
            if ($plan['status'] === 'refunded') {
                $events[] = ['title' => 'Order Refunded'];
            }

            foreach ($events as $event) {
                $order->events()->create($event);
            }

            $payment = null;
            if ($plan['payment_status'] !== 'pending') {
                $gateway = [$stripe, $paypal, $cod][$i % 3];
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'gateway_id' => $gateway?->id,
                    'transaction_ref' => 'TXN-'.($txnSeq++),
                    'status' => $plan['payment_status'] === 'refunded' ? 'refunded' : 'success',
                    'amount' => $total,
                    'card_brand' => $gateway?->code === 'stripe' ? 'Visa' : null,
                    'card_last_four' => $gateway?->code === 'stripe' ? '4821' : null,
                ]);
            }

            if (in_array($plan['status'], ['returned', 'refunded'], true) && $payment) {
                Refund::create([
                    'order_id' => $order->id,
                    'payment_id' => $payment->id,
                    'amount' => $total,
                    'reason' => $plan['status'] === 'returned' ? 'Item damaged' : 'Changed mind',
                    'stage' => $plan['status'] === 'refunded' ? 'processed' : 'requested',
                ]);
            }
        }
    }
}
