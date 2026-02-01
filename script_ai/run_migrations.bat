@echo off
REM Скрипт для запуска миграций Laravel
cd ..
php artisan migrate --force
pause