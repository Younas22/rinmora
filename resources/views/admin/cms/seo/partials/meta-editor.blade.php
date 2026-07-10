<div id="panel-meta-editor" class="tab-panel space-y-6 {{ request('tab') !== 'meta-editor' ? 'hidden' : '' }}">

    @if ($selectedMeta)
        <form method="POST" action="{{ route('admin.cms.seo.meta.update', $selectedMeta) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 mb-6">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                    <div>
                        <h2 class="font-bold text-sm">Meta Editor</h2>
                        <p class="text-black/40 text-xs mt-0.5">Editing: {{ $selectedMeta->page_label }}</p>
                    </div>
                    <div class="relative">
                        <label for="pagePicker" class="sr-only">Page</label>
                        <select id="pagePicker" onchange="window.location = this.value" class="appearance-none px-4 py-2.5 pr-10 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                            @foreach ($seoMetas as $meta)
                                <option value="{{ route('admin.cms.seo.index', ['tab' => 'meta-editor', 'page' => $meta->page_url]) }}" @selected($meta->id === $selectedMeta->id)>{{ $meta->page_label }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-medium" for="metaTitle">Meta Title</label>
                            <span id="metaTitleCount" class="text-black/40 text-xs">{{ strlen($selectedMeta->meta_title ?? '') }} / 60</span>
                        </div>
                        <input id="metaTitle" name="meta_title" type="text" value="{{ $selectedMeta->meta_title }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-medium" for="metaDescription">Meta Description</label>
                            <span id="metaDescCount" class="text-black/40 text-xs">{{ strlen($selectedMeta->meta_description ?? '') }} / 160</span>
                        </div>
                        <textarea id="metaDescription" name="meta_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none">{{ $selectedMeta->meta_description }}</textarea>
                    </div>
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="focusKeyword">Focus Keyword</label>
                            <input id="focusKeyword" name="focus_keyword" type="text" value="{{ $selectedMeta->focus_keyword }}" placeholder="e.g. leather handbags" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                            <p class="text-black/40 text-xs mt-1.5">The primary term this page should rank for.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="canonicalUrl">Canonical URL</label>
                            <input id="canonicalUrl" name="canonical_url" type="text" value="{{ $selectedMeta->canonical_url }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 mb-6">
                <h2 class="font-bold text-sm mb-1">Social Sharing</h2>
                <p class="text-black/40 text-xs mb-5">Controls how this page appears when shared on social platforms.</p>
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Open Graph Image</label>
                        <label class="block border-2 border-dashed border-black/10 rounded-2xl p-8 text-center hover:border-primary hover:bg-primary/5 transition cursor-pointer bg-cover bg-center" style="{{ $selectedMeta->og_image_url ? "background-image:url('{$selectedMeta->og_image_url}')" : '' }}">
                            <input type="file" name="og_image" accept="image/*" class="hidden">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-black/25 mb-3"></i>
                            <p class="text-sm font-medium">Click to upload or drag and drop</p>
                            <p class="text-black/40 text-xs mt-1">PNG, JPG up to 5MB &middot; 1200&times;630px recommended</p>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="twitterCardType">Twitter Card Type</label>
                        <div class="relative">
                            <select id="twitterCardType" name="twitter_card_type" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                                <option value="summary_large_image" @selected($selectedMeta->twitter_card_type === 'summary_large_image')>Summary Large Image</option>
                                <option value="summary" @selected($selectedMeta->twitter_card_type === 'summary')>Summary</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                        </div>
                        <p class="text-black/40 text-xs mt-1.5">Applies when this page is shared on X / Twitter.</p>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                    <h2 class="font-bold text-sm mb-5">Google Search Preview</h2>
                    <p class="text-[13px] text-black/60 truncate">{{ url('/') }} &rsaquo; {{ $selectedMeta->page_url }}</p>
                    <p id="spTitle" class="text-[#1a0dab] text-lg leading-snug mt-0.5 truncate">{{ $selectedMeta->meta_title }}</p>
                    <p id="spDesc" class="text-sm text-black/60 mt-1 leading-relaxed">{{ $selectedMeta->meta_description }}</p>
                </div>
                <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                    <h2 class="font-bold text-sm mb-1">Open Graph Preview</h2>
                    <p class="text-black/40 text-xs mb-4">How this page appears on Facebook / LinkedIn.</p>
                    <div class="rounded-2xl border border-black/10 overflow-hidden">
                        <div class="h-36 bg-black/5">
                            @if ($selectedMeta->og_image_url)
                                <img src="{{ $selectedMeta->og_image_url }}" alt="" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-3 bg-black/[0.02]">
                            <p class="text-[11px] uppercase tracking-wide text-black/40">{{ parse_url(url('/'), PHP_URL_HOST) }}</p>
                            <p class="text-sm font-semibold mt-0.5 truncate">{{ $selectedMeta->meta_title }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-black/5 mt-2">
                <button type="submit" class="text-sm font-semibold px-6 py-2.5 rounded-full bg-ink text-white hover:bg-black/80 transition">Save Changes</button>
            </div>
        </form>
    @else
        <div class="bg-white rounded-3xl shadow-card p-10 text-center text-black/40 text-sm">No pages tracked yet.</div>
    @endif
</div>

<script>
  (function () {
    const metaTitleInput = document.getElementById('metaTitle');
    const metaTitleCount = document.getElementById('metaTitleCount');
    metaTitleInput?.addEventListener('input', () => {
      metaTitleCount.textContent = metaTitleInput.value.length + ' / 60';
      document.getElementById('spTitle').textContent = metaTitleInput.value;
    });
    const metaDescInput = document.getElementById('metaDescription');
    const metaDescCount = document.getElementById('metaDescCount');
    metaDescInput?.addEventListener('input', () => {
      metaDescCount.textContent = metaDescInput.value.length + ' / 160';
      document.getElementById('spDesc').textContent = metaDescInput.value;
    });
  })();
</script>
