<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperPromotion
 */
class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'description',
        'featured_image',
        'images',
        'original_price',
        'discount_price',
        'discount_percentage',
        'promotion_type',
        'contact_person',
        'contact_phone',
        'contact_email',
        'location',
        'terms_conditions',
        'start_date',
        'end_date',
        'status',
        'is_featured',
        'views',
    ];

    protected $casts = [
        'images' => 'array',
        'original_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'discount_percentage' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean',
        'views' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($promotion) {
            if (empty($promotion->slug)) {
                $promotion->slug = Str::slug($promotion->title);
            }
            if (empty($promotion->user_id) && Auth::check()) {
                $promotion->user_id = Auth::id();
            }
        });

        static::updating(function ($promotion) {
            if ($promotion->isDirty('title') && empty($promotion->slug)) {
                $promotion->slug = Str::slug($promotion->title);
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('end_date')
            ->where('end_date', '<', now());
    }

    // Accessors
    public function getIsActiveAttribute()
    {
        if ($this->status !== 'active') return false;
        
        $now = now();
        
        if ($this->start_date && $this->start_date > $now) return false;
        if ($this->end_date && $this->end_date < $now) return false;
        
        return true;
    }
}
