-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2026 at 04:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `ip_address`, `created_at`) VALUES
(1, 5, 'Création', 'Vente', 'Nouvelle vente enregistrée (ID : 15)', '::1', '2026-04-09 14:49:39'),
(2, 5, 'Désactivation', 'Utilisateur', 'Désactivation du compte ID : 6', '::1', '2026-04-09 14:53:56'),
(3, 5, 'Activation', 'Utilisateur', 'Activation du compte ID : 6', '::1', '2026-04-09 14:54:03'),
(4, 5, 'Désactivation', 'Utilisateur', 'Désactivation du compte ID : 6', '::1', '2026-04-09 14:54:09'),
(5, 7, 'Création', 'Vente', 'Nouvelle vente enregistrée (ID : 16)', '::1', '2026-04-09 14:59:58'),
(6, 7, 'Modification', 'Profil', 'Modification des informations personnelles', '::1', '2026-04-09 15:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Épicerie', 'Produits alimentaires secs et conserves', '2026-03-30 21:11:47'),
(2, 'Produits frais', 'Produits réfrigérés : yaourts, fromages, charcuterie', '2026-03-30 21:11:47'),
(3, 'Produits congelés', 'Aliments surgelés', '2026-03-30 21:11:47'),
(4, 'Fruits & Légumes', 'Produits agricoles frais', '2026-03-30 21:11:47'),
(5, 'Viandes & Poissons', 'Produits carnés et poissons', '2026-03-30 21:11:47'),
(6, 'Boulangerie & Pâtisserie', 'Pain, viennoiseries et pâtisseries', '2026-03-30 21:11:47'),
(7, 'Boissons', 'Boissons diverses non alcoolisées', '2026-03-30 21:11:47'),
(8, 'Eau', 'Eaux plates et gazeuses', '2026-03-30 21:11:47'),
(9, 'Snacks & Confiseries', 'Chips, biscuits, bonbons, chocolats', '2026-03-30 21:11:47'),
(10, 'Hygiène & Beauté', 'Produits d’hygiène corporelle et cosmétiques', '2026-03-30 21:11:47'),
(11, 'Entretien & Nettoyage', 'Produits ménagers et d’entretien', '2026-03-30 21:11:47'),
(12, 'Maison & Cuisine', 'Ustensiles et accessoires pour la maison', '2026-03-30 21:11:47'),
(13, 'Bébé', 'Produits alimentaires et hygiène pour bébés', '2026-03-30 21:11:47'),
(14, 'Animaux', 'Nourriture et accessoires pour animaux', '2026-03-30 21:11:47'),
(15, 'Électronique', 'Piles, lampes, petits accessoires électroniques', '2026-03-30 21:11:47'),
(16, 'Autres', 'Articles divers non classés', '2026-03-30 21:11:47');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `created_at`) VALUES
(1, 'Noe Swedi', '0978373738', 'golf-malela', '2026-04-07 22:00:00'),
(2, 'Emil', '+243995530219', 'golf-meteo', '2026-04-07 22:00:00'),
(3, 'Jonathan Swedi', '+243995530219', 'golf-malela', '2026-04-07 22:00:00'),
(4, 'Jonathan Swedi', '+243995530219', 'golf-malela', '2026-04-07 22:00:00'),
(5, 'Miguel', '0978373735', 'golf-batan', '2026-04-07 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `barcode` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `purchase_price`, `quantity`, `barcode`, `category_id`, `created_at`) VALUES
(2, 'Eau', 'Eaux plates', 200.00, 400.00, 67, '444444', 8, '2026-03-30 20:36:00'),
(6, 'whisky', 'alcool', 30.00, 60.00, 5, '12345', 7, '2026-04-07 12:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'admin', 'Administrateur du système', '2026-04-07 06:20:07'),
(2, 'manager', 'Gérant du magasin', '2026-04-07 06:20:07'),
(3, 'responsable_stock', 'Responsable du stock', '2026-04-07 06:20:07'),
(4, 'magasinier', 'Gestionnaire des entrées et sorties de stock', '2026-04-07 06:20:07'),
(5, 'caissier', 'Responsable des ventes en caisse', '2026-04-07 06:20:07'),
(6, 'vendeur', 'Vendeur en boutique', '2026-04-07 06:20:07'),
(7, 'comptable', 'Accès aux rapports financiers', '2026-04-07 06:20:07'),
(8, 'auditeur', 'Contrôle et audit du stock', '2026-04-07 06:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` enum('cash','mobile') NOT NULL DEFAULT 'cash'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `created_at`, `total_amount`, `payment_method`) VALUES
(1, 5, '2026-04-07 09:22:27', 0.00, 'cash'),
(2, 5, '2026-04-07 13:02:17', 490.00, 'cash'),
(3, 5, '2026-04-07 13:17:26', 260.00, 'cash'),
(4, 7, '2026-04-07 13:22:34', 260.00, 'mobile'),
(5, 5, '2026-04-07 13:54:29', 30.00, 'cash'),
(6, 7, '2026-04-07 13:55:22', 200.00, 'mobile'),
(7, 7, '2026-04-07 14:18:30', 30.00, 'cash'),
(8, 7, '2026-04-07 14:43:08', 830.00, 'cash'),
(9, 5, '2026-04-07 18:17:18', 30.00, 'mobile'),
(10, 7, '2026-04-07 18:19:43', 830.00, 'cash'),
(11, 5, '2026-04-07 18:23:47', 430.00, 'mobile'),
(12, 5, '2026-04-08 06:06:47', 30.00, 'mobile'),
(13, 5, '2026-04-09 11:47:06', 2000.00, 'cash'),
(14, 5, '2026-04-09 12:45:54', 800.00, 'cash'),
(15, 5, '2026-04-09 12:49:39', 200.00, 'cash'),
(16, 7, '2026-04-09 12:59:58', 230.00, 'mobile');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `total_price`) VALUES
(1, 2, 2, 2, 200.00, 400.00),
(2, 2, 6, 3, 30.00, 90.00),
(3, 3, 2, 1, 200.00, 200.00),
(4, 3, 6, 2, 30.00, 60.00),
(5, 4, 2, 1, 200.00, 200.00),
(6, 4, 6, 2, 30.00, 60.00),
(7, 5, 6, 1, 30.00, 30.00),
(8, 6, 2, 1, 200.00, 200.00),
(9, 7, 6, 1, 30.00, 30.00),
(10, 8, 6, 1, 30.00, 30.00),
(11, 8, 2, 4, 200.00, 800.00),
(12, 9, 6, 1, 30.00, 30.00),
(13, 10, 2, 4, 200.00, 800.00),
(14, 10, 6, 1, 30.00, 30.00),
(15, 11, 6, 1, 30.00, 30.00),
(16, 11, 2, 2, 200.00, 400.00),
(17, 12, 6, 1, 30.00, 30.00),
(18, 13, 2, 10, 200.00, 2000.00),
(19, 14, 2, 4, 200.00, 800.00),
(20, 15, 2, 1, 200.00, 200.00),
(21, 16, 2, 1, 200.00, 200.00),
(22, 16, 6, 1, 30.00, 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `email`, `address`, `created_at`) VALUES
(1, 'john dupond', '+243995530219', 'johndupond@gmail.com', 'golf-malela', '2026-04-07 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role_id` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `role_id`, `is_active`) VALUES
(5, 'Jonathan Swedi', 'jonathan.swedi@graaentreprises.com', '$2y$10$1vY6Za3ee4f75mZHuOji/ueaCJ4pAPsrxzawsgH0IwyywKL4CumnK', 'staff', '2026-04-07 07:10:34', 1, 1),
(6, 'Gloire Swedi', 'gloire@gmail.com', '$2y$10$UNdrMte0HW0vf2AE5RMqR.AI3Fv5.nJCeHQ7gvR/T.Y8qPplg44le', 'staff', '2026-04-07 07:18:47', 8, 0),
(7, 'Clara Binti Mbombo', 'clarabinti@gmail.com', '$2y$10$pvDhUPLxrVpe6V3WrMPqmuJtyZnsIGhTz/lw7fZoofiTq/NSw4N4K', 'staff', '2026-04-07 08:36:17', 6, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sales_user` (`user_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sale_items_sale` (`sale_id`),
  ADD KEY `fk_sale_items_product` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sales_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `fk_sale_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_sale_items_sale` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
