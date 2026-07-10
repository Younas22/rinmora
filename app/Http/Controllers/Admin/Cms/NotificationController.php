<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;
use App\Models\Cms\EmailLog;
use App\Models\Cms\NotificationCampaign;
use App\Models\Sales\Order;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'system');

        $systemNotifications = $this->liveSystemNotifications();
        if ($request->get('filter') === 'high') {
            $systemNotifications = $systemNotifications->where('priority', 'High');
        }
        if ($search = $request->get('notif_search')) {
            $systemNotifications = $systemNotifications->filter(fn ($n) => str_contains(strtolower($n['title']), strtolower($search)));
        }

        $audienceCounts = [
            'all' => User::customers()->count(),
            'vip' => User::vip()->count(),
            'recent' => User::customers()->whereHas('orders', fn ($q) => $q->where('created_at', '>=', now()->subDays(30)))->count(),
            'cart' => 0,
            'custom' => 0,
        ];

        $campaigns = NotificationCampaign::latest()->paginate(10, ['*'], 'campaigns_page')->withQueryString();

        $emailLogs = EmailLog::query();
        if ($status = $request->get('email_status')) {
            $emailLogs->where('status', $status);
        }
        $emailLogs = $emailLogs->latest()->paginate(15, ['*'], 'email_logs_page')->withQueryString();

        $emailStats = [
            'total' => EmailLog::count(),
            'delivered' => EmailLog::where('status', 'delivered')->count(),
            'opened' => EmailLog::where('status', 'opened')->count(),
            'bounced' => EmailLog::where('status', 'bounced')->count(),
            'failed' => EmailLog::where('status', 'failed')->count(),
        ];

        return view('admin.cms.notifications.index', compact(
            'tab', 'systemNotifications', 'audienceCounts', 'campaigns', 'emailLogs', 'emailStats'
        ));
    }

    public function storeCampaign(Request $request)
    {
        $data = $request->validate([
            'channel' => 'required|in:push,email,sms',
            'title' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message_body' => 'required|string',
            'audience' => 'required|in:all,vip,recent,cart,custom',
            'action' => 'required|in:send,draft',
        ]);

        $campaign = NotificationCampaign::create([
            'title' => $data['title'],
            'channel' => $data['channel'],
            'audience' => $data['audience'],
            'subject' => $data['subject'] ?? null,
            'message_body' => $data['message_body'],
            'status' => 'draft',
        ]);

        if ($data['action'] === 'send') {
            $campaign->markSent();

            return redirect()->route('admin.cms.notifications.index', ['tab' => 'customer'])
                ->with('success', 'Campaign sent (demo only — no real push/email/SMS was dispatched).');
        }

        return redirect()->route('admin.cms.notifications.index', ['tab' => 'customer'])->with('success', 'Campaign saved as draft.');
    }

    public function sendCampaign(NotificationCampaign $campaign)
    {
        $campaign->markSent();

        return redirect()->route('admin.cms.notifications.index', ['tab' => 'customer'])
            ->with('success', 'Campaign sent (demo only — no real push/email/SMS was dispatched).');
    }

    protected function liveSystemNotifications()
    {
        $items = collect();

        foreach (Product::lowStock()->latest('updated_at')->take(5)->get() as $product) {
            $items->push([
                'icon' => 'fa-box', 'color' => 'warning', 'type' => 'Inventory', 'priority' => 'Medium',
                'title' => "Low stock: {$product->name}",
                'message' => "Only {$product->quantity} units remaining — consider restocking soon.",
                'time' => $product->updated_at,
            ]);
        }

        foreach (Review::pending()->latest()->take(5)->get() as $review) {
            $items->push([
                'icon' => 'fa-star-half-stroke', 'color' => 'info', 'type' => 'Review', 'priority' => 'Low',
                'title' => 'New review pending moderation',
                'message' => 'A ' . $review->rating . '-star review was submitted and is awaiting approval.',
                'time' => $review->created_at,
            ]);
        }

        foreach (Order::latest()->take(5)->get() as $order) {
            $items->push([
                'icon' => 'fa-receipt', 'color' => 'success', 'type' => 'Order', 'priority' => 'Low',
                'title' => "New order #{$order->order_number}",
                'message' => 'Order placed for $' . number_format($order->total, 2) . '.',
                'time' => $order->created_at,
            ]);
        }

        return $items->sortByDesc('time')->values();
    }
}
