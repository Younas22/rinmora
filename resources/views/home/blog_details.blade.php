@include('home.include.head')
<!-- blog details -->
<style type="text/css">
.section-title-wrap{
border-radius: unset;
}

h3{
font-size: 20px;
color:#212529;
}


h2{
color:#212529;
}

.services-thumb{
padding-bottom: 10px;
}
.page_header{
position: fixed;
top: 0;
left: 0;
width: 100%;
z-index: 2;
}
</style>
<section class="services section-padding" id="section_3">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-12 mx-auto">
                <div class="col-lg-12 col-md-12 col-12 text-center page_header">
                    <div class="section-title-wrap d-flex justify-content-center align-items-center mb-4" style="background-color:#535da1;">
                        <img src="{{url('public/web/images/white-desk-work-study-aesthetics.jpg')}}" class="avatar-image img-fluid d-none" alt="">
                        <h2 class="text-white ms-4 mb-0 p-5">Blog Details</h2>
                    </div>
                </div>
                <div class="clearfix"></div><br>
                <div class="row pt-5">
                    <div class="col-lg-12 col-12">
                        <div class="services-thumb">
                            <div class="d-flex flex-wrap align-items-center mb-2 pb-2">
                                <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">{{$post_details->name}}</p>
                                    <div class="services-price-overlay"></div>
                                </div>

                                <h1 class="mb-0">{{$post_details->title}}</h1>

                                <p class="author-name mt-1">Author: Younas Dev</p>
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <p class="post-date mt-1">Date: {{$post_details->created_at->format('F d, Y')}}</p>

                                <img class="img-fluid" src="{{$post_details->featured_image}}" alt="{{$post_details->title}}" class="">
                                
                            </div>
                            <div class="p-4">
                                <?=$post_details->body?>
                                <br>
                                <b>Tags: {{$keywords}}</b>
                            </div>
                            <div class="m-4 text-center social-icon">
                                <strong class="site-footer-title d-block">Share</strong>
                                <ul class="social-icon share-style">
                                    {!! $shareComponent !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact -->
@include('home.include.contactpage')
@include('home.include.footer')