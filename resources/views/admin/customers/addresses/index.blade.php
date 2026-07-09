@extends('admin.catalog.layouts.app')

@section('title', 'Customer Addresses')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Customer Addresses</h1>
            <p class="text-black/45 text-sm mt-1">Browse every saved shipping and billing address across your customers.</p>
        </div>
        <button type="button" onclick="openAddressModal()" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
            <i class="fa-solid fa-plus text-[10px]"></i> Add Address
        </button>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Addresses</p>
            <p class="text-xl font-bold">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Default Shipping Set</p>
            <p class="text-xl font-bold text-success">{{ $stats['default_shipping'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Default Billing Set</p>
            <p class="text-xl font-bold text-info">{{ $stats['default_billing'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Countries Covered</p>
            <p class="text-xl font-bold">{{ $stats['countries'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-card overflow-hidden">
        <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                <label for="addressSearch" class="sr-only">Search addresses</label>
                <input id="addressSearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search by customer, city, or postcode..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
            </div>
            <div class="relative">
                <select name="type" aria-label="Filter by type" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Types</option>
                    <option value="shipping" @selected(request('type') === 'shipping')>Shipping</option>
                    <option value="billing" @selected(request('type') === 'billing')>Billing</option>
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
            <div class="relative">
                <select name="country" aria-label="Filter by country" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">All Countries</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" @selected(request('country') === $country)>{{ $country }}</option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[780px]">
                <thead>
                    <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                        <th class="py-3 pl-5 font-medium">Customer</th>
                        <th class="py-3 font-medium">Address</th>
                        <th class="py-3 font-medium">City / Country</th>
                        <th class="py-3 font-medium">Type</th>
                        <th class="py-3 font-medium text-center">Default</th>
                        <th class="py-3 pr-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($addresses as $address)
                        <tr class="hover:bg-black/[0.02] transition">
                            <td class="py-3 pl-5">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-8 h-8 rounded-full bg-primary/20 grid place-items-center text-xs font-semibold shrink-0">{{ strtoupper(substr($address->user->first_name ?? '?', 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <p class="font-medium truncate">{{ $address->user->full_name ?? 'Unknown' }}</p>
                                        <p class="text-black/40 text-xs truncate">{{ $address->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-black/60">{{ $address->address_line1 }}</td>
                            <td class="py-3 text-black/60">{{ $address->city }}, {{ $address->country }}</td>
                            <td class="py-3">
                                @if ($address->type === 'shipping')
                                    <span class="bg-info/10 text-info text-[11px] font-semibold px-2.5 py-1 rounded-full">Shipping</span>
                                @else
                                    <span class="bg-primary/15 text-primary-dark text-[11px] font-semibold px-2.5 py-1 rounded-full">Billing</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                @if ($address->is_default)
                                    <i class="fa-solid fa-circle-check text-success"></i>
                                @else
                                    <span class="text-black/25">—</span>
                                @endif
                            </td>
                            <td class="py-3 pr-5 text-right">
                                <button type="button" class="edit-address-btn text-xs font-semibold text-black/50 hover:text-ink transition mr-3"
                                    data-id="{{ $address->id }}" data-user_id="{{ $address->user_id }}" data-type="{{ $address->type }}"
                                    data-recipient_name="{{ $address->recipient_name }}" data-phone="{{ $address->phone }}"
                                    data-address_line1="{{ $address->address_line1 }}" data-address_line2="{{ $address->address_line2 }}"
                                    data-city="{{ $address->city }}" data-state="{{ $address->state }}" data-zip="{{ $address->zip }}" data-country="{{ $address->country }}"
                                    data-is_default="{{ $address->is_default ? 1 : 0 }}"
                                    data-action="{{ route('admin.customers.addresses.update', $address) }}">Edit</button>
                                <form method="POST" action="{{ route('admin.customers.addresses.destroy', $address) }}" class="inline" onsubmit="return confirm('Delete this address?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-danger hover:text-danger/70 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-10 text-center text-black/40 text-sm">No addresses yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($addresses->hasPages())
            <div class="p-4 md:p-5 border-t border-black/5">
                {{ $addresses->links('admin.catalog.partials.pagination') }}
            </div>
        @endif
    </div>

    <!-- Address Modal -->
    <div id="addressModal" class="hidden fixed inset-0 z-50 bg-black/40 grid place-items-center p-4">
        <form method="POST" id="addressForm" class="bg-white rounded-3xl shadow-soft w-full max-w-md p-6 max-h-[90vh] overflow-y-auto">
            @csrf
            <div id="addressMethodField"></div>
            <div class="flex items-center justify-between mb-4">
                <h2 id="addressModalTitle" class="font-bold text-base">Add Address</h2>
                <button type="button" onclick="closeAddressModal()" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Customer</label>
                    <select name="user_id" id="addressUserId" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        @foreach ($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->full_name }} ({{ $c->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Type</label>
                    <select name="type" id="addressType" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <option value="shipping">Shipping</option>
                        <option value="billing">Billing</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Recipient Name</label>
                    <input type="text" name="recipient_name" id="addressRecipientName" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Phone</label>
                    <input type="text" name="phone" id="addressPhone" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Address Line 1</label>
                    <input type="text" name="address_line1" id="addressLine1" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Address Line 2</label>
                    <input type="text" name="address_line2" id="addressLine2" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">City</label>
                        <input type="text" name="city" id="addressCity" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">State</label>
                        <input type="text" name="state" id="addressState" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Postal Code</label>
                        <input type="text" name="zip" id="addressZip" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Country</label>
                        <input type="text" name="country" id="addressCountry" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm font-medium">
                    <input type="checkbox" name="is_default" id="addressIsDefault" value="1" class="rounded"> Set as default for this type
                </label>
                <button type="submit" class="w-full bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Save Address</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
  function openAddressModal(data = null) {
    const form = document.getElementById('addressForm');
    form.action = data ? data.action : "{{ route('admin.customers.addresses.store') }}";
    document.getElementById('addressMethodField').innerHTML = data ? '<input type="hidden" name="_method" value="PATCH">' : '';
    document.getElementById('addressModalTitle').textContent = data ? 'Edit Address' : 'Add Address';
    document.getElementById('addressUserId').value = data?.user_id || '';
    document.getElementById('addressType').value = data?.type || 'shipping';
    document.getElementById('addressRecipientName').value = data?.recipient_name || '';
    document.getElementById('addressPhone').value = data?.phone || '';
    document.getElementById('addressLine1').value = data?.address_line1 || '';
    document.getElementById('addressLine2').value = data?.address_line2 || '';
    document.getElementById('addressCity').value = data?.city || '';
    document.getElementById('addressState').value = data?.state || '';
    document.getElementById('addressZip').value = data?.zip || '';
    document.getElementById('addressCountry').value = data?.country || '';
    document.getElementById('addressIsDefault').checked = data ? data.is_default === '1' : false;
    document.getElementById('addressModal').classList.remove('hidden');
  }
  function closeAddressModal() { document.getElementById('addressModal').classList.add('hidden'); }
  document.querySelectorAll('.edit-address-btn').forEach(btn => btn.addEventListener('click', () => openAddressModal(btn.dataset)));
</script>
@endpush
