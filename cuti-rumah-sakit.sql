-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2026 at 09:48 AM
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
-- Database: `cuti-rumah-sakit`
--

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
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') NOT NULL DEFAULT 'pending',
  `berkas_pendukung` varchar(255) DEFAULT NULL,
  `disetujui_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `disetujui_oleh_kepala_bagian` bigint(20) UNSIGNED DEFAULT NULL,
  `disetujui_oleh_kepala_ruangan` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id`, `user_id`, `tanggal_mulai`, `tanggal_selesai`, `keterangan`, `status`, `berkas_pendukung`, `disetujui_oleh`, `disetujui_oleh_kepala_bagian`, `disetujui_oleh_kepala_ruangan`, `created_at`, `updated_at`) VALUES
(2, 13, '2025-09-12', '2025-09-12', NULL, 'ditolak', NULL, 7, 7, NULL, '2025-09-05 19:52:15', '2025-09-05 19:55:25'),
(3, 13, '2025-09-24', '2025-09-24', NULL, 'disetujui', NULL, 7, 7, NULL, '2025-09-05 20:15:29', '2025-09-05 20:19:27'),
(4, 15, '2025-09-12', '2025-09-12', NULL, 'disetujui', NULL, 14, NULL, 14, '2025-09-05 21:16:19', '2025-09-05 21:16:55'),
(5, 16, '2025-09-11', '2025-09-11', NULL, 'disetujui', NULL, 4, 4, NULL, '2025-09-09 22:09:27', '2025-09-09 22:10:28'),
(6, 11, '2025-09-12', '2025-09-12', NULL, 'ditolak', NULL, 9, 9, NULL, '2025-09-10 01:27:23', '2025-09-10 01:32:58'),
(7, 11, '2025-09-12', '2025-09-12', NULL, 'ditolak', NULL, 9, 9, NULL, '2025-09-10 01:35:24', '2025-09-10 01:42:24'),
(8, 9, '2025-09-12', '2025-09-12', NULL, 'disetujui', NULL, 9, 9, NULL, '2025-09-10 05:55:54', '2025-09-10 05:55:54'),
(9, 18, '2025-09-12', '2025-09-12', 'holiday', 'disetujui', NULL, 14, NULL, 14, '2025-09-10 20:22:42', '2025-09-10 20:26:39'),
(10, 18, '2025-09-18', '2025-09-18', NULL, 'disetujui', NULL, 14, NULL, 14, '2025-09-10 23:38:55', '2025-09-10 23:48:24'),
(11, 3, '2025-09-12', '2025-09-12', 'menikah', 'pending', NULL, NULL, NULL, NULL, '2025-09-10 23:58:44', '2025-09-10 23:58:44');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_divisi` varchar(255) NOT NULL,
  `kepala_divisi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `nama_divisi`, `kepala_divisi`, `created_at`, `updated_at`) VALUES
(3, 'Administrasi Sistem', NULL, '2025-09-05 19:18:51', '2025-09-05 19:18:51'),
(4, 'Kepala Bagian Keperawatan', NULL, '2025-09-05 19:18:51', '2025-09-05 19:18:51'),
(5, 'Kepala Bidang Penunjang Medis', NULL, '2025-09-05 19:18:52', '2025-09-05 19:18:52'),
(6, 'Kepala Bagian Keuangan', NULL, '2025-09-05 19:18:52', '2025-09-05 19:18:52'),
(7, 'Kepala Bidang Pelayanan Medis', NULL, '2025-09-05 19:18:52', '2025-09-05 19:18:52'),
(8, 'Casemix', NULL, '2025-09-05 19:18:52', '2025-09-05 19:18:52'),
(9, 'SDM & UMUM', NULL, '2025-09-05 19:18:53', '2025-09-11 01:04:05');

-- --------------------------------------------------------

--
-- Table structure for table `ijin`
--

CREATE TABLE `ijin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_ijin` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `keterangan` text NOT NULL,
  `berkas_pendukung` varchar(255) DEFAULT NULL,
  `jenis_ijin` enum('sakit','keluarga','pribadi','lainnya') NOT NULL,
  `status` enum('pending','disetujui_kepala_ruangan','disetujui_kepala_bagian','disetujui','ditolak') NOT NULL DEFAULT 'pending',
  `disetujui_oleh_kepala_ruangan` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_persetujuan` timestamp NULL DEFAULT NULL,
  `catatan_persetujuan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `disetujui_oleh_kepala_bagian` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ijin`
--

INSERT INTO `ijin` (`id`, `user_id`, `tanggal_ijin`, `jam_mulai`, `jam_selesai`, `keterangan`, `berkas_pendukung`, `jenis_ijin`, `status`, `disetujui_oleh_kepala_ruangan`, `tanggal_persetujuan`, `catatan_persetujuan`, `created_at`, `updated_at`, `disetujui_oleh_kepala_bagian`) VALUES
(3, 7, '2025-09-11', NULL, NULL, 'ijin 2 hari bossss', '1757472945_11.png', 'keluarga', 'disetujui', NULL, '2025-09-09 19:55:45', NULL, '2025-09-09 19:55:45', '2025-09-09 19:55:45', 7),
(4, 15, '2025-09-11', NULL, NULL, 'sakit', '1757473424_dfd.png', 'sakit', 'disetujui_kepala_ruangan', 14, '2025-09-09 20:04:18', 'gasss', '2025-09-09 20:03:44', '2025-09-09 20:04:18', NULL),
(5, 3, '2025-09-12', NULL, NULL, 'menikah', '1757574236_WhatsApp Image 2025-08-14 at 11.11.56.jpeg', 'sakit', 'pending', NULL, NULL, NULL, '2025-09-11 00:03:56', '2025-09-11 00:03:56', NULL);

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
(1, '2025_01_20_000000_fix_users_and_add_divisi_table', 1),
(2, '2025_01_20_000001_add_divisi_and_role_to_users_and_fk_to_cuti', 1),
(3, '2025_08_15_062359_create_users_table', 1),
(4, '2025_08_15_062360_create_units_table', 1),
(5, '2025_08_15_062808_create_unit_user_table', 1),
(6, '2025_08_15_062838_create_cuti_table', 1),
(7, '2025_09_03_000100_add_missing_columns_for_mysql', 1),
(8, '2025_09_03_000110_make_users_divisi_nullable', 1),
(9, '2025_09_03_000120_add_role_kepala_ruangan', 1),
(10, '2025_09_03_065456_create_sessions_table', 1),
(11, '2025_09_05_180717_add_dual_approval_fields_to_cuti_table', 1),
(12, '2025_09_06_020749_update_role_enum_to_include_kepala_kepegawaian', 1),
(13, '2025_09_10_000000_add_divisi_id_to_users_table', 1),
(14, '2025_09_10_000001_add_role_to_users_table', 1),
(15, '2025_09_11_000000_create_overtimes_table', 2),
(16, '2025_09_08_051147_create_cache_table', 3),
(17, '2025_09_12_000000_add_jam_mulai_jam_selesai_to_overtimes_table', 4),
(18, '2025_09_09_064447_create_sisa_cuti_table', 5),
(19, '2025_09_09_065107_create_sisa_cuti_table_v2', 5),
(20, '2025_09_09_065842_create_ijin_table', 5),
(21, '2025_09_13_000000_add_nik_to_users_table', 6),
(22, '2025_09_09_080800_remove_nik_from_users_table', 7),
(23, '2025_09_09_080906_add_berkas_pendukung_to_cuti_table', 8),
(24, '2025_09_09_081340_add_keterangan_to_cuti_table', 8),
(25, '2025_09_09_081704_add_berkas_pendukung_to_ijin_table', 9),
(26, '2025_09_12_000000_add_dual_approval_fields_to_ijin_table', 10),
(27, '2025_09_14_000000_update_ijin_status_enum', 11),
(28, '2025_09_10_031031_add_jumlah_cuti_to_users_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `overtimes`
--

CREATE TABLE `overtimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `overtimes`
--

INSERT INTO `overtimes` (`id`, `user_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `keterangan`, `status`, `approved_by`, `created_at`, `updated_at`) VALUES
(2, 15, '2025-08-10', '18:00:00', '20:00:00', 'Lembur contoh untuk testing', 'approved', 15, '2025-09-08 22:14:40', '2025-09-08 22:14:40'),
(3, 13, '2025-08-26', '18:00:00', '20:00:00', 'Lembur contoh untuk testing', 'approved', 13, '2025-09-08 22:14:40', '2025-09-08 22:14:40'),
(4, 3, '2025-09-12', '07:00:00', '14:00:00', 'menjagakan cici', 'pending', NULL, '2025-09-11 00:00:04', '2025-09-11 00:00:04');

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
('862JGGQXW0hDsFb1UjZRXZQt4hRRuVALPValXs4H', NULL, '192.168.2.80', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGhNUFhzTDl5YVZsMHFMa0dpU1pUYThXbDM3cFc5dWVBMmdYcXJ0VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xOTIuMTY4LjIuODA6ODAwMi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1766477536),
('9etrAUuiC08ZZHV10kA5HeuKJSA1wBYrRGkwfXkV', 3, '192.168.2.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUVVScnVMckZDckt4Vk00dTk1TXhoRmZtdDRGV1VZSWY5eXBhUEdpWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xOTIuMTY4LjIuODA6ODAwMy9hZG1pbi9kaXZpc2kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1760514127),
('DNA0fqN8I4FA6rnTHVXOxlJXKHdE6yIIbwu15g3m', NULL, '192.168.2.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUTNtUDV3Mjl3cm00TUtjZlV5WjhxR25YZWlMWUZocVdsa3NzTFpnWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xOTIuMTY4LjIuODA6ODAwMy9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1758517835),
('DqGFdqGpjXAeaJHI7NAeVj95sE07FtlDyIm1PB69', NULL, '192.168.2.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicHJpNFdzT01ua1RiTHVyN1UwT2xYYjBoV2swTmNzeFBodFhicTJOMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xOTIuMTY4LjIuODA6ODAwMy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1759588575),
('EdqGBDkMeXzmh9KhucLdyeIP04Wn6x1r2sXCY6cB', 3, '192.168.2.80', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRmVuMkZXWENOWXREbUQyb3JHNDVGWjlyZURucWtSNjBmT3QyR25zMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xOTIuMTY4LjIuODA6ODAwMi9hZG1pbi91c2VycyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1766541714),
('F4McD7tZbVPVowrlVi3rmCukBgVD6ySto8FuLmb8', NULL, '192.168.2.80', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3d5SWlkc2RaNWZlVFdZRmZGWTc3bjlPYTM1b1BLUTZEbnBXeXhvOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xOTIuMTY4LjIuODA6ODAwMy9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763963374),
('Q0rngze4QtKFyBwDm0yKXlZp52Tf6GFW3z92ahkM', 11, '192.168.2.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMk1YSVhKV1hZQXdUektjdHd4ZXg3VVRPUkpNaVU3RnpTTHJIWGJzcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xOTIuMTY4LjIuODA6ODAwMy9rZXBhbGEta2VwZWdhd2FpYW4vZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTE7fQ==', 1757752230);

-- --------------------------------------------------------

--
-- Table structure for table `sisa_cuti`
--

CREATE TABLE `sisa_cuti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sisa_cuti_table_v2`
--

CREATE TABLE `sisa_cuti_table_v2` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_unit` varchar(255) NOT NULL,
  `tipe_unit` enum('medis','non-medis') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `nama_unit`, `tipe_unit`, `created_at`, `updated_at`) VALUES
(1, 'IGD', 'medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(2, 'Rawat inap', 'medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(3, 'VK', 'medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(4, 'Nicu', 'medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(5, 'ICU', 'medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(6, 'OK', 'medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(7, 'Poli', 'medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(8, 'MCU', 'medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(9, 'Farmasi', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(10, 'Radiologi', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(11, 'Laboratorium', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(12, 'Gizi', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(13, 'Rehab', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(14, 'Rekam medis', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(15, 'Keuangan', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(16, 'Kasir', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(17, 'KESLING', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(18, 'Admin TPPRI-TPPRJ', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(19, 'LAUNDRY', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(20, 'IT', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(21, 'PEMELIHARAAN SARANA', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(22, 'ATEM', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(23, 'DRIVER', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(24, 'SECURITY', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(25, 'OFFICE BOY', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(26, 'MARKETING', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(27, 'KESEKRETARIATAN & DIKLAT', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(28, 'KEPALA RUMAH TANGGA', 'non-medis', '2025-09-05 19:18:50', '2025-09-05 19:18:50'),
(29, 'PARKIR', 'non-medis', '2025-09-10 01:21:50', '2025-09-10 01:21:50'),
(30, 'BPJS', 'non-medis', '2025-09-10 08:54:27', '2025-09-10 08:54:27'),
(31, 'Kepegawaian', 'non-medis', '2025-09-11 00:31:10', '2025-09-11 00:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `unit_user`
--

CREATE TABLE `unit_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_user`
--

INSERT INTO `unit_user` (`id`, `user_id`, `unit_id`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`) VALUES
(3, 12, 8, '2025-09-06', NULL, '2025-09-05 19:50:15', '2025-09-05 19:50:15'),
(4, 13, 8, '2025-09-06', NULL, '2025-09-05 19:51:06', '2025-09-05 19:51:06'),
(6, 15, 20, '2025-09-10', NULL, '2025-09-05 21:15:43', '2025-09-10 07:22:37'),
(7, 16, 1, '2025-09-10', '2025-09-10', '2025-09-09 22:08:48', '2025-09-09 23:17:59'),
(8, 16, 3, '2025-09-10', NULL, '2025-09-09 23:17:59', '2025-09-09 23:17:59'),
(9, 17, 24, '2025-09-10', NULL, '2025-09-10 07:21:33', '2025-09-10 07:21:33'),
(10, 18, 20, '2025-09-11', NULL, '2025-09-10 20:21:53', '2025-09-10 20:21:53'),
(12, 14, 20, '2025-09-11', NULL, '2025-09-10 23:36:32', '2025-09-10 23:36:51'),
(17, 21, 23, '2025-09-11', NULL, '2025-09-11 01:16:57', '2025-09-11 01:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `divisi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `jumlah_cuti` int(11) NOT NULL DEFAULT 0,
  `jenis_karyawan` enum('medis','non-medis') NOT NULL,
  `role` enum('admin','kepala_bagian','kepala_ruangan','kepala_kepegawaian','karyawan') NOT NULL DEFAULT 'karyawan',
  `sisa_cuti` int(11) NOT NULL DEFAULT 12,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `divisi_id`, `nama`, `jabatan`, `jumlah_cuti`, `jenis_karyawan`, `role`, `sisa_cuti`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 3, 'Admin RS', 'Administrator', 0, 'non-medis', 'admin', 12, 'admin@rs.com', '$2y$12$G7IiDHPkMgdzzhwVLQtJCOBEyqoiMdlnZiSYq5YASTkhd0HFtLL4m', '1AwieR2lA0IvPYViJIo8wS8c0CCMTZITsxmCw3ocSGA1SllLJygnUxPAMgKq', '2025-09-05 19:18:51', '2025-09-07 22:12:23'),
(4, 4, 'KB Keperawatan', 'Kepala Bagian Keperawatan', 0, 'medis', 'kepala_bagian', 12, 'kb.keperawatan@rs.com', '$2y$12$p/pGp.DbLcPDucyY8TGC1O9fnB8L9d80T3gONUxWY/R9D.BND7/6O', NULL, '2025-09-05 19:18:52', '2025-09-05 19:18:52'),
(5, 5, 'KB Penunjang Medis', 'Kepala Bidang Penunjang Medis', 0, 'medis', 'kepala_bagian', 12, 'kb.penunjang@rs.com', '$2y$12$a52H7YHfwqfNPM20gDs1nuNxIBsriRRI.8NAEfE0ICaWuYaixpdm2', NULL, '2025-09-05 19:18:52', '2025-09-05 19:18:52'),
(6, 6, 'KB Keuangan', 'Kepala Bagian Keuangan', 0, 'non-medis', 'kepala_bagian', 12, 'kb.keuangan@rs.com', '$2y$12$qZKfI5o8xWnGeDiFUOo1Je05UpYFH8SGCyghBoCGN7d4DKeeX61mq', NULL, '2025-09-05 19:18:52', '2025-09-05 19:18:52'),
(7, 7, 'KB Pelayanan Medis', 'Kepala Bidang Pelayanan Medis', 0, 'medis', 'kepala_bagian', 12, 'kb.pelayanan@rs.com', '$2y$12$VA.Qlvsq9cNTYtSZa4MwZ.u37nxDHCVwFCJ8NkKObzLTQbk9606TW', NULL, '2025-09-05 19:18:52', '2025-09-05 19:18:52'),
(8, 8, 'KB Casemix', 'Kepala Casemix', 0, 'non-medis', 'kepala_bagian', 12, 'kb.casemix@rs.com', '$2y$12$EeDjA4rmJyYgFBa0SG2rU.U1lg66E1Dj.1YwpBeaZ45sZmE./FJrC', NULL, '2025-09-05 19:18:53', '2025-09-05 19:18:53'),
(9, 9, 'KB Kepegawaian', 'Kepala Kepegawaian', 0, 'non-medis', 'kepala_bagian', 12, 'kb.kepegawaian@rs.com', '$2y$12$sL3grs3ZBtCQEAP2CWGdcuY45.t3n/pOWREHuG8iY25altrQQ6QXu', NULL, '2025-09-05 19:18:53', '2025-09-05 19:18:53'),
(10, 4, 'KR Ruangan', 'Kepala Ruangan', 0, 'medis', 'kepala_ruangan', 12, 'kr.ruangan@rs.com', '$2y$12$myKQTs8O/c3.qrJaEpSOm.DaRef1fVvX6v7NljcmiJqroCDN5FADy', NULL, '2025-09-05 19:18:53', '2025-09-05 19:18:53'),
(11, 9, 'Kepala Kepegawaian', 'Kepala Kepegawaian', 0, 'non-medis', 'kepala_kepegawaian', 12, 'kepala.kepegawaian@rs.com', '$2y$12$ShHinUmfSsfHHeeGf9AOnONWU58eAxV7Y4q4Xenpts7RDr87zSOPS', NULL, '2025-09-05 19:18:54', '2025-09-08 06:57:15'),
(12, 7, 'MCU', 'kepala ruangan', 0, 'medis', 'kepala_ruangan', 12, 'mcu@rs.com', '$2y$12$8tGgM50uu3TPcP/K52LUROdSYgW1v6xjuowG/dFeO7XPaUK74H0N.', NULL, '2025-09-05 19:50:15', '2025-09-05 19:50:15'),
(13, 7, 'intan', 'pelaksana', 0, 'medis', 'karyawan', 11, 'intan@mail.com', '$2y$12$/nfVCqc8VusajDOdR9IejeNaQ7GwrF5T2/OLS/Sc8PFNXI1BPopxm', NULL, '2025-09-05 19:51:06', '2025-09-05 20:19:27'),
(14, 9, 'Ruang IT', 'Kepala ruangan', 0, 'non-medis', 'kepala_ruangan', 12, 'IT@mail.com', '$2y$12$yXZfE32g7x7/NCmspnauAuewsTrIIoYJPv.a44Kn8X4XT1zXvpGji', NULL, '2025-09-05 21:14:54', '2025-09-10 23:36:51'),
(15, 9, 'aji', 'pelaksana', 0, 'non-medis', 'karyawan', 11, 'aji@mail.com', '$2y$12$1VQkMvtutd7BFI8cHVTtQunMjOLPu5TGr96dJ3hqGM4HfONuoJy7W', NULL, '2025-09-05 21:15:43', '2025-09-10 07:22:37'),
(16, 4, 'perawat igd', 'Pelaksana', 12, 'medis', 'karyawan', 11, 'perawat@mail.com', '$2y$12$KiVfk2AIVpSXC.A5Cu.TMOW7ioxI/zjaLIlsLuqP/IwhfEWENvrPi', NULL, '2025-09-09 22:08:48', '2025-09-09 22:10:28'),
(17, 9, 'sandi', 'Pelaksana', 10, 'non-medis', 'karyawan', 12, 'sandi@mail.com', '$2y$12$77TfDYW4pbeFt63opDvmSuQW.FqE3tchVWptWF1pdKFf2/z66orDG', NULL, '2025-09-10 07:21:33', '2025-09-10 07:21:33'),
(18, 9, 'namaku', 'Staff', 12, 'non-medis', 'karyawan', 10, 'namaku@gmail.com', '$2y$12$tiqh1M34zLGysbRN5TFVPuYn0MfRIg.v8IB19G/QX58peERH.QxVu', NULL, '2025-09-10 20:21:53', '2025-09-10 23:48:24'),
(21, 9, 'tes', 'Karyawan', 12, 'non-medis', 'karyawan', 5, 'tes@mail.com', '$2y$12$Zauc6iARMEjlONjvxxHvhuH0TVO7On46cbygw8EwBJ6CU2mxpi1h.', NULL, '2025-09-11 01:08:46', '2025-09-11 01:16:57');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuti_user_id_foreign` (`user_id`),
  ADD KEY `cuti_disetujui_oleh_foreign` (`disetujui_oleh`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ijin`
--
ALTER TABLE `ijin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ijin_user_id_foreign` (`user_id`),
  ADD KEY `ijin_disetujui_oleh_kepala_ruangan_foreign` (`disetujui_oleh_kepala_ruangan`),
  ADD KEY `ijin_disetujui_oleh_kepala_bagian_foreign` (`disetujui_oleh_kepala_bagian`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtimes`
--
ALTER TABLE `overtimes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `overtimes_user_id_foreign` (`user_id`),
  ADD KEY `overtimes_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sisa_cuti`
--
ALTER TABLE `sisa_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sisa_cuti_table_v2`
--
ALTER TABLE `sisa_cuti_table_v2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_user`
--
ALTER TABLE `unit_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_user_user_id_foreign` (`user_id`),
  ADD KEY `unit_user_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_divisi_id_foreign` (`divisi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ijin`
--
ALTER TABLE `ijin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sisa_cuti`
--
ALTER TABLE `sisa_cuti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sisa_cuti_table_v2`
--
ALTER TABLE `sisa_cuti_table_v2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `unit_user`
--
ALTER TABLE `unit_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_disetujui_oleh_foreign` FOREIGN KEY (`disetujui_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cuti_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ijin`
--
ALTER TABLE `ijin`
  ADD CONSTRAINT `ijin_disetujui_oleh_kepala_bagian_foreign` FOREIGN KEY (`disetujui_oleh_kepala_bagian`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ijin_disetujui_oleh_kepala_ruangan_foreign` FOREIGN KEY (`disetujui_oleh_kepala_ruangan`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ijin_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `overtimes`
--
ALTER TABLE `overtimes`
  ADD CONSTRAINT `overtimes_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `overtimes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unit_user`
--
ALTER TABLE `unit_user`
  ADD CONSTRAINT `unit_user_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `unit_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
