@php
    $editingCurrency = request('edit_currency') ? $currencies->firstWhere('id', (int) request('edit_currency')) : null;
@endphp

<div id="panel-currency" class="tab-panel space-y-6 {{ request('tab') !== 'currency' ? 'hidden' : '' }}">

    <div class="bg-primary/10 rounded-xl px-4 py-3 text-xs text-black/60 leading-relaxed">
        <strong>How this applies:</strong> whichever currency is "Active" below is used to format every price across the admin panel and the storefront — symbol, decimal places, and exchange rate all switch instantly, no rebuild needed. Prices are stored in the base currency ({{ $currencies->firstWhere('is_base', true)?->code ?? 'USD' }}); the exchange rate converts to the active currency for display only.
    </div>

    <div class="grid lg:grid-cols-[360px_1fr] gap-6 items-start">

        <form method="POST" action="{{ $editingCurrency ? route('admin.system.settings.currencies.update', $editingCurrency) : route('admin.system.settings.currencies.store') }}" class="bg-white rounded-3xl shadow-card p-5 lg:sticky lg:top-[88px]">
            @csrf
            @if ($editingCurrency) @method('PUT') @endif

            <h2 class="font-bold text-sm mb-1">{{ $editingCurrency ? 'Edit Currency' : 'Add New Currency' }}</h2>
            <p class="text-black/40 text-xs mb-5">{{ $editingCurrency ? 'Update this currency.' : 'Add a currency to make it selectable as active.' }}</p>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="currCode">Code</label>
                        <input id="currCode" name="code" type="text" maxlength="3" placeholder="USD" style="text-transform:uppercase" value="{{ old('code', $editingCurrency?->code) }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm font-mono uppercase focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="currSymbol">Symbol</label>
                        <input id="currSymbol" name="symbol" type="text" placeholder="$" value="{{ old('symbol', $editingCurrency?->symbol) }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="currName">Name</label>
                    <input id="currName" name="name" type="text" placeholder="US Dollar" value="{{ old('name', $editingCurrency?->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="currPosition">Symbol Position</label>
                        <div class="relative">
                            <select id="currPosition" name="symbol_position" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition pr-9">
                                <option value="before" @selected(old('symbol_position', $editingCurrency?->symbol_position ?? 'before') === 'before')>Before ($100)</option>
                                <option value="after" @selected(old('symbol_position', $editingCurrency?->symbol_position) === 'after')>After (100$)</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="currDecimals">Decimal Places</label>
                        <input id="currDecimals" name="decimal_places" type="number" min="0" max="4" value="{{ old('decimal_places', $editingCurrency?->decimal_places ?? 2) }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="currRate">Exchange Rate <span class="text-black/40 font-normal">(vs base currency)</span></label>
                    <input id="currRate" name="exchange_rate" type="number" step="0.000001" min="0.000001" value="{{ old('exchange_rate', $editingCurrency?->exchange_rate ?? 1) }}" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition mt-2">
                    <i class="fa-solid fa-{{ $editingCurrency ? 'check' : 'plus' }} text-[10px]"></i> {{ $editingCurrency ? 'Update Currency' : 'Add Currency' }}
                </button>
                @if ($editingCurrency)
                    <a href="{{ route('admin.system.settings.index', ['tab' => 'currency']) }}" class="block text-center text-xs font-semibold text-black/45 hover:text-ink transition mt-2">Cancel edit</a>
                @endif
            </div>
        </form>

        <div class="bg-white rounded-3xl shadow-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[640px]">
                    <thead>
                        <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                            <th class="py-3 pl-5 font-medium">Currency</th>
                            <th class="py-3 font-medium">Symbol</th>
                            <th class="py-3 font-medium">Rate</th>
                            <th class="py-3 font-medium">Active</th>
                            <th class="py-3 pr-5 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5">
                        @foreach ($currencies as $currency)
                            <tr class="hover:bg-black/[0.02] transition">
                                <td class="py-3 pl-5">
                                    <p class="font-semibold">{{ $currency->code }} <span class="text-black/40 font-normal">— {{ $currency->name }}</span></p>
                                    @if ($currency->is_base)
                                        <span class="bg-black/5 text-black/45 text-[10px] font-semibold px-2 py-0.5 rounded-full">Base currency</span>
                                    @endif
                                </td>
                                <td class="py-3 text-black/60 font-mono">{{ $currency->symbol }}</td>
                                <td class="py-3 text-black/60 font-mono">{{ rtrim(rtrim(number_format((float) $currency->exchange_rate, 6), '0'), '.') }}</td>
                                <td class="py-3">
                                    @if ($currency->is_active)
                                        <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Active</span>
                                    @else
                                        <form method="POST" action="{{ route('admin.system.settings.currencies.activate', $currency) }}">
                                            @csrf
                                            <button type="submit" class="text-xs font-semibold text-black/50 hover:text-ink transition">Set Active</button>
                                        </form>
                                    @endif
                                </td>
                                <td class="py-3 pr-5 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.system.settings.index', ['tab' => 'currency', 'edit_currency' => $currency->id]) }}" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">Edit</a>
                                    @unless ($currency->is_active || $currency->is_base)
                                        <form method="POST" action="{{ route('admin.system.settings.currencies.destroy', $currency) }}" class="inline" onsubmit="return confirm('Delete this currency?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-danger hover:text-danger/70 transition">Delete</button>
                                        </form>
                                    @endunless
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
