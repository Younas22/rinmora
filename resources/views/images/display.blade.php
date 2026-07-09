@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Uploaded Images</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Uploaded Images</li>
                </ul>
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_images"><i class="fa fa-plus"></i> Add Images</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        @foreach($images as $image)
        <div class="col-md-3">
            <div class="card">
                <img src="{{ url('storage/app/'.$image->path) }}" class="card-img-top img-fluid" alt="Image 1">
                <div class="card-body">
                    <a href="{{ route('images.destroy', $image->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    <button class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Copy Image Path" onclick="copyToClipboard('{{ url('storage/app/'.$image->path) }}')">
                    <i class="fa fa-copy"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{$images->links()}}
</div>




<!-- Add Images Modal -->
<div id="add_images" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Images</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('images.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Add Images <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="images[]" multiple>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Add Images</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Images Modal -->

@include('include.footer')
<script>
function copyToClipboard(link) {
navigator.clipboard.writeText(link);
}
</script>