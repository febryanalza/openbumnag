<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperGallery
 */
class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'type',
        'album',
        'taken_date',
        'photographer',
        'location',
        'is_featured',
        'order',
        'views',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'taken_date' => 'date',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'views' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            if (empty($gallery->user_id) && auth()->check()) {
                $gallery->user_id = auth()->id();
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('file_type', 'video');
    }

    public function scopeInAlbum($query, $album)
    {
        return $query->where('album', $album);
    }
}
