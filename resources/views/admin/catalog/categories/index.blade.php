@extends('admin.catalog.layouts.app')

@section('title', 'Categories')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Categories</h1>
            <p class="text-black/45 text-sm mt-1">Organize your catalog into browsable categories.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Total Categories</p>
            <p class="text-xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Active</p>
            <p class="text-xl font-bold text-success">{{ $stats['active'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Products Categorized</p>
            <p class="text-xl font-bold">{{ $stats['products_categorized'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-card p-5">
            <p class="text-black/45 text-xs mb-1">Empty Categories</p>
            <p class="text-xl font-bold text-warning">{{ $stats['empty'] }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-[320px_1fr] gap-6 items-start">

        <form method="POST" action="{{ $editing ? route('admin.catalog.categories.update', $editing) : route('admin.catalog.categories.store') }}" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-card p-5 lg:sticky lg:top-[88px]">
            @csrf
            @if ($editing) @method('PUT') @endif

            <h2 class="font-bold text-sm mb-1">{{ $editing ? 'Edit Category' : 'Add New Category' }}</h2>
            <p class="text-black/40 text-xs mb-5">{{ $editing ? 'Update this category.' : 'Create a category to group related products.' }}</p>

            <div class="space-y-4">
                <label class="block aspect-[16/9] rounded-2xl border-2 border-dashed border-black/10 grid place-items-center text-center cursor-pointer hover:bg-black/[0.02] transition overflow-hidden">
                    <input type="file" name="image" class="hidden" accept="image/*">
                    @if ($editing?->image_url)
                        <img src="{{ $editing->image_url }}" alt="" class="w-full h-full object-cover">
                    @else
                        <span>
                            <i class="fa-solid fa-image text-black/30 text-lg block mb-1"></i>
                            <span class="text-black/40 text-[11px] font-medium">Upload category image</span>
                        </span>
                    @endif
                </label>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="catName">Category Name</label>
                    <input id="catName" name="name" type="text" value="{{ old('name', $editing?->name) }}" placeholder="e.g. Weekend Totes" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="catSlug">URL Slug</label>
                    <input id="catSlug" name="slug" type="text" value="{{ old('slug', $editing?->slug) }}" placeholder="auto-generated if left blank" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="catParent">Parent Category</label>
                    <div class="relative">
                        <select id="catParent" name="parent_id" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition pr-10">
                            <option value="">None (top level)</option>
                            @foreach ($parents as $parent)
                                @if (!$editing || $parent->id !== $editing->id)
                                    <option value="{{ $parent->id }}" @selected(old('parent_id', $editing?->parent_id) == $parent->id)>{{ $parent->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1.5" for="catDesc">Description</label>
                    <textarea id="catDesc" name="description" rows="3" placeholder="Short description shown on the category page..." class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none">{{ old('description', $editing?->description) }}</textarea>
                </div>

                <div class="flex items-center justify-between gap-4 py-1">
                    <div>
                        <p class="text-sm font-semibold">Active</p>
                        <p class="text-black/45 text-xs mt-0.5">Visible in the storefront.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input type="checkbox" name="status" value="1" class="peer sr-only" @checked(old('status', $editing?->status ?? true))>
                        <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                        <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                    </label>
                </div>

                <div class="pt-1 border-t border-black/5">
                    <p class="text-sm font-semibold mt-3">Reel / Story Media</p>
                    <p class="text-black/45 text-xs mt-0.5 mb-3">Add several photos or short videos for this category's home page reel. The first item is used as its cover.</p>

                    <div id="categoryMediaGrid" class="grid grid-cols-3 gap-2">
                        @if ($editing)
                            @foreach ($editing->media as $item)
                                <div class="relative aspect-square rounded-xl overflow-hidden group bg-black/5">
                                    @if ($item->type === 'video')
                                        <video src="{{ $item->url }}" class="w-full h-full object-cover" muted playsinline></video>
                                        <span class="absolute bottom-1 left-1 w-5 h-5 rounded-full bg-black/60 text-white grid place-items-center text-[9px]"><i class="fa-solid fa-play"></i></span>
                                    @else
                                        <img src="{{ $item->url }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                    @if ($item->is_cover)
                                        <span class="absolute top-1 left-1 bg-ink text-white text-[9px] font-semibold px-1.5 py-0.5 rounded-full">Cover</span>
                                    @else
                                        <form method="POST" action="{{ route('admin.catalog.categories.media.cover', [$editing, $item]) }}" class="absolute top-1 left-1 opacity-0 group-hover:opacity-100 transition">
                                            @csrf
                                            <button type="submit" class="bg-white/90 text-[9px] font-semibold px-1.5 py-0.5 rounded-full">Set Cover</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.catalog.categories.media.destroy', [$editing, $item]) }}" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition" onsubmit="return confirm('Remove this media?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" aria-label="Remove media" class="w-5 h-5 rounded-full bg-black/60 text-white grid place-items-center text-[9px]"><i class="fa-solid fa-xmark"></i></button>
                                    </form>
                                </div>
                            @endforeach
                        @endif
                        <label class="aspect-square rounded-xl border-2 border-dashed border-black/10 grid place-items-center text-center cursor-pointer hover:bg-black/[0.02] transition">
                            <input type="file" name="media[]" id="categoryMediaInput" class="hidden" accept="image/*,video/*" multiple>
                            <span>
                                <i class="fa-solid fa-cloud-arrow-up text-black/30 text-base block mb-1"></i>
                                <span class="text-black/40 text-[10px] font-medium">Upload</span>
                            </span>
                        </label>
                    </div>
                    <p id="newCategoryMediaLabel" class="text-black/35 text-[11px] mt-2 hidden"></p>
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition mt-2">
                    <i class="fa-solid fa-{{ $editing ? 'check' : 'plus' }} text-[10px]"></i> {{ $editing ? 'Update Category' : 'Add Category' }}
                </button>
                @if ($editing)
                    <a href="{{ route('admin.catalog.categories.index') }}" class="block text-center text-xs font-semibold text-black/45 hover:text-ink transition mt-2">Cancel edit</a>
                @endif
            </div>
        </form>

        <div class="bg-white rounded-3xl shadow-card overflow-hidden">
            <form method="GET" class="p-4 md:p-5 border-b border-black/5 flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                    <label for="categorySearch" class="sr-only">Search categories</label>
                    <input id="categorySearch" name="search" type="text" value="{{ request('search') }}" placeholder="Search categories..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
                </div>
                <div class="relative">
                    <select name="status" aria-label="Filter by status" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">All Status</option>
                        <option value="active" @selected(request('status') === 'active')>Active</option>
                        <option value="hidden" @selected(request('status') === 'hidden')>Hidden</option>
                    </select>
                    <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[720px]">
                    <thead>
                        <tr class="text-left text-black/40 text-xs uppercase tracking-wide border-b border-black/5">
                            <th class="py-3 pl-5 font-medium">Category</th>
                            <th class="py-3 font-medium">Slug</th>
                            <th class="py-3 font-medium text-center">Products</th>
                            <th class="py-3 font-medium">Status</th>
                            <th class="py-3 pr-5 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-black/[0.02] transition">
                                <td class="py-3 pl-5">
                                    <div class="flex items-center gap-3">
                                        @if ($category->image_url)
                                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-lg object-cover shrink-0">
                                        @else
                                            <span class="w-10 h-10 rounded-lg bg-black/5 grid place-items-center text-black/25 shrink-0"><i class="fa-solid fa-image text-xs"></i></span>
                                        @endif
                                        <div>
                                            <p class="font-semibold">{{ $category->name }}</p>
                                            @if ($category->parent)
                                                <p class="text-black/40 text-xs">in {{ $category->parent->name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-black/45">/{{ $category->slug }}</td>
                                <td class="py-3 text-center">{{ $category->products_count }}</td>
                                <td class="py-3">
                                    @if ($category->status)
                                        <span class="bg-success/10 text-success text-[11px] font-semibold px-2.5 py-1 rounded-full">Active</span>
                                    @else
                                        <span class="bg-black/5 text-black/50 text-[11px] font-semibold px-2.5 py-1 rounded-full">Hidden</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-5 text-right">
                                    <a href="{{ route('admin.catalog.categories.index', ['edit' => $category->id]) }}" class="text-xs font-semibold text-black/50 hover:text-ink transition mr-3">Edit</a>
                                    <form method="POST" action="{{ route('admin.catalog.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Delete this category?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-danger hover:text-danger/70 transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-black/40 text-sm">No categories yet — add your first one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="p-4 md:p-5 border-t border-black/5">
                    {{ $categories->links('admin.catalog.partials.pagination') }}
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
<script>
  const categoryMediaInput = document.getElementById('categoryMediaInput');
  const newCategoryMediaLabel = document.getElementById('newCategoryMediaLabel');
  categoryMediaInput.addEventListener('change', () => {
    if (categoryMediaInput.files.length) {
      newCategoryMediaLabel.textContent = categoryMediaInput.files.length + ' new file(s) selected — will be uploaded on save.';
      newCategoryMediaLabel.classList.remove('hidden');
    } else {
      newCategoryMediaLabel.classList.add('hidden');
    }
  });
</script>
@endpush
