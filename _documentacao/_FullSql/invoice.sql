-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2016 at 01:57 PM
-- Server version: 5.6.20-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `giga`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
`id_iv` bigint(20) unsigned NOT NULL,
  `iv_numero` char(5) NOT NULL,
  `iv_data` date NOT NULL,
  `iv_hora` varchar(8) NOT NULL,
  `iv_cliente` int(11) NOT NULL,
  `iv_filial` int(11) NOT NULL,
  `iv_situacao` int(11) NOT NULL DEFAULT '1',
  `iv_emissor` int(11) NOT NULL,
  `iv_cod_op_fiscal` char(8) NOT NULL,
  `iv_iss` float NOT NULL,
  `iv_icms` float NOT NULL,
  `iv_ipi` float NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id_iv`, `iv_numero`, `iv_data`, `iv_hora`, `iv_cliente`, `iv_filial`, `iv_situacao`, `iv_emissor`, `iv_cod_op_fiscal`, `iv_iss`, `iv_icms`, `iv_ipi`) VALUES
(1, '00001', '2016-08-22', '', 4, 1, 1, 1, 'LOCACAO', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
 ADD UNIQUE KEY `id_iv` (`id_iv`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
MODIFY `id_iv` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
