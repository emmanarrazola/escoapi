-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 26, 2021 at 02:48 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `escoapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_methods`
--

DROP TABLE IF EXISTS `api_methods`;
CREATE TABLE IF NOT EXISTS `api_methods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `method` varchar(255) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1005 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api_methods`
--

INSERT INTO `api_methods` (`id`, `description`, `method`, `isactive`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1000, 'Not Applicable', NULL, 1, 0, '2021-09-24 07:49:40', NULL, NULL),
(1001, 'Get', 'get', 1, 0, '2021-09-24 07:49:48', '2021-09-24 07:50:26', NULL),
(1002, 'Post', 'post', 1, 0, '2021-09-24 07:50:11', '2021-09-24 07:50:28', NULL),
(1003, 'Put', 'put', 1, 0, '2021-09-24 07:50:11', '2021-09-24 07:50:30', NULL),
(1004, 'Destroy', 'destroy', 1, 0, '2021-09-24 07:50:20', '2021-09-24 07:50:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `controllers` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `module_display_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1000',
  `sorter` int(9) NOT NULL DEFAULT '0',
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_display_id` (`module_display_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1006 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `description`, `controllers`, `route`, `icon`, `module_display_id`, `sorter`, `isactive`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1000, 'Not Applicable', NULL, NULL, NULL, 1000, 0, 1, 0, '2021-09-20 09:19:34', NULL, NULL),
(1001, 'Zoho Connectivity', 'zohoapi', 'zohoapi.index', 'fas fa-plug', 1001, 2, 1, 0, '2021-09-21 01:36:39', '2021-09-24 07:15:08', NULL),
(1002, 'Masterfiles', 'zohoapi', 'zohoapi.index', 'far fa-folder', 1001, 3, 1, 0, '2021-09-21 01:47:36', '2021-09-24 06:50:31', NULL),
(1003, 'System Setup', 'zohoapi', 'zohoapi.index', 'fas fa-cogs', 1001, 4, 1, 0, '2021-09-21 04:51:42', '2021-09-24 06:50:31', NULL),
(1004, 'Reports', 'zohoapi', 'zohoapi.index', 'fas fa-print', 1001, 5, 1, 0, '2021-09-22 04:43:07', '2021-09-24 08:21:49', NULL),
(1005, 'Zoho Modules', 'zohoapi', 'zohoapi.index', 'fas fa-cloud', 1001, 1, 1, 0, '2021-09-21 01:36:39', '2021-09-24 06:53:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_display`
--

DROP TABLE IF EXISTS `module_display`;
CREATE TABLE IF NOT EXISTS `module_display` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1003 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_display`
--

INSERT INTO `module_display` (`id`, `description`, `isactive`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1000, 'Not Applicable', 1, 0, '2021-09-21 01:34:17', '2021-09-21 01:35:19', NULL),
(1001, 'Sidebar Navigation', 1, 0, '2021-09-21 01:36:14', '2021-09-24 02:07:03', NULL),
(1002, 'Header Navigation', 1, 0, '2021-09-22 04:42:26', '2021-09-24 02:56:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scopes`
--

DROP TABLE IF EXISTS `scopes`;
CREATE TABLE IF NOT EXISTS `scopes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `zoho_scope` varchar(255) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1002 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scopes`
--

INSERT INTO `scopes` (`id`, `description`, `zoho_scope`, `isactive`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1000, 'Not Applicable', NULL, 1, 0, '2021-09-24 04:52:32', '2021-09-23 22:45:51', NULL),
(1001, 'Get All Tickets', 'Desk.tickets.ALL', 1, 0, '2021-09-23 22:45:15', '2021-09-23 22:47:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_modules`
--

DROP TABLE IF EXISTS `sub_modules`;
CREATE TABLE IF NOT EXISTS `sub_modules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `controllers` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1000',
  `sorter` int(9) NOT NULL DEFAULT '0',
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_display_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1010 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_modules`
--

INSERT INTO `sub_modules` (`id`, `description`, `controllers`, `route`, `module_id`, `sorter`, `isactive`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1000, 'Not Applicable', NULL, NULL, 1000, 0, 1, 0, '2021-09-24 03:00:32', NULL, NULL),
(1001, 'Desk Department', 'desk_departments', 'desk_departments.index', 1002, 1, 1, 0, '2021-09-24 03:00:32', '2021-09-24 07:38:01', NULL),
(1002, 'Desk Agents', 'zohoapi', 'zohoapi.index', 1002, 2, 1, 0, '2021-09-24 03:00:32', '2021-09-24 04:42:17', NULL),
(1003, 'General Setup', 'zohoapi', 'zohoapi.index', 1003, 1, 1, 0, '2021-09-24 03:00:32', '2021-09-24 04:42:22', NULL),
(1004, 'Users', 'zohoapi', 'zohoapi.index', 1003, 3, 1, 0, '2021-09-24 03:00:32', '2021-09-24 04:42:26', NULL),
(1005, 'Groups', 'zohoapi', 'zohoapi.index', 1003, 4, 1, 0, '2021-09-24 03:00:32', '2021-09-24 04:42:29', NULL),
(1006, 'Scopes', 'zohoapi', 'scopes.index', 1003, 2, 1, 0, '2021-09-24 03:00:32', '2021-09-24 05:10:36', NULL),
(1007, 'Tickets', 'zohoapi', 'zohoapi.index', 1005, 2, 1, 0, '2021-09-24 03:00:32', '2021-09-24 05:10:36', NULL),
(1008, 'API', 'zohoapi', 'zohoapi.index', 1001, 1, 1, 0, '2021-09-24 03:00:32', '2021-09-24 08:22:29', NULL),
(1009, 'Parameters', 'parameters', 'parameters.index', 1001, 2, 1, 0, '2021-09-24 03:00:32', '2021-09-24 08:22:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `systemsetup`
--

DROP TABLE IF EXISTS `systemsetup`;
CREATE TABLE IF NOT EXISTS `systemsetup` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `appname` varchar(255) NOT NULL,
  `redirect_uri` varchar(255) DEFAULT NULL,
  `client_id` varchar(255) DEFAULT NULL,
  `client_pass` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1002 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `systemsetup`
--

INSERT INTO `systemsetup` (`id`, `appname`, `redirect_uri`, `client_id`, `client_pass`) VALUES
(1001, 'Attendance System', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1003 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `remember_token`, `isactive`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1001, 'Emmanuel', 'Arrazola', 'emmanarrazola@gmail.com', NULL, '$2y$10$azTl5yS0RBw8aqXjTO4cxuTlZ0P5oboZAesg/uB0zM0V3vJJXMEtq', NULL, 1, 0, '2021-09-19 19:52:04', '2021-09-20 22:27:53', NULL),
(1002, 'Albert', 'Einstein', 'alberteinstein@gmail.com', NULL, '$2y$10$IF7XCywKmaVr6Dl7WRFdx./d0wlBJhxquTzgAHFeHGcp/fx93YVLW', NULL, 1, 0, '2021-09-20 22:37:42', '2021-09-20 22:37:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_modules`
--

DROP TABLE IF EXISTS `user_modules`;
CREATE TABLE IF NOT EXISTS `user_modules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `selected` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`),
  KEY `user_modules_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1015 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_modules`
--

INSERT INTO `user_modules` (`id`, `user_id`, `module_id`, `selected`, `created_at`, `updated_at`) VALUES
(1001, 1001, 1002, 1, '2021-09-21 02:30:41', '2021-09-21 02:30:48'),
(1002, 1001, 1001, 1, '2021-09-21 02:30:41', '2021-09-21 02:30:50'),
(1004, 1001, 1003, 1, '2021-09-21 04:52:30', '2021-09-24 04:25:12'),
(1005, 1002, 1001, 1, '2021-09-24 03:42:02', NULL),
(1006, 1002, 1002, 1, '2021-09-24 03:42:02', NULL),
(1007, 1002, 1003, 1, '2021-09-24 03:42:02', NULL),
(1008, 1002, 1004, 1, '2021-09-24 03:42:02', NULL),
(1009, 1001, 1004, 1, '2021-09-24 03:42:02', NULL),
(1012, 1002, 1005, 1, '2021-09-24 06:54:37', NULL),
(1013, 1001, 1005, 1, '2021-09-24 06:54:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_modules`
--

DROP TABLE IF EXISTS `user_sub_modules`;
CREATE TABLE IF NOT EXISTS `user_sub_modules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sub_module_id` bigint(20) UNSIGNED NOT NULL,
  `selected` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `module_id` (`sub_module_id`),
  KEY `user_modules_ibfk_1` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1029 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_modules`
--

INSERT INTO `user_sub_modules` (`id`, `user_id`, `sub_module_id`, `selected`, `created_at`, `updated_at`) VALUES
(1001, 1002, 1001, 1, '2021-09-24 03:54:19', NULL),
(1002, 1001, 1001, 1, '2021-09-24 03:54:19', NULL),
(1003, 1002, 1002, 1, '2021-09-24 03:54:19', NULL),
(1004, 1001, 1002, 1, '2021-09-24 03:54:19', NULL),
(1005, 1002, 1003, 1, '2021-09-24 03:54:19', NULL),
(1006, 1001, 1003, 1, '2021-09-24 03:54:19', NULL),
(1007, 1002, 1004, 1, '2021-09-24 03:54:19', NULL),
(1008, 1001, 1004, 1, '2021-09-24 03:54:19', NULL),
(1009, 1002, 1005, 1, '2021-09-24 03:54:19', NULL),
(1010, 1001, 1005, 1, '2021-09-24 03:54:19', NULL),
(1016, 1002, 1006, 1, '2021-09-24 04:43:04', NULL),
(1017, 1001, 1006, 1, '2021-09-24 04:43:04', NULL),
(1019, 1002, 1007, 1, '2021-09-24 06:54:41', NULL),
(1020, 1001, 1007, 1, '2021-09-24 06:54:41', NULL),
(1022, 1002, 1008, 1, '2021-09-24 08:20:51', NULL),
(1023, 1001, 1008, 1, '2021-09-24 08:20:51', NULL),
(1024, 1002, 1009, 1, '2021-09-24 08:20:51', NULL),
(1025, 1001, 1009, 1, '2021-09-24 08:20:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zoho_api`
--

DROP TABLE IF EXISTS `zoho_api`;
CREATE TABLE IF NOT EXISTS `zoho_api` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isrequest` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1003 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zoho_api`
--

INSERT INTO `zoho_api` (`id`, `description`, `url`, `isactive`, `isrequest`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1000, 'Not Applicable', NULL, 1, 0, 0, '2021-09-24 07:03:07', '2021-09-24 08:47:54', NULL),
(1001, 'Zoho Auth', 'https://accounts.zoho.com/oauth/v2/auth', 1, 0, 0, '2021-09-24 08:16:15', '2021-09-24 19:18:16', NULL),
(1002, 'Get Departments', 'https://desk.zoho.com/api/v1/departments', 1, 1, 0, '2021-09-23 23:21:53', '2021-09-24 19:19:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zoho_api_params`
--

DROP TABLE IF EXISTS `zoho_api_params`;
CREATE TABLE IF NOT EXISTS `zoho_api_params` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `zoho_api_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1000',
  `params_type_id` bigint(20) UNSIGNED NOT NULL DEFAULT '1000',
  `params_key` varchar(255) DEFAULT NULL,
  `params_value` varchar(255) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zoho_api` (`zoho_api_id`),
  KEY `params_type_id` (`params_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1009 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zoho_api_params`
--

INSERT INTO `zoho_api_params` (`id`, `zoho_api_id`, `params_type_id`, `params_key`, `params_value`, `isactive`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1001, 1002, 1002, 'OrgId', '680708905', 1, 0, '2021-09-24 08:11:50', '2021-09-24 01:34:58', NULL),
(1002, 1002, 1002, 'Authorization', 'Zoho-oauthtoken @token', 1, 0, '2021-09-24 08:11:50', '2021-09-24 01:34:47', NULL),
(1003, 1001, 1002, 'response_type', 'code', 1, 0, '2021-09-24 01:48:22', '2021-09-24 01:48:22', NULL),
(1004, 1001, 1002, 'access_type', 'offline', 1, 0, '2021-09-24 01:49:02', '2021-09-24 01:49:02', NULL),
(1005, 1001, 1002, 'prompt', 'consent', 1, 0, '2021-09-24 01:49:28', '2021-09-24 01:49:28', NULL),
(1006, 1001, 1002, 'client_id', '@client_id', 1, 0, '2021-09-24 01:53:49', '2021-09-24 01:53:49', NULL),
(1007, 1001, 1002, 'scope', '@scopes', 1, 0, '2021-09-24 01:55:27', '2021-09-24 01:55:27', NULL),
(1008, 1001, 1002, 'redirect_uri', 'http://localhost:8080/escoapi/desk_departments/', 1, 0, '2021-09-24 01:56:19', '2021-09-24 01:56:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zoho_api_params_type`
--

DROP TABLE IF EXISTS `zoho_api_params_type`;
CREATE TABLE IF NOT EXISTS `zoho_api_params_type` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1005 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zoho_api_params_type`
--

INSERT INTO `zoho_api_params_type` (`id`, `description`, `isactive`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1001, 'Not Applicable', 1, 0, '2021-09-24 08:04:15', NULL, NULL),
(1002, 'Header', 1, 0, '2021-09-24 08:04:27', NULL, NULL),
(1003, 'Body', 1, 0, '2021-09-24 08:04:27', NULL, NULL),
(1004, 'Query Params', 1, 0, '2021-09-24 09:42:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zoho_api_type`
--

DROP TABLE IF EXISTS `zoho_api_type`;
CREATE TABLE IF NOT EXISTS `zoho_api_type` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1003 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zoho_api_type`
--

INSERT INTO `zoho_api_type` (`id`, `description`, `isactive`, `isdelete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1000, 'Not Applicable', 1, 0, '2021-09-24 08:15:26', NULL, NULL),
(1001, 'Authentication', 1, 0, '2021-09-24 08:15:33', NULL, NULL),
(1002, 'Standard', 1, 0, '2021-09-24 08:15:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zoho_desk_dept`
--

DROP TABLE IF EXISTS `zoho_desk_dept`;
CREATE TABLE IF NOT EXISTS `zoho_desk_dept` (
  `id` int(18) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `chatStatus` varchar(255) DEFAULT NULL,
  `nameInCustomerPortal` varchar(255) DEFAULT NULL,
  `creatorId` bigint(18) DEFAULT '1000',
  `hasLogo` tinyint(1) NOT NULL DEFAULT '0',
  `isEnabled` tinyint(1) NOT NULL DEFAULT '1',
  `sanitizedName` varchar(255) DEFAULT NULL,
  `isVisibleinCustomerPortal` tinyint(1) DEFAULT '0',
  `isDefault` tinyint(1) NOT NULL DEFAULT '0',
  `isAssignToTeamEnabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zoho_desk_dept`
--

INSERT INTO `zoho_desk_dept` (`id`, `name`, `description`, `chatStatus`, `nameInCustomerPortal`, `creatorId`, `hasLogo`, `isEnabled`, `sanitizedName`, `isVisibleinCustomerPortal`, `isDefault`, `isAssignToTeamEnabled`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1000, 'Not Applicable', 'Not Applicable', NULL, NULL, 1000, 0, 1, NULL, 0, 0, 0, '2021-09-24 07:56:48', '2021-09-24 07:57:16', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`module_display_id`) REFERENCES `module_display` (`id`);

--
-- Constraints for table `sub_modules`
--
ALTER TABLE `sub_modules`
  ADD CONSTRAINT `sub_modules_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`);

--
-- Constraints for table `user_modules`
--
ALTER TABLE `user_modules`
  ADD CONSTRAINT `user_modules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_modules_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`);

--
-- Constraints for table `user_sub_modules`
--
ALTER TABLE `user_sub_modules`
  ADD CONSTRAINT `user_sub_modules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_sub_modules_ibfk_2` FOREIGN KEY (`sub_module_id`) REFERENCES `sub_modules` (`id`);

--
-- Constraints for table `zoho_api_params`
--
ALTER TABLE `zoho_api_params`
  ADD CONSTRAINT `zoho_api_params_ibfk_1` FOREIGN KEY (`zoho_api_id`) REFERENCES `zoho_api` (`id`),
  ADD CONSTRAINT `zoho_api_params_ibfk_2` FOREIGN KEY (`params_type_id`) REFERENCES `zoho_api_params_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
