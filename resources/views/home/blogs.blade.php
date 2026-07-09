@include('home.include.head')
<!-- blog -->
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


.page-link {
    color: #14b789 !important;
}

.page-item.active .page-link {
    z-index: 1 !important;
    background-color: #14b789 !important;
    border-color: #14b789 !important;
    color: white !important;
}

</style>
<section class="services section-padding" id="section_3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 mx-auto">
                <div class="col-lg-12 col-md-12 col-12 mb-5 page_header">
                    <!-- <a href="index.html">
                        <img src="{{url('public/web/images/arrow.png')}}" width="50" height="50" class="mb-2">
                    </a> -->
                    <div class="section-title-wrap d-flex justify-content-center align-items-center mb-4" style="background-color:#535da1;">
                        <img src="{{url('public/web/images/white-desk-work-study-aesthetics.jpg')}}" class="avatar-image img-fluid d-none" alt="">
                        <h2 class="text-white ms-4 mb-0 p-5">Blogs</h2>
                    </div>
                </div>
                <div class="clearfix"></div>
                
                <div class="row pt-5 mt-5">
                <p class="text-center mt-5 mb-5">Stay up-to-date with the latest industry news and insights on our blog</p class="text-center mt-5">
                
                    @foreach ($posts as $post)
                       <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="services-thumb">
                            <div class="d-flex flex-wrap align-items-center border-bottom mb-4 pb-3">
                                <h3 class="mb-0">{{$post->title}}</h3>
                                <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">{{$post->name}}</p>
                                    <div class="services-price-overlay"></div>
                                </div>
                                <img class="img-fluid mt-3" src="{{$post->featured_image}}" alt="{{$post->title}}">
                                <p class="author-name mt-1">Author: Younas Dev</p>
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <p class="post-date mt-1">Date: {{$post->created_at->format('F d, Y')}}</p>
                                            
                            </div>
                            <p><?=lmt($post->body, 250)?></p>
                            {{-- <a href="{{ str_slug($post->name,$post->slug) }}" class="custom-btn custom-border-btn btn mt-3">Read More</a> --}}

                            <a href="{{ str_slug($post->name,$post->slug) }}" class="custom-btn custom-border-btn btn mt-3">Read More</a>
                            <!-- <div class="services-icon-wrap d-flex justify-content-center align-items-center">
                                <i class="services-icon bi-globe"></i>
                            </div> -->
                        </div>
                    </div>
                    @endforeach
                

            </div>
            <div class="text-center">
                {!! $posts->links() !!}
                {{-- <a href="#" class="custom-btn custom-border-btn btn mt-3" style="background-color:#14B789; color: white; padding: 12px 50px;">Load More</a> --}}
            </div>
        </div>
    </div>
</div>
</section>
<!-- contact -->
@include('home.include.contactpage')
@include('home.include.footer')