-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2022 at 04:52 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trashedu_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE `beli` (
  `beli_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `beli_norumah` int(11) NOT NULL,
  `beli_kodepos` varchar(10) NOT NULL,
  `beli_alamat` varchar(255) NOT NULL,
  `beli_kuantitas` int(11) DEFAULT NULL,
  `beli_harga` int(11) NOT NULL,
  `beli_waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `beli`
--

INSERT INTO `beli` (`beli_id`, `user_id`, `item_id`, `beli_norumah`, `beli_kodepos`, `beli_alamat`, `beli_kuantitas`, `beli_harga`, `beli_waktu`) VALUES
(3, 3, 13, 100, '12312', 'jl oke gresik', 2, 0, '0000-00-00 00:00:00'),
(4, 3, 13, 100, '12312', 'jl oke gresik', 2, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_filename` varchar(255) NOT NULL,
  `item_price` int(11) DEFAULT NULL,
  `item_address` varchar(255) NOT NULL,
  `item_stok` int(11) NOT NULL,
  `item_opsipengiriman` varchar(255) NOT NULL,
  `item_createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `item_updatedat` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `user_id`, `item_name`, `item_filename`, `item_price`, `item_address`, `item_stok`, `item_opsipengiriman`, `item_createdat`, `item_updatedat`) VALUES
(13, 3, 'asd', '1652880376_6003ef4fb2f8853c7143.png', 12, 'asd', 123, 'asd', '2022-05-18 20:26:16', '2022-05-18 20:26:16'),
(14, 3, 'asd', '1652880388_203c2dfa4f7fb7e7209c.png', 12, 'asd', 123, 'asd', '2022-05-18 20:26:28', '2022-05-18 20:26:28'),
(15, 3, 'asd', '1652880560_67acacf0c5bc9fa2eb93.png', 12, 'asd', 123, 'asd', '2022-05-18 20:29:20', '2022-05-18 20:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `keranjang_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `keranjang_kuantitas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`keranjang_id`, `user_id`, `item_id`, `keranjang_kuantitas`) VALUES
(1, 3, 13, 2),
(2, 3, 13, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tipe`
--

CREATE TABLE `tipe` (
  `tipe_id` int(11) NOT NULL,
  `tipe_nama` varchar(255) NOT NULL,
  `tipe_deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipe`
--

INSERT INTO `tipe` (`tipe_id`, `tipe_nama`, `tipe_deskripsi`) VALUES
(1, 'plastik', 'merupakan sampah jenis plastik'),
(2, 'kertas', 'merupakan sampah jenis kertas');

-- --------------------------------------------------------

--
-- Table structure for table `tipe_item`
--

CREATE TABLE `tipe_item` (
  `tipe_item_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `tipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipe_item`
--

INSERT INTO `tipe_item` (`tipe_item_id`, `item_id`, `tipe_id`) VALUES
(1, 13, 2),
(2, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_namadepan` varchar(255) NOT NULL,
  `user_namabelakang` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `user_updatedat` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_namadepan`, `user_namabelakang`, `user_username`, `user_password`, `user_createdat`, `user_updatedat`) VALUES
(3, 'ab', 'ab', 'ab', 'asdb', '2022-05-15 02:38:17', '2022-05-15 02:38:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`beli_id`),
  ADD KEY `FK_user_id` (`user_id`),
  ADD KEY `FK_item_id` (`item_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `FK_item_to_user_id` (`user_id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`keranjang_id`),
  ADD KEY `FK_keranjang_to_user_id` (`user_id`),
  ADD KEY `FK_keranjang_to_item_id` (`item_id`);

--
-- Indexes for table `tipe`
--
ALTER TABLE `tipe`
  ADD PRIMARY KEY (`tipe_id`);

--
-- Indexes for table `tipe_item`
--
ALTER TABLE `tipe_item`
  ADD PRIMARY KEY (`tipe_item_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `tipe_id` (`tipe_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beli`
--
ALTER TABLE `beli`
  MODIFY `beli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `keranjang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tipe`
--
ALTER TABLE `tipe`
  MODIFY `tipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tipe_item`
--
ALTER TABLE `tipe_item`
  MODIFY `tipe_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beli`
--
ALTER TABLE `beli`
  ADD CONSTRAINT `FK_item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_item_to_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `FK_keranjang_to_item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_keranjang_to_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tipe_item`
--
ALTER TABLE `tipe_item`
  ADD CONSTRAINT `item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tipe_id` FOREIGN KEY (`tipe_id`) REFERENCES `tipe` (`tipe_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
