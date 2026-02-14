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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // Polymorphic relationship - can be for Catalog or Promotion
            $table->morphs('reviewable');
            
            // Reviewer info (nullable for guest reviews)
            $table->string('reviewer_name');
            $table->string('reviewer_email')->nullable();
            $table->string('reviewer_phone')->nullable();
            
            // Review content
            $table->unsignedTinyInteger('rating')->default(5); // 1-5 stars
            $table->text('comment')->nullable();
            
            // Moderation
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            
            // Metadata
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            // Helpful votes
            $table->unsignedInteger('helpful_count')->default(0);
            
            // Verification
            $table->boolean('is_verified_purchase')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['reviewable_type', 'reviewable_id', 'status']);
            $table->index('status');
            $table->index('rating');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
