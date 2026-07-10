@php
    $platformMeta = [
        'facebook' => ['icon' => 'fa-brands fa-facebook', 'placeholder' => 'https://facebook.com/rinmora'],
        'instagram' => ['icon' => 'fa-brands fa-instagram', 'placeholder' => 'https://instagram.com/rinmora'],
        'tiktok' => ['icon' => 'fa-brands fa-tiktok', 'placeholder' => 'https://tiktok.com/@rinmora'],
        'pinterest' => ['icon' => 'fa-brands fa-pinterest', 'placeholder' => 'https://pinterest.com/rinmora'],
        'youtube' => ['icon' => 'fa-brands fa-youtube', 'placeholder' => 'https://youtube.com/@rinmora'],
        'linkedin' => ['icon' => 'fa-brands fa-linkedin', 'placeholder' => 'https://linkedin.com/company/rinmora'],
        'twitter' => ['icon' => 'fa-brands fa-x-twitter', 'placeholder' => 'https://x.com/rinmora'],
        'whatsapp' => ['icon' => 'fa-brands fa-whatsapp', 'placeholder' => 'https://wa.me/14155550148'],
    ];
@endphp

<div id="panel-social" class="tab-panel {{ request('tab') !== 'social' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.social') }}" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <h2 class="font-bold text-sm mb-5">Social Profiles</h2>
        <div class="space-y-3">
            @foreach ($platformMeta as $key => $meta)
                <div class="flex items-center gap-3">
                    <i class="{{ $meta['icon'] }} text-black/40 w-5 text-center shrink-0"></i>
                    <input type="text" name="{{ $key }}_url" value="{{ $socialMedia["{$key}_url"] ?? '' }}" placeholder="{{ $meta['placeholder'] }}" class="flex-1 px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input type="checkbox" name="{{ $key }}_enabled" value="1" class="peer sr-only" {{ ($socialMedia["{$key}_enabled"] ?? '0') === '1' ? 'checked' : '' }}>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </label>
                </div>
            @endforeach
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>
</div>
