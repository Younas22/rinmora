@include('home.include.head')
<!-- blog details -->
<style type="text/css">
.section-title-wrap{
border-radius: unset;
}

h3{
font-size: 20px;
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
                        <img src="{{$img}}" class="avatar-image img-fluid d-none" alt="">
                        <h2 class="text-white ms-4 mb-0 p-5 text-capitalize">{{$name}}</h2>
                    </div>
                </div>
                <div class="clearfix"></div><br>
                <div class="row pt-5">
                    <div class="col-lg-12 col-12">
                        <div class="services-thumb">
                            <div class="d-flex flex-wrap align-items-center mb-4 pb-3">
                                <h1 class="mb-0">{{$title}}</h1>
                                {{-- <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">{{$name}}</p>
                                    <div class="services-price-overlay"></div>
                                </div> --}}
                                <img class="img-fluid" src="{{$img}}" alt="" width="1000">
                            </div>
                            <div class="p-4">
                                <p>
                                    <?=$details?>
                                </p>
                            </div>
                            <!-- <div class="services-icon-wrap d-flex justify-content-center align-items-center">
                                <i class="services-icon bi-globe"></i>
                            </div> -->
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


<!-- contact -->
@include('home.include.contactpage')
@include('home.include.footer')