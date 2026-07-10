@extends('admin.catalog.layouts.app')

@section('title', 'Media Manager')

@section('content')

    @php
        $folders = [
            'images' => ['label' => 'Images', 'icon' => 'fa-regular fa-image'],
            'videos' => ['label' => 'Videos', 'icon' => 'fa-regular fa-circle-play'],
            'documents' => ['label' => 'Documents', 'icon' => 'fa-regular fa-file-lines'],
            'products' => ['label' => 'Products', 'icon' => 'fa-solid fa-bag-shopping'],
            'banners' => ['label' => 'Banners', 'icon' => 'fa-regular fa-rectangle-list'],
        ];
        $typeSizes = [
            'image' => ['label' => 'Images', 'dot' => 'bg-primary-dark'],
            'video' => ['label' => 'Videos', 'dot' => 'bg-info'],
            'document' => ['label' => 'Documents', 'dot' => 'bg-black/20'],
        ];
        $storageCapBytes = 10 * 1024 * 1024 * 1024;
        $usedPct = $storageCapBytes > 0 ? min(100, round($stats['total_size'] / $storageCapBytes * 100)) : 0;

        function humanSize($bytes) {
            if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 1) . ' GB';
            if ($bytes >= 1048576) return number_format($bytes / 1048576, 1) . ' MB';
            if ($bytes >= 1024) return number_format($bytes / 1024, 1) . ' KB';
            return $bytes . ' B';
        }
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Media Manager</h1>
            <p class="text-black/45 text-sm mt-1">Organize images, videos, and files used across your store.</p>
        </div>
        <button type="button" id="uploadFilesBtn" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
            <i class="fa-solid fa-cloud-arrow-up text-[10px]"></i> Upload Files
        </button>
    </div>

    <form id="uploadForm" method="POST" action="{{ route('admin.cms.media.store') }}" enctype="multipart/form-data" class="hidden">
        @csrf
        <input type="file" name="files[]" id="fileUploadInput" multiple accept="image/*,video/*,.pdf,.doc,.docx">
        <input type="hidden" name="folder" value="{{ $folder !== 'all' ? $folder : '' }}">
    </form>

    <div class="grid lg:grid-cols-[220px_1fr_300px] gap-5">

        <!-- ============ FOLDERS + STORAGE ============ -->
        <div class="space-y-4">
            <div class="bg-white rounded-3xl shadow-card p-4">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-black/35 px-2 pb-2">Folders</p>
                <nav class="space-y-1 text-sm">
                    <a href="{{ route('admin.cms.media.index') }}" class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ $folder === 'all' ? 'bg-primary/15 text-ink font-semibold' : 'text-black/60 hover:bg-black/5' }}">
                        <span><i class="fa-regular fa-folder-open w-4 mr-2 text-primary-dark"></i>All Media</span><span class="text-xs text-black/40">{{ $stats['total'] }}</span>
                    </a>
                    @foreach ($folders as $key => $f)
                        <a href="{{ route('admin.cms.media.index', ['folder' => $key]) }}" class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ $folder === $key ? 'bg-primary/15 text-ink font-semibold' : 'text-black/60 hover:bg-black/5' }}">
                            <span><i class="{{ $f['icon'] }} w-4 mr-2 text-black/35"></i>{{ $f['label'] }}</span><span class="text-xs text-black/40">{{ $stats['by_folder'][$key] ?? 0 }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="bg-white rounded-3xl shadow-card p-4">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-black/35 px-2 pb-3">Storage</p>
                <div class="px-2">
                    <div class="flex items-baseline justify-between mb-2">
                        <span class="text-sm font-bold">{{ humanSize($stats['total_size']) }}</span>
                        <span class="text-xs text-black/40">of 10 GB</span>
                    </div>
                    <div class="h-2 rounded-full bg-black/5 overflow-hidden mb-3">
                        <div class="h-full rounded-full bg-primary-dark" style="width: {{ $usedPct }}%"></div>
                    </div>
                    <ul class="space-y-1.5 text-xs text-black/55">
                        @foreach ($typeSizes as $key => $t)
                            <li class="flex items-center justify-between"><span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full {{ $t['dot'] }}"></span> {{ $t['label'] }}</span><span>{{ humanSize($stats['by_type_size'][$key] ?? 0) }}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- ============ MEDIA GRID ============ -->
        <div class="bg-white rounded-3xl shadow-card p-4 md:p-5">
            <form method="GET" class="flex flex-wrap items-center gap-3 mb-4">
                <input type="hidden" name="folder" value="{{ $folder }}">
                <div class="relative flex-1 min-w-[180px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-black/30 text-xs"></i>
                    <label for="mediaSearch" class="sr-only">Search media</label>
                    <input id="mediaSearch" name="search" type="text" value="{{ $search }}" placeholder="Search files..." class="w-full pl-10 pr-4 py-2.5 rounded-full bg-black/[0.03] text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition">
                </div>
                <div class="relative">
                    <select name="type" aria-label="Filter by type" onchange="this.form.submit()" class="appearance-none border border-black/10 rounded-full pl-4 pr-8 py-2.5 text-xs font-medium bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">All Types</option>
                        <option value="image" @selected($type === 'image')>Images</option>
                        <option value="video" @selected($type === 'video')>Videos</option>
                        <option value="document" @selected($type === 'document')>Documents</option>
                    </select>
                    <i class="fa-solid fa-chevron-down text-[9px] absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-black/40"></i>
                </div>
            </form>

            <!-- Drag & drop upload zone -->
            <div id="dropzone" class="border-2 border-dashed border-black/10 rounded-2xl p-6 text-center mb-5 hover:border-primary-dark transition cursor-pointer">
                <i class="fa-solid fa-cloud-arrow-up text-2xl text-black/25 mb-2"></i>
                <p class="text-sm font-medium">Drag &amp; drop files here, or <span class="text-primary-dark underline underline-offset-2">browse</span></p>
                <p class="text-black/40 text-xs mt-1">Supports JPG, PNG, MP4, PDF up to 25MB</p>
            </div>

            <!-- Bulk actions -->
            <form id="bulkForm" method="POST" action="{{ route('admin.cms.media.bulk-destroy') }}">
                @csrf @method('POST')
                <div id="bulkActionsBar" class="hidden items-center justify-between gap-3 px-4 py-3 bg-ink text-white text-sm rounded-2xl mb-4">
                    <span><span id="bulkSelectedCount">0</span> selected</span>
                    <div class="flex items-center gap-2">
                        <button type="button" id="bulkMoveBtn" class="text-xs font-semibold px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20 transition">Move</button>
                        <button type="submit" id="bulkDeleteBtn" class="text-xs font-semibold px-3 py-1.5 rounded-full bg-danger hover:bg-danger/85 transition" onclick="return confirm('Delete selected files?');">Delete</button>
                    </div>
                </div>

                <!-- Grid View -->
                <div id="mediaGrid" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3">
                    @forelse ($media as $item)
                        <div class="media-tile rounded-2xl overflow-hidden bg-canvas aspect-square cursor-pointer {{ $item->type !== 'image' && $item->type !== 'video' ? 'flex flex-col items-center justify-center gap-2' : '' }}"
                            data-id="{{ $item->id }}" data-name="{{ $item->original_name }}"
                            data-meta="{{ humanSize($item->size) }} &middot; Uploaded {{ $item->created_at->format('M j, Y') }}"
                            data-img="{{ $item->type === 'image' ? $item->url : '' }}" data-type="{{ $item->type }}"
                            data-folder="{{ $item->folder }}" data-alt="{{ $item->alt_text }}"
                            data-update-action="{{ route('admin.cms.media.update', $item) }}"
                            data-destroy-action="{{ route('admin.cms.media.destroy', $item) }}">
                            @if ($item->type === 'image')
                                <img src="{{ $item->thumb_url }}" alt="{{ $item->alt_text ?: $item->original_name }}" class="w-full h-full object-cover">
                            @elseif ($item->type === 'video')
                                <div class="w-full h-full bg-black/10 relative">
                                    <div class="absolute inset-0 flex items-center justify-center"><i class="fa-solid fa-circle-play text-black/40 text-2xl"></i></div>
                                </div>
                            @else
                                <i class="fa-regular fa-file-lines text-3xl text-info/70"></i>
                                <span class="text-[11px] text-black/50 px-2 text-center truncate w-full">{{ $item->original_name }}</span>
                            @endif
                            <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="media-checkbox absolute top-2 left-2 w-4 h-4 rounded z-10">
                            <div class="tile-overlay absolute inset-0 bg-black/40 flex items-center justify-center gap-2 opacity-0 hover:opacity-100 transition">
                                <button type="button" aria-label="Delete" class="delete-tile-btn w-8 h-8 rounded-full bg-white/90 grid place-items-center"><i class="fa-solid fa-trash-can text-xs text-danger"></i></button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-black/40 text-sm py-10">No files yet — upload something to get started.</div>
                    @endforelse
                </div>
            </form>

            @if ($media->hasPages())
                <div class="pt-5 mt-5 border-t border-black/5">
                    {{ $media->links('admin.catalog.partials.pagination') }}
                </div>
            @endif
        </div>

        <!-- ============ DETAILS PANEL ============ -->
        <div class="bg-white rounded-3xl shadow-card p-5 h-fit lg:sticky lg:top-24">
            <h2 class="font-bold text-sm mb-4">File Details</h2>
            <div id="detailsPreview" class="rounded-2xl overflow-hidden aspect-square bg-canvas mb-4 grid place-items-center">
                <i class="fa-regular fa-image text-4xl text-black/20"></i>
            </div>
            <p id="detailsName" class="text-sm font-semibold truncate mb-1">No file selected</p>
            <p id="detailsMeta" class="text-black/45 text-xs mb-5">Select a file to see its details.</p>

            <form id="detailsForm" method="POST">
                @csrf @method('PATCH')
                <label for="altText" class="block text-xs font-medium text-black/50 mb-2">Alt Text</label>
                <input id="altText" name="alt_text" type="text" placeholder="Describe this image..." class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm mb-3 focus:outline-none focus:ring-2 focus:ring-primary">
                <button type="submit" id="detailsSaveBtn" class="hidden w-full bg-primary text-ink rounded-full py-2.5 text-xs font-semibold hover:bg-primary-dark transition mb-2">Save Alt Text</button>
            </form>

            <div class="grid grid-cols-2 gap-2 mb-2">
                <button type="button" id="detailsCopyUrlBtn" class="inline-flex items-center justify-center gap-2 border border-black/10 rounded-xl py-2.5 text-xs font-semibold hover:bg-black/5 transition"><i class="fa-solid fa-link text-black/40"></i> Copy URL</button>
                <button type="button" id="detailsMoveBtn" class="inline-flex items-center justify-center gap-2 border border-black/10 rounded-xl py-2.5 text-xs font-semibold hover:bg-black/5 transition"><i class="fa-solid fa-folder-tree text-black/40"></i> Move</button>
            </div>
            <form id="detailsDeleteForm" method="POST" onsubmit="return confirm('Delete this file?');">
                @csrf @method('DELETE')
                <button type="submit" id="detailsDeleteBtn" disabled class="w-full inline-flex items-center justify-center gap-2 text-danger text-xs font-semibold py-2.5 hover:bg-danger/5 rounded-xl transition mt-1 disabled:opacity-40 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-trash-can"></i> Delete File
                </button>
            </form>
        </div>

    </div>

    <!-- MOVE TO FOLDER MODAL -->
    <div id="moveModalOverlay" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-soft w-full max-w-xs">
            <div class="flex items-center justify-between px-5 pt-5">
                <h2 class="font-bold text-base">Move to Folder</h2>
                <button type="button" id="moveModalCloseBtn" aria-label="Close" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark text-black/50"></i></button>
            </div>
            <form id="moveForm" method="POST">
                @csrf @method('PATCH')
                <div class="px-5 py-4 space-y-1.5">
                    @foreach ($folders as $key => $f)
                        <button type="submit" name="folder" value="{{ $key }}" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-black/70 hover:bg-black/5 transition"><i class="{{ $f['icon'] }} w-4 text-black/35"></i> {{ $f['label'] }}</button>
                    @endforeach
                </div>
            </form>
            <div class="px-5 pb-5 pt-1">
                <button type="button" id="moveModalCancelBtn" class="w-full border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Bulk move modal (reuses same folder list, posts to bulk-move with selected ids) -->
    <div id="bulkMoveModalOverlay" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-soft w-full max-w-xs">
            <div class="flex items-center justify-between px-5 pt-5">
                <h2 class="font-bold text-base">Move Selected to Folder</h2>
                <button type="button" id="bulkMoveModalCloseBtn" aria-label="Close" class="w-8 h-8 rounded-full grid place-items-center hover:bg-black/5 transition"><i class="fa-solid fa-xmark text-black/50"></i></button>
            </div>
            <form id="bulkMoveForm" method="POST" action="{{ route('admin.cms.media.bulk-move') }}">
                @csrf
                <div id="bulkMoveIdsWrap"></div>
                <div class="px-5 py-4 space-y-1.5">
                    @foreach ($folders as $key => $f)
                        <button type="submit" name="folder" value="{{ $key }}" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-black/70 hover:bg-black/5 transition"><i class="{{ $f['icon'] }} w-4 text-black/35"></i> {{ $f['label'] }}</button>
                    @endforeach
                </div>
            </form>
            <div class="px-5 pb-5 pt-1">
                <button type="button" id="bulkMoveModalCancelBtn" class="w-full border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">Cancel</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
  const uploadFilesBtn = document.getElementById('uploadFilesBtn');
  const fileUploadInput = document.getElementById('fileUploadInput');
  const uploadForm = document.getElementById('uploadForm');
  const dropzone = document.getElementById('dropzone');

  uploadFilesBtn.addEventListener('click', () => fileUploadInput.click());
  dropzone.addEventListener('click', () => fileUploadInput.click());
  fileUploadInput.addEventListener('change', () => { if (fileUploadInput.files.length) uploadForm.submit(); });

  ['dragenter', 'dragover'].forEach(evt => dropzone.addEventListener(evt, (e) => { e.preventDefault(); dropzone.classList.add('border-primary-dark', 'bg-primary/5'); }));
  ['dragleave', 'drop'].forEach(evt => dropzone.addEventListener(evt, (e) => { e.preventDefault(); dropzone.classList.remove('border-primary-dark', 'bg-primary/5'); }));
  dropzone.addEventListener('drop', (e) => {
    if (e.dataTransfer?.files?.length) {
      fileUploadInput.files = e.dataTransfer.files;
      uploadForm.submit();
    }
  });

  const detailsName = document.getElementById('detailsName');
  const detailsMeta = document.getElementById('detailsMeta');
  const detailsPreview = document.getElementById('detailsPreview');
  const altText = document.getElementById('altText');
  const detailsForm = document.getElementById('detailsForm');
  const detailsSaveBtn = document.getElementById('detailsSaveBtn');
  const detailsDeleteForm = document.getElementById('detailsDeleteForm');
  const detailsDeleteBtn = document.getElementById('detailsDeleteBtn');
  const moveForm = document.getElementById('moveForm');
  let selectedTile = null;

  function selectTile(tile) {
    document.querySelectorAll('.media-tile').forEach(t => t.classList.remove('selected', 'outline', 'outline-2', 'outline-primary-dark'));
    tile.classList.add('selected', 'outline', 'outline-2', 'outline-primary-dark');
    selectedTile = tile;

    detailsName.textContent = tile.dataset.name;
    detailsMeta.innerHTML = tile.dataset.meta;
    altText.value = tile.dataset.alt || '';
    detailsForm.action = tile.dataset.updateAction;
    detailsDeleteForm.action = tile.dataset.destroyAction;
    moveForm.action = tile.dataset.updateAction;
    detailsSaveBtn.classList.remove('hidden');
    detailsDeleteBtn.disabled = false;

    detailsPreview.innerHTML = tile.dataset.img
      ? '<img src="' + tile.dataset.img + '" alt="" class="w-full h-full object-cover">'
      : '<div class="w-full h-full grid place-items-center"><i class="fa-regular fa-file text-4xl text-black/20"></i></div>';
  }

  document.querySelectorAll('.media-tile').forEach(tile => {
    tile.addEventListener('click', (e) => {
      if (e.target.closest('.tile-overlay') || e.target.classList.contains('media-checkbox')) return;
      selectTile(tile);
    });
    tile.querySelector('.delete-tile-btn')?.addEventListener('click', (e) => {
      e.stopPropagation();
      if (!confirm('Delete this file?')) return;
      selectTile(tile);
      detailsDeleteForm.submit();
    });
    const cb = tile.querySelector('.media-checkbox');
    cb?.addEventListener('click', e => e.stopPropagation());
    cb?.addEventListener('change', updateBulkBar);
  });

  document.getElementById('detailsCopyUrlBtn').addEventListener('click', () => {
    if (!selectedTile) return;
    navigator.clipboard?.writeText(selectedTile.dataset.img || '');
  });

  const bulkActionsBar = document.getElementById('bulkActionsBar');
  const bulkSelectedCount = document.getElementById('bulkSelectedCount');
  function updateBulkBar() {
    const checked = document.querySelectorAll('.media-checkbox:checked').length;
    bulkSelectedCount.textContent = checked;
    bulkActionsBar.classList.toggle('hidden', checked === 0);
    bulkActionsBar.classList.toggle('flex', checked > 0);
  }

  // Move modal (single)
  const moveModalOverlay = document.getElementById('moveModalOverlay');
  document.getElementById('detailsMoveBtn').addEventListener('click', () => {
    if (!selectedTile) return;
    moveModalOverlay.classList.remove('hidden');
    moveModalOverlay.classList.add('flex');
  });
  document.getElementById('moveModalCloseBtn').addEventListener('click', () => moveModalOverlay.classList.add('hidden', 'flex'));
  document.getElementById('moveModalCancelBtn').addEventListener('click', () => { moveModalOverlay.classList.add('hidden'); moveModalOverlay.classList.remove('flex'); });

  // Bulk move modal
  const bulkMoveModalOverlay = document.getElementById('bulkMoveModalOverlay');
  const bulkMoveIdsWrap = document.getElementById('bulkMoveIdsWrap');
  document.getElementById('bulkMoveBtn').addEventListener('click', () => {
    const ids = Array.from(document.querySelectorAll('.media-checkbox:checked')).map(cb => cb.value);
    bulkMoveIdsWrap.innerHTML = ids.map(id => '<input type="hidden" name="ids[]" value="' + id + '">').join('');
    bulkMoveModalOverlay.classList.remove('hidden');
    bulkMoveModalOverlay.classList.add('flex');
  });
  document.getElementById('bulkMoveModalCloseBtn').addEventListener('click', () => { bulkMoveModalOverlay.classList.add('hidden'); bulkMoveModalOverlay.classList.remove('flex'); });
  document.getElementById('bulkMoveModalCancelBtn').addEventListener('click', () => { bulkMoveModalOverlay.classList.add('hidden'); bulkMoveModalOverlay.classList.remove('flex'); });
</script>
@endpush
