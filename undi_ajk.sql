-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2026 at 05:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `undi_ajk`
--

-- --------------------------------------------------------

--
-- Table structure for table `calon`
--

CREATE TABLE `calon` (
  `id_calon` varchar(10) NOT NULL,
  `nama_calon` varchar(100) DEFAULT NULL,
  `gambar` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jawatan`
--

CREATE TABLE `jawatan` (
  `idjawatan` varchar(5) NOT NULL,
  `nama_jawatan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jawatan`
--

INSERT INTO `jawatan` (`idjawatan`, `nama_jawatan`) VALUES
('K2', 'SETIAUSAHA'),
('K3', 'BENDAHARI'),
('KI', 'PENGERUSI');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `nokp` varchar(12) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `katalaluan` varchar(100) DEFAULT NULL,
  `tahap` enum('ADMIN','PENGGUNA') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`nokp`, `nama`, `katalaluan`, `tahap`) VALUES
('012345678901', 'AM', '123', 'ADMIN'),
('090404160230', 'Divyaa', 'mdivyaa6', 'PENGGUNA'),
('123456789', 'Divyaa', '123456', 'PENGGUNA'),
('123456789098', 'qwe', '1234567', 'PENGGUNA'),
('333', 'fifi', '1', 'PENGGUNA'),
('77', 'jiji', '1', 'PENGGUNA');

-- --------------------------------------------------------

--
-- Table structure for table `undian`
--

CREATE TABLE `undian` (
  `id_undi` int(11) NOT NULL,
  `nokp` varchar(12) DEFAULT NULL,
  `idjawatan` varchar(5) DEFAULT NULL,
  `id_calon` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calon`
--
ALTER TABLE `calon`
  ADD PRIMARY KEY (`id_calon`);

--
-- Indexes for table `jawatan`
--
ALTER TABLE `jawatan`
  ADD PRIMARY KEY (`idjawatan`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`nokp`);

--
-- Indexes for table `undian`
--
ALTER TABLE `undian`
  ADD PRIMARY KEY (`id_undi`),
  ADD UNIQUE KEY `nokp` (`nokp`,`idjawatan`),
  ADD UNIQUE KEY `nokp_2` (`nokp`,`id_calon`),
  ADD KEY `id_calon` (`id_calon`),
  ADD KEY `idjawatan` (`idjawatan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `undian`
--
ALTER TABLE `undian`
  MODIFY `id_undi` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `undian`
--
ALTER TABLE `undian`
  ADD CONSTRAINT `undian_ibfk_1` FOREIGN KEY (`nokp`) REFERENCES `pengguna` (`nokp`),
  ADD CONSTRAINT `undian_ibfk_2` FOREIGN KEY (`id_calon`) REFERENCES `calon` (`id_calon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `undian_ibfk_3` FOREIGN KEY (`idjawatan`) REFERENCES `jawatan` (`idjawatan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
