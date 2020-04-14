-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2019 at 02:18 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uaspaw`
--

-- --------------------------------------------------------

--
-- Table structure for table `buy_cars`
--

CREATE TABLE `buy_cars` (
  `id` int(10) NOT NULL,
  `name` varchar(256) NOT NULL,
  `merk` varchar(256) NOT NULL,
  `type` varchar(256) NOT NULL,
  `harga` bigint(200) NOT NULL,
  `nomorhp` varchar(200) NOT NULL,
  `email_pembeli` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buy_cars`
--

INSERT INTO `buy_cars` (`id`, `name`, `merk`, `type`, `harga`, `nomorhp`, `email_pembeli`) VALUES
(9, 'adfdaf', 'Ferrari', '812 GTS', 8000000000, '087878787878', 'felix.asui@gmail.com'),
(10, 'FERNAN', 'Ferrari', '812 GTS', 890000000, '078787878778', 'felix.asui@gmail.com'),
(11, 'felix fernando wijaya', 'Ferrari', '812 GTS', 87878787878, '089898989898', 'felix.asui@gmail.com'),
(33, 'qweqweqwe', 'Ferrari', '812 GTS', 8000000000, '087878787878', 'felix.asui@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `buy_sparepart`
--

CREATE TABLE `buy_sparepart` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `name_sparepart` varchar(256) NOT NULL,
  `deskripsi` varchar(300) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `kondisi` varchar(256) NOT NULL,
  `email_pembeli` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buy_sparepart`
--

INSERT INTO `buy_sparepart` (`id`, `name`, `name_sparepart`, `deskripsi`, `harga`, `kondisi`, `email_pembeli`) VALUES
(2, 'burhan', 'lampu depan', 'mantab jiwa ', 9000000000, 'New', 'felix.asui@gmail.com'),
(3, 'felixx', 'adasd', 'asdasdas', 6767, 'Old', 'felix.asui@gmail.com'),
(6, 'asd', 'sdasd', 'asdas', 2222, 'New', 'felix.asui@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `sell_cars`
--

CREATE TABLE `sell_cars` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `merk` varchar(256) NOT NULL,
  `warna` varchar(256) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `bahan_bakar` varchar(256) NOT NULL,
  `email_pembeli` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sell_cars`
--

INSERT INTO `sell_cars` (`id`, `name`, `merk`, `warna`, `harga`, `bahan_bakar`, `email_pembeli`) VALUES
(4, 'ASD', 'ASDAS', 'AADSDASD', 2323, 'BENSIN', 'felix.asui@gmail.com'),
(5, 'asd', 'asd', 'asd', 2323, 'DIESEL', 'felix.asui@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(5) NOT NULL,
  `datecreated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `datecreated`) VALUES
(3, 'adasd', 'asdasdasd@adasd.com', 'default.jpg', '$2y$10$LT/V/dddCJfGZUrAI0EX.elrY5Wi4sl4wjxeh7FaAtpLzj/1ygUqW', 2, 1, 1573056488),
(4, 'burhan', 'burhan@gmail.com', 'default.jpg', '$2y$10$sJvNCFd9sw4VQ0Le.hYaLOuab6wMC152U3MgyHJWtOOlphIMZ29TO', 1, 1, 1573403786),
(7, 'felix admin', 'admin@gmail.com', 'EDITEDDD_LOGO2.jpg', '$2y$10$oFwEiTp0AvcaR3akiyR85OZBePrqjptTI6KJEf.PFh7jKtCg5Mj22', 1, 1, 1573456062),
(10, 'asdasd', 'akuncm@gmail.com', 'ad.png', '$2y$10$JlaUiKc/1pigk9XrNAsN4ubF98cPobAej4VXqELMWApYIPSMfpScC', 2, 1, 1573496930),
(12, 'Felix Fernando Wijaya', 'felix.asui@gmail.com', 'ferrari_488.png', '$2y$10$XXexbjOHgARJs84A23aeoeKVmfcVVOgeM9MgkM54CGRgcFM81.ugK', 1, 1, 1573498377);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'menu'),
(5, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Management', 'menu/', 'fas fa-fw fa-folder', 1),
(7, 2, 'Buy Car', 'user/buycars', 'fas fa-fw fa-car', 1),
(8, 2, 'Sell Sparepart', 'user/buysparepart', 'fas fa-fw fa-car', 1),
(9, 2, 'Sell Car', 'user/sellcars', 'fas fa-fw fa-car', 1),
(12, 1, 'Dashboard', 'Admin', 'fas fa-fw fa-folder', 1),
(13, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder', 1),
(28, 1, 'User Management', 'admin/configuser', 'fas fa-users-cog', 1),
(29, 1, 'Buy Car Management', 'admin/configbuycars', 'fas fa-user-lock\"', 1),
(30, 1, 'Sparepart Management', 'admin/configsparepart', 'fas fa-user-lock', 1),
(31, 1, 'Sell Car Management', 'admin/configsellcars', 'fas fa-user-lock\"', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buy_cars`
--
ALTER TABLE `buy_cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buy_sparepart`
--
ALTER TABLE `buy_sparepart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sell_cars`
--
ALTER TABLE `sell_cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buy_cars`
--
ALTER TABLE `buy_cars`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `buy_sparepart`
--
ALTER TABLE `buy_sparepart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sell_cars`
--
ALTER TABLE `sell_cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
