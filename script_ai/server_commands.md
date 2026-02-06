# Команды для работы с сервером moonny.art

## Информация о сервере

- **IP**: 212.113.120.197
- **Пользователь**: moonny_art_usr
- **Домашняя директория**: `/var/www/moonny_art_usr/data/`
- **Веб-корень**: `/var/www/moonny_art_usr/data/www/moonny.art/`
- **PHP 8.3**: `/opt/php83/bin/php`
- **Composer**: `/usr/local/bin/composer`

## Подключение

```bash
# SSH подключение
ssh moonny_art_usr@212.113.120.197

# SFTP подключение
sftp moonny_art_usr@212.113.120.197
```

## PHP команды (используйте правильный путь!)

```bash
# CLI версия по умолчанию (PHP 7.2 - НЕ ИСПОЛЬЗОВАТЬ!)
php -v

# Правильная версия PHP 8.3
/opt/php83/bin/php -v

# Composer с PHP 8.3
/opt/php83/bin/php /usr/local/bin/composer install

# Laravel Artisan с PHP 8.3
/opt/php83/bin/php artisan migrate
/opt/php83/bin/php artisan config:cache
/opt/php83/bin/php artisan route:list
```

## Структура установленных PHP

```
/opt/php81/bin/php  # PHP 8.1
/opt/php82/bin/php  # PHP 8.2
/opt/php83/bin/php  # PHP 8.3 ✓ (используем эту)
```

## Развертывание проекта

### Вариант 1: Git Clone (рекомендуется)

```bash
# На сервере
cd /var/www/moonny_art_usr/data/www/moonny.art
git clone [URL_ВАШЕГО_РЕПОЗИТОРИЯ] .

# Установка зависимостей
/opt/php83/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader

# Настройка .env
cp .env.example .env
nano .env  # или используйте vi

# Генерация ключа приложения
/opt/php83/bin/php artisan key:generate

# Права доступа
chmod -R 755 storage bootstrap/cache

# Миграции
/opt/php83/bin/php artisan migrate --force

# Сборка фронтенда (если есть Node.js)
npm install
npm run build

# Кэширование конфигурации
/opt/php83/bin/php artisan config:cache
/opt/php83/bin/php artisan route:cache
/opt/php83/bin/php artisan view:cache
```

### Вариант 2: Rsync с локальной машины

```powershell
# В Windows PowerShell (из корня проекта)
rsync -avz --exclude 'vendor' --exclude 'node_modules' --exclude 'storage/logs/*' --exclude 'storage/framework/cache/*' --exclude '.env' --exclude '.git' ./ moonny_art_usr@212.113.120.197:/var/www/moonny_art_usr/data/www/moonny.art/
```

### Вариант 3: SFTP/FTP

```bash
# Подключение через SFTP
sftp moonny_art_usr@212.113.120.197

# Переход в директорию
cd /var/www/moonny_art_usr/data/www/moonny.art/

# Загрузка файлов
put -r /path/to/local/project/*
```

## Типичные команды обслуживания

```bash
# Очистка кэша
/opt/php83/bin/php artisan cache:clear
/opt/php83/bin/php artisan config:clear
/opt/php83/bin/php artisan route:clear
/opt/php83/bin/php artisan view:clear

# Просмотр логов
tail -f storage/logs/laravel.log
tail -f /var/www/moonny_art_usr/data/logs/error.log

# Проверка статуса
/opt/php83/bin/php artisan about

# Проверка миграций
/opt/php83/bin/php artisan migrate:status

# Права доступа (если возникли проблемы)
chmod -R 755 storage bootstrap/cache
chown -R moonny_art_usr:moonny_art_usr .
```

## Настройка .env для продакшена

```env
APP_NAME="MPlace"
APP_ENV=production
APP_KEY=  # Сгенерируется через artisan key:generate
APP_DEBUG=false
APP_URL=https://moonny.art

# База данных
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=moonny_art
DB_USERNAME=moonny_art
DB_PASSWORD=UF;7nD#sknNiUTiF

# Кэш и очереди
CACHE_DRIVER=file
QUEUE_CONNECTION=database
SESSION_DRIVER=file

# Почта
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@moonny.art
MAIL_FROM_NAME="${APP_NAME}"
```

## Проверка установленных расширений PHP

```bash
/opt/php83/bin/php -m
```

Установлены все необходимые для Laravel расширения:
- ✓ PDO, pdo_mysql, mysqli
- ✓ mbstring, xml
- ✓ curl, gd, zip
- ✓ intl, opcache

## Troubleshooting

### Ошибка "Class not found"
```bash
/opt/php83/bin/php /usr/local/bin/composer dump-autoload
```

### Ошибка прав доступа
```bash
chmod -R 755 storage bootstrap/cache
```

### Проблемы с миграциями
```bash
# Проверить подключение к БД
/opt/php83/bin/php artisan db:show

# Откатить и повторить
/opt/php83/bin/php artisan migrate:fresh --force
```

### 500 Internal Server Error
1. Проверить логи: `tail -f storage/logs/laravel.log`
2. Проверить веб-сервер: `tail -f /var/www/moonny_art_usr/data/logs/error.log`
3. Включить отладку временно: `APP_DEBUG=true` в `.env`

## Полезные алиасы (добавить в ~/.bashrc)

```bash
alias php='/opt/php83/bin/php'
alias composer='/opt/php83/bin/php /usr/local/bin/composer'
alias artisan='/opt/php83/bin/php artisan'
alias cdweb='cd /var/www/moonny_art_usr/data/www/moonny.art'
```

После добавления: `source ~/.bashrc`
