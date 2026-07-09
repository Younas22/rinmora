@include('home.include.head')
<!-- products -->
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
            <div class="col-lg-12 col-12 mx-auto">
                <div class="col-lg-12 col-md-12 col-12 mb-5 page_header">
                    <!-- <a href="index.html">
                        <img src="images/arrow.png" width="50" height="50" class="mb-2">
                    </a> -->
                    <div class="section-title-wrap d-flex justify-content-center align-items-center mb-4" style="background-color:#535da1;">
                        <img src="images/white-desk-work-study-aesthetics.jpg" class="avatar-image img-fluid d-none" alt="">
                        <h2 class="text-white ms-4 mb-0 p-5">Products</h2>
                    </div>
                </div>
                <div class="clearfix"></div>
                <p class="text-center mt-5 pt-5 mb-5">Browse our selection of premium products</p>
                <div class="row pt-lg-5">
                    
                    <div class="col-lg-4 col-12">
                        <div class="services-thumb border-dark">
                            <div class="d-flex flex-wrap align-items-center border-bottom mb-4 pb-3">
                                <h6 class="mb-0">Blog Script</h6>
                                <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">$20</p>
                                    <div class="services-price-overlay"></div>
                                </div>
                            </div>
                            <p>Are you looking to start your own blog? Our Blog Script is a powerful and user-friendly platform for creating and managing your own blog. With features such as customizable templates, SEO optimization, and easy integration with social media, it's the perfect solution for bloggers of all levels.  Get started on your blogging journey today by clicking the link below.</p>
                            <a href="#" class="custom-btn custom-border-btn_ btn mt-3"style="background-color:#535da1; color: white;">Details</a>
                            <div class="services-icon-wrap d-flex justify-content-center align-items-center">
                                <i class="services-icon bi-globe"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="services-thumb border-dark">
                            <div class="d-flex flex-wrap align-items-center border-bottom mb-4 pb-3">
                                <h6 class="mb-0">Web Design Mastery</h6>
                                <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">$5</p>
                                    <div class="services-price-overlay"></div>
                                </div>
                            </div>
                            <p>"Web Design Mastery: 80 Lessons to Build Your Skills and Get an Internship" is a comprehensive guide for beginners to learn web designing and increase their chances of getting an internship opportunity. The book is designed to cover the fundamentals of web design and provide practical tips and strategies for landing an internship in the field.</p>
                            <a href="#" class="custom-btn custom-border-btn_ btn mt-3"style="background-color:#535da1; color: white;">Details</a>
                            <div class="services-icon-wrap d-flex justify-content-center align-items-center">
                                <i class="services-icon bi-laptop"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="services-thumb border-dark">
                            <div class="d-flex flex-wrap align-items-center border-bottom mb-4 pb-3">
                                <h6 class="mb-0">e-Books</h6>
                                <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">$1</p>
                                    <div class="services-price-overlay"></div>
                                </div>
                            </div>
                            <p>Expand your knowledge on a variety of topics with our e-books. Our e-books cover a wide range of topics such as web development, marketing, SEO, business, self-help, and ChatGPT. They are convenient and easy to access, making them the perfect resource for those who want to learn on the go. Click the link below to purchase our e-books today.</p>
                            <a href="#" class="custom-btn custom-border-btn_ btn mt-3"style="background-color:#535da1; color: white;">Details</a>
                            <div class="services-icon-wrap d-flex justify-content-center align-items-center">
                                <i class="services-icon bi-book"></i>
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