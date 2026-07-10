@php
    $languages = ['en' => 'English', 'ar' => 'Arabic', 'ur' => 'Urdu', 'fr' => 'French', 'de' => 'German', 'es' => 'Spanish'];
@endphp

<div id="panel-language" class="tab-panel {{ request('tab') !== 'language' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.language') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <h2 class="font-bold text-sm mb-5">Language Preferences</h2>
        <div class="space-y-4 mb-6">
            <div>
                <label class="block text-sm font-medium mb-1.5">Default Language</label>
                <select name="default_language" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    @foreach ($languages as $code => $name)
                        <option value="{{ $code }}" @selected(($language['default_language'] ?? 'en') === $code)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center justify-between gap-4 py-1">
                <div><p class="text-sm font-semibold">RTL Layout</p><p class="text-black/45 text-xs mt-0.5">Enable right-to-left layout for Arabic/Urdu.</p></div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" name="rtl_layout" value="1" class="peer sr-only" {{ ($language['rtl_layout'] ?? '0') === '1' ? 'checked' : '' }}>
                    <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                    <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                </label>
            </div>
        </div>

        <p class="text-sm font-semibold mb-3">Available Languages</p>
        <div class="grid sm:grid-cols-2 gap-2">
            @foreach ($languages as $code => $name)
                <label class="flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl border border-black/10">
                    <span class="text-sm">{{ $name }}</span>
                    <input type="checkbox" name="enabled_languages[]" value="{{ $code }}" class="rounded" {{ in_array($code, $enabledLanguages ?: ['en', 'ar', 'ur']) ? 'checked' : '' }}>
                </label>
            @endforeach
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>
</div>
