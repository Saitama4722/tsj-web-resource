@echo off
chcp 65001 >nul
title Остановка ТСЖ Онлайн

echo Остановка PHP-сервера...
taskkill /F /IM php.exe >nul 2>&1
if %errorlevel% equ 0 (
    echo Сервер остановлен.
) else (
    echo Процесс php.exe не найден или уже остановлен.
)
echo.
pause
