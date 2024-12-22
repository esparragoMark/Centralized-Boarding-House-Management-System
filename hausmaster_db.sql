-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 12:17 PM
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
-- Database: `hausmaster_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_acc`
--

CREATE TABLE `admin_acc` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(100) DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_acc`
--

INSERT INTO `admin_acc` (`id`, `fullname`, `email`, `password`, `profile`, `reset_token`, `reset_token_expires_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$10$F5hr5KM7y0pMWEpl/gCss.COd.XAKVXFSrs8XanI4ifGvy3KzXMiC', '1733461814_Screenshot 2024-11-17 233845.png', NULL, NULL),
(2, 'adminsample', 'ad@gmail.com', '$2a$12$tLfD95nfTior41REljloF.C.1PAFuFb4MbqW7StVCzeYTnaEJECli', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `bed_id` int(11) NOT NULL,
  `bed_number` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `status` enum('available','occupied','booked') NOT NULL,
  `image` varchar(200) NOT NULL,
  `bh_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`bed_id`, `bed_number`, `room_id`, `status`, `image`, `bh_id`) VALUES
(81, 1, 44, 'available', '1731136785_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(82, 2, 44, 'occupied', '1731136793_455608108_478717378459474_2866458856930844495_n.jpg', 18),
(83, 3, 44, 'occupied', '1731136801_455608108_478717378459474_2866458856930844495_n.jpg', 18),
(84, 4, 44, 'booked', '1731137102_455608108_478717378459474_2866458856930844495_n.jpg', 18),
(87, 5, 44, 'booked', '1731137122_455608108_478717378459474_2866458856930844495_n.jpg', 18),
(88, 1, 46, 'occupied', '1731137132_455608108_478717378459474_2866458856930844495_n.jpg', 18),
(89, 2, 46, 'occupied', '1731137162_455608108_478717378459474_2866458856930844495_n.jpg', 18),
(90, 3, 46, 'booked', '1731137170_455608108_478717378459474_2866458856930844495_n.jpg', 18),
(91, 4, 46, 'available', '1731137206_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(92, 5, 46, 'available', '1731137216_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(93, 1, 47, 'available', '1730039043_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(94, 2, 47, 'available', '1730039055_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(95, 3, 47, 'available', '1730039078_455608108_478717378459474_2866458856930844495_n.jpg', 20),
(96, 4, 47, 'available', '1730039090_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(97, 1, 48, 'available', '1730039103_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(98, 3, 48, 'available', '1730039121_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(99, 4, 48, 'available', '1730039134_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(100, 2, 48, 'available', '1730039183_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(101, 1, 49, 'available', '1730039197_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(102, 2, 49, 'available', '1730039211_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(103, 3, 49, 'available', '1730039221_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(104, 4, 49, 'available', '1730039258_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(105, 1, 50, 'available', '1730039276_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(106, 2, 50, 'available', '1730039287_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(107, 3, 50, 'available', '1730039304_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(108, 4, 50, 'available', '1730039316_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(109, 1, 51, 'available', '1730039335_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(110, 2, 51, 'available', '1730039345_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(111, 3, 51, 'available', '1730039357_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(112, 4, 51, 'available', '1730039381_455608108_478717378459474_2866458856930844495_n (1).jpg', 20),
(113, 1, 52, 'available', '1730039446_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(114, 2, 52, 'available', '1730039458_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(115, 3, 52, 'available', '1730039471_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(116, 4, 52, 'available', '1730039503_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(117, 1, 53, 'available', '1730039522_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(118, 2, 53, 'available', '1730039540_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(119, 3, 53, 'available', '1730039561_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(120, 4, 53, 'available', '1730039671_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(121, 1, 54, 'available', '1730039686_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(122, 2, 54, 'available', '1730039703_455608108_478717378459474_2866458856930844495_n.jpg', 20),
(123, 3, 54, 'available', '1730039726_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(124, 4, 54, 'available', '1730039968_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(125, 1, 55, 'available', '1730039985_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(126, 2, 55, 'available', '1730039998_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(127, 3, 55, 'available', '1730040011_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(128, 4, 55, 'available', '1730040048_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(129, 1, 56, 'available', '1730040089_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(130, 2, 56, 'available', '1730040104_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(131, 3, 56, 'available', '1730040147_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(132, 4, 56, 'available', '1730040163_455611925_814161740869370_4089344344989752353_n.jpg', 20),
(133, 1, 57, 'booked', '1731137228_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(134, 2, 57, 'available', '1731137241_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(135, 3, 57, 'available', '1731137263_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(136, 4, 57, 'available', '1731137269_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(137, 1, 58, 'available', '1731137276_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(138, 2, 58, 'booked', '1731137283_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(139, 3, 58, 'available', '1731137288_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(140, 4, 58, 'available', '1731137296_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(141, 1, 59, 'available', '1731137304_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(142, 2, 59, 'available', '1731137311_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(143, 4, 59, 'available', '1731137318_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(144, 3, 59, 'available', '1731137325_455608108_478717378459474_2866458856930844495_n (1).jpg', 18),
(145, 1, 60, 'booked', '1731137333_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(146, 2, 60, 'booked', '1731137339_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(147, 3, 60, 'available', '1731137349_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(148, 4, 60, 'booked', '1731137356_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(149, 1, 61, 'occupied', '1731137364_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(150, 2, 61, 'available', '1731137370_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(151, 3, 61, 'available', '1731137377_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(152, 4, 61, 'available', '1731137385_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(153, 1, 62, 'available', '1731137393_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(154, 2, 62, 'available', '1731137402_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(155, 3, 62, 'available', '1731137410_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(156, 4, 62, 'available', '1731137418_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(157, 1, 63, 'available', '1731137426_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(158, 2, 63, 'available', '1731137432_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(159, 3, 63, 'available', '1731137440_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(160, 1, 64, 'available', '1731137447_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(161, 2, 64, 'available', '1731137454_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(162, 3, 64, 'available', '1731137461_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(163, 4, 64, 'available', '1731137485_455611925_814161740869370_4089344344989752353_n.jpg', 18),
(164, 1, 65, 'available', '1730044517_455608108_478717378459474_2866458856930844495_n (1).jpg', 21),
(165, 2, 65, 'available', '1730044542_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(166, 3, 65, 'available', '1730044554_455608108_478717378459474_2866458856930844495_n (1).jpg', 21),
(167, 4, 65, 'available', '1730044564_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(168, 1, 66, 'available', '1730044582_455608108_478717378459474_2866458856930844495_n (1).jpg', 21),
(169, 2, 66, 'available', '1730044598_455608108_478717378459474_2866458856930844495_n (1).jpg', 21),
(170, 3, 66, 'available', '1730044612_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(171, 4, 66, 'available', '1730044628_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(172, 1, 67, 'available', '1730044649_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(173, 2, 67, 'available', '1730044686_455608108_478717378459474_2866458856930844495_n (1).jpg', 21),
(174, 3, 67, 'available', '1730044719_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(175, 4, 67, 'available', '1730044733_455608108_478717378459474_2866458856930844495_n (1).jpg', 21),
(176, 1, 68, 'available', '1730044759_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(177, 2, 68, 'available', '1730044778_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(178, 3, 68, 'available', '1730044827_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(179, 4, 68, 'available', '1730044869_455608108_478717378459474_2866458856930844495_n.jpg', 21),
(180, 1, 69, 'available', '1730044922_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(181, 2, 69, 'available', '1730044940_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(182, 3, 69, 'available', '1730044962_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(183, 4, 69, 'available', '1730044974_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(184, 1, 70, 'available', '1730044990_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(185, 2, 70, 'available', '1730045035_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(186, 3, 70, 'available', '1730045071_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(187, 4, 70, 'available', '1730045082_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(188, 1, 71, 'available', '1730045113_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(189, 2, 71, 'available', '1730045131_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(190, 3, 71, 'available', '1730045176_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(191, 4, 71, 'available', '1730045203_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(192, 1, 72, 'available', '1730045216_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(193, 2, 72, 'available', '1730045269_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(194, 3, 72, 'available', '1730045315_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(195, 4, 72, 'available', '1730045349_455611925_814161740869370_4089344344989752353_n.jpg', 21),
(196, 1, 73, 'booked', '1730098147_455608108_478717378459474_2866458856930844495_n (1).jpg', 22),
(197, 2, 73, 'booked', '1730048863_455608108_478717378459474_2866458856930844495_n (1).jpg', 22),
(198, 3, 73, 'available', '1730048873_455608108_478717378459474_2866458856930844495_n (1).jpg', 22),
(199, 4, 73, 'available', '1730048886_455608108_478717378459474_2866458856930844495_n (1).jpg', 22),
(200, 1, 74, 'available', '1730048896_455608108_478717378459474_2866458856930844495_n.jpg', 22),
(201, 2, 74, 'available', '1730048905_455608108_478717378459474_2866458856930844495_n (1).jpg', 22),
(202, 3, 74, 'available', '1730048916_455608108_478717378459474_2866458856930844495_n (1).jpg', 22),
(203, 4, 74, 'available', '1730048927_455608108_478717378459474_2866458856930844495_n.jpg', 22),
(204, 1, 75, 'available', '1730048941_455608108_478717378459474_2866458856930844495_n.jpg', 22),
(205, 2, 75, 'available', '1730048952_455608108_478717378459474_2866458856930844495_n (1).jpg', 22),
(206, 3, 75, 'available', '1730048966_455608108_478717378459474_2866458856930844495_n.jpg', 22),
(207, 4, 75, 'available', '1730048979_455608108_478717378459474_2866458856930844495_n.jpg', 22),
(208, 1, 76, 'available', '1730048992_455608108_478717378459474_2866458856930844495_n.jpg', 22),
(209, 2, 76, 'available', '1730049003_455608108_478717378459474_2866458856930844495_n (1).jpg', 22),
(210, 3, 76, 'available', '1730049022_455608108_478717378459474_2866458856930844495_n.jpg', 22),
(211, 4, 76, 'available', '1730049036_455608108_478717378459474_2866458856930844495_n (1).jpg', 22),
(212, 1, 77, 'available', '1730049080_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(213, 2, 77, 'available', '1730049067_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(214, 3, 77, 'available', '1730049110_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(215, 4, 77, 'available', '1730049125_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(216, 1, 78, 'available', '1730049138_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(217, 2, 78, 'available', '1730049148_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(218, 3, 78, 'available', '1730049205_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(219, 4, 78, 'available', '1730049215_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(220, 1, 79, 'available', '1730049256_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(221, 2, 79, 'available', '1730049269_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(222, 3, 79, 'available', '1730049339_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(223, 4, 79, 'available', '1730049366_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(224, 1, 80, 'available', '1730049381_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(225, 2, 80, 'available', '1730049392_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(226, 3, 80, 'available', '1730049404_455611925_814161740869370_4089344344989752353_n.jpg', 22),
(227, 4, 80, 'available', '1730049416_455611925_814161740869370_4089344344989752353_n.jpg', 22);

-- --------------------------------------------------------

--
-- Table structure for table `boarding_house_registration`
--

CREATE TABLE `boarding_house_registration` (
  `bh_id` int(11) NOT NULL,
  `owner_name` varchar(200) NOT NULL,
  `owner_phone` varchar(50) NOT NULL,
  `owner_email` varchar(100) NOT NULL,
  `owner_address` varchar(200) NOT NULL,
  `house_name` varchar(100) NOT NULL,
  `house_location` varchar(200) NOT NULL,
  `bhImage` varchar(200) NOT NULL,
  `terms_and_conditions` text NOT NULL,
  `major_permit` varchar(250) NOT NULL,
  `DTI` varchar(250) NOT NULL,
  `BIR` varchar(250) NOT NULL,
  `fire_safety_path` varchar(250) NOT NULL,
  `ATO` varchar(250) NOT NULL,
  `barangay_permit_path` varchar(250) NOT NULL,
  `landlord_id` int(11) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boarding_house_registration`
--

INSERT INTO `boarding_house_registration` (`bh_id`, `owner_name`, `owner_phone`, `owner_email`, `owner_address`, `house_name`, `house_location`, `bhImage`, `terms_and_conditions`, `major_permit`, `DTI`, `BIR`, `fire_safety_path`, `ATO`, `barangay_permit_path`, `landlord_id`, `latitude`, `longitude`) VALUES
(18, 'Francis Malto', '09482244276', 'francis@gmail.com', 'Cabitan', 'Francis Place Boarding House', 'College of Education', '1731136387_462581464_3393856347582434_3250738523602924982_n.jpg', 'Terms and Conditions for Boarding House Management System\r\n\r\n1. Introduction Welcome to the Centralized Boarding House Management System. By using this platform, both tenants (students) and landlords agree to comply with the following terms and conditions.\r\n\r\n2. Account Registration and Usage\r\n\r\nUsers must provide accurate and complete information during registration.\r\nTenants and landlords are responsible for maintaining the confidentiality of their login credentials.\r\nUsers are prohibited from sharing their accounts with others.\r\n3. Booking and Reservation Policy\r\n\r\nTenants can search for available boarding houses and book rooms through the system.\r\nA reservation is only confirmed after the landlord has verified and accepted the booking.\r\nAny cancellation policies or fees associated with the booking are determined by the landlord.\r\n4. Payments\r\n\r\nAll payment confirmations for bookings must be made through the system.\r\nLandlords are responsible for providing accurate payment information, and tenants are expected to follow the instructions for payment.\r\nThe system does not store any payment data or offer refund services.\r\n\r\n\r\n\r\n', '1731136387_mayor.jpg', '1731136387_dti.webp', '1731136387_bir.jpg', '1731136387_bfp.webp', '1731136387_Certificate-of-Authority.jpg', '1731136387_barangay.jpg', 31, '', ''),
(20, 'Carmen', '09482244276', 'carmen@gmail.com', 'Cabitan, Mandaon', 'Carmen Boarding House', 'College of Engineering', '1731137938_462563249_547471588022324_7455071678773116505_n.jpg', 'TERMS AND CONDITIONS: \r\n\r\nPayment Terms\r\nTenants must pay rent by the designated due date each month. Late fees will be applied for payments received after the due date. Failure to pay rent within 30 days may result in termination of the rental agreement.\r\n\r\n\r\n', '1731137938_mayor.jpg', '1731137938_dti.webp', '1731137938_bir.jpg', '1731137938_bfp.webp', '1731137938_Certificate-of-Authority.jpg', '1731137938_barangay.jpg', 35, '', ''),
(21, 'Bartolata', '09482244276', 'bartolata@gmail.com', 'Cabitan, Mandaon', 'Bartolata Boarding House', 'College of Education', '1730367125_bartolata.jpg', 'TERMS AND CONDITIONS:\r\n\r\nPayment Terms\r\nTenants must pay rent by the designated due date each month. Late fees will be applied for payments received after the due date. Failure to pay rent within 30 days may result in termination of the rental agreement.\r\n\r\n', '1730044112_mayor.jpg', '1730044112_dti.webp', '1730044112_bir.jpg', '1730044112_bfp.webp', '1730044112_Certificate-of-Authority.jpg', '1730044112_barangay.jpg', 36, '', ''),
(22, 'Turco', '09482244276', 'turco@gmail.com', 'Cabitan, Mandaon', 'Turco Boarding House', 'College of Education', '1730367269_462551326_450162874315237_7719872054210839502_n.jpg', 'TERMS AND CONDITIONS:\r\n\r\nPayment Terms\r\nTenants must pay rent by the designated due date each month. Late fees will be applied for payments received after the due date. Failure to pay rent within 30 days may result in termination of the rental agreement.\r\n\r\n\r\n\r\n', '1730048445_mayor.jpg', '1730048445_dti.webp', '1730048445_bir.jpg', '1730048445_bfp.webp', '1730048445_Certificate-of-Authority.jpg', '1730048445_barangay.jpg', 37, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `course` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `guardian_name` varchar(50) NOT NULL,
  `guardian_contact` varchar(15) NOT NULL,
  `room_no` int(11) NOT NULL,
  `bed_no` int(11) NOT NULL,
  `monthly_rent` decimal(10,2) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `image` varchar(100) NOT NULL,
  `reference_no` char(13) NOT NULL,
  `status` enum('pending','confirmed','rejected') NOT NULL DEFAULT 'pending',
  `user_id` int(11) NOT NULL,
  `bh_name` varchar(100) NOT NULL,
  `bh_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `reject_reason` text DEFAULT NULL,
  `confirm_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `fullname`, `gender`, `course`, `address`, `contact_no`, `guardian_name`, `guardian_contact`, `room_no`, `bed_no`, `monthly_rent`, `payment_amount`, `check_in`, `check_out`, `image`, `reference_no`, `status`, `user_id`, `bh_name`, `bh_id`, `room_id`, `reject_reason`, `confirm_message`) VALUES
(30, 'Mark L. Esparrago', 'Male', 'BSCS 4A', 'Tinapian, Baleno, Masbate', '09482244276', 'Leni L. Esparrago ', '09485851815', 1, 1, 500.00, 500.00, '2024-10-05', '2024-11-05', '1728117847_Screenshot_2024-10-05-13-03-45-346_com.globe.gcash.android.jpg', '5021482542212', 'confirmed', 8, 'Francis Place Boarding House', 18, 44, NULL, 'You can now proceed. Thank you for booking!'),
(31, 'Mark L. Esparrago', 'Male', 'BSCS 4A', 'Tinapian, Baleno, Masbate', '09482244276', 'Leni L. Esparrago ', '09485851815', 1, 4, 500.00, 500.00, '2024-10-16', '2024-11-06', '1729092999_GCash-639709644225-16102024112358.PNG.jpg', '1828185951958', 'rejected', 8, 'Francis Place Boarding House', 18, 44, 'Payment not found. please contact us if you have  any concern.', NULL),
(32, 'Mark L. Esparrago', 'Male', 'BSCS 4A', 'Tinapian, Baleno, Masbate', '09482244276', 'Leni L. Esparrago ', '09485851815', 2, 1, 1000.00, 1000.00, '2024-10-20', '2024-11-20', '1729407149_455955296_407744481921434_5887583971356670414_n.jpg', '3578698563453', 'confirmed', 8, 'Francis Place Boarding House', 18, 46, NULL, 'Welcome ...'),
(33, 'Romel Laurio', 'Male', 'BSCS 3A', 'Puro, Aroroy, Masbate', '09482244276', 'Romel Mother', '09274742752', 1, 4, 500.00, 500.00, '2024-10-28', '2024-11-04', '1730100835_GCash-639076124930-26102024154311.PNG.jpg', '4168326167956', 'pending', 12, 'Francis Place Boarding House', 18, 44, NULL, NULL),
(34, 'Anna Jean Cortes', 'Female', 'BSED 2A', 'Puro, Aroroy ', '09385162190', 'Amelia Cortes', '09319828181', 1, 1, 600.00, 600.00, '2024-10-28', '2024-11-04', '1730101285_GCash-639076124930-26102024154311.PNG.jpg', '4613538161656', 'pending', 13, 'Francis Place Boarding House', 18, 60, NULL, NULL),
(35, 'Jason Mingoy', 'Male', 'BSIT 2B', 'Baleno, Masbate', '09385162190', 'Nong Mingoy', '09485851815', 1, 1, 700.00, 700.00, '2024-10-28', '2024-11-11', '1730102384_GCash-639076124930-26102024154311.PNG.jpg', '4646532646468', 'pending', 14, 'Turco Boarding House', 22, 73, NULL, NULL),
(36, 'Leslie Bitancur', 'Female', 'BSCS 4A', 'Tinapian, Baleno, Masbate', '09482244276', 'Lizabel A. Bitancur ', '09319828181', 1, 2, 600.00, 600.00, '2024-10-28', '2024-11-28', '1730103643_GCash-639076124930-26102024154311.PNG.jpg', '4168326167959', 'pending', 15, 'Francis Place Boarding House', 18, 60, NULL, NULL),
(37, 'Stefanie S. Laurio', 'Female', 'BSED 4A', 'Baleno, Masbate', '09385162192', 'Leslie A. Bitancur ', '09485851815', 3, 1, 500.00, 500.00, '2024-10-28', '2024-11-28', '1730104455_GCash-639076124930-26102024154311.PNG.jpg', '1828185951955', 'pending', 16, 'Francis Place Boarding House', 18, 57, NULL, NULL),
(38, 'Nonie H. Abelida', 'Female', 'BSIS-2A', 'Palanas, Masbate ', '09854401349', 'Lonie Abelida ', '09361846583', 1, 2, 700.00, 700.00, '2024-10-28', '2024-11-28', '1730105869_GCash-639076124930-26102024154311.PNG.jpg', '5021482642216', 'pending', 17, 'Turco Boarding House', 22, 73, NULL, NULL),
(39, 'Relica V. Malinao', 'Female', 'BSCS 2A', 'Brgy. Guincaiptan, Mandaon, Masbate', '09857586381', 'Renil M. Malinao Sr.', '09306216215', 4, 2, 500.00, 500.00, '2024-10-28', '2024-11-28', '1730106058_Messenger_creation_55B5E5F5-61BD-44AF-A584-154A5E8E15E9.jpeg', '8555889631588', 'pending', 18, 'Francis Place Boarding House', 18, 58, NULL, NULL),
(40, 'Glyzel Gomez', 'Female', 'BSCS 4A', 'Tigbao Milagros Masbate', '09851109558', 'Hazel Gomez', '09997710123', 1, 4, 600.00, 600.00, '2024-10-30', '2024-11-30', '1730270643_Messenger_creation_55B5E5F5-61BD-44AF-A584-154A5E8E15E9.jpeg', '5794546432424', 'pending', 21, 'Francis Place Boarding House', 18, 60, NULL, NULL),
(41, 'Jason c. Salivion', 'Male', 'Ab Econ 3A', 'Tinapian, baleno, Masbate ', '09636700640', 'Merla albao salivio', '09319181379', 1, 5, 500.00, 500.00, '2024-10-30', '2024-11-30', '1730272127_Messenger_creation_55B5E5F5-61BD-44AF-A584-154A5E8E15E9.jpeg', '5794546432485', 'pending', 22, 'Francis Place Boarding House', 18, 44, NULL, NULL),
(42, 'Mark L. Esparrago', 'Male', 'BSCS 4A', 'Tinapian, Baleno, Masbate', '09482244276', 'Leni L. Esparrago ', '09485851815', 2, 2, 1000.00, 1000.00, '2024-11-02', '2024-12-02', '1730553451_gcash_example.jpg', '2378562389742', 'confirmed', 8, 'Francis Place Boarding House', 18, 46, NULL, 'Booking Confirmation\r\n\r\nDear Mark L. Esparrago,\r\n\r\nCongratulations! Your booking for the boarding house has been successfully completed. You can now proceed to your reserved room. If you have any questions or need further assistance, please feel free to reach out.\r\n\r\nThank you for choosing our boarding house, and we wish you a pleasant stay!'),
(43, 'Leslie Bitancur', 'Female', 'BSCS 4A', 'Monreal, Masbate', '09482244276', 'Lizabel A. Bitancur ', '09319828181', 2, 3, 1000.00, 1000.00, '2024-11-06', '2024-12-06', '1730880849_Messenger_creation_55B5E5F5-61BD-44AF-A584-154A5E8E15E9.jpeg', '3121518994634', 'pending', 11, 'Francis Place Boarding House', 18, 46, NULL, NULL),
(44, 'Mark L. Esparrago', 'Male', 'BSCS 4A', 'Tinapian, Baleno, Masbate', '09482244276', 'Leni L. Esparrago ', '09485851815', 2, 1, 600.00, 600.00, '2024-11-07', '2024-11-08', '1730880915_Screenshot_2024-11-04-16-47-27-908_com.globe.gcash.android.jpg', '1234567891023', 'confirmed', 8, 'Francis Place Boarding House', 18, 61, NULL, 'Welcome and thank you choosing francis place boarding house.');

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `id` int(11) NOT NULL,
  `college` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `college`) VALUES
(1, 'College of Engineering'),
(2, 'College of Agriculture'),
(3, 'College of Education'),
(4, 'College of Arts And Sciences'),
(5, 'College of Industrial Technology');

-- --------------------------------------------------------

--
-- Table structure for table `dislay_config`
--

CREATE TABLE `dislay_config` (
  `id` int(11) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `front_end_text` text DEFAULT NULL,
  `footer_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dislay_config`
--

INSERT INTO `dislay_config` (`id`, `image`, `front_end_text`, `footer_text`) VALUES
(1, '1727372251_logo2.png', 'Search Your Boarding House Now!', 'HausMaster');

-- --------------------------------------------------------

--
-- Table structure for table `landlords_acc`
--

CREATE TABLE `landlords_acc` (
  `landlord_id` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `bh_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(300) NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `landlords_acc`
--

INSERT INTO `landlords_acc` (`landlord_id`, `fullname`, `bh_name`, `email`, `password`, `reset_token`, `reset_token_expires_at`) VALUES
(31, 'francis Malto', 'Francis Place Boarding House ', 'francis@gmail.com', '$2y$10$CEG5zf7hREkslZkj6HVXVuHQ9tvOsv4es4/mu.7J4pdQeU5zrRiZW', NULL, NULL),
(35, 'Carmen', 'Carmen Boarding House', 'carmen@gmail.com', '$2y$10$sv42VViQqKsjpfMVRQZ9Z.AKm/bRZZsnlLxYahfEKyy.L89ibKoK.', NULL, NULL),
(36, 'Bartolata', 'Bartolata Boarding House', 'bartolata@gmail.com', '$2y$10$DmeK.kKg8.HaExxMuHJ.gOuPrgFl8OGYPAJQJTlec29ZQPm4q0KIi', NULL, NULL),
(37, 'Turco', 'Turco Boarding House', 'turco@gmail.com', '$2y$10$BghEDQbUEhPrRWTBys./LO1rTysAhUC65wRu2aGRzcyAkTIJygSP6', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `occupants`
--

CREATE TABLE `occupants` (
  `occupant_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `course_year_section` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `guardian_name` varchar(50) NOT NULL,
  `guardian_contact` varchar(15) NOT NULL,
  `room_number` int(11) NOT NULL,
  `bed_number` int(11) NOT NULL,
  `monthly_rent` decimal(10,2) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `date_of_moving_in` date NOT NULL DEFAULT current_timestamp(),
  `bh_name` varchar(100) NOT NULL,
  `bh_id` int(11) NOT NULL,
  `room_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `occupants`
--

INSERT INTO `occupants` (`occupant_id`, `fullname`, `gender`, `course_year_section`, `address`, `contact_number`, `guardian_name`, `guardian_contact`, `room_number`, `bed_number`, `monthly_rent`, `payment_amount`, `start_date`, `end_date`, `date_of_moving_in`, `bh_name`, `bh_id`, `room_fk`) VALUES
(88, 'Joel Alfabete', 'Male', 'BSCS 4A', 'Mobo, Masbate', '09482244276', 'Teodora A. Realonda', '09482244276', 1, 2, 500.00, 500.00, '0000-00-00', '2024-11-20', '2024-10-16', 'Francis Place Boarding House', 18, 44),
(89, 'Freddie Alicante', 'Male', 'BSCS 4A', 'Mobo, Masbate', '09482244276', 'Teodora A. Realonda', '09482244276', 1, 3, 500.00, 500.00, '0000-00-00', '2024-11-16', '2024-10-16', 'Francis Place Boarding House', 18, 44),
(92, 'Leslie A. Bitancur', 'Female', 'BSCS 4A', 'Poblacion, Monreal, Masbate', '09482244276', 'Lizabel A. BItancur', '09485851815', 2, 1, 1000.00, 1000.00, '2024-10-20', '2024-11-20', '2024-10-19', 'Francis Place Boarding House', 18, 46),
(93, 'Mark L. Esparrago', 'Male', 'BSCS 4A', 'Tinapian, Baleno, Masbate', '09482244276', 'Leni L. Esparrago ', '09485851815', 2, 2, 1000.00, 1000.00, '2024-11-02', '2024-12-02', '2024-11-02', 'Francis Place Boarding House', 18, 46),
(94, 'Mark L. Esparrago', 'Male', 'BSCS 4A', 'Tinapian, Baleno, Masbate', '09482244276', 'Leni L. Esparrago ', '09485851815', 2, 1, 600.00, 600.00, '2024-11-07', '2024-11-08', '2024-11-06', 'Francis Place Boarding House', 18, 61);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `tenant_name` varchar(100) NOT NULL,
  `due_date` date NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_rent_paid` decimal(10,2) NOT NULL,
  `bh_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `tenant_name`, `due_date`, `payment_date`, `total_rent_paid`, `bh_id`) VALUES
(39, 'Mark L. Esparrago', '2024-11-05', '2024-10-05 01:46:14', 500.00, 18),
(40, 'Mark L. Esparrago', '2024-11-16', '2024-10-16 06:42:46', 500.00, 18),
(41, 'Joel Alfabete', '2024-11-16', '2024-10-16 06:43:34', 500.00, 18),
(42, 'Freddie Alicante', '2024-11-16', '2024-10-16 06:44:29', 500.00, 18),
(43, 'Mark Batoctoc', '2024-11-16', '2024-10-16 06:46:20', 500.00, 18),
(44, 'Mark Batoctoc', '2024-11-16', '2024-10-16 08:18:54', 500.00, 18),
(45, 'Joel Alfabete', '2024-11-20', '2024-10-19 23:55:36', 500.00, 18),
(46, 'Joel Alfabete', '2024-11-20', '2024-10-19 23:56:25', 500.00, 18),
(47, 'Mark L. Esparrago', '2024-11-20', '2024-10-19 23:58:47', 1000.00, 18),
(48, 'Mark L. Esparrago', '2024-12-02', '2024-11-02 06:32:53', 1000.00, 18),
(49, 'Mark L. Esparrago', '2024-11-08', '2024-11-06 00:16:05', 600.00, 18);

-- --------------------------------------------------------

--
-- Table structure for table `profile_image`
--

CREATE TABLE `profile_image` (
  `id` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `landlord_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_image`
--

INSERT INTO `profile_image` (`id`, `image`, `landlord_id`) VALUES
(8, '1731137542_462581464_3393856347582434_3250738523602924982_n.jpg', 31),
(9, '1731137955_462563249_547471588022324_7455071678773116505_n.jpg', 35);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL,
  `rating_count` int(5) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_review` text NOT NULL,
  `bh_id` int(11) NOT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `rating_count`, `user_name`, `user_review`, `bh_id`, `time`) VALUES
(11, 5, 'Mark L. Esparrago', 'Nice Experience and Nice Boarding House . Totally good and it\'s insaneðŸ”¥', 18, '04:49:19'),
(12, 4, 'Mark L. Esparrago', 'NICE', 18, '02:11:06'),
(13, 5, 'Romel Laurio', 'Ayos at maganda sa bh na to. Solid!!\n', 18, '03:33:00'),
(14, 5, 'Anna Jean Cortes', 'Nice bh and I love it...', 18, '03:42:56'),
(15, 2, 'Leslie Bitancur', 'Cr maluya ', 18, '04:21:14'),
(16, 4, 'Stefanie S. Laurio', 'Good', 18, '04:35:52'),
(17, 3, 'Nonie H. Abelida', 'Goods', 22, '04:57:01'),
(18, 4, 'Relica V. Malinao', 'Excellent ', 18, '04:59:24'),
(19, 4, 'Mark L. Esparrago', 'Nice boarding houseðŸ”¥', 22, '02:49:58'),
(20, 4, 'Leslie Bitancur', 'nice', 18, '20:54:51');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` int(11) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text NOT NULL,
  `monthly_rent` decimal(10,2) NOT NULL,
  `vacant_bed` int(11) NOT NULL DEFAULT 0,
  `occupied_bed` int(11) NOT NULL DEFAULT 0,
  `image` text NOT NULL,
  `bh_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `gender`, `capacity`, `description`, `monthly_rent`, `vacant_bed`, `occupied_bed`, `image`, `bh_fk`) VALUES
(44, 1, 'Male', 5, 'WiFi, Bunk Beds, Fan, Electricity', 500.00, 3, 2, '1731136484_455977415_1559955441605590_2107516523584443896_n.jpg', 18),
(46, 2, 'Male', 5, 'WiFi, Single Bed, Double Bed, Electricity', 1000.00, 3, 2, '1731136507_455977415_1559955441605590_2107516523584443896_n.jpg', 18),
(47, 1, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 800.00, 4, 0, '1730038625_455977415_1559955441605590_2107516523584443896_n.jpg', 20),
(48, 2, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 800.00, 4, 0, '1730038660_455977415_1559955441605590_2107516523584443896_n.jpg', 20),
(49, 3, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 800.00, 4, 0, '1730038695_455977415_1559955441605590_2107516523584443896_n.jpg', 20),
(50, 4, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 800.00, 4, 0, '1730038721_455977415_1559955441605590_2107516523584443896_n.jpg', 20),
(51, 5, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 800.00, 4, 0, '1730038753_455977415_1559955441605590_2107516523584443896_n.jpg', 20),
(52, 1, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 1000.00, 4, 0, '1730038846_456037705_2196042287438050_7029933501681346318_n.jpg', 20),
(53, 2, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 1000.00, 4, 0, '1730038880_456037705_2196042287438050_7029933501681346318_n.jpg', 20),
(54, 3, 'Female', 4, 'WiFi, Parking, Fan, 24/7 Water Supply, Electricity', 1000.00, 4, 0, '1730038909_456037705_2196042287438050_7029933501681346318_n.jpg', 20),
(55, 4, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 1000.00, 4, 0, '1730038942_456037705_2196042287438050_7029933501681346318_n.jpg', 20),
(56, 5, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 1000.00, 4, 0, '1730038975_456037705_2196042287438050_7029933501681346318_n.jpg', 20),
(57, 3, 'Male', 4, 'WiFi, CR Inside, 24/7 Water Supply, Electricity', 500.00, 4, 0, '1731136525_455977415_1559955441605590_2107516523584443896_n.jpg', 18),
(58, 4, 'Male', 4, 'WiFi, CR Inside, 24/7 Water Supply, Electricity', 500.00, 4, 0, '1731136546_455977415_1559955441605590_2107516523584443896_n.jpg', 18),
(59, 5, 'Male', 4, 'WiFi, CR Inside, 24/7 Water Supply, Electricity', 500.00, 4, 0, '1731136566_455977415_1559955441605590_2107516523584443896_n.jpg', 18),
(60, 1, 'Female', 4, 'WiFi, CR Inside, 24/7 Water Supply, Electricity', 600.00, 4, 0, '1731136622_456096032_303724026137955_293830537823628709_n.jpg', 18),
(61, 2, 'Female', 4, 'WiFi, CR Inside, 24/7 Water Supply, Electricity', 600.00, 3, 1, '1731136639_456096032_303724026137955_293830537823628709_n.jpg', 18),
(62, 3, 'Female', 4, 'WiFi, CR Inside, 24/7 Water Supply, Electricity', 600.00, 4, 0, '1731136668_456096032_303724026137955_293830537823628709_n.jpg', 18),
(63, 4, 'Female', 3, 'WiFi, CR Inside, 24/7 Water Supply, Electricity', 600.00, 3, 0, '1731136693_456096032_303724026137955_293830537823628709_n.jpg', 18),
(64, 5, 'Female', 4, 'WiFi, CR Inside, 24/7 Water Supply, Electricity', 600.00, 4, 0, '1731136724_456096032_303724026137955_293830537823628709_n.jpg', 18),
(65, 1, 'Male', 4, 'WiFi, CR Inside, Laundry Area, Fan, 24/7 Water Supply, Electricity', 900.00, 4, 0, '1730044193_455977415_1559955441605590_2107516523584443896_n.jpg', 21),
(66, 2, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 900.00, 4, 0, '1730044242_455977415_1559955441605590_2107516523584443896_n.jpg', 21),
(67, 3, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 900.00, 4, 0, '1730044276_455977415_1559955441605590_2107516523584443896_n.jpg', 21),
(68, 4, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 900.00, 4, 0, '1730044312_455977415_1559955441605590_2107516523584443896_n.jpg', 21),
(69, 1, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 950.00, 4, 0, '1730044347_456037705_2196042287438050_7029933501681346318_n.jpg', 21),
(70, 2, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 950.00, 4, 0, '1730044383_456037705_2196042287438050_7029933501681346318_n.jpg', 21),
(71, 3, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 950.00, 4, 0, '1730044433_456037705_2196042287438050_7029933501681346318_n.jpg', 21),
(72, 4, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 950.00, 4, 0, '1730044478_456037705_2196042287438050_7029933501681346318_n.jpg', 21),
(73, 1, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 700.00, 4, 0, '1730048491_455977415_1559955441605590_2107516523584443896_n.jpg', 22),
(74, 2, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 700.00, 4, 0, '1730048511_455977415_1559955441605590_2107516523584443896_n.jpg', 22),
(75, 3, 'Male', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 700.00, 4, 0, '1730048537_455977415_1559955441605590_2107516523584443896_n.jpg', 22),
(76, 4, 'Male', 4, 'WiFi, Parking, Fan, 24/7 Water Supply, Electricity', 700.00, 4, 0, '1730048639_455977415_1559955441605590_2107516523584443896_n.jpg', 22),
(77, 1, 'Female', 4, 'WiFi, Fan, 24/7 Water Supply, Electricity', 850.00, 4, 0, '1730048678_456037705_2196042287438050_7029933501681346318_n.jpg', 22),
(78, 2, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 850.00, 4, 0, '1730048726_456037705_2196042287438050_7029933501681346318_n.jpg', 22),
(79, 3, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 850.00, 4, 0, '1730048781_456037705_2196042287438050_7029933501681346318_n.jpg', 22),
(80, 4, 'Female', 4, 'WiFi, CR Inside, Fan, 24/7 Water Supply, Electricity', 850.00, 4, 0, '1730048819_456037705_2196042287438050_7029933501681346318_n.jpg', 22);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `course` varchar(250) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` varchar(250) NOT NULL,
  `guardian_name` varchar(50) NOT NULL,
  `guardian_contact` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `gender`, `course`, `contact_number`, `address`, `guardian_name`, `guardian_contact`, `email`, `password`, `reset_token`, `reset_token_expires_at`) VALUES
(8, 'Mark L. Esparrago', 'Male', 'BSCS 4A', '09482244276', 'Tinapian, Baleno, Masbate', 'Leni L. Esparrago ', '09485851815', 'markesparrago5@gmail.com', '$2y$10$wj.bViwmHRBGT13cl0.MMeRNKayPzBjWPEnsPvJv4vyb3C9/YCuki', NULL, NULL),
(9, 'Christian Divida ', 'Male', 'BSCS 4A ', '09123556789', 'Masbate ', 'Mama mo', '61837474', 'juantamad123@gmail.com', '$2y$10$IIHhP7JQtziqIIb6Ha7IxuU5sskrTH8WILfC4enTo/21HKm/.SfSC', NULL, NULL),
(10, 'Jerry Esparas ', 'Male', 'BSCS 4A', '09107327658', 'Poblacion Monreal Masbate ', 'Father ', '09129383285', 'jerryesparas1@gmail.com', '$2y$10$seiHY/4I6CarfyHXBXYeou4SZyQWvBnjHIQzpLdtc6xRQXWvR2qwK', NULL, NULL),
(11, 'Leslie Bitancur', 'Female', 'BSCS 4A', '09482244276', 'Monreal, Masbate', 'Lizabel A. Bitancur ', '09319828181', 'bitancurleslie@gmail.com', '$2y$10$iq3lo5Bo.zBHKJn/aRsE5eS9lQQijJVLpZHKiML956TszW2ruzGcK', 'bafa8df4a59d4319c3a62d40832db7a934a6d386b5dd81bb4104f127f0b29b73', '2024-11-05 12:19:19'),
(12, 'Romel Laurio', 'Male', 'BSCS 3A', '09482244276', 'Puro, Aroroy, Masbate', 'Romel Mother', '09274742752', 'romel@gmail.com', '$2y$10$IPjKBzPuxsUEKTw0lclJU.0RjmgmP1iZS8faRauu/V1Jr13f2iMCC', NULL, NULL),
(13, 'Anna Jean Cortes', 'Female', 'BSED 2A', '09385162190', 'Puro, Aroroy ', 'Amelia Cortes', '09319828181', 'jeancortes24@gmail.com', '$2y$10$LUy4CBP0OQgmPADgdBpNietVwYCZYgIiPdCTp3Sr1MmO60K0rsPqq', NULL, NULL),
(14, 'Jason Mingoy', 'Male', 'BSIT 2B', '09385162190', 'Baleno, Masbate', 'Nong Mingoy', '09485851815', 'jason@gmail.com', '$2y$10$wkZ4PVbINhNrhbpTUQA.HOJgGhlWYR0yWhxfEy9pulSalcKWnBe16', NULL, NULL),
(15, 'Leslie Bitancur', 'Female', 'BSCS 4A', '09482244276', 'Tinapian, Baleno, Masbate', 'Lizabel A. Bitancur ', '09319828181', 'lesliebitancur@gamil.com', '$2y$10$JA.pFcsV3l9XepmDisa1A.8HLvioOc4pf6XeyiZJz8zMTsR2wo6L6', NULL, NULL),
(16, 'Stefanie S. Laurio', 'Female', 'BSED 4A', '09385162192', 'Baleno, Masbate', 'Leslie A. Bitancur ', '09485851815', 'stefanielaurio@gmail.com', '$2y$10$aX/8NdYopIlcJxeb9HJh7uwc753IWqNNM8FHAoHybNqL5Jq6xr93W', NULL, NULL),
(17, 'Nonie H. Abelida', 'Female', 'BSIS-2A', '09854401349', 'Palanas, Masbate ', 'Lonie Abelida ', '09361846583', 'nonie@gmail.com', '$2y$10$YxBcvS9ZwBiwe9QKGe47eOCHlLvKTLn3vizgJnpxMINixJD5cnu7W', NULL, NULL),
(18, 'Relica V. Malinao', 'Female', 'BSCS 2A', '09857586381', 'Brgy. Guincaiptan, Mandaon, Masbate', 'Renil M. Malinao Sr.', '09306216215', 'relicamalinao@gmail.com', '$2y$10$R7B2xqPaDJji8Z4dGqdP1OZuDwIBpofTblBgm9ns3AtPEi0HG0g.S', NULL, NULL),
(19, 'Marry Grace O. Abad', 'Female', 'BS ENTREP 2A', '09858009433', 'Cadulan,Dimasalang,Masbate', 'Grace Abad', '09056816621', 'mgabad09032004@gmail.com', '$2y$10$r4hdp6Q4W2eqr1fhknaMHeyl1kVK60pbHhwbQ7fZgs73UejM.vLqG', NULL, NULL),
(20, 'Jeson', 'Male', 'BSCS 3C', '09104552388', 'Poblacion west milagros, masbate', 'Patrick', '727272727', 'jeson@gmail.com', '$2y$10$Pdr50xuNikumqAH0xICPYOSDIUgiqvG1vN7Ax6WRZNVLsfCPiCSvW', NULL, NULL),
(21, 'Glyzel Gomez', 'Female', 'BSCS 4A', '09851109558', 'Tigbao Milagros Masbate', 'Hazel Gomez', '09997710123', 'gomezglyzel11@gmail.com', '$2y$10$XpPtYmPQGnZ99vuu5zGulOYLf6.YKpbKn291VJ6ACbHzrNtJqy3YK', NULL, NULL),
(22, 'Jason c. Salivion', 'Male', 'Ab Econ 3A', '09636700640', 'Tinapian, baleno, Masbate ', 'Merla albao salivio', '09319181379', 'jasonsalivio@gmail.com', '$2y$10$xlZtEqHR5RKXn0rZkK/FVuFlm5V///J2XOC0yHYMx8ezXcb2Leyu.', NULL, NULL),
(23, 'Kenji Anave ', 'Male', 'BSCS3A', '09853656243', 'Sto niÃ±o,Monreal, Masbate ', 'Joana', '09319828181', 'kenjianave@gmail.con', '$2y$10$0mBAetBLTHlHwqFo2FDCtuWQliaV.WhmRhF4JRJVxEeWk66j1IO9K', NULL, NULL),
(24, 'Joel Alfabete', 'Male', 'BSCS 4A', '09223533', 'Mobo, Masbate', 'Carmen', '09482244276', 'virgo_mak@yahoo.com', '$2y$10$kOQNYuCcDinj9wLF3iIzW.vyMk5/ECPTT7WKiZApODcDXxK08afe2', NULL, NULL),
(25, 'yo', 'Male', 'BSCS 4A', '09482244276', 'Tinapian, Baleno, Masbate', 'yu', '09482244276', 'yo@gmail.com', '$2y$10$y8eFTTaY6efLAa6iQIO1AutC6GuMtieGLpD.0.jiOHO0p3OWP4Yq6', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_acc`
--
ALTER TABLE `admin_acc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token` (`reset_token`);

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`bed_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `boarding_house_registration`
--
ALTER TABLE `boarding_house_registration`
  ADD PRIMARY KEY (`bh_id`),
  ADD KEY `landlord_id` (`landlord_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dislay_config`
--
ALTER TABLE `dislay_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landlords_acc`
--
ALTER TABLE `landlords_acc`
  ADD PRIMARY KEY (`landlord_id`),
  ADD UNIQUE KEY `reset_token` (`reset_token`);

--
-- Indexes for table `occupants`
--
ALTER TABLE `occupants`
  ADD PRIMARY KEY (`occupant_id`),
  ADD KEY `room_fk` (`room_fk`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `profile_image`
--
ALTER TABLE `profile_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `landlord_id` (`landlord_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `bh_fk` (`bh_fk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token` (`reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_acc`
--
ALTER TABLE `admin_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `bed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `boarding_house_registration`
--
ALTER TABLE `boarding_house_registration`
  MODIFY `bh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dislay_config`
--
ALTER TABLE `dislay_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `landlords_acc`
--
ALTER TABLE `landlords_acc`
  MODIFY `landlord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `occupants`
--
ALTER TABLE `occupants`
  MODIFY `occupant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `profile_image`
--
ALTER TABLE `profile_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `boarding_house_registration`
--
ALTER TABLE `boarding_house_registration`
  ADD CONSTRAINT `boarding_house_registration_ibfk_1` FOREIGN KEY (`landlord_id`) REFERENCES `landlords_acc` (`landlord_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `occupants`
--
ALTER TABLE `occupants`
  ADD CONSTRAINT `occupants_ibfk_1` FOREIGN KEY (`room_fk`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE;

--
-- Constraints for table `profile_image`
--
ALTER TABLE `profile_image`
  ADD CONSTRAINT `profile_image_ibfk_1` FOREIGN KEY (`landlord_id`) REFERENCES `landlords_acc` (`landlord_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`bh_fk`) REFERENCES `boarding_house_registration` (`bh_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
