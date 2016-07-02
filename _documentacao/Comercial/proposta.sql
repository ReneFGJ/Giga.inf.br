-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2016 at 09:20 PM
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
-- Table structure for table `proposta`
--

CREATE TABLE IF NOT EXISTS `proposta` (
`id_po` bigint(20) unsigned NOT NULL,
  `pp_nr` char(10) NOT NULL,
  `pp_ano` char(4) NOT NULL,
  `pp_situacao` int(11) NOT NULL,
  `pp_cliente` int(11) NOT NULL,
  `pp_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pp_vendor` int(11) NOT NULL,
  `pp_condicoes` int(11) NOT NULL,
  `pp_garantia` int(11) NOT NULL,
  `pp_validade_proposta` int(11) NOT NULL,
  `pp_montagem` int(11) NOT NULL,
  `pp_obs` text NOT NULL,
  `pp_evento` int(11) NOT NULL,
  `pp_local_entrega` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `proposta`
--
ALTER TABLE `proposta`
 ADD UNIQUE KEY `id_po` (`id_po`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `proposta`
--
ALTER TABLE `proposta`
MODIFY `id_po` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
