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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('app_name')->default('MyShop');
            $table->string('primary_color')->default('#3b82f6'); // Default blue
            $table->string('secondary_color')->default('#8b5cf6'); // Default purple
            $table->timestamps();
        });
        
        // Create banners table for banner management
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('link')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('badge')->nullable();
            $table->string('badge_color')->nullable();
            $table->string('gradient_from')->nullable();
            $table->string('gradient_to')->nullable();
            $table->enum('type', ['main', 'side'])->default('main');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
        Schema::dropIfExists('themes');
    }
};
