-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2025 at 01:58 PM
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
(123, 31, 61, '2025-01-23 17:21:09', '2025-01-23 17:21:09');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `venue_id`, `discount_code`, `discount_type`, `discount_value`, `expiration_date`, `created_at`, `updated_at`) VALUES
(1, NULL, 'SAVE10', 'percentage', 10.00, '2024-12-25 20:40:37', '2025-01-24 02:07:46', '2025-01-24 02:07:46'),
(2, NULL, 'SAVE20', 'percentage', 20.00, '2024-12-25 20:40:37', '2025-01-24 02:07:46', '2025-01-24 02:07:46'),
(3, NULL, 'SAVE30', 'percentage', 30.00, '2025-12-25 20:40:37', '2025-01-24 02:07:46', '2025-01-24 02:07:46'),
(4, NULL, 'none', 'percentage', 0.00, NULL, '2025-01-24 02:07:46', '2025-01-24 02:07:46');

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
(5, 31, 'PWD', 'Joevin Ansoc', '126215090018', '/mandatory_discount_id/6795deb68ae1a.png', 'Active', '2025-01-26 07:05:26', '2025-01-26 07:06:12', 20.00);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `middlename`, `sex_id`, `user_type_id`, `birthdate`, `contact_number`, `address`, `profile_pic`, `bio`, `email`, `password`, `created_at`, `updated_at`) VALUES
(30, 'Joevin', 'Ansoc', 'C', 1, 3, '2003-09-28', '09053258512', '6.952867833063975,122.08186864914751', NULL, NULL, 'joevinansoc870@gmail.com', '$2y$10$smhcx5OP9rFvCtpQEzLEBOWmqxYhglKgDpyt2y5ZLRQwpz.ghICc.', '2025-01-19 08:59:35', '2025-01-19 09:01:39'),
(31, 'Joevin', 'Ansoc', 'C', 1, 1, '2003-09-28', '09053258512', '6.92106841695142,122.08812713302906', NULL, '', 'joevinansoc871@gmail.com', '$2y$10$U0hitgecUwvWCunyGve9Qe6XOfTwoMknXxPX5vfxmf1IOdx0ffE6S', '2025-01-19 09:03:00', '2025-01-19 10:40:03');

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
(61, 'Marcian Convention Center', 'A versatile and elegantly designed space featuring modern amenities and customizable layouts to suit various needs. With its convenient location, ample parking, and dedicated staff, it ensures a seamless and memorable experience for all occasions.', 'Marcian Convention center, Governor Camins Avenue, Zone Ⅱ, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Pilipinas', '6.918710471255118,122.06581115721748', 3800.00, 200, '[\"Wifi\",\"TV\",\"Kitchen\",\"Free parking on premises\",\"Air conditioning\",\"Dedicated workspace\",\"Pool\",\"Pool table\",\"Piano\",\"Exercise equipment\",\"Smoke alarm\",\"First aid kit\",\"Fire extinguisher\"]', '[\"No smoking\",\"No pets\",\"No outside food and drinks\"]', 0, 0, 2, 2, 11, '{\"check_in\":\"14:00\",\"check_out\":\"12:00\"}', 31, 2, 1, '2025-01-23 17:06:12', '2025-01-27 12:34:44');

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
(463, 61, '/venue_image_uploads/6792770480dcd.jpeg', '2025-01-27 12:34:44');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `booking_charges`
--
ALTER TABLE `booking_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sex_sub`
--
ALTER TABLE `sex_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_types_sub`
--
ALTER TABLE `user_types_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `venue_availability_sub`
--
ALTER TABLE `venue_availability_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venue_images`
--
ALTER TABLE `venue_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=464;

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
