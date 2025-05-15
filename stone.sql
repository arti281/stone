-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 07:02 PM
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
-- Database: `stone`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact` bigint(20) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `admin_group_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `image`, `ip`, `status`, `admin_group_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$Q6fxG6K5Lr1QTxMzJOucC.dm7Ma1nrS2NRdIOm6JdJpaOGpPQ/R1S', 'admin', 'admin', 'admin@gmail.com', NULL, NULL, 1, 0, '2025-05-01 10:52:50', '2025-05-01 10:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `description`, `button_url`, `button_text`, `sort`, `status`) VALUES
(1, '', '1.jpg', '', '', '', 0, 1),
(2, '', '5.jpg', '', '', '', 1, 1),
(3, '', '4.jpg', '', '', '', 2, 1),
(4, '', '2.jpg', '', '', '', 3, 1),
(5, '', '3.jpg', '', '', '', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `color_id`, `size_id`, `quantity`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 1, NULL, NULL, 1, 1, '2025-05-15 11:15:58', '2025-05-15 11:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `meta_tag` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `menu_top` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `slug`, `parent_id`, `image`, `description`, `meta_tag`, `sort_order`, `level`, `menu_top`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Religious Statues', 'religious-statues', NULL, '1746367166_47b34583-e18a-48f0-bb11-cff53789bafa.jpg', '', '', 0, 0, 1, 1, '2025-05-02 11:37:30', '2025-05-04 08:29:27'),
(3, 'Decorative & Garden', 'decorative-garden', NULL, '1746367644_7da6e15d-8c5a-4ea4-9050-f8dbfc0c7a34.jpg', '', '', 0, 0, 1, 1, '2025-05-02 11:38:31', '2025-05-04 08:37:24'),
(4, 'Cosmetics', 'cosmetics', NULL, '1746296555_59d9ba68-c8aa-484b-9eaf-08ccc760e293.jpg', '', '', 0, 0, 1, 1, '2025-05-02 11:39:08', '2025-05-03 13:53:28'),
(5, 'Custom & Portrait', 'custom-portrait', NULL, '1746368114_6611d959-bfec-4e69-9639-20bc41d5b331.jpg', '', '', 0, 0, 1, 1, '2025-05-02 11:39:44', '2025-05-04 08:45:15'),
(7, 'Architectural Stone Carvings', 'architectural-stone-carvings', NULL, '1746369089_08391b4d-ca43-448a-80aa-288aa8228358.jpg', '', '', 0, 0, 1, 1, '2025-05-02 12:02:21', '2025-05-04 09:01:29'),
(8, 'Radha Krishan', 'radha-krishan', 2, NULL, '', '', 0, 0, 0, 1, '2025-05-03 09:09:32', '2025-05-03 09:18:36'),
(9, 'Hanumanji', 'hanumanji', 2, NULL, '', '', 0, 0, 0, 1, '2025-05-03 09:17:05', '2025-05-03 09:17:05'),
(10, 'Ganesha', 'ganesha', 2, NULL, '', '', 0, 0, 0, 1, '2025-05-03 09:33:12', '2025-05-03 09:33:12'),
(11, 'Temple Statues', 'temple-statues', 7, NULL, '', '', 0, 0, 0, 1, '2025-05-03 09:34:50', '2025-05-03 09:34:50'),
(12, 'Pillars & Reliefs', 'pillars-reliefs', 7, NULL, '', '', 0, 0, 0, 1, '2025-05-03 09:35:46', '2025-05-03 09:35:46'),
(13, 'Wall Panels & Murals', 'wall-panels-murals', 7, NULL, '', '', 0, 0, 0, 1, '2025-05-03 09:38:08', '2025-05-03 09:38:08'),
(14, 'Bust Statues (Head & Shoulder)', 'bust-statues-head-shoulder', 5, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:03:28', '2025-05-03 10:03:28'),
(15, 'Full-body Portraits', 'full-body-portraits', 5, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:04:38', '2025-05-03 10:04:38'),
(16, 'Memorial Statues', 'memorial-statues', 5, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:05:22', '2025-05-03 10:05:22'),
(17, 'Celebrity or Leader Statues', 'celebrity-or-leader-statues', 5, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:05:59', '2025-05-03 10:05:59'),
(18, 'Face', 'face', 4, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:10:35', '2025-05-03 10:10:35'),
(19, 'Eyes', 'eyes', 4, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:11:10', '2025-05-03 10:11:32'),
(20, 'Lips', 'lips', 4, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:12:21', '2025-05-03 10:12:21'),
(21, 'Nails', 'nails', 4, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:13:04', '2025-05-03 10:13:24'),
(22, 'Skin Care (often overlaps with cosmetics)', 'skin-care-often-overlaps-with-cosmetics', 4, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:14:22', '2025-05-03 10:14:22'),
(23, 'Hair Cosmetics', 'hair-cosmetics', 4, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:15:21', '2025-05-03 10:15:21'),
(24, 'Fragrance', 'fragrance', 4, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:16:42', '2025-05-03 10:16:42'),
(25, 'Foundation', 'foundation', 18, NULL, '', '', 0, 0, 0, 1, '2025-05-03 10:18:16', '2025-05-03 10:18:16'),
(26, 'Shiva', 'shiva', 2, NULL, '', '', 0, 0, 0, 1, '2025-05-03 11:06:58', '2025-05-03 11:06:58'),
(27, 'Vishnu & Lakshmi ji', 'vishnu-lakshmi-ji', 2, NULL, '', '', 0, 0, 0, 1, '2025-05-03 11:07:52', '2025-05-03 11:07:52'),
(28, 'Durgaji', 'durgaji', 2, NULL, '', '', 0, 0, 0, 1, '2025-05-03 11:09:06', '2025-05-03 11:09:06'),
(29, 'Saraswati', 'saraswati', 2, NULL, '', '', 0, 0, 0, 1, '2025-05-03 11:09:39', '2025-05-03 11:09:39'),
(30, 'Garden Buddha / Zen Statues', 'garden-buddha-zen-statues', 3, NULL, '', '', 0, 0, 0, 1, '2025-05-03 11:11:48', '2025-05-03 11:11:48'),
(31, 'Animal Figures (Elephants, Lions, Turtles, Swans)', 'animal-figures-elephants-lions-turtles-swans', 3, NULL, '', '', 0, 0, 0, 1, '2025-05-03 11:12:17', '2025-05-03 11:12:17'),
(32, 'Water Fountain Statues', 'water-fountain-statues', 3, NULL, '', '', 0, 0, 0, 1, '2025-05-03 11:12:45', '2025-05-03 11:12:45'),
(33, 'Abstract Human Forms', 'abstract-human-forms', 3, NULL, '', '', 0, 0, 0, 1, '2025-05-03 11:13:36', '2025-05-03 11:13:36'),
(34, 'Cosmetics', 'cosmetics', 1, '1746299388_6ecb63e8-ca54-4ac7-b9e7-fcf0ba6143f5.jpg', '', '', 0, 0, 0, 1, '2025-05-03 13:39:48', '2025-05-03 13:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `category_path`
--

CREATE TABLE `category_path` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `path_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_path`
--

INSERT INTO `category_path` (`id`, `category_id`, `path_id`, `level`) VALUES
(1, 1, 1, 0),
(2, 6, 6, 0),
(3, 8, 2, 0),
(4, 9, 2, 0),
(5, 10, 2, 0),
(6, 11, 7, 0),
(7, 12, 7, 0),
(8, 13, 7, 0),
(9, 14, 5, 0),
(10, 15, 5, 0),
(11, 16, 5, 0),
(12, 17, 5, 0),
(13, 18, 4, 0),
(14, 19, 4, 0),
(15, 20, 4, 0),
(16, 21, 4, 0),
(17, 22, 4, 0),
(18, 23, 4, 0),
(19, 24, 4, 0),
(20, 25, 18, 0),
(21, 26, 2, 0),
(22, 27, 2, 0),
(23, 28, 2, 0),
(24, 29, 2, 0),
(25, 30, 3, 0),
(26, 31, 3, 0),
(27, 32, 3, 0),
(28, 33, 3, 0),
(29, 34, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `color_name` varchar(20) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` bigint(20) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `reference_name` varchar(50) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `countryCode` varchar(50) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `regionName` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `lon` varchar(50) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `isp` varchar(50) DEFAULT NULL,
  `org` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_04_20_164857_contact_us', 1),
(6, '2024_04_24_184224_admin', 1),
(7, '2024_04_28_183958_locations', 1),
(8, '2024_05_08_193739_banners', 1),
(9, '2024_05_18_192322_create_social_medias', 1),
(10, '2024_05_18_192334_create_settings', 1),
(11, '2024_06_19_163034_create_products', 1),
(12, '2024_06_19_170425_create_product_prices', 1),
(13, '2024_06_19_171935_create_product_categories', 1),
(14, '2024_06_19_174327_create_product_filters', 1),
(15, '2024_06_19_174404_create_product_specials', 1),
(16, '2024_06_19_184636_create_product_downloads', 1),
(17, '2024_06_19_185734_create_product_discounts', 1),
(18, '2024_06_21_193923_create_product_rewards', 1),
(19, '2024_06_21_194038_create_product_images', 1),
(20, '2024_06_21_194238_create_product_other_links', 1),
(21, '2024_08_03_191613_create_category', 1),
(22, '2024_08_19_182756_create_category_path', 1),
(23, '2024_09_02_192646_create_colors', 1),
(24, '2024_09_02_192702_create_size', 1),
(25, '2024_09_25_065254_create_product_variation', 1),
(26, '2024_11_27_172753_create_cart', 1),
(27, '2024_11_28_045155_create_stock_status', 1),
(28, '2024_12_15_231531_create_wishlists_table', 1),
(29, '2024_12_16_120811_create_addresses_table', 1),
(30, '2024_12_16_122830_create_countries_table', 1),
(31, '2024_12_16_122839_create_states_table', 1),
(32, '2025_01_03_224344_create_order_masters_table', 1),
(33, '2025_01_03_224447_create_orders_table', 1),
(34, '2025_01_05_003303_create_order_histories_table', 1),
(35, '2025_01_05_005112_create_order_statuses_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_master_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `size_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_histories`
--

CREATE TABLE `order_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_master_id` int(11) NOT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `notify` int(11) NOT NULL DEFAULT 0,
  `comment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_masters`
--

CREATE TABLE `order_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `total_mrp` double NOT NULL,
  `total_amount` double NOT NULL,
  `discount_on_mrp` double NOT NULL DEFAULT 0,
  `coupon_discount` double NOT NULL DEFAULT 0,
  `platform_fee` double NOT NULL DEFAULT 0,
  `shipping_fee` double NOT NULL DEFAULT 0,
  `cod_fee` int(11) NOT NULL DEFAULT 0,
  `prepaid_fee` int(11) NOT NULL DEFAULT 0,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `payment_request_id` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `invoice_no` int(11) NOT NULL DEFAULT 0,
  `invoice_prefix` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Pending', '2025-05-01 10:52:50', '2025-05-01 10:52:50'),
(2, 'Processing', '2025-05-01 10:52:50', '2025-05-01 10:52:50'),
(3, 'Shipped', '2025-05-01 10:52:50', '2025-05-01 10:52:50'),
(4, 'On the way', '2025-05-01 10:52:50', '2025-05-01 10:52:50'),
(5, 'Delivered', '2025-05-01 10:52:50', '2025-05-01 10:52:50'),
(6, 'Completed', '2025-05-01 10:52:50', '2025-05-01 10:52:50'),
(7, 'Canceled', '2025-05-01 10:52:50', '2025-05-01 10:52:50'),
(8, 'Refunded', '2025-05-01 10:52:50', '2025-05-01 10:52:50'),
(9, 'Order Booked', '2025-05-01 10:52:50', '2025-05-01 10:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `tag` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `minimum` int(11) DEFAULT NULL,
  `subtract` int(11) DEFAULT NULL,
  `stock_status_id` int(11) DEFAULT NULL,
  `date_available` timestamp NULL DEFAULT NULL,
  `shipping` tinyint(1) DEFAULT 0,
  `length` decimal(15,4) DEFAULT NULL,
  `width` decimal(15,4) DEFAULT NULL,
  `height` decimal(15,4) DEFAULT NULL,
  `length_class_id` int(11) DEFAULT NULL,
  `weight` decimal(15,4) DEFAULT NULL,
  `weight_class_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_description`, `tag`, `meta_title`, `meta_description`, `meta_keyword`, `model`, `quantity`, `minimum`, `subtract`, `stock_status_id`, `date_available`, `shipping`, `length`, `width`, `height`, `length_class_id`, `weight`, `weight_class_id`, `image`, `slug`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Radha Krishna Marble Statue For Home Temple (Makrana)', '<p align=\"justify\">Crafted from pristine Makrana marble, this lifelike Radha Krishna statue radiates divine love and serene beauty. The smooth finish and intricate color detailing elevate its charm, while the delicately sculpted peacock feather (mor pankh) adds a magical touch. The vibrant hues breathe life into the murti, making it a captivating blend of artistry and spirituality. Invite the sacred presence of Radha Krishna into your space with this exquisite symbol of devotion and grace.</p>', '', '', '\"Shop an exquisite Radha Krishna marble statue crafted from premium Makrana marble — perfect for your home temple. A symbol of divine love, grace, and devotion.\"', 'Radha Krishna marble statue, Radha Krishna idol for home, Makrana marble Radha Krishna murti, Radha Krishna statue for temple, Radha Krishna sculpture online, Radha Krishna murti for pooja room, Buy Radha Krishna idol, Radha Krishna idol with mor pankh', 'Pstone', 2, 0, 0, NULL, '2025-05-14 11:35:07', 1, 0.0000, 0.0000, 0.0000, 1, 0.0000, 1, '1746983352_8633c622-65be-465a-8baa-17190fca2c66.jpg', 'radha-krishna-marble-statue-for-home-temple-makrana', 1, 0, '2025-05-11 11:37:25', '2025-05-14 11:35:07'),
(2, 'Radha Krishna Marble Idol for Home Temple – Vietnam', '<p><b>PRODUCT DETAILS</b></p><p>Material: Vietnam Marble<br>Dimensions (Height &amp; Length &amp; Width): 36 x 18 x 10 inches<br>Weight: 270000 gms<br><br>This realistic statue of Radha and Kanha, crafted from pure Vietnam marble, The murti captures the divine beauty with its sleek details and smooth finish. Adorned with delicate craftsmanship, the mesmerizing gaze of Radha and Krishna emanates a hypnotic charm. This exquisite sculpture symbolizes eternal love and devotion and captures divine grace and spiritual bliss.</p>', '', '', 'Elegant Radha Krishna Marble Statue for Home Temple – Crafted in Vietnam, Hand-Carved Radha Krishna Marble Sculpture for Home Worship (Vietnam)', 'Handcrafted Radha Krishna marble statue Vietnam ,Spiritual home decor Radha Krishna, Devotional Radha Krishna marble sculpture, Traditional Indian marble deity statue, Hindu God Radha Krishna marble figure, White marble Radha Krishna pair idol', 'Pstone', 2, 0, 0, NULL, '2025-05-15 09:37:59', 1, 0.0000, 0.0000, 0.0000, 1, 0.0000, 1, '1747320756_9a2661f6-85f6-4f04-a57d-661edb8afec1.jpg', 'radha-krishna-marble-idol-for-home-temple-vietnam', 1, 0, '2025-05-15 09:18:25', '2025-05-15 09:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `product_id`, `category_id`) VALUES
(7, 1, 8),
(9, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `product_discounts`
--

CREATE TABLE `product_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `customer_group_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `price` decimal(15,4) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `close_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_downloads`
--

CREATE TABLE `product_downloads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_filters`
--

CREATE TABLE `product_filters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `sort`) VALUES
(1, 1, '1746983359_f59657ab-2fce-4ced-8e7d-eb5d105b18a7.jpg', NULL),
(2, 1, '1746983360_f13fd8c8-4f87-4c49-81a3-ef3cdd01397f.jpg', NULL),
(3, 2, '1747320764_253fb413-164e-4bab-950e-34495cbc49de.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_other_links`
--

CREATE TABLE `product_other_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `amazon` varchar(300) DEFAULT NULL,
  `flipkart` varchar(300) DEFAULT NULL,
  `myntra` varchar(300) DEFAULT NULL,
  `ajio` varchar(300) DEFAULT NULL,
  `meesho` varchar(300) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `mrp` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_prices`
--

INSERT INTO `product_prices` (`id`, `product_id`, `price`, `mrp`) VALUES
(1, 1, 90000.00, 70000.00),
(2, 2, 180000.00, 181200.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_rewards`
--

CREATE TABLE `product_rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_specials`
--

CREATE TABLE `product_specials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `customer_group_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `price` decimal(15,4) NOT NULL,
  `start_date` date DEFAULT NULL,
  `close_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variation`
--

CREATE TABLE `product_variation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `combination` varchar(20) NOT NULL,
  `price` decimal(15,4) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sku` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variation`
--

INSERT INTO `product_variation` (`id`, `product_id`, `color_id`, `size_id`, `combination`, `price`, `quantity`, `sku`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '1_2', 90000.0000, 1, '001', 1, '2025-05-14 11:34:29', '2025-05-14 11:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('21dQ3PkCjjC3TuwYe4krYTGbfk1CbTXa0YkojuOo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOU1NQUhFbFZBRncydEdETFFzR3JDT0FZckU3bU9WY2RSQzBKZzlYbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0LzIvcmFkaGEta3Jpc2huYS1tYXJibGUtaWRvbC1mb3ItaG9tZS10ZW1wbGUtdmlldG5hbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747323056),
('iSXVL9Zcar7jiJbCJVO6AvMXF0bxX748bS0ssz72', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZUNrWHdRYWl6bHJ6emhHcGVSWGh6N083cGR2RHl6WE5kbjVid2o3ciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0LzIvcmFkaGEta3Jpc2huYS1tYXJibGUtaWRvbC1mb3ItaG9tZS10ZW1wbGUtdmlldG5hbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747328154),
('LHtTg4ogMoDTK12uv9cW8pvUn4C4So5P74wK8QJA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibDZnRnMyVENkaGpZNnJHa2tSZnFUZHFnU2VVN09WdHgwMWJITjEzYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dC9jYXJ0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo4OiJhZG1pbl9pZCI7aToxO3M6NjoiaXNVc2VyIjtpOjE7czo5OiJ1c2VyX25hbWUiO3M6NToiQWFydGkiO30=', 1747328390),
('vUgdF3Rekw02PCPRCVIS2Aed2MAqsUS9uKOzobWF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:138.0) Gecko/20100101 Firefox/138.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibHN2NklocUEzblBJWEVlVkQxcDFxUDlGejVIVVpQeldZMUw1dHF0dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0LzEvcmFkaGEta3Jpc2huYS1tYXJibGUtc3RhdHVlLWZvci1ob21lLXRlbXBsZS1tYWtyYW5hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1747324154);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `code`, `key`, `value`) VALUES
(19, 'site', 'site_title', 'Best seller of All stone Statues'),
(20, 'site', 'site_description', NULL),
(21, 'site', 'desktop_logo', 'pstone.PNG'),
(22, 'site', 'mobile_logo', 'pstone.PNG'),
(33, 'ecommerce', 'ecommerce_other_url_status', 'on'),
(34, 'ecommerce', 'ecommerce_checkout_status', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size_name` varchar(20) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_medias`
--

CREATE TABLE `social_medias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_medias`
--

INSERT INTO `social_medias` (`id`, `instagram`, `facebook`, `youtube`, `status`) VALUES
(1, '@instagram', '@facebook', 'Youtube', 1);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_status`
--

CREATE TABLE `stock_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `number` bigint(20) DEFAULT NULL,
  `number_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_group_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `custom` text DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `number`, `number_verified_at`, `password`, `user_group_id`, `status`, `image`, `custom`, `google_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Aarti', 'artisharma824@gmail.com', NULL, 8130854742, NULL, '$2y$12$Qpm3SMcTkiq7yKOYiloc6edo0rrv6Cgj8sF.rumPDojL/AwUxYO.a', 0, 1, NULL, NULL, NULL, NULL, '2025-05-12 02:23:36', '2025-05-12 02:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `session_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, 2, 1, '2025-05-15 10:51:03', '2025-05-15 10:51:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_path`
--
ALTER TABLE `category_path`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_order_master_id_foreign` (`order_master_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`),
  ADD KEY `orders_color_id_foreign` (`color_id`),
  ADD KEY `orders_size_id_foreign` (`size_id`);

--
-- Indexes for table `order_histories`
--
ALTER TABLE `order_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_masters`
--
ALTER TABLE `order_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_discounts`
--
ALTER TABLE `product_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_downloads`
--
ALTER TABLE `product_downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_filters`
--
ALTER TABLE `product_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_other_links`
--
ALTER TABLE `product_other_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_rewards`
--
ALTER TABLE `product_rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_specials`
--
ALTER TABLE `product_specials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_medias`
--
ALTER TABLE `social_medias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `stock_status`
--
ALTER TABLE `stock_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `category_path`
--
ALTER TABLE `category_path`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_histories`
--
ALTER TABLE `order_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_masters`
--
ALTER TABLE `order_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_discounts`
--
ALTER TABLE `product_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_downloads`
--
ALTER TABLE `product_downloads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_filters`
--
ALTER TABLE `product_filters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_other_links`
--
ALTER TABLE `product_other_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_rewards`
--
ALTER TABLE `product_rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_specials`
--
ALTER TABLE `product_specials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variation`
--
ALTER TABLE `product_variation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `social_medias`
--
ALTER TABLE `social_medias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_status`
--
ALTER TABLE `stock_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_order_master_id_foreign` FOREIGN KEY (`order_master_id`) REFERENCES `order_masters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
