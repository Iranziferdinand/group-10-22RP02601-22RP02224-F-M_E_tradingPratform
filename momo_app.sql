-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 06:15 PM
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
-- Database: `momo_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `Agent_Code` varchar(6) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 500.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `sender_phone` varchar(15) DEFAULT NULL,
  `recipient_phone` varchar(15) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('SEND','WITHDRAW','DEPOSIT') NOT NULL,
  `agent_phone` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `phone_number`, `full_name`, `Agent_Code`, `pin`, `balance`, `created_at`) VALUES
(1, '0788001122', 'Agent John', 'A12345', '$2y$10$iF235T0nu5SZL/D7KtENeuULOG.7fDmD6yqBD/WzR7rrLA2kQTMkW', 500.00, '2025-04-28 08:50:05'),
(2, '0788112233', 'Agent Mary', 'B23456', '$2y$10$B28pTLNCKln.5a97guN58OsIKl3UKSTKcLEvxJuZwvIo8ZAi4fcqC', 500.00, '2025-04-28 08:50:05');

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `sender_phone`, `recipient_phone`, `amount`, `transaction_type`, `agent_phone`, `created_at`) VALUES
(1, NULL, '+250784427150', 500.00, 'DEPOSIT', '0788112233', '2025-04-28 08:50:05'),
(2, '+250784427150', '+250781798011', 300.00, 'SEND', NULL, '2025-04-28 08:54:57'),
(3, '+250784427150', '+250781798011', 100.00, 'SEND', NULL, '2025-04-28 09:26:40');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `phone_number`, `full_name`, `pin`, `balance`) VALUES
(1, '+250781798011', 'Samuel YITAKUBAYO', '$2y$10$iF235T0nu5SZL/D7KtENeuULOG.7fDmD6yqBD/WzR7rrLA2kQTMkW', 400.00),
(2, '+250784427150', 'My dad\'s phone', '$2y$10$B28pTLNCKln.5a97guN58OsIKl3UKSTKcLEvxJuZwvIo8ZAi4fcqC', 100.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_phone` (`sender_phone`),
  ADD KEY `recipient_phone` (`recipient_phone`),
  ADD KEY `agent_phone` (`agent_phone`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`sender_phone`) REFERENCES `users` (`phone_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`recipient_phone`) REFERENCES `users` (`phone_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`agent_phone`) REFERENCES `agents` (`phone_number`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
