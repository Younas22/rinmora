<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_notification_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('channel', ['push', 'email', 'sms']);
            $table->string('audience');
            $table->string('subject')->nullable();
            $table->text('message_body');
            $table->enum('status', ['draft', 'scheduled', 'sent'])->default('draft');
            $table->unsignedInteger('sent_count')->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_notification_campaigns');
    }
};
