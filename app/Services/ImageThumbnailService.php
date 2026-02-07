<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class ImageThumbnailService
{
    /**
     * Размеры миниатюр
     */
    const SIZES = [
        'thumb' => ['width' => 100, 'height' => 100],      // Для галереи миниатюр
        'medium' => ['width' => 400, 'height' => 300],     // Для всплывающих просмотров
        'large' => ['width' => 800, 'height' => 600],      // Для основного изображения
    ];

    private ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Загрузить картинку и создать все размеры миниатюр
     *
     * @param UploadedFile $file
     * @param string $basePath Базовый путь без имени файла (например: "products/images/2026-02/123")
     * @return array Array with keys: 'original', 'thumb', 'medium', 'large'
     */
    public function uploadAndCreateThumbnails(UploadedFile $file, string $basePath = 'products/images'): array
    {
        // Генерируем имя файла
        $filename = $file->hashName();
        $originalExt = $file->getClientOriginalExtension();
        $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);

        $paths = [];

        // Сохраняем оригинал
        $file->storeAs("{$basePath}/originals", $filename, 'public');
        $paths['original'] = "{$basePath}/originals/{$filename}";

        // Читаем файл в памяти
        $fileContent = file_get_contents($file->getPathname());

        foreach (self::SIZES as $size => $dimensions) {
            try {
                $thumbName = "{$filenameWithoutExt}-{$size}.{$originalExt}";
                $thumbPath = "{$basePath}/{$size}/{$thumbName}";

                // Создаем новое изображение из содержимого
                $image = $this->imageManager->read($fileContent);
                
                // Масштабируем картинку
                $image->scaleDown($dimensions['width'], $dimensions['height']);

                // Сохраняем
                Storage::disk('public')->put(
                    $thumbPath,
                    $image->encode(new JpegEncoder(quality: 85))
                );

                $paths[$size] = $thumbPath;
            } catch (\Exception $e) {
                \Log::warning("Failed to create {$size} thumbnail: " . $e->getMessage());
            }
        }

        return $paths;
    }

    /**
     * Создать миниатюры из существующего файла
     *
     * @param string $originalPath Полный путь к оригиналу в storage
     * @param string|null $basePath Если null, парсим из originalPath
     * @return array
     */
    public function generateFromExisting(string $originalPath, ?string $basePath = null): array
    {
        if (!Storage::disk('public')->exists($originalPath)) {
            return [];
        }

        // Если basePath не передан, вычисляем из пути
        if (!$basePath) {
            $basePath = dirname($originalPath);
        }

        $filename = basename($originalPath);
        $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        $paths = [];
        $paths['original'] = $originalPath;

        try {
            // Читаем оригинальный файл в памяти
            $fileContent = Storage::disk('public')->get($originalPath);

            // Создаем каждый размер
            foreach (self::SIZES as $size => $dimensions) {
                $thumbName = "{$filenameWithoutExt}-{$size}.{$ext}";
                $thumbPath = "{$basePath}/{$size}/{$thumbName}";

                try {
                    // Создаем новое изображение из содержимого
                    $image = $this->imageManager->read($fileContent);
                    
                    // Масштабируем картинку
                    $image->scaleDown($dimensions['width'], $dimensions['height']);

                    Storage::disk('public')->put(
                        $thumbPath,
                        $image->encode(new JpegEncoder(quality: 85))
                    );

                    $paths[$size] = $thumbPath;
                } catch (\Exception $e) {
                    \Log::warning("Failed to create {$size} thumbnail for {$originalPath}: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            // Если ошибка при чтении файла
            \Log::error('Thumbnail generation error: ' . $e->getMessage(), [
                'path' => $originalPath,
            ]);
        }

        return $paths;
    }

    /**
     * Удалить картинку и все её миниатюры
     *
     * @param string $imagePath
     * @param string|null $basePath
     * @return bool
     */
    public function deleteWithThumbnails(string $imagePath, ?string $basePath = null): bool
    {
        if (!$basePath) {
            $basePath = dirname($imagePath);
        }

        $filename = basename($imagePath);
        $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        $deleted = false;

        // Удаляем оригинал
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            $deleted = true;
        }

        // Удаляем все размеры
        foreach (array_keys(self::SIZES) as $size) {
            $thumbName = "{$filenameWithoutExt}-{$size}.{$ext}";
            $thumbPath = "{$basePath}/{$size}/{$thumbName}";

            if (Storage::disk('public')->exists($thumbPath)) {
                Storage::disk('public')->delete($thumbPath);
                $deleted = true;
            }
        }

        return $deleted;
    }

    /**
     * Получить оптимальный путь для использования
     * Возвращает thumb для миниатюр, иначе оригинал/medium
     *
     * @param string $originalPath
     * @param string $usage 'thumb'|'medium'|'large'|'original'
     * @return string
     */
    public function getThumbnailPath(string $originalPath, string $usage = 'original'): string
    {
        $basePath = dirname($originalPath);
        $filename = basename($originalPath);
        $filenameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if ($usage === 'original' || !isset(self::SIZES[$usage])) {
            return $originalPath;
        }

        $thumbName = "{$filenameWithoutExt}-{$usage}.{$ext}";
        $thumbPath = "{$basePath}/{$usage}/{$thumbName}";

        // Проверяем существование, если нет - возвращаем оригинал
        if (!Storage::disk('public')->exists($thumbPath)) {
            return $originalPath;
        }

        return $thumbPath;
    }
}
