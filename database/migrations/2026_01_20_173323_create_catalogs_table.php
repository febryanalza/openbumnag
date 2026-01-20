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
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bumnag_profile_id')->constrained('bumnag_profiles')->cascadeOnDelete();
            $table->string('name'); // Nama produk
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->nullable(); // Harga produk
            $table->string('unit')->nullable(); // Satuan (kg, pcs, liter, dll)
            $table->integer('stock')->default(0); // Stok tersedia
            $table->string('sku')->nullable(); // SKU produk
            $table->string('category')->nullable(); // Kategori produk
            $table->string('featured_image')->nullable();
            $table->json('images')->nullable(); // Galeri gambar produk
            $table->boolean('is_available')->default(true); // Status ketersediaan
            $table->boolean('is_featured')->default(false); // Produk unggulan
            $table->integer('view_count')->default(0);
            $table->json('specifications')->nullable(); // Spesifikasi produk
            $table->timestamps();
            
            $table->index(['bumnag_profile_id', 'is_available']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogs');
    }
};
