<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_masters', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('name');
            $table->string('contact');
            $table->string('email');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('pincode');

            $table->double('total_mrp');
            $table->double('total_amount');
            $table->double('discount_on_mrp')->default(0);
            $table->double('coupon_discount')->default(0);
            $table->double('platform_fee')->default(0);
            $table->double('shipping_fee')->default(0);
            $table->integer('cod_fee')->default(0);
            $table->integer('prepaid_fee')->default(0);
            
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_request_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('order_status')->nullable();

            $table->string('tracking_no')->nullable();
            $table->integer('invoice_no')->default(0);
            $table->string('invoice_prefix');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_masters');
    }
};
