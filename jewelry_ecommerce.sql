-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 27, 2025 at 03:22 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jewelry_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_client_cart` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-04-14 23:16:35', '2025-04-14 23:16:35'),
(2, 9, '2025-04-26 14:15:49', '2025-04-26 14:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_product_in_cart` (`cart_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `added_at`) VALUES
(14, 2, 6, 1, '2025-04-26 15:03:32'),
(4, 1, 6, 1, '2025-04-21 07:41:45'),
(16, 2, 12, 1, '2025-04-26 15:03:51'),
(15, 2, 10, 1, '2025-04-26 15:03:43'),
(17, 2, 73, 1, '2025-04-27 09:15:18'),
(18, 2, 74, 1, '2025-04-27 14:26:13');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` enum('admin','client') NOT NULL DEFAULT 'client',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `email`, `password_hash`, `created_at`, `updated_at`, `role`) VALUES
(2, 'fname', 'lname', 'fname@gmail.com', '$2y$10$OUQkkr1xx79yy5cSYhvpXeWpvU3OMltV61ThVlONzWgSZX5xwGqaG', '2025-04-13 16:44:18', '2025-04-13 16:44:18', 'client'),
(4, 'user3', 'user', 'user3@gmail.com', '$2y$10$kuFICSKAUEs9RojzuQz8E.AcdjAvZHeTOMD8jOjDMsBlSmT1iHHnq', '2025-04-14 23:29:06', '2025-04-14 23:29:06', 'client'),
(5, 'user3', 'user', 'user4@gmail.com', '$2y$10$6MvV7BiTTsHeTWv/i8yW5uEKoXaDPLMq0GCDAZ7YQNJ0oVpY/W9BO', '2025-04-14 23:35:38', '2025-04-14 23:35:38', 'client'),
(6, 'xxxxx', 'yyyyyy', 'y@gmail.com', '$2y$10$4K4iOspJPWkXu9aCLdqmLeEwsCmKblCs4wn/7wn9Y5MWjL/UYxeLW', '2025-04-14 23:37:45', '2025-04-14 23:37:45', 'client'),
(8, 'chaimaa', 'kefi', 'shaimakefi2@gmail.com', '$2y$10$r0kZXnbaTYBi6lE1v9qd6OoWcWvHERdwp58pU95.fzmPL7jCyfiwC', '2025-04-24 14:18:23', '2025-04-24 14:18:23', 'client'),
(9, 'Admin', 'User', 'admin@example.com', '$2y$10$t2SskZRayGN4fyn7IZknY.mLgZLISXfT9MfSJcsJROyKTK90wEDZO', '2025-04-24 14:36:55', '2025-04-24 14:36:55', 'admin'),
(10, 'ahmed', 'salhi', 'ahmed@gmail.com', '$2y$10$FHEV26WCEGU7ARpvVPWqmuy0R3Zi80EB4ETS7n3bc6MxRS/hWzrby', '2025-04-24 14:50:53', '2025-04-24 14:50:53', 'client'),
(11, 'chaimaa2', 'kefi', 'shaimakefi@gmail.com', '$2y$10$sR09i8.jqhRuTqWUMr5j5eSdc0x/1UYxNa7a6ESFUFpi1DavcbPB6', '2025-04-25 05:34:47', '2025-04-25 05:34:47', 'client'),
(12, 'chaimaa2', 'kefi', 'chaimakefi@gmail.com', '$2y$10$kdFfN9UR0mLwOhTHXWPEIukKMiAMCJGONOJIf.jIpceOVQUVN7Y52', '2025-04-25 05:38:05', '2025-04-25 05:38:05', 'client');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `shipping_address` text,
  `billing_address` text,
  `payment_method` varchar(50) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_orders_client` (`client_id`),
  KEY `idx_orders_status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `idx_order_items_order` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Completed','Failed','Refunded') DEFAULT 'Pending',
  `payment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `category` enum('Ring','Earring','Necklace','Bracelet') NOT NULL,
  `gem_type` enum('Diamond','Pearl','Opal','Lapis','Ruby','Emerald','Amethyst','Sapphire') NOT NULL,
  `size` varchar(20) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `availability` enum('In Stock','Out of Stock') DEFAULT 'In Stock',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_products_category` (`category`),
  KEY `idx_products_gem_type` (`gem_type`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `discount_price`, `category`, `gem_type`, `size`, `image_path`, `availability`, `created_at`, `updated_at`) VALUES
(75, 'p3', 'sddq', 20.00, 10.00, 'Earring', 'Diamond', 'x', '/web/cartiboi/image/bracelet/amethyst%20b1.jpg', 'In Stock', '2025-04-26 14:15:00', '2025-04-26 14:15:00'),
(80, 'dsDs', 'DZSF', 45.00, 30.00, 'Bracelet', 'Lapis', '4', '/web/cartiboi/image/bracelet/amethyst%20b1.jpg', 'In Stock', '2025-04-27 09:14:50', '2025-04-27 09:14:50'),
(81, 'jjsl', 'sqDd', 10.00, NULL, 'Necklace', 'Ruby', '4', '/web/cartiboi/image/bracelet/amethyst%20b1.jpg', 'In Stock', '2025-04-27 09:14:54', '2025-04-27 09:14:54'),
(82, 'dsDs', 'DZSF', 45.00, 30.00, 'Bracelet', 'Lapis', '4', '/web/cartiboi/image/bracelet/amethyst%20b1.jpg', 'In Stock', '2025-04-27 09:14:54', '2025-04-27 09:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_email` varchar(100) NOT NULL,
  `review` text NOT NULL,
  `review_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `client_email` (`client_email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
