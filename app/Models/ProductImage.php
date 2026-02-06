<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'is_main',
        'sort_order',
        'alt_text',
        'title',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    protected $attributes = [
        'is_main' => false,
        'sort_order' => 0,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
