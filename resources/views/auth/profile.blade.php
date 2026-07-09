@include('include.header')
{{-- {{dd($get_profile->name)}} --}}
            
                <!-- Page Content -->
                <div class="content container-fluid">
                
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Profile</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
                                </ul>
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
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-view">
                                        <div class="profile-img-wrap">
                                            <div class="profile-img">
                                                <a href="#"><img alt="" src="@if (empty($get_profile->profile_image))
                                                    {{url('public/assets/img/profiles/avatar-02.jpg')}}
                                                    @else
                                                    {{url('public/profile_image').'/'.$get_profile->profile_image}}
                                                @endif"></a>
                                            </div>
                                        </div>
                                        <div class="profile-basic">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="profile-info-left">
                                                        <h3 class="user-name m-t-0 mb-0">{{$get_profile->name}}</h3>
                                                        {{-- <h6 class="text-muted">UI/UX Design Team</h6> --}}
                                                        <small class="text-muted">{{$get_profile->department_name}}</small>
                                                        {{-- <div class="staff-id">Employee ID : FT-0001</div> --}}
                                                        <div class="small doj text-muted">Date of Join : {{ date('d-m-Y', strtotime($get_profile->created_at)) }}</div>
                                                        <!-- <div class="staff-msg"><a class="btn btn-custom" href="chat.html">Send Message</a></div> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <ul class="personal-info">
                                                        <li>
                                                            <div class="title">Name:</div>
                                                            <div class="text"><a href="">{{$get_profile->name}}</a></div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Email:</div>
                                                            <div class="text"><a href="">{{$get_profile->email}}</a></div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Address:</div>
                                                            <div class="text">{{$get_profile->address}}</div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Phone:</div>
                                                            <div class="text"><a href="">{{$get_profile->phone}}</a></div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Alternate Phone:</div>
                                                            <div class="text">{{$get_profile->alternate_phone}}</div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
                <!-- /Page Content -->
                
                <!-- Profile Modal -->
                <div id="profile_info" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Profile Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('employees-list.update',$get_profile->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" class="form-control" name="profile" value="profile">
                                <input type="hidden" class="form-control" name="self" value="self">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="profile-img-wrap edit-img">
                                                <img class="inline-block" src="{{url('public/assets/img/profiles/avatar-02.jpg')}}" alt="user">
                                                <div class="fileupload btn">
                                                    <span class="btn-text">edit</span>
                                                    <input type="hidden" name="old_profile_image_name" value="{{$get_profile->profile_image}}">
                                                    <input class="upload" type="file" name="profile_img">
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{$get_profile->name}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control" name="email" value="{{$get_profile->email}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="text" class="form-control" name="password" value="{{$get_profile->dc_password}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address" value="{{$get_profile->address}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" class="form-control" name="phone" value="{{$get_profile->phone}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alternate Phone</label>
                                                <input type="text" class="form-control" name="alternate_phone" value="{{$get_profile->alternate_phone}}">
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
                <!-- /Profile Modal -->
                

@include('include.footer')