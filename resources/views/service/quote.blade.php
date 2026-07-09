@include('include.header')
<style type="text/css">
.nopad {
padding-left: 0 !important;
padding-right: 0 !important;
}
/*image gallery*/
.image-checkbox {
cursor: pointer;
box-sizing: border-box;
-moz-box-sizing: border-box;
-webkit-box-sizing: border-box;
border: 4px solid transparent;
margin-bottom: 0;
outline: 0;
}
.image-checkbox input[type="checkbox"] {
display: none;
}
.image-checkbox-checked {
border-color: #4783B0;
}
.image-checkbox .fa {
position: absolute;
color: #4A79A3;
background-color: #fff;
padding: 10px;
top: 0;
right: 0;
}
.image-checkbox-checked .fa {
display: block !important;
}
@media (max-width: 768px) {
table th {
font-size: 14px;
}
table td:nth-child(2),
table th:nth-child(2) {
width: 50%;
}
}
.table td, .table th{
vertical-align:middle;
}
/*card*/
.card {
box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
transition: 0.3s;
border-radius: 20px;
}
.card:hover {
box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}
.card-img-top {
border-top-left-radius: 20px;
border-top-right-radius: 20px;
}
.price {
font-size: 1.5rem;
font-weight: bold;
color: #ff4500;
}
.payment-option {
cursor: pointer;
}
.payment-option.selected {
border: 2px solid blue;
}
</style>
<!-- Page Content -->
<div class="content container-fluid">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Quote</h3>
                <!-- <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Salary</li>
                </ul> -->
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_orders"><i class="fa fa-plus"></i> Add Quote</a>
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
    <!-- Search Filter -->
    <div class="row filter-row d-none">
        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
            <div class="form-group form-focus">
                <input type="text" class="form-control floating">
                <label class="focus-label">Employee Name</label>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
            <div class="form-group form-focus select-focus">
                <select class="select floating">
                    <option value=""> -- Select -- </option>
                    <option value="">Employee</option>
                    <option value="1">Manager</option>
                </select>
                <label class="focus-label">Role</label>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
            <div class="form-group form-focus select-focus">
                <select class="select floating">
                    <option> -- Select -- </option>
                    <option> Pending </option>
                    <option> Approved </option>
                    <option> Rejected </option>
                </select>
                <label class="focus-label">Leave Status</label>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
            <div class="form-group form-focus">
                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <label class="focus-label">From</label>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
            <div class="form-group form-focus">
                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <label class="focus-label">To</label>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
            <a href="#" class="btn btn-success btn-block"> Search </a>
        </div>
    </div>
    <!-- /Search Filter -->
    
    <div class="row">
                <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Quote id</th>
                            <th>Name</th>
                            <th>Project</th>
                            <th>Created by</th>
                            <th>Project Docs</th>
                            <th>Quote status</th>
                            <th>Date</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quote as $key) { ?>
                        <tr>
                            <td><?=++$i?></td>
                            @if (auth()->user()->roll == 'hr')
                            <td><a target="_blank" href="{{ url('track-quote/'.$key->order_id) }}">{{$key->order_id}}</a></td>
                            @else
                            <td><a target="_blank" href="{{url('quote-details').'/'.$key->id}}">{{$key->order_id}}</a></td>
                            @endif
                            

                            <td>{{$key->name}}</td>
                            <td>{{$key->product_name}}</td>
                            <td>{{$key->created_by}}</td>
                            @if (!empty($key->document))
                            <td><a href="{{url('public/quote_document/'.$key->document)}}" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-eye m-r-5"></i></a></td>
                            @else
                            <td>empty</td>
                            @endif


                            <td>{{$key->order_status}}</td>
                            <td>{{$key->created_at->format('d-m-Y')}}</td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{url('quote-details').'/'.$key->id}}"><i class="fa fa-eye m-r-5"></i> Show</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_orders_<?=$key->id?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Edit orders Modal -->
                        <div id="edit_orders_<?=$key->id?>" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Files</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('addordersFile') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Upload Files</label>
                                                        <input type="hidden" name="ordersId" value="<?=$key->id?>">
                                                        <input class="form-control" type="file" name="files[]" multiple>
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
                        <!-- Edit orders Modal -->
                        
                        <!-- Delete orders Modal -->
                        <div class="modal custom-modal fade" id="delete_orders_<?=$key->id?>" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-header">
                                            <h3>Delete orders</h3>
                                            <p>Are you sure want to delete?</p>
                                        </div>
                                        <div class="modal-btn delete-action">
                                            <div class="row">
                                                <div class="col-6">
                                                    <form action="{{ route('all-orders.destroy',$key->id) }}" method="POST">
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
                        <!-- Delete orders Modal -->
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            {!! $quote->links() !!}
        </div>
    </div>
</div>
<!-- /Page Content -->
<!-- Add orders Modal -->
<div id="add_orders" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title bg-danger p-3 text-white font-weight-bold">Request a Quote for Your Project</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('all-orders.store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data" id="order_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <p class="text-center">Transform your online presence with our comprehensive Website, SEO, Marketing, and Support services. Request a Quote now and let's make it happen.</p>
                        </div>
                        @foreach ($services as $service)
                        <div class="col-3">
                                <div class="card text-center">
                                    <img src="{{$service->image}}" class="card-img-top">
                                    <div class="card-body">
                                        <h2 class="card-title font-weight-bold">{{$service->name}}</h2>
                                        <a href="{{ $service->website }}" class="btn-sm btn-danger" target="_blank">details</a>
                                    </div>
                                </div>
                        </div>
                        @endforeach


                        <input type="hidden" name="order_type" value="services">
                        @if (auth()->user()->roll == 'hr')
                        <input type="hidden" name="created_by" value="admin">
                        @endif

                        @if (auth()->user()->roll == 'user')
                        <input type="hidden" name="created_by" value="self">
                        <input type="hidden" name="customer_id" value="{{auth()->user()->id}}">                        
                        @endif
                        @if (!Auth::check())
                           <input type="hidden" name="created_by" value="self">
                        @endif

                        <div class="col-sm-12 mt-3 mb-3">
                            <h2 class="text-center font-weight-bold">Information</h2>
                        </div>

                        @if (auth()->user()->roll == 'hr')
                        <div class="col-sm-12">
                        <div class="form-group">
                        <label>Name</label>
                        <select class="form-control" id="customer_id" name="customer_id" required>
                            <option disabled selected>Select Name</option>
                            @foreach ($user as $get_user)
                <option value="{{$get_user->id}}">{{$get_user->name}}</option>
                            @endforeach
                        </select>
                        </div>
                        </div>
                        @endif

                        @if (auth()->user()->roll == 'user')
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" name="customer_name" value="<?=auth()->user()->name?>" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" name="customer_email" value="<?=auth()->user()->email?>" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" type="text" name="customer_phone" value="<?=auth()->user()->phone?>">
                            </div>
                        </div>

                        @endif
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Project title</label>
                                <input class="form-control" type="text" name="project_title">
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3 mb-3">
                            <h2 class="text-center font-weight-bold">Project</h2>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Ready to take the next step with your project? Let us know the details of your project including the type of project, specific requirements, deadline, and budget. Our team will provide you with a personalized quote to help bring your project to life.</label>
                                <textarea name="note" rows="5" class="form-control" placeholder="Write here...."></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Upload document</label>
                                <input class="form-control" type="file" name="document">
                            </div>
                        </div>
                        
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-danger submit-btn" id="submit-button">Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add orders Modal -->
@include('include.footer')