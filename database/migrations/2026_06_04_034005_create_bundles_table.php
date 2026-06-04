<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('subtitle')->nullable();
            $table->integer('price');
            $table->integer('original_price')->nullable();
            $table->json('benefits')->nullable();
            $table->json('included_products')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};
