@include('include.header')
<!-- Page Content -->
<div class="content container-fluid"> 
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Edit Posts SEO</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Edit Posts SEO</li>
        </ul>
      </div>
      {{-- <div class="col-auto float-right ml-auto">
        <a href="{{ route('seo.create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Posts SEO</a>
      </div> --}}
    </div>
  </div>
  <!-- /Page Header -->
  <div class="row">
    <div class="col-12">
      <form action="{{ route('seo.update', $seos->id) }}" method="POST">
    @csrf
    @method('PUT')
      <div class="form-group">
        <label for="title">Blog Title</label>
        <select class="form-control" name="blog_post_id">
          @foreach ($blogpost as $blog)
          @if ($seos->blog_post_id == $blog->id)
            <option value="{{$blog->blog_post_id}}" class="form-control" selected>{{$blog->id.' ) '.$blog->title}}</option>
            @else
            <option value="{{$blog->id}}" class="form-control">{{$blog->id.' ) '.$blog->title}}</option>
          @endif
          @endforeach
        </select>
      </div>
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" id="title" value="{{ $seos->title }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" name="description" id="description" value="{{ $seos->description }}" required>
    </div>

    <div class="form-group">
        <label for="keywords">keywords</label>
        <input type="text" class="form-control" name="keywords" id="keywords" value="{{ $seos->keywords }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<form action="{{ route('seo.destroy', $seos->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>

  </div>
</div>
</div>
@include('include.footer')

