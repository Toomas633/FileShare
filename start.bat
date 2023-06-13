@echo off
title FileShare
cd %~dp0

start /B "setup" php createDB.php -c FileShare.ini
start /B "server" php -c FileShare.ini -S 0.0.0.0:8000
start /B "cleanup" python cleanup.py

taskkill /f /im server
taskkill /f /im cleanup

:cleanup
tasklist | findstr /i "server cleanup" >nul
if %errorlevel% equ 0 (
    timeout /t 1 >nul
    goto cleanup
)

exit