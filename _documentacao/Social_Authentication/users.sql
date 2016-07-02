-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 28, 2016 at 09:49 AM
-- Server version: 5.6.20-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sisdoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id_us` bigint(20) unsigned NOT NULL,
  `us_nome` char(80) NOT NULL,
  `us_email` char(80) NOT NULL,
  `us_password` char(40) NOT NULL,
  `us_cidade` char(40) NOT NULL,
  `us_pais` char(40) NOT NULL,
  `us_badge` char(12) NOT NULL,
  `us_link` char(80) NOT NULL,
  `us_ativo` int(11) NOT NULL,
  `us_image` text NOT NULL,
  `us_genero` char(1) NOT NULL,
  `us_verificado` char(1) NOT NULL,
  `us_autenticador` char(3) NOT NULL,
  `us_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `us_acessos` int(11) NOT NULL,
  `us_erros` int(11) NOT NULL,
  `us_last` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `us_perfil` text,
  `us_perfil_check` char(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_us`, `us_nome`, `us_email`, `us_password`, `us_cidade`, `us_pais`, `us_badge`, `us_link`, `us_ativo`, `us_image`, `us_genero`, `us_verificado`, `us_autenticador`, `us_cadastro`, `us_acessos`, `us_erros`, `us_last`, `us_perfil`, `us_perfil_check`) VALUES
(7, 'Super User Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', '00000007', '', 1, '', '', '', 'MD5', '2016-06-27 02:53:04', 0, 0, '2016-06-27 02:53:04', '', '8f14e45fceea167a5a36dedd4bea2543');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD UNIQUE KEY `id_us` (`id_us`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id_us` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
