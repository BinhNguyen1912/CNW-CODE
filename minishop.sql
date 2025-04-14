-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 14, 2025 at 11:43 AM
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
-- Database: `minishop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` float DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(12, 'Anh Bình Nguyễn', '', 123456, '1744620302_gheyeudau.png', '2025-04-14 08:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `address`, `password`, `role`) VALUES
(2, 'admin', NULL, '$2y$10$1yJjNnl7OBu0yRV4DjKW4.Dwr99xt1C5MkeXVg6/1QRWqgxouBo0y', 'admin'),
(3, 'ninh1', 'nguyen du bao an', '$2y$10$vGzHcI.U.QsleLdsy9Zwmu30MEFQoi.8qjVJWjVMCieKniyHAPB.C', 'user'),
(4, 'hihi', 'ahihi', '$2y$10$yJThZkFe/BJx3eB4yM/wo.gSj5VAH4n9koDmaD5s.fdK.0C7xkL4.', 'user'),
(5, 'binh', 'ahiahi', '$2y$10$PU3.mVQCFcTgS4RhQ64DlOXfnrK8jngVXSVSU..ujmZLXlNbLvxtO', 'user'),
(6, 'binh3', 'aa', '$2y$10$22ye5Peekd0rUvPreb.QIe74lgTS0iVVl7ByiB0iH59p2uKGn1BL.', 'user'),
(7, 'binh4', 'aa', '$2y$10$GIC0jfMHysanZNIywwoqaugX3lC5hdVHMgXD6.950rp.MT.3MetkW', 'user'),
(8, 'binh5', 'aa', '$2y$10$5keGGcUVMZ1lmSQpADhe7OIgKx82vR9JNPhajc49mrbCQMjEooO/i', 'user'),
(9, 'ahihihihih', '1234561234', '$2y$10$pA8XCzPvpwnHicWa4plCxulaKS6wMxP3hn5oTkSvJMYGHPXLpsbD2', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
