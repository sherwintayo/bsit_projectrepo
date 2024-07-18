CREATE TABLE `archive_counter` (
  `id` int(11) NOT NULL,
  `archive_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_counter`
--

INSERT INTO `archive_counter` (`id`, `archive_id`, `created_at`) VALUES
(1, 7, '2023-07-25 13:25:59'),
(2, 7, '2023-07-25 13:55:12'),
(3, 7, '2023-07-25 13:56:39'),
(4, 5, '2023-07-26 13:23:20'),
(5, 1, '2023-07-26 13:23:25'),
(6, 7, '2023-07-26 13:23:29'),
(7, 7, '2023-07-26 13:23:31'),
(8, 7, '2023-07-26 13:23:32'),
(9, 7, '2023-07-26 13:23:33'),
(10, 2, '2023-07-26 13:23:36'),
(11, 2, '2023-07-26 13:23:39'),
(12, 4, '2023-07-26 13:23:43'),
(13, 5, '2023-07-26 13:23:46'),
(14, 5, '2023-07-26 13:23:47'),
(15, 5, '2023-07-26 13:23:50'),
(16, 6, '2023-07-26 13:23:52'),
(17, 6, '2023-07-26 13:23:55'),
(18, 3, '2023-07-26 13:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `archive_list`
--