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
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('locale'); // pending, quote_sent, completed, cancelled
            $table->string('quote_template')->nullable()->after('status'); // en or ko
            $table->text('quote_data')->nullable()->after('quote_template'); // JSON data for quote
            $table->string('quote_pdf')->nullable()->after('quote_data'); // Path to generated PDF
            $table->timestamp('quote_sent_at')->nullable()->after('quote_pdf');
            $table->text('admin_notes')->nullable()->after('quote_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'quote_template',
                'quote_data',
                'quote_pdf',
                'quote_sent_at',
                'admin_notes'
            ]);
        });
    }
};
