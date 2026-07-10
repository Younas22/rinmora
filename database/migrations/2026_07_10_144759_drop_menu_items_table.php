<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * The Menu Management admin module (Admin\MenuController, admin/menus/*) was
 * removed along with the old Bootstrap admin/frontend template it belonged
 * to — every row here pointed at pages that no longer exist (Home, /about,
 * /services, /contact, etc).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('menu_items');
    }

    public function down(): void
    {
        //
    }
};
