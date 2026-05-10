-- Run once in Ubuntu WSL (enter your sudo password when prompted):
--   sudo mysql < /home/zhupa/projects/laravel-jquery-pos-beginners/database/wsl_mysql_once.sql
-- If you only use the Windows copy of the repo, use that path instead.

CREATE DATABASE IF NOT EXISTS laravel_jquery_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'laravel'@'127.0.0.1' IDENTIFIED BY 'secret';
CREATE USER IF NOT EXISTS 'laravel'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON laravel_jquery_pos.* TO 'laravel'@'127.0.0.1';
GRANT ALL PRIVILEGES ON laravel_jquery_pos.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
