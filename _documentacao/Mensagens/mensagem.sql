-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2016 at 11:41 AM
-- Server version: 5.6.20-log
-- PHP Version: 5.4.31

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
-- Table structure for table `mensagem`
--

CREATE TABLE IF NOT EXISTS `mensagem` (
`id_nw` bigint(20) unsigned NOT NULL,
  `nw_titulo` char(250) NOT NULL,
  `nw_ref` char(30) NOT NULL,
  `nw_texto` longtext NOT NULL,
  `nw_dt_cadastro` date NOT NULL DEFAULT '0000-00-00',
  `nw_own` char(10) NOT NULL COMMENT '(criar tabela de vinculo) IC - iniciação cientifica ICJr - Iniciação científica junior CIP - Centro Integrado de Pesquisa DGP - Diretórios do grupo de pesquisa',
  `nw_ativo` tinyint(1) NOT NULL,
  `nw_formato` char(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=189 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mensagem`
--
ALTER TABLE `mensagem`
 ADD UNIQUE KEY `id_nw` (`id_nw`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mensagem`
--
ALTER TABLE `mensagem`
MODIFY `id_nw` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=189;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
