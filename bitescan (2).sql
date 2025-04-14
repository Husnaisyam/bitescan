-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 06:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bitescan`
--

-- --------------------------------------------------------

--
-- Table structure for table `food_info`
--

CREATE TABLE `food_info` (
  `food_name` varchar(100) NOT NULL,
  `calories` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_info`
--

INSERT INTO `food_info` (`food_name`, `calories`) VALUES
('Cendol', 250),
('Ketupat', 200),
('Laksa', 350),
('Nasi Lemak', 450);

-- --------------------------------------------------------

--
-- Table structure for table `meal_history`
--

CREATE TABLE `meal_history` (
  `id` int(11) NOT NULL,
  `food_name` varchar(100) DEFAULT NULL,
  `calories` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_history`
--

INSERT INTO `meal_history` (`id`, `food_name`, `calories`, `image_path`, `timestamp`) VALUES
(18, 'Ketupat', 200, 'uploads\\captured_image.jpg', '2025-04-12 15:07:47'),
(19, 'Ketupat', 200, 'uploads\\captured_image.jpg', '2025-04-12 15:10:31'),
(20, 'Ketupat', 200, 'captured_image.jpg', '2025-04-12 15:18:40'),
(21, 'Cendol', 250, 'captured_image.jpg', '2025-04-13 08:33:46'),
(22, 'Nasi Lemak', 450, '9cf8698f3bc949f983d0e2c575bb9d8a.jpg', '2025-04-13 19:16:04'),
(24, 'Cendol', 250, 'b38c447a25c94fafbac6f6a0de144a6a.jpeg', '2025-04-13 19:25:12'),
(25, 'Nasi Lemak', 450, 'ce7016cc04b346b7ae6a5d8997903242.jpeg', '2025-04-13 19:25:57'),
(26, 'Nasi Lemak', 450, '19a9b4efb5164525915f6a4678b8ef41.jpg', '2025-04-14 10:15:17'),
(27, 'Ketupat', 200, 'ec9ca4cdb40b45d0bac13a74fe70fc8f.jpg', '2025-04-14 10:16:13'),
(28, 'Ketupat', 200, '6b28aa4723c54408ac5d32186a1d6a6f.jpg', '2025-04-14 10:16:33'),
(29, 'Ketupat', 200, '22697e5e477847a39cd3a1b2382064a7.jpg', '2025-04-14 10:16:45'),
(30, 'Nasi Lemak', 450, 'c7c26d19ccd244008f6e5e9849b3af50.jpg', '2025-04-14 10:17:14'),
(31, 'Ketupat', 200, '00355c288b774924a32b3dc232257d7e.jpg', '2025-04-14 10:17:43'),
(32, 'Ketupat', 200, 'c40c623d36484ccaa419f32fb90456c6.jpg', '2025-04-14 10:17:51'),
(33, 'Nasi Lemak', 450, '873053c88a534eddb33d1af1fc300bde.jpg', '2025-04-14 11:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `weight` float NOT NULL,
  `height` float NOT NULL,
  `calorie_limit` int(11) NOT NULL DEFAULT 0,
  `age` int(11) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `activity_level` enum('sedentary','light','moderate','active','very_active') NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `weight`, `height`, `calorie_limit`, `age`, `gender`, `activity_level`, `profile_pic`) VALUES
(9, 'nurul husna1', 'husnabusuk3@gmail.com', '$2y$10$PJ96dXURF5On3IA7MykQJuLSfGYTi8wOS61h26VcSUhZvunnKX2/e', 48, 157, 1424, 23, 'female', 'sedentary', NULL),
(10, 'nurul jannah', 'jannahsaubri0@gmail.com', '$2y$10$VXXHfxtgc7.GlGOtMQQ8DuETV4J1dCD5KUQ9ajJMjld0Dtr/fagEK', 50, 157, 0, 23, 'female', 'light', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food_info`
--
ALTER TABLE `food_info`
  ADD PRIMARY KEY (`food_name`);

--
-- Indexes for table `meal_history`
--
ALTER TABLE `meal_history`
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
-- AUTO_INCREMENT for table `meal_history`
--
ALTER TABLE `meal_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
