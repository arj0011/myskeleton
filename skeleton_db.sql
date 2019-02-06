-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2019 at 06:23 PM
-- Server version: 5.7.25-0ubuntu0.16.04.2
-- PHP Version: 7.1.24-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skeleton_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_01_02_101409_create_permission_tables', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(4, 'App\\User', 2),
(4, 'App\\User', 3),
(4, 'App\\User', 4),
(3, 'App\\User', 5),
(3, 'App\\User', 6),
(3, 'App\\User', 17),
(3, 'App\\User', 18),
(4, 'App\\User', 19),
(4, 'App\\User', 20),
(4, 'App\\User', 21),
(3, 'App\\User', 22);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(11, 'Create User', 'web', '2019-01-04 03:56:00', '2019-01-04 03:56:00'),
(12, 'Edit User', 'web', '2019-01-04 03:57:08', '2019-01-04 03:57:08'),
(13, 'View User', 'web', '2019-01-04 03:57:19', '2019-01-04 03:57:19'),
(14, 'Delete User', 'web', '2019-01-04 03:57:26', '2019-01-04 03:57:26'),
(15, 'Import User', 'web', '2019-01-04 03:57:31', '2019-01-04 03:57:31'),
(16, 'Export User', 'web', '2019-01-04 03:57:36', '2019-01-04 03:57:36'),
(17, 'Create Teacher', 'web', '2019-01-04 03:57:54', '2019-01-04 03:57:54'),
(18, 'Edit Teacher', 'web', '2019-01-04 03:58:07', '2019-01-04 03:58:07'),
(19, 'View Teacher', 'web', '2019-01-04 03:58:20', '2019-01-04 03:58:20'),
(20, 'Delete Teacher', 'web', '2019-01-04 03:58:28', '2019-01-04 03:58:28'),
(21, 'Import Teacher', 'web', '2019-01-04 03:59:01', '2019-01-04 03:59:01'),
(22, 'Export Teacher', 'web', '2019-01-04 03:59:21', '2019-01-04 03:59:21'),
(23, 'Create Attendance', 'web', '2019-01-04 04:01:37', '2019-01-04 04:01:37'),
(24, 'Edit Attendance', 'web', '2019-01-04 04:01:52', '2019-01-04 04:01:52'),
(25, 'View Attendance', 'web', '2019-01-04 04:01:59', '2019-01-04 04:01:59'),
(26, 'Delete Attendance', 'web', '2019-01-04 04:02:07', '2019-01-04 04:02:07'),
(27, 'Import Attendance', 'web', '2019-01-04 04:02:16', '2019-01-04 04:02:16'),
(28, 'Export Attendance', 'web', '2019-01-04 04:02:25', '2019-01-04 04:02:25'),
(29, 'Create Post', 'web', '2019-01-08 05:35:24', '2019-01-08 05:35:24'),
(30, 'Edit Post', 'web', '2019-01-08 05:35:50', '2019-01-08 05:35:50'),
(31, 'View Post', 'web', '2019-01-08 05:36:09', '2019-01-08 05:36:09'),
(32, 'Delete Post', 'web', '2019-01-08 05:36:37', '2019-01-08 05:36:37');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `banner_image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Happy New Year', 'Dear All,\r\nWishing you and your family a joyful, bright, healthy, prosperous and happiest new year In Advance. \r\nAnd we are happy to announce that on the occasion of the new year, there will be holiday on 1st January.\r\n\r\nHappy New Year', 'post_ba5100a5cf3a75eaae2f2479e7877685.jpg', '2019-01-08 12:41:21', '2019-01-08 12:41:21'),
(2, 17, 'Testing Post', '<p><strong>This is testing post</strong></p>\r\n\r\n<p><em>Lorem ipsum</em></p>\r\n\r\n<p>Lorem ipsum&nbsp;Lorem ipsum&nbsp;Lorem ipsum&nbsp;Lorem ipsum&nbsp;Lorem ipsum&nbsp;Lorem ipsum&nbsp;Lorem ipsum&nbsp;Lorem ipsum&nbsp;Lorem ipsum&nbsp;Lorem ipsum&nbsp;Lorem ipsum .</p>\r\n\r\n<p><a href="http://google.com" target="_blank">click here</a></p>', NULL, '2019-01-09 05:22:24', '2019-01-09 05:22:24');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2019-01-04 04:47:18', '2019-01-04 04:47:18'),
(2, 'admin', 'web', '2019-01-04 04:47:49', '2019-01-04 04:47:49'),
(3, 'teacher', 'web', '2019-01-04 04:50:23', '2019-01-04 04:50:23'),
(4, 'Student', 'web', '2019-01-04 05:17:24', '2019-01-04 05:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(23, 3),
(24, 3),
(25, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(25, 4),
(31, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_type` enum('ANDROID','IOS') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `device_type`, `device_token`, `remember_token`, `auth_token`, `image`, `mobile`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'superadmin', NULL, NULL, 'superadmin@gmail.com', NULL, '$2y$10$plFYISwseaUDogs713mAn.OrsYrzOrn7P626WGXx4TUdimRyW2yme', NULL, NULL, 'NatRhelrWacj8hPOaFyO4UpvyyusTqgRdhWFcJwBmRMVs19zsvuk1tEetVYi', NULL, NULL, '9876543210', NULL, 1, '2019-01-04 05:08:44', '2019-01-04 05:08:45'),
(2, 4, 'amit', 'amit', 'sharma', 'amit@gmail.com', NULL, '$2y$10$ApXoX1t5G06eGrTEWAjMquQqnzWbOPRThBlAIVBNZbd9NPouoF/1K', NULL, NULL, 'ItepJUGtIHgkzEuxqBPZo3l5Zph7Q4qvVk4KByInFQUoybUm2165YwC69JYZ', NULL, 'profile_5baf44e746a5106f5698b9125e97f5d1.jpg', '9876543211', 'Tikamgar Madya Pradesh', 1, '2019-01-04 05:50:22', '2019-01-07 04:42:48'),
(3, 4, 'anoop', NULL, NULL, 'anoop@gmail.com', NULL, '$2y$10$E1Td4xhnKh/vm.L5jY/GYOYHP.hNXqeHTisHdqcArVtXn2P5KohGS', NULL, NULL, 'pquRYgkxSEs3Tv6v0s0nO1DlqE9gRMrwwy5BpFJzZmtelILZ8rKQx6LWj3DK', NULL, NULL, '9876543212', NULL, 1, '2019-01-04 07:20:41', '2019-01-05 00:09:09'),
(4, 4, 'bhavesh', 'bhavesh', 'Joshi', 'bhavesh@gmail.com', NULL, '$2y$10$gKV2NdZeE2Gvwgnl6bMx.OUYr3MGOXYh/RiPM61O/FMZy24y/CpM6', NULL, NULL, 'eDe98dCWckpWjLXryAGKr4V6UmDcCBMuJ2sxHNNbRW3M7xmzbo2yvatKBi6j', NULL, NULL, '9876543213', 'Ratlam Madhya Pradesh', 1, '2019-01-05 00:01:18', '2019-01-07 04:37:42'),
(5, 3, 'manish', NULL, NULL, 'manish@gmail.com', NULL, '$2y$10$drVq9MmtybBXt1FfaAJKg.qU8px.L0KB.d6N.ePDnB3Z7LDvvPwU6', NULL, NULL, 'LszM80fYYjVTEPWgekAZLGPKNd5sqHlrilVFdNhVeITqOhb7sxQBDicJ8UKj', NULL, NULL, '9876543214', NULL, 1, '2019-01-05 00:18:24', '2019-01-05 01:36:33'),
(6, 3, 'kamlesh', NULL, NULL, 'kamlesh@gmail.com', NULL, '$2y$10$aXl08hsLhWbveOnNRQ34L.t/kUVTGgzO./WemEkSdp.5fuZmJRgKG', NULL, NULL, NULL, NULL, NULL, '9876543215', NULL, 1, '2019-01-05 00:21:46', '2019-01-05 00:26:12'),
(17, 3, 'ram', NULL, NULL, 'ram@gmail.com', NULL, '$2y$10$OPvStGfhLx915bCuAXj7UeOpuPOfnAZAgRpv7TvwvHmN92dFt2F0a', NULL, NULL, NULL, NULL, NULL, '9876543216', NULL, 1, '2019-01-05 01:31:32', '2019-01-05 01:31:32'),
(18, 3, 'jayesh', NULL, NULL, 'jayesh@gmail.com', NULL, '$2y$10$zKeHDvIpP4mDA4eUD7MrCOBj1vp0ZqgcxjP9T0GOVADzDFilC18oO', NULL, NULL, 'lLIXSIbmTK2CH4F5XBb7Z0gvvkjnmgW0gVHodewaPWABa0Fn2XIKXKhpV7K4', NULL, NULL, '9876543217', NULL, 1, '2019-01-05 01:31:32', '2019-01-05 01:31:32'),
(19, 4, 'chetan', NULL, NULL, 'chetan@gmail.com', NULL, '$2y$10$vkiv/SikJ3j3WJ8znrKvyeGeba4kgjO9dHQSXXHP8Jl9y8Yfxg1rS', NULL, NULL, NULL, NULL, NULL, '9876543218', NULL, 1, '2019-01-05 01:41:32', '2019-01-05 01:41:32'),
(20, 4, 'kalpit', NULL, NULL, 'kalpit@gmail.com', NULL, '$2y$10$xb1gc/f2PYTPZUFQQc.Z2.2yRrB/SHfDhQqKgF7JSBfp6Yz/.EXBe', NULL, NULL, NULL, NULL, NULL, '9876543219', NULL, 1, '2019-01-05 01:41:32', '2019-01-05 01:41:32'),
(21, 4, 'nikhil', NULL, NULL, 'nikhil@gmail.com', NULL, '$2y$10$8EsWbJ.afNNR0yHDtWOJPuvuR59qbms1tPMwyqI27j.fVGf6ycnmO', 'IOS', '7df7dsf7dsf7ds7f87d8sf87d8sf8d7sfdsfdsf9ds0f9dsf', 'NALGCT6K1shHclrkMbyf5DXhTvHmLRO4rObiMw1U1bGA7NRZirZjwrdqaPNV', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL215c2tlbGV0b25cL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE1NDcwMjI4NDIsImV4cCI6MTU0NzAyNjQ0MiwibmJmIjoxNTQ3MDIyODQyLCJqdGkiOiJRVGNodXg2S1M2UW41V0NqIiwic3ViIjoyMSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.5tYprMPUDODn3ysKZ6FHDzij0OyuAYotVg5fEBhkOps', 'profile_50d0a33b1043d9c527cf307fa26a438f.png', '9876542311', NULL, 1, '2019-01-08 00:45:48', '2019-01-09 03:04:02'),
(22, 3, 'somesh', NULL, NULL, 'somesh@gmail.com', NULL, '$2y$10$W0vMl3Rb5wkSmjMq4G/tZ.1fQ87uhphBKBBkxrTZLRwescyjYRS.i', 'ANDROID', 'dsfdsf78dsf56d5fdsfdsf09ds-09f-0ds80f89ds8fdsf7dsf56dsfds', 'T709FTalXJ8d7RV01EDrdGGtrh5IY6QIsdqIUc41L2PWEcyttL46zhxqMDHj', NULL, 'profile_570104bae9fa96f674a3385b71553341.png', '9876543220', NULL, 1, '2019-01-08 05:16:47', '2019-01-08 05:16:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
