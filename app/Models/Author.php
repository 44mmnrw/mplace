<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'display_name',
        'slug',
        'about',
        'social_links',
        'masterclasses_count',
        'author_rating',
        'author_reviews_count',
        'is_verified',
        'is_active',
    ];

    protected $casts = [
        'specializations' => 'array',
        'social_links' => 'array',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'author_rating' => 'decimal:2',
    ];

    /**
     * Get the user associated with this author
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all products created by this author
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all addresses for this author
     */
    public function addresses()
    {
        return $this->hasMany(AuthorAddress::class);
    }

    /**
     * Get the default address
     */
    public function defaultAddress()
    {
        return $this->hasOne(AuthorAddress::class)->where('is_default', true);
    }
}
