<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\System\AdminActivityLog;
use App\Models\System\AdminErrorLog;
use App\Models\System\AdminLoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'admin-activity');

        $activityQuery = AdminActivityLog::with('admin');
        if ($module = $request->get('module')) {
            $activityQuery->where('module', $module);
        }
        if ($search = $request->get('activity_search')) {
            $activityQuery->where('action', 'like', "%{$search}%");
        }
        $activities = $activityQuery->latest()->paginate(8, ['*'], 'activity_page')->withQueryString();

        $stats = [
            'actions_today' => AdminActivityLog::whereDate('created_at', today())->count(),
            'active_admins' => AdminActivityLog::where('created_at', '>=', now()->subDay())->distinct('user_id')->count('user_id'),
            'failed_logins_24h' => AdminLoginLog::where('status', 'failed')->where('created_at', '>=', now()->subDay())->count(),
            'open_errors' => AdminErrorLog::where('status', 'open')->count(),
        ];

        $recentActivity = AdminActivityLog::with('admin')->latest()->take(5)->get();

        $moduleBreakdown = AdminActivityLog::select('module', DB::raw('count(*) as cnt'))
            ->groupBy('module')->orderByDesc('cnt')->take(4)->get();
        $moduleTotal = max(1, $moduleBreakdown->sum('cnt'));

        $moduleOptions = AdminActivityLog::select('module')->distinct()->orderBy('module')->pluck('module');

        $logins = AdminLoginLog::with('admin')->latest()->paginate(8, ['*'], 'login_page')->withQueryString();
        $loginStats = [
            'failed_today' => AdminLoginLog::where('status', 'failed')->whereDate('created_at', today())->count(),
            'suspicious_ips' => AdminLoginLog::where('status', 'failed')->distinct('ip_address')->count('ip_address'),
            'last_failed_at' => AdminLoginLog::where('status', 'failed')->latest()->value('created_at'),
        ];

        $errorLogs = AdminErrorLog::latest()->paginate(8, ['*'], 'error_page')->withQueryString();
        $errorStats = [
            'server_errors' => AdminErrorLog::where('error_type', '500 Server Error')->count(),
            'failed_payments' => AdminErrorLog::where('error_type', 'Failed Payment')->count(),
            'api_timeouts' => AdminErrorLog::where('error_type', 'API Timeout')->count(),
            'validation_errors' => AdminErrorLog::where('error_type', 'Validation Error')->count(),
        ];

        return view('admin.system.activity.index', compact(
            'tab', 'activities', 'stats', 'recentActivity', 'moduleBreakdown', 'moduleTotal', 'moduleOptions',
            'logins', 'loginStats', 'errorLogs', 'errorStats'
        ));
    }

    public function resolveError(AdminErrorLog $errorLog)
    {
        $errorLog->markResolved();

        return back()->with('success', 'Error marked as resolved.');
    }
}
