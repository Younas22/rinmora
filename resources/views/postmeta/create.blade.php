@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Add Posts Meta</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Add Posts Meta</li>
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
    <form action="{{ route('postmeta.store') }}" method="POST">
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
        <label for="meta_key">Meta Key</label>
        <input type="text" class="form-control" name="meta_key" id="meta_key" required>
    </div>
    <div class="form-group">
        <label for="meta_value">Meta Value</label>
        <input type="text" class="form-control" name="meta_value" id="meta_value" required>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

  </div>
</div>
</div>

@include('include.footer')

