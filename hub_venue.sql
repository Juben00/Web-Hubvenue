-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 04:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;00000000000000000000000000

--
-- Database: `hub_venue`
--

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
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `host_application`
--

INSERT INTO `host_application` (`id`, `userId`, `fullname`, `address`, `birthdate`, `status_id`) VALUES
(5, 2, 'Ansoc, Joevin C.', 'Veterans Avenue, Zone III, Santa Catalina, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', '2003-09-28', 1);

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
(5, 'Philippine Passport', '/host_id_image/67321f17c3abe.jpg', 'Driver&#039;s License', '/host_id_image/67321f17c3eb9.jpg', '2024-11-11 15:13:27');

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
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `middlename`, `sex_id`, `user_type_id`, `birthdate`, `contact_number`, `address`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Joevin', 'Ansoc', 'C', 1, 3, '2003-09-28', '09053258512', 'Veterans Avenue, Zone III, Santa Catalina, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 'joevinansoc870@gmail.com', '$2y$10$oZOd4iRtyixA/HUBET5Wmuj.6I6jvJ911JtmUBFAUjlOIb.ckS4Km', '2024-11-06 18:18:45', '2024-11-11 00:48:03'),
(2, 'Joevin', 'Ansoc', 'C', 1, 2, '2003-09-28', '09053258512', 'Veterans Avenue, Zone III, Santa Catalina, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 'joevinansoc871@gmail.com', '$2y$10$l365/PHYVfu0zelT5t9YNO6R4ihGg6oOGNMKE2OS8hGTPRBV3za2e', '2024-11-07 03:19:46', '2024-11-11 00:47:57'),
(3, 'Jorica Sher', 'Alejandro', 'L', 2, 2, '2004-06-17', '09053258512', 'Veterans Avenue, Zone III, Santa Catalina, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 'joricasheralejandro@yahoo.com', '$2y$10$09zM7efNo0nYI7TTKCdc3u/ByH7HmMKrBZq8bif1QfODcL9VJ4Isa', '2024-11-09 14:50:31', '2024-11-11 00:47:50'),
(4, 'Joreen Jeay', 'Alejandro', 'L', 2, 2, '2004-06-17', '09954687923', 'Veterans Avenue, Zone III, Santa Catalina, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 'joreenjeayalejandro@yahoo.com', '$2y$10$.7iXs5OGrAZ3jHdADTyd2.omDREXvaRgwtCv3hcs/O/DO/YhYMUsu', '2024-11-09 14:53:25', '2024-11-11 00:47:43'),
(5, 'Ray Vincent', 'Concepcion', 'D.S', 1, 2, '2003-04-04', '09950331778', 'Veterans Avenue, Zone III, Santa Catalina, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 'rayvincent@gmail.com', '$2y$10$QdJ9AkFqFm.gEEP3Vs/d9.oNVc0HbNw.Iw.z0qGJMp5IQvuj1KS2a', '2024-11-11 00:46:32', '2024-11-11 00:46:32');

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
  `location` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `amenities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`amenities`)),
  `entrance` int(11) NOT NULL,
  `cleaning` int(11) NOT NULL,
  `venue_tag` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `availability_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `name`, `description`, `location`, `price`, `capacity`, `amenities`, `entrance`, `cleaning`, `venue_tag`, `host_id`, `status_id`, `availability_id`, `created_at`, `updated_at`) VALUES
(22, 'Santiago Resort Room 1', 'This Resort offers wide range of activities suitable for all ages.', 'Cabatangan, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 500.00, 5, '[\"Pool\",\"Karaoke\",\"Duyan Spot\",\"Shower\",\"Comfort Rooms\",\"Cottages\"]', 100, 250, 1, 1, 2, 1, '2024-11-07 04:10:40', '2024-11-08 17:17:47'),
(23, 'Garden Orchid Room 301', 'Garden Orchid Room 301 offers a serene and luxurious escape, perfectly blending comfort and elegance. Located on the garden side of the resort, this room provides a peaceful view of lush greenery and vibrant orchids in bloom. Designed with a modern aesthetic and warm tones, it features a plush king-size bed, soft lighting, and natural wood accents that enhance the tranquil atmosphere.', 'Garden Orchid Hotel and Resort Corporation, Governor Camins Avenue, Zone Ⅱ, Baliwasan, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 4800.00, 3, '[\"Pool\",\"WiFi\",\"Air-conditioned Room\",\"Smart TV\"]', 0, 500, 1, 1, 2, 1, '2024-11-07 07:14:47', '2024-11-11 15:22:55'),
(24, 'Rest House', 'Escape to tranquility at our charming rest house, designed for relaxation and comfort. Nestled in a quiet, scenic area, this spacious and well-furnished rest house offers a serene atmosphere perfect for families, couples, or solo travelers. Featuring a warm, welcoming ambiance, the interior boasts comfortable living spaces, a fully-equipped kitchen, and cozy bedrooms that ensure a restful stay.', 'Sinunoc, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 5600.00, 15, '[\"Private Pool\",\"Billiard Hall\",\"2 Queen-size beds\",\"Air-conditioned\",\"Smart TV\"]', 0, 0, 1, 1, 2, 1, '2024-11-07 08:45:33', '2024-11-07 15:50:04'),
(30, 'Astoria Regency', 'Astoria Regency is a stylish and versatile reception hall, perfect for hosting memorable events and gatherings. Known for its elegant design and spacious layout, it provides a sophisticated setting ideal for weddings, corporate functions, and social events.', 'Astoria Regency Convention Center, Pasonanca Road, Luyahan Urban Poor Subdivision, Pasonanca, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 5000.00, 50, '[\"Pool\",\"Hall\",\"Sound System\",\"Free Parking Space\",\"Tables and Chairs\"]', 100, 0, 2, 1, 2, 1, '2024-11-08 17:49:18', '2024-11-08 17:49:48'),
(31, 'Astoria Hotel', 'The venue offers exceptional amenities, flexible seating arrangements, and a warm ambiance, ensuring guests experience both comfort and luxury. With its commitment to quality service, Astoria Hotel makes any occasion truly unforgettable.', 'Astoria Hotel, Mayor Cesar C. Climaco Avenue, Zone IV, Santa Catalina, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 5899.00, 100, '[\"Pool\",\"Hall\",\"Sound System\",\"Free Parking Space\",\"Tables and Chairs\"]', 0, 250, 2, 1, 2, 1, '2024-11-08 17:58:59', '2024-11-08 17:59:08'),
(32, 'adasdasdasdas', 'asdasd', 'Zamboanga City Golf Club and Beach Resort, 1st Road, Lopez Subdivision, Calarian, Zamboanga City, Zamboanga Peninsula, 7000, Philippines', 123.00, 213, '[\"asdasdas\"]', 3123, 1, 1, 1, 1, 1, '2024-11-11 13:33:10', '2024-11-11 13:33:10');

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
(23, 22, '/venue_image_uploads/672c3dc0cad12.jpg', '2024-11-07 04:10:40'),
(24, 22, '/venue_image_uploads/672c3dc0cb590.jpg', '2024-11-07 04:10:40'),
(25, 22, '/venue_image_uploads/672c3dc0cba57.jpg', '2024-11-07 04:10:40'),
(26, 23, '/venue_image_uploads/672c68e737a10.jpg', '2024-11-07 07:14:47'),
(27, 23, '/venue_image_uploads/672c68e7383fb.jpg', '2024-11-07 07:14:47'),
(28, 23, '/venue_image_uploads/672c68e73894f.jpg', '2024-11-07 07:14:47'),
(29, 23, '/venue_image_uploads/672c68e738e02.jpg', '2024-11-07 07:14:47'),
(30, 23, '/venue_image_uploads/672c68e7393ee.jpg', '2024-11-07 07:14:47'),
(31, 24, '/venue_image_uploads/672c7e2d5a0b3.jpg', '2024-11-07 08:45:33'),
(32, 24, '/venue_image_uploads/672c7e2d5a946.jpg', '2024-11-07 08:45:33'),
(43, 30, '/venue_image_uploads/672e4f1ebefb3.jpg', '2024-11-08 17:49:18'),
(44, 30, '/venue_image_uploads/672e4f1ebf45c.jpg', '2024-11-08 17:49:18'),
(45, 30, '/venue_image_uploads/672e4f1ebf88c.jpg', '2024-11-08 17:49:18'),
(46, 30, '/venue_image_uploads/672e4f1ebfd91.jpg', '2024-11-08 17:49:18'),
(47, 30, '/venue_image_uploads/672e4f1ec0123.jpg', '2024-11-08 17:49:18'),
(48, 31, '/venue_image_uploads/672e516372dfd.jpg', '2024-11-08 17:58:59'),
(49, 31, '/venue_image_uploads/672e5163738e3.jpg', '2024-11-08 17:58:59'),
(50, 31, '/venue_image_uploads/672e516373e1e.jpg', '2024-11-08 17:58:59'),
(51, 31, '/venue_image_uploads/672e5163742fc.jpg', '2024-11-08 17:58:59'),
(52, 32, '/venue_image_uploads/6732079604ac9.jpg', '2024-11-11 13:33:10');

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
  ADD KEY `fk_venue_tag_id` (`venue_tag`);

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
-- AUTO_INCREMENT for table `host_application`
--
ALTER TABLE `host_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `host_application_status_sub`
--
ALTER TABLE `host_application_status_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sex_sub`
--
ALTER TABLE `sex_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_types_sub`
--
ALTER TABLE `user_types_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `venue_availability_sub`
--
ALTER TABLE `venue_availability_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venue_images`
--
ALTER TABLE `venue_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
  ADD CONSTRAINT `fk_host_id` FOREIGN KEY (`host_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_status_id` FOREIGN KEY (`status_id`) REFERENCES `venue_status_sub` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
