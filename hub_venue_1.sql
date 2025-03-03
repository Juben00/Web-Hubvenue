-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2025 at 04:22 PM
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
(23, '2025-02-19', '2025-02-21', 200, 4800.00, 0.00, 1000.00, 1590.00, 2, 12190.00, 6095.00, 0.00, 3, 3, 7, 2, 31, 77, 1, 'asdasdas', 2, 'asdasdasdasdasd', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=23', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=23', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-18 08:07:15', '2025-02-18 08:08:35'),
(24, '2025-02-23', '2025-02-24', 200, 4800.00, 0.00, 500.00, 795.00, 1, 6095.00, 4266.50, 0.00, 3, 1, 7, 2, 31, 77, 1, 'asdasdas', 2, 'SAVE', NULL, 'http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=24', 'http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=24', 'Pending', 'Pending', '0000-00-00', '0000-00-00', '2025-02-18 10:07:08', '2025-02-18 10:08:36');

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
(11, 31, 'Ansoc, Joevin C.', 'Tetuan, Guiwan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '2003-09-28', 2, '2025-01-24 01:54:36', '2025-01-24 01:54:36');

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
(11, 'Philippine Passport', '/host_id_image/678cd66ce5370.png', 'UMID Card', '/host_id_image/678cd66ce5949.png', '2025-01-19 10:39:40');

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
  `type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(43, 'Joevin', 'Ansoc', 'C', 1, 2, '0321-12-23', '09053258512', '6.955736212950079,122.09300994261868', NULL, NULL, 'qrh8z1xskx@ibolinva.com', '$2y$10$JzXQY2DfrMBUHQq80un5uOWgna5EWwjtTCLZX6eVbDEJNj4gwo.sm', 'Verified', 'b7aa88c5de67441d95b0164ba36d0bf488db7d9400b32866e052f1710e7822f5', NULL, NULL, NULL, NULL, '2025-02-11 13:38:55', '2025-02-11 14:27:52');

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
(77, 'Marcian Garden Hotel', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Marcian Garden Hotel, Governor Camins Avenue, Canelar, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.918939461449293,122.06591129288428', 4800.00, 200, '[\"Wifi\",\"TV\",\"Free parking on premises\",\"Air Conditioned Room\",\"CCTV Cameras\",\"Dedicated workspace\",\"Pool\",\"Outdoor dining area\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\",\"Sprinkler\",\"Wine Bar\",\"Water and Beverage Dispenser\",\"Bidet\",\"Garment Rack\",\"Sanitary Products\",\"Hair Dryer\",\"Grooming Kit\",\"Fresh Towels\",\"Dressing and Vanity Area\"]', '[\"No smoking\",\"No pets\",\"No outside food and drinks\"]', 0, 500, 3, 2, 9, '{\"check_in\":\"14:00\",\"check_out\":\"12:00\"}', 31, 2, 1, '2025-02-16 06:54:24', '2025-02-18 14:52:40'),
(78, 'LM Metro Hotel', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'LM Metro Hotel, Don A. V. Toribio Street, Tetuan, Guiwan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.919940626575424,122.09259599447252', 18500.00, 150, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"CCTV Cameras\",\"Dedicated workspace\",\"Pool\",\"Exercise equipment\",\"Sound System\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\",\"Carbon monoxide alarm\",\"Sprinkler\",\"Buffet Table\",\"Wine Bar\",\"Water and Beverage Dispenser\",\"Bidet\",\"Garment Rack\",\"Sanitary Products\",\"Hair Dryer\",\"Grooming Kit\",\"Fresh Towels\",\"Dressing and Vanity Area\"]', '[\"No smoking\"]', 0, 500, 3, 2, 4, '{\"check_in\":\"00:00\",\"check_out\":\"14:00\"}', 31, 2, 1, '2025-02-18 11:15:50', '2025-02-18 12:36:47'),
(79, 'Astoria Grand Hotel', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Astoria Hotel, Mayor Cesar C. Climaco Avenue, Zone IV, Santa Catalina, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.909012900910168,122.07365423440935', 16000.00, 200, '[\"Wifi\",\"TV\",\"Air Conditioned Room\",\"CCTV Cameras\",\"Dedicated workspace\",\"Pool\",\"Pool table\",\"Sound System\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\",\"Carbon monoxide alarm\",\"Sprinkler\",\"Buffet Table\",\"Wine Bar\",\"Bidet\",\"Garment Rack\",\"Sanitary Products\",\"Hair Dryer\",\"Grooming Kit\",\"Fresh Towels\",\"Dressing and Vanity Area\"]', '[\"No smoking\",\"No pets\"]', 0, 1000, 3, 2, 6, '{\"check_in\":\"12:00\",\"check_out\":\"14:00\"}', 31, 2, 1, '2025-02-18 12:27:46', '2025-02-18 12:36:53'),
(80, 'WINN Hotel', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Mayor M.S. Jaldon Street, Canelar, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.910461424883246,122.0732867717743', 8900.00, 100, '[\"Wifi\",\"Free parking on premises\",\"Air Conditioned Room\",\"CCTV Cameras\",\"Dedicated workspace\",\"Pool\",\"Exercise equipment\",\"Karaoke System\",\"Sound System\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\",\"Carbon monoxide alarm\",\"Sprinkler\",\"Buffet Table\",\"Wine Bar\",\"Water and Beverage Dispenser\",\"Microwave Oven\",\"Bidet\",\"Cleaning Products and Tool\",\"Iron\",\"Garment Rack\",\"Sanitary Products\",\"Hair Dryer\",\"Grooming Kit\",\"Fresh Towels\",\"Dressing and Vanity Area\"]', '[\"No smoking\",\"No pets\"]', 0, 700, 3, 2, 1, '{\"check_in\":\"12:00\",\"check_out\":\"14:00\"}', 31, 2, 1, '2025-02-18 12:36:15', '2025-02-18 12:36:50');

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
(1404, 77, '/venue_image_uploads/67b49dcd33909.jpeg', '2025-02-18 14:52:40');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `booking_charges`
--
ALTER TABLE `booking_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_types_sub`
--
ALTER TABLE `user_types_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `venue_availability_sub`
--
ALTER TABLE `venue_availability_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venue_images`
--
ALTER TABLE `venue_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1405;

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
