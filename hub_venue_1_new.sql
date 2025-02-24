-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2025 at 09:42 AM
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
-- Database: `hub_venue_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_start_date` date DEFAULT NULL,
  `booking_end_date` date DEFAULT NULL,
  `booking_participants` int(11) DEFAULT NULL,
  `booking_venue_price` decimal(10,2) DEFAULT NULL,
  `booking_entrance` decimal(10,2) DEFAULT NULL,
  `booking_cleaning` decimal(10,2) DEFAULT NULL,
  `booking_service_fee` decimal(10,2) DEFAULT NULL,
  `booking_duration` int(11) DEFAULT NULL,
  `booking_grand_total` decimal(10,2) DEFAULT NULL,
  `booking_dp_amount` decimal(10,2) DEFAULT NULL,
  `booking_balance` decimal(10,2) DEFAULT NULL,
  `booking_dp_id` int(11) DEFAULT NULL,
  `booking_coupon_id` int(11) DEFAULT NULL,
  `booking_discount_id` int(11) DEFAULT NULL,
  `booking_status_id` int(11) DEFAULT NULL,
  `booking_guest_id` int(11) DEFAULT NULL,
  `booking_venue_id` int(11) DEFAULT NULL,
  `booking_payment_method` int(11) DEFAULT NULL,
  `booking_payment_reference` varchar(255) DEFAULT NULL,
  `booking_payment_status_id` int(11) DEFAULT NULL,
  `booking_request` text DEFAULT NULL,
  `booking_cancellation_reason` text DEFAULT NULL,
  `booking_checkin_link` text NOT NULL,
  `booking_checkout_link` text NOT NULL,
  `booking_checkin_status` enum('Pending','Checked-In','No-Show') NOT NULL DEFAULT 'Pending',
  `booking_checkout_status` enum('Pending','Checked-Out') NOT NULL DEFAULT 'Pending',
  `booking_checkin_date` date NOT NULL,
  `booking_checkout_date` date NOT NULL,
  `booking_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_start_date`, `booking_end_date`, `booking_participants`, `booking_venue_price`, `booking_entrance`, `booking_cleaning`, `booking_service_fee`, `booking_duration`, `booking_grand_total`, `booking_dp_amount`, `booking_balance`, `booking_dp_id`, `booking_coupon_id`, `booking_discount_id`, `booking_status_id`, `booking_guest_id`, `booking_venue_id`, `booking_payment_method`, `booking_payment_reference`, `booking_payment_status_id`, `booking_request`, `booking_cancellation_reason`, `booking_checkin_link`, `booking_checkout_link`, `booking_checkin_status`, `booking_checkout_status`, `booking_checkin_date`, `booking_checkout_date`, `booking_created_at`, `booking_updated_at`) VALUES
(23, '2025-02-19', '2025-02-21', 200, 4800.00, 0.00, 1000.00, 1590.00, 2, 12190.00, 6095.00, 0.00, 3, 3, 7, 1, 31, 77, 1, 'asdasdas', 2, 'asdasdasdasdasd', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=23', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=23', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-18 08:07:15', '2025-02-19 18:03:56'),
(24, '2025-02-23', '2025-02-24', 200, 4800.00, 0.00, 500.00, 795.00, 1, 6095.00, 4266.50, 0.00, 3, 1, 7, 2, 31, 77, 1, 'asdasdas', 2, 'SAVE', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=24', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=24', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-18 10:07:08', '2025-02-18 10:08:36'),
(25, '2025-03-01', '2025-03-03', 150, 16000.00, 0.00, 1000.00, 2550.00, 2, 19550.00, 19550.00, 0.00, 3, NULL, NULL, 2, 42, 79, 1, 'GC123456789', 2, 'Corporate Event', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=25', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=25', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-18 07:00:00', '2025-02-18 07:00:00'),
(26, '2025-03-05', '2025-03-06', 100, 8900.00, 0.00, 700.00, 1440.00, 1, 11040.00, 5520.00, 5520.00, 2, 1, NULL, 2, 43, 80, 2, 'PM987654321', 2, 'Wedding Reception', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=26', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=26', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-18 08:00:00', '2025-02-18 08:00:00'),
(27, '2025-03-10', '2025-03-11', 200, 4800.00, 0.00, 500.00, 795.00, 1, 6095.00, 3047.50, 3047.50, 2, NULL, NULL, 3, 42, 77, 1, 'GC456789123', 2, 'Birthday Party', 'Change of plans', 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=27', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=27', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-18 09:00:00', '2025-02-18 09:00:00'),
(28, '2025-02-18', '2025-02-19', 150, 18500.00, 0.00, 500.00, 2850.00, 1, 21850.00, 21850.00, 0.00, 3, NULL, NULL, 2, 43, 78, 1, 'GC789123456', 2, 'Corporate Training', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=28', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=28', 'Checked-In', 'Pending', '2025-02-18', '0000-00-00', '2025-02-18 10:00:00', '2025-02-18 10:00:00'),
(29, '2025-02-17', '2025-02-18', 100, 8900.00, 0.00, 700.00, 1440.00, 1, 11040.00, 11040.00, 0.00, 3, NULL, NULL, 4, 42, 80, 2, 'PM321654987', 2, 'Team Building', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=29', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=29', 'Checked-In', 'Checked-Out', '2025-02-17', '2025-02-18', '2025-02-18 11:00:00', '2025-02-18 11:00:00'),
(30, '2025-02-16', '2025-02-17', 200, 4800.00, 0.00, 1000.00, 870.00, 1, 6670.00, 3335.00, 3335.00, 2, NULL, NULL, 2, 43, 77, 1, 'GC147258369', 2, 'Anniversary Party', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=30', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=30', 'No-Show', 'Pending', '2025-02-16', '0000-00-00', '2025-02-18 12:00:00', '2025-02-18 12:00:00'),
(31, '2025-03-15', '2025-03-16', 150, 18500.00, 0.00, 500.00, 2850.00, 1, 21850.00, 21850.00, 0.00, 3, NULL, NULL, 3, 42, 78, 1, 'GC789456123', 2, 'Corporate Training Event with Lunch Setup', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=31', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=31', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-19 17:58:35', '2025-02-19 18:02:00'),
(40, '2025-02-20', '2025-02-21', 200, 16000.00, 0.00, 1000.00, 2550.00, 1, 19550.00, 19550.00, 0.00, 3, 4, NULL, 1, 48, 79, 1, 'asd2', 1, '', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=40', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=40', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-20 11:25:53', '2025-02-20 11:25:53'),
(41, '2025-02-20', '2025-02-22', 20, 5000.00, 0.00, 0.00, 1500.00, 2, 11500.00, 10350.00, 0.00, 3, 1, NULL, 1, 48, 81, 1, 'ASD12', 1, '', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=41', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=41', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-20 11:27:24', '2025-02-20 11:27:24'),
(46, '2025-02-25', '2025-02-27', 20, 5000.00, 0.00, 0.00, 1500.00, 2, 11500.00, 11500.00, 0.00, 3, 4, NULL, 2, 49, 81, 2, 'asd12', 2, '', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=46', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=46', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-21 13:29:20', '2025-02-21 13:45:41'),
(47, '2025-03-07', '2025-03-10', 20, 5000.00, 0.00, 0.00, 2250.00, 3, 17250.00, 17250.00, 0.00, 3, 4, NULL, 2, 49, 81, 1, 'asd21', 2, '', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=47', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=47', 'Checked-In', 'Pending', '0000-00-00', '0000-00-00', '2025-02-21 13:51:12', '2025-02-21 15:18:12'),
(48, '2025-03-11', '2025-03-13', 20, 5000.00, 0.00, 0.00, 1500.00, 2, 11500.00, 11500.00, 0.00, 3, 4, NULL, 1, 49, 81, 2, 'asd12', 1, '', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=48', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=48', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-21 15:29:25', '2025-02-21 15:29:25'),
(49, '2025-02-21', '2025-02-22', 150, 18500.00, 0.00, 500.00, 2850.00, 1, 21850.00, 21850.00, 0.00, 3, 4, NULL, 2, 49, 78, 1, 'asd21', 2, '', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=49', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=49', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-21 15:29:48', '2025-02-21 15:30:26'),
(50, '2025-03-14', '2025-03-15', 20, 5000.00, 0.00, 0.00, 750.00, 1, 5750.00, 5750.00, 0.00, 3, 1, NULL, 2, 50, 81, 2, 'asd12', 2, '', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=50', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=50', 'Checked-In', 'Checked-Out', '0000-00-00', '0000-00-00', '2025-02-21 15:51:17', '2025-02-21 15:53:41'),
(51, '2025-03-16', '2025-03-17', 20, 5000.00, 0.00, 0.00, 750.00, 1, 5750.00, 5750.00, 0.00, 3, 4, NULL, 2, 50, 81, 1, 'asd21', 2, '', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=51', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=51', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-21 15:54:22', '2025-02-21 15:54:40'),
(52, '2025-03-18', '2025-03-19', 20, 5000.00, 0.00, 0.00, 750.00, 1, 5750.00, 5750.00, 0.00, 3, 4, NULL, 2, 51, 81, 1, 'asdas12', 2, '', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=52', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=52', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-21 16:21:20', '2025-02-21 16:21:41');

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
(143, 31, 77, '2025-02-16 07:07:28', '2025-02-16 07:07:28'),
(144, 31, 78, '2025-02-18 12:45:14', '2025-02-18 12:45:14'),
(145, 31, 79, '2025-02-18 12:45:15', '2025-02-18 12:45:15');

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
(34, 49, 'booking', NULL, '2025-02-21 15:30:28'),
(35, 47, 'booking', NULL, '2025-02-21 15:30:29'),
(36, 51, 'booking', NULL, '2025-02-21 15:59:21'),
(37, 52, 'booking', NULL, '2025-02-21 16:21:44');

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
(67, 34, 31, 'member'),
(68, 34, 49, 'member'),
(69, 35, 48, 'member'),
(70, 35, 49, 'member'),
(71, 36, 48, 'member'),
(72, 36, 50, 'member'),
(73, 37, 48, 'member'),
(74, 37, 51, 'member');

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
  `expiration_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `min_days` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `venue_id`, `discount_code`, `discount_type`, `discount_value`, `expiration_date`, `created_at`, `updated_at`, `min_days`) VALUES
(1, NULL, 'SAVE10', 'percentage', 10.00, '2025-12-31', '2025-01-24 02:07:46', '2025-02-17 17:17:21', 1),
(2, NULL, 'SAVE20', 'percentage', 20.00, '2024-12-25', '2025-01-24 02:07:46', '2025-01-24 02:07:46', 1),
(3, NULL, 'SAVE30', 'percentage', 30.00, '2025-12-31', '2025-01-24 02:07:46', '2025-02-17 18:42:50', 1),
(4, NULL, 'none', 'percentage', 0.00, NULL, '2025-01-24 02:07:46', '2025-01-24 02:07:46', 1),
(5, 77, 'Marcian', 'percentage', 20.00, '2025-02-28', '2025-02-16 14:16:02', '2025-02-16 14:16:02', 1);

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
(14, 48, 'Jjohn, Rei O.', 'Galvez Drive, Camino Nuevo, Santa Maria, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '2004-02-19', 2, '2025-02-19 11:44:37', '2025-02-19 11:46:50');

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
(14, 'UMID Card', '/host_id_image/67b5c425a4d2a.jpg', 'National ID', '/host_id_image/67b5c425a55bf.jpg', '2025-02-19 11:44:37');

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
(7, 31, 'PWD', 'Joevin Ansoc', '54545sf', '/mandatory_discount_id/67b0544e5e885.jpg', 'Active', '2025-02-15 08:46:06', '2025-02-15 08:46:27', 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `type` varchar(50) DEFAULT 'text' COMMENT 'Types: text, image, file, etc.',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply_to_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `content`, `type`, `created_at`, `reply_to_id`) VALUES
(536, 35, 49, 'aasd', 'text', '2025-02-21 15:34:45', NULL),
(537, 36, 50, 'c2', 'text', '2025-02-21 16:00:23', NULL),
(538, 35, 48, 'asdasd', 'text', '2025-02-21 16:13:47', NULL),
(539, 35, 48, 'asdas', 'text', '2025-02-21 16:13:54', NULL),
(540, 37, 51, 'Hi sir, aq pala nag book para match 18 birthday kasi ng anak q :>', 'text', '2025-02-21 16:22:06', NULL),
(541, 37, 48, 'Omkiii salamuchh pu', 'text', '2025-02-21 16:22:46', NULL),
(542, 37, 48, 'Hello sir, cancel ko po sana booking mo', 'text', '2025-02-22 07:30:59', NULL),
(543, 37, 48, 'Hello sir, cancel ko po sana booking mo', 'text', '2025-02-22 07:30:59', NULL),
(544, 37, 48, 'Hello sir, cancel ko po sana booking mo', 'text', '2025-02-22 07:30:59', NULL),
(545, 37, 48, 'Hello sir, cancel ko po sana booking mo', 'text', '2025-02-22 07:31:06', NULL),
(546, 37, 48, 'sirrr', 'text', '2025-02-22 07:31:24', NULL),
(547, 37, 48, 'as', 'text', '2025-02-22 08:04:04', NULL),
(548, 37, 48, 'asd', 'text', '2025-02-22 08:32:32', NULL),
(549, 36, 48, 'Seen', 'text', '2025-02-22 08:32:38', NULL),
(550, 35, 48, 'Seen', 'text', '2025-02-22 08:32:43', NULL),
(551, 36, 48, 'Hell o', 'text', '2025-02-22 08:34:59', NULL),
(552, 37, 48, 'asd', 'text', '2025-02-22 08:35:05', NULL),
(553, 35, 48, 'Hello', 'text', '2025-02-22 08:35:40', NULL),
(554, 35, 48, 'aasd', 'text', '2025-02-22 08:35:53', NULL),
(555, 35, 49, 'asd', 'text', '2025-02-22 08:36:05', NULL),
(556, 35, 48, 'asdas', 'text', '2025-02-22 08:36:14', NULL),
(557, 35, 48, 'asd', 'text', '2025-02-22 08:36:18', NULL),
(558, 36, 48, 'asdas', 'text', '2025-02-22 08:37:59', NULL),
(559, 35, 48, 'asdas', 'text', '2025-02-22 08:38:04', NULL),
(560, 35, 49, 'asdsa', 'text', '2025-02-22 08:40:11', NULL),
(561, 35, 49, 'asdas', 'text', '2025-02-22 08:40:17', NULL),
(562, 35, 49, 'asdas', 'text', '2025-02-22 08:40:20', NULL),
(563, 35, 49, 'asdasd', 'text', '2025-02-22 08:40:22', NULL),
(564, 35, 48, 'asda', 'text', '2025-02-22 08:43:35', NULL),
(565, 35, 49, 'sent', 'text', '2025-02-22 08:48:55', NULL),
(566, 35, 48, 'asdas', 'text', '2025-02-22 08:49:16', NULL),
(567, 35, 48, 'asdasknas', 'text', '2025-02-22 08:49:52', NULL),
(568, 35, 48, 'sda', 'text', '2025-02-22 08:49:52', NULL),
(569, 35, 48, 'ads', 'text', '2025-02-22 08:49:52', NULL),
(570, 35, 48, 'asd', 'text', '2025-02-22 08:49:52', NULL),
(571, 35, 48, 'adadsas', 'text', '2025-02-22 08:49:53', NULL),
(572, 35, 48, 'as', 'text', '2025-02-22 08:49:53', NULL),
(573, 35, 48, 'da', 'text', '2025-02-22 08:49:53', NULL),
(574, 35, 48, 's', 'text', '2025-02-22 08:49:53', NULL),
(575, 35, 48, 'ads', 'text', '2025-02-22 08:49:54', NULL),
(576, 35, 48, 'sa', 'text', '2025-02-22 08:49:54', NULL),
(577, 35, 48, 'a', 'text', '2025-02-22 08:49:54', NULL),
(578, 35, 48, 'ds', 'text', '2025-02-22 08:49:54', NULL),
(579, 35, 48, 'dsa', 'text', '2025-02-22 08:49:54', NULL),
(580, 35, 48, 's', 'text', '2025-02-22 08:49:54', NULL),
(581, 35, 48, 'aasdas', 'text', '2025-02-22 08:49:59', NULL),
(582, 35, 48, 'asdas', 'text', '2025-02-22 08:50:03', NULL),
(583, 35, 48, 'ads3', 'text', '2025-02-22 08:52:31', NULL),
(584, 35, 48, 'asd', 'text', '2025-02-22 08:52:37', NULL),
(585, 35, 48, 'asd', 'text', '2025-02-22 08:52:41', NULL),
(586, 35, 48, 'New', 'text', '2025-02-22 08:52:51', NULL),
(587, 35, 48, 'New new', 'text', '2025-02-22 08:52:58', NULL),
(588, 35, 48, 'no new', 'text', '2025-02-22 08:53:06', NULL),
(589, 35, 49, 'asd', 'text', '2025-02-22 08:55:02', NULL),
(590, 35, 49, 'asdas', 'text', '2025-02-22 08:55:04', NULL),
(591, 35, 49, 'asd', 'text', '2025-02-22 08:55:06', NULL),
(592, 35, 48, 'asdas', 'text', '2025-02-22 08:55:13', NULL),
(593, 35, 49, 'asdas', 'text', '2025-02-22 08:55:27', NULL),
(594, 35, 49, 'asdasdas', 'text', '2025-02-22 08:55:55', NULL),
(595, 35, 49, 'asd', 'text', '2025-02-22 08:58:00', NULL),
(596, 35, 49, 'asdasd', 'text', '2025-02-22 08:58:02', NULL),
(597, 35, 48, 'asdas', 'text', '2025-02-22 08:58:19', NULL),
(598, 35, 49, 'asdas', 'text', '2025-02-22 09:09:08', NULL),
(599, 35, 49, 'asdasd', 'text', '2025-02-22 09:09:22', NULL),
(600, 35, 48, 'asdasd', 'text', '2025-02-22 09:09:33', NULL),
(601, 35, 48, 'asda', 'text', '2025-02-22 09:09:35', NULL),
(602, 35, 49, 'asdas+', 'text', '2025-02-22 09:11:53', NULL),
(603, 35, 49, 'asdas', 'text', '2025-02-22 09:12:06', NULL),
(604, 35, 49, 'asdas', 'text', '2025-02-22 09:12:08', NULL),
(605, 35, 49, 'asdas', 'text', '2025-02-22 09:14:08', NULL),
(606, 35, 49, 'asd', 'text', '2025-02-22 09:14:13', NULL),
(607, 35, 49, 'asdasd', 'text', '2025-02-22 09:14:18', NULL),
(608, 35, 48, 'asdas', 'text', '2025-02-22 09:14:39', NULL),
(609, 35, 49, 'asdas', 'text', '2025-02-22 09:14:46', NULL),
(610, 35, 48, 'asdas', 'text', '2025-02-22 09:14:50', NULL),
(611, 35, 48, 'asdas', 'text', '2025-02-22 09:14:53', NULL),
(612, 35, 49, 'asda', 'text', '2025-02-22 09:17:53', NULL),
(613, 35, 49, 'asda', 'text', '2025-02-22 09:18:22', NULL),
(614, 35, 48, 'asda', 'text', '2025-02-22 09:18:31', NULL),
(615, 35, 48, 'asdas', 'text', '2025-02-22 09:18:34', NULL),
(616, 35, 48, 'asdas', 'text', '2025-02-22 09:20:37', NULL),
(617, 35, 48, 'asdas', 'text', '2025-02-22 09:20:41', NULL),
(618, 35, 49, 'asda', 'text', '2025-02-22 09:22:59', NULL),
(619, 35, 49, 'assada', 'text', '2025-02-22 09:23:05', NULL),
(620, 35, 49, 'asdas', 'text', '2025-02-22 09:23:06', NULL),
(621, 35, 49, 'helo', 'text', '2025-02-22 09:25:55', NULL),
(622, 35, 49, 'as', 'text', '2025-02-22 09:29:11', NULL),
(623, 35, 49, 'asdas', 'text', '2025-02-22 09:29:17', NULL),
(624, 35, 48, 'asdas', 'text', '2025-02-22 09:31:13', NULL),
(625, 35, 49, 'asdas', 'text', '2025-02-22 09:31:24', NULL),
(626, 35, 49, 'asdas', 'text', '2025-02-22 09:31:37', NULL),
(627, 35, 49, 'sadas', 'text', '2025-02-22 09:31:38', NULL),
(628, 35, 49, 'asdas', 'text', '2025-02-22 09:31:41', NULL),
(629, 35, 48, 'asdas', 'text', '2025-02-22 09:31:55', NULL),
(630, 35, 49, 'Hello?', 'text', '2025-02-22 11:53:01', NULL),
(631, 35, 49, 'asd', 'text', '2025-02-22 11:59:40', NULL),
(632, 35, 49, 'asdas', 'text', '2025-02-22 11:59:50', NULL),
(633, 35, 49, 'asdas', 'text', '2025-02-22 11:59:55', NULL),
(634, 35, 49, 'asdas', 'text', '2025-02-22 12:01:22', NULL),
(635, 35, 48, 'asda', 'text', '2025-02-22 12:01:31', NULL),
(636, 35, 49, 'asdas', 'text', '2025-02-22 12:03:05', NULL),
(637, 35, 48, 'asdas', 'text', '2025-02-22 12:03:11', NULL),
(638, 35, 48, 'asdas', 'text', '2025-02-22 12:03:14', NULL),
(639, 35, 49, 'asda', 'text', '2025-02-22 12:04:47', NULL),
(640, 35, 49, 'asdas', 'text', '2025-02-22 12:06:56', NULL),
(641, 35, 49, 'adas', 'text', '2025-02-22 12:09:33', NULL),
(642, 35, 49, 'asdas', 'text', '2025-02-22 12:09:46', NULL),
(643, 35, 49, 'asdas', 'text', '2025-02-22 12:09:49', NULL),
(644, 35, 49, 'asdas', 'text', '2025-02-22 12:09:52', NULL),
(645, 35, 49, 'asasd', 'text', '2025-02-22 12:11:54', NULL),
(646, 35, 49, 'sadas', 'text', '2025-02-22 12:12:25', NULL),
(647, 35, 49, 'asda', 'text', '2025-02-22 12:14:45', NULL),
(648, 35, 49, 'asda', 'text', '2025-02-22 12:14:56', NULL),
(649, 35, 49, 'asdasd', 'text', '2025-02-22 12:15:07', NULL),
(650, 35, 49, 'asdas', 'text', '2025-02-22 12:15:09', NULL),
(651, 35, 49, 'asdas', 'text', '2025-02-22 12:15:11', NULL),
(652, 35, 49, 'asda', 'text', '2025-02-22 12:15:12', NULL),
(653, 35, 49, 'asdas', 'text', '2025-02-22 12:15:13', NULL),
(654, 35, 49, 'asda', 'text', '2025-02-22 12:15:13', NULL),
(655, 35, 49, 'asd', 'text', '2025-02-22 12:15:14', NULL),
(656, 35, 49, 'asdas', 'text', '2025-02-22 12:15:21', NULL),
(657, 35, 49, 'asd', 'text', '2025-02-22 12:15:26', NULL),
(658, 35, 49, 'asdas', 'text', '2025-02-22 12:17:47', NULL),
(659, 35, 49, 'asdasd', 'text', '2025-02-22 12:17:53', NULL),
(660, 35, 49, 'asdasd', 'text', '2025-02-22 12:18:00', NULL),
(661, 35, 49, 'asdas', 'text', '2025-02-22 12:19:51', NULL),
(662, 35, 49, 'asdas', 'text', '2025-02-22 12:19:53', NULL),
(663, 35, 49, 'asdasd', 'text', '2025-02-22 12:20:01', NULL),
(664, 35, 49, 'asdasd', 'text', '2025-02-22 12:20:02', NULL),
(665, 35, 49, 'asdasasgasg', 'text', '2025-02-22 12:20:04', NULL),
(666, 35, 49, 'asdas', 'text', '2025-02-22 12:20:23', NULL),
(667, 35, 48, 'asdasd', 'text', '2025-02-22 12:21:03', NULL),
(668, 35, 49, 'asdsa', 'text', '2025-02-22 12:21:29', NULL),
(669, 35, 49, 'asda', 'text', '2025-02-22 12:21:32', NULL),
(670, 35, 49, 'asdas', 'text', '2025-02-22 12:21:37', NULL),
(671, 35, 49, 'asdasdas', 'text', '2025-02-22 12:21:41', NULL),
(672, 35, 49, 'asdas', 'text', '2025-02-22 12:21:48', NULL),
(673, 35, 49, 'asdas', 'text', '2025-02-22 12:22:16', NULL),
(674, 35, 49, 'asdas', 'text', '2025-02-22 12:22:19', NULL),
(675, 35, 49, 'sdfsdfs', 'text', '2025-02-22 12:22:23', NULL),
(676, 35, 49, 'adas', 'text', '2025-02-22 12:22:40', NULL),
(677, 35, 49, 'asdasd', 'text', '2025-02-22 12:22:46', NULL),
(678, 35, 49, 'agaga', 'text', '2025-02-22 12:22:48', NULL),
(679, 35, 48, 'das', 'text', '2025-02-22 12:25:46', NULL),
(680, 35, 49, 'asdasd', 'text', '2025-02-22 12:27:52', NULL),
(681, 35, 49, 'asdasda', 'text', '2025-02-22 12:28:30', NULL),
(682, 35, 48, 'asdas', 'text', '2025-02-22 12:34:05', NULL),
(683, 35, 48, 'sda', 'text', '2025-02-22 12:34:13', NULL),
(684, 35, 48, 'asdasdsada', 'text', '2025-02-22 12:34:15', NULL),
(685, 36, 48, 'asd', 'text', '2025-02-22 12:34:23', NULL),
(686, 35, 48, 'das', 'text', '2025-02-22 12:34:33', NULL),
(687, 35, 48, 'adasda', 'text', '2025-02-22 12:34:47', NULL),
(688, 35, 48, 'asdasd', 'text', '2025-02-22 12:34:52', NULL),
(689, 35, 49, 'asdas', 'text', '2025-02-22 12:35:03', NULL),
(690, 35, 49, 'asdasd', 'text', '2025-02-22 12:36:21', NULL),
(691, 35, 48, 'asdasdas', 'text', '2025-02-22 12:36:29', NULL),
(692, 35, 49, 'asdasdasdasd', 'text', '2025-02-22 12:36:53', NULL),
(693, 35, 49, 'asdasdas', 'text', '2025-02-22 12:38:15', NULL),
(694, 35, 49, 'asdasd', 'text', '2025-02-22 12:38:22', NULL),
(695, 35, 49, 'asdasd', 'text', '2025-02-22 12:38:23', NULL),
(696, 35, 49, 'asdasdas', 'text', '2025-02-22 12:38:39', NULL),
(697, 35, 49, 'asdasd', 'text', '2025-02-22 12:38:41', NULL),
(698, 35, 49, 'asdasadss', 'text', '2025-02-22 12:40:38', NULL),
(699, 35, 49, 'asdasda', 'text', '2025-02-22 12:40:39', NULL),
(700, 35, 48, 'dassad', 'text', '2025-02-22 12:40:45', NULL),
(701, 34, 49, 'asdasds', 'text', '2025-02-22 12:40:48', NULL),
(702, 34, 49, 'asdasd', 'text', '2025-02-22 12:40:49', NULL),
(703, 34, 49, 'asdas', 'text', '2025-02-22 12:40:50', NULL),
(704, 34, 49, 'asdasdas', 'text', '2025-02-22 12:40:55', NULL),
(705, 34, 49, 'asdasda', 'text', '2025-02-22 12:40:56', NULL),
(706, 34, 49, 'afssf', 'text', '2025-02-22 12:40:57', NULL),
(707, 34, 49, 'asf', 'text', '2025-02-22 12:40:57', NULL),
(708, 34, 49, 'asg', 'text', '2025-02-22 12:40:58', NULL),
(709, 34, 49, 's', 'text', '2025-02-22 12:40:58', NULL),
(710, 34, 49, 'adsdasd', 'text', '2025-02-22 12:41:02', NULL),
(711, 35, 49, 'asdasd', 'text', '2025-02-22 12:41:16', NULL),
(712, 35, 49, 'asdasda', 'text', '2025-02-22 12:41:28', NULL),
(713, 35, 49, 'asdasda', 'text', '2025-02-22 12:41:33', NULL),
(714, 35, 48, 'daasdasda', 'text', '2025-02-22 12:44:29', NULL),
(715, 35, 49, 'asdads', 'text', '2025-02-22 12:46:20', NULL),
(716, 35, 49, 'asdasd', 'text', '2025-02-22 12:46:25', NULL),
(717, 35, 49, 'asdaasgas', 'text', '2025-02-22 12:46:29', NULL),
(718, 35, 49, 'omasmasoidmoasi', 'text', '2025-02-22 12:46:32', NULL),
(719, 35, 49, 'asdasd', 'text', '2025-02-22 12:48:31', NULL),
(720, 35, 48, 'asdasdas', 'text', '2025-02-22 12:48:37', NULL),
(721, 35, 49, 'asdasd', 'text', '2025-02-22 12:48:39', NULL),
(722, 35, 49, 'asdas', 'text', '2025-02-22 12:48:40', NULL),
(723, 35, 48, 'asdas', 'text', '2025-02-22 12:48:41', NULL),
(724, 35, 48, 'asdas', 'text', '2025-02-22 12:48:56', NULL),
(725, 35, 49, 'asdasd', 'text', '2025-02-22 12:50:42', NULL),
(726, 35, 49, 'asdasd', 'text', '2025-02-22 12:50:49', NULL),
(727, 35, 49, 'asdasd', 'text', '2025-02-22 12:50:50', NULL),
(728, 35, 49, 'asdasd', 'text', '2025-02-22 12:51:05', NULL),
(729, 35, 49, 'asdasd', 'text', '2025-02-22 12:53:58', NULL),
(730, 35, 49, 'asdas', 'text', '2025-02-22 12:54:29', NULL),
(731, 35, 48, 'asdasdas', 'text', '2025-02-22 12:54:46', NULL),
(732, 35, 49, 'asdas', 'text', '2025-02-22 12:56:19', NULL),
(733, 35, 49, 'asdasd', 'text', '2025-02-22 12:56:23', NULL),
(734, 35, 49, 'asdas', 'text', '2025-02-22 12:56:32', NULL),
(735, 35, 49, 'asdas', 'text', '2025-02-22 12:57:05', NULL),
(736, 35, 49, 'asdas', 'text', '2025-02-22 12:57:57', NULL),
(737, 35, 49, 'asdas', 'text', '2025-02-22 13:00:45', NULL),
(738, 35, 49, 'asdas', 'text', '2025-02-22 13:01:37', NULL),
(739, 35, 49, 'asdasd', 'text', '2025-02-22 13:01:43', NULL),
(740, 35, 49, 'asdas', 'text', '2025-02-22 13:06:41', NULL),
(741, 35, 49, 'asdas', 'text', '2025-02-22 13:06:52', NULL),
(742, 35, 49, 'asdasd', 'text', '2025-02-22 13:07:07', NULL),
(743, 35, 48, 'asdas', 'text', '2025-02-22 13:09:51', NULL),
(744, 35, 49, 'asdas', 'text', '2025-02-22 13:11:54', NULL),
(745, 35, 49, 'asdasd', 'text', '2025-02-22 13:12:19', NULL),
(746, 35, 49, 'asdas', 'text', '2025-02-22 13:14:39', NULL),
(747, 35, 49, 'asdas', 'text', '2025-02-22 13:14:42', NULL),
(748, 35, 49, 'asdas', 'text', '2025-02-22 13:16:41', NULL),
(749, 35, 49, 'asdas', 'text', '2025-02-22 13:18:33', NULL),
(750, 35, 49, 'asdas', 'text', '2025-02-22 13:21:36', NULL),
(751, 35, 49, 'asdas.', 'text', '2025-02-22 13:23:49', NULL),
(752, 35, 49, 'asdas', 'text', '2025-02-22 13:37:14', NULL),
(753, 35, 49, 'asdas', 'text', '2025-02-23 04:18:08', NULL),
(754, 35, 48, 'asdas', 'text', '2025-02-23 04:19:08', NULL),
(755, 35, 49, 'asdas', 'text', '2025-02-23 04:19:31', NULL),
(756, 35, 49, 'as', 'text', '2025-02-23 04:19:37', NULL),
(757, 35, 49, 'asdas', 'text', '2025-02-23 04:23:19', NULL),
(758, 35, 49, 'asda', 'text', '2025-02-23 04:23:46', NULL),
(759, 35, 49, 'asdas', 'text', '2025-02-23 04:23:47', NULL),
(760, 35, 49, 'asdas', 'text', '2025-02-23 04:29:15', NULL),
(761, 35, 49, 'asdas', 'text', '2025-02-23 04:29:20', NULL),
(762, 35, 49, 'asda', 'text', '2025-02-23 04:29:22', NULL),
(763, 35, 49, 'sada', 'text', '2025-02-23 04:30:54', NULL),
(764, 35, 49, 'dfs', 'text', '2025-02-23 04:33:45', NULL),
(765, 35, 49, 'asd', 'text', '2025-02-23 07:51:18', NULL),
(766, 35, 49, 'asdas', 'text', '2025-02-23 08:21:24', NULL),
(767, 35, 49, 'asd', 'text', '2025-02-23 08:24:02', NULL),
(768, 35, 49, 'asdas', 'text', '2025-02-23 08:30:36', NULL),
(769, 35, 49, 'sad', 'text', '2025-02-23 08:36:20', NULL),
(770, 35, 49, 'das', 'text', '2025-02-23 08:36:22', NULL),
(771, 35, 49, 'asdsa', 'text', '2025-02-23 08:36:25', NULL),
(772, 35, 49, 'asda', 'text', '2025-02-23 08:36:35', NULL),
(773, 35, 49, 'asdas', 'text', '2025-02-23 08:36:41', NULL),
(774, 35, 49, 'asdas', 'text', '2025-02-23 08:36:44', NULL),
(775, 35, 48, 'asdsa', 'text', '2025-02-23 08:37:16', NULL),
(776, 35, 49, 'asdasds', 'text', '2025-02-23 08:37:32', NULL),
(777, 35, 48, 'asd', 'text', '2025-02-23 08:41:18', NULL),
(778, 35, 48, 'sdasdas', 'text', '2025-02-23 08:41:43', NULL),
(779, 35, 48, 'asdas', 'text', '2025-02-23 08:41:47', NULL),
(780, 35, 49, 'asdas', 'text', '2025-02-23 08:42:02', NULL),
(781, 35, 48, 'sadas', 'text', '2025-02-23 08:42:10', NULL);

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
(989, 536, 48, 1, '2025-02-21 15:34:45', '2025-02-22 08:32:27'),
(990, 536, 49, 1, '2025-02-21 15:34:45', '2025-02-21 15:34:45'),
(991, 537, 48, 1, '2025-02-21 16:00:23', '2025-02-22 08:32:26'),
(992, 537, 50, 1, '2025-02-21 16:00:23', '2025-02-21 16:00:23'),
(993, 538, 49, 1, '2025-02-21 16:13:47', '2025-02-22 08:35:24'),
(994, 538, 48, 1, '2025-02-21 16:13:47', '2025-02-21 16:13:47'),
(995, 539, 49, 1, '2025-02-21 16:13:54', '2025-02-22 08:35:24'),
(996, 539, 48, 1, '2025-02-21 16:13:54', '2025-02-21 16:13:54'),
(997, 540, 48, 1, '2025-02-21 16:22:06', '2025-02-22 08:32:25'),
(998, 540, 51, 1, '2025-02-21 16:22:06', '2025-02-21 16:22:06'),
(999, 541, 51, 0, '2025-02-21 16:22:46', '2025-02-21 16:22:46'),
(1000, 541, 48, 1, '2025-02-21 16:22:46', '2025-02-21 16:22:46'),
(1001, 542, 51, 0, '2025-02-22 07:30:59', '2025-02-22 07:30:59'),
(1002, 542, 48, 1, '2025-02-22 07:30:59', '2025-02-22 07:30:59'),
(1003, 543, 51, 0, '2025-02-22 07:30:59', '2025-02-22 07:30:59'),
(1004, 543, 48, 1, '2025-02-22 07:30:59', '2025-02-22 07:30:59'),
(1005, 544, 51, 0, '2025-02-22 07:30:59', '2025-02-22 07:30:59'),
(1006, 544, 48, 1, '2025-02-22 07:30:59', '2025-02-22 07:30:59'),
(1007, 545, 51, 0, '2025-02-22 07:31:06', '2025-02-22 07:31:06'),
(1008, 545, 48, 1, '2025-02-22 07:31:06', '2025-02-22 07:31:06'),
(1009, 546, 51, 0, '2025-02-22 07:31:24', '2025-02-22 07:31:24'),
(1010, 546, 48, 1, '2025-02-22 07:31:24', '2025-02-22 07:31:24'),
(1011, 547, 51, 0, '2025-02-22 08:04:04', '2025-02-22 08:04:04'),
(1012, 547, 48, 1, '2025-02-22 08:04:04', '2025-02-22 08:04:04'),
(1013, 548, 51, 0, '2025-02-22 08:32:32', '2025-02-22 08:32:32'),
(1014, 548, 48, 1, '2025-02-22 08:32:32', '2025-02-22 08:32:32'),
(1015, 549, 50, 0, '2025-02-22 08:32:38', '2025-02-22 08:32:38'),
(1016, 549, 48, 1, '2025-02-22 08:32:38', '2025-02-22 08:32:38'),
(1017, 550, 49, 1, '2025-02-22 08:32:43', '2025-02-22 08:35:24'),
(1018, 550, 48, 1, '2025-02-22 08:32:43', '2025-02-22 08:32:43'),
(1019, 551, 48, 1, '2025-02-22 08:34:59', '2025-02-22 08:34:59'),
(1020, 551, 50, 0, '2025-02-22 08:34:59', '2025-02-22 08:34:59'),
(1021, 552, 48, 1, '2025-02-22 08:35:05', '2025-02-22 08:35:05'),
(1022, 552, 51, 0, '2025-02-22 08:35:05', '2025-02-22 08:35:05'),
(1023, 553, 48, 1, '2025-02-22 08:35:40', '2025-02-22 08:35:40'),
(1024, 553, 49, 1, '2025-02-22 08:35:40', '2025-02-22 08:36:01'),
(1025, 554, 48, 1, '2025-02-22 08:35:53', '2025-02-22 08:35:53'),
(1026, 554, 49, 1, '2025-02-22 08:35:53', '2025-02-22 08:36:01'),
(1027, 555, 48, 1, '2025-02-22 08:36:05', '2025-02-22 08:36:05'),
(1028, 555, 49, 1, '2025-02-22 08:36:05', '2025-02-22 08:36:05'),
(1029, 556, 48, 1, '2025-02-22 08:36:14', '2025-02-22 08:36:14'),
(1030, 556, 49, 1, '2025-02-22 08:36:14', '2025-02-22 08:36:14'),
(1031, 557, 48, 1, '2025-02-22 08:36:18', '2025-02-22 08:36:18'),
(1032, 557, 49, 1, '2025-02-22 08:36:18', '2025-02-22 08:40:09'),
(1033, 558, 48, 1, '2025-02-22 08:37:59', '2025-02-22 08:37:59'),
(1034, 558, 50, 0, '2025-02-22 08:37:59', '2025-02-22 08:37:59'),
(1035, 559, 48, 1, '2025-02-22 08:38:04', '2025-02-22 08:38:04'),
(1036, 559, 49, 1, '2025-02-22 08:38:04', '2025-02-22 08:40:09'),
(1037, 560, 48, 1, '2025-02-22 08:40:11', '2025-02-22 08:40:13'),
(1038, 560, 49, 1, '2025-02-22 08:40:11', '2025-02-22 08:40:11'),
(1039, 561, 48, 1, '2025-02-22 08:40:17', '2025-02-22 08:43:31'),
(1040, 561, 49, 1, '2025-02-22 08:40:17', '2025-02-22 08:40:17'),
(1041, 562, 48, 1, '2025-02-22 08:40:20', '2025-02-22 08:43:31'),
(1042, 562, 49, 1, '2025-02-22 08:40:20', '2025-02-22 08:40:20'),
(1043, 563, 48, 1, '2025-02-22 08:40:22', '2025-02-22 08:43:31'),
(1044, 563, 49, 1, '2025-02-22 08:40:22', '2025-02-22 08:40:22'),
(1045, 564, 48, 1, '2025-02-22 08:43:35', '2025-02-22 08:43:35'),
(1046, 564, 49, 1, '2025-02-22 08:43:35', '2025-02-22 08:46:49'),
(1047, 565, 48, 1, '2025-02-22 08:48:55', '2025-02-22 08:49:03'),
(1048, 565, 49, 1, '2025-02-22 08:48:55', '2025-02-22 08:48:55'),
(1049, 566, 48, 1, '2025-02-22 08:49:16', '2025-02-22 08:49:16'),
(1050, 566, 49, 1, '2025-02-22 08:49:16', '2025-02-22 08:49:16'),
(1051, 567, 48, 1, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(1052, 567, 49, 1, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(1053, 568, 48, 1, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(1054, 568, 49, 1, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(1055, 569, 48, 1, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(1056, 569, 49, 1, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(1057, 570, 48, 1, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(1058, 570, 49, 1, '2025-02-22 08:49:52', '2025-02-22 08:49:53'),
(1059, 571, 48, 1, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(1060, 571, 49, 1, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(1061, 572, 48, 1, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(1062, 572, 49, 1, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(1063, 573, 48, 1, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(1064, 573, 49, 1, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(1065, 574, 48, 1, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(1066, 574, 49, 1, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(1067, 575, 48, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1068, 575, 49, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1069, 576, 48, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1070, 576, 49, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1071, 577, 48, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1072, 577, 49, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1073, 578, 48, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1074, 578, 49, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1075, 579, 48, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1076, 579, 49, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1077, 580, 48, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1078, 580, 49, 1, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(1079, 581, 48, 1, '2025-02-22 08:49:59', '2025-02-22 08:49:59'),
(1080, 581, 49, 1, '2025-02-22 08:49:59', '2025-02-22 08:49:59'),
(1081, 582, 48, 1, '2025-02-22 08:50:03', '2025-02-22 08:50:03'),
(1082, 582, 49, 1, '2025-02-22 08:50:03', '2025-02-22 08:50:03'),
(1083, 583, 48, 1, '2025-02-22 08:52:31', '2025-02-22 08:52:31'),
(1084, 583, 49, 1, '2025-02-22 08:52:31', '2025-02-22 08:52:31'),
(1085, 584, 48, 1, '2025-02-22 08:52:37', '2025-02-22 08:52:37'),
(1086, 584, 49, 1, '2025-02-22 08:52:37', '2025-02-22 08:52:37'),
(1087, 585, 48, 1, '2025-02-22 08:52:41', '2025-02-22 08:52:41'),
(1088, 585, 49, 1, '2025-02-22 08:52:41', '2025-02-22 08:52:41'),
(1089, 586, 48, 1, '2025-02-22 08:52:51', '2025-02-22 08:52:51'),
(1090, 586, 49, 1, '2025-02-22 08:52:51', '2025-02-22 08:52:52'),
(1091, 587, 48, 1, '2025-02-22 08:52:58', '2025-02-22 08:52:58'),
(1092, 587, 49, 1, '2025-02-22 08:52:58', '2025-02-22 08:52:58'),
(1093, 588, 48, 1, '2025-02-22 08:53:06', '2025-02-22 08:53:06'),
(1094, 588, 49, 1, '2025-02-22 08:53:06', '2025-02-22 08:53:06'),
(1095, 589, 48, 1, '2025-02-22 08:55:02', '2025-02-22 08:55:09'),
(1096, 589, 49, 1, '2025-02-22 08:55:02', '2025-02-22 08:55:02'),
(1097, 590, 48, 1, '2025-02-22 08:55:04', '2025-02-22 08:55:09'),
(1098, 590, 49, 1, '2025-02-22 08:55:04', '2025-02-22 08:55:04'),
(1099, 591, 48, 1, '2025-02-22 08:55:06', '2025-02-22 08:55:09'),
(1100, 591, 49, 1, '2025-02-22 08:55:06', '2025-02-22 08:55:06'),
(1101, 592, 48, 1, '2025-02-22 08:55:13', '2025-02-22 08:55:13'),
(1102, 592, 49, 1, '2025-02-22 08:55:13', '2025-02-22 08:55:23'),
(1103, 593, 48, 1, '2025-02-22 08:55:27', '2025-02-22 08:55:32'),
(1104, 593, 49, 1, '2025-02-22 08:55:27', '2025-02-22 08:55:27'),
(1105, 594, 48, 1, '2025-02-22 08:55:55', '2025-02-22 08:56:07'),
(1106, 594, 49, 1, '2025-02-22 08:55:55', '2025-02-22 08:55:55'),
(1107, 595, 48, 1, '2025-02-22 08:58:00', '2025-02-22 08:58:13'),
(1108, 595, 49, 1, '2025-02-22 08:58:00', '2025-02-22 08:58:00'),
(1109, 596, 48, 1, '2025-02-22 08:58:02', '2025-02-22 08:58:13'),
(1110, 596, 49, 1, '2025-02-22 08:58:02', '2025-02-22 08:58:02'),
(1111, 597, 48, 1, '2025-02-22 08:58:19', '2025-02-22 08:58:19'),
(1112, 597, 49, 1, '2025-02-22 08:58:19', '2025-02-22 08:58:22'),
(1113, 598, 48, 1, '2025-02-22 09:09:08', '2025-02-22 09:09:16'),
(1114, 598, 49, 1, '2025-02-22 09:09:08', '2025-02-22 09:09:08'),
(1115, 599, 48, 1, '2025-02-22 09:09:22', '2025-02-22 09:09:25'),
(1116, 599, 49, 1, '2025-02-22 09:09:22', '2025-02-22 09:09:22'),
(1117, 600, 48, 1, '2025-02-22 09:09:33', '2025-02-22 09:09:33'),
(1118, 600, 49, 1, '2025-02-22 09:09:33', '2025-02-22 09:09:33'),
(1119, 601, 48, 1, '2025-02-22 09:09:35', '2025-02-22 09:09:35'),
(1120, 601, 49, 1, '2025-02-22 09:09:35', '2025-02-22 09:09:37'),
(1121, 602, 48, 1, '2025-02-22 09:11:53', '2025-02-22 09:12:01'),
(1122, 602, 49, 1, '2025-02-22 09:11:53', '2025-02-22 09:11:53'),
(1123, 603, 48, 1, '2025-02-22 09:12:06', '2025-02-22 09:12:06'),
(1124, 603, 49, 1, '2025-02-22 09:12:06', '2025-02-22 09:12:06'),
(1125, 604, 48, 1, '2025-02-22 09:12:08', '2025-02-22 09:12:50'),
(1126, 604, 49, 1, '2025-02-22 09:12:08', '2025-02-22 09:12:08'),
(1127, 605, 48, 1, '2025-02-22 09:14:08', '2025-02-22 09:14:09'),
(1128, 605, 49, 1, '2025-02-22 09:14:08', '2025-02-22 09:14:08'),
(1129, 606, 48, 1, '2025-02-22 09:14:13', '2025-02-22 09:14:23'),
(1130, 606, 49, 1, '2025-02-22 09:14:13', '2025-02-22 09:14:13'),
(1131, 607, 48, 1, '2025-02-22 09:14:18', '2025-02-22 09:14:23'),
(1132, 607, 49, 1, '2025-02-22 09:14:18', '2025-02-22 09:14:18'),
(1133, 608, 48, 1, '2025-02-22 09:14:39', '2025-02-22 09:14:39'),
(1134, 608, 49, 1, '2025-02-22 09:14:39', '2025-02-22 09:14:40'),
(1135, 609, 48, 1, '2025-02-22 09:14:46', '2025-02-22 09:14:48'),
(1136, 609, 49, 1, '2025-02-22 09:14:46', '2025-02-22 09:14:46'),
(1137, 610, 48, 1, '2025-02-22 09:14:50', '2025-02-22 09:14:50'),
(1138, 610, 49, 1, '2025-02-22 09:14:50', '2025-02-22 09:14:51'),
(1139, 611, 48, 1, '2025-02-22 09:14:53', '2025-02-22 09:14:53'),
(1140, 611, 49, 1, '2025-02-22 09:14:53', '2025-02-22 09:18:19'),
(1141, 612, 48, 1, '2025-02-22 09:17:53', '2025-02-22 09:18:28'),
(1142, 612, 49, 1, '2025-02-22 09:17:53', '2025-02-22 09:17:53'),
(1143, 613, 48, 1, '2025-02-22 09:18:22', '2025-02-22 09:18:28'),
(1144, 613, 49, 1, '2025-02-22 09:18:22', '2025-02-22 09:18:22'),
(1145, 614, 48, 1, '2025-02-22 09:18:31', '2025-02-22 09:18:31'),
(1146, 614, 49, 1, '2025-02-22 09:18:31', '2025-02-22 09:18:32'),
(1147, 615, 48, 1, '2025-02-22 09:18:34', '2025-02-22 09:18:34'),
(1148, 615, 49, 1, '2025-02-22 09:18:34', '2025-02-22 09:20:22'),
(1149, 616, 48, 1, '2025-02-22 09:20:37', '2025-02-22 09:20:37'),
(1150, 616, 49, 1, '2025-02-22 09:20:37', '2025-02-22 09:20:45'),
(1151, 617, 48, 1, '2025-02-22 09:20:41', '2025-02-22 09:20:41'),
(1152, 617, 49, 1, '2025-02-22 09:20:41', '2025-02-22 09:20:45'),
(1153, 618, 48, 1, '2025-02-22 09:22:59', '2025-02-22 09:23:01'),
(1154, 618, 49, 1, '2025-02-22 09:22:59', '2025-02-22 09:22:59'),
(1155, 619, 48, 1, '2025-02-22 09:23:05', '2025-02-22 09:25:49'),
(1156, 619, 49, 1, '2025-02-22 09:23:05', '2025-02-22 09:23:05'),
(1157, 620, 48, 1, '2025-02-22 09:23:06', '2025-02-22 09:25:49'),
(1158, 620, 49, 1, '2025-02-22 09:23:06', '2025-02-22 09:23:06'),
(1159, 621, 48, 1, '2025-02-22 09:25:55', '2025-02-22 09:26:00'),
(1160, 621, 49, 1, '2025-02-22 09:25:55', '2025-02-22 09:25:55'),
(1161, 622, 48, 1, '2025-02-22 09:29:11', '2025-02-22 09:29:26'),
(1162, 622, 49, 1, '2025-02-22 09:29:11', '2025-02-22 09:29:11'),
(1163, 623, 48, 1, '2025-02-22 09:29:17', '2025-02-22 09:29:26'),
(1164, 623, 49, 1, '2025-02-22 09:29:17', '2025-02-22 09:29:17'),
(1165, 624, 48, 1, '2025-02-22 09:31:13', '2025-02-22 09:31:13'),
(1166, 624, 49, 1, '2025-02-22 09:31:13', '2025-02-22 09:31:14'),
(1167, 625, 48, 1, '2025-02-22 09:31:24', '2025-02-22 09:31:25'),
(1168, 625, 49, 1, '2025-02-22 09:31:24', '2025-02-22 09:31:24'),
(1169, 626, 48, 1, '2025-02-22 09:31:37', '2025-02-22 09:31:44'),
(1170, 626, 49, 1, '2025-02-22 09:31:37', '2025-02-22 09:31:37'),
(1171, 627, 48, 1, '2025-02-22 09:31:38', '2025-02-22 09:31:44'),
(1172, 627, 49, 1, '2025-02-22 09:31:38', '2025-02-22 09:31:38'),
(1173, 628, 48, 1, '2025-02-22 09:31:41', '2025-02-22 09:31:44'),
(1174, 628, 49, 1, '2025-02-22 09:31:41', '2025-02-22 09:31:41'),
(1175, 629, 48, 1, '2025-02-22 09:31:55', '2025-02-22 09:31:55'),
(1176, 629, 49, 1, '2025-02-22 09:31:55', '2025-02-22 09:32:17'),
(1177, 630, 48, 1, '2025-02-22 11:53:01', '2025-02-22 11:54:33'),
(1178, 630, 49, 1, '2025-02-22 11:53:01', '2025-02-22 11:53:01'),
(1179, 631, 48, 1, '2025-02-22 11:59:40', '2025-02-22 11:59:44'),
(1180, 631, 49, 1, '2025-02-22 11:59:40', '2025-02-22 11:59:40'),
(1181, 632, 48, 1, '2025-02-22 11:59:50', '2025-02-22 12:01:29'),
(1182, 632, 49, 1, '2025-02-22 11:59:50', '2025-02-22 11:59:50'),
(1183, 633, 48, 1, '2025-02-22 11:59:55', '2025-02-22 12:01:29'),
(1184, 633, 49, 1, '2025-02-22 11:59:55', '2025-02-22 11:59:55'),
(1185, 634, 48, 1, '2025-02-22 12:01:22', '2025-02-22 12:01:29'),
(1186, 634, 49, 1, '2025-02-22 12:01:22', '2025-02-22 12:01:22'),
(1187, 635, 48, 1, '2025-02-22 12:01:31', '2025-02-22 12:01:31'),
(1188, 635, 49, 1, '2025-02-22 12:01:31', '2025-02-22 12:01:32'),
(1189, 636, 48, 1, '2025-02-22 12:03:05', '2025-02-22 12:03:06'),
(1190, 636, 49, 1, '2025-02-22 12:03:05', '2025-02-22 12:03:05'),
(1191, 637, 48, 1, '2025-02-22 12:03:11', '2025-02-22 12:03:11'),
(1192, 637, 49, 1, '2025-02-22 12:03:11', '2025-02-22 12:03:12'),
(1193, 638, 48, 1, '2025-02-22 12:03:14', '2025-02-22 12:03:14'),
(1194, 638, 49, 1, '2025-02-22 12:03:14', '2025-02-22 12:03:36'),
(1195, 639, 48, 1, '2025-02-22 12:04:47', '2025-02-22 12:04:49'),
(1196, 639, 49, 1, '2025-02-22 12:04:47', '2025-02-22 12:04:47'),
(1197, 640, 48, 1, '2025-02-22 12:06:56', '2025-02-22 12:06:59'),
(1198, 640, 49, 1, '2025-02-22 12:06:56', '2025-02-22 12:06:56'),
(1199, 641, 48, 1, '2025-02-22 12:09:33', '2025-02-22 12:09:36'),
(1200, 641, 49, 1, '2025-02-22 12:09:33', '2025-02-22 12:09:33'),
(1201, 642, 48, 1, '2025-02-22 12:09:46', '2025-02-22 12:09:47'),
(1202, 642, 49, 1, '2025-02-22 12:09:46', '2025-02-22 12:09:46'),
(1203, 643, 48, 1, '2025-02-22 12:09:49', '2025-02-22 12:10:00'),
(1204, 643, 49, 1, '2025-02-22 12:09:49', '2025-02-22 12:09:49'),
(1205, 644, 48, 1, '2025-02-22 12:09:52', '2025-02-22 12:10:00'),
(1206, 644, 49, 1, '2025-02-22 12:09:52', '2025-02-22 12:09:52'),
(1207, 645, 48, 1, '2025-02-22 12:11:54', '2025-02-22 12:11:59'),
(1208, 645, 49, 1, '2025-02-22 12:11:54', '2025-02-22 12:11:54'),
(1209, 646, 48, 1, '2025-02-22 12:12:25', '2025-02-22 12:12:33'),
(1210, 646, 49, 1, '2025-02-22 12:12:25', '2025-02-22 12:12:25'),
(1211, 647, 48, 1, '2025-02-22 12:14:45', '2025-02-22 12:14:50'),
(1212, 647, 49, 1, '2025-02-22 12:14:45', '2025-02-22 12:14:45'),
(1213, 648, 48, 1, '2025-02-22 12:14:56', '2025-02-22 12:14:58'),
(1214, 648, 49, 1, '2025-02-22 12:14:56', '2025-02-22 12:14:56'),
(1215, 649, 48, 1, '2025-02-22 12:15:07', '2025-02-22 12:15:09'),
(1216, 649, 49, 1, '2025-02-22 12:15:07', '2025-02-22 12:15:07'),
(1217, 650, 48, 1, '2025-02-22 12:15:09', '2025-02-22 12:15:09'),
(1218, 650, 49, 1, '2025-02-22 12:15:09', '2025-02-22 12:15:09'),
(1219, 651, 48, 1, '2025-02-22 12:15:11', '2025-02-22 12:15:24'),
(1220, 651, 49, 1, '2025-02-22 12:15:11', '2025-02-22 12:15:11'),
(1221, 652, 48, 1, '2025-02-22 12:15:12', '2025-02-22 12:15:24'),
(1222, 652, 49, 1, '2025-02-22 12:15:12', '2025-02-22 12:15:12'),
(1223, 653, 48, 1, '2025-02-22 12:15:13', '2025-02-22 12:15:24'),
(1224, 653, 49, 1, '2025-02-22 12:15:13', '2025-02-22 12:15:13'),
(1225, 654, 48, 1, '2025-02-22 12:15:13', '2025-02-22 12:15:24'),
(1226, 654, 49, 1, '2025-02-22 12:15:13', '2025-02-22 12:15:13'),
(1227, 655, 48, 1, '2025-02-22 12:15:14', '2025-02-22 12:15:24'),
(1228, 655, 49, 1, '2025-02-22 12:15:14', '2025-02-22 12:15:14'),
(1229, 656, 48, 1, '2025-02-22 12:15:21', '2025-02-22 12:15:24'),
(1230, 656, 49, 1, '2025-02-22 12:15:21', '2025-02-22 12:15:21'),
(1231, 657, 48, 1, '2025-02-22 12:15:26', '2025-02-22 12:15:28'),
(1232, 657, 49, 1, '2025-02-22 12:15:26', '2025-02-22 12:15:26'),
(1233, 658, 48, 1, '2025-02-22 12:17:47', '2025-02-22 12:17:49'),
(1234, 658, 49, 1, '2025-02-22 12:17:47', '2025-02-22 12:17:47'),
(1235, 659, 48, 1, '2025-02-22 12:17:53', '2025-02-22 12:18:13'),
(1236, 659, 49, 1, '2025-02-22 12:17:53', '2025-02-22 12:17:53'),
(1237, 660, 48, 1, '2025-02-22 12:18:00', '2025-02-22 12:18:13'),
(1238, 660, 49, 1, '2025-02-22 12:18:00', '2025-02-22 12:18:00'),
(1239, 661, 48, 1, '2025-02-22 12:19:51', '2025-02-22 12:19:52'),
(1240, 661, 49, 1, '2025-02-22 12:19:51', '2025-02-22 12:19:51'),
(1241, 662, 48, 1, '2025-02-22 12:19:53', '2025-02-22 12:19:54'),
(1242, 662, 49, 1, '2025-02-22 12:19:53', '2025-02-22 12:19:53'),
(1243, 663, 48, 1, '2025-02-22 12:20:01', '2025-02-22 12:20:30'),
(1244, 663, 49, 1, '2025-02-22 12:20:01', '2025-02-22 12:20:01'),
(1245, 664, 48, 1, '2025-02-22 12:20:02', '2025-02-22 12:20:30'),
(1246, 664, 49, 1, '2025-02-22 12:20:02', '2025-02-22 12:20:02'),
(1247, 665, 48, 1, '2025-02-22 12:20:04', '2025-02-22 12:20:30'),
(1248, 665, 49, 1, '2025-02-22 12:20:04', '2025-02-22 12:20:04'),
(1249, 666, 48, 1, '2025-02-22 12:20:23', '2025-02-22 12:20:30'),
(1250, 666, 49, 1, '2025-02-22 12:20:23', '2025-02-22 12:20:23'),
(1251, 667, 48, 1, '2025-02-22 12:21:03', '2025-02-22 12:21:03'),
(1252, 667, 49, 1, '2025-02-22 12:21:03', '2025-02-22 12:21:04'),
(1253, 668, 48, 1, '2025-02-22 12:21:29', '2025-02-22 12:21:30'),
(1254, 668, 49, 1, '2025-02-22 12:21:29', '2025-02-22 12:21:29'),
(1255, 669, 48, 1, '2025-02-22 12:21:32', '2025-02-22 12:22:13'),
(1256, 669, 49, 1, '2025-02-22 12:21:32', '2025-02-22 12:21:32'),
(1257, 670, 48, 1, '2025-02-22 12:21:37', '2025-02-22 12:22:13'),
(1258, 670, 49, 1, '2025-02-22 12:21:37', '2025-02-22 12:21:37'),
(1259, 671, 48, 1, '2025-02-22 12:21:41', '2025-02-22 12:22:13'),
(1260, 671, 49, 1, '2025-02-22 12:21:41', '2025-02-22 12:21:41'),
(1261, 672, 48, 1, '2025-02-22 12:21:48', '2025-02-22 12:22:13'),
(1262, 672, 49, 1, '2025-02-22 12:21:48', '2025-02-22 12:21:48'),
(1263, 673, 48, 1, '2025-02-22 12:22:16', '2025-02-22 12:22:17'),
(1264, 673, 49, 1, '2025-02-22 12:22:16', '2025-02-22 12:22:16'),
(1265, 674, 48, 1, '2025-02-22 12:22:19', '2025-02-22 12:22:33'),
(1266, 674, 49, 1, '2025-02-22 12:22:19', '2025-02-22 12:22:19'),
(1267, 675, 48, 1, '2025-02-22 12:22:23', '2025-02-22 12:22:33'),
(1268, 675, 49, 1, '2025-02-22 12:22:23', '2025-02-22 12:22:23'),
(1269, 676, 48, 1, '2025-02-22 12:22:40', '2025-02-22 12:22:41'),
(1270, 676, 49, 1, '2025-02-22 12:22:40', '2025-02-22 12:22:40'),
(1271, 677, 48, 1, '2025-02-22 12:22:46', '2025-02-22 12:25:32'),
(1272, 677, 49, 1, '2025-02-22 12:22:46', '2025-02-22 12:22:46'),
(1273, 678, 48, 1, '2025-02-22 12:22:48', '2025-02-22 12:25:32'),
(1274, 678, 49, 1, '2025-02-22 12:22:48', '2025-02-22 12:22:48'),
(1275, 679, 48, 1, '2025-02-22 12:25:46', '2025-02-22 12:25:46'),
(1276, 679, 49, 1, '2025-02-22 12:25:46', '2025-02-22 12:25:49'),
(1277, 680, 48, 1, '2025-02-22 12:27:52', '2025-02-22 12:27:55'),
(1278, 680, 49, 1, '2025-02-22 12:27:52', '2025-02-22 12:27:52'),
(1279, 681, 48, 1, '2025-02-22 12:28:30', '2025-02-22 12:28:31'),
(1280, 681, 49, 1, '2025-02-22 12:28:30', '2025-02-22 12:28:30'),
(1281, 682, 48, 1, '2025-02-22 12:34:05', '2025-02-22 12:34:05'),
(1282, 682, 49, 1, '2025-02-22 12:34:05', '2025-02-22 12:34:07'),
(1283, 683, 48, 1, '2025-02-22 12:34:13', '2025-02-22 12:34:13'),
(1284, 683, 49, 1, '2025-02-22 12:34:13', '2025-02-22 12:34:58'),
(1285, 684, 48, 1, '2025-02-22 12:34:15', '2025-02-22 12:34:15'),
(1286, 684, 49, 1, '2025-02-22 12:34:15', '2025-02-22 12:34:58'),
(1287, 685, 48, 1, '2025-02-22 12:34:23', '2025-02-22 12:34:23'),
(1288, 685, 50, 0, '2025-02-22 12:34:23', '2025-02-22 12:34:23'),
(1289, 686, 48, 1, '2025-02-22 12:34:33', '2025-02-22 12:34:33'),
(1290, 686, 49, 1, '2025-02-22 12:34:33', '2025-02-22 12:34:58'),
(1291, 687, 48, 1, '2025-02-22 12:34:47', '2025-02-22 12:34:47'),
(1292, 687, 49, 1, '2025-02-22 12:34:47', '2025-02-22 12:34:58'),
(1293, 688, 48, 1, '2025-02-22 12:34:52', '2025-02-22 12:34:52'),
(1294, 688, 49, 1, '2025-02-22 12:34:52', '2025-02-22 12:34:58'),
(1295, 689, 48, 1, '2025-02-22 12:35:03', '2025-02-22 12:36:13'),
(1296, 689, 49, 1, '2025-02-22 12:35:03', '2025-02-22 12:35:03'),
(1297, 690, 48, 1, '2025-02-22 12:36:21', '2025-02-22 12:36:22'),
(1298, 690, 49, 1, '2025-02-22 12:36:21', '2025-02-22 12:36:21'),
(1299, 691, 48, 1, '2025-02-22 12:36:29', '2025-02-22 12:36:29'),
(1300, 691, 49, 1, '2025-02-22 12:36:29', '2025-02-22 12:36:31'),
(1301, 692, 48, 1, '2025-02-22 12:36:53', '2025-02-22 12:36:56'),
(1302, 692, 49, 1, '2025-02-22 12:36:53', '2025-02-22 12:36:53'),
(1303, 693, 48, 1, '2025-02-22 12:38:15', '2025-02-22 12:38:16'),
(1304, 693, 49, 1, '2025-02-22 12:38:15', '2025-02-22 12:38:15'),
(1305, 694, 48, 1, '2025-02-22 12:38:22', '2025-02-22 12:38:33'),
(1306, 694, 49, 1, '2025-02-22 12:38:22', '2025-02-22 12:38:22'),
(1307, 695, 48, 1, '2025-02-22 12:38:23', '2025-02-22 12:38:33'),
(1308, 695, 49, 1, '2025-02-22 12:38:23', '2025-02-22 12:38:23'),
(1309, 696, 48, 1, '2025-02-22 12:38:39', '2025-02-22 12:40:42'),
(1310, 696, 49, 1, '2025-02-22 12:38:39', '2025-02-22 12:38:39'),
(1311, 697, 48, 1, '2025-02-22 12:38:41', '2025-02-22 12:40:42'),
(1312, 697, 49, 1, '2025-02-22 12:38:41', '2025-02-22 12:38:41'),
(1313, 698, 48, 1, '2025-02-22 12:40:38', '2025-02-22 12:40:42'),
(1314, 698, 49, 1, '2025-02-22 12:40:38', '2025-02-22 12:40:38'),
(1315, 699, 48, 1, '2025-02-22 12:40:39', '2025-02-22 12:40:42'),
(1316, 699, 49, 1, '2025-02-22 12:40:39', '2025-02-22 12:40:39'),
(1317, 700, 48, 1, '2025-02-22 12:40:45', '2025-02-22 12:40:45'),
(1318, 700, 49, 1, '2025-02-22 12:40:45', '2025-02-22 12:40:46'),
(1319, 701, 31, 0, '2025-02-22 12:40:48', '2025-02-22 12:40:48'),
(1320, 701, 49, 1, '2025-02-22 12:40:48', '2025-02-22 12:40:48'),
(1321, 702, 31, 0, '2025-02-22 12:40:49', '2025-02-22 12:40:49'),
(1322, 702, 49, 1, '2025-02-22 12:40:49', '2025-02-22 12:40:49'),
(1323, 703, 31, 0, '2025-02-22 12:40:50', '2025-02-22 12:40:50'),
(1324, 703, 49, 1, '2025-02-22 12:40:50', '2025-02-22 12:40:50'),
(1325, 704, 31, 0, '2025-02-22 12:40:55', '2025-02-22 12:40:55'),
(1326, 704, 49, 1, '2025-02-22 12:40:55', '2025-02-22 12:40:55'),
(1327, 705, 31, 0, '2025-02-22 12:40:56', '2025-02-22 12:40:56'),
(1328, 705, 49, 1, '2025-02-22 12:40:56', '2025-02-22 12:40:56'),
(1329, 706, 31, 0, '2025-02-22 12:40:57', '2025-02-22 12:40:57'),
(1330, 706, 49, 1, '2025-02-22 12:40:57', '2025-02-22 12:40:57'),
(1331, 707, 31, 0, '2025-02-22 12:40:57', '2025-02-22 12:40:57'),
(1332, 707, 49, 1, '2025-02-22 12:40:57', '2025-02-22 12:40:57'),
(1333, 708, 31, 0, '2025-02-22 12:40:58', '2025-02-22 12:40:58'),
(1334, 708, 49, 1, '2025-02-22 12:40:58', '2025-02-22 12:40:58'),
(1335, 709, 31, 0, '2025-02-22 12:40:58', '2025-02-22 12:40:58'),
(1336, 709, 49, 1, '2025-02-22 12:40:58', '2025-02-22 12:40:58'),
(1337, 710, 31, 0, '2025-02-22 12:41:02', '2025-02-22 12:41:02'),
(1338, 710, 49, 1, '2025-02-22 12:41:02', '2025-02-22 12:41:02'),
(1339, 711, 48, 1, '2025-02-22 12:41:16', '2025-02-22 12:41:18'),
(1340, 711, 49, 1, '2025-02-22 12:41:16', '2025-02-22 12:41:16'),
(1341, 712, 48, 1, '2025-02-22 12:41:28', '2025-02-22 12:41:30'),
(1342, 712, 49, 1, '2025-02-22 12:41:28', '2025-02-22 12:41:28'),
(1343, 713, 48, 1, '2025-02-22 12:41:33', '2025-02-22 12:44:00'),
(1344, 713, 49, 1, '2025-02-22 12:41:33', '2025-02-22 12:41:33'),
(1345, 714, 48, 1, '2025-02-22 12:44:29', '2025-02-22 12:44:29'),
(1346, 714, 49, 1, '2025-02-22 12:44:29', '2025-02-22 12:45:44'),
(1347, 715, 48, 1, '2025-02-22 12:46:20', '2025-02-22 12:46:21'),
(1348, 715, 49, 1, '2025-02-22 12:46:20', '2025-02-22 12:46:20'),
(1349, 716, 48, 1, '2025-02-22 12:46:25', '2025-02-22 12:48:35'),
(1350, 716, 49, 1, '2025-02-22 12:46:25', '2025-02-22 12:46:25'),
(1351, 717, 48, 1, '2025-02-22 12:46:29', '2025-02-22 12:48:35'),
(1352, 717, 49, 1, '2025-02-22 12:46:29', '2025-02-22 12:46:29'),
(1353, 718, 48, 1, '2025-02-22 12:46:32', '2025-02-22 12:48:35'),
(1354, 718, 49, 1, '2025-02-22 12:46:32', '2025-02-22 12:46:32'),
(1355, 719, 48, 1, '2025-02-22 12:48:31', '2025-02-22 12:48:35'),
(1356, 719, 49, 1, '2025-02-22 12:48:31', '2025-02-22 12:48:31'),
(1357, 720, 48, 1, '2025-02-22 12:48:37', '2025-02-22 12:48:37'),
(1358, 720, 49, 1, '2025-02-22 12:48:37', '2025-02-22 12:48:38'),
(1359, 721, 48, 1, '2025-02-22 12:48:39', '2025-02-22 12:48:41'),
(1360, 721, 49, 1, '2025-02-22 12:48:39', '2025-02-22 12:48:39'),
(1361, 722, 48, 1, '2025-02-22 12:48:40', '2025-02-22 12:48:41'),
(1362, 722, 49, 1, '2025-02-22 12:48:40', '2025-02-22 12:48:40'),
(1363, 723, 48, 1, '2025-02-22 12:48:41', '2025-02-22 12:48:41'),
(1364, 723, 49, 1, '2025-02-22 12:48:41', '2025-02-22 12:48:43'),
(1365, 724, 48, 1, '2025-02-22 12:48:56', '2025-02-22 12:48:56'),
(1366, 724, 49, 1, '2025-02-22 12:48:56', '2025-02-22 12:48:57'),
(1367, 725, 48, 1, '2025-02-22 12:50:42', '2025-02-22 12:50:52'),
(1368, 725, 49, 1, '2025-02-22 12:50:42', '2025-02-22 12:50:42'),
(1369, 726, 48, 1, '2025-02-22 12:50:49', '2025-02-22 12:50:52'),
(1370, 726, 49, 1, '2025-02-22 12:50:49', '2025-02-22 12:50:49'),
(1371, 727, 48, 1, '2025-02-22 12:50:50', '2025-02-22 12:50:52'),
(1372, 727, 49, 1, '2025-02-22 12:50:50', '2025-02-22 12:50:50'),
(1373, 728, 48, 1, '2025-02-22 12:51:05', '2025-02-22 12:51:07'),
(1374, 728, 49, 1, '2025-02-22 12:51:05', '2025-02-22 12:51:05'),
(1375, 729, 48, 1, '2025-02-22 12:53:58', '2025-02-22 12:54:17'),
(1376, 729, 49, 1, '2025-02-22 12:53:58', '2025-02-22 12:53:58'),
(1377, 730, 48, 1, '2025-02-22 12:54:29', '2025-02-22 12:54:30'),
(1378, 730, 49, 1, '2025-02-22 12:54:29', '2025-02-22 12:54:29'),
(1379, 731, 48, 1, '2025-02-22 12:54:46', '2025-02-22 12:54:46'),
(1380, 731, 49, 1, '2025-02-22 12:54:46', '2025-02-22 12:54:48'),
(1381, 732, 48, 1, '2025-02-22 12:56:19', '2025-02-22 12:56:20'),
(1382, 732, 49, 1, '2025-02-22 12:56:19', '2025-02-22 12:56:19'),
(1383, 733, 48, 1, '2025-02-22 12:56:23', '2025-02-22 12:56:28'),
(1384, 733, 49, 1, '2025-02-22 12:56:23', '2025-02-22 12:56:23'),
(1385, 734, 48, 1, '2025-02-22 12:56:32', '2025-02-22 12:56:34'),
(1386, 734, 49, 1, '2025-02-22 12:56:32', '2025-02-22 12:56:32'),
(1387, 735, 48, 1, '2025-02-22 12:57:05', '2025-02-22 12:57:07'),
(1388, 735, 49, 1, '2025-02-22 12:57:05', '2025-02-22 12:57:05'),
(1389, 736, 48, 1, '2025-02-22 12:57:57', '2025-02-22 12:59:44'),
(1390, 736, 49, 1, '2025-02-22 12:57:57', '2025-02-22 12:57:57'),
(1391, 737, 48, 1, '2025-02-22 13:00:45', '2025-02-22 13:00:46'),
(1392, 737, 49, 1, '2025-02-22 13:00:45', '2025-02-22 13:00:45'),
(1393, 738, 48, 1, '2025-02-22 13:01:37', '2025-02-22 13:01:38'),
(1394, 738, 49, 1, '2025-02-22 13:01:37', '2025-02-22 13:01:37'),
(1395, 739, 48, 1, '2025-02-22 13:01:43', '2025-02-22 13:01:47'),
(1396, 739, 49, 1, '2025-02-22 13:01:43', '2025-02-22 13:01:43'),
(1397, 740, 48, 1, '2025-02-22 13:06:41', '2025-02-22 13:06:45'),
(1398, 740, 49, 1, '2025-02-22 13:06:41', '2025-02-22 13:06:41'),
(1399, 741, 48, 1, '2025-02-22 13:06:52', '2025-02-22 13:07:03'),
(1400, 741, 49, 1, '2025-02-22 13:06:52', '2025-02-22 13:06:52'),
(1401, 742, 48, 1, '2025-02-22 13:07:07', '2025-02-22 13:09:42'),
(1402, 742, 49, 1, '2025-02-22 13:07:07', '2025-02-22 13:07:07'),
(1403, 743, 48, 1, '2025-02-22 13:09:51', '2025-02-22 13:09:51'),
(1404, 743, 49, 1, '2025-02-22 13:09:51', '2025-02-22 13:09:53'),
(1405, 744, 48, 1, '2025-02-22 13:11:54', '2025-02-22 13:11:55'),
(1406, 744, 49, 1, '2025-02-22 13:11:54', '2025-02-22 13:11:54'),
(1407, 745, 48, 1, '2025-02-22 13:12:19', '2025-02-22 13:12:24'),
(1408, 745, 49, 1, '2025-02-22 13:12:19', '2025-02-22 13:12:19'),
(1409, 746, 48, 1, '2025-02-22 13:14:39', '2025-02-22 13:18:41'),
(1410, 746, 49, 1, '2025-02-22 13:14:39', '2025-02-22 13:14:39'),
(1411, 747, 48, 1, '2025-02-22 13:14:42', '2025-02-22 13:18:41'),
(1412, 747, 49, 1, '2025-02-22 13:14:42', '2025-02-22 13:14:42'),
(1413, 748, 48, 1, '2025-02-22 13:16:41', '2025-02-22 13:18:41'),
(1414, 748, 49, 1, '2025-02-22 13:16:41', '2025-02-22 13:16:41'),
(1415, 749, 48, 1, '2025-02-22 13:18:33', '2025-02-22 13:18:41'),
(1416, 749, 49, 1, '2025-02-22 13:18:33', '2025-02-22 13:18:33'),
(1417, 750, 48, 1, '2025-02-22 13:21:36', '2025-02-22 13:22:44'),
(1418, 750, 49, 1, '2025-02-22 13:21:36', '2025-02-22 13:21:36'),
(1419, 751, 48, 1, '2025-02-22 13:23:49', '2025-02-22 13:25:44'),
(1420, 751, 49, 1, '2025-02-22 13:23:49', '2025-02-22 13:23:49'),
(1421, 752, 48, 1, '2025-02-22 13:37:14', '2025-02-22 13:38:44'),
(1422, 752, 49, 1, '2025-02-22 13:37:14', '2025-02-22 13:37:14'),
(1423, 753, 48, 1, '2025-02-23 04:18:08', '2025-02-23 04:18:43'),
(1424, 753, 49, 1, '2025-02-23 04:18:08', '2025-02-23 04:18:08'),
(1425, 754, 48, 1, '2025-02-23 04:19:08', '2025-02-23 04:19:08'),
(1426, 754, 49, 1, '2025-02-23 04:19:08', '2025-02-23 04:19:08'),
(1427, 755, 48, 1, '2025-02-23 04:19:31', '2025-02-23 04:19:31'),
(1428, 755, 49, 1, '2025-02-23 04:19:31', '2025-02-23 04:19:31'),
(1429, 756, 48, 1, '2025-02-23 04:19:37', '2025-02-23 04:19:37'),
(1430, 756, 49, 1, '2025-02-23 04:19:37', '2025-02-23 04:19:37'),
(1431, 757, 48, 1, '2025-02-23 04:23:19', '2025-02-23 04:23:38'),
(1432, 757, 49, 1, '2025-02-23 04:23:19', '2025-02-23 04:23:19'),
(1433, 758, 48, 1, '2025-02-23 04:23:46', '2025-02-23 08:41:40'),
(1434, 758, 49, 1, '2025-02-23 04:23:46', '2025-02-23 04:23:46'),
(1435, 759, 48, 1, '2025-02-23 04:23:47', '2025-02-23 08:41:06'),
(1436, 759, 49, 1, '2025-02-23 04:23:47', '2025-02-23 04:23:47'),
(1437, 760, 48, 1, '2025-02-23 04:29:15', '2025-02-23 08:41:06'),
(1438, 760, 49, 1, '2025-02-23 04:29:15', '2025-02-23 04:29:15'),
(1439, 761, 48, 1, '2025-02-23 04:29:20', '2025-02-23 08:41:06'),
(1440, 761, 49, 1, '2025-02-23 04:29:20', '2025-02-23 04:29:20'),
(1441, 762, 48, 1, '2025-02-23 04:29:22', '2025-02-23 08:41:06'),
(1442, 762, 49, 1, '2025-02-23 04:29:22', '2025-02-23 04:29:22'),
(1443, 763, 48, 1, '2025-02-23 04:30:54', '2025-02-23 08:41:06'),
(1444, 763, 49, 1, '2025-02-23 04:30:54', '2025-02-23 04:30:54'),
(1445, 764, 48, 1, '2025-02-23 04:33:45', '2025-02-23 08:41:06'),
(1446, 764, 49, 1, '2025-02-23 04:33:45', '2025-02-23 04:33:45'),
(1447, 765, 48, 1, '2025-02-23 07:51:18', '2025-02-23 08:41:06'),
(1448, 765, 49, 1, '2025-02-23 07:51:18', '2025-02-23 07:51:18'),
(1449, 766, 48, 1, '2025-02-23 08:21:24', '2025-02-23 08:41:06'),
(1450, 766, 49, 1, '2025-02-23 08:21:24', '2025-02-23 08:21:24'),
(1451, 767, 48, 1, '2025-02-23 08:24:02', '2025-02-23 08:37:12'),
(1452, 767, 49, 1, '2025-02-23 08:24:02', '2025-02-23 08:24:02'),
(1453, 768, 48, 1, '2025-02-23 08:30:36', '2025-02-23 08:37:12'),
(1454, 768, 49, 1, '2025-02-23 08:30:36', '2025-02-23 08:30:36'),
(1455, 769, 48, 1, '2025-02-23 08:36:20', '2025-02-23 08:37:12'),
(1456, 769, 49, 1, '2025-02-23 08:36:20', '2025-02-23 08:36:20'),
(1457, 770, 48, 1, '2025-02-23 08:36:22', '2025-02-23 08:37:12'),
(1458, 770, 49, 1, '2025-02-23 08:36:22', '2025-02-23 08:36:22'),
(1459, 771, 48, 1, '2025-02-23 08:36:25', '2025-02-23 08:37:12'),
(1460, 771, 49, 1, '2025-02-23 08:36:25', '2025-02-23 08:36:25'),
(1461, 772, 48, 1, '2025-02-23 08:36:35', '2025-02-23 08:37:12'),
(1462, 772, 49, 1, '2025-02-23 08:36:35', '2025-02-23 08:36:35'),
(1463, 773, 48, 1, '2025-02-23 08:36:41', '2025-02-23 08:37:12'),
(1464, 773, 49, 1, '2025-02-23 08:36:41', '2025-02-23 08:36:41'),
(1465, 774, 48, 1, '2025-02-23 08:36:44', '2025-02-23 08:37:12'),
(1466, 774, 49, 1, '2025-02-23 08:36:44', '2025-02-23 08:36:44'),
(1467, 775, 48, 1, '2025-02-23 08:37:16', '2025-02-23 08:37:16'),
(1468, 775, 49, 1, '2025-02-23 08:37:16', '2025-02-23 08:37:23'),
(1469, 776, 48, 1, '2025-02-23 08:37:32', '2025-02-23 08:37:32'),
(1470, 776, 49, 1, '2025-02-23 08:37:32', '2025-02-23 08:37:32'),
(1471, 777, 48, 1, '2025-02-23 08:41:18', '2025-02-23 08:41:18'),
(1472, 777, 49, 1, '2025-02-23 08:41:18', '2025-02-23 08:41:18'),
(1473, 778, 48, 1, '2025-02-23 08:41:43', '2025-02-23 08:41:43'),
(1474, 778, 49, 1, '2025-02-23 08:41:43', '2025-02-23 08:41:43'),
(1475, 779, 48, 1, '2025-02-23 08:41:47', '2025-02-23 08:41:47'),
(1476, 779, 49, 1, '2025-02-23 08:41:47', '2025-02-23 08:41:53'),
(1477, 780, 48, 1, '2025-02-23 08:42:02', '2025-02-23 08:42:08'),
(1478, 780, 49, 1, '2025-02-23 08:42:02', '2025-02-23 08:42:02'),
(1479, 781, 48, 1, '2025-02-23 08:42:10', '2025-02-23 08:42:10'),
(1480, 781, 49, 1, '2025-02-23 08:42:10', '2025-02-23 08:42:10');

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
(31, 48, 'message', 536, 'aasd', 0, NULL, '2025-02-21 15:34:45', '2025-02-21 15:34:45'),
(32, 48, 'message', 537, 'c2', 0, NULL, '2025-02-21 16:00:23', '2025-02-21 16:00:23'),
(33, 49, 'message', 538, 'asdasd', 0, NULL, '2025-02-21 16:13:47', '2025-02-21 16:13:47'),
(34, 49, 'message', 539, 'asdas', 0, NULL, '2025-02-21 16:13:54', '2025-02-21 16:13:54'),
(35, 48, 'message', 540, 'Hi sir, aq pala nag book para match 18 birthday kasi ng anak q :>', 0, NULL, '2025-02-21 16:22:06', '2025-02-21 16:22:06'),
(36, 51, 'message', 541, 'Omkiii salamuchh pu', 0, NULL, '2025-02-21 16:22:46', '2025-02-21 16:22:46'),
(37, 51, 'message', 542, 'Hello sir, cancel ko po sana booking mo', 0, NULL, '2025-02-22 07:30:59', '2025-02-22 07:30:59'),
(38, 51, 'message', 543, 'Hello sir, cancel ko po sana booking mo', 0, NULL, '2025-02-22 07:30:59', '2025-02-22 07:30:59'),
(39, 51, 'message', 544, 'Hello sir, cancel ko po sana booking mo', 0, NULL, '2025-02-22 07:30:59', '2025-02-22 07:30:59'),
(40, 51, 'message', 545, 'Hello sir, cancel ko po sana booking mo', 0, NULL, '2025-02-22 07:31:06', '2025-02-22 07:31:06'),
(41, 51, 'message', 546, 'sirrr', 0, NULL, '2025-02-22 07:31:24', '2025-02-22 07:31:24'),
(42, 51, 'message', 547, 'as', 0, NULL, '2025-02-22 08:04:04', '2025-02-22 08:04:04'),
(43, 51, 'message', 548, 'asd', 0, NULL, '2025-02-22 08:32:32', '2025-02-22 08:32:32'),
(44, 50, 'message', 549, 'Seen', 0, NULL, '2025-02-22 08:32:38', '2025-02-22 08:32:38'),
(45, 49, 'message', 550, 'Seen', 0, NULL, '2025-02-22 08:32:43', '2025-02-22 08:32:43'),
(46, 50, 'message', 551, 'Hell o', 0, NULL, '2025-02-22 08:34:59', '2025-02-22 08:34:59'),
(47, 51, 'message', 552, 'asd', 0, NULL, '2025-02-22 08:35:05', '2025-02-22 08:35:05'),
(48, 49, 'message', 553, 'Hello', 0, NULL, '2025-02-22 08:35:40', '2025-02-22 08:35:40'),
(49, 49, 'message', 554, 'aasd', 0, NULL, '2025-02-22 08:35:53', '2025-02-22 08:35:53'),
(50, 48, 'message', 555, 'asd', 0, NULL, '2025-02-22 08:36:05', '2025-02-22 08:36:05'),
(51, 49, 'message', 556, 'asdas', 0, NULL, '2025-02-22 08:36:14', '2025-02-22 08:36:14'),
(52, 49, 'message', 557, 'asd', 0, NULL, '2025-02-22 08:36:18', '2025-02-22 08:36:18'),
(53, 50, 'message', 558, 'asdas', 0, NULL, '2025-02-22 08:37:59', '2025-02-22 08:37:59'),
(54, 49, 'message', 559, 'asdas', 0, NULL, '2025-02-22 08:38:04', '2025-02-22 08:38:04'),
(55, 48, 'message', 560, 'asdsa', 0, NULL, '2025-02-22 08:40:11', '2025-02-22 08:40:11'),
(56, 48, 'message', 561, 'asdas', 0, NULL, '2025-02-22 08:40:17', '2025-02-22 08:40:17'),
(57, 48, 'message', 562, 'asdas', 0, NULL, '2025-02-22 08:40:20', '2025-02-22 08:40:20'),
(58, 48, 'message', 563, 'asdasd', 0, NULL, '2025-02-22 08:40:22', '2025-02-22 08:40:22'),
(59, 49, 'message', 564, 'asda', 0, NULL, '2025-02-22 08:43:35', '2025-02-22 08:43:35'),
(60, 48, 'message', 565, 'sent', 0, NULL, '2025-02-22 08:48:55', '2025-02-22 08:48:55'),
(61, 49, 'message', 566, 'asdas', 0, NULL, '2025-02-22 08:49:16', '2025-02-22 08:49:16'),
(62, 49, 'message', 567, 'asdasknas', 0, NULL, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(63, 49, 'message', 568, 'sda', 0, NULL, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(64, 49, 'message', 569, 'ads', 0, NULL, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(65, 49, 'message', 570, 'asd', 0, NULL, '2025-02-22 08:49:52', '2025-02-22 08:49:52'),
(66, 49, 'message', 571, 'adadsas', 0, NULL, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(67, 49, 'message', 572, 'as', 0, NULL, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(68, 49, 'message', 573, 'da', 0, NULL, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(69, 49, 'message', 574, 's', 0, NULL, '2025-02-22 08:49:53', '2025-02-22 08:49:53'),
(70, 49, 'message', 575, 'ads', 0, NULL, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(71, 49, 'message', 576, 'sa', 0, NULL, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(72, 49, 'message', 577, 'a', 0, NULL, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(73, 49, 'message', 578, 'ds', 0, NULL, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(74, 49, 'message', 579, 'dsa', 0, NULL, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(75, 49, 'message', 580, 's', 0, NULL, '2025-02-22 08:49:54', '2025-02-22 08:49:54'),
(76, 49, 'message', 581, 'aasdas', 0, NULL, '2025-02-22 08:49:59', '2025-02-22 08:49:59'),
(77, 49, 'message', 582, 'asdas', 0, NULL, '2025-02-22 08:50:03', '2025-02-22 08:50:03'),
(78, 49, 'message', 583, 'ads3', 0, NULL, '2025-02-22 08:52:31', '2025-02-22 08:52:31'),
(79, 49, 'message', 584, 'asd', 0, NULL, '2025-02-22 08:52:37', '2025-02-22 08:52:37'),
(80, 49, 'message', 585, 'asd', 0, NULL, '2025-02-22 08:52:41', '2025-02-22 08:52:41'),
(81, 49, 'message', 586, 'New', 0, NULL, '2025-02-22 08:52:51', '2025-02-22 08:52:51'),
(82, 49, 'message', 587, 'New new', 0, NULL, '2025-02-22 08:52:58', '2025-02-22 08:52:58'),
(83, 49, 'message', 588, 'no new', 0, NULL, '2025-02-22 08:53:06', '2025-02-22 08:53:06'),
(84, 48, 'message', 589, 'asd', 0, NULL, '2025-02-22 08:55:02', '2025-02-22 08:55:02'),
(85, 48, 'message', 590, 'asdas', 0, NULL, '2025-02-22 08:55:04', '2025-02-22 08:55:04'),
(86, 48, 'message', 591, 'asd', 0, NULL, '2025-02-22 08:55:06', '2025-02-22 08:55:06'),
(87, 49, 'message', 592, 'asdas', 0, NULL, '2025-02-22 08:55:13', '2025-02-22 08:55:13'),
(88, 48, 'message', 593, 'asdas', 0, NULL, '2025-02-22 08:55:27', '2025-02-22 08:55:27'),
(89, 48, 'message', 594, 'asdasdas', 0, NULL, '2025-02-22 08:55:55', '2025-02-22 08:55:55'),
(90, 48, 'message', 595, 'asd', 0, NULL, '2025-02-22 08:58:00', '2025-02-22 08:58:00'),
(91, 48, 'message', 596, 'asdasd', 0, NULL, '2025-02-22 08:58:02', '2025-02-22 08:58:02'),
(92, 49, 'message', 597, 'asdas', 0, NULL, '2025-02-22 08:58:19', '2025-02-22 08:58:19'),
(93, 48, 'message', 598, 'asdas', 0, NULL, '2025-02-22 09:09:08', '2025-02-22 09:09:08'),
(94, 48, 'message', 599, 'asdasd', 0, NULL, '2025-02-22 09:09:22', '2025-02-22 09:09:22'),
(95, 49, 'message', 600, 'asdasd', 0, NULL, '2025-02-22 09:09:33', '2025-02-22 09:09:33'),
(96, 49, 'message', 601, 'asda', 0, NULL, '2025-02-22 09:09:35', '2025-02-22 09:09:35'),
(97, 48, 'message', 602, 'asdas+', 0, NULL, '2025-02-22 09:11:53', '2025-02-22 09:11:53'),
(98, 48, 'message', 603, 'asdas', 0, NULL, '2025-02-22 09:12:06', '2025-02-22 09:12:06'),
(99, 48, 'message', 604, 'asdas', 0, NULL, '2025-02-22 09:12:08', '2025-02-22 09:12:08'),
(100, 48, 'message', 605, 'asdas', 0, NULL, '2025-02-22 09:14:08', '2025-02-22 09:14:08'),
(101, 48, 'message', 606, 'asd', 0, NULL, '2025-02-22 09:14:13', '2025-02-22 09:14:13'),
(102, 48, 'message', 607, 'asdasd', 0, NULL, '2025-02-22 09:14:18', '2025-02-22 09:14:18'),
(103, 49, 'message', 608, 'asdas', 0, NULL, '2025-02-22 09:14:39', '2025-02-22 09:14:39'),
(104, 48, 'message', 609, 'asdas', 0, NULL, '2025-02-22 09:14:46', '2025-02-22 09:14:46'),
(105, 49, 'message', 610, 'asdas', 0, NULL, '2025-02-22 09:14:50', '2025-02-22 09:14:50'),
(106, 49, 'message', 611, 'asdas', 0, NULL, '2025-02-22 09:14:53', '2025-02-22 09:14:53'),
(107, 48, 'message', 612, 'asda', 0, NULL, '2025-02-22 09:17:53', '2025-02-22 09:17:53'),
(108, 48, 'message', 613, 'asda', 0, NULL, '2025-02-22 09:18:22', '2025-02-22 09:18:22'),
(109, 49, 'message', 614, 'asda', 0, NULL, '2025-02-22 09:18:31', '2025-02-22 09:18:31'),
(110, 49, 'message', 615, 'asdas', 0, NULL, '2025-02-22 09:18:34', '2025-02-22 09:18:34'),
(111, 49, 'message', 616, 'asdas', 0, NULL, '2025-02-22 09:20:37', '2025-02-22 09:20:37'),
(112, 49, 'message', 617, 'asdas', 0, NULL, '2025-02-22 09:20:41', '2025-02-22 09:20:41'),
(113, 48, 'message', 618, 'asda', 0, NULL, '2025-02-22 09:22:59', '2025-02-22 09:22:59'),
(114, 48, 'message', 619, 'assada', 0, NULL, '2025-02-22 09:23:05', '2025-02-22 09:23:05'),
(115, 48, 'message', 620, 'asdas', 0, NULL, '2025-02-22 09:23:06', '2025-02-22 09:23:06'),
(116, 48, 'message', 621, 'helo', 0, NULL, '2025-02-22 09:25:55', '2025-02-22 09:25:55'),
(117, 48, 'message', 622, 'as', 0, NULL, '2025-02-22 09:29:11', '2025-02-22 09:29:11'),
(118, 48, 'message', 623, 'asdas', 0, NULL, '2025-02-22 09:29:17', '2025-02-22 09:29:17'),
(119, 49, 'message', 624, 'asdas', 0, NULL, '2025-02-22 09:31:13', '2025-02-22 09:31:13'),
(120, 48, 'message', 625, 'asdas', 0, NULL, '2025-02-22 09:31:24', '2025-02-22 09:31:24'),
(121, 48, 'message', 626, 'asdas', 0, NULL, '2025-02-22 09:31:37', '2025-02-22 09:31:37'),
(122, 48, 'message', 627, 'sadas', 0, NULL, '2025-02-22 09:31:38', '2025-02-22 09:31:38'),
(123, 48, 'message', 628, 'asdas', 0, NULL, '2025-02-22 09:31:41', '2025-02-22 09:31:41'),
(124, 49, 'message', 629, 'asdas', 0, NULL, '2025-02-22 09:31:55', '2025-02-22 09:31:55'),
(125, 48, 'message', 630, 'Hello?', 0, NULL, '2025-02-22 11:53:01', '2025-02-22 11:53:01'),
(126, 48, 'message', 631, 'asd', 0, NULL, '2025-02-22 11:59:40', '2025-02-22 11:59:40'),
(127, 48, 'message', 632, 'asdas', 0, NULL, '2025-02-22 11:59:50', '2025-02-22 11:59:50'),
(128, 48, 'message', 633, 'asdas', 0, NULL, '2025-02-22 11:59:55', '2025-02-22 11:59:55'),
(129, 48, 'message', 634, 'asdas', 0, NULL, '2025-02-22 12:01:22', '2025-02-22 12:01:22'),
(130, 49, 'message', 635, 'asda', 0, NULL, '2025-02-22 12:01:31', '2025-02-22 12:01:31'),
(131, 48, 'message', 636, 'asdas', 0, NULL, '2025-02-22 12:03:05', '2025-02-22 12:03:05'),
(132, 49, 'message', 637, 'asdas', 0, NULL, '2025-02-22 12:03:11', '2025-02-22 12:03:11'),
(133, 49, 'message', 638, 'asdas', 0, NULL, '2025-02-22 12:03:14', '2025-02-22 12:03:14'),
(134, 48, 'message', 639, 'asda', 0, NULL, '2025-02-22 12:04:47', '2025-02-22 12:04:47'),
(135, 48, 'message', 640, 'asdas', 0, NULL, '2025-02-22 12:06:56', '2025-02-22 12:06:56'),
(136, 48, 'message', 641, 'adas', 0, NULL, '2025-02-22 12:09:33', '2025-02-22 12:09:33'),
(137, 48, 'message', 642, 'asdas', 0, NULL, '2025-02-22 12:09:46', '2025-02-22 12:09:46'),
(138, 48, 'message', 643, 'asdas', 0, NULL, '2025-02-22 12:09:49', '2025-02-22 12:09:49'),
(139, 48, 'message', 644, 'asdas', 0, NULL, '2025-02-22 12:09:52', '2025-02-22 12:09:52'),
(140, 48, 'message', 645, 'asasd', 0, NULL, '2025-02-22 12:11:54', '2025-02-22 12:11:54'),
(141, 48, 'message', 646, 'sadas', 0, NULL, '2025-02-22 12:12:25', '2025-02-22 12:12:25'),
(142, 48, 'message', 647, 'asda', 0, NULL, '2025-02-22 12:14:45', '2025-02-22 12:14:45'),
(143, 48, 'message', 648, 'asda', 0, NULL, '2025-02-22 12:14:56', '2025-02-22 12:14:56'),
(144, 48, 'message', 649, 'asdasd', 0, NULL, '2025-02-22 12:15:07', '2025-02-22 12:15:07'),
(145, 48, 'message', 650, 'asdas', 0, NULL, '2025-02-22 12:15:09', '2025-02-22 12:15:09'),
(146, 48, 'message', 651, 'asdas', 0, NULL, '2025-02-22 12:15:11', '2025-02-22 12:15:11'),
(147, 48, 'message', 652, 'asda', 0, NULL, '2025-02-22 12:15:12', '2025-02-22 12:15:12'),
(148, 48, 'message', 653, 'asdas', 0, NULL, '2025-02-22 12:15:13', '2025-02-22 12:15:13'),
(149, 48, 'message', 654, 'asda', 0, NULL, '2025-02-22 12:15:13', '2025-02-22 12:15:13'),
(150, 48, 'message', 655, 'asd', 0, NULL, '2025-02-22 12:15:14', '2025-02-22 12:15:14'),
(151, 48, 'message', 656, 'asdas', 0, NULL, '2025-02-22 12:15:21', '2025-02-22 12:15:21'),
(152, 48, 'message', 657, 'asd', 0, NULL, '2025-02-22 12:15:26', '2025-02-22 12:15:26'),
(153, 48, 'message', 658, 'asdas', 0, NULL, '2025-02-22 12:17:47', '2025-02-22 12:17:47'),
(154, 48, 'message', 659, 'asdasd', 0, NULL, '2025-02-22 12:17:53', '2025-02-22 12:17:53'),
(155, 48, 'message', 660, 'asdasd', 0, NULL, '2025-02-22 12:18:00', '2025-02-22 12:18:00'),
(156, 48, 'message', 661, 'asdas', 0, NULL, '2025-02-22 12:19:51', '2025-02-22 12:19:51'),
(157, 48, 'message', 662, 'asdas', 0, NULL, '2025-02-22 12:19:53', '2025-02-22 12:19:53'),
(158, 48, 'message', 663, 'asdasd', 0, NULL, '2025-02-22 12:20:01', '2025-02-22 12:20:01'),
(159, 48, 'message', 664, 'asdasd', 0, NULL, '2025-02-22 12:20:02', '2025-02-22 12:20:02'),
(160, 48, 'message', 665, 'asdasasgasg', 0, NULL, '2025-02-22 12:20:04', '2025-02-22 12:20:04'),
(161, 48, 'message', 666, 'asdas', 0, NULL, '2025-02-22 12:20:23', '2025-02-22 12:20:23'),
(162, 49, 'message', 667, 'asdasd', 0, NULL, '2025-02-22 12:21:03', '2025-02-22 12:21:03'),
(163, 48, 'message', 668, 'asdsa', 0, NULL, '2025-02-22 12:21:29', '2025-02-22 12:21:29'),
(164, 48, 'message', 669, 'asda', 0, NULL, '2025-02-22 12:21:32', '2025-02-22 12:21:32'),
(165, 48, 'message', 670, 'asdas', 0, NULL, '2025-02-22 12:21:37', '2025-02-22 12:21:37'),
(166, 48, 'message', 671, 'asdasdas', 0, NULL, '2025-02-22 12:21:41', '2025-02-22 12:21:41'),
(167, 48, 'message', 672, 'asdas', 0, NULL, '2025-02-22 12:21:48', '2025-02-22 12:21:48'),
(168, 48, 'message', 673, 'asdas', 0, NULL, '2025-02-22 12:22:16', '2025-02-22 12:22:16'),
(169, 48, 'message', 674, 'asdas', 0, NULL, '2025-02-22 12:22:19', '2025-02-22 12:22:19'),
(170, 48, 'message', 675, 'sdfsdfs', 0, NULL, '2025-02-22 12:22:23', '2025-02-22 12:22:23'),
(171, 48, 'message', 676, 'adas', 0, NULL, '2025-02-22 12:22:40', '2025-02-22 12:22:40'),
(172, 48, 'message', 677, 'asdasd', 0, NULL, '2025-02-22 12:22:46', '2025-02-22 12:22:46'),
(173, 48, 'message', 678, 'agaga', 0, NULL, '2025-02-22 12:22:48', '2025-02-22 12:22:48'),
(174, 49, 'message', 679, 'das', 0, NULL, '2025-02-22 12:25:46', '2025-02-22 12:25:46'),
(175, 48, 'message', 680, 'asdasd', 0, NULL, '2025-02-22 12:27:52', '2025-02-22 12:27:52'),
(176, 48, 'message', 681, 'asdasda', 0, NULL, '2025-02-22 12:28:30', '2025-02-22 12:28:30'),
(177, 49, 'message', 682, 'asdas', 0, NULL, '2025-02-22 12:34:05', '2025-02-22 12:34:05'),
(178, 49, 'message', 683, 'sda', 0, NULL, '2025-02-22 12:34:13', '2025-02-22 12:34:13'),
(179, 49, 'message', 684, 'asdasdsada', 0, NULL, '2025-02-22 12:34:15', '2025-02-22 12:34:15'),
(180, 50, 'message', 685, 'asd', 0, NULL, '2025-02-22 12:34:23', '2025-02-22 12:34:23'),
(181, 49, 'message', 686, 'das', 0, NULL, '2025-02-22 12:34:33', '2025-02-22 12:34:33'),
(182, 49, 'message', 687, 'adasda', 0, NULL, '2025-02-22 12:34:47', '2025-02-22 12:34:47'),
(183, 49, 'message', 688, 'asdasd', 0, NULL, '2025-02-22 12:34:52', '2025-02-22 12:34:52'),
(184, 48, 'message', 689, 'asdas', 0, NULL, '2025-02-22 12:35:03', '2025-02-22 12:35:03'),
(185, 48, 'message', 690, 'asdasd', 0, NULL, '2025-02-22 12:36:21', '2025-02-22 12:36:21'),
(186, 49, 'message', 691, 'asdasdas', 0, NULL, '2025-02-22 12:36:29', '2025-02-22 12:36:29'),
(187, 48, 'message', 692, 'asdasdasdasd', 0, NULL, '2025-02-22 12:36:53', '2025-02-22 12:36:53'),
(188, 48, 'message', 693, 'asdasdas', 0, NULL, '2025-02-22 12:38:15', '2025-02-22 12:38:15'),
(189, 48, 'message', 694, 'asdasd', 0, NULL, '2025-02-22 12:38:22', '2025-02-22 12:38:22'),
(190, 48, 'message', 695, 'asdasd', 0, NULL, '2025-02-22 12:38:23', '2025-02-22 12:38:23'),
(191, 48, 'message', 696, 'asdasdas', 0, NULL, '2025-02-22 12:38:39', '2025-02-22 12:38:39'),
(192, 48, 'message', 697, 'asdasd', 0, NULL, '2025-02-22 12:38:41', '2025-02-22 12:38:41'),
(193, 48, 'message', 698, 'asdasadss', 0, NULL, '2025-02-22 12:40:38', '2025-02-22 12:40:38'),
(194, 48, 'message', 699, 'asdasda', 0, NULL, '2025-02-22 12:40:39', '2025-02-22 12:40:39'),
(195, 49, 'message', 700, 'dassad', 0, NULL, '2025-02-22 12:40:45', '2025-02-22 12:40:45'),
(196, 31, 'message', 701, 'asdasds', 0, NULL, '2025-02-22 12:40:48', '2025-02-22 12:40:48'),
(197, 31, 'message', 702, 'asdasd', 0, NULL, '2025-02-22 12:40:49', '2025-02-22 12:40:49'),
(198, 31, 'message', 703, 'asdas', 0, NULL, '2025-02-22 12:40:50', '2025-02-22 12:40:50'),
(199, 31, 'message', 704, 'asdasdas', 0, NULL, '2025-02-22 12:40:55', '2025-02-22 12:40:55'),
(200, 31, 'message', 705, 'asdasda', 0, NULL, '2025-02-22 12:40:56', '2025-02-22 12:40:56'),
(201, 31, 'message', 706, 'afssf', 0, NULL, '2025-02-22 12:40:57', '2025-02-22 12:40:57'),
(202, 31, 'message', 707, 'asf', 0, NULL, '2025-02-22 12:40:57', '2025-02-22 12:40:57'),
(203, 31, 'message', 708, 'asg', 0, NULL, '2025-02-22 12:40:58', '2025-02-22 12:40:58'),
(204, 31, 'message', 709, 's', 0, NULL, '2025-02-22 12:40:58', '2025-02-22 12:40:58'),
(205, 31, 'message', 710, 'adsdasd', 0, NULL, '2025-02-22 12:41:02', '2025-02-22 12:41:02'),
(206, 48, 'message', 711, 'asdasd', 0, NULL, '2025-02-22 12:41:16', '2025-02-22 12:41:16'),
(207, 48, 'message', 712, 'asdasda', 0, NULL, '2025-02-22 12:41:28', '2025-02-22 12:41:28'),
(208, 48, 'message', 713, 'asdasda', 0, NULL, '2025-02-22 12:41:33', '2025-02-22 12:41:33'),
(209, 49, 'message', 714, 'daasdasda', 0, NULL, '2025-02-22 12:44:29', '2025-02-22 12:44:29'),
(210, 48, 'message', 715, 'asdads', 0, NULL, '2025-02-22 12:46:20', '2025-02-22 12:46:20'),
(211, 48, 'message', 716, 'asdasd', 0, NULL, '2025-02-22 12:46:25', '2025-02-22 12:46:25'),
(212, 48, 'message', 717, 'asdaasgas', 0, NULL, '2025-02-22 12:46:29', '2025-02-22 12:46:29'),
(213, 48, 'message', 718, 'omasmasoidmoasi', 0, NULL, '2025-02-22 12:46:32', '2025-02-22 12:46:32'),
(214, 48, 'message', 719, 'asdasd', 0, NULL, '2025-02-22 12:48:31', '2025-02-22 12:48:31'),
(215, 49, 'message', 720, 'asdasdas', 0, NULL, '2025-02-22 12:48:37', '2025-02-22 12:48:37'),
(216, 48, 'message', 721, 'asdasd', 0, NULL, '2025-02-22 12:48:39', '2025-02-22 12:48:39'),
(217, 48, 'message', 722, 'asdas', 0, NULL, '2025-02-22 12:48:40', '2025-02-22 12:48:40'),
(218, 49, 'message', 723, 'asdas', 0, NULL, '2025-02-22 12:48:41', '2025-02-22 12:48:41'),
(219, 49, 'message', 724, 'asdas', 0, NULL, '2025-02-22 12:48:56', '2025-02-22 12:48:56'),
(220, 48, 'message', 725, 'asdasd', 0, NULL, '2025-02-22 12:50:42', '2025-02-22 12:50:42'),
(221, 48, 'message', 726, 'asdasd', 0, NULL, '2025-02-22 12:50:49', '2025-02-22 12:50:49'),
(222, 48, 'message', 727, 'asdasd', 0, NULL, '2025-02-22 12:50:50', '2025-02-22 12:50:50'),
(223, 48, 'message', 728, 'asdasd', 0, NULL, '2025-02-22 12:51:05', '2025-02-22 12:51:05'),
(224, 48, 'message', 729, 'asdasd', 0, NULL, '2025-02-22 12:53:58', '2025-02-22 12:53:58'),
(225, 48, 'message', 730, 'asdas', 0, NULL, '2025-02-22 12:54:29', '2025-02-22 12:54:29'),
(226, 49, 'message', 731, 'asdasdas', 0, NULL, '2025-02-22 12:54:46', '2025-02-22 12:54:46'),
(227, 48, 'message', 732, 'asdas', 0, NULL, '2025-02-22 12:56:19', '2025-02-22 12:56:19'),
(228, 48, 'message', 733, 'asdasd', 0, NULL, '2025-02-22 12:56:23', '2025-02-22 12:56:23'),
(229, 48, 'message', 734, 'asdas', 0, NULL, '2025-02-22 12:56:32', '2025-02-22 12:56:32'),
(230, 48, 'message', 735, 'asdas', 0, NULL, '2025-02-22 12:57:05', '2025-02-22 12:57:05'),
(231, 48, 'message', 736, 'asdas', 0, NULL, '2025-02-22 12:57:57', '2025-02-22 12:57:57'),
(232, 48, 'message', 737, 'asdas', 0, NULL, '2025-02-22 13:00:45', '2025-02-22 13:00:45'),
(233, 48, 'message', 738, 'asdas', 0, NULL, '2025-02-22 13:01:37', '2025-02-22 13:01:37'),
(234, 48, 'message', 739, 'asdasd', 0, NULL, '2025-02-22 13:01:43', '2025-02-22 13:01:43'),
(235, 48, 'message', 740, 'asdas', 0, NULL, '2025-02-22 13:06:41', '2025-02-22 13:06:41'),
(236, 48, 'message', 741, 'asdas', 0, NULL, '2025-02-22 13:06:52', '2025-02-22 13:06:52'),
(237, 48, 'message', 742, 'asdasd', 0, NULL, '2025-02-22 13:07:07', '2025-02-22 13:07:07'),
(238, 49, 'message', 743, 'asdas', 0, NULL, '2025-02-22 13:09:51', '2025-02-22 13:09:51'),
(239, 48, 'message', 744, 'asdas', 0, NULL, '2025-02-22 13:11:54', '2025-02-22 13:11:54'),
(240, 48, 'message', 745, 'asdasd', 0, NULL, '2025-02-22 13:12:19', '2025-02-22 13:12:19'),
(241, 48, 'message', 746, 'asdas', 0, NULL, '2025-02-22 13:14:39', '2025-02-22 13:14:39'),
(242, 48, 'message', 747, 'asdas', 0, NULL, '2025-02-22 13:14:42', '2025-02-22 13:14:42'),
(243, 48, 'message', 748, 'asdas', 0, NULL, '2025-02-22 13:16:41', '2025-02-22 13:16:41'),
(244, 48, 'message', 749, 'asdas', 0, NULL, '2025-02-22 13:18:33', '2025-02-22 13:18:33'),
(245, 48, 'message', 750, 'asdas', 0, NULL, '2025-02-22 13:21:36', '2025-02-22 13:21:36'),
(246, 48, 'message', 751, 'asdas.', 0, NULL, '2025-02-22 13:23:49', '2025-02-22 13:23:49'),
(247, 48, 'message', 752, 'asdas', 0, NULL, '2025-02-22 13:37:14', '2025-02-22 13:37:14'),
(248, 48, 'message', 753, 'asdas', 0, NULL, '2025-02-23 04:18:08', '2025-02-23 04:18:08'),
(249, 49, 'message', 754, 'asdas', 0, NULL, '2025-02-23 04:19:08', '2025-02-23 04:19:08'),
(250, 48, 'message', 755, 'asdas', 0, NULL, '2025-02-23 04:19:31', '2025-02-23 04:19:31'),
(251, 48, 'message', 756, 'as', 0, NULL, '2025-02-23 04:19:37', '2025-02-23 04:19:37'),
(252, 48, 'message', 757, 'asdas', 0, NULL, '2025-02-23 04:23:19', '2025-02-23 04:23:19'),
(253, 48, 'message', 758, 'asda', 0, NULL, '2025-02-23 04:23:46', '2025-02-23 04:23:46'),
(254, 48, 'message', 759, 'asdas', 0, NULL, '2025-02-23 04:23:47', '2025-02-23 04:23:47'),
(255, 48, 'message', 760, 'asdas', 0, NULL, '2025-02-23 04:29:15', '2025-02-23 04:29:15'),
(256, 48, 'message', 761, 'asdas', 0, NULL, '2025-02-23 04:29:20', '2025-02-23 04:29:20'),
(257, 48, 'message', 762, 'asda', 0, NULL, '2025-02-23 04:29:22', '2025-02-23 04:29:22'),
(258, 48, 'message', 763, 'sada', 0, NULL, '2025-02-23 04:30:54', '2025-02-23 04:30:54'),
(259, 48, 'message', 764, 'dfs', 0, NULL, '2025-02-23 04:33:45', '2025-02-23 04:33:45'),
(260, 48, 'message', 765, 'asd', 0, NULL, '2025-02-23 07:51:18', '2025-02-23 07:51:18'),
(261, 48, 'message', 766, 'asdas', 0, NULL, '2025-02-23 08:21:24', '2025-02-23 08:21:24'),
(262, 48, 'message', 767, 'asd', 0, NULL, '2025-02-23 08:24:02', '2025-02-23 08:24:02'),
(263, 48, 'message', 768, 'asdas', 0, NULL, '2025-02-23 08:30:36', '2025-02-23 08:30:36'),
(264, 48, 'message', 769, 'sad', 0, NULL, '2025-02-23 08:36:20', '2025-02-23 08:36:20'),
(265, 48, 'message', 770, 'das', 0, NULL, '2025-02-23 08:36:22', '2025-02-23 08:36:22'),
(266, 48, 'message', 771, 'asdsa', 0, NULL, '2025-02-23 08:36:25', '2025-02-23 08:36:25'),
(267, 48, 'message', 772, 'asda', 0, NULL, '2025-02-23 08:36:35', '2025-02-23 08:36:35'),
(268, 48, 'message', 773, 'asdas', 0, NULL, '2025-02-23 08:36:41', '2025-02-23 08:36:41'),
(269, 48, 'message', 774, 'asdas', 0, NULL, '2025-02-23 08:36:44', '2025-02-23 08:36:44'),
(270, 49, 'message', 775, 'asdsa', 0, NULL, '2025-02-23 08:37:16', '2025-02-23 08:37:16'),
(271, 48, 'message', 776, 'asdasds', 0, NULL, '2025-02-23 08:37:32', '2025-02-23 08:37:32'),
(272, 49, 'message', 777, 'asd', 0, NULL, '2025-02-23 08:41:18', '2025-02-23 08:41:18'),
(273, 49, 'message', 778, 'sdasdas', 0, NULL, '2025-02-23 08:41:43', '2025-02-23 08:41:43'),
(274, 49, 'message', 779, 'asdas', 0, NULL, '2025-02-23 08:41:47', '2025-02-23 08:41:47'),
(275, 48, 'message', 780, 'asdas', 0, NULL, '2025-02-23 08:42:02', '2025-02-23 08:42:02'),
(276, 49, 'message', 781, 'sadas', 0, NULL, '2025-02-23 08:42:10', '2025-02-23 08:42:10');

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
(6, 31, 3, 1, 1, '2025-02-06 21:23:26', '2025-02-06 21:23:26');

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
  `is_Verified` enum('Verified','Not Verified') NOT NULL DEFAULT 'Not Verified',
  `verification_Token` text NOT NULL,
  `remember_token` text DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `reset_token` text DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `middlename`, `sex_id`, `user_type_id`, `birthdate`, `contact_number`, `address`, `profile_pic`, `bio`, `email`, `password`, `is_Verified`, `verification_Token`, `remember_token`, `token_expiry`, `reset_token`, `reset_token_expiry`, `created_at`, `updated_at`) VALUES
(30, 'Joevin', 'Ansoc', 'C', 1, 3, '2003-09-28', '09053258512', '6.952867833063975,122.08186864914751', NULL, NULL, 'joevinansoc870@gmail.com', '$2y$10$smhcx5OP9rFvCtpQEzLEBOWmqxYhglKgDpyt2y5ZLRQwpz.ghICc.', 'Verified', '', NULL, NULL, NULL, NULL, '2025-01-19 08:59:35', '2025-02-11 08:23:39'),
(31, 'Joevin', 'Ansoc', 'C', 1, 1, '2003-09-28', '09053258512', '6.920443579780613,122.08435059124896', '/profile_image_uploads/67ab01b974cef.jpg', '', 'joevinansoc871@gmail.com', '$2y$10$U0hitgecUwvWCunyGve9Qe6XOfTwoMknXxPX5vfxmf1IOdx0ffE6S', 'Verified', '', 'c1818c730f2c49d7180a58e444aeaab772a063ea1356864e814f84513ec1cc75', '2025-03-18 07:49:34', NULL, NULL, '2025-01-19 09:03:00', '2025-02-16 06:49:34'),
(42, 'Joevin', 'Ansoc', 'C', 1, 2, '2003-09-28', '09053258512', '6.947367699979677,122.07307815537207', NULL, NULL, 'visew97278@intady.com', '$2y$10$YhKF59J5ek51PistUlp9Lem3YTs8IDR.lz4UWOMICLXPc7zYUnxjC', 'Verified', '20bcac07695a547ee468b7cec085216a3b9bd07d4cfc4f06c4ed01377dda173d', NULL, NULL, NULL, NULL, '2025-02-11 11:42:21', '2025-02-11 11:47:35'),
(43, 'Joevin', 'Ansoc', 'C', 1, 2, '0321-12-23', '09053258512', '6.955736212950079,122.09300994261868', NULL, NULL, 'qrh8z1xskx@ibolinva.com', '$2y$10$JzXQY2DfrMBUHQq80un5uOWgna5EWwjtTCLZX6eVbDEJNj4gwo.sm', 'Verified', 'b7aa88c5de67441d95b0164ba36d0bf488db7d9400b32866e052f1710e7822f5', NULL, NULL, NULL, NULL, '2025-02-11 13:38:55', '2025-02-11 14:27:52'),
(48, 'Rei', 'Jjohn', 'O', 1, 1, '2004-02-19', '09708701567', '6.936992059517811,122.06462860107423', '/profile_image_uploads/67b8b5a695ff4.jpg', '', 'EH202201475@wmsu.edu.ph', '$2y$10$yWGK6stijKkIr.KNvolqDeY2Yainyrv77enrb0AlF3WUVtsEihbhq', 'Verified', '8a2b7d589967436a37d6db474038391635bd3f7eb2177b3ebbed546c4bc1710a', NULL, NULL, NULL, NULL, '2025-02-19 11:38:54', '2025-02-21 17:19:34'),
(49, 'Rei', 'Ohm', 'O', 1, 2, '2000-11-11', '09708701567', '6.929399522697131,122.07126617257019', NULL, NULL, 'johnmagno332@wmsu.edu.ph', '$2y$10$lsHAyMeJCfn79NmQFNMkbOuMDng0SuA0Vp.iqSb5uJbURF4bQ3Vrq', 'Verified', '555f618ca381ec1083bb3c6c7ea26609255c62d40d31a791e720c4955c483827', NULL, NULL, NULL, NULL, '2025-02-19 11:45:06', '2025-02-20 08:53:24'),
(50, 'MusTard', 'Jjohn', 'O', 1, 3, '2025-02-10', '09708701567', '6.9260860298120726,122.07630157470705', NULL, NULL, 'chrisbrown@gmail.com', '$2y$10$3i6ThrdsiX.ofNA0CHoqQump65c13rQsH9tRDDCEoAibhcuJ1E8xW', 'Verified', 'a61942b45011c36d2b8af2feb2821858f0b6691042daa86262c689ffddc9b934', '25f9d492b2755449e5d0d349fb0116b24bce9463e7ab498ad4e15728f2f6e0bc', '2025-03-23 16:56:23', NULL, NULL, '2025-02-21 15:49:58', '2025-02-21 16:04:10'),
(51, 'Rizal', 'Lammoa', 'O', 1, 2, '2025-01-31', '09708701567', '6.923359482967472,122.06555557277173', NULL, NULL, 'sample@gmail.com', '$2y$10$dNlo0M1fY/2Ny5NZB6xuKenS5T8yUyH80xYITCh4o5HFqwmCiRSha', 'Verified', '5fb03f79e048e9de71fd5e89c77dad25095ee08390ae2a52daa9c9d2428b270d', NULL, NULL, NULL, NULL, '2025-02-21 16:03:11', '2025-02-21 16:03:35');

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
(77, 'Marcian Garden Hotel', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Marcian Garden Hotel, Governor Camins Avenue, Canelar, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.918939461449293,122.06591129288428', 4800.00, 200, '[\"Wifi\",\"TV\",\"Free parking on premises\",\"Air Conditioned Room\",\"CCTV Cameras\",\"Dedicated workspace\",\"Pool\",\"Outdoor dining area\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\",\"Sprinkler\",\"Wine Bar\",\"Water and Beverage Dispenser\",\"Bidet\",\"Garment Rack\",\"Sanitary Products\",\"Hair Dryer\",\"Grooming Kit\",\"Fresh Towels\",\"Dressing and Vanity Area\"]', '[\"No smoking\",\"No pets\",\"No outside food and drinks\"]', 0, 500, 3, 2, 9, '{\"check_in\":\"14:00\",\"check_out\":\"12:00\"}', 31, 3, 1, '2025-02-16 06:54:24', '2025-02-19 14:01:29'),
(78, 'LM Metro Hotel', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'LM Metro Hotel, Don A. V. Toribio Street, Tetuan, Guiwan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.919940626575424,122.09259599447252', 18500.00, 150, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"CCTV Cameras\",\"Dedicated workspace\",\"Pool\",\"Exercise equipment\",\"Sound System\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\",\"Carbon monoxide alarm\",\"Sprinkler\",\"Buffet Table\",\"Wine Bar\",\"Water and Beverage Dispenser\",\"Bidet\",\"Garment Rack\",\"Sanitary Products\",\"Hair Dryer\",\"Grooming Kit\",\"Fresh Towels\",\"Dressing and Vanity Area\"]', '[\"No smoking\"]', 0, 500, 3, 2, 4, '{\"check_in\":\"00:00\",\"check_out\":\"14:00\"}', 31, 2, 1, '2025-02-18 11:15:50', '2025-02-18 12:36:47'),
(79, 'Astoria Grand Hotel', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Astoria Hotel, Mayor Cesar C. Climaco Avenue, Zone IV, Santa Catalina, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.909012900910168,122.07365423440935', 16000.00, 200, '[\"Wifi\",\"TV\",\"Air Conditioned Room\",\"CCTV Cameras\",\"Dedicated workspace\",\"Pool\",\"Pool table\",\"Sound System\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\",\"Carbon monoxide alarm\",\"Sprinkler\",\"Buffet Table\",\"Wine Bar\",\"Bidet\",\"Garment Rack\",\"Sanitary Products\",\"Hair Dryer\",\"Grooming Kit\",\"Fresh Towels\",\"Dressing and Vanity Area\"]', '[\"No smoking\",\"No pets\"]', 0, 1000, 3, 2, 6, '{\"check_in\":\"12:00\",\"check_out\":\"14:00\"}', 31, 2, 1, '2025-02-18 12:27:46', '2025-02-18 12:36:53'),
(80, 'WINN Hotel', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Mayor M.S. Jaldon Street, Canelar, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.910461424883246,122.0732867717743', 8900.00, 100, '[\"Wifi\",\"Free parking on premises\",\"Air Conditioned Room\",\"CCTV Cameras\",\"Dedicated workspace\",\"Pool\",\"Exercise equipment\",\"Karaoke System\",\"Sound System\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\",\"Carbon monoxide alarm\",\"Sprinkler\",\"Buffet Table\",\"Wine Bar\",\"Water and Beverage Dispenser\",\"Microwave Oven\",\"Bidet\",\"Cleaning Products and Tool\",\"Iron\",\"Garment Rack\",\"Sanitary Products\",\"Hair Dryer\",\"Grooming Kit\",\"Fresh Towels\",\"Dressing and Vanity Area\"]', '[\"No smoking\",\"No pets\"]', 0, 700, 3, 2, 1, '{\"check_in\":\"12:00\",\"check_out\":\"14:00\"}', 31, 2, 1, '2025-02-18 12:36:15', '2025-02-18 12:36:50'),
(81, 'Cozy Cove', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Claret School of Zamboanga City, El Paso Street, Canelar, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.914429932833263,122.06641387834681', 5000.00, 20, '[\"Kitchen\"]', '[\"No parties or events\"]', 0, 0, 3, 2, 0, '{\"check_in\":\"21:57\",\"check_out\":\"09:57\"}', 48, 2, 1, '2025-02-19 13:57:36', '2025-02-19 13:58:09'),
(82, 'Cave Logs', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Zamboanga City Bypass Road, Malagutay, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.944251246595978,122.0166320790304', 2000.00, 20, '[\"TV\"]', '[\"No parties or events\"]', 0, 0, 3, 3, 4, '{\"check_in\":\"22:06\",\"check_out\":\"10:06\"}', 48, 3, 1, '2025-02-19 14:06:32', '2025-02-19 14:09:07'),
(83, 'Outdoor Beach', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'LTP Complex, Cabatangan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.940843191976424,122.05611419572962', 8000.00, 20, '[\"Dedicated workspace\"]', '[]', 0, 0, 3, 4, 3, '{\"check_in\":\"10:14\",\"check_out\":\"22:14\"}', 48, 1, 1, '2025-02-19 14:14:24', '2025-02-19 14:14:24');

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
(1196, 78, '/venue_image_uploads/67b46be694675.jpg', '2025-02-18 11:15:50'),
(1197, 78, '/venue_image_uploads/67b46be6953f0.jpg', '2025-02-18 11:15:50'),
(1198, 78, '/venue_image_uploads/67b46be69579e.jpg', '2025-02-18 11:15:50'),
(1199, 78, '/venue_image_uploads/67b46be695a4b.jpg', '2025-02-18 11:15:50'),
(1200, 78, '/venue_image_uploads/67b46be695cc5.jpg', '2025-02-18 11:15:50'),
(1201, 78, '/venue_image_uploads/67b46be695eeb.jpg', '2025-02-18 11:15:50'),
(1202, 78, '/venue_image_uploads/67b46be696141.jpg', '2025-02-18 11:15:50'),
(1203, 78, '/venue_image_uploads/67b46be696397.jpg', '2025-02-18 11:15:50'),
(1204, 78, '/venue_image_uploads/67b46be6965dc.jpg', '2025-02-18 11:15:50'),
(1205, 78, '/venue_image_uploads/67b46be696835.jpg', '2025-02-18 11:15:50'),
(1206, 78, '/venue_image_uploads/67b46be696b72.jpg', '2025-02-18 11:15:50'),
(1207, 78, '/venue_image_uploads/67b46be696dce.jpg', '2025-02-18 11:15:50'),
(1208, 78, '/venue_image_uploads/67b46be697216.jpg', '2025-02-18 11:15:50'),
(1209, 78, '/venue_image_uploads/67b46be69782c.jpg', '2025-02-18 11:15:50'),
(1210, 78, '/venue_image_uploads/67b46be697b80.jpg', '2025-02-18 11:15:50'),
(1211, 78, '/venue_image_uploads/67b46be697e55.jpg', '2025-02-18 11:15:50'),
(1212, 78, '/venue_image_uploads/67b46be6980f3.jpg', '2025-02-18 11:15:50'),
(1213, 78, '/venue_image_uploads/67b46be698378.jpg', '2025-02-18 11:15:50'),
(1214, 78, '/venue_image_uploads/67b46be6985e0.jpg', '2025-02-18 11:15:50'),
(1215, 78, '/venue_image_uploads/67b46be698832.jpg', '2025-02-18 11:15:50'),
(1216, 79, '/venue_image_uploads/67b47cc2333f7.jpg', '2025-02-18 12:27:46'),
(1217, 79, '/venue_image_uploads/67b47cc233e96.jpg', '2025-02-18 12:27:46'),
(1218, 79, '/venue_image_uploads/67b47cc2343a1.jpg', '2025-02-18 12:27:46'),
(1219, 79, '/venue_image_uploads/67b47cc2349ce.jpg', '2025-02-18 12:27:46'),
(1220, 79, '/venue_image_uploads/67b47cc2355dc.jpg', '2025-02-18 12:27:46'),
(1221, 79, '/venue_image_uploads/67b47cc236012.jpg', '2025-02-18 12:27:46'),
(1222, 79, '/venue_image_uploads/67b47cc23655f.jpg', '2025-02-18 12:27:46'),
(1223, 80, '/venue_image_uploads/67b47ebf00056.png', '2025-02-18 12:36:15'),
(1224, 80, '/venue_image_uploads/67b47ebf0055c.png', '2025-02-18 12:36:15'),
(1225, 80, '/venue_image_uploads/67b47ebf00997.png', '2025-02-18 12:36:15'),
(1226, 80, '/venue_image_uploads/67b47ebf00e7f.png', '2025-02-18 12:36:15'),
(1227, 80, '/venue_image_uploads/67b47ebf01364.png', '2025-02-18 12:36:15'),
(1228, 80, '/venue_image_uploads/67b47ebf01851.png', '2025-02-18 12:36:15'),
(1390, 77, '/venue_image_uploads/67b18ba018778.jpeg', '2025-02-18 14:52:40'),
(1391, 77, '/venue_image_uploads/67b18ba0195ec.jpeg', '2025-02-18 14:52:40'),
(1392, 77, '/venue_image_uploads/67b18ba019892.jpeg', '2025-02-18 14:52:40'),
(1393, 77, '/venue_image_uploads/67b18ba019b5c.jpeg', '2025-02-18 14:52:40'),
(1394, 77, '/venue_image_uploads/67b18ba019e77.jpeg', '2025-02-18 14:52:40'),
(1395, 77, '/venue_image_uploads/67b18ba01a2f6.jpeg', '2025-02-18 14:52:40'),
(1396, 77, '/venue_image_uploads/67b18ba01a609.jpeg', '2025-02-18 14:52:40'),
(1397, 77, '/venue_image_uploads/67b18ba01a8bf.jpeg', '2025-02-18 14:52:40'),
(1398, 77, '/venue_image_uploads/67b18ba01ab6e.jpeg', '2025-02-18 14:52:40'),
(1399, 77, '/venue_image_uploads/67b18ba01ae1f.jpeg', '2025-02-18 14:52:40'),
(1400, 77, '/venue_image_uploads/67b18ba01b11f.jpeg', '2025-02-18 14:52:40'),
(1401, 77, '/venue_image_uploads/67b18ba01b501.jpeg', '2025-02-18 14:52:40'),
(1402, 77, '/venue_image_uploads/67b18ba01bb39.jpeg', '2025-02-18 14:52:40'),
(1403, 77, '/venue_image_uploads/67b49dcd3328c.jpeg', '2025-02-18 14:52:40'),
(1404, 77, '/venue_image_uploads/67b49dcd33909.jpeg', '2025-02-18 14:52:40'),
(1405, 81, '/venue_image_uploads/67b5e350f0e08.jpg', '2025-02-19 13:57:36'),
(1406, 81, '/venue_image_uploads/67b5e350f0f82.jpg', '2025-02-19 13:57:36'),
(1407, 81, '/venue_image_uploads/67b5e350f1040.jpg', '2025-02-19 13:57:36'),
(1408, 81, '/venue_image_uploads/67b5e350f10ee.jpg', '2025-02-19 13:57:36'),
(1409, 81, '/venue_image_uploads/67b5e350f1196.jpg', '2025-02-19 13:57:36'),
(1410, 81, '/venue_image_uploads/67b5e350f125b.jpg', '2025-02-19 13:57:36'),
(1411, 82, '/venue_image_uploads/67b5e568dfcaf.jpg', '2025-02-19 14:06:32'),
(1412, 82, '/venue_image_uploads/67b5e568dfe3a.jpg', '2025-02-19 14:06:32'),
(1413, 82, '/venue_image_uploads/67b5e568dff2a.jpg', '2025-02-19 14:06:32'),
(1414, 82, '/venue_image_uploads/67b5e568e00ee.jpg', '2025-02-19 14:06:32'),
(1415, 82, '/venue_image_uploads/67b5e568e0a7c.jpg', '2025-02-19 14:06:32'),
(1416, 83, '/venue_image_uploads/67b5e740d3935.jpg', '2025-02-19 14:14:24'),
(1417, 83, '/venue_image_uploads/67b5e740d3b49.jpg', '2025-02-19 14:14:24'),
(1418, 83, '/venue_image_uploads/67b5e740d3c12.jpg', '2025-02-19 14:14:24'),
(1419, 83, '/venue_image_uploads/67b5e740d3cde.jpg', '2025-02-19 14:14:24'),
(1420, 83, '/venue_image_uploads/67b5e740d3daf.jpg', '2025-02-19 14:14:24');

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
  ADD KEY `booking_ibfk_1` (`booking_guest_id`),
  ADD KEY `booking_ibfk_2` (`booking_dp_id`),
  ADD KEY `booking_ibfk_3` (`booking_venue_id`),
  ADD KEY `booking_ibfk_4` (`booking_status_id`),
  ADD KEY `booking_ibfk_7` (`booking_payment_status_id`),
  ADD KEY `booking_ibfk_6` (`booking_discount_id`),
  ADD KEY `booking_ibfk_8` (`booking_coupon_id`),
  ADD KEY `bookings_ibfk_9` (`booking_payment_method`);

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
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `idx_conversation_created` (`conversation_id`,`created_at`),
  ADD KEY `idx_sender_created` (`sender_id`,`created_at`),
  ADD KEY `idx_reply_lookup` (`reply_to_id`);

--
-- Indexes for table `message_status`
--
ALTER TABLE `message_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_message_user` (`message_id`,`user_id`),
  ADD KEY `idx_message_user` (`message_id`,`user_id`),
  ADD KEY `idx_user_read` (`user_id`,`is_read`),
  ADD KEY `idx_message_read` (`message_id`,`is_read`),
  ADD KEY `idx_user_conversation` (`user_id`,`created_at`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `booking_charges`
--
ALTER TABLE `booking_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `downpayment_sub`
--
ALTER TABLE `downpayment_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `host_application`
--
ALTER TABLE `host_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=782;

--
-- AUTO_INCREMENT for table `message_status`
--
ALTER TABLE `message_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1481;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sex_sub`
--
ALTER TABLE `sex_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `user_types_sub`
--
ALTER TABLE `user_types_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `venue_availability_sub`
--
ALTER TABLE `venue_availability_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venue_images`
--
ALTER TABLE `venue_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1421;

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
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`booking_guest_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`booking_dp_id`) REFERENCES `downpayment_sub` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`booking_venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_4` FOREIGN KEY (`booking_status_id`) REFERENCES `bookings_status_sub` (`id`),
  ADD CONSTRAINT `booking_ibfk_5` FOREIGN KEY (`booking_payment_status_id`) REFERENCES `payment_status_sub` (`id`),
  ADD CONSTRAINT `booking_ibfk_6` FOREIGN KEY (`booking_discount_id`) REFERENCES `mandatory_discount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_8` FOREIGN KEY (`booking_coupon_id`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `bookings_ibfk_9` FOREIGN KEY (`booking_payment_method`) REFERENCES `payment_method_sub` (`id`);

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
  ADD CONSTRAINT `fk_messages_conversation` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reply_to` FOREIGN KEY (`reply_to_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_status`
--
ALTER TABLE `message_status`
  ADD CONSTRAINT `fk_message_status_message` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `fk_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviews_venue_id` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
