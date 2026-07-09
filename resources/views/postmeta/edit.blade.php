@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Edit Posts Meta</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Edit Posts Meta</li>
        </ul>
      </div>
      {{-- <div class="col-auto float-right ml-auto">
        <a href="{{ route('postmeta.create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Posts Meta</a>
      </div> --}}
    </div>
  </div>
  <!-- /Page Header -->
  <div class="row">
    <div class="col-12">
      <form action="{{ route('postmeta.update', $postMeta->id) }}" method="POST">
    @csrf
    @method('PUT')
      <div class="form-group">
        <label for="title">Blog Title</label>
        <select class="form-control" name="blog_post_id">
          @foreach ($blogpost as $blog)
          @if ($postMeta->blog_post_id == $blog->id)
            <option value="{{$blog->blog_post_id}}" class="form-control" selected>{{$blog->id.' ) '.$blog->title}}</option>
            @else
            <option value="{{$blog->id}}" class="form-control">{{$blog->id.' ) '.$blog->title}}</option>
          @endif
          @endforeach
        </select>
      </div>
    <div class="form-group">
        <label for="meta_key">Meta Key</label>
        <input type="text" class="form-control" name="meta_key" id="meta_key" value="{{ $postMeta->meta_key }}" required>
    </div>
    <div class="form-group">
        <label for="meta_value">Meta Value</label>
        <input type="text" class="form-control" name="meta_value" id="meta_value" value="{{ $postMeta->meta_value }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<form action="{{ route('postmeta.destroy', $postMeta->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>

  </div>
</div>
</div>

@include('include.footer')
