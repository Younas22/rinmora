@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Quote details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Quote-Details</li>
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
            @if ($quote_detail->order_status == 'pending')
            <div class="col-auto float-right ml-auto">
                <span class="btn btn-sm text-white bg-warning p-2 text-capitalize" style="border-radius: 50px">{{$quote_detail->order_status}}</span>
            </div>
            @endif
            @if ($quote_detail->order_status == 'open')
            <div class="col-auto float-right ml-auto">
                <span class="btn btn-sm text-white bg-success p-2 text-capitalize" style="border-radius: 50px">{{$quote_detail->order_status}}</span>
            </div>
            @endif
            @if ($quote_detail->order_status == 'completed')
            <div class="col-auto float-right ml-auto">
                <span class="btn btn-sm text-white bg-info p-2 text-capitalize" style="border-radius: 50px">{{$quote_detail->order_status}}</span>
            </div>
            @endif
            
            @if ($quote_detail->order_status == 'completed')
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
                        <h3>Quote ID: <span style="font-size: 18px;">{{$quote_detail->order_id}}</span></h3>
                    </div>
                    <div class="project-title">
                        <h3>Quote Title: <span style="font-size: 18px;">{{$quote_detail->product_name}}</span></h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="m-b-20">Quote details here</h3>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
                            <span style="font-size: 18px;">{{$quote_detail->desc}}</span>
                        </div>
                        
                    </div>
                </div>
            </div>
            @if (!empty($quote_detail->document))
            <div class="card">
                <div class="card-body">
                    <div class="uploaded-img-name">
                    <div class="project-title">
                        <h3>Document</h3>
                    </div>
                        <a href="{{ url('public/quote_document/'.$quote_detail->document) }}" target="_blank" download="{{ url('public/quote_document/'.$quote_detail->document) }}" class="dropdown-item btn-danger text-center" style="border-radius:15px; color: white; width:20%;">Download</a>
                    </div>
                </div>
            </div>
            @endif

            @if (!empty($quote_detail->answer))
            <div class="card">
                <div class="card-body">
                    <div class="project-title">
                        <h3>Answer by Team: <span style="font-size: 18px;">{{$quote_detail->answer}}</span></h3>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-4 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title m-b-15">Quote details</h6>
                    <table class="table table-striped table-border">
                        <tbody>
                            <tr>
                                <td>Name:</td>
                                <td class="text-right text-capitalize">{{$quote_detail->name}}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td class="text-right text-capitalize">{{$quote_detail->email}}</td>
                            </tr>
                            @if (!empty($quote_detail->phone))
                            <tr>
                                <td>Phone:</td>
                                <td class="text-right text-capitalize">{{$quote_detail->phone}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Quote Status:</td>
                                <td class="text-right text-capitalize">{{$quote_detail->order_status}}</td>
                            </tr>
                            <tr>
                                <td>Created:</td>
                                <td class="text-right">{{$quote_detail->created_at->format('d-m-Y')}}</td>
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