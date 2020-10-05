-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Agu 2020 pada 04.18
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etalase_app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `apps`
--

CREATE TABLE `apps` (
  `id` int(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `app_icon` varchar(255) DEFAULT NULL,
  `sdk_target_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `version` varchar(11) DEFAULT NULL,
  `file_size` varchar(32) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updates_description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `apk_file` varchar(255) DEFAULT NULL,
  `expansion_file` varchar(255) DEFAULT NULL,
  `developer_id` int(20) DEFAULT NULL,
  `is_approve` tinyint(4) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `is_partnership` tinyint(4) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `updated_by` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `apps`
--

INSERT INTO `apps` (`id`, `name`, `type`, `app_icon`, `sdk_target_id`, `category_id`, `rate`, `version`, `file_size`, `description`, `updates_description`, `link`, `apk_file`, `expansion_file`, `developer_id`, `is_approve`, `is_active`, `is_partnership`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'App', 'Games', 'app.png', 1, 1, 0, '1.0', '2000', 'test app', 'testing apps', 'www.apps.com', 'app.apk', 'aa', 33, 1, 1, 0, '2020-08-01 13:08:00', 0, '2020-08-01 23:21:37', 0),
(2, 'Example App2', 'Games', 'app_icon_Example App2_2.jpg', 2, 1, 14, '1.0', '3000', 'test example app2', 'testing example apps2', 'www.p.com', 'app2.apk', 'aa', 33, 1, 1, 1, '2020-08-01 13:08:00', 0, '2020-08-01 22:57:22', 0),
(4, 'etalse apps update', 'Musik', 'app_icon_etalse apps update_4.jpg', 2, 2, 15, '1.2', '', 'w update', 'w update', NULL, '$file_name', '$file_name', 33, 1, 1, 1, '2020-08-01 21:38:00', 0, '2020-08-02 08:29:54', NULL),
(7, 'etalse apps 3', 'Musik', 'app_icon_etalse apps 3_.jpg', 1, 2, 15, '1.1', '', 'ga jelas', 'tsting', NULL, 'apk_etalse apps 3_.sql', 'exp_file_etalse apps 3_.rar', 34, 2, 1, 1, '2020-08-01 21:24:12', 0, '2020-08-01 23:24:30', NULL),
(8, 'etalse apps 2 update', 'Musik', 'app_icon_etalse apps 2 update_5.jpg', 2, 3, 17, '1.1', '', 'testiing update', 'esting update', NULL, 'app_icon_etalse apps 2 update_5.jpg', 'app_icon_etalse apps 2 update_5.jpg', 33, 2, 1, 1, '2020-08-01 21:35:44', 0, '2020-08-02 08:29:34', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `download_apps`
--

CREATE TABLE `download_apps` (
  `id` int(20) NOT NULL,
  `apps_id` int(20) DEFAULT NULL,
  `end_users_id` int(20) DEFAULT NULL,
  `clicked` int(20) DEFAULT NULL,
  `installed` int(20) DEFAULT NULL,
  `version` varchar(32) NOT NULL,
  `clicked_at` timestamp NULL DEFAULT current_timestamp(),
  `installed_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2020_07_20_203215_create_mst_countries_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_ads`
--

CREATE TABLE `mst_ads` (
  `id` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `orders` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(20) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updated_by` int(20) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_category`
--

CREATE TABLE `mst_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mst_category`
--

INSERT INTO `mst_category` (`id`, `name`, `icon`) VALUES
(1, 'Puzzle', 'puzzle.png'),
(2, 'Action', 'action.png'),
(3, 'RPG', 'rpg.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_countries`
--

CREATE TABLE `mst_countries` (
  `id` int(11) NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mst_countries`
--

INSERT INTO `mst_countries` (`id`, `country`) VALUES
(1, 'Indonesia'),
(2, 'Malaysia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_sdk`
--

CREATE TABLE `mst_sdk` (
  `id` int(11) NOT NULL,
  `sdk` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mst_sdk`
--

INSERT INTO `mst_sdk` (`id`, `sdk`) VALUES
(1, '28'),
(2, '29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ratings`
--

CREATE TABLE `ratings` (
  `id` int(20) NOT NULL,
  `apps_id` int(20) DEFAULT NULL,
  `end_users_id` int(20) DEFAULT NULL,
  `ratings` float DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `users_dev_id` int(20) DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `comment_at` timestamp NULL DEFAULT current_timestamp(),
  `reply_at` timestamp NULL DEFAULT current_timestamp(),
  `read_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ratings`
--

INSERT INTO `ratings` (`id`, `apps_id`, `end_users_id`, `ratings`, `comment`, `users_dev_id`, `reply`, `comment_at`, `reply_at`, `read_at`) VALUES
(1, 1, 33, 5, 'ok', 33, 'yes', '2020-08-01 06:20:00', '2020-08-01 06:20:00', '2020-08-01 06:20:00'),
(2, 2, 33, 4.5, 'okk', 33, 'yess', '2020-08-01 06:20:00', '2020-08-01 06:20:00', '2020-08-01 06:20:00'),
(3, 1, 34, 5, 'bagus', 33, 'thanks', '2020-07-31 17:00:00', '2020-07-31 17:00:00', '2020-07-31 17:00:00'),
(4, 1, 34, 4, 'baguslah', 33, 'thank you', '2020-07-31 17:00:00', '2020-07-31 17:00:00', '2020-07-31 17:00:00'),
(5, 2, 34, 5, 'good', 33, 'makasih', '2020-07-31 17:00:00', '2020-07-31 17:00:00', '2020-07-31 17:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reset_password_token`
--

CREATE TABLE `reset_password_token` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reset_password_token`
--

INSERT INTO `reset_password_token` (`email`, `token`, `expired_at`, `updated_at`, `created_at`) VALUES
('mchrezky@gmail.com', '8a12f4e532cc771b48e25ed4ea8319e4', '2020-07-22 15:48:01', '2020-07-22 14:48:03', '2020-07-22 14:48:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dev_web` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dev_country_id` int(11) DEFAULT NULL,
  `dev_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eu_birthday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eu_device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(4) DEFAULT NULL,
  `is_blocked` tinyint(4) DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  `updated_by` int(20) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `picture`, `role_id`, `token`, `dev_web`, `dev_country_id`, `dev_address`, `eu_birthday`, `eu_device_id`, `is_verified`, `is_blocked`, `created_by`, `updated_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'mchrezky1', 'mchrezky@gmail.com', '2020-07-29 16:11:04', '$2y$10$HHT/HBpf/pEtXP9TDrbhfeRmYRt7.zFL/p.Lxz8jzLM74AyvmmcrS', 'mchrezky@gmail.comimage_profile.jpg', 1, NULL, NULL, 1, NULL, NULL, '', NULL, 0, NULL, NULL, NULL, '2020-07-20 07:14:20', '2020-08-02 02:03:32'),
(30, 'sefiana putris', 'sefianaputri41@gmail.com', '2020-07-29 16:11:04', '$2y$10$SyDaPC5yXqgpsZe/EuiEW.9n.F3fZhxHwowZybpECLcKlJjmBmZKW', 'sefianaputri41@gmail.comimage_profile.jpg', 1, NULL, NULL, NULL, NULL, '2020-07-23', NULL, NULL, 1, NULL, NULL, NULL, '2020-07-29 16:11:04', '2020-07-29 16:11:37'),
(33, 'mchdev', 'mchdev1@yahoo.com', '2020-07-30 01:35:21', '$2y$10$Wgl4iTqBMmgQYXjCdtLL8e4DWHmHqSqMNsQN5JSfKSF0xFuFOXVty', 'mchdev@yahoo.comimage_profile.jpg', 2, NULL, 'mch.web.id', 1, 'bekasi tambun', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2020-07-30 01:35:21', '2020-08-02 02:00:18'),
(34, 'kiwi', 'kiwi@gmail.com', '2020-07-30 01:37:01', '$2y$10$3Z8YHF53SrRLPZBdFgOFgerlAgU71RR39Y1N4nueMEfI/IYKx.rES', 'kiwi@gmail.comimage_profile.png', 2, NULL, 'kiwi.id', 1, 'bekasi', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2020-07-30 01:37:01', '2020-07-30 01:37:01'),
(35, 'rizky', 'rizkyslankers89@gmail.com', '2020-08-02 02:06:20', '$2y$10$FzrJsXkofBoRPzJVwgMyNenqhMA39IUpEqa2dpEXcoxJXZCq.onfq', 'rizkyslankers89@gmail.comimage_profile.png', 1, NULL, NULL, NULL, NULL, '2020-08-15', NULL, NULL, 1, NULL, NULL, NULL, '2020-08-02 02:06:20', '2020-08-02 02:06:20');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_avg_ratings`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_avg_ratings` (
`avg_ratings` double
,`id` int(20)
,`name` varchar(255)
,`type` varchar(255)
,`app_icon` varchar(255)
,`sdk_target_id` int(11)
,`category_id` int(11)
,`rate` float
,`version` varchar(11)
,`file_size` varchar(32)
,`description` text
,`updates_description` text
,`link` varchar(255)
,`apk_file` varchar(255)
,`expansion_file` varchar(255)
,`developer_id` int(20)
,`is_approve` tinyint(4)
,`is_active` tinyint(4)
,`is_partnership` tinyint(4)
,`created_at` varchar(255)
,`created_by` int(20)
,`updated_at` varchar(255)
,`updated_by` int(20)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_avg_ratings`
--
DROP TABLE IF EXISTS `view_avg_ratings`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_avg_ratings`  AS  select avg(`a`.`ratings`) AS `avg_ratings`, count(b.id) AS `download_counter`, `b`.`id` AS `id`,`b`.`name` AS `name`,`b`.`type` AS `type`,`b`.`app_icon` AS `app_icon`,`b`.`sdk_target_id` AS `sdk_target_id`,`b`.`category_id` AS `category_id`,`b`.`rate` AS `rate`,`b`.`version` AS `version`,`b`.`file_size` AS `file_size`,`b`.`description` AS `description`,`b`.`updates_description` AS `updates_description`,`b`.`link` AS `link`,`b`.`apk_file` AS `apk_file`,`b`.`expansion_file` AS `expansion_file`,`b`.`developer_id` AS `developer_id`,`b`.`is_approve` AS `is_approve`,`b`.`is_active` AS `is_active`,`b`.`is_partnership` AS `is_partnership`,`b`.`created_at` AS `created_at`,`b`.`created_by` AS `created_by`,`b`.`updated_at` AS `updated_at`,`b`.`updated_by` AS `updated_by` from (`apps` `b` left join `ratings` `a` on(`a`.`apps_id` = `b`.`id`) left join `download_apps` `c` on(`c`.`apps_id` = `b`.`id`)) group by `b`.`id` ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sdk_target_id` (`sdk_target_id`),
  ADD KEY `developer_id` (`developer_id`),
  ADD KEY `apps_ibfk_2` (`category_id`);

--
-- Indeks untuk tabel `download_apps`
--
ALTER TABLE `download_apps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apps_id` (`apps_id`),
  ADD KEY `end_users_id` (`end_users_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mst_ads`
--
ALTER TABLE `mst_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mst_category`
--
ALTER TABLE `mst_category`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mst_countries`
--
ALTER TABLE `mst_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mst_sdk`
--
ALTER TABLE `mst_sdk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apps_id` (`apps_id`),
  ADD KEY `end_users_id` (`end_users_id`),
  ADD KEY `users_dev_id` (`users_dev_id`);

--
-- Indeks untuk tabel `reset_password_token`
--
ALTER TABLE `reset_password_token`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `dev_country_id` (`dev_country_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `apps`
--
ALTER TABLE `apps`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `download_apps`
--
ALTER TABLE `download_apps`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `mst_ads`
--
ALTER TABLE `mst_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mst_category`
--
ALTER TABLE `mst_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `mst_countries`
--
ALTER TABLE `mst_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mst_sdk`
--
ALTER TABLE `mst_sdk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `apps`
--
ALTER TABLE `apps`
  ADD CONSTRAINT `apps_ibfk_1` FOREIGN KEY (`sdk_target_id`) REFERENCES `mst_sdk` (`id`),
  ADD CONSTRAINT `apps_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `mst_category` (`id`),
  ADD CONSTRAINT `apps_ibfk_3` FOREIGN KEY (`developer_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `download_apps`
--
ALTER TABLE `download_apps`
  ADD CONSTRAINT `download_apps_ibfk_1` FOREIGN KEY (`apps_id`) REFERENCES `apps` (`id`),
  ADD CONSTRAINT `download_apps_ibfk_2` FOREIGN KEY (`end_users_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`apps_id`) REFERENCES `apps` (`id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`end_users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ratings_ibfk_3` FOREIGN KEY (`users_dev_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`dev_country_id`) REFERENCES `mst_countries` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
