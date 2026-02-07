<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroBannerImage extends Model
{
    protected $fillable = [
        'column_number',
        'position',
        'image_path',
        'link_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Получить полный URL картинки
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Scope для активных картинок
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope для конкретной колонки
     */
    public function scopeColumn($query, $columnNumber)
    {
        return $query->where('column_number', $columnNumber);
    }
}
