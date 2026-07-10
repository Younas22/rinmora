@extends('admin.catalog.layouts.app')

@section('title', 'Add New Page')

@push('styles')
<style>
  .ck-editor__editable_inline { min-height: 360px; max-height: 600px; }
  .ck.ck-editor { max-width: 100%; }
  .ck.ck-toolbar { border-radius: 0.75rem 0.75rem 0 0 !important; border-color: rgba(0,0,0,0.1) !important; }
  .ck.ck-editor__editable { border-radius: 0 0 0.75rem 0.75rem !important; border-color: rgba(0,0,0,0.1) !important; }
</style>
@endpush

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold">Add New Page</h1>
            <p class="text-black/45 text-sm mt-1">Create a static content page.</p>
        </div>
        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-black/50 hover:text-ink transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Pages
        </a>
    </div>

    <form action="{{ route('admin.pages.store') }}" method="POST" id="pageForm">
        @csrf

        <div class="grid lg:grid-cols-[1fr_340px] gap-6 items-start">
            <div class="bg-white rounded-3xl shadow-card p-5 md:p-6 space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium mb-1.5">Page Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. About Us" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                    @error('name') <p class="text-danger text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium mb-1.5">URL Slug</label>
                    <div class="flex items-center gap-2">
                        <span class="text-black/40 text-sm shrink-0">{{ url('/') }}/</span>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="auto-generated-from-name" class="flex-1 px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <button type="button" onclick="generateSlug()" class="shrink-0 w-9 h-9 rounded-xl border border-black/10 grid place-items-center hover:bg-black/5 transition" title="Regenerate from name">
                            <i class="fa-solid fa-arrows-rotate text-xs"></i>
                        </button>
                    </div>
                    <p class="text-black/40 text-xs mt-1.5">Leave empty to auto-generate from the page name.</p>
                    @error('slug') <p class="text-danger text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium mb-1.5">Page Content</label>
                    <textarea name="content" id="content" required style="display:none">{{ old('content') }}</textarea>
                    @error('content') <p class="text-danger text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-5">
                <div class="bg-white rounded-3xl shadow-card p-5">
                    <h2 class="font-bold text-sm mb-4">Publishing Options</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium mb-1.5">Status</label>
                            <div class="relative">
                                <select name="status" id="status" required class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition pr-10">
                                    <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                                    <option value="published" @selected(old('status') === 'published')>Published</option>
                                    <option value="private" @selected(old('status') === 'private')>Private</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-black/30 text-xs pointer-events-none"></i>
                            </div>
                        </div>

                        <div>
                            <label for="sort_order" class="block text-sm font-medium mb-1.5">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" min="0" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                            <p class="text-black/40 text-xs mt-1.5">Lower numbers appear first in navigation.</p>
                        </div>

                        <div class="flex items-center justify-between gap-4 py-1">
                            <div>
                                <p class="text-sm font-semibold">Set as Homepage</p>
                                <p class="text-black/45 text-xs mt-0.5">Replaces the current homepage.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" name="is_homepage" value="1" class="peer sr-only" @checked(old('is_homepage'))>
                                <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                                <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between gap-4 py-1">
                            <div>
                                <p class="text-sm font-semibold">Show in Menu</p>
                                <p class="text-black/45 text-xs mt-0.5">Include in the navigation menu.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" name="show_in_menu" value="1" class="peer sr-only" @checked(old('show_in_menu', true))>
                                <span class="w-10 h-6 bg-black/10 peer-checked:bg-success rounded-full transition block"></span>
                                <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-4"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-card p-5">
                    <h2 class="font-bold text-sm mb-4">SEO Settings</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium mb-1.5">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" placeholder="SEO optimized title" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label for="meta_description" class="block text-sm font-medium mb-1.5">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3" placeholder="Brief description for search engines" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none">{{ old('meta_description') }}</textarea>
                        </div>
                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium mb-1.5">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2" class="w-full px-4 py-2.5 rounded-xl border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.pages.index') }}" class="flex-1 text-center border border-black/10 rounded-full px-4 py-3 text-xs font-semibold hover:bg-black/5 transition">Cancel</a>
                    <button type="submit" class="flex-1 bg-primary text-ink rounded-full px-4 py-3 text-xs font-semibold hover:bg-primary-dark transition">Create Page</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
let editorInstance;

class MyUploadAdapter {
    constructor(loader) { this.loader = loader; }
    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            this._initRequest();
            this._initListeners(resolve, reject, file);
            this._sendRequest(file);
        }));
    }
    abort() { if (this.xhr) this.xhr.abort(); }
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.pages.upload-image") }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.responseType = 'json';
    }
    _initListeners(resolve, reject, file) {
        const xhr = this.xhr;
        const genericErrorText = `Couldn't upload file: ${file.name}.`;
        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;
            if (!response || xhr.status !== 200) return reject(response?.message || genericErrorText);
            if (!response.url) return reject(response.message || genericErrorText);
            resolve({ default: response.url });
        });
    }
    _sendRequest(file) {
        const data = new FormData();
        data.append('upload', file);
        this.xhr.send(data);
    }
}

function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new MyUploadAdapter(loader);
}

ClassicEditor.create(document.querySelector('#content'), {
    extraPlugins: [MyCustomUploadAdapterPlugin],
    toolbar: {
        items: ['heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'link', 'imageUpload', 'mediaEmbed', '|',
            'bulletedList', 'numberedList', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'codeBlock', '|',
            'undo', 'redo', '|', 'alignment', 'fontColor', 'fontBackgroundColor', '|', 'removeFormat', 'specialCharacters'],
    },
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
        ],
    },
    image: { toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', 'linkImage', 'imageResize'] },
    table: { contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableCellProperties', 'tableProperties'] },
    mediaEmbed: { previewsInData: true },
}).then(editor => {
    editorInstance = editor;
    editor.model.document.on('change:data', () => {
        document.querySelector('#content').value = editor.getData();
    });
}).catch(error => {
    console.error('CKEditor initialization error:', error);
    const contentTextarea = document.querySelector('#content');
    contentTextarea.style.display = 'block';
    contentTextarea.style.minHeight = '360px';
});

function generateSlug() {
    const name = document.getElementById('name').value;
    const slug = name.toLowerCase().replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
    document.getElementById('slug').value = slug;
}

document.getElementById('name').addEventListener('input', function () {
    const slugInput = document.getElementById('slug');
    const metaTitleInput = document.getElementById('meta_title');
    if (!slugInput.value) generateSlug();
    if (!metaTitleInput.value) metaTitleInput.value = this.value;
});

document.getElementById('pageForm').addEventListener('submit', function (e) {
    if (editorInstance) {
        document.querySelector('#content').value = editorInstance.getData();
    }
    const content = document.querySelector('#content').value.trim();
    if (!content || content === '<p>&nbsp;</p>') {
        e.preventDefault();
        alert('Please add some content to your page.');
        editorInstance?.editing.view.focus();
    }
});
</script>
@endpush
