-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 09, 2018 at 10:09 AM
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
-- Table structure for table `produto_agenda_status`
--

CREATE TABLE IF NOT EXISTS `produto_agenda_status` (
`id_pas` bigint(20) unsigned NOT NULL,
  `pas_descricao` char(100) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `produto_agenda_status`
--

INSERT INTO `produto_agenda_status` (`id_pas`, `pas_descricao`) VALUES
(1, 'Reservado'),
(2, 'Locado'),
(3, 'Devolvido'),
(9, 'Cancelado');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produto_agenda_status`
--
ALTER TABLE `produto_agenda_status`
 ADD UNIQUE KEY `id_pas` (`id_pas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produto_agenda_status`
--
ALTER TABLE `produto_agenda_status`
MODIFY `id_pas` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
