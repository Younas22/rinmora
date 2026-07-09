@include('home.include.head')
<nav class="navbar navbar-expand-lg d-none_">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <a href="{{ url('/') }}" class="navbar-brand mx-auto mx-lg-0">Younas <span style="color:#ffe400;">Dev</span></a>
        
        <div class="d-flex align-items-center d-lg-none">
            <i class="navbar-icon bi-telephone-plus me-3"></i>
            <a class="custom-btn btn" href="tel:+923460820722">
                +92 346 0820 722
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-5">
                {{-- <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_1">Home</a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_3">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_4">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll_" href="{{ url('testimonial') }}">Testimonial</a>
                </li> --}}

                <!-- <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_8">FAQ</a>
                </li> -->
                {{-- <li class="nav-item">
                    <a class="nav-link click-scroll_" href="{{ url('contact-us') }}">Contact</a>
                </li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:11% !important; font-size: 16px !important;">
                        Pages
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('about') }}">About</a>
                        <a class="dropdown-item" href="{{ url('projects') }}">Projects</a>
                        <a class="dropdown-item" href="{{ url('testimonial') }}">Testimonial</a>
                        <a class="dropdown-item" href="{{ url('get-services') }}">Services</a>
                        <a class="dropdown-item" href="{{ url('get-quote') }}">Get Quote</a>
                        <a class="dropdown-item" href="{{ url('get-products') }}">Products</a>
                        <a class="dropdown-item" href="{{ url('buy-now') }}">Buy Now</a>
                        <a class="dropdown-item" href="{{ url('blogs') }}">Blogs</a>
                        <a class="dropdown-item" href="{{ url('faq') }}">FAQ</a>
                        <a class="dropdown-item" href="{{ url('customer-service') }}">Help</a>
                    </div>
                </li>
            </ul>
            <div class="d-lg-flex align-items-center d-none ms-auto">
                <i class="navbar-icon bi-telephone-plus me-3"></i>
                <a class="custom-btn btn" href="tel:+923460820722">
                    +92 346 0820 722
                </a>
            </div>
            <!-- <div class="navbar-nav">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Page
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</nav>
<main>
    <section class="hero d-flex justify-content-center align-items-center" id="section_1" style="background-color: #535da1 !important;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 text-center">
                    <div class="hero-text">
                        <div class="hero-title-wrap  align-items-center mb-4">
                            <img src="{{url('public/web/images/me.png')}}" class="avatar-image mb-3 avatar-image-large_ img-fluid img-thumbnail" alt="">
                            <h2 class="hero-title ms-3 mb-0" style="color:black;">Welcome To Younas Dev!</h2>
                        </div>
                        <center><h1 class="text-white" style="margin-bottom:50px; max-width: 55rem;">Maximize Your Business Potential with Our Custom Web Development Services</h1></center>

                        <p class="text-white" style="font-weight: bold;">Get your free quote in 48 hours!</p>
                        <a class="custom-btn btn custom-link" href="{{ url('get-quote') }}" style="background-color:#ffe400; color: black;">Get a Quote</a>
                    </div>
                </div>
            </div>
        </div>
</section>