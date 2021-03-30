-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 17, 2018 at 11:11 AM
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
CREATE DATABASE `st_train` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `st_train`;

-- --------------------------------------------------------

--
-- Table structure for table `mdept`
--

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
(2, 'Akan diadakan perekrutan untuk kenaikan jabatan dengan syarat wanita dan pria', '2018-06-27', '2018-07-18'),
(3, 'backdate pengumuman', '2018-06-26', '2018-06-30'),
(4, 'future', '2018-07-01', '2018-07-31');

-- --------------------------------------------------------

--
-- Table structure for table `mtraining`
--

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
(1, 'Training Kepemimpinan', 'VIP Sumatra', '2018-06-30', '13:00:00', 'Stevi', 40, 39, 1),
(2, 'Training Leadership', 'Head Office', '2018-06-29', '09:00:00', 'Stevi', 20, 19, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `rraport`
--
CREATE TABLE IF NOT EXISTS `rraport` (
`training` varchar(30)
,`iduser` int(11)
,`peserta` varchar(100)
,`NIK` varchar(10)
,`dept` varchar(2)
,`jabatan` varchar(2)
,`nilai` char(3)
,`evaluasi` text
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `rtraining`
--
CREATE TABLE IF NOT EXISTS `rtraining` (
`nilai` char(3)
,`evaluasi` text
,`idtraining` tinyint(4)
,`namatraining` varchar(30)
,`tempat` varchar(50)
,`tanggal` date
,`jam` time
,`trainer` varchar(30)
,`terisi` tinyint(4)
,`peserta` varchar(100)
,`dept` varchar(2)
,`jabatan` varchar(2)
);
-- --------------------------------------------------------

--
-- Table structure for table `ttraining`
--

CREATE TABLE IF NOT EXISTS `ttraining` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idtraining` tinyint(4) DEFAULT NULL,
  `iduser` tinyint(4) DEFAULT NULL,
  `kehadiran` char(1) DEFAULT NULL,
  `nilai` char(3) DEFAULT NULL,
  `evaluasi` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ttraining`
--

INSERT INTO `ttraining` (`id`, `idtraining`, `iduser`, `kehadiran`, `nilai`, `evaluasi`) VALUES
(1, 1, 1, '1', '90', 'yuk'),
(2, 2, 1, '1', '90', 'yuk'),
(3, 2, 1, '1', '80', 'weds'),
(4, 1, 1, '1', '76', 'kuy');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

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

-- --------------------------------------------------------

--
-- Structure for view `rraport`
--
DROP TABLE IF EXISTS `rraport`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rraport` AS (select `mtraining`.`nama` AS `training`,`user`.`id` AS `iduser`,`user`.`nama` AS `peserta`,`user`.`NIK` AS `NIK`,`user`.`dept` AS `dept`,`user`.`jabatan` AS `jabatan`,`ttraining`.`nilai` AS `nilai`,`ttraining`.`evaluasi` AS `evaluasi` from ((`user` join `ttraining`) join `mtraining`) where ((`user`.`id` = `ttraining`.`iduser`) and (`mtraining`.`idtraining` = `ttraining`.`idtraining`)));

-- --------------------------------------------------------

--
-- Structure for view `rtraining`
--
DROP TABLE IF EXISTS `rtraining`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rtraining` AS (select `ttraining`.`nilai` AS `nilai`,`ttraining`.`evaluasi` AS `evaluasi`,`mtraining`.`idtraining` AS `idtraining`,`mtraining`.`nama` AS `namatraining`,`mtraining`.`tempat` AS `tempat`,`mtraining`.`tanggal` AS `tanggal`,`mtraining`.`jam` AS `jam`,`mtraining`.`trainer` AS `trainer`,`mtraining`.`terisi` AS `terisi`,`user`.`nama` AS `peserta`,`user`.`dept` AS `dept`,`user`.`jabatan` AS `jabatan` from ((`ttraining` join `mtraining`) join `user`) where ((`ttraining`.`idtraining` = `mtraining`.`idtraining`) and (`ttraining`.`iduser` = `user`.`id`)));
