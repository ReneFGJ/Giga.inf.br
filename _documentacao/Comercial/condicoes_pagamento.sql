-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 01, 2016 at 12:26 PM
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
-- Table structure for table `condicoes_pagamento`
--

CREATE TABLE IF NOT EXISTS `condicoes_pagamento` (
`id_pg` bigint(20) unsigned NOT NULL,
  `pg_nome` char(80) NOT NULL,
  `pg_ativo` int(11) NOT NULL DEFAULT '1',
  `pg_seq` int(11) NOT NULL,
  `pg_visivel` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `condicoes_pagamento`
--

INSERT INTO `condicoes_pagamento` (`id_pg`, `pg_nome`, `pg_ativo`, `pg_seq`, `pg_visivel`) VALUES
(1, '28 Dias', 1, 0, 1),
(2, 'Contra apresentação', 1, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `condicoes_pagamento`
--
ALTER TABLE `condicoes_pagamento`
 ADD UNIQUE KEY `id_pg` (`id_pg`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `condicoes_pagamento`
--
ALTER TABLE `condicoes_pagamento`
MODIFY `id_pg` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
