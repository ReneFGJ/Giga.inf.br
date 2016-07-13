-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2016 at 12:46 AM
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
-- Table structure for table `clientes_contatos`
--

CREATE TABLE IF NOT EXISTS `clientes_contatos` (
`id_cc` bigint(20) unsigned NOT NULL,
  `cc_cliente_id` int(11) NOT NULL,
  `cc_nome` char(80) NOT NULL,
  `cc_telefone` char(20) NOT NULL,
  `cc_email` char(80) NOT NULL,
  `cc_ativo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `clientes_contatos`
--

INSERT INTO `clientes_contatos` (`id_cc`, `cc_cliente_id`, `cc_nome`, `cc_telefone`, `cc_email`, `cc_ativo`) VALUES
(1, 4131, 'Rene Faustino Gabriel junior', '(41)8811.9061', 'renefgj@gmail.com', 1),
(2, 4131, 'Viviane de Fátima Tulio', '8866.6389', 'vivianetulio@gmail.com', 1),
(3, 4131, 'Andre Vitor Gabriel', '', 'andrevitor.gabriel@gmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes_contatos`
--
ALTER TABLE `clientes_contatos`
 ADD UNIQUE KEY `id_cc` (`id_cc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes_contatos`
--
ALTER TABLE `clientes_contatos`
MODIFY `id_cc` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
