-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 14, 2017 at 04:55 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_4171`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` bigint(20) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `barang` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode`, `barang`, `keterangan`) VALUES
(1, '001', 'Indosat Ooredo 2GB', '');

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE `captcha` (
  `captcha_id` bigint(20) NOT NULL,
  `captcha_time` bigint(20) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `word` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `harga`
--

CREATE TABLE `harga` (
  `id_harga` bigint(20) NOT NULL,
  `id_suplier` bigint(20) NOT NULL,
  `id_product` bigint(20) NOT NULL,
  `id_lokasi` bigint(20) NOT NULL,
  `harga_awal` varchar(255) DEFAULT NULL,
  `harga_jual` varchar(255) DEFAULT NULL,
  `harga_akhir` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` bigint(20) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `kode`, `jenis`, `keterangan`) VALUES
(1, '01', 'Fisik', '');

-- --------------------------------------------------------

--
-- Table structure for table `log_stock`
--

CREATE TABLE `log_stock` (
  `id_log` bigint(20) NOT NULL,
  `id_product` bigint(20) NOT NULL,
  `id_lokasi` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `tanggal` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `kode` varchar(255) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `quantity_awal` varchar(255) DEFAULT NULL,
  `quantity_akhir` varchar(255) DEFAULT NULL,
  `quantity_tambah` varchar(255) DEFAULT NULL,
  `quantity_jual` varchar(255) DEFAULT NULL,
  `harga_satuan` varchar(255) DEFAULT NULL,
  `harga_masuk` varchar(255) DEFAULT NULL,
  `harga_keluar` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` bigint(20) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp1` varchar(255) DEFAULT NULL,
  `telp2` varchar(255) DEFAULT NULL,
  `telp3` varchar(255) DEFAULT NULL,
  `telp4` varchar(255) DEFAULT NULL,
  `telp5` varchar(255) DEFAULT NULL,
  `heat` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `kode`, `lokasi`, `alamat`, `telp1`, `telp2`, `telp3`, `telp4`, `telp5`, `heat`, `keterangan`) VALUES
(1, '01', 'Gudang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '001', 'Outlet 1', '', '', '', NULL, NULL, NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `mutasi`
--

CREATE TABLE `mutasi` (
  `id_mutasi` bigint(20) NOT NULL,
  `id_lokasi_awal` bigint(20) NOT NULL,
  `id_lokasi_akhir` bigint(20) NOT NULL,
  `id_product_awal` bigint(20) NOT NULL,
  `kode_awal` varchar(255) DEFAULT NULL,
  `id_product_akhir` bigint(20) NOT NULL,
  `kode_akhir` varchar(255) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) NOT NULL,
  `lokasi_awal` varchar(255) NOT NULL,
  `lokasi_akhir` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mutasi_detail`
--

CREATE TABLE `mutasi_detail` (
  `id_detail` bigint(20) NOT NULL,
  `id_mutasi` bigint(20) NOT NULL,
  `harga` varchar(255) DEFAULT NULL,
  `id_stock` bigint(20) NOT NULL,
  `kode_stock` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_product` bigint(20) NOT NULL,
  `id_supplier` bigint(20) NOT NULL,
  `id_jenis` bigint(20) NOT NULL,
  `id_provider` bigint(20) NOT NULL,
  `id_lokasi` bigint(20) NOT NULL,
  `id_barang` bigint(20) DEFAULT NULL,
  `kode` varchar(255) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `harga_beli` varchar(255) DEFAULT NULL,
  `harga_awal` varchar(255) DEFAULT NULL,
  `harga_jual` varchar(255) DEFAULT NULL,
  `harga_akhir` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_detail`
--

CREATE TABLE `product_detail` (
  `id_pdetail` bigint(20) NOT NULL,
  `id_product` bigint(20) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `exp` date NOT NULL,
  `tglmasuk` datetime NOT NULL,
  `product` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `flag` enum('0','1') NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `id_provider` bigint(20) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`id_provider`, `kode`, `provider`, `keterangan`) VALUES
(1, '89', 'Indosat', '');

-- --------------------------------------------------------

--
-- Table structure for table `retur`
--

CREATE TABLE `retur` (
  `id_retur` bigint(20) NOT NULL,
  `id_user` bigint(20) DEFAULT NULL,
  `id_lokasi` bigint(20) NOT NULL,
  `id_product` bigint(20) NOT NULL,
  `no_faktur` varchar(255) NOT NULL,
  `tanggal_transaksi` datetime DEFAULT NULL,
  `totalitem` varchar(255) DEFAULT NULL,
  `totalbelanja` varchar(255) DEFAULT NULL,
  `tanggal_retur` datetime DEFAULT NULL,
  `kode_product` varchar(255) NOT NULL,
  `kode_stock` varchar(255) NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `harga_satuan` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `logo` longblob,
  `alamat` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  `ig` varchar(255) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `tips` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `nama`, `logo`, `alamat`, `telp`, `pin`, `ig`, `keterangan`, `tips`) VALUES
(1, '4171', 0x30, 'Jalan Kenaris', '0987654321', '8732H423', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat obcaecati mollitia iste numquam culpa, ratione optio officia inventore voluptate quidem.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, at!');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_stock` bigint(20) NOT NULL,
  `id_supplier` bigint(20) NOT NULL,
  `id_jenis` bigint(20) NOT NULL,
  `id_provider` bigint(20) NOT NULL,
  `id_lokasi` bigint(20) NOT NULL,
  `id_barang` bigint(20) DEFAULT NULL,
  `id_user` bigint(20) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `product` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp1` varchar(255) DEFAULT NULL,
  `telp2` varchar(255) DEFAULT NULL,
  `telp3` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `kode`, `supplier`, `alamat`, `telp1`, `telp2`, `telp3`, `keterangan`) VALUES
('1', '01', 'Komunika', '', '', '', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_faktur` bigint(20) NOT NULL,
  `id_user` bigint(20) DEFAULT NULL,
  `id_lokasi` bigint(20) NOT NULL,
  `id_product` bigint(20) NOT NULL,
  `no_faktur` varchar(255) NOT NULL,
  `tanggal` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `totalitem` varchar(255) DEFAULT NULL,
  `totaldisc` varchar(255) DEFAULT NULL,
  `totalbelanja_awal` varchar(255) DEFAULT NULL,
  `totalbelanja_akhir` varchar(255) DEFAULT NULL,
  `tunai` varchar(255) DEFAULT NULL,
  `kembali` varchar(255) DEFAULT NULL,
  `flag_transaksi` tinyint(1) NOT NULL,
  `kode_product` varchar(255) NOT NULL,
  `kode_stock` varchar(255) NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `harga_satuan` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_transaksi_detail` int(20) NOT NULL,
  `id_faktur` char(8) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `product` varchar(255) NOT NULL,
  `kode_product` varchar(255) NOT NULL,
  `kode_stock` varchar(255) NOT NULL,
  `nama_product` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_grosir`
--

CREATE TABLE `transaksi_grosir` (
  `id_faktur` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_lokasi` bigint(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `no_faktur` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_grosir_detail`
--

CREATE TABLE `transaksi_grosir_detail` (
  `id` bigint(20) NOT NULL,
  `id_faktur` bigint(20) NOT NULL,
  `id_product` bigint(20) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `hargasatuan` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `diskon` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_grosir_tmp`
--

CREATE TABLE `transaksi_grosir_tmp` (
  `id` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_lokasi` bigint(20) NOT NULL,
  `id_product` bigint(20) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `hargasatuan` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `diskon` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `flag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) NOT NULL,
  `id_lokasi` bigint(20) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp1` varchar(255) DEFAULT NULL,
  `telp2` varchar(255) DEFAULT NULL,
  `photo` longblob
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `id_lokasi`, `username`, `password`, `level`, `status`, `nama`, `email`, `alamat`, `telp1`, `telp2`, `photo`) VALUES
(1, NULL, 'admin', '670d988eb61f063e252cd1d0e183e5ce', NULL, NULL, 'Administrator', NULL, '', '', '', NULL),
(2, NULL, 'sigit', '9254629d998057afc2d6e7c7c7ba8b06', 'Admin', NULL, 'Sigit', NULL, '', '', '', NULL),
(3, NULL, 'ani123', '296c71777feef0358a7b3fa16c64473b', 'Seles', NULL, 'Anisa', NULL, '', '', '', NULL),
(4, NULL, 'susi123', 'ce5bd6bbec21e80e267624cdfb20175f', 'Seles', NULL, 'Susi', NULL, '', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_logs`
--

CREATE TABLE `users_logs` (
  `id` bigint(20) NOT NULL,
  `datetime` datetime NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_lokasi` bigint(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `captcha`
--
ALTER TABLE `captcha`
  ADD PRIMARY KEY (`captcha_id`);

--
-- Indexes for table `harga`
--
ALTER TABLE `harga`
  ADD PRIMARY KEY (`id_harga`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `log_stock`
--
ALTER TABLE `log_stock`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `mutasi`
--
ALTER TABLE `mutasi`
  ADD PRIMARY KEY (`id_mutasi`);

--
-- Indexes for table `mutasi_detail`
--
ALTER TABLE `mutasi_detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Indexes for table `product_detail`
--
ALTER TABLE `product_detail`
  ADD PRIMARY KEY (`id_pdetail`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`id_provider`);

--
-- Indexes for table `retur`
--
ALTER TABLE `retur`
  ADD PRIMARY KEY (`id_retur`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_faktur`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id_transaksi_detail`);

--
-- Indexes for table `transaksi_grosir`
--
ALTER TABLE `transaksi_grosir`
  ADD PRIMARY KEY (`id_faktur`);

--
-- Indexes for table `transaksi_grosir_detail`
--
ALTER TABLE `transaksi_grosir_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_grosir_tmp`
--
ALTER TABLE `transaksi_grosir_tmp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `users_logs`
--
ALTER TABLE `users_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `captcha`
--
ALTER TABLE `captcha`
  MODIFY `captcha_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `log_stock`
--
ALTER TABLE `log_stock`
  MODIFY `id_log` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mutasi_detail`
--
ALTER TABLE `mutasi_detail`
  MODIFY `id_detail` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_detail`
--
ALTER TABLE `product_detail`
  MODIFY `id_pdetail` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `retur`
--
ALTER TABLE `retur`
  MODIFY `id_retur` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_faktur` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id_transaksi_detail` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaksi_grosir`
--
ALTER TABLE `transaksi_grosir`
  MODIFY `id_faktur` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaksi_grosir_detail`
--
ALTER TABLE `transaksi_grosir_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaksi_grosir_tmp`
--
ALTER TABLE `transaksi_grosir_tmp`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_logs`
--
ALTER TABLE `users_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
