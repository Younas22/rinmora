@php
    $subStatusStyle = ['active' => 'success', 'inactive' => 'black/5', 'unsubscribed' => 'danger'];
@endphp

<div id="section-newsletter" class="section-panel {{ $tab !== 'newsletter' ? 'hidden' : '' }}">

    <div class="grid sm:grid-cols-2 gap-4 mb-5">
        <div class="bg-white rounded-2xl shadow-card p-5"><p class="text-black/45 text-xs mb-1">Total Subscribers</p><p class="text-xl font-bold">{{ number_format($subscriberStats['total']) }}</p></div>
        <div class="bg-white rounded-2xl shadow-card p-5"><p class="text-black/45 text-xs mb-1">Active</p><p class="text-xl font-bold text-success">{{ number_format($subscriberStats['active']) }}</p></div>
    </div>

    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <input type="hidden" name="tab" value="newsletter">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <input type="text" name="sub_search" value="{{ request('sub_search') }}" placeholder="Search subscribers..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="sub_status" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Statuses</option>
                    <option value="active" @selected(request('sub_status') === 'active')>Subscribed</option>
                    <option value="unsubscribed" @selected(request('sub_status') === 'unsubscribed')>Unsubscribed</option>
                    <option value="inactive" @selected(request('sub_status') === 'inactive')>Inactive</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        <form id="bulkSubscriberForm" method="POST" action="{{ route('admin.system.support.newsletter.bulk-destroy') }}">
            @csrf
            <div id="subscriberBulkBar" class="hidden items-center justify-between gap-3 px-4 py-3 bg-ink text-white text-sm mx-4 md:mx-5 mt-4 rounded-2xl">
                <span><span id="subscriberSelectedCount">0</span> selected</span>
                <button type="submit" onclick="return confirm('Delete selected subscribers?');" class="text-xs font-semibold px-3 py-1.5 rounded-full bg-danger hover:bg-danger/85 transition">Bulk Delete</button>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm min-w-[640px]">
                    <thead>
                        <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                            <th class="py-3 pl-5 font-medium w-8"><input type="checkbox" id="subscriberSelectAll"></th>
                            <th class="py-3 font-medium">Email</th>
                            <th class="py-3 font-medium">Status</th>
                            <th class="py-3 font-medium">Subscription Date</th>
                            <th class="py-3 pr-5 font-medium">Source</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5">
                        @forelse ($subscribers as $sub)
                            <tr class="hover:bg-black/[0.02] transition">
                                <td class="py-3 pl-5"><input type="checkbox" name="ids[]" value="{{ $sub->id }}" class="subscriber-checkbox"></td>
                                <td class="py-3 font-medium">{{ $sub->email }}</td>
                                <td class="py-3"><span class="bg-{{ $subStatusStyle[$sub->status] ?? 'black/5' }}/10 text-{{ $subStatusStyle[$sub->status] ?? 'black/50' }} text-[11px] font-semibold px-2.5 py-1 rounded-full capitalize">{{ $sub->status === 'active' ? 'Subscribed' : $sub->status }}</span></td>
                                <td class="py-3 text-black/45 text-xs">{{ $sub->joined_date?->format('M j, Y') ?? '—' }}</td>
                                <td class="py-3 pr-5 text-black/60">{{ $sub->source ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-black/40 text-sm">No subscribers yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @if ($subscribers->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $subscribers->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>
</div>

<script>
  (function () {
    const selectAll = document.getElementById('subscriberSelectAll');
    const bar = document.getElementById('subscriberBulkBar');
    const countEl = document.getElementById('subscriberSelectedCount');

    function updateBar() {
      const checked = document.querySelectorAll('.subscriber-checkbox:checked').length;
      countEl.textContent = checked;
      bar.classList.toggle('hidden', checked === 0);
      bar.classList.toggle('flex', checked > 0);
    }

    selectAll?.addEventListener('change', () => {
      document.querySelectorAll('.subscriber-checkbox').forEach(cb => { cb.checked = selectAll.checked; });
      updateBar();
    });
    document.querySelectorAll('.subscriber-checkbox').forEach(cb => cb.addEventListener('change', updateBar));
  })();
</script>
