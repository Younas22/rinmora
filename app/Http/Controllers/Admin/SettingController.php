<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Resend\Laravel\Facades\Resend;
use Illuminate\Support\Facades\Http;

class SettingController extends Controller
{

    public function website()
{
    // Get all settings grouped by their group
    $allSettings = Setting::where('is_active', true)->get()->groupBy('group');
    
    // Convert to array format for easier access in view
    $settings = [];
    foreach ($allSettings as $group => $groupSettings) {
        $settings[$group] = $groupSettings->pluck('value', 'key')->toArray();
    }
    
    return view('admin.settings.website', compact('settings'));
}

public function updateWebsite(Request $request)
{
    $group = $request->input('group', 'main');
    
    // Define validation rules for different groups
    $validationRules = $this->getValidationRules($group);
    
    $validated = $request->validate($validationRules);
    
    // Remove group from validated data
    unset($validated['group']);
    
    try {
        foreach ($validated as $key => $value) {
            // Handle file uploads
            if ($request->hasFile($key)) {
                $value = $request->file($key)->store("settings/{$group}", 'public');
            }
            
            // Handle checkboxes (convert to boolean)
            if (in_array($key, ['website_offline', 'guest_booking', 'user_registration', 'supplier_registration', 'agent_registration'])) {
                $value = $request->has($key) ? '1' : '0';
            }
            
            Setting::updateOrCreate(
                ['group' => $group, 'key' => $key],
                ['value' => $value, 'is_active' => true]
            );
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => ucfirst($group) . ' settings updated successfully!'
            ]);
        }
        
        return back()->with('success', ucfirst($group) . ' settings updated successfully!');
        
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating settings: ' . $e->getMessage()
            ], 500);
        }
        
        return back()->withErrors(['error' => 'Error updating settings: ' . $e->getMessage()]);
    }
}

private function getValidationRules($group)
{
    $rules = [
        'main' => [
            'business_name' => 'required|string|max:255',
            'domain_name' => 'required|string|max:255',
            'license_key' => 'nullable|string|max:255',
            'website_offline' => 'nullable|boolean'
        ],
        'seo' => [
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'meta_keywords' => 'nullable|string|max:255'
        ],
        'accounts' => [
            'guest_booking' => 'nullable|boolean',
            'user_registration' => 'nullable|boolean',
            'supplier_registration' => 'nullable|boolean',
            'agent_registration' => 'nullable|boolean'
        ],
        'system' => [
            'google_analytics_id' => 'nullable|string|max:50',
            'google_tag_manager_id' => 'nullable|string|max:50',
            'facebook_pixel_id' => 'nullable|string|max:50',
            'custom_tracking_code' => 'nullable|string'
        ],
        'contact' => [
            'business_address' => 'nullable|string',
            'map_embed_code' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'support_email' => 'nullable|email|max:255',
            'emergency_contact' => 'nullable|string|max:20'
        ],
        'branding' => [
            'business_logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024'
        ],
        'homepage' => [
            'cover_image' => 'nullable|image|max:5120',
            'cover_title' => 'nullable|string|max:255',
            'cover_subtitle' => 'nullable|string|max:500'
        ],
        'social' => [
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'google_business_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'whatsapp_number' => 'nullable|string|max:20'
        ]
    ];
    
    return $rules[$group] ?? [];
}

   



public function email()
{
    $settings = Setting::where('group', 'email')->pluck('value', 'key');
    
    // Mock email statistics (you can replace with real data from your email service)
    $stats = [
        'total_sent' => 1250,
        'delivered' => 1198,
        'opened' => 856,
        'bounced' => 12
    ];
    
    return view('admin.settings.email', compact('settings', 'stats'));
}

// Update your updateEmail method to handle AJAX:

public function updateEmail(Request $request)
{
    $validated = $request->validate([
        'resend_api_key' => 'required|string|starts_with:re_',
        'sender_name' => 'required|string|max:255',
        'sender_email' => 'required|email',
    ]);

    // Test API key before saving
    $testResult = $this->testResendConnection($validated['resend_api_key']);
    
    if (!$testResult['success']) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $testResult['message']
            ], 422);
        }
        return back()->withErrors(['resend_api_key' => $testResult['message']]);
    }

    foreach ($validated as $key => $value) {
        Setting::updateOrCreate(
            ['group' => 'email', 'key' => $key],
            ['value' => $value]
        );
    }

    // Update API status
    Setting::updateOrCreate(
        ['group' => 'email', 'key' => 'api_status'],
        ['value' => 'connected']
    );

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Email settings updated successfully!'
        ]);
    }

    return back()->with('success', 'Email settings updated successfully!');
}



public function testEmailConnection(Request $request)
{
    $request->validate([
        'api_key' => 'required|string|starts_with:re_',
    ]);

    $result = $this->testResendConnection($request->api_key);
    
    return response()->json($result);
}

public function sendTestEmail(Request $request)
{
    $request->validate([
        'test_email' => 'required|email',
    ]);

    $apiKey = Setting::getValue('resend_api_key', 'email');
    $senderName = Setting::getValue('sender_name', 'email', 'SkyBooking');
    $senderEmail = Setting::getValue('sender_email', 'email', 'noreply@skybooking.com');

    if (!$apiKey) {
        return response()->json([
            'success' => false,
            'message' => 'API key not configured. Please save your API settings first.'
        ]);
    }

    try {
        // Configure Resend temporarily
        config(['services.resend.key' => $apiKey]);

        $result = Resend::emails()->send([
            'from' => "{$senderName} <{$senderEmail}>",
            'to' => [$request->test_email],
            'subject' => 'SkyBooking Email Test - Configuration Successful',
            'html' => $this->getTestEmailTemplate(),
        ]);

        // Save last test email
        Setting::updateOrCreate(
            ['group' => 'email', 'key' => 'last_test_email'],
            ['value' => $request->test_email]
        );

        return response()->json([
            'success' => true,
            'message' => 'Test email sent successfully! Please check your inbox.',
            'email_id' => $result['id'] ?? null
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send test email: ' . $e->getMessage()
        ]);
    }
}

private function testResendConnection($apiKey)
{
    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->get('https://api.resend.com/domains');

        if ($response->successful()) {
            return [
                'success' => true,
                'message' => 'API connection successful!'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Invalid API key or connection failed.'
            ];
        }
    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => 'Connection error: ' . $e->getMessage()
        ];
    }
}

private function getTestEmailTemplate()
{
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background: #f8f9fa; }
            .success { background: #d1edff; border-left: 4px solid #0066cc; padding: 15px; margin: 20px 0; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🛫 SkyBooking Email Test</h1>
            </div>
            <div class="content">
                <div class="success">
                    <strong>✅ Configuration Successful!</strong><br>
                    Your email settings are working correctly.
                </div>
                <p>This is a test email from your SkyBooking travel platform.</p>
                <p><strong>Test Details:</strong></p>
                <ul>
                    <li>Service: Resend Email API</li>
                    <li>Time: ' . now()->format('Y-m-d H:i:s') . '</li>
                    <li>Status: Email delivery successful</li>
                </ul>
                <p>If you received this email, your email configuration is working perfectly!</p>
            </div>
        </div>
    </body>
    </html>';
}

}