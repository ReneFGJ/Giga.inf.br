-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2016 at 04:28 PM
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
-- Table structure for table `invoice_nrs`
--

CREATE TABLE IF NOT EXISTS `invoice_nrs` (
`id_nrs` bigint(20) unsigned NOT NULL,
  `nrs_nr` char(8) NOT NULL,
  `nrs_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nrs_id` int(11) NOT NULL,
  `nrs_cliente` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=302 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice_nrs`
--
ALTER TABLE `invoice_nrs`
 ADD UNIQUE KEY `id_nrs` (`id_nrs`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice_nrs`
--
ALTER TABLE `invoice_nrs`
MODIFY `id_nrs` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=302;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
