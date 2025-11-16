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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company_email');
            $table->string('company_name');
            $table->string('phone');
            $table->string('contact_name');
            $table->text('product_url')->nullable();
            $table->string('inquiry_type');
            $table->string('quantity')->nullable();
            $table->text('message');
            $table->string('attachment')->nullable();
            $table->boolean('privacy_agreed')->default(false);
            $table->string('locale', 10)->default('en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
