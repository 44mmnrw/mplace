@echo off
chcp 65001 >nul
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
set BRANCH=main

REM Получение текущей даты и времени
for /f "tokens=*" %%i in ('powershell -Command "Get-Date -Format 'yyyy-MM-dd HH:mm:ss'"') do set DATETIME=%%i

REM Сборка фронтенда локально
echo [0/10] Сборка фронтенда (production)...
call npm run build
if %errorlevel% neq 0 (
    echo Ошибка: не удалось собрать фронтенд
    exit /b 1
)
echo OK
echo.

REM Коммит изменений (теперь public/build включен в Git)
echo [1/11] Коммит изменений в Git (включая public/build)...
git add -A
git commit -m "Deploy %DATETIME%" --allow-empty
if %errorlevel% neq 0 (
    echo Ошибка при коммите
    exit /b 1
)
echo OK
echo.

REM Push в репозиторий
echo [2/12] Push в репозиторий ветка '%BRANCH%'...
git push origin %BRANCH%
if %errorlevel% neq 0 (
    echo Ошибка при push в репозиторий
    exit /b 1
)
echo OK
echo.

REM Загрузка собранного Vite build через SCP
echo [3/12] Загрузка собранного Vite build на сервер...
scp -r public\build\* %USER%@%SERVER%:%REMOTE_PATH%/public/build/
if %errorlevel% neq 0 (
    echo ВНИМАНИЕ: Ошибка при загрузке build через scp
)
echo OK
echo.

REM Проверка подключения
echo [4/12] Проверка SSH подключения...
ssh %USER%@%SERVER% "echo 'SSH OK'"
if %errorlevel% neq 0 (
    echo Ошибка: не удалось подключиться к серверу
    exit /b 1
)
echo OK
echo.

REM Резервная копия текущего состояния
echo [5/12] Создание резервной копии...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && cp -r . ../moonny.art.backup.$(date +%%Y%%m%%d_%%H%%M%%S) 2>/dev/null || true && echo 'Backup created'"
echo OK
echo.

REM Загрузка проекта через Git pull
echo [6/12] Обновление кода на сервере через Git (ветка %BRANCH%)...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && git fetch origin && git checkout %BRANCH% && git pull origin %BRANCH% --ff-only"
if %errorlevel% neq 0 (
    echo Ошибка: не удалось обновить код через Git
    exit /b 1
)
echo OK
echo.

REM Установка зависимостей
echo [7/12] Установка зависимостей через Composer...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && %PHP% /usr/local/bin/composer install --no-dev --optimize-autoloader --no-interaction"
if %errorlevel% neq 0 (
    echo Ошибка: не удалось установить зависимостей Composer
    exit /b 1
)
echo OK
echo.

REM Настройка прав доступа
echo [8/12] Настройка прав доступа...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && chmod -R 755 storage bootstrap/cache public/storage && chown -R moonny_art_usr:moonny_art_usr . 2>/dev/null || true"
echo OK
echo.

REM Очистка кэша ДО миграций
echo [9/12] Очистка кэша конфигурации...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && %PHP% artisan config:clear && %PHP% artisan cache:clear && %PHP% artisan view:clear"
echo OK
echo.

REM Запуск миграций
echo [10/12] Запуск миграций БД...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && %PHP% artisan migrate --force"
if %errorlevel% neq 0 (
    echo ВНИМАНИЕ: Ошибка при запуске миграций (может быть уже выполнены)
)
echo OK
echo.

REM Создание символической ссылки storage и кэширование конфигурации
echo [11/12] Финализация (storage link, кэширование)...
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && %PHP% artisan storage:link --force 2>/dev/null && %PHP% artisan config:cache && %PHP% artisan route:cache && %PHP% artisan view:cache && %PHP% artisan --version"
echo OK
echo.

REM Проверка manifest.json
echo [12/12] Проверка наличия Vite manifest на сервере...
ssh %USER%@%SERVER% "test -f %REMOTE_PATH%/public/build/manifest.json && echo 'manifest.json OK' || echo 'ВНИМАНИЕ: manifest.json не найден'"
echo OK
echo OK
echo.

echo ================================
echo Развертывание завершено!
echo ================================
echo.
echo Проект успешно развернут на https://moonny.art
echo Ветка: %BRANCH%
echo Время деплоя: %DATETIME%
echo.
echo Проверка статуса на сервере:
ssh %USER%@%SERVER% "cd %REMOTE_PATH% && %PHP% artisan about"
echo.
timeout /t 5 /nobreak
echo.
pause
