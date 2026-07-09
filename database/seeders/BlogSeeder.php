<?php
// database/seeders/BlogSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            [
                'name' => 'Destinations',
                'slug' => 'destinations',
                'description' => 'Travel destination guides and recommendations',
                'color' => '#28a745'
            ],
            [
                'name' => 'Travel Tips',
                'slug' => 'tips',
                'description' => 'Helpful travel advice and tips',
                'color' => '#dc3545'
            ],
            [
                'name' => 'Travel Guides',
                'slug' => 'travel',
                'description' => 'Complete travel guides for various locations',
                'color' => '#fd7e14'
            ],
            [
                'name' => 'Travel News',
                'slug' => 'news',
                'description' => 'Latest travel updates and news',
                'color' => '#6f42c1'
            ]
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }

        // Create tags
        $tags = [
            'travel', 'tips', 'guide', 'budget', 'luxury', 'adventure',
            'family', 'solo', 'backpacking', 'culture', 'food', 'photography'
        ];

        foreach ($tags as $tag) {
            BlogTag::create([
                'name' => ucfirst($tag),
                'slug' => $tag
            ]);
        }

        // Create sample blog posts
        $posts = [
            [
                'title' => 'Ultimate Guide to Tokyo Travel',
                'content' => 'Discover the best places to visit in Tokyo, from traditional temples to modern attractions...',
                'excerpt' => 'Discover the best places to visit in Tokyo, from traditional temples to modern attractions...',
                'category_id' => 1,
                'status' => 'published',
                'views_count' => 12450,
                'likes_count' => 234,
                'comments_count' => 67,
                'seo_score' => 95,
                'published_at' => now()->subDays(3)
            ],
            [
                'title' => '10 Money-Saving Travel Tips',
                'content' => 'Learn how to travel on a budget without compromising on experience...',
                'excerpt' => 'Learn how to travel on a budget without compromising on experience...',
                'category_id' => 2,
                'status' => 'published',
                'views_count' => 8320,
                'likes_count' => 189,
                'comments_count' => 43,
                'seo_score' => 78,
                'published_at' => now()->subDays(5)
            ]
        ];

        $admin = User::where('user_type', 'admin')->first();
        
        foreach ($posts as $postData) {
            $postData['author_id'] = $admin->id;
            $post = BlogPost::create($postData);
            $post->calculateSeoScore();
        }
    }
}