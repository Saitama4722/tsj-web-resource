@echo off
title Setup TSJ Online Database

echo Importing database...

mysql -u root -p < database.sql

echo Database installed
pause
