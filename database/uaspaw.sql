-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2020 at 07:17 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

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
-- Table structure for table `data_customer`
--

CREATE TABLE `data_customer` (
  `id_customer` int(200) NOT NULL,
  `nama_customer` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `alamat_customer` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tanggal_lahir_customer` date NOT NULL,
  `nomor_hp_customer` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_customer`
--

INSERT INTO `data_customer` (`id_customer`, `nama_customer`, `alamat_customer`, `tanggal_lahir_customer`, `nomor_hp_customer`, `created_date`, `updated_date`, `deleted_date`) VALUES
(1, 'Felix', 'Jalan Segaran 15 Ilir No 278', '1990-10-29', '0895610801917', '2020-03-05 00:22:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'TIGEEEEE UTIMU ANJENG KAU TIGE', 'BURHAN UDIN NO 222', '1999-10-10', '089898989898', '2020-03-05 00:22:55', '2020-03-11 12:38:50', '0000-00-00 00:00:00'),
(3, 'TIGEEEEE UTIMU BANGSAT KAU TIGEEEEE', 'BURHAN UDIN NO 222', '1999-10-10', '089898989898', '2020-03-05 00:25:22', '2020-03-11 11:36:05', '0000-00-00 00:00:00'),
(9, 'TIGEEEEE UTIMU ANJENG KAU TIGE', 'BURHAN UDIN NO 222', '1999-10-10', '089898989898', '2020-03-11 12:32:34', '2020-03-11 12:42:09', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `data_detail_layanan`
--

CREATE TABLE `data_detail_layanan` (
  `id_jenis_hewan_fk` int(200) NOT NULL,
  `id_jasa_layanan_fk` int(200) NOT NULL,
  `id_ukuran_hewan_fk` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_detail_layanan`
--

INSERT INTO `data_detail_layanan` (`id_jenis_hewan_fk`, `id_jasa_layanan_fk`, `id_ukuran_hewan_fk`) VALUES
(1, 1, 3),
(2, 2, 2),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `data_detail_pengadaan`
--

CREATE TABLE `data_detail_pengadaan` (
  `id_detail_pengadaan` int(255) NOT NULL,
  `id_produk_fk` int(200) NOT NULL,
  `kode_pengadaan_fk` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `satuan_pengadaan` varchar(200) NOT NULL,
  `jumlah_pengadaan` int(200) NOT NULL,
  `tanggal_pengadaan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_detail_pengadaan`
--

INSERT INTO `data_detail_pengadaan` (`id_detail_pengadaan`, `id_produk_fk`, `kode_pengadaan_fk`, `satuan_pengadaan`, `jumlah_pengadaan`, `tanggal_pengadaan`) VALUES
(1, 1, 'PO-2020-02-02-01', 'Botol', 5, '2020-03-05 04:43:31'),
(2, 2, 'PO-2020-03-03-02', 'Botol', 1, '2020-03-05 04:43:31'),
(3, 3, 'PO-2020-04-04-03', 'Pack', 1, '2020-03-05 04:43:44'),
(4, 1, 'PO-2020-02-02-01', 'Pack', 20, '2020-04-10 14:10:40'),
(5, 1, 'PO-2020-02-02-01', 'Pack', 20, '2020-04-10 14:12:33'),
(6, 1, 'PO-2020-02-02-01', 'Pack', 20, '2020-04-10 14:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `data_detail_penjualan_jasa_layanan`
--

CREATE TABLE `data_detail_penjualan_jasa_layanan` (
  `id_jasa_layanan_fk` int(200) NOT NULL,
  `kode_transaksi_penjualan_jasa_layanan_fk` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `jumlah_jasa_layanan` int(200) NOT NULL,
  `subtotal` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_detail_penjualan_jasa_layanan`
--

INSERT INTO `data_detail_penjualan_jasa_layanan` (`id_jasa_layanan_fk`, `kode_transaksi_penjualan_jasa_layanan_fk`, `jumlah_jasa_layanan`, `subtotal`) VALUES
(3, 'LY-240220-01', 1, 20000),
(2, 'LY-240220-02', 1, 30000),
(1, 'LY-240220-03', 1, 40000);

-- --------------------------------------------------------

--
-- Table structure for table `data_detail_penjualan_produk`
--

CREATE TABLE `data_detail_penjualan_produk` (
  `kode_transaksi_penjualan_produk_fk` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_produk_penjualan_fk` int(200) NOT NULL,
  `jumlah_produk` int(200) NOT NULL,
  `subtotal` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_detail_penjualan_produk`
--

INSERT INTO `data_detail_penjualan_produk` (`kode_transaksi_penjualan_produk_fk`, `id_produk_penjualan_fk`, `jumlah_produk`, `subtotal`) VALUES
('PR-200220-01\r\n', 1, 1, 200000),
('PR-200220-02\r\n', 2, 1, 20000),
('PR-200220-03', 2, 1, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `data_hewan`
--

CREATE TABLE `data_hewan` (
  `id_hewan` int(200) NOT NULL,
  `nama_hewan` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_jenis_hewan` int(200) NOT NULL,
  `id_ukuran_hewan` int(200) NOT NULL,
  `id_customer` int(200) NOT NULL,
  `tanggal_lahir_hewan` date NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_hewan`
--

INSERT INTO `data_hewan` (`id_hewan`, `nama_hewan`, `id_jenis_hewan`, `id_ukuran_hewan`, `id_customer`, `tanggal_lahir_hewan`, `created_date`, `updated_date`, `deleted_date`) VALUES
(1, 'Micky', 1, 3, 1, '2018-10-10', '2020-03-05 00:54:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Lucy', 2, 2, 2, '2017-12-12', '2020-03-05 00:54:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Hammy', 3, 1, 3, '2020-01-07', '2020-03-05 00:54:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'TOKOPEDIA nt', 1, 1, 1, '2020-12-12', '2020-04-14 19:45:16', '2020-04-14 19:46:30', '0000-00-00 00:00:00'),
(11, 'HGHJ', 1, 1, 2, '2020-12-12', '2020-04-15 00:09:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'jhkjhjkh', 1, 2, 1, '2020-12-12', '2020-04-15 00:09:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `data_jasa_layanan`
--

CREATE TABLE `data_jasa_layanan` (
  `id_jasa_layanan` int(200) NOT NULL,
  `nama_jasa_layanan` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `harga_jasa_layanan` int(200) NOT NULL,
  `id_jenis_hewan` int(200) NOT NULL,
  `id_ukuran_hewan` int(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_jasa_layanan`
--

INSERT INTO `data_jasa_layanan` (`id_jasa_layanan`, `nama_jasa_layanan`, `harga_jasa_layanan`, `id_jenis_hewan`, `id_ukuran_hewan`, `created_date`, `updated_date`, `deleted_date`) VALUES
(1, 'Grooming', 40000, 1, 3, '2020-03-05 00:56:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Potong Kuku', 30000, 2, 2, '2020-03-05 00:56:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Smoothing', 20000, 3, 1, '2020-03-05 00:56:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `data_jenis_hewan`
--

CREATE TABLE `data_jenis_hewan` (
  `id_jenis_hewan` int(200) NOT NULL,
  `nama_jenis_hewan` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_jenis_hewan`
--

INSERT INTO `data_jenis_hewan` (`id_jenis_hewan`, `nama_jenis_hewan`, `created_date`, `updated_date`, `deleted_date`) VALUES
(1, 'Anjing', '2020-03-05 00:26:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Kucing', '2020-03-05 00:26:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Hamster', '2020-03-05 00:26:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'TIGEEEEE UTIMU KAU TIGE', '2020-03-12 08:13:30', '2020-03-12 08:22:28', '0000-00-00 00:00:00'),
(5, 'TIGEEEEE UTIMU KAU TIGE', '2020-03-12 08:19:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `data_pegawai`
--

CREATE TABLE `data_pegawai` (
  `id_pegawai` int(200) NOT NULL,
  `nama_pegawai` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `alamat_pegawai` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tanggal_lahir_pegawai` date NOT NULL,
  `nomor_hp_pegawai` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `role_pegawai` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `username` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `password` varchar(256) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pegawai`
--

INSERT INTO `data_pegawai` (`id_pegawai`, `nama_pegawai`, `alamat_pegawai`, `tanggal_lahir_pegawai`, `nomor_hp_pegawai`, `role_pegawai`, `username`, `password`, `created_date`, `updated_date`, `deleted_date`) VALUES
(2, 'BANG WAWAN Y', 'asdasd', '1999-10-10', '087878787878', 'Owner', 'kang', '$2y$10$fgKtOiebFFXAl9MNhRRRUuVRXG22PwIpT7M9uM6ASjEabgGwYjqM6', '2020-03-05 00:30:05', '2020-04-14 17:04:13', '0000-00-00 00:00:00'),
(3, 'BANG WAWAN n', 'asdasd', '1999-10-10', '087878787878', 'Owner', 'aliandocool', '$2y$10$4RikOFVUqViX4KBjfuua5el/eYBoAnlk3.XWNv9vgMkbux95/31mu', '2020-03-05 00:30:05', '2020-03-30 15:15:04', '0000-00-00 00:00:00'),
(4, 'BANG WAWAN', 'asdasd', '1999-10-10', '087878787878', 'Owner', 'wawaw', 'awawaw', '2020-03-25 17:56:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'BANG WAWAN', 'asdasd', '1999-10-10', '087878787878', 'Owner', 'udin', 'awawaw', '2020-03-25 17:57:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'BANG WAWAN', 'asdasd', '1999-10-10', '087878787878', 'Owner', 'udinpenyok', '$2y$10$TEZkUO1aTYSSMSp/HDHiTeQsOTxxeiBtQKwMhcjRM/yL5qiKOQktu', '2020-03-30 05:02:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'BANG WAWAN', 'asdasd', '1999-10-10', '087878787878', 'Owner', 'udinpenyok1', '$2y$10$RWh9UOjU0HTIlxY3GTFey.xHHKtDLthAky/o.fikUW3EBHG4i8hSO', '2020-03-30 05:03:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'asd', 'asdas', '2020-12-12', '087878787878', 'asd', 'asd', 'asd', '2020-04-14 16:54:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `data_pengadaan`
--

CREATE TABLE `data_pengadaan` (
  `id_pengadaan` bigint(255) NOT NULL,
  `kode_pengadaan` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_supplier` int(200) NOT NULL,
  `status` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tanggal_pengadaan` datetime NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pengadaan`
--

INSERT INTO `data_pengadaan` (`id_pengadaan`, `kode_pengadaan`, `id_supplier`, `status`, `tanggal_pengadaan`, `total`) VALUES
(1, 'PO-2020-02-02-01', 1, 'Sudah Diterima', '2020-03-05 00:42:51', 577720),
(2, 'PO-2020-03-03-02', 3, 'Sudah Diterima', '2020-04-05 00:42:51', 375520),
(3, 'PO-2020-04-04-03', 2, 'Sudah Diterima', '2020-05-05 00:42:51', 90000);

-- --------------------------------------------------------

--
-- Table structure for table `data_produk`
--

CREATE TABLE `data_produk` (
  `id_produk` int(200) NOT NULL,
  `nama_produk` varchar(200) NOT NULL,
  `harga_produk` int(200) NOT NULL,
  `stok_produk` int(200) NOT NULL,
  `gambar_produk` varchar(200) NOT NULL,
  `stok_minimal_produk` int(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_produk`
--

INSERT INTO `data_produk` (`id_produk`, `nama_produk`, `harga_produk`, `stok_produk`, `gambar_produk`, `stok_minimal_produk`, `created_date`, `updated_date`, `deleted_date`) VALUES
(1, 'TIGE UTIMU', 8888, 232, 'upload/gambar_produk/58e0afe6e2ad8fd836ee853a12d338da.jpg', 10, '2020-03-05 01:50:41', '2020-03-11 18:54:31', '0000-00-00 00:00:00'),
(2, 'Snack Jerry High Carrot', 20000, 40, 'gambar/snack.jpg', 10, '2020-03-05 01:50:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Vita Fortan ', 50000, 40, 'gambar/vita.jpg', 10, '2020-03-05 01:50:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'ROYAL JELLY', 232323, 232, 'Belum ada Gambar yang diupload!', 10, '2020-03-11 18:13:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'ROYAL JELLY', 232323, 232, '/upload/gambar_produk/default.jpg', 10, '2020-03-11 18:15:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'ROYAL JELLY', 232323, 232, '/upload/gambar_produk/a8c28ded47f31c3b056521234afaa7fd.jpg', 10, '2020-03-11 18:15:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'TIGE UTIMU', 232323, 232, 'upload/gambar_produk/ebc939c10d62d15839ea6d876660caa3.jpg', 10, '2020-03-11 18:38:24', '2020-03-11 18:41:49', '0000-00-00 00:00:00'),
(10, 'COVID-22', 10000, 20, 'upload/gambar_produk/img1850.jpg', 10, '2020-03-18 16:04:10', '2020-04-06 19:27:56', '0000-00-00 00:00:00'),
(11, 'BANG WAWAN', 20000, 10, 'upload/gambar_produk/default.jpg', 10, '2020-03-18 16:12:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'BANG WAWAN', 20000, 10, 'upload/gambar_produk/EDITEDDD_LOGO.jpg', 10, '2020-03-18 16:13:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'BANG WAWAN', 20000, 10, 'upload/gambar_produk/default.jpg', 10, '2020-03-18 16:14:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'BANG WAWAN', 20000, 10, 'upload/gambar_produk/default.jpg', 10, '2020-03-18 16:15:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'BANG WAWAN', 20000, 10, 'upload/gambar_produk/EDITEDDD_LOGO1.jpg', 10, '2020-03-18 16:15:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'BANG WAWAN', 20000, 10, 'upload/gambar_produk/EDITEDDD_LOGO2.jpg', 10, '2020-03-18 16:16:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'BANG WAWAN', 20000, 10, 'upload/gambar_produk/EDITEDDD_LOGO3.jpg', 10, '2020-03-18 16:18:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'BANG WAWAN', 20000, 10, 'upload/gambar_produk/EDITEDDD_LOGO4.jpg', 10, '2020-03-18 16:18:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'BANG WAWAN', 20000, 10, 'upload/gambar_produk/3f7a00cda15c8111da5219e08b95c889.jpg', 10, '2020-03-18 16:21:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'COVID-22', 10000, 20, 'upload/gambar_produk/img5186.jpg', 10, '2020-03-18 16:23:26', '2020-04-06 22:20:36', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `data_supplier`
--

CREATE TABLE `data_supplier` (
  `id_supplier` int(200) NOT NULL,
  `nama_supplier` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `alamat_supplier` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nomor_telepon_supplier` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_supplier`
--

INSERT INTO `data_supplier` (`id_supplier`, `nama_supplier`, `alamat_supplier`, `nomor_telepon_supplier`, `created_date`, `updated_date`, `deleted_date`) VALUES
(1, 'PT. Royal Canin Indonesia', 'Jalan Laksda ADisucipto Semarang', '087867676767', '2020-03-05 00:35:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'PT. Royal Jelly Argentina', 'Jalan Solo No 278', '087898989898', '2020-03-05 00:35:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'PT. Anggora Indonesia', 'Jalan Merdeka No 99', '086789898989', '2020-03-05 00:35:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'felixxx', 'asdasdasxsds', '087878787889', '2020-04-04 11:43:01', '2020-04-04 11:46:37', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_penjualan`
--

CREATE TABLE `data_transaksi_penjualan` (
  `kode_transaksi` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_hewan` int(200) NOT NULL,
  `tanggal_penjualan` datetime NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL,
  `total_harga` int(200) NOT NULL,
  `diskon_pembayaran` int(200) NOT NULL,
  `status_pembayaran` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `id_cs` int(200) NOT NULL,
  `id_kasir` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_transaksi_penjualan`
--

INSERT INTO `data_transaksi_penjualan` (`kode_transaksi`, `id_hewan`, `tanggal_penjualan`, `tanggal_pembayaran`, `total_harga`, `diskon_pembayaran`, `status_pembayaran`, `created_date`, `updated_date`, `id_cs`, `id_kasir`) VALUES
('LY-240220-01', 1, '2020-03-05 02:05:29', '2020-03-05 02:05:29', 0, 20000, 'Lunas', '2020-03-05 02:05:29', '0000-00-00 00:00:00', 2, 3),
('PR-200220-01', 1, '2020-03-05 02:05:29', '2020-03-05 02:05:29', 180000, 20000, 'Lunas', '2020-03-05 02:05:29', '0000-00-00 00:00:00', 2, 3),
('PR-200220-02', 2, '2020-03-05 02:05:29', '2020-03-05 02:05:29', 180000, 20000, 'Lunas', '2020-03-05 02:05:29', '0000-00-00 00:00:00', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_penjualan_jasa_layanan`
--

CREATE TABLE `data_transaksi_penjualan_jasa_layanan` (
  `kode_transaksi_penjualan_jasa_layanan` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_hewan` int(200) NOT NULL,
  `tanggal_penjualan_jasa_layanan` datetime NOT NULL,
  `tanggal_pembayaran_jasa_layanan` datetime NOT NULL,
  `status_layanan` varchar(200) NOT NULL,
  `status_pembayaran` varchar(200) NOT NULL,
  `diskon` int(200) NOT NULL,
  `total_penjualan_jasa_layanan` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_cs` int(200) NOT NULL,
  `id_kasir` int(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `total_harga` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_transaksi_penjualan_jasa_layanan`
--

INSERT INTO `data_transaksi_penjualan_jasa_layanan` (`kode_transaksi_penjualan_jasa_layanan`, `id_hewan`, `tanggal_penjualan_jasa_layanan`, `tanggal_pembayaran_jasa_layanan`, `status_layanan`, `status_pembayaran`, `diskon`, `total_penjualan_jasa_layanan`, `id_cs`, `id_kasir`, `created_date`, `updated_date`, `total_harga`) VALUES
('LY-240220-01', 1, '2020-03-05 01:12:54', '2020-03-05 01:12:54', 'Selesai', 'Lunas', 20000, '20000', 2, 3, '2020-03-05 01:12:54', '0000-00-00 00:00:00', 0),
('LY-240220-02', 2, '2020-03-05 01:12:54', '0000-00-00 00:00:00', 'Selesai', 'Belum Lunas', 20000, '30000', 2, 3, '2020-03-05 01:12:54', '0000-00-00 00:00:00', 10000),
('LY-240220-03', 3, '2020-03-05 01:12:54', '2020-03-05 01:12:54', 'Selesai', 'Lunas', 20000, '40000', 2, 3, '2020-03-05 01:12:54', '0000-00-00 00:00:00', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_penjualan_produk`
--

CREATE TABLE `data_transaksi_penjualan_produk` (
  `kode_transaksi_penjualan_produk` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_hewan` int(200) NOT NULL,
  `tanggal_penjualan_produk` datetime NOT NULL,
  `tanggal_pembayaran_produk` datetime NOT NULL,
  `diskon` int(200) NOT NULL,
  `total_penjualan_produk` int(200) NOT NULL,
  `status_pembayaran` varchar(200) NOT NULL,
  `id_cs` int(200) NOT NULL,
  `id_kasir` int(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `total_harga` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_transaksi_penjualan_produk`
--

INSERT INTO `data_transaksi_penjualan_produk` (`kode_transaksi_penjualan_produk`, `id_hewan`, `tanggal_penjualan_produk`, `tanggal_pembayaran_produk`, `diskon`, `total_penjualan_produk`, `status_pembayaran`, `id_cs`, `id_kasir`, `created_date`, `updated_date`, `total_harga`) VALUES
('PR-200220-01\r\n', 1, '2020-03-05 01:04:12', '2020-03-05 01:04:12', 20000, 200000, 'Lunas', 2, 3, '2020-03-05 01:04:12', '0000-00-00 00:00:00', 180000),
('PR-200220-02\r\n', 2, '2020-03-05 01:04:12', '2020-03-05 01:04:12', 20000, 20000, 'Lunas', 2, 3, '2020-03-05 01:04:12', '0000-00-00 00:00:00', 0),
('PR-200220-03', 3, '2020-03-05 01:04:12', '2020-03-05 01:04:12', 20000, 20000, 'Lunas', 2, 3, '2020-03-05 01:04:12', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `data_ukuran_hewan`
--

CREATE TABLE `data_ukuran_hewan` (
  `id_ukuran_hewan` int(200) NOT NULL,
  `ukuran_hewan` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_ukuran_hewan`
--

INSERT INTO `data_ukuran_hewan` (`id_ukuran_hewan`, `ukuran_hewan`, `created_date`, `updated_date`, `deleted_date`) VALUES
(1, 'Small', '2020-03-05 00:37:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Medium', '2020-03-05 00:37:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Large', '2020-03-05 00:37:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
(33, 1, 'Kelola Data Pegawai', 'admin/kelola_pegawai', 'fas fa-users-cog', 1),
(34, 1, 'Kelola Data Jenis Hewan', 'admin/kelola_jenis_hewan', 'fas fa-users-cog', 1),
(35, 1, 'Kelola Data Ukuran Hewan', 'admin/kelola_ukuran_hewan', 'fas fa-users-cog', 1),
(36, 1, 'Kelola Data Customer', 'admin/kelola_customer', 'fas fa-users-cog', 1),
(37, 1, 'Kelola Data Supplier', 'admin/kelola_supplier', 'fas fa-users-cog', 1),
(38, 1, 'Kelola Data Hewan', 'admin/kelola_hewan', 'fas fa-users-cog', 1);

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
-- Indexes for table `data_customer`
--
ALTER TABLE `data_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `data_detail_layanan`
--
ALTER TABLE `data_detail_layanan`
  ADD KEY `id_jasa_layanan_fk` (`id_jasa_layanan_fk`),
  ADD KEY `id_jenis_hewan_fk` (`id_jenis_hewan_fk`),
  ADD KEY `id_ukuran_hewan_fk` (`id_ukuran_hewan_fk`);

--
-- Indexes for table `data_detail_pengadaan`
--
ALTER TABLE `data_detail_pengadaan`
  ADD PRIMARY KEY (`id_detail_pengadaan`),
  ADD KEY `id_produk_fk` (`id_produk_fk`),
  ADD KEY `kode_pengadaan_fk` (`kode_pengadaan_fk`);

--
-- Indexes for table `data_detail_penjualan_jasa_layanan`
--
ALTER TABLE `data_detail_penjualan_jasa_layanan`
  ADD KEY `id_jasa_layanan_fk` (`id_jasa_layanan_fk`),
  ADD KEY `kode_transaksi_penjualan_jasa_layanan_fk` (`kode_transaksi_penjualan_jasa_layanan_fk`);

--
-- Indexes for table `data_detail_penjualan_produk`
--
ALTER TABLE `data_detail_penjualan_produk`
  ADD KEY `id_produk_penjualan_fk` (`id_produk_penjualan_fk`),
  ADD KEY `kode_transaksi_penjualan_produk_fk` (`kode_transaksi_penjualan_produk_fk`);

--
-- Indexes for table `data_hewan`
--
ALTER TABLE `data_hewan`
  ADD PRIMARY KEY (`id_hewan`),
  ADD KEY `id_jenis_hewan` (`id_jenis_hewan`),
  ADD KEY `id_ukuran_hewan` (`id_ukuran_hewan`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `data_jasa_layanan`
--
ALTER TABLE `data_jasa_layanan`
  ADD PRIMARY KEY (`id_jasa_layanan`),
  ADD KEY `id_jenis_hewan` (`id_jenis_hewan`),
  ADD KEY `id_ukuran_hewan` (`id_ukuran_hewan`);

--
-- Indexes for table `data_jenis_hewan`
--
ALTER TABLE `data_jenis_hewan`
  ADD PRIMARY KEY (`id_jenis_hewan`);

--
-- Indexes for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `data_pengadaan`
--
ALTER TABLE `data_pengadaan`
  ADD PRIMARY KEY (`id_pengadaan`),
  ADD UNIQUE KEY `kode_pengadaan` (`kode_pengadaan`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `data_produk`
--
ALTER TABLE `data_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `data_supplier`
--
ALTER TABLE `data_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `data_transaksi_penjualan`
--
ALTER TABLE `data_transaksi_penjualan`
  ADD PRIMARY KEY (`kode_transaksi`),
  ADD KEY `id_hewan` (`id_hewan`),
  ADD KEY `id_cs` (`id_cs`),
  ADD KEY `id_kasir` (`id_kasir`);

--
-- Indexes for table `data_transaksi_penjualan_jasa_layanan`
--
ALTER TABLE `data_transaksi_penjualan_jasa_layanan`
  ADD PRIMARY KEY (`kode_transaksi_penjualan_jasa_layanan`),
  ADD KEY `id_hewan` (`id_hewan`),
  ADD KEY `id_cs` (`id_cs`),
  ADD KEY `id_kasir` (`id_kasir`);

--
-- Indexes for table `data_transaksi_penjualan_produk`
--
ALTER TABLE `data_transaksi_penjualan_produk`
  ADD PRIMARY KEY (`kode_transaksi_penjualan_produk`),
  ADD KEY `id_hewan` (`id_hewan`),
  ADD KEY `id_cs` (`id_cs`),
  ADD KEY `id_kasir` (`id_kasir`);

--
-- Indexes for table `data_ukuran_hewan`
--
ALTER TABLE `data_ukuran_hewan`
  ADD PRIMARY KEY (`id_ukuran_hewan`);

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
-- AUTO_INCREMENT for table `data_customer`
--
ALTER TABLE `data_customer`
  MODIFY `id_customer` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_detail_pengadaan`
--
ALTER TABLE `data_detail_pengadaan`
  MODIFY `id_detail_pengadaan` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `data_hewan`
--
ALTER TABLE `data_hewan`
  MODIFY `id_hewan` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `data_jasa_layanan`
--
ALTER TABLE `data_jasa_layanan`
  MODIFY `id_jasa_layanan` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_jenis_hewan`
--
ALTER TABLE `data_jenis_hewan`
  MODIFY `id_jenis_hewan` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  MODIFY `id_pegawai` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_pengadaan`
--
ALTER TABLE `data_pengadaan`
  MODIFY `id_pengadaan` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `data_produk`
--
ALTER TABLE `data_produk`
  MODIFY `id_produk` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `data_supplier`
--
ALTER TABLE `data_supplier`
  MODIFY `id_supplier` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_ukuran_hewan`
--
ALTER TABLE `data_ukuran_hewan`
  MODIFY `id_ukuran_hewan` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_detail_layanan`
--
ALTER TABLE `data_detail_layanan`
  ADD CONSTRAINT `data_detail_layanan_ibfk_1` FOREIGN KEY (`id_jenis_hewan_fk`) REFERENCES `data_jenis_hewan` (`id_jenis_hewan`),
  ADD CONSTRAINT `data_detail_layanan_ibfk_2` FOREIGN KEY (`id_jasa_layanan_fk`) REFERENCES `data_jasa_layanan` (`id_jasa_layanan`),
  ADD CONSTRAINT `data_detail_layanan_ibfk_3` FOREIGN KEY (`id_jenis_hewan_fk`) REFERENCES `data_jenis_hewan` (`id_jenis_hewan`),
  ADD CONSTRAINT `data_detail_layanan_ibfk_4` FOREIGN KEY (`id_ukuran_hewan_fk`) REFERENCES `data_ukuran_hewan` (`id_ukuran_hewan`);

--
-- Constraints for table `data_detail_pengadaan`
--
ALTER TABLE `data_detail_pengadaan`
  ADD CONSTRAINT `data_detail_pengadaan_ibfk_1` FOREIGN KEY (`id_produk_fk`) REFERENCES `data_produk` (`id_produk`),
  ADD CONSTRAINT `data_detail_pengadaan_ibfk_2` FOREIGN KEY (`kode_pengadaan_fk`) REFERENCES `data_pengadaan` (`kode_pengadaan`),
  ADD CONSTRAINT `data_detail_pengadaan_ibfk_3` FOREIGN KEY (`kode_pengadaan_fk`) REFERENCES `data_pengadaan` (`kode_pengadaan`);

--
-- Constraints for table `data_detail_penjualan_jasa_layanan`
--
ALTER TABLE `data_detail_penjualan_jasa_layanan`
  ADD CONSTRAINT `data_detail_penjualan_jasa_layanan_ibfk_1` FOREIGN KEY (`id_jasa_layanan_fk`) REFERENCES `data_jasa_layanan` (`id_jasa_layanan`),
  ADD CONSTRAINT `data_detail_penjualan_jasa_layanan_ibfk_3` FOREIGN KEY (`kode_transaksi_penjualan_jasa_layanan_fk`) REFERENCES `data_transaksi_penjualan_jasa_layanan` (`kode_transaksi_penjualan_jasa_layanan`),
  ADD CONSTRAINT `data_detail_penjualan_jasa_layanan_ibfk_4` FOREIGN KEY (`kode_transaksi_penjualan_jasa_layanan_fk`) REFERENCES `data_transaksi_penjualan_jasa_layanan` (`kode_transaksi_penjualan_jasa_layanan`);

--
-- Constraints for table `data_detail_penjualan_produk`
--
ALTER TABLE `data_detail_penjualan_produk`
  ADD CONSTRAINT `data_detail_penjualan_produk_ibfk_1` FOREIGN KEY (`kode_transaksi_penjualan_produk_fk`) REFERENCES `data_transaksi_penjualan_produk` (`kode_transaksi_penjualan_produk`),
  ADD CONSTRAINT `data_detail_penjualan_produk_ibfk_2` FOREIGN KEY (`id_produk_penjualan_fk`) REFERENCES `data_produk` (`id_produk`),
  ADD CONSTRAINT `data_detail_penjualan_produk_ibfk_3` FOREIGN KEY (`kode_transaksi_penjualan_produk_fk`) REFERENCES `data_transaksi_penjualan_produk` (`kode_transaksi_penjualan_produk`);

--
-- Constraints for table `data_hewan`
--
ALTER TABLE `data_hewan`
  ADD CONSTRAINT `data_hewan_ibfk_1` FOREIGN KEY (`id_jenis_hewan`) REFERENCES `data_jenis_hewan` (`id_jenis_hewan`),
  ADD CONSTRAINT `data_hewan_ibfk_2` FOREIGN KEY (`id_ukuran_hewan`) REFERENCES `data_ukuran_hewan` (`id_ukuran_hewan`),
  ADD CONSTRAINT `data_hewan_ibfk_3` FOREIGN KEY (`id_customer`) REFERENCES `data_customer` (`id_customer`);

--
-- Constraints for table `data_jasa_layanan`
--
ALTER TABLE `data_jasa_layanan`
  ADD CONSTRAINT `data_jasa_layanan_ibfk_1` FOREIGN KEY (`id_jenis_hewan`) REFERENCES `data_jenis_hewan` (`id_jenis_hewan`),
  ADD CONSTRAINT `data_jasa_layanan_ibfk_2` FOREIGN KEY (`id_ukuran_hewan`) REFERENCES `data_ukuran_hewan` (`id_ukuran_hewan`);

--
-- Constraints for table `data_pengadaan`
--
ALTER TABLE `data_pengadaan`
  ADD CONSTRAINT `data_pengadaan_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `data_supplier` (`id_supplier`);

--
-- Constraints for table `data_transaksi_penjualan`
--
ALTER TABLE `data_transaksi_penjualan`
  ADD CONSTRAINT `data_transaksi_penjualan_ibfk_1` FOREIGN KEY (`id_hewan`) REFERENCES `data_hewan` (`id_hewan`),
  ADD CONSTRAINT `data_transaksi_penjualan_ibfk_2` FOREIGN KEY (`id_cs`) REFERENCES `data_pegawai` (`id_pegawai`),
  ADD CONSTRAINT `data_transaksi_penjualan_ibfk_3` FOREIGN KEY (`id_kasir`) REFERENCES `data_pegawai` (`id_pegawai`);

--
-- Constraints for table `data_transaksi_penjualan_jasa_layanan`
--
ALTER TABLE `data_transaksi_penjualan_jasa_layanan`
  ADD CONSTRAINT `data_transaksi_penjualan_jasa_layanan_ibfk_1` FOREIGN KEY (`id_hewan`) REFERENCES `data_hewan` (`id_hewan`),
  ADD CONSTRAINT `data_transaksi_penjualan_jasa_layanan_ibfk_2` FOREIGN KEY (`id_cs`) REFERENCES `data_pegawai` (`id_pegawai`),
  ADD CONSTRAINT `data_transaksi_penjualan_jasa_layanan_ibfk_3` FOREIGN KEY (`id_kasir`) REFERENCES `data_pegawai` (`id_pegawai`);

--
-- Constraints for table `data_transaksi_penjualan_produk`
--
ALTER TABLE `data_transaksi_penjualan_produk`
  ADD CONSTRAINT `data_transaksi_penjualan_produk_ibfk_1` FOREIGN KEY (`id_hewan`) REFERENCES `data_hewan` (`id_hewan`),
  ADD CONSTRAINT `data_transaksi_penjualan_produk_ibfk_2` FOREIGN KEY (`id_cs`) REFERENCES `data_pegawai` (`id_pegawai`),
  ADD CONSTRAINT `data_transaksi_penjualan_produk_ibfk_3` FOREIGN KEY (`id_kasir`) REFERENCES `data_pegawai` (`id_pegawai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
