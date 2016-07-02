-- phpgyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpgyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 01, 2016 at 12:26 pg
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
-- Table structure for table `prazo_garantia`
--

CREATE TABLE IF NOT EXISTS `prazo_garantia` (
`id_pg` bigint(20) unsigned NOT NULL,
  `pg_nome` char(80) NOT NULL,
  `pg_ativo` int(1) NOT NULL DEFAULT '1',
  `pg_seq` int(11) NOT NULL,
  `pg_visivel` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `prazo_garantia`
--

INSERT INTO `prazo_garantia` (`id_pg`, `pg_nome`, `pg_ativo`, `pg_seq`, `pg_visivel`) VALUES
(1, '::Não aplicável::', 1, 1, 0),
(2, 'Durante o período de locação', 1, 1, 1),
(3, '1 Ano de substituição de peças, serviço e atendimento Onsite', 1, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prazo_garantia`
--
ALTER TABLE `prazo_garantia`
 ADD UNIQUE KEY `id_pg` (`id_pg`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prazo_garantia`
--
ALTER TABLE `prazo_garantia`
MODIFY `id_pg` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
