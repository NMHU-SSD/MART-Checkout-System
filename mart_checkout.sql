-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 03, 2019 at 03:21 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `checkout_archive`
--

CREATE TABLE `checkout_archive` (
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

CREATE TABLE `clearance` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `courses` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clearance`
--

INSERT INTO `clearance` (`id`, `name`, `description`, `courses`) VALUES
(1, 'Photo 1', 'Can only checkout \"point and shoot\" cameras', 'Photography 1'),
(3, 'SSD', 'Can checkout any SSD equipment', 'Ambient Computing,Physical Computing,Mobile Apps\r\n'),
(4, 'Faculty', 'can checkout equipment for longer periods of time', ''),
(5, 'Restricted', 'Not allowed to checkout without special permission', '');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `barcode` varchar(255) NOT NULL,
  `name` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `clearance` text,
  `notes` text NOT NULL,
  `purchase_account` varchar(500) NOT NULL,
  `status` enum('available for checkout','available after class','reserved','out for repair','out of commission') NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`barcode`, `name`, `description`, `clearance`, `notes`, `purchase_account`, `status`, `isDeleted`) VALUES
('LUZ-3d-04', 'Lulzbot 3d Printer', '2014 Edition', NULL, 'Broken', 'NMSL', 'out of commission', NULL),
('PiKit-1', 'raspberry pi', 'kit includes sd card, power supply, usb mic, shield', '3', 'Students must retrieve the kit from Mary', 'ssd', 'available for checkout', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `banner_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `clearance` varchar(255) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`banner_id`, `name`, `email`, `phone`, `clearance`, `isDeleted`) VALUES
('4321', 'Faculty', 'faculty@nmhu.edu', 5054444444, '4', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `equipment` text NOT NULL,
  `banner_id` varchar(11) NOT NULL COMMENT 'student or faculty id',
  `date_pickup` varchar(255) NOT NULL,
  `date_due` varchar(255) NOT NULL,
  `notes` varchar(5000) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `date_time` varchar(250) DEFAULT NULL,
  `isCheckedOut` tinyint(1) NOT NULL,
  `wasReturned` tinyint(1) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `equipment`, `banner_id`, `date_pickup`, `date_due`, `notes`, `user_id`, `date_time`, `isCheckedOut`, `wasReturned`, `isDeleted`) VALUES
(18, 'test, PiKit-1', '1234', '02/25/2019 5:25 PM', '02/25/2019 5:25 PM', '', '0123456789', 'Sat, Feb 23,2019 5:26 pm', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `banner_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `clearance` varchar(255) NOT NULL,
  `amount_owed` decimal(10,0) NOT NULL DEFAULT '0',
  `enrollment` enum('inactive','active') NOT NULL,
  `eligibility` enum('ineligible','eligible') NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`banner_id`, `name`, `email`, `phone`, `clearance`, `amount_owed`, `enrollment`, `eligibility`, `isDeleted`) VALUES
('1234', 'MART Student', 'student@nmhu.edu', 505555555, '1,3', '0', 'active', 'eligible', 0),
('12345678', 'NMHU Student', 'ssd@nmhu.edu', 505555555, '3', '0', 'active', 'eligible', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `banner_id` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` enum('Admin','Manager','Assistant','Student Employee') NOT NULL,
  `password` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`banner_id`, `name`, `role`, `password`) VALUES
('0123456789', 'SuperUser', 'Admin', '$2y$10$5eOPQ9JYf9YVeyuEH4vo4.y7o1v9TrPW4lKvurqy3i.2pzNWJmr/6'),
('12345678', 'Admin', 'Admin', '$2y$10$VdLXIC3d.2CHuY1XM.qr.ei0e2YwmzWa4OAdPV6qzEgRiXIVlMWhG'),
('2020', 'Manager', 'Manager', '$2y$10$yQPRv/2qdtZ3xsJcRPIx/OBYB2fNgmrm8ZqyUbnpMH4S.doIf7Cq6'),
('3030', 'Assistant', 'Assistant', '$2y$10$hFA071hMyein9.y6VMYRDO4NNur8y6QgFvSSoTKNN8FUGRNPhv2se'),
('97531', 'Student', 'Student Employee', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`barcode`);

--
-- Indexes for table `checkout_archive`
--
ALTER TABLE `checkout_archive`
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
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `checkout_archive`
--
ALTER TABLE `checkout_archive`
  MODIFY `checkout_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clearance`
--
ALTER TABLE `clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
