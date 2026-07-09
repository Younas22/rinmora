<?php
namespace App\Http\Controllers\home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Carbon\Carbon;
use DB;


class HomeController extends Controller
{
       public function index()
    {
        $title = 'Home';
        $image = "";
        $keywords = "web developer, digital solutions, ecommerce websites, hotel booking platforms, mobile apps, custom software development, website optimization, PHP, Laravel, Codeigniter, JavaScript, HTML/CSS, customer service, ongoing support and maintenance";
        $meta_title = 'Web Development and Digital Product Creation Services - Younas Dev';
        $meta_description = 'Younas Dev is a highly skilled and experienced web developer, specializing in web development and digital product creation. I can help you achieve your online goals. Contact me for a free consultation today.';
        $posts = BlogPost::join('blog_categories', 'blog_posts.category_id', '=', 'blog_categories.id')
            ->select('blog_posts.*', 'blog_categories.name')
            ->paginate(4);

        return view('home.index',get_defined_vars());
    }
       public function about()
    {
        $title = 'About';
        $image = url('public/web/images/about-younas-dev.png');
        $keywords = "web developer, digital solutions, ecommerce websites, hotel booking platforms, mobile apps, custom software development, website optimization, PHP, Laravel, Codeigniter, JavaScript, HTML/CSS, customer service, ongoing support and maintenance";
        $meta_title = 'Web Developer Younas - Innovative and Effective Digital Solutions';
        $meta_description = 'Looking for a highly skilled and experienced web developer? Look no further than Younas. Specializing in web development and digital product creation, I offer a wide range of services to help businesses and entrepreneurs achieve their online goals. With a proven track record of delivering high-quality results, I am dedicated to providing excellent customer service and ongoing support. Contact me for more information.';
        return view('home.about',get_defined_vars());
    }


       public function services()
    {
        $title = 'Services';
        $image = "";
        $keywords = "Web development, Website Design, Website Creation, Website Maintenance, Programming Languages, HTML, CSS, JavaScript, PHP, Content Management Systems, WordPress, Marketing, Social Media Marketing, Email Marketing, Content Marketing, Market Research, SEO, Search Engine Optimization, Visibility, Website Ranking, Support, Technical Support, Troubleshooting, Website Downtime, Broken Links, Website Updates, Backups, Website Security, Monitoring, Training, Education, Technical Assistance, Guidance, Advice";
        $meta_title = 'Our Services | Web Development, Marketing, SEO, and Support';
        $meta_description = 'Explore our services: web development, marketing, SEO and support. We offer a range of services including website design and creation, programming languages, content management systems, market research, social media marketing, email marketing, content marketing, search engine optimization, technical support, troubleshooting, website updates and backups, training, education, technical assistance and guidance. Contact us today to learn more about how we can help you achieve your goals.';

        return view('home.services',get_defined_vars());
    }

       public function service_details(Request $request)
    {
        $name = $request->name;
        if ($name == 'website') {
            $title = 'Boost Your Business with Custom Website Development Services';
            $image = "";
            $img = DB::table('services')->where('name','Website')->first()->image;
            $keywords = "web development, website design, website creation, website maintenance, programming languages, HTML, CSS, JavaScript, PHP, content management systems, WordPress, website features, website functionalities.";
            $meta_title = 'Web Development Services | Design, Creation, and Maintenance';
            $meta_description = 'Boost online pres. w/ web dev services: design, creation, maintenance, blog & social network. Specialized in website optimization & support.';
            $details = "Are you looking to take your business to the next level? Look no further than our custom website development services! We understand that every business is unique and requires a website that reflects that. That's why we offer tailored solutions that are customized to meet the specific needs of your business.
              <p>Our team of experienced developers is well-versed in the latest technologies, including <strong>Bootstrap 4</strong>, to create a website that not only looks great, but also performs well. We take the time to understand your business, your customers, and your goals, to create a website that will help you achieve success.</p>
              <h3>What We Offer:</h3>
              <ul>
                <li><strong>Responsive Design:</strong> We understand the importance of having a website that looks great on any device, which is why we use responsive design techniques to ensure that your website looks and works great on desktop computers, tablets, and mobile phones.</li>
                <li><strong>SEO Optimization:</strong> We know that a great website is nothing without good SEO optimization, which is why we ensure that your website is optimized for search engines, to help you reach more customers and boost your online visibility.</li>
                <li><strong>Scalable Solutions:</strong> We understand that your business will grow and change over time, which is why we create scalable solutions that can grow with your business. Whether you need to add new features or expand to new markets, our solutions are designed to adapt to your changing needs.</li>
                <li><strong>Affordable Prices:</strong> We believe that custom website development services should be accessible to all businesses, which is why we offer affordable prices that are tailored to meet your budget.</li>
              </ul>
              <p>Don't let your website hold you back! Contact us today to learn more about our custom website development services and how we can help you boost your business and achieve success online!</p>";


            $shareComponent = \Share::page(url('service/website'), 'Boost Your Business with Custom Website Development Services')
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->telegram()
            ->reddit();
        }

        if ($name == 'marketing') {
            $title = 'Boost Your Business with Our Professional Marketing Services';
            $image = "";
            $img = DB::table('services')->where('name','Marketing')->first()->image;
            $keywords = "marketing strategies, social media marketing, email marketing, content marketing, market research, market analysis, target audience, brand awareness";
            $meta_title = 'Marketing Services | Social Media, Email, Content Marketing and Market Research';
            $meta_description = 'Maximize your biz impact w/our Marketing services. Social media, email, content mktg & research to reach target audience & drive results. Contact us.';
            $details = "Are you looking for ways to increase your business's visibility and reach more customers? Look no further than our professional marketing services. We have a team of experts who are dedicated to helping businesses like yours achieve their marketing goals and grow their customer base.</p>
              <h3>What We Offer:</h3>
              <ul>
                <li><strong>Search Engine Optimization (SEO):</strong> Our team of SEO experts will work with you to improve your website's visibility on search engines like Google, Bing, and Yahoo. We will optimize your website's content and structure to increase your search engine rankings and drive more traffic to your site.</li>
                <li><strong>Social Media Marketing:</strong> We will help you create and implement a social media marketing strategy that will increase your brand's visibility on platforms like Facebook, Instagram, and Twitter. We will help you create engaging content, manage your accounts, and grow your following.</li>
                <li><strong>Pay-Per-Click (PPC) Advertising:</strong> Our team will work with you to create and manage PPC campaigns on platforms like Google Ads and Bing Ads. We will help you target the right audience, create effective ad copy, and measure the success of your campaigns.</li>
                <li><strong>Email Marketing:</strong> We will help you design and send email campaigns that will help you connect with your customers and increase sales. We will help you create effective subject lines, design visually appealing emails, and target the right audience.</li>
              </ul>
              <p>Our goal is to help you reach your target audience, increase your visibility, and drive more sales. We will work with you to create a customized marketing plan that meets your specific needs and budget. Whether you're a small business just starting out or a large corporation looking to expand your reach, we have the expertise and experience to help you succeed.</p>
              <p>Don't wait any longer to take your business to the next level. Contact us today to learn more about how our professional marketing services can help you achieve your goals and boost your business. We're excited to work with you and help you succeed!";


        $shareComponent = \Share::page(url('service/marketing'), 'Boost Your Business with Our Professional Marketing Services')
        ->facebook()
        ->twitter()
        ->linkedin()
        ->whatsapp()
        ->telegram()
        ->reddit();

            }

            if ($name == 'SEO') {

            $title = 'Improve Your Online performance & Ranking with SEO Services';
            $image = "";
            $img = DB::table('services')->where('name','SEO')->first()->image;
            $keywords = "search engine optimization, visibility, website ranking, search engines, Google, website content, website structure, technical optimization, mobile-friendly, off-page optimization, link building, backlinks, keyword research, meta tags";
            $meta_title = "Improve Your Online performance & Ranking with SEO Services";
            $meta_description = "Boost website visibility & ranking with our SEO. Optimize content, structure & tech. Contact us for more info. Help you reach your goals.";
            $details = "Search Engine Optimization (SEO) is a crucial aspect of any website's success. It helps to increase visibility and drive more traffic to your website, which can ultimately lead to more conversions and revenue. As an experienced SEO specialist, I offer a range of services to help your website rank higher in search engine results and achieve its full potential.
              <h3>Keyword Research and Optimization</h3>
              <p>One of the most important aspects of SEO is identifying the right keywords to target. I will conduct thorough research to find the most relevant and profitable keywords for your website and then optimize your website's content and meta tags to include those keywords. This will help search engines understand what your website is about and improve its chances of ranking well for those keywords.</p>
              <h3>On-Page Optimization</h3>
              <p>On-page optimization refers to the changes that can be made to a website's content and structure to improve its chances of ranking well in search engine results. I will analyze your website's content and structure to identify areas that need improvement. This may include optimizing title tags, meta descriptions, header tags, and more. I will also ensure that your website is mobile-friendly and has a fast loading speed, as these are important factors for SEO.</p>
              <h3>Link Building</h3>
              <p>Link building is the process of getting other websites to link to your website. These links are important for SEO because search engines use them to determine the relevance and authority of your website. I will create a link building strategy that will help to increase the number of high-quality, relevant links pointing to your website. This will help to improve your website's visibility and search engine rankings.</p>
              <h3>Reporting and Analysis</h3>
              <p>To ensure that your SEO efforts are paying off, I will provide regular reporting and analysis of your website's performance. This will include detailed information on your website's traffic, search engine rankings, and more. I will also use this information to identify areas where your SEO efforts can be improved and make recommendations for how to achieve better results.</p>
              <p>In conclusion, SEO is a continuous process that requires regular monitoring and optimization. My services will not only help to improve your website's visibility, but also keep track of the progress and make necessary changes to maintain the ranking. With my experience and expertise, I can help you to achieve your business goals and reach your target audience.</p>";


        $shareComponent = \Share::page(url('service/SEO'), 'SEO Services | Improve Visibility and Ranking of Your Website')
        ->facebook()
        ->twitter()
        ->linkedin()
        ->whatsapp()
        ->telegram()
        ->reddit();

            }

            if ($name == 'support') {
            $title = "Ongoing Web Development Project Support Services";
            $image = "";
            $img = DB::table('services')->where('name','Support')->first()->image;
            $keywords = "technical support, troubleshooting, website downtime, broken links, website updates, backups, website security, monitoring, training, education, technical assistance, guidance, advice";
            $meta_title = 'Support Services | Technical Issues and Troubleshooting for Your Website';
            $meta_description = 'Get support for website with our services. Tech issues, troubleshooting, guidance & advice on website usage & maintenance. Contact us for more info.';
            $details = "As a business owner, you understand the importance of having a website that is up-to-date and functional. However, maintaining and updating a website can be time-consuming and costly. That's why we offer ongoing web development project support services to help you keep your website running smoothly and efficiently. Our team of experienced developers will work closely with you to ensure that your website is always up-to-date and meeting the needs of your business.
          <h3>1. Regular Updates and Maintenance</h3>
          <p>Our team will work with you to schedule regular updates and maintenance to your website. This includes software updates, security patches, and bug fixes to ensure that your website is always running at its best. We will also work with you to make any necessary design changes or updates to keep your website looking fresh and modern.</p>
          <h3>2. Custom Development</h3>
          <p>We understand that every business has unique needs and requirements. That's why we offer custom development services to meet the specific needs of your business. Whether you need a new feature added to your website or a complete redesign, our team will work with you to create a solution that meets your needs.</p>
          <h3>3. Support and Troubleshooting</h3>
          <p>Our team is available to provide support and troubleshoot any issues that may arise with your website. We will work with you to diagnose and resolve any problems quickly and efficiently, ensuring that your website is always up and running.</p>
          <h3>4. Responsive Design</h3>
          <p>We know that more and more people are accessing the internet on their mobile devices. That's why we use <strong>Latest Technologies</strong> in our development process to ensure that your website is fully responsive and looks great on any device. This will make sure that your website is accessible to more customers and will help to increase your visibility in the search engine results.</p>
          <p>Don't let the stress of maintaining your website take away from growing your business. Allow us to take care of the technical aspect of your website and focus on what you do best. Contact us today to learn more about our ongoing web development project support services and how we can help your business succeed.</p>";



            $shareComponent = \Share::page(url('service/support'), 'Boost Your Business with Our Professional Marketing Services')
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->telegram()
            ->reddit();
        }
        return view('home.service_details',get_defined_vars());
    }

       public function products()
    {
            $title = "Products";
            $image = "";
            $keywords = "Blog Script, Web Design Mentorship Program, e-Books, Blogging, Web Design, Coding, Learning, Books";
            $meta_title = 'Our Products | Blog Script, Web Design Mentorship Program, e-Books';
            $meta_description = 'Explore our products: Blog Script, Web Design Mentorship Program, e-Books. Get started on your blogging';
        return view('home.products',get_defined_vars());
    }

       public function projects()
    {
        $title = "Projects";
        $image = "";
        $keywords = "projects, portfolio, work, showcase, examples";
        $meta_title = 'Projects - See Our Recent Work and Portfolio';
        $meta_description = 'Explore our portfolio of projects and see examples of our work in various industries. From website design to software development, we have a diverse range of completed projects that showcase our skills and expertise.';
        return view('home.projects',get_defined_vars());
    }

       public function blogs()
    {
        $title = "Blogs";
        $image = "";
        $keywords = "blog, articles, news, information, latest updates";
        $meta_title = 'Blog - Stay Up-to-Date with the Latest News and Information';
        $meta_description = 'Keep informed with our blog featuring the latest articles and updates on a variety of topics. Stay up-to-date with the latest news and information.';

        $posts = BlogPost::join('blog_categories', 'blog_posts.category_id', '=', 'blog_categories.id')
            ->select('blog_posts.*', 'blog_categories.name')
            ->paginate(6);
        return view('home.blogs',get_defined_vars());
    }

       public function blog_details(Request $request)
    {
        
        $category = str_replace("-", " ", $request->category);
        $slug = $request->slug;
        $post_details = BlogPost::join('blog_categories', 'blog_posts.category_id', '=', 'blog_categories.id')
            ->leftJoin('seo', 'seo.blog_post_id', '=', 'blog_posts.id')
            ->select('blog_posts.*', 'blog_categories.name','seo.title as meta_title','seo.description as meta_description','seo.keywords as meta_keywords')
            ->where('blog_categories.name', $category)->where('blog_posts.slug', $slug)
            ->first();
            // dd($post_details);
        $title = $post_details->meta_title;
        $image = $post_details->featured_image;
        $keywords = $post_details->meta_keywords;
        $meta_title = $post_details->meta_title;
        $meta_description = $post_details->meta_description;


        $shareComponent = \Share::page(url($request->category.'/'.$slug),$post_details->title)
        ->facebook()
        ->twitter()
        ->linkedin()
        ->whatsapp()
        ->telegram()
        ->reddit();
        // dd($shareComponent);
        return view('home.blog_details',get_defined_vars());
    }

       public function faq()
    {
        $title = "FAQ";
        $image = "";
        $keywords = "FAQ, questions, answers, help, support, information";
        $meta_title = 'Frequently Asked Questions - Get the help you need';
        $meta_description = 'Find answers to frequently asked questions about our products and services on our FAQ page. Get the help and support you need from our team.';
        return view('home.faq',get_defined_vars());
    }

       public function testimonial()
    {
        $title = "Testimonial";
        $image = "";
        $keywords = "testimonials, customer reviews, feedback, customer satisfaction, positive reviews, satisfied customers";
        $meta_title = 'Testimonials - See What Our Satisfied Customers Have to Say';
        $meta_description = 'Check out our testimonial page to see what our satisfied customers have to say about our products and services. Read through real customer reviews and feedback to see why we have a reputation for excellent customer satisfaction. See for yourself why our customers keep coming back.';
        return view('home.testimonial',get_defined_vars());
    }

       public function contact_us()
    {
        $title = "Contact us";
        $image = "";
        $keywords = "contact, contact us, customer service, support, inquiries, questions";
        $meta_title = 'Contact Us - Get in Touch with Our Customer Service Team';
        $meta_description = "Need assistance or have a question? Contact our customer service team for support and inquiries. We're here to help you with any questions you may have.";
        return view('home.contact-us',get_defined_vars());
    }

}
