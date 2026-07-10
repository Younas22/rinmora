<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscriber;
use App\Models\Setting;
use App\Models\System\AdminActivityLog;
use App\Models\System\AdminErrorLog;
use App\Models\System\ContactMessage;
use App\Models\System\Permission;
use App\Models\System\Role;
use App\Models\System\SupportTicket;
use App\Models\System\SupportTicketMessage;
use App\Models\System\TaxRule;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSystemSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPermissionsAndRoles();
        $this->seedStaffUsers();
        $this->seedErrorLogs();
        $this->seedContactMessages();
        $this->seedSupportTickets();
        $this->seedTaxRules();
        $this->backfillNewsletterSource();
        $this->seedActivityLogs();
        $this->seedSettings();
    }

    protected function seedPermissionsAndRoles(): void
    {
        $permissions = [
            ['name' => 'Manage Products', 'slug' => 'manage-products', 'group' => 'Catalog'],
            ['name' => 'Manage Inventory', 'slug' => 'manage-inventory', 'group' => 'Catalog'],
            ['name' => 'Manage Reviews', 'slug' => 'manage-reviews', 'group' => 'Catalog'],
            ['name' => 'Manage Orders', 'slug' => 'manage-orders', 'group' => 'Orders'],
            ['name' => 'Issue Refunds', 'slug' => 'issue-refunds', 'group' => 'Orders'],
            ['name' => 'Manage Shipping', 'slug' => 'manage-shipping', 'group' => 'Orders'],
            ['name' => 'Manage Payments', 'slug' => 'manage-payments', 'group' => 'Orders'],
            ['name' => 'Manage Customers', 'slug' => 'manage-customers', 'group' => 'Customers'],
            ['name' => 'Manage CMS Content', 'slug' => 'manage-cms-content', 'group' => 'Content'],
            ['name' => 'Manage Media', 'slug' => 'manage-media', 'group' => 'Content'],
            ['name' => 'Manage SEO', 'slug' => 'manage-seo', 'group' => 'Content'],
            ['name' => 'Manage Notifications', 'slug' => 'manage-notifications', 'group' => 'Content'],
            ['name' => 'View Reports', 'slug' => 'view-reports', 'group' => 'Reports'],
            ['name' => 'Manage Users & Roles', 'slug' => 'manage-users-roles', 'group' => 'System'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'group' => 'System'],
            ['name' => 'View Activity Logs', 'slug' => 'view-activity-logs', 'group' => 'System'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }

        $roles = [
            'super-admin' => ['name' => 'Super Admin', 'description' => 'Full access to everything.', 'is_system' => true, 'permissions' => 'all'],
            'store-manager' => ['name' => 'Store Manager', 'description' => 'Manages catalog, orders, and customers.', 'is_system' => true, 'permissions' => [
                'manage-products', 'manage-inventory', 'manage-reviews', 'manage-orders', 'issue-refunds',
                'manage-shipping', 'manage-payments', 'manage-customers', 'view-reports',
            ]],
            'support-staff' => ['name' => 'Support Staff', 'description' => 'Handles orders and customer support.', 'is_system' => true, 'permissions' => [
                'manage-orders', 'manage-customers', 'manage-reviews',
            ]],
            'content-editor' => ['name' => 'Content Editor', 'description' => 'Manages homepage, media, and SEO content.', 'is_system' => true, 'permissions' => [
                'manage-cms-content', 'manage-media', 'manage-seo', 'manage-notifications',
            ]],
        ];

        foreach ($roles as $slug => $r) {
            $role = Role::firstOrCreate(
                ['slug' => $slug],
                ['name' => $r['name'], 'description' => $r['description'], 'is_system' => $r['is_system']]
            );

            $permissionIds = $r['permissions'] === 'all'
                ? Permission::pluck('id')
                : Permission::whereIn('slug', $r['permissions'])->pluck('id');

            $role->permissions()->sync($permissionIds);
        }
    }

    protected function seedStaffUsers(): void
    {
        $superAdmin = Role::where('slug', 'super-admin')->first();
        $admin = User::where('email', 'admin@rinmora.test')->first();
        if ($admin && !$admin->role_id) {
            $admin->update(['role_id' => $superAdmin->id]);
        }

        $staff = [
            ['first_name' => 'Bilal', 'last_name' => 'Hassan', 'email' => 'bilal@rinmora.test', 'role' => 'store-manager', 'user_type' => 'agent'],
            ['first_name' => 'Fatima', 'last_name' => 'Zahra', 'email' => 'fatima@rinmora.test', 'role' => 'support-staff', 'user_type' => 'agent'],
            ['first_name' => 'Meher', 'last_name' => 'Fatima', 'email' => 'meher@rinmora.test', 'role' => 'content-editor', 'user_type' => 'agent'],
        ];

        foreach ($staff as $s) {
            $role = Role::where('slug', $s['role'])->first();
            User::firstOrCreate(
                ['email' => $s['email']],
                [
                    'first_name' => $s['first_name'],
                    'last_name' => $s['last_name'],
                    'user_type' => $s['user_type'],
                    'role_id' => $role->id,
                    'status' => 'active',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }

    protected function seedErrorLogs(): void
    {
        $errors = [
            ['error_type' => '500 Server Error', 'message' => 'Payment gateway timeout after 30s', 'endpoint' => '/api/checkout/payment', 'occurrences' => 4, 'status' => 'open', 'hours_ago' => 2],
            ['error_type' => 'API Timeout', 'message' => 'Shipping rate API did not respond in time', 'endpoint' => '/api/shipping/rates', 'occurrences' => 4, 'status' => 'open', 'hours_ago' => 4],
            ['error_type' => 'Validation Error', 'message' => 'Missing required field: postal_code', 'endpoint' => '/api/checkout/address', 'occurrences' => 12, 'status' => 'resolved', 'hours_ago' => 24],
            ['error_type' => '500 Server Error', 'message' => 'Unhandled exception in inventory sync job', 'endpoint' => '/jobs/inventory-sync', 'occurrences' => 2, 'status' => 'open', 'hours_ago' => 26],
            ['error_type' => 'Failed Payment', 'message' => 'Card declined — insufficient funds', 'endpoint' => '/api/checkout/payment', 'occurrences' => 1, 'status' => 'resolved', 'hours_ago' => 32],
            ['error_type' => 'Validation Error', 'message' => 'Invalid coupon code format', 'endpoint' => '/api/cart/coupon', 'occurrences' => 6, 'status' => 'resolved', 'hours_ago' => 48],
        ];

        foreach ($errors as $e) {
            $lastSeen = now()->subHours($e['hours_ago']);
            AdminErrorLog::firstOrCreate(
                ['message' => $e['message'], 'endpoint' => $e['endpoint']],
                [
                    'error_type' => $e['error_type'],
                    'stack_trace' => "{$e['error_type']}: {$e['message']}\n  at Handler.process ({$e['endpoint']})",
                    'occurrences' => $e['occurrences'],
                    'status' => $e['status'],
                    'first_seen_at' => $lastSeen->copy()->subDays(3),
                    'last_seen_at' => $lastSeen,
                ]
            );
        }
    }

    protected function seedContactMessages(): void
    {
        $messages = [
            ['name' => 'Sana Khan', 'email' => 'sana.khan@gmail.com', 'subject' => 'Question about order #RIN-20583', 'priority' => 'high', 'days_ago' => 1],
            ['name' => 'Bilal Ahmed', 'email' => 'bilal.ahmed@outlook.com', 'subject' => 'Bulk order inquiry', 'priority' => 'medium', 'days_ago' => 1],
            ['name' => 'Hira Malik', 'email' => 'hira.malik@yahoo.com', 'subject' => 'Return policy question', 'priority' => 'low', 'days_ago' => 2, 'read' => true],
            ['name' => 'Faisal Traders', 'email' => 'faisal@faisaltraders.com', 'subject' => 'Wholesale partnership', 'priority' => 'medium', 'days_ago' => 3, 'read' => true],
            ['name' => 'Zoya Ahmed', 'email' => 'zoya.ahmed@gmail.com', 'subject' => 'Product defect report', 'priority' => 'high', 'days_ago' => 4],
            ['name' => 'Amina Raza', 'email' => 'amina.raza@hotmail.com', 'subject' => 'Gift wrapping availability', 'priority' => 'low', 'days_ago' => 5, 'read' => true],
            ['name' => 'Noor Fatima', 'email' => 'noor.fatima@gmail.com', 'subject' => 'Website login issue', 'priority' => 'medium', 'days_ago' => 6, 'read' => true],
        ];

        foreach ($messages as $m) {
            ContactMessage::firstOrCreate(
                ['email' => $m['email'], 'subject' => $m['subject']],
                [
                    'name' => $m['name'],
                    'message' => "Hi Rinmora team,\n\nI'm writing about: {$m['subject']}. Could someone please get back to me?\n\nThanks,\n{$m['name']}",
                    'priority' => $m['priority'],
                    'is_read' => $m['read'] ?? false,
                    'created_at' => now()->subDays($m['days_ago']),
                    'updated_at' => now()->subDays($m['days_ago']),
                ]
            );
        }
    }

    protected function seedSupportTickets(): void
    {
        $tickets = [
            [
                'customer_name' => 'Sana Khan', 'customer_email' => 'sana.khan@gmail.com',
                'subject' => 'Damaged zipper on Milano Tote', 'status' => 'open', 'minutes_ago' => 12,
                'messages' => [
                    ['sender_type' => 'customer', 'sender_name' => 'Sana Khan', 'body' => 'Hi, the zipper on my tote arrived damaged. Can I get a replacement?', 'hours_ago' => 48],
                    ['sender_type' => 'admin', 'sender_name' => 'Ayesha N.', 'body' => "So sorry to hear that! Could you send a photo of the damage?", 'hours_ago' => 46],
                    ['sender_type' => 'customer', 'sender_name' => 'Sana Khan', 'body' => 'Attached — the zipper pull snapped off.', 'hours_ago' => 44],
                    ['sender_type' => 'internal', 'sender_name' => 'Ayesha N.', 'body' => 'Repeat customer, VIP tier — expedite replacement and include a handwritten apology card.', 'hours_ago' => 43],
                ],
            ],
            ['customer_name' => 'Bilal Ahmed', 'customer_email' => 'bilal.ahmed@outlook.com', 'subject' => 'Wrong item received', 'status' => 'pending', 'minutes_ago' => 60],
            ['customer_name' => 'Hira Malik', 'customer_email' => 'hira.malik@yahoo.com', 'subject' => 'Refund not processed', 'status' => 'open', 'minutes_ago' => 180],
            ['customer_name' => 'Zoya Ahmed', 'customer_email' => 'zoya.ahmed@gmail.com', 'subject' => 'Late delivery complaint', 'status' => 'resolved', 'minutes_ago' => 1440],
            ['customer_name' => 'Amina Raza', 'customer_email' => 'amina.raza@hotmail.com', 'subject' => 'Discount code not working', 'status' => 'closed', 'minutes_ago' => 2880],
            ['customer_name' => 'Noor Fatima', 'customer_email' => 'noor.fatima@gmail.com', 'subject' => 'Packaging feedback', 'status' => 'resolved', 'minutes_ago' => 4320],
        ];

        foreach ($tickets as $t) {
            $ticket = SupportTicket::firstOrCreate(
                ['customer_email' => $t['customer_email'], 'subject' => $t['subject']],
                [
                    'ticket_number' => SupportTicket::nextTicketNumber(),
                    'customer_name' => $t['customer_name'],
                    'status' => $t['status'],
                    'created_at' => now()->subMinutes($t['minutes_ago'] + 60),
                    'updated_at' => now()->subMinutes($t['minutes_ago']),
                ]
            );

            if ($ticket->messages()->count() > 0) {
                continue;
            }

            $messages = $t['messages'] ?? [
                ['sender_type' => 'customer', 'sender_name' => $t['customer_name'], 'body' => "Hi, I need help with: {$t['subject']}.", 'hours_ago' => $t['minutes_ago'] / 60 + 1],
            ];

            foreach ($messages as $m) {
                SupportTicketMessage::create([
                    'ticket_id' => $ticket->id,
                    'sender_type' => $m['sender_type'] === 'internal' ? 'admin' : $m['sender_type'],
                    'sender_name' => $m['sender_name'],
                    'is_internal_note' => $m['sender_type'] === 'internal',
                    'body' => $m['body'],
                    'created_at' => now()->subHours($m['hours_ago']),
                    'updated_at' => now()->subHours($m['hours_ago']),
                ]);
            }
        }
    }

    protected function seedTaxRules(): void
    {
        $rules = [
            ['name' => 'Standard VAT', 'applies_to' => 'All Products', 'rate' => 20, 'is_active' => true],
            ['name' => 'Reduced Rate', 'applies_to' => 'Accessories', 'rate' => 5, 'is_active' => true],
            ['name' => 'Zero Rated', 'applies_to' => 'Export Orders', 'rate' => 0, 'is_active' => true],
            ['name' => 'Digital Goods', 'applies_to' => 'Gift Cards', 'rate' => 12, 'is_active' => false],
        ];

        foreach ($rules as $r) {
            TaxRule::firstOrCreate(['name' => $r['name']], $r);
        }
    }

    protected function backfillNewsletterSource(): void
    {
        $sources = ['Checkout', 'Website', 'Import'];
        NewsletterSubscriber::whereNull('source')->get()->each(function ($sub, $i) use ($sources) {
            $sub->update(['source' => $sources[$i % 3]]);
        });
    }

    protected function seedActivityLogs(): void
    {
        if (AdminActivityLog::count() > 0) {
            return;
        }

        $admin = User::where('email', 'admin@rinmora.test')->first();
        if (!$admin) {
            return;
        }

        $samples = [
            ['module' => 'Products', 'action' => 'Updated Products', 'device' => 'Desktop', 'browser' => 'Chrome'],
            ['module' => 'Orders', 'action' => 'Updated Orders', 'device' => 'Mobile', 'browser' => 'Safari'],
            ['module' => 'Customers', 'action' => 'Updated Customers', 'device' => 'Desktop', 'browser' => 'Firefox'],
            ['module' => 'Homepage Sections', 'action' => 'Created Homepage Sections', 'device' => 'Desktop', 'browser' => 'Edge'],
            ['module' => 'Media', 'action' => 'Created Media', 'device' => 'Desktop', 'browser' => 'Chrome'],
            ['module' => 'Redirects', 'action' => 'Deleted Redirects', 'device' => 'Desktop', 'browser' => 'Chrome'],
        ];

        for ($i = 0; $i < 20; $i++) {
            $sample = $samples[$i % count($samples)];
            AdminActivityLog::create([
                'user_id' => $admin->id,
                'module' => $sample['module'],
                'action' => $sample['action'],
                'route_name' => null,
                'ip_address' => '192.168.1.14',
                'device' => $sample['device'],
                'browser' => $sample['browser'],
                'url' => null,
                'created_at' => now()->subHours($i * 3 + 1),
                'updated_at' => now()->subHours($i * 3 + 1),
            ]);
        }
    }

    protected function seedSettings(): void
    {
        $defaults = [
            'general' => ['store_name' => 'Rinmora', 'default_country' => 'United States', 'store_status' => '1', 'maintenance_mode' => '0'],
            'store_info' => [
                'biz_name' => 'Rinmora Leather Goods LLC', 'biz_phone' => '+1 (415) 555-0148',
                'biz_address' => "208 Market Street, Suite 4B, San Francisco, CA 94103, United States",
                'biz_email' => 'hello@rinmora.com', 'support_phone' => '+1 (415) 555-0199', 'support_email' => 'support@rinmora.com',
                'store_desc' => 'Rinmora crafts timeless, handcrafted leather handbags for the modern woman.',
                'business_hours' => json_encode([
                    'mon' => ['open' => true, 'from' => '10:00 AM', 'to' => '8:00 PM'],
                    'tue' => ['open' => true, 'from' => '10:00 AM', 'to' => '8:00 PM'],
                    'wed' => ['open' => true, 'from' => '10:00 AM', 'to' => '8:00 PM'],
                    'thu' => ['open' => true, 'from' => '10:00 AM', 'to' => '8:00 PM'],
                    'fri' => ['open' => true, 'from' => '10:00 AM', 'to' => '9:00 PM'],
                    'sat' => ['open' => true, 'from' => '11:00 AM', 'to' => '6:00 PM'],
                    'sun' => ['open' => false, 'from' => 'Closed', 'to' => 'Closed'],
                ]),
            ],
            'theme' => ['primary_color' => '#CFBAA5', 'secondary_color' => '#000000', 'accent_color' => '#3B82F6', 'background_color' => '#F8F8F8'],
            'currency' => ['default_currency' => 'USD', 'currency_symbol' => '$', 'currency_position' => 'before', 'decimal_places' => '2', 'currency_active' => '1'],
            'language' => ['default_language' => 'en', 'rtl_layout' => '0', 'enabled_languages' => json_encode(['en', 'ar', 'ur'])],
            'timezone' => ['timezone' => 'Asia/Karachi', 'date_format' => 'd/m/Y', 'time_format' => '12'],
            'seo' => ['store_meta_title' => 'Rinmora | Premium Handcrafted Leather Handbags', 'store_meta_description' => 'Shop timeless leather handbags, totes, and clutches crafted for everyday luxury.'],
        ];

        foreach ($defaults as $group => $keys) {
            foreach ($keys as $key => $value) {
                if (Setting::where('group', $group)->where('key', $key)->doesntExist()) {
                    Setting::setValue($key, $value, $group);
                }
            }
        }
    }
}
