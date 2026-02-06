<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id',
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'social_links',
        'seller_rating',
        'seller_reviews_count',
        'products_count',
        'sales_count',
        'is_verified',
        'is_active',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'seller_rating' => 'decimal:2',
    ];

    /**
     * Get the author associated with this shop
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get all products in this shop
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
