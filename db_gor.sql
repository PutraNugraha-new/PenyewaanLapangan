-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2024 at 09:10 AM
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
-- Database: `db_gor`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_login` varchar(100) DEFAULT NULL,
  `role` enum('admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama`, `username`, `password`, `last_login`, `role`) VALUES
(6, 'admin', 'admin', 'sha256:1000:GPfopQiZrkXXqJLB8ecINQaCZFS0XxCa:oFPFKyQ2bId8+x2VQRNippwbD3ZlH9Co', '2024-03-08', 'admin'),
(7, 'puutra', 'putra', 'sha256:1000:I23AHwq7mPLS+vMG9H/uwWZ6+eHcsblh:sD4T+4iGqiac1sgfeeXk47o5t8wOabBE', '2024-03-06', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detailpemesanan`
--

CREATE TABLE `tb_detailpemesanan` (
  `id_detail` int NOT NULL,
  `kode_pemesanan` int DEFAULT NULL,
  `jam_dipesan` varchar(100) DEFAULT NULL,
  `tgl_main` varchar(50) DEFAULT NULL,
  `no_lapangan` int DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_detailpemesanan`
--

INSERT INTO `tb_detailpemesanan` (`id_detail`, `kode_pemesanan`, `jam_dipesan`, `tgl_main`, `no_lapangan`, `status`) VALUES
(8, 12, '8-9', '2024-03-07', 1, 'proses'),
(9, 12, '10-11', '2024-03-07', 1, 'proses'),
(10, 13, '18-19', '2024-03-07', 2, 'disewa'),
(11, 14, '16-17', '2024-03-08', 2, 'selesai'),
(12, 14, '17-18', '2024-03-08', 2, 'selesai'),
(13, 15, '18-19', '2024-03-08', 2, 'disewa'),
(14, 16, '16-17', '2024-03-08', 1, 'disewa'),
(15, 16, '17-18', '2024-03-08', 1, 'disewa'),
(16, 18, '18-19', '2024-03-09', 3, 'proses'),
(17, 18, '19-20', '2024-03-09', 3, 'proses');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` int NOT NULL,
  `nama_pelanggan` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `level` enum('user') DEFAULT NULL,
  `last_login` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `nama_pelanggan`, `username`, `tanggal_lahir`, `jenis_kelamin`, `no_hp`, `email`, `password`, `level`, `last_login`) VALUES
(4, 'putra nugraha', 'putra', '2024-03-06', 'Laki-Laki', '081351678870', 'admin@gmail.com', 'sha256:1000:N4KpG32IajUc43mynbUDXT2grbPXHM5F:RbJjqPsjtNS0tyFaw1OF/Hfo1r/jOK0x', 'user', '2024-03-09'),
(5, 'putra', 'nugraha', '2024-03-06', 'Perempuan', '08138128714', 'pnugraha501@gmail.com', 'sha256:1000:u5hTg38vAtnViwoQEcytIi20aOqyM2DZ:O70h0s+Jlg6na2hfQZ4DzfnzDKV+8Asw', 'user', '2024-03-08'),
(7, 'david', 'david123', '2002-06-01', 'Laki-Laki', '085654153115', 'davidrizaldi202@gmail.com', 'sha256:1000:ngQXj7M+o/THZ9BlC009ra6eS8dN7bsJ:9M35PNzxdn1xfW+YYtlPsrSX0pEER3Kg', 'user', '2024-03-08'),
(8, 'salmi', 'salmi', '2001-04-01', 'Laki-Laki', '0856541533115', 'salmitine7@gamil.com', 'sha256:1000:LrwyhbTVBA5ATCDajvY6L501G9blKw9h:8+QlOv7RyCmmTs2cq+rx0HNz0/VmKCQV', 'user', '2024-03-08');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemesanan`
--

CREATE TABLE `tb_pemesanan` (
  `kode_pemesanan` int NOT NULL,
  `id_pelanggan` int NOT NULL,
  `no_lapangan` varchar(10) DEFAULT NULL,
  `tgl_main` varchar(50) DEFAULT NULL,
  `jam_bermain` varchar(10) DEFAULT NULL,
  `total_bayar` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pemesanan`
--

INSERT INTO `tb_pemesanan` (`kode_pemesanan`, `id_pelanggan`, `no_lapangan`, `tgl_main`, `jam_bermain`, `total_bayar`) VALUES
(12, 4, '1', '2024-03-07', '3', 120000),
(13, 4, '2', '2024-03-07', '1', 40000),
(14, 4, '2', '2024-03-08', '2', 80000),
(15, 5, '2', '2024-03-08', '1', 40000),
(16, 7, '1', '2024-03-08', '2', 80000),
(17, 8, '1', '2024-03-08', '2', 80000),
(18, 4, '3', '2024-03-09', '2', 80000);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `id_pelanggan` int NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `id_pelanggan`, `created`) VALUES
(1, '7df72e2ff4aed29498d056f06d2223', 5, '2024-03-06'),
(2, '7fb7108a4e6d3ac5fe26515e8e65c3', 5, '2024-03-06'),
(3, '27e4f0dc2c5aaec1ef870dd8dd610f', 5, '2024-03-06'),
(4, '66d91a609220f7372a85628d0d1d76', 5, '2024-03-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_detailpemesanan`
--
ALTER TABLE `tb_detailpemesanan`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `tb_pemesanan`
--
ALTER TABLE `tb_pemesanan`
  ADD PRIMARY KEY (`kode_pemesanan`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_detailpemesanan`
--
ALTER TABLE `tb_detailpemesanan`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `id_pelanggan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_pemesanan`
--
ALTER TABLE `tb_pemesanan`
  MODIFY `kode_pemesanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
