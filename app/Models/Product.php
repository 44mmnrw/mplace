<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id',
        'primary_category_id',
        'difficulty_level_id',
        'title',
        'slug',
        'sku',
        'short_description',
        'description',
        'format',
        'language',
        'materials',
        'requirements',
        'what_you_learn',
        'status',
        'is_active',
        'is_featured',
        'is_digital',
        'auto_delivery',
        'delivery_instructions',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published_at',
        'files',
        'stock_quantity',
    ];

    protected $casts = [
        'materials' => 'array',
        'requirements' => 'array',
        'what_you_learn' => 'array',
        'auto_delivery' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_digital' => 'boolean',
        'rating' => 'decimal:2',
        'published_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'draft',
        'is_active' => true,
        'is_digital' => true,
        'language' => 'ru',
        'auto_delivery' => false,
        'views_count' => 0,
        'sales_count' => 0,
        'rating' => 0,
        'reviews_count' => 0,
    ];

    /**
     * Get the active price for this product
     */
    public function activePrice()
    {
        return $this->hasOne(ProductPrice::class)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_to')
                    ->orWhere('valid_to', '>=', now());
            })
            ->latest();
    }

    /**
     * Get all prices for this product
     */
    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    /**
     * Get the main image
     */
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    /**
     * Get all images
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Get all categories (additional)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories')
            ->withPivot('sort_order')
            ->orderBy('sort_order');
    }

    /**
     * Get primary category
     */
    public function primaryCategory()
    {
        return $this->belongsTo(Category::class, 'primary_category_id');
    }

    /**
     * Get the author
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the shop
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the difficulty level
     */
    public function difficultyLevel()
    {
        return $this->belongsTo(DifficultyLevel::class);
    }

    /**
     * Get product files
     */
    public function files()
    {
        return $this->hasMany(ProductFile::class)->orderBy('sort_order');
    }

    /**
     * Get attribute values
     */
    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
