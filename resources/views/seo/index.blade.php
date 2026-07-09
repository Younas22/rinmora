@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
  
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="page-title">Posts SEO</h3>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Posts SEO</li>
        </ul>
      </div>
      <div class="col-auto float-right ml-auto">
        <a href="{{ route('seo.create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add Posts SEO</a>
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
            <th>Title</th>
            <th>Description</th>
            <th>Keywords</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($seos as $seo)
            <tr>
                <td>{{ $seo->id }}</td>
                <td>{{ $seo->blog_post_id }}</td>
                <td>{{ $seo->title }}</td>
                <td>{{ $seo->description }}</td>
                <td>{{ $seo->keywords }}</td>
                <td>
                    <a href="{{ route('seo.edit', $seo->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('seo.destroy', $seo->id) }}" method="POST" style="display: inline-block">
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

