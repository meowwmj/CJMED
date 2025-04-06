-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 06:38 PM
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
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(20) NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(100) CHARACTER SET latin7 COLLATE latin7_general_cs NOT NULL,
  `password` varchar(100) CHARACTER SET latin7 COLLATE latin7_general_cs NOT NULL,
  `address` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `agency_id` varchar(50) NOT NULL,
  `photo` varchar(700) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `phone`, `username`, `password`, `address`, `agency_id`, `photo`, `status`) VALUES
(22, 'Jerriecho Herrera', 'jerriechoclemente20@gmail.com', '09753029123', 'meowwmj', 'Helloimback7!', 'Manila, Philippines', '2619', 'admin25c471b48c394f657a5dffc08bf91113.png', 'active'),
(34, 'qwertyui', 'marquez.ericson@yahoo.com', '2345678ui', 'sdfghjkl', 'sdfghjm,', 'sdfghjk', '1871', '', 'active'),
(59, 'meowmmj', 'meowwmj@gmail.com', '09187534305', 'admin', 'Admin123!', 'malolos, bulacan', '3005', '', 'active'),
(60, 'mj santos', 'maryjoycesantos1207@gmail.com', '09187534305', 'admin', 'Admin123!', 'malolos, bulacan', '2378', '', 'active'),
(61, 'admin', 'admin@gmail.com', '09187534305', 'admin', 'Admin123!', 'malolos, bulacan', '6336', '', 'active'),
(62, 'meowmmj', 'santosmaryjoyce47@gmail.com', '4545454545', 'admin2', 'Admin123!', 'malolos', '5907', '', 'active'),
(63, 'admin', 'admin12@gmail.com', '1111111111111111111111', 'admin2', 'Admin123!', 'japan', '6516', '', 'active'),
(64, 'dfsfda', 'admin2@gmail.com', '2323233', 'admin3', 'Co+ZXQv3G1+SFL7xo2QImQ==', 'japann', '5812', '', 'active'),
(65, 'mj santos', 'santosmaryjoyce467@gmail.com', '4343344', 'admin4', 'tojONtL2hbW34PazqBgOhQ==', 'cebu', '3882', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE `agency` (
  `id` int(11) NOT NULL,
  `agency_id` varchar(50) NOT NULL,
  `agency_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `personincharge` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `photo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`id`, `agency_id`, `agency_name`, `phone_number`, `email`, `personincharge`, `username`, `password`, `state`, `address`, `photo`) VALUES
(9, '7623', 'Bulacan Medical Emergency Rescue Team- BMERT', '09123456789', 'BMERT@gmail.com', 'Jose Raymundo Carlos', 'agency', 'Agency@1', 'Bulacan', 'Malolos, Bulacan', 'agencye6a7623ea51e931e010e38b8d8a661cc.jpg'),
(10, '5982', 'Bulacan Red Cross', '923-407-9909', 'bulacan@redcross.org.ph', 'Ms. Rizza Cansino', 'Bulacan Red Cross', 'agency', 'Bulacan Red Cross', 'Capitol Compound, Barangay Guinhawa, Malolos', 'agency17c3529f0ce915a957750a30d846762a.jpg'),
(11, '8558', 'Bulacan PDRRMC Operation Center', '911 or 791-0566', 'pdrrmo@bulacan.gov.ph', 'Manuel M. Lukban, Jr.', 'PDRRMC', 'PDRRMC', 'Bulacan', 'Capitol Compound, Malolos, 3000 Bulacan', 'agency2e8da3889c96c4e3528a4ea07f086ea4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `emergency`
--

CREATE TABLE `emergency` (
  `id` int(11) NOT NULL,
  `emergency_id` int(11) NOT NULL,
  `agency_id` varchar(50) CHARACTER SET latin7 COLLATE latin7_general_cs NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `age` int(11) NOT NULL,
  `emergency_category` varchar(255) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `address` text NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `dates` date NOT NULL,
  `injury` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency`
--

INSERT INTO `emergency` (`id`, `emergency_id`, `agency_id`, `patient_name`, `phone`, `age`, `emergency_category`, `latitude`, `longitude`, `address`, `status`, `dates`, `injury`, `description`, `created_at`, `deleted_at`) VALUES
(8, 7123, '5982', 'users', '09123456789', 12, 'Fire Emergencies', 14.82363200, 120.86837800, 'Saint Lorraine Village, St. Peter Village, Guiguinto, Bulacan, Central Luzon, 3015, Philippines', 'Pending', '0000-00-00', 'sasas', 'asdsdadasd', '2025-03-30 10:26:59', NULL),
(9, 7977, '7623', 'mj santos', '4343344', 9, 'Medical Emergency', 14.82379600, 120.86832400, 'Saint Lorraine Village, St. Peter Village, Guiguinto, Bulacan, Central Luzon, 3015, Philippines', 'Pending', '0000-00-00', 'heart attck', 'shesh', '2025-03-30 11:15:09', NULL),
(10, 8077, '8558', 'mj santos', '4343344', 22, 'Vehicular Accident', 14.82377700, 120.86834000, 'Saint Lorraine Village, St. Peter Village, Guiguinto, Bulacan, Central Luzon, 3015, Philippines', 'Pending', '0000-00-00', 'zzz', '222', '2025-03-30 13:09:50', NULL),
(11, 7193, '8558', 'mj santos', '4343344', 55, 'Medical Emergency', 14.82377700, 120.86834000, 'Saint Lorraine Village, St. Peter Village, Guiguinto, Bulacan, Central Luzon, 3015, Philippines', 'Pending', '0000-00-00', 'dggfg', 'dgfgfd', '2025-03-30 13:10:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emergency_history`
--

CREATE TABLE `emergency_history` (
  `id` int(11) NOT NULL,
  `emergency_category` varchar(255) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `agency_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_history`
--

INSERT INTO `emergency_history` (`id`, `emergency_category`, `agency_id`, `agency_name`, `address`, `created_at`, `deleted_at`) VALUES
(1, 'Landslide', 7623, NULL, 'Saint Lorraine Village, St. Peter Village, Guiguinto, Bulacan, Central Luzon, 3015, Philippines', '2025-03-30 15:07:51', '2025-03-30 18:22:04'),
(2, 'Landslide', 7623, NULL, 'Saint Lorraine Village, St. Peter Village, Guiguinto, Bulacan, Central Luzon, 3015, Philippines', '2025-03-30 15:43:36', '2025-03-30 18:26:37'),
(3, 'Typhoon', 5982, NULL, 'Saint Lorraine Village, St. Peter Village, Guiguinto, Bulacan, Central Luzon, 3015, Philippines', '2025-03-30 15:13:34', '2025-03-30 19:01:19'),
(4, 'Accident', 5982, NULL, 'Saint Lorraine Village, St. Peter Village, Guiguinto, Bulacan, Central Luzon, 3015, Philippines', '2025-03-30 16:42:03', '2025-03-30 19:07:59');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_type`
--

CREATE TABLE `emergency_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_type`
--

INSERT INTO `emergency_type` (`id`, `name`, `description`) VALUES
(1, 'Flood ', 'A flood is an overflow of water beyond its normal limits ( or rarely other fluids ) that submerges land that is usually dry. In the sense of \"flowing water\", the word may also be applied to the inflow of the tide.'),
(2, 'Medical Emergency', 'A medical emergency is an acute injury or illness that poses an immediate risk to a person\'s life or long-term health, sometimes referred to as a situation risking \"life or limb\". '),
(3, 'Fire Emergencies', 'A fire emergency is a situation in which fire may cause death or severe injury. It refers to a fire or the potential for a fire that may escalate beyond the ability of the local fire service resources to safely control and thereby endangering lives, property, buildings or the environment. Fire emergency most commonly refers to conflagration, structure fire, vehicle fire, and wildfire.'),
(4, 'Vehicular Accident', 'A vehicular accident, also known as a \"traffic collision\" or a \"motor vehicle accident,\" occurs when a motor vehicle strikes or collides with another vehicle, a stationary object, a pedestrian, or an animal. These accidents can result in property damage, severe injuries, or death.'),
(5, 'Trauma Case', 'A trauma case refers to an injured person who has been evaluated by prehospital personnel and found to require transportation to a trauma facility. Trauma is a pervasive problem that results from exposure to an incident or series of events that are emotionally disturbing or life-threatening with lasting adverse effects on the individual’s functioning and mental, physical, social, emotional, and/or spiritual well-being.\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `joined` varchar(30) NOT NULL,
  `state` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `photo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `joined`, `state`, `phone`, `user_id`, `address`, `photo`) VALUES
(31, 'users', 'users@gmail.com', 'users', 'BQkrS3hFrC/wkyXhZ1wQrg==', '', '', '09123456789', '1279', 'Hagonoy, Bulacan', '240_F_81506241_4cElmoPALLOigRryZM9kw68K0tBy3v5y.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agency`
--
ALTER TABLE `agency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency`
--
ALTER TABLE `emergency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_history`
--
ALTER TABLE `emergency_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_type`
--
ALTER TABLE `emergency_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `agency`
--
ALTER TABLE `agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `emergency`
--
ALTER TABLE `emergency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `emergency_history`
--
ALTER TABLE `emergency_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `emergency_type`
--
ALTER TABLE `emergency_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
