-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2025 at 04:49 PM
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
-- Database: `hub_venue`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_start_date` date NOT NULL,
  `booking_end_date` date NOT NULL,
  `booking_duration` int(11) NOT NULL,
  `booking_status_id` int(11) DEFAULT NULL,
  `booking_request` text DEFAULT NULL,
  `booking_participants` int(11) NOT NULL,
  `booking_original_price` decimal(10,2) NOT NULL,
  `booking_grand_total` decimal(10,2) NOT NULL,
  `booking_balance` decimal(10,2) NOT NULL,
  `booking_guest_id` int(11) DEFAULT NULL,
  `booking_venue_id` int(11) DEFAULT NULL,
  `booking_down_payment` int(11) NOT NULL,
  `booking_discount` varchar(255) DEFAULT NULL,
  `booking_payment_method` varchar(50) DEFAULT NULL,
  `booking_payment_reference` text NOT NULL,
  `booking_payment_status_id` int(11) DEFAULT NULL,
  `booking_cancellation_reason` text DEFAULT NULL,
  `booking_service_fee` decimal(10,2) NOT NULL,
  `booking_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `check_in_link` varchar(255) DEFAULT NULL,
  `check_out_link` varchar(255) DEFAULT NULL,
  `check_in_status` enum('Pending','Checked-In','No-Show') DEFAULT 'Pending',
  `check_out_status` enum('Pending','Checked-Out') DEFAULT 'Pending',
  `check_in_date` datetime DEFAULT NULL,
  `check_out_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_start_date`, `booking_end_date`, `booking_duration`, `booking_status_id`, `booking_request`, `booking_participants`, `booking_original_price`, `booking_grand_total`, `booking_balance`, `booking_guest_id`, `booking_venue_id`, `booking_down_payment`, `booking_discount`, `booking_payment_method`, `booking_payment_reference`, `booking_payment_status_id`, `booking_cancellation_reason`, `booking_service_fee`, `booking_created_at`, `booking_updated_at`, `check_in_link`, `check_out_link`, `check_in_status`, `check_out_status`, `check_in_date`, `check_out_date`) VALUES
(64, '2025-01-31', '2025-02-04', 4, 4, '', 20, 4600.00, 4600.00, 0.00, 32, 65, 1, 'none', 'PayMaya', '41313213545', 2, NULL, 600.00, '2025-01-31 14:12:39', '2025-02-06 12:06:44', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=64', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=64', 'Pending', 'Pending', NULL, NULL),
(65, '2025-02-06', '2025-02-10', 4, 1, '', 20, 230000.00, 230000.00, 0.00, 32, 69, 1, 'none', 'G-cash', 'asadasd12312', 1, NULL, 30000.00, '2025-02-06 03:03:00', '2025-02-06 03:03:00', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=65', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=65', 'Pending', 'Pending', NULL, NULL),
(66, '2025-02-12', '2025-02-14', 2, 1, '', 20, 115000.00, 115000.00, 0.00, 34, 69, 1, 'none', 'G-cash', '12312sasd', 1, NULL, 15000.00, '2025-02-06 12:54:41', '2025-02-06 12:54:41', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=66', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=66', 'Pending', 'Pending', NULL, NULL),
(67, '2025-02-16', '2025-02-19', 3, 4, '', 20, 172500.00, 172500.00, 0.00, 34, 69, 1, 'none', 'G-cash', 'asdasd123321', 1, NULL, 22500.00, '2025-02-06 13:41:17', '2025-02-06 13:42:07', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=67', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=67', 'Pending', 'Pending', NULL, NULL),
(68, '2025-02-06', '2025-02-08', 2, 1, '', 20, 11500.00, 11500.00, 0.00, 32, 70, 1, 'none', 'PayMaya', 'asdas1221', 1, NULL, 1500.00, '2025-02-06 14:39:31', '2025-02-06 14:39:31', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=68', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=68', 'Pending', 'Pending', NULL, NULL),
(69, '2025-02-15', '2025-02-17', 2, 1, '', 20, 115000.00, 115000.00, 0.00, 36, 69, 1, 'none', 'G-cash', 'asdas1312', 1, NULL, 15000.00, '2025-02-06 16:08:21', '2025-02-06 16:08:21', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=69', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=69', 'Pending', 'Pending', NULL, NULL),
(70, '2025-02-19', '2025-02-21', 2, 1, '', 20, 115000.00, 115000.00, 0.00, 36, 69, 1, 'none', 'PayMaya', 'sdas132', 1, NULL, 15000.00, '2025-02-06 16:18:23', '2025-02-06 16:18:23', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=70', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=70', 'Pending', 'Pending', NULL, NULL),
(71, '2025-02-09', '2025-02-11', 2, 1, '', 20, 11500.00, 11500.00, 0.00, 32, 70, 1, 'none', 'PayMaya', '1221', 1, NULL, 1500.00, '2025-02-06 16:32:59', '2025-02-06 16:32:59', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=71', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=71', 'Pending', 'Pending', NULL, NULL),
(72, '2025-02-22', '2025-02-25', 3, 3, '', 20, 172500.00, 172500.00, 0.00, 37, 69, 1, 'none', 'PayMaya', 'asdasd1', 1, 'Nononono', 22500.00, '2025-02-06 16:35:07', '2025-02-07 14:57:50', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=72', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=72', 'Pending', 'Pending', NULL, NULL),
(73, '2025-02-07', '2025-02-10', 3, 1, '', 20, 6900.00, 6900.00, 0.00, 35, 67, 1, 'none', 'G-cash', 'asdasdas12', 1, NULL, 900.00, '2025-02-06 18:29:41', '2025-02-06 18:29:41', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=73', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=73', 'Pending', 'Pending', NULL, NULL),
(74, '2025-02-07', '2025-02-11', 4, 1, '', 20, 9200.00, 9200.00, 0.00, 38, 65, 1, 'none', 'PayMaya', 'asdas1', 1, NULL, 1200.00, '2025-02-06 18:34:12', '2025-02-06 18:34:12', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=74', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=74', 'Pending', 'Pending', NULL, NULL),
(75, '2025-02-07', '2025-02-10', 3, 1, '', 20, 20700.00, 20700.00, 0.00, 38, 62, 1, 'none', 'PayMaya', '21312sada', 1, NULL, 2700.00, '2025-02-06 21:30:51', '2025-02-06 21:30:51', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=75', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=75', 'Pending', 'Pending', NULL, NULL),
(76, '2025-02-11', '2025-02-13', 2, 1, '', 20, 13800.00, 13800.00, 0.00, 38, 62, 1, 'none', 'PayMaya', 'asdaa2131', 1, NULL, 1800.00, '2025-02-06 21:39:58', '2025-02-06 21:39:58', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=76', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=76', 'Pending', 'Pending', NULL, NULL),
(77, '2025-02-14', '2025-02-17', 3, 1, '', 20, 20700.00, 20700.00, 0.00, 38, 62, 1, 'none', 'PayMaya', 'asdasd', 1, NULL, 2700.00, '2025-02-06 21:42:07', '2025-02-06 21:42:07', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=77', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=77', 'Pending', 'Pending', NULL, NULL),
(78, '2025-02-14', '2025-02-17', 3, 1, '', 20, 20700.00, 20700.00, 0.00, 38, 62, 1, 'none', 'PayMaya', 'asdasd', 1, NULL, 2700.00, '2025-02-06 21:42:20', '2025-02-06 21:42:20', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=78', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=78', 'Pending', 'Pending', NULL, NULL),
(79, '2025-02-14', '2025-02-17', 3, 1, '', 20, 20700.00, 20700.00, 0.00, 38, 62, 1, 'none', 'PayMaya', 'asdasd', 1, NULL, 2700.00, '2025-02-06 21:43:18', '2025-02-06 21:43:18', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=79', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=79', 'Pending', 'Pending', NULL, NULL),
(80, '2025-02-14', '2025-02-17', 3, 1, '', 20, 20700.00, 20700.00, 0.00, 38, 62, 1, 'none', 'PayMaya', 'SADAS21', 1, NULL, 2700.00, '2025-02-06 21:43:36', '2025-02-06 21:43:36', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=80', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=80', 'Pending', 'Pending', NULL, NULL),
(81, '2025-02-14', '2025-02-17', 3, 1, '', 20, 20700.00, 20700.00, 0.00, 38, 62, 1, 'none', 'PayMaya', 'asdas', 1, NULL, 2700.00, '2025-02-06 21:45:35', '2025-02-06 21:45:35', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=81', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=81', 'Pending', 'Pending', NULL, NULL),
(82, '2025-02-14', '2025-02-17', 3, 1, '', 20, 20700.00, 20700.00, 0.00, 38, 62, 1, 'none', 'PayMaya', 'asdas2', 1, NULL, 2700.00, '2025-02-06 21:46:13', '2025-02-06 21:46:13', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=82', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=82', 'Pending', 'Pending', NULL, NULL),
(83, '2025-02-14', '2025-02-17', 3, 1, '', 20, 20700.00, 20700.00, 0.00, 38, 62, 1, 'none', 'PayMaya', 'asdas', 1, NULL, 2700.00, '2025-02-06 21:48:36', '2025-02-06 21:48:36', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=83', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=83', 'Pending', 'Pending', NULL, NULL),
(84, '2025-02-07', '2025-02-10', 3, 1, '', 20, 17250.00, 17250.00, 0.00, 38, 64, 1, 'SAVE30', 'PayMaya', 'ASDA12', 1, NULL, 2250.00, '2025-02-06 21:50:47', '2025-02-06 21:50:47', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=84', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=84', 'Pending', 'Pending', NULL, NULL),
(85, '2025-02-26', '2025-02-28', 2, 1, '', 20, 115000.00, 115000.00, 0.00, 32, 69, 1, 'none', 'PayMaya', 'ASDAS2', 1, NULL, 15000.00, '2025-02-06 21:53:04', '2025-02-06 21:53:04', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=85', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=85', 'Pending', 'Pending', NULL, NULL),
(86, '2025-03-01', '2025-03-03', 2, 1, '', 20, 115000.00, 115000.00, 0.00, 35, 69, 1, 'none', 'PayMaya', 'asdas1', 1, NULL, 15000.00, '2025-02-07 03:51:34', '2025-02-07 03:51:34', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=86', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=86', 'Pending', 'Pending', NULL, NULL),
(87, '2025-02-12', '2025-02-14', 2, 3, '', 20, 11500.00, 11500.00, 0.00, 37, 70, 1, 'none', 'G-cash', 'asdas1231', 1, 'Nononono', 1500.00, '2025-02-07 04:13:40', '2025-02-07 14:57:47', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=87', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=87', 'Pending', 'Pending', NULL, NULL),
(88, '2025-02-07', '2025-02-10', 3, 2, '', 80, 12075.00, 12075.00, 0.00, 37, 71, 1, 'none', 'PayMaya', 'asda12', 2, NULL, 1575.00, '2025-02-07 04:19:15', '2025-02-07 04:38:06', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=88', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=88', 'Pending', 'Pending', NULL, NULL),
(89, '2025-02-11', '2025-02-16', 5, 3, '', 20, 11500.00, 11500.00, 0.00, 37, 67, 1, 'none', 'PayMaya', 'asdas123', 1, 'Nononono', 1500.00, '2025-02-07 14:43:14', '2025-02-07 14:57:39', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=89', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=89', 'Pending', 'Pending', NULL, NULL),
(90, '2025-02-07', '2025-02-10', 3, 1, '', 20, 6900.00, 6900.00, 0.00, 37, 66, 1, 'none', 'PayMaya', 'asda1', 1, NULL, 900.00, '2025-02-07 15:38:46', '2025-02-07 15:38:46', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=90', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=90', 'Pending', 'Pending', NULL, NULL),
(91, '2025-02-18', '2025-02-19', 1, 1, '', 20, 6900.00, 6900.00, 0.00, 37, 62, 1, 'none', 'PayMaya', 'asda12', 1, NULL, 900.00, '2025-02-07 15:44:53', '2025-02-07 15:44:53', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=91', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=91', 'Pending', 'Pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookings_status_sub`
--

CREATE TABLE `bookings_status_sub` (
  `id` int(11) NOT NULL,
  `booking_status_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings_status_sub`
--

INSERT INTO `bookings_status_sub` (`id`, `booking_status_name`) VALUES
(1, 'Pending'),
(2, 'Confirmed'),
(3, 'Cancelled'),
(4, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `booking_charges`
--

CREATE TABLE `booking_charges` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL,
  `status` enum('paid','pending') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `venueId` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `userId`, `venueId`, `created_at`, `updated_at`) VALUES
(123, 31, 61, '2025-01-23 17:21:09', '2025-01-23 17:21:09'),
(125, 32, 70, '2025-02-06 16:26:05', '2025-02-06 16:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `booking_id`, `type`, `name`, `created_at`) VALUES
(1, 67, 'booking', NULL, '2025-02-06 14:02:21'),
(2, 66, 'booking', NULL, '2025-02-06 14:03:50'),
(3, 69, 'booking', NULL, '2025-02-06 16:08:27'),
(4, 65, 'booking', NULL, '2025-02-06 16:16:14'),
(5, 70, 'booking', NULL, '2025-02-06 16:18:30'),
(6, 68, 'booking', NULL, '2025-02-06 16:23:23'),
(7, 71, 'booking', NULL, '2025-02-06 16:33:05'),
(8, 72, 'booking', NULL, '2025-02-06 16:35:12'),
(9, 64, 'booking', 'PariX Pixar', '2025-02-06 17:19:48'),
(10, 73, 'booking', NULL, '2025-02-06 18:30:00'),
(11, 74, 'booking', NULL, '2025-02-06 18:34:17'),
(12, 75, 'booking', NULL, '2025-02-06 21:36:34'),
(13, 83, 'booking', NULL, '2025-02-06 21:49:12'),
(14, 85, 'booking', NULL, '2025-02-06 21:54:05'),
(15, 86, 'booking', NULL, '2025-02-07 03:52:17'),
(16, 87, 'booking', NULL, '2025-02-07 04:13:45'),
(17, 84, 'booking', 'Tomorrow Land Room 2', '2025-02-07 04:31:46'),
(18, 84, 'booking', 'Tomorrow Land Room 2', '2025-02-07 04:31:46'),
(19, 82, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(20, 82, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(21, 81, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(22, 81, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(23, 80, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(24, 80, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(25, 79, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(26, 79, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(27, 78, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(28, 78, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(29, 77, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(30, 76, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(31, 77, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(32, 76, 'booking', 'Tomorrow Land Gc!', '2025-02-07 04:31:46'),
(33, 88, 'booking', NULL, '2025-02-07 04:32:06');

-- --------------------------------------------------------

--
-- Table structure for table `conversation_participants`
--

CREATE TABLE `conversation_participants` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversation_participants`
--

INSERT INTO `conversation_participants` (`id`, `conversation_id`, `user_id`, `role`) VALUES
(1, 1, 32, 'member'),
(2, 1, 34, 'member'),
(3, 2, 32, 'member'),
(4, 2, 34, 'member'),
(5, 3, 32, 'member'),
(6, 3, 36, 'member'),
(7, 4, 32, 'member'),
(8, 4, 32, 'member'),
(9, 5, 32, 'member'),
(10, 5, 36, 'member'),
(11, 6, 35, 'member'),
(12, 6, 32, 'member'),
(13, 7, 35, 'member'),
(14, 7, 32, 'member'),
(15, 8, 32, 'member'),
(16, 8, 37, 'member'),
(17, 9, 32, 'member'),
(18, 9, 32, 'member'),
(19, 10, 32, 'member'),
(20, 10, 35, 'member'),
(21, 11, 32, 'member'),
(22, 11, 38, 'member'),
(23, 12, 32, 'member'),
(24, 12, 38, 'member'),
(25, 13, 32, 'member'),
(26, 13, 38, 'member'),
(27, 14, 32, 'member'),
(28, 14, 32, 'member'),
(29, 15, 32, 'member'),
(30, 15, 35, 'member'),
(31, 16, 35, 'member'),
(32, 16, 37, 'member'),
(33, 17, 32, 'member'),
(34, 17, 38, 'member'),
(35, 18, 32, 'member'),
(36, 18, 38, 'member'),
(37, 19, 32, 'member'),
(38, 19, 38, 'member'),
(39, 20, 32, 'member'),
(40, 20, 38, 'member'),
(41, 21, 32, 'member'),
(42, 21, 38, 'member'),
(43, 22, 32, 'member'),
(44, 22, 38, 'member'),
(45, 23, 32, 'member'),
(46, 23, 38, 'member'),
(47, 24, 32, 'member'),
(48, 24, 38, 'member'),
(49, 25, 32, 'member'),
(50, 25, 38, 'member'),
(51, 26, 32, 'member'),
(52, 26, 38, 'member'),
(53, 27, 32, 'member'),
(54, 27, 38, 'member'),
(55, 28, 32, 'member'),
(56, 28, 38, 'member'),
(57, 29, 32, 'member'),
(58, 29, 38, 'member'),
(59, 30, 32, 'member'),
(60, 30, 38, 'member'),
(61, 31, 32, 'member'),
(62, 31, 38, 'member'),
(63, 32, 32, 'member'),
(64, 32, 38, 'member'),
(65, 33, 35, 'member'),
(66, 33, 37, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `discount_code` varchar(255) DEFAULT NULL,
  `discount_type` enum('flat','percentage') DEFAULT NULL,
  `discount_value` decimal(10,2) DEFAULT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `min_days` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `venue_id`, `discount_code`, `discount_type`, `discount_value`, `expiration_date`, `created_at`, `updated_at`, `min_days`) VALUES
(1, NULL, 'SAVE10', 'percentage', 10.00, '2024-12-25 20:40:37', '2025-01-24 02:07:46', '2025-01-24 02:07:46', 1),
(2, NULL, 'SAVE20', 'percentage', 20.00, '2024-12-25 20:40:37', '2025-01-24 02:07:46', '2025-01-24 02:07:46', 1),
(3, NULL, 'SAVE30', 'percentage', 30.00, '2025-12-25 20:40:37', '2025-01-24 02:07:46', '2025-01-24 02:07:46', 1),
(4, NULL, 'none', 'percentage', 0.00, NULL, '2025-01-24 02:07:46', '2025-01-24 02:07:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `downpayment_sub`
--

CREATE TABLE `downpayment_sub` (
  `id` int(11) NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downpayment_sub`
--

INSERT INTO `downpayment_sub` (`id`, `value`) VALUES
(1, 0.3),
(2, 0.5),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `host_application`
--

CREATE TABLE `host_application` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birthdate` varchar(50) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `host_application`
--

INSERT INTO `host_application` (`id`, `userId`, `fullname`, `address`, `birthdate`, `status_id`, `created_at`, `updated_at`) VALUES
(11, 31, 'Ansoc, Joevin C.', 'Tetuan, Guiwan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '2003-09-28', 2, '2025-01-24 01:54:36', '2025-01-24 01:54:36'),
(12, 32, 'Ohm, Rei O.', 'Governor Ramos Avenue, Sanroe Subdivision, San Roque, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '2000-02-06', 2, '2025-01-31 12:38:01', '2025-01-31 12:39:23'),
(13, 35, 'Reidan, Reizer O.', 'West Metro Medical Center, Veterans Avenue Extension, Tetuan, Santa Maria, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '2000-02-06', 2, '2025-02-06 14:36:20', '2025-02-06 14:36:36');

-- --------------------------------------------------------

--
-- Table structure for table `host_application_status_sub`
--

CREATE TABLE `host_application_status_sub` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `host_application_status_sub`
--

INSERT INTO `host_application_status_sub` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Approved'),
(3, 'Declined');

-- --------------------------------------------------------

--
-- Table structure for table `host_id_images`
--

CREATE TABLE `host_id_images` (
  `id` int(11) NOT NULL,
  `idOne_type` varchar(100) NOT NULL,
  `idOne_image_url` varchar(255) NOT NULL,
  `idTwo_type` varchar(100) NOT NULL,
  `idTwo_image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `host_id_images`
--

INSERT INTO `host_id_images` (`id`, `idOne_type`, `idOne_image_url`, `idTwo_type`, `idTwo_image_url`, `created_at`) VALUES
(11, 'Philippine Passport', '/host_id_image/678cd66ce5370.png', 'UMID Card', '/host_id_image/678cd66ce5949.png', '2025-01-19 10:39:40'),
(12, 'Philippine Passport', '/host_id_image/679cc429a09f3.jpg', 'National ID', '/host_id_image/679cc429a0ad0.jpg', '2025-01-31 12:38:01'),
(13, 'UMID Card', '/host_id_image/67a4c8e48fb70.jpg', 'National ID', '/host_id_image/67a4c8e48fd63.jpg', '2025-02-06 14:36:20');

-- --------------------------------------------------------

--
-- Table structure for table `host_reviews`
--

CREATE TABLE `host_reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `host_reviews`
--

INSERT INTO `host_reviews` (`id`, `user_id`, `host_id`, `rating`, `review`, `created_at`, `updated_at`) VALUES
(2, 31, 31, 5, 'Great Experience!', '2025-01-24 13:23:33', '2025-01-24 13:23:33'),
(3, 31, 31, 4, 'Very accomodating!', '2025-01-24 13:24:49', '2025-01-24 13:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `mandatory_discount`
--

CREATE TABLE `mandatory_discount` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `discount_type` enum('PWD','Senior Citizen') NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `discount_id` varchar(50) NOT NULL,
  `card_image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `discount_value` decimal(5,2) NOT NULL DEFAULT 20.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mandatory_discount`
--

INSERT INTO `mandatory_discount` (`id`, `userId`, `discount_type`, `fullname`, `discount_id`, `card_image`, `status`, `created_at`, `updated_at`, `discount_value`) VALUES
(5, 31, 'PWD', 'Joevin Ansoc', '126215090018', '/mandatory_discount_id/6795deb68ae1a.png', 'Active', '2025-01-26 07:05:26', '2025-01-26 07:06:12', 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `content`, `type`, `created_at`) VALUES
(1, 2, 34, 'hELLO', 'text', '2025-02-06 14:03:59'),
(2, 2, 34, 'hello', 'text', '2025-02-06 14:07:23'),
(3, 2, 34, 'hello', 'text', '2025-02-06 14:07:24'),
(4, 2, 34, 'hello', 'text', '2025-02-06 14:07:25'),
(5, 2, 34, 'hello', 'text', '2025-02-06 14:07:26'),
(6, 2, 34, 'hellohello', 'text', '2025-02-06 14:07:27'),
(7, 2, 34, 'hello', 'text', '2025-02-06 14:07:28'),
(8, 2, 34, 'hello', 'text', '2025-02-06 14:07:29'),
(9, 2, 34, 'hello', 'text', '2025-02-06 14:07:30'),
(10, 2, 34, 'hello', 'text', '2025-02-06 14:07:34'),
(11, 2, 34, 'ad', 'text', '2025-02-06 14:10:34'),
(12, 1, 34, '1321213', 'text', '2025-02-06 14:30:53'),
(13, 1, 34, 'asdasdaa', 'text', '2025-02-06 14:30:58'),
(14, 3, 36, 'hello', 'text', '2025-02-06 16:08:31'),
(15, 3, 32, 'you are not welcome to my house', 'text', '2025-02-06 16:16:32'),
(16, 3, 32, 'Im sorry but youre just a betch', 'text', '2025-02-06 16:16:39'),
(17, 3, 32, 'asdas', 'text', '2025-02-06 16:17:58'),
(18, 5, 32, 'Betch?', 'text', '2025-02-06 16:23:56'),
(19, 5, 36, 'hello', 'text', '2025-02-06 16:24:19'),
(20, 5, 36, 'hello', 'text', '2025-02-06 16:24:24'),
(21, 5, 36, 'hellohello', 'text', '2025-02-06 16:24:24'),
(22, 5, 36, 'vvvv', 'text', '2025-02-06 16:24:25'),
(23, 5, 36, 'vv', 'text', '2025-02-06 16:24:26'),
(24, 5, 36, 'v', 'text', '2025-02-06 16:24:26'),
(25, 5, 36, 'v', 'text', '2025-02-06 16:24:26'),
(26, 5, 36, 'vhellohellohellohellohello', 'text', '2025-02-06 16:24:27'),
(27, 5, 36, 'hellovhello', 'text', '2025-02-06 16:24:28'),
(28, 5, 36, 'hello', 'text', '2025-02-06 16:24:28'),
(29, 5, 36, 'hello', 'text', '2025-02-06 16:24:28'),
(30, 5, 36, 'v', 'text', '2025-02-06 16:24:29'),
(31, 5, 36, 'hello', 'text', '2025-02-06 16:24:29'),
(32, 5, 32, 'You are now banned!', 'text', '2025-02-06 16:24:39'),
(33, 5, 32, 'Toxic mf', 'text', '2025-02-06 16:24:40'),
(34, 5, 32, 'Stop texting me stalker', 'text', '2025-02-06 16:24:45'),
(35, 5, 32, 'Dont book this venue!!!!', 'text', '2025-02-06 16:24:50'),
(36, 5, 32, 'I will report you to the admin', 'text', '2025-02-06 16:24:56'),
(37, 5, 32, 'STALKEERRRR!!!', 'text', '2025-02-06 16:24:59'),
(38, 5, 36, 'i AM NOT', 'text', '2025-02-06 16:25:08'),
(39, 5, 36, 'I like you cj', 'text', '2025-02-06 16:25:12'),
(40, 5, 36, 'Im sorry', 'text', '2025-02-06 16:25:14'),
(41, 5, 36, ':<', 'text', '2025-02-06 16:25:15'),
(42, 5, 32, 'Hello sample', 'text', '2025-02-06 16:25:22'),
(43, 6, 35, 'Wehh', 'text', '2025-02-06 16:31:11'),
(44, 7, 35, 'asd', 'text', '2025-02-06 16:33:07'),
(45, 4, 32, 'asdas', 'text', '2025-02-06 16:33:16'),
(46, 8, 32, 'Hello', 'text', '2025-02-06 16:35:14'),
(47, 8, 37, 'asda', 'text', '2025-02-06 16:37:20'),
(48, 8, 32, 'asdasdasd', 'text', '2025-02-06 16:37:30'),
(49, 8, 37, 'asd', 'text', '2025-02-06 16:39:17'),
(50, 8, 37, 'HELLOOOOHELLOOOOHELLOOOOHELLOOOOHELLOOOOHELLOOOO', 'text', '2025-02-06 16:39:40'),
(51, 8, 32, 'ASDAS', 'text', '2025-02-06 16:41:17'),
(52, 8, 37, 'ASDASDA', 'text', '2025-02-06 16:41:21'),
(53, 8, 37, 'ASDASGAOPJDGSD[OJG', 'text', '2025-02-06 16:41:32'),
(54, 5, 32, 'asdas', 'text', '2025-02-06 17:09:22'),
(55, 5, 32, 'asdafagh', 'text', '2025-02-06 17:11:40'),
(56, 5, 32, 'asgasher', 'text', '2025-02-06 17:15:00'),
(57, 8, 32, 'hafhasdha', 'text', '2025-02-06 17:15:04'),
(58, 1, 32, 'mn', 'text', '2025-02-06 17:15:09'),
(59, 8, 32, 'Helllo dear customer', 'text', '2025-02-06 17:18:01'),
(60, 8, 37, 'hello', 'text', '2025-02-06 17:19:48'),
(61, 8, 32, 'asdas', 'text', '2025-02-06 17:20:01'),
(62, 8, 32, 'asdasgasg', 'text', '2025-02-06 17:20:10'),
(63, 8, 32, 'asda', 'text', '2025-02-06 17:21:50'),
(64, 8, 32, 'hELLO DRAGONNN', 'text', '2025-02-06 17:22:05'),
(65, 8, 32, 'Hello sample', 'text', '2025-02-06 17:24:23'),
(66, 8, 32, 'Hello sample', 'text', '2025-02-06 17:24:33'),
(67, 8, 37, 'hello', 'text', '2025-02-06 17:24:47'),
(68, 8, 37, 'jaerarda', 'text', '2025-02-06 17:24:58'),
(69, 8, 32, 'Hello sample', 'text', '2025-02-06 17:25:12'),
(70, 8, 37, 'asdasd', 'text', '2025-02-06 17:26:13'),
(71, 8, 32, 'asda', 'text', '2025-02-06 17:27:03'),
(72, 8, 32, 'asdasd', 'text', '2025-02-06 17:28:40'),
(73, 8, 32, 'shsrhrahd', 'text', '2025-02-06 17:28:48'),
(74, 8, 37, 'asagddsg', 'text', '2025-02-06 17:28:56'),
(75, 8, 37, 'gaSSDG\\S', 'text', '2025-02-06 17:28:58'),
(76, 8, 37, 'HDASDHSDHS', 'text', '2025-02-06 17:31:02'),
(77, 8, 37, 'DSGAHDS', 'text', '2025-02-06 17:31:13'),
(78, 8, 32, 'ADSAS', 'text', '2025-02-06 17:34:31'),
(79, 8, 37, 'asagddsg', 'text', '2025-02-06 17:37:25'),
(80, 8, 32, 'asdasda', 'text', '2025-02-06 17:37:54'),
(81, 8, 32, 'hsrhSDSSD', 'text', '2025-02-06 17:40:13'),
(82, 8, 32, 'SDHADFHADFH', 'text', '2025-02-06 17:40:19'),
(83, 5, 32, 'asagASGAs', 'text', '2025-02-06 17:40:56'),
(84, 5, 32, 'SDGDSAGDDS', 'text', '2025-02-06 17:41:06'),
(85, 8, 32, 'GASGASGASGAS', 'text', '2025-02-06 17:41:51'),
(86, 8, 32, 'SDSJGO\\DSKKDSG', 'text', '2025-02-06 17:41:58'),
(87, 8, 32, 'OJgs;ds;lkgls\\ds', 'text', '2025-02-06 17:42:09'),
(88, 8, 32, 'agsagasga', 'text', '2025-02-06 17:45:37'),
(89, 8, 32, '15212sdfsdgs', 'text', '2025-02-06 17:52:09'),
(90, 8, 32, 'asdasgasga', 'text', '2025-02-06 17:54:13'),
(91, 8, 32, 'dgsdgsdgsd', 'text', '2025-02-06 17:54:45'),
(92, 8, 32, 'asdgasdgsd', 'text', '2025-02-06 17:55:01'),
(93, 8, 32, 'asfasfasfa', 'text', '2025-02-06 17:55:41'),
(94, 8, 32, 'hasrhr', 'text', '2025-02-06 17:56:05'),
(95, 8, 32, 'asgasgas', 'text', '2025-02-06 17:56:42'),
(96, 8, 32, 'safafsas', 'text', '2025-02-06 17:57:15'),
(97, 8, 32, 'asgasga', 'text', '2025-02-06 17:57:22'),
(98, 8, 32, 'asfasfa', 'text', '2025-02-06 17:58:21'),
(99, 8, 37, 'agasgas', 'text', '2025-02-06 17:58:52'),
(100, 8, 37, 'gasgasasg', 'text', '2025-02-06 17:58:59'),
(101, 8, 37, 'agasgasag', 'text', '2025-02-06 17:59:08'),
(102, 8, 32, 'asgpasgakspg', 'text', '2025-02-06 18:00:03'),
(103, 8, 32, 'agasfa', 'text', '2025-02-06 18:00:07'),
(104, 8, 32, 'asfasf', 'text', '2025-02-06 18:00:11'),
(105, 8, 37, 'asgasgasgas', 'text', '2025-02-06 18:06:06'),
(106, 8, 37, 'asfasfas', 'text', '2025-02-06 18:06:16'),
(107, 8, 37, 'saflasf;\'las\'f;a', 'text', '2025-02-06 18:06:21'),
(108, 8, 37, 'asfas;f\'as', 'text', '2025-02-06 18:06:25'),
(109, 8, 37, 'f;as', 'text', '2025-02-06 18:06:26'),
(110, 8, 37, 'asfasfas', 'text', '2025-02-06 18:08:08'),
(111, 8, 37, 'asagddsg', 'text', '2025-02-06 18:12:48'),
(112, 8, 32, 'asdasdasda', 'text', '2025-02-06 18:21:25'),
(113, 8, 32, 'asfasfasfas', 'text', '2025-02-06 18:23:07'),
(114, 8, 32, 'asdasdasdas', 'text', '2025-02-06 18:23:18'),
(115, 8, 37, 'asfasfas', 'text', '2025-02-06 18:23:45'),
(116, 8, 37, 'asdasdas', 'text', '2025-02-06 18:23:50'),
(117, 8, 37, 'asdasdasd', 'text', '2025-02-06 18:23:52'),
(118, 8, 37, 'asfasfas', 'text', '2025-02-06 18:23:54'),
(119, 8, 32, 'asfasfas', 'text', '2025-02-06 18:25:08'),
(120, 8, 32, 'sdfsdfsd', 'text', '2025-02-06 18:25:10'),
(121, 8, 32, 'fgdgdf', 'text', '2025-02-06 18:25:11'),
(122, 8, 32, 'asdasd', 'text', '2025-02-06 18:25:26'),
(123, 8, 37, 'sdasd', 'text', '2025-02-06 18:25:38'),
(124, 8, 37, 'asdadas', 'text', '2025-02-06 18:25:47'),
(125, 8, 37, 'asdasdas', 'text', '2025-02-06 18:26:07'),
(126, 8, 32, 'aasdas', 'text', '2025-02-06 18:26:25'),
(127, 8, 32, 'asdasdasda', 'text', '2025-02-06 18:26:34'),
(128, 8, 32, 'asdadas', 'text', '2025-02-06 18:27:00'),
(129, 1, 32, 'asdasd', 'text', '2025-02-06 18:28:05'),
(130, 4, 32, 'asdasdasda', 'text', '2025-02-06 18:28:11'),
(131, 7, 35, 'asdasdsa', 'text', '2025-02-06 18:29:51'),
(132, 7, 35, 'agsaasgas', 'text', '2025-02-06 18:30:04'),
(133, 10, 32, 'agsasgasgas', 'text', '2025-02-06 18:30:12'),
(134, 8, 37, 'asfasfas', 'text', '2025-02-06 18:31:05'),
(135, 7, 35, 'asdasfasfas', 'text', '2025-02-06 18:32:01'),
(136, 11, 32, 'hELLO', 'text', '2025-02-06 18:34:29'),
(137, 11, 32, 'Helllloaooaso', 'text', '2025-02-06 18:37:23'),
(138, 8, 32, 'asfasfas', 'text', '2025-02-06 18:37:36'),
(139, 11, 38, 'asfasfas', 'text', '2025-02-06 18:37:55'),
(140, 8, 37, 'asdasdad', 'text', '2025-02-06 18:38:00'),
(141, 8, 37, 'asdasda', 'text', '2025-02-06 18:38:43'),
(142, 11, 38, 'asdasdasdsa', 'text', '2025-02-06 18:40:25'),
(143, 11, 38, 'gasgagsa', 'text', '2025-02-06 18:40:26'),
(144, 11, 38, 'asdasd', 'text', '2025-02-06 18:40:39'),
(145, 11, 38, 'asdas', 'text', '2025-02-06 18:41:10'),
(146, 11, 32, 'asdasd', 'text', '2025-02-06 18:41:18'),
(147, 11, 32, 'asdasa', 'text', '2025-02-06 18:41:52'),
(148, 11, 38, 'deliver', 'text', '2025-02-06 18:43:47'),
(149, 11, 38, 'asdas', 'text', '2025-02-06 18:43:55'),
(150, 11, 32, 'asdas', 'text', '2025-02-06 18:44:14'),
(151, 11, 32, 'Hello', 'text', '2025-02-06 18:44:40'),
(152, 11, 32, 'Hello', 'text', '2025-02-06 18:44:54'),
(153, 11, 38, 'Hello', 'text', '2025-02-06 18:45:47'),
(154, 11, 38, 'asdasdasd', 'text', '2025-02-06 18:47:51'),
(155, 11, 38, 'Hello', 'text', '2025-02-06 18:48:12'),
(156, 11, 38, 'Hello', 'text', '2025-02-06 18:48:32'),
(157, 11, 38, 'asdas', 'text', '2025-02-06 18:49:00'),
(158, 11, 32, 'asdasd', 'text', '2025-02-06 18:51:52'),
(159, 11, 38, 'asdasd', 'text', '2025-02-06 18:52:17'),
(160, 11, 38, 'asdasdasd', 'text', '2025-02-06 18:52:24'),
(161, 11, 38, 'asdasd', 'text', '2025-02-06 18:52:34'),
(162, 11, 32, 'asdasdas', 'text', '2025-02-06 18:52:47'),
(163, 11, 32, 'asdasda', 'text', '2025-02-06 18:52:58'),
(164, 11, 32, 'aasdasd', 'text', '2025-02-06 18:53:11'),
(165, 11, 38, 'asdasdas', 'text', '2025-02-06 18:53:35'),
(166, 11, 38, 'asdasdas', 'text', '2025-02-06 18:54:15'),
(167, 11, 38, 'asdasdas', 'text', '2025-02-06 18:54:16'),
(168, 11, 38, 'asdasdas', 'text', '2025-02-06 18:54:42'),
(169, 11, 32, 'asdasdasd', 'text', '2025-02-06 18:55:42'),
(170, 11, 32, 'asdasda', 'text', '2025-02-06 18:55:42'),
(171, 11, 32, 'sadas', 'text', '2025-02-06 18:55:43'),
(172, 11, 32, 'asd', 'text', '2025-02-06 18:55:43'),
(173, 11, 32, 'asasdas', 'text', '2025-02-06 18:57:29'),
(174, 8, 32, 'asdads', 'text', '2025-02-06 18:58:27'),
(175, 11, 32, 'asdasd', 'text', '2025-02-06 18:58:29'),
(176, 11, 38, 'asdasdas', 'text', '2025-02-06 18:58:37'),
(177, 11, 38, 'asdasdas', 'text', '2025-02-06 18:59:08'),
(178, 11, 38, 'asafasfas', 'text', '2025-02-06 18:59:11'),
(179, 11, 38, 'asdasdasd', 'text', '2025-02-06 18:59:15'),
(180, 11, 32, 'asdasdas', 'text', '2025-02-06 18:59:24'),
(181, 11, 32, 'asdasd', 'text', '2025-02-06 18:59:25'),
(182, 11, 32, 'asdas', 'text', '2025-02-06 18:59:26'),
(183, 11, 32, 'asdasdsa', 'text', '2025-02-06 19:02:07'),
(184, 11, 32, 'asdasdas', 'text', '2025-02-06 19:02:09'),
(185, 11, 32, 'asdasd', 'text', '2025-02-06 19:02:17'),
(186, 11, 32, 'afasfa', 'text', '2025-02-06 19:02:18'),
(187, 11, 32, 'asdasdagasgas', 'text', '2025-02-06 19:02:27'),
(188, 11, 32, 'gassag', 'text', '2025-02-06 19:02:29'),
(189, 11, 32, 'asd', 'text', '2025-02-06 19:03:05'),
(190, 11, 38, 'asdas', 'text', '2025-02-06 19:03:14'),
(191, 11, 38, 'asdas', 'text', '2025-02-06 19:03:18'),
(192, 11, 38, 'asdas', 'text', '2025-02-06 19:03:23'),
(193, 11, 38, 'asdas', 'text', '2025-02-06 19:03:31'),
(194, 11, 38, 'asdas', 'text', '2025-02-06 19:03:33'),
(195, 11, 38, 'asdasd', 'text', '2025-02-06 19:03:43'),
(196, 11, 38, 'gasagsa', 'text', '2025-02-06 19:03:47'),
(197, 11, 32, 'sdsadas', 'text', '2025-02-06 19:03:53'),
(198, 11, 32, 'asdasd', 'text', '2025-02-06 19:04:00'),
(199, 11, 32, 'asdgasasg', 'text', '2025-02-06 19:04:01'),
(200, 11, 38, 'asdasda', 'text', '2025-02-06 19:04:06'),
(201, 11, 38, 'asdasd', 'text', '2025-02-06 19:04:14'),
(202, 1, 32, 'asda', 'text', '2025-02-06 19:05:54'),
(203, 1, 32, 'asdas', 'text', '2025-02-06 19:05:56'),
(204, 11, 32, 'adagassa', 'text', '2025-02-06 19:06:07'),
(205, 11, 32, 'gasagsa', 'text', '2025-02-06 19:06:20'),
(206, 11, 38, 'asdasgasgl', 'text', '2025-02-06 19:06:37'),
(207, 11, 32, 'asda', 'text', '2025-02-06 19:08:46'),
(208, 11, 32, 'asdasda', 'text', '2025-02-06 19:08:58'),
(209, 11, 38, 'adasda', 'text', '2025-02-06 19:09:04'),
(210, 11, 32, 'asdasd', 'text', '2025-02-06 19:10:07'),
(211, 11, 32, 'asdasda', 'text', '2025-02-06 19:10:16'),
(212, 11, 32, 'asdasd', 'text', '2025-02-06 19:10:17'),
(213, 11, 32, 'asdas', 'text', '2025-02-06 19:10:17'),
(214, 11, 32, 'asdasd', 'text', '2025-02-06 19:10:27'),
(215, 11, 32, 'asdasd', 'text', '2025-02-06 19:10:45'),
(216, 11, 38, 'asdasd', 'text', '2025-02-06 19:11:06'),
(217, 11, 32, 'asdas', 'text', '2025-02-06 19:11:10'),
(218, 11, 38, 'asdasd', 'text', '2025-02-06 19:11:17'),
(219, 11, 38, 'asdasd', 'text', '2025-02-06 19:11:22'),
(220, 11, 32, 'asdasdsa', 'text', '2025-02-06 19:11:32'),
(221, 11, 32, 'asdasd', 'text', '2025-02-06 19:11:33'),
(222, 11, 32, 'asdas', 'text', '2025-02-06 19:12:07'),
(223, 11, 32, 'asdadsa', 'text', '2025-02-06 19:12:13'),
(224, 11, 32, 'asdasd', 'text', '2025-02-06 19:13:46'),
(225, 11, 38, 'asdasd', 'text', '2025-02-06 19:13:54'),
(226, 11, 38, 'asdasd', 'text', '2025-02-06 19:13:57'),
(227, 11, 38, 'asdas', 'text', '2025-02-06 19:14:04'),
(228, 11, 38, 'asfasfas', 'text', '2025-02-06 19:14:09'),
(229, 11, 32, 'asdasd', 'text', '2025-02-06 19:14:16'),
(230, 11, 32, 'asdas', 'text', '2025-02-06 19:14:17'),
(231, 11, 32, 'asdas', 'text', '2025-02-06 19:14:22'),
(232, 11, 38, 'asdas', 'text', '2025-02-06 19:14:37'),
(233, 11, 38, 'asdasda', 'text', '2025-02-06 19:14:44'),
(234, 11, 38, 'asdas', 'text', '2025-02-06 19:16:21'),
(235, 11, 38, 'asdasd', 'text', '2025-02-06 19:16:26'),
(236, 11, 32, 'asdas', 'text', '2025-02-06 19:18:57'),
(237, 11, 32, 'asdas', 'text', '2025-02-06 19:19:05'),
(238, 11, 32, 'asdas', 'text', '2025-02-06 19:19:23'),
(239, 11, 32, 'dasasdas', 'text', '2025-02-06 19:19:24'),
(240, 11, 32, 'asdasd', 'text', '2025-02-06 19:19:31'),
(241, 11, 38, 'asdasdsa', 'text', '2025-02-06 19:19:47'),
(242, 11, 38, 'asdasda', 'text', '2025-02-06 19:19:48'),
(243, 11, 38, 'asdasd', 'text', '2025-02-06 19:19:49'),
(244, 11, 38, 'sadas', 'text', '2025-02-06 19:20:32'),
(245, 11, 38, 'asdasd', 'text', '2025-02-06 19:20:43'),
(246, 11, 38, 'asdas', 'text', '2025-02-06 19:21:15'),
(247, 11, 38, 'asdasd', 'text', '2025-02-06 19:21:18'),
(248, 11, 38, 'asdas', 'text', '2025-02-06 19:21:22'),
(249, 11, 32, 'asdasd', 'text', '2025-02-06 19:21:29'),
(250, 11, 32, 'asdasd', 'text', '2025-02-06 19:21:35'),
(251, 11, 38, 'asdasd', 'text', '2025-02-06 19:21:38'),
(252, 11, 38, 'asdas', 'text', '2025-02-06 19:21:45'),
(253, 11, 38, 'asdas', 'text', '2025-02-06 19:23:19'),
(254, 11, 32, 'asdas', 'text', '2025-02-06 19:23:24'),
(255, 11, 32, 'asdas', 'text', '2025-02-06 19:23:33'),
(256, 11, 32, 'asdasd', 'text', '2025-02-06 19:25:56'),
(257, 11, 38, 'asdasd', 'text', '2025-02-06 19:26:09'),
(258, 11, 38, 'asda', 'text', '2025-02-06 19:26:18'),
(259, 11, 38, 'asdas', 'text', '2025-02-06 19:27:08'),
(260, 11, 38, 'asdas', 'text', '2025-02-06 19:28:02'),
(261, 11, 32, 'asdasd', 'text', '2025-02-06 19:28:32'),
(262, 11, 38, 'asdasd', 'text', '2025-02-06 19:28:37'),
(263, 11, 38, 'asda', 'text', '2025-02-06 19:28:42'),
(264, 11, 38, 'asfasfa', 'text', '2025-02-06 19:28:46'),
(265, 11, 38, 'hgaasasgas', 'text', '2025-02-06 19:28:48'),
(266, 11, 38, 'asdas', 'text', '2025-02-06 19:28:57'),
(267, 11, 32, 'asdas', 'text', '2025-02-06 19:31:06'),
(268, 11, 32, 'asdas', 'text', '2025-02-06 19:33:12'),
(269, 11, 32, 'asdasdas', 'text', '2025-02-06 19:33:15'),
(270, 11, 32, 'asdasd', 'text', '2025-02-06 19:33:15'),
(271, 11, 32, 'asdas', 'text', '2025-02-06 19:33:16'),
(272, 11, 38, 'asdasdas', 'text', '2025-02-06 19:33:22'),
(273, 11, 38, 'asdas', 'text', '2025-02-06 19:35:50'),
(274, 11, 38, 'gasdasasd', 'text', '2025-02-06 19:35:58'),
(275, 11, 38, 'asdasd', 'text', '2025-02-06 19:36:02'),
(276, 11, 38, 'fsasaf', 'text', '2025-02-06 19:38:18'),
(277, 11, 32, 'gassa', 'text', '2025-02-06 19:38:24'),
(278, 10, 32, 'asdas', 'text', '2025-02-06 19:38:27'),
(279, 4, 32, 'asdas', 'text', '2025-02-06 19:38:30'),
(280, 1, 32, 'asdas.', 'text', '2025-02-06 19:38:33'),
(281, 11, 32, 'asdas', 'text', '2025-02-06 19:38:38'),
(282, 11, 38, 'asdads', 'text', '2025-02-06 19:38:40'),
(283, 11, 32, 'asdas', 'text', '2025-02-06 19:38:45'),
(284, 11, 32, 'asdasd', 'text', '2025-02-06 19:38:47'),
(285, 11, 32, 'asdasd', 'text', '2025-02-06 19:41:11'),
(286, 11, 32, 'asdasdas', 'text', '2025-02-06 19:41:17'),
(287, 11, 32, 'asdas', 'text', '2025-02-06 19:43:22'),
(288, 11, 32, 'asdas', 'text', '2025-02-06 19:44:10'),
(289, 11, 38, 'asdasd', 'text', '2025-02-06 19:45:13'),
(290, 11, 38, 'asdasd', 'text', '2025-02-06 19:45:13'),
(291, 11, 32, 'asdasd', 'text', '2025-02-06 19:46:34'),
(292, 11, 32, 'asda', 'text', '2025-02-06 19:46:36'),
(293, 11, 38, 'asda', 'text', '2025-02-06 19:46:42'),
(294, 11, 38, 'asdas', 'text', '2025-02-06 19:46:43'),
(295, 11, 38, 'asda', 'text', '2025-02-06 19:46:46'),
(296, 11, 32, 'asdas', 'text', '2025-02-06 19:47:15'),
(297, 11, 32, 'asdsas', 'text', '2025-02-06 19:47:27'),
(298, 11, 32, 'asdsad', 'text', '2025-02-06 19:49:35'),
(299, 11, 32, 'asdasd', 'text', '2025-02-06 19:49:55'),
(300, 11, 38, 'asdasd', 'text', '2025-02-06 19:50:04'),
(301, 11, 38, 'asdasd', 'text', '2025-02-06 19:50:28'),
(302, 11, 38, 'asdas', 'text', '2025-02-06 19:50:28'),
(303, 11, 38, 'asdas', 'text', '2025-02-06 19:50:29'),
(304, 11, 32, 'adas', 'text', '2025-02-06 19:55:12'),
(305, 11, 32, 'asdas', 'text', '2025-02-06 19:55:13'),
(306, 11, 32, 'asdasdas', 'text', '2025-02-06 19:59:07'),
(307, 11, 32, 'adasdasgas', 'text', '2025-02-06 19:59:13'),
(308, 11, 32, 'asgasgas', 'text', '2025-02-06 19:59:14'),
(309, 11, 38, 'asdad', 'text', '2025-02-06 19:59:28'),
(310, 11, 32, 'asdasgasga', 'text', '2025-02-06 19:59:32'),
(311, 11, 38, 'sadasd', 'text', '2025-02-06 19:59:39'),
(312, 11, 38, 'asda', 'text', '2025-02-06 20:11:56'),
(313, 11, 38, 'asdas', 'text', '2025-02-06 20:14:28'),
(314, 11, 38, 'asdad', 'text', '2025-02-06 20:14:30'),
(315, 11, 38, 'asdas', 'text', '2025-02-06 20:14:33'),
(316, 11, 38, 'asdasa', 'text', '2025-02-06 20:14:40'),
(317, 11, 32, 'asdasda', 'text', '2025-02-06 20:14:43'),
(318, 11, 38, 'asdasd', 'text', '2025-02-06 20:17:02'),
(319, 11, 38, 'adas', 'text', '2025-02-06 20:17:08'),
(320, 11, 38, 'adas', 'text', '2025-02-06 20:17:13'),
(321, 11, 38, 'asdasd', 'text', '2025-02-06 20:17:43'),
(322, 11, 32, 'adas', 'text', '2025-02-06 20:17:49'),
(323, 11, 32, 'asdasd', 'text', '2025-02-06 20:17:52'),
(324, 11, 32, 'asdas', 'text', '2025-02-06 20:17:56'),
(325, 11, 32, 'asdasd', 'text', '2025-02-06 20:18:01'),
(326, 11, 38, 'asdas', 'text', '2025-02-06 20:20:17'),
(327, 11, 38, 'asdas', 'text', '2025-02-06 20:20:18'),
(328, 11, 38, 'asdasdsa', 'text', '2025-02-06 20:20:29'),
(329, 11, 38, 'asd', 'text', '2025-02-06 20:20:39'),
(330, 11, 32, 'asda', 'text', '2025-02-06 20:20:45'),
(331, 11, 32, 'asdas', 'text', '2025-02-06 20:20:58'),
(332, 11, 38, 'asd', 'text', '2025-02-06 20:31:06'),
(333, 11, 32, 'adasd', 'text', '2025-02-06 20:31:50'),
(334, 11, 38, 'asdasd', 'text', '2025-02-06 20:31:55'),
(335, 11, 38, 'asda', 'text', '2025-02-06 20:32:06'),
(336, 11, 38, 'asdas', 'text', '2025-02-06 20:32:08'),
(337, 11, 32, 'asd', 'text', '2025-02-06 20:33:29'),
(338, 11, 38, 'asd', 'text', '2025-02-06 20:33:38'),
(339, 11, 38, 'asd', 'text', '2025-02-06 20:33:48'),
(340, 11, 32, 'asd', 'text', '2025-02-06 20:38:10'),
(341, 11, 38, 'asdas', 'text', '2025-02-06 20:38:17'),
(342, 11, 32, 'asdas', 'text', '2025-02-06 20:38:27'),
(343, 11, 32, 'adas', 'text', '2025-02-06 20:38:35'),
(344, 11, 32, 'asdas', 'text', '2025-02-06 20:38:37'),
(345, 11, 32, 'lml', 'text', '2025-02-06 20:38:41'),
(346, 11, 38, 'asdas', 'text', '2025-02-06 20:42:25'),
(347, 11, 38, 'asdas', 'text', '2025-02-06 20:42:37'),
(348, 11, 32, 'asdasd', 'text', '2025-02-06 20:42:43'),
(349, 11, 38, 'asdasd', 'text', '2025-02-06 20:42:49'),
(350, 11, 38, 'asdasd', 'text', '2025-02-06 20:42:50'),
(351, 11, 38, 'asdas', 'text', '2025-02-06 20:42:50'),
(352, 11, 38, 'asdasd', 'text', '2025-02-06 21:16:59'),
(353, 11, 32, 'asdasd', 'text', '2025-02-06 21:27:57'),
(354, 11, 38, 'asdad', 'text', '2025-02-06 21:28:03'),
(355, 11, 38, 'asdasda', 'text', '2025-02-06 21:28:16'),
(356, 11, 38, 'adas', 'text', '2025-02-06 21:28:18'),
(357, 12, 38, 'asdas', 'text', '2025-02-06 21:36:38'),
(358, 12, 38, 'asdasdas', 'text', '2025-02-06 21:36:49'),
(359, 12, 38, 'asdasda', 'text', '2025-02-06 21:37:03'),
(360, 12, 38, 'asda', 'text', '2025-02-06 21:39:07'),
(361, 12, 38, 'asdas', 'text', '2025-02-06 21:39:14'),
(362, 12, 38, 'adas', 'text', '2025-02-06 21:39:15'),
(363, 12, 38, 'asdas', 'text', '2025-02-06 21:39:20'),
(364, 12, 38, 'asdad', 'text', '2025-02-06 21:39:25'),
(365, 13, 38, 'asdas', 'text', '2025-02-06 21:49:13'),
(366, 13, 38, 'asda', 'text', '2025-02-06 21:49:25'),
(367, 13, 32, 'ASDASDA', 'text', '2025-02-06 21:51:04'),
(368, 13, 32, 'ASDASDGASG', 'text', '2025-02-06 21:51:40'),
(369, 13, 32, 'ASDAD', 'text', '2025-02-06 21:51:57'),
(370, 14, 32, 'ASDAS', 'text', '2025-02-06 21:54:17'),
(371, 13, 38, 'ASDASDS', 'text', '2025-02-06 21:56:17'),
(372, 13, 38, 'ASDAS', 'text', '2025-02-06 21:56:19'),
(373, 13, 38, 'ASD', 'text', '2025-02-06 21:56:20'),
(374, 13, 38, 'ASDA', 'text', '2025-02-06 21:56:20'),
(375, 13, 38, 'DAS', 'text', '2025-02-06 21:56:20'),
(376, 13, 38, 'DA', 'text', '2025-02-06 21:56:20'),
(377, 13, 38, 'SD', 'text', '2025-02-06 21:56:21'),
(378, 13, 38, 'ASD', 'text', '2025-02-06 21:56:21'),
(379, 13, 38, 'AS', 'text', '2025-02-06 21:56:21'),
(380, 13, 38, 'DS', 'text', '2025-02-06 21:56:21'),
(381, 13, 38, 'ASD', 'text', '2025-02-06 21:56:21'),
(382, 13, 38, 'AS', 'text', '2025-02-06 21:56:22'),
(383, 13, 38, 'DA', 'text', '2025-02-06 21:56:22'),
(384, 13, 38, 'DS', 'text', '2025-02-06 21:56:22'),
(385, 13, 38, 'AS', 'text', '2025-02-06 21:56:22'),
(386, 13, 38, 'DAS', 'text', '2025-02-06 21:56:22'),
(387, 13, 38, 'D', 'text', '2025-02-06 21:56:23'),
(388, 13, 38, 'ASD', 'text', '2025-02-06 21:56:23'),
(389, 13, 38, 'AS', 'text', '2025-02-06 21:56:23'),
(390, 13, 38, 'AS', 'text', '2025-02-06 21:56:23'),
(391, 13, 38, 'D', 'text', '2025-02-06 21:56:23'),
(392, 13, 38, 'D', 'text', '2025-02-06 21:56:24'),
(393, 13, 38, 'AS', 'text', '2025-02-06 21:56:24'),
(394, 13, 38, 'AS', 'text', '2025-02-06 21:56:24'),
(395, 13, 38, 'AS', 'text', '2025-02-06 21:56:24'),
(396, 13, 38, 'DAS', 'text', '2025-02-06 21:56:24'),
(397, 13, 38, 'A', 'text', '2025-02-06 21:56:25'),
(398, 13, 38, 'G', 'text', '2025-02-06 21:56:25'),
(399, 13, 38, 'AS', 'text', '2025-02-06 21:56:25'),
(400, 13, 38, 'GA', 'text', '2025-02-06 21:56:25'),
(401, 13, 38, 'G', 'text', '2025-02-06 21:56:26'),
(402, 13, 38, 'AS', 'text', '2025-02-06 21:56:26'),
(403, 13, 38, 'GA', 'text', '2025-02-06 21:56:26'),
(404, 13, 38, 'SG', 'text', '2025-02-06 21:56:26'),
(405, 13, 38, 'ASG', 'text', '2025-02-06 21:56:26'),
(406, 13, 38, 'ASG', 'text', '2025-02-06 21:56:27'),
(407, 13, 38, 'AS', 'text', '2025-02-06 21:56:27'),
(408, 13, 38, 'G', 'text', '2025-02-06 21:56:27'),
(409, 13, 38, 'ASG', 'text', '2025-02-06 21:56:27'),
(410, 13, 38, 'AS', 'text', '2025-02-06 21:56:27'),
(411, 13, 38, 'G', 'text', '2025-02-06 21:56:28'),
(412, 13, 38, 'SG', 'text', '2025-02-06 21:56:28'),
(413, 13, 38, 'AS', 'text', '2025-02-06 21:56:28'),
(414, 13, 38, 'GAS', 'text', '2025-02-06 21:56:28'),
(415, 13, 38, 'G', 'text', '2025-02-06 21:56:29'),
(416, 13, 38, 'AS', 'text', '2025-02-06 21:56:29'),
(417, 13, 38, 'GAS', 'text', '2025-02-06 21:56:29'),
(418, 13, 38, 'G', 'text', '2025-02-06 21:56:29'),
(419, 13, 38, 'ASG', 'text', '2025-02-06 21:56:29'),
(420, 13, 38, 'AS', 'text', '2025-02-06 21:56:30'),
(421, 13, 38, 'G', 'text', '2025-02-06 21:56:30'),
(422, 13, 38, 'ASG', 'text', '2025-02-06 21:56:30'),
(423, 13, 38, 'AS', 'text', '2025-02-06 21:56:30'),
(424, 13, 38, 'GA', 'text', '2025-02-06 21:56:31'),
(425, 13, 38, 'SG', 'text', '2025-02-06 21:56:31'),
(426, 13, 38, 'AS', 'text', '2025-02-06 21:56:31'),
(427, 13, 38, 'G', 'text', '2025-02-06 21:56:31'),
(428, 13, 38, 'ASG', 'text', '2025-02-06 21:56:31'),
(429, 13, 38, 'AS', 'text', '2025-02-06 21:56:32'),
(430, 13, 38, 'G', 'text', '2025-02-06 21:56:32'),
(431, 13, 38, 'SG', 'text', '2025-02-06 21:56:32'),
(432, 13, 38, 'AS', 'text', '2025-02-06 21:56:32'),
(433, 13, 38, 'G', 'text', '2025-02-06 21:56:33'),
(434, 13, 38, 'ASG', 'text', '2025-02-06 21:56:33'),
(435, 13, 38, 'AS', 'text', '2025-02-06 21:56:33'),
(436, 13, 38, 'G', 'text', '2025-02-06 21:56:33'),
(437, 13, 38, 'SG', 'text', '2025-02-06 21:56:33'),
(438, 13, 38, 'AS', 'text', '2025-02-06 21:56:34'),
(439, 13, 38, 'GA', 'text', '2025-02-06 21:56:34'),
(440, 13, 38, 'SG', 'text', '2025-02-06 21:56:34'),
(441, 13, 38, 'AS', 'text', '2025-02-06 21:56:34'),
(442, 13, 38, 'GAS', 'text', '2025-02-06 21:56:35'),
(443, 13, 38, 'G', 'text', '2025-02-06 21:56:35'),
(444, 13, 38, 'AS', 'text', '2025-02-06 21:56:35'),
(445, 13, 38, 'GAS', 'text', '2025-02-06 21:56:35'),
(446, 13, 38, 'G', 'text', '2025-02-06 21:56:35'),
(447, 13, 38, 'SAG', 'text', '2025-02-06 21:56:36'),
(448, 13, 38, 'AS', 'text', '2025-02-06 21:56:36'),
(449, 13, 38, 'G', 'text', '2025-02-06 21:56:36'),
(450, 13, 38, 'ASG', 'text', '2025-02-06 21:56:36'),
(451, 13, 38, 'AS', 'text', '2025-02-06 21:56:37'),
(452, 13, 38, 'G', 'text', '2025-02-06 21:56:37'),
(453, 13, 38, 'AGSSA', 'text', '2025-02-06 21:56:38'),
(454, 13, 38, 'ASGA', 'text', '2025-02-06 21:56:39'),
(455, 13, 38, 'SASG', 'text', '2025-02-06 21:56:39'),
(456, 13, 38, 'ASGAS', 'text', '2025-02-06 21:56:40'),
(457, 13, 38, 'GA', 'text', '2025-02-06 21:56:40'),
(458, 13, 38, 'SGA', 'text', '2025-02-06 21:56:40'),
(459, 13, 38, 'SGAS', 'text', '2025-02-06 21:56:41'),
(460, 13, 38, 'G', 'text', '2025-02-06 21:56:41'),
(461, 13, 38, 'ASGA', 'text', '2025-02-06 21:56:41'),
(462, 13, 38, 'GAS', 'text', '2025-02-06 21:56:42'),
(463, 13, 38, 'ASDASFASGASG', 'text', '2025-02-06 21:56:53'),
(464, 13, 38, 'ASGAS', 'text', '2025-02-06 21:56:53'),
(465, 13, 38, 'GASG', 'text', '2025-02-06 21:56:54'),
(466, 13, 38, 'AS', 'text', '2025-02-06 21:56:54'),
(467, 13, 38, 'GAS', 'text', '2025-02-06 21:56:54'),
(468, 13, 38, 'G', 'text', '2025-02-06 21:56:55'),
(469, 13, 38, 'ASG', 'text', '2025-02-06 21:56:55'),
(470, 13, 38, 'AS', 'text', '2025-02-06 21:56:55'),
(471, 13, 38, 'H', 'text', '2025-02-06 21:56:55'),
(472, 13, 38, 'HA', 'text', '2025-02-06 21:56:55'),
(473, 13, 38, 'SH', 'text', '2025-02-06 21:56:56'),
(474, 13, 38, 'AS', 'text', '2025-02-06 21:56:56'),
(475, 13, 38, 'S', 'text', '2025-02-06 21:56:56'),
(476, 13, 38, 'A', 'text', '2025-02-06 21:56:56'),
(477, 13, 38, 'H', 'text', '2025-02-06 21:56:56'),
(478, 13, 38, 'A', 'text', '2025-02-06 21:56:57'),
(479, 13, 38, 'AS', 'text', '2025-02-06 21:56:57'),
(480, 13, 38, 'ASH', 'text', '2025-02-06 21:56:58'),
(481, 13, 38, 'SA', 'text', '2025-02-06 21:56:58'),
(482, 13, 38, 'SA', 'text', '2025-02-06 21:56:58'),
(483, 13, 38, 'H', 'text', '2025-02-06 21:56:58'),
(484, 13, 38, 'A', 'text', '2025-02-06 21:56:58'),
(485, 13, 38, 'HA', 'text', '2025-02-06 21:56:59'),
(486, 13, 38, 'S', 'text', '2025-02-06 21:56:59'),
(487, 13, 38, 'AS', 'text', '2025-02-06 21:57:00'),
(488, 13, 32, 'ASD', 'text', '2025-02-06 22:12:19'),
(489, 13, 32, 'ASD', 'text', '2025-02-06 22:12:23'),
(490, 13, 38, 'ASD', 'text', '2025-02-06 22:12:28'),
(491, 13, 32, 'ASDA', 'text', '2025-02-06 22:12:35'),
(492, 13, 32, 'ASD', 'text', '2025-02-06 22:12:38'),
(493, 13, 38, 'ASD', 'text', '2025-02-06 22:12:44'),
(494, 13, 38, 'AAASD', 'text', '2025-02-06 22:12:47'),
(495, 13, 32, 'ADAS', 'text', '2025-02-06 22:12:56'),
(496, 7, 35, 'Hello', 'text', '2025-02-07 03:51:51'),
(497, 15, 32, 'aslkagklasl', 'text', '2025-02-07 03:52:20'),
(498, 8, 32, 'Hello', 'text', '2025-02-07 04:11:23'),
(499, 8, 37, 'Hi', 'text', '2025-02-07 04:11:49'),
(500, 8, 37, 'Hiii', 'text', '2025-02-07 04:11:57'),
(501, 8, 32, 'sadasd', 'text', '2025-02-07 04:13:04'),
(502, 16, 35, 'Hello', 'text', '2025-02-07 04:14:54'),
(503, 1, 32, 'hell o', 'text', '2025-02-07 04:15:20'),
(504, 7, 35, 'Hello', 'text', '2025-02-07 04:15:37'),
(505, 16, 35, 'Hellloo', 'text', '2025-02-07 04:15:41'),
(506, 33, 37, 'Helloloo', 'text', '2025-02-07 04:32:21'),
(507, 8, 37, 'Hello', 'text', '2025-02-07 04:40:03'),
(508, 8, 37, 'saddas', 'text', '2025-02-07 04:40:15'),
(509, 8, 32, 'asdas', 'text', '2025-02-07 04:40:25'),
(510, 8, 32, 'klasdkas', 'text', '2025-02-07 04:40:38'),
(511, 8, 37, 'asdasd', 'text', '2025-02-07 04:40:53'),
(512, 8, 37, 'hello', 'text', '2025-02-07 14:33:02'),
(513, 8, 32, 'HiiII!!', 'text', '2025-02-07 14:39:43'),
(514, 8, 37, 'Hi benn', 'text', '2025-02-07 14:42:27'),
(515, 8, 32, 'Hello senny', 'text', '2025-02-07 14:52:18'),
(516, 8, 32, 'sseney?', 'text', '2025-02-07 14:58:59'),
(517, 8, 32, 'hello!/\\', 'text', '2025-02-07 14:59:07'),
(518, 8, 37, 'Hello', 'text', '2025-02-07 15:05:52'),
(519, 8, 37, 'nonono', 'text', '2025-02-07 15:06:06'),
(520, 8, 37, 'Heyyyy', 'text', '2025-02-07 15:06:15'),
(521, 8, 37, 'Haluu', 'text', '2025-02-07 15:07:25'),
(522, 8, 37, 'Helllloooo!!', 'text', '2025-02-07 15:07:47'),
(523, 8, 37, 'AYYYYY', 'text', '2025-02-07 15:07:56'),
(524, 8, 37, 'ayyhashash', 'text', '2025-02-07 15:25:56'),
(525, 8, 37, 'HAHAHAHAHAHA\'', 'text', '2025-02-07 15:26:14'),
(526, 8, 32, 'Ehhh?', 'text', '2025-02-07 15:27:34'),
(527, 8, 32, 'What', 'text', '2025-02-07 15:27:41'),
(528, 8, 32, 'What do you want', 'text', '2025-02-07 15:27:45'),
(529, 8, 37, 'Nothing', 'text', '2025-02-07 15:31:37'),
(530, 8, 37, 'Just wanted to bother you', 'text', '2025-02-07 15:31:49'),
(531, 8, 32, 'Okay???!?!?', 'text', '2025-02-07 15:32:36'),
(532, 8, 32, 'Hello>!>!>!>!>?!?!?!', 'text', '2025-02-07 15:33:07'),
(533, 8, 32, 'Alright', 'text', '2025-02-07 15:33:14'),
(534, 8, 32, 'Heyyy', 'text', '2025-02-07 15:35:40'),
(535, 8, 32, 'You alright?', 'text', '2025-02-07 15:35:48');

-- --------------------------------------------------------

--
-- Table structure for table `message_status`
--

CREATE TABLE `message_status` (
  `id` int(11) NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message_status`
--

INSERT INTO `message_status` (`id`, `message_id`, `user_id`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(2, 2, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(3, 3, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(4, 4, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(5, 5, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(6, 6, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(7, 7, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(8, 8, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(9, 9, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(10, 10, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(11, 11, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(12, 12, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(13, 13, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(14, 14, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(15, 15, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(16, 16, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(17, 17, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(18, 18, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(19, 19, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(20, 20, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(21, 21, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(22, 22, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(23, 23, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(24, 24, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(25, 25, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(26, 26, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(27, 27, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(28, 28, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(29, 29, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(30, 30, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(31, 31, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(32, 32, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(33, 33, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(34, 34, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(35, 35, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(36, 36, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(37, 37, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(38, 38, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(39, 39, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(40, 40, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(41, 41, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(42, 42, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(43, 43, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(44, 44, 32, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(45, 46, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(46, 47, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(47, 48, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(48, 49, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(49, 50, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(50, 51, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(51, 52, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(52, 53, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(53, 54, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(54, 55, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(55, 56, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(56, 57, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(57, 58, 34, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(58, 59, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(59, 60, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(60, 61, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(61, 62, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(62, 63, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(63, 64, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(64, 65, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(65, 66, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(66, 67, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(67, 68, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(68, 69, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(69, 70, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(70, 71, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(71, 72, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(72, 73, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(73, 74, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(74, 75, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(75, 76, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(76, 77, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(77, 78, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(78, 78, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(79, 79, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(80, 79, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(81, 80, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(82, 80, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(83, 81, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(84, 81, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(85, 82, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(86, 82, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(87, 83, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(88, 83, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(89, 84, 36, 0, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(90, 84, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(91, 85, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(92, 85, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(93, 86, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(94, 86, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(95, 87, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(96, 87, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(97, 88, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(98, 88, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(99, 89, 37, 1, '2025-02-06 17:53:58', '2025-02-06 17:54:47'),
(100, 89, 32, 1, '2025-02-06 17:53:58', '2025-02-06 17:53:58'),
(101, 90, 37, 1, '2025-02-06 17:54:13', '2025-02-06 17:54:47'),
(102, 90, 32, 1, '2025-02-06 17:54:13', '2025-02-06 17:54:13'),
(103, 91, 37, 1, '2025-02-06 17:54:45', '2025-02-06 17:54:47'),
(104, 91, 32, 1, '2025-02-06 17:54:45', '2025-02-06 17:54:45'),
(105, 92, 37, 1, '2025-02-06 17:55:01', '2025-02-06 17:55:06'),
(106, 92, 32, 1, '2025-02-06 17:55:01', '2025-02-06 17:55:01'),
(107, 93, 37, 1, '2025-02-06 17:55:41', '2025-02-06 17:55:47'),
(108, 93, 32, 1, '2025-02-06 17:55:41', '2025-02-06 17:55:41'),
(109, 94, 37, 1, '2025-02-06 17:56:05', '2025-02-06 17:56:35'),
(110, 94, 32, 1, '2025-02-06 17:56:05', '2025-02-06 17:56:05'),
(111, 95, 37, 1, '2025-02-06 17:56:42', '2025-02-06 17:56:47'),
(112, 95, 32, 1, '2025-02-06 17:56:42', '2025-02-06 17:56:42'),
(113, 96, 37, 1, '2025-02-06 17:57:15', '2025-02-06 17:57:15'),
(114, 96, 32, 1, '2025-02-06 17:57:15', '2025-02-06 17:57:15'),
(115, 97, 37, 1, '2025-02-06 17:57:22', '2025-02-06 17:57:47'),
(116, 97, 32, 1, '2025-02-06 17:57:22', '2025-02-06 17:57:22'),
(117, 98, 37, 1, '2025-02-06 17:58:21', '2025-02-06 17:58:44'),
(118, 98, 32, 1, '2025-02-06 17:58:21', '2025-02-06 17:58:21'),
(119, 99, 32, 1, '2025-02-06 17:58:52', '2025-02-06 17:58:56'),
(120, 99, 37, 1, '2025-02-06 17:58:52', '2025-02-06 17:58:52'),
(121, 100, 32, 1, '2025-02-06 17:58:59', '2025-02-06 17:59:43'),
(122, 100, 37, 1, '2025-02-06 17:58:59', '2025-02-06 17:58:59'),
(123, 101, 32, 1, '2025-02-06 17:59:08', '2025-02-06 17:59:43'),
(124, 101, 37, 1, '2025-02-06 17:59:08', '2025-02-06 17:59:08'),
(125, 102, 37, 1, '2025-02-06 18:00:03', '2025-02-06 18:00:47'),
(126, 102, 32, 1, '2025-02-06 18:00:03', '2025-02-06 18:00:03'),
(127, 103, 37, 1, '2025-02-06 18:00:07', '2025-02-06 18:00:47'),
(128, 103, 32, 1, '2025-02-06 18:00:07', '2025-02-06 18:00:07'),
(129, 104, 37, 1, '2025-02-06 18:00:11', '2025-02-06 18:00:47'),
(130, 104, 32, 1, '2025-02-06 18:00:11', '2025-02-06 18:00:11'),
(131, 105, 32, 1, '2025-02-06 18:06:06', '2025-02-06 18:06:09'),
(132, 105, 37, 1, '2025-02-06 18:06:06', '2025-02-06 18:06:06'),
(133, 106, 32, 1, '2025-02-06 18:06:16', '2025-02-06 18:13:02'),
(134, 106, 37, 1, '2025-02-06 18:06:16', '2025-02-06 18:06:16'),
(135, 107, 32, 1, '2025-02-06 18:06:21', '2025-02-06 18:13:02'),
(136, 107, 37, 1, '2025-02-06 18:06:21', '2025-02-06 18:06:21'),
(137, 108, 32, 1, '2025-02-06 18:06:25', '2025-02-06 18:13:02'),
(138, 108, 37, 1, '2025-02-06 18:06:25', '2025-02-06 18:06:25'),
(139, 109, 32, 1, '2025-02-06 18:06:26', '2025-02-06 18:13:02'),
(140, 109, 37, 1, '2025-02-06 18:06:26', '2025-02-06 18:06:26'),
(141, 110, 32, 1, '2025-02-06 18:08:08', '2025-02-06 18:13:02'),
(142, 110, 37, 1, '2025-02-06 18:08:08', '2025-02-06 18:08:08'),
(143, 111, 32, 1, '2025-02-06 18:12:48', '2025-02-06 18:13:02'),
(144, 111, 37, 1, '2025-02-06 18:12:48', '2025-02-06 18:12:48'),
(145, 112, 37, 1, '2025-02-06 18:21:25', '2025-02-06 18:21:47'),
(146, 112, 32, 1, '2025-02-06 18:21:25', '2025-02-06 18:21:25'),
(147, 113, 37, 1, '2025-02-06 18:23:07', '2025-02-06 18:23:43'),
(148, 113, 32, 1, '2025-02-06 18:23:07', '2025-02-06 18:23:07'),
(149, 114, 37, 1, '2025-02-06 18:23:18', '2025-02-06 18:23:43'),
(150, 114, 32, 1, '2025-02-06 18:23:18', '2025-02-06 18:23:18'),
(151, 115, 32, 1, '2025-02-06 18:23:45', '2025-02-06 18:23:45'),
(152, 115, 37, 1, '2025-02-06 18:23:45', '2025-02-06 18:23:45'),
(153, 116, 32, 1, '2025-02-06 18:23:50', '2025-02-06 18:24:53'),
(154, 116, 37, 1, '2025-02-06 18:23:50', '2025-02-06 18:23:50'),
(155, 117, 32, 1, '2025-02-06 18:23:52', '2025-02-06 18:24:53'),
(156, 117, 37, 1, '2025-02-06 18:23:52', '2025-02-06 18:23:52'),
(157, 118, 32, 1, '2025-02-06 18:23:54', '2025-02-06 18:24:53'),
(158, 118, 37, 1, '2025-02-06 18:23:54', '2025-02-06 18:23:54'),
(159, 119, 37, 1, '2025-02-06 18:25:08', '2025-02-06 18:25:37'),
(160, 119, 32, 1, '2025-02-06 18:25:08', '2025-02-06 18:25:08'),
(161, 120, 37, 1, '2025-02-06 18:25:10', '2025-02-06 18:25:37'),
(162, 120, 32, 1, '2025-02-06 18:25:10', '2025-02-06 18:25:10'),
(163, 121, 37, 1, '2025-02-06 18:25:11', '2025-02-06 18:25:37'),
(164, 121, 32, 1, '2025-02-06 18:25:11', '2025-02-06 18:25:11'),
(165, 122, 37, 1, '2025-02-06 18:25:26', '2025-02-06 18:25:37'),
(166, 122, 32, 1, '2025-02-06 18:25:26', '2025-02-06 18:25:26'),
(167, 123, 32, 1, '2025-02-06 18:25:38', '2025-02-06 18:25:52'),
(168, 123, 37, 1, '2025-02-06 18:25:38', '2025-02-06 18:25:38'),
(169, 124, 32, 1, '2025-02-06 18:25:47', '2025-02-06 18:25:52'),
(170, 124, 37, 1, '2025-02-06 18:25:47', '2025-02-06 18:25:47'),
(171, 125, 32, 1, '2025-02-06 18:26:07', '2025-02-06 18:26:20'),
(172, 125, 37, 1, '2025-02-06 18:26:07', '2025-02-06 18:26:07'),
(173, 126, 37, 1, '2025-02-06 18:26:25', '2025-02-06 18:28:26'),
(174, 126, 32, 1, '2025-02-06 18:26:25', '2025-02-06 18:26:25'),
(175, 127, 37, 1, '2025-02-06 18:26:34', '2025-02-06 18:28:26'),
(176, 127, 32, 1, '2025-02-06 18:26:34', '2025-02-06 18:26:34'),
(177, 128, 37, 1, '2025-02-06 18:27:00', '2025-02-06 18:28:26'),
(178, 128, 32, 1, '2025-02-06 18:27:00', '2025-02-06 18:27:00'),
(179, 129, 34, 0, '2025-02-06 18:28:05', '2025-02-06 18:28:05'),
(180, 129, 32, 1, '2025-02-06 18:28:05', '2025-02-06 18:28:05'),
(181, 130, 32, 1, '2025-02-06 18:28:11', '2025-02-06 18:28:11'),
(182, 131, 32, 0, '2025-02-06 18:29:51', '2025-02-06 18:29:51'),
(183, 131, 35, 1, '2025-02-06 18:29:51', '2025-02-06 18:29:51'),
(184, 132, 32, 0, '2025-02-06 18:30:04', '2025-02-06 18:30:04'),
(185, 132, 35, 1, '2025-02-06 18:30:04', '2025-02-06 18:30:04'),
(186, 133, 35, 0, '2025-02-06 18:30:12', '2025-02-06 18:30:12'),
(187, 133, 32, 1, '2025-02-06 18:30:12', '2025-02-06 18:30:12'),
(188, 134, 32, 1, '2025-02-06 18:31:05', '2025-02-06 18:32:12'),
(189, 134, 37, 1, '2025-02-06 18:31:05', '2025-02-06 18:31:05'),
(190, 135, 32, 0, '2025-02-06 18:32:01', '2025-02-06 18:32:01'),
(191, 135, 35, 1, '2025-02-06 18:32:01', '2025-02-06 18:32:01'),
(192, 136, 38, 1, '2025-02-06 18:34:29', '2025-02-06 18:34:32'),
(193, 136, 32, 1, '2025-02-06 18:34:29', '2025-02-06 18:34:29'),
(194, 137, 38, 1, '2025-02-06 18:37:23', '2025-02-06 18:37:28'),
(195, 137, 32, 1, '2025-02-06 18:37:23', '2025-02-06 18:37:23'),
(196, 138, 37, 1, '2025-02-06 18:37:36', '2025-02-06 18:37:58'),
(197, 138, 32, 1, '2025-02-06 18:37:36', '2025-02-06 18:37:36'),
(198, 139, 32, 1, '2025-02-06 18:37:55', '2025-02-06 18:40:45'),
(199, 139, 38, 1, '2025-02-06 18:37:55', '2025-02-06 18:37:55'),
(200, 140, 32, 1, '2025-02-06 18:38:00', '2025-02-06 18:38:36'),
(201, 140, 37, 1, '2025-02-06 18:38:00', '2025-02-06 18:38:00'),
(202, 141, 32, 1, '2025-02-06 18:38:43', '2025-02-06 18:38:46'),
(203, 141, 37, 1, '2025-02-06 18:38:43', '2025-02-06 18:38:43'),
(204, 142, 32, 1, '2025-02-06 18:40:25', '2025-02-06 18:40:45'),
(205, 142, 38, 1, '2025-02-06 18:40:25', '2025-02-06 18:40:25'),
(206, 143, 32, 1, '2025-02-06 18:40:26', '2025-02-06 18:40:45'),
(207, 143, 38, 1, '2025-02-06 18:40:26', '2025-02-06 18:40:26'),
(208, 144, 32, 1, '2025-02-06 18:40:39', '2025-02-06 18:40:45'),
(209, 144, 38, 1, '2025-02-06 18:40:39', '2025-02-06 18:40:39'),
(210, 145, 32, 1, '2025-02-06 18:41:10', '2025-02-06 18:41:10'),
(211, 145, 38, 1, '2025-02-06 18:41:10', '2025-02-06 18:41:10'),
(212, 146, 38, 1, '2025-02-06 18:41:18', '2025-02-06 18:41:19'),
(213, 146, 32, 1, '2025-02-06 18:41:18', '2025-02-06 18:41:18'),
(214, 147, 38, 1, '2025-02-06 18:41:52', '2025-02-06 18:41:53'),
(215, 147, 32, 1, '2025-02-06 18:41:52', '2025-02-06 18:41:52'),
(216, 148, 32, 1, '2025-02-06 18:43:47', '2025-02-06 18:44:05'),
(217, 148, 38, 1, '2025-02-06 18:43:47', '2025-02-06 18:43:47'),
(218, 149, 32, 1, '2025-02-06 18:43:55', '2025-02-06 18:44:05'),
(219, 149, 38, 1, '2025-02-06 18:43:55', '2025-02-06 18:43:55'),
(220, 150, 38, 1, '2025-02-06 18:44:14', '2025-02-06 18:44:14'),
(221, 150, 32, 1, '2025-02-06 18:44:14', '2025-02-06 18:44:14'),
(222, 151, 38, 1, '2025-02-06 18:44:40', '2025-02-06 18:44:44'),
(223, 151, 32, 1, '2025-02-06 18:44:40', '2025-02-06 18:44:40'),
(224, 152, 38, 1, '2025-02-06 18:44:54', '2025-02-06 18:45:18'),
(225, 152, 32, 1, '2025-02-06 18:44:54', '2025-02-06 18:44:54'),
(226, 153, 32, 1, '2025-02-06 18:45:47', '2025-02-06 18:45:54'),
(227, 153, 38, 1, '2025-02-06 18:45:47', '2025-02-06 18:45:47'),
(228, 154, 32, 1, '2025-02-06 18:47:51', '2025-02-06 18:47:54'),
(229, 154, 38, 1, '2025-02-06 18:47:51', '2025-02-06 18:47:51'),
(230, 155, 32, 1, '2025-02-06 18:48:12', '2025-02-06 18:48:17'),
(231, 155, 38, 1, '2025-02-06 18:48:12', '2025-02-06 18:48:12'),
(232, 156, 32, 1, '2025-02-06 18:48:32', '2025-02-06 18:49:23'),
(233, 156, 38, 1, '2025-02-06 18:48:32', '2025-02-06 18:48:32'),
(234, 157, 32, 1, '2025-02-06 18:49:00', '2025-02-06 18:49:23'),
(235, 157, 38, 1, '2025-02-06 18:49:00', '2025-02-06 18:49:00'),
(236, 158, 38, 1, '2025-02-06 18:51:52', '2025-02-06 18:52:08'),
(237, 158, 32, 1, '2025-02-06 18:51:52', '2025-02-06 18:51:52'),
(238, 159, 32, 1, '2025-02-06 18:52:17', '2025-02-06 18:52:45'),
(239, 159, 38, 1, '2025-02-06 18:52:17', '2025-02-06 18:52:17'),
(240, 160, 32, 1, '2025-02-06 18:52:24', '2025-02-06 18:52:45'),
(241, 160, 38, 1, '2025-02-06 18:52:24', '2025-02-06 18:52:24'),
(242, 161, 32, 1, '2025-02-06 18:52:34', '2025-02-06 18:52:45'),
(243, 161, 38, 1, '2025-02-06 18:52:34', '2025-02-06 18:52:34'),
(244, 162, 38, 1, '2025-02-06 18:52:47', '2025-02-06 18:52:48'),
(245, 162, 32, 1, '2025-02-06 18:52:47', '2025-02-06 18:52:47'),
(246, 163, 38, 1, '2025-02-06 18:52:58', '2025-02-06 18:53:27'),
(247, 163, 32, 1, '2025-02-06 18:52:58', '2025-02-06 18:52:58'),
(248, 164, 38, 1, '2025-02-06 18:53:11', '2025-02-06 18:53:27'),
(249, 164, 32, 1, '2025-02-06 18:53:11', '2025-02-06 18:53:11'),
(250, 165, 32, 1, '2025-02-06 18:53:35', '2025-02-06 18:55:40'),
(251, 165, 38, 1, '2025-02-06 18:53:35', '2025-02-06 18:53:35'),
(252, 166, 32, 1, '2025-02-06 18:54:15', '2025-02-06 18:55:40'),
(253, 166, 38, 1, '2025-02-06 18:54:15', '2025-02-06 18:54:15'),
(254, 167, 32, 1, '2025-02-06 18:54:16', '2025-02-06 18:55:40'),
(255, 167, 38, 1, '2025-02-06 18:54:16', '2025-02-06 18:54:16'),
(256, 168, 32, 1, '2025-02-06 18:54:42', '2025-02-06 18:55:40'),
(257, 168, 38, 1, '2025-02-06 18:54:42', '2025-02-06 18:54:42'),
(258, 169, 38, 1, '2025-02-06 18:55:42', '2025-02-06 18:58:35'),
(259, 169, 32, 1, '2025-02-06 18:55:42', '2025-02-06 18:55:42'),
(260, 170, 38, 1, '2025-02-06 18:55:42', '2025-02-06 18:58:35'),
(261, 170, 32, 1, '2025-02-06 18:55:42', '2025-02-06 18:55:42'),
(262, 171, 38, 1, '2025-02-06 18:55:43', '2025-02-06 18:58:35'),
(263, 171, 32, 1, '2025-02-06 18:55:43', '2025-02-06 18:55:43'),
(264, 172, 38, 1, '2025-02-06 18:55:43', '2025-02-06 18:58:35'),
(265, 172, 32, 1, '2025-02-06 18:55:43', '2025-02-06 18:55:43'),
(266, 173, 38, 1, '2025-02-06 18:57:29', '2025-02-06 18:58:35'),
(267, 173, 32, 1, '2025-02-06 18:57:29', '2025-02-06 18:57:29'),
(268, 174, 37, 1, '2025-02-06 18:58:27', '2025-02-06 18:58:47'),
(269, 174, 32, 1, '2025-02-06 18:58:27', '2025-02-06 18:58:27'),
(270, 175, 38, 1, '2025-02-06 18:58:29', '2025-02-06 18:58:35'),
(271, 175, 32, 1, '2025-02-06 18:58:29', '2025-02-06 18:58:29'),
(272, 176, 32, 1, '2025-02-06 18:58:37', '2025-02-06 18:58:37'),
(273, 176, 38, 1, '2025-02-06 18:58:37', '2025-02-06 18:58:37'),
(274, 177, 32, 1, '2025-02-06 18:59:08', '2025-02-06 18:59:19'),
(275, 177, 38, 1, '2025-02-06 18:59:08', '2025-02-06 18:59:08'),
(276, 178, 32, 1, '2025-02-06 18:59:11', '2025-02-06 18:59:19'),
(277, 178, 38, 1, '2025-02-06 18:59:11', '2025-02-06 18:59:11'),
(278, 179, 32, 1, '2025-02-06 18:59:15', '2025-02-06 18:59:19'),
(279, 179, 38, 1, '2025-02-06 18:59:15', '2025-02-06 18:59:15'),
(280, 180, 38, 1, '2025-02-06 18:59:24', '2025-02-06 18:59:28'),
(281, 180, 32, 1, '2025-02-06 18:59:24', '2025-02-06 18:59:24'),
(282, 181, 38, 1, '2025-02-06 18:59:25', '2025-02-06 18:59:28'),
(283, 181, 32, 1, '2025-02-06 18:59:25', '2025-02-06 18:59:25'),
(284, 182, 38, 1, '2025-02-06 18:59:26', '2025-02-06 18:59:28'),
(285, 182, 32, 1, '2025-02-06 18:59:26', '2025-02-06 18:59:26'),
(286, 183, 38, 1, '2025-02-06 19:02:07', '2025-02-06 19:02:11'),
(287, 183, 32, 1, '2025-02-06 19:02:07', '2025-02-06 19:02:07'),
(288, 184, 38, 1, '2025-02-06 19:02:09', '2025-02-06 19:02:11'),
(289, 184, 32, 1, '2025-02-06 19:02:09', '2025-02-06 19:02:09'),
(290, 185, 38, 1, '2025-02-06 19:02:17', '2025-02-06 19:03:09'),
(291, 185, 32, 1, '2025-02-06 19:02:17', '2025-02-06 19:02:17'),
(292, 186, 38, 1, '2025-02-06 19:02:18', '2025-02-06 19:03:09'),
(293, 186, 32, 1, '2025-02-06 19:02:18', '2025-02-06 19:02:18'),
(294, 187, 38, 1, '2025-02-06 19:02:27', '2025-02-06 19:03:09'),
(295, 187, 32, 1, '2025-02-06 19:02:27', '2025-02-06 19:02:27'),
(296, 188, 38, 1, '2025-02-06 19:02:29', '2025-02-06 19:03:09'),
(297, 188, 32, 1, '2025-02-06 19:02:29', '2025-02-06 19:02:29'),
(298, 189, 38, 1, '2025-02-06 19:03:05', '2025-02-06 19:03:09'),
(299, 189, 32, 1, '2025-02-06 19:03:05', '2025-02-06 19:03:05'),
(300, 190, 32, 1, '2025-02-06 19:03:14', '2025-02-06 19:03:14'),
(301, 190, 38, 1, '2025-02-06 19:03:14', '2025-02-06 19:03:14'),
(302, 191, 32, 1, '2025-02-06 19:03:18', '2025-02-06 19:03:49'),
(303, 191, 38, 1, '2025-02-06 19:03:18', '2025-02-06 19:03:18'),
(304, 192, 32, 1, '2025-02-06 19:03:23', '2025-02-06 19:03:49'),
(305, 192, 38, 1, '2025-02-06 19:03:23', '2025-02-06 19:03:23'),
(306, 193, 32, 1, '2025-02-06 19:03:31', '2025-02-06 19:03:49'),
(307, 193, 38, 1, '2025-02-06 19:03:31', '2025-02-06 19:03:31'),
(308, 194, 32, 1, '2025-02-06 19:03:33', '2025-02-06 19:03:49'),
(309, 194, 38, 1, '2025-02-06 19:03:33', '2025-02-06 19:03:33'),
(310, 195, 32, 1, '2025-02-06 19:03:43', '2025-02-06 19:03:49'),
(311, 195, 38, 1, '2025-02-06 19:03:43', '2025-02-06 19:03:43'),
(312, 196, 32, 1, '2025-02-06 19:03:47', '2025-02-06 19:03:49'),
(313, 196, 38, 1, '2025-02-06 19:03:47', '2025-02-06 19:03:47'),
(314, 197, 38, 1, '2025-02-06 19:03:53', '2025-02-06 19:03:53'),
(315, 197, 32, 1, '2025-02-06 19:03:53', '2025-02-06 19:03:53'),
(316, 198, 38, 1, '2025-02-06 19:04:00', '2025-02-06 19:04:04'),
(317, 198, 32, 1, '2025-02-06 19:04:00', '2025-02-06 19:04:00'),
(318, 199, 38, 1, '2025-02-06 19:04:01', '2025-02-06 19:04:04'),
(319, 199, 32, 1, '2025-02-06 19:04:01', '2025-02-06 19:04:01'),
(320, 200, 32, 1, '2025-02-06 19:04:06', '2025-02-06 19:04:06'),
(321, 200, 38, 1, '2025-02-06 19:04:06', '2025-02-06 19:04:06'),
(322, 201, 32, 1, '2025-02-06 19:04:14', '2025-02-06 19:04:20'),
(323, 201, 38, 1, '2025-02-06 19:04:14', '2025-02-06 19:04:14'),
(324, 202, 34, 0, '2025-02-06 19:05:54', '2025-02-06 19:05:54'),
(325, 202, 32, 1, '2025-02-06 19:05:54', '2025-02-06 19:05:54'),
(326, 203, 34, 0, '2025-02-06 19:05:56', '2025-02-06 19:05:56'),
(327, 203, 32, 1, '2025-02-06 19:05:56', '2025-02-06 19:05:56'),
(328, 204, 38, 1, '2025-02-06 19:06:07', '2025-02-06 19:06:08'),
(329, 204, 32, 1, '2025-02-06 19:06:07', '2025-02-06 19:06:07'),
(330, 205, 38, 1, '2025-02-06 19:06:20', '2025-02-06 19:06:27'),
(331, 205, 32, 1, '2025-02-06 19:06:20', '2025-02-06 19:06:20'),
(332, 206, 32, 1, '2025-02-06 19:06:37', '2025-02-06 19:06:37'),
(333, 206, 38, 1, '2025-02-06 19:06:37', '2025-02-06 19:06:37'),
(334, 207, 38, 1, '2025-02-06 19:08:46', '2025-02-06 19:08:46'),
(335, 207, 32, 1, '2025-02-06 19:08:46', '2025-02-06 19:08:46'),
(336, 208, 38, 1, '2025-02-06 19:08:58', '2025-02-06 19:08:58'),
(337, 208, 32, 1, '2025-02-06 19:08:58', '2025-02-06 19:08:58'),
(338, 209, 32, 1, '2025-02-06 19:09:04', '2025-02-06 19:09:05'),
(339, 209, 38, 1, '2025-02-06 19:09:04', '2025-02-06 19:09:04'),
(340, 210, 38, 1, '2025-02-06 19:10:07', '2025-02-06 19:10:07'),
(341, 210, 32, 1, '2025-02-06 19:10:07', '2025-02-06 19:10:07'),
(342, 211, 38, 1, '2025-02-06 19:10:16', '2025-02-06 19:10:54'),
(343, 211, 32, 1, '2025-02-06 19:10:16', '2025-02-06 19:10:16'),
(344, 212, 38, 1, '2025-02-06 19:10:17', '2025-02-06 19:10:54'),
(345, 212, 32, 1, '2025-02-06 19:10:17', '2025-02-06 19:10:17'),
(346, 213, 38, 1, '2025-02-06 19:10:17', '2025-02-06 19:10:54'),
(347, 213, 32, 1, '2025-02-06 19:10:17', '2025-02-06 19:10:17'),
(348, 214, 38, 1, '2025-02-06 19:10:27', '2025-02-06 19:10:54'),
(349, 214, 32, 1, '2025-02-06 19:10:27', '2025-02-06 19:10:27'),
(350, 215, 38, 1, '2025-02-06 19:10:45', '2025-02-06 19:10:54'),
(351, 215, 32, 1, '2025-02-06 19:10:45', '2025-02-06 19:10:45'),
(352, 216, 32, 1, '2025-02-06 19:11:06', '2025-02-06 19:11:06'),
(353, 216, 38, 1, '2025-02-06 19:11:06', '2025-02-06 19:11:06'),
(354, 217, 38, 1, '2025-02-06 19:11:10', '2025-02-06 19:11:10'),
(355, 217, 32, 1, '2025-02-06 19:11:10', '2025-02-06 19:11:10'),
(356, 218, 32, 1, '2025-02-06 19:11:17', '2025-02-06 19:11:25'),
(357, 218, 38, 1, '2025-02-06 19:11:17', '2025-02-06 19:11:17'),
(358, 219, 32, 1, '2025-02-06 19:11:22', '2025-02-06 19:11:25'),
(359, 219, 38, 1, '2025-02-06 19:11:22', '2025-02-06 19:11:22'),
(360, 220, 38, 1, '2025-02-06 19:11:32', '2025-02-06 19:13:52'),
(361, 220, 32, 1, '2025-02-06 19:11:32', '2025-02-06 19:11:32'),
(362, 221, 38, 1, '2025-02-06 19:11:33', '2025-02-06 19:13:52'),
(363, 221, 32, 1, '2025-02-06 19:11:33', '2025-02-06 19:11:33'),
(364, 222, 38, 1, '2025-02-06 19:12:07', '2025-02-06 19:13:52'),
(365, 222, 32, 1, '2025-02-06 19:12:07', '2025-02-06 19:12:07'),
(366, 223, 38, 1, '2025-02-06 19:12:13', '2025-02-06 19:13:52'),
(367, 223, 32, 1, '2025-02-06 19:12:13', '2025-02-06 19:12:13'),
(368, 224, 38, 1, '2025-02-06 19:13:46', '2025-02-06 19:13:52'),
(369, 224, 32, 1, '2025-02-06 19:13:46', '2025-02-06 19:13:46'),
(370, 225, 32, 1, '2025-02-06 19:13:54', '2025-02-06 19:13:55'),
(371, 225, 38, 1, '2025-02-06 19:13:54', '2025-02-06 19:13:54'),
(372, 226, 32, 1, '2025-02-06 19:13:57', '2025-02-06 19:14:13'),
(373, 226, 38, 1, '2025-02-06 19:13:57', '2025-02-06 19:13:57'),
(374, 227, 32, 1, '2025-02-06 19:14:04', '2025-02-06 19:14:13'),
(375, 227, 38, 1, '2025-02-06 19:14:04', '2025-02-06 19:14:04'),
(376, 228, 32, 1, '2025-02-06 19:14:09', '2025-02-06 19:14:13'),
(377, 228, 38, 1, '2025-02-06 19:14:09', '2025-02-06 19:14:09'),
(378, 229, 38, 1, '2025-02-06 19:14:16', '2025-02-06 19:14:16'),
(379, 229, 32, 1, '2025-02-06 19:14:16', '2025-02-06 19:14:16'),
(380, 230, 38, 1, '2025-02-06 19:14:17', '2025-02-06 19:14:17'),
(381, 230, 32, 1, '2025-02-06 19:14:17', '2025-02-06 19:14:17'),
(382, 231, 38, 1, '2025-02-06 19:14:22', '2025-02-06 19:14:35'),
(383, 231, 32, 1, '2025-02-06 19:14:22', '2025-02-06 19:14:22'),
(384, 232, 32, 1, '2025-02-06 19:14:37', '2025-02-06 19:18:49'),
(385, 232, 38, 1, '2025-02-06 19:14:37', '2025-02-06 19:14:37'),
(386, 233, 32, 1, '2025-02-06 19:14:44', '2025-02-06 19:18:49'),
(387, 233, 38, 1, '2025-02-06 19:14:44', '2025-02-06 19:14:44'),
(388, 234, 32, 1, '2025-02-06 19:16:21', '2025-02-06 19:18:49'),
(389, 234, 38, 1, '2025-02-06 19:16:21', '2025-02-06 19:16:21'),
(390, 235, 32, 1, '2025-02-06 19:16:26', '2025-02-06 19:18:49'),
(391, 235, 38, 1, '2025-02-06 19:16:26', '2025-02-06 19:16:26'),
(392, 236, 38, 1, '2025-02-06 19:18:57', '2025-02-06 19:19:42'),
(393, 236, 32, 1, '2025-02-06 19:18:57', '2025-02-06 19:18:57'),
(394, 237, 38, 1, '2025-02-06 19:19:05', '2025-02-06 19:19:43'),
(395, 237, 32, 1, '2025-02-06 19:19:05', '2025-02-06 19:19:05'),
(396, 238, 38, 1, '2025-02-06 19:19:23', '2025-02-06 19:19:43'),
(397, 238, 32, 1, '2025-02-06 19:19:23', '2025-02-06 19:19:23'),
(398, 239, 38, 1, '2025-02-06 19:19:24', '2025-02-06 19:19:43'),
(399, 239, 32, 1, '2025-02-06 19:19:24', '2025-02-06 19:19:24'),
(400, 240, 38, 1, '2025-02-06 19:19:31', '2025-02-06 19:19:43'),
(401, 240, 32, 1, '2025-02-06 19:19:31', '2025-02-06 19:19:31'),
(402, 241, 32, 1, '2025-02-06 19:19:47', '2025-02-06 19:21:27'),
(403, 241, 38, 1, '2025-02-06 19:19:47', '2025-02-06 19:19:47'),
(404, 242, 32, 1, '2025-02-06 19:19:48', '2025-02-06 19:21:27'),
(405, 242, 38, 1, '2025-02-06 19:19:48', '2025-02-06 19:19:48'),
(406, 243, 32, 1, '2025-02-06 19:19:49', '2025-02-06 19:21:27'),
(407, 243, 38, 1, '2025-02-06 19:19:49', '2025-02-06 19:19:49'),
(408, 244, 32, 1, '2025-02-06 19:20:32', '2025-02-06 19:21:27'),
(409, 244, 38, 1, '2025-02-06 19:20:32', '2025-02-06 19:20:32'),
(410, 245, 32, 1, '2025-02-06 19:20:43', '2025-02-06 19:21:27'),
(411, 245, 38, 1, '2025-02-06 19:20:43', '2025-02-06 19:20:43'),
(412, 246, 32, 1, '2025-02-06 19:21:15', '2025-02-06 19:21:27'),
(413, 246, 38, 1, '2025-02-06 19:21:15', '2025-02-06 19:21:15'),
(414, 247, 32, 1, '2025-02-06 19:21:18', '2025-02-06 19:21:27'),
(415, 247, 38, 1, '2025-02-06 19:21:18', '2025-02-06 19:21:18'),
(416, 248, 32, 1, '2025-02-06 19:21:22', '2025-02-06 19:21:27'),
(417, 248, 38, 1, '2025-02-06 19:21:22', '2025-02-06 19:21:22'),
(418, 249, 38, 1, '2025-02-06 19:21:29', '2025-02-06 19:21:37'),
(419, 249, 32, 1, '2025-02-06 19:21:29', '2025-02-06 19:21:29'),
(420, 250, 38, 1, '2025-02-06 19:21:35', '2025-02-06 19:21:37'),
(421, 250, 32, 1, '2025-02-06 19:21:35', '2025-02-06 19:21:35'),
(422, 251, 32, 1, '2025-02-06 19:21:38', '2025-02-06 19:21:38'),
(423, 251, 38, 1, '2025-02-06 19:21:38', '2025-02-06 19:21:38'),
(424, 252, 32, 1, '2025-02-06 19:21:45', '2025-02-06 19:23:22'),
(425, 252, 38, 1, '2025-02-06 19:21:45', '2025-02-06 19:21:45'),
(426, 253, 32, 1, '2025-02-06 19:23:19', '2025-02-06 19:23:22'),
(427, 253, 38, 1, '2025-02-06 19:23:19', '2025-02-06 19:23:19'),
(428, 254, 38, 1, '2025-02-06 19:23:24', '2025-02-06 19:23:25'),
(429, 254, 32, 1, '2025-02-06 19:23:24', '2025-02-06 19:23:24'),
(430, 255, 38, 1, '2025-02-06 19:23:33', '2025-02-06 19:23:33'),
(431, 255, 32, 1, '2025-02-06 19:23:33', '2025-02-06 19:23:33'),
(432, 256, 38, 1, '2025-02-06 19:25:56', '2025-02-06 19:25:58'),
(433, 256, 32, 1, '2025-02-06 19:25:56', '2025-02-06 19:25:56'),
(434, 257, 32, 1, '2025-02-06 19:26:09', '2025-02-06 19:26:19'),
(435, 257, 38, 1, '2025-02-06 19:26:09', '2025-02-06 19:26:09'),
(436, 258, 32, 1, '2025-02-06 19:26:18', '2025-02-06 19:26:19'),
(437, 258, 38, 1, '2025-02-06 19:26:18', '2025-02-06 19:26:18'),
(438, 259, 32, 1, '2025-02-06 19:27:08', '2025-02-06 19:28:21'),
(439, 259, 38, 1, '2025-02-06 19:27:08', '2025-02-06 19:27:08'),
(440, 260, 32, 1, '2025-02-06 19:28:02', '2025-02-06 19:28:21'),
(441, 260, 38, 1, '2025-02-06 19:28:02', '2025-02-06 19:28:02'),
(442, 261, 38, 1, '2025-02-06 19:28:32', '2025-02-06 19:28:32'),
(443, 261, 32, 1, '2025-02-06 19:28:32', '2025-02-06 19:28:32'),
(444, 262, 32, 1, '2025-02-06 19:28:37', '2025-02-06 19:28:38'),
(445, 262, 38, 1, '2025-02-06 19:28:37', '2025-02-06 19:28:37'),
(446, 263, 32, 1, '2025-02-06 19:28:42', '2025-02-06 19:30:43'),
(447, 263, 38, 1, '2025-02-06 19:28:42', '2025-02-06 19:28:42'),
(448, 264, 32, 1, '2025-02-06 19:28:46', '2025-02-06 19:30:43'),
(449, 264, 38, 1, '2025-02-06 19:28:46', '2025-02-06 19:28:46'),
(450, 265, 32, 1, '2025-02-06 19:28:48', '2025-02-06 19:30:43'),
(451, 265, 38, 1, '2025-02-06 19:28:48', '2025-02-06 19:28:48'),
(452, 266, 32, 1, '2025-02-06 19:28:57', '2025-02-06 19:30:43'),
(453, 266, 38, 1, '2025-02-06 19:28:57', '2025-02-06 19:28:57'),
(454, 267, 38, 1, '2025-02-06 19:31:06', '2025-02-06 19:31:07'),
(455, 267, 32, 1, '2025-02-06 19:31:06', '2025-02-06 19:31:06'),
(456, 268, 38, 1, '2025-02-06 19:33:12', '2025-02-06 19:33:17'),
(457, 268, 32, 1, '2025-02-06 19:33:12', '2025-02-06 19:33:12'),
(458, 269, 38, 1, '2025-02-06 19:33:15', '2025-02-06 19:33:17'),
(459, 269, 32, 1, '2025-02-06 19:33:15', '2025-02-06 19:33:15'),
(460, 270, 38, 1, '2025-02-06 19:33:15', '2025-02-06 19:33:17'),
(461, 270, 32, 1, '2025-02-06 19:33:15', '2025-02-06 19:33:15'),
(462, 271, 38, 1, '2025-02-06 19:33:16', '2025-02-06 19:33:17'),
(463, 271, 32, 1, '2025-02-06 19:33:16', '2025-02-06 19:33:16'),
(464, 272, 32, 1, '2025-02-06 19:33:22', '2025-02-06 19:33:22'),
(465, 272, 38, 1, '2025-02-06 19:33:22', '2025-02-06 19:33:22'),
(466, 273, 32, 1, '2025-02-06 19:35:50', '2025-02-06 19:38:09'),
(467, 273, 38, 1, '2025-02-06 19:35:50', '2025-02-06 19:35:50'),
(468, 274, 32, 1, '2025-02-06 19:35:58', '2025-02-06 19:38:09'),
(469, 274, 38, 1, '2025-02-06 19:35:58', '2025-02-06 19:35:58'),
(470, 275, 32, 1, '2025-02-06 19:36:02', '2025-02-06 19:38:09'),
(471, 275, 38, 1, '2025-02-06 19:36:02', '2025-02-06 19:36:02'),
(472, 276, 32, 1, '2025-02-06 19:38:18', '2025-02-06 19:38:22'),
(473, 276, 38, 1, '2025-02-06 19:38:18', '2025-02-06 19:38:18'),
(474, 277, 38, 1, '2025-02-06 19:38:24', '2025-02-06 19:38:24'),
(475, 277, 32, 1, '2025-02-06 19:38:24', '2025-02-06 19:38:24'),
(476, 278, 35, 0, '2025-02-06 19:38:27', '2025-02-06 19:38:27'),
(477, 278, 32, 1, '2025-02-06 19:38:27', '2025-02-06 19:38:27'),
(478, 279, 32, 1, '2025-02-06 19:38:30', '2025-02-06 19:38:30'),
(479, 280, 34, 0, '2025-02-06 19:38:33', '2025-02-06 19:38:33'),
(480, 280, 32, 1, '2025-02-06 19:38:33', '2025-02-06 19:38:33'),
(481, 281, 38, 1, '2025-02-06 19:38:38', '2025-02-06 19:38:39'),
(482, 281, 32, 1, '2025-02-06 19:38:38', '2025-02-06 19:38:38'),
(483, 282, 32, 1, '2025-02-06 19:38:40', '2025-02-06 19:38:40'),
(484, 282, 38, 1, '2025-02-06 19:38:40', '2025-02-06 19:38:40'),
(485, 283, 38, 1, '2025-02-06 19:38:45', '2025-02-06 19:44:13'),
(486, 283, 32, 1, '2025-02-06 19:38:45', '2025-02-06 19:38:45'),
(487, 284, 38, 1, '2025-02-06 19:38:47', '2025-02-06 19:44:13'),
(488, 284, 32, 1, '2025-02-06 19:38:47', '2025-02-06 19:38:47'),
(489, 285, 38, 1, '2025-02-06 19:41:11', '2025-02-06 19:44:13'),
(490, 285, 32, 1, '2025-02-06 19:41:11', '2025-02-06 19:41:11'),
(491, 286, 38, 1, '2025-02-06 19:41:17', '2025-02-06 19:44:13'),
(492, 286, 32, 1, '2025-02-06 19:41:17', '2025-02-06 19:41:17'),
(493, 287, 38, 1, '2025-02-06 19:43:22', '2025-02-06 19:44:13'),
(494, 287, 32, 1, '2025-02-06 19:43:22', '2025-02-06 19:43:22'),
(495, 288, 38, 1, '2025-02-06 19:44:10', '2025-02-06 19:44:13'),
(496, 288, 32, 1, '2025-02-06 19:44:10', '2025-02-06 19:44:10'),
(497, 289, 32, 1, '2025-02-06 19:45:13', '2025-02-06 19:45:18'),
(498, 289, 38, 1, '2025-02-06 19:45:13', '2025-02-06 19:45:13'),
(499, 290, 32, 1, '2025-02-06 19:45:13', '2025-02-06 19:45:18'),
(500, 290, 38, 1, '2025-02-06 19:45:13', '2025-02-06 19:45:13'),
(501, 291, 38, 1, '2025-02-06 19:46:34', '2025-02-06 19:46:39'),
(502, 291, 32, 1, '2025-02-06 19:46:34', '2025-02-06 19:46:34'),
(503, 292, 38, 1, '2025-02-06 19:46:36', '2025-02-06 19:46:39'),
(504, 292, 32, 1, '2025-02-06 19:46:36', '2025-02-06 19:46:36'),
(505, 293, 32, 1, '2025-02-06 19:46:42', '2025-02-06 19:46:58'),
(506, 293, 38, 1, '2025-02-06 19:46:42', '2025-02-06 19:46:42'),
(507, 294, 32, 1, '2025-02-06 19:46:43', '2025-02-06 19:46:58'),
(508, 294, 38, 1, '2025-02-06 19:46:43', '2025-02-06 19:46:43'),
(509, 295, 32, 1, '2025-02-06 19:46:46', '2025-02-06 19:46:58'),
(510, 295, 38, 1, '2025-02-06 19:46:46', '2025-02-06 19:46:46'),
(511, 296, 38, 1, '2025-02-06 19:47:15', '2025-02-06 19:47:15'),
(512, 296, 32, 1, '2025-02-06 19:47:15', '2025-02-06 19:47:15'),
(513, 297, 38, 1, '2025-02-06 19:47:27', '2025-02-06 19:47:27'),
(514, 297, 32, 1, '2025-02-06 19:47:27', '2025-02-06 19:47:27'),
(515, 298, 38, 1, '2025-02-06 19:49:35', '2025-02-06 19:49:35'),
(516, 298, 32, 1, '2025-02-06 19:49:35', '2025-02-06 19:49:35'),
(517, 299, 38, 1, '2025-02-06 19:49:55', '2025-02-06 19:50:02'),
(518, 299, 32, 1, '2025-02-06 19:49:55', '2025-02-06 19:49:55'),
(519, 300, 32, 1, '2025-02-06 19:50:04', '2025-02-06 19:50:04'),
(520, 300, 38, 1, '2025-02-06 19:50:04', '2025-02-06 19:50:04'),
(521, 301, 32, 1, '2025-02-06 19:50:28', '2025-02-06 19:53:10'),
(522, 301, 38, 1, '2025-02-06 19:50:28', '2025-02-06 19:50:28'),
(523, 302, 32, 1, '2025-02-06 19:50:28', '2025-02-06 19:53:10'),
(524, 302, 38, 1, '2025-02-06 19:50:28', '2025-02-06 19:50:28'),
(525, 303, 32, 1, '2025-02-06 19:50:29', '2025-02-06 19:53:10'),
(526, 303, 38, 1, '2025-02-06 19:50:29', '2025-02-06 19:50:29'),
(527, 304, 38, 1, '2025-02-06 19:55:12', '2025-02-06 19:55:16'),
(528, 304, 32, 1, '2025-02-06 19:55:12', '2025-02-06 19:55:12'),
(529, 305, 38, 1, '2025-02-06 19:55:13', '2025-02-06 19:55:16'),
(530, 305, 32, 1, '2025-02-06 19:55:13', '2025-02-06 19:55:13'),
(531, 306, 38, 1, '2025-02-06 19:59:07', '2025-02-06 19:59:17'),
(532, 306, 32, 1, '2025-02-06 19:59:07', '2025-02-06 19:59:07'),
(533, 307, 38, 1, '2025-02-06 19:59:13', '2025-02-06 19:59:17'),
(534, 307, 32, 1, '2025-02-06 19:59:13', '2025-02-06 19:59:13'),
(535, 308, 38, 1, '2025-02-06 19:59:14', '2025-02-06 19:59:17'),
(536, 308, 32, 1, '2025-02-06 19:59:14', '2025-02-06 19:59:14'),
(537, 309, 32, 1, '2025-02-06 19:59:28', '2025-02-06 19:59:28'),
(538, 309, 38, 1, '2025-02-06 19:59:28', '2025-02-06 19:59:28'),
(539, 310, 38, 1, '2025-02-06 19:59:32', '2025-02-06 19:59:33'),
(540, 310, 32, 1, '2025-02-06 19:59:32', '2025-02-06 19:59:32'),
(541, 311, 32, 1, '2025-02-06 19:59:39', '2025-02-06 20:14:41'),
(542, 311, 38, 1, '2025-02-06 19:59:39', '2025-02-06 19:59:39'),
(543, 312, 32, 1, '2025-02-06 20:11:56', '2025-02-06 20:14:41'),
(544, 312, 38, 1, '2025-02-06 20:11:56', '2025-02-06 20:11:56'),
(545, 313, 32, 1, '2025-02-06 20:14:28', '2025-02-06 20:14:41'),
(546, 313, 38, 1, '2025-02-06 20:14:28', '2025-02-06 20:14:28'),
(547, 314, 32, 1, '2025-02-06 20:14:30', '2025-02-06 20:14:41'),
(548, 314, 38, 1, '2025-02-06 20:14:30', '2025-02-06 20:14:30'),
(549, 315, 32, 1, '2025-02-06 20:14:33', '2025-02-06 20:14:41'),
(550, 315, 38, 1, '2025-02-06 20:14:33', '2025-02-06 20:14:33'),
(551, 316, 32, 1, '2025-02-06 20:14:40', '2025-02-06 20:14:41'),
(552, 316, 38, 1, '2025-02-06 20:14:40', '2025-02-06 20:14:40'),
(553, 317, 38, 1, '2025-02-06 20:14:43', '2025-02-06 20:14:52'),
(554, 317, 32, 1, '2025-02-06 20:14:43', '2025-02-06 20:14:43'),
(555, 318, 32, 1, '2025-02-06 20:17:02', '2025-02-06 20:17:45'),
(556, 318, 38, 1, '2025-02-06 20:17:02', '2025-02-06 20:17:02'),
(557, 319, 32, 1, '2025-02-06 20:17:08', '2025-02-06 20:17:45'),
(558, 319, 38, 1, '2025-02-06 20:17:08', '2025-02-06 20:17:08'),
(559, 320, 32, 1, '2025-02-06 20:17:13', '2025-02-06 20:17:45'),
(560, 320, 38, 1, '2025-02-06 20:17:13', '2025-02-06 20:17:13'),
(561, 321, 32, 1, '2025-02-06 20:17:43', '2025-02-06 20:17:45'),
(562, 321, 38, 1, '2025-02-06 20:17:43', '2025-02-06 20:17:43'),
(563, 322, 38, 1, '2025-02-06 20:17:49', '2025-02-06 20:17:49'),
(564, 322, 32, 1, '2025-02-06 20:17:49', '2025-02-06 20:17:49'),
(565, 323, 38, 1, '2025-02-06 20:17:52', '2025-02-06 20:17:53'),
(566, 323, 32, 1, '2025-02-06 20:17:52', '2025-02-06 20:17:52'),
(567, 324, 38, 1, '2025-02-06 20:17:56', '2025-02-06 20:17:56'),
(568, 324, 32, 1, '2025-02-06 20:17:56', '2025-02-06 20:17:56'),
(569, 325, 38, 1, '2025-02-06 20:18:01', '2025-02-06 20:18:01'),
(570, 325, 32, 1, '2025-02-06 20:18:01', '2025-02-06 20:18:01'),
(571, 326, 32, 1, '2025-02-06 20:20:17', '2025-02-06 20:20:20'),
(572, 326, 38, 1, '2025-02-06 20:20:17', '2025-02-06 20:20:17'),
(573, 327, 32, 1, '2025-02-06 20:20:18', '2025-02-06 20:20:20'),
(574, 327, 38, 1, '2025-02-06 20:20:18', '2025-02-06 20:20:18'),
(575, 328, 32, 1, '2025-02-06 20:20:29', '2025-02-06 20:20:41'),
(576, 328, 38, 1, '2025-02-06 20:20:29', '2025-02-06 20:20:29'),
(577, 329, 32, 1, '2025-02-06 20:20:39', '2025-02-06 20:20:41'),
(578, 329, 38, 1, '2025-02-06 20:20:39', '2025-02-06 20:20:39'),
(579, 330, 38, 1, '2025-02-06 20:20:45', '2025-02-06 20:20:50'),
(580, 330, 32, 1, '2025-02-06 20:20:45', '2025-02-06 20:20:45'),
(581, 331, 38, 1, '2025-02-06 20:20:58', '2025-02-06 20:20:58'),
(582, 331, 32, 1, '2025-02-06 20:20:58', '2025-02-06 20:20:58'),
(583, 332, 32, 1, '2025-02-06 20:31:06', '2025-02-06 20:38:07'),
(584, 332, 38, 1, '2025-02-06 20:31:06', '2025-02-06 20:31:06'),
(585, 333, 38, 1, '2025-02-06 20:31:50', '2025-02-06 20:38:15'),
(586, 333, 32, 1, '2025-02-06 20:31:50', '2025-02-06 20:31:50'),
(587, 334, 32, 1, '2025-02-06 20:31:55', '2025-02-06 20:38:07'),
(588, 334, 38, 1, '2025-02-06 20:31:55', '2025-02-06 20:31:55'),
(589, 335, 32, 1, '2025-02-06 20:32:06', '2025-02-06 20:38:07'),
(590, 335, 38, 1, '2025-02-06 20:32:06', '2025-02-06 20:32:06'),
(591, 336, 32, 1, '2025-02-06 20:32:08', '2025-02-06 20:38:07'),
(592, 336, 38, 1, '2025-02-06 20:32:08', '2025-02-06 20:32:08'),
(593, 337, 38, 1, '2025-02-06 20:33:29', '2025-02-06 20:38:15'),
(594, 337, 32, 1, '2025-02-06 20:33:29', '2025-02-06 20:33:29'),
(595, 338, 32, 1, '2025-02-06 20:33:38', '2025-02-06 20:38:07'),
(596, 338, 38, 1, '2025-02-06 20:33:38', '2025-02-06 20:33:38'),
(597, 339, 32, 1, '2025-02-06 20:33:48', '2025-02-06 20:38:07'),
(598, 339, 38, 1, '2025-02-06 20:33:48', '2025-02-06 20:33:48'),
(599, 340, 38, 1, '2025-02-06 20:38:10', '2025-02-06 20:38:15'),
(600, 340, 32, 1, '2025-02-06 20:38:10', '2025-02-06 20:38:10'),
(601, 341, 32, 1, '2025-02-06 20:38:17', '2025-02-06 20:38:17'),
(602, 341, 38, 1, '2025-02-06 20:38:17', '2025-02-06 20:38:17'),
(603, 342, 38, 1, '2025-02-06 20:38:27', '2025-02-06 20:38:27'),
(604, 342, 32, 1, '2025-02-06 20:38:27', '2025-02-06 20:38:27'),
(605, 343, 38, 1, '2025-02-06 20:38:35', '2025-02-06 20:38:42'),
(606, 343, 32, 1, '2025-02-06 20:38:35', '2025-02-06 20:38:35'),
(607, 344, 38, 1, '2025-02-06 20:38:37', '2025-02-06 20:38:42'),
(608, 344, 32, 1, '2025-02-06 20:38:37', '2025-02-06 20:38:37'),
(609, 345, 38, 1, '2025-02-06 20:38:41', '2025-02-06 20:38:42'),
(610, 345, 32, 1, '2025-02-06 20:38:41', '2025-02-06 20:38:41'),
(611, 346, 32, 1, '2025-02-06 20:42:25', '2025-02-06 20:42:29'),
(612, 346, 38, 1, '2025-02-06 20:42:25', '2025-02-06 20:42:25'),
(613, 347, 32, 1, '2025-02-06 20:42:37', '2025-02-06 20:42:38'),
(614, 347, 38, 1, '2025-02-06 20:42:37', '2025-02-06 20:42:37'),
(615, 348, 38, 1, '2025-02-06 20:42:43', '2025-02-06 20:42:43'),
(616, 348, 32, 1, '2025-02-06 20:42:43', '2025-02-06 20:42:43'),
(617, 349, 32, 1, '2025-02-06 20:42:49', '2025-02-06 20:42:53'),
(618, 349, 38, 1, '2025-02-06 20:42:49', '2025-02-06 20:42:49'),
(619, 350, 32, 1, '2025-02-06 20:42:50', '2025-02-06 20:42:53'),
(620, 350, 38, 1, '2025-02-06 20:42:50', '2025-02-06 20:42:50'),
(621, 351, 32, 1, '2025-02-06 20:42:50', '2025-02-06 20:42:53'),
(622, 351, 38, 1, '2025-02-06 20:42:50', '2025-02-06 20:42:50'),
(623, 352, 32, 1, '2025-02-06 21:16:59', '2025-02-06 21:27:55'),
(624, 352, 38, 1, '2025-02-06 21:16:59', '2025-02-06 21:16:59'),
(625, 353, 38, 1, '2025-02-06 21:27:57', '2025-02-06 21:28:00'),
(626, 353, 32, 1, '2025-02-06 21:27:57', '2025-02-06 21:27:57'),
(627, 354, 32, 1, '2025-02-06 21:28:03', '2025-02-06 21:28:03'),
(628, 354, 38, 1, '2025-02-06 21:28:03', '2025-02-06 21:28:03'),
(629, 355, 32, 0, '2025-02-06 21:28:16', '2025-02-06 21:28:16'),
(630, 355, 38, 1, '2025-02-06 21:28:16', '2025-02-06 21:28:16'),
(631, 356, 32, 0, '2025-02-06 21:28:18', '2025-02-06 21:28:18'),
(632, 356, 38, 1, '2025-02-06 21:28:18', '2025-02-06 21:28:18'),
(633, 357, 32, 1, '2025-02-06 21:36:38', '2025-02-06 21:36:45'),
(634, 357, 38, 1, '2025-02-06 21:36:38', '2025-02-06 21:36:38'),
(635, 358, 32, 1, '2025-02-06 21:36:49', '2025-02-06 21:36:49'),
(636, 358, 38, 1, '2025-02-06 21:36:49', '2025-02-06 21:36:49'),
(637, 359, 32, 1, '2025-02-06 21:37:03', '2025-02-06 21:39:03'),
(638, 359, 38, 1, '2025-02-06 21:37:03', '2025-02-06 21:37:03'),
(639, 360, 32, 1, '2025-02-06 21:39:07', '2025-02-06 21:39:07'),
(640, 360, 38, 1, '2025-02-06 21:39:07', '2025-02-06 21:39:07'),
(641, 361, 32, 0, '2025-02-06 21:39:14', '2025-02-06 21:39:14'),
(642, 361, 38, 1, '2025-02-06 21:39:14', '2025-02-06 21:39:14'),
(643, 362, 32, 0, '2025-02-06 21:39:15', '2025-02-06 21:39:15'),
(644, 362, 38, 1, '2025-02-06 21:39:15', '2025-02-06 21:39:15'),
(645, 363, 32, 0, '2025-02-06 21:39:20', '2025-02-06 21:39:20'),
(646, 363, 38, 1, '2025-02-06 21:39:20', '2025-02-06 21:39:20'),
(647, 364, 32, 0, '2025-02-06 21:39:25', '2025-02-06 21:39:25'),
(648, 364, 38, 1, '2025-02-06 21:39:25', '2025-02-06 21:39:25'),
(649, 365, 32, 1, '2025-02-06 21:49:13', '2025-02-06 21:51:02'),
(650, 365, 38, 1, '2025-02-06 21:49:13', '2025-02-06 21:49:13'),
(651, 366, 32, 1, '2025-02-06 21:49:25', '2025-02-06 21:51:02'),
(652, 366, 38, 1, '2025-02-06 21:49:25', '2025-02-06 21:49:25'),
(653, 367, 38, 1, '2025-02-06 21:51:04', '2025-02-06 21:51:58'),
(654, 367, 32, 1, '2025-02-06 21:51:04', '2025-02-06 21:51:04'),
(655, 368, 38, 1, '2025-02-06 21:51:40', '2025-02-06 21:51:58'),
(656, 368, 32, 1, '2025-02-06 21:51:40', '2025-02-06 21:51:40'),
(657, 369, 38, 1, '2025-02-06 21:51:57', '2025-02-06 21:51:58'),
(658, 369, 32, 1, '2025-02-06 21:51:57', '2025-02-06 21:51:57'),
(659, 370, 32, 1, '2025-02-06 21:54:17', '2025-02-06 21:54:17'),
(660, 371, 32, 1, '2025-02-06 21:56:17', '2025-02-06 21:56:44'),
(661, 371, 38, 1, '2025-02-06 21:56:17', '2025-02-06 21:56:17'),
(662, 372, 32, 1, '2025-02-06 21:56:19', '2025-02-06 21:56:44'),
(663, 372, 38, 1, '2025-02-06 21:56:19', '2025-02-06 21:56:19'),
(664, 373, 32, 1, '2025-02-06 21:56:20', '2025-02-06 21:56:44'),
(665, 373, 38, 1, '2025-02-06 21:56:20', '2025-02-06 21:56:20'),
(666, 374, 32, 1, '2025-02-06 21:56:20', '2025-02-06 21:56:44'),
(667, 374, 38, 1, '2025-02-06 21:56:20', '2025-02-06 21:56:20'),
(668, 375, 32, 1, '2025-02-06 21:56:20', '2025-02-06 21:56:44'),
(669, 375, 38, 1, '2025-02-06 21:56:20', '2025-02-06 21:56:20'),
(670, 376, 32, 1, '2025-02-06 21:56:20', '2025-02-06 21:56:44'),
(671, 376, 38, 1, '2025-02-06 21:56:20', '2025-02-06 21:56:20'),
(672, 377, 32, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:44'),
(673, 377, 38, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:21'),
(674, 378, 32, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:44'),
(675, 378, 38, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:21'),
(676, 379, 32, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:44'),
(677, 379, 38, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:21'),
(678, 380, 32, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:44'),
(679, 380, 38, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:21'),
(680, 381, 32, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:44'),
(681, 381, 38, 1, '2025-02-06 21:56:21', '2025-02-06 21:56:21'),
(682, 382, 32, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:44'),
(683, 382, 38, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:22'),
(684, 383, 32, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:44'),
(685, 383, 38, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:22'),
(686, 384, 32, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:44'),
(687, 384, 38, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:22'),
(688, 385, 32, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:44'),
(689, 385, 38, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:22'),
(690, 386, 32, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:44'),
(691, 386, 38, 1, '2025-02-06 21:56:22', '2025-02-06 21:56:22'),
(692, 387, 32, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:44'),
(693, 387, 38, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:23'),
(694, 388, 32, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:44'),
(695, 388, 38, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:23'),
(696, 389, 32, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:44'),
(697, 389, 38, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:23'),
(698, 390, 32, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:44'),
(699, 390, 38, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:23'),
(700, 391, 32, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:44'),
(701, 391, 38, 1, '2025-02-06 21:56:23', '2025-02-06 21:56:23'),
(702, 392, 32, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:44'),
(703, 392, 38, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:24'),
(704, 393, 32, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:44'),
(705, 393, 38, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:24'),
(706, 394, 32, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:44'),
(707, 394, 38, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:24'),
(708, 395, 32, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:44'),
(709, 395, 38, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:24'),
(710, 396, 32, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:44'),
(711, 396, 38, 1, '2025-02-06 21:56:24', '2025-02-06 21:56:24'),
(712, 397, 32, 1, '2025-02-06 21:56:25', '2025-02-06 21:56:44'),
(713, 397, 38, 1, '2025-02-06 21:56:25', '2025-02-06 21:56:25'),
(714, 398, 32, 1, '2025-02-06 21:56:25', '2025-02-06 21:56:44'),
(715, 398, 38, 1, '2025-02-06 21:56:25', '2025-02-06 21:56:25'),
(716, 399, 32, 1, '2025-02-06 21:56:25', '2025-02-06 21:56:44'),
(717, 399, 38, 1, '2025-02-06 21:56:25', '2025-02-06 21:56:25'),
(718, 400, 32, 1, '2025-02-06 21:56:25', '2025-02-06 21:56:44'),
(719, 400, 38, 1, '2025-02-06 21:56:25', '2025-02-06 21:56:25'),
(720, 401, 32, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:44'),
(721, 401, 38, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:26'),
(722, 402, 32, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:44'),
(723, 402, 38, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:26'),
(724, 403, 32, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:44'),
(725, 403, 38, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:26'),
(726, 404, 32, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:44'),
(727, 404, 38, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:26'),
(728, 405, 32, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:44'),
(729, 405, 38, 1, '2025-02-06 21:56:26', '2025-02-06 21:56:26'),
(730, 406, 32, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:44'),
(731, 406, 38, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:27'),
(732, 407, 32, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:44'),
(733, 407, 38, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:27'),
(734, 408, 32, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:44'),
(735, 408, 38, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:27'),
(736, 409, 32, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:44'),
(737, 409, 38, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:27'),
(738, 410, 32, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:44'),
(739, 410, 38, 1, '2025-02-06 21:56:27', '2025-02-06 21:56:27'),
(740, 411, 32, 1, '2025-02-06 21:56:28', '2025-02-06 21:56:44'),
(741, 411, 38, 1, '2025-02-06 21:56:28', '2025-02-06 21:56:28'),
(742, 412, 32, 1, '2025-02-06 21:56:28', '2025-02-06 21:56:44'),
(743, 412, 38, 1, '2025-02-06 21:56:28', '2025-02-06 21:56:28'),
(744, 413, 32, 1, '2025-02-06 21:56:28', '2025-02-06 21:56:44'),
(745, 413, 38, 1, '2025-02-06 21:56:28', '2025-02-06 21:56:28'),
(746, 414, 32, 1, '2025-02-06 21:56:28', '2025-02-06 21:56:44'),
(747, 414, 38, 1, '2025-02-06 21:56:28', '2025-02-06 21:56:28'),
(748, 415, 32, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:44'),
(749, 415, 38, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:29'),
(750, 416, 32, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:44'),
(751, 416, 38, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:29'),
(752, 417, 32, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:44'),
(753, 417, 38, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:29'),
(754, 418, 32, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:44'),
(755, 418, 38, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:29'),
(756, 419, 32, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:44'),
(757, 419, 38, 1, '2025-02-06 21:56:29', '2025-02-06 21:56:29'),
(758, 420, 32, 1, '2025-02-06 21:56:30', '2025-02-06 21:56:44'),
(759, 420, 38, 1, '2025-02-06 21:56:30', '2025-02-06 21:56:30'),
(760, 421, 32, 1, '2025-02-06 21:56:30', '2025-02-06 21:56:44'),
(761, 421, 38, 1, '2025-02-06 21:56:30', '2025-02-06 21:56:30'),
(762, 422, 32, 1, '2025-02-06 21:56:30', '2025-02-06 21:56:44'),
(763, 422, 38, 1, '2025-02-06 21:56:30', '2025-02-06 21:56:30'),
(764, 423, 32, 1, '2025-02-06 21:56:30', '2025-02-06 21:56:44'),
(765, 423, 38, 1, '2025-02-06 21:56:30', '2025-02-06 21:56:30'),
(766, 424, 32, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:44'),
(767, 424, 38, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:31'),
(768, 425, 32, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:44'),
(769, 425, 38, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:31'),
(770, 426, 32, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:44'),
(771, 426, 38, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:31'),
(772, 427, 32, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:44'),
(773, 427, 38, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:31'),
(774, 428, 32, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:44'),
(775, 428, 38, 1, '2025-02-06 21:56:31', '2025-02-06 21:56:31'),
(776, 429, 32, 1, '2025-02-06 21:56:32', '2025-02-06 21:56:44'),
(777, 429, 38, 1, '2025-02-06 21:56:32', '2025-02-06 21:56:32'),
(778, 430, 32, 1, '2025-02-06 21:56:32', '2025-02-06 21:56:44'),
(779, 430, 38, 1, '2025-02-06 21:56:32', '2025-02-06 21:56:32'),
(780, 431, 32, 1, '2025-02-06 21:56:32', '2025-02-06 21:56:44'),
(781, 431, 38, 1, '2025-02-06 21:56:32', '2025-02-06 21:56:32'),
(782, 432, 32, 1, '2025-02-06 21:56:32', '2025-02-06 21:56:44'),
(783, 432, 38, 1, '2025-02-06 21:56:32', '2025-02-06 21:56:32'),
(784, 433, 32, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:44'),
(785, 433, 38, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:33'),
(786, 434, 32, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:44'),
(787, 434, 38, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:33'),
(788, 435, 32, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:44'),
(789, 435, 38, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:33'),
(790, 436, 32, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:44'),
(791, 436, 38, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:33'),
(792, 437, 32, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:44'),
(793, 437, 38, 1, '2025-02-06 21:56:33', '2025-02-06 21:56:33'),
(794, 438, 32, 1, '2025-02-06 21:56:34', '2025-02-06 21:56:44'),
(795, 438, 38, 1, '2025-02-06 21:56:34', '2025-02-06 21:56:34');
INSERT INTO `message_status` (`id`, `message_id`, `user_id`, `is_read`, `created_at`, `updated_at`) VALUES
(796, 439, 32, 1, '2025-02-06 21:56:34', '2025-02-06 21:56:44'),
(797, 439, 38, 1, '2025-02-06 21:56:34', '2025-02-06 21:56:34'),
(798, 440, 32, 1, '2025-02-06 21:56:34', '2025-02-06 21:56:44'),
(799, 440, 38, 1, '2025-02-06 21:56:34', '2025-02-06 21:56:34'),
(800, 441, 32, 1, '2025-02-06 21:56:34', '2025-02-06 21:56:44'),
(801, 441, 38, 1, '2025-02-06 21:56:34', '2025-02-06 21:56:34'),
(802, 442, 32, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:44'),
(803, 442, 38, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:35'),
(804, 443, 32, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:44'),
(805, 443, 38, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:35'),
(806, 444, 32, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:44'),
(807, 444, 38, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:35'),
(808, 445, 32, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:44'),
(809, 445, 38, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:35'),
(810, 446, 32, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:44'),
(811, 446, 38, 1, '2025-02-06 21:56:35', '2025-02-06 21:56:35'),
(812, 447, 32, 1, '2025-02-06 21:56:36', '2025-02-06 21:56:44'),
(813, 447, 38, 1, '2025-02-06 21:56:36', '2025-02-06 21:56:36'),
(814, 448, 32, 1, '2025-02-06 21:56:36', '2025-02-06 21:56:44'),
(815, 448, 38, 1, '2025-02-06 21:56:36', '2025-02-06 21:56:36'),
(816, 449, 32, 1, '2025-02-06 21:56:36', '2025-02-06 21:56:44'),
(817, 449, 38, 1, '2025-02-06 21:56:36', '2025-02-06 21:56:36'),
(818, 450, 32, 1, '2025-02-06 21:56:36', '2025-02-06 21:56:44'),
(819, 450, 38, 1, '2025-02-06 21:56:36', '2025-02-06 21:56:36'),
(820, 451, 32, 1, '2025-02-06 21:56:37', '2025-02-06 21:56:44'),
(821, 451, 38, 1, '2025-02-06 21:56:37', '2025-02-06 21:56:37'),
(822, 452, 32, 1, '2025-02-06 21:56:37', '2025-02-06 21:56:44'),
(823, 452, 38, 1, '2025-02-06 21:56:37', '2025-02-06 21:56:37'),
(824, 453, 32, 1, '2025-02-06 21:56:38', '2025-02-06 21:56:44'),
(825, 453, 38, 1, '2025-02-06 21:56:38', '2025-02-06 21:56:38'),
(826, 454, 32, 1, '2025-02-06 21:56:39', '2025-02-06 21:56:44'),
(827, 454, 38, 1, '2025-02-06 21:56:39', '2025-02-06 21:56:39'),
(828, 455, 32, 1, '2025-02-06 21:56:39', '2025-02-06 21:56:44'),
(829, 455, 38, 1, '2025-02-06 21:56:39', '2025-02-06 21:56:39'),
(830, 456, 32, 1, '2025-02-06 21:56:40', '2025-02-06 21:56:44'),
(831, 456, 38, 1, '2025-02-06 21:56:40', '2025-02-06 21:56:40'),
(832, 457, 32, 1, '2025-02-06 21:56:40', '2025-02-06 21:56:44'),
(833, 457, 38, 1, '2025-02-06 21:56:40', '2025-02-06 21:56:40'),
(834, 458, 32, 1, '2025-02-06 21:56:40', '2025-02-06 21:56:44'),
(835, 458, 38, 1, '2025-02-06 21:56:40', '2025-02-06 21:56:40'),
(836, 459, 32, 1, '2025-02-06 21:56:41', '2025-02-06 21:56:44'),
(837, 459, 38, 1, '2025-02-06 21:56:41', '2025-02-06 21:56:41'),
(838, 460, 32, 1, '2025-02-06 21:56:41', '2025-02-06 21:56:44'),
(839, 460, 38, 1, '2025-02-06 21:56:41', '2025-02-06 21:56:41'),
(840, 461, 32, 1, '2025-02-06 21:56:41', '2025-02-06 21:56:44'),
(841, 461, 38, 1, '2025-02-06 21:56:41', '2025-02-06 21:56:41'),
(842, 462, 32, 1, '2025-02-06 21:56:42', '2025-02-06 21:56:44'),
(843, 462, 38, 1, '2025-02-06 21:56:42', '2025-02-06 21:56:42'),
(844, 463, 32, 1, '2025-02-06 21:56:53', '2025-02-06 22:12:05'),
(845, 463, 38, 1, '2025-02-06 21:56:53', '2025-02-06 21:56:53'),
(846, 464, 32, 1, '2025-02-06 21:56:53', '2025-02-06 22:12:05'),
(847, 464, 38, 1, '2025-02-06 21:56:53', '2025-02-06 21:56:53'),
(848, 465, 32, 1, '2025-02-06 21:56:54', '2025-02-06 22:12:05'),
(849, 465, 38, 1, '2025-02-06 21:56:54', '2025-02-06 21:56:54'),
(850, 466, 32, 1, '2025-02-06 21:56:54', '2025-02-06 22:12:05'),
(851, 466, 38, 1, '2025-02-06 21:56:54', '2025-02-06 21:56:54'),
(852, 467, 32, 1, '2025-02-06 21:56:54', '2025-02-06 22:12:05'),
(853, 467, 38, 1, '2025-02-06 21:56:54', '2025-02-06 21:56:54'),
(854, 468, 32, 1, '2025-02-06 21:56:55', '2025-02-06 22:12:05'),
(855, 468, 38, 1, '2025-02-06 21:56:55', '2025-02-06 21:56:55'),
(856, 469, 32, 1, '2025-02-06 21:56:55', '2025-02-06 22:12:05'),
(857, 469, 38, 1, '2025-02-06 21:56:55', '2025-02-06 21:56:55'),
(858, 470, 32, 1, '2025-02-06 21:56:55', '2025-02-06 22:12:05'),
(859, 470, 38, 1, '2025-02-06 21:56:55', '2025-02-06 21:56:55'),
(860, 471, 32, 1, '2025-02-06 21:56:55', '2025-02-06 22:12:05'),
(861, 471, 38, 1, '2025-02-06 21:56:55', '2025-02-06 21:56:55'),
(862, 472, 32, 1, '2025-02-06 21:56:55', '2025-02-06 22:12:05'),
(863, 472, 38, 1, '2025-02-06 21:56:55', '2025-02-06 21:56:55'),
(864, 473, 32, 1, '2025-02-06 21:56:56', '2025-02-06 22:12:05'),
(865, 473, 38, 1, '2025-02-06 21:56:56', '2025-02-06 21:56:56'),
(866, 474, 32, 1, '2025-02-06 21:56:56', '2025-02-06 22:12:05'),
(867, 474, 38, 1, '2025-02-06 21:56:56', '2025-02-06 21:56:56'),
(868, 475, 32, 1, '2025-02-06 21:56:56', '2025-02-06 22:12:05'),
(869, 475, 38, 1, '2025-02-06 21:56:56', '2025-02-06 21:56:56'),
(870, 476, 32, 1, '2025-02-06 21:56:56', '2025-02-06 22:12:05'),
(871, 476, 38, 1, '2025-02-06 21:56:56', '2025-02-06 21:56:56'),
(872, 477, 32, 1, '2025-02-06 21:56:56', '2025-02-06 22:12:05'),
(873, 477, 38, 1, '2025-02-06 21:56:56', '2025-02-06 21:56:56'),
(874, 478, 32, 1, '2025-02-06 21:56:57', '2025-02-06 22:12:05'),
(875, 478, 38, 1, '2025-02-06 21:56:57', '2025-02-06 21:56:57'),
(876, 479, 32, 1, '2025-02-06 21:56:57', '2025-02-06 22:12:05'),
(877, 479, 38, 1, '2025-02-06 21:56:57', '2025-02-06 21:56:57'),
(878, 480, 32, 1, '2025-02-06 21:56:58', '2025-02-06 22:12:05'),
(879, 480, 38, 1, '2025-02-06 21:56:58', '2025-02-06 21:56:58'),
(880, 481, 32, 1, '2025-02-06 21:56:58', '2025-02-06 22:12:05'),
(881, 481, 38, 1, '2025-02-06 21:56:58', '2025-02-06 21:56:58'),
(882, 482, 32, 1, '2025-02-06 21:56:58', '2025-02-06 22:12:05'),
(883, 482, 38, 1, '2025-02-06 21:56:58', '2025-02-06 21:56:58'),
(884, 483, 32, 1, '2025-02-06 21:56:58', '2025-02-06 22:12:05'),
(885, 483, 38, 1, '2025-02-06 21:56:58', '2025-02-06 21:56:58'),
(886, 484, 32, 1, '2025-02-06 21:56:58', '2025-02-06 22:12:05'),
(887, 484, 38, 1, '2025-02-06 21:56:58', '2025-02-06 21:56:58'),
(888, 485, 32, 1, '2025-02-06 21:56:59', '2025-02-06 22:12:05'),
(889, 485, 38, 1, '2025-02-06 21:56:59', '2025-02-06 21:56:59'),
(890, 486, 32, 1, '2025-02-06 21:56:59', '2025-02-06 22:12:05'),
(891, 486, 38, 1, '2025-02-06 21:56:59', '2025-02-06 21:56:59'),
(892, 487, 32, 1, '2025-02-06 21:57:00', '2025-02-06 22:12:05'),
(893, 487, 38, 1, '2025-02-06 21:57:00', '2025-02-06 21:57:00'),
(894, 488, 38, 1, '2025-02-06 22:12:19', '2025-02-06 22:12:28'),
(895, 488, 32, 1, '2025-02-06 22:12:19', '2025-02-06 22:12:19'),
(896, 489, 38, 1, '2025-02-06 22:12:23', '2025-02-06 22:12:28'),
(897, 489, 32, 1, '2025-02-06 22:12:23', '2025-02-06 22:12:23'),
(898, 490, 32, 1, '2025-02-06 22:12:28', '2025-02-06 22:12:28'),
(899, 490, 38, 1, '2025-02-06 22:12:28', '2025-02-06 22:12:28'),
(900, 491, 38, 1, '2025-02-06 22:12:35', '2025-02-06 22:12:44'),
(901, 491, 32, 1, '2025-02-06 22:12:35', '2025-02-06 22:12:35'),
(902, 492, 38, 1, '2025-02-06 22:12:38', '2025-02-06 22:12:44'),
(903, 492, 32, 1, '2025-02-06 22:12:38', '2025-02-06 22:12:38'),
(904, 493, 32, 1, '2025-02-06 22:12:44', '2025-02-06 22:12:44'),
(905, 493, 38, 1, '2025-02-06 22:12:44', '2025-02-06 22:12:44'),
(906, 494, 32, 1, '2025-02-06 22:12:47', '2025-02-06 22:12:53'),
(907, 494, 38, 1, '2025-02-06 22:12:47', '2025-02-06 22:12:47'),
(908, 495, 38, 1, '2025-02-06 22:12:56', '2025-02-07 03:49:40'),
(909, 495, 32, 1, '2025-02-06 22:12:56', '2025-02-06 22:12:56'),
(910, 496, 32, 0, '2025-02-07 03:51:51', '2025-02-07 03:51:51'),
(911, 496, 35, 1, '2025-02-07 03:51:51', '2025-02-07 03:51:51'),
(912, 497, 35, 0, '2025-02-07 03:52:20', '2025-02-07 03:52:20'),
(913, 497, 32, 1, '2025-02-07 03:52:20', '2025-02-07 03:52:20'),
(914, 498, 37, 1, '2025-02-07 04:11:23', '2025-02-07 04:11:34'),
(915, 498, 32, 1, '2025-02-07 04:11:23', '2025-02-07 04:11:23'),
(916, 499, 32, 1, '2025-02-07 04:11:49', '2025-02-07 04:11:49'),
(917, 499, 37, 1, '2025-02-07 04:11:49', '2025-02-07 04:11:49'),
(918, 500, 32, 1, '2025-02-07 04:11:57', '2025-02-07 04:12:01'),
(919, 500, 37, 1, '2025-02-07 04:11:57', '2025-02-07 04:11:57'),
(920, 501, 37, 1, '2025-02-07 04:13:04', '2025-02-07 04:13:11'),
(921, 501, 32, 1, '2025-02-07 04:13:04', '2025-02-07 04:13:04'),
(922, 502, 37, 1, '2025-02-07 04:14:54', '2025-02-07 04:14:54'),
(923, 502, 35, 1, '2025-02-07 04:14:54', '2025-02-07 04:14:54'),
(924, 503, 34, 0, '2025-02-07 04:15:20', '2025-02-07 04:15:20'),
(925, 503, 32, 1, '2025-02-07 04:15:20', '2025-02-07 04:15:20'),
(926, 504, 32, 0, '2025-02-07 04:15:37', '2025-02-07 04:15:37'),
(927, 504, 35, 1, '2025-02-07 04:15:37', '2025-02-07 04:15:37'),
(928, 505, 37, 1, '2025-02-07 04:15:41', '2025-02-07 04:15:52'),
(929, 505, 35, 1, '2025-02-07 04:15:41', '2025-02-07 04:15:41'),
(930, 506, 35, 0, '2025-02-07 04:32:21', '2025-02-07 04:32:21'),
(931, 507, 32, 1, '2025-02-07 04:40:03', '2025-02-07 04:40:23'),
(932, 507, 37, 1, '2025-02-07 04:40:03', '2025-02-07 04:40:03'),
(933, 508, 32, 1, '2025-02-07 04:40:15', '2025-02-07 04:40:23'),
(934, 508, 37, 1, '2025-02-07 04:40:15', '2025-02-07 04:40:15'),
(935, 509, 37, 1, '2025-02-07 04:40:25', '2025-02-07 04:40:51'),
(936, 509, 32, 1, '2025-02-07 04:40:25', '2025-02-07 04:40:25'),
(937, 510, 37, 1, '2025-02-07 04:40:38', '2025-02-07 04:40:51'),
(938, 510, 32, 1, '2025-02-07 04:40:38', '2025-02-07 04:40:38'),
(939, 511, 32, 1, '2025-02-07 04:40:53', '2025-02-07 04:40:53'),
(940, 511, 37, 1, '2025-02-07 04:40:53', '2025-02-07 04:40:53'),
(941, 512, 32, 1, '2025-02-07 14:33:02', '2025-02-07 14:39:40'),
(942, 512, 37, 1, '2025-02-07 14:33:02', '2025-02-07 14:33:02'),
(943, 513, 37, 1, '2025-02-07 14:39:43', '2025-02-07 14:42:23'),
(944, 513, 32, 1, '2025-02-07 14:39:43', '2025-02-07 14:39:43'),
(945, 514, 32, 1, '2025-02-07 14:42:27', '2025-02-07 14:52:13'),
(946, 514, 37, 1, '2025-02-07 14:42:27', '2025-02-07 14:42:27'),
(947, 515, 37, 1, '2025-02-07 14:52:18', '2025-02-07 15:05:49'),
(948, 515, 32, 1, '2025-02-07 14:52:18', '2025-02-07 14:52:18'),
(949, 516, 37, 1, '2025-02-07 14:58:59', '2025-02-07 15:05:49'),
(950, 516, 32, 1, '2025-02-07 14:58:59', '2025-02-07 14:58:59'),
(951, 517, 37, 1, '2025-02-07 14:59:07', '2025-02-07 15:05:49'),
(952, 517, 32, 1, '2025-02-07 14:59:07', '2025-02-07 14:59:07'),
(953, 518, 32, 1, '2025-02-07 15:05:52', '2025-02-07 15:27:28'),
(954, 518, 37, 1, '2025-02-07 15:05:52', '2025-02-07 15:05:52'),
(955, 519, 32, 1, '2025-02-07 15:06:06', '2025-02-07 15:27:28'),
(956, 519, 37, 1, '2025-02-07 15:06:06', '2025-02-07 15:06:06'),
(957, 520, 32, 1, '2025-02-07 15:06:15', '2025-02-07 15:27:28'),
(958, 520, 37, 1, '2025-02-07 15:06:15', '2025-02-07 15:06:15'),
(959, 521, 32, 1, '2025-02-07 15:07:25', '2025-02-07 15:27:28'),
(960, 521, 37, 1, '2025-02-07 15:07:25', '2025-02-07 15:07:25'),
(961, 522, 32, 1, '2025-02-07 15:07:47', '2025-02-07 15:27:28'),
(962, 522, 37, 1, '2025-02-07 15:07:47', '2025-02-07 15:07:47'),
(963, 523, 32, 1, '2025-02-07 15:07:56', '2025-02-07 15:27:28'),
(964, 523, 37, 1, '2025-02-07 15:07:56', '2025-02-07 15:07:56'),
(965, 524, 32, 1, '2025-02-07 15:25:56', '2025-02-07 15:27:28'),
(966, 524, 37, 1, '2025-02-07 15:25:56', '2025-02-07 15:25:56'),
(967, 525, 32, 1, '2025-02-07 15:26:14', '2025-02-07 15:27:28'),
(968, 525, 37, 1, '2025-02-07 15:26:14', '2025-02-07 15:26:14'),
(969, 526, 37, 1, '2025-02-07 15:27:34', '2025-02-07 15:30:54'),
(970, 526, 32, 1, '2025-02-07 15:27:34', '2025-02-07 15:27:34'),
(971, 527, 37, 1, '2025-02-07 15:27:41', '2025-02-07 15:30:54'),
(972, 527, 32, 1, '2025-02-07 15:27:41', '2025-02-07 15:27:41'),
(973, 528, 37, 1, '2025-02-07 15:27:45', '2025-02-07 15:30:54'),
(974, 528, 32, 1, '2025-02-07 15:27:45', '2025-02-07 15:27:45'),
(975, 529, 32, 1, '2025-02-07 15:31:37', '2025-02-07 15:32:19'),
(976, 529, 37, 1, '2025-02-07 15:31:37', '2025-02-07 15:31:37'),
(977, 530, 32, 1, '2025-02-07 15:31:49', '2025-02-07 15:32:19'),
(978, 530, 37, 1, '2025-02-07 15:31:49', '2025-02-07 15:31:49'),
(979, 531, 37, 1, '2025-02-07 15:32:36', '2025-02-07 15:32:53'),
(980, 531, 32, 1, '2025-02-07 15:32:36', '2025-02-07 15:32:36'),
(981, 532, 37, 1, '2025-02-07 15:33:07', '2025-02-07 15:33:18'),
(982, 532, 32, 1, '2025-02-07 15:33:07', '2025-02-07 15:33:07'),
(983, 533, 37, 1, '2025-02-07 15:33:14', '2025-02-07 15:33:18'),
(984, 533, 32, 1, '2025-02-07 15:33:14', '2025-02-07 15:33:14'),
(985, 534, 37, 1, '2025-02-07 15:35:40', '2025-02-07 15:39:11'),
(986, 534, 32, 1, '2025-02-07 15:35:40', '2025-02-07 15:35:40'),
(987, 535, 37, 1, '2025-02-07 15:35:48', '2025-02-07 15:39:11'),
(988, 535, 32, 1, '2025-02-07 15:35:48', '2025-02-07 15:35:48');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('booking','message','venue') NOT NULL,
  `reference_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `reference_id`, `message`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 32, 'booking', 1, 'New booking request for Beach House', 1, NULL, '2025-02-06 21:32:25', '2025-02-06 21:35:41'),
(2, 32, 'message', 1, 'New message from John Doe', 1, NULL, '2025-02-06 21:32:25', '2025-02-06 21:35:41'),
(3, 32, 'venue', 1, 'Your venue Mountain Retreat has been approved', 1, NULL, '2025-02-06 21:32:25', '2025-02-06 21:34:01'),
(4, 38, 'booking', 1, 'New booking request for Beach House', 1, NULL, '2025-02-06 21:32:52', '2025-02-06 21:51:34'),
(5, 38, 'message', 1, 'New message from John Doe', 1, NULL, '2025-02-06 21:32:52', '2025-02-06 21:51:34'),
(6, 38, 'venue', 1, 'Your venue Mountain Retreat has been approved', 1, NULL, '2025-02-06 21:32:52', '2025-02-06 21:51:34'),
(7, 32, 'message', 357, 'Cyril Benwa sent you a message', 1, NULL, '2025-02-06 21:36:38', '2025-02-06 21:38:50'),
(8, 32, 'message', 358, 'Cyril Benwa sent you a message', 1, NULL, '2025-02-06 21:36:49', '2025-02-06 21:38:50'),
(9, 32, 'message', 359, 'Cyril Benwa sent you a message', 1, NULL, '2025-02-06 21:37:03', '2025-02-06 21:38:50'),
(10, 32, 'message', 360, 'Cyril Benwa sent you a message', 1, NULL, '2025-02-06 21:39:07', '2025-02-06 21:49:05'),
(11, 32, 'message', 365, 'Cyril Benwa sent you a message', 1, NULL, '2025-02-06 21:49:13', '2025-02-07 14:32:35'),
(12, 32, 'message', 1, 'Hello! This is a test message.', 1, NULL, '2025-02-07 14:54:43', '2025-02-07 14:55:03'),
(13, 32, 'booking', 1, 'New booking request received', 1, NULL, '2025-02-07 14:54:44', '2025-02-07 14:55:03'),
(14, 32, 'venue', 1, 'Your venue listing has been approved', 1, NULL, '2025-02-07 14:54:51', '2025-02-07 14:55:03'),
(15, 32, '', 1, 'Booking status has been updated', 1, NULL, '2025-02-07 14:54:55', '2025-02-07 14:55:03'),
(16, 32, '', 1, 'Booking price has been updated', 1, NULL, '2025-02-07 14:54:59', '2025-02-07 14:55:03'),
(17, 32, '', 32, 'Your account has been verified', 1, NULL, '2025-02-07 14:55:01', '2025-02-07 14:55:03'),
(18, 32, 'message', 1, 'Hello! This is a test message.', 1, NULL, '2025-02-07 14:55:12', '2025-02-07 15:03:45'),
(19, 32, 'booking', 1, 'New booking request received', 1, NULL, '2025-02-07 14:55:49', '2025-02-07 15:03:45'),
(20, 32, 'booking', 1, 'New booking request received', 1, NULL, '2025-02-07 14:55:49', '2025-02-07 15:03:45'),
(21, 32, 'message', 1, 'Hello! This is a test message.', 1, NULL, '2025-02-07 14:55:51', '2025-02-07 15:03:45'),
(22, 37, 'message', 517, 'hello!/\\', 1, NULL, '2025-02-07 14:58:59', '2025-02-07 15:28:41'),
(23, 32, 'message', 518, 'Hello', 1, NULL, '2025-02-07 08:05:52', '2025-02-07 15:29:31'),
(24, 32, 'message', 519, 'nonono', 1, NULL, '2025-02-07 08:06:06', '2025-02-07 15:29:31'),
(25, 32, 'message', 520, 'Heyyyy', 1, NULL, '2025-02-07 08:06:15', '2025-02-07 15:29:31'),
(26, 32, 'message', 523, 'AYYYYY', 1, NULL, '2025-02-07 15:07:25', '2025-02-07 15:29:31'),
(27, 32, 'message', 525, 'HAHAHAHAHAHA\'', 1, NULL, '2025-02-07 15:25:56', '2025-02-07 15:29:31'),
(28, 37, 'message', 528, 'What do you want', 1, NULL, '2025-02-07 15:27:34', '2025-02-07 15:32:58'),
(29, 32, 'message', 530, 'Just wanted to bother you', 1, NULL, '2025-02-07 15:31:37', '2025-02-07 15:32:19'),
(30, 37, 'message', 535, 'You alright?', 1, NULL, '2025-02-07 15:32:36', '2025-02-07 15:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_type_id` int(11) NOT NULL,
  `email_enabled` tinyint(1) DEFAULT 1,
  `push_enabled` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_settings`
--

INSERT INTO `notification_settings` (`id`, `user_id`, `notification_type_id`, `email_enabled`, `push_enabled`, `created_at`, `updated_at`) VALUES
(1, 30, 1, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(2, 30, 2, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(3, 30, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(4, 31, 1, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(5, 31, 2, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(6, 31, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(7, 32, 1, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(8, 32, 2, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(9, 32, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(10, 33, 1, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(11, 33, 2, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(12, 33, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(13, 34, 1, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(14, 34, 2, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(15, 34, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(16, 35, 1, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(17, 35, 2, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(18, 35, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(19, 36, 1, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(20, 36, 2, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(21, 36, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(22, 37, 1, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(23, 37, 2, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(24, 37, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(25, 38, 1, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(26, 38, 2, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26'),
(27, 38, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE `notification_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `name`, `description`) VALUES
(1, 'booking', 'Notifications related to bookings'),
(2, 'message', 'Notifications related to messages'),
(3, 'venue', 'Notifications related to venues');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method_sub`
--

CREATE TABLE `payment_method_sub` (
  `id` int(11) NOT NULL,
  `payment_method_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method_sub`
--

INSERT INTO `payment_method_sub` (`id`, `payment_method_name`) VALUES
(1, 'G-cash'),
(2, 'PayMaya');

-- --------------------------------------------------------

--
-- Table structure for table `payment_status_sub`
--

CREATE TABLE `payment_status_sub` (
  `id` int(11) NOT NULL,
  `payment_status_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_status_sub`
--

INSERT INTO `payment_status_sub` (`id`, `payment_status_name`) VALUES
(1, 'Pending'),
(2, 'Paid'),
(3, 'Failed');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `venue_id`, `rating`, `review`, `created_at`, `updated_at`) VALUES
(11, 34, 69, 5, 'Su gud', '2025-02-06 13:42:16', '2025-02-06 13:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `sex_sub`
--

CREATE TABLE `sex_sub` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sex_sub`
--

INSERT INTO `sex_sub` (`id`, `name`) VALUES
(1, 'Male'),
(2, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `sex_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `birthdate` date NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `profile_pic` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `middlename`, `sex_id`, `user_type_id`, `birthdate`, `contact_number`, `address`, `profile_pic`, `bio`, `email`, `password`, `created_at`, `updated_at`) VALUES
(30, 'Joevin', 'Ansoc', 'C', 1, 3, '2003-09-28', '09053258512', '6.952867833063975,122.08186864914751', NULL, NULL, 'joevinansoc870@gmail.com', '$2y$10$smhcx5OP9rFvCtpQEzLEBOWmqxYhglKgDpyt2y5ZLRQwpz.ghICc.', '2025-01-19 08:59:35', '2025-01-19 09:01:39'),
(31, 'Joevin', 'Ansoc', 'C', 1, 1, '2003-09-28', '09053258512', '6.92106841695142,122.08812713302906', NULL, '', 'joevinansoc871@gmail.com', '$2y$10$U0hitgecUwvWCunyGve9Qe6XOfTwoMknXxPX5vfxmf1IOdx0ffE6S', '2025-01-19 09:03:00', '2025-01-19 10:40:03'),
(32, 'Rei', 'Ohm', 'O', 1, 1, '2000-02-06', '09708701567', '6.929528272172397,122.06229400529993', NULL, NULL, 'johnmagno332@wmsu.edu.ph', '$2y$10$huGCjd/1nfa0h5h0Xqqqwu0ReG5jrMty/kGUFgR6/EOphFQh6qtle', '2025-01-31 12:35:44', '2025-01-31 12:39:23'),
(33, 'Reio', 'Mao', 'O', 1, 3, '2000-01-31', '09708701567', '6.930772245372988,122.05801963806154', NULL, NULL, 'leviejeanne25@gmail.com', '$2y$10$bgt0PughudQ17kdwmtfVJORp9y/yEmSMp8m7ewwSl.iokfKzvVp5e', '2025-01-31 12:38:52', '2025-01-31 12:39:11'),
(34, 'Rei', 'Reidan', 'O', 1, 2, '2000-11-11', '09708701567', '6.956928997086352,122.0806960965274', NULL, NULL, 'chrisbrown@gmail.com', '$2y$10$0i82otBlCZ8ZGlqBH95l8usOOCcDYJzf7UewqhmDECyecN2nyJZ02', '2025-02-06 12:54:09', '2025-02-06 12:54:09'),
(35, 'Reizer', 'Reidan', 'O', 1, 1, '2000-02-06', '09708701567', '6.924041121155904,122.0799751271261', NULL, NULL, 'johnmagno3322@wmsu.edu.ph', '$2y$10$dc4Q36hhWlExPqfzkJ/ZvebHGQFNeREIVv5Tf6I8dh0LAu0dUxVOq', '2025-02-06 14:35:56', '2025-02-06 14:36:36'),
(36, 'Henny', 'John', 'O', 1, 2, '0223-12-11', '09708701567', '6.9231890732664985,122.07190704240931', NULL, NULL, 'rahema@sample.com', '$2y$10$VMcjUm/J.8gD8pxMKELfouCUu5Yo5bPE6t/wTMfQ7TIAx.zTwlPrC', '2025-02-06 16:07:05', '2025-02-06 16:07:05'),
(37, 'senny', 'John', 'O', 1, 2, '2025-02-07', '09708701567', '6.937844082456897,122.06933212175501', NULL, NULL, 'Mustard@gmail.com', '$2y$10$LD.M3BcqWTpbzGIN7CNieu3rm59tMATOKxevqYybpT7JGKcb.FQqK', '2025-02-06 16:28:26', '2025-02-06 16:28:26'),
(38, 'Cyril', 'Benwa', 'O', 1, 2, '0200-12-11', '09708701567', '6.927790113586606,122.06263732805384', NULL, NULL, 'CyrilBenwa@gmail.com', '$2y$10$uqzbHdIEuZ4S6/KWU1AlbO21/ZYDx9AXoJG5.i0roqCO17RKGjZF.', '2025-02-06 18:33:45', '2025-02-06 18:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_types_sub`
--

CREATE TABLE `user_types_sub` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_types_sub`
--

INSERT INTO `user_types_sub` (`id`, `name`) VALUES
(1, 'Host'),
(2, 'Guest'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `amenities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`amenities`)),
  `rules` longtext NOT NULL,
  `entrance` int(11) NOT NULL,
  `cleaning` int(11) NOT NULL,
  `down_payment_id` int(11) NOT NULL,
  `venue_tag` int(11) NOT NULL,
  `thumbnail` int(11) NOT NULL,
  `time_inout` text NOT NULL,
  `host_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `availability_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `name`, `description`, `address`, `location`, `price`, `capacity`, `amenities`, `rules`, `entrance`, `cleaning`, `down_payment_id`, `venue_tag`, `thumbnail`, `time_inout`, `host_id`, `status_id`, `availability_id`, `created_at`, `updated_at`) VALUES
(61, 'Marcian Convention Center', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Marcian Convention center, Governor Camins Avenue, Zone Ⅱ, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.918710471255118,122.06581115721748', 3800.00, 200, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"Air conditioning\",\"Dedicated workspace\",\"Pool\",\"Pool table\",\"Piano\",\"Exercise equipment\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\"]', '[\"No smoking\",\"No pets\",\"No outside food and drinks\"]', 0, 0, 2, 2, 11, '{\"check_in\":\"14:00\",\"check_out\":\"12:00\"}', 31, 2, 1, '2025-01-23 17:06:12', '2025-01-27 12:34:44'),
(62, 'Tomorrow Land Gc!', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Tumaga, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.937707758370217,122.07345199480189', 6000.00, 20, '[\"Pool\",\"Hot tub\",\"Patio\",\"BBQ grill\",\"Outdoor dining area\",\"Fire pit\",\"Pool table\",\"Indoor fireplace\",\"Piano\",\"Exercise equipment\"]', '[]', 0, 0, 3, 3, 1, '{\"check_in\":\"21:03\",\"check_out\":\"09:03\"}', 32, 2, 1, '2025-01-31 13:03:34', '2025-02-02 14:23:34'),
(63, 'Tomorrow Land Gc!', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Tumaga, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.937707758370217,122.07345199480189', 5000.00, 20, '[\"Pool\",\"Hot tub\",\"Patio\",\"BBQ grill\",\"Outdoor dining area\",\"Fire pit\",\"Pool table\",\"Indoor fireplace\",\"Piano\",\"Exercise equipment\"]', '[]', 0, 0, 3, 3, 1, '{\"check_in\":\"21:03\",\"check_out\":\"09:03\"}', 32, 2, 1, '2025-01-31 13:03:35', '2025-01-31 13:10:30'),
(64, 'Tomorrow Land Room 2', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Canelar, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.9176677667045885,122.06795883073939', 5000.00, 20, '[\"TV\",\"Free parking on premises\"]', '[\"No parties or events\"]', 0, 0, 3, 3, 0, '{\"check_in\":\"21:23\",\"check_out\":\"09:23\"}', 32, 2, 1, '2025-01-31 13:23:15', '2025-01-31 14:02:29'),
(65, 'PariX Pixar', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Edwin Andrews Air Base, Governor Ramos Avenue, Sanroe Subdivision, Santa Maria, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.922268860857976,122.06967544450892', 2000.00, 20, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"Paid parking on premises\",\"Air conditioning\",\"Dedicated workspace\"]', '[\"No pets\"]', 0, 0, 3, 4, 0, '{\"check_in\":\"22:01\",\"check_out\":\"10:01\"}', 32, 2, 1, '2025-01-31 14:01:50', '2025-02-02 14:49:38'),
(66, 'Salted Sugar Candy House', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Moret Road, Canelar, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.918179001602595,122.06521224870814', 2000.00, 20, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"Paid parking on premises\",\"Air conditioning\",\"Dedicated workspace\"]', '[]', 0, 0, 3, 3, 1, '{\"check_in\":\"22:03\",\"check_out\":\"10:03\"}', 32, 2, 1, '2025-01-31 14:03:51', '2025-02-06 14:38:29'),
(67, 'Salted Sugar Candy House', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Moret Road, Canelar, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.918179001602595,122.06521224870814', 2000.00, 20, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"Paid parking on premises\",\"Air conditioning\",\"Dedicated workspace\"]', '[]', 0, 0, 3, 3, 1, '{\"check_in\":\"22:03\",\"check_out\":\"10:03\"}', 32, 2, 1, '2025-01-31 14:03:53', '2025-02-01 03:10:44'),
(68, 'Salted Sugar Candy House', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Moret Road, Canelar, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.918179001602595,122.06521224870814', 90800.00, 20, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"Paid parking on premises\",\"Air conditioning\",\"Dedicated workspace\"]', '[]', 0, 0, 3, 3, 1, '{\"check_in\":\"22:03\",\"check_out\":\"10:03\"}', 32, 1, 1, '2025-01-31 14:03:55', '2025-02-07 15:40:29'),
(69, 'Cabin in The woods', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Recodo, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.955599891450079,121.9648590066936', 50000.00, 20, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"Paid parking on premises\",\"Air conditioning\",\"Dedicated workspace\"]', '[\"No pets\"]', 0, 0, 3, 1, 0, '{\"check_in\":\"11:02\",\"check_out\":\"23:02\"}', 32, 2, 1, '2025-02-06 03:02:14', '2025-02-06 03:02:30'),
(70, 'Cozy Cove', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Zone Ⅱ, Santa Maria, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.9200535248263515,122.07619857683314', 5000.00, 20, '[\"Kitchen\",\"Dedicated workspace\"]', '[]', 0, 0, 3, 1, 2, '{\"check_in\":\"22:38\",\"check_out\":\"10:38\"}', 35, 2, 1, '2025-02-06 14:38:21', '2025-02-06 14:38:43'),
(71, 'Office Block', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Camino Nuevo, Santa Maria, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.925336232040834,122.0757179244538', 3500.00, 80, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"Paid parking on premises\",\"Air conditioning\",\"Dedicated workspace\"]', '[]', 0, 0, 3, 1, 4, '{\"check_in\":\"12:17\",\"check_out\":\"00:17\"}', 35, 2, 1, '2025-02-07 04:17:46', '2025-02-07 04:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `venue_availability_sub`
--

CREATE TABLE `venue_availability_sub` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue_availability_sub`
--

INSERT INTO `venue_availability_sub` (`id`, `name`) VALUES
(1, 'Available'),
(2, 'Not Available');

-- --------------------------------------------------------

--
-- Table structure for table `venue_images`
--

CREATE TABLE `venue_images` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue_images`
--

INSERT INTO `venue_images` (`id`, `venue_id`, `image_url`, `created_at`) VALUES
(449, 61, '/venue_image_uploads/679277047a91f.jpeg', '2025-01-27 12:34:44'),
(450, 61, '/venue_image_uploads/679277047ae19.jpeg', '2025-01-27 12:34:44'),
(451, 61, '/venue_image_uploads/679277047b18e.jpeg', '2025-01-27 12:34:44'),
(452, 61, '/venue_image_uploads/679277047b43a.jpeg', '2025-01-27 12:34:44'),
(453, 61, '/venue_image_uploads/679277047b6b8.jpeg', '2025-01-27 12:34:44'),
(454, 61, '/venue_image_uploads/679277047f0bf.jpeg', '2025-01-27 12:34:44'),
(455, 61, '/venue_image_uploads/679277047f60a.jpeg', '2025-01-27 12:34:44'),
(456, 61, '/venue_image_uploads/679277047f9a3.jpeg', '2025-01-27 12:34:44'),
(457, 61, '/venue_image_uploads/679277047fce4.jpeg', '2025-01-27 12:34:44'),
(458, 61, '/venue_image_uploads/679277047fffc.jpeg', '2025-01-27 12:34:44'),
(459, 61, '/venue_image_uploads/67927704802c0.jpeg', '2025-01-27 12:34:44'),
(460, 61, '/venue_image_uploads/6792770480558.jpeg', '2025-01-27 12:34:44'),
(461, 61, '/venue_image_uploads/67927704807d1.jpeg', '2025-01-27 12:34:44'),
(462, 61, '/venue_image_uploads/6792770480a3e.jpeg', '2025-01-27 12:34:44'),
(463, 61, '/venue_image_uploads/6792770480dcd.jpeg', '2025-01-27 12:34:44'),
(474, 64, '/venue_image_uploads/679ccec324100.jpg', '2025-01-31 13:23:15'),
(475, 64, '/venue_image_uploads/679ccec324423.jpg', '2025-01-31 13:23:15'),
(476, 64, '/venue_image_uploads/679ccec324702.jpg', '2025-01-31 13:23:15'),
(477, 64, '/venue_image_uploads/679ccec324943.jpg', '2025-01-31 13:23:15'),
(478, 64, '/venue_image_uploads/679ccec324c41.jpg', '2025-01-31 13:23:15'),
(485, 66, '/venue_image_uploads/679cd847a4f86.jpg', '2025-01-31 14:03:51'),
(486, 66, '/venue_image_uploads/679cd847a5124.jpg', '2025-01-31 14:03:51'),
(487, 66, '/venue_image_uploads/679cd847a5247.jpg', '2025-01-31 14:03:51'),
(488, 66, '/venue_image_uploads/679cd847a531a.jpg', '2025-01-31 14:03:51'),
(489, 66, '/venue_image_uploads/679cd847a53e7.jpg', '2025-01-31 14:03:51'),
(490, 67, '/venue_image_uploads/679cd849d20fe.jpg', '2025-01-31 14:03:53'),
(491, 67, '/venue_image_uploads/679cd849d228d.jpg', '2025-01-31 14:03:53'),
(492, 67, '/venue_image_uploads/679cd849d2b63.jpg', '2025-01-31 14:03:53'),
(493, 67, '/venue_image_uploads/679cd849d2c86.jpg', '2025-01-31 14:03:53'),
(494, 67, '/venue_image_uploads/679cd849d2d4f.jpg', '2025-01-31 14:03:53'),
(511, 63, '/venue_image_uploads/679cca27b0ce2.jpg', '2025-02-02 14:29:58'),
(512, 63, '/venue_image_uploads/679cca27b0f5a.jpg', '2025-02-02 14:29:58'),
(513, 63, '/venue_image_uploads/679cca27b1355.jpg', '2025-02-02 14:29:58'),
(514, 63, '/venue_image_uploads/679cca27b15c1.jpg', '2025-02-02 14:29:58'),
(515, 63, '/venue_image_uploads/679cca27b1ab7.jpg', '2025-02-02 14:29:58'),
(516, 65, '/venue_image_uploads/679cd7cea8179.jpg', '2025-02-02 14:49:38'),
(517, 65, '/venue_image_uploads/679cd7cea8457.jpg', '2025-02-02 14:49:38'),
(518, 65, '/venue_image_uploads/679cd7cea8cbf.jpg', '2025-02-02 14:49:38'),
(519, 65, '/venue_image_uploads/679cd7cea8d7c.jpg', '2025-02-02 14:49:38'),
(520, 65, '/venue_image_uploads/679cd7cea8e0a.jpg', '2025-02-02 14:49:38'),
(521, 65, '/venue_image_uploads/679cd7cea8e92.jpg', '2025-02-02 14:49:38'),
(522, 62, '/venue_image_uploads/679cca26172e0.jpg', '2025-02-06 02:50:36'),
(523, 62, '/venue_image_uploads/679cca261765d.jpg', '2025-02-06 02:50:36'),
(524, 62, '/venue_image_uploads/679cca26178a2.jpg', '2025-02-06 02:50:36'),
(525, 62, '/venue_image_uploads/679cca2617e05.jpg', '2025-02-06 02:50:36'),
(526, 62, '/venue_image_uploads/679cca2618328.jpg', '2025-02-06 02:50:36'),
(527, 69, '/venue_image_uploads/67a42636e0404.jpg', '2025-02-06 03:02:14'),
(528, 69, '/venue_image_uploads/67a42636e056a.jpg', '2025-02-06 03:02:14'),
(529, 69, '/venue_image_uploads/67a42636e08f0.jpg', '2025-02-06 03:02:14'),
(530, 69, '/venue_image_uploads/67a42636e09b8.jpg', '2025-02-06 03:02:14'),
(531, 69, '/venue_image_uploads/67a42636e0a59.jpg', '2025-02-06 03:02:14'),
(532, 70, '/venue_image_uploads/67a4c95d99a6f.jpg', '2025-02-06 14:38:21'),
(533, 70, '/venue_image_uploads/67a4c95d99c24.jpg', '2025-02-06 14:38:21'),
(534, 70, '/venue_image_uploads/67a4c95d99d7d.jpg', '2025-02-06 14:38:21'),
(535, 70, '/venue_image_uploads/67a4c95d99e80.jpg', '2025-02-06 14:38:21'),
(536, 70, '/venue_image_uploads/67a4c95d99f83.jpg', '2025-02-06 14:38:21'),
(537, 70, '/venue_image_uploads/67a4c95d9e288.jpg', '2025-02-06 14:38:21'),
(538, 71, '/venue_image_uploads/67a5896a9ccdd.jpg', '2025-02-07 04:17:46'),
(539, 71, '/venue_image_uploads/67a5896a9ce72.jpg', '2025-02-07 04:17:46'),
(540, 71, '/venue_image_uploads/67a5896a9cf5e.jpg', '2025-02-07 04:17:46'),
(541, 71, '/venue_image_uploads/67a5896a9d045.jpg', '2025-02-07 04:17:46'),
(542, 71, '/venue_image_uploads/67a5896a9d157.jpg', '2025-02-07 04:17:46'),
(543, 71, '/venue_image_uploads/67a5896a9d270.jpg', '2025-02-07 04:17:46'),
(544, 68, '/venue_image_uploads/679cd84b025a9.jpg', '2025-02-07 15:40:29'),
(545, 68, '/venue_image_uploads/679cd84b02830.jpg', '2025-02-07 15:40:29'),
(546, 68, '/venue_image_uploads/679cd84b0295b.jpg', '2025-02-07 15:40:29'),
(547, 68, '/venue_image_uploads/679cd84b02a51.jpg', '2025-02-07 15:40:29'),
(548, 68, '/venue_image_uploads/679cd84b02b1a.jpg', '2025-02-07 15:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `venue_status_sub`
--

CREATE TABLE `venue_status_sub` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue_status_sub`
--

INSERT INTO `venue_status_sub` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Approved'),
(3, 'Declined');

-- --------------------------------------------------------

--
-- Table structure for table `venue_tag_sub`
--

CREATE TABLE `venue_tag_sub` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue_tag_sub`
--

INSERT INTO `venue_tag_sub` (`id`, `tag_name`) VALUES
(1, 'Corporate Events'),
(2, 'Reception Hall'),
(3, 'Intimate Gatherings'),
(4, 'Outdoor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_guest_id` (`booking_guest_id`),
  ADD KEY `booking_venue_id` (`booking_venue_id`),
  ADD KEY `booking_status_id` (`booking_status_id`),
  ADD KEY `booking_payment_status_id` (`booking_payment_status_id`),
  ADD KEY `booking_payment_method` (`booking_payment_method`),
  ADD KEY `booking_discount` (`booking_discount`),
  ADD KEY `bookings_ibfk_10` (`booking_down_payment`);

--
-- Indexes for table `bookings_status_sub`
--
ALTER TABLE `bookings_status_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_charges`
--
ALTER TABLE `booking_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_booking_id` (`booking_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `venueId` (`venueId`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discount_code` (`discount_code`),
  ADD KEY `venue_id` (`venue_id`);

--
-- Indexes for table `downpayment_sub`
--
ALTER TABLE `downpayment_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `host_application`
--
ALTER TABLE `host_application`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`userId`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `host_application_status_sub`
--
ALTER TABLE `host_application_status_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `host_id_images`
--
ALTER TABLE `host_id_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `host_reviews`
--
ALTER TABLE `host_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_host_reviews_user_id` (`user_id`),
  ADD KEY `fk_host_reviews_host_id` (`host_id`);

--
-- Indexes for table `mandatory_discount`
--
ALTER TABLE `mandatory_discount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`userId`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `message_status`
--
ALTER TABLE `message_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_message_user` (`message_id`,`user_id`),
  ADD KEY `idx_message_user` (`message_id`,`user_id`),
  ADD KEY `idx_user_read` (`user_id`,`is_read`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_notification_type` (`user_id`,`notification_type_id`),
  ADD KEY `notification_type_id` (`notification_type_id`);

--
-- Indexes for table `notification_types`
--
ALTER TABLE `notification_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_method_sub`
--
ALTER TABLE `payment_method_sub`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_payment_method_name` (`payment_method_name`);

--
-- Indexes for table `payment_status_sub`
--
ALTER TABLE `payment_status_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reviews_user_id` (`user_id`),
  ADD KEY `fk_reviews_venue_id` (`venue_id`);

--
-- Indexes for table `sex_sub`
--
ALTER TABLE `sex_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_sex_id` (`sex_id`),
  ADD KEY `fk_user_type_id` (`user_type_id`);

--
-- Indexes for table `user_types_sub`
--
ALTER TABLE `user_types_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_availability_id` (`availability_id`),
  ADD KEY `fk_status_id` (`status_id`),
  ADD KEY `fk_host_id` (`host_id`),
  ADD KEY `fk_venue_tag_id` (`venue_tag`),
  ADD KEY `fk_dp_id` (`down_payment_id`);

--
-- Indexes for table `venue_availability_sub`
--
ALTER TABLE `venue_availability_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venue_images`
--
ALTER TABLE `venue_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_venue_id` (`venue_id`);

--
-- Indexes for table `venue_status_sub`
--
ALTER TABLE `venue_status_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venue_tag_sub`
--
ALTER TABLE `venue_tag_sub`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `booking_charges`
--
ALTER TABLE `booking_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `downpayment_sub`
--
ALTER TABLE `downpayment_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `host_application`
--
ALTER TABLE `host_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `host_application_status_sub`
--
ALTER TABLE `host_application_status_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `host_reviews`
--
ALTER TABLE `host_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mandatory_discount`
--
ALTER TABLE `mandatory_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=536;

--
-- AUTO_INCREMENT for table `message_status`
--
ALTER TABLE `message_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=989;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_method_sub`
--
ALTER TABLE `payment_method_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_status_sub`
--
ALTER TABLE `payment_status_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sex_sub`
--
ALTER TABLE `sex_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_types_sub`
--
ALTER TABLE `user_types_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `venue_availability_sub`
--
ALTER TABLE `venue_availability_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venue_images`
--
ALTER TABLE `venue_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=549;

--
-- AUTO_INCREMENT for table `venue_status_sub`
--
ALTER TABLE `venue_status_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venue_tag_sub`
--
ALTER TABLE `venue_tag_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`booking_guest_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_10` FOREIGN KEY (`booking_down_payment`) REFERENCES `downpayment_sub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`booking_venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`booking_status_id`) REFERENCES `bookings_status_sub` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_ibfk_6` FOREIGN KEY (`booking_payment_status_id`) REFERENCES `payment_status_sub` (`id`),
  ADD CONSTRAINT `bookings_ibfk_8` FOREIGN KEY (`booking_payment_method`) REFERENCES `payment_method_sub` (`payment_method_name`),
  ADD CONSTRAINT `bookings_ibfk_9` FOREIGN KEY (`booking_discount`) REFERENCES `discounts` (`discount_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking_charges`
--
ALTER TABLE `booking_charges`
  ADD CONSTRAINT `fk_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`venueId`) REFERENCES `venues` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD CONSTRAINT `conversation_participants_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversation_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `host_application`
--
ALTER TABLE `host_application`
  ADD CONSTRAINT `host_application_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `host_application_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `host_application_status_sub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `host_id_images`
--
ALTER TABLE `host_id_images`
  ADD CONSTRAINT `host_id_images_ibfk_1` FOREIGN KEY (`id`) REFERENCES `host_application` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `host_reviews`
--
ALTER TABLE `host_reviews`
  ADD CONSTRAINT `fk_host_reviews_host_id` FOREIGN KEY (`host_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_host_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `mandatory_discount`
--
ALTER TABLE `mandatory_discount`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_status`
--
ALTER TABLE `message_status`
  ADD CONSTRAINT `message_status_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_status_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD CONSTRAINT `fk_notification_settings_type` FOREIGN KEY (`notification_type_id`) REFERENCES `notification_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_notification_settings_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reviews_venue_id` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_sex_id` FOREIGN KEY (`sex_id`) REFERENCES `sex_sub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_type_id` FOREIGN KEY (`user_type_id`) REFERENCES `user_types_sub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `venues`
--
ALTER TABLE `venues`
  ADD CONSTRAINT `fk_availability_id` FOREIGN KEY (`availability_id`) REFERENCES `venue_availability_sub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dp_id` FOREIGN KEY (`down_payment_id`) REFERENCES `downpayment_sub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_host_id` FOREIGN KEY (`host_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_status_id` FOREIGN KEY (`status_id`) REFERENCES `venue_status_sub` (`id`),
  ADD CONSTRAINT `fk_venue_tag_id` FOREIGN KEY (`venue_tag`) REFERENCES `venue_tag_sub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `venue_images`
--
ALTER TABLE `venue_images`
  ADD CONSTRAINT `fk_venue_id` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
