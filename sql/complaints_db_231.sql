-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2023 at 08:10 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `complaints_db_231`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories_table`
--

CREATE TABLE `categories_table` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories_table`
--

INSERT INTO `categories_table` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Personal Issue', '2023-01-10 13:26:13', '2023-01-10 13:45:16', '2023-01-10 13:45:16'),
(3, 'Electricity Issue', '2023-01-10 13:47:39', '2023-01-10 13:47:54', NULL),
(4, 'Water Bill', '2023-01-10 17:32:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `state_table`
--

CREATE TABLE `state_table` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `state_table`
--

INSERT INTO `state_table` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Orrisa', '2023-01-10 14:02:27', '2023-01-10 14:20:29', NULL),
(2, 'Chhattisgarh', '2023-01-10 14:18:10', NULL, NULL),
(3, 'Delhi', '2023-01-11 06:03:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories_table`
--

CREATE TABLE `subcategories_table` (
  `id` bigint(255) NOT NULL,
  `name` text NOT NULL,
  `category` bigint(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategories_table`
--

INSERT INTO `subcategories_table` (`id`, `name`, `category`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'House Electricity', 3, '2023-01-10 14:40:38', '2023-01-10 17:44:16', NULL),
(2, 'Sub Electric Bill', 3, '2023-01-10 17:34:15', '2023-01-10 17:47:49', '2023-01-10 17:47:49'),
(3, 'Water High Rate', 4, '2023-01-11 06:03:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT 0 COMMENT ' 1-godfather, 2-super admin,3-admin, \r\n',
  `verification_code` text DEFAULT NULL,
  `forgot_token` text DEFAULT NULL,
  `verified` int(10) NOT NULL DEFAULT 0 COMMENT '0-No, 1-Yes',
  `user_block` int(10) NOT NULL DEFAULT 0 COMMENT '0-unblock, 1-block',
  `welcome_mail_sended` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `is_admin`, `verification_code`, `forgot_token`, `verified`, `user_block`, `welcome_mail_sended`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin 1', 'superadmin@gmail.com', '7775875580', '$2y$10$AFh.Ms8vr.QztUEYqNODl.Ud2Ztmc0tAX50Jvh0c6QZt2qyYsgHhW', 1, '0000', '3001', 1, 0, 1, '2022-03-03 07:44:41', '2023-01-11 07:05:32', NULL),
(80, 'Amar', 'amar@gmail.com', '8452323433', '$2y$10$HGsXc5BNCnlgYjOr4EsQeOVWtbrLfkAGR46/srchcAUuBI7SfT/UC', 0, '7720', NULL, 1, 0, 0, '2023-01-11 06:39:17', '2023-01-11 07:07:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_complaints`
--

CREATE TABLE `user_complaints` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `category` int(11) NOT NULL COMMENT 'foreign key',
  `subcategory` int(11) NOT NULL COMMENT 'foreign key',
  `state` int(11) NOT NULL DEFAULT -1 COMMENT 'foreign key',
  `user_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '1-peanding, 2-solved, 3-declined',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_complaints`
--

INSERT INTO `user_complaints` (`id`, `message`, `category`, `subcategory`, `state`, `user_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'Electricity Bills are very high even after low usage.', 3, 1, 2, 80, 1, '2023-01-11 07:08:48', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories_table`
--
ALTER TABLE `categories_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state_table`
--
ALTER TABLE `state_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories_table`
--
ALTER TABLE `subcategories_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_complaints`
--
ALTER TABLE `user_complaints`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories_table`
--
ALTER TABLE `categories_table`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `state_table`
--
ALTER TABLE `state_table`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategories_table`
--
ALTER TABLE `subcategories_table`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `user_complaints`
--
ALTER TABLE `user_complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
