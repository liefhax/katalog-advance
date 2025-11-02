-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2025 at 06:37 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `katalog`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 3, '2025-10-14 15:04:03', '2025-10-20 08:48:09'),
(2, 1, 1, 1, '2025-10-14 15:32:07', '2025-10-14 15:32:07'),
(3, 2, 2, 1, '2025-10-20 05:49:37', '2025-10-20 05:49:37'),
(4, 1, 2, 2, '2025-10-20 08:35:57', '2025-10-20 08:47:25');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Kaos & Atasan', 'kaos-atasan'),
(2, 'Celana & Bawahan', 'celana-bawahan'),
(3, 'Outerwear & Jaket', 'outerwear-jaket');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `promo_id` int(11) UNSIGNED DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `final_amount` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `stock`, `is_active`, `category_id`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Kaos Oversized Katun Combed 24s', 'kaos-oversized-katun', 'Kaos gaya urban yang nyaman dipakai seharian. Bahan tebal dan tidak menerawang.', 125000.00, 50, 1, 1, 'https://placehold.co/400x500/f8b400/FFFFFF?text=Kaos+Oversized', NULL, NULL),
(2, 'Kemeja Flanel Lengan Panjang Kotak', 'kemeja-flanel-kotak', 'Kemeja flanel klasik yang tidak pernah ketinggalan zaman. Cocok untuk gaya kasual.', 189000.00, 50, 1, 1, 'https://placehold.co/400x500/c20000/FFFFFF?text=Kemeja+Flanel', NULL, NULL),
(3, 'Polo Shirt Kerah Strip', 'polo-shirt-strip', 'Tampil rapi namun tetap santai dengan polo shirt premium. Bahan adem dengan detail strip di kerah.', 155000.00, 50, 1, 1, 'https://placehold.co/400x500/006494/FFFFFF?text=Polo+Shirt', NULL, NULL),
(4, 'Celana Chino Slim Fit Stretch', 'celana-chino-slim-fit', 'Celana chino serbaguna untuk acara formal maupun santai. Bahan stretch yang nyaman bergerak.', 220000.00, 50, 1, 2, 'https://placehold.co/400x500/8a716a/FFFFFF?text=Celana+Chino', NULL, NULL),
(5, 'Jeans Pria Slim-Fit Washed Blue', 'jeans-slim-fit-blue', 'Jeans andalan untuk setiap gaya. Warna washed blue yang klasik dan mudah dipadukan.', 299000.00, 50, 1, 2, 'https://placehold.co/400x500/003554/FFFFFF?text=Jeans+Pria', NULL, NULL),
(6, 'Celana Kargo Taktis Banyak Saku', 'celana-kargo-taktis', 'Celana kargo fungsional dengan banyak saku. Cocok untuk kegiatan outdoor atau gaya streetwear.', 210000.00, 50, 1, 2, 'https://placehold.co/400x500/585043/FFFFFF?text=Celana+Kargo', NULL, NULL),
(7, 'Jaket Bomber Parasut Anti Angin', 'jaket-bomber-parasut', 'Jaket bomber ringan dari bahan parasut yang efektif menahan angin. Stylish dan fungsional.', 250000.00, 50, 1, 3, 'https://placehold.co/400x500/0b090a/FFFFFF?text=Jaket+Bomber', NULL, NULL),
(8, 'Hoodie Jumper Polos Fleece Tebal', 'hoodie-jumper-polos', 'Hoodie esensial untuk cuaca dingin. Bahan fleece tebal yang hangat dan lembut di kulit.', 199000.00, 50, 1, 3, 'https://placehold.co/400x500/8d99ae/FFFFFF?text=Hoodie', NULL, NULL),
(9, 'Sweater Rajut Kerah Bulat', 'sweater-rajut-kerah-bulat', 'Sweater rajut dengan desain minimalis. Memberikan kesan hangat dan elegan.', 175000.00, 50, 1, 3, 'https://placehold.co/400x500/2b2d42/FFFFFF?text=Sweater', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `min_purchase` decimal(10,2) DEFAULT 0.00,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`id`, `name`, `code`, `description`, `discount_type`, `discount_value`, `min_purchase`, `max_discount`, `usage_limit`, `used_count`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Welcome Discount', 'WELCOME10', 'Discount 10% untuk pembelian pertama', 'percentage', 10.00, 100000.00, 50000.00, 100, 0, '2025-10-01 00:00:00', '2025-12-31 23:59:59', 1, '2025-10-20 16:15:43', NULL),
(2, 'Flash Sale', 'FLASH25', 'Discount flat Rp 25.000', 'fixed', 25000.00, 150000.00, NULL, 50, 0, '2025-10-20 00:00:00', '2025-10-27 23:59:59', 1, '2025-10-20 16:15:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'Budi BUDBUD', 'budi@bud.com', '$2y$10$MHi0Q4BKfuMnbP8AH3/XieWnxIoBVeDHWt4hkv0uge59Mu3A2aVwy', 1, '2025-10-14 13:18:15', '2025-10-14 13:18:15'),
(2, 'Til itil', 'atilah@atil.com', '$2y$10$VXGkxEV3zy28gEn79AOjP.QU7NpjcYaDN7wlMyi9ret9MOLq6mxqi', 0, '2025-10-14 14:25:45', '2025-10-14 14:25:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_user` (`user_id`),
  ADD KEY `fk_cart_product` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `fk_order_user` (`user_id`),
  ADD KEY `fk_order_promo` (`promo_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orderitem_order` (`order_id`),
  ADD KEY `fk_orderitem_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_promo` FOREIGN KEY (`promo_id`) REFERENCES `promos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_orderitem_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderitem_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
