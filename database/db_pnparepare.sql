-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2025 at 02:14 AM
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
-- Database: `db_pnparepare`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'adminpn', '12345', 'Admin PN Parepare');

-- --------------------------------------------------------

--
-- Table structure for table `berkas`
--

CREATE TABLE `berkas` (
  `id` int NOT NULL,
  `id_pendaftaran` int NOT NULL,
  `jenis_berkas` enum('foto','surat') NOT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `tanggal_upload` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int NOT NULL,
  `kategori` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text,
  `sekolah` varchar(100) DEFAULT NULL,
  `nisn` varchar(30) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `institusi` varchar(100) DEFAULT NULL,
  `nim` varchar(30) DEFAULT NULL,
  `prodi` varchar(50) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `surat` varchar(255) DEFAULT NULL,
  `tanggal_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `surat_stored` varchar(255) DEFAULT NULL,
  `surat_original` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `kategori`, `nama`, `email`, `telepon`, `alamat`, `sekolah`, `nisn`, `jurusan`, `kelas`, `institusi`, `nim`, `prodi`, `semester`, `tanggal_mulai`, `tanggal_selesai`, `foto`, `surat`, `tanggal_daftar`, `surat_stored`, `surat_original`, `status`) VALUES
(1, 'siswa', 'alghazali', 'alghazali.123@gmail.com', '085242850505', 'jl. a.r. malaka', 'sd bina insan', '1122334455', 'multimedia', 'XI', '', '', '', '', '2025-11-06', '2025-11-30', '6906d504e2148_Hijau Kuning Modern Islami Ucapan Hari Santri Instagram Post (1).png', '6906d504e22fd_SURAT PERMOHONAN MAGANG.pdf', '2025-11-02 03:50:28', NULL, NULL, 'Ditolak'),
(2, 'mahasiswa', 'ucu', 'ucupakbal321@gmail.com', '1234567890', 'jl. ratulangi', '', '', '', '', 'unhas', '123456', 'agribisnis', '7', '2025-11-03', '2025-11-30', '6908128d97187_Picapica-photostrip (4).jpg', '6908128d97193_KRS_20251_221011040_SAPHIRA NUR MALIKA.pdf', '2025-11-03 02:25:17', NULL, NULL, 'Ditolak'),
(3, 'mahasiswa', 'ghazali', 'ghazali.123@gmail.com', '741258963', 'Jl. Reformasi No. 7C', '', '', '', '', 'Universitas Hasanuddin', '36985214', 'Hukum', '5', '2025-11-24', '2025-12-24', '6923aac8be701_BUKTI PENDAFTARAN.jpeg', '6923aac8be8af_SURAT MASUK KISRA.pdf', '2025-11-24 00:46:00', NULL, NULL, 'Diterima'),
(4, 'siswa', 'nada', 'nada.321@gmail.com', '0987654321', 'Jl. Cendrawasih', 'SMK 2 Parepare', '9963255', 'RPL', 'XII', '', '', '', '', '2025-11-06', '2025-12-27', '6923ba90bbf41_WhatsApp Image 2025-11-07 at 10.31.30_e92de3c9 (2).jpg', '6923ba90bbf50_SURAT MASUK MAPERWA.pdf', '2025-11-24 01:53:20', NULL, NULL, 'Diterima');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int NOT NULL,
  `kategori` enum('siswa','mahasiswa') NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `sekolah` varchar(100) DEFAULT NULL,
  `nisn` varchar(30) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `institusi` varchar(100) DEFAULT NULL,
  `nim` varchar(30) DEFAULT NULL,
  `prodi` varchar(100) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tanggal_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi`
--

CREATE TABLE `verifikasi` (
  `id` int NOT NULL,
  `id_pendaftaran` int DEFAULT NULL,
  `status` enum('Menunggu','Diterima','Ditolak') DEFAULT 'Menunggu',
  `catatan` text,
  `tanggal_verifikasi` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verifikasi`
--
ALTER TABLE `verifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `berkas`
--
ALTER TABLE `berkas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verifikasi`
--
ALTER TABLE `verifikasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berkas`
--
ALTER TABLE `berkas`
  ADD CONSTRAINT `berkas_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verifikasi`
--
ALTER TABLE `verifikasi`
  ADD CONSTRAINT `verifikasi_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
