<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddToStorefrontTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storefront', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
        });
        Schema::table('banking_beneficiaries', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
        });
        Schema::table('banking_details', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
        });
        Schema::table('beneficiary', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
            $table->uuid('ben_id')->change();
        });
        Schema::table('booking_services', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
        });
        Schema::table('cart', function (Blueprint $table) {
            $table->uuid('id')->change();
            //$table->nullableTimestamps(0);
        });
        Schema::table('contact', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->timestamp('updated_at')->nullable()->default(NULL)->change();
            $table->timestamp('created_at')->nullable()->change();
        });
        Schema::table('charges', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
        });
        Schema::table('coupon', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
        });
        Schema::table('customer', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
            $table->timestamp('updated_at')->nullable()->default(NULL)->change();
            $table->timestamp('created_at')->nullable()->change();
        });
        Schema::table('customer_address', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('customer_id')->change();
            $table->timestamp('updated_at')->nullable()->default(NULL)->change();
            $table->timestamp('created_at')->nullable()->change();
        });
        Schema::table('customer_password_resets', function (Blueprint $table) {
            $table->uuid('id')->change();
        });
        Schema::table('custom_domain', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('store_id')->change();
        });
        Schema::table('donations', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
            $table->timestamp('updated_at')->nullable()->default(NULL)->change();
            $table->timestamp('created_at')->nullable()->change();
        });
        Schema::table('ext_transfer', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('receiver_id')->change();
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
            $table->timestamp('updated_at')->nullable()->default(NULL)->change();
            $table->timestamp('created_at')->nullable()->change();
        });
        Schema::table('merchants', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
        });
        Schema::table('store_blog', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('store_id')->change();
        });
        Schema::table('store_faq', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('store_id')->change();
        });
        Schema::table('store_pages', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('store_id')->change();
        });
        Schema::table('store_review', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('store_id')->change();
        });
        Schema::table('store_pages', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('store_id')->change();
        });
        // Schema::table('theme_blog_category', function (Blueprint $table) {
        //     $table->uuid('id')->change();
        //     $table->uuid('store_id')->change();
        // });
        // Schema::table('theme_faq_category', function (Blueprint $table) {
        //     $table->uuid('id')->change();
        //     $table->uuid('store_id')->change();
        // });
        // Schema::table('theme_feature', function (Blueprint $table) {
        //     $table->uuid('id')->change();
        //     $table->uuid('store_id')->change();
        // });
        Schema::table('theme_sliders', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('store_id')->change();
        });
        Schema::table('payment_link', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
            $table->timestamp('updated_at')->nullable()->default(NULL)->change();
            $table->timestamp('created_at')->nullable()->change();
        });
        Schema::table('support', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('user_id')->change();
            $table->timestamp('updated_at')->nullable()->default(NULL)->change();
            $table->timestamp('created_at')->nullable()->change();
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('receiver_id')->change();
        });
        Schema::table('wishlist', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('product_id')->change();
            $table->uuid('store_id')->change();
            $table->uuid('customer_id')->change();
        });
        Schema::table('password_resets', function (Blueprint $table) {
            $table->uuid('id')->change();
        });
        Schema::table('sub', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->timestamp('updated_at')->nullable()->default(NULL)->change();
            $table->timestamp('created_at')->nullable()->change();
        });
        Schema::table('reply_support', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->timestamp('updated_at')->nullable()->default(NULL)->change();
            $table->timestamp('created_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storefront', function (Blueprint $table) {
            //
        });
    }
}
