@echo off
REM Скрипт развертывания Laravel проекта на сервер moonny.art
REM PHP 8.3 находится по адресу /opt/php83/bin/php

echo ================================
echo Развертывание проекта на сервер
echo ================================
echo.

set SERVER=212.113.120.197
set USER=moonny_art_usr
set REMOTE_PATH=/var/www/moonny_art_usr/data/www/moonny.art
set PHP=/opt/php83/bin/php

REM Проверка подключения
echo [1/6] Проверка SSH подключения...
ssh %USER%@%SERVER% "echo 'SSH OK'"
if %errorlevel% neq 0 (
    echo Ошибка: не удалось подключиться к серверу
    exit /b 1
)
echo OK
echo.

REM Резервная копия текущего index.php
echo [2/6] Создание резервной копии...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && cp index.php index.php.backup.$(date +%%Y%%m%%d_%%H%%M%%S) 2>/dev/null || true"
echo OK
echo.

REM Загрузка проекта (без node_modules и vendor)
echo [3/6] Загрузка файлов проекта (это может занять несколько минут)...
echo ВАЖНО: Убедитесь, что у вас настроен .gitignore для исключения:
echo   - vendor/
echo   - node_modules/
echo   - storage/
echo   - .env
echo.
echo Используйте rsync или Git для загрузки файлов:
echo   rsync -avz --exclude 'vendor' --exclude 'node_modules' --exclude 'storage' --exclude '.env' ./ %USER%@%SERVER%:%REMOTE_PATH%/
echo   ИЛИ
echo   git clone [репозиторий] на сервере
echo.
pause

REM Установка зависимостей
echo [4/6] Установка зависимостей через Composer...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && %PHP% /usr/local/bin/composer install --no-dev --optimize-autoloader"
echo OK
echo.

REM Настройка прав доступа
echo [5/6] Настройка прав доступа...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && chmod -R 755 storage bootstrap/cache"
echo OK
echo.

REM Проверка конфигурации Laravel
echo [6/6] Проверка конфигурации Laravel...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && %PHP% artisan --version"
echo OK
echo.

echo ================================
echo Развертывание завершено!
echo ================================
echo.
echo Следующие шаги:
echo 1. Настройте файл .env на сервере
echo 2. Запустите миграции: php artisan migrate --force
echo 3. Соберите фронтенд: npm install ^&^& npm run build
echo 4. Очистите кэш: php artisan config:cache
echo.
pause
