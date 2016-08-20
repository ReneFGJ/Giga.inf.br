-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2016 at 11:13 AM
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
-- Table structure for table `pedido_contato`
--

CREATE TABLE IF NOT EXISTS `pedido_contato` (
`id_pct` bigint(20) unsigned NOT NULL,
  `pct_id_pp` int(11) NOT NULL,
  `pct_id_contato` int(11) NOT NULL,
  `pct_ativo` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pedido_contato`
--
ALTER TABLE `pedido_contato`
 ADD UNIQUE KEY `id_pct` (`id_pct`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pedido_contato`
--
ALTER TABLE `pedido_contato`
MODIFY `id_pct` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
