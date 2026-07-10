@php
    $schemaTypes = ['Product', 'Organization', 'BreadcrumbList', 'FAQPage', 'LocalBusiness'];
@endphp

<div id="panel-schema" class="tab-panel space-y-6 {{ request('tab') !== 'schema' ? 'hidden' : '' }}">

    @if ($selectedMeta)
        <form method="POST" action="{{ route('admin.cms.seo.schema.update', $selectedMeta) }}">
            @csrf @method('PUT')

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 mb-6">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                    <div>
                        <h2 class="font-bold text-sm">Schema Builder</h2>
                        <p class="text-black/40 text-xs mt-0.5">Structured data for rich search results &mdash; editing: {{ $selectedMeta->page_label }}</p>
                    </div>
                    <div class="relative">
                        <label for="schemaPagePicker" class="sr-only">Page</label>
                        <select id="schemaPagePicker" onchange="window.location = this.value" class="appearance-none px-4 py-2.5 pr-10 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                            @foreach ($seoMetas as $meta)
                                <option value="{{ route('admin.cms.seo.index', ['tab' => 'schema', 'page' => $meta->page_url]) }}" @selected($meta->id === $selectedMeta->id)>{{ $meta->page_label }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="schemaType">Schema Type</label>
                        <div class="relative">
                            <select id="schemaType" name="schema_type" class="w-full appearance-none px-4 py-2.5 pr-10 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                                <option value="">None</option>
                                @foreach ($schemaTypes as $type)
                                    <option value="{{ $type }}" @selected($selectedMeta->schema_type === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 mb-6">
                <div class="flex items-center justify-between mb-1">
                    <h2 class="font-bold text-sm">JSON-LD Output</h2>
                </div>
                <p class="text-black/40 text-xs mb-5">Raw JSON-LD to inject into this page's <code class="font-mono">&lt;head&gt;</code>. Must be valid JSON.</p>
                <label for="schemaJson" class="sr-only">Schema JSON</label>
                <textarea id="schemaJson" name="schema_json" rows="14" class="w-full px-4 py-3 rounded-xl border border-black/10 bg-black/[0.03] font-mono text-xs focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none">{{ $selectedMeta->schema_json }}</textarea>
                <p id="schemaJsonError" class="text-danger text-xs mt-2 hidden">Invalid JSON &mdash; please fix before saving.</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-black/5 mt-2">
                <button type="submit" id="schemaSaveBtn" class="text-sm font-semibold px-6 py-2.5 rounded-full bg-ink text-white hover:bg-black/80 transition">Save Changes</button>
            </div>
        </form>
    @else
        <div class="bg-white rounded-3xl shadow-card p-10 text-center text-black/40 text-sm">No pages tracked yet.</div>
    @endif
</div>

<script>
  (function () {
    const form = document.getElementById('schemaJson')?.closest('form');
    const jsonField = document.getElementById('schemaJson');
    const errorMsg = document.getElementById('schemaJsonError');
    form?.addEventListener('submit', (e) => {
      const value = jsonField.value.trim();
      if (!value) { errorMsg.classList.add('hidden'); return; }
      try {
        JSON.parse(value);
        errorMsg.classList.add('hidden');
      } catch (err) {
        e.preventDefault();
        errorMsg.classList.remove('hidden');
      }
    });
  })();
</script>
