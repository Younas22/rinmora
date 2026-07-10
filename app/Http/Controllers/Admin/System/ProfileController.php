<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use App\Models\System\SupportTicket;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
    }

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'profile');
        $user = auth()->user();

        $recentActivity = $user->adminActivityLogs()->latest()->take(5)->get();

        $stats = [
            'orders_processed' => Order::whereIn('status', ['shipped', 'delivered'])->count(),
            'products_managed' => Product::count(),
            'tickets_resolved' => SupportTicket::where('status', 'resolved')->count(),
        ];

        $preferences = $user->notification_preferences ?? [
            'email_notifications' => true, 'sms_notifications' => false, 'push_notifications' => true,
            'marketing_emails' => false, 'security_alerts' => true, 'order_notifications' => true,
        ];

        return view('admin.system.profile.index', compact('tab', 'user', 'recentActivity', 'stats', 'preferences'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:500',
            'social_website' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
        ]);

        $user->update($data);

        return back()->with('success', 'Profile updated.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($data['new_password'])]);

        return back()->with('success', 'Password updated.');
    }

    public function updatePreferences(Request $request)
    {
        $keys = ['email_notifications', 'sms_notifications', 'push_notifications', 'marketing_emails', 'security_alerts', 'order_notifications'];
        $preferences = [];
        foreach ($keys as $key) {
            $preferences[$key] = $request->boolean($key);
        }

        auth()->user()->update(['notification_preferences' => $preferences]);

        return back()->with('success', 'Notification preferences saved.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:4096',
        ]);

        $user = auth()->user();
        $this->imageUploadService->delete($user->profile_image);

        $stored = $this->imageUploadService->store($request->file('avatar'), 'profile');
        $user->update(['profile_image' => $stored['path']]);

        return back()->with('success', 'Profile photo updated.');
    }
}
