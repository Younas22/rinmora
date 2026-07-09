@include('home.include.head')
<!-- services -->
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

                                    <h2 class="text-white ms-4 mb-0 p-5">Services</h2>
                                </div>
                            </div>

                        <div class="clearfix"></div>
                            <p class="text-center mt-5 pt-5 mb-5">Learn about the range of services we offer to help your business succeed</p>
                            <div class="row pt-lg-5">

                                                    <div class="col-lg-6 col-12">
                        <div class="services-thumb">
                            <div class="d-flex flex-wrap align-items-center border-bottom mb-4 pb-3">
                                <h3 class="mb-0">Websites</h3>
                                {{-- <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">$1000</p>
                                    <div class="services-price-overlay"></div>
                                </div> --}}
                            </div>
                            <p>Our web development services include the design, creation, and maintenance of websites. We can work with you to develop a website from scratch or update an existing one. Our team is proficient in a variety of programming languages and frameworks, including HTML, CSS, JavaScript, and PHP. We also have experience with content management systems such as WordPress and can assist with the integration of various features and functionalities.</p>
                            <a href="{{ url('service/website') }}" class="custom-btn custom-border-btn_ btn mt-3" style="background-color:#535da1; color: white;">Details</a>
                            <div class="services-icon-wrap d-flex justify-content-center align-items-center">
                                <i class="services-icon bi-globe"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="services-thumb services-thumb-up">
                            <div class="d-flex flex-wrap align-items-center border-bottom mb-4 pb-3">
                                <h3 class="mb-0">Marketing</h3>
                                {{-- <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">$500</p>
                                    <div class="services-price-overlay"></div>
                                </div> --}}
                            </div>
                            <p>Our marketing services aim to help you promote your business and increase brand awareness. We offer a range of marketing strategies, including social media marketing, email marketing, and content marketing. We can also help you with market research and analysis to better understand your target audience and how to effectively reach them.</p>
                            <a href="{{ url('service/marketing') }}" class="custom-btn custom-border-btn_ btn mt-3"  style="background-color:#535da1; color: white;">Details</a>
                            <div class="services-icon-wrap d-flex justify-content-center align-items-center">
                                <i class="services-icon bi-lightbulb"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="services-thumb">
                            <div class="d-flex flex-wrap align-items-center border-bottom mb-4 pb-3">
                                <h3 class="mb-0">SEO</h3>
                                {{-- <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">$700</p>
                                    <div class="services-price-overlay"></div>
                                </div> --}}
                            </div>
                            <p>Our SEO (Search Engine Optimization) services help to improve the visibility and ranking of your website in search engines like Google. We can optimize your website's content, structure, and technical aspects to make it more attractive to search engines and improve its ranking in search results.</p>
                            <a href="{{ url('service/SEO') }}" class="custom-btn custom-border-btn_ btn mt-3"  style="background-color:#535da1; color: white;">Details</a>
                            <div class="services-icon-wrap d-flex justify-content-center align-items-center">
                                <i class="services-icon bi-google "></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="services-thumb services-thumb-up">
                            <div class="d-flex flex-wrap align-items-center border-bottom mb-4 pb-3">
                                <h3 class="mb-0">Support</h3>
                                {{-- <div class="services-price-wrap ms-auto">
                                    <p class="services-price-text mb-0">$100</p>
                                    <div class="services-price-overlay"></div>
                                </div> --}}
                            </div>
                            <p>Our support services include assistance with technical issues and troubleshooting for your website or other online resources. We can also provide guidance and advice on how to best use and maintain your online assets. Our team is available to answer your questions and provide support as needed.</p>
                            <a href="{{ url('service/support') }}" class="custom-btn custom-border-btn_ btn mt-3"  style="background-color:#535da1; color: white;">Details</a>
                            <div class="services-icon-wrap d-flex justify-content-center align-items-center">
                                <i class="services-icon bi-phone"></i>
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