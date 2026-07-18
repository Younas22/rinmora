@php
    $product = $product ?? null;
    $isEdit = (bool) $product;
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.catalog.products.update', $product) : route('admin.catalog.products.store') }}" enctype="multipart/form-data" id="productForm">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    @if ($errors->any())
        <div class="bg-danger/10 text-danger text-sm rounded-2xl px-5 py-4 mb-6">
            <p class="font-semibold mb-1">This product wasn't saved — please fix the following:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">{{ $isEdit ? 'Edit Product' : 'Add New Product' }}</h1>
            <p class="text-black/45 text-sm mt-1">{{ $isEdit ? 'Update this product\'s details.' : 'Fill in the details below to list a new item in your catalog.' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.catalog.products.index') }}" class="inline-flex items-center gap-2 bg-white border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">
                <i class="fa-solid fa-arrow-left text-black/40 text-[10px]"></i> Back
            </a>
            <button type="submit" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-5 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                <i class="fa-solid fa-check text-[10px]"></i> {{ $isEdit ? 'Save Changes' : 'Publish Product' }}
            </button>
        </div>
    </div>

    <div class="grid lg:grid-cols-[1fr_320px] gap-6 items-start">

        <!-- LEFT COLUMN -->
        <div class="min-w-0 space-y-6">

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-1">General Information</h2>
                <p class="text-black/40 text-xs mb-5">The core details customers will see first.</p>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="productName">Product Name</label>
                        <input id="productName" name="name" type="text" value="{{ old('name', $product?->name) }}" placeholder="e.g. Milano Leather Tote" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="productSlug">URL Slug</label>
                        <div class="flex items-center rounded-xl border border-black/10 focus-within:ring-2 focus-within:ring-primary transition overflow-hidden">
                            <span class="pl-4 pr-2 text-black/35 text-sm shrink-0">/shop/</span>
                            <input id="productSlug" name="slug" type="text" value="{{ old('slug', $product?->slug) }}" placeholder="auto-generated if left blank" class="w-full py-2.5 pr-4 bg-white text-sm focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="shortDesc">Short Description</label>
                        <textarea id="shortDesc" name="short_description" rows="2" placeholder="One or two lines shown on listing cards..." class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none">{{ old('short_description', $product?->short_description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="fullDesc">Full Description</label>
                        <textarea id="fullDesc" name="description" rows="6" placeholder="Describe materials, craftsmanship, sizing, and care instructions..." class="w-full px-4 py-3 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none">{{ old('description', $product?->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-1">Product Media</h2>
                <p class="text-black/40 text-xs mb-5">Upload high-quality images. The first image is used as the featured thumbnail.</p>

                <div id="imageGrid" class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 gap-3">
                    @if ($isEdit)
                        @foreach ($product->images as $image)
                            <div class="relative aspect-square rounded-2xl overflow-hidden group">
                                <img src="{{ $image->url }}" alt="" class="w-full h-full object-cover">
                                @if ($image->is_cover)
                                    <span class="absolute top-1.5 left-1.5 bg-ink text-white text-[9px] font-semibold px-2 py-0.5 rounded-full">Cover</span>
                                @else
                                    <button type="button" data-action-url="{{ route('admin.catalog.products.images.cover', [$product, $image]) }}" data-action-method="POST" class="image-action-btn absolute bottom-1.5 left-1.5 opacity-0 group-hover:opacity-100 transition bg-white/90 text-[9px] font-semibold px-2 py-0.5 rounded-full">Set Cover</button>
                                @endif
                                <button type="button" data-action-url="{{ route('admin.catalog.products.images.destroy', [$product, $image]) }}" data-action-method="DELETE" data-action-confirm="Remove this image?" aria-label="Remove image" class="image-action-btn absolute top-1.5 right-1.5 opacity-0 group-hover:opacity-100 transition w-6 h-6 rounded-full bg-black/60 text-white grid place-items-center text-[10px]"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        @endforeach
                    @endif
                    <label class="aspect-square rounded-2xl border-2 border-dashed border-black/10 grid place-items-center text-center cursor-pointer hover:bg-black/[0.02] transition">
                        <input type="file" name="images[]" id="imagesInput" class="hidden" accept="image/*" multiple>
                        <span>
                            <i class="fa-solid fa-cloud-arrow-up text-black/30 text-lg block mb-1"></i>
                            <span class="text-black/40 text-[11px] font-medium">Upload</span>
                        </span>
                    </label>
                </div>
                <p id="newImagesLabel" class="text-black/35 text-[11px] mt-3 hidden"></p>
            </div>

            {{-- Prices are always entered and stored in the base currency (Settings > Currency)
                 regardless of which currency is set active for display, so the prefix below
                 shows the base symbol, not the active one. --}}
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-1">Pricing</h2>
                <p class="text-black/40 text-xs mb-5">Set the retail price and optional compare-at price for discounts.</p>

                <div class="grid sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="priceField">Price</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-black/35 text-sm">{{ \App\Models\Currency::where('is_base', true)->value('symbol') ?? '$' }}</span>
                            <input id="priceField" name="price" type="text" value="{{ old('price', $product?->price) }}" class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="compareAtField">Compare-at Price</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-black/35 text-sm">{{ \App\Models\Currency::where('is_base', true)->value('symbol') ?? '$' }}</span>
                            <input id="compareAtField" name="compare_at_price" type="text" value="{{ old('compare_at_price', $product?->compare_at_price) }}" placeholder="0.00" class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="costField">Cost per Item</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-black/35 text-sm">{{ \App\Models\Currency::where('is_base', true)->value('symbol') ?? '$' }}</span>
                            <input id="costField" name="cost_per_item" type="text" value="{{ old('cost_per_item', $product?->cost_per_item) }}" placeholder="0.00" class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        </div>
                    </div>
                </div>

                <label class="flex items-center justify-between gap-4 py-3 mt-2 border-t border-black/5 cursor-pointer">
                    <div>
                        <p class="text-sm font-semibold">Charge Tax on This Product</p>
                        <p class="text-black/45 text-xs mt-0.5">Applies your store's default tax rate at checkout.</p>
                    </div>
                    <span class="relative inline-flex items-center shrink-0">
                        <input type="checkbox" name="charge_tax" value="1" class="peer sr-only" @checked(old('charge_tax', $product?->charge_tax ?? true))>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </span>
                </label>
            </div>

            <!-- Inventory -->
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-1">Inventory</h2>
                <p class="text-black/40 text-xs mb-5">Track stock levels and identifiers for this product.</p>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="skuField">SKU</label>
                        <input id="skuField" name="sku" type="text" value="{{ old('sku', $product?->sku) }}" placeholder="RIN-MLT-118" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="barcodeField">Barcode (ISBN, UPC, GTIN)</label>
                        <input id="barcodeField" name="barcode" type="text" value="{{ old('barcode', $product?->barcode) }}" placeholder="Optional" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="qtyField">Quantity in Stock</label>
                        <input id="qtyField" name="quantity" type="number" value="{{ old('quantity', $product?->quantity ?? 0) }}" placeholder="0" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="lowStockField">Low Stock Threshold</label>
                        <input id="lowStockField" name="low_stock_threshold" type="number" value="{{ old('low_stock_threshold', $product?->low_stock_threshold ?? 10) }}" placeholder="10" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                </div>

                <label class="flex items-center justify-between gap-4 py-3 mt-2 border-t border-black/5 cursor-pointer">
                    <div>
                        <p class="text-sm font-semibold">Track Quantity</p>
                        <p class="text-black/45 text-xs mt-0.5">Automatically reduce stock count when orders are placed.</p>
                    </div>
                    <span class="relative inline-flex items-center shrink-0">
                        <input type="checkbox" name="track_quantity" value="1" class="peer sr-only" @checked(old('track_quantity', $product?->track_quantity ?? true))>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </span>
                </label>
                <label class="flex items-center justify-between gap-4 py-3 border-t border-black/5 cursor-pointer">
                    <div>
                        <p class="text-sm font-semibold">Allow Backorders</p>
                        <p class="text-black/45 text-xs mt-0.5">Let customers order this product when out of stock.</p>
                    </div>
                    <span class="relative inline-flex items-center shrink-0">
                        <input type="checkbox" name="allow_backorders" value="1" class="peer sr-only" @checked(old('allow_backorders', $product?->allow_backorders))>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </span>
                </label>
            </div>

            <!-- Variants -->
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <div class="flex items-center justify-between gap-4 mb-1">
                    <h2 class="font-bold text-sm">Variants</h2>
                    <button type="button" id="addOptionBtn" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-dark hover:text-ink transition">
                        <i class="fa-solid fa-plus text-[10px]"></i> Add Option
                    </button>
                </div>
                <p class="text-black/40 text-xs mb-5">Add options like size or color to create purchasable variants.</p>

                <div id="optionsContainer" class="space-y-4"></div>

                <div class="mt-5 overflow-x-auto">
                    <table class="w-full text-sm min-w-[560px]">
                        <thead>
                            <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                                <th class="py-2.5 font-medium">Variant</th>
                                <th class="py-2.5 font-medium">SKU</th>
                                <th class="py-2.5 font-medium">Price</th>
                                <th class="py-2.5 font-medium">Stock</th>
                            </tr>
                        </thead>
                        <tbody id="variantsTableBody" class="divide-y divide-black/5">
                            <tr id="noVariantsRow"><td colspan="4" class="py-4 text-center text-black/35 text-xs">Add an option above to generate variants.</td></tr>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="variants_json" id="variantsJson">
            </div>

            <!-- Shipping -->
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-1">Shipping</h2>
                <p class="text-black/40 text-xs mb-5">Used to calculate shipping rates at checkout.</p>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="weightField">Weight (kg)</label>
                        <input id="weightField" name="weight" type="text" value="{{ old('weight', $product?->weight) }}" placeholder="0.8" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="dimsField">Dimensions (cm)</label>
                        <input id="dimsField" name="dimensions" type="text" value="{{ old('dimensions', $product?->dimensions) }}" placeholder="L 40 x W 15 x H 28" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-1">Search Engine Listing</h2>
                <p class="text-black/40 text-xs mb-5">Controls how this product appears in Google search results.</p>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="metaTitle">Meta Title</label>
                        <input id="metaTitle" name="meta_title" type="text" value="{{ old('meta_title', $product?->meta_title) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="metaDesc">Meta Description</label>
                        <textarea id="metaDesc" name="meta_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none">{{ old('meta_description', $product?->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="space-y-6">

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Status</h2>
                <div class="relative">
                    <select name="status" aria-label="Product status" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                        @foreach (['draft' => 'Draft', 'active' => 'Active', 'archived' => 'Archived'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $product?->status ?? 'draft') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                </div>
                <label class="flex items-center justify-between gap-4 py-3 mt-4 border-t border-black/5 cursor-pointer">
                    <p class="text-sm font-semibold">Featured Product</p>
                    <span class="relative inline-flex items-center shrink-0">
                        <input type="checkbox" name="is_featured" value="1" class="peer sr-only" @checked(old('is_featured', $product?->is_featured))>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </span>
                </label>
                <label class="flex items-center justify-between gap-4 py-3 border-t border-black/5 cursor-pointer">
                    <p class="text-sm font-semibold">Visible in Storefront</p>
                    <span class="relative inline-flex items-center shrink-0">
                        <input type="checkbox" name="is_visible" value="1" class="peer sr-only" @checked(old('is_visible', $product?->is_visible ?? true))>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </span>
                </label>
            </div>

            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                <h2 class="font-bold text-sm mb-4">Organize</h2>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="categorySelect">Category</label>
                        <div class="relative">
                            <select id="categorySelect" name="category_id" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                                <option value="">None</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="brandSelect">Brand</label>
                        <div class="relative">
                            <select id="brandSelect" name="brand_id" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                                <option value="">None</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product?->brand_id) == $brand->id)>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="collectionSelect">Collection</label>
                        <div class="relative">
                            <select id="collectionSelect" name="collection_id" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                                <option value="">None</option>
                                @foreach ($collections as $collection)
                                    <option value="{{ $collection->id }}" @selected(old('collection_id', $product?->collection_id) == $collection->id)>{{ $collection->name }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" for="tagsField">Tags</label>
                        <div id="tagChips" class="flex flex-wrap items-center gap-1.5 px-3 py-2 rounded-xl border border-black/10 focus-within:ring-2 focus-within:ring-primary transition">
                            <input id="tagsField" type="text" placeholder="Add tag..." class="flex-1 min-w-[70px] py-1 text-xs bg-transparent focus:outline-none">
                        </div>
                        <input type="hidden" name="tags" id="tagsHidden" value="{{ old('tags', is_array($product?->tags) ? implode(',', $product->tags) : '') }}">
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

@push('scripts')
<script>
  // ---- Tags ----
  const tagChips = document.getElementById('tagChips');
  const tagsInput = document.getElementById('tagsField');
  const tagsHidden = document.getElementById('tagsHidden');

  function syncTagsHidden() {
    const values = [...tagChips.querySelectorAll('[data-tag]')].map(el => el.dataset.tag);
    tagsHidden.value = values.join(',');
  }
  function addTag(value) {
    value = value.trim();
    if (!value) return;
    const chip = document.createElement('span');
    chip.className = 'inline-flex items-center gap-1.5 bg-black/[0.04] rounded-full pl-2.5 pr-1.5 py-1 text-xs font-medium';
    chip.dataset.tag = value;
    chip.innerHTML = `<span>${value}</span> <button type="button" aria-label="Remove tag" class="text-black/30 hover:text-danger"><i class="fa-solid fa-xmark text-[9px]"></i></button>`;
    chip.querySelector('button').addEventListener('click', () => { chip.remove(); syncTagsHidden(); });
    tagChips.insertBefore(chip, tagsInput);
    syncTagsHidden();
  }
  (tagsHidden.value ? tagsHidden.value.split(',') : []).filter(Boolean).forEach(addTag);
  tagsInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ',') { e.preventDefault(); addTag(tagsInput.value); tagsInput.value = ''; }
  });
  tagsInput.addEventListener('blur', () => { if (tagsInput.value.trim()) { addTag(tagsInput.value); tagsInput.value = ''; } });

  // ---- Per-image actions (Set Cover / Remove) ----
  // These can't be real nested <form> elements since they live inside the
  // main #productForm — a <form> can never contain another <form> in HTML;
  // browsers silently close the OUTER form at the inner form's </form> tag,
  // which used to drop every field below the image grid (price, status,
  // variants, ...) from the save request. Submit them as detached forms instead.
  document.querySelectorAll('.image-action-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      const message = btn.dataset.actionConfirm;
      if (message && !confirm(message)) return;

      const form = document.createElement('form');
      form.method = 'POST';
      form.action = btn.dataset.actionUrl;
      form.style.display = 'none';

      const token = document.createElement('input');
      token.type = 'hidden';
      token.name = '_token';
      token.value = document.querySelector('#productForm input[name="_token"]').value;
      form.appendChild(token);

      if (btn.dataset.actionMethod !== 'POST') {
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = btn.dataset.actionMethod;
        form.appendChild(method);
      }

      document.body.appendChild(form);
      form.submit();
    });
  });

  // ---- New image previews ----
  const imagesInput = document.getElementById('imagesInput');
  const newImagesLabel = document.getElementById('newImagesLabel');
  imagesInput.addEventListener('change', () => {
    if (imagesInput.files.length) {
      newImagesLabel.textContent = imagesInput.files.length + ' new image(s) selected — will be uploaded on save.';
      newImagesLabel.classList.remove('hidden');
    } else {
      newImagesLabel.classList.add('hidden');
    }
  });

  // ---- Variant options builder ----
  const optionsContainer = document.getElementById('optionsContainer');
  const addOptionBtn = document.getElementById('addOptionBtn');
  const variantsTableBody = document.getElementById('variantsTableBody');
  const variantsJsonInput = document.getElementById('variantsJson');
  const productSkuField = document.getElementById('skuField');
  const productPriceField = document.getElementById('priceField');

  @php
    $existingVariantsPayload = $isEdit
        ? $product->variants->map(fn ($v) => [
            'option_values' => $v->option_values,
            'sku' => $v->sku,
            'price' => $v->price,
            'quantity' => $v->quantity,
        ])
        : [];
  @endphp
  const existingVariants = @json($existingVariantsPayload);
  let options = []; // [{ name, values: [] }]
  if (existingVariants.length) {
    const optionNames = Object.keys(existingVariants[0].option_values || {});
    options = optionNames.map(name => ({
      name,
      values: [...new Set(existingVariants.map(v => v.option_values[name]))],
    }));
  }
  let variantOverrides = {}; // label -> {sku, price, quantity}
  existingVariants.forEach(v => {
    const label = Object.values(v.option_values).join(' / ');
    variantOverrides[label] = { sku: v.sku || '', price: v.price ?? '', quantity: v.quantity ?? 0 };
  });

  function renderOptions() {
    optionsContainer.innerHTML = '';
    options.forEach((opt, optIndex) => {
      const div = document.createElement('div');
      div.className = 'border border-black/10 rounded-2xl p-4';
      div.innerHTML = `
        <div class="flex items-center justify-between gap-3 mb-3">
          <input type="text" value="${opt.name}" placeholder="Option name (e.g. Color)" class="option-name-input text-sm font-semibold bg-transparent focus:outline-none border-b border-dashed border-black/20 focus:border-primary">
          <button type="button" aria-label="Remove option" class="remove-option-btn text-black/30 hover:text-danger transition"><i class="fa-solid fa-trash-can text-xs"></i></button>
        </div>
        <div class="flex flex-wrap gap-2 value-chip-row"></div>
      `;
      const chipRow = div.querySelector('.value-chip-row');
      opt.values.forEach((val, valIndex) => {
        const chip = document.createElement('span');
        chip.className = 'inline-flex items-center gap-2 bg-black/[0.04] rounded-full pl-3 pr-2 py-1.5 text-xs font-medium';
        chip.innerHTML = `${val} <button type="button" aria-label="Remove value" class="text-black/30 hover:text-danger"><i class="fa-solid fa-xmark text-[10px]"></i></button>`;
        chip.querySelector('button').addEventListener('click', () => { opt.values.splice(valIndex, 1); renderOptions(); });
        chipRow.appendChild(chip);
      });
      const addBtn = document.createElement('button');
      addBtn.type = 'button';
      addBtn.className = 'inline-flex items-center gap-1.5 border border-dashed border-black/20 rounded-full px-3 py-1.5 text-xs font-medium text-black/50 hover:border-primary hover:text-ink transition';
      addBtn.innerHTML = '<i class="fa-solid fa-plus text-[9px]"></i> Add value';
      addBtn.addEventListener('click', () => {
        const val = prompt('Value for "' + (opt.name || 'this option') + '":');
        if (val && val.trim()) { opt.values.push(val.trim()); renderOptions(); }
      });
      chipRow.appendChild(addBtn);

      div.querySelector('.option-name-input').addEventListener('input', (e) => { opt.name = e.target.value; renderVariants(); });
      div.querySelector('.remove-option-btn').addEventListener('click', () => { options.splice(optIndex, 1); renderOptions(); });

      optionsContainer.appendChild(div);
    });
    renderVariants();
  }

  function cartesian(arrays) {
    return arrays.reduce((acc, curr) => acc.flatMap(a => curr.map(c => [...a, c])), [[]]);
  }

  function renderVariants() {
    const activeOptions = options.filter(o => o.name && o.values.length);
    variantsTableBody.innerHTML = '';

    if (!activeOptions.length) {
      variantsTableBody.innerHTML = '<tr id="noVariantsRow"><td colspan="4" class="py-4 text-center text-black/35 text-xs">Add an option above to generate variants.</td></tr>';
      variantsJsonInput.value = '[]';
      return;
    }

    const combos = cartesian(activeOptions.map(o => o.values));
    const variants = combos.map(combo => {
      const optionValues = {};
      activeOptions.forEach((o, i) => optionValues[o.name] = combo[i]);
      const label = combo.join(' / ');
      const override = variantOverrides[label] || {};
      return { label, option_values: optionValues, sku: override.sku || '', price: override.price ?? '', quantity: override.quantity ?? 0 };
    });

    variants.forEach((variant, i) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td class="py-2.5 font-medium">${variant.label}</td>
        <td class="py-2.5"><input type="text" data-field="sku" value="${variant.sku}" placeholder="${(productSkuField.value || 'SKU')}-${i+1}" class="w-32 px-2 py-1 rounded-lg border border-black/10 text-xs focus:outline-none focus:ring-2 focus:ring-primary"></td>
        <td class="py-2.5"><input type="text" data-field="price" value="${variant.price}" placeholder="${productPriceField.value || '0.00'}" class="w-20 px-2 py-1 rounded-lg border border-black/10 text-xs focus:outline-none focus:ring-2 focus:ring-primary"></td>
        <td class="py-2.5"><input type="text" data-field="quantity" value="${variant.quantity}" class="w-16 px-2 py-1 rounded-lg border border-black/10 text-xs focus:outline-none focus:ring-2 focus:ring-primary"></td>
      `;
      ['sku', 'price', 'quantity'].forEach(field => {
        tr.querySelector(`[data-field="${field}"]`).addEventListener('input', (e) => {
          variantOverrides[variant.label] = variantOverrides[variant.label] || {};
          variantOverrides[variant.label][field] = e.target.value;
        });
      });
      variantsTableBody.appendChild(tr);
    });

    updateVariantsJson(variants);
  }

  function updateVariantsJson(variants) {
    const payload = variants.map(v => ({
      option_values: v.option_values,
      sku: variantOverrides[v.label]?.sku ?? v.sku,
      price: variantOverrides[v.label]?.price ?? v.price,
      quantity: variantOverrides[v.label]?.quantity ?? v.quantity,
    }));
    variantsJsonInput.value = JSON.stringify(payload);
  }

  document.getElementById('productForm').addEventListener('submit', () => {
    const activeOptions = options.filter(o => o.name && o.values.length);
    if (activeOptions.length) {
      const combos = cartesian(activeOptions.map(o => o.values));
      const variants = combos.map(combo => {
        const optionValues = {};
        activeOptions.forEach((o, i) => optionValues[o.name] = combo[i]);
        return { label: combo.join(' / '), option_values: optionValues };
      });
      updateVariantsJson(variants);
    }
  });

  addOptionBtn.addEventListener('click', () => { options.push({ name: '', values: [] }); renderOptions(); });

  renderOptions();
</script>
@endpush
