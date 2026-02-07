# Инструкции для AI-агентов по работе с проектом mplace

Маркетплейс мастер-классов по рукоделию на Laravel 12 + Vite. Проект находится на ранней стадии разработки с базовыми страницами (welcome, catalog, masterclass-detail) и модульной CSS-архитектурой.

## Архитектура и структура

### Frontend-архитектура
- **Layout-система**: Единый базовый layout `resources/views/layouts/app.blade.php` с секциями `@yield('content')` и компонентами `@include('header')`, `@include('footer')`
- **CSS-модули**: Модульная структура в `resources/css/`:
  - `app.css` — точка входа, импортирует все модули через `@import`
  - `base.css` — CSS-переменные и базовые стили (`:root` с `--primary-color`, `--text-primary` и т.д.)
  - `fonts.css` — подключение шрифта Onest через @font-face
  - `reset.css`, `header.css`, `footer.css`, `welcome.css`, `catalog.css`, `masterclass-detail.css` — компонентные модули
  - **Контейнер**: `.container` с `max-width: 1504px` и `padding: 0 58px`
- **Именование классов**: BEM-подобная структура (`class-card`, `class-card-title`, `hero-section`)
- **Сборка**: Vite собирает `resources/css/app.css` и `resources/js/app.js`, подключаются через `@vite()` в layout
- **Особенности Vite**: Конфигурация игнорирует `storage/framework/views/**` для избежания лишних перезагрузок при компиляции Blade-шаблонов

### Backend-архитектура
- **Версия**: Laravel 12 (PHP 8.2+)
- **Контроллеры**: Основные страницы используют контроллеры (`WelcomeController`, `CatalogController`, `MasterclassController`)
- **Маршруты**: Определены в `routes/web.php`, временные страницы (login, register, masters, blog) — через замыкания, возвращают `view('welcome')`
- **Текущие маршруты**: 
  - `/` (home) - WelcomeController@index
  - `/catalog` (catalog) - CatalogController@index
  - `/masterclass/{id}` (masterclass.show) - MasterclassController@show
  - `/login`, `/register`, `/masters`, `/blog` - временные заглушки
- **База данных**: MySQL `mplace` (пользователь `mplace_usr`, пароль `123`), миграции в `database/migrations/`
- **Схема БД**: Полная DBML-схема в `script_ai/database/mplace_dbml_schema.dbml` — используйте для понимания структуры таблиц, связей и бизнес-логики

## Критические рабочие процессы

### Запуск окружения разработки
```bash
# Первоначальная настройка (автоматизирован через composer.json scripts)
composer setup
# Выполняет: composer install, копирует .env, генерирует APP_KEY, 
# запускает миграции, npm install, npm run build

# Запуск dev-серверов (ОСНОВНОЙ СПОСОБ из корня проекта)
composer dev
# Запускает через concurrently с цветными логами:
# - Laravel dev server (php artisan serve) - синий
# - Queue worker (php artisan queue:listen) - фиолетовый
# - Pail logs (php artisan pail) - розовый
# - Vite HMR (npm run dev) - оранжевый
# Все процессы завершаются одновременно при Ctrl+C (--kill-others)
```

**Альтернативные способы запуска** (используйте только если нужен контроль над отдельными процессами):
```bash
cd script_ai
start_server.bat  # Отдельно php artisan serve
start_vite.bat    # Отдельно npm run dev
run_migrations.bat # Отдельно php artisan migrate
```

### Тестирование
```bash
composer test       # Очищает кэш конфига и запускает PHPUnit
vendor\bin\phpunit  # Прямой запуск тестов
```

### Проверка базы данных
```bash
php artisan db:show            # Подключение, драйвер, список таблиц
php artisan migrate:status     # Статус выполнения миграций
php script_ai/check_database.php  # Детальная проверка: таблицы, поля, типы, индексы, foreign keys
mysql -u mplace_usr -p123 -D mplace  # Прямой доступ к MySQL CLI
```

### Создание дампа схемы БД
```bash
composer dump-schema  # Создает/обновляет database/schema/mysql-schema.sql (только структура, без данных)
```
**Важно**: Эта команда сохраняет только структуру таблиц (CREATE TABLE, индексы, ключи). Данные не включаются. Используется для фиксации схемы БД в репозитории.

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

**Реализовано:**
- ✅ Базовая структура Laravel 12 с автоматизированными scripts (setup, dev, test)
- ✅ Layout-система: `layouts/app.blade.php` → `@include('header/footer')` → `@yield('content')`
- ✅ 3 основных страницы: welcome, catalog, masterclass-detail
- ✅ Контроллеры: WelcomeController, CatalogController, MasterclassController (пока с заглушками)
- ✅ Модульная CSS-архитектура: `app.css` импортирует `base.css`, `header.css`, `footer.css` и компонентные модули
- ✅ Vite HMR с игнорированием `storage/framework/views/**` для стабильности
- ✅ Миграции БД: categories, attributes, products, orders и 20+ таблиц (см. DBML-схему)

**В разработке (TODO в контроллерах):**
- ⏳ Модели Eloquent (User уже есть, нужны Product, Category, Shop, Author и др.)
- ⏳ Реализация фильтров в CatalogController (закомментированные примеры есть)
- ⏳ Загрузка данных в WelcomeController (popularClasses, topMasters, categories)
- ⏳ Аутентификация Laravel Breeze/Jetstream
- ⏳ Административная панель (планируется отдельный маршрут-группа)
- ⏳ Factories и Seeders для тестовых данных

**Архитектурные особенности БД** (важно для создания моделей):
- Категории: поддержка множественных родителей через `category_relations` (many-to-many self-referencing)
- EAV для товаров: `attributes`, `attribute_options`, `product_attribute_values` (полиморфные значения)
- Полиморфные связи: `reviews` (Product/Shop/Author/Customer), `follows` (Author/Shop), `reports` (любые сущности)
- Денормализация для производительности: `rating`, `reviews_count`, `sales_count` в products

## Система производства миниатюр изображений

### Описание
Автоматическая генерация миниатюр при загрузке изображений товаров. Использует **Intervention Image v3** с GD driver.

### Структура размеров
```
const SIZES = [
    'thumb'  => ['width' => 100, 'height' => 100],   // Галерея миниатюр
    'medium' => ['width' => 400, 'height' => 300],   // Просмотр в модалях
    'large'  => ['width' => 800, 'height' => 600],   // Основное изображение
];
```

### Расположение файлов
```
storage/app/public/products/images/
└── {product_id}/
    └── {YYYY-MM}/
        ├── originals/          # Оригинальные файлы (полный размер)
        │   └── {hash}.{ext}
        ├── thumb/              # Миниатюры 100x100
        │   └── {hash}-thumb.{ext}
        ├── medium/             # Средние 400x300
        │   └── {hash}-medium.{ext}
        └── large/              # Большие 800x600
            └── {hash}-large.{ext}
```

### Как работает масштабирование
- **Метод**: `scaleDown()` — сохраняет пропорции, вписывает в "ящик"
- **Принцип**: Если оригинал 2000×1500 → для large (800×600) делает 800×600
- **Качество**: JPEG с качеством 85 (баланс размер/качество)
- **Не увеличивает**: Если оригинал меньше целевого размера, оставляет как есть

### Интеграция в контроллер
```php
// В Author/MasterclassController@store и @update
if ($request->hasFile('main_image')) {
    $imageService = new ImageThumbnailService();
    $paths = $imageService->uploadAndCreateThumbnails(
        $request->file('main_image'),
        "products/images/{$product->id}/" . now()->format('Y-m')
    );
    // $paths['original', 'thumb', 'medium', 'large']
}
```

### Вывод на фронте
```php
// В модели ProductImage
$image->getThumbnailUrl('thumb');   // Возвращает путь без asset()
$image->getThumbnailUrl('large');   // Путь к большой версии

// В Blade (компонент автоматически добавит asset)
<x-product-image :src="$image->getThumbnailUrl('medium')" />
```

### Важные моменты
- ✅ Флаг `is_main=1` должен быть установлен для главного изображения (первое автоматически если не загружено отдельное)
- ✅ Миниатюры создаются **при загрузке** (синхронно, не в очереди)
- ✅ Для существующих изображений: `php artisan thumbnails:generate`
- ✅ При удалении продукта удаляются все размеры через `ImageThumbnailService::deleteWithThumbnails()`
- ⚠️ Компонент `x-product-image` автоматически обворачивает пути в `asset('storage/')` и проверяет полный ли это URL

## Развертывание на продакшн-сервере

### Информация о сервере

- **Домен**: moonny.art
- **IP**: 212.113.120.197
- **SSH пользователь**: moonny_art_usr
- **Веб-корень**: `/var/www/moonny_art_usr/data/www/moonny.art/`
- **Домашняя директория**: `/var/www/moonny_art_usr/data/`
- **Панель управления**: FastPanel

### Важно: Пути к PHP на сервере

⚠️ **КРИТИЧЕСКИ ВАЖНО**: На сервере установлено несколько версий PHP. CLI версия по умолчанию — **PHP 7.2** (устаревшая), но для Laravel нужна **PHP 8.3**.

**ВСЕГДА используйте полный путь к PHP 8.3**:
```bash
# ❌ НЕПРАВИЛЬНО (использует PHP 7.2)
php artisan migrate
composer install

# ✅ ПРАВИЛЬНО (использует PHP 8.3)
/opt/php83/bin/php artisan migrate
/opt/php83/bin/php /usr/local/bin/composer install
```

**Доступные версии PHP**:
- `/opt/php81/bin/php` — PHP 8.1
- `/opt/php82/bin/php` — PHP 8.2
- `/opt/php83/bin/php` — PHP 8.3 ✓ (используем эту)

**PHP-FPM** для веб-сервера уже настроен на PHP 8.3 через FastPanel.

### Структура директорий на сервере

```
/var/www/moonny_art_usr/data/
├── www/
│   └── moonny.art/          # Веб-корень проекта (сюда деплоим)
├── logs/                    # Логи веб-сервера
├── tmp/                     # Временные файлы
├── email/                   # Почтовый каталог
└── php-bin/                 # Дополнительные PHP скрипты
```

### Процесс развертывания

**Автоматизированный скрипт**: `script_ai/deploy_to_server.bat` — используйте для развертывания с Windows

**Ручное развертывание через Git** (рекомендуется):
```bash
# 1. Подключение к серверу
ssh moonny_art_usr@212.113.120.197

# 2. Переход в веб-корень
cd /var/www/moonny_art_usr/data/www/moonny.art

# 3. Клонирование репозитория (первый раз)
git clone [URL_РЕПОЗИТОРИЯ] .

# 4. Или обновление (при последующих деплоях)
git pull origin main

# 5. Установка зависимостей
/opt/php83/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader

# 6. Настройка окружения
cp .env.example .env
nano .env  # Настроить DB_*, APP_URL и т.д.
/opt/php83/bin/php artisan key:generate

# 7. Права доступа
chmod -R 755 storage bootstrap/cache

# 8. Миграции
/opt/php83/bin/php artisan migrate --force

# 9. Сборка фронтенда
npm install
npm run build

# 10. Оптимизация
/opt/php83/bin/php artisan config:cache
/opt/php83/bin/php artisan route:cache
/opt/php83/bin/php artisan view:cache
```

**Развертывание через rsync** (с локальной машины):
```powershell
rsync -avz --exclude 'vendor' --exclude 'node_modules' --exclude 'storage/logs/*' --exclude '.env' --exclude '.git' ./ moonny_art_usr@212.113.120.197:/var/www/moonny_art_usr/data/www/moonny.art/
```

### Конфигурация .env для продакшена

```env
APP_NAME="MPlace"
APP_ENV=production
APP_KEY=  # Генерируется через artisan key:generate
APP_DEBUG=false
APP_URL=https://moonny.art

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=moonny_art
DB_USERNAME=moonny_art
DB_PASSWORD=UF;7nD#sknNiUTiF

CACHE_DRIVER=file
QUEUE_CONNECTION=database
SESSION_DRIVER=file

MAIL_FROM_ADDRESS=noreply@moonny.art
MAIL_FROM_NAME="${APP_NAME}"
```

### Типичные команды обслуживания

```bash
# Очистка кэша
/opt/php83/bin/php artisan cache:clear
/opt/php83/bin/php artisan config:clear
/opt/php83/bin/php artisan view:clear

# Просмотр логов
tail -f storage/logs/laravel.log
tail -f /var/www/moonny_art_usr/data/logs/error.log

# Проверка статуса
/opt/php83/bin/php artisan about
/opt/php83/bin/php artisan migrate:status

# Права доступа (при проблемах)
chmod -R 755 storage bootstrap/cache
```

### Полезные алиасы для .bashrc

Чтобы не писать полные пути, добавьте в `~/.bashrc`:
```bash
alias php='/opt/php83/bin/php'
alias composer='/opt/php83/bin/php /usr/local/bin/composer'
alias artisan='/opt/php83/bin/php artisan'
alias cdweb='cd /var/www/moonny_art_usr/data/www/moonny.art'
```

После добавления: `source ~/.bashrc`

### Справочные материалы

- **Полная документация**: `script_ai/server_commands.md` — детальный справочник команд
- **Скрипт развертывания**: `script_ai/deploy_to_server.bat` — автоматизация для Windows

### Требования сервера (проверено ✓)

- ✓ PHP 8.3.17 с OPcache
- ✓ Composer 2.9.1
- ✓ MySQL 5.7.42
- ✓ Расширения: pdo_mysql, mbstring, xml, curl, zip, gd, intl
- ✓ SSH доступ настроен

---

**Версия документа**: 1.4 (обновлено 2026-02-03)