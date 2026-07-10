<div id="panel-redirects" class="tab-panel space-y-6 {{ request('tab') !== 'redirects' ? 'hidden' : '' }}">

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        <h2 class="font-bold text-sm mb-1">Add Redirect</h2>
        <p class="text-black/40 text-xs mb-5">Create a new URL redirect rule.</p>
        <form method="POST" action="{{ route('admin.cms.seo.redirects.store') }}" class="grid md:grid-cols-[1fr_1fr_140px_auto] gap-3 items-end">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1.5" for="fromUrl">From URL</label>
                <input id="fromUrl" name="from_url" type="text" value="{{ $prefillFrom }}" placeholder="/old-page-url" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5" for="toUrl">To URL</label>
                <input id="toUrl" name="to_url" type="text" placeholder="/new-page-url" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5" for="redirectType">Type</label>
                <div class="relative">
                    <select id="redirectType" name="type" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                        <option value="301">301 Permanent</option>
                        <option value="302">302 Temporary</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                </div>
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-ink text-white text-sm font-semibold px-6 py-2.5 rounded-full hover:bg-black/80 transition shrink-0">
                <i class="fa-solid fa-plus text-xs"></i> Add
            </button>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
        <h2 class="font-bold text-sm mb-5">Redirect Table</h2>
        <table class="w-full text-sm min-w-[760px]">
            <thead>
                <tr class="text-left text-black/40 text-xs uppercase tracking-wide">
                    <th class="pb-3 font-medium">Source URL</th>
                    <th class="pb-3 font-medium">Destination URL</th>
                    <th class="pb-3 font-medium">Type</th>
                    <th class="pb-3 font-medium">Hits</th>
                    <th class="pb-3 font-medium">Status</th>
                    <th class="pb-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($redirects as $redirect)
                    <tr class="hover:bg-black/[0.02] transition">
                        <td class="py-3.5 font-mono text-xs">{{ $redirect->from_url }}</td>
                        <td class="py-3.5 font-mono text-xs text-black/60">{{ $redirect->to_url }}</td>
                        <td class="py-3.5"><span class="bg-info/10 text-info text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $redirect->type }}</span></td>
                        <td class="py-3.5">{{ number_format($redirect->hits) }}</td>
                        <td class="py-3.5">
                            @if ($redirect->status === 'active')
                                <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">Paused</span>
                            @endif
                        </td>
                        <td class="py-3.5">
                            <div class="flex items-center justify-end gap-1">
                                <button type="button" aria-label="Edit redirect" class="edit-redirect-btn w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"
                                    data-action="{{ route('admin.cms.seo.redirects.update', $redirect) }}" data-from="{{ $redirect->from_url }}"
                                    data-to="{{ $redirect->to_url }}" data-type="{{ $redirect->type }}" data-status="{{ $redirect->status }}">
                                    <i class="fa-solid fa-pen text-[11px] text-black/50"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.cms.seo.redirects.destroy', $redirect) }}" onsubmit="return confirm('Delete this redirect?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" aria-label="Delete redirect" class="w-8 h-8 rounded-full grid place-items-center hover:bg-danger/10 transition"><i class="fa-solid fa-trash text-[11px] text-danger"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-10 text-center text-black/40 text-sm">No redirects yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if ($redirects->hasPages())
            <div class="pt-5 mt-5 border-t border-black/5">
                {{ $redirects->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 overflow-x-auto">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-sm">404 Redirect Manager</h2>
            <span class="bg-danger/10 text-danger text-[11px] font-semibold px-2.5 py-1 rounded-full">{{ $notFoundLogs->count() }} URLs hit</span>
        </div>
        <table class="w-full text-sm min-w-[520px]">
            <thead>
                <tr class="text-left text-black/40 text-xs uppercase tracking-wide">
                    <th class="pb-3 font-medium">404 URL</th>
                    <th class="pb-3 font-medium">Hit Count</th>
                    <th class="pb-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($notFoundLogs as $log)
                    <tr class="hover:bg-black/[0.02] transition">
                        <td class="py-3.5 font-mono text-xs">{{ $log->url }}</td>
                        <td class="py-3.5">{{ $log->hit_count }}</td>
                        <td class="py-3.5 text-right">
                            <form method="POST" action="{{ route('admin.cms.seo.not-found.create-redirect', $log) }}">
                                @csrf
                                <button type="submit" class="text-xs font-semibold border border-black/10 rounded-full px-3.5 py-1.5 hover:bg-black/5 transition">Create Redirect</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-10 text-center text-black/40 text-sm">No 404s logged.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Edit Redirect Modal -->
    <div id="redirectModalOverlay" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <form method="POST" id="redirectForm" class="bg-white rounded-3xl shadow-soft w-full max-w-md p-6">
            @csrf @method('PATCH')
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-base">Edit Redirect</h2>
                <button type="button" id="redirectModalCloseBtn" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">From URL</label>
                    <input type="text" name="from_url" id="redirectFromUrl" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">To URL</label>
                    <input type="text" name="to_url" id="redirectToUrl" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Type</label>
                    <select name="type" id="redirectTypeSelect" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <option value="301">301 Permanent</option>
                        <option value="302">302 Temporary</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Status</label>
                    <select name="status" id="redirectStatusSelect" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <option value="active">Active</option>
                        <option value="paused">Paused</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Save Redirect</button>
            </div>
        </form>
    </div>
</div>

<script>
  (function () {
    const overlay = document.getElementById('redirectModalOverlay');
    const form = document.getElementById('redirectForm');
    document.querySelectorAll('.edit-redirect-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        form.action = btn.dataset.action;
        document.getElementById('redirectFromUrl').value = btn.dataset.from;
        document.getElementById('redirectToUrl').value = btn.dataset.to;
        document.getElementById('redirectTypeSelect').value = btn.dataset.type;
        document.getElementById('redirectStatusSelect').value = btn.dataset.status;
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
      });
    });
    document.getElementById('redirectModalCloseBtn').addEventListener('click', () => { overlay.classList.add('hidden'); overlay.classList.remove('flex'); });
    overlay.addEventListener('click', (e) => { if (e.target === overlay) { overlay.classList.add('hidden'); overlay.classList.remove('flex'); } });
  })();
</script>
