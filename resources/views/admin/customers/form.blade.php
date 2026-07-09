@php
    $customer = $customer ?? null;
    $isEdit = (bool) $customer;
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.customers.update', $customer) : route('admin.customers.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">{{ $isEdit ? 'Edit Customer' : 'Add Customer' }}</h1>
            <p class="text-black/45 text-sm mt-1">{{ $isEdit ? 'Update this customer\'s details.' : 'Manually add a new customer record.' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-2 bg-white border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">
                <i class="fa-solid fa-arrow-left text-black/40 text-[10px]"></i> Back
            </a>
            <button type="submit" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-5 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                <i class="fa-solid fa-check text-[10px]"></i> {{ $isEdit ? 'Save Changes' : 'Create Customer' }}
            </button>
        </div>
    </div>

    <div class="grid lg:grid-cols-[1fr_320px] gap-6 items-start">
        <div class="space-y-6 min-w-0">
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-1">Basic Information</h2>
                <p class="text-black/40 text-xs mb-5">Customer's name and contact details.</p>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="firstName">First Name</label>
                        <input id="firstName" name="first_name" type="text" required value="{{ old('first_name', $customer?->first_name) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="lastName">Last Name</label>
                        <input id="lastName" name="last_name" type="text" required value="{{ old('last_name', $customer?->last_name) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="email">Email</label>
                        <input id="email" name="email" type="email" required value="{{ old('email', $customer?->email) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="phone">Phone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $customer?->phone) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-1">Address</h2>
                <p class="text-black/40 text-xs mb-5">Default address on file (separate from saved shipping/billing addresses).</p>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium mb-1.5" for="address">Street Address</label>
                        <input id="address" name="address" type="text" value="{{ old('address', $customer?->address) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="city">City</label>
                        <input id="city" name="city" type="text" value="{{ old('city', $customer?->city) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="state">State</label>
                        <input id="state" name="state" type="text" value="{{ old('state', $customer?->state) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="zipCode">Postal Code</label>
                        <input id="zipCode" name="zip_code" type="text" value="{{ old('zip_code', $customer?->zip_code) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="country">Country</label>
                        <input id="country" name="country" type="text" value="{{ old('country', $customer?->country) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <label class="block text-sm font-medium mb-1.5" for="internalNotes">Internal Notes</label>
                <textarea id="internalNotes" name="internal_notes" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none">{{ old('internal_notes', $customer?->internal_notes) }}</textarea>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Status &amp; Tier</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="status">Status</label>
                        <select id="status" name="status" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                            @foreach (['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended', 'vip' => 'VIP'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $customer?->status ?? 'active') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="customerTier">Tier</label>
                        <select id="customerTier" name="customer_tier" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                            @foreach (['bronze' => 'Bronze', 'silver' => 'Silver', 'gold' => 'Gold', 'platinum' => 'Platinum'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('customer_tier', $customer?->customer_tier ?? 'bronze') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="flex items-center justify-between gap-4 py-1 cursor-pointer">
                        <span class="text-sm font-semibold">Newsletter / Marketing Emails</span>
                        <span class="relative inline-flex items-center shrink-0">
                            <input type="checkbox" name="marketing_emails" value="1" class="peer sr-only" @checked(old('marketing_emails', $customer?->marketing_emails))>
                            <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                            <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>
