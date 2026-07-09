@include('home.include.head')
<!-- About -->
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
                                <div class="section-title-wrap d-flex justify-content-center align-items-center mb-4" style="background-color:#535da1;">
                                    <img src="{{url('public/web/images/me.png')}}" class="avatar-image img-fluid" alt="">

                                    <h2 class="text-white ms-4 mb-0 p-5">About Me</h2>
                                </div>
                            </div>

                        <div class="clearfix"></div>
                            
                            <div class="row pt-5 mt-5">
                                


                    <div class="col-lg-12 col-12 mt-5 mt-lg-0">
                        <div class="about-thumb text-justify">
                            <h1 style="font-size: 30px; letter-spacing: unset;">I am Younas, a highly skilled and experienced web developer with a passion for creating innovative and effective digital solutions for businesses and entrepreneurs.</h1><br>
<p>I specialize in web development and digital product creation, offering a wide range of services to help clients achieve their online goals. With several years of experience in the field, I have a proven track record of delivering high-quality, professional results for a variety of clients. I have worked on a wide range of projects, including ecommerce websites, hotel booking platforms, and mobile apps, as well as custom software development and website optimization. My expertise in PHP, Laravel and Codeigniter, JavaScript, and HTML/CSS allows me to create fully-functional and responsive websites that are optimized for search engines and user experience.</p>
<p>I am dedicated to providing excellent customer service and am always willing to go the extra mile to ensure that my clients are completely satisfied with the final product. I work closely with clients to understand their unique needs and goals, and use this information to create a website or digital product that perfectly fits their business. I am also able to provide ongoing support and maintenance to ensure that the website or product remains up-to-date and fully functional.</p>
<h5>My Services Include:</h5>
<ul>
  <li>Website development: Whether you need a basic website, an ecommerce platform, or a custom web application, I have the skills and experience to create a website that meets your needs.</li>
  <li>Digital product creation: I can help you create a digital product, such as a mobile app or custom software, that will help you achieve your business goals.</li>
  <li>Website optimization: I can help you improve the performance and user experience of your website, as well as optimize it for search engines.</li>
  <li>Ongoing support and maintenance: I am available to provide ongoing support and maintenance for your website or digital product, ensuring that it remains up-to-date and fully functional.</li>
</ul>
<p>My hourly rate is $50 and I offer project-based pricing, depending on the scope and complexity of the project. I am also available for hire on Upwork and Fiverr, and can be contacted through my website or LinkedIn for further information.</p>


                            

                            <div class="footer row">
                        <div class="large-5 large-centered columns">
                            <p class="links">
                                <a target="_blank" href="{{ url('get-quote') }}" title="Quote">
                                            <img src="{{url('public/web/images/request-a-quote.jpg')}}" class="img-fluid" style="width: 10%; height:10%;" alt="Request a Quote">
                                        </a>

                                        <a target="_blank" href="https://www.upwork.com/freelancers/~01d6e1105ca9f0b977" title="Upwork">
                                            <img src="{{url('public/web/images/upwork.png')}}" class="img-fluid" style="width: 8%; height:8%;" alt="upwork">
                                        </a>

                                        <a target="_blank" href="https://www.fiverr.com/younasphp?up_rollout=true" title="Fiverr">
                                        <img src="{{url('public/web/images/fiverr.png')}}" class=" img-fluid" style="width: 9%; height:9%;" alt="fiverr">
                                        </a>

                                        <a target="_blank" href="https://www.linkedin.com/in/younasdev/" title="Linkedin">
                                        <img src="{{url('public/web/images/linkedin.png')}}" class=" img-fluid" style="width: 7%; height:7%;" alt="linkedin">
                                        </a>
                            </p>
                        </div>
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