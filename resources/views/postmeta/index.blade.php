@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Blog Posts Meta</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Blog Posts Meta</li>
        </ul>
      </div>
      <div class="col-auto float-right ml-auto">
        <a href="{{ route('postmeta.create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Posts Meta</a>
      </div>
    </div>
  </div>
  <!-- /Page Header -->
  <div class="row">
    <div class="col-12">
    <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Post ID</th>
            <th>Meta Key</th>
            <th>Meta Value</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($postMetas as $postMeta)
            <tr>
                <td>{{ $postMeta->id }}</td>
                <td>{{ $postMeta->blog_post_id }}</td>
                <td>{{ $postMeta->meta_key }}</td>
                <td>{{ $postMeta->meta_value }}</td>
                <td>
                    <a href="{{ route('postmeta.edit', $postMeta->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('postmeta.destroy', $postMeta->id) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

  </div>
</div>
</div>

@include('include.footer')
