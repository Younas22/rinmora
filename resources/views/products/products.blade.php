@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
 
        <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Products</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ul>
            </div>
            
            @if (auth()->user()->roll == 'hr')
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_products"><i class="fa fa-plus"></i> Add Products</a>
            </div>
            @else
            <a href="{{ url('employee-dashboard') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back</a>
            @endif

        </div>
    </div>
    <!-- /Page Header -->


@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
@endif

<div class="row">
<div class="col-sm-12">
<div class="file-wrap">
<div class="file-cont-wrap">
<div class="file-cont-inner">
    <div class="file-content">
        <div class="file-body">
            <div class="file-scroll">
                <div class="file-content-inner">
                    <div class="row">
                        @if (count($products) > 0)
                        @foreach($products as $product)
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="card text-center">
                                <img src="{{ $product->image }}" class="card-img-top img-fluid" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->desc }}</p>
                                    {{-- <p class="card-text text-danger">Price: 12</p> --}}
                                    <a href="{{ $product->website }}" class="btn-sm btn-success" target="_blank">Website</a>

                                    @if (auth()->user()->roll == 'hr')
                                    <a class="btn-sm btn-info" href="#" data-toggle="modal" data-target="#edit_product_{{$product->id}}">Edit</a>

                                    <a class="btn-sm btn-danger" target="_blank" href="#" data-toggle="modal" data-target="#delete_product_{{$product->id}}">Delete</a>
                                    @endif

                                </div>
                            </div>
                        </div>





                    <!-- Edit Product Modal -->
                    <div id="edit_product_{{$product->id}}" class="modal custom-modal fade" role="dialog">
                        <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Product</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    
                                    <form action="{{ route('products.update',$product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                        <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="name" value="{{$product->name}}">
                                        </div>
                                        </div>

                                        <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Image<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="image" value="{{$product->image}}">
                                        </div>
                                        </div>

                                        <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Website <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="website" value="{{$product->website}}">
                                        </div>
                                        </div>

                                        <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Desc <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="desc" rows="5" placeholder="Add description">{{$product->desc}}</textarea>
                                        </div>
                                        </div>
                                    </div>


                                        <div class="submit-section">
                                            <button class="btn btn-primary submit-btn">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Edit product Modal -->
                    <!-- Delete product Modal -->
                    <div class="modal custom-modal fade" id="delete_product_{{$product->id}}" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="form-header">
                                        <h3>Delete Product</h3>
                                        <p>Are you sure want to delete?</p>
                                    </div>
                                    <div class="modal-btn delete-action">
                                        <div class="row">
                                            <div class="col-6">
                                                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</button>
                                                </form>
                                            </div>
                                            <div class="col-6">
                                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Delete Department Modal -->


                        @endforeach
                        @else
                        <p class="p-3">Data Not Found!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Page Content -->




                <!-- Add products Modal -->
                <div id="add_products" class="modal custom-modal fade" role="dialog">
                    <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add products</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('products.store') }}" method="POST">
                                @csrf
                                    <div class="row">
                                        <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="name">
                                        </div>
                                        </div>

                                        <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Image<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="image">
                                        </div>
                                        </div>

                                        <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Website <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="website">
                                        </div>
                                        </div>

                                        <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Desc <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="desc" rows="5" placeholder="Add description"></textarea>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Add Department Modal -->


@include('include.footer')