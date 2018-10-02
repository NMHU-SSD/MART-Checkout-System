-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 02, 2018 at 09:53 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mart_checkout`
--
CREATE DATABASE IF NOT EXISTS `mart_checkout` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mart_checkout`;

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

DROP TABLE IF EXISTS `approvals`;
CREATE TABLE `approvals` (
  `barcode` varchar(255) NOT NULL,
  `banner_id` varchar(11) NOT NULL,
  `date_issued` varchar(10) NOT NULL,
  `date_due` varchar(10) NOT NULL,
  `notes` varchar(5000) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = false = not approved, 1 = true = approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `checked_out`
--

DROP TABLE IF EXISTS `checked_out`;
CREATE TABLE `checked_out` (
  `checkout_id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `banner_id` varchar(11) NOT NULL,
  `date_issued` varchar(10) NOT NULL,
  `date_due` varchar(10) NOT NULL,
  `notes` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clearance`
--

DROP TABLE IF EXISTS `clearance`;
CREATE TABLE `clearance` (
  `id` int(11) NOT NULL,
  `level` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `class` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clearance`
--

INSERT INTO `clearance` (`id`, `level`, `barcode`, `description`, `class`) VALUES
(1, 'Photo 2', '654321', 'Camera', 'Photography 1 and Photography 2'),
(2, 'Photo 1', '951', 'Camera only', 'Photography 1');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE `equipment` (
  `barcode` varchar(255) NOT NULL,
  `name` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `clearance` varchar(20) NOT NULL,
  `notes` varchar(5000) NOT NULL,
  `account_purchased_from` varchar(500) NOT NULL,
  `status` enum('out of commission','available for checkout','reserved','available after class','out for repair') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`barcode`, `name`, `description`, `clearance`, `notes`, `account_purchased_from`, `status`) VALUES
('123456', 'Camera 1', 'None', 'Photo 1', 'Camera Only', '', 'available for checkout'),
('753159', 'Cannon Camera', 'Camera only', '1', 'camera with stand', '', 'reserved'),
('951', 'Cannon Camera', '', '0,1', '', '', 'out of commission');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `student_id` varchar(11) NOT NULL COMMENT 'barcode from id',
  `date_pickup` varchar(255) NOT NULL,
  `date_due` varchar(255) NOT NULL,
  `notes` varchar(5000) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `date_time` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `barcode`, `student_id`, `date_pickup`, `date_due`, `notes`, `user_id`, `date_time`) VALUES
(5, '1234', '1234', '05/09/2018 9:30 AM', '05/11/2018 4:00 PM', '', '1234', 'Tue, 08 May 18 03:25:26pm');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `banner_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `clearance_level` int(5) NOT NULL,
  `amount_owed` decimal(10,0) NOT NULL DEFAULT '0',
  `enrollment` enum('inactive','active') NOT NULL,
  `eligibility` enum('ineligible','eligible') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `banner_id` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` enum('Manager','Assistant','Student Employee') NOT NULL,
  `password` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`banner_id`, `name`, `role`, `password`) VALUES
('1010', 'test1', 'Manager', '$2y$10$0g0JPR11vLB0iaY.dDpz.e2gv8JVyw8Sv1PA6nCqJxx5qQjsJxeZO'),
('1234', 'Manager', 'Manager', '$2y$10$ad5SemSTQUqkJA0YPbEYw.cS3z/AkwbQmP8uanPg6TXFZQ5BMHsBu'),
('2020', 'test2', 'Student Employee', '$2y$10$GNpgFUYur59tgNDgzohfm.WH1w50GqxiqtVfIREksPvJVNVCvyG76'),
('97531', 'Student Name', 'Student Employee', '$2y$10$3pDY7oNFxESm3Yo2Hm8g.ugXdy1mAi/nNfx88Tzujo1iGH3jj.jdW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`barcode`);

--
-- Indexes for table `checked_out`
--
ALTER TABLE `checked_out`
  ADD PRIMARY KEY (`checkout_id`),
  ADD UNIQUE KEY `Unique` (`barcode`) USING BTREE;

--
-- Indexes for table `clearance`
--
ALTER TABLE `clearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`barcode`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD UNIQUE KEY `Unique` (`barcode`) USING BTREE;

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`banner_id`),
  ADD UNIQUE KEY `banner_id` (`banner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checked_out`
--
ALTER TABLE `checked_out`
  MODIFY `checkout_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clearance`
--
ALTER TABLE `clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
