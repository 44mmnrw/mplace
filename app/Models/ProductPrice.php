<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'old_price',
        'currency',
        'valid_from',
        'valid_to',
        'is_active',
        'note',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    protected $attributes = [
        'currency' => 'RUB',
        'is_active' => true,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate discount percentage
     */
    public function getDiscountPercentAttribute()
    {
        if (!$this->old_price || $this->old_price <= $this->price) {
            return 0;
        }

        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }
}
