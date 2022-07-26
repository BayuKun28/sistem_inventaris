-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 26, 2022 at 03:40 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventaris`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_tidak_tetap`
--

DROP TABLE IF EXISTS `barang_tidak_tetap`;
CREATE TABLE IF NOT EXISTS `barang_tidak_tetap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_tidak_tetap`
--

INSERT INTO `barang_tidak_tetap` (`id`, `nama_barang`, `jumlah`, `keterangan`) VALUES
(2, 'KERTAS HVS A4', 1000, 'Buram'),
(3, 'KERTAS HVS A3', 12, 'Putih'),
(4, 'KALENDER 2022', 10, 'KALENDER');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi_elektronik`
--

DROP TABLE IF EXISTS `detail_transaksi_elektronik`;
CREATE TABLE IF NOT EXISTS `detail_transaksi_elektronik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `peminjaman_id` int(11) NOT NULL,
  `barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_transaksi_elektronik`
--

INSERT INTO `detail_transaksi_elektronik` (`id`, `peminjaman_id`, `barang`, `qty`) VALUES
(22, 9, 3, 1),
(21, 9, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi_kendaraan`
--

DROP TABLE IF EXISTS `detail_transaksi_kendaraan`;
CREATE TABLE IF NOT EXISTS `detail_transaksi_kendaraan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `peminjaman_id` int(11) NOT NULL,
  `barang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_transaksi_kendaraan`
--

INSERT INTO `detail_transaksi_kendaraan` (`id`, `peminjaman_id`, `barang`) VALUES
(4, 8, 2),
(3, 8, 1),
(5, 10, 8),
(6, 10, 6);

-- --------------------------------------------------------

--
-- Table structure for table `elektronik`
--

DROP TABLE IF EXISTS `elektronik`;
CREATE TABLE IF NOT EXISTS `elektronik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(255) NOT NULL,
  `nomor_seri_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `kondisi` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `elektronik`
--

INSERT INTO `elektronik` (`id`, `nama_barang`, `nomor_seri_barang`, `jumlah`, `kondisi`, `image`, `status`) VALUES
(2, 'LAPTOP ACER ASPIRE ONE ', 'LPT001PK', 10, 1, 'output-onlinejpgtools2.jpg', 0),
(3, 'LAMPU', '12368712HH', 19, 1, 'output-onlinejpgtools3.jpg', 0),
(4, 'PRINTER EPSON A900', 'AVSU898', 2, 1, 'pemadaman.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

DROP TABLE IF EXISTS `jenis`;
CREATE TABLE IF NOT EXISTS `jenis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id`, `nama_jenis`, `url`) VALUES
(1, 'Kendaraan', 'kendaraan'),
(2, 'Elektronik', 'elektronik');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_bbm`
--

DROP TABLE IF EXISTS `jenis_bbm`;
CREATE TABLE IF NOT EXISTS `jenis_bbm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis_bbm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_bbm`
--

INSERT INTO `jenis_bbm` (`id`, `nama_jenis_bbm`) VALUES
(1, 'PERTALITE'),
(2, 'PERTAMAX'),
(4, 'PERTAMAX TURBO');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_ranmor`
--

DROP TABLE IF EXISTS `jenis_ranmor`;
CREATE TABLE IF NOT EXISTS `jenis_ranmor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis_ranmor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_ranmor`
--

INSERT INTO `jenis_ranmor` (`id`, `nama_jenis_ranmor`) VALUES
(1, 'SPM'),
(3, 'KBM');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

DROP TABLE IF EXISTS `kendaraan`;
CREATE TABLE IF NOT EXISTS `kendaraan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_ranmor` int(11) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `tipe_ranmor` varchar(255) NOT NULL,
  `unit_pengguna` int(11) NOT NULL,
  `no_pol` varchar(255) NOT NULL,
  `no_rangka` varchar(255) NOT NULL,
  `no_mesin` varchar(255) NOT NULL,
  `tahun_perolehan` int(11) NOT NULL,
  `asal_perolehan` varchar(255) NOT NULL,
  `kondisi_ranmor` int(11) NOT NULL,
  `jenis_bbm` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `jenis_ranmor`, `merk`, `tipe_ranmor`, `unit_pengguna`, `no_pol`, `no_rangka`, `no_mesin`, `tahun_perolehan`, `asal_perolehan`, `kondisi_ranmor`, `jenis_bbm`, `file`, `status`) VALUES
(1, 1, 'HONDA', 'MOTOR', 1, 'AD 0000 BB', '123123HHJ1239217UHH', '31293HGJHJH123', 2022, 'POLDA JATENGG', 1, 2, '_21_minimalist-iron-man-wallpaper_Iron-Man-4k-Ultra-HD-Wallpaper-Background-Image-1.jpg', 0),
(2, 1, 'SUZUKI', 'MOBIL', 1, 'AD 0000 CC', '130912809JBJH', '3812039JBDJSJ', 2021, 'POLDA DIY', 1, 2, '01__pt_gin_Surat_kesanggupan_tutor_Bayu_Prastyo_10-01-2022.pdf', 0),
(3, 1, 'Kawasaki', 'MOTOR', 1, 'AB 0000 BB', '123123HHJ1239217ULL', '31293HGJHJ131', 2022, 'POLDA JATENG', 1, 1, '01__pt_gin_Surat_kesanggupan_tutor_Bayu_Prastyo_10-01-2022.pdf', 0),
(5, 1, 'COBA MERK', 'COBA TIPE', 1, 'B 0001 XY', '123123HHJ1239217UHHDAJBJS123', '3812039JBDJSJASAHAS', 2022, 'POLDA JATENG', 1, 2, '_21_minimalist-iron-man-wallpaper_Iron-Man-4k-Ultra-HD-Wallpaper-Background-Image-.jpg', 0),
(6, 3, 'HONDA', 'JAZZ', 1, 'AB 0001 XZ', '138129038SIHFSI23', '21312312ASDAIH', 2021, 'POLDA JATENG', 1, 4, 'output-onlinejpgtools.jpg', 1),
(8, 3, 'SUZUKI', 'GSX 150 RR', 1, 'AB 9898 OP', '3456789EDTY9876RDTY', '3245678OIUYT34567IHJG', 2022, 'POLDA JOGJA', 1, 2, 'SeekPng_com_user-png_7297561.png', 1),
(10, 1, 'asd', 'asd', 1, 'asd', 'asd', 'asd', 2022, 'sad', 1, 1, 'Remini20220712065327838.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kondisi`
--

DROP TABLE IF EXISTS `kondisi`;
CREATE TABLE IF NOT EXISTS `kondisi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kondisi` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kondisi`
--

INSERT INTO `kondisi` (`id`, `kondisi`) VALUES
(1, 'BAIK'),
(2, 'RUSAK RINGAN'),
(4, 'RUSAK PARAH');

-- --------------------------------------------------------

--
-- Table structure for table `level_pengguna`
--

DROP TABLE IF EXISTS `level_pengguna`;
CREATE TABLE IF NOT EXISTS `level_pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_level` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level_pengguna`
--

INSERT INTO `level_pengguna` (`id`, `nama_level`) VALUES
(1, 'Admin'),
(2, 'Peminjam');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jenis_pinjam` int(11) NOT NULL,
  `nama_unit` varchar(255) NOT NULL,
  `nama_barang` text NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `nama`, `jenis_pinjam`, `nama_unit`, `nama_barang`, `tgl_pinjam`, `tgl_kembali`, `keterangan`, `id_user`) VALUES
(10, 'TES MULTIPLE DETAIL LAGI', 1, '123', '8,6', '2022-07-26', NULL, '123', 1),
(9, 'TES MULTIPLE DETAIL ELEKTRONIK', 2, 'TES UNIT', 'In Detail', '2022-07-26', '2022-07-26', 'abc', 1),
(8, 'TES MULTIPLE DETAIL', 1, 'TES UNIT', '1,2', '2022-07-26', '2022-07-26', '123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE IF NOT EXISTS `pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `nama`, `level`, `is_active`) VALUES
(1, 'admin', '$2y$10$/I7laWi1mlNFxYSv54EUPOH8MuZhmRWxhE.LaddTK9TSmVe.IHP2C', 'Admin', 1, 1),
(2, 'peminjam1', '$2y$10$sHy4mAQIwZAkly2iDeuFxuHT06pLeVf6ddfZIawN7C09OcNu63dw.', 'Peminjam1', 2, 1),
(3, 'peminjam2', '$2y$10$UqRs8NE0/xsXpwYWQIF0Q.HgCK9HfE/3.hI4JW0RHOvu8sSYBRXWO', 'Peminjam2', 2, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `split_string_into_rows`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `split_string_into_rows`;
CREATE TABLE IF NOT EXISTS `split_string_into_rows` (
);

-- --------------------------------------------------------

--
-- Table structure for table `unit_pengguna`
--

DROP TABLE IF EXISTS `unit_pengguna`;
CREATE TABLE IF NOT EXISTS `unit_pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_pengguna` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_pengguna`
--

INSERT INTO `unit_pengguna` (`id`, `unit_pengguna`) VALUES
(1, 'UNIT LAKA'),
(2, 'UNIT LAKA TUNGGAL');

-- --------------------------------------------------------

--
-- Structure for view `split_string_into_rows`
--
DROP TABLE IF EXISTS `split_string_into_rows`;

DROP VIEW IF EXISTS `split_string_into_rows`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `split_string_into_rows`  AS  select straight_join (`n1`.`n` | (`n256`.`n` << 8)) AS `i`,`SET_EXTRACT`((`n1`.`n` | (`n256`.`n` << 8)),`split_string_into_rows`(NULL)) AS `e` from (`number_set` `n1` join `number_set` `n256`) where (1 & ((`n1`.`n` | (`n256`.`n` << 8)) < `SET_COUNT`(`split_string_into_rows`(NULL)))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
