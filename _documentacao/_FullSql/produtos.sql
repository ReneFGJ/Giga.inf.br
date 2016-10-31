-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2016 at 05:38 PM
-- Server version: 5.6.20-log
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `giga`
--

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE `produtos` (
  `id_pr` bigint(20) UNSIGNED NOT NULL,
  `pr_produto` int(11) NOT NULL,
  `pr_categoria` int(11) NOT NULL,
  `pr_patrimonio` char(30) NOT NULL,
  `pr_serial` char(20) NOT NULL,
  `pr_marca` int(11) NOT NULL,
  `pr_modelo` char(80) NOT NULL,
  `pr_tag` char(20) NOT NULL,
  `pr_fornecedor` int(11) NOT NULL,
  `pr_nf` varchar(10) NOT NULL,
  `pr_nf_data` date NOT NULL,
  `pr_vlr_custo` float NOT NULL,
  `pr_dt_baixa` date NOT NULL,
  `pr_filial` int(11) NOT NULL,
  `pr_cliente` int(11) NOT NULL,
  `pr_cliente_dt` date NOT NULL,
  `pr_doc` int(11) NOT NULL,
  `pr_ativo` int(11) NOT NULL DEFAULT '1',
  `pr_data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pr_etiqueta` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD UNIQUE KEY `id_pr` (`id_pr`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_pr` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
