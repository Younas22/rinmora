<div id="panel-general" class="tab-panel {{ request('tab', 'general') !== 'general' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.general') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <h2 class="font-bold text-sm mb-5">Store Details</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1.5">Store Name</label>
                <input type="text" name="store_name" value="{{ $general['store_name'] ?? 'Rinmora' }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Default Country</label>
                <select name="default_country" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    @foreach (['United States', 'United Kingdom', 'United Arab Emirates', 'Pakistan', 'Canada'] as $country)
                        <option value="{{ $country }}" @selected(($general['default_country'] ?? 'United States') === $country)>{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center justify-between gap-4 py-1">
                <div><p class="text-sm font-semibold">Store Status</p><p class="text-black/45 text-xs mt-0.5">Store is live and accepting orders from customers.</p></div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" name="store_status" value="1" class="peer sr-only" {{ ($general['store_status'] ?? '1') === '1' ? 'checked' : '' }}>
                    <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                    <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                </label>
            </div>
            <div class="flex items-center justify-between gap-4 py-1">
                <div><p class="text-sm font-semibold">Maintenance Mode</p><p class="text-black/45 text-xs mt-0.5">Show a maintenance page to visitors while you work.</p></div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" name="maintenance_mode" value="1" class="peer sr-only" {{ ($general['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' }}>
                    <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                    <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                </label>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>
</div>
