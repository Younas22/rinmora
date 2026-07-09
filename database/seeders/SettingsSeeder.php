<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Main Settings
            [
                'group' => 'main',
                'key' => 'business_name',
                'value' => 'SkyBooking Travel',
                'type' => 'text',
                'description' => 'Business name displayed across the website'
            ],
            [
                'group' => 'main',
                'key' => 'domain_name',
                'value' => 'skybooking.com',
                'type' => 'text',
                'description' => 'Primary domain name'
            ],
            [
                'group' => 'main',
                'key' => 'license_key',
                'value' => 'SK-2025-XXXXXXXX-XXXX',
                'type' => 'text',
                'description' => 'Software license key'
            ],
            [
                'group' => 'main',
                'key' => 'website_offline',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Put website in maintenance mode'
            ],

            // SEO Settings
            [
                'group' => 'seo',
                'key' => 'meta_title',
                'value' => 'SkyBooking - Best Flight Booking Platform',
                'type' => 'text',
                'description' => 'Meta title for SEO (50-60 characters)'
            ],
            [
                'group' => 'seo',
                'key' => 'meta_description',
                'value' => 'Book flights at the best prices with SkyBooking. Compare flights from multiple airlines and save on your next trip. Easy booking, 24/7 support.',
                'type' => 'textarea',
                'description' => 'Meta description for SEO (150-160 characters)'
            ],
            [
                'group' => 'seo',
                'key' => 'keywords',
                'value' => 'flight booking, cheap flights, airline tickets, travel',
                'type' => 'text',
                'description' => 'SEO keywords separated by commas'
            ],

            // Account Settings
            [
                'group' => 'accounts',
                'key' => 'guest_booking',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Allow guest users to make bookings'
            ],
            [
                'group' => 'accounts',
                'key' => 'user_registration',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable user registration'
            ],
            [
                'group' => 'accounts',
                'key' => 'supplier_registration',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Allow suppliers to register'
            ],
            [
                'group' => 'accounts',
                'key' => 'agent_registration',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Allow travel agents to register'
            ],

            // System Settings
            [
                'group' => 'system',
                'key' => 'google_analytics_id',
                'value' => 'G-XXXXXXXXXX',
                'type' => 'text',
                'description' => 'Google Analytics 4 measurement ID'
            ],
            [
                'group' => 'system',
                'key' => 'google_tag_manager_id',
                'value' => 'GTM-XXXXXXX',
                'type' => 'text',
                'description' => 'Google Tag Manager container ID'
            ],
            [
                'group' => 'system',
                'key' => 'facebook_pixel_id',
                'value' => '123456789012345',
                'type' => 'text',
                'description' => 'Facebook Pixel ID for tracking'
            ],
            [
                'group' => 'system',
                'key' => 'custom_tracking_code',
                'value' => '',
                'type' => 'textarea',
                'description' => 'Custom tracking scripts for head section'
            ],

            // Contact Settings
            [
                'group' => 'contact',
                'key' => 'business_address',
                'value' => "123 Travel Street, Suite 456\nDowntown Business District\nNew York, NY 10001, USA",
                'type' => 'textarea',
                'description' => 'Complete business address'
            ],
            [
                'group' => 'contact',
                'key' => 'map_embed_code',
                'value' => '',
                'type' => 'textarea',
                'description' => 'Google Maps embed code'
            ],
            [
                'group' => 'contact',
                'key' => 'contact_email',
                'value' => 'info@skybooking.com',
                'type' => 'email',
                'description' => 'Primary contact email'
            ],
            [
                'group' => 'contact',
                'key' => 'contact_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'tel',
                'description' => 'Primary contact phone'
            ],
            [
                'group' => 'contact',
                'key' => 'support_email',
                'value' => 'support@skybooking.com',
                'type' => 'email',
                'description' => 'Customer support email'
            ],
            [
                'group' => 'contact',
                'key' => 'emergency_contact',
                'value' => '+1 (555) 911-HELP',
                'type' => 'tel',
                'description' => 'Emergency contact number'
            ],

            // Branding Settings
            [
                'group' => 'branding',
                'key' => 'business_logo',
                'value' => '',
                'type' => 'file',
                'description' => 'Business logo (PNG, max 1MB)'
            ],
            [
                'group' => 'branding',
                'key' => 'favicon',
                'value' => '',
                'type' => 'file',
                'description' => 'Website favicon (PNG, 32x32, max 1MB)'
            ],

            // Homepage Settings
            [
                'group' => 'homepage',
                'key' => 'cover_image',
                'value' => '',
                'type' => 'file',
                'description' => 'Homepage hero cover image (PNG, 1920x800, max 1MB)'
            ],
            [
                'group' => 'homepage',
                'key' => 'cover_title',
                'value' => 'Find Your Perfect Flight',
                'type' => 'text',
                'description' => 'Homepage hero title'
            ],
            [
                'group' => 'homepage',
                'key' => 'cover_subtitle',
                'value' => 'Compare prices and book flights from top airlines worldwide',
                'type' => 'text',
                'description' => 'Homepage hero subtitle'
            ],

            // Social Links
            [
                'group' => 'social',
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/skybooking',
                'type' => 'url',
                'description' => 'Facebook page URL'
            ],
            [
                'group' => 'social',
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/skybooking',
                'type' => 'url',
                'description' => 'Twitter profile URL'
            ],
            [
                'group' => 'social',
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com/company/skybooking',
                'type' => 'url',
                'description' => 'LinkedIn company page URL'
            ],
            [
                'group' => 'social',
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/skybooking',
                'type' => 'url',
                'description' => 'Instagram profile URL'
            ],
            [
                'group' => 'social',
                'key' => 'google_url',
                'value' => '',
                'type' => 'url',
                'description' => 'Google Business profile URL'
            ],
            [
                'group' => 'social',
                'key' => 'youtube_url',
                'value' => 'https://youtube.com/c/skybooking',
                'type' => 'url',
                'description' => 'YouTube channel URL'
            ],
            [
                'group' => 'social',
                'key' => 'whatsapp_number',
                'value' => '+1-555-123-4567',
                'type' => 'tel',
                'description' => 'WhatsApp business number'
            ],
            [
                'group' => 'email',
                'key' => 'resend_api_key',
                'value' => '',
                'type' => 'password',
                'description' => 'Resend API key for email delivery'
            ],
            [
                'group' => 'email',
                'key' => 'sender_name',
                'value' => 'SkyBooking Support',
                'type' => 'text',
                'description' => 'Name that appears in recipient inbox'
            ],
            [
                'group' => 'email',
                'key' => 'sender_email',
                'value' => 'noreply@skybooking.com',
                'type' => 'email',
                'description' => 'Sender email address (must be verified domain)'
            ],
            [
                'group' => 'email',
                'key' => 'api_status',
                'value' => 'disconnected',
                'type' => 'text',
                'description' => 'API connection status'
            ],
            [
                'group' => 'email',
                'key' => 'last_test_email',
                'value' => '',
                'type' => 'email',
                'description' => 'Last email used for testing'
            ],

            // Payment Settings (existing settings ke baad add karo)

            // Stripe Settings
            [
                'group' => 'payment_stripe',
                'key' => 'stripe_publishable_key',
                'value' => 'pk_test_51234567890abcdef',
                'type' => 'text',
                'description' => 'Stripe publishable key'
            ],
            [
                'group' => 'payment_stripe',
                'key' => 'stripe_secret_key',
                'value' => 'sk_test_••••••••••••••••',
                'type' => 'password',
                'description' => 'Stripe secret key'
            ],
            [
                'group' => 'payment_stripe',
                'key' => 'stripe_webhook_secret',
                'value' => 'whsec_••••••••••••••••',
                'type' => 'password',
                'description' => 'Stripe webhook endpoint secret'
            ],
            [
                'group' => 'payment_stripe',
                'key' => 'stripe_test_mode',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable Stripe test mode'
            ],
            [
                'group' => 'payment_stripe',
                'key' => 'stripe_status',
                'value' => 'configured',
                'type' => 'text',
                'description' => 'Stripe gateway status'
            ],
            [
                'group' => 'payment_stripe',
                'key' => 'stripe_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable/disable Stripe gateway'
            ],
            [
                'group' => 'payment_stripe',
                'key' => 'stripe_notes',
                'value' => 'Stripe configured for production. Test mode enabled for development environment.',
                'type' => 'textarea',
                'description' => 'Administrative notes for Stripe'
            ],

            // PayPal Settings
            [
                'group' => 'payment_paypal',
                'key' => 'paypal_client_id',
                'value' => '',
                'type' => 'text',
                'description' => 'PayPal application client ID'
            ],
            [
                'group' => 'payment_paypal',
                'key' => 'paypal_client_secret',
                'value' => '',
                'type' => 'password',
                'description' => 'PayPal application client secret'
            ],
            [
                'group' => 'payment_paypal',
                'key' => 'paypal_webhook_id',
                'value' => '',
                'type' => 'text',
                'description' => 'PayPal webhook identifier'
            ],
            [
                'group' => 'payment_paypal',
                'key' => 'paypal_sandbox_mode',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Enable PayPal sandbox mode'
            ],
            [
                'group' => 'payment_paypal',
                'key' => 'paypal_status',
                'value' => 'active',
                'type' => 'text',
                'description' => 'PayPal gateway status'
            ],
            [
                'group' => 'payment_paypal',
                'key' => 'paypal_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable/disable PayPal gateway'
            ],
            [
                'group' => 'payment_paypal',
                'key' => 'paypal_notes',
                'value' => 'PayPal production environment. Business account verified.',
                'type' => 'textarea',
                'description' => 'Administrative notes for PayPal'
            ],

            // Razorpay Settings
            [
                'group' => 'payment_razorpay',
                'key' => 'razorpay_key_id',
                'value' => '',
                'type' => 'text',
                'description' => 'Razorpay key ID'
            ],
            [
                'group' => 'payment_razorpay',
                'key' => 'razorpay_key_secret',
                'value' => '',
                'type' => 'password',
                'description' => 'Razorpay key secret'
            ],
            [
                'group' => 'payment_razorpay',
                'key' => 'razorpay_webhook_secret',
                'value' => '',
                'type' => 'password',
                'description' => 'Razorpay webhook secret'
            ],
            [
                'group' => 'payment_razorpay',
                'key' => 'razorpay_test_mode',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable Razorpay test mode'
            ],
            [
                'group' => 'payment_razorpay',
                'key' => 'razorpay_status',
                'value' => 'pending',
                'type' => 'text',
                'description' => 'Razorpay gateway status'
            ],
            [
                'group' => 'payment_razorpay',
                'key' => 'razorpay_enabled',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Enable/disable Razorpay gateway'
            ],
            [
                'group' => 'payment_razorpay',
                'key' => 'razorpay_notes',
                'value' => 'Razorpay setup pending. Need to verify business documents.',
                'type' => 'textarea',
                'description' => 'Administrative notes for Razorpay'
            ],

            // Square Settings
            [
                'group' => 'payment_square',
                'key' => 'square_application_id',
                'value' => '',
                'type' => 'text',
                'description' => 'Square application ID'
            ],
            [
                'group' => 'payment_square',
                'key' => 'square_access_token',
                'value' => '',
                'type' => 'password',
                'description' => 'Square access token'
            ],
            [
                'group' => 'payment_square',
                'key' => 'square_location_id',
                'value' => '',
                'type' => 'text',
                'description' => 'Square business location ID'
            ],
            [
                'group' => 'payment_square',
                'key' => 'square_sandbox_mode',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Enable Square sandbox mode'
            ],
            [
                'group' => 'payment_square',
                'key' => 'square_status',
                'value' => 'inactive',
                'type' => 'text',
                'description' => 'Square gateway status'
            ],
            [
                'group' => 'payment_square',
                'key' => 'square_enabled',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Enable/disable Square gateway'
            ],
            [
                'group' => 'payment_square',
                'key' => 'square_notes',
                'value' => 'Square integration not yet configured. Awaiting business verification.',
                'type' => 'textarea',
                'description' => 'Administrative notes for Square'
            ],

            // General Payment Settings
            [
                'group' => 'payment',
                'key' => 'default_currency',
                'value' => 'USD',
                'type' => 'text',
                'description' => 'Default payment currency'
            ],
            [
                'group' => 'payment',
                'key' => 'payment_processing_fee',
                'value' => '2.9',
                'type' => 'text',
                'description' => 'Payment processing fee percentage'
            ],
            [
                'group' => 'payment',
                'key' => 'minimum_payment_amount',
                'value' => '1.00',
                'type' => 'text',
                'description' => 'Minimum payment amount'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}