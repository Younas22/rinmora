@php
    $statusStyle = ['delivered' => 'success', 'opened' => 'info', 'bounced' => 'danger', 'failed' => 'danger', 'queued' => 'black/5'];
@endphp

<div id="panel-email-logs" class="tab-panel space-y-6 {{ request('tab') !== 'email-logs' ? 'hidden' : '' }}">

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <h2 class="font-bold text-sm">Email Delivery Logs</h2>
        </div>

        <form method="GET" class="pill-group flex flex-wrap items-center gap-2 mb-5">
            <input type="hidden" name="tab" value="email-logs">
            <a href="{{ route('admin.cms.notifications.index', ['tab' => 'email-logs']) }}" class="text-xs font-semibold px-3.5 py-2 rounded-full transition {{ !request('email_status') ? 'bg-ink text-white' : 'bg-black/5 text-black/60 hover:bg-black/10' }}">All ({{ $emailStats['total'] }})</a>
            <a href="{{ route('admin.cms.notifications.index', ['tab' => 'email-logs', 'email_status' => 'delivered']) }}" class="text-xs font-semibold px-3.5 py-2 rounded-full transition {{ request('email_status') === 'delivered' ? 'bg-ink text-white' : 'bg-black/5 text-black/60 hover:bg-black/10' }}">Delivered ({{ $emailStats['delivered'] }})</a>
            <a href="{{ route('admin.cms.notifications.index', ['tab' => 'email-logs', 'email_status' => 'opened']) }}" class="text-xs font-semibold px-3.5 py-2 rounded-full transition {{ request('email_status') === 'opened' ? 'bg-ink text-white' : 'bg-black/5 text-black/60 hover:bg-black/10' }}">Opened ({{ $emailStats['opened'] }})</a>
            <a href="{{ route('admin.cms.notifications.index', ['tab' => 'email-logs', 'email_status' => 'bounced']) }}" class="text-xs font-semibold px-3.5 py-2 rounded-full transition {{ request('email_status') === 'bounced' ? 'bg-ink text-white' : 'bg-black/5 text-black/60 hover:bg-black/10' }}">Bounced ({{ $emailStats['bounced'] }})</a>
            <a href="{{ route('admin.cms.notifications.index', ['tab' => 'email-logs', 'email_status' => 'failed']) }}" class="text-xs font-semibold px-3.5 py-2 rounded-full transition {{ request('email_status') === 'failed' ? 'bg-ink text-white' : 'bg-black/5 text-black/60 hover:bg-black/10' }}">Failed ({{ $emailStats['failed'] }})</a>
        </form>

        <table class="w-full text-sm min-w-[680px]">
            <thead>
                <tr class="text-left text-black/40 text-xs uppercase tracking-wide">
                    <th class="pb-3 font-medium">Recipient</th>
                    <th class="pb-3 font-medium">Subject</th>
                    <th class="pb-3 font-medium">Status</th>
                    <th class="pb-3 font-medium">Date</th>
                    <th class="pb-3 font-medium text-right">Opens</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($emailLogs as $log)
                    <tr class="hover:bg-black/[0.02] transition">
                        <td class="py-3.5">
                            <div class="min-w-0">
                                <p class="font-medium truncate">{{ $log->recipient_name }}</p>
                                <p class="text-black/40 text-xs truncate">{{ $log->recipient_email }}</p>
                            </div>
                        </td>
                        <td class="py-3.5 text-black/70">{{ $log->subject }}</td>
                        <td class="py-3.5"><span class="bg-{{ $statusStyle[$log->status] }}/10 text-{{ $statusStyle[$log->status] }} text-[11px] font-semibold px-2.5 py-1 rounded-full capitalize">{{ $log->status }}</span></td>
                        <td class="py-3.5 text-black/45">{{ $log->created_at->format('M j, Y') }}</td>
                        <td class="py-3.5 text-right">{{ $log->opened_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-10 text-center text-black/40 text-sm">No email logs yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if ($emailLogs->hasPages())
            <div class="pt-5 mt-5 border-t border-black/5">
                {{ $emailLogs->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

</div>
