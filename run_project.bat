@echo off
chcp 65001 >nul
title ТСЖ Онлайн — сервер

cd /d "%~dp0"
set "PROJECT_DIR=%CD%"

echo.
echo ========================================
echo   ТСЖ Онлайн — запуск сервера
echo ========================================
echo.

echo Папка проекта: %PROJECT_DIR%
echo.

echo Проверка PHP...
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo [ОШИБКА] PHP не найден. Установите PHP и добавьте его в PATH.
    echo.
    pause
    exit /b 1
)
php -v
echo.

echo Запуск встроенного сервера PHP на http://localhost:8080
echo Корневая папка документа: %PROJECT_DIR%
echo.
echo Не закрывайте это окно. Откройте в браузере:
echo   http://localhost:8080/test.php  — проверка PHP
echo   http://localhost:8080/index.php — главная страница
echo.
echo Для остановки сервера закройте окно или запустите stop_project.bat
echo ========================================
echo.

php -S localhost:8080 -t "%PROJECT_DIR%"

echo.
echo Сервер остановлен.
pause
