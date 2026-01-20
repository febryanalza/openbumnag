<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperBumnagProfile
 */
class BumnagProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'nagari_name',
        'slug',
        'tagline',
        'about',
        'vision',
        'mission',
        'values',
        'history',
        'logo',
        'banner',
        'images',
        'legal_entity_number',
        'established_date',
        'notary_name',
        'deed_number',
        'address',
        'postal_code',
        'phone',
        'fax',
        'email',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'tiktok',
        'whatsapp',
        'latitude',
        'longitude',
        'operating_hours',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'operating_hours' => 'array',
        'established_date' => 'date',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            if (empty($profile->slug)) {
                $profile->slug = static::generateUniqueSlug($profile->name);
            }
        });

        static::updating(function ($profile) {
            if ($profile->isDirty('name') && empty($profile->slug)) {
                $profile->slug = static::generateUniqueSlug($profile->name, $profile->id);
            }
        });
    }

    // Helper method to generate unique slug
    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the catalogs for the BUMNag profile.
     */
    public function catalogs(): HasMany
    {
        return $this->hasMany(Catalog::class);
    }
}
