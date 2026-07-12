@php
    $assetUrl = fn ($path) => $path ? Storage::disk('public_uploads')->url($path) : null;
@endphp

<div id="panel-logo-favicon" class="tab-panel {{ request('tab') !== 'logo-favicon' ? 'hidden' : '' }}">
    <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 mb-6">
        <h2 class="font-bold text-sm mb-5">Current Assets</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="border border-black/10 rounded-2xl p-4 flex items-center gap-3">
                @if ($assetUrl($branding['logo_path'] ?? null))
                    <img src="{{ $assetUrl($branding['logo_path']) }}" alt="Logo" class="h-10 object-contain">
                @else
                    <span class="h-10 w-16 bg-black/5 rounded grid place-items-center text-black/25"><i class="fa-solid fa-image text-xs"></i></span>
                @endif
                <div><p class="text-sm font-medium">Logo</p><p class="text-black/40 text-xs">{{ ($branding['logo_path'] ?? null) ? 'Uploaded' : 'Not uploaded' }}</p></div>
            </div>
            <div class="border border-black/10 rounded-2xl p-4 flex items-center gap-3">
                @if ($assetUrl($branding['favicon_path'] ?? null))
                    <img src="{{ $assetUrl($branding['favicon_path']) }}" alt="Favicon" class="h-10 w-10 object-contain">
                @else
                    <span class="h-10 w-10 bg-black/5 rounded grid place-items-center text-black/25"><i class="fa-solid fa-image text-xs"></i></span>
                @endif
                <div><p class="text-sm font-medium">Favicon</p><p class="text-black/40 text-xs">{{ ($branding['favicon_path'] ?? null) ? 'Uploaded' : 'Not uploaded' }}</p></div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.system.settings.logo') }}" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <h2 class="font-bold text-sm mb-5">Upload New Assets</h2>
        @if ($errors->any())
            <div class="bg-danger/10 text-danger text-xs rounded-xl px-4 py-3 mb-4">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach (['logo' => 'Logo (PNG/JPG/SVG up to 5MB)', 'dark_logo' => 'Dark Logo (for dark header)', 'mobile_logo' => 'Mobile Logo (compact mark)', 'favicon' => 'Favicon (PNG/JPG, 512x512px)'] as $field => $helper)
                <label class="block border-2 border-dashed rounded-2xl p-6 text-center hover:border-primary hover:bg-primary/5 transition cursor-pointer {{ $errors->has($field) ? 'border-danger' : 'border-black/10' }}">
                    <input type="file" name="{{ $field }}" accept="image/*" class="hidden">
                    <i class="fa-solid fa-cloud-arrow-up text-xl text-black/25 mb-2"></i>
                    <p class="text-sm font-medium">Upload {{ str_replace('_', ' ', ucfirst($field)) }}</p>
                    <p class="text-black/40 text-[11px] mt-1">{{ $helper }}</p>
                    @error($field)
                        <p class="text-danger text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </label>
            @endforeach
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Upload</button>
        </div>
    </form>
</div>
