-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2023 at 08:15 PM
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
-- Database: `php_web_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.online`
--

CREATE TABLE `tb_admin.online` (
  `id` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `ultima_acao` datetime NOT NULL,
  `token` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.online`
--

INSERT INTO `tb_admin.online` (`id`, `ip`, `ultima_acao`, `token`) VALUES
(1, '::1', '2023-11-17 16:03:17', 655780),
(2, '::1', '2023-11-17 16:05:41', 65578145),
(3, '::1', '2023-11-21 20:04:59', 655);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.users`
--

CREATE TABLE `tb_admin.users` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.users`
--

INSERT INTO `tb_admin.users` (`id`, `user`, `password`, `name`, `role`, `avatar`) VALUES
(1, 'admin', 'admin', 'Administrator', '2', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.visits`
--

CREATE TABLE `tb_admin.visits` (
  `id` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.visits`
--

INSERT INTO `tb_admin.visits` (`id`, `ip`, `day`) VALUES
(1, '::1', '2023-11-19'),
(2, '::1', '2023-11-21'),
(3, '::1', '2023-11-21'),
(4, '::1', '2023-11-21'),
(5, '::1', '2023-11-21');

-- --------------------------------------------------------

--
-- Table structure for table `tb_site.depoimentos`
--

CREATE TABLE `tb_site.depoimentos` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_site.home`
--

CREATE TABLE `tb_site.home` (
  `id` int(11) NOT NULL,
  `pagetitle` varchar(255) NOT NULL,
  `pagedescription` varchar(255) NOT NULL,
  `logotitle` varchar(255) NOT NULL,
  `mailtitle` varchar(255) NOT NULL,
  `authorname` varchar(255) NOT NULL,
  `authordescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_site.home`
--

INSERT INTO `tb_site.home` (`id`, `pagetitle`, `pagedescription`, `logotitle`, `mailtitle`, `authorname`, `authordescription`) VALUES
(1, 'PHP_Web_dev', '', '', 'website Header', 'Adriaan Willem', 'Descrição do author nada criatia.');

-- --------------------------------------------------------

--
-- Table structure for table `tb_site.service`
--

CREATE TABLE `tb_site.service` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_site.slide`
--

CREATE TABLE `tb_site.slide` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin.online`
--
ALTER TABLE `tb_admin.online`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_admin.users`
--
ALTER TABLE `tb_admin.users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin.visits`
--
ALTER TABLE `tb_admin.visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_site.depoimentos`
--
ALTER TABLE `tb_site.depoimentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_site.home`
--
ALTER TABLE `tb_site.home`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_site.service`
--
ALTER TABLE `tb_site.service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_site.slide`
--
ALTER TABLE `tb_site.slide`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin.online`
--
ALTER TABLE `tb_admin.online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=316;

--
-- AUTO_INCREMENT for table `tb_admin.users`
--
ALTER TABLE `tb_admin.users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_admin.visits`
--
ALTER TABLE `tb_admin.visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_site.depoimentos`
--
ALTER TABLE `tb_site.depoimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_site.home`
--
ALTER TABLE `tb_site.home`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_site.service`
--
ALTER TABLE `tb_site.service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_site.slide`
--
ALTER TABLE `tb_site.slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
