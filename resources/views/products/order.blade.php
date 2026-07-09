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


input[type="radio"] {
    display: none;
}
input[type="radio"]:checked + label .card {
    border: 3px solid #007bff;
}
</style>
<!-- Page Content -->
<div class="content container-fluid">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Orders</h3>
                <!-- <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Salary</li>
                </ul> -->
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_orders"><i class="fa fa-plus"></i> Add Order</a>
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
                            <th>Order id</th>
                            <th>Name</th>
                            <th>Item</th>
                            <th>Created by</th>
                            <th>Payment via</th>
                            <th>Pay SS</th>
                            <th>Total</th>
                            <th>Pay status</th>
                            <th>Order status</th>
                            <th>Date</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order as $key) { ?>
                        <tr>
                            <td><?=++$i?></td>
                            @if (auth()->user()->roll == 'hr')
                            <td><a target="_blank" href="{{ url('track-order/'.$key->order_id) }}">{{$key->order_id}}</a></td>
                            @else
                            <td><a target="_blank" href="{{url('orders-details').'/'.$key->id}}">{{$key->order_id}}</a></td>
                            @endif

                            <td>{{$key->name}}</td>
                            <td>{{$key->product_name}}</td>
                            <td>{{$key->created_by}}</td>
                            <td>{{$key->payment_option}}</td>
                            <td><a href="{{url('public/screenshoot/'.$key->screen_shoot)}}" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-eye m-r-5"></i></a></td>
                            <td>{{$key->total_cost}}</td>
                            <td>{{$key->payment_status}}</td>



                        @if (auth()->user()->roll == 'hr')
                            <td>
                                @if ($key->order_status == 'pending')
                                    <a class="btn btn-sm btn-warning text-white" href="#" data-toggle="modal" data-target="#status_update_<?=$key->id?>"> {{$key->order_status}}</a>
                                @endif

                                @if ($key->order_status == 'close')
                                    <a class="btn btn-sm btn-danger text-white" href="#" data-toggle="modal" data-target="#status_update_<?=$key->id?>"> {{$key->order_status}}</a>
                                @endif

                                @if ($key->order_status == 'open')
                                    <a class="btn btn-sm btn-success text-white" href="#" data-toggle="modal" data-target="#status_update_<?=$key->id?>"> {{$key->order_status}}</a>
                                @endif

                                @if ($key->order_status == 'completed')
                                    <a class="btn btn-sm btn-info text-white" href="#" data-toggle="modal" data-target="#status_update_<?=$key->id?>"> {{$key->order_status}}</a>
                                @endif
                            </td>
                        @else
                            <td>
                                @if ($key->order_status == 'pending')
                                    <a class="btn btn-sm btn-warning text-white"> {{$key->order_status}}</a>
                                @endif

                                @if ($key->order_status == 'close')
                                    <a class="btn btn-sm btn-danger text-white"> {{$key->order_status}}</a>
                                @endif

                                @if ($key->order_status == 'open')
                                    <a class="btn btn-sm btn-success text-white"> {{$key->order_status}}</a>
                                @endif

                                @if ($key->order_status == 'completed')
                                    <a class="btn btn-sm btn-info text-white"> {{$key->order_status}}</a>
                                @endif
                            </td>
                        @endif



                            <td>{{$key->created_at->format('d-m-Y')}}</td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{url('orders-details').'/'.$key->id}}"><i class="fa fa-eye m-r-5"></i> Show</a>

                                        @if (auth()->user()->roll == 'hr')
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_orders_<?=$key->id?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        @endif
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




<!-- Update Order Status -->
<div class="modal custom-modal fade order_status" id="status_update_{{$key->id}}" role="dialog">
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <select class="form-control" id="status-select">
                <option value="pending" {{ $key->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="close" {{ $key->order_status == 'close' ? 'selected' : '' }}>Close</option>
                <option value="completed" {{ $key->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="open" {{ $key->order_status == 'open' ? 'selected' : '' }}>Open</option>
            </select>


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-status-btn" data-order-id="{{ $key->id }}">Save</button>
      </div>
    </div>
  </div>

</div>
<!-- end Update Order Status -->



                        <?php } ?>
                    </tbody>
                </table>
            </div>
            {!! $order->links() !!}
        </div>
    </div>
</div>
<!-- /Page Content -->
<!-- Add orders Modal -->
<div id="add_orders" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title bg-danger p-3 text-white font-weight-bold">Get Now</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('all-orders.store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data" id="order_form">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="order_type" value="product">
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
                        
                        <div class="col-lg-8 offset-lg-2">
                            <p class="text-center d-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                        </div>
                        @foreach ($products as $product)
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <input type="radio" id="p{{$product->id}}" name="product" @if ($product->id == 1) {{'checked'}} @endif value="{{$product->id}}">
                            <label for="p{{$product->id}}">
                                <div class="card" style="cursor: pointer;">
                                    <img src="{{$product->image}}" class="card-img-top">
                                    <div class="card-body">
                                        <h2 class="card-title font-weight-bold">{{$product->name}}</h2>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                        {{-- book_details --}}
                        <div id="book_details">
                            <div class="col-sm-12">
                                <h2 class="text-center font-weight-bold"><?=$product_b->name?></h2>
                                <p><?=$product_b->desc?></p>
                            </div>

                            <div class="col-sm-12 mt-3">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm" id="order_teble_1">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Book Name</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = 1; ?>
                                        @foreach ($booking_details as $booking_b)
                                        
                                        <tr>
                                            <th scope="row">{{$count}}</th>
                                            <td class="checkbox-td">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-group" id="{{$booking_b->id}}" value="{{$booking_b->id}}" name="subproduct[]">
                                                        <label class="custom-control-label" for="{{$booking_b->id}}">{{$booking_b->name}}</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <label class="image-checkbox">
                                                    <img class="img-responsive" width="100" height="auto" src="{{$booking_b->image}}" />
                                                </label>
                                            </td>
                                            <td id="price">${{$booking_b->price}}</td>
                                            <td class="qty">1</td>
                                        </tr>
                                        <?php $count++; ?>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="4" class="font-weight-bold">Total</td>
                                            <td id="total" class="font-weight-bold"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- end book_details --}}
                        {{-- blogging_details --}}
                        <div id="blogging_details">
                            <div class="col-sm-12">
                                <h2 class="text-center font-weight-bold">{{$product_s->name}}</h2>
                                <p>{{$product_s->desc}}</p>
                            </div>
                            <div class="col-lg-6 offset-lg-3 mt-3">
                                <div id="order_teble_2" class="text-center">
                                    <div class="card" style="width_: 18rem;">
                                        <img src="{{$code_details->image}}" class="card-img-top img-fluid">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{$code_details->name}}</h5>
                                            <hr>
                                            <p class="card-text text-center">
                                                <span class="price">${{$code_details->price}}</span>
                                            </p>
                                            <input type="hidden" name="item_id" value="{{$code_details->id}}">
                                            <div class="text-center">
                                                <a href="#" class="btn btn-primary">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end blogging_details --}}


                        <div class="col-sm-12 mt-3 mb-3">
                            <h2 class="text-center font-weight-bold">Customer Information</h2>
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

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Note</label>
                                <textarea rows="5" class="form-control" type="text" name="note" placeholder="Important Note..."></textarea>
                            </div>
                        </div>

                        @endif


                        <div class="col-sm-12 mt-3 mb-3">
                            <h2 class="text-center font-weight-bold">Payment</h2>
                        </div>
                        <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <img src="{{ url('public/assets/img/payment/jazzcash.png') }}"  class="payment-option img-thumbnail img-responsive" data-name="JazzCash" data-details="Pay via JazzCash and enjoy quick and secure transactions.
                            <p>Title: Muhammad Yousaf</p>
                            <p>Account: +92-304-7222-723</p>
                            ">
                        </div>
                        <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <img src="{{ url('public/assets/img/payment/easypasa.png') }}" class="payment-option img-thumbnail img-responsive" data-name="EasyPaisa" data-details="Pay via EasyPaisa and enjoy quick and secure transactions.
                            <p>Title: Muhammad Younas</p>
                            <p>Account: +92-317-4340-853</p>
                            ">
                        </div>
                        <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <img src="{{ url('public/assets/img/payment/ubl.png') }}" class="payment-option img-thumbnail img-responsive p-4" data-name="UBL Omni" data-details="Pay via UBL Omni and enjoy quick and secure transactions.
                            <p>Title: Muhammad Younas</p>
                            <p>Account: 1097263183584</p>
                            ">
                        </div>
                        <div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                            <img src="{{ url('public/assets/img/payment/payoneer.png') }}" class="payment-option img-thumbnail img-responsive p-4" data-name="Payoneer" data-details="Pay via Payoneer and enjoy quick and secure transactions.
                            <p>Title: Muhammad Younas</p>
                            <p>Account: hm.younas22@gmail.com</p>
                            ">
                        </div>
                        <div class="col-12">
                            <div id="payment-details" class="mb-5 mt-3"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Payment Option</label>
                                <input type="text" class="form-control has-danger" name="payment_method" id="payment_method" value="" required>
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                            <div class="form-group">
                                <label>Add Payment</label>
                                <input type="text" class="form-control has-danger" name="total_payment" id="total_payment" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Upload Payment screenshoot</label>
                                <input class="form-control" type="file" name="screenshoot" required>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" id="submit-button">Add Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add orders Modal -->
@include('include.footer')

<script type="text/javascript">

$(document).on('change', '#status-select', function () {
    var status = $(this).val();
    $('#status-select').val(status);
});


$(document).on('click', '#save-status-btn', function () {
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var status = $('#status-select').val();
    var orderId = $(this).data('order-id');

    $.ajax({
        type: 'POST',
        url: '{{route('update-status')}}',
        data: {
            status: status,
            id: orderId
        },
        success: function (response) {
            console.log(response);
            $('.order_status').modal('hide');
            location.reload();
        }
    });
});


</script>