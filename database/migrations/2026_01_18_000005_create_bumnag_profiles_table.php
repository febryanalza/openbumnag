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
        Schema::create('bumnag_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama BUMNag
            $table->string('nagari_name'); // Nama Nagari
            $table->string('slug')->unique();
            $table->text('tagline')->nullable();
            $table->longText('about')->nullable();
            $table->longText('vision')->nullable();
            $table->longText('mission')->nullable();
            $table->longText('values')->nullable();
            $table->text('history')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->json('images')->nullable();
            
            // Legal Information
            $table->string('legal_entity_number')->nullable();
            $table->date('established_date')->nullable();
            $table->string('notary_name')->nullable();
            $table->string('deed_number')->nullable();
            
            // Contact Information
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            
            // Social Media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();
            
            // Coordinates for map
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            // Operating Hours
            $table->json('operating_hours')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bumnag_profiles');
    }
};
