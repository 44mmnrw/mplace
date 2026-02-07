<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'reviewable_type',
        'reviewable_id',
        'rating',
        'review_text',
        'is_verified_purchase',
        'is_approved',
        'helpful_count',
        'not_helpful_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'helpful_count' => 'integer',
        'not_helpful_count' => 'integer',
    ];

    protected $attributes = [
        'is_approved' => false,
        'is_verified_purchase' => false,
        'helpful_count' => 0,
        'not_helpful_count' => 0,
    ];

    /**
     * Get the reviewable model (Product, Shop, Author, etc.)
     */
    public function reviewable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who wrote the review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
