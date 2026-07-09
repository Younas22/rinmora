{{-- resources/views/admin/pages/edit.blade.php --}}

@extends('admin.layouts.app')

@section('title', 'Edit Page')

@section('styles')
<!-- CKEditor 5 Styles -->
<style>
.ck-editor__editable_inline {
    min-height: 400px;
}
.ck.ck-editor {
    max-width: 100%;
}
.ck-content {
    font-size: 16px;
    line-height: 1.6;
}
.form-group {
    margin-bottom: 1.5rem;
}
.card {
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    border: none;
    border-radius: 10px;
}
.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px 10px 0 0 !important;
}
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 10px 25px;
    border-radius: 25px;
}
.btn-secondary {
    padding: 10px 25px;
    border-radius: 25px;
}
.btn-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border: none;
    color: white;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-edit me-2"></i>Edit Page: {{ Str::limit($page->name, 30) }}
                    </h3>
                    <div class="d-flex gap-2">
                        @if($page->status === 'published')
                            <a href="{{ $page->url }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-external-link-alt me-1"></i> View Live
                            </a>
                        @endif
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Pages
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.update', $page) }}" method="POST" id="pageEditForm">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Page Name -->
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-heading me-1"></i>Page Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $page->name) }}" required placeholder="Enter page name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <span id="nameCounter">0</span>/255 characters
                                        </small>
                                    </div>
                                </div>

                                <!-- URL Slug -->
                                <div class="form-group">
                                    <label for="slug" class="form-label">
                                        <i class="fas fa-link me-1"></i>URL Slug <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ url('/') }}/</span>
                                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" 
                                               value="{{ old('slug', $page->slug) }}" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        <small class="text-muted">URL-friendly version of the page name</small>
                                    </div>
                                    @error('slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Content Editor -->
                                <div class="form-group">
                                    <label for="content" class="form-label">
                                        <i class="fas fa-edit me-1"></i>Page Content <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" 
                                              required style="display: none;">{{ old('content', $page->content) }}</textarea>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Use the rich text editor to format your content. You can upload images, add links, and more.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Publishing Options -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-cog me-1"></i>Publishing Options
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                                <option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>
                                                    📝 Draft
                                                </option>
                                                <option value="published" {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>
                                                    🚀 Published
                                                </option>
                                                <option value="private" {{ old('status', $page->status) == 'private' ? 'selected' : '' }}>
                                                    🔒 Private
                                                </option>
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="sort_order" class="form-label">Sort Order</label>
                                            <input type="number" name="sort_order" id="sort_order" 
                                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                                   value="{{ old('sort_order', $page->sort_order) }}" min="0">
                                            <div class="form-text">
                                                <small class="text-muted">Lower numbers appear first in navigation</small>
                                            </div>
                                            @error('sort_order')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" name="is_homepage" id="is_homepage" 
                                                       class="form-check-input" value="1" {{ old('is_homepage', $page->is_homepage) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_homepage">
                                                    🏠 Set as Homepage
                                                </label>
                                            </div>
                                            <div class="form-text">
                                                <small class="text-muted">
                                                    @if($page->is_homepage)
                                                        This page is currently the homepage
                                                    @else
                                                        This will replace the current homepage
                                                    @endif
                                                </small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="checkbox" name="show_in_menu" id="show_in_menu" 
                                                       class="form-check-input" value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="show_in_menu">
                                                    🔗 Show in Navigation Menu
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Page Stats -->
                                        <div class="mt-3 pt-3" style="border-top: 1px solid #dee2e6;">
                                            <small class="text-muted">
                                                <div><strong>Created:</strong> {{ $page->created_at->format('M j, Y g:i A') }}</div>
                                                <div><strong>Updated:</strong> {{ $page->updated_at->format('M j, Y g:i A') }}</div>
                                                @if($page->published_at)
                                                    <div><strong>Published:</strong> {{ $page->published_at->format('M j, Y g:i A') }}</div>
                                                @endif
                                                <div><strong>Word Count:</strong> {{ $page->word_count }}</div>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Settings -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-search me-1"></i>SEO Settings
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" name="meta_title" id="meta_title" 
                                                   class="form-control @error('meta_title') is-invalid @enderror" 
                                                   value="{{ old('meta_title', $page->meta_title) }}" placeholder="SEO optimized title">
                                            <div class="form-text">
                                                <small class="text-muted">
                                                    <span id="metaTitleCounter">0</span>/255 characters
                                                </small>
                                            </div>
                                            @error('meta_title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea name="meta_description" id="meta_description" 
                                                      class="form-control @error('meta_description') is-invalid @enderror" 
                                                      rows="3" placeholder="Brief description for search engines">{{ old('meta_description', $page->meta_description) }}</textarea>
                                            <div class="form-text">
                                                <small class="text-muted">
                                                    <span id="metaDescCounter">0</span>/500 characters
                                                </small>
                                            </div>
                                            @error('meta_description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                            <input type="text" name="meta_keywords" id="meta_keywords" 
                                                   class="form-control @error('meta_keywords') is-invalid @enderror" 
                                                   value="{{ old('meta_keywords', $page->meta_keywords) }}" placeholder="keyword1, keyword2, keyword3">
                                            <div class="form-text">
                                                <small class="text-muted">Separate keywords with commas</small>
                                            </div>
                                            @error('meta_keywords')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top: 1px solid #dee2e6;">
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                                            <i class="fas fa-save me-1"></i> Save as Draft
                                        </button>
                                        @if($page->status !== 'published')
                                            <button type="button" class="btn btn-outline-info" onclick="previewPage()">
                                                <i class="fas fa-eye me-1"></i> Preview
                                            </button>
                                        @endif
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-secondary me-2" onclick="window.location='{{ route('admin.pages.index') }}'">
                                            <i class="fas fa-times me-1"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Update Page
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
let editorInstance;

// Custom Upload Adapter (same as create form)
class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file
            .then(file => new Promise((resolve, reject) => {
                this._initRequest();
                this._initListeners(resolve, reject, file);
                this._sendRequest(file);
            }));
    }

    abort() {
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.pages.upload-image") }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.responseType = 'json';
    }

    _initListeners(resolve, reject, file) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${file.name}.`;

        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;

            if (!response || xhr.status !== 200) {
                return reject(response && response.message ? response.message : genericErrorText);
            }

            if (!response.url) {
                return reject(response.message || genericErrorText);
            }

            resolve({
                default: response.url
            });
        });

        if (xhr.upload) {
            xhr.upload.addEventListener('progress', evt => {
                if (evt.lengthComputable) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            });
        }
    }

    _sendRequest(file) {
        const data = new FormData();
        data.append('upload', file);
        this.xhr.send(data);
    }
}

// Plugin to register the upload adapter
function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    };
}

// Initialize CKEditor 5
ClassicEditor
    .create(document.querySelector('#content'), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'link', 'imageUpload', 'mediaEmbed', '|',
                'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                'blockQuote', 'insertTable', 'codeBlock', '|',
                'undo', 'redo', '|',
                'alignment', 'fontColor', 'fontBackgroundColor', '|',
                'removeFormat', 'specialCharacters'
            ]
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
            ]
        },
        image: {
            toolbar: [
                'imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side',
                'linkImage', 'imageResize'
            ]
        },
        table: {
            contentToolbar: [
                'tableColumn', 'tableRow', 'mergeTableCells',
                'tableCellProperties', 'tableProperties'
            ]
        },
        link: {
            decorators: {
                openInNewTab: {
                    mode: 'manual',
                    label: 'Open in a new tab',
                    attributes: {
                        target: '_blank',
                        rel: 'noopener noreferrer'
                    }
                }
            }
        },
        mediaEmbed: {
            previewsInData: true
        }
    })
    .then(editor => {
        editor.ui.view.editable.element.style.minHeight = '400px';
        editor.ui.view.editable.element.style.maxHeight = '600px';
        
        editorInstance = editor;
        
        // Update content on change
        editor.model.document.on('change:data', () => {
            document.querySelector('#content').value = editor.getData();
        });

        // Set initial content
        const initialContent = document.querySelector('#content').value;
        if (initialContent) {
            editor.setData(initialContent);
        }

        console.log('✅ CKEditor 5 initialized successfully for page edit!');
    })
    .catch(error => {
        console.error('❌ CKEditor initialization error:', error);
        
        // Fallback to simple textarea
        const contentTextarea = document.querySelector('#content');
        contentTextarea.style.display = 'block';
        contentTextarea.style.minHeight = '400px';
        alert('Rich text editor failed to load. Using simple text editor instead.');
    });

// Character counters
function setupCharacterCounters() {
    // Name counter
    const nameInput = document.getElementById('name');
    const nameCounter = document.getElementById('nameCounter');
    if (nameInput && nameCounter) {
        nameInput.addEventListener('input', function() {
            nameCounter.textContent = this.value.length;
            if (this.value.length > 255) {
                nameCounter.style.color = 'red';
            } else {
                nameCounter.style.color = '';
            }
        });
    }

    // Meta Title counter
    const metaTitleInput = document.getElementById('meta_title');
    const metaTitleCounter = document.getElementById('metaTitleCounter');
    if (metaTitleInput && metaTitleCounter) {
        metaTitleInput.addEventListener('input', function() {
            metaTitleCounter.textContent = this.value.length;
            if (this.value.length > 255) {
                metaTitleCounter.style.color = 'red';
            } else {
                metaTitleCounter.style.color = '';
            }
        });
    }

    // Meta Description counter
    const metaDescInput = document.getElementById('meta_description');
    const metaDescCounter = document.getElementById('metaDescCounter');
    if (metaDescInput && metaDescCounter) {
        metaDescInput.addEventListener('input', function() {
            metaDescCounter.textContent = this.value.length;
            if (this.value.length > 500) {
                metaDescCounter.style.color = 'red';
            } else {
                metaDescCounter.style.color = '';
            }
        });
    }
}

// Slug generation
function generateSlug() {
    const name = document.getElementById('name').value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '');
    
    document.getElementById('slug').value = slug;
}

// Save as draft
function saveDraft() {
    const statusSelect = document.getElementById('status');
    statusSelect.value = 'draft';
    
    // Update editor content before saving
    if (editorInstance) {
        document.querySelector('#content').value = editorInstance.getData();
    }
    
    document.getElementById('pageEditForm').submit();
}

// Preview page (placeholder)
function previewPage() {
    alert('Preview functionality can be implemented based on your requirements');
}

// Form submission handler
const pageForm = document.getElementById('pageEditForm');
if (pageForm) {
    pageForm.addEventListener('submit', function(e) {
        // Update textarea with editor content before submit
        if (editorInstance) {
            const editorData = editorInstance.getData();
            document.querySelector('#content').value = editorData;
        }
        
        // Validate required fields
        const name = document.getElementById('name').value.trim();
        const content = document.querySelector('#content').value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('Please enter a page name.');
            document.getElementById('name').focus();
            return;
        }
        
        if (!content || content === '<p>&nbsp;</p>' || content === '') {
            e.preventDefault();
            alert('Please add some content to your page.');
            if (editorInstance) {
                editorInstance.editing.view.focus();
            }
            return;
        }

        // Show loading state
        const submitButton = this.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Updating...';
            submitButton.disabled = true;
        }
    });
}

// Initialize everything when page loads
document.addEventListener('DOMContentLoaded', function() {
    setupCharacterCounters();
    
    // Initialize counters with existing values
    const elements = [
        { input: 'name', counter: 'nameCounter' },
        { input: 'meta_title', counter: 'metaTitleCounter' },
        { input: 'meta_description', counter: 'metaDescCounter' }
    ];
    
    elements.forEach(element => {
        const inputEl = document.getElementById(element.input);
        const counterEl = document.getElementById(element.counter);
        
        if (inputEl && counterEl) {
            counterEl.textContent = inputEl.value.length;
        }
    });
    
    console.log('🚀 Page edit form initialized successfully!');
});
</script>
@endpush