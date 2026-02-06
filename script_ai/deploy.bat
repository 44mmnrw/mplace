@echo off
chcp 65001 > nul
echo ================================================
echo   Автоматический деплой на moonny.art
echo ================================================
echo.

REM 1. Проверка незакоммиченных изменений
echo [1/7] Проверка изменений...
git status --short
if %errorlevel% neq 0 (
    echo ОШИБКА: Не удалось проверить статус Git
    pause
    exit /b 1
)
echo.

REM 2. Добавление всех изменений
echo [2/7] Добавление файлов в Git...
git add -A
if %errorlevel% neq 0 (
    echo ОШИБКА: Не удалось добавить файлы
    pause
    exit /b 1
)
echo.

REM 3. Коммит с сообщением
set /p commit_msg="Введите сообщение коммита (или Enter для 'Auto deploy'): "
if "%commit_msg%"=="" set commit_msg=Auto deploy

echo [3/7] Создание коммита: %commit_msg%
git commit -m "%commit_msg%"
if %errorlevel% neq 0 (
    echo ВНИМАНИЕ: Нет изменений для коммита или ошибка
)
echo.

REM 4. Пуш в GitHub
echo [4/6] Отправка изменений в GitHub (ветка dev)...
git push origin dev
if %errorlevel% neq 0 (
    echo ОШИБКА: Не удалось отправить изменения в GitHub
    pause
    exit /b 1
)
echo.

REM 5. Локальная сборка фронтенда
echo [5/6] Сборка фронтенда локально (Node.js на сервере устарел - GLIBC 2.27)...
call npm run build
if %errorlevel% neq 0 (
    echo ОШИБКА: Не удалось собрать фронтенд
    pause
    exit /b 1
)
echo.

REM 6. Обновление на сервере (git pull + загрузка сборки + кэш)
echo [6/6] Обновление кода на сервере...
ssh moonny_art_usr@212.113.120.197 "cd /var/www/moonny_art_usr/data/www/moonny.art && git pull origin dev && /opt/php83/bin/php artisan route:clear && /opt/php83/bin/php artisan config:clear && /opt/php83/bin/php artisan view:clear && /opt/php83/bin/php artisan route:cache && /opt/php83/bin/php artisan config:cache && echo 'Код обновлен на сервере'"
if %errorlevel% neq 0 (
    echo ОШИБКА: Не удалось обновить код на сервере
    pause
    exit /b 1
)

echo Загрузка собранного фронтенда...
scp -r ../public/build moonny_art_usr@212.113.120.197:/var/www/moonny_art_usr/data/www/moonny.art/public/
if %errorlevel% neq 0 (
    echo ОШИБКА: Не удалось загрузить фронтенд
    pause
    exit /b 1
)
echo.

echo ================================================
echo   ✓ Деплой завершен успешно!
echo   Сайт: https://moonny.art
echo ================================================
pause
