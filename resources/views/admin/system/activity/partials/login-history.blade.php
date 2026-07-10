<div id="panel-login-history" class="tab-panel space-y-6 {{ request('tab') !== 'login-history' ? 'hidden' : '' }}">

    @if ($loginStats['failed_today'] > 0)
        <div class="bg-danger/5 border border-danger/20 rounded-2xl px-4 py-3 text-sm text-danger">
            <i class="fa-solid fa-triangle-exclamation mr-1.5"></i>
            {{ $loginStats['failed_today'] }} failed login attempt{{ $loginStats['failed_today'] === 1 ? '' : 's' }} detected today.
        </div>
    @endif

    <div class="grid sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Failed Attempts Today</p>
            <p class="text-xl font-bold text-danger">{{ $loginStats['failed_today'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Unique Suspicious IPs</p>
            <p class="text-xl font-bold">{{ $loginStats['suspicious_ips'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Last Failed Attempt</p>
            <p class="text-xl font-bold">{{ $loginStats['last_failed_at'] ? \Illuminate\Support\Carbon::parse($loginStats['last_failed_at'])->format('g:i A') : '—' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
        <table class="w-full text-sm min-w-[680px]">
            <thead>
                <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                    <th class="py-3 font-medium">Admin</th>
                    <th class="py-3 font-medium">Status</th>
                    <th class="py-3 font-medium">IP Address</th>
                    <th class="py-3 font-medium">Location</th>
                    <th class="py-3 font-medium">Device</th>
                    <th class="py-3 font-medium">Date/Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($logins as $log)
                    <tr class="hover:bg-black/[0.02] transition {{ $log->status === 'failed' ? 'bg-danger/[0.03]' : '' }}">
                        <td class="py-3 font-medium">{{ $log->admin->full_name ?? 'Unknown' }} <span class="text-black/40 text-xs font-normal">({{ $log->email_attempted }})</span></td>
                        <td class="py-3">
                            @if ($log->status === 'success')
                                <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Success</span>
                            @else
                                <span class="bg-danger/10 text-danger text-[11px] font-semibold px-2.5 py-1 rounded-full">Failed</span>
                            @endif
                        </td>
                        <td class="py-3 font-mono text-xs text-black/50">{{ $log->ip_address }}</td>
                        <td class="py-3 text-black/50"><i class="fa-solid fa-location-dot mr-1 text-[10px]"></i>{{ $log->location }}</td>
                        <td class="py-3 text-black/50">{{ $log->device }} &middot; {{ $log->browser }}</td>
                        <td class="py-3 text-black/45 text-xs">{{ $log->created_at->format('M j, Y g:i A') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-10 text-center text-black/40 text-sm">No login history yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if ($logins->hasPages())
            <div class="pt-5 mt-5 border-t border-black/5">
                {{ $logins->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>
</div>
