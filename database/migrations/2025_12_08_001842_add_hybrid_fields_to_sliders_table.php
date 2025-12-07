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
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('title')->nullable()->after('label');
            $table->string('subtitle')->nullable()->after('title');
            $table->text('description')->nullable()->after('subtitle');
            $table->string('cta_text')->nullable()->after('description');
            $table->string('cta_link')->nullable()->after('cta_text');
            $table->foreignId('product_id')->nullable()->after('cta_link')->constrained()->nullOnDelete();
            $table->string('badge_title')->nullable()->after('product_id');
            $table->string('badge_subtitle')->nullable()->after('badge_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn([
                'title',
                'subtitle',
                'description',
                'cta_text',
                'cta_link',
                'product_id',
                'badge_title',
                'badge_subtitle',
            ]);
        });
    }
};
