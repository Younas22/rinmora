<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('created_by')->default('self');
            $table->string('order_type')->nullable();
            $table->string('payment_option')->nullable();
            $table->string('screen_shoot')->nullable();
            $table->string('total_cost')->nullable();
            $table->enum('payment_status', ['paid','unpaid'])->default('paid');
            $table->enum('order_status', ['pending','close','open','completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
