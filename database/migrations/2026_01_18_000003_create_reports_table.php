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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('type')->default('financial'); // financial, activity, annual, monthly
            $table->string('period'); // 2024, Q1-2024, Jan-2024, etc
            $table->integer('year');
            $table->integer('month')->nullable();
            $table->integer('quarter')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable(); // pdf, excel, doc
            $table->bigInteger('file_size')->nullable();
            $table->string('cover_image')->nullable();
            $table->longText('content')->nullable();
            $table->string('status')->default('draft'); // draft, published, archived
            $table->integer('downloads')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['type', 'year', 'status']);
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
