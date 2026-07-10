@php
    $ogUrl = ($seo['store_og_image'] ?? null) ? Storage::disk('public_uploads')->url($seo['store_og_image']) : null;
@endphp

<div id="panel-seo" class="tab-panel {{ request('tab') !== 'seo' ? 'hidden' : '' }}">
    <form method="POST" action="{{ route('admin.system.settings.seo') }}" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-card p-5 md:p-6">
        @csrf @method('PUT')
        <h2 class="font-bold text-sm mb-1">Default Meta Tags</h2>
        <p class="text-black/40 text-xs mb-5">Global fallback used when a page has no specific SEO override (see CMS &gt; SEO for per-page meta).</p>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1.5">Meta Title</label>
                <input type="text" name="store_meta_title" value="{{ $seo['store_meta_title'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Meta Description</label>
                <textarea name="store_meta_description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none">{{ $seo['store_meta_description'] ?? '' }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Meta Keywords</label>
                <input type="text" name="store_meta_keywords" value="{{ $seo['store_meta_keywords'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Canonical URL</label>
                <input type="text" name="store_canonical_url" value="{{ $seo['store_canonical_url'] ?? url('/') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">OG Image</label>
                <label class="block border-2 border-dashed border-black/10 rounded-2xl p-6 text-center hover:border-primary hover:bg-primary/5 transition cursor-pointer bg-cover bg-center" style="{{ $ogUrl ? "background-image:url('{$ogUrl}')" : '' }}">
                    <input type="file" name="store_og_image" accept="image/*" class="hidden">
                    @unless ($ogUrl)
                        <i class="fa-solid fa-cloud-arrow-up text-xl text-black/25 mb-2"></i>
                        <p class="text-sm font-medium">Click to upload</p>
                    @endunless
                </label>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-black/5">
            <button type="submit" class="bg-primary text-ink rounded-full px-6 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Save Changes</button>
        </div>
    </form>
</div>
