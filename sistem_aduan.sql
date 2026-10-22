-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2026 at 12:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_aduan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918');

-- --------------------------------------------------------

--
-- Table structure for table `aduan`
--

CREATE TABLE `aduan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jenis_aduan` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_aduan` date NOT NULL,
  `lokasi_aduan` varchar(100) NOT NULL,
  `file_pendukung` varchar(255) DEFAULT NULL,
  `status` enum('Diajukan','Diproses','Selesai') DEFAULT 'Diajukan',
  `catatan_admin` text DEFAULT NULL,
  `notifikasi` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aduan`
--

INSERT INTO `aduan` (`id`, `nama`, `email`, `jenis_aduan`, `deskripsi`, `tanggal_aduan`, `lokasi_aduan`, `file_pendukung`, `status`, `catatan_admin`, `notifikasi`) VALUES
(52, 'Cici', 'cinctaarmadhani@gmail.com', 'Parkir Liar', 'Gilaaaa sembarangan cuy markiirnya', '2025-02-27', 'Jl. Kembang Jambe', 'uploads/screencapture-localhost-dishub-aduan-parkir-liar-admin-dashboard-php-2025-03-12-09_28_24.png', 'Selesai', NULL, 0),
(53, 'Intan', 'intansuciramadhanipk@gmail.com', 'Juru Parkir Ilegal', 'gak dikasi karcis, mana mahal banget', '2025-02-28', 'Pecinan', 'uploads/screencapture-localhost-dishub-aduan-parkir-liar-admin-dashboard-php-2025-03-12-09_28_24.png', 'Diproses', NULL, 0),
(54, 'Bambang', 'bambang@gmail.com', 'Tarif Parkir Tidak Sesuai', 'Pak tolong dong, jukir disini ngambil 5k. gada karcisnya', '2025-03-05', 'Pecinan', 'uploads/screencapture-localhost-dishub-aduan-parkir-liar-admin-dashboard-php-2025-03-12-09_28_24.png', 'Diproses', NULL, 0),
(55, 'Indah', 'yjg77512@gmail.com', 'Tarif Parkir Tidak Sesuai', 'gak jelas jukirnya', '2025-03-05', 'Dekat Banplaz', 'uploads/screencapture-localhost-dishub-aduan-parkir-liar-admin-dashboard-php-2025-03-12-09_28_24.png', 'Diajukan', NULL, 0),
(56, 'Cici', 'cinctaarmadhani@gmail.com', 'Parkir Mengganggu Jalan', 'Kocakk', '2025-03-06', 'Jl. Muria', 'uploads/screencapture-localhost-dishub-aduan-parkir-liar-admin-dashboard-php-2025-03-12-09_28_24.png', 'Diajukan', NULL, 0),
(57, 'Cici', 'bambang@gmail.com', 'Parkir di Trotoar', ' kocak', '2025-03-13', 'jl. kelapa gading', '', 'Diajukan', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `aduan_progress`
--

CREATE TABLE `aduan_progress` (
  `id` int(11) NOT NULL,
  `aduan_id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `deskripsi_progres` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aduan_progress`
--

INSERT INTO `aduan_progress` (`id`, `aduan_id`, `tanggal`, `deskripsi_progres`) VALUES
(8, 52, '2025-03-12 09:56:45', ' Aduan Diterima'),
(9, 52, '2025-03-12 09:57:09', 'Petugas Dikirim ke Lokasi'),
(10, 52, '2025-03-12 09:57:32', 'Kendaraan yang parkir sembarangan telah ditindak sesuai aturan.'),
(11, 52, '2025-03-12 09:57:48', 'Permasalahan telah diselesaikan dan lokasi kembali tertib.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `aduan`
--
ALTER TABLE `aduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aduan_progress`
--
ALTER TABLE `aduan_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aduan_id` (`aduan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `aduan`
--
ALTER TABLE `aduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `aduan_progress`
--
ALTER TABLE `aduan_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aduan_progress`
--
ALTER TABLE `aduan_progress`
  ADD CONSTRAINT `aduan_progress_ibfk_1` FOREIGN KEY (`aduan_id`) REFERENCES `aduan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
