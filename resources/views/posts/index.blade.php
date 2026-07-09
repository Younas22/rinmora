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
        <a href="{{ url('posts/create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Blog</a>
      </div>
    </div>
  </div>
  <!-- /Page Header -->
  <div class="row">
    <div class="col-12">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
          <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td><?=lmt($post->body, 150)?></td>
            <td>{{ $post->status }}</td>
            <td>
              <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
              <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {!! $posts->links() !!}
  </div>
</div>

@include('include.footer')