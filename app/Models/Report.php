<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperReport
 */
class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'description',
        'type',
        'period',
        'year',
        'month',
        'quarter',
        'file_path',
        'file_type',
        'file_size',
        'cover_image',
        'content',
        'status',
        'downloads',
        'published_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'quarter' => 'integer',
        'file_size' => 'integer',
        'downloads' => 'integer',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($report) {
            if (empty($report->slug)) {
                $report->slug = static::generateUniqueSlug($report->title);
            }
            if (empty($report->user_id) && auth()->check()) {
                $report->user_id = auth()->id();
            }
        });

        static::updating(function ($report) {
            if ($report->isDirty('title') && empty($report->slug)) {
                $report->slug = static::generateUniqueSlug($report->title, $report->id);
            }
        });
    }

    // Helper method to generate unique slug
    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
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
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOfYear($query, $year)
    {
        return $query->where('year', $year);
    }

    // Accessors
    public function getFileSizeFormatted()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
