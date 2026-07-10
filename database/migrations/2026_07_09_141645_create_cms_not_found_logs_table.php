<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Static/seeded demo data only — no live 404-capture hook exists (would
// need a global exception-handler listener, out of scope for this phase).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_not_found_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedInteger('hit_count')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_not_found_logs');
    }
};
