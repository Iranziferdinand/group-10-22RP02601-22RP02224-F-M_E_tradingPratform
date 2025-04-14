-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 09:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_trading_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_samuel@gmail.com|127.0.0.1', 'i:1;', 1744138108),
('laravel_cache_samuel@gmail.com|127.0.0.1:timer', 'i:1744138108;', 1744138108);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '0001_01_01_000000_create_users_table', 1),
(9, '0001_01_01_000001_create_cache_table', 1),
(10, '0001_01_01_000002_create_jobs_table', 1),
(11, '2025_03_28_154251_create_user_table', 1),
(12, '2025_03_28_173250_create_products_table', 2),
(13, '2025_03_29_100310_create_stocks_table', 3),
(14, '2025_03_29_113957_create_stock_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('iranziferdinand845@gmail.com', '$2y$12$Qfwd86xRXrHidNbomN5kSOe4Vl8IVwHh0G4TKhQrmDYYWcN3Rh7xS', '2025-04-06 17:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT '',
  `price` decimal(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `image`, `created_at`, `updated_at`) VALUES
(2, 'laptop', 'lenovo laptop', 500000.00, 6, 'product_images/8PTTkZRLHn9igWUwpMbtUEpJ7T0ozcTuDQ06AwYV.jpg', '2025-03-28 16:18:12', '2025-03-29 10:28:12'),
(3, 'cassava', 'fresh cassava', 200.00, 980, 'product_images/iPVhYy0ty3kVglfK1wbuSYKremHG15nr7CSy6PCD.jpg', '2025-03-28 16:22:12', '2025-04-02 11:03:13'),
(4, 'cooking oil', 'erayo cooking oil', 5000.00, 1, 'product_images/4YEZb1xthCIGMgmdwETIWewtE3rBOQOary0K8uk7.jpg', '2025-03-28 16:23:13', '2025-03-29 10:21:58'),
(5, 'Camera', 'canon camera with 240px', 1000.00, 2, 'product_images/J4Fo2EvghFNs6AjmuAyJIwfvnuxr0d6hn8yECuKS.jpg', '2025-03-28 17:03:10', '2025-03-28 17:03:10'),
(6, 'phone', 'Iphone', 10000.00, 0, 'product_images/vXLPshv3seVcnXrSRJJSga7GXT2IKhpwgHBNoWwF.jpg', '2025-03-28 17:04:37', '2025-04-01 14:11:50'),
(7, 'raspberry', 'raspbery pi3', 100.00, 4, 'product_images/sJ8brwQEL6GGZH0S1pmLsk2bR6HkSk1EfnaRVktu.jpg', '2025-03-29 06:50:43', '2025-04-02 03:51:54'),
(11, 'mangoes', '', 200.00, 298, 'products/sn2sNIhynJszconRx6VzErVZi9y7MGdd5cCI9eCD.jpg', '2025-04-02 10:33:08', '2025-04-08 17:21:20'),
(12, 'mangoes', '', 200.00, 295, 'products/EbZ8XWJhbGMD9VX4F9tCMJnBDQttis6hA4sOv0ZE.jpg', '2025-04-02 11:00:48', '2025-04-02 11:47:50'),
(13, 'shoes', '', 350.00, 9, 'products/tdF85TntC8OwWVPnIshuCUaHDpGSPGXCijOGkB2i.jpg', '2025-04-02 11:06:36', '2025-04-02 11:07:21'),
(14, 'patatoes', '', 3700.00, 23, 'products/89pyRbWJKDVgyMEulByAmN5JoDQUD5TW5aPd5KIA.jpg', '2025-04-02 11:10:22', '2025-04-02 11:10:22'),
(17, 'Car', '', 80.50, 19, 'products/R3DLLZp7oQETxgNqfLzuKxqcr3CDIcPmOPINTLyp.jpg', '2025-04-08 16:29:33', '2025-04-08 17:19:57'),
(18, 'Shoes', '', 23.00, 100, 'products/7gR0kaRNWCNhHoqYYHpp0yCLLztvMaH7E4OmhCia.jpg', '2025-04-08 16:30:29', '2025-04-08 16:30:29');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4LL6Wswm3oN8nSRhvy74oTsTB7kCN1imBU1oYf0i', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZHY4OU9zbkh6WEVsUHhOQ1lWbVk4NVVLYlVUUUNKeHBLRkNXMG5KNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NDQxMzg0Nzk7fX0=', 1744140081),
('6qCUHvxYAwkqVQzDQGHLPMZd2HnZvpc6FwPrEUSw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZEY3eUlGUXdOdW9nTE1lT2NlY2hDNG0xT3hPOVNFdnFzZlZuNWtHNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1743603034),
('bg6cc23dMbsGQw4zVBeT3Ax0HWj0hK0MgLeAcf7X', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjlLVDBmUmpONE1GbFZJUnFlU2RUSUxXR2N3akhMQ0UwSjF5RVJSZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wYXNzd29yZC9yZXNldCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1743966173),
('TMtyShWVo9ULyQsQ8gjNnjBdr69yOl8CyAShIwjt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSjk2ZlV4c0htRlFvU1YyWkZBUkNRblNzZ1hGODdBVnREWjFleUZUayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1743702112),
('WdgMPr3bypQXwWh4ctcKKb09NXcUnb3FKdWoD2rl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMnRmZmhmUjFTUTJNZEJEaUc0Vm5vT0l3S0VXYzdXS2Q2UGlMMXU1cSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1743962781);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `quantity`, `total_price`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 5000.00, 1, '2025-03-29 10:21:58', '2025-03-29 10:21:58'),
(2, 6, 2, 20000.00, 1, '2025-03-29 10:22:50', '2025-03-29 10:22:50'),
(3, 2, 1, 500000.00, 1, '2025-03-29 10:28:12', '2025-03-29 10:28:12'),
(4, 6, 3, 30000.00, 1, '2025-04-01 14:11:50', '2025-04-01 14:11:50'),
(5, 7, 1, 100.00, 1, '2025-04-02 03:51:53', '2025-04-02 03:51:53'),
(6, 3, 3, 600.00, 1, '2025-04-02 10:04:25', '2025-04-02 10:04:25'),
(7, 3, 2, 400.00, 1, '2025-04-02 10:52:36', '2025-04-02 10:52:36'),
(8, 3, 2, 400.00, 1, '2025-04-02 10:52:47', '2025-04-02 10:52:47'),
(9, 3, 4, 800.00, 1, '2025-04-02 11:02:44', '2025-04-02 11:02:44'),
(10, 3, 9, 1800.00, 1, '2025-04-02 11:03:13', '2025-04-02 11:03:13'),
(11, 13, 1, 350.00, 1, '2025-04-02 11:07:21', '2025-04-02 11:07:21'),
(12, 12, 5, 1000.00, 1, '2025-04-02 11:47:50', '2025-04-02 11:47:50'),
(13, 17, 1, 80.50, 1, '2025-04-08 17:19:57', '2025-04-08 17:19:57'),
(14, 11, 2, 400.00, 1, '2025-04-08 17:21:20', '2025-04-08 17:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ferdinand', 'iranziferdinand845@gmail.com', NULL, '$2y$12$PjY0HHHFqrk8ca8w1..sdOwV56qtv4.QA3c73m7.Ty0U6hVK4.rea', 't3wkUkXBWH7LUI4UMX5GsySdwNNlpaZqTfwgAOuGiSpRraq3AUzOf8v1Hhw2', '2025-03-28 15:20:46', '2025-03-28 15:20:46'),
(4, 'samuel', 'samuel@gmail.com', NULL, '$2y$12$F.c4gejXNFY8wh7GjD8yGe9k6ct9bonF3cS5Ijd4BeutaJWTxx6Si', NULL, '2025-04-08 16:48:44', '2025-04-08 16:48:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_product_id_foreign` (`product_id`),
  ADD KEY `stock_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stock_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
