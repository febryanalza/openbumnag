<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewable_type',
        'reviewable_id',
        'reviewer_name',
        'reviewer_email',
        'reviewer_phone',
        'rating',
        'comment',
        'status',
        'admin_notes',
        'ip_address',
        'user_agent',
        'helpful_count',
        'is_verified_purchase',
    ];

    protected $casts = [
        'rating' => 'integer',
        'helpful_count' => 'integer',
        'is_verified_purchase' => 'boolean',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Get the reviewable model (Catalog or Promotion)
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope for approved reviews only
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope for pending reviews
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope for rejected reviews
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    /**
     * Scope by rating
     */
    public function scopeWithRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get rating stars as HTML
     */
    public function getStarsHtmlAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>';
            } else {
                $stars .= '<svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>';
            }
        }
        return $stars;
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            self::STATUS_APPROVED => 'bg-green-100 text-green-800',
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Unknown',
        };
    }

    /**
     * Get masked email for display
     */
    public function getMaskedEmailAttribute(): ?string
    {
        if (!$this->reviewer_email) {
            return null;
        }
        
        $parts = explode('@', $this->reviewer_email);
        if (count($parts) !== 2) {
            return $this->reviewer_email;
        }
        
        $name = $parts[0];
        $domain = $parts[1];
        
        $maskedName = substr($name, 0, 2) . str_repeat('*', max(strlen($name) - 2, 3));
        
        return $maskedName . '@' . $domain;
    }

    /**
     * Calculate statistics for a reviewable model
     */
    public static function getStatisticsFor($reviewableType, $reviewableId): array
    {
        $reviews = static::where('reviewable_type', $reviewableType)
            ->where('reviewable_id', $reviewableId)
            ->approved()
            ->get();

        if ($reviews->isEmpty()) {
            return [
                'average_rating' => 0,
                'total_reviews' => 0,
                'rating_distribution' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
                'rating_percentages' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
            ];
        }

        $average = $reviews->avg('rating');
        $total = $reviews->count();
        
        $distribution = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        foreach ($reviews as $review) {
            $distribution[$review->rating]++;
        }

        $percentages = [];
        foreach ($distribution as $rating => $count) {
            $percentages[$rating] = $total > 0 ? round(($count / $total) * 100) : 0;
        }

        return [
            'average_rating' => round($average, 1),
            'total_reviews' => $total,
            'rating_distribution' => $distribution,
            'rating_percentages' => $percentages,
        ];
    }
}
