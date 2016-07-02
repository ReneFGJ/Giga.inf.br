-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 01, 2016 at 11:52 PM
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
-- Table structure for table `cx_conta_codigo`
--

CREATE TABLE IF NOT EXISTS `cx_conta_codigo` (
`id_cd` bigint(20) unsigned NOT NULL,
  `cd_codigo` char(4) NOT NULL,
  `cd_descricao` char(80) NOT NULL,
  `cd_cod_contabil` char(10) NOT NULL,
  `cd_ativo` int(11) NOT NULL DEFAULT '1',
  `cd_cpage` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `cx_conta_codigo`
--

INSERT INTO `cx_conta_codigo` (`id_cd`, `cd_codigo`, `cd_descricao`, `cd_cod_contabil`, `cd_ativo`, `cd_cpage`) VALUES
(1, 'PRO', 'Produto para Venda', '', 1, 1),
(2, 'SAL', 'Salário', '', 1, 1),
(3, 'VTR', 'Vale transporte', '', 1, 1),
(4, 'VLR', 'Vale refeição', '', 1, 1),
(5, 'PAP', 'Papelaria', '', 1, 1),
(6, 'LIM', 'Material de limpeza / cafe', '', 1, 1),
(7, 'TER', 'Mão de obra tercerizada', '', 1, 1),
(8, 'INV', 'Investimento & Imobilizado', '', 1, 1),
(9, 'BCO', 'Transferência para Banco / Depósito', '', 1, 1),
(10, 'ALU', 'Aluguel', '', 1, 1),
(11, 'LAT', 'Luz, água ou telefone', '', 1, 1),
(12, 'PRO', 'Pro-labore sócios', '', 1, 1),
(13, 'CTB', 'Contabilidade', '', 0, 1),
(14, 'VDO', 'Venda de produto', '', 1, 2),
(15, 'ASS', 'Mão de obra assistência técnica', '', 1, 2),
(16, 'LOC', 'Locação', '', 1, 2),
(17, 'CART', 'Caixa 1', '', 1, 3),
(18, 'BITA', 'Boleto Itaú', '', 1, 3),
(19, 'CH1', 'Pagamento em Cheque Banco do Brasil', '', 1, 4),
(20, 'CH2', 'Pagamento em Cheque Itaú', '', 1, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cx_conta_codigo`
--
ALTER TABLE `cx_conta_codigo`
 ADD UNIQUE KEY `id_cd` (`id_cd`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cx_conta_codigo`
--
ALTER TABLE `cx_conta_codigo`
MODIFY `id_cd` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
