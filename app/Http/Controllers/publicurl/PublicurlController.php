<?php
namespace App\Http\Controllers\publicurl;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use Hash;
use Ramsey\Uuid\Uuid;

class PublicurlController extends Controller
{
       public function publicurl()
    {
        return view('hr.publicurl',get_defined_vars());
    }
       public function customer_service()
    {
        $title = "Contact us";
        $image = "";
        $keywords = "contact, contact us, customer service, support, inquiries, questions";
        $meta_title = 'Contact Us - Get in Touch with Our Customer Service Team';
        $meta_description = "Need assistance or have a question? Contact our customer service team for support and inquiries. We're here to help you with any questions you may have.";
        return view('hr.gethelp',get_defined_vars());
    }

       public function buy_now()
    {
        $title = "Buy Now";
        $image = "";
        $keywords = "buy now, blog script, web design mentorship program, e-books";
        $meta_title = 'Buy Now - Get Your Hands on a High-Quality Blog Script, Join Our Web Design Mentorship Program, and Learn from Our Expert-Authored e-Books';
        $meta_description = 'Want to take your website to the next level? Buy now and gain access to our high-quality blog script, join our web design mentorship program, and learn from our expert-authored e-books. Make your website stand out and achieve success online.';
        $products = DB::table('products')->get();
        $product_b = DB::table('products')->where('id',1)->first();
        $product_s = DB::table('products')->where('id',2)->first();


        $booking_details = DB::table('products_detials')->where('product_id',1)->get();
        $code_details = DB::table('products_detials')->where('product_id',2)->first();

        $services = DB::table('services')->get();

        return view('products.getproducts',get_defined_vars());
    }

       public function order_now()
    {
        $title = "Order Now";
        $image = "";
        $keywords = "buy now, blog script, web design mentorship program, e-books";
        $meta_title = 'Buy Now - Get Your Hands on a High-Quality Blog Script, Join Our Web Design Mentorship Program, and Learn from Our Expert-Authored e-Books';
        $meta_description = 'Want to take your website to the next level? Buy now and gain access to our high-quality blog script, join our web design mentorship program, and learn from our expert-authored e-books. Make your website stand out and achieve success online.';
        $product_cat = DB::table('cat')->get();
        $booking_details = DB::table('products_detials')->where('product_id',1)->get();


        return view('products.books_order',get_defined_vars());
    }

       public function get_quote()
    {
        $title = "Get Quote | Free";
        $image = "";
        $keywords = "web development, marketing, SEO, support, quote";
        $meta_title = 'Get a Quote for Web Development, Marketing, SEO, and Support Services';
        $meta_description = 'Looking for a quote for web development, marketing, SEO, or support services? Fill out our form and we will provide you with a customized quote for your specific needs. Trust our team of experts to help take your business to the next level.';
        $products = DB::table('products')->get();
        $product_b = DB::table('products')->where('id',1)->first();
        $product_s = DB::table('products')->where('id',2)->first();
        $product_c = DB::table('products')->where('id',3)->first();

        $booking_details = DB::table('products_detials')->where('product_id',1)->get();
        $code_details = DB::table('products_detials')->where('product_id',2)->first();
        $course_details = DB::table('products_detials')->where('product_id',3)->first();
        $services = DB::table('services')->get();
        return view('service.getservice',get_defined_vars());
    }



        public function test_view()
    {
        return view('test_view.test_view',get_defined_vars());
    }
}