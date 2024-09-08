-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2024 at 01:23 AM
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
-- Database: `bsit_projectrepo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `activity_log_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `date` varchar(25) NOT NULL,
  `action` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`activity_log_id`, `username`, `date`, `action`) VALUES
(1, 'admin', '2024-07-17 02:14:44', 'Program saved or updated: BSBA'),
(2, 'admin', '2024-07-17 02:37:24', 'Deleted program \'BSBA\''),
(3, 'admin', '2024-07-17 21:58:04', 'Curriculum updated: Data Structure and Algorithms'),
(4, 'admin', '2024-07-17 22:00:24', 'Curriculum updated: Database'),
(5, 'admin', '2024-07-17 22:01:20', 'Curriculum updated: Data Structure and Algorithms'),
(6, 'admin', '2024-07-17 22:26:32', 'Program saved or updated: BSBA'),
(7, 'admin', '2024-07-17 23:40:31', 'Program saved or updated: BEED'),
(8, 'admin', '2024-07-17 23:41:39', 'Deleted program \'BEED\''),
(9, 'admin', '2024-07-18 00:00:37', 'Curriculum updated: Assurance'),
(10, 'admin', '2024-07-19 02:26:00', 'Deleted curriculum \'Assurance\''),
(11, 'admin', '2024-07-31 00:01:48', 'Curriculum added or updated: Capstone 2'),
(12, 'admin', '2024-07-31 00:01:54', 'Deleted curriculum \'Data Algorithm\''),
(13, 'admin', '2024-07-31 00:01:58', 'Deleted curriculum \'Data Structure and Algorithms\''),
(14, 'admin', '2024-07-31 00:02:02', 'Deleted curriculum \'Database\''),
(15, 'admin', '2024-07-31 00:02:05', 'Deleted curriculum \'Method of Research\'');

-- --------------------------------------------------------

--
-- Table structure for table `archive_counter`
--

CREATE TABLE `archive_counter` (
  `id` int(11) NOT NULL,
  `archive_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_counter`
--

INSERT INTO `archive_counter` (`id`, `archive_id`, `created_at`) VALUES
(0, 21, '2023-07-30 17:23:29'),
(0, 21, '2023-07-30 17:24:41'),
(0, 19, '2023-07-30 17:30:51'),
(0, 19, '2023-07-30 17:31:38'),
(0, 19, '2023-07-30 17:32:28'),
(0, 19, '2023-07-30 17:35:21'),
(0, 8, '2023-07-30 17:35:40'),
(0, 8, '2023-07-30 17:36:19'),
(0, 22, '2023-07-31 03:00:39'),
(0, 26, '2023-07-31 03:12:24'),
(0, 26, '2023-07-31 03:12:51'),
(0, 26, '2023-07-31 03:14:28'),
(0, 22, '2023-07-31 03:14:50'),
(0, 22, '2023-07-31 03:15:03'),
(0, 26, '2023-07-31 03:16:56'),
(0, 23, '2023-07-31 03:17:27'),
(0, 22, '2023-07-31 03:22:53'),
(0, 22, '2023-07-31 03:23:18'),
(0, 22, '2023-07-31 03:23:29'),
(0, 22, '2023-07-31 03:24:38'),
(0, 26, '2023-07-31 05:57:31'),
(0, 8, '2023-07-31 06:02:41'),
(0, 19, '2023-07-31 06:34:13'),
(0, 8, '2023-07-31 06:35:23'),
(0, 19, '2023-07-31 06:35:54'),
(0, 19, '2023-07-31 06:41:37'),
(0, 19, '2023-07-31 06:41:58'),
(0, 27, '2023-07-31 06:42:11'),
(0, 8, '2023-07-31 06:42:20'),
(0, 8, '2023-07-31 06:42:42'),
(0, 23, '2023-07-31 07:22:21'),
(0, 19, '2023-07-31 07:46:34'),
(0, 21, '2023-07-31 09:16:41'),
(0, 27, '2023-07-31 12:11:32'),
(0, 27, '2023-07-31 12:18:53'),
(0, 32, '2023-07-31 15:11:26'),
(0, 36, '2023-07-31 21:52:46'),
(0, 39, '2023-07-31 22:03:59'),
(0, 38, '2023-07-31 22:06:37'),
(0, 39, '2023-07-31 22:26:46'),
(0, 39, '2023-07-31 22:26:55'),
(0, 36, '2023-07-31 22:27:08'),
(0, 26, '2023-07-31 22:49:36'),
(0, 38, '2023-07-31 22:49:55'),
(0, 38, '2023-07-31 22:52:25'),
(0, 35, '2023-08-01 04:31:28'),
(0, 35, '2023-08-01 07:37:26'),
(0, 26, '2023-08-01 08:47:09'),
(0, 26, '2023-08-01 08:54:39'),
(0, 8, '2023-08-01 10:47:39'),
(0, 19, '2023-08-01 10:54:12'),
(0, 26, '2023-08-01 10:56:05'),
(0, 48, '2023-08-01 14:04:28'),
(0, 47, '2023-08-01 14:05:09'),
(0, 35, '2023-08-02 10:23:55'),
(0, 50, '2023-08-06 15:40:41'),
(0, 51, '2023-08-06 15:45:36'),
(0, 51, '2023-08-06 15:46:17'),
(0, 52, '2023-08-06 15:53:06'),
(0, 50, '2023-08-06 15:55:58'),
(0, 47, '2023-08-06 15:58:21'),
(0, 52, '2024-07-16 14:37:16'),
(0, 80, '2024-07-17 11:40:02'),
(0, 81, '2024-07-17 11:43:43'),
(0, 83, '2024-07-17 13:44:16'),
(0, 83, '2024-07-18 18:46:58'),
(0, 83, '2024-07-18 18:47:57'),
(0, 83, '2024-07-18 19:06:10'),
(0, 84, '2024-07-18 19:17:15'),
(0, 85, '2024-07-18 19:30:08'),
(0, 86, '2024-07-19 07:44:27'),
(0, 85, '2024-07-19 07:49:29'),
(0, 84, '2024-07-19 07:49:32'),
(0, 83, '2024-07-19 07:49:56'),
(0, 88, '2024-07-19 08:21:39'),
(0, 88, '2024-07-19 15:15:10'),
(0, 89, '2024-07-21 03:51:51'),
(0, 90, '2024-07-24 20:41:49'),
(0, 90, '2024-07-24 21:12:29'),
(0, 93, '2024-07-30 15:37:30'),
(0, 93, '2024-07-30 15:39:55'),
(0, 96, '2024-07-30 15:49:02'),
(0, 100, '2024-07-30 16:42:23'),
(0, 108, '2024-07-30 20:08:13'),
(0, 108, '2024-07-30 20:13:23'),
(0, 110, '2024-07-30 21:02:53'),
(0, 52, '2024-07-30 21:16:55'),
(0, 52, '2024-07-31 04:46:11'),
(0, 21, '2024-08-22 03:22:38'),
(0, 21, '2024-08-22 03:30:04'),
(0, 21, '2024-08-22 03:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `archive_list`
--

CREATE TABLE `archive_list` (
  `id` int(30) NOT NULL,
  `archive_code` varchar(100) NOT NULL,
  `curriculum_id` int(30) NOT NULL,
  `year` year(4) NOT NULL,
  `title` text NOT NULL,
  `abstract` text NOT NULL,
  `members` text NOT NULL,
  `banner_path` text NOT NULL,
  `document_path` text NOT NULL,
  `folder_path` text DEFAULT NULL,
  `sql_path` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `student_id` int(30) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `archive_list`
--

INSERT INTO `archive_list` (`id`, `archive_code`, `curriculum_id`, `year`, `title`, `abstract`, `members`, `banner_path`, `document_path`, `folder_path`, `sql_path`, `status`, `student_id`, `date_created`, `date_updated`) VALUES
(21, '2023070007', 7, '2023', 'Web App Development', 'bububububububujbu', '&lt;p&gt;bubu&lt;/p&gt;&lt;p&gt;tanga&lt;/p&gt;&lt;p&gt;lutang&lt;/p&gt;', 'uploads/banners/archive-21.png?v=1690737880', 'uploads/pdf/archive-21.pdf?v=1690647491', 'uploads/files/upload_21.zip?v=1690647492', NULL, 1, 13, '2023-07-30 00:18:08', NULL),
(22, '2023070001', 7, '2023', 'Android studio System', '&lt;p&gt;Basta bisan nano ang unod dire&lt;/p&gt;', '&lt;p&gt;Franco&lt;/p&gt;&lt;p&gt;Khufra&lt;/p&gt;&lt;p&gt;Akia&lt;/p&gt;', 'uploads/banners/archive-22.png?v=1690741220', 'uploads/pdf/archive-22.pdf?v=1690741220', 'uploads/files/upload_22.zip?v=1690741220', NULL, 1, 16, '2023-07-31 02:20:19', NULL),
(23, '2023070002', 7, '2023', 'Coding Matrix Systeem', 'Basta Abstract lagi kami bahala nanong ibutang', '&lt;p&gt;Miya&amp;nbsp;&lt;/p&gt;&lt;p&gt;Layla&lt;/p&gt;&lt;p&gt;Lesley&lt;/p&gt;', 'uploads/banners/archive-23.png?v=1690742332', 'uploads/pdf/archive-23.pdf?v=1690742332', 'uploads/files/upload_23.zip?v=1690742332', NULL, 1, 17, '2023-07-31 02:38:51', NULL),
(32, '2023070011', 11, '2023', 'Computer Programming', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;/p&gt;&lt;p&gt;tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;/p&gt;&lt;p&gt;quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;/p&gt;&lt;p&gt;consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;/p&gt;&lt;p&gt;cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;/p&gt;&lt;p&gt;proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '&lt;p&gt;Bene&lt;/p&gt;&lt;p&gt;Ana&lt;/p&gt;&lt;p&gt;Delia&lt;/p&gt;', 'uploads/banners/archive-32.png?v=1690816195', 'uploads/pdf/archive-32.pdf?v=1690816195', 'uploads/files/upload_32.zip?v=1690816195', NULL, 1, 19, '2023-07-31 23:09:54', NULL),
(35, '2023070014', 1, '2023', 'System Integration', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;/p&gt;&lt;p&gt;tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;/p&gt;&lt;p&gt;quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;/p&gt;&lt;p&gt;consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;/p&gt;&lt;p&gt;cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;/p&gt;&lt;p&gt;proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '&lt;p&gt;Pekka&lt;/p&gt;&lt;p&gt;Golem&lt;/p&gt;&lt;p&gt;HOg Rider&lt;/p&gt;', 'uploads/banners/archive-35.png?v=1690817605', 'uploads/pdf/archive-35.pdf?v=1690817605', 'uploads/files/upload_35.zip?v=1690817605', NULL, 1, 22, '2023-07-31 23:33:24', NULL),
(38, '2023080002', 7, '2023', 'Optimizing your capstone experiences', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;/p&gt;&lt;p&gt;tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;/p&gt;&lt;p&gt;quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;/p&gt;&lt;p&gt;consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;/p&gt;&lt;p&gt;cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;/p&gt;&lt;p&gt;proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '&lt;p&gt;Layla&amp;nbsp;&lt;/p&gt;&lt;p&gt;Selena&lt;/p&gt;&lt;p&gt;Gusion&lt;/p&gt;', 'uploads/banners/archive-38.png?v=1690840884', 'uploads/pdf/archive-38.pdf?v=1690840885', 'uploads/files/upload_38.zip?v=1690840885', NULL, 1, 29, '2023-08-01 06:01:24', NULL),
(39, '2023080003', 7, '2023', 'Pressbooks Management System', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;/p&gt;&lt;p&gt;tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;/p&gt;&lt;p&gt;quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;/p&gt;&lt;p&gt;consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;/p&gt;&lt;p&gt;cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;/p&gt;&lt;p&gt;proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '&lt;p&gt;Khufra&lt;/p&gt;&lt;p&gt;Tigreal&lt;/p&gt;&lt;p&gt;Lolita&lt;/p&gt;', 'uploads/banners/archive-39.png?v=1690841039', 'uploads/pdf/archive-39.pdf?v=1690841039', NULL, NULL, 1, 30, '2023-08-01 06:03:58', NULL),
(42, '2023080006', 7, '2023', 'Physical Archives Management system', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;/p&gt;&lt;p&gt;tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;/p&gt;&lt;p&gt;quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;/p&gt;&lt;p&gt;consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;/p&gt;&lt;p&gt;cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;/p&gt;&lt;p&gt;proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '&lt;p&gt;Martes&lt;/p&gt;&lt;p&gt;Argus&lt;/p&gt;&lt;p&gt;Yu zhong&lt;/p&gt;', 'uploads/banners/archive-42.png?v=1690841887', 'uploads/pdf/archive-42.pdf?v=1690841888', 'uploads/files/upload_42.zip?v=1690841888', NULL, 1, 33, '2023-08-01 06:18:07', NULL),
(44, '2023080008', 7, '2023', 'Sonia\'s Digital World Management System', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;/p&gt;&lt;p&gt;tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;/p&gt;&lt;p&gt;quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;/p&gt;&lt;p&gt;consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;/p&gt;&lt;p&gt;cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;/p&gt;&lt;p&gt;proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '&lt;p&gt;Sonia&lt;/p&gt;&lt;p&gt;sonya&lt;/p&gt;&lt;p&gt;Sunyia&lt;/p&gt;', 'uploads/banners/archive-44.png?v=1690842354', 'uploads/pdf/archive-44.pdf?v=1690842354', 'uploads/files/upload_44.zip?v=1690842354', NULL, 1, 35, '2023-08-01 06:25:52', NULL),
(46, '2023080010', 7, '2023', 'Tools And Resources For Capstone', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;/p&gt;&lt;p&gt;tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;/p&gt;&lt;p&gt;quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;/p&gt;&lt;p&gt;consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;/p&gt;&lt;p&gt;cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;/p&gt;&lt;p&gt;proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '&lt;p&gt;Akia&lt;/p&gt;&lt;p&gt;Minsitar&lt;/p&gt;&lt;p&gt;Joy&lt;/p&gt;', 'uploads/banners/archive-46.png?v=1690842773', 'uploads/pdf/archive-46.pdf?v=1690842773', 'uploads/files/upload_46.zip?v=1690842773', NULL, 1, 37, '2023-08-01 06:32:52', NULL),
(49, '2023080013', 7, '2023', 'Enrollment Management System', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod&lt;/p&gt;&lt;p&gt;tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,&lt;/p&gt;&lt;p&gt;quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo&lt;/p&gt;&lt;p&gt;consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse&lt;/p&gt;&lt;p&gt;cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non&lt;/p&gt;&lt;p&gt;proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '&lt;p&gt;Freya&lt;/p&gt;&lt;p&gt;Moskov&lt;/p&gt;&lt;p&gt;Valentina&lt;/p&gt;', 'uploads/banners/archive-49.png?v=1690843930', 'uploads/pdf/archive-49.pdf?v=1690843930', 'uploads/files/upload_49.zip?v=1690843930', NULL, 1, 40, '2023-08-01 06:52:09', NULL),
(51, '2023080015', 7, '2023', 'Testing 123', '&lt;p&gt;test&lt;/p&gt;', '&lt;p&gt;test1&lt;/p&gt;&lt;p&gt;test2&lt;/p&gt;', 'uploads/banners/archive-51.png?v=1691336735', 'uploads/pdf/archive-51.pdf?v=1691336735', NULL, 'uploads/sql/sql51.sql?v=1691336735', 1, 13, '2023-08-06 23:45:33', NULL),
(52, '2023080016', 7, '2023', 'Database Design system', '&lt;p&gt;Testing&lt;/p&gt;', '&lt;p&gt;rhej&lt;/p&gt;&lt;p&gt;hsis&lt;/p&gt;&lt;p&gt;gu&lt;/p&gt;', 'uploads/banners/archive-52.png?v=1691337122', 'uploads/pdf/archive-52.pdf?v=1691337123', 'uploads/files/upload_52.zip?v=1691337124', 'uploads/sql/sql52.sql?v=1691337123', 1, 13, '2023-08-06 23:52:01', NULL),
(80, '2024070003', 7, '2024', 'House Rental Management System', '&lt;p&gt;ajncljan scbkjab swknc akbckahs&lt;/p&gt;', '&lt;p&gt;1. kjascm asbjk&lt;/p&gt;&lt;p&gt;2. klasnc. d,cne&lt;/p&gt;&lt;p&gt;3. kjaskcbakjek&lt;/p&gt;', '', '', NULL, NULL, 1, 13, '2024-07-16 22:44:58', NULL),
(83, '2024070001', 7, '2024', 'BSIT Repository', '&lt;p&gt;acajbckjashjdcacs oasshcoahsdlvcajv olabsla olajn jsabdcg oajxbcaljsduc&lt;/p&gt;', '&lt;p&gt;AJSNCLABCLLD&lt;/p&gt;&lt;p&gt;oacnlajbdo&lt;/p&gt;&lt;p&gt;baojsablsjc&lt;/p&gt;', '', '', NULL, NULL, 1, 41, '2024-07-17 21:41:26', NULL),
(90, '2024070002', 7, '2024', 'Pizza Store Management', '&lt;p&gt;hkasbckdsb&amp;nbsp;&lt;/p&gt;', '&lt;p&gt;dcscscd&lt;/p&gt;', '', '', NULL, NULL, 1, 45, '2024-07-24 19:58:19', NULL),
(123, '2024080001', 7, '0000', '', '', '', '', '', NULL, NULL, 0, 45, '2024-08-01 03:08:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_list`
--

CREATE TABLE `curriculum_list` (
  `id` int(30) NOT NULL,
  `program_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `curriculum_list`
--

INSERT INTO `curriculum_list` (`id`, `program_id`, `name`, `description`, `status`, `date_created`, `date_updated`) VALUES
(1, 5, 'System Integration', 'System Integration', 1, '2021-12-07 10:10:20', '2023-06-29 04:05:19'),
(3, 5, 'Mobile Application', 'Mobile Application Development - hybrid / native', 1, '2021-12-07 10:12:50', '2023-06-29 04:14:58'),
(7, 5, 'Capstone', 'Capstone Project', 1, '2021-12-07 10:15:28', '2023-06-29 04:08:48'),
(11, 5, 'Capstone 2', 'Computer Programming Projects', 1, '2023-06-29 04:19:47', NULL),
(12, 5, 'Web System', 'Web System and Technologies', 1, '2023-06-29 04:20:58', NULL),
(15, 5, 'Networking', 'Networking', 1, '2024-07-17 22:27:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ip_details`
--

CREATE TABLE `ip_details` (
  `id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `login_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ip_details`
--

INSERT INTO `ip_details` (`id`, `ip`, `login_time`) VALUES
(1, '::1', 1725609623),
(2, '::1', 1725609637),
(3, '::1', 1725613925),
(4, '::1', 1725613954),
(5, '::1', 1725614971),
(6, '::1', 1725639895),
(7, '::1', 1725639918),
(8, '::1', 1725639964),
(9, '::1', 1725640173);

-- --------------------------------------------------------

--
-- Table structure for table `keyword_search_counter`
--

CREATE TABLE `keyword_search_counter` (
  `id` int(11) NOT NULL,
  `keyword` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keyword_search_counter`
--

INSERT INTO `keyword_search_counter` (`id`, `keyword`, `created_at`) VALUES
(0, 'Android', '2023-07-31 03:00:08'),
(0, 'Andriod', '2023-07-31 03:00:34'),
(0, 'MCC Library', '2023-07-31 03:01:15'),
(0, 'computer', '2023-07-31 15:11:22'),
(0, 'Clash of', '2023-08-01 10:47:35'),
(0, 'wood', '2023-08-01 10:55:36'),
(0, 'wood', '2023-08-01 10:56:00'),
(0, 'system in', '2023-08-02 10:23:22'),
(0, 'system in', '2023-08-02 10:23:48');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('read','unread') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `student_id`, `message`, `date_created`, `status`) VALUES
(1, 45, 'Your project has been published by the admin.', '2024-07-25 15:50:46', 'read'),
(2, 45, 'Your project has been unpublished by the admin.', '2024-07-25 16:39:53', 'read'),
(3, 45, 'Your project has been published by the admin.', '2024-07-25 16:40:32', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_list`
--

CREATE TABLE `program_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `program_list`
--

INSERT INTO `program_list` (`id`, `name`, `description`, `status`, `date_created`, `date_updated`) VALUES
(5, 'BSIT', 'Bachelor of Science and Information Technology', 1, '2023-06-28 09:35:19', '2023-06-29 00:51:32'),
(9, 'BSBA', 'Bachelor of Science of Business Add', 1, '2024-07-17 22:26:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `program_id` int(30) NOT NULL,
  `curriculum_id` int(30) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `avatar` text NOT NULL,
  `captcha_code` varchar(100) NOT NULL DEFAULT '0000',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`id`, `firstname`, `middlename`, `lastname`, `program_id`, `curriculum_id`, `email`, `password`, `gender`, `status`, `avatar`, `captcha_code`, `date_created`, `date_updated`, `reset_token`, `token_expiry`) VALUES
(13, 'Romel', '', 'Alolod', 5, 7, 'romel@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Male', 1, 'uploads/student-13.png?v=1690156908', '0000', '2023-07-24 07:41:28', NULL, NULL, NULL),
(16, 'lot', '', 'lance', 5, 7, 'lancelot@gmail.com', '8743d4f8db2f7e463089c5d5477940a0', 'Male', 1, 'uploads/student-16.png?v=1690740597', '0000', '2023-07-31 02:06:27', NULL, NULL, NULL),
(17, 'sion', '', 'gu', 5, 7, 'gusion@gmail.com', 'bb97f8726468ab2a205bf640eb28e728', 'Male', 1, 'uploads/student-17.png?v=1690742085', '0000', '2023-07-31 02:31:45', NULL, NULL, NULL),
(19, 'curt', '', 'hel', 5, 11, 'helcurt@gmail.com', 'cf8b66ebfc6f04e47bca0b1cf117d54f', 'Male', 1, 'uploads/student-19.png?v=1690793348', '0000', '2023-07-31 14:07:13', NULL, NULL, NULL),
(22, 'card', '', 'alu', 5, 1, 'alucard@gmail.com', '4dbf17d127c7acd54b25276782a48041', 'Male', 1, 'uploads/student-22.png?v=1690793671', '0000', '2023-07-31 14:49:12', NULL, NULL, NULL),
(23, 'ber', '', 'sa', 5, 12, 'saber@gmail.com', '2bde79bff687ae45f1354cde4324ccdd', 'Male', 1, 'uploads/student-23.png?v=1690793744', '0000', '2023-07-31 14:53:38', NULL, NULL, NULL),
(24, 'shin', '', 'yisun', 5, 7, 'yisunshin@gmail.com', 'bf4e4b08141f72e34a59011d4929fcbc', 'Male', 1, 'uploads/student-24.png?v=1690793851', '0000', '2023-07-31 14:55:38', NULL, NULL, NULL),
(25, 'ley', '', 'har', 5, 7, 'harley@gmail.com', 'ef4cdd3117793b9fd593d7488409626d', 'Male', 1, 'uploads/student-25.png?v=1690793941', '0000', '2023-07-31 15:00:16', NULL, NULL, NULL),
(26, 'mon', '', 'aa', 5, 7, 'aamon@gmail.com', 'd850f895529a6b8658c13a808474337b', 'Male', 1, 'uploads/student-26.png?v=1690794010', '0000', '2023-07-31 15:03:28', NULL, NULL, NULL),
(28, 'lott', '', 'ar', 5, 7, 'arlott@gmail.com', 'bbb9a2ca264f9bf115fbfcd9767c5f13', 'Male', 1, 'uploads/student-28.png?v=1690794075', '0000', '2023-07-31 15:09:27', NULL, NULL, NULL),
(29, 'oy', '', 'j', 5, 7, 'joy@gmail.com', 'c2c8e798aecbc26d86e4805114b03c51', 'Female', 1, 'uploads/student-29.png?v=1690794137', '0000', '2023-07-31 15:10:48', NULL, NULL, NULL),
(30, 'rina', '', 'ka', 5, 7, 'karina@gmail.com', 'a37b2a637d2541a600d707648460397e', 'Female', 1, 'uploads/student-30.png?v=1690794207', '0000', '2023-07-31 15:11:59', NULL, NULL, NULL),
(31, 'lia', '', 'nata', 5, 7, 'natalia@gmail.com', 'c1ed60949799e3adcd72928bb3314fe0', 'Female', 1, 'uploads/student-31.png?v=1690794301', '0000', '2023-07-31 15:13:24', NULL, NULL, NULL),
(32, 'lena', '', 'se', 5, 7, 'selena@gmail.com', '1dbb36285f8dd70721b245b98fbaf4f4', 'Female', 1, 'uploads/student-32.png?v=1690794367', '0000', '2023-07-31 15:16:27', NULL, NULL, NULL),
(33, 'zo', '', 'han', 5, 7, 'hanzo@gmail.com', 'ce15b45484a184c81076752d7f8b30c1', 'Male', 1, 'uploads/student-33.png?v=1690794439', '0000', '2023-07-31 15:18:21', NULL, NULL, NULL),
(34, 'detta', '', 'bene', 5, 7, 'benedetta@gmail.com', '40f111ab7749b471fff12b44c648b92e', 'Female', 1, 'uploads/student-34.png?v=1690794518', '0000', '2023-07-31 15:20:08', NULL, NULL, NULL),
(35, 'n', '', 'yi', 5, 7, 'yin@gmail.com', '08fb144c598dba6ce102bf0696b0a6c8', 'Male', 1, 'uploads/student-35.png?v=1690794596', '0000', '2023-07-31 15:27:15', NULL, NULL, NULL),
(36, 'ilda', '', 'math', 5, 7, 'mathilda@gmail.com', '54368aff579eabe182cc2e47f9034a58', 'Female', 1, 'uploads/student-36.png?v=1690794674', '0000', '2023-07-31 15:30:38', NULL, NULL, NULL),
(37, 'uito', '', 'paq', 5, 7, 'paquito@gmail.com', 'f1aaaa4510293f29504303fc3111a7ae', 'Male', 1, 'uploads/student-37.png?v=1690794747', '0000', '2023-07-31 15:34:20', NULL, NULL, NULL),
(38, 'dita', '', 'ka', 5, 7, 'kadita@gmail.com', 'adc4b69f52d6b82ab93e8bb339b2e07c', 'Female', 1, 'uploads/student-38.png?v=1690794821', '0000', '2023-07-31 15:36:46', NULL, NULL, NULL),
(39, 'ley', '', 'les', 5, 7, 'lesley@gmail.com', '8744c53672906143e20538f6ac3deadb', 'Female', 1, 'uploads/student-39.png?v=1690794880', '0000', '2023-07-31 15:39:55', NULL, NULL, NULL),
(40, 'long', '', 'zi', 5, 7, 'zilong@gmail', '595851bf7481b355ff77a38f9183e162', 'Male', 1, 'uploads/student-40.png?v=1690794959', '0000', '2023-07-31 15:41:53', NULL, NULL, NULL),
(41, 'Sherwin', '', 'Ciervo', 5, 7, 'sherwin@gmail.com', '875a31ea8071f7effdecf590626bde0a', 'Male', 1, '', '0000', '2024-07-15 17:46:24', NULL, NULL, NULL),
(44, 'John', '', 'James', 5, 7, 'johnjames@gmail.com', '9ba36afc4e560bf811caefc0c7fddddf', 'Male', 0, '', '0000', '2024-07-17 17:40:15', NULL, NULL, NULL),
(45, 'Sherwin', '', 'Ciervo', 5, 7, 'sherwintayo08@gmail.com', '875a31ea8071f7effdecf590626bde0a', 'Male', 1, '', '0000', '2024-07-21 15:12:56', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'BSIT Department Management System'),
(6, 'short_name', 'BSIT PRS'),
(11, 'logo', 'uploads/logo-1689949096.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1689949096.png'),
(15, 'content', 'Array'),
(16, 'email', 'mccbsit@mcclawis.edu.ph'),
(17, 'contact', '(032) 11787877'),
(18, 'from_time', '11:00'),
(19, 'to_time', '21:30'),
(20, 'address', 'Bunakan Madridejos Cebu');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'Sherwin', NULL, 'Ciervo', 'sherwintayo08@gmail.com', '909c8cb92b10071621bf6455a0bcea98', 'uploads/student-1.png?v=1639202560', NULL, 1, 1, '2021-01-20 14:02:37', '2021-12-11 14:02:40', NULL, NULL),
(2, 'Jane', NULL, 'Doe', 'jdoe', '4f709c721d104de88781649ec5d0e616', 'uploads/avatar-2.png?v=1639377482', NULL, 2, 1, '2021-12-13 14:38:02', '2023-06-29 08:54:13', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`activity_log_id`);

--
-- Indexes for table `archive_list`
--
ALTER TABLE `archive_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curriculum_id` (`curriculum_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `curriculum_list`
--
ALTER TABLE `curriculum_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `ip_details`
--
ALTER TABLE `ip_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`token`);

--
-- Indexes for table `program_list`
--
ALTER TABLE `program_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD KEY `curriculum_id` (`curriculum_id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
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
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `activity_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `archive_list`
--
ALTER TABLE `archive_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `curriculum_list`
--
ALTER TABLE `curriculum_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ip_details`
--
ALTER TABLE `ip_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program_list`
--
ALTER TABLE `program_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archive_list`
--
ALTER TABLE `archive_list`
  ADD CONSTRAINT `archive_list_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_list` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `curriculum_list`
--
ALTER TABLE `curriculum_list`
  ADD CONSTRAINT `curriculum_list_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `program_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_list`
--
ALTER TABLE `student_list`
  ADD CONSTRAINT `student_list_ibfk_1` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_list_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `program_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
