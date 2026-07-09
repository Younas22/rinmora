<?php

namespace App\Http\Controllers\sitemap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Carbon\Carbon;
use DB;

class SitemapXmlController extends Controller
{
       public function index() {
        $blogs = BlogPost::join('blog_categories', 'blog_posts.category_id', '=', 'blog_categories.id')
            ->select('blog_posts.*', 'blog_categories.name')
            ->get();

        return response()->view('sitemap.sitemap', [
            'blogs' => $blogs
        ])->header('Content-Type', 'text/xml');
      }
}
