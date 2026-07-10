<div id="panel-currency" class="tab-panel {{ request('tab') !== 'currency' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.currency') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <h2 class="font-bold text-sm mb-5">Currency Configuration</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1.5">Default Currency</label>
                <select name="default_currency" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    @foreach (['USD' => 'US Dollar', 'EUR' => 'Euro', 'GBP' => 'British Pound', 'AED' => 'UAE Dirham', 'PKR' => 'Pakistani Rupee'] as $code => $label)
                        <option value="{{ $code }}" @selected(($currency['default_currency'] ?? 'USD') === $code)>{{ $code }} — {{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Currency Symbol</label>
                    <input type="text" name="currency_symbol" value="{{ $currency['currency_symbol'] ?? '$' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Symbol Position</label>
                    <select name="currency_position" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <option value="before" @selected(($currency['currency_position'] ?? 'before') === 'before')>Before amount ($100)</option>
                        <option value="after" @selected(($currency['currency_position'] ?? 'before') === 'after')>After amount (100$)</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Decimal Places</label>
                <select name="decimal_places" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    <option value="0" @selected(($currency['decimal_places'] ?? '2') === '0')>0</option>
                    <option value="2" @selected(($currency['decimal_places'] ?? '2') === '2')>2</option>
                </select>
            </div>
            <div class="flex items-center justify-between gap-4 py-1">
                <p class="text-sm font-semibold">Currency Active</p>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" name="currency_active" value="1" class="peer sr-only" {{ ($currency['currency_active'] ?? '1') === '1' ? 'checked' : '' }}>
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
