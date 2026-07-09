@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Blog Posts</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Blog Posts</li>
        </ul>
      </div>
      <div class="col-auto float-right ml-auto">
        <a href="{{ url('blog/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Blog</a>
      </div>
    </div>
  </div>
  <!-- /Page Header -->
  <div class="row">
    <div class="col-12">
<form method="post" action="{{ route('blog.category.store') }}">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>


    </div>
  </div>
</div>

@include('include.footer')