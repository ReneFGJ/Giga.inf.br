-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2016 at 09:16 PM
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
-- Table structure for table `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
`id_f` bigint(20) unsigned NOT NULL,
  `f_razao_social` char(200) NOT NULL,
  `f_nome_fantasia` char(200) NOT NULL,
  `f_cnpj` char(20) NOT NULL,
  `f_ie` char(20) NOT NULL,
  `f_im` char(20) NOT NULL,
  `f_logradouro` char(100) NOT NULL,
  `f_numero` char(20) NOT NULL,
  `f_complemento` char(20) NOT NULL,
  `f_bairro` char(30) NOT NULL,
  `f_cidade` char(30) NOT NULL,
  `f_estado` char(2) NOT NULL,  
  `f_cep` char(10) NOT NULL,
  `f_fone_1` char(15) NOT NULL,
  `f_fone_2` char(15) NOT NULL,
  `f_email` char(80) NOT NULL,
  `f_email_cobranca` char(80) NOT NULL,
  `f_ativo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
 ADD UNIQUE KEY `id_f` (`id_f`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
MODIFY `id_f` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
