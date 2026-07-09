<?php
// database/seeders/MenuItemSeeder.php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menu items
        MenuItem::truncate();

        // Header Menu Items
        $headerMenus = [
            [
                'name' => 'Home',
                'url' => '/',
                'category' => 'header',
                'sort_order' => 1,
                'is_active' => true,
                'icon' => 'bi bi-house',
                'target' => '_self',
                'description' => 'Homepage link'
            ],
            [
                'name' => 'About',
                'url' => '/about',
                'category' => 'header',
                'sort_order' => 2,
                'is_active' => true,
                'icon' => 'bi bi-info-circle',
                'target' => '_self',
                'description' => 'About us page'
            ],
            [
                'name' => 'Services',
                'url' => null, // Parent item for dropdown
                'category' => 'header',
                'sort_order' => 3,
                'is_active' => true,
                'icon' => 'bi bi-gear',
                'target' => '_self',
                'description' => 'Services dropdown menu'
            ],
            [
                'name' => 'Contact',
                'url' => '/contact',
                'category' => 'header',
                'sort_order' => 4,
                'is_active' => true,
                'icon' => 'bi bi-envelope',
                'target' => '_self',
                'description' => 'Contact page'
            ],
        ];

        foreach ($headerMenus as $menu) {
            MenuItem::create($menu);
        }

        // Services Sub-menu items
        $servicesParent = MenuItem::where('name', 'Services')->first();
        $serviceSubMenus = [
            [
                'name' => 'Web Development',
                'url' => '/services/web-development',
                'category' => 'header',
                'parent_id' => $servicesParent->id,
                'sort_order' => 1,
                'is_active' => true,
                'icon' => 'bi bi-code-slash',
                'target' => '_self',
                'description' => 'Web development services'
            ],
            [
                'name' => 'Mobile Apps',
                'url' => '/services/mobile-apps',
                'category' => 'header',
                'parent_id' => $servicesParent->id,
                'sort_order' => 2,
                'is_active' => true,
                'icon' => 'bi bi-phone',
                'target' => '_self',
                'description' => 'Mobile app development'
            ],
            [
                'name' => 'Digital Marketing',
                'url' => '/services/digital-marketing',
                'category' => 'header',
                'parent_id' => $servicesParent->id,
                'sort_order' => 3,
                'is_active' => true,
                'icon' => 'bi bi-megaphone',
                'target' => '_self',
                'description' => 'Digital marketing services'
            ],
        ];

        foreach ($serviceSubMenus as $submenu) {
            MenuItem::create($submenu);
        }

        // Footer Quick Links
        $footerQuickLinks = [
            [
                'name' => 'Privacy Policy',
                'url' => '/privacy-policy',
                'category' => 'footer_quick_links',
                'sort_order' => 1,
                'is_active' => true,
                'icon' => 'bi bi-shield-check',
                'target' => '_self',
                'description' => 'Privacy policy page'
            ],
            [
                'name' => 'Terms & Conditions',
                'url' => '/terms-conditions',
                'category' => 'footer_quick_links',
                'sort_order' => 2,
                'is_active' => true,
                'icon' => 'bi bi-file-text',
                'target' => '_self',
                'description' => 'Terms and conditions'
            ],
            [
                'name' => 'Sitemap',
                'url' => '/sitemap',
                'category' => 'footer_quick_links',
                'sort_order' => 3,
                'is_active' => true,
                'icon' => 'bi bi-diagram-3',
                'target' => '_self',
                'description' => 'Website sitemap'
            ],
            [
                'name' => 'Blog',
                'url' => '/blog',
                'category' => 'footer_quick_links',
                'sort_order' => 4,
                'is_active' => true,
                'icon' => 'bi bi-journal-text',
                'target' => '_self',
                'description' => 'Company blog'
            ],
        ];

        foreach ($footerQuickLinks as $link) {
            MenuItem::create($link);
        }

        // Footer Services
        $footerServices = [
            [
                'name' => 'Web Design',
                'url' => '/services/web-design',
                'category' => 'footer_services',
                'sort_order' => 1,
                'is_active' => true,
                'icon' => 'bi bi-palette',
                'target' => '_self',
                'description' => 'Web design services'
            ],
            [
                'name' => 'E-commerce',
                'url' => '/services/ecommerce',
                'category' => 'footer_services',
                'sort_order' => 2,
                'is_active' => true,
                'icon' => 'bi bi-cart',
                'target' => '_self',
                'description' => 'E-commerce solutions'
            ],
            [
                'name' => 'SEO Services',
                'url' => '/services/seo',
                'category' => 'footer_services',
                'sort_order' => 3,
                'is_active' => true,
                'icon' => 'bi bi-search',
                'target' => '_self',
                'description' => 'Search engine optimization'
            ],
            [
                'name' => 'Hosting',
                'url' => '/services/hosting',
                'category' => 'footer_services',
                'sort_order' => 4,
                'is_active' => true,
                'icon' => 'bi bi-server',
                'target' => '_self',
                'description' => 'Web hosting services'
            ],
        ];

        foreach ($footerServices as $service) {
            MenuItem::create($service);
        }

        // Footer Support
        $footerSupport = [
            [
                'name' => 'Help Center',
                'url' => '/help',
                'category' => 'footer_support',
                'sort_order' => 1,
                'is_active' => true,
                'icon' => 'bi bi-question-circle',
                'target' => '_self',
                'description' => 'Help and support center'
            ],
            [
                'name' => 'Contact Support',
                'url' => '/support',
                'category' => 'footer_support',
                'sort_order' => 2,
                'is_active' => true,
                'icon' => 'bi bi-headset',
                'target' => '_self',
                'description' => 'Contact support team'
            ],
            [
                'name' => 'Documentation',
                'url' => '/docs',
                'category' => 'footer_support',
                'sort_order' => 3,
                'is_active' => true,
                'icon' => 'bi bi-book',
                'target' => '_self',
                'description' => 'Product documentation'
            ],
            [
                'name' => 'Community Forum',
                'url' => 'https://forum.example.com',
                'category' => 'footer_support',
                'sort_order' => 4,
                'is_active' => true,
                'icon' => 'bi bi-people',
                'target' => '_blank',
                'description' => 'Community discussion forum'
            ],
        ];

        foreach ($footerSupport as $support) {
            MenuItem::create($support);
        }

        echo "Menu items seeded successfully!\n";
        echo "Header Menu: " . MenuItem::header()->count() . " items\n";
        echo "Footer Quick Links: " . MenuItem::footerQuickLinks()->count() . " items\n";
        echo "Footer Services: " . MenuItem::footerServices()->count() . " items\n";
        echo "Footer Support: " . MenuItem::footerSupport()->count() . " items\n";
    }
}