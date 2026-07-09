@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Order details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Order-Details</li>
                </ul>
            </div>
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
            @if ($order_detail->order_status == 'pending')
            <div class="col-auto float-right ml-auto">
                <span class="btn btn-sm text-white bg-warning p-2 text-capitalize" style="border-radius: 50px">{{$order_detail->order_status}}</span>
            </div>
            @endif
            @if ($order_detail->order_status == 'open')
            <div class="col-auto float-right ml-auto">
                <span class="btn btn-sm text-white bg-success p-2 text-capitalize" style="border-radius: 50px">{{$order_detail->order_status}}</span>
            </div>
            @endif
            @if ($order_detail->order_status == 'completed')
            <div class="col-auto float-right ml-auto">
                <span class="btn btn-sm text-white bg-info p-2 text-capitalize" style="border-radius: 50px">{{$order_detail->order_status}}</span>
            </div>
            @endif
            
            @if ($order_detail->order_status == 'completed')
            <div class="col-auto float-right ml-auto d-none">
                <a href="#" class="btn add-btn" target="_blank">Invoice</a>
            </div>
            @endif

            @if (auth()->user()->roll == 'hr')
            <div class="col-auto float-right ml-auto">
                <a href="{{ url('hr-dashboard') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            @else
            <div class="col-auto float-right ml-auto">
                <a href="{{ url('employee-dashboard') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            @endif
            
            
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row">
        <div class="col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="project-title">
                        <h3>Order ID: <span style="font-size: 18px;">{{$order_detail->order_id}}</span></h3>
                    </div>
                    <div class="project-title">
                        <h3>Order Title: <span style="font-size: 18px;">{{$order_detail->product_name}}</span></h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="m-b-20">Order details here</h3>
                    <div class="row">
                        @if ($order_detail->product_name == 'e-Books')
                        @foreach ($product_details as $key)
                        <div class="col-md-4 col-sm-6 col-lg-4 col-xl-4">
                            
                            <h5 class="text-left">Type: {{ ucfirst($key->product_type) }}</h5>
                            <h5 class="text-left">{{ $key->name }}</h5>
                            <div class="uploaded-box text-center">
                                <div class="uploaded-img">
                                    <img src="{{ $key->image }}" class="img-fluid" alt="">
                                </div>
                                <div class="uploaded-img-name">

                                    @if (!empty($key->joining_link))
                                    @if ($key->product_type == 'notion')
                                        <a href="{{ $key->joining_link }}" target="_blank" class="dropdown-item btn-danger" style="border-radius:15px; color: white;">Find here</a>
                                    @else
                                        <a href="{{ $key->joining_link }}" target="_blank" download="{{ $key->joining_link }}" class="dropdown-item btn-danger" style="border-radius:15px; color: white;">Download</a>
                                    @endif
                                    
                                    @else
                                    <a href="#" class="btn btn-secondary">Download</a>
                                    @endif


                                   
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        {{-- <?php dd($product_details); ?> --}}
                        @if ($order_detail->product_name == 'eBlog Code')
                        @foreach ($product_details as $key)
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
                            <div class="card text-center">
                                <img class="card-img-top" src="{{ $key->image }}" alt="Card image">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $key->name }}</h5>
                                    @if (!empty($key->joining_link))
                                        <a target="_blank" href="{{$key->joining_link}}" class="btn btn-primary">Download</a>
                                    @else
                                    <a href="#" class="btn btn-secondary">Download</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title m-b-20">Description</h5>
                                    <p><?=$key->desc?></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        @if ($order_detail->product_name == 'Cource')
                        @foreach ($product_details as $key)
                        <div class="col-md-4 col-sm-12 col-lg-4 col-xl-4">
                            <div class="card text-center">
                                <img class="card-img-top" src="{{ $key->image }}" alt="Card image">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $key->name }}</h5>
                                    @if (!empty($key->joining_link))
                                        <a target="_blank" href="{{$key->joining_link}}" class="btn btn-primary">Join</a>
                                    @else
                                    <a href="#" class="btn btn-secondary">Join</a>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 col-lg-8 col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title m-b-20">Facebook Profile</h5>
                                    <p>{{ $key->desc }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        
                    </div>


                </div>
            </div>


            @if (!empty($order_detail->desc))
            <div class="card">
                <div class="card-body">
                    <div class="project-title">
                        <h3>Note: <span style="font-size: 18px;">{{$order_detail->desc}}</span></h3>
                    </div>
                </div>
            </div>
            @endif

        </div>
        <div class="col-lg-4 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title m-b-15">Order details</h6>
                    <table class="table table-striped table-border">
                        <tbody>
                            <tr>
                                <td>Name:</td>
                                <td class="text-right text-capitalize">{{$order_detail->name}}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td class="text-right text-capitalize">{{$order_detail->email}}</td>
                            </tr>
                            @if (!empty($order_detail->phone))
                            <tr>
                                <td>Phone:</td>
                                <td class="text-right text-capitalize">{{$order_detail->phone}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Payment Option:</td>
                                <td class="text-right text-capitalize">{{$order_detail->payment_option}}</td>
                            </tr>
                            <tr>
                                <td>Payment status:</td>
                                <td class="text-right text-capitalize">{{$order_detail->payment_status}}</td>
                            </tr>
                            <tr>
                                <td>Order Status:</td>
                                <td class="text-right text-capitalize">{{$order_detail->order_status}}</td>
                            </tr>
                            <tr>
                                <td>Total cost:</td>
                                <td class="text-right">{{$order_detail->total_cost}}</td>
                            </tr>
                            <tr>
                                <td>Created:</td>
                                <td class="text-right">{{$order_detail->created_at->format('d-m-Y')}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- /Page Content -->
@include('include.footer')