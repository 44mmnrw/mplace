<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DifficultyLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
    ];

    protected $attributes = [
        'sort_order' => 0,
    ];

    /**
     * Get products with this difficulty level
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'difficulty_level_id');
    }
}
