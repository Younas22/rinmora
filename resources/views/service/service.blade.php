@include('include.header')
<!-- Page Content -->
<div class="content container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="file-wrap"> 
<div class="file-cont-wrap">
<div class="file-cont-inner">
    <div class="file-cont-header">
        {{-- <div class="file-options">
            <a href="javascript:void(0)" id="file_sidebar_toggle" class="file-sidebar-toggle">
                <i class="fa fa-bars"></i>
            </a>
        </div> --}}
        <span>Services</span>
        <div class="col-auto float-right ml-auto">
            <?php if (auth()->user()->roll == 'user') { ?>
                <a href="{{ url('employee-dashboard') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back</a>
            <?php }else{ ?>
                <a href="{{ url('hr-dashboard') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back</a>
            <?php } ?>
        </div>
    </div>
    <div class="file-content">
        <div class="file-body">
            <div class="file-scroll">
                <div class="file-content-inner">
                    <div class="row">
                        @if (count($services) > 0)
                        @foreach($services as $service)
                        <div class="col-md-3">
                            <div class="card text-center">
                                <img src="{{ $service->image }}" class="card-img-top img-fluid" alt="{{ $service->name }}">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">{{ $service->name }}</h5>
                                    <p class="card-text">{{ $service->desc }}</p>
                                    {{-- <p class="card-text text-danger">Price: 12</p> --}}
                                    <a href="{{ $service->website }}" class="btn btn-success" target="_blank">Go to website</a>
                                </div>
                            </div>
                        </div>
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

@include('include.footer')