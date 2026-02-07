<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Accessor: автоматически возвращает заглушку если файл не существует
     */
    public function getImageUrlAttribute(): string
    {
        // Если путь пустой - возвращаем маркер для Lottie-заглушки
        if (empty($this->image_path)) {
            return 'placeholder:lottie';
        }

        // Проверяем существует ли файл
        if (Storage::disk('public')->exists($this->image_path)) {
            return asset('storage/' . $this->image_path);
        }

        // Файл не найден - возвращаем маркер для Lottie-заглушки
        return 'placeholder:lottie';
    }

    /**
     * Получить URL миниатюры нужного размера
     * Возвращает путь (для обворачивания в asset()),
     * Если миниатюра не существует, возвращает оригинал
     */
    public function getThumbnailUrl(string $size = 'original'): string
    {
        if (empty($this->image_path)) {
            return 'placeholder:lottie';
        }

        if ($size === 'original') {
            // Возвращаем просто путь без asset()!
            if (Storage::disk('public')->exists($this->image_path)) {
                return $this->image_path;
            }
            return 'placeholder:lottie';
        }

        // Конструируем путь к миниатюре
        // Входящий путь: "products/images/123/2026-02/originals/abc123.jpg"
        // Нужно получить: "products/images/123/2026-02/thumb/abc123-thumb.jpg"
        
        $pathParts = explode('/', $this->image_path);
        $filename = array_pop($pathParts); // abc123.jpg
        array_pop($pathParts); // Удаляем "originals"
        
        $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        $thumbFilename = "{$filenameWithoutExt}-{$size}.{$ext}";
        $thumbPath = implode('/', $pathParts) . "/{$size}/{$thumbFilename}";

        // Проверяем существование миниатюры
        if (Storage::disk('public')->exists($thumbPath)) {
            return $thumbPath;  // Просто путь без asset()!
        }

        // Если миниатюра не найдена, возвращаем оригинал
        return $this->image_path;
    }

    /**
     * Получить все доступные размеры миниатюр
     */
    public function getAllThumbnailUrls(): array
    {
        return [
            'original' => $this->image_url,
            'thumb' => $this->getThumbnailUrl('thumb'),
            'medium' => $this->getThumbnailUrl('medium'),
            'large' => $this->getThumbnailUrl('large'),
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
