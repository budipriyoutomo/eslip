-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 28, 2018 at 10:35 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `st_train`
--
DROP DATABASE `st_train`;
CREATE DATABASE `st_train` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `st_train`;

-- --------------------------------------------------------

--
-- Table structure for table `mdept`
--

DROP TABLE IF EXISTS `mdept`;
CREATE TABLE IF NOT EXISTS `mdept` (
  `iddept` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`iddept`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mdept`
--

INSERT INTO `mdept` (`iddept`, `nama`) VALUES
(1, 'Services'),
(2, 'Kitchen'),
(3, 'IT'),
(4, 'HRD'),
(5, 'Accounting'),
(6, 'Purchasing'),
(7, 'PPIC'),
(8, 'GA');

-- --------------------------------------------------------

--
-- Table structure for table `mjabatan`
--

DROP TABLE IF EXISTS `mjabatan`;
CREATE TABLE IF NOT EXISTS `mjabatan` (
  `idjabatan` tinyint(4) NOT NULL AUTO_INCREMENT,
  `iddept` tinyint(4) DEFAULT NULL,
  `namajabatan` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idjabatan`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `mjabatan`
--

INSERT INTO `mjabatan` (`idjabatan`, `iddept`, `namajabatan`) VALUES
(1, 1, 'Waiter'),
(2, 1, 'Captain'),
(3, 2, 'Cook 1'),
(4, 2, 'Cook 2'),
(5, 2, 'Cook 3'),
(6, 3, 'Staff'),
(7, 3, 'Supervisor');

-- --------------------------------------------------------

--
-- Table structure for table `mpengumuman`
--

DROP TABLE IF EXISTS `mpengumuman`;
CREATE TABLE IF NOT EXISTS `mpengumuman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pengumuman` text NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mpengumuman`
--

INSERT INTO `mpengumuman` (`id`, `pengumuman`, `start`, `end`) VALUES
(1, 'Akan diadakan Training di Head Office', '2018-06-01', '2018-06-30'),
(2, 'Akan diadakan perekrutan untuk kenaikan jabatan dengan syarat wanita dan pria', '2018-06-27', '2018-07-05'),
(3, 'backdate pengumuman', '2018-06-26', '2018-06-30'),
(4, 'future', '2018-07-01', '2018-07-31');

-- --------------------------------------------------------

--
-- Table structure for table `mtraining`
--

DROP TABLE IF EXISTS `mtraining`;
CREATE TABLE IF NOT EXISTS `mtraining` (
  `idtraining` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  `tempat` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `trainer` varchar(30) DEFAULT NULL,
  `kapasitas` tinyint(4) DEFAULT NULL,
  `tersedia` tinyint(4) DEFAULT NULL,
  `terisi` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idtraining`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mtraining`
--

INSERT INTO `mtraining` (`idtraining`, `nama`, `tempat`, `tanggal`, `jam`, `trainer`, `kapasitas`, `tersedia`, `terisi`) VALUES
(1, 'Training Kepemimpinan', 'VIP Sumatra', '2018-06-30', '13:00:00', 'Stevi', 40, 40, 0),
(2, 'Training Leadership', 'Head Office', '2018-06-29', '09:00:00', 'Stevi', 20, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ttraining`
--

DROP TABLE IF EXISTS `ttraining`;
CREATE TABLE IF NOT EXISTS `ttraining` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idtraining` tinyint(4) DEFAULT NULL,
  `iduser` tinyint(4) DEFAULT NULL,
  `kehadiran` char(1) DEFAULT NULL,
  `nilai` char(3) DEFAULT NULL,
  `evaluasi` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ttraining`
--

INSERT INTO `ttraining` (`id`, `idtraining`, `iduser`, `kehadiran`, `nilai`, `evaluasi`) VALUES
(1, 1, 1, '1', '', ''),
(2, 2, 1, '1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` enum('Admin','User','SuperAdmin') DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `pp` varchar(20) DEFAULT NULL,
  `NIK` varchar(10) DEFAULT NULL,
  `dept` varchar(2) DEFAULT NULL,
  `jabatan` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `nama`, `pp`, `NIK`, `dept`, `jabatan`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'SuperAdmin', 'System Administrator', 'an.png', NULL, NULL, NULL),
(2, 'operator', 'fe96dd39756ac41b74283a9292652d366d73931f', 'User', 'Admin ISA', 'an.png', NULL, NULL, NULL),
(4, 'budi', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'Budi Priyo Utomo', 'pp.jpg', NULL, NULL, NULL),
(6, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Admin', 'test1', 'pp.png', NULL, NULL, NULL),
(7, 'topan', '3a9b97b2498230a6bf1e431bc22ff87484918add', 'Admin', 'Asep Topan Suryadi', 'an.png', '1231', '3', '6'),
(8, 'set', '65c10dc3549fe07424148a8a4790a3341ecbc253', 'Admin', 'Se', 'an.png', '134', '2', '3'),
(9, 'set', '65c10dc3549fe07424148a8a4790a3341ecbc253', 'Admin', 'Se', 'an.png', '134', '2', '3'),
(10, 'heru', '2ed1ca789fc3d1db2fb1b65a8906f483a7dc739a', 'Admin', 'heru', 'an.png', '1212231231', '1', '1');
