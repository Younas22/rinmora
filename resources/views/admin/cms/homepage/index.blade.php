@extends('admin.catalog.layouts.app')

@section('title', 'Homepage Builder')

@section('content')

    @php
        $typeLabels = [
            'hero_slider' => 'Hero Slider',
            'featured_categories' => 'Featured Categories',
            'best_sellers' => 'Best Sellers',
            'promotional_banner' => 'Promotional Banner',
            'testimonials' => 'Testimonials',
            'newsletter' => 'Newsletter',
            'custom_html' => 'Custom HTML',
        ];
        $typeIcons = [
            'hero_slider' => 'fa-images',
            'featured_categories' => 'fa-layer-group',
            'best_sellers' => 'fa-star',
            'promotional_banner' => 'fa-bullhorn',
            'testimonials' => 'fa-quote-right',
            'newsletter' => 'fa-envelope',
            'custom_html' => 'fa-code',
        ];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Homepage Builder</h1>
            <p class="text-black/45 text-sm mt-1">Arrange, enable, and preview the sections shoppers see on your homepage.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-black/40">{{ $stats['visible'] }} of {{ $stats['total'] }} sections visible</span>
        </div>
    </div>

    <div class="grid lg:grid-cols-[1fr_380px] gap-5">

        <!-- ============ SECTION MANAGER ============ -->
        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-sm">Section Manager</h2>
                <button type="button" id="addSectionBtn" class="inline-flex items-center gap-2 border border-black/10 rounded-full px-3.5 py-2 text-xs font-semibold hover:bg-black/5 transition">
                    <i class="fa-solid fa-plus text-[10px]"></i> Add New Section
                </button>
            </div>

            <ul id="sectionList" class="space-y-3">
                @forelse ($sections as $section)
                    <li class="section-row flex items-center gap-3 bg-canvas rounded-2xl p-3.5 hover-lift {{ $section->is_visible ? '' : 'opacity-60' }}" data-id="{{ $section->id }}">
                        <i class="fa-solid fa-grip-vertical text-black/25"></i>
                        <div class="w-11 h-11 rounded-xl overflow-hidden shrink-0 {{ $section->image_url ? '' : 'bg-primary/20 grid place-items-center' }}">
                            @if ($section->image_url)
                                <img src="{{ $section->image_url }}" alt="" class="w-full h-full object-cover {{ $section->is_visible ? '' : 'grayscale' }}">
                            @else
                                <i class="fa-solid {{ $typeIcons[$section->type] }} text-primary-dark text-sm"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold section-row-title">{{ $section->title }}</p>
                            <p class="text-black/40 text-xs section-row-subtitle">{{ $section->is_visible ? ($section->subtitle ?: $typeLabels[$section->type]) : 'Disabled' }} &middot; Position <span class="section-row-position">{{ $loop->iteration }}</span></p>
                        </div>
                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button" aria-label="Move up" class="move-up-btn w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-chevron-up text-xs text-black/40"></i></button>
                            <button type="button" aria-label="Move down" class="move-down-btn w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-chevron-down text-xs text-black/40"></i></button>
                            <button type="button" aria-label="Edit section" class="edit-section-btn w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"
                                data-id="{{ $section->id }}" data-type="{{ $section->type }}" data-title="{{ $section->title }}"
                                data-subtitle="{{ $section->subtitle }}" data-button-text="{{ $section->button_text }}"
                                data-button-link="{{ $section->button_link }}" data-content="{{ $section->content }}"
                                data-visible="{{ $section->is_visible ? 1 : 0 }}" data-image="{{ $section->image_url }}"
                                data-action="{{ route('admin.cms.homepage-sections.update', $section) }}">
                                <i class="fa-solid fa-pen text-xs text-black/40"></i>
                            </button>
                            <label class="relative inline-flex items-center cursor-pointer ml-1">
                                <input type="checkbox" class="peer sr-only visible-toggle" checked disabled>
                                <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                                <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                            </label>
                        </div>
                    </li>
                @empty
                    <li class="text-center text-black/40 text-sm py-10">No sections yet — add one to build your homepage.</li>
                @endforelse
            </ul>
        </div>

        <!-- ============ LIVE PREVIEW ============ -->
        <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 lg:sticky lg:top-24 h-fit">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-sm">Live Homepage Preview</h2>
                <span class="text-[10px] font-semibold uppercase tracking-wide bg-black/5 text-black/40 px-2.5 py-1 rounded-full" title="Static mockup preview, not wired to real section data">Preview</span>
            </div>
            {{-- Reproduced verbatim as static markup, matching the source mockup's own fidelity — not data-bound to $sections. --}}
            <div class="rounded-2xl border border-black/10 overflow-hidden">
                <div class="flex items-center gap-1.5 bg-black/[0.03] px-3 py-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-black/15"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-black/15"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-black/15"></span>
                    <span class="flex-1 text-center text-[10px] text-black/35">rinmora.com</span>
                </div>
                <div class="p-2 space-y-2 bg-canvas max-h-[520px] overflow-y-auto">
                    <div class="relative rounded-xl overflow-hidden aspect-[16/10]">
                        <img src="https://picsum.photos/seed/preview-hero/500/320" alt="" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex flex-col items-center justify-center text-white text-center px-4">
                            <p class="text-[13px] font-bold">Elegance You Can Carry.</p>
                            <span class="mt-1.5 text-[9px] bg-primary text-ink font-semibold px-2.5 py-1 rounded-full">Shop Now</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-1.5">
                        <div class="aspect-square rounded-full overflow-hidden"><img src="https://picsum.photos/seed/preview-cat-1/100/100" class="w-full h-full object-cover" alt=""></div>
                        <div class="aspect-square rounded-full overflow-hidden"><img src="https://picsum.photos/seed/preview-cat-2/100/100" class="w-full h-full object-cover" alt=""></div>
                        <div class="aspect-square rounded-full overflow-hidden"><img src="https://picsum.photos/seed/preview-cat-3/100/100" class="w-full h-full object-cover" alt=""></div>
                        <div class="aspect-square rounded-full overflow-hidden"><img src="https://picsum.photos/seed/preview-cat-4/100/100" class="w-full h-full object-cover" alt=""></div>
                    </div>
                    <div class="grid grid-cols-3 gap-1.5">
                        <div class="bg-white rounded-lg overflow-hidden"><img src="https://picsum.photos/seed/preview-prod-1/150/180" class="w-full aspect-[4/5] object-cover" alt=""></div>
                        <div class="bg-white rounded-lg overflow-hidden"><img src="https://picsum.photos/seed/preview-prod-2/150/180" class="w-full aspect-[4/5] object-cover" alt=""></div>
                        <div class="bg-white rounded-lg overflow-hidden"><img src="https://picsum.photos/seed/preview-prod-3/150/180" class="w-full aspect-[4/5] object-cover" alt=""></div>
                    </div>
                    <div class="rounded-xl overflow-hidden aspect-[16/7] relative">
                        <img src="https://picsum.photos/seed/preview-banner/500/220" class="w-full h-full object-cover" alt="">
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                            <span class="text-white text-[11px] font-bold">New Season Collection</span>
                        </div>
                    </div>
                    <div class="bg-ink rounded-xl p-3 text-center">
                        <p class="text-white text-[11px] font-bold">Stay in Style</p>
                        <span class="inline-block mt-1.5 bg-primary text-ink text-[9px] font-semibold px-2.5 py-1 rounded-full">Subscribe</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ADD / EDIT SECTION MODAL -->
    <div id="sectionModalOverlay" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-soft w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <form id="sectionForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.cms.homepage-sections.store') }}">
                @csrf
                <div id="sectionMethodField"></div>

                <div class="flex items-center justify-between px-5 md:px-6 pt-5 md:pt-6">
                    <h2 id="sectionModalTitle" class="font-bold text-base">Add New Section</h2>
                    <button type="button" id="sectionModalCloseBtn" aria-label="Close" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark text-black/50"></i></button>
                </div>

                <div class="px-5 md:px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="modalSectionType">Section Type</label>
                        <div class="relative">
                            <select name="type" id="modalSectionType" required class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                                @foreach ($typeLabels as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="modalTitle">Section Title</label>
                        <input name="title" id="modalTitle" type="text" placeholder="e.g. Hero Slider" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="modalSubtitle">Description</label>
                        <input name="subtitle" id="modalSubtitle" type="text" placeholder="e.g. 3 slides" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>

                    <label class="upload-dropzone block aspect-[21/9] rounded-2xl border border-dashed border-black/15 hover:border-primary grid place-items-center text-center cursor-pointer transition bg-cover bg-center" id="modalImagePreviewWrap">
                        <input type="file" name="image" id="modalImage" class="hidden" accept="image/*">
                        <span id="modalImagePlaceholder">
                            <i class="fa-solid fa-image text-black/30 text-lg block mb-1"></i>
                            <span class="text-black/40 text-[11px] font-medium">Upload section image</span>
                        </span>
                    </label>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="modalButtonText">Button Text</label>
                            <input name="button_text" id="modalButtonText" type="text" placeholder="Shop Now" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="modalButtonLink">Button Link</label>
                            <input name="button_link" id="modalButtonLink" type="text" placeholder="/shop" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        </div>
                    </div>

                    <div id="modalContentWrap" class="hidden">
                        <label class="block text-sm font-medium mb-1.5" for="modalContent">Custom HTML</label>
                        <textarea name="content" id="modalContent" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none"></textarea>
                    </div>

                    <div class="flex items-center justify-between gap-4 py-1">
                        <div>
                            <p class="text-sm font-semibold">Visible on Homepage</p>
                            <p class="text-black/45 text-xs mt-0.5">Toggle off to hide without deleting.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="is_visible" id="modalVisible" value="1" class="peer sr-only" checked>
                            <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                            <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 px-5 md:px-6 pb-5 md:pb-6 pt-2">
                    <button type="button" id="removeSectionBtn" class="hidden text-xs font-semibold text-danger hover:text-danger/70 transition">
                        <i class="fa-solid fa-trash-can mr-1.5"></i> Remove Section
                    </button>
                    <div class="flex items-center gap-2 ml-auto">
                        <button type="button" id="sectionModalCancelBtn" class="border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">Cancel</button>
                        <button type="submit" id="sectionModalSaveBtn" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-5 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">Add Section</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden delete form, action swapped per row -->
    <form id="removeSectionForm" method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>

@endsection

@push('scripts')
<script>
  const sectionList = document.getElementById('sectionList');
  const sectionModalOverlay = document.getElementById('sectionModalOverlay');
  const sectionModalTitle = document.getElementById('sectionModalTitle');
  const sectionForm = document.getElementById('sectionForm');
  const sectionMethodField = document.getElementById('sectionMethodField');
  const modalSectionType = document.getElementById('modalSectionType');
  const modalTitle = document.getElementById('modalTitle');
  const modalSubtitle = document.getElementById('modalSubtitle');
  const modalButtonText = document.getElementById('modalButtonText');
  const modalButtonLink = document.getElementById('modalButtonLink');
  const modalContent = document.getElementById('modalContent');
  const modalContentWrap = document.getElementById('modalContentWrap');
  const modalVisible = document.getElementById('modalVisible');
  const modalImagePreviewWrap = document.getElementById('modalImagePreviewWrap');
  const modalImagePlaceholder = document.getElementById('modalImagePlaceholder');
  const sectionModalSaveBtn = document.getElementById('sectionModalSaveBtn');
  const removeSectionBtn = document.getElementById('removeSectionBtn');
  const removeSectionForm = document.getElementById('removeSectionForm');
  const reorderUrl = "{{ route('admin.cms.homepage-sections.reorder') }}";
  const csrfToken = "{{ csrf_token() }}";

  function toggleContentField() {
    modalContentWrap.classList.toggle('hidden', modalSectionType.value !== 'custom_html');
  }
  modalSectionType.addEventListener('change', toggleContentField);

  function openSectionModal(data) {
    sectionForm.reset();
    modalImagePreviewWrap.style.backgroundImage = '';
    modalImagePlaceholder.classList.remove('hidden');

    if (data) {
      sectionModalTitle.textContent = 'Edit Section';
      sectionModalSaveBtn.textContent = 'Save Changes';
      removeSectionBtn.classList.remove('hidden');
      sectionForm.action = data.action;
      sectionMethodField.innerHTML = '<input type="hidden" name="_method" value="PATCH">';
      modalSectionType.value = data.type;
      modalTitle.value = data.title || '';
      modalSubtitle.value = data.subtitle || '';
      modalButtonText.value = data.buttonText || '';
      modalButtonLink.value = data.buttonLink || '';
      modalContent.value = data.content || '';
      modalVisible.checked = data.visible === '1';
      if (data.image) {
        modalImagePreviewWrap.style.backgroundImage = `url('${data.image}')`;
        modalImagePlaceholder.classList.add('hidden');
      }
      removeSectionForm.action = data.action;
    } else {
      sectionModalTitle.textContent = 'Add New Section';
      sectionModalSaveBtn.textContent = 'Add Section';
      removeSectionBtn.classList.add('hidden');
      sectionForm.action = "{{ route('admin.cms.homepage-sections.store') }}";
      sectionMethodField.innerHTML = '';
      modalVisible.checked = true;
    }
    toggleContentField();

    sectionModalOverlay.classList.remove('hidden');
    sectionModalOverlay.classList.add('flex');
  }

  function closeSectionModal() {
    sectionModalOverlay.classList.add('hidden');
    sectionModalOverlay.classList.remove('flex');
  }

  document.getElementById('addSectionBtn').addEventListener('click', () => openSectionModal(null));
  document.getElementById('sectionModalCloseBtn').addEventListener('click', closeSectionModal);
  document.getElementById('sectionModalCancelBtn').addEventListener('click', closeSectionModal);
  sectionModalOverlay.addEventListener('click', (e) => { if (e.target === sectionModalOverlay) closeSectionModal(); });

  document.querySelectorAll('.edit-section-btn').forEach(btn => {
    btn.addEventListener('click', () => openSectionModal({
      id: btn.dataset.id, type: btn.dataset.type, title: btn.dataset.title, subtitle: btn.dataset.subtitle,
      buttonText: btn.dataset.buttonText, buttonLink: btn.dataset.buttonLink, content: btn.dataset.content,
      visible: btn.dataset.visible, image: btn.dataset.image, action: btn.dataset.action,
    }));
  });

  removeSectionBtn.addEventListener('click', () => {
    if (!confirm('Remove this section?')) return;
    removeSectionForm.action = sectionForm.action;
    removeSectionForm.submit();
  });

  // Move up/down: swap DOM rows, then persist the full new order.
  function persistOrder() {
    const rows = [...sectionList.querySelectorAll('.section-row')];
    rows.forEach((row, i) => {
      row.querySelector('.section-row-position').textContent = i + 1;
    });
    const items = rows.map((row, i) => ({ id: row.dataset.id, sort_order: i + 1 }));

    fetch(reorderUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
      body: JSON.stringify({ items }),
    });
  }

  function bindRowEvents(row) {
    row.querySelector('.move-up-btn')?.addEventListener('click', function () {
      const prev = row.previousElementSibling;
      if (prev) { row.parentNode.insertBefore(row, prev); persistOrder(); }
    });
    row.querySelector('.move-down-btn')?.addEventListener('click', function () {
      const next = row.nextElementSibling;
      if (next) { row.parentNode.insertBefore(next, row); persistOrder(); }
    });
  }
  document.querySelectorAll('.section-row').forEach(bindRowEvents);
</script>
@endpush
