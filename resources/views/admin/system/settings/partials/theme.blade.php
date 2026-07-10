@php
    $colors = [
        'primary_color' => ['label' => 'Primary Color', 'default' => '#CFBAA5'],
        'secondary_color' => ['label' => 'Secondary Color', 'default' => '#000000'],
        'accent_color' => ['label' => 'Accent Color', 'default' => '#3B82F6'],
        'background_color' => ['label' => 'Background Color', 'default' => '#F8F8F8'],
    ];
@endphp

<div id="panel-theme-colors" class="tab-panel {{ request('tab') !== 'theme-colors' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.theme') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <h2 class="font-bold text-sm mb-5">Brand Palette</h2>
        <div class="grid sm:grid-cols-2 gap-5">
            @foreach ($colors as $key => $c)
                <div>
                    <label class="block text-sm font-medium mb-1.5">{{ $c['label'] }}</label>
                    <div class="flex items-center gap-2">
                        <input type="color" value="{{ $theme[$key] ?? $c['default'] }}" onchange="this.nextElementSibling.value = this.value" class="w-10 h-10 rounded-lg border border-black/10 cursor-pointer">
                        <input type="text" name="{{ $key }}" value="{{ $theme[$key] ?? $c['default'] }}" class="flex-1 px-4 py-2.5 rounded-xl border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary transition">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>
</div>
