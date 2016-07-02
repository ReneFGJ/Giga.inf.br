-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 01, 2016 at 12:26 PM
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
-- Table structure for table `prazo_entrega`
--

CREATE TABLE IF NOT EXISTS `prazo_entrega` (
`id_pz` bigint(20) unsigned NOT NULL,
  `pz_nome` char(80) NOT NULL,
  `pz_ativo` int(1) NOT NULL DEFAULT '1',
  `pz_seq` int(11) NOT NULL,
  `pz_visivel` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `prazo_entrega`
--

INSERT INTO `prazo_entrega` (`id_pz`, `pz_nome`, `pz_ativo`, `pz_seq`, `pz_visivel`) VALUES
(1, '::Não aplicável::', 1, 1, 0),
(2, 'pronta entrega', 1, 1, 1),
(3, '10 a 15 dias', 1, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prazo_entrega`
--
ALTER TABLE `prazo_entrega`
 ADD UNIQUE KEY `id_pz` (`id_pz`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prazo_entrega`
--
ALTER TABLE `prazo_entrega`
MODIFY `id_pz` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
