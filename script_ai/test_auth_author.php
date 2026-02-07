<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Author;
use Illuminate\Support\Facades\DB;

echo "=== Проверка User <-> Author связи ===\n\n";

// Проверяем существующих пользователей с авторами
$users = User::with('author')->get();

echo "👤 Пользователи в системе:\n";
foreach ($users as $user) {
    echo "  User ID: {$user->id} | Email: {$user->email} | Name: {$user->first_name} {$user->last_name}\n";
    
    if ($user->author) {
        echo "    ✅ Автор: ID={$user->author->id} | Display Name: {$user->author->display_name}\n";
    } else {
        echo "    ❌ Нет профиля автора\n";
    }
    echo "\n";
}

// Проверяем что можно получить автора через User модель
$userWithAuthor = User::whereHas('author')->first();

if ($userWithAuthor) {
    echo "✅ Связь User->author работает!\n";
    echo "   User: {$userWithAuthor->email}\n";
    echo "   Author: {$userWithAuthor->author->display_name}\n";
} else {
    echo "❌ Нет пользователей с профилем автора\n";
    echo "   Создайте пользователя через регистрацию: /author/auth/register\n";
}

echo "\n=== Тест middleware ===\n";
echo "Middleware 'author' зарегистрирован и проверяет:\n";
echo "  1. Пользователь авторизован (auth()->check())\n";
echo "  2. У пользователя есть профиль автора (auth()->user()->author)\n";
echo "\nДля тестирования:\n";
echo "  - Зайдите на /author/auth/login\n";
echo "  - Войдите или зарегистрируйтесь\n";
echo "  - Попробуйте открыть /author/dashboard\n";
