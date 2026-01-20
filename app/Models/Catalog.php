<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'bumnag_profile_id',
        'name',
        'slug',
        'description',
        'price',
        'unit',
        'stock',
        'sku',
        'category',
        'featured_image',
        'images',
        'is_available',
        'is_featured',
        'view_count',
        'specifications',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
        'images' => 'array',
        'specifications' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($catalog) {
            if (empty($catalog->slug)) {
                $catalog->slug = Str::slug($catalog->name);
            }
            
            // Ensure unique slug
            $originalSlug = $catalog->slug;
            $count = 1;
            while (static::where('slug', $catalog->slug)->exists()) {
                $catalog->slug = $originalSlug . '-' . $count;
                $count++;
            }
        });

        static::updating(function ($catalog) {
            if ($catalog->isDirty('name') && !$catalog->isDirty('slug')) {
                $catalog->slug = Str::slug($catalog->name);
                
                // Ensure unique slug
                $originalSlug = $catalog->slug;
                $count = 1;
                while (static::where('slug', $catalog->slug)->where('id', '!=', $catalog->id)->exists()) {
                    $catalog->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Get the BUMNag profile that owns the catalog.
     */
    public function bumnagProfile(): BelongsTo
    {
        return $this->belongsTo(BumnagProfile::class);
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        if (!$this->price) {
            return 'Hubungi Kami';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Scope for available products.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stock', '>', 0);
    }

    /**
     * Scope for featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
