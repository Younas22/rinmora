<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customers\RewardPoint;
use Illuminate\Http\Request;

class RewardPointController extends Controller
{
    public function index(Request $request)
    {
        $query = RewardPoint::with('user');

        if ($search = $request->get('search')) {
            $query->whereHas('user', fn ($u) => $u->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"));
        }
        if ($tier = $request->get('tier')) {
            $query->whereHas('user', fn ($u) => $u->where('customer_tier', $tier));
        }

        match ($request->get('sort')) {
            'expiring_soon' => $query->orderByDesc('expiring_soon'),
            'most_redeemed' => $query->orderByDesc('redeemed'),
            default => $query->orderByDesc('points_balance'),
        };

        $rewardPoints = $query->paginate(15)->withQueryString();

        $stats = [
            'points_outstanding' => RewardPoint::sum('points_balance'),
            'redeemed_this_month' => RewardPoint::whereMonth('updated_at', now()->month)->sum('redeemed'),
            'enrolled_customers' => RewardPoint::count(),
            'expiring_this_month' => RewardPoint::sum('expiring_soon'),
        ];

        return view('admin.customers.reward-points.index', compact('rewardPoints', 'stats'));
    }
}
