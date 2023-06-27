@echo off
title FileShare
cd %~dp0

start /B "setup" php -c FileShare.ini createDB.php
start /B "server" php -c FileShare.ini -S 0.0.0.0:8000
start /B "cleanup" php -c FileShare.ini cleanup.php

taskkill /f /im server
taskkill /f /im cleanup

:cleanup
tasklist | findstr /i "server cleanup" >nul
if %errorlevel% equ 0 (
    timeout /t 1 >nul
    goto cleanup
)

exit