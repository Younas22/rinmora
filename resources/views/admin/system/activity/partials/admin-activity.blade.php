<div id="panel-admin-activity" class="tab-panel {{ request('tab', 'admin-activity') !== 'admin-activity' ? 'hidden' : '' }}">
    <div class="grid lg:grid-cols-[1fr_300px] gap-5">

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <form method="GET" class="flex flex-wrap items-center gap-3 mb-4">
                <input type="hidden" name="tab" value="admin-activity">
                <div class="relative flex-1 min-w-[180px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                    <input type="text" name="activity_search" value="{{ request('activity_search') }}" placeholder="Search actions..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
                </div>
                <div class="relative">
                    <select name="module" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">All Modules</option>
                        @foreach ($moduleOptions as $m)
                            <option value="{{ $m }}" @selected(request('module') === $m)>{{ $m }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[640px]">
                    <thead>
                        <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                            <th class="py-3 font-medium">Admin</th>
                            <th class="py-3 font-medium">Module</th>
                            <th class="py-3 font-medium">Action</th>
                            <th class="py-3 font-medium">IP</th>
                            <th class="py-3 font-medium">Device</th>
                            <th class="py-3 font-medium">Date/Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5">
                        @forelse ($activities as $log)
                            <tr class="hover:bg-black/[0.02] transition cursor-pointer log-row"
                                data-admin="{{ $log->admin->full_name ?? 'Unknown' }}" data-module="{{ $log->module }}"
                                data-action="{{ $log->action }}" data-route="{{ $log->route_name }}" data-ip="{{ $log->ip_address }}"
                                data-device="{{ $log->device }}" data-browser="{{ $log->browser }}" data-url="{{ $log->url }}"
                                data-time="{{ $log->created_at->format('M j, Y \\a\\t g:i:s A') }}">
                                <td class="py-3 font-medium">{{ $log->admin->full_name ?? 'Unknown' }}</td>
                                <td class="py-3"><span class="bg-black/5 text-black/60 text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $log->module }}</span></td>
                                <td class="py-3 text-black/70">{{ $log->action }}</td>
                                <td class="py-3 font-mono text-xs text-black/50">{{ $log->ip_address }}</td>
                                <td class="py-3 text-black/50"><i class="fa-solid {{ $log->device === 'Mobile' ? 'fa-mobile-screen' : 'fa-desktop' }} mr-1 text-[10px]"></i>{{ $log->device }}</td>
                                <td class="py-3 text-black/45 text-xs">{{ $log->created_at->format('M j, Y g:i A') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-10 text-center text-black/40 text-sm">No activity recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($activities->hasPages())
                <div class="pt-5 mt-5 border-t border-black/5">
                    {{ $activities->links('admin.catalog.partials.pagination') }}
                </div>
            @endif
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-3xl shadow-card p-5">
                <h2 class="font-bold text-sm mb-4">Recent Activity</h2>
                <ol class="space-y-3">
                    @forelse ($recentActivity as $log)
                        <li class="flex items-start gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary-dark mt-1.5 shrink-0"></span>
                            <div class="min-w-0">
                                <p class="text-xs text-black/70">{{ $log->admin->full_name ?? 'Unknown' }} &mdash; {{ $log->action }}</p>
                                <p class="text-black/35 text-[11px]">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="text-xs text-black/40">No recent activity.</li>
                    @endforelse
                </ol>
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5">
                <h2 class="font-bold text-sm mb-4">Actions by Module</h2>
                <div class="space-y-3">
                    @forelse ($moduleBreakdown as $m)
                        @php $pct = round($m->cnt / $moduleTotal * 100); @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-black/60">{{ $m->module }}</span>
                                <span class="text-black/40">{{ $pct }}%</span>
                            </div>
                            <div class="h-1.5 rounded-full bg-black/5 overflow-hidden"><div class="h-full bg-primary-dark rounded-full" style="width:{{ $pct }}%"></div></div>
                        </div>
                    @empty
                        <p class="text-xs text-black/40">No data yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log Detail Drawer -->
<div id="logDetailDrawer" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/40" onclick="closeLogDrawer()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-sm bg-white shadow-soft p-6 overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-base">Activity Detail</h2>
            <button type="button" onclick="closeLogDrawer()" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <dl class="space-y-4 text-sm">
            <div><dt class="text-black/40 text-xs mb-0.5">Admin</dt><dd id="drawerAdmin" class="font-medium"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Module</dt><dd id="drawerModule" class="font-medium"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Action</dt><dd id="drawerAction" class="font-medium"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Route</dt><dd id="drawerRoute" class="font-mono text-xs"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">URL</dt><dd id="drawerUrl" class="font-mono text-xs break-all"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">IP Address</dt><dd id="drawerIp" class="font-mono text-xs"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Device</dt><dd id="drawerDevice"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Browser</dt><dd id="drawerBrowser"></dd></div>
            <div><dt class="text-black/40 text-xs mb-0.5">Timestamp</dt><dd id="drawerTime"></dd></div>
        </dl>
    </div>
</div>

<script>
  (function () {
    const drawer = document.getElementById('logDetailDrawer');
    document.querySelectorAll('.log-row').forEach(row => {
      row.addEventListener('click', () => {
        document.getElementById('drawerAdmin').textContent = row.dataset.admin;
        document.getElementById('drawerModule').textContent = row.dataset.module;
        document.getElementById('drawerAction').textContent = row.dataset.action;
        document.getElementById('drawerRoute').textContent = row.dataset.route || '—';
        document.getElementById('drawerUrl').textContent = row.dataset.url || '—';
        document.getElementById('drawerIp').textContent = row.dataset.ip || '—';
        document.getElementById('drawerDevice').textContent = row.dataset.device || '—';
        document.getElementById('drawerBrowser').textContent = row.dataset.browser || '—';
        document.getElementById('drawerTime').textContent = row.dataset.time;
        drawer.classList.remove('hidden');
      });
    });
    window.closeLogDrawer = () => drawer.classList.add('hidden');
  })();
</script>
