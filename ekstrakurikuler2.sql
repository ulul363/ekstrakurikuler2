-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 25, 2024 at 01:36 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ekstrakurikuler2`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id_chat` bigint UNSIGNED NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengirim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengajuan_pertemuan_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_anggota`
--

CREATE TABLE `daftar_anggota` (
  `id` bigint UNSIGNED NOT NULL,
  `ekstrakurikuler_id` bigint UNSIGNED NOT NULL,
  `nis` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekstrakurikuler`
--

CREATE TABLE `ekstrakurikuler` (
  `id_ekstrakurikuler` bigint UNSIGNED NOT NULL,
  `nama` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ekstrakurikuler`
--

CREATE TABLE `jadwal_ekstrakurikuler` (
  `id_jadwal_ekstrakurikuler` bigint UNSIGNED NOT NULL,
  `ekstrakurikuler_id` bigint UNSIGNED NOT NULL,
  `hari` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu` time NOT NULL,
  `lokasi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id_kehadiran` bigint UNSIGNED NOT NULL,
  `ekstrakurikuler_id` bigint UNSIGNED NOT NULL,
  `ketua_id` bigint UNSIGNED NOT NULL,
  `pembina_id` bigint UNSIGNED DEFAULT NULL,
  `nama_kegiatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran` int NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `berkas` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ketua`
--

CREATE TABLE `ketua` (
  `id_ketua` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ekstrakurikuler_id` bigint UNSIGNED NOT NULL,
  `nis` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_07_13_144821_create_permission_tables', 1),
(6, '2024_07_13_144850_create_ekstrakurikuler_table', 1),
(7, '2024_07_13_144910_create_pembina_table', 1),
(8, '2024_07_13_144930_create_ketua_table', 1),
(9, '2024_07_13_145000_create_jadwal_ekstrakurikuler_table', 1),
(10, '2024_07_13_152537_create_program_kegiatan_table', 1),
(11, '2024_07_13_235211_create_kehadiran_table', 1),
(12, '2024_07_14_001005_create_daftar_anggota_table', 1),
(13, '2024_07_14_001009_create_prestasi_table', 1),
(14, '2024_07_14_005646_create_pengajuan_pertemuan_table', 1),
(15, '2024_07_14_013636_create_chat_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembina`
--

CREATE TABLE `pembina` (
  `id_pembina` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ekstrakurikuler_id` bigint UNSIGNED NOT NULL,
  `nip` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_pertemuan`
--

CREATE TABLE `pengajuan_pertemuan` (
  `id_pengajuan_pertemuan` bigint UNSIGNED NOT NULL,
  `ketua_id` bigint UNSIGNED NOT NULL,
  `pembina_id` bigint UNSIGNED NOT NULL,
  `verifikasi_id` bigint UNSIGNED DEFAULT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `waktu_verifikasi` datetime DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'user.index', 'web', '2024-08-25 06:34:25', '2024-08-25 06:34:25'),
(2, 'user.create', 'web', '2024-08-25 06:34:25', '2024-08-25 06:34:25'),
(3, 'user.store', 'web', '2024-08-25 06:34:25', '2024-08-25 06:34:25'),
(4, 'user.edit', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(5, 'user.update', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(6, 'user.destroy', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(7, 'role.index', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(8, 'role.create', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(9, 'role.store', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(10, 'role.edit', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(11, 'role.update', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(12, 'role.destroy', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(13, 'role.getRoutesAllJson', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(14, 'role.getRefreshAndDeleteJson', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(15, 'dashboard', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(16, 'pembina.index', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(17, 'pembina.create', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(18, 'pembina.store', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(19, 'pembina.edit', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(20, 'pembina.update', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(21, 'pembina.destroy', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(22, 'pembina.createuser', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(23, 'pembina.storeuser', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(24, 'pembina.updateUser', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(25, 'ketua.index', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(26, 'ketua.create', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(27, 'ketua.store', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(28, 'ketua.edit', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(29, 'ketua.update', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(30, 'ketua.destroy', 'web', '2024-08-25 06:34:26', '2024-08-25 06:34:26'),
(31, 'ketua.createuser', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(32, 'ketua.storeuser', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(33, 'ketua.updateUser', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(34, 'ekstrakurikuler.index', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(35, 'ekstrakurikuler.create', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(36, 'ekstrakurikuler.store', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(37, 'ekstrakurikuler.edit', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(38, 'ekstrakurikuler.update', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(39, 'ekstrakurikuler.destroy', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(40, 'jadwal_ekstrakurikuler.index', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(41, 'jadwal_ekstrakurikuler.create', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(42, 'jadwal_ekstrakurikuler.store', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(43, 'jadwal_ekstrakurikuler.edit', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(44, 'jadwal_ekstrakurikuler.update', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(45, 'jadwal_ekstrakurikuler.destroy', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(46, 'laporan.index', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(47, 'laporan.exportPDF', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(48, 'program_kegiatan.index', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(49, 'program_kegiatan.create', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(50, 'program_kegiatan.store', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(51, 'program_kegiatan.edit', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(52, 'program_kegiatan.update', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(53, 'program_kegiatan.destroy', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(54, 'program_kegiatan.show', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(55, 'kehadiran.index', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(56, 'kehadiran.create', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(57, 'kehadiran.store', 'web', '2024-08-25 06:34:27', '2024-08-25 06:34:27'),
(58, 'kehadiran.edit', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(59, 'kehadiran.update', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(60, 'kehadiran.destroy', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(61, 'kehadiran.show', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(62, 'prestasi.index', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(63, 'prestasi.create', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(64, 'prestasi.store', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(65, 'prestasi.edit', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(66, 'prestasi.update', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(67, 'prestasi.destroy', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(68, 'prestasi.show', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(69, 'pertemuan.index', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(70, 'pertemuan.create', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(71, 'pertemuan.store', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(72, 'pertemuan.edit', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(73, 'pertemuan.update', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(74, 'pertemuan.destroy', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(75, 'pertemuan.show', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(76, 'chat.show', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(77, 'chat.store', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(78, 'daftaranggota.index', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(79, 'daftaranggota.create', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(80, 'daftaranggota.store', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(81, 'daftaranggota.edit', 'web', '2024-08-25 06:34:28', '2024-08-25 06:34:28'),
(82, 'daftaranggota.update', 'web', '2024-08-25 06:34:29', '2024-08-25 06:34:29'),
(83, 'daftaranggota.destroy', 'web', '2024-08-25 06:34:29', '2024-08-25 06:34:29'),
(84, 'daftaranggota.show', 'web', '2024-08-25 06:34:29', '2024-08-25 06:34:29'),
(85, 'program_kegiatan.verifikasi', 'web', '2024-08-25 06:34:29', '2024-08-25 06:34:29'),
(86, 'kehadiran.verifikasi', 'web', '2024-08-25 06:34:29', '2024-08-25 06:34:29'),
(87, 'prestasi.verifikasi', 'web', '2024-08-25 06:34:29', '2024-08-25 06:34:29'),
(88, 'pertemuan.verifikasi', 'web', '2024-08-25 06:34:29', '2024-08-25 06:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id_prestasi` bigint UNSIGNED NOT NULL,
  `ekstrakurikuler_id` bigint UNSIGNED NOT NULL,
  `ketua_id` bigint UNSIGNED NOT NULL,
  `pembina_id` bigint UNSIGNED DEFAULT NULL,
  `prestasi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_siswa` json NOT NULL,
  `kelas` json NOT NULL,
  `tahun_ajaran` int NOT NULL,
  `berkas` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_kegiatan`
--

CREATE TABLE `program_kegiatan` (
  `id_program_kegiatan` bigint UNSIGNED NOT NULL,
  `ekstrakurikuler_id` bigint UNSIGNED NOT NULL,
  `ketua_id` bigint UNSIGNED NOT NULL,
  `pembina_id` bigint UNSIGNED DEFAULT NULL,
  `nama_program` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran` int NOT NULL,
  `deskripsi` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2024-08-25 06:34:29', '2024-08-25 06:34:29'),
(2, 'Ketua', 'web', '2024-08-25 06:34:32', '2024-08-25 06:34:32'),
(3, 'Pembina', 'web', '2024-08-25 06:34:34', '2024-08-25 06:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
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
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(15, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(15, 3),
(48, 3),
(50, 3),
(54, 3),
(55, 3),
(57, 3),
(61, 3),
(62, 3),
(64, 3),
(68, 3),
(69, 3),
(71, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(80, 3),
(84, 3),
(85, 3),
(86, 3),
(87, 3),
(88, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', NULL, '$2y$12$ycKweNIxwEGuBqEnSLg9vu0w5azzt6j//BU9Xd.vQE3AGDO.8WUnC', NULL, '2024-08-25 06:34:32', '2024-08-25 06:34:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `chat_pengajuan_pertemuan_id_foreign` (`pengajuan_pertemuan_id`);

--
-- Indexes for table `daftar_anggota`
--
ALTER TABLE `daftar_anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daftar_anggota_ekstrakurikuler_id_foreign` (`ekstrakurikuler_id`);

--
-- Indexes for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  ADD PRIMARY KEY (`id_ekstrakurikuler`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal_ekstrakurikuler`
--
ALTER TABLE `jadwal_ekstrakurikuler`
  ADD PRIMARY KEY (`id_jadwal_ekstrakurikuler`),
  ADD KEY `jadwal_ekstrakurikuler_ekstrakurikuler_id_foreign` (`ekstrakurikuler_id`);

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id_kehadiran`),
  ADD KEY `kehadiran_ekstrakurikuler_id_foreign` (`ekstrakurikuler_id`),
  ADD KEY `kehadiran_ketua_id_foreign` (`ketua_id`),
  ADD KEY `kehadiran_pembina_id_foreign` (`pembina_id`);

--
-- Indexes for table `ketua`
--
ALTER TABLE `ketua`
  ADD PRIMARY KEY (`id_ketua`),
  ADD UNIQUE KEY `ketua_nis_unique` (`nis`),
  ADD KEY `ketua_user_id_foreign` (`user_id`),
  ADD KEY `ketua_ekstrakurikuler_id_foreign` (`ekstrakurikuler_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembina`
--
ALTER TABLE `pembina`
  ADD PRIMARY KEY (`id_pembina`),
  ADD UNIQUE KEY `pembina_nip_unique` (`nip`),
  ADD KEY `pembina_user_id_foreign` (`user_id`),
  ADD KEY `pembina_ekstrakurikuler_id_foreign` (`ekstrakurikuler_id`);

--
-- Indexes for table `pengajuan_pertemuan`
--
ALTER TABLE `pengajuan_pertemuan`
  ADD PRIMARY KEY (`id_pengajuan_pertemuan`),
  ADD KEY `pengajuan_pertemuan_pembina_id_foreign` (`pembina_id`),
  ADD KEY `pengajuan_pertemuan_ketua_id_foreign` (`ketua_id`),
  ADD KEY `pengajuan_pertemuan_verifikasi_id_foreign` (`verifikasi_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id_prestasi`),
  ADD KEY `prestasi_ekstrakurikuler_id_foreign` (`ekstrakurikuler_id`),
  ADD KEY `prestasi_ketua_id_foreign` (`ketua_id`),
  ADD KEY `prestasi_pembina_id_foreign` (`pembina_id`);

--
-- Indexes for table `program_kegiatan`
--
ALTER TABLE `program_kegiatan`
  ADD PRIMARY KEY (`id_program_kegiatan`),
  ADD KEY `program_kegiatan_ekstrakurikuler_id_foreign` (`ekstrakurikuler_id`),
  ADD KEY `program_kegiatan_ketua_id_foreign` (`ketua_id`),
  ADD KEY `program_kegiatan_pembina_id_foreign` (`pembina_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

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
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daftar_anggota`
--
ALTER TABLE `daftar_anggota`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  MODIFY `id_ekstrakurikuler` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_ekstrakurikuler`
--
ALTER TABLE `jadwal_ekstrakurikuler`
  MODIFY `id_jadwal_ekstrakurikuler` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id_kehadiran` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ketua`
--
ALTER TABLE `ketua`
  MODIFY `id_ketua` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pembina`
--
ALTER TABLE `pembina`
  MODIFY `id_pembina` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_pertemuan`
--
ALTER TABLE `pengajuan_pertemuan`
  MODIFY `id_pengajuan_pertemuan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id_prestasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program_kegiatan`
--
ALTER TABLE `program_kegiatan`
  MODIFY `id_program_kegiatan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_pengajuan_pertemuan_id_foreign` FOREIGN KEY (`pengajuan_pertemuan_id`) REFERENCES `pengajuan_pertemuan` (`id_pengajuan_pertemuan`);

--
-- Constraints for table `daftar_anggota`
--
ALTER TABLE `daftar_anggota`
  ADD CONSTRAINT `daftar_anggota_ekstrakurikuler_id_foreign` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `jadwal_ekstrakurikuler`
--
ALTER TABLE `jadwal_ekstrakurikuler`
  ADD CONSTRAINT `jadwal_ekstrakurikuler_ekstrakurikuler_id_foreign` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_ekstrakurikuler_id_foreign` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `kehadiran_ketua_id_foreign` FOREIGN KEY (`ketua_id`) REFERENCES `ketua` (`id_ketua`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `kehadiran_pembina_id_foreign` FOREIGN KEY (`pembina_id`) REFERENCES `pembina` (`id_pembina`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ketua`
--
ALTER TABLE `ketua`
  ADD CONSTRAINT `ketua_ekstrakurikuler_id_foreign` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ketua_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `pembina`
--
ALTER TABLE `pembina`
  ADD CONSTRAINT `pembina_ekstrakurikuler_id_foreign` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pembina_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengajuan_pertemuan`
--
ALTER TABLE `pengajuan_pertemuan`
  ADD CONSTRAINT `pengajuan_pertemuan_ketua_id_foreign` FOREIGN KEY (`ketua_id`) REFERENCES `ketua` (`id_ketua`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pengajuan_pertemuan_pembina_id_foreign` FOREIGN KEY (`pembina_id`) REFERENCES `pembina` (`id_pembina`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `pengajuan_pertemuan_verifikasi_id_foreign` FOREIGN KEY (`verifikasi_id`) REFERENCES `pembina` (`id_pembina`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD CONSTRAINT `prestasi_ekstrakurikuler_id_foreign` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prestasi_ketua_id_foreign` FOREIGN KEY (`ketua_id`) REFERENCES `ketua` (`id_ketua`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prestasi_pembina_id_foreign` FOREIGN KEY (`pembina_id`) REFERENCES `pembina` (`id_pembina`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `program_kegiatan`
--
ALTER TABLE `program_kegiatan`
  ADD CONSTRAINT `program_kegiatan_ekstrakurikuler_id_foreign` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `program_kegiatan_ketua_id_foreign` FOREIGN KEY (`ketua_id`) REFERENCES `ketua` (`id_ketua`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `program_kegiatan_pembina_id_foreign` FOREIGN KEY (`pembina_id`) REFERENCES `pembina` (`id_pembina`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
