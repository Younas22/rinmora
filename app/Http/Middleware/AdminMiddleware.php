<?php

namespace App\Http\Middleware;

use App\Models\System\AdminActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isAdmin() && !auth()->user()->isAgent()) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        $response = $next($request);

        $this->logActivity($request);

        return $response;
    }

    /**
     * Logs the attempt (not just confirmed success) of every non-GET admin
     * request — Laravel's session-redirect validation failures are also
     * 302s, indistinguishable from success without deeper inspection, so
     * logging the attempt is the honest, simple signal. Wrapped in a
     * try/catch so a logging failure never breaks the actual request.
     */
    protected function logActivity(Request $request): void
    {
        if ($request->isMethod('GET') || $request->isMethod('HEAD')) {
            return;
        }

        try {
            $routeName = $request->route()?->getName();
            if (!$routeName) {
                return;
            }

            $segments = explode('.', $routeName);
            $last = end($segments);

            if (count($segments) >= 3) {
                $resource = $segments[count($segments) - 2];
            } else {
                $resource = 'auth';
            }

            $module = Str::headline($resource);

            $verbMap = [
                'store' => 'Created', 'update' => 'Updated', 'destroy' => 'Deleted',
                'bulk-destroy' => 'Bulk deleted', 'bulk-move' => 'Bulk moved',
                'bulk-action' => 'Bulk updated', 'reorder' => 'Reordered',
                'toggle-read' => 'Toggled read status', 'toggle-status' => 'Toggled status',
                'archive' => 'Archived', 'resolve' => 'Resolved', 'send' => 'Sent',
                'reply' => 'Replied to', 'logout' => 'Logged out of',
            ];
            $verb = $verbMap[$last] ?? Str::headline($last);

            $userAgent = $request->userAgent() ?? '';
            $device = preg_match('/Mobile|Android|iPhone/i', $userAgent) ? 'Mobile' : 'Desktop';
            $browser = match (true) {
                str_contains($userAgent, 'Edg/') => 'Edge',
                str_contains($userAgent, 'Chrome/') => 'Chrome',
                str_contains($userAgent, 'Firefox/') => 'Firefox',
                str_contains($userAgent, 'Safari/') => 'Safari',
                default => 'Unknown',
            };

            AdminActivityLog::create([
                'user_id' => auth()->id(),
                'module' => $module,
                'action' => "{$verb} {$module}",
                'route_name' => $routeName,
                'ip_address' => $request->ip(),
                'device' => $device,
                'browser' => $browser,
                'url' => $request->fullUrl(),
            ]);
        } catch (\Throwable $e) {
            // Logging must never break the actual admin request.
        }
    }
}
