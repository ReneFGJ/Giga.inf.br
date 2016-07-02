-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2016 at 12:03 AM
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
-- Table structure for table `cx_receber`
--

CREATE TABLE IF NOT EXISTS `cx_receber` (
`id_cp` bigint(20) unsigned NOT NULL,
  `cp_data` date NOT NULL,
  `cp_vencimento` date NOT NULL,
  `cp_doc` char(15) NOT NULL,
  `cp_valor` float NOT NULL,
  `cp_valor_pago` float NOT NULL,
  `cp_conta` int(11) NOT NULL,
  `cp_contal_old` char(3) NOT NULL,
  `cp_fornecedor` int(11) NOT NULL,
  `cp_pedido` char(15) NOT NULL,
  `cp_dt_pagamento` date NOT NULL,
  `cp_log_pagamento` int(11) NOT NULL,
  `cp_situacao` int(11) NOT NULL,
  `cp_img` char(20) NOT NULL,
  `cp_empresa` int(11) NOT NULL,
  `cp_historico` char(80) NOT NULL,
  `cp_auto` int(11) NOT NULL,
  `cp_parcela_atual` int(11) NOT NULL,
  `cp_parcela_total` int(11) NOT NULL,
  `cp_forma_pagamento` int(11) NOT NULL,
  `cp_previsao` int(11) NOT NULL DEFAULT '0',
  `cp_nossonumero` char(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cx_receber`
--
ALTER TABLE `cx_receber`
 ADD UNIQUE KEY `id_cp` (`id_cp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cx_receber`
--
ALTER TABLE `cx_receber`
MODIFY `id_cp` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
