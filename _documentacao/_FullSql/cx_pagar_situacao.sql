-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 22, 2016 at 12:17 PM
-- Server version: 5.5.41-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `giga`
--

-- --------------------------------------------------------

--
-- Table structure for table `cx_pagar_situacao`
--

CREATE TABLE IF NOT EXISTS `cx_pagar_situacao` (
  `id_cpa` bigint(20) unsigned NOT NULL,
  `cpa_descricao` char(80) NOT NULL,
  `cpa_ativo` int(1) NOT NULL DEFAULT '1',
  `cpa_classe` char(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cx_pagar_situacao`
--

INSERT INTO `cx_pagar_situacao` (`id_cpa`, `cpa_descricao`, `cpa_ativo`, `cpa_classe`) VALUES
(1, 'Aberto', 1, 'danger'),
(2, 'Pago', 1, 'success'),
(3, 'Atrasado', 1, 'danger'),
(99, 'Cancelado', 1, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cx_pagar_situacao`
--
ALTER TABLE `cx_pagar_situacao`
  ADD UNIQUE KEY `id_cpa` (`id_cpa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cx_pagar_situacao`
--
ALTER TABLE `cx_pagar_situacao`
  MODIFY `id_cpa` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
