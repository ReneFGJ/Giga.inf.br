-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2016 at 11:37 AM
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
-- Table structure for table `contrato_modelo`
--

CREATE TABLE IF NOT EXISTS `contrato_modelo` (
`id_c` bigint(20) unsigned NOT NULL,
  `c_descricao` char(80) NOT NULL,
  `c_contrato` longtext NOT NULL,
  `c_ativo` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contrato_modelo`
--

INSERT INTO `contrato_modelo` (`id_c`, `c_descricao`, `c_contrato`, `c_ativo`) VALUES
(1, 'Contrato de Locação', '<h3>CLÁUSULA PRIMEIRA</h3>\r\n<p>A locadora, sendo proprietária dos equipamentos designados no item 01, loca-os à locatária pelo período designado no item 02. O valor da locação ora ajustada descrito no item 02, deverá será conforme item 02. </p>\r\n\r\n<h3>CLÁUSULA SEGUNDA</h3>\r\n<p>A locatária declara que recebe os equipamentos em perfeito estado, aparência e funcionamento, isentando a locadora de eventuais prejuízos que lhe possam advir, na hipótese do equipamento apresentar defeito quando em uso. </p>\r\n\r\n<h3>CLÁUSULA TERCEIRA</h3>\r\n<p>A locatária assume de forma expressa e completa, a total responsabilidade pelos equipamentos ora locados obrigando-se a devolvê-los no mesmo estado e condições em que foram recebidos, declarando-se ainda responsável pela ocorrência de qualquer dano físico, eletrônico ou mecânico causado aos equipamentos, obrigando-se, nesta hipótese, a ressarcir a locadora dos prejuízos decorrentes.</p>\r\n\r\n<h3>PARÁGRAFO PRIMEIRO</h3>\r\n<p>A presente locação não inclui sistema de alimentação tipo gerador de energia, sendo assim qualquer problema referente à instalação elétrica, ou falta de energia, não será de responsabilidade da locadora. </p>\r\n\r\n<h3>PARÁGRAFO SEGUNDO</h3>\r\n<p>É de extrema importância que a instalação dos equipamentos para o evento solicitado seja feita com no mínimo 24 horas de antecedência, para evitar devidos problemas. Sendo de inteira responsabilidade de a locatária disponibilizar o espaço para montagem. Isentando a locadora de devidos atrasos. </p>\r\n\r\n<h3>CLÁUSULA QUARTA</h3>\r\n<p>Correm por conta da locatária todas as despesas referente à substituição, de equipamentos danificados durante o evento. </p>\r\n\r\n<h3>CLÁUSULA QUINTA</h3>\r\n<p>A locadora reserva-se o direito de examinar os equipamentos, quando for de sua exclusiva conveniência, verificando a manutenção da aparência e funcionamento, bem como sua correta utilização e operação. </p>\r\n\r\n<h3>CLÁUSULA SEXTA</h3>\r\n<p>Todo equipamento locado por selos identificadores da garantia, não podendo a locatária, em hipótese alguma, violar quaisquer deles, sob pena de ter que pagar à locadora o seu valor de mercado, condições em que o equipamento violado será transferido em definitivo para a locatária. </p>\r\n\r\n<h3>CLÁUSULA SÉTIMA</h3>\r\n<p>A locatária obriga-se a utilizar os equipamentos para fins lícitos, observando, sempre, os usos e bons costumes, além de proceder à manutenção como se seus fossem mantendo-os sempre bem cuidados, ressalvando o desgaste natural decorrente do uso normal. </p>\r\n\r\n<h3>CLÁUSULA OITAVA</h3>\r\n<p>Caso a locatária não promova a devolução dos equipamentos no prazo previsto na cláusula primeira o presente contrato ficará automaticamente prorrogado, até a efetiva devolução dos bens locados, devendo, então a locatária pagar o valor correspondente ao período da prorrogação. </p>\r\n\r\n<h3>PARÁGRAFO TERCEIRO</h3>\r\n<p>Na hipótese de ocorrências, como, furto, perda, extravio, apropriação indébita, quebra mecânica, etc., a locatária, compromete-se a pagar o valor diário da locação estipulado na cláusula primeira, até a efetiva reposição dos equipamentos, que deverá ocorrer no prazo máximo de 15 dias após o término da locação. </p>\r\n\r\n<h3>PARÁGRAFO QUARTO</h3>\r\n<p>Para fins de ressarcimento do prejuízo, as partes desde já acordam que será devido pela locatária, o valor estipulado o item 02 deste instrumento. </p>\r\n\r\n<h3>CLÁUSULA NONA</h3>\r\n<p>A reserva do equipamento e a vigência deste contrato está sujeita à aprovação prévia do cadastro da locatária. </p>\r\n\r\n<h3>CLÁUSULA DÉCIMA</h3>\r\n<p>A locadora se responsabiliza pelo transporte, e assistência técnica no periodo de locação dos equipamentos descritos no item 01 deste instrumento. </p>\r\n\r\n<h3>CLÁUSULA DÉCIMA - PRIMEIRA</h3>\r\n<p>Nos casos omissos ou não previstos neste instrumento será aplicada a legislação pertinente, sendo que as partes desde já, elegem o foro da comarca de Curitiba, como a competente para dirimir quaisquer dúvidas ou divergências decorrentes deste contrato, renunciando a qualquer outro por mais privilegiado que seja. E por estarem assim justos e contratados, as contratantes assinam o presente instrumento em duas vias de igual teor e forma, na presença das testemunhas abaixo nomeadas. </p>\r\n', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contrato_modelo`
--
ALTER TABLE `contrato_modelo`
 ADD UNIQUE KEY `id_c` (`id_c`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contrato_modelo`
--
ALTER TABLE `contrato_modelo`
MODIFY `id_c` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
