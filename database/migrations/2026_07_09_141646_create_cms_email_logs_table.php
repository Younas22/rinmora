<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Static/seeded demo data — no real send pipeline wired (resend-laravel is
// installed but nothing calls it for campaigns yet).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name');
            $table->string('recipient_email');
            $table->string('subject');
            $table->enum('status', ['delivered', 'opened', 'bounced', 'failed', 'queued'])->default('queued');
            $table->unsignedInteger('opened_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_email_logs');
    }
};
