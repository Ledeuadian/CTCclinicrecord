-- Fix MySQL/MariaDB authentication method for PHP compatibility
-- Run this in MySQL/MariaDB command line or phpMyAdmin

ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password;
ALTER USER 'root'@'127.0.0.1' IDENTIFIED VIA mysql_native_password;
FLUSH PRIVILEGES;

-- If you have a password for root, set it like this:
-- ALTER USER 'root'@'localhost' IDENTIFIED BY 'your_password' VIA mysql_native_password;
