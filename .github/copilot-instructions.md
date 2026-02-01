# Инструкции для AI-агентов по работе с проектом mplace

Маркетплейс мастер-классов по рукоделию на Laravel 12 + Vite. Проект находится на ранней стадии разработки с базовыми страницами (welcome, catalog) и модульной CSS-архитектурой.

## Архитектура и структура

### Frontend-архитектура
- **Layout-система**: Единый базовый layout `resources/views/layouts/app.blade.php` с секциями `@yield('content')` и компонентами `@include('header')`, `@include('footer')`
- **CSS-модули**: Модульная структура в `resources/css/`:
  - `app.css` — точка входа, импортирует все модули
  - `base.css` — CSS-переменные и базовые стили (`:root` с `--primary-color`, `--text-primary` и т.д.)
  - `reset.css`, `header.css`, `footer.css`, `welcome.css`, `catalog.css` — компонентные модули
  - **Контейнер**: `.container` с `max-width: 1504px` и `padding: 0 58px`
- **Именование классов**: BEM-подобная структура (`class-card`, `class-card-title`, `hero-section`)
- **Сборка**: Vite собирает `resources/css/app.css` и `resources/js/app.js`, подключаются через `@vite()` в layout

### Backend-архитектура
- **Версия**: Laravel 12 (PHP 8.2+)
- **Контроллеры**: Основные страницы используют контроллеры (`WelcomeController`, `CatalogController`)
- **Маршруты**: Определены в `routes/web.php`, временные страницы (login, register, masters, blog) — через замыкания
- **Текущие маршруты**: `/`, `/catalog`, `/login`, `/register`, `/masters`, `/blog`
- **База данных**: SQLite (для разработки), миграции в `database/migrations/`

## Критические рабочие процессы

### Запуск окружения разработки
```bash
# Полный setup с одной командой
composer setup

# Или вручную:
composer install
npm install
php artisan key:generate
php artisan migrate

# Запуск dev-серверов (из корня проекта):
composer dev  # Запускает Laravel + Vite + queue + logs через concurrently
```

### Альтернативные способы запуска (через script_ai/)
```bash
# Из каталога script_ai/
start_server.bat  # php artisan serve
start_vite.bat    # npm run dev
run_migrations.bat # php artisan migrate
```

### Тестирование
```bash
composer test  # Очищает кэш и запускает PHPUnit
vendor\bin\phpunit  # Прямой запуск
```

## Специфические соглашения проекта

### CSS-стилизация
- **ЗАПРЕЩЕНО**: Использовать Tailwind CSS классы в HTML (зависимость удалена из проекта)
- **ОБЯЗАТЕЛЬНО**: Писать только классический CSS в модулях `resources/css/`
- **Переменные**: Использовать CSS-переменные из `base.css` вместо хардкода цветов
- **Новые стили**: Создавать отдельный CSS-файл для новой страницы и импортировать в `app.css`

### Blade-шаблоны
- **Layout**: Все страницы наследуются от `layouts/app.blade.php`
- **Секции**: `@section('title')` для тега `<title>`, `@section('content')` для основного контента
- **Компоненты**: Header и Footer включаются через `@include()` в layout
- **Стеки**: `@stack('styles')` и `@stack('scripts')` для дополнительных ресурсов

### Контроллеры (будущее)
- Переносить логику из замыканий в `routes/web.php` в контроллеры по мере роста сложности
- Размещать бизнес-логику в сервисах (`app/Services/`), а не в контроллерах
- Контроллеры должны быть тонкими (thin controllers)

### Скрипты и утилиты
- **СТРОГО**: Все вспомогательные скрипты (проверки, дебаг, работа с БД) создавать только в `script_ai/`
- Не засорять корень проекта служебными файлами

## Примеры кода

### Новая страница с модульным CSS
```php
// resources/views/profile.blade.php
@extends('layouts.app')
@section('title', 'Профиль')
@section('content')
<div class="profile-page">
    <div class="container">
        <h1 class="profile-title">Мой профиль</h1>
    </div>
</div>
@endsection
```

```css
/* resources/css/profile.css */
.profile-page {
    padding: 40px 0;
    background: var(--bg-beige-light);
}
.profile-title {
    font-size: 32px;
    color: var(--text-primary);
}
```

```css
/* resources/css/app.css — добавить импорт */
@import './profile.css';
```

### Маршрут с контроллером (когда понадобится)
```php
// routes/web.php
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

// app/Http/Controllers/CatalogController.php
namespace App\Http\Controllers;

class CatalogController extends Controller
{
    public function index()
    {
        // Логика в сервисе
        $classes = app(MasterClassService::class)->getPopular();
        return view('catalog', compact('classes'));
    }
}
```

## Точки интеграции

- **Vite**: Конфигурация в `vite.config.js`, игнорирует `storage/framework/views/**` для избежания лишних перезагрузок
- **Composer scripts**: `dev`, `setup`, `test` для типовых задач разработки
- **Asset pipeline**: Все ресурсы проходят через Vite, используйте `@vite()` в Blade, а не прямые ссылки на файлы
- **База данных**: Используйте фабрики (`database/factories/`) и сидеры (`database/seeders/`) для тестовых данных

## Текущее состояние проекта

- ✅ Базовая структура Laravel 12
- ✅ Layout-система с header/footer
- ✅ Главная страница (welcome) с hero-секцией
- ✅ Страница каталога с фильтрами
- ✅ Модульная CSS-архитектура
- ✅ Контроллеры для основных страниц (WelcomeController, CatalogController)
- ⏳ Модели для мастер-классов, мастеров
- ⏳ Аутентификация
- ⏳ Административная панель

---

**Версия документа**: 1.2 (обновлено 2026-02-01)