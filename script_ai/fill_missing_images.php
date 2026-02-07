<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\Storage;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "===========================================\n";
echo "Заполнение отсутствующих изображений\n";
echo "===========================================\n\n";

// Путь к заглушке (поместите вашу заглушку в resources/images/placeholder.png)
$placeholderSource = __DIR__ . '/../resources/images/placeholder.png';

if (!file_exists($placeholderSource)) {
    echo "ОШИБКА: Заглушка не найдена по адресу: $placeholderSource\n";
    echo "Создайте файл placeholder.png в resources/images/\n";
    exit(1);
}

// Получаем все изображения продуктов
$images = \App\Models\ProductImage::all();
$fixed = 0;
$missing = 0;

echo "Найдено изображений в БД: " . $images->count() . "\n\n";

foreach ($images as $image) {
    $fullPath = storage_path('app/public/' . $image->image_path);
    
    // Проверяем существует ли файл
    if (!file_exists($fullPath)) {
        $missing++;
        echo "❌ Отсутствует: {$image->image_path} (ID: {$image->id})\n";
        
        // Создаем директорию если не существует
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Копируем заглушку
        if (copy($placeholderSource, $fullPath)) {
            $fixed++;
            echo "   ✅ Заглушка скопирована\n";
        } else {
            echo "   ⚠️  Не удалось скопировать заглушку\n";
        }
    }
}

echo "\n===========================================\n";
echo "Результаты:\n";
echo "===========================================\n";
echo "Отсутствующих файлов: $missing\n";
echo "Исправлено: $fixed\n";
echo "===========================================\n";
