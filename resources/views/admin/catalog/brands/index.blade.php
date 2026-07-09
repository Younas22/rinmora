@extends('admin.catalog.layouts.app')

@section('title', 'Brands & Collections')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Brands &amp; Collections</h1>
            <p class="text-black/45 text-sm mt-1">Manage the brands you carry and curated product collections.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" id="addBrandBtn" class="section-brands-only inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                <i class="fa-solid fa-plus text-[10px]"></i> Add Brand
            </button>
            <button type="button" id="addCollectionBtn" class="section-collections-only hidden inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                <i class="fa-solid fa-plus text-[10px]"></i> Add Collection
            </button>
        </div>
    </div>

    <div class="inline-flex items-center gap-1 bg-white rounded-full shadow-card p-1.5 mb-6">
        <button type="button" class="section-tab-btn active-section-tab px-5 py-2 rounded-full text-xs font-semibold bg-primary/20 text-ink transition" data-section="brands">
            <i class="fa-solid fa-tag mr-1.5"></i> Brands
        </button>
        <button type="button" class="section-tab-btn px-5 py-2 rounded-full text-xs font-semibold text-black/50 hover:text-ink transition" data-section="collections">
            <i class="fa-solid fa-layer-group mr-1.5"></i> Collections
        </button>
    </div>

    <!-- BRANDS PANEL -->
    <div id="section-brands" class="section-panel">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-6">
            <div class="bg-white rounded-2xl shadow-card p-5">
                <p class="text-black/45 text-xs mb-1">Total Brands</p>
                <p class="text-xl font-bold">{{ $brandStats['total'] }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-card p-5">
                <p class="text-black/45 text-xs mb-1">Active</p>
                <p class="text-xl font-bold text-success">{{ $brandStats['active'] }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-card p-5">
                <p class="text-black/45 text-xs mb-1">Products Assigned</p>
                <p class="text-xl font-bold">{{ $brandStats['products_assigned'] }}</p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($brands as $brand)
                <div class="hover-lift bg-white rounded-3xl shadow-card overflow-hidden">
                    <div class="h-28 bg-black/[0.03] flex items-center justify-center">
                        @if ($brand->logo_url)
                            <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="h-12 object-contain">
                        @else
                            <i class="fa-solid fa-tag text-black/15 text-2xl"></i>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-semibold text-sm">{{ $brand->name }}</p>
                                <p class="text-black/40 text-xs mt-0.5">{{ $brand->products_count }} products</p>
                            </div>
                            @if ($brand->status)
                                <span class="bg-success/10 text-success text-[10px] font-semibold px-2 py-1 rounded-full shrink-0">Active</span>
                            @else
                                <span class="bg-black/5 text-black/45 text-[10px] font-semibold px-2 py-1 rounded-full shrink-0">Hidden</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <button type="button" class="edit-brand-btn flex-1 text-xs font-semibold border border-black/10 rounded-full py-2 hover:bg-black/[0.03] transition"
                                data-id="{{ $brand->id }}" data-name="{{ $brand->name }}" data-slug="{{ $brand->slug }}"
                                data-description="{{ $brand->description }}" data-status="{{ $brand->status ? 1 : 0 }}"
                                data-logo="{{ $brand->logo_url }}"
                                data-action="{{ route('admin.catalog.brands.update', $brand) }}">Edit</button>
                            <form method="POST" action="{{ route('admin.catalog.brands.destroy', $brand) }}" onsubmit="return confirm('Delete this brand?');">
                                @csrf @method('DELETE')
                                <button type="submit" aria-label="Delete brand" class="w-8 h-8 rounded-full border border-black/10 grid place-items-center text-black/40 hover:text-danger hover:border-danger/30 transition"><i class="fa-solid fa-trash-can text-xs"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <label class="hover-lift rounded-3xl border-2 border-dashed border-black/10 grid place-items-center text-center cursor-pointer hover:bg-white transition min-h-[196px]" onclick="openBrandModal()">
                <span>
                    <i class="fa-solid fa-plus text-black/30 text-xl block mb-2"></i>
                    <span class="text-black/45 text-sm font-semibold">Add New Brand</span>
                </span>
            </label>
        </div>
    </div>

    <!-- COLLECTIONS PANEL -->
    <div id="section-collections" class="section-panel hidden">
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-6">
            <div class="bg-white rounded-2xl shadow-card p-5">
                <p class="text-black/45 text-xs mb-1">Total Collections</p>
                <p class="text-xl font-bold">{{ $collectionStats['total'] }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-card p-5">
                <p class="text-black/45 text-xs mb-1">Live</p>
                <p class="text-xl font-bold text-success">{{ $collectionStats['live'] }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-card p-5">
                <p class="text-black/45 text-xs mb-1">Draft</p>
                <p class="text-xl font-bold text-black/50">{{ $collectionStats['draft'] }}</p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($collections as $collection)
                <div class="hover-lift bg-white rounded-3xl shadow-card overflow-hidden">
                    <div class="relative h-36 bg-black/[0.03]">
                        @if ($collection->cover_image_url)
                            <img src="{{ $collection->cover_image_url }}" alt="{{ $collection->name }}" class="w-full h-full object-cover">
                        @endif
                        @if ($collection->status)
                            <span class="absolute top-3 left-3 bg-success text-white text-[10px] font-semibold px-2.5 py-1 rounded-full">Live</span>
                        @else
                            <span class="absolute top-3 left-3 bg-black/60 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full">Draft</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-sm">{{ $collection->name }}</p>
                        <p class="text-black/40 text-xs mt-0.5">{{ $collection->products_count }} products &middot; {{ ucfirst($collection->type) }}</p>
                        <div class="flex items-center gap-2 mt-4">
                            <button type="button" class="edit-collection-btn flex-1 text-xs font-semibold border border-black/10 rounded-full py-2 hover:bg-black/[0.03] transition"
                                data-id="{{ $collection->id }}" data-name="{{ $collection->name }}" data-slug="{{ $collection->slug }}"
                                data-description="{{ $collection->description }}" data-type="{{ $collection->type }}" data-status="{{ $collection->status ? 1 : 0 }}"
                                data-cover="{{ $collection->cover_image_url }}"
                                data-action="{{ route('admin.catalog.collections.update', $collection) }}">Edit</button>
                            <form method="POST" action="{{ route('admin.catalog.collections.destroy', $collection) }}" onsubmit="return confirm('Delete this collection?');">
                                @csrf @method('DELETE')
                                <button type="submit" aria-label="Delete collection" class="w-8 h-8 rounded-full border border-black/10 grid place-items-center text-black/40 hover:text-danger hover:border-danger/30 transition"><i class="fa-solid fa-trash-can text-xs"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <label class="hover-lift rounded-3xl border-2 border-dashed border-black/10 grid place-items-center text-center cursor-pointer hover:bg-white transition min-h-[196px]" onclick="openCollectionModal()">
                <span>
                    <i class="fa-solid fa-plus text-black/30 text-xl block mb-2"></i>
                    <span class="text-black/45 text-sm font-semibold">Add New Collection</span>
                </span>
            </label>
        </div>
    </div>

    <!-- Brand Modal -->
    <div id="brandModal" class="hidden fixed inset-0 z-50 bg-black/40 grid place-items-center p-4">
        <form method="POST" id="brandForm" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-soft w-full max-w-md p-6">
            @csrf
            <div id="brandMethodField"></div>
            <div class="flex items-center justify-between mb-4">
                <h2 id="brandModalTitle" class="font-bold text-base">Add Brand</h2>
                <button type="button" onclick="closeBrandModal()" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Brand Name</label>
                    <input type="text" name="name" id="brandName" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">URL Slug</label>
                    <input type="text" name="slug" id="brandSlug" placeholder="auto-generated if left blank" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Description</label>
                    <textarea name="description" id="brandDescription" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Logo</label>
                    <input type="file" name="logo" accept="image/*" class="w-full text-sm">
                    <img id="brandLogoPreview" src="" alt="" class="hidden mt-2 h-12 object-contain">
                </div>
                <label class="flex items-center gap-2 text-sm font-medium">
                    <input type="checkbox" name="status" id="brandStatus" value="1" checked class="rounded"> Active
                </label>
                <button type="submit" class="w-full bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Save Brand</button>
            </div>
        </form>
    </div>

    <!-- Collection Modal -->
    <div id="collectionModal" class="hidden fixed inset-0 z-50 bg-black/40 grid place-items-center p-4">
        <form method="POST" id="collectionForm" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-soft w-full max-w-md p-6">
            @csrf
            <div id="collectionMethodField"></div>
            <div class="flex items-center justify-between mb-4">
                <h2 id="collectionModalTitle" class="font-bold text-base">Add Collection</h2>
                <button type="button" onclick="closeCollectionModal()" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Collection Name</label>
                    <input type="text" name="name" id="collectionName" required class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">URL Slug</label>
                    <input type="text" name="slug" id="collectionSlug" placeholder="auto-generated if left blank" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Type</label>
                    <select name="type" id="collectionType" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <option value="manual">Manual</option>
                        <option value="automatic">Automatic</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Description</label>
                    <textarea name="description" id="collectionDescription" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*" class="w-full text-sm">
                    <img id="collectionCoverPreview" src="" alt="" class="hidden mt-2 h-16 rounded-lg object-cover">
                </div>
                <label class="flex items-center gap-2 text-sm font-medium">
                    <input type="checkbox" name="status" id="collectionStatus" value="1" checked class="rounded"> Live
                </label>
                <button type="submit" class="w-full bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Save Collection</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.section-tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.section-tab-btn').forEach(b => { b.classList.remove('active-section-tab', 'bg-primary/20', 'text-ink'); b.classList.add('text-black/50'); });
      btn.classList.add('active-section-tab', 'bg-primary/20', 'text-ink');
      btn.classList.remove('text-black/50');

      const section = btn.dataset.section;
      document.querySelectorAll('.section-panel').forEach(p => p.classList.add('hidden'));
      document.getElementById('section-' + section).classList.remove('hidden');

      document.querySelectorAll('.section-brands-only').forEach(el => el.classList.toggle('hidden', section !== 'brands'));
      document.querySelectorAll('.section-collections-only').forEach(el => el.classList.toggle('hidden', section !== 'collections'));
    });
  });
  document.getElementById('addBrandBtn').addEventListener('click', () => openBrandModal());
  document.getElementById('addCollectionBtn').addEventListener('click', () => openCollectionModal());

  function openBrandModal(data = null) {
    const form = document.getElementById('brandForm');
    form.action = data ? data.action : "{{ route('admin.catalog.brands.store') }}";
    document.getElementById('brandMethodField').innerHTML = data ? '<input type="hidden" name="_method" value="PUT">' : '';
    document.getElementById('brandModalTitle').textContent = data ? 'Edit Brand' : 'Add Brand';
    document.getElementById('brandName').value = data?.name || '';
    document.getElementById('brandSlug').value = data?.slug || '';
    document.getElementById('brandDescription').value = data?.description || '';
    document.getElementById('brandStatus').checked = data ? data.status === '1' : true;
    const preview = document.getElementById('brandLogoPreview');
    if (data?.logo) { preview.src = data.logo; preview.classList.remove('hidden'); } else { preview.classList.add('hidden'); }
    document.getElementById('brandModal').classList.remove('hidden');
  }
  function closeBrandModal() { document.getElementById('brandModal').classList.add('hidden'); }
  document.querySelectorAll('.edit-brand-btn').forEach(btn => btn.addEventListener('click', () => openBrandModal(btn.dataset)));

  function openCollectionModal(data = null) {
    const form = document.getElementById('collectionForm');
    form.action = data ? data.action : "{{ route('admin.catalog.collections.store') }}";
    document.getElementById('collectionMethodField').innerHTML = data ? '<input type="hidden" name="_method" value="PUT">' : '';
    document.getElementById('collectionModalTitle').textContent = data ? 'Edit Collection' : 'Add Collection';
    document.getElementById('collectionName').value = data?.name || '';
    document.getElementById('collectionSlug').value = data?.slug || '';
    document.getElementById('collectionDescription').value = data?.description || '';
    document.getElementById('collectionType').value = data?.type || 'manual';
    document.getElementById('collectionStatus').checked = data ? data.status === '1' : true;
    const preview = document.getElementById('collectionCoverPreview');
    if (data?.cover) { preview.src = data.cover; preview.classList.remove('hidden'); } else { preview.classList.add('hidden'); }
    document.getElementById('collectionModal').classList.remove('hidden');
  }
  function closeCollectionModal() { document.getElementById('collectionModal').classList.add('hidden'); }
  document.querySelectorAll('.edit-collection-btn').forEach(btn => btn.addEventListener('click', () => openCollectionModal(btn.dataset)));
</script>
@endpush
