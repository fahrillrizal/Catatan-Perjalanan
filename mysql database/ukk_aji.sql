-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2022 at 07:22 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukk_rendra`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_catatan`
--

CREATE TABLE `tb_catatan` (
  `no_catatan` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `tgl_catatan` date NOT NULL,
  `jam` time NOT NULL,
  `lokasi` text NOT NULL,
  `suhu_tubuh` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_catatan`
--

INSERT INTO `tb_catatan` (`no_catatan`, `id_pengguna`, `tgl_catatan`, `jam`, `lokasi`, `suhu_tubuh`) VALUES
(7, 9, '2022-04-09', '12:17:00', 'taman kota pasuruan', 34.6),
(8, 9, '2022-04-08', '03:17:00', 'alun-alun kota pasuruan', 32),
(9, 9, '2022-04-07', '00:18:00', 'pelabuhan kota pasuruan', 33.5),
(10, 10, '2022-04-07', '12:23:00', 'smkn 1 kota pasuruan', 37.1),
(11, 10, '2022-04-08', '03:20:00', 'kantor dinas kota pasuruan', 32),
(12, 10, '2022-04-09', '12:21:00', 'stadion untung surapati', 34.7);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nik` bigint(16) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(12) NOT NULL,
  `nama_pengguna` varchar(25) NOT NULL,
  `alamat_pengguna` text NOT NULL,
  `jenis_kelamin` varchar(9) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id_pengguna`, `nik`, `username`, `password`, `nama_pengguna`, `alamat_pengguna`, `jenis_kelamin`, `foto`, `email`) VALUES
(9, 3575089761235645, 'na_rendra.18', 'Rendra123', 'alifianto narendra', 'temenggungan kota pasuruan', 'laki-laki', 'man.jpg', 'rendra@gmail.com'),
(10, 3575017632857316, 'windy_123', 'Windy123', 'windy susiati', 'tamanan pasuruan', 'perempuan', 'women.jpg', 'windy@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_catatan`
--
ALTER TABLE `tb_catatan`
  ADD PRIMARY KEY (`no_catatan`);

--
-- Indexes for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_catatan`
--
ALTER TABLE `tb_catatan`
  MODIFY `no_catatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
