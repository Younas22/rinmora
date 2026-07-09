@include('include.header')

<!-- Page Content -->
<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Products detials</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Products detials</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_product_details"><i class="fa fa-plus"></i> Add Products detials</a>
        </div>
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
<div class="col-md-12">
    <div>
        <table class="table table-striped custom-table mb-0 datatable table-responsive_">
            <thead>
                <tr>
                    <th style="width: 30px;">#</th>
                    <th>Cat</th>
                    <th>Name</th>
                    <th>price</th>
                    <th>img-1</th>
                    <th>img-2</th>
                    <th>type</th>
                    <th>source</th>
                    <th>desc</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products_detials as $products_detial)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{$products_detial->product_cat}}</td>
                    <td>{{$products_detial->name}}</td>
                    <td>{{$products_detial->price}}</td>

                    <td>
                        <img src="{{$products_detial->image}}" class="img-fluid" width="30" height="30">
                    </td>
                    <td>
                        <img src="{{$products_detial->image_2}}" class="img-fluid" width="30" height="30">
                    </td>

                    <td>{{$products_detial->product_type}}</td>
                    <td><a href="{{$products_detial->source}}" class="btn-sm bg-danger text-white" target="_blank"><i class="fa fa-pencil"></i></a></td>

                    <td><a href="#" class="btn-sm bg-info text-white" data-toggle="modal" data-target="#see_details"><i class="fa fa-eye"></i></a></td>

                    <td class="text-right">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_product_details_{{$products_detial->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_product_details_{{$products_detial->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>




            <!-- see_details Modal -->
            <div id="see_details" class="modal custom-modal fade" role="dialog">
                <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><?=$products_detial->desc?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add Department Modal -->





                <!-- Edit Department Modal -->
                <div id="edit_product_details_{{$products_detial->id}}" class="modal custom-modal fade" role="dialog">
                    <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Department</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                
                                <form action="{{ route('product-details.update',$products_detial->id) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                
                                <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Product Cat</label>
                                        <select class="form-control" name="product_id">
                                            @foreach ($products as $cat)
                                            @if ($products_detial->product_id == $cat->id)
                                            <option value="{{$products_detial->product_id}}" class="form-control" selected>{{$cat->name}}</option>
                                            @else
                                            <option value="{{$cat->id}}" class="form-control">{{$cat->name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>

                                    <div class="col-4">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" value="{{$products_detial->name}}" required>
                                    </div>
                                    </div>

                                    <div class="col-4">
                                    <div class="form-group">
                                        <label>Price <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="price" value="{{$products_detial->price}}" required>
                                    </div>
                                    </div>

                                    <div class="col-4">
                                    <div class="form-group">
                                        <label>Image One<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="image" value="{{$products_detial->image}}" required>
                                    </div>
                                    </div>

                                    <div class="col-4">
                                    <div class="form-group">
                                        <label>Image Two <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="image_2" value="{{$products_detial->image_2}}" required>
                                    </div>
                                    </div>

                                <div class="col-4">
                                <div class="form-group">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select class="select" name="product_type" required>
                                        <?php
                                        $types = [
                                            'pdf', 'notion','sourcecode'
                                        ]
                                        ?>

                                        @foreach ($types as $type => $val)
                                        @if ($val == $products_detial->product_type)
                                            <option value="{{$products_detial->product_type}}" selected>{{$products_detial->product_type}}</option>

                                        @else
                                        <option value="{{$val}}">{{$val}}</option>
                                        @endif


                                        @endforeach
                                        </select>
                                </div>
                                </div>

                                    <div class="col-6">
                                    <div class="form-group">
                                        <label>Source <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="source">
                                        <input type="hidden" name="oldsource" value="{{$products_detial->source}}">
                                    </div>
                                    </div>

                                    <div class="col-6">
                                    <div class="form-group">
                                        <label>Link <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="link" value="{{$products_detial->source}}">
                                    </div>
                                    </div>

                                    <div class="col-12">
                                    <div class="form-group">
                                        <label>Desc <span class="text-danger">*</span></label>
                                        <textarea name="desc" class="ckeditor form-control" placeholder="add desc">{{$products_detial->desc}}</textarea>
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
                <!-- /Edit Product Details Modal -->

                <!-- Delete Product Details Modal -->
                <div class="modal custom-modal fade" id="delete_product_details_{{$products_detial->id}}" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>Delete Product Details</h3>
                                    <p>Are you sure want to delete?</p>
                                </div>
                                <div class="modal-btn delete-action">
                                    <div class="row">
                                        <div class="col-6">
                                            <form action="{{ route('product-details.destroy',$products_detial->id) }}"      method="POST">
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
                <!-- /Delete Products detial Modal -->
                @endforeach
            </tbody>
            
        </table>
        
    </div>
    {!! $products_detials->links() !!}
</div>
</div>
</div>
<!-- /Page Content -->
            
            <!-- add_product_details Modal -->
            <div id="add_product_details" class="modal custom-modal fade" role="dialog">
                <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Product details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('product-details.store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                            @csrf
                                
                                <div class="row">
                                    <div class="col-4">
                                    <div class="form-group">
                                            <label class="col-form-label">Product Cat</label>

                                    <select class="form-control" name="product_id">
                                      <option>Select Product Cat</option>
                                      @foreach ($products as $cat)
                                      <option value="{{$cat->id}}" class="form-control">{{$cat->name}}</option>
                                      @endforeach
                                    </select>

                                        </div>
                                    </div>

                                    <div class="col-4">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" required>
                                    </div>
                                    </div>

                                    <div class="col-4">
                                    <div class="form-group">
                                        <label>Price <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="price" required>
                                    </div>
                                    </div>

                                    <div class="col-4">
                                    <div class="form-group">
                                        <label>Image One<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="image" required>
                                    </div>
                                    </div>

                                    <div class="col-4">
                                    <div class="form-group">
                                        <label>Image Two <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="image_2" required>
                                    </div>
                                    </div>

                                <div class="col-4">
                                <div class="form-group">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select class="select" name="product_type" required>
                                            <option value="pdf">PDF</option>
                                            <option value="notion">Notion Note</option>
                                            <option value="sourcecode">Source Code</option>
                                        </select>
                                </div>
                                </div>

                                    <div class="col-6">
                                    <div class="form-group">
                                        <label>Source <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="source">
                                    </div>
                                    </div>

                                    <div class="col-6">
                                    <div class="form-group">
                                        <label>Link <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="link">
                                    </div>
                                    </div>

                                    <div class="col-12">
                                    <div class="form-group">
                                        <label>Desc <span class="text-danger">*</span></label>
                                        <textarea name="desc" class="ckeditor form-control" placeholder="add desc"></textarea>
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