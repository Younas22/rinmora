<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected const CANCELLABLE_BLOCKED = ['cancelled', 'delivered', 'returned', 'refunded'];

    protected const UPDATABLE_STATUSES = ['processing', 'packed', 'shipped', 'delivered', 'returned', 'refunded'];

    public function index(Request $request)
    {
        $query = Order::query();

        $tab = $request->get('tab', 'all');
        if ($tab !== 'all') {
            $query->where('status', $tab);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }
        if ($payment = $request->get('payment')) {
            $query->where('payment_status', $payment);
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $orders = $query->withCount('items')->latest()->paginate(15)->withQueryString();

        $counts = ['all' => Order::count()];
        foreach (['pending', 'processing', 'packed', 'shipped', 'delivered', 'cancelled', 'returned', 'refunded'] as $status) {
            $counts[$status] = Order::where('status', $status)->count();
        }

        return view('admin.sales.orders.index', compact('orders', 'counts', 'tab'));
    }

    public function create()
    {
        $customers = User::customers()->orderBy('first_name')->get();
        $products = Product::with('variants')->active()->orderBy('name')->get()->map(fn (Product $p) => [
            'id' => $p->id,
            'name' => $p->name,
            'sku' => $p->sku,
            'price' => (float) $p->price,
            'weight' => (float) $p->weight,
            'variants' => $p->variants->map(fn ($v) => [
                'id' => $v->id,
                'label' => $v->label,
                'price' => $v->price !== null ? (float) $v->price : (float) $p->price,
                'quantity' => $v->quantity,
            ])->values(),
        ])->values();

        return view('admin.sales.orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
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
            'shipping_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'customer_note' => 'nullable|string',
            'items_json' => 'required|string',
        ]);

        $items = json_decode($data['items_json'], true) ?: [];
        $items = array_values(array_filter($items, fn ($i) => (int) ($i['quantity'] ?? 0) > 0));

        if (empty($items)) {
            return back()->withErrors(['items_json' => 'Add at least one order item.'])->withInput();
        }

        $data['billing_same_as_shipping'] = $request->boolean('billing_same_as_shipping', true);

        $order = DB::transaction(function () use ($data, $items, $request) {
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += (float) $item['unit_price'] * (int) $item['quantity'];
            }

            $shippingAmount = (float) ($data['shipping_amount'] ?? 0);
            $discountAmount = (float) ($data['discount_amount'] ?? 0);
            $taxAmount = (float) ($data['tax_amount'] ?? 0);

            $order = Order::create($data + [
                'subtotal' => $subtotal,
                'shipping_amount' => $shippingAmount,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total' => $subtotal + $shippingAmount + $taxAmount - $discountAmount,
            ]);

            foreach ($items as $item) {
                $lineTotal = (float) $item['unit_price'] * (int) $item['quantity'];

                $order->items()->create([
                    'product_id' => $item['product_id'] ?: null,
                    'variant_id' => $item['variant_id'] ?: null,
                    'product_name' => $item['product_name'],
                    'variant_label' => $item['variant_label'] ?: null,
                    'sku' => $item['sku'] ?: null,
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $lineTotal,
                    'weight' => $item['weight'] ?: null,
                ]);

                if (!empty($item['product_id']) && $product = Product::find($item['product_id'])) {
                    $variant = !empty($item['variant_id']) ? $product->variants()->find($item['variant_id']) : null;
                    $variant?->decrement('quantity', (int) $item['quantity']);
                    $product->decrement('quantity', (int) $item['quantity']);

                    $product->inventoryMovements()->create([
                        'variant_id' => $variant?->id,
                        'type' => 'remove',
                        'quantity_change' => -(int) $item['quantity'],
                        'reason' => 'order_placed',
                        'notes' => "Order {$order->order_number}",
                        'user_id' => $request->user()->id,
                    ]);
                }
            }

            $order->events()->create([
                'title' => 'Order Placed',
                'created_by' => $request->user()->id,
            ]);

            return $order;
        });

        return redirect()->route('admin.sales.orders.show', $order)->with('success', "Order {$order->order_number} created.");
    }

    public function show(Order $order)
    {
        $order->load(['items', 'events', 'latestPayment.gateway', 'user']);

        return view('admin.sales.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:'.implode(',', self::UPDATABLE_STATUSES),
            'carrier' => 'nullable|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
            'signee' => 'nullable|string|max:255',
        ]);

        $order->update(['status' => $data['status']]);

        $description = match ($data['status']) {
            'shipped' => trim(($data['carrier'] ?? '').(!empty($data['tracking_number']) ? ' · '.$data['tracking_number'] : '')) ?: null,
            'delivered' => !empty($data['signee']) ? "Signed by {$data['signee']}" : null,
            default => null,
        };

        $order->events()->create([
            'title' => 'Order '.ucfirst($data['status']),
            'description' => $description,
            'created_by' => $request->user()->id,
        ]);

        return back()->with('success', 'Order status updated.');
    }

    public function cancel(Request $request, Order $order)
    {
        if (in_array($order->status, self::CANCELLABLE_BLOCKED, true)) {
            return back()->with('error', 'This order can no longer be cancelled.');
        }

        DB::transaction(function () use ($order, $request) {
            foreach ($order->items as $item) {
                if ($item->product_id && $product = Product::find($item->product_id)) {
                    $variant = $item->variant_id ? $product->variants()->find($item->variant_id) : null;
                    $variant?->increment('quantity', $item->quantity);
                    $product->increment('quantity', $item->quantity);

                    $product->inventoryMovements()->create([
                        'variant_id' => $variant?->id,
                        'type' => 'add',
                        'quantity_change' => $item->quantity,
                        'reason' => 'order_cancelled',
                        'notes' => "Order {$order->order_number} cancelled",
                        'user_id' => $request->user()->id,
                    ]);
                }
            }

            $order->update(['status' => 'cancelled']);
            $order->events()->create([
                'title' => 'Order Cancelled',
                'created_by' => $request->user()->id,
            ]);
        });

        return back()->with('success', 'Order cancelled and stock restored.');
    }

    public function invoice(Order $order)
    {
        $order->load(['items', 'latestPayment']);

        return view('admin.sales.orders.invoice', compact('order'));
    }

    public function shippingLabel(Order $order)
    {
        $order->load('items');

        return view('admin.sales.orders.shipping-label', compact('order'));
    }
}
