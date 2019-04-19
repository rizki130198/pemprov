-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2019 at 08:37 PM
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
-- Table structure for table `ceks_notif_grup`
--

CREATE TABLE `ceks_notif_grup` (
  `id_ceks` int(11) NOT NULL,
  `id_coment` int(11) NOT NULL,
  `id_grup` int(11) NOT NULL,
  `id_post_grup` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `seen` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ceks_notif_news`
--

CREATE TABLE `ceks_notif_news` (
  `id_cek` int(11) NOT NULL,
  `id_coment` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_berita` int(11) NOT NULL,
  `seen` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `mulai` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `akhir` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id_events`, `id_users`, `nama_event`, `keterangan`, `cover_event`, `lokasi`, `mulai`, `akhir`, `tanggal`, `status`) VALUES
(3, 1, 'Hahah', 'Coba', '', '', '2018-09-19 22:09:00', '2018-09-12 22:09:00', '2018-09-13 01:09:31', 0),
(5, 1, '1212', '1212121', '', '', '2018-09-20 10:25:00', '2018-09-28 09:36:00', '2018-09-16 23:36:23', 0),
(6, 1, 'asasa', 'sasasasa', '', '', '2018-10-26 09:28:00', '2018-10-31 08:28:00', '2018-10-26 01:28:33', 0),
(7, 1, 'Testing', 'Hahaha', '', '', '2020-03-11 19:11:00', '2020-12-18 10:11:00', '2018-11-07 23:14:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_coment`
--

CREATE TABLE `event_coment` (
  `id` int(11) NOT NULL,
  `id_users` int(11) UNSIGNED NOT NULL,
  `id_events` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_coment`
--

INSERT INTO `event_coment` (`id`, `id_users`, `id_events`, `komentar`, `seen`, `created_at`, `updated_at`) VALUES
(9, 1, 5, 'Wkowkowko', 1, '2018-09-17 08:08:16', '2018-09-17 01:08:16'),
(13, 1, 5, 'afafafa', 1, '2018-09-17 08:21:21', '2018-09-17 01:21:21'),
(15, 1, 5, 'hahaha', 1, '2018-09-17 08:21:21', '2018-09-17 01:21:21'),
(16, 1, 5, 'coman', 1, '2018-09-20 04:58:08', '2018-09-19 21:58:08'),
(17, 1, 5, 'gagaga', 1, '2018-09-21 07:57:46', '2018-09-21 00:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `file_upload`
--

CREATE TABLE `file_upload` (
  `id_upload` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `filenya` text NOT NULL,
  `jenis_file` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 1, 'Hahahaha', '', '', 'public'),
(2, 1, 'Jancok', '', '12af1081bf580b9abe0b7d2143c4234a.jpeg', 'public');

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
-- Table structure for table `history_spj`
--

CREATE TABLE `history_spj` (
  `id_history` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_spj` int(11) NOT NULL,
  `comment` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
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
-- Table structure for table `news_comment`
--

CREATE TABLE `news_comment` (
  `id_comment` int(11) NOT NULL,
  `id_news` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `comment` text NOT NULL,
  `seen` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `notif_grup`
--

CREATE TABLE `notif_grup` (
  `id_notif` int(11) NOT NULL,
  `id_grup` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `seen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notif_grup`
--

INSERT INTO `notif_grup` (`id_notif`, `id_grup`, `id_post`, `id_user`, `seen`) VALUES
(1, 2, 6, 4, 1),
(2, 2, 4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notif_news`
--

CREATE TABLE `notif_news` (
  `id_notif_news` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_news` int(11) NOT NULL,
  `seen` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notif_news`
--

INSERT INTO `notif_news` (`id_notif_news`, `id_users`, `id_news`, `seen`) VALUES
(1, 4, 2, 1),
(2, 4, 4, 1),
(3, 4, 11, 1),
(4, 2, 1, 1),
(5, 2, 4, 1),
(6, 2, 2, 1),
(7, 2, 11, 1);

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
-- Table structure for table `pengajuan_spj`
--

CREATE TABLE `pengajuan_spj` (
  `id_pengajuan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `snack` varchar(200) NOT NULL,
  `makan` varchar(200) NOT NULL,
  `harga_snack` varchar(100) DEFAULT NULL,
  `harga_makan` varchar(100) DEFAULT NULL,
  `penyedia_snack` varchar(100) DEFAULT NULL,
  `penyedia_makan` varchar(100) DEFAULT NULL,
  `nama_rapat` varchar(200) NOT NULL,
  `tanggal_rapat` date NOT NULL,
  `status` enum('Pending','Verifikasi','Tolak','Terima','Selesai','Tolak1') NOT NULL,
  `tgl_snack` date NOT NULL,
  `tgl_makan` date NOT NULL,
  `total` varchar(20) NOT NULL,
  `total_fix` varchar(100) DEFAULT NULL,
  `file_kwutansi` varchar(100) DEFAULT NULL,
  `file_kwd` varchar(255) NOT NULL,
  `file_notulen` varchar(255) NOT NULL,
  `file_absen` varchar(255) NOT NULL,
  `file_undangan` varchar(255) NOT NULL,
  `file_nota` varchar(255) NOT NULL,
  `baca_pptk` varchar(2) NOT NULL,
  `baca_subbag` varchar(2) NOT NULL,
  `alasan` text NOT NULL,
  `tgl_expired` datetime NOT NULL,
  `tgl_tolak_pptk` datetime NOT NULL,
  `tgl_tolak_subbag` datetime NOT NULL,
  `tgl_verif` datetime NOT NULL,
  `tgl_form` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_selesai` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(3, 1, 0, 1, 'Gahahaha', '2018-11-15 12:10:51', '2018-11-15 13:21:30'),
(4, 1, 0, 0, 'sasa', '2018-11-18 21:38:44', '2018-11-18 21:46:16'),
(5, 1, 0, 0, 'ada', '2018-11-18 21:44:26', '2018-11-18 21:44:49'),
(6, 1, 0, 0, 'asasasas', '2018-11-18 21:46:30', '2018-11-18 21:53:22'),
(7, 1, 0, 0, 'asasasasa', '2018-11-18 21:53:41', '2018-11-18 21:53:41'),
(8, 1, 0, 0, 'asasasasa', '2018-11-18 23:40:14', '2018-11-18 23:52:17');

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
(3, 1, 2, 1, 'asasasa', '2018-11-13 09:39:19', '2018-11-15 19:26:00'),
(4, 1, 2, 0, 'asasasa', '2018-11-21 10:38:01', '2018-11-16 10:38:01'),
(5, 4, 2, 0, 'adadada', '2017-12-19 11:58:07', '2018-11-16 11:58:07'),
(6, 1, 2, 0, 'asdasdasd', '2018-11-16 13:50:10', '2018-11-16 13:50:10');

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
  `id_user` int(11) NOT NULL,
  `image_path` varchar(225) DEFAULT NULL,
  `file_path` varchar(225) NOT NULL,
  `original_name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_grup_images`
--

INSERT INTO `post_grup_images` (`id`, `post_grup_id`, `id_user`, `image_path`, `file_path`, `original_name`) VALUES
(1, 12, 9, '5c848121273e7296ea703d41c7cfeeba.JPG,858892310c3aa2db78fd5b20eee80006.JPG,4e0b5faf30fd378dbba15ed74e86d5be.JPG', '', '1.JPG,2.JPG,8.JPG'),
(2, 13, 4, '67fd9cc270d4323e159b38f590d1ac9c.JPG,bece90acdbfe81feaf5a829eb275da4b.PNG', '', 'Capture.JPG,Capture.PNG'),
(3, 1, 1, '5cb1091fb19a4e02380ba3a39e38fbe6.jpeg', '', 'Halaman57.jpeg,'),
(5, 3, 1, '[object HTMLInputElement]', '0', '');

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

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE `post_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_images`
--

INSERT INTO `post_images` (`id`, `post_id`, `image_path`, `file_path`, `original_name`) VALUES
(1, 8, 'b5bbf1d6cc65371c5b8efd8b75ba43b8.jpg', '', '');

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
-- Table structure for table `post_news`
--

CREATE TABLE `post_news` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cover` varchar(250) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `seen` varchar(250) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_news`
--

INSERT INTO `post_news` (`id`, `user_id`, `cover`, `judul`, `isi`, `seen`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, '7f46f0cd368dd2faf175986a06b747af.jpg', 'asdasdasdas', '<p>asdasdas</p>', '0', '2018-10-08 06:38:06', '2018-10-07 23:38:06', '2018-10-07 23:38:06'),
(2, 1, '', 'asasa', '<p>asasasasa</p>', '0', '2018-11-15 20:12:26', '2018-11-15 20:12:26', '2018-11-15 13:12:26'),
(4, 1, '', 'PENGUMUMAN HASIL UJI KOMPETENSI PENGADAAN LANGSUNG JASA LAINNYA UNTUK PERORANGAN KEGIATAN PEMBUATAN PETA TEMATIK (Jasa CAD/CAM Operator)', '<p>Hahahah imana ?</p>', '0', '2018-11-15 20:10:51', '2018-11-15 20:10:51', '2018-11-15 13:10:51'),
(11, 1, '', 'asasaasasasasasadadasd', '<p>asasasa</p>', '0', '2018-11-16 08:38:32', '2018-11-16 01:38:32', '2018-11-16 01:38:32');

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
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `id_saldo` int(1) NOT NULL,
  `saldo` varchar(15) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id_saldo`, `saldo`, `nama`, `updated_at`) VALUES
(1, '249191000', 'snack', '2019-04-19'),
(2, '249191000', 'makan', '2019-04-19'),
(3, '498382000', 'total', '2019-04-19');

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
  `role` enum('member','admin','pptk','subbag') COLLATE utf8mb4_unicode_ci NOT NULL,
  `groups` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `private`, `birthday`, `sex`, `phone`, `bio`, `profile_path`, `username`, `role`, `groups`, `cover_path`) VALUES
(1, 'Fahmi Fauzi', 'fauzifahmi55@gmail.com', '$2y$10$smFbadRM4NEmo2mCZ2IpSO4QW1K17l7vC9ShrlI/gGO5sCzcOhJNe', 'fXp1MF9QXS0joyKzKxnIarLYYkaA0g5fyUtNYhrn0VkIJPpwNYxrsysooqjv', '2018-09-16 21:03:30', '2018-09-16 21:03:30', 0, NULL, 0, NULL, NULL, NULL, 'admin', 'subbag', '', NULL),
(2, 'Fahmi Fauzi1', 'fauzifahmi551@gmail.com', '$2y$10$INurBkW6Km/Ge7kcTnfJbuj4bvMZF44R2P6WblYWME2g1wIRzKd8q', 'lEeRZ0WRSzEae7124EfnAiPtgA8fJy5nCMJNIZKjVz4oCBSqXacaRottK1IK', '2018-09-09 23:42:48', '2018-10-01 00:14:09', 0, NULL, 0, NULL, NULL, 'ea8c97a609d6f3ca02bc783b87e01bee.jpeg', 'admin121', 'member', '', NULL),
(4, 'Fahmi Fauzi', 'fauzifahmi98@gmail.com', '$2y$10$GoY4/KHOOSritkm2v9opSuRhEpjt/Fhm129qZkJCE39JTcOi.oLs.', 'TVdqJCGycJwzJWJIfJnCYAAJQWM07CNbY0aM1JmHSFoPir1vYfZutJqeeTFe', '2018-11-11 20:35:40', '2019-03-03 12:16:59', 0, NULL, 0, NULL, NULL, NULL, 'admin36', 'admin', '', NULL);

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
(1, 2, 1, 1),
(2, 1, 2, 1),
(3, 2, 4, 1),
(4, 4, 1, 1),
(5, 1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `id_user` varchar(9) NOT NULL,
  `id_groups` varchar(9) NOT NULL,
  `jabatan_grup` enum('member','moderator','admin') NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `allow` tinyint(1) NOT NULL,
  `tanggal_gabung` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `id_user`, `id_groups`, `jabatan_grup`, `seen`, `allow`, `tanggal_gabung`) VALUES
(1, '4', '2', 'member', 1, 1, '2018-11-15 03:37:33'),
(3, '1', '2', 'admin', 1, 1, '2018-10-06 05:40:25'),
(5, '3', '1', 'member', 1, 1, '2018-10-06 05:40:25'),
(8, '2', '1', 'member', 1, 1, '2018-10-06 07:24:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_hobbies`
--

CREATE TABLE `user_hobbies` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `hobby_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `ceks_notif_grup`
--
ALTER TABLE `ceks_notif_grup`
  ADD PRIMARY KEY (`id_ceks`);

--
-- Indexes for table `ceks_notif_news`
--
ALTER TABLE `ceks_notif_news`
  ADD PRIMARY KEY (`id_cek`);

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
-- Indexes for table `file_upload`
--
ALTER TABLE `file_upload`
  ADD PRIMARY KEY (`id_upload`);

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
-- Indexes for table `history_spj`
--
ALTER TABLE `history_spj`
  ADD PRIMARY KEY (`id_history`);

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
-- Indexes for table `news_comment`
--
ALTER TABLE `news_comment`
  ADD PRIMARY KEY (`id_comment`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`);

--
-- Indexes for table `notif_grup`
--
ALTER TABLE `notif_grup`
  ADD PRIMARY KEY (`id_notif`);

--
-- Indexes for table `notif_news`
--
ALTER TABLE `notif_news`
  ADD PRIMARY KEY (`id_notif_news`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pengajuan_spj`
--
ALTER TABLE `pengajuan_spj`
  ADD PRIMARY KEY (`id_pengajuan`);

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
-- Indexes for table `post_news`
--
ALTER TABLE `post_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id_saldo`),
  ADD KEY `saldo` (`id_saldo`);

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
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `ceks_notif_grup`
--
ALTER TABLE `ceks_notif_grup`
  MODIFY `id_ceks` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ceks_notif_news`
--
ALTER TABLE `ceks_notif_news`
  MODIFY `id_cek` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id_events` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `event_coment`
--
ALTER TABLE `event_coment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `file_upload`
--
ALTER TABLE `file_upload`
  MODIFY `id_upload` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id_grup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `grup_post_comments`
--
ALTER TABLE `grup_post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `history_spj`
--
ALTER TABLE `history_spj`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `news_comment`
--
ALTER TABLE `news_comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notif_grup`
--
ALTER TABLE `notif_grup`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notif_news`
--
ALTER TABLE `notif_news`
  MODIFY `id_notif_news` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `pengajuan_spj`
--
ALTER TABLE `pengajuan_spj`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `posts_grup`
--
ALTER TABLE `posts_grup`
  MODIFY `id_post_grup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `post_grup_images`
--
ALTER TABLE `post_grup_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `post_news`
--
ALTER TABLE `post_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_direct_messages`
--
ALTER TABLE `user_direct_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_following`
--
ALTER TABLE `user_following`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
