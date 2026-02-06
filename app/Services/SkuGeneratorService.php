<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class SkuGeneratorService
{
    /**
     * Генерирует SKU для продукта на основе категории и счетчика
     * Алгоритм: первые 4 цифры - MD5 хеш названия категории, остальные 6 - счетчик
     *
     * @param int $categoryId ID категории
     * @return string SKU в формате XXXXNNNNNN (X - цифры из MD5, N - счетчик)
     */
    public function generate(int $categoryId): string
    {
        $category = Category::findOrFail($categoryId);

        // Получаем первые 4 цифры из MD5 хеша названия категории
        $hash = md5($category->name);
        $hashDigits = $this->extractDigitsFromHash($hash, 4);

        // Получаем следующий номер счетчика для этой категории
        $counter = $this->getNextCounterForCategory($categoryId);
        $counterPart = str_pad($counter, 6, '0', STR_PAD_LEFT);

        return $hashDigits . $counterPart;
    }

    /**
     * Извлекает первые N цифр из строки, заменяя буквы на цифры по алфавиту
     *
     * @param string $hash MD5 хеш
     * @param int $count количество нужных цифр
     * @return string строка из цифр
     */
    private function extractDigitsFromHash(string $hash, int $count): string
    {
        $digits = '';
        $i = 0;

        while (strlen($digits) < $count && $i < strlen($hash)) {
            $char = $hash[$i];

            // Если уже цифра, добавляем её
            if (is_numeric($char)) {
                $digits .= $char;
            } else {
                // Если буква, преобразуем в цифру (a=0, b=1, ..., f=5)
                $digit = ord(strtolower($char)) - ord('a');
                if ($digit >= 0 && $digit <= 9) {
                    $digits .= $digit;
                }
            }

            $i++;
        }

        // Если не хватает цифр, дополняем нулями
        return str_pad($digits, $count, '0', STR_PAD_LEFT);
    }

    /**
     * Получает следующий номер счетчика для категории
     *
     * @param int $categoryId ID категории
     * @return int следующий номер счетчика
     */
    private function getNextCounterForCategory(int $categoryId): int
    {
        // Первые 4 цифры SKU для этой категории
        $category = Category::findOrFail($categoryId);
        $hash = md5($category->name);
        $hashDigits = $this->extractDigitsFromHash($hash, 4);

        // Находим максимальный счетчик для этой категории
        $maxSku = Product::where('primary_category_id', $categoryId)
            ->where('sku', 'LIKE', $hashDigits . '%')
            ->orderByRaw('CAST(SUBSTRING(sku, 5) AS UNSIGNED) DESC')
            ->value('sku');

        if ($maxSku) {
            // Извлекаем последние 6 цифр и увеличиваем на 1
            $lastCounter = intval(substr($maxSku, 4));
            return $lastCounter + 1;
        }

        // Если продуктов ещё нет, начинаем с 1
        return 1;
    }
}
