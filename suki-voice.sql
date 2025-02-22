-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2025 at 02:24 PM
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
-- Database: `suki-voice`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `full_name`, `address`, `email`, `phone_number`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'salim Said', 'mikocheni', 'salim@oxoafrica.com', '', 1, '2025-02-22 09:01:17', '2025-02-22 09:59:24'),
(3, 'test', 'sdf', 'sdf', '7888', 0, '2025-02-22 09:44:21', '2025-02-22 09:44:50'),
(4, 'Muniru Mrisho', 'Tabata', 'muniru@gmail.com', '7744778458', 0, '2025-02-22 09:45:21', '2025-02-22 09:59:02'),
(6, 'Muhidin', 'Mikocheni', 'muhi@gmail.com', '858777', 0, '2025-02-22 09:57:09', '2025-02-22 09:57:09');

-- --------------------------------------------------------

--
-- Table structure for table `networks`
--
DROP TABLE IF EXISTS `networks`;
CREATE TABLE `networks` (
  `id` int(11) NOT NULL,
  `network` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `networks`
--

INSERT INTO `networks` (`id`, `network`) VALUES
(1, 'Vodacom'),
(2, 'Yas');

-- --------------------------------------------------------

--
-- Table structure for table `terminals`
--
DROP TABLE IF EXISTS `terminals`;
CREATE TABLE `terminals` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `serial_number` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminals`
--

INSERT INTO `terminals` (`id`, `client_id`, `serial_number`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Q181F1100047709361', 1, '2025-02-22 09:12:32', '2025-02-22 13:05:18'),
(3, 2, 'Q181D1238991237812', 1, '2025-02-22 11:12:54', '2025-02-22 12:46:05'),
(5, 4, 'Q1812347823423', 1, '2025-02-22 12:02:59', '2025-02-22 12:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `tills`
--
DROP TABLE IF EXISTS `tills`;
CREATE TABLE `tills` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `till_number` int(11) DEFAULT NULL,
  `network_id` int(11) NOT NULL,
  `terminal_id` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tills`
--

INSERT INTO `tills` (`id`, `client_id`, `till_number`, `network_id`, `terminal_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 88687, 1, 1, 1, '2025-02-22 09:08:23', '2025-02-22 10:06:45'),
(2, 4, 14858, 1, 5, 1, '2025-02-22 10:58:07', '2025-02-22 12:30:52'),
(4, 2, 1000, 2, 1, 1, '2025-02-22 12:03:44', '2025-02-22 12:30:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `networks`
--
ALTER TABLE `networks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terminals`
--
ALTER TABLE `terminals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tills`
--
ALTER TABLE `tills`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `networks`
--
ALTER TABLE `networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `terminals`
--
ALTER TABLE `terminals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tills`
--
ALTER TABLE `tills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
