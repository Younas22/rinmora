@include('include.header')
<?php if (auth()->user()->roll == 'hr') { ?>
<!-- Page Content -->
<div class="content container-fluid">

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
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-12">
            <div class="card-body bg-white">
                <form action="{{ route('add_note') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary mb-2" type="submit">Add Notice</button>
                    <br><i style="font-size:1rem;">Notice Posted On : {{date("d-m-Y", strtotime($notice_board->created_at))}}</i>
                    <textarea rows="3" class="ckeditor_ form-control" placeholder="Add Notice here....." name="note"><?=$notice_board->desc?></textarea>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Page Header -->
{{-- Seles Dashboard --}}
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12 db-header">
            <h3 class="page-title">Sales Overview</h3>
        </div>
    </div>
</div>
<!-- /Page Header -->
<!-- Total Revenue  -->
<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
        <div class="stats-info">
            <h6>Total Revenue </h6>
            <h4><?=$get_all_time_revenue?> <span>all time</span></h4>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
        <div class="stats-info">
            <h6>Total Revenue </h6>
            <h4><?=$get_monthly_revenue?> <span>this month</span></h4>
        </div>
    </div>
    
</div>
{{-- User --}}
<div class="page-header">
    <div class="row">
        <div class="col-sm-12 db-header">
            <h3 class="page-title">Users</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Total Users</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$total_users?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Monthly Users</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$monthly_users?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Today Users</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$today_users?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-users"></i>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
</div>
<!-- /Page Content -->
{{-- Service --}}
<div class="page-header">
    <div class="row">
        <div class="col-sm-12 db-header">
            <h3 class="page-title">Projects Quotes</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Total Quotes</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$total_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-question"></i>
                    </div>
                </div>
                <div class="db-ico d-none">
                    <div class="db-left">
                        <h2>
                        <?=$total_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Monthly Quotes</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$monthly_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-question"></i>
                    </div>
                </div>
                <div class="db-ico d-none">
                    <div class="db-left">
                        <h2>
                        <?=$monthly_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Today Quotes</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$today_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-question"></i>
                    </div>
                </div>
                <div class="db-ico d-none">
                    <div class="db-left">
                        <h2>
                        <?=$today_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
                
            </div>
        </div>
    </div>


    
</div>
<!-- /Page Content -->
<!-- Service Orders -->
<div class="row mb-5">
    <div class="col-md-12 col-lg-12">
        <div class="row d-flex">
            <div class="col-md-12">
                <div class="card card-table mb-0">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Service Orders & Quotes</h3>
                        <a target="_blank" href="{{ url('all-quote') }}" class="btn btn-primary">All Quotes</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-nowrap mb-0">
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
                                    <?php $count=1; foreach ($quote as $key) { ?>
                                    <tr>
                                        <td><?=$count?></td>
                                        <td><a target="_blank" href="{{ url('track-quote/'.$key->order_id) }}">{{$key->order_id}}</a></td>
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
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $count++; } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- /Service Orders -->
{{-- book --}}
<div class="page-header">
    <div class="row">
        <div class="col-sm-12 db-header">
            <h3 class="page-title">Books</h3>
        </div>
    </div>
</div>
<!-- /Page Header -->
<div class="row">
    <div class="col-md-4 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Total Sales</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$total_books?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-book"></i>
                    </div>
                </div>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$total_books_sale?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Monthly Sales</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$monthly_books?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-book"></i>
                    </div>
                </div>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$monthly_books_sale?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Today Sales</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$today_books?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-book"></i>
                    </div>
                </div>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$today_books_sale?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
{{-- Blog --}}
<div class="page-header">
    <div class="row">
        <div class="col-sm-12 db-header">
            <h3 class="page-title">Blog</h3>
        </div>
    </div>
</div>
<!-- /Page Header -->
<div class="row">
    <div class="col-md-4 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Total Sales</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$total_blog?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-newspaper-o"></i>
                    </div>
                </div>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$total_blog_sale?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Monthly Sales</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$monthly_blog?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-newspaper-o"></i>
                    </div>
                </div>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$monthly_blog_sale?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Today Sales</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$today_blog?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-newspaper-o"></i>
                    </div>
                </div>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$today_blog_sale?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Products order list -->
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="row d-flex">
            <div class="col-md-12">
                <div class="card card-table mb-0">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Products Orders</h3>
                        <a target="_blank" href="{{ url('all-orders') }}" class="btn btn-primary">All Orders</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-nowrap mb-0">
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
                                    <?php $count = 1; foreach ($order as $key) { ?>
                                    <tr>
                                        <td><?=$count?></td>
                                        <td><a target="_blank" href="{{ url('track-order/'.$key->order_id) }}">{{$key->order_id}}</a></td>
                                        <td>{{$key->name}}</td>
                                        <td>{{$key->product_name}}</td>
                                        <td>{{$key->created_by}}</td>
                                        <td>{{$key->payment_option}}</td>
                                        <td><a href="{{url('public/screenshoot/'.$key->screen_shoot)}}" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-eye m-r-5"></i></a></td>
                                        <td>{{$key->total_cost}}</td>
                                        <td>{{$key->payment_status}}</td>
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
                                        <td>{{$key->created_at->format('d-m-Y')}}</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{url('orders-details').'/'.$key->id}}"><i class="fa fa-eye m-r-5"></i> Show</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $count++; } ?>
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<!-- /Products order list -->
</div>
<!-- /Page Content -->
<?php }if (auth()->user()->roll == 'user') { ?>
<!-- Page Content -->
<div class="content container-fluid">
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12 db-header">
            <h3 class="page-title">Your journey starts now. Welcome!</h3>
            <!-- <select class="select">
                <option>This Month</option>
                <option>This Year</option>
            </select> -->
        </div>
    </div>
</div>
<!-- /Page Header -->

<!-- Page Header -->
<div class="page-header">
@if (!empty($note->desc) && $note->desc != '.')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <?=$note->desc?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="row">


    <div class="col-sm-12 db-header">
        <div class="card-body bg-white">
            {{-- <h3>Your journey starts now. Welcome!</h3> --}}
            <p class="">
             <strong>
                 Welcome to our website! We're excited to have you join us and offer our services and products to help grow your online presence.
             </strong>

            Our services include website development, SEO, marketing and support. Our products include e-books and blog script.<br><br>
            <button class="btn btn-sm btn-outline-danger"><a target="_blank" href="{{ url('/') }}">Services</a></button>
            <button class="btn btn-sm btn-outline-dark"><a target="_blank" href="https://eresources.younasdev.com/">E-books</a></button>
            <button class="btn btn-sm btn-outline-info"><a href="#">Blog Script</a></button>
            <br><br>Click on the appropriate button to learn more and start utilizing our services and products to enhance your online presence.

            </p>
        </div>
    </div>
</div>
</div>
<!-- /Page Header -->

{{-- Products --}}
<div class="page-header">
    <div class="row">
        <div class="col-sm-12 db-header">
            <h3 class="page-title">Products</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Books</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$total_books?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-book"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Blog Source Code</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$total_blog?>
                        <!-- <span>+2.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-newspaper-o"></i>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
</div>
<!-- /Page Content -->
{{-- Latest Activity --}}
<div class="row">
    
    <div class="col-md-12">
        <div class="card card-table mb-0">
            <div class="card-header">
                        <h3 class="card-title mb-0">Products Orders</h3>
                        <a target="_blank" href="{{ url('all-orders') }}" class="btn btn-primary">All Orders</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-nowrap mb-0">
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
                                    <?php $count = 1; foreach ($order as $key) { ?>
                                    <tr>
                                        <td><?=$count?></td>
                                        <td><a target="_blank" href="{{url('orders-details').'/'.$key->id}}">{{$key->order_id}}</a></td>
                                        <td>{{$key->name}}</td>
                                        <td>{{$key->product_name}}</td>
                                        <td>{{$key->created_by}}</td>
                                        <td>{{$key->payment_option}}</td>
                                        <td><a href="{{url('public/screenshoot/'.$key->screen_shoot)}}" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-eye m-r-5"></i></a></td>
                                        <td>{{$key->total_cost}}</td>
                                        <td>{{$key->payment_status}}</td>
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
                                        <td>{{$key->created_at->format('d-m-Y')}}</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{url('orders-details').'/'.$key->id}}"><i class="fa fa-eye m-r-5"></i> Show</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $count++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Projects Quotes --}}
<div class="page-header mt-5">
    <div class="row">
        <div class="col-sm-12 db-header">
            <h3 class="page-title">Projects Quotes</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Total Quotes</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$total_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-question"></i>
                    </div>
                </div>
                <div class="db-ico d-none">
                    <div class="db-left">
                        <h2>
                        <?=$total_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Monthly Quotes</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$monthly_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-question"></i>
                    </div>
                </div>
                <div class="db-ico d-none">
                    <div class="db-left">
                        <h2>
                        <?=$monthly_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4 col-xl-4">
        <div class="card dash-widget" style="background-color:#14B789;">
            <div class="card-body">
                <h4>Today Quotes</h4>
                <div class="db-ico">
                    <div class="db-left">
                        <h2>
                        <?=$today_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-question"></i>
                    </div>
                </div>
                <div class="db-ico d-none">
                    <div class="db-left">
                        <h2>
                        <?=$today_quotes?>
                        <!-- <span>+10.5%</span> -->
                        </h2>
                    </div>
                    <div class="db-right">
                        <i class="la la-money mt-2"></i>
                    </div>
                </div>
                
            </div>
        </div>
    </div>


    
</div>
<!-- /Page Content -->
<div class="row mb-5">
    
    
    <div class="col-md-12">
        <div class="card card-table mb-0">
            <div class="card-header">
                        <h3 class="card-title mb-0">Service Orders & Quotes</h3>
                        <a target="_blank" href="{{ url('all-quote') }}" class="btn btn-primary">All Quotes</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-nowrap mb-0">
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
                                    <?php $count=1; foreach ($quote as $key) { ?>
                                    <tr>
                                        <td><?=$count?></td>
                                        <td><a target="_blank" href="{{ url('quote-details').'/'.$key->id}}">{{$key->order_id}}</a></td>
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
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $count++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- /Page Content -->
</div>
<!-- /Page Wrapper -->
<?php } ?>
@include('include.footer')