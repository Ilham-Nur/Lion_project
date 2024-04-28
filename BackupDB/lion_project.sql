-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 06:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lion_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_harian`
--

CREATE TABLE `tbl_harian` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_pembayaran` text NOT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `no_resi` varchar(255) DEFAULT NULL,
  `ongkir` decimal(30,0) DEFAULT NULL,
  `pajak` decimal(30,0) DEFAULT NULL,
  `pembayaran_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_harian`
--

INSERT INTO `tbl_harian` (`id`, `tanggal`, `jenis_pembayaran`, `pelanggan_id`, `keterangan`, `no_resi`, `ongkir`, `pajak`, `pembayaran_id`) VALUES
(1, '2024-04-24', 'Masuk', 2, 'bayar', '11LP1713942142697', 20000, 30000, 1),
(2, '2024-04-24', 'Keluar', 3, 'Bayar Resi', '11LP1713938080829', 60000, 29000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pelanggan`
--

CREATE TABLE `tbl_pelanggan` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `no_telpon` varchar(50) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pelanggan`
--

INSERT INTO `tbl_pelanggan` (`id`, `nama`, `no_telpon`, `alamat`) VALUES
(1, 'Meta', '08123493294324', 'Jl. Cendrawasih no 13 blok a'),
(2, 'Lina', '0213940234', 'PT Seraya Pakmur Perdana Kawansan Industri Tunas Harapan'),
(3, 'Pije', '08212238343', 'Apartment Victoria'),
(7, 'K Chris', '23455436534', 'KDA Batam Center cluster Rajawali'),
(8, 'Hikmah', '08239409234', 'Depan Masjid Lama');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran`
--

CREATE TABLE `tbl_pembayaran` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pembayaran`
--

INSERT INTO `tbl_pembayaran` (`id`, `name`) VALUES
(1, 'Cash'),
(2, 'Transfer'),
(3, 'Piutang');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `id` int(11) NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`id`, `role`) VALUES
(2, 'Karyawan'),
(1, 'Owner');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `badge`, `password`, `role_id`) VALUES
(1, 'ilhamnur', '0001', 'ilonoer123', 1),
(2, 'wulan', '0003', '12345', 2),
(6, 'nurindah', '0002', 'ilonoer447522', 1),
(8, 'tyo', '0004', '12345', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_harian`
--
ALTER TABLE `tbl_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_id` (`pembayaran_id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role` (`role`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_harian`
--
ALTER TABLE `tbl_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_harian`
--
ALTER TABLE `tbl_harian`
  ADD CONSTRAINT `tbl_harian_ibfk_1` FOREIGN KEY (`pembayaran_id`) REFERENCES `tbl_pembayaran` (`id`),
  ADD CONSTRAINT `tbl_harian_ibfk_2` FOREIGN KEY (`pelanggan_id`) REFERENCES `tbl_pelanggan` (`id`);

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tbl_role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
