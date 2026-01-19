-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 12, 2020 at 04:58 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mypos`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `gender`, `phone`, `address`, `created`, `updated`) VALUES
(1, 'JUMADI', 'L', '12345', 'JEPARA', '2020-09-13 10:08:18', NULL),
(2, 'TUKIYEM', 'P', '2345', 'KUDUS', '2020-09-13 10:08:43', NULL),
(3, 'Paijo', 'L', '085', 'SEMARANG\r\n', '2020-09-13 13:15:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `p_category`
--

CREATE TABLE `p_category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_category`
--

INSERT INTO `p_category` (`category_id`, `name`, `created`, `updated`) VALUES
(2, 'ATK', '2020-09-13 11:08:52', '2020-09-13 06:09:18'),
(3, 'Sembako', '2020-09-13 11:11:44', '2020-09-13 06:54:21'),
(4, 'Makanan', '2020-09-13 12:23:25', '2020-09-13 12:23:25'),
(5, 'Minuman', '2020-09-13 12:29:47', '2020-09-13 08:14:44'),
(6, 'Pembersih', '2020-09-13 20:16:36', '2020-09-13 20:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `p_item`
--

CREATE TABLE `p_item` (
  `item_id` int(11) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(10) NOT NULL DEFAULT '0',
  `image` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_item`
--

INSERT INTO `p_item` (`item_id`, `barcode`, `name`, `category_id`, `unit_id`, `price`, `stock`, `image`, `created`, `updated`) VALUES
(7, 'A001', 'Kacang Garuda', 4, 3, 2000, 0, 'item-201012-1027e4baab6a50345bb72256e850aa2a.jpeg', '2020-10-11 18:34:00', '2020-10-12 04:55:56'),
(8, 'A002', 'Mie Sedap Goreng', 4, 3, 3000, 0, 'item-201012-05dbbc6e0f511c395fa8eed0b75259e5.jpg', '2020-10-11 21:56:24', '2020-10-11 21:56:24'),
(9, 'A003', 'Shampo ZINC', 6, 5, 500, 0, 'item-201012-9254492cce066ddb1b5d8b532013fa1d.jpg', '2020-10-11 21:57:26', '2020-10-11 21:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `p_unit`
--

CREATE TABLE `p_unit` (
  `unit_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_unit`
--

INSERT INTO `p_unit` (`unit_id`, `name`, `created`, `updated`) VALUES
(2, 'Kilogram', '2020-09-13 11:08:52', '2020-09-13 08:11:49'),
(3, 'Bungkus', '2020-09-13 11:11:44', '2020-09-13 08:11:57'),
(4, 'Pak', '2020-09-13 12:23:25', '2020-09-13 08:12:15'),
(5, 'Renceng', '2020-09-13 12:29:47', '2020-09-13 08:12:26'),
(6, 'Karton', '2020-09-13 20:16:59', '2020-09-13 20:16:59');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(200) NOT NULL,
  `description` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `phone`, `address`, `description`, `created`, `updated`) VALUES
(10, 'TOKO ABATA', '12345', 'JEPARA', 'PEMASOK BAHAN BANGUNAN', '2020-09-12 17:34:53', '2020-09-12 21:22:33'),
(11, 'TOKO ABC', '2345', 'KUDUS', 'PEMASOK BERAS', '2020-09-12 17:37:04', '2020-09-12 16:28:22'),
(16, 'TOKO ABC', '12345', 'jepara', 'toko sembako', '2020-09-12 18:47:23', '0000-00-00 00:00:00'),
(17, 'TOKO ABATA', '12345', 'JEPARA', 'TOKO GULA', '2020-09-12 20:09:27', '0000-00-00 00:00:00'),
(18, 'TOKO ABATA', '12345', 'JEPARA', 'TOKO SEMBAKO', '2020-09-12 20:11:43', '0000-00-00 00:00:00'),
(20, 'TOKO ABATA', '12345', 'JEPARA', 'TOKO ATK', '2020-09-12 20:12:25', '0000-00-00 00:00:00'),
(21, 'TOKO ABATA', '12345', 'JEPARA', 'PEMASOK PLASTIK', '2020-09-12 20:12:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `level` int(1) NOT NULL COMMENT '1:admin, 2:kasir'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `address`, `name`, `level`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'sukosono', 'Nur Huda', 1),
(2, 'kasir', '8691e4fc53b99da544ce86e22acba62d13352eff', 'jepara', 'Dewi Annisa', 2),
(6, 'selamet', '8cb2237d0679ca88db6464eac60da96345513964', 'demak', 'selamet', 2),
(7, 'ilham', '8cb2237d0679ca88db6464eac60da96345513964', 'sukosono', 'ilham', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `p_category`
--
ALTER TABLE `p_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `p_item`
--
ALTER TABLE `p_item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `p_unit`
--
ALTER TABLE `p_unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `p_category`
--
ALTER TABLE `p_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `p_item`
--
ALTER TABLE `p_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `p_unit`
--
ALTER TABLE `p_unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `p_item`
--
ALTER TABLE `p_item`
  ADD CONSTRAINT `p_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `p_category` (`category_id`),
  ADD CONSTRAINT `p_item_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `p_unit` (`unit_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
