<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Static/seeded demo data only — no live exception-handler capture hook
// exists (would require touching Laravel's global exception reporting
// app-wide, out of scope for this phase). "Resolve" toggle is real.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('error_type');
            $table->text('message');
            $table->string('endpoint');
            $table->text('stack_trace')->nullable();
            $table->unsignedInteger('occurrences')->default(1);
            $table->enum('status', ['open', 'resolved'])->default('open');
            $table->dateTime('first_seen_at');
            $table->dateTime('last_seen_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_error_logs');
    }
};
