<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Customers\Address;
use App\Models\Customers\RewardPoint;
use App\Models\Customers\Wishlist;
use App\Models\Sales\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StorefrontAccountController extends Controller
{
    public function summary(Request $request)
    {
        $user = $request->user();

        $ordersQuery = Order::where('user_id', $user->id);

        $recentOrders = (clone $ordersQuery)
            ->with(['items.product.coverImage', 'items.product.images'])
            ->latest()
            ->take(3)
            ->get();

        return response()->json([
            'profile' => new UserResource($user),
            'counts' => [
                'orders_total' => (clone $ordersQuery)->count(),
                'orders_pending' => (clone $ordersQuery)->where('status', 'pending')->count(),
                'wishlist_count' => Wishlist::where('user_id', $user->id)->count(),
                'addresses_count' => Address::where('user_id', $user->id)->count(),
            ],
            'reward_points' => (int) (RewardPoint::where('user_id', $user->id)->value('points_balance') ?? 0),
            'recent_orders' => OrderResource::collection($recentOrders),
        ]);
    }

    public function orders(Request $request)
    {
        $query = Order::where('user_id', $request->user()->id)
            ->with(['items.product.coverImage', 'items.product.images'])
            ->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $perPage = min((int) $request->input('per_page', 10), 30);

        $orders = $query->paginate($perPage)->withQueryString();

        return OrderResource::collection($orders);
    }

    public function orderDetail(Request $request, string $orderNumber)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->where('order_number', $orderNumber)
            ->with(['items.product.coverImage', 'items.product.images', 'latestPayment.gateway', 'events'])
            ->first();

        if (! $order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return new OrderResource($order);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email_notifications' => 'nullable|boolean',
            'sms_notifications' => 'nullable|boolean',
            'marketing_emails' => 'nullable|boolean',
        ]);

        $data['email_notifications'] = $request->boolean('email_notifications');
        $data['sms_notifications'] = $request->boolean('sms_notifications');
        $data['marketing_emails'] = $request->boolean('marketing_emails');

        $user->update($data);

        return new UserResource($user);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (! Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Your current password is incorrect.',
            ]);
        }

        $user->update(['password' => Hash::make($data['password'])]);

        return response()->json(['message' => 'Password updated successfully.']);
    }
}
