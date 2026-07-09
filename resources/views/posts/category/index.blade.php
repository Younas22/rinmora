@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Category Posts</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Category Posts</li>
        </ul>
      </div>
      <div class="col-auto float-right ml-auto">
        <a href="{{ url('blog/category/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Category</a>
      </div>
    </div>
  </div>
  <!-- /Page Header -->
  <div class="row">
    <div class="col-12">
      <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>
                <a href="{{ route('blog.category.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('blog.category.delete', $category->id) }}" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

    </div>
  </div>
</div>

@include('include.footer')