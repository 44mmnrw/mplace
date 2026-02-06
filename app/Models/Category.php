<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'sort_order' => 0,
        'is_active' => true,
    ];

    /**
     * Get parent categories
     */
    public function parents()
    {
        return $this->belongsToMany(Category::class, 'category_relations', 'child_id', 'parent_id')
            ->withPivot('sort_order')
            ->orderBy('sort_order');
    }

    /**
     * Get child categories
     */
    public function children()
    {
        return $this->belongsToMany(Category::class, 'category_relations', 'parent_id', 'child_id')
            ->withPivot('sort_order')
            ->orderBy('sort_order');
    }

    /**
     * Get products in this category
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }
}
