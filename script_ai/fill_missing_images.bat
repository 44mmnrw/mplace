@echo off
chcp 65001 >nul
echo ======================================
echo Заполнение отсутствующих изображений
echo ======================================
echo.
echo Этот скрипт заменит все отсутствующие
echo изображения продуктов на заглушку
echo.
pause
php script_ai\fill_missing_images.php
pause
