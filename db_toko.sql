-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2026 at 07:07 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `foto` text NOT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `harga`, `stok`, `foto`, `deskripsi`) VALUES
(4, 'Blue Blossom Cardigan', 150000, 20, 'download (3).jpeg', 'Classic with floral accents'),
(5, 'Daisy Whisper Cardigan', 150000, 35, 'download (4).jpeg', 'Warmth with floral elegance'),
(7, 'Smile Blossom Cardigan', 150000, 20, 'download (11).jpeg', 'Simple, soft, and pretty'),
(8, 'Lace Belle Cardigan', 150000, 35, 'download (2).jpeg', 'Soft touch, lovely style'),
(9, 'Noir Blossom Cardigan', 159000, 20, 'download (6).jpeg', 'Sweet Korean daily wear'),
(10, 'Mocha Ribbon Cardigan', 159000, 30, 'エラーページ.jpeg', 'Made for cozy days'),
(11, 'Teddy Hug Cardigan', 159000, 20, 'download (12).jpeg', 'Light, cozy, effortlessly chic'),
(12, 'Rosé Garden Cardigan', 159000, 30, 'download (7).jpeg', 'Grace in every stitch');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int NOT NULL,
  `id_pesanan` varchar(20) NOT NULL,
  `id_barang` int NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_barang`, `jumlah`) VALUES
(1, 'ASP-997852', 10, 1),
(2, 'ASP-901305', 9, 1),
(4, 'ASP-317734', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi_toko`
--

CREATE TABLE `konfigurasi_toko` (
  `id` int NOT NULL,
  `link_banner` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `konfigurasi_toko`
--

INSERT INTO `konfigurasi_toko` (`id`, `link_banner`) VALUES
(1, 'https://i.pinimg.com/1200x/35/6d/b0/356db07120233fb188b01bd4c752edb9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` varchar(20) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `alamat_penerima` text NOT NULL,
  `total_bayar` int NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `tanggal_pesan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `nama_penerima`, `alamat_penerima`, `total_bayar`, `metode_pembayaran`, `tanggal_pesan`) VALUES
('ASP-317734', 'fiyaa', 'poiuy, qwert (Telp: 098767890)', 129000, 'QRIS', '2026-07-11 18:29:23'),
('ASP-901305', 'nusaibah afiyah', 'fvghbjkjhgfredfcgvbn jh, oiuytr (Telp: 0987654)', 129000, 'E-Wallet', '2026-07-06 20:59:17'),
('ASP-997852', 'fiyaa', 'serasi ii, pekan (Telp: 098765432)', 129000, 'QRIS', '2026-07-03 11:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'fiyacantik', '$2y$10$n94TADAUFxyKAxP40wEoe.afASv83UyWF65EqRHBNvF3HpeeWYAZq', 'customer'),
(2, 'adminaespa', 'ecc02531a72e684847aac79d1eca17df', 'admin'),
(4, 'admin0', '$2y$10$Kmym3F5T/ZEihTMvZiuOb.rv1CWPb6qp32OSg7VbvuZMoQBPBXveG', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `konfigurasi_toko`
--
ALTER TABLE `konfigurasi_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `konfigurasi_toko`
--
ALTER TABLE `konfigurasi_toko`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `fk_detail_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
