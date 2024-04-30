CREATE DATABASE IF NOT EXISTS `cityswap` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE USER 'cityswap'@'%' IDENTIFIED BY 'cityswap';
GRANT ALL PRIVILEGES ON `cityswap`.* TO 'cityswap'@'%';

CREATE USER 'cityswap'@'localhost' IDENTIFIED BY 'cityswap';
GRANT ALL PRIVILEGES ON `cityswap`.* TO 'cityswap'@'localhost';