@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Create Blog Posts</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Create Blog Posts</li>
        </ul>
      </div>
      {{-- <div class="col-auto float-right ml-auto">
        <a href="{{ url('posts/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Create Blog</a>
      </div> --}}
    </div>
  </div>
  <!-- /Page Header -->
  <div class="row">
    <div class="col-12">
      <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
      <div class="form-group">
        <label for="title">Categories</label>
        <select class="form-control" name="category_id">
          @foreach ($categories as $cat)
          @if ($post->category_id == $cat->id)
            <option value="{{$post->category_id}}" class="form-control" selected>{{$cat->name}}</option>
            @else
            <option value="{{$cat->id}}" class="form-control">{{$cat->name}}</option>
          @endif
          @endforeach
        </select>
        @error('categories')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') ?? $post->title }}">
          @error('title')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="slug">Slug</label>
          <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') ?? $post->slug }}">
          @error('slug')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="featured_image">Featured image</label>
          <input type="text" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" value="{{ old('featured_image') ?? $post->featured_image }}">
          @error('featured_image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="body">body</label>
          <textarea class="ckeditor form-control @error('body') is-invalid @enderror" id="body" name="body">{{ old('body') ?? $post->body }}</textarea>
          @error('body')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
            <option value="published" {{ old('status') ?? $post->status == 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ old('status') ?? $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
          </select>
          @error('status')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
@include('include.footer')