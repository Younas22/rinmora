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
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="title">Categories</label>
        <select class="form-control" name="category_id">
          <option>Select Categories</option>
          @foreach ($categories as $cat)
          <option value="{{$cat->id}}" class="form-control">{{$cat->name}}</option>
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
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
        @error('title')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
        @error('slug')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>


      <div class="form-group">
        <label for="featured_image">featured image</label>
        <input type="text" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" value="{{ old('featured_image') }}">
        @error('featured_image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label for="body">Body</label>
        <div class="form-group">
            <textarea class="ckeditor form-control" name="body"></textarea>
          </div>
        @error('body')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
          <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
          <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        @error('status')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Create</button>
    </form>
  </div>
</div>
</div>

@include('include.footer')