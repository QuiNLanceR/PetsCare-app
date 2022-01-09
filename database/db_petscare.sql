-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2022 at 04:07 AM
-- Server version: 5.7.33
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_petscare`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id_absen` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `tgl_absen` date NOT NULL,
  `kehadiran` enum('y','t') NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensis`
--

INSERT INTO `absensis` (`id_absen`, `id_dokter`, `tgl_absen`, `kehadiran`, `jam_masuk`, `jam_keluar`, `created_at`, `updated_at`) VALUES
(7, 1, '2022-01-03', 'y', '23:20:00', '23:21:00', '2022-01-03 16:20:33', '2022-01-03 16:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `nm_admin` varchar(100) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `tmp_lah_admin` varchar(100) DEFAULT NULL,
  `tgl_lah_admin` date DEFAULT NULL,
  `jen_kel_admin` enum('l','p') DEFAULT NULL,
  `no_hp_admin` varchar(13) DEFAULT NULL,
  `photo_admin` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `nm_admin`, `email_admin`, `username`, `tmp_lah_admin`, `tgl_lah_admin`, `jen_kel_admin`, `no_hp_admin`, `photo_admin`, `created_at`, `updated_at`) VALUES
(1, 'Imbar Umbara', 'imbar204@gmail.com', 'imbar', 'Subang', '1998-01-30', 'l', '8124124125', '20211231072723.png', NULL, '2022-01-01 18:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `data_kontrols`
--

CREATE TABLE `data_kontrols` (
  `id_kontrols` int(11) NOT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `tgl_kontrol` date DEFAULT NULL,
  `tindakan_kontrol` text,
  `st_kontrol` enum('1','2') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_kontrols`
--

INSERT INTO `data_kontrols` (`id_kontrols`, `id_pemeriksaan`, `tgl_kontrol`, `tindakan_kontrol`, `st_kontrol`, `created_at`, `updated_at`) VALUES
(5, 1, '2022-01-10', 'melakukan perban kembali', '2', '2022-01-03 16:33:00', '2022-01-03 16:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemeriksaans`
--

CREATE TABLE `detail_pemeriksaans` (
  `id_pemeriksaan` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `dosis_obat` varchar(50) DEFAULT NULL,
  `jml_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dokters`
--

CREATE TABLE `dokters` (
  `id_dokter` int(11) NOT NULL,
  `email_dokter` varchar(100) NOT NULL,
  `nm_dokter` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `tmp_lah_dokter` varchar(50) NOT NULL,
  `tgl_lah_dokter` date NOT NULL,
  `jen_kel_dokter` enum('l','p') NOT NULL,
  `no_hp_dokter` varchar(13) DEFAULT NULL,
  `photo_dokter` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dokters`
--

INSERT INTO `dokters` (`id_dokter`, `email_dokter`, `nm_dokter`, `username`, `tmp_lah_dokter`, `tgl_lah_dokter`, `jen_kel_dokter`, `no_hp_dokter`, `photo_dokter`, `created_at`, `updated_at`) VALUES
(1, 'wilda@gmail.com', 'Wilda Irma', 'wilda', 'karawang', '1998-11-17', 'p', '8888881231', '20211231124619.png', '2021-12-28 07:22:24', '2022-01-03 16:19:11'),
(2, 'test@email.com', 'nicholas', 'nicholas', 'test', '2022-01-01', 'l', '7412421', NULL, '2022-01-03 16:15:47', '2022-01-03 16:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_dokters`
--

CREATE TABLE `jadwal_dokters` (
  `id_jadwal` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `senin` enum('t','f') NOT NULL,
  `selasa` enum('t','f') NOT NULL,
  `rabu` enum('t','f') NOT NULL,
  `kamis` enum('t','f') NOT NULL,
  `jumat` enum('t','f') NOT NULL,
  `ket_jadwal` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal_dokters`
--

INSERT INTO `jadwal_dokters` (`id_jadwal`, `id_dokter`, `senin`, `selasa`, `rabu`, `kamis`, `jumat`, `ket_jadwal`, `created_at`, `updated_at`) VALUES
(3, 1, 't', 't', 'f', 'f', 'f', 'Test aja', '2022-01-03 16:16:41', '2022-01-03 16:16:55');

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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pasiens`
--

CREATE TABLE `pasiens` (
  `nik_pasien` varchar(50) NOT NULL,
  `nm_pasien` varchar(100) NOT NULL,
  `email_pasien` varchar(100) NOT NULL,
  `tmp_lah_pasien` varchar(50) DEFAULT NULL,
  `tgl_lah_pasien` date DEFAULT NULL,
  `alamat_pasien` text,
  `no_hp_pasien` varchar(13) DEFAULT NULL,
  `jen_kel_pasien` enum('l','p') NOT NULL,
  `photo_pasien` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasiens`
--

INSERT INTO `pasiens` (`nik_pasien`, `nm_pasien`, `email_pasien`, `tmp_lah_pasien`, `tgl_lah_pasien`, `alamat_pasien`, `no_hp_pasien`, `jen_kel_pasien`, `photo_pasien`, `created_at`, `updated_at`) VALUES
('123456', 'Evi Maesyari', 'evi@gmail.com', 'Karawang', '1997-01-23', 'test 41242', '821391274124', 'p', '20220103232843.png', '2022-01-03 16:12:35', '2022-01-03 16:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('imbar204@gmail.com', '$2y$10$Tc0ME6TnuY/dFXzjHOO/Xezz.EQQbYpLyjabEdy5qKYafVFqytFje', '2021-12-25 09:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id_pembayaran` varchar(20) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_pemeriksaan` int(11) NOT NULL,
  `uang_bayar` int(11) DEFAULT NULL,
  `uang_kembalian` int(11) DEFAULT NULL,
  `tgl_pembayaran` date DEFAULT NULL,
  `photo_pembayaran` varchar(255) DEFAULT NULL,
  `ket_pembayaran` text,
  `st_pembayaran` enum('1','2','3') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayarans`
--

INSERT INTO `pembayarans` (`id_pembayaran`, `id_admin`, `id_pemeriksaan`, `uang_bayar`, `uang_kembalian`, `tgl_pembayaran`, `photo_pembayaran`, `ket_pembayaran`, `st_pembayaran`, `created_at`, `updated_at`) VALUES
('PMB/1/2022/0001', 1, 1, 15000, 5000, '2022-01-03', '20220103233408.png', 'tasdwijaijdw', '3', '2022-01-03 16:33:00', '2022-01-03 16:35:22'),
('PMB/1/2022/0002', NULL, 1, NULL, NULL, NULL, NULL, NULL, '1', '2022-01-03 16:42:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaans`
--

CREATE TABLE `pemeriksaans` (
  `id_pemeriksaan` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `tgl_pemeriksaan` date NOT NULL,
  `diagnosis_pemeriksaan` text NOT NULL,
  `tindakan_pemeriksaan` text NOT NULL,
  `harga_pemeriksaan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemeriksaans`
--

INSERT INTO `pemeriksaans` (`id_pemeriksaan`, `id_dokter`, `id_pendaftaran`, `tgl_pemeriksaan`, `diagnosis_pemeriksaan`, `tindakan_pemeriksaan`, `harga_pemeriksaan`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '2022-01-03', 'tulang patah', 'dilakukan pembalutan perban', 10000, '2022-01-03 16:33:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftarans`
--

CREATE TABLE `pendaftarans` (
  `id_pendaftaran` int(11) NOT NULL,
  `nik_pasien` varchar(50) NOT NULL,
  `tgl_pendaftaran` date NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `keluhan` text NOT NULL,
  `nm_hewan` varchar(100) DEFAULT NULL,
  `jenis_hewan` varchar(25) DEFAULT NULL,
  `st_pendaftarans` enum('1','2','3') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pendaftarans`
--

INSERT INTO `pendaftarans` (`id_pendaftaran`, `nik_pasien`, `tgl_pendaftaran`, `no_antrian`, `keluhan`, `nm_hewan`, `jenis_hewan`, `st_pendaftarans`, `created_at`, `updated_at`) VALUES
(6, '123456', '2022-01-03', 1, 'tidak bisa jalan', 'Blacky', 'Anjing', '3', '2022-01-03 16:30:05', '2022-01-03 16:35:22'),
(7, '123456', '2022-01-03', 1, 'mual2', 'Catty', 'Kucing', '3', '2022-01-03 16:37:35', '2022-01-03 16:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resep_obats`
--

CREATE TABLE `resep_obats` (
  `id_obat` int(11) NOT NULL,
  `nm_obat` varchar(100) NOT NULL,
  `harga_obat` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resep_obats`
--

INSERT INTO `resep_obats` (`id_obat`, `nm_obat`, `harga_obat`, `created_at`, `updated_at`) VALUES
(4, 'Fludoxina', 15000, '2022-01-03 16:24:40', '2022-01-03 16:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `rujukans`
--

CREATE TABLE `rujukans` (
  `id_rujukan` varchar(20) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `lok_tujuan` varchar(50) NOT NULL,
  `alamat_tujuan` text NOT NULL,
  `ket_rujukan` text NOT NULL,
  `tgl_rujukan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rujukans`
--

INSERT INTO `rujukans` (`id_rujukan`, `id_pendaftaran`, `lok_tujuan`, `alamat_tujuan`, `ket_rujukan`, `tgl_rujukan`, `created_at`, `updated_at`) VALUES
('TRF/1/2022/0001', 7, 'puskeswan kalibata', 'test 4124124', 'Penyakit tidak dapat kami tangani', '2022-01-03', '2022-01-03 16:38:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','pasien','dokter','') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Imbar Umbara', 'imbar', 'imbar204@gmail.com', 'admin', NULL, '$2y$10$QuCDSGKnCPvdgJSJjsnHZOZr0HOo/YEe9A6cKi7SMNQGxZwW3tpXC', 'EhhNGOHKIiaQclTJGi61S8TqmklTthROa4PNrVekZU1AVuE9BpuCTQWtRp0X', NULL, '2022-01-01 18:58:26'),
(3, 'Wilda Irma', 'wilda', 'wilda@gmail.com', 'dokter', NULL, '$2y$10$ze7lEqw9P/Udhm/oX3BmGOPrCcRjNPcsDCRVIcX1JTNOUWzMNBiuG', NULL, NULL, '2022-01-03 16:19:11'),
(25, 'Evi Maesyari', '123456', 'evi@gmail.com', 'pasien', NULL, '$2y$10$5YvIhiBLYMziayjYnAmky.AhUUV6LqFbjJgsUzk0j8xkeVbSv64Oy', NULL, '2022-01-03 16:12:35', '2022-01-03 16:28:43'),
(26, 'nicholas', 'nicholas', 'test@email.com', 'dokter', NULL, '$2y$10$7FFT4COGOUrUX2yciPJOLOM1fV6mH1QAF2KH/9l50lwyFjmuVJpIS', NULL, '2022-01-03 16:15:47', '2022-01-03 16:15:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email_admin` (`email_admin`),
  ADD UNIQUE KEY `admins_un` (`username`);

--
-- Indexes for table `data_kontrols`
--
ALTER TABLE `data_kontrols`
  ADD PRIMARY KEY (`id_kontrols`);

--
-- Indexes for table `dokters`
--
ALTER TABLE `dokters`
  ADD PRIMARY KEY (`id_dokter`),
  ADD UNIQUE KEY `email_dokter` (`email_dokter`),
  ADD UNIQUE KEY `dokters_un` (`username`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal_dokters`
--
ALTER TABLE `jadwal_dokters`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasiens`
--
ALTER TABLE `pasiens`
  ADD PRIMARY KEY (`nik_pasien`),
  ADD UNIQUE KEY `pasiens_un` (`email_pasien`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `pemeriksaans`
--
ALTER TABLE `pemeriksaans`
  ADD PRIMARY KEY (`id_pemeriksaan`);

--
-- Indexes for table `pendaftarans`
--
ALTER TABLE `pendaftarans`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `resep_obats`
--
ALTER TABLE `resep_obats`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `rujukans`
--
ALTER TABLE `rujukans`
  ADD PRIMARY KEY (`id_rujukan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_un` (`username`),
  ADD UNIQUE KEY `users_un2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_kontrols`
--
ALTER TABLE `data_kontrols`
  MODIFY `id_kontrols` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dokters`
--
ALTER TABLE `dokters`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_dokters`
--
ALTER TABLE `jadwal_dokters`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pemeriksaans`
--
ALTER TABLE `pemeriksaans`
  MODIFY `id_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pendaftarans`
--
ALTER TABLE `pendaftarans`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resep_obats`
--
ALTER TABLE `resep_obats`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
