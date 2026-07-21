<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::customers()
            ->withCount('orders')
            ->withSum(['orders as lifetime_value' => function ($q) {
                $q->whereNotIn('status', ['cancelled', 'refunded']);
            }], 'total');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($tag = $request->get('tag')) {
            match ($tag) {
                'vip' => $query->where('status', 'vip'),
                'newsletter' => $query->where('marketing_emails', true),
                default => null,
            };
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        match ($request->get('sort')) {
            'lifetime_value' => $query->orderByDesc('lifetime_value'),
            'most_orders' => $query->orderByDesc('orders_count'),
            default => $query->latest(),
        };

        $customers = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => User::customers()->count(),
            'new_this_month' => User::customers()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'returning_pct' => $this->returningCustomerPercent(),
            'avg_lifetime_value' => User::customers()->withSum(['orders as lv' => fn ($q) => $q->whereNotIn('status', ['cancelled', 'refunded'])], 'total')->get()->avg('lv') ?? 0,
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    protected function returningCustomerPercent(): float
    {
        $total = User::customers()->withCount('orders')->get();
        if ($total->isEmpty()) {
            return 0;
        }

        return round($total->filter(fn ($u) => $u->orders_count > 1)->count() / $total->count() * 100, 1);
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_type'] = 'user';
        $data['password'] = Hash::make($request->input('password') ?: 'password123');
        $data['email_verified_at'] = now();

        $customer = User::create($data);

        return redirect()->route('admin.customers.show', $customer)->with('success', 'Customer created.');
    }

    public function show(User $customer)
    {
        abort_unless($customer->isCustomer(), 404);

        $customer->loadCount('orders');
        $recentOrders = $customer->orders()->latest()->take(5)->get();
        $addresses = $customer->addresses()->orderByDesc('is_default')->get();
        $wishlist = $customer->wishlist()->with('product')->latest()->take(10)->get();
        $rewardPoints = $customer->rewardPoints;
        $lifetimeValue = $customer->orders()->whereNotIn('status', ['cancelled', 'refunded'])->sum('total');

        return view('admin.customers.show', compact('customer', 'recentOrders', 'addresses', 'wishlist', 'rewardPoints', 'lifetimeValue'));
    }

    public function edit(User $customer)
    {
        abort_unless($customer->isCustomer(), 404);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        abort_unless($customer->isCustomer(), 404);

        $data = $this->validated($request, $customer);
        $customer->update($data);

        return redirect()->route('admin.customers.show', $customer)->with('success', 'Customer updated.');
    }

    public function destroy(Request $request, User $customer)
    {
        abort_unless($customer->isCustomer(), 404);
        abort_unless($request->user()->hasPermission('delete-customers'), 403);

        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted.');
    }

    public function destroyMany(Request $request)
    {
        abort_unless($request->user()->hasPermission('delete-customers'), 403);

        $customers = User::customers()->whereIn('id', (array) $request->input('customer_ids', []))->get();

        foreach ($customers as $customer) {
            $customer->delete();
        }

        return response()->json(['deleted' => $customers->pluck('id')]);
    }

    protected function validated(Request $request, ?User $customer = null): array
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.($customer?->id ?? 'NULL'),
            'phone' => 'nullable|string|max:255',
            'customer_tier' => 'required|in:bronze,silver,gold,platinum',
            'status' => 'required|in:active,inactive,suspended,vip',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'internal_notes' => 'nullable|string',
        ]);

        $data['marketing_emails'] = $request->boolean('marketing_emails');

        return $data;
    }
}
