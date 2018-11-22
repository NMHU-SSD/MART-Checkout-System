-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2018 at 04:17 AM
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

CREATE TABLE `clearance` (
  `id` int(11) NOT NULL,
  `level` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `class` varchar(5000) NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clearance`
--

INSERT INTO `clearance` (`id`, `level`, `barcode`, `description`, `class`, `isDeleted`) VALUES
(1, 'Photo 2', '654321', 'Camera', 'Photography 1 and Photography 2', 1),
(3, 'Ambient Computing', '123232', 'computer', 'Ambient Computing, Physical Coputing', 0),
(4, 'Faculty', '1010', 'Faculty ', 'None', 0),
(5, 'Restricted', '000000', 'Restricted', 'None', 0);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `barcode` varchar(255) NOT NULL,
  `name` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `clearance` varchar(20) NOT NULL,
  `notes` varchar(5000) NOT NULL,
  `account_purchased_from` varchar(500) NOT NULL,
  `status` enum('out of commission','available for checkout','reserved','available after class','out for repair') NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`barcode`, `name`, `description`, `clearance`, `notes`, `account_purchased_from`, `status`, `isDeleted`) VALUES
('123124', 'Raspberry Pi', 'None', '1,4', 'Only Raspberry Pi', '', 'available for checkout', 0),
('333333', 'Item test', 'None', '3,5', 'Ambient Computing, Restricted. ', '', 'out for repair', 0),
('654321', 'Cannon Camera', 'Camera only', '1,3,4,5', '', '', 'available for checkout', 0),
('753159', 'Cannon Camera', 'Camera only', '1,3', 'camera with stand', '', 'available for checkout', 0);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `banner_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `clearance_level` varchar(255) NOT NULL,
  `amount_owed` decimal(10,0) NOT NULL DEFAULT '0',
  `enrollment` enum('inactive','active') NOT NULL,
  `eligibility` enum('ineligible','eligible') NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`banner_id`, `name`, `email`, `phone`, `clearance_level`, `amount_owed`, `enrollment`, `eligibility`, `isDeleted`) VALUES
('654456', 'Tom Wilson', 'twilson@live.nmhu.edu', 505123456, 'Faculty', 0, 'active', 'eligible', 0),
('9797979797', 'Faculty Name', 'faculty@nmhu.edu', 555555555, 'Faculty', 0, 'active', 'eligible', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `student_id` varchar(11) NOT NULL COMMENT 'barcode from id',
  `date_pickup` varchar(255) NOT NULL,
  `date_due` varchar(255) NOT NULL,
  `notes` varchar(5000) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `date_time` varchar(250) DEFAULT NULL,
  `isCheckedOut` tinyint(1) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `barcode`, `student_id`, `date_pickup`, `date_due`, `notes`, `user_id`, `date_time`, `isCheckedOut`, `isDeleted`) VALUES
(2, '654321', '2020', '10/18/2018 11:19 AM', '10/27/2018 11:19 AM', 'pkmpkm;,', '1010', 'Thu, 18 Oct 18 11:19:28am', 0, 1),
(3, '5555', '002468', '10/29/2018 9:51 AM', '11/05/2018 11:38 AM', 'Test Test Test', '2020', 'Sun, 28 Oct 18 12:19:29pm', 0, 0),
(6, '444444', '001357', '10/29/2018 9:56 AM', '10/31/2018 12:56 AM', 'Test With Drop down being populated by database.', '2020', 'Sun, 28 Oct 18 01:15:50am', 0, 1),
(7, '3333', '654123', '11/03/2018 9:57 AM', '11/19/2018 11:57 PM', 'Only Managers can add.', '1010', 'Fri, 02 Nov 18 11:58:03pm', 0, 0),
(9, '684', '99999', '11/12/2018 2:31 PM', '11/14/2018 2:32 PM', 'Reservation barcode made with 684, 351 are together.', '1010', 'Sat, 10 Nov 18 02:32:38pm', 0, 0),
(10, '351', '99999', '11/12/2018 2:31 PM', '11/14/2018 2:32 PM', 'Reservation barcode made with 684, 351 are together.', '1010', 'Sat, 10 Nov 18 02:32:38pm', 0, 0),
(11, '321657', '123456', '11/22/2018 9:06 AM', '11/26/2018 9:06 PM', 'test', '1010', 'Wed, 21 Nov 18 09:06:15pm', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `banner_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `clearance_level` varchar(255) NOT NULL,
  `amount_owed` decimal(10,0) NOT NULL DEFAULT '0',
  `enrollment` enum('inactive','active') NOT NULL,
  `eligibility` enum('ineligible','eligible') NOT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`banner_id`, `name`, `email`, `phone`, `clearance_level`, `amount_owed`, `enrollment`, `eligibility`, `isDeleted`) VALUES
('001357', 'Faculty', 'faculty@nmhu.edu', 505555555, '1,3', 5, 'active', 'ineligible', 0),
('654123', 'Restricted', 'res@nmhu.edu', 5057654321, '5', 0, 'active', 'eligible', 1);

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
('1010', 'test1', 'Manager', '$2y$10$0g0JPR11vLB0iaY.dDpz.e2gv8JVyw8Sv1PA6nCqJxx5qQjsJxeZO'),
('1234', 'Manager', 'Manager', '$2y$10$ad5SemSTQUqkJA0YPbEYw.cS3z/AkwbQmP8uanPg6TXFZQ5BMHsBu'),
('12345678', 'Admin', 'Admin', '$2y$10$VdLXIC3d.2CHuY1XM.qr.ei0e2YwmzWa4OAdPV6qzEgRiXIVlMWhG'),
('2020', 'test2', 'Student Employee', '$2y$10$GNpgFUYur59tgNDgzohfm.WH1w50GqxiqtVfIREksPvJVNVCvyG76'),
('3030', 'assistant', 'Assistant', '$2y$10$HWxzJ41prDbepDctJtnsk.tTg.vevshSj.Ewj6/w9x/BRzePQq0Jq'),
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
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`banner_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
