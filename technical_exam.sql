-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2024 at 04:43 AM
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
-- Database: `technical_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`id`, `name`, `title`, `content`, `action`, `created_at`, `updated_at`) VALUES
(1, 'Jessiesam', 'My 8th Blog Post', 'This is the content of my 8th blog post.', 'INSERT', '2024-08-02 02:19:03', '2024-08-02 02:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `user_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(2, 2, 'My Second Blog Post', 'This is the content of my second blog post.', '2024-08-01 07:42:09', '2024-08-01 07:42:09'),
(3, 2, 'My Third Blog Post', 'This is the content of my Third blog post.', '2024-08-01 07:54:40', '2024-08-01 07:54:40'),
(4, 2, 'My 4th Blog Post', 'This is the content of my 4th blog post.', '2024-08-01 07:57:54', '2024-08-01 07:57:54'),
(5, 2, 'My 5th Blog Post', 'This is the content of my 5th blog post.', '2024-08-01 16:50:29', '2024-08-01 16:50:29'),
(6, 2, 'My 6th Blog Post', 'This is the content of my 6th blog post.', '2024-08-01 17:29:47', '2024-08-01 17:29:47'),
(7, 2, 'My 6th Blog Post', 'This is the content of my 6th blog post.', '2024-08-01 17:31:06', '2024-08-01 17:31:06'),
(8, 2, 'My 6th Blog Post', 'This is the content of my 6th blog post.', '2024-08-01 17:35:17', '2024-08-01 17:35:17'),
(9, 2, 'My 6th Blog Post', 'This is the content of my 6th blog post.', '2024-08-01 17:36:01', '2024-08-01 17:36:01'),
(10, 2, 'My 6th Blog Post', 'This is the content of my 6th blog post.', '2024-08-01 17:40:29', '2024-08-01 17:40:29'),
(11, 2, 'My 6th Blog Post', 'This is the content of my 6th blog post.', '2024-08-01 17:41:43', '2024-08-01 17:41:43'),
(12, 2, 'My 7th Blog Post', 'This is the content of my 7th blog post.', '2024-08-01 17:43:55', '2024-08-01 17:43:55'),
(13, 2, 'My 8th Blog Post', 'This is the content of my 8th blog post.', '2024-08-01 18:19:03', '2024-08-01 18:19:03');

--
-- Triggers `blog_posts`
--
DELIMITER $$
CREATE TRIGGER `blog_post_delete` AFTER DELETE ON `blog_posts` FOR EACH ROW BEGIN
                INSERT INTO audit (name, title, content, action, created_at, updated_at)
                SELECT users.name, OLD.title, OLD.content, "DELETE", NOW(), NOW()
                FROM users
                WHERE users.id = OLD.user_id;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `blog_post_insert` AFTER INSERT ON `blog_posts` FOR EACH ROW BEGIN
                INSERT INTO audit (name, title, content, action, created_at, updated_at)
                SELECT users.name, NEW.title, NEW.content, "INSERT", NOW(), NOW()
                FROM users
                WHERE users.id = NEW.user_id;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `blog_post_update` AFTER UPDATE ON `blog_posts` FOR EACH ROW BEGIN
                INSERT INTO audit (name, title, content, action, created_at, updated_at)
                SELECT users.name, NEW.title, NEW.content, "UPDATE", NOW(), NOW()
                FROM users
                WHERE users.id = NEW.user_id;
            END
$$
DELIMITER ;

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
(4, '2024_08_01_123717_create_personal_access_tokens_table', 1),
(5, '2024_08_01_140622_create_blog_posts_table', 2),
(6, '2024_08_02_021246_create_audit_table', 3),
(7, '2024_08_02_021815_create_blog_post_trigger', 3);

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'auth_token', '62e1da1f412924e36f596bc734d0453e41f41ebfe5c8de966e8f766f2c734f8d', '[\"*\"]', NULL, NULL, '2024-08-01 05:19:55', '2024-08-01 05:19:55'),
(2, 'App\\Models\\User', 3, 'auth_token', '0eed0deaf927525e3b9d1bba63b3d2c2268db45c1059ccf2c70752c547157ac3', '[\"*\"]', NULL, NULL, '2024-08-01 05:21:42', '2024-08-01 05:21:42'),
(3, 'App\\Models\\User', 2, 'auth_token', '22ea2fced12212ea6a2c14e2038b5d1112812022a398b69aadaf45e708f9c120', '[\"*\"]', NULL, NULL, '2024-08-01 05:29:48', '2024-08-01 05:29:48'),
(4, 'App\\Models\\User', 4, 'auth_token', 'eff6d63dc10601067faad67c982ff52a6731b25c9ce73d75135fd7ed9797f90f', '[\"*\"]', NULL, NULL, '2024-08-01 05:42:37', '2024-08-01 05:42:37'),
(5, 'App\\Models\\User', 5, 'auth_token', 'eab6f9a1457d8f9a8bbbe2f088d06a7fd74bb0dd3c5f1143972cbd2e022be492', '[\"*\"]', NULL, NULL, '2024-08-01 07:01:46', '2024-08-01 07:01:46'),
(8, 'App\\Models\\User', 2, 'auth_token', 'bb0321a5ded18ee549c2fd8510fb5ccc188d633c00d4cd437de4fbf683900945', '[\"*\"]', '2024-08-01 18:39:46', NULL, '2024-08-01 07:27:56', '2024-08-01 18:39:46'),
(9, 'App\\Models\\User', 6, 'auth_token', 'b54fb87937ca009263998060296d47073651a06e22a3a71d9d821fae28bd8f5c', '[\"*\"]', NULL, NULL, '2024-08-01 17:34:17', '2024-08-01 17:34:17');

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
('6M4hI01rTkyeLR7UhPdleK6FsoyN4aoYnuNu3vzd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib25ZQkpSTmNKZG9sTGVZa21SUENuR0ltOVIxWW9wN0xBQk5RNDZ3MiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1722557666),
('Dhsmbl0seXR4Uvos27IHWyppGxkcvICmXEQe3Syj', NULL, '127.0.0.1', 'PostmanRuntime/7.40.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOU9jV2tBVzZTY0VsTFczaEN0bkFWclR6NEFyaTh6WnZXcUp1SFBlTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1722526075),
('NTPpYyK06vMoTK5Nr9KIwPyoRq6NSRIu5Lc02I43', NULL, '127.0.0.1', 'PostmanRuntime/7.40.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR3NIb3V2VXJBSUVwclg0ckJIUkl0NWlpd1N1OERzNkFJUlI4amduUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYW5jdHVtL2NzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1722562456);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jessie', 'sam@example.com', NULL, '$2y$12$d04L/aGT5avZ9a4MIH38Ju/uxmlChHVRB.l8PGKNUDmH8yvchJK4O', NULL, '2024-08-01 05:15:23', '2024-08-01 05:15:23'),
(2, 'Jessiesam', 'newemail@example.com', NULL, '$2y$12$q1xV7xlmMa7IXZkBmaXXE.wTpo7/MfRhyB5feNwatxITgYNpJk20K', NULL, '2024-08-01 05:19:55', '2024-08-01 18:39:47'),
(3, 'Diannesam', 'dianne@example.com', NULL, '$2y$12$rbzCFRB4nkqjI3wlD8dw4.RbJ.z.Z8F7gmdgpTf14AVxlY1QohWxi', NULL, '2024-08-01 05:21:42', '2024-08-01 05:21:42'),
(4, 'Clintsam', 'clint@example.com', NULL, '$2y$12$nbG/d0MaEv.WfJszYuZHZ.z.vfQsKbekUgZZSlm..6MO33k4cSoJG', NULL, '2024-08-01 05:42:37', '2024-08-01 05:42:37'),
(5, 'jessam', 'jes@example.com', NULL, '$2y$12$RneWCkCVlKeGF16r2zFqbeMwmOA6tIRrWdYVJfqLukvGnbVC6jIwy', NULL, '2024-08-01 07:01:46', '2024-08-01 07:01:46'),
(6, 'jessie conn sam', 'jessieconnralph.official@gmail.com', NULL, '$2y$12$hCTGVHkAHptCQgH7anF3fudmFfAw78T88IHLYEzKRZfuo71yLd6vu', NULL, '2024-08-01 17:34:17', '2024-08-01 17:34:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_posts_user_id_foreign` (`user_id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
