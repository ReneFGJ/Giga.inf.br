-- phpMyAdmin SQL Dump
-- version 4.4.8
-- http://www.phpmyadmin.net
--
-- Host: mariadb.pro.pucpr.br
-- Generation Time: Jun 27, 2016 at 12:17 AM
-- Server version: 10.0.21-MariaDB-wsrep
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cip`
--

-- --------------------------------------------------------

--
-- Table structure for table `logins_perfil_ativo`
--

CREATE TABLE IF NOT EXISTS `logins_perfil_ativo` (
  `id_up` bigint(20) unsigned NOT NULL,
  `up_perfil` tinyint(4) DEFAULT '0',
  `up_data` date DEFAULT '0000-00-00',
  `up_data_end` date DEFAULT '0000-00-00',
  `up_ativo` tinyint(11) DEFAULT NULL,
  `up_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logins_perfil_ativo`
--
ALTER TABLE `logins_perfil_ativo`
  ADD UNIQUE KEY `id_up` (`id_up`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logins_perfil_ativo`
--
ALTER TABLE `logins_perfil_ativo`
  MODIFY `id_up` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
