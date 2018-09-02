-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2018 at 05:49 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemprov`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` int(11) DEFAULT NULL,
  `shortname` char(2) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id_events` int(11) NOT NULL,
  `id_users` int(10) UNSIGNED NOT NULL,
  `nama_event` varchar(225) NOT NULL,
  `keterangan` text NOT NULL,
  `cover_event` varchar(225) NOT NULL,
  `lokasi` varchar(225) NOT NULL,
  `mulai` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `akhir` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tanggal` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id_events`, `id_users`, `nama_event`, `keterangan`, `cover_event`, `lokasi`, `mulai`, `akhir`, `tanggal`, `status`) VALUES
(4, 1, '1212', 'asasa', '', '', '2018-09-13 22:18:00', '2018-09-20 10:57:00', '2018-09-01 09:57:32', 0),
(5, 1, 'Hahah', 'Cobain', '', '', '2018-09-01 18:10:10', '2018-09-02 17:49:00', '2018-09-01 10:52:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_coment`
--

CREATE TABLE `event_coment` (
  `id` int(11) NOT NULL,
  `id_users` int(11) UNSIGNED NOT NULL,
  `id_events` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_coment`
--

INSERT INTO `event_coment` (`id`, `id_users`, `id_events`, `komentar`, `created_at`, `updated_at`) VALUES
(2, 1, 4, 'aaaa', '2018-09-01 10:38:10', '2018-09-01 10:38:10'),
(5, 1, 4, 'aaaaa', '2018-09-01 10:38:56', '2018-09-01 10:38:56'),
(10, 1, 4, 'asasa', '2018-09-01 12:31:57', '2018-09-01 12:31:57'),
(13, 1, 5, 'asasasasa', '2018-09-01 12:38:47', '2018-09-01 12:38:47'),
(14, 1, 5, '11111', '2018-09-01 12:38:52', '2018-09-01 12:38:52'),
(15, 1, 5, 'Jancok', '2018-09-01 12:39:08', '2018-09-01 12:39:08'),
(16, 1, 4, 'Jancok', '2018-09-01 12:40:10', '2018-09-01 12:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `id` int(10) UNSIGNED NOT NULL,
  `requester` int(11) NOT NULL,
  `user_requested` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `hobby_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grup`
--

CREATE TABLE `grup` (
  `id_grup` int(11) NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `nama_grup` varchar(225) NOT NULL,
  `avatar` varchar(225) NOT NULL,
  `cover_grup` varchar(225) NOT NULL,
  `status_grup` enum('public','tertutup','rahasia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grup`
--

INSERT INTO `grup` (`id_grup`, `id_user`, `nama_grup`, `avatar`, `cover_grup`, `status_grup`) VALUES
(2, 1, 'Hahaha', '', '', 'public'),
(6, 1, 'coba', '', '', 'public'),
(7, 1, 'hahah bisa ?', '', '', 'public'),
(8, 1, 'Coba again', '', '', 'public');

-- --------------------------------------------------------

--
-- Table structure for table `grup_post_comments`
--

CREATE TABLE `grup_post_comments` (
  `id` int(11) NOT NULL,
  `grup_post_id` int(10) UNSIGNED NOT NULL,
  `comment_grup_user_id` int(10) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seen` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hobbies`
--

CREATE TABLE `hobbies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hobbies`
--

INSERT INTO `hobbies` (`id`, `name`) VALUES
(1, 'Reading'),
(2, 'Watching TV'),
(3, 'Family Time'),
(4, 'Going to Movies'),
(5, 'Fishing'),
(6, 'Computer'),
(7, 'Gardening'),
(8, 'Renting Movies'),
(9, 'Walking'),
(10, 'Exercise'),
(11, 'Listening to Music'),
(12, 'Entertaining'),
(13, 'Hunting'),
(14, 'Team Sports'),
(15, 'Shopping'),
(16, 'Traveling'),
(17, 'Sleeping'),
(18, 'Socializing'),
(19, 'Sewing'),
(20, 'Golf'),
(21, 'Church Activities'),
(22, 'Relaxing'),
(23, 'Playing Music'),
(24, 'Housework'),
(25, 'Crafts'),
(26, 'Watching Sports'),
(27, 'Bicycling'),
(28, 'Playing Cards'),
(29, 'Hiking'),
(30, 'Cooking'),
(31, 'Eating Out'),
(32, 'Dating Online'),
(33, 'Swimming'),
(34, 'Camping'),
(35, 'Skiing'),
(36, 'Working on Cars'),
(37, 'Writing'),
(38, 'Boating'),
(39, 'Motorcycling'),
(40, 'Animal Care'),
(41, 'Bowling'),
(42, 'Painting'),
(43, 'Running'),
(44, 'Dancing'),
(45, 'Horseback Riding'),
(46, 'Tennis'),
(47, 'Theater'),
(48, 'Billiards'),
(49, 'Beach'),
(50, 'Volunteer Work');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_05_20_131345_update_users_table', 1),
(4, '2017_05_20_131839_create_user_direct_messages', 1),
(5, '2017_05_20_132515_create_user_following_table', 1),
(6, '2017_05_20_133038_create_countries', 1),
(7, '2017_05_20_133151_create_cities_table', 1),
(8, '2017_05_20_133406_create_hobbies_table', 1),
(9, '2017_05_20_133512_create_groups_table', 1),
(10, '2017_05_20_133707_create_user_hobbies_table', 1),
(11, '2017_05_20_133850_create_user_locations_table', 1),
(12, '2017_05_20_134119_create_posts_tables', 1),
(13, '2017_05_20_202256_update_users_table_2', 1),
(14, '2017_06_03_143218_update_users_table_3', 1),
(15, '2017_06_03_185756_update_user_locations_table', 1),
(16, '2017_06_06_182742_create_user_relationship_table', 1),
(17, '2017_06_08_181805_update_seen_tables', 1),
(18, '2016_12_14_083405_create_profiles_table', 2),
(19, '2016_12_17_064034_create_friendships_table', 2),
(20, '2016_12_22_095620_create_notifications_table', 2),
(21, '2016_12_23_091201_create_jobs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` int(10) UNSIGNED NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `has_image` tinyint(1) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `group_id`, `has_image`, `content`, `created_at`, `updated_at`) VALUES
(2, 2, 0, 1, 'Testing', '2018-08-28 23:47:35', '2018-08-28 23:47:35'),
(22, 1, 0, 0, 'Aaa', '2018-09-02 07:04:33', '2018-09-02 07:04:33'),
(23, 1, 0, 0, 'asasa', '2018-09-02 07:05:30', '2018-09-02 07:05:30');

-- --------------------------------------------------------

--
-- Table structure for table `posts_grup`
--

CREATE TABLE `posts_grup` (
  `id_post_grup` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `group_post_id` int(11) UNSIGNED NOT NULL,
  `has_image` tinyint(2) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts_grup`
--

INSERT INTO `posts_grup` (`id_post_grup`, `user_id`, `group_post_id`, `has_image`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 0, 'asasasaasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 6, 1, 'asasasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 6, 1, 'asasasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 6, 1, 'asasasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 6, 1, 'asasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 1, 6, 1, 'aasasasaasasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 1, 6, 1, 'asasasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 1, 6, 1, 'HJHJH', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 1, 6, 0, 'jljl', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 1, 7, 0, 'asasasasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 1, 7, 1, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 1, 8, 0, 'asasasasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 1, 8, 0, 'asasa', '2018-09-02 08:37:32', '2018-09-02 08:37:32'),
(16, 1, 8, 1, '', '2018-09-02 08:37:56', '2018-09-02 08:37:56'),
(17, 1, 8, 0, 'asasasa', '2018-09-02 09:43:46', '2018-09-02 09:43:46'),
(18, 1, 8, 0, 'asasasa', '2018-09-02 09:49:18', '2018-09-02 09:49:18'),
(19, 1, 8, 0, 'asasa', '2018-09-02 09:49:39', '2018-09-02 09:49:39'),
(20, 1, 7, 0, 'asasasa', '2018-09-02 09:56:35', '2018-09-02 09:56:35'),
(21, 1, 7, 0, 'asasa', '2018-09-02 09:57:58', '2018-09-02 09:57:58'),
(22, 1, 7, 0, 'sasasa', '2018-09-02 09:58:31', '2018-09-02 09:58:31'),
(23, 1, 7, 0, 'aasasa', '2018-09-02 09:59:19', '2018-09-02 09:59:19'),
(26, 1, 7, 1, 'asasasasa', '2018-09-02 12:07:54', '2018-09-02 12:07:54'),
(27, 1, 7, 1, 'asasasasa', '2018-09-02 12:10:11', '2018-09-02 12:10:11'),
(28, 1, 7, 0, 'asasasa', '2018-09-02 12:11:49', '2018-09-02 12:11:49'),
(29, 1, 8, 0, 'asasasa', '2018-09-02 14:25:08', '2018-09-02 14:25:08'),
(30, 1, 8, 0, 'aaaa', '2018-09-02 15:02:29', '2018-09-02 15:02:29'),
(31, 1, 8, 0, 'asa', '2018-09-02 15:04:20', '2018-09-02 15:04:20'),
(32, 1, 8, 0, 'asa', '2018-09-02 15:04:34', '2018-09-02 15:04:34'),
(33, 1, 8, 0, 'asasasa', '2018-09-02 15:05:33', '2018-09-02 15:05:33'),
(34, 1, 8, 0, 'asasasa', '2018-09-02 15:05:45', '2018-09-02 15:05:45'),
(35, 1, 8, 0, 'asasasa', '2018-09-02 15:05:53', '2018-09-02 15:05:53'),
(36, 1, 8, 0, 'asasasa', '2018-09-02 15:07:54', '2018-09-02 15:07:54'),
(37, 1, 8, 0, 'asasasa', '2018-09-02 15:08:43', '2018-09-02 15:08:43'),
(38, 1, 8, 0, 'asasa', '2018-09-02 15:09:40', '2018-09-02 15:09:40'),
(39, 1, 8, 0, 'aaa', '2018-09-02 15:12:33', '2018-09-02 15:12:33'),
(40, 1, 8, 0, 'aaaaa', '2018-09-02 15:13:20', '2018-09-02 15:13:20'),
(41, 1, 8, 0, 'aaaaa', '2018-09-02 15:13:28', '2018-09-02 15:13:28'),
(42, 1, 8, 0, 'aaaaa', '2018-09-02 15:30:40', '2018-09-02 15:30:40'),
(43, 1, 8, 0, 'aaaaa', '2018-09-02 15:32:23', '2018-09-02 15:32:23'),
(44, 1, 8, 0, 'asas', '2018-09-02 15:33:45', '2018-09-02 15:33:45'),
(45, 1, 8, 0, 'sasasasa', '2018-09-02 15:34:52', '2018-09-02 15:34:52'),
(46, 1, 8, 0, 'asasa', '2018-09-02 15:37:05', '2018-09-02 15:37:05'),
(47, 1, 8, 0, 'asasa', '2018-09-02 15:37:13', '2018-09-02 15:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `comment_user_id` int(10) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_grup_images`
--

CREATE TABLE `post_grup_images` (
  `id` int(11) NOT NULL,
  `post_grup_id` int(11) NOT NULL,
  `image_path` varchar(225) NOT NULL,
  `file_path` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_grup_images`
--

INSERT INTO `post_grup_images` (`id`, `post_grup_id`, `image_path`, `file_path`) VALUES
(1, 4, '', '413d9ef9148bad1b81412c0115bffc20.txt'),
(2, 5, '', '8b6c3a49cff5c39f53dc957b2793e0ac.docx'),
(3, 6, '', 'f2dd19e9acdd49eb5373c3da0260548e.docx'),
(4, 7, '', '213f1e4a6a2f02e14eaaa12dc0fed71d.docx'),
(5, 8, '', '69b5bff27d9a8dc4368cd97400b1e864.txt'),
(6, 13, 'bf10a01a0c819b4f207dacb339acbf20.JPG', ''),
(7, 16, '6dfdf041fe7c4f2b4c3402cdd344346d.JPG', ''),
(9, 27, '', 'c160c5d66486cc6f615e8899fd0b1926.sql');

-- --------------------------------------------------------

--
-- Table structure for table `post_grup_likes`
--

CREATE TABLE `post_grup_likes` (
  `grup_post_id` int(11) NOT NULL,
  `like_user` int(11) UNSIGNED NOT NULL,
  `seen` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_grup_likes`
--

INSERT INTO `post_grup_likes` (`grup_post_id`, `like_user`, `seen`, `created_at`, `updated_at`) VALUES
(9, 1, 0, '2018-09-02 04:59:53', '2018-09-02 04:59:53'),
(21, 1, 0, '2018-09-02 04:54:39', '2018-09-02 04:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE `post_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_images`
--

INSERT INTO `post_images` (`id`, `post_id`, `image_path`, `file_path`) VALUES
(1, 2, 'a506055466e67dce252b98e29d720cca.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `like_user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('member','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `groups` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `private`, `birthday`, `sex`, `phone`, `bio`, `profile_path`, `username`, `role`, `groups`, `cover_path`) VALUES
(1, 'Fahmi Fauzi', 'fauzifahmi55@gmail.com', '$2y$10$1M/C1JxXOUHlE8aTwvccguBkRFNueng7r9j3MNLEbzbR.D6ODUE5O', 'M1Y3cqezjl6YgBA6r6At9qp0BH5d6BzmHAAtewaYfralRhx8Pvi5F2BA1EmD', '2018-08-28 23:41:23', '2018-08-31 08:39:18', 0, NULL, 0, NULL, NULL, 'd1aefacc1601a33c5e81bedcc14e31ce.JPG', 'admin', 'admin', '', '408b419c5540a64c54af9d6835dd7c47.JPG'),
(2, 'Fahmi Fauzi', 'fauzifahmi551@gmail.com', '$2y$10$k2AVCxAdNrEl54hCusVlUOrcJwDIThltxih69Goy7nNDGGB/KPGhO', '3LbNkbPMbxrXY0GkogeQrnaenYkPUHuu7iOl1uLUak5O2aqMFuzE40RYbHnm', '2018-08-28 23:42:57', '2018-08-30 01:28:41', 1, NULL, 0, NULL, NULL, '9e2dd42733c59ac487894c70f3aa987e.JPG', 'admin12121', 'member', '', 'c5896b10a7b2b21ca7d3d19e9536b69a.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `user_direct_messages`
--

CREATE TABLE `user_direct_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender_user_id` int(10) UNSIGNED NOT NULL,
  `receiver_user_id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `sender_delete` tinyint(1) NOT NULL DEFAULT '0',
  `receiver_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_direct_messages`
--

INSERT INTO `user_direct_messages` (`id`, `sender_user_id`, `receiver_user_id`, `message`, `seen`, `sender_delete`, `receiver_delete`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Test', 1, 0, 1, '2018-08-28 23:44:26', '2018-09-01 21:33:36'),
(2, 1, 2, 'Hahaha bisa', 1, 1, 0, '2018-08-28 23:45:02', '2018-09-01 21:33:36'),
(3, 1, 2, 'Hahaha bisa', 1, 1, 0, '2018-08-28 23:45:32', '2018-09-01 21:33:36'),
(4, 1, 2, 'Bisa ?', 1, 1, 1, '2018-08-28 23:45:51', '2018-09-01 21:33:36'),
(5, 1, 2, 'Bisa ?', 1, 1, 0, '2018-08-28 23:45:56', '2018-09-01 21:33:36'),
(6, 2, 1, 'Apaan ?', 1, 0, 1, '2018-08-28 23:52:30', '2018-09-01 21:33:36'),
(7, 1, 2, 'Tadi testing', 1, 1, 1, '2018-08-29 20:01:53', '2018-09-01 21:33:36'),
(8, 2, 1, '1111', 1, 0, 1, '2018-08-30 01:21:38', '2018-09-01 21:33:36'),
(9, 2, 1, '112121', 1, 0, 1, '2018-08-30 01:21:57', '2018-09-01 21:33:36'),
(10, 2, 1, '1111', 1, 0, 1, '2018-08-30 01:23:36', '2018-09-01 21:33:36'),
(11, 1, 2, 'ada apa ?', 0, 1, 0, '2018-08-30 02:55:33', '2018-09-01 21:33:36'),
(12, 1, 2, 'kokoko', 0, 1, 0, '2018-08-30 05:56:39', '2018-08-30 05:56:44'),
(13, 1, 2, '111', 0, 1, 0, '2018-08-31 06:26:20', '2018-09-01 21:33:36'),
(14, 1, 2, 'bisa ?', 0, 1, 0, '2018-08-31 06:29:16', '2018-09-01 21:33:36'),
(15, 1, 2, 'hahaha', 0, 1, 0, '2018-08-31 06:29:20', '2018-09-01 21:33:36'),
(16, 1, 2, 'Testin', 0, 1, 0, '2018-09-01 21:33:25', '2018-09-01 21:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_following`
--

CREATE TABLE `user_following` (
  `id` int(10) UNSIGNED NOT NULL,
  `following_user_id` int(10) UNSIGNED NOT NULL,
  `follower_user_id` int(10) UNSIGNED NOT NULL,
  `allow` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_following`
--

INSERT INTO `user_following` (`id`, `following_user_id`, `follower_user_id`, `allow`) VALUES
(2, 1, 2, 1),
(3, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id_user` varchar(9) NOT NULL,
  `id_groups` varchar(9) NOT NULL,
  `allow` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id_user`, `id_groups`, `allow`) VALUES
('1', '6', 1),
('1', '7', 1),
('1', '8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_hobbies`
--

CREATE TABLE `user_hobbies` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `hobby_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_hobbies`
--

INSERT INTO `user_hobbies` (`user_id`, `hobby_id`) VALUES
(1, 4),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

CREATE TABLE `user_locations` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `latitud` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitud` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_relationship`
--

CREATE TABLE `user_relationship` (
  `id` int(10) UNSIGNED NOT NULL,
  `related_user_id` int(10) UNSIGNED NOT NULL,
  `main_user_id` int(10) UNSIGNED NOT NULL,
  `relation_type` int(11) NOT NULL DEFAULT '0',
  `allow` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_events`);

--
-- Indexes for table `event_coment`
--
ALTER TABLE `event_coment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_events` (`id_events`),
  ADD KEY `id_users` (`id_users`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_hobby_id_foreign` (`hobby_id`);

--
-- Indexes for table `grup`
--
ALTER TABLE `grup`
  ADD PRIMARY KEY (`id_grup`);

--
-- Indexes for table `grup_post_comments`
--
ALTER TABLE `grup_post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `posts_grup`
--
ALTER TABLE `posts_grup`
  ADD PRIMARY KEY (`id_post_grup`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_comments_post_id_foreign` (`post_id`),
  ADD KEY `post_comments_comment_user_id_foreign` (`comment_user_id`);

--
-- Indexes for table `post_grup_images`
--
ALTER TABLE `post_grup_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_grup_id` (`post_grup_id`);

--
-- Indexes for table `post_grup_likes`
--
ALTER TABLE `post_grup_likes`
  ADD PRIMARY KEY (`grup_post_id`,`like_user`),
  ADD KEY `like_user` (`like_user`);

--
-- Indexes for table `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_images_post_id_foreign` (`post_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`post_id`,`like_user_id`),
  ADD KEY `post_likes_like_user_id_foreign` (`like_user_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_direct_messages`
--
ALTER TABLE `user_direct_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_direct_messages_sender_user_id_foreign` (`sender_user_id`),
  ADD KEY `user_direct_messages_receiver_user_id_foreign` (`receiver_user_id`);

--
-- Indexes for table `user_following`
--
ALTER TABLE `user_following`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_following_following_user_id_foreign` (`following_user_id`),
  ADD KEY `user_following_follower_user_id_foreign` (`follower_user_id`);

--
-- Indexes for table `user_hobbies`
--
ALTER TABLE `user_hobbies`
  ADD PRIMARY KEY (`user_id`,`hobby_id`),
  ADD KEY `user_hobbies_hobby_id_foreign` (`hobby_id`);

--
-- Indexes for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_locations_city_id_foreign` (`city_id`);

--
-- Indexes for table `user_relationship`
--
ALTER TABLE `user_relationship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_relationship_related_user_id_foreign` (`related_user_id`),
  ADD KEY `user_relationship_main_user_id_foreign` (`main_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id_events` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `event_coment`
--
ALTER TABLE `event_coment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grup`
--
ALTER TABLE `grup`
  MODIFY `id_grup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `grup_post_comments`
--
ALTER TABLE `grup_post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `hobbies`
--
ALTER TABLE `hobbies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `posts_grup`
--
ALTER TABLE `posts_grup`
  MODIFY `id_post_grup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `post_grup_images`
--
ALTER TABLE `post_grup_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_direct_messages`
--
ALTER TABLE `user_direct_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `user_following`
--
ALTER TABLE `user_following`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_relationship`
--
ALTER TABLE `user_relationship`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_coment`
--
ALTER TABLE `event_coment`
  ADD CONSTRAINT `event_coment_ibfk_1` FOREIGN KEY (`id_events`) REFERENCES `events` (`id_events`),
  ADD CONSTRAINT `event_coment_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_hobby_id_foreign` FOREIGN KEY (`hobby_id`) REFERENCES `hobbies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts_grup`
--
ALTER TABLE `posts_grup`
  ADD CONSTRAINT `posts_grup_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_comment_user_id_foreign` FOREIGN KEY (`comment_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_grup_images`
--
ALTER TABLE `post_grup_images`
  ADD CONSTRAINT `post_grup_images_ibfk_1` FOREIGN KEY (`post_grup_id`) REFERENCES `posts_grup` (`id_post_grup`);

--
-- Constraints for table `post_grup_likes`
--
ALTER TABLE `post_grup_likes`
  ADD CONSTRAINT `post_grup_likes_ibfk_1` FOREIGN KEY (`like_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `post_images_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_like_user_id_foreign` FOREIGN KEY (`like_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_direct_messages`
--
ALTER TABLE `user_direct_messages`
  ADD CONSTRAINT `user_direct_messages_receiver_user_id_foreign` FOREIGN KEY (`receiver_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_direct_messages_sender_user_id_foreign` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_following`
--
ALTER TABLE `user_following`
  ADD CONSTRAINT `user_following_follower_user_id_foreign` FOREIGN KEY (`follower_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_following_following_user_id_foreign` FOREIGN KEY (`following_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_hobbies`
--
ALTER TABLE `user_hobbies`
  ADD CONSTRAINT `user_hobbies_hobby_id_foreign` FOREIGN KEY (`hobby_id`) REFERENCES `hobbies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_hobbies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD CONSTRAINT `user_locations_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `user_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_relationship`
--
ALTER TABLE `user_relationship`
  ADD CONSTRAINT `user_relationship_main_user_id_foreign` FOREIGN KEY (`main_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_relationship_related_user_id_foreign` FOREIGN KEY (`related_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
