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

REM Получение текущей даты и времени
for /f "tokens=*" %%i in ('powershell -Command "Get-Date -Format 'yyyy-MM-dd HH:mm:ss'"') do set DATETIME=%%i

REM Коммит изменений
echo [0/7] Коммит изменений в Git...
git add .
git commit -m "Dev Deploy %DATETIME%"
if %errorlevel% equ 0 (
    echo Коммит создан: Dev Deploy %DATETIME%
) else (
    echo Нет изменений для коммита или ошибка
)
git push origin dev
if %errorlevel% neq 0 (
    echo ВНИМАНИЕ: Ошибка при push в репозиторий
    echo Продолжить деплой? (Ctrl+C для отмены)
    pause
)
echo OK
echo.

REM Проверка подключения
echo [1/7] Проверка SSH подключения...
ssh %USER%@%SERVER% "echo 'SSH OK'"
if %errorlevel% neq 0 (
    echo Ошибка: не удалось подключиться к серверу
    exit /b 1
)
echo OK
echo.

REM Резервная копия текущего index.php
echo [2/7] Создание резервной копии...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && cp index.php index.php.backup.$(date +%%Y%%m%%d_%%H%%M%%S) 2>/dev/null || true"
echo OK
echo.

REM Загрузка проекта через Git pull
echo [3/7] Обновление кода на сервере через Git...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && git pull origin dev"
if %errorlevel% neq 0 (
    echo Ошибка: не удалось обновить код через Git
    exit /b 1
)
echo OK
echo.

REM Установка зависимостей
echo [4/7] Установка зависимостей через Composer...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && %PHP% /usr/local/bin/composer install --no-dev --optimize-autoloader"
echo OK
echo.

REM Настройка прав доступа
echo [5/7] Настройка прав доступа...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && chmod -R 755 storage bootstrap/cache"
echo OK
echo.

REM Сборка фронтенда
echo [6/7] Сборка фронтенда...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && npm install && npm run build"
echo OK
echo.

REM Проверка конфигурации Laravel и очистка кэша
echo [7/7] Очистка кэша и проверка конфигурации...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && %PHP% artisan config:cache && %PHP% artisan route:cache && %PHP% artisan view:cache && %PHP% artisan --version"
echo OK
echo.

echo ================================
echo Развертывание завершено!
echo ================================
echo.
echo Проект успешно развернут на https://moonny.art
echo Время деплоя: %DATETIME%
echo.
pause
