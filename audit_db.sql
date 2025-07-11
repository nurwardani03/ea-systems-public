-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 09:30 AM
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
-- Database: `audit_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin EAS', 'admin@eas.co.id', '$2y$12$PszKPE24LTrON7.64Zo/YuCErDoz6KDOcQjnznjBvkyonSfmIc4KK', '2025-07-07 10:00:00', '2025-07-07 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `auditor` varchar(100) NOT NULL,
  `tema` varchar(200) NOT NULL,
  `kategori` enum('Ringkas','Rapi','Resik','ISO 14001','Lainnya') NOT NULL,
  `lokasi` varchar(200) DEFAULT NULL,
  `foto_sebelum` varchar(255) DEFAULT NULL,
  `foto_sesudah` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `keterangan_sesudah` text DEFAULT NULL,
  `tanggal_audit` date NOT NULL,
  `tanggal_verifikasi` date DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bagian_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`id`, `user_id`, `auditor`, `tema`, `kategori`, `lokasi`, `foto_sebelum`, `foto_sesudah`, `keterangan`, `keterangan_sesudah`, `tanggal_audit`, `tanggal_verifikasi`, `status`, `created_at`, `updated_at`, `bagian_id`) VALUES
(10, 4, 'RIDWAN', 'TEST', 'Rapi', 'TEST', 'audit/tjh4P1K7qwDzPvlc8LJ8IT2da5VmpnuEEGDdm8R4.png', 'audit/hp6JTax0UHgsHGyv9qcrOe5bNsGoo0hUSZRJRv0h.png', 'TEST', 'DONE', '2025-07-03', '2025-08-10', NULL, '2025-07-03 01:23:13', '2025-07-10 01:44:34', 7),
(11, 4, 'RIDWAN', 'TEST', 'ISO 14001', 'TEST', 'audit/1CE5QY7G77hoUelPVurG1A7a4Q6NNSLC1zCTAybM.png', NULL, 'TEST', NULL, '2025-07-03', '2025-08-10', NULL, '2025-07-03 01:23:32', '2025-07-10 01:44:34', 7),
(12, 2, 'DANI', 'TEST', 'Rapi', 'TEST', 'audit/A7WfbviO9mYTJItzwINLq8MBwUF29WqJoUjKEVxZ.png', NULL, 'TEST', NULL, '2025-07-03', '2025-08-10', NULL, '2025-07-03 01:58:02', '2025-07-10 01:44:34', 4),
(14, 2, 'DANI', 'bagian TEST', 'Lainnya', 'TEST', 'audit/4TFUhNql1TyhBK8Y7EsszdcSj1hLC4Dws6fIW6UP.png', 'audit/pbZvBhez7B8fmqAtD5SFiFIx8Yi4UcyuZJz2EYgh.png', 'TEST', 'done test', '2025-07-04', '2025-08-10', NULL, '2025-07-03 20:22:29', '2025-07-10 01:44:34', 3),
(15, 4, 'RIDWAN', '5S Seiton', 'ISO 14001', 'line', 'audit/audit_auditor-machining_machining_sebelum_1751964007.jpg', NULL, 'tidak rapih new', NULL, '2025-07-08', '2025-08-10', NULL, '2025-07-08 08:40:07', '2025-07-10 01:44:34', 7),
(16, 4, 'TEST', 'TEST NEW', 'Rapi', 'TEST', 'audit/audit_auditor-machining_machining_sebelum_1752067721.jpg', NULL, 'TEST', NULL, '2025-07-09', '2025-08-10', NULL, '2025-07-09 13:28:44', '2025-07-10 01:44:34', 7),
(17, 4, 'new', 'new', 'Ringkas', 'new', 'audit/audit_auditor-machining_machining_sebelum_1752111730.jpg', 'audit/audit_auditor-machining_machining_sesudah_1752111763.jpg', 'new', 'new', '2025-07-10', '2025-08-10', 'Close', '2025-07-10 01:42:10', '2025-07-10 01:44:34', 7),
(18, 4, 'one', 'one', 'Rapi', 'one', 'audit/audit_auditor-machining_machining_sebelum_1752111855.jpg', 'audit/audit_auditor-machining_machining_sesudah_1752112332.jpg', 'one', 'done', '2025-07-10', '2025-08-10', 'Close', '2025-07-10 01:44:15', '2025-07-10 01:52:12', 7),
(19, 12, 'GA', 'TEST', 'Ringkas', 'TEST', 'audit/audit_auditor-hrd-ga_hrd-ga_sebelum_1752115311.jpg', NULL, 'TEST', NULL, '2025-07-10', NULL, NULL, '2025-07-10 02:41:53', '2025-07-10 02:41:53', 4);

-- --------------------------------------------------------

--
-- Table structure for table `bagian`
--

CREATE TABLE `bagian` (
  `id` int(11) NOT NULL,
  `nama_bagian` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bagian`
--

INSERT INTO `bagian` (`id`, `nama_bagian`, `created_at`, `updated_at`) VALUES
(1, 'HRD-GA', '2025-07-03 07:35:48', '2025-07-03 07:35:48'),
(2, 'Assembly', '2025-07-03 07:35:48', '2025-07-03 07:35:48'),
(3, 'Machining', '2025-07-03 07:35:48', '2025-07-03 07:35:48'),
(4, 'Stamping', '2025-07-03 07:35:48', '2025-07-03 07:35:48'),
(5, 'Injection', '2025-07-03 07:35:48', '2025-07-03 07:35:48'),
(6, 'Logistic', '2025-07-03 07:35:48', '2025-07-03 07:35:48'),
(7, 'Rubber', '2025-07-03 07:35:48', '2025-07-03 07:35:48'),
(8, 'Tooling', '2025-07-03 07:35:48', '2025-07-03 07:35:48');

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
-- Table structure for table `jadwal_verifikasi`
--

CREATE TABLE `jadwal_verifikasi` (
  `id` int(11) NOT NULL,
  `audit_id` int(11) UNSIGNED DEFAULT NULL,
  `tanggal_verifikasi` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, '0001_01_01_000001_create_cache_table', 2),
(4, '0001_01_01_000002_create_jobs_table', 2),
(5, '2025_07_09_164550_create_personal_access_tokens_table', 3),
(6, '2025_07_09_200547_update_type_column_in_notifications_table', 3),
(7, '2025_07_09_082533_create_notifications_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0ef40a8b-beb6-4d94-b0af-05cf7b446638', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\Admin', 1, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 14:24:07', '2025-07-09 14:24:07'),
('276dc771-f41d-4201-9371-c21e18cad412', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 12, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:27:42', '2025-07-09 13:27:42'),
('27ba4e99-f833-4064-92e4-bbbfb5aaf8b0', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 12, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 14:24:07', '2025-07-09 14:24:07'),
('2b5ddf32-95d8-4ac0-9a92-9eeea44977f4', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 10, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 14:24:07', '2025-07-09 14:24:07'),
('38ef08e5-0807-4b43-a362-779007089034', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 4, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', '2025-07-09 14:24:37', '2025-07-09 14:24:07', '2025-07-09 14:24:37'),
('43bd7053-88c6-4b5c-9757-395ae4934957', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 9, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 14:24:07', '2025-07-09 14:24:07'),
('53c212c5-df8c-4323-a22c-b48d96bd94ba', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 5, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 14:24:07', '2025-07-09 14:24:07'),
('594de45c-4662-4329-8f8e-ee6567cfa2f8', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 6, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 14:24:07', '2025-07-09 14:24:07'),
('5f3e96ba-fb86-4ad7-880f-6ebcaeee8164', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 5, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:27:42', '2025-07-09 13:27:42'),
('62d7b98c-23b6-47b0-aeba-4c4b4cccb4d1', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 10, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:27:42', '2025-07-09 13:27:42'),
('803b2fa2-d2da-4014-8b41-955083af94eb', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\Admin', 1, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:27:42', '2025-07-09 13:27:42'),
('81fc2b74-d739-4fc4-b5d3-b5c339e1a088', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 4, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:27:42', '2025-07-09 13:27:42'),
('831a82c2-37f7-4653-a60b-12713a8d109b', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 12, '{\"judul\":\"Jadwal Audit\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Audit 5S\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nAudit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].\\r\\nTema audit bulan ini adalah : [TEMA_AUDIT]\\r\\n\\r\\nMohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.\\r\\n\\r\\nTerima kasih atas kerja sama dan partisipasinya.\\r\\n\\r\\nSalam hormat,\\r\\nTim Audit 5S\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:22:06', '2025-07-09 13:22:06'),
('91d98d99-d547-437a-8245-205a18eda4b5', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 7, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:27:42', '2025-07-09 13:27:42'),
('932dddd3-1687-4457-8da6-9361f2c0abe3', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 9, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:27:42', '2025-07-09 13:27:42'),
('a50b6855-4f76-459c-b934-6adbce3936e3', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 5, '{\"judul\":\"Jadwal Audit\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Audit 5S\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nAudit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].\\r\\nTema audit bulan ini adalah : [TEMA_AUDIT]\\r\\n\\r\\nMohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.\\r\\n\\r\\nTerima kasih atas kerja sama dan partisipasinya.\\r\\n\\r\\nSalam hormat,\\r\\nTim Audit 5S\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:22:06', '2025-07-09 13:22:06'),
('b882b01c-7926-4fd0-8d15-48819663594b', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 8, '{\"judul\":\"Jadwal Audit\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Audit 5S\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nAudit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].\\r\\nTema audit bulan ini adalah : [TEMA_AUDIT]\\r\\n\\r\\nMohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.\\r\\n\\r\\nTerima kasih atas kerja sama dan partisipasinya.\\r\\n\\r\\nSalam hormat,\\r\\nTim Audit 5S\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:22:06', '2025-07-09 13:22:06'),
('b92df4e3-1d4e-4130-a4fd-85daf1c822f9', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 10, '{\"judul\":\"Jadwal Audit\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Audit 5S\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nAudit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].\\r\\nTema audit bulan ini adalah : [TEMA_AUDIT]\\r\\n\\r\\nMohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.\\r\\n\\r\\nTerima kasih atas kerja sama dan partisipasinya.\\r\\n\\r\\nSalam hormat,\\r\\nTim Audit 5S\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:22:06', '2025-07-09 13:22:06'),
('c5dad6f0-7f4e-4c43-9455-6f117efcff4b', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 6, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:27:42', '2025-07-09 13:27:42'),
('cb80cbaa-3196-4756-8f25-40ec67a39682', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 7, '{\"judul\":\"Jadwal Audit\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Audit 5S\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nAudit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].\\r\\nTema audit bulan ini adalah : [TEMA_AUDIT]\\r\\n\\r\\nMohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.\\r\\n\\r\\nTerima kasih atas kerja sama dan partisipasinya.\\r\\n\\r\\nSalam hormat,\\r\\nTim Audit 5S\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:22:06', '2025-07-09 13:22:06'),
('ccb8bb9e-42b5-448b-89e3-e7e6d2ff2440', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 4, '{\"judul\":\"Jadwal Audit\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Audit 5S\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nAudit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].\\r\\nTema audit bulan ini adalah : [TEMA_AUDIT]\\r\\n\\r\\nMohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.\\r\\n\\r\\nTerima kasih atas kerja sama dan partisipasinya.\\r\\n\\r\\nSalam hormat,\\r\\nTim Audit 5S\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', '2025-07-09 13:22:42', '2025-07-09 13:22:05', '2025-07-09 13:22:42'),
('e2371fc3-b2e7-4242-baba-5e743316afd3', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 9, '{\"judul\":\"Jadwal Audit\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Audit 5S\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nAudit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].\\r\\nTema audit bulan ini adalah : [TEMA_AUDIT]\\r\\n\\r\\nMohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.\\r\\n\\r\\nTerima kasih atas kerja sama dan partisipasinya.\\r\\n\\r\\nSalam hormat,\\r\\nTim Audit 5S\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:22:06', '2025-07-09 13:22:06'),
('e4461064-71e1-4ec5-8a24-4be4cea39e7f', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 8, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:27:42', '2025-07-09 13:27:42'),
('e98dded3-5346-4fde-800c-0aa368644a9b', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\Admin', 1, '{\"judul\":\"Jadwal Audit\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Audit 5S\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nAudit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].\\r\\nTema audit bulan ini adalah : [TEMA_AUDIT]\\r\\n\\r\\nMohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.\\r\\n\\r\\nTerima kasih atas kerja sama dan partisipasinya.\\r\\n\\r\\nSalam hormat,\\r\\nTim Audit 5S\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:22:06', '2025-07-09 13:22:06'),
('efb8aeed-a9ce-42fe-9783-f7c5b0910332', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 8, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 14:24:07', '2025-07-09 14:24:07'),
('f00fc016-5d9b-4b45-9f54-f4159a594a17', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 7, '{\"judul\":\"Pemberitahuan Umum\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Umum\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nBerikut informasi penting: [ISI_PESAN].\\r\\n\\r\\nMohon diperhatikan dan dilaksanakan sesuai instruksi.\\r\\n\\r\\nTerima kasih.\\r\\n\\r\\nSalam hormat,\\r\\nManajemen Audit\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 14:24:07', '2025-07-09 14:24:07'),
('f495e81c-f486-4d70-aeca-14965f84a155', 'App\\Notifications\\PesanNotifikasi', 'App\\Models\\User', 6, '{\"judul\":\"Jadwal Audit\",\"isi_pesan\":\"\\ud83d\\udce2 Pemberitahuan Audit 5S\\r\\n\\r\\nYth. Bapak\\/Ibu Auditor,\\r\\n\\r\\nAudit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].\\r\\nTema audit bulan ini adalah : [TEMA_AUDIT]\\r\\n\\r\\nMohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.\\r\\n\\r\\nTerima kasih atas kerja sama dan partisipasinya.\\r\\n\\r\\nSalam hormat,\\r\\nTim Audit 5S\",\"foto\":null,\"icon\":\"\\ud83d\\udce2\",\"warna\":\"yellow\"}', NULL, '2025-07-09 13:22:06', '2025-07-09 13:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('33Jhfp7vwjgFRE9CDxwxjbAwya57CTb2zIZoOGT2', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVkJNQ2liTExHZ0tyeWRwQVJaVmtzOFJGRzJWRThuSEJYWER4bUlWbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQ/YnVsYW5fYXVkaXQ9MjAyNS0wOCI7fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1752121954),
('DfHb6WpREckHAeQruTsrfegQQuqEXa8mfFBslWxL', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQ1J4WjB6T21ua0R6UEk2c3pZUWJVMkJGMHhleVlYY0pmaG01SDY4ZiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcHJvZmlsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1752132222);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `bagian_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `foto`, `password`, `bagian_id`, `created_at`, `updated_at`) VALUES
(4, 'Auditor Machining', 'machining@eas.co.id', NULL, '$2y$12$tg2vgHGHjrQ4vm2XBNMjoO6OzGgQyhy8u1a2A3Hq9urmE3cOAW8Zm', 3, '2025-07-03 01:04:52', '2025-07-04 02:33:42'),
(5, 'Auditor Rubber', 'rubber@eas.co.id', NULL, '$2y$12$6.iAxBNz6aLdwreV4z/wYuyiyXMk7i/Y7AaYvhfUCHC0GX.uBfeZG', 7, '2025-07-03 20:21:48', '2025-07-03 20:21:48'),
(6, 'Auditor Assembly', 'assembly@eas.co.id', NULL, '$2y$12$toJbWVYoEcOLkyV41Myy/O3vyuYo6lTquRhNdfTQFra0oV.DpTM4m', 2, '2025-07-09 06:28:05', '2025-07-09 06:28:05'),
(7, 'Auditor Stamping', 'stamping@eas.co.id', NULL, '$2y$12$Jis1Hd.Ih9NsDt/3dFVVYeKS6LKSa2M4iBMs8Wc0HIK2s.3XYr.sG', 4, '2025-07-09 06:28:38', '2025-07-09 06:28:38'),
(8, 'Auditor Injection', 'injection@eas.co.id', NULL, '$2y$12$CdDef7m9bB9CCCW.obu7t.FniwjGtP5CivsNqjR5PrERylcZFbR16', 5, '2025-07-09 06:29:17', '2025-07-09 06:29:17'),
(9, 'Auditor Logistic', 'logistic@eas.co.id', NULL, '$2y$12$W29DOtD0.WWvYTZm/cIFie/KFNusfrPs4yrR5v6iFNZeBCAvVRjSu', 6, '2025-07-09 06:30:06', '2025-07-09 06:30:06'),
(10, 'Auditor Tooling', 'tooling@eas.co.id', NULL, '$2y$12$4kHC4J6azxmxzmuLEZL.b.CWTd63H2pxwawfz4jB9J9NMHFSxYWaW', 8, '2025-07-09 06:31:04', '2025-07-09 06:31:04'),
(12, 'Auditor HRD-GA', 'hrd-ga@eas.co.id', NULL, '$2y$12$/Lr48UbrFADQUdYiB34.9O6o2ofqfbsLimK9clFRgrBKjZ4rn.cIO', 1, '2025-07-09 09:47:28', '2025-07-09 09:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `user_audit`
--

CREATE TABLE `user_audit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bagian_diaudit_id` int(11) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_audit` date DEFAULT NULL,
  `status` enum('belum_close','close') DEFAULT 'belum_close',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_audit_bagian` (`bagian_id`);

--
-- Indexes for table `bagian`
--
ALTER TABLE `bagian`
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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal_verifikasi`
--
ALTER TABLE `jadwal_verifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jadwal_audit` (`audit_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

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
  ADD KEY `sessions_user_id_index` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `bagian_id` (`bagian_id`);

--
-- Indexes for table `user_audit`
--
ALTER TABLE `user_audit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bagian_diaudit_id` (`bagian_diaudit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `bagian`
--
ALTER TABLE `bagian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_verifikasi`
--
ALTER TABLE `jadwal_verifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_audit`
--
ALTER TABLE `user_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit`
--
ALTER TABLE `audit`
  ADD CONSTRAINT `fk_audit_bagian` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jadwal_verifikasi`
--
ALTER TABLE `jadwal_verifikasi`
  ADD CONSTRAINT `fk_jadwal_audit` FOREIGN KEY (`audit_id`) REFERENCES `audit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_audit`
--
ALTER TABLE `user_audit`
  ADD CONSTRAINT `user_audit_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_audit_ibfk_2` FOREIGN KEY (`bagian_diaudit_id`) REFERENCES `bagian` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
