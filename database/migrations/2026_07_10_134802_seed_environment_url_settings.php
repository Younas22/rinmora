<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'mode' => 'development',
            'dev_admin_url' => 'http://localhost/rinmora',
            'dev_frontend_url' => 'http://localhost:3000',
            'dev_api_url' => 'http://localhost/rinmora/api',
            'prod_admin_url' => '',
            'prod_frontend_url' => '',
            'prod_api_url' => '',
        ];

        foreach ($defaults as $key => $value) {
            // Don't clobber a value an admin may have already saved via the UI.
            if (Setting::where('group', 'environment')->where('key', $key)->doesntExist()) {
                Setting::setValue($key, $value, 'environment');
            }
        }
    }

    public function down(): void
    {
        Setting::where('group', 'environment')->delete();
    }
};
