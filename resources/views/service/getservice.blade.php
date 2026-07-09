<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index, follow">
        <meta name="keywords" content="{{$keywords}}">
        <meta name="description" content="{{$meta_description}}">
        <meta name="author" content="YounasDev">

        <!-- MEDA FOR SEARCH ENGINES AND SOCIAL PLATFORMS -->
        <meta property="og:title" content="{{$meta_title}}">
        <meta property="og:description" content="{{$meta_description}}">
        <meta property="og:image" content="{{$image}}">
        <meta property="og:site_name" content="YounasDev"/>
        <meta property="og:url" content="{{url()->current()}}"/>
        <meta property="og:publisher" content="YounasDev"/>


            <!-- TWITTER CARD -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@'YounasDev' | {{$title}}" />
        <meta name="twitter:title" content="{{$meta_title}}" />
        <meta name="twitter:description" content="{{$meta_description}}" />
        <meta name="twitter:image" content="{{$image}}" />

        <link rel="icon" href="{{url('public/web/images/favicon.png')}}">
        <link rel="canonical" href="{{url()->current()}}" />
        <title>{{$title}}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<style type="text/css">
a{
text-decoration: none !important;
}
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
@media (min-width: 576px) {
.card-title {
font-size: 1.2rem !important;
}
}
@media (min-width: 768px) {
.card-title {
font-size: 1.5rem !important;
}
}
@media (min-width: 992px) {
.card-title {
font-size: 1.8rem !important;
}
}
@media (min-width: 1200px) {
.card-title {
font-size: 2rem !important;
}
}
</style>
</head> 
<body style="background-color: black;">
<!-- Add orders Modal -->
<div id="add_orders" class="custom-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#535da1;">
                <h2 class="text-center p-3 text-white font-weight-bold">Request a Quote for Your Project</h2>
                <a class="btn-sm text-dark" target="_blank" href="{{ url('customer-service') }}" style="text-decoration: none; background-color: #ffe400;">Help</a>
            </div>
            <div class="modal-body">
                <form action="{{ route('create.order.store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data" id="order_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <h2 class="text-center">Our Services</h2>
                            <p class="text-center">Transform your online presence with our comprehensive Website, SEO, Marketing, and Support services. Request a Quote now and let's make it happen.</p>
                        </div>
                        @foreach ($services as $service)
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3 mb-3">
                                <div class="card text-center">
                                    <img src="{{$service->image}}" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title font-weight-bold">{{$service->name}}</h5>
                                        <a href="{{ $service->website }}" class="btn-sm text-white" style="background-color:#535da1;" target="_blank">details</a>
                                    </div>
                                </div>
                        </div>
                        @endforeach

                        <div class="col-sm-12 mt-3 mb-3">
                            <h2 class="text-center font-weight-bold">Information</h2>
                        </div>
                        <input type="hidden" name="order_type" value="services">
                        <input type="hidden" name="created_by" value="self">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" name="customer_name" required>
                            </div> 
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" name="customer_email" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" type="text" name="customer_phone">
                            </div>
                        </div>
                        
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
                                <textarea name="note" rows="5" class="form-control" placeholder="Write here...." required></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Upload document</label>
                                <input class="form-control" type="file" name="document">
                            </div>
                        </div>
                        
                    </div>

                    <div class="submit-section text-center mt-3">
                        <button class="btn btn-danger submit-btn" id="submit-button">Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add orders Modal -->
</body>
</html>