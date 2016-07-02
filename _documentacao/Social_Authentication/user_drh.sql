-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2016 at 09:21 PM
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
-- Table structure for table `user_drh`
--

CREATE TABLE IF NOT EXISTS `user_drh` (
`id_usd` bigint(20) unsigned NOT NULL,
  `usd_id_us` int(11) NOT NULL,
  `usd_cpf` char(15) NOT NULL,
  `usd_rg` char(15) NOT NULL,
  `usd_rg_emissor` char(20) NOT NULL,
  `usd_rg_dt_emissao` date NOT NULL,
  `usd_pis` char(20) NOT NULL,
  `usd_dt_nasc` date NOT NULL,
  `usd_ct` char(15) NOT NULL,
  `usd_ct_serie` char(15) NOT NULL,
  `usd_dt_admissao` date NOT NULL,
  `usd_dt_demissao` date NOT NULL,
  `usd_cargo` char(30) NOT NULL,
  `usd_departamento` char(30) NOT NULL,
  `usd_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_drh`
--
ALTER TABLE `user_drh`
 ADD UNIQUE KEY `id_usd` (`id_usd`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_drh`
--
ALTER TABLE `user_drh`
MODIFY `id_usd` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
