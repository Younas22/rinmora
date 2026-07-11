@extends('admin.catalog.layouts.app')

@section('title', 'Shipping')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Shipping</h1>
            <p class="text-black/45 text-sm mt-1">Manage shipping zones, rates, and delivery rules.</p>
        </div>
        <button type="button" onclick="openZoneModal()" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
            <i class="fa-solid fa-plus text-[10px]"></i> Add Shipping Zone
        </button>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Active Zones</p>
            <p class="text-xl font-bold">{{ $stats['active_zones'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Shipping Methods</p>
            <p class="text-xl font-bold">{{ $stats['methods'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Free Shipping Threshold</p>
            <p class="text-xl font-bold">{{ format_price((float) $stats['free_shipping_threshold']) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 mb-6">
        <h2 class="font-bold text-sm mb-4">Shipping Zones</h2>
        <div class="space-y-3">
            @forelse ($zones as $zone)
                <div class="border border-black/10 rounded-2xl overflow-hidden">
                    <button type="button" class="zone-toggle w-full flex items-center justify-between gap-3 p-4 text-left hover:bg-black/[0.02] transition">
                        <div>
                            <p class="text-sm font-semibold">{{ $zone->name }}</p>
                            <p class="text-black/40 text-xs mt-0.5">{{ $zone->countries }} &middot; {{ $zone->methods->count() }} methods</p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            @if ($zone->is_active)
                                <span class="bg-success/10 text-success text-[10px] font-semibold px-2 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-black/5 text-black/45 text-[10px] font-semibold px-2 py-1 rounded-full">Inactive</span>
                            @endif
                            <i class="fa-solid fa-chevron-down text-xs text-black/30 zone-chevron transition-transform"></i>
                        </div>
                    </button>
                    <div class="zone-detail hidden px-4 pb-4">
                        <table class="w-full text-sm mb-3">
                            <tbody class="divide-y divide-black/5">
                                @foreach ($zone->methods as $method)
                                    <tr>
                                        <td class="py-2">{{ $method->name }}</td>
                                        <td class="py-2 text-black/50">{{ $method->delivery_time }}</td>
                                        <td class="py-2 text-right font-medium">{{ $method->rate_label }}</td>
                                        <td class="py-2 pl-3 text-right">
                                            <form method="POST" action="{{ route('admin.sales.shipping.methods.destroy', $method) }}" class="inline" onsubmit="return confirm('Delete this method?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-black/30 hover:text-danger transition"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form method="POST" action="{{ route('admin.sales.shipping.methods.store', $zone) }}" class="flex flex-wrap items-center gap-2">
                            @csrf
                            <input type="text" name="name" placeholder="Method name" required class="flex-1 min-w-[120px] px-3 py-2 rounded-lg border border-black/10 text-xs">
                            <input type="text" name="delivery_time" placeholder="e.g. 3-5 days" required class="w-28 px-3 py-2 rounded-lg border border-black/10 text-xs">
                            <input type="number" step="0.01" min="0" name="rate" placeholder="Rate (blank=Free)" class="w-32 px-3 py-2 rounded-lg border border-black/10 text-xs">
                            <button type="submit" class="text-xs font-semibold bg-ink text-white rounded-lg px-3 py-2 hover:bg-black/80 transition">Add Method</button>
                        </form>
                        <div class="flex items-center gap-3 mt-3 pt-3 border-t border-black/5">
                            <button type="button" class="edit-zone-btn text-xs font-semibold text-black/50 hover:text-ink transition"
                                data-id="{{ $zone->id }}" data-name="{{ $zone->name }}" data-countries="{{ $zone->countries }}" data-active="{{ $zone->is_active ? 1 : 0 }}"
                                data-action="{{ route('admin.sales.shipping.zones.update', $zone) }}">Edit Zone</button>
                            <form method="POST" action="{{ route('admin.sales.shipping.zones.destroy', $zone) }}" onsubmit="return confirm('Delete this zone and all its methods?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-danger hover:text-danger/70 transition">Delete Zone</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-black/40 text-sm text-center py-6">No shipping zones yet.</p>
            @endforelse
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <h2 class="font-bold text-sm mb-4">Free Shipping Rule</h2>
            <form method="POST" action="{{ route('admin.sales.shipping.free-threshold') }}">
                @csrf @method('PUT')
                <label class="flex items-center justify-between gap-4 py-1 mb-4 cursor-pointer">
                    <span class="text-sm font-semibold">Enable Free Shipping</span>
                    <span class="relative inline-flex items-center shrink-0">
                        <input type="checkbox" name="free_shipping_enabled" value="1" class="peer sr-only" @checked($freeShippingEnabled)>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </span>
                </label>
                <label class="block text-sm font-medium mb-1.5" for="freeShipThreshold">Minimum Order Amount</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-black/35 text-sm">{{ \App\Models\Currency::where('is_base', true)->value('symbol') ?? '$' }}</span>
                    <input id="freeShipThreshold" name="free_shipping_threshold" type="number" step="0.01" min="0" value="{{ $freeShippingThreshold }}" class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <p class="text-black/45 text-xs mt-1.5">Orders above this amount qualify for free standard shipping.</p>
                <button type="submit" class="mt-4 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Rule</button>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <h2 class="font-bold text-sm mb-4">Shipping Calculator (Preview)</h2>
            <div class="space-y-3">
                <select id="calcZone" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    @foreach ($zones as $zone)
                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                    @endforeach
                </select>
                <input id="calcWeight" type="number" step="0.1" value="1.2" placeholder="Weight (kg)" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                <button type="button" id="calcShippingBtn" class="w-full bg-ink text-white rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/80 transition">Calculate Estimate</button>
                <div id="calcResult" class="hidden bg-black/[0.02] rounded-xl p-4 text-sm">
                    <div class="flex justify-between mb-1"><span class="text-black/50">Estimated Cost</span><span id="calcCost" class="font-semibold"></span></div>
                    <div class="flex justify-between"><span class="text-black/50">Delivery Time</span><span id="calcTime" class="font-semibold"></span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone Modal -->
    <div id="zoneModal" class="hidden fixed inset-0 z-50 bg-black/40 grid place-items-center p-4">
        <form method="POST" id="zoneForm" class="bg-white rounded-3xl shadow-soft w-full max-w-md p-6">
            @csrf
            <div id="zoneMethodField"></div>
            <div class="flex items-center justify-between mb-4">
                <h2 id="zoneModalTitle" class="font-bold text-base">Add Shipping Zone</h2>
                <button type="button" onclick="closeZoneModal()" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Zone Name</label>
                    <input type="text" name="name" id="zoneName" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Countries</label>
                    <input type="text" name="countries" id="zoneCountries" required placeholder="e.g. United States, Canada" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <label class="flex items-center gap-2 text-sm font-medium">
                    <input type="checkbox" name="is_active" id="zoneActive" value="1" checked class="rounded"> Active
                </label>
                <button type="submit" class="w-full bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Save Zone</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.zone-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const detail = btn.nextElementSibling;
      const chevron = btn.querySelector('.zone-chevron');
      detail.classList.toggle('hidden');
      chevron.classList.toggle('rotate-180');
    });
  });

  function openZoneModal(data = null) {
    const form = document.getElementById('zoneForm');
    form.action = data ? data.action : "{{ route('admin.sales.shipping.zones.store') }}";
    document.getElementById('zoneMethodField').innerHTML = data ? '<input type="hidden" name="_method" value="PATCH">' : '';
    document.getElementById('zoneModalTitle').textContent = data ? 'Edit Shipping Zone' : 'Add Shipping Zone';
    document.getElementById('zoneName').value = data?.name || '';
    document.getElementById('zoneCountries').value = data?.countries || '';
    document.getElementById('zoneActive').checked = data ? data.active === '1' : true;
    document.getElementById('zoneModal').classList.remove('hidden');
  }
  function closeZoneModal() { document.getElementById('zoneModal').classList.add('hidden'); }
  document.querySelectorAll('.edit-zone-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); openZoneModal(btn.dataset); }));

  @php
    $zoneMethodsPayload = $zones->mapWithKeys(function ($z) {
        $methods = $z->methods->map(function ($m) {
            return ['rate' => $m->rate, 'delivery_time' => $m->delivery_time];
        });

        return [$z->id => $methods];
    });
  @endphp
  const zoneMethods = @json($zoneMethodsPayload);

  document.getElementById('calcShippingBtn').addEventListener('click', () => {
    const zoneId = document.getElementById('calcZone').value;
    const methods = zoneMethods[zoneId] || [];
    const cheapest = methods.reduce((min, m) => (m.rate === null ? 0 : m.rate) < (min === null ? 0 : min.rate ?? 0) ? m : min, methods[0]);
    document.getElementById('calcCost').textContent = cheapest && cheapest.rate !== null ? '$' + parseFloat(cheapest.rate).toFixed(2) : 'Free';
    document.getElementById('calcTime').textContent = cheapest ? cheapest.delivery_time : '—';
    document.getElementById('calcResult').classList.remove('hidden');
  });
</script>
@endpush
