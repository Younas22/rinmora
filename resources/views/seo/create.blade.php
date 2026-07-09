@include('include.header')
<!-- Page Content -->
<div class="content container-fluid"> 
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Add Posts SEO</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Add Posts SEO</li>
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
      <form action="{{ route('seo.store') }}" method="POST">
        @csrf
      <div class="form-group">
          <label for="title">Blog Title</label>
          <select class="form-control" name="blog_post_id">
            <option>Select Blog Title</option>
            @foreach ($blogpost as $blog)
            <option value="{{$blog->id}}" class="form-control">{{$blog->id.' ) '.$blog->title}}</option>
            @endforeach
          </select>
      </div>
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" class="form-control" name="title" id="title" required>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <input type="text" class="form-control" name="description" id="description" required>
        </div>
        <div class="form-group">
          <label for="keywords">keywords</label>
          <input type="text" class="form-control" name="keywords" id="keywords" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
      </form>
    </div>

  </div>
</div>

@include('include.footer')

