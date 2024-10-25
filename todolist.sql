-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 25, 2024 at 08:42 AM
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
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `detaillists`
--

CREATE TABLE `detaillists` (
  `id` int(11) NOT NULL,
  `todolist_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `is_complete` tinyint(1) DEFAULT 0,
  `label_color` varchar(7) DEFAULT '#ff0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detaillists`
--

INSERT INTO `detaillists` (`id`, `todolist_id`, `title`, `due_date`, `is_complete`, `label_color`) VALUES
(1, 18, 'mobil legen', '2024-10-25', 0, '#ff0000'),
(3, 21, 'buah', '2024-10-26', 1, '#00fdff'),
(4, 23, 'Air putih', '2024-10-26', 1, '#000000'),
(5, 23, 'Air Keran', '2024-10-27', 1, '#ff2600'),
(6, 24, 'Lem', '2024-10-31', 1, '#ff40ff'),
(7, 22, '12 jam', '2024-10-31', 0, '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `task_description` text NOT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `todolists`
--

CREATE TABLE `todolists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completion_status` enum('complete','incomplete') DEFAULT 'incomplete',
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todolists`
--

INSERT INTO `todolists` (`id`, `user_id`, `title`, `created_at`, `completion_status`, `due_date`) VALUES
(1, 5, 'test', '2024-10-22 06:48:32', 'incomplete', NULL),
(5, 1, 'probstat', '2024-10-22 07:47:01', 'incomplete', NULL),
(6, 1, 'denito cuki', '2024-10-22 07:53:10', 'incomplete', NULL),
(7, 1, 'lian tol', '2024-10-22 07:53:19', 'incomplete', NULL),
(8, 1, 'denito wibu', '2024-10-22 07:53:34', 'incomplete', NULL),
(9, 11, 'Religion', '2024-10-22 08:07:31', 'incomplete', NULL),
(10, 11, 'English', '2024-10-22 08:07:38', 'complete', NULL),
(11, 17, 'okeee', '2024-10-24 07:10:48', 'complete', NULL),
(13, 21, 'resa', '2024-10-24 09:59:41', 'complete', NULL),
(18, 22, 'main', '2024-10-24 14:47:58', 'incomplete', '2024-10-31'),
(21, 22, 'makan', '2024-10-25 03:20:43', 'complete', '2024-10-26'),
(22, 22, 'Turu', '2024-10-25 03:30:57', 'incomplete', '2024-11-22'),
(23, 23, 'Minum', '2024-10-25 03:41:27', 'complete', '2024-10-28'),
(24, 23, 'Mabuk', '2024-10-25 03:43:18', 'complete', '2024-10-30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `profile_image`, `profile_picture`) VALUES
(1, 'felix', 'test@test.com', '$2y$10$L6yO8zRlKuGeSwj5TwaOnuYpJepTkfqcJKt3/uGfXqi.rtqRvI9Ay', '2024-10-21 10:16:10', NULL, NULL),
(2, 'felix', 'test@test.com', '$2y$10$.GpvQuX3.9U8sM8NMJ72qOKYfnHVAMwl9.soFnXMqMaQKWQvu.AP.', '2024-10-21 10:16:45', NULL, NULL),
(3, 'jhon', 'jhon@test.com', '$2y$10$e/wfQSgD/TLqNU0qbOwN/u/e.xzsk9PRqU7N0jzXxWDLu.DhL2ZrK', '2024-10-22 06:09:52', NULL, NULL),
(4, 'test', 'jhon@jhon.com', '$2y$10$AqUp0l8nseFf074B4IdIwOaeVQrH6wXD/xkfjry34dwp.xyM1sloO', '2024-10-22 06:45:01', NULL, NULL),
(5, 'rayden', 'rayden@test.com', '$2y$10$aJVXyz7TK2.daOfiJu8Fc.bAINwew7zyEH8fSx6vSXgU3By4v35lm', '2024-10-22 06:47:30', NULL, NULL),
(6, 'rel', 'rel@test.com', '$2y$10$.ebxZzSULgVmy20I3mTMDu4KBD41zvkixcMHFSwmPCpNtIRx5/uqy', '2024-10-22 06:49:46', NULL, NULL),
(7, 'philip', 'philip@test.com', '$2y$10$ZAKwwjdXffaMCI89C4475OIgsfhXC8c56cHOFyVOFqx0wnrLOxG.m', '2024-10-22 06:53:57', NULL, NULL),
(8, 'OKE', 'oke@test.com', '$2y$10$SpHblRjkR8c7DeDUVTLNbOYvJooBgJCj7NRENln2Wj9cavmDDuw3q', '2024-10-22 06:57:03', NULL, NULL),
(9, 'test', 'test@test.com', '$2y$10$Bpx.9iVs16iTSvphBp066.nWe8I0SRfe3zHqXZ24qai9StaqRU88i', '2024-10-22 07:26:04', NULL, NULL),
(10, 'test', 'gg@gg.com', '$2y$10$lYUXqzQaFZ.Z1RUCPl3m4.GulO4.Nf3oohzCRY7fhzj38Pu9.ec6y', '2024-10-22 07:34:23', NULL, NULL),
(11, 'Felix Octaniel Telaumbanua', 'felixtel@test.com', '$2y$10$HZHZofF0UjNRBkNEEa.WP.HQN0j3WUlwtQjzDyh0iMtYkI1/MsnLK', '2024-10-22 08:06:12', NULL, NULL),
(12, 'test', 'felix1@test.com', '$2y$10$U5J4FncPyKTPTMiMvHWypOat13kzS6.TV5eOtJCB0hq2Naasa/gke', '2024-10-22 08:28:33', NULL, NULL),
(13, 'jhon', 'test@test.com', '$2y$10$P8AcQEoMXekc/b8AXK9wXO8GKnHr/uPy2U.9HYr5Z15dzwkjK6MKm', '2024-10-22 08:36:02', NULL, NULL),
(14, 'oke1', 'test123@test.com', '$2y$10$IvfdXjJW3zf1JCUpT2jwG.VRhJmr58iuPt2ZI/oVYDjzKpgwKaRru', '2024-10-22 08:51:56', NULL, NULL),
(15, 'den', 'den@test.com', '$2y$10$kGv.5k9PCKbrU0hAR9wYRO1RQ1TvzMwIZoi2hDVDwC50LYN6YOQb2', '2024-10-22 09:38:05', NULL, NULL),
(16, 'JHON1', 'jhon2@test.com', '$2y$10$ychXfNmtx8r53S5xFx7sze.GJ7XCxkZfRCBfbd5DxHqTZUp2Deq52', '2024-10-23 04:05:21', NULL, NULL),
(17, 'reja', 'reja@gmail.com', '$2y$10$UK9m5F00i0yMxBnerbpR5.Suc2GqxgYp8rZuR3/cWeWYZmsFU7vBG', '2024-10-24 07:10:24', NULL, NULL),
(18, 'levonchka', 'jere@gmail.com', '$2y$10$04wUX3plUzvJmOvarRx1ZegU3FFluLcS9.vnz5nwqwrBOdJ1XD8Ye', '2024-10-24 09:56:13', NULL, NULL),
(19, 'relrel', 'relllll@gmail.com', '$2y$10$.IHwP7neFSziF.inpzFRKeNm4QBjnO1y/rpK1rpUmf3X3td8MUm1y', '2024-10-24 09:57:14', NULL, NULL),
(20, 'relrell', 'rellll@gmail.com', '$2y$10$1d9Rp5kdmCwW4b5BlPOnw.Kr5jkgC6AzzgF5U8zpNjDIKJ0mjCqzm', '2024-10-24 09:57:50', NULL, NULL),
(21, 'jere', 'jere@test.com', '$2y$10$35KUxXpYxtd/hTV0r1t5y.cZmLnXYlBzVB7lY6SzoZxeEPy6N45E.', '2024-10-24 09:58:38', NULL, NULL),
(22, 'frl', 'iyahh@gmail.com', '$2y$10$XujPCFrN7r1MqM67ncLzQOy2E3uIVexlmAva2PXkAoXfXNgEmF8qW', '2024-10-24 10:52:12', NULL, ' -2.jpg'),
(23, 'Jamal', 'jamalsukamakan@gmail.com', '$2y$10$2gNd.1VDxX.d4Y2E780WMuXD1RUIPVmMQY533i7ByAZ9qMmm86tN2', '2024-10-24 15:50:38', NULL, 'UTS.drawio-2.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detaillists`
--
ALTER TABLE `detaillists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `todolist_id` (`todolist_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_id` (`list_id`);

--
-- Indexes for table `todolists`
--
ALTER TABLE `todolists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detaillists`
--
ALTER TABLE `detaillists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `todolists`
--
ALTER TABLE `todolists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detaillists`
--
ALTER TABLE `detaillists`
  ADD CONSTRAINT `detaillists_ibfk_1` FOREIGN KEY (`todolist_id`) REFERENCES `todolists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `todolists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `todolists`
--
ALTER TABLE `todolists`
  ADD CONSTRAINT `todolists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
