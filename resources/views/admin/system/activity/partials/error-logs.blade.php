<div id="panel-error-logs" class="tab-panel space-y-6 {{ request('tab') !== 'error-logs' ? 'hidden' : '' }}">

    <div class="bg-black/[0.03] rounded-2xl px-4 py-3 text-xs text-black/50">
        <i class="fa-regular fa-circle-question mr-1"></i> Static demo data — no live exception capture is wired up. "Resolve" is real and persists.
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 md:gap-4">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">500 Server Errors</p>
            <p class="text-xl font-bold text-danger">{{ $errorStats['server_errors'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Failed Payments</p>
            <p class="text-xl font-bold text-danger">{{ $errorStats['failed_payments'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">API Timeouts</p>
            <p class="text-xl font-bold text-warning">{{ $errorStats['api_timeouts'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Validation Errors</p>
            <p class="text-xl font-bold text-info">{{ $errorStats['validation_errors'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
        <table class="w-full text-sm min-w-[720px]">
            <thead>
                <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                    <th class="py-3 font-medium">Error Type</th>
                    <th class="py-3 font-medium">Message</th>
                    <th class="py-3 font-medium">Endpoint</th>
                    <th class="py-3 font-medium">Occurrences</th>
                    <th class="py-3 font-medium">Last Seen</th>
                    <th class="py-3 font-medium">Status</th>
                    <th class="py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($errorLogs as $error)
                    <tr class="hover:bg-black/[0.02] transition">
                        <td class="py-3"><span class="bg-danger/10 text-danger text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $error->error_type }}</span></td>
                        <td class="py-3 text-black/70 max-w-[220px] truncate cursor-pointer error-row" data-message="{{ $error->message }}" data-trace="{{ $error->stack_trace }}" data-endpoint="{{ $error->endpoint }}" data-type="{{ $error->error_type }}" data-occurrences="{{ $error->occurrences }}" data-status="{{ $error->status }}" data-first="{{ $error->first_seen_at->format('M j, Y g:i A') }}" data-last="{{ $error->last_seen_at->format('M j, Y g:i A') }}">{{ $error->message }}</td>
                        <td class="py-3 font-mono text-xs text-black/50">{{ $error->endpoint }}</td>
                        <td class="py-3">{{ $error->occurrences }}</td>
                        <td class="py-3 text-black/45 text-xs">{{ $error->last_seen_at->format('M j, Y g:i A') }}</td>
                        <td class="py-3">
                            @if ($error->status === 'open')
                                <span class="bg-warning/10 text-warning text-[11px] font-semibold px-2.5 py-1 rounded-full">Open</span>
                            @else
                                <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Resolved</span>
                            @endif
                        </td>
                        <td class="py-3 text-right">
                            @if ($error->status === 'open')
                                <form method="POST" action="{{ route('admin.system.activity.error-logs.resolve', $error) }}">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold border border-black/10 rounded-full px-3.5 py-1.5 hover:bg-black/5 transition">Resolve</button>
                                </form>
                            @else
                                <span class="text-xs text-black/30 px-3.5 py-1.5 inline-block">Resolved</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-center text-black/40 text-sm">No errors logged.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if ($errorLogs->hasPages())
            <div class="pt-5 mt-5 border-t border-black/5">
                {{ $errorLogs->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>
</div>

<!-- Error Detail Drawer -->
<div id="errorDetailDrawer" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/40" onclick="closeErrorDrawer()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-sm bg-white shadow-soft p-6 overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-base">Error Detail</h2>
            <button type="button" onclick="closeErrorDrawer()" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <dl class="space-y-4 text-sm">
            <div><dt class="text-black/40 text-xs mb-0.5">Type</dt><dd id="errDrawerType" class="font-medium"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Endpoint</dt><dd id="errDrawerEndpoint" class="font-mono text-xs"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Message</dt><dd id="errDrawerMessage"></dd></div>
            <div>
                <dt class="text-black/40 text-xs mb-1">Stack Trace</dt>
                <dd id="errDrawerTrace" class="bg-black/[0.03] rounded-xl p-3 font-mono text-[11px] whitespace-pre-wrap"></dd>
            </div>
            <div><dt class="text-black/40 text-xs mb-0.5">Occurrences</dt><dd id="errDrawerOccurrences" class="font-medium"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Status</dt><dd id="errDrawerStatus" class="font-medium"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">First Seen</dt><dd id="errDrawerFirst"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Last Seen</dt><dd id="errDrawerLast"></dd></div>
        </dl>
    </div>
</div>

<script>
  (function () {
    const drawer = document.getElementById('errorDetailDrawer');
    document.querySelectorAll('.error-row').forEach(row => {
      row.addEventListener('click', () => {
        document.getElementById('errDrawerType').textContent = row.dataset.type;
        document.getElementById('errDrawerEndpoint').textContent = row.dataset.endpoint;
        document.getElementById('errDrawerMessage').textContent = row.dataset.message;
        document.getElementById('errDrawerTrace').textContent = row.dataset.trace || 'No stack trace available.';
        document.getElementById('errDrawerOccurrences').textContent = row.dataset.occurrences;
        document.getElementById('errDrawerStatus').textContent = row.dataset.status;
        document.getElementById('errDrawerFirst').textContent = row.dataset.first;
        document.getElementById('errDrawerLast').textContent = row.dataset.last;
        drawer.classList.remove('hidden');
      });
    });
    window.closeErrorDrawer = () => drawer.classList.add('hidden');
  })();
</script>
