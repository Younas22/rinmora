<?php

namespace App\Http\Controllers;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class PagesController extends Controller
{
public function home()
{
    $seo = [
        'title' => 'Younas Dev - Launch Your Limo Business in 7 Days | AI-Powered Business Solutions',
        'description' => 'Professional limo business setup services by Younas Dev. Complete done-for-you solution with AI calling bot, booking system, and website. Launch in just 7 days!',
        'keywords' => 'limo business setup, AI calling bot, business automation, transportation software, booking system, Younas Dev, limousine business',
        'img' => asset('public/assets/images/profile-pic.png'),
        'url' => 'https://younasdev.com'
    ];

    $schema = [
        'person' => [
            "@context" => "https://schema.org",
            "@type" => "Person",
            "name" => "Younas Dev",
            "url" => "https://younasdev.com",
            "image" => asset('public/assets/images/profile-pic.png'),
            "jobTitle" => "Web Developer, AI Expert",
            "description" => "Professional limo business setup services with AI integration",
            "knowsAbout" => ["Limo Business Setup", "AI Calling Bots", "Business Automation", "Web Development"],
            "offers" => [
                [
                    "@type" => "Service",
                    "name" => "Limo Business Setup",
                    "description" => "Complete done-for-you limo business setup with website, booking system, and AI integration",
                    "provider" => [
                        "@type" => "Person",
                        "name" => "Younas Dev"
                    ]
                ],
                [
                    "@type" => "Service",
                    "name" => "AI Calling Bot",
                    "description" => "24/7 automated calling bot for customer bookings and follow-ups",
                    "provider" => [
                        "@type" => "Person",
                        "name" => "Younas Dev"
                    ]
                ]
            ],
            "contactPoint" => [
                "@type" => "ContactPoint",
                "telephone" => "+1-555-123-4567",
                "contactType" => "Customer Service",
                "email" => "hello@younasdev.com"
            ],
            "sameAs" => [
                "https://linkedin.com/in/younasdev",
                "https://twitter.com/younasdev"
            ]
        ],
        'business' => [
            "@context" => "https://schema.org",
            "@type" => "LocalBusiness",
            "name" => "Younas Dev - Web Developer, AI Expert",
            "description" => "Professional limo business setup services with AI integration and automation",
            "url" => "https://younasdev.com",
            "telephone" => "+1-555-123-4567",
            "email" => "hello@younasdev.com",
            "founder" => [
                "@type" => "Person",
                "name" => "Younas Dev"
            ],
            "serviceArea" => [
                "@type" => "Place",
                "name" => "Worldwide"
            ],
            "hasOfferCatalog" => [
                "@type" => "OfferCatalog",
                "name" => "Business Setup Services",
                "itemListElement" => [
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Starter Package",
                            "description" => "Basic limo business setup with website and booking system"
                        ],
                        "price" => "1497",
                        "priceCurrency" => "USD"
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Professional Package",
                            "description" => "Complete business solution with AI calling bot"
                        ],
                        "price" => "2497",
                        "priceCurrency" => "USD"
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "Service",
                            "name" => "Enterprise Package",
                            "description" => "Advanced solution with custom integrations and analytics"
                        ],
                        "price" => "3997",
                        "priceCurrency" => "USD"
                    ]
                ]
            ]
        ]
    ];

    return view('pages.home', compact('seo', 'schema'));
}


 
        public function about()
    {
        $seo = [
            'title' => 'Senior Laravel Developer | Younas Dev – Web & API Expert',
            'description' => 'Hire Younas Dev — a senior Laravel developer with 5+ years of experience in building scalable, secure web applications, APIs, and SaaS platforms. Let\'s build something great!',
            'keywords' => 'Laravel developer, PHP expert, backend developer, API integration, SaaS developer, secure web development, Web developer in Lahore',
            'img' => asset('public/assets/images/profile-pic.png'),
        ];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'Younas Dev',
            'jobTitle' => 'Senior Laravel Developer',
            'url' => url('/about'),
            'sameAs' => [
                'https://github.com/younas22',     // update as needed
                'https://linkedin.com/in/younasdev' // update as needed
            ],
            'image' => asset('public/assets/images/profile-pic.png'),
            'description' => 'Younas Dev is a senior Laravel developer with 5+ years of experience in PHP, Laravel, API development, and SaaS applications.',
            'worksFor' => [
                '@type' => 'Organization',
                'name' => 'Younas Dev',
                'url' => url('/')
            ],
            'email' => 'mailto:hello@younasdev.com',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Lahore',
                'addressCountry' => 'Pakistan'
            ]
        ];

        return view('pages.about', compact('seo', 'schema'));
    }


    public function contact()
    {
        $seo = [
            'title' => 'Contact Laravel Expert | Younas Dev – Hire Today',
            'description' => 'Get in touch with Laravel expert Younas Dev for scalable web apps, APIs & AI solutions. Fast response guaranteed. Book a free consultation today!',
            'keywords' => 'Laravel developer contact, hire Laravel expert, web developer Lahore, Younas Dev contact, API developer, PHP expert contact',
            'img' => asset('assets/images/profile-pic.png'),
        ];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'mainEntity' => [
                '@type' => 'LocalBusiness',
                'name' => 'Younas Dev',
                'image' => asset('assets/images/profile-pic.png'),
                'url' => url('/contact'),
                'email' => 'mailto:hello@younasdev.com',
                'telephone' => '+923460820722',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Lahore',
                    'addressCountry' => 'PK'
                ],
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => '+923460820722',
                    'contactType' => 'Customer Service',
                    'areaServed' => 'PK',
                    'availableLanguage' => ['English', 'Urdu']
                ],
                'sameAs' => [
                    'https://github.com/younas22',
                    'https://linkedin.com/in/younasdev'
                ]
            ]
        ];

        return view('pages.contact', compact('seo', 'schema'));
    }

 
    public function services()
    {
        $seo = [
            'title' => 'Laravel Web & AI Services | Hire Younas Dev Today',
            'description' => 'Custom Laravel web, API & AI solutions by Younas Dev. Scalable, secure, and fast. Book a free call to start your project today!',
            'keywords' => 'Laravel developer, API integration, SaaS solutions, PHP expert, AI development, web development, hire Laravel developer',
            'img' => asset('public/assets/images/profile-pic.png'),
        ];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => 'Younas Dev',
            'image' => asset('public/assets/images/profile-pic.png'),
            'url' => url('/services'),
            'description' => 'Custom Laravel development, API integration, and AI-powered solutions for startups and enterprises. Hire a seasoned developer with 5+ years experience.',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Lahore',
                'addressCountry' => 'PK'
            ],
            'telephone' => '+923460820722',
            'email' => 'hello@younasdev.com',
            'priceRange' => '$$$',
            'areaServed' => 'Global',
            'founder' => [
                '@type' => 'Person',
                'name' => 'Younas Dev'
            ],
            'sameAs' => [
                'https://github.com/younas22',
                'https://linkedin.com/in/younasdev'
            ]
        ];

        return view('pages.services', compact('seo', 'schema'));
    }


    public function servicedetail($slug)
    {
        $seo = [
            'title' => 'Our services',
            'description' => 'Explore the services we have completed for clients.',
            'keywords' => 'services, portfolio, work',
        ];
        // Assuming $services = service::latest()->paginate(10);
        return view('pages.servicedetail', compact('seo'));
    }

    public function projects()
    {
        $seo = [
            'title' => 'Laravel Developer Portfolio | Younas Dev Projects',
            'description' => 'Explore real Laravel projects by Younas Dev: SaaS apps, APIs, booking platforms & dashboards. Built with performance & scale in mind.',
            'keywords' => 'Laravel portfolio, web development projects, SaaS projects, PHP developer work, API integrations, dashboard systems',
            'img' => asset('public/assets/images/profile-pic.png'),
        ];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            'name' => 'Younas Dev Projects',
            'headline' => 'Recent Laravel Projects by Younas Dev',
            'description' => 'View Laravel and PHP projects developed by Younas Dev including SaaS apps, travel platforms, HR systems, and eCommerce tools.',
            'creator' => [
                '@type' => 'Person',
                'name' => 'Younas Dev',
                'jobTitle' => 'Senior Laravel Developer',
                'url' => url('/'),
                'image' => asset('public/assets/images/profile-pic.png'),
                'email' => 'mailto:hello@younasdev.com',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Lahore',
                    'addressCountry' => 'PK'
                ],
                'sameAs' => [
                    'https://github.com/younas22',
                    'https://linkedin.com/in/younasdev'
                ]
            ],
            'url' => url('/projects'),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Younas Dev',
                'url' => url('/')
            ],
            'mainEntityOfPage' => url('/projects')
        ];

        return view('pages.projects', compact('seo', 'schema'));
    }


    

public function projectdetail($slug)
{
    $projects = json_decode(file_get_contents('project.json'), true);
    $slug = $slug ?? '';
    $searchTitle = ucwords(str_replace('-', ' ', $slug));
    $project = null;

    foreach ($projects as $item) {
        if (strtolower($item['title']) === strtolower($searchTitle)) {
            $project = $item;
            break;
        }
    }

    if (!$project) {
        return redirect()->route('projects')->with('error', 'Project not found.');
    }

    $seo = [
        'title' => $project['title'] . ' – Laravel Costom Project | Younas Dev',
        'description' => substr($project['short_detail'], 0, 160),
        'keywords' => implode(', ', $project['tech_stack']) . ', ' . $project['title'],
        'img' => asset('public/assets/images/project/' . $project['image'])
    ];

    $schema = [
        "@context" => "https://schema.org",
        "@type" => "SoftwareApplication",
        "name" => $project['title'],
        "operatingSystem" => "Web",
        "applicationCategory" => "BusinessApplication",
        "url" => $project['link'],
        "description" => $project['short_detail'],
        "creator" => [
            "@type" => "Person",
            "name" => "Younas Dev"
        ],
        "offers" => [
            "@type" => "Offer",
            "price" => "0.00",
            "priceCurrency" => "USD"
        ],
        "aggregateRating" => [
            "@type" => "AggregateRating",
            "ratingValue" => "5",
            "reviewCount" => "3"
        ]
    ];


    return view('pages.projectdetail', compact('seo', 'project', 'schema'));
}


    public function products()
    {
        $seo = [
            'title' => 'Our Products',
            'description' => 'Discover our range of quality products.',
            'keywords' => 'products, ecommerce, items',
        ];
        // Assuming $products = Product::latest()->paginate(10);
        return view('pages.products', compact('seo'));
    }
    

    public function productdetail($slug)
    {
        $seo = [
            'title' => 'Our Products',
            'description' => 'Discover our range of quality products.',
            'keywords' => 'products, ecommerce, items',
        ];
        // Assuming $products = Product::latest()->paginate(10);
        return view('pages.productdetail', compact('seo'));
    }

public function sitemap()
{
    $seo = [
        'title' => 'Website Sitemap - All Pages & URLs',
        'description' => 'Explore a complete sitemap of all website pages, services, and blog posts for easy navigation.',
        'keywords' => 'sitemap, website pages, page list, navigation, SEO',
        'img' => 'sitemap.png', // Optional image
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'SiteNavigationElement',
        'name' => 'Website Sitemap',
        'description' => 'List of all accessible pages and sections of the website',
        'url' => url('/sitemap'),
    ];

    return view('pages.sitemap', compact('seo', 'schema'));
}


    public function faq()
{
    $seo = [
        'title' => 'FAQs - Frequently Asked Questions',
        'description' => 'Get answers to frequently asked questions about services, process, and more.',
        'keywords' => 'FAQ, questions, answers, help, support, guide',
        'img' => 'faq.png', // Optional image
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'What services do you offer?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'I offer web development, API development, AI solutions, and system integration.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'How can I contact you?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'You can contact me via email at hello@younasdev.com or call at +92 346 0820722.'
                ]
            ],
            [
                '@type' => 'Question',
                'name' => 'Are you available for new projects?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes, I’m currently available and accepting new projects.'
                ]
            ]
        ]
    ];

    return view('pages.faq', compact('seo', 'schema'));
}



    public function blog(Request $request) 
    {
    $seo = [
        'title' => 'Laravel Developer Blog | Younas Dev Insights',
        'description' => 'Read Laravel tutorials, dev tips, and web insights by Younas Dev. Learn modern PHP, APIs, and real-world use cases. Subscribe for updates!',
        'keywords' => 'Laravel blog, PHP tutorials, API development, Laravel tips, Younas Dev blog, web development blog',
        'img' => asset('public/assets/images/profile-pic.png'),
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        'name' => 'Younas Dev Blog',
        'url' => url('/blogs'),
        'description' => 'Laravel tutorials, developer experiences, and technical insights by Younas Dev. Covering web development, APIs, and modern PHP practices.',
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Younas Dev',
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('public/assets/images/profile-pic.png')
            ]
        ],
        'author' => [
            '@type' => 'Person',
            'name' => 'Younas Dev',
            'url' => url('/'),
            'image' => asset('public/assets/images/profile-pic.png'),
            'email' => 'mailto:hello@younasdev.com',
            'sameAs' => [
                'https://github.com/younas22',
                'https://linkedin.com/in/younasdev'
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Lahore',
                'addressCountry' => 'PK'
            ]
        ],
        'mainEntityOfPage' => url('/blogs')
    ];


        // Get featured post (most recent or manually featured)
        $featuredPost = BlogPost::with(['category', 'author'])
                              ->where('status', 'published')
                              ->where('is_featured', true)
                              ->latest('published_at')
                              ->first();

        if (!$featuredPost) {
            $featuredPost = BlogPost::with(['category', 'author'])
                                  ->where('status', 'published')
                                  ->latest('published_at')
                                  ->first();
        }

        // Get initial blog posts (excluding featured post)
        $query = BlogPost::with(['category', 'author'])
                        ->where('status', 'published');
        
        if ($featuredPost) {
            $query->where('id', '!=', $featuredPost->id);
        }

        // Apply filters
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->latest('published_at')->paginate(9);
        
        // Get all active categories that have blog posts
        $categories = BlogCategory::has('posts')
                            ->whereHas('posts', function($query) {
                                $query->where('status', 'published');
                            })
                            ->withCount(['posts' => function($query) {
                                $query->where('status', 'published');
                            }])
                            ->get();

        // Get blog stats
        $stats = [
            'total_posts' => BlogPost::where('status', 'published')->count(),
            'total_views' => BlogPost::where('status', 'published')->sum('views_count'),
            'total_categories' => $categories->count()
        ];
        
        return view('pages.blog', compact('blogs', 'categories', 'featuredPost', 'stats', 'seo','schema'));
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        
        $query = BlogPost::with(['category', 'author'])
                        ->where('status', 'published');

        // Exclude featured post from load more results
        if ($request->has('exclude_featured') && $request->exclude_featured) {
            $featuredPost = BlogPost::where('status', 'published')
                                  ->where('is_featured', true)
                                  ->latest('published_at')
                                  ->first();
            
            if (!$featuredPost) {
                $featuredPost = BlogPost::where('status', 'published')
                                      ->latest('published_at')
                                      ->first();
            }
            
            if ($featuredPost) {
                $query->where('id', '!=', $featuredPost->id);
            }
        }

        // Apply filters
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->latest('published_at')->paginate(9, ['*'], 'page', $page);

        if ($request->ajax()) {
            $html = view('common.blog-cards', compact('blogs'))->render();
            
            return response()->json([
                'html' => $html,
                'has_more' => $blogs->hasMorePages(),
                'next_page' => $blogs->currentPage() + 1
            ]);
        }

        return redirect()->route('blog');
    }


    public function blogdetail($slug)
{
    $post = BlogPost::with(['category', 'author', 'tags', 'comments.author'])
                   ->where('slug', $slug)
                   ->where('status', 'published')
                   ->firstOrFail();

    // Increment views
    $post->incrementViews();

    // Get related posts
    $relatedPosts = BlogPost::with(['category', 'author'])
                          ->where('status', 'published')
                          ->where('id', '!=', $post->id)
                          ->where('category_id', $post->category_id)
                          ->latest('published_at')
                          ->limit(3)
                          ->get();

    $seo = [
        'title' => $post->seo_title ?: $post->title,
        'description' => $post->meta_description ?: $post->excerpt,
        'keywords' => $post->tags->pluck('name')->implode(', '),
        'img' => $post->featured_image ? asset('storage/app/public/' . $post->featured_image) : null,
    ];

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => url()->current()
        ],
        'headline' => $post->title,
        'description' => $seo['description'],
        'image' => $post->featured_image ? asset('storage/app/public/' . $post->featured_image) : null,
        'author' => [
            '@type' => 'Person',
            'name' => $post->author->name ?? 'Younas Dev'
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Younas Dev',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('public/assets/images/profile-pic.png') // Update logo path if needed
            ]
        ],
        'datePublished' => $post->published_at 
                ? Carbon::parse($post->published_at)->toIso8601String() 
                : null,

            'dateModified' => $post->updated_at 
                ? Carbon::parse($post->updated_at)->toIso8601String() 
                : null,
            ];

    return view('pages.blogdetails', compact('post', 'relatedPosts', 'seo', 'schema'));
}

public function sitemapxml()
{
    $projects = json_decode(file_get_contents('project.json'), true);
    $posts = BlogPost::where('status', 'published')->latest()->get();
    $content = view('pages.sitemapxml', compact('posts','projects'));
    return Response::make($content, 200)->header('Content-Type', 'application/xml');
}

}
