-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 03, 2016 at 05:16 PM
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
-- Table structure for table `cc_banco`
--

CREATE TABLE IF NOT EXISTS `cc_banco` (
`id_cc` bigint(20) unsigned NOT NULL,
  `cc_nome` char(40) NOT NULL,
  `cc_agencia` char(8) NOT NULL,
  `cc_conta` char(20) NOT NULL,
  `cc_operacao` char(5) NOT NULL,
  `cc_empresa` int(11) NOT NULL,
  `cc_ativo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cc_banco`
--

INSERT INTO `cc_banco` (`id_cc`, `cc_nome`, `cc_agencia`, `cc_conta`, `cc_operacao`, `cc_empresa`, `cc_ativo`) VALUES
(1, 'Caixa / Carteira', '', '', '', 0, 1),
(2, 'Banco Itaú', '', '', '', 1, 1),
(3, 'Banco do Brasil', '', '', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
`id_f` bigint(20) unsigned NOT NULL,
  `f_tipo` int(11) NOT NULL COMMENT '1 - Pessoa Juridica, 2 - Pessoa Física',
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
  `f_ativo` int(11) NOT NULL DEFAULT '1',
  `f_obs` text NOT NULL,
  `f_vendor` int(11) NOT NULL DEFAULT '0',
  `f_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `f_fornecedor` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_f`, `f_tipo`, `f_razao_social`, `f_nome_fantasia`, `f_cnpj`, `f_ie`, `f_im`, `f_logradouro`, `f_numero`, `f_complemento`, `f_bairro`, `f_cidade`, `f_estado`, `f_cep`, `f_fone_1`, `f_fone_2`, `f_email`, `f_email_cobranca`, `f_ativo`, `f_obs`, `f_vendor`, `f_created`, `f_fornecedor`) VALUES
(1, 2, 'Rene Faustino Gabriel Junior', 'Rene Faustino Gabriel Junior', '72952105987', '38253557', '', '', '', '', '', '', 'PR', '80710000', '', '', '', '', 1, '', 0, '2016-08-03 00:36:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clientes_contatos`
--

CREATE TABLE IF NOT EXISTS `clientes_contatos` (
`id_cc` bigint(20) unsigned NOT NULL,
  `cc_cliente_id` int(11) NOT NULL,
  `cc_nome` char(80) NOT NULL,
  `cc_funcao` int(11) NOT NULL,
  `cc_telefone` char(20) NOT NULL,
  `cc_email` char(80) NOT NULL,
  `cc_ativo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `clientes_contatos`
--

INSERT INTO `clientes_contatos` (`id_cc`, `cc_cliente_id`, `cc_nome`, `cc_funcao`, `cc_telefone`, `cc_email`, `cc_ativo`) VALUES
(1, 1, 'Rene Junior', 2, '4188119061', 'renefgj@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clientes_mensagem`
--

CREATE TABLE IF NOT EXISTS `clientes_mensagem` (
`id_msg` bigint(20) unsigned NOT NULL,
  `msg_cliente_id` int(11) NOT NULL,
  `msg_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg_user` int(11) NOT NULL,
  `msg_text` longtext NOT NULL,
  `msg_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `condicoes_pagamento`
--

INSERT INTO `condicoes_pagamento` (`id_pg`, `pg_nome`, `pg_ativo`, `pg_seq`, `pg_visivel`) VALUES
(1, '-- não aplicável --', 1, 0, 0),
(2, 'Contra apresentação', 1, 0, 1),
(3, 'Boleto 28 dias', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contato_funcao`
--

CREATE TABLE IF NOT EXISTS `contato_funcao` (
`id_ct` bigint(20) unsigned NOT NULL,
  `ct_nome` char(40) NOT NULL,
  `ct_ativo` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `contato_funcao`
--

INSERT INTO `contato_funcao` (`id_ct`, `ct_nome`, `ct_ativo`) VALUES
(1, 'Financeiro', 1),
(2, 'Dono da empresa', 1),
(3, 'Comercial', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cx_caixa`
--

CREATE TABLE IF NOT EXISTS `cx_caixa` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

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
(19, 'BC1', 'Pagamento em Cheque', '', 1, 4),
(20, 'BC2', 'Transferência por DOC', '', 1, 4),
(21, 'BC3', 'Pagamento eletrônico', '', 1, 4),
(22, 'PRL', 'PRL', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cx_pagar`
--

CREATE TABLE IF NOT EXISTS `cx_pagar` (
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
  `cp_parcela` char(10) NOT NULL,
  `cp_forma_pagamento` int(11) NOT NULL,
  `cp_previsao` int(11) NOT NULL DEFAULT '0',
  `cp_nossonumero` char(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `logins_log`
--

CREATE TABLE IF NOT EXISTS `logins_log` (
`id_ul` bigint(20) unsigned NOT NULL,
  `ul_us` int(11) NOT NULL,
  `ul_data` timestamp NOT NULL,
  `ul_ip` char(15) NOT NULL,
  `ul_proto` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `logins_perfil`
--

CREATE TABLE IF NOT EXISTS `logins_perfil` (
`id_usp` bigint(20) unsigned NOT NULL,
  `usp_codigo` char(4) DEFAULT NULL,
  `usp_descricao` char(50) DEFAULT NULL,
  `usp_ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `logins_perfil`
--

INSERT INTO `logins_perfil` (`id_usp`, `usp_codigo`, `usp_descricao`, `usp_ativo`) VALUES
(1, '#ADM', 'Administrador do Sistema', 1),
(2, '#GEC', 'Gestor Comercial', 1),
(3, '#GEF', 'Gestor Financeiro', 1),
(4, '#GEA', 'Gestor da Assistência Técnica (laboratório)', 1),
(5, '#GEO', 'Gestor de Assistência Técnica (Onsite)', 1),
(6, '#RPC', 'Representante Comercial', 1),
(7, '#DRH', 'Gestor de DRH', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logins_perfil_ativo`
--

CREATE TABLE IF NOT EXISTS `logins_perfil_ativo` (
`id_up` bigint(20) unsigned NOT NULL,
  `up_perfil` tinyint(4) DEFAULT '0',
  `up_data` date DEFAULT '0000-00-00',
  `up_data_end` date DEFAULT '0000-00-00',
  `up_ativo` tinyint(11) DEFAULT NULL,
  `up_user` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `logins_perfil_ativo`
--

INSERT INTO `logins_perfil_ativo` (`id_up`, `up_perfil`, `up_data`, `up_data_end`, `up_ativo`, `up_user`) VALUES
(1, 1, '2016-07-27', '0000-00-00', 1, 8),
(2, 3, '2016-07-27', '0000-00-00', 1, 21);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191 ;

--
-- Dumping data for table `mensagem`
--

INSERT INTO `mensagem` (`id_nw`, `nw_titulo`, `nw_ref`, `nw_texto`, `nw_dt_cadastro`, `nw_own`, `nw_ativo`, `nw_formato`) VALUES
(189, 'Cabeçalho do Pedido', 'PED_2', '$CLIENTE_DADOS', '2016-07-28', '10', 1, 'TEXT'),
(190, 'Cabeçalho do Orçamento', 'PED_1', '$data\r\nA\r\n$f_nome_fantasia\r\n\r\nEstamos encaminhando proposta comercial com os itens:', '2016-07-28', '10', 1, 'TEXT');

-- --------------------------------------------------------

--
-- Table structure for table `mensagem_own`
--

CREATE TABLE IF NOT EXISTS `mensagem_own` (
`id_m` bigint(20) unsigned NOT NULL,
  `m_descricao` char(150) NOT NULL,
  `m_header` char(150) NOT NULL,
  `m_foot` char(150) NOT NULL,
  `m_ativo` tinyint(4) NOT NULL,
  `m_email` char(100) NOT NULL,
  `m_own_cod` char(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `mensagem_own`
--

INSERT INTO `mensagem_own` (`id_m`, `m_descricao`, `m_header`, `m_foot`, `m_ativo`, `m_email`, `m_own_cod`) VALUES
(10, 'Giga', '', '', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
`id_pp` bigint(20) unsigned NOT NULL,
  `pp_tipo_pedido` int(11) NOT NULL,
  `pp_nr` char(10) NOT NULL,
  `pp_ano` char(4) NOT NULL,
  `pp_situacao` int(11) NOT NULL DEFAULT '0',
  `pp_cliente` int(11) NOT NULL,
  `pp_cliente_faturamento` int(11) NOT NULL DEFAULT '0',
  `pp_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pp_vendor` int(11) NOT NULL,
  `pp_condicoes` int(11) NOT NULL DEFAULT '1',
  `pp_prazo_entrega` int(11) NOT NULL DEFAULT '1',
  `pp_garantia` int(11) NOT NULL DEFAULT '1',
  `pp_validade_ppdido` int(11) NOT NULL DEFAULT '1',
  `pp_montagem` int(11) NOT NULL DEFAULT '1',
  `pp_periodo_locacao` int(11) NOT NULL DEFAULT '0',
  `pp_obs` text NOT NULL,
  `pp_evento` text NOT NULL,
  `pp_local_entrega` text NOT NULL,
  `pp_dt_ini_evento` date NOT NULL,
  `pp_dt_fim_evento` date NOT NULL,
  `pp_valor` float NOT NULL DEFAULT '0',
  `pp_validade_proposta` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pedido`
--

INSERT INTO `pedido` (`id_pp`, `pp_tipo_pedido`, `pp_nr`, `pp_ano`, `pp_situacao`, `pp_cliente`, `pp_cliente_faturamento`, `pp_data`, `pp_vendor`, `pp_condicoes`, `pp_prazo_entrega`, `pp_garantia`, `pp_validade_ppdido`, `pp_montagem`, `pp_periodo_locacao`, `pp_obs`, `pp_evento`, `pp_local_entrega`, `pp_dt_ini_evento`, `pp_dt_fim_evento`, `pp_valor`, `pp_validade_proposta`) VALUES
(1, 1, '0000001', '16', 1, 1, 0, '2016-08-03 01:25:18', 8, 3, 1, 2, 1, 1, 0, '', '', '', '0000-00-00', '0000-00-00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pedido_itens`
--

CREATE TABLE IF NOT EXISTS `pedido_itens` (
`id_pi` bigint(20) unsigned NOT NULL,
  `pi_nr` int(11) NOT NULL,
  `pi_seq` int(11) NOT NULL,
  `pi_produto` char(100) NOT NULL,
  `pi_descricao` text NOT NULL,
  `pi_quant` float NOT NULL,
  `pi_valor_unit` int(11) NOT NULL,
  `pi_vendor` int(11) NOT NULL,
  `pi_ativo` int(11) NOT NULL DEFAULT '1',
  `pi_qt_diarias` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pedido_itens`
--

INSERT INTO `pedido_itens` (`id_pi`, `pi_nr`, `pi_seq`, `pi_produto`, `pi_descricao`, `pi_quant`, `pi_valor_unit`, `pi_vendor`, `pi_ativo`, `pi_qt_diarias`) VALUES
(1, 1, 0, 'Notebook I5', '', 5, 30, 8, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pedido_situacao`
--

CREATE TABLE IF NOT EXISTS `pedido_situacao` (
`id_s` bigint(20) unsigned NOT NULL,
  `s_descricao` char(80) NOT NULL,
  `s_edicao` int(11) NOT NULL DEFAULT '0',
  `s_finalizado` int(11) NOT NULL DEFAULT '0',
  `s_class` char(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `pedido_situacao`
--

INSERT INTO `pedido_situacao` (`id_s`, `s_descricao`, `s_edicao`, `s_finalizado`, `s_class`) VALUES
(1, 'Em edição', 1, 0, 'alert-warning'),
(2, 'Em análise', 0, 0, 'alert-success'),
(3, 'Em separação de mercadoria', 0, 0, 'alert-success'),
(4, 'Emissão de nota fiscal', 0, 0, 'alert-primary'),
(5, 'Mercadoria enviada para entrega', 0, 0, 'alert-primary'),
(6, 'Pedido finalizado', 0, 0, ''),
(900, 'Finalizado', 0, 0, ''),
(999, 'Cancelado', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `pedido_tipo`
--

CREATE TABLE IF NOT EXISTS `pedido_tipo` (
`id_t` bigint(20) unsigned NOT NULL,
  `t_descricao` char(100) NOT NULL,
  `t_locacao` int(11) NOT NULL DEFAULT '0',
  `t_venda` int(11) NOT NULL DEFAULT '0',
  `t_laboratorio` int(11) NOT NULL DEFAULT '0',
  `t_campo` int(11) NOT NULL DEFAULT '0',
  `t_cor` char(7) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pedido_tipo`
--

INSERT INTO `pedido_tipo` (`id_t`, `t_descricao`, `t_locacao`, `t_venda`, `t_laboratorio`, `t_campo`, `t_cor`) VALUES
(1, 'Orçamento', 0, 0, 0, 0, '#80EE80'),
(2, 'Pedido de Venda', 0, 1, 0, 0, '#8080EE'),
(3, 'Pedido de Locação', 1, 0, 0, 0, '#EEEE80'),
(4, 'Ordem de serviço Laboratório', 0, 0, 1, 0, '#EE8080'),
(5, 'Ordem de atendimento onsite', 0, 0, 0, 1, '#80EEEE');

-- --------------------------------------------------------

--
-- Table structure for table `pedido_validade`
--

CREATE TABLE IF NOT EXISTS `pedido_validade` (
  `id_vd` bigint(20) unsigned NOT NULL,
  `vd_nome` char(80) NOT NULL,
  `vd_ativo` int(1) NOT NULL DEFAULT '1',
  `vd_seq` int(11) NOT NULL,
  `vd_visivel` int(11) NOT NULL DEFAULT '1',
  `vd_dias` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pedido_validade`
--

INSERT INTO `pedido_validade` (`id_vd`, `vd_nome`, `vd_ativo`, `vd_seq`, `vd_visivel`, `vd_dias`) VALUES
(1, '--Não aplicável--', 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `prazo_entrega`
--

CREATE TABLE IF NOT EXISTS `prazo_entrega` (
`id_pz` bigint(20) unsigned NOT NULL,
  `pz_nome` char(80) NOT NULL,
  `pz_ativo` int(1) NOT NULL DEFAULT '1',
  `pz_seq` int(11) NOT NULL,
  `pz_visivel` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `prazo_entrega`
--

INSERT INTO `prazo_entrega` (`id_pz`, `pz_nome`, `pz_ativo`, `pz_seq`, `pz_visivel`) VALUES
(1, '-- não aplicável --', 1, 1, 0),
(2, '10 a 15 dias', 1, 2, 1),
(3, 'Pronta entrega', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prazo_garantia`
--

CREATE TABLE IF NOT EXISTS `prazo_garantia` (
`id_pga` bigint(20) unsigned NOT NULL,
  `pga_nome` char(80) NOT NULL,
  `pga_ativo` int(1) NOT NULL DEFAULT '1',
  `pga_seq` int(11) NOT NULL,
  `pga_visivel` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `prazo_garantia`
--

INSERT INTO `prazo_garantia` (`id_pga`, `pga_nome`, `pga_ativo`, `pga_seq`, `pga_visivel`) VALUES
(1, '-- não aplicável --', 1, 1, 0),
(2, 'Durante o período de locação', 1, 2, 1),
(3, '1 Ano de substituição de peças, serviço e atendimento Onsite', 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prazo_montagem`
--

CREATE TABLE IF NOT EXISTS `prazo_montagem` (
`id_pm` bigint(20) unsigned NOT NULL,
  `pm_nome` char(80) NOT NULL,
  `pm_ativo` int(1) NOT NULL DEFAULT '1',
  `pm_seq` int(11) NOT NULL,
  `pm_visivel` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `prazo_montagem`
--

INSERT INTO `prazo_montagem` (`id_pm`, `pm_nome`, `pm_ativo`, `pm_seq`, `pm_visivel`) VALUES
(1, '-- não aplicável --', 1, 1, 0),
(2, '1 dia', 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
`id_pr` bigint(20) unsigned NOT NULL,
  `pr_produto` int(11) NOT NULL,
  `pr_patrimonio` char(30) NOT NULL,
  `pr_serial` char(20) NOT NULL,
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
  `pr_data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id_pr`, `pr_produto`, `pr_patrimonio`, `pr_serial`, `pr_tag`, `pr_fornecedor`, `pr_nf`, `pr_nf_data`, `pr_vlr_custo`, `pr_dt_baixa`, `pr_filial`, `pr_cliente`, `pr_cliente_dt`, `pr_doc`, `pr_ativo`, `pr_data_cadastro`) VALUES
(1, 1, '001', 'HY3DY02', '001', 0, '', '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0, 1, '2016-08-03 00:30:30'),
(2, 1, '002', 'HY3DY03', '002', 0, '', '0000-00-00', 0, '0000-00-00', 0, 0, '0000-00-00', 0, 1, '2016-08-03 00:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `produtos_categoria`
--

CREATE TABLE IF NOT EXISTS `produtos_categoria` (
`id_pc` bigint(20) unsigned NOT NULL,
  `pc_nome` char(100) NOT NULL,
  `pc_marca` int(11) NOT NULL,
  `pc_ativo` int(11) NOT NULL DEFAULT '1',
  `pc_codigo` char(10) NOT NULL,
  `pc_desc_basica` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `produtos_categoria`
--

INSERT INTO `produtos_categoria` (`id_pc`, `pc_nome`, `pc_marca`, `pc_ativo`, `pc_codigo`, `pc_desc_basica`) VALUES
(1, 'TV 40-42"', 0, 1, 'TV40', ''),
(2, 'Notebook I5', 0, 1, 'NT-I5', ''),
(3, 'Acessórios', 0, 1, 'AC', ''),
(4, 'Notebook I3', 0, 1, 'NT-I3', 'Processador Intel I3'),
(5, 'Notebook I7', 0, 1, 'NT-I7', '');

-- --------------------------------------------------------

--
-- Table structure for table `produtos_historico`
--

CREATE TABLE IF NOT EXISTS `produtos_historico` (
`id_ph` bigint(20) unsigned NOT NULL,
  `ph_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ph_produto` int(11) NOT NULL,
  `ph_historico` int(11) NOT NULL,
  `ph_log` int(11) NOT NULL,
  `ph_pedido` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `produtos_historico`
--

INSERT INTO `produtos_historico` (`id_ph`, `ph_data`, `ph_produto`, `ph_historico`, `ph_log`, `ph_pedido`) VALUES
(1, '2016-08-03 00:19:44', 0, 1, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `produtos_historico_tipo`
--

CREATE TABLE IF NOT EXISTS `produtos_historico_tipo` (
`id_ht` bigint(20) unsigned NOT NULL,
  `ht_descricao` char(80) NOT NULL,
  `ht_perfil` char(60) NOT NULL,
  `ht_ativo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `produtos_historico_tipo`
--

INSERT INTO `produtos_historico_tipo` (`id_ht`, `ht_descricao`, `ht_perfil`, `ht_ativo`) VALUES
(1, 'Entrada de produto em estoque', '#GES', 1),
(2, 'Baixa de produto por defeito', '#GES', 1);

-- --------------------------------------------------------

--
-- Table structure for table `produtos_marca`
--

CREATE TABLE IF NOT EXISTS `produtos_marca` (
`id_ma` bigint(20) unsigned NOT NULL,
  `ma_nome` char(80) NOT NULL,
  `ma_ativo` int(11) NOT NULL DEFAULT '1',
  `ma_logo` char(200) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `produtos_marca`
--

INSERT INTO `produtos_marca` (`id_ma`, `ma_nome`, `ma_ativo`, `ma_logo`) VALUES
(1, 'Epson', 1, 'img/logo/epson.jpg'),
(2, 'HP', 1, ''),
(3, 'Microsoft', 1, ''),
(4, 'Dell', 1, ''),
(5, 'AOC', 1, ''),
(6, 'Multilaser', 1, ''),
(7, 'Apple', 1, ''),
(8, 'Samsung', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `produtos_situacao`
--

CREATE TABLE IF NOT EXISTS `produtos_situacao` (
`id_ps` bigint(20) unsigned NOT NULL,
  `ps_descricao` char(50) NOT NULL,
  `ps_ativo` int(11) NOT NULL DEFAULT '1',
  `ps_produto_disponivel` int(11) NOT NULL,
  `ps_class` char(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `produtos_situacao`
--

INSERT INTO `produtos_situacao` (`id_ps`, `ps_descricao`, `ps_ativo`, `ps_produto_disponivel`, `ps_class`) VALUES
(1, 'Produto em estoque', 1, 1, 'bg-success'),
(2, 'Produto no cliente', 1, 0, 'bg-danger'),
(3, 'Baixa do produto', 1, 0, 'bg-default'),
(4, 'Produto em reparo', 1, 0, 'bg-warning'),
(5, 'Em uso pelo administrativo', 1, 0, 'bg-danger');

-- --------------------------------------------------------

--
-- Table structure for table `produtos_tipo`
--

CREATE TABLE IF NOT EXISTS `produtos_tipo` (
`id_prd` bigint(20) unsigned NOT NULL,
  `prd_nome` char(100) NOT NULL,
  `prd_marca` int(11) NOT NULL,
  `prd_categoria` int(11) NOT NULL,
  `prd_ativo` int(11) NOT NULL,
  `prd_descricao` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `produtos_tipo`
--

INSERT INTO `produtos_tipo` (`id_prd`, `prd_nome`, `prd_marca`, `prd_categoria`, `prd_ativo`, `prd_descricao`) VALUES
(1, 'Notebook Vostro 5470', 4, 2, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `produto_agenda`
--

CREATE TABLE IF NOT EXISTS `produto_agenda` (
`id_ag` bigint(20) unsigned NOT NULL,
  `ag_produto` int(11) NOT NULL,
  `ag_data` date NOT NULL,
  `ag_cliente` int(11) NOT NULL,
  `ag_vendedor` int(11) NOT NULL,
  `ag_data_reserva` date NOT NULL,
  `ag_hora_reserva` char(8) NOT NULL,
  `ag_reservado` int(11) NOT NULL,
  `ag_situacao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `produto_doc_ged`
--

CREATE TABLE IF NOT EXISTS `produto_doc_ged` (
`id_doc` bigint(20) unsigned NOT NULL,
  `doc_dd0` int(11) DEFAULT NULL,
  `doc_tipo` int(11) DEFAULT NULL,
  `doc_ano` char(4) DEFAULT NULL,
  `doc_filename` text,
  `doc_status` char(1) DEFAULT NULL,
  `doc_data` int(11) DEFAULT NULL,
  `doc_hora` char(8) DEFAULT NULL,
  `doc_arquivo` text,
  `doc_extensao` char(4) DEFAULT NULL,
  `doc_size` float DEFAULT NULL,
  `doc_versao` char(4) DEFAULT NULL,
  `doc_ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `produto_doc_ged_tipo`
--

CREATE TABLE IF NOT EXISTS `produto_doc_ged_tipo` (
`id_doct` bigint(20) unsigned NOT NULL,
  `doct_nome` char(50) DEFAULT NULL,
  `doct_codigo` char(5) DEFAULT NULL,
  `doct_publico` int(11) DEFAULT NULL,
  `doct_avaliador` int(11) DEFAULT NULL,
  `doct_autor` int(11) DEFAULT NULL,
  `doct_restrito` int(11) DEFAULT NULL,
  `doct_ativo` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `produto_doc_ged_tipo`
--

INSERT INTO `produto_doc_ged_tipo` (`id_doct`, `doct_nome`, `doct_codigo`, `doct_publico`, `doct_avaliador`, `doct_autor`, `doct_restrito`, `doct_ativo`) VALUES
(1, 'Imagem', 'PRODT', 1, 0, 0, 0, 1),
(2, 'Manual do produto', 'MANUA', 1, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id_us` bigint(20) unsigned NOT NULL,
  `us_nome` char(80) NOT NULL,
  `us_email` char(80) NOT NULL,
  `us_login` char(20) NOT NULL,
  `us_password` char(40) NOT NULL,
  `us_badge` char(12) NOT NULL,
  `us_link` char(80) NOT NULL,
  `us_ativo` int(11) NOT NULL,
  `us_genero` char(1) NOT NULL,
  `us_verificado` char(1) NOT NULL,
  `us_autenticador` char(3) NOT NULL,
  `us_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `us_acessos` int(11) NOT NULL,
  `us_erros` int(11) NOT NULL,
  `us_last` timestamp NOT NULL,
  `us_perfil` text,
  `us_perfil_check` char(50) DEFAULT NULL,
  `us_com_nome` char(50) NOT NULL,
  `us_com_ass` char(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_us`, `us_nome`, `us_email`, `us_login`, `us_password`, `us_badge`, `us_link`, `us_ativo`, `us_genero`, `us_verificado`, `us_autenticador`, `us_cadastro`, `us_acessos`, `us_erros`, `us_last`, `us_perfil`, `us_perfil_check`, `us_com_nome`, `us_com_ass`) VALUES
(7, 'Super User Admin', 'admin', 'ADMIN', '21232f297a57a5a743894a0e4a801fc3', '00007', '', 1, '', '', 'MD5', '2016-06-27 02:53:04', 0, 0, '2016-06-27 02:53:04', '', '8f14e45fceea167a5a36dedd4bea2543', '', ''),
(8, 'Rene Faustino Gabriel Junior', 'renefgj@gmail.com', 'RENE', '2e3db7994011c8c5e315e42a0cb439c5', '00008', '', 1, 'M', '', 'MD5', '2016-06-29 12:28:18', 0, 0, '2016-06-29 12:28:18', '#ADM', NULL, '', ''),
(9, 'Tadeu Everton Zamoiski', '', 'TMK', '123456', '00009', '', 0, 'M', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(10, 'Moacyr Zambaldi Junior', '', 'JUNIOR', '123456', '00010', '', 0, 'C', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(11, 'Ana Cristina Zamoiski', '', 'ACZ', '123456', '00011', '', 0, 'F', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(12, 'Jacqueline Stein Jendick', '', 'JACKY', '123456', '00012', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(13, 'Douglas Antonio Durante Pegoraro', '', 'DOUGLAS', 'e10adc3949ba59abbe56e057f20f883e', '00013', '', 1, '0', '', 'MD5', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, 'Douglas Pegoraro', 'Representante Comercial'),
(14, 'Gleisi Silvia Sima', '', 'GLEISI', '123456', '00014', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(15, 'Wagner Block', '', 'BLOCK', '123456', '00015', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(16, 'Fabricio Cola', '', 'FABRI', '123456', '00016', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(17, 'Joao Luiz Zamoiski', '', 'KIKO', '123456', '00017', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(18, 'Luis Fernando de Andrade', '', 'LUIS', '123456', '00018', '', 0, 'M', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(19, 'Olinda Maria Rigoni Ferreira', '', 'OLINDA', '123456', '00019', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(20, 'Elcio Douglas Ferreira', '', 'ELCIO', '123456', '00020', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(21, 'Eliara Prado Zambaldi', '', 'ELIARA', '123456', '00021', '', 1, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '#GEF', NULL, '', ''),
(22, 'Maite Elisa Kreusch', '', 'MAITE', '123456', '00022', '', 0, '3', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(23, 'Rodrigo Baptista', '', 'RODRIGO', '123456', '00023', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(24, 'Deisi Gomes Dos Santos', '', 'DGS', '123456', '00024', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(25, 'Welch MagalhÃes Brezina', '', 'WMB', '123456', '00025', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(26, 'Jose Domingos Favile Junior', '', 'JDFJ', '123456', '00026', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(27, 'Daniel Wojciechowski Martins', '', 'DANI', '123456', '00027', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(28, 'Natalia Henrique Zambaldi', '', 'NATALIA', '123456', '00028', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(29, 'Marcos Pontes Carvalho', '', 'MARCOS', '123456', '00029', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(30, 'Virgilio Paschoal Vintem', '', 'PASCHOAL', '123456', '00030', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(31, 'Samuel D. Sima de Azevedo', '', 'SAMUEL', '123456', '00031', '', 0, '2', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(32, 'Mariana Das Virgens', '', 'MARIANA', '123456', '00032', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(33, 'Barbara do Nascimento', '', 'BAR', '123456', '00033', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(34, 'Rodrigo Otavio França Miranda', '', 'ROM', '123456', '00034', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(35, 'Gabriel Pereira Das Virgens', '', 'GABRIEL', '123456', '00035', '', 0, 'M', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(36, 'Gregorio Luis Trentino', '', 'GREG', '123456', '00036', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(37, 'Giuliano Maciel Schiavinatto', '', 'GIULIANO', '123456', '00037', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(38, 'Jairo Vieira Sanguinete', '', 'JAIRO', '123456', '00038', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(39, 'Fabio Andre Tauffer de Sousa', '', 'FAA', '123456', '00039', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(40, 'Edyomar Souza de Jesus', '', 'EDY', '123456', '00040', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(41, 'Getulio da Silva Costa Neto', '', 'GETULIO', '123456', '00041', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(42, 'Marcos Francisco Dos Santos', '', 'FCO', '123456', '00042', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(43, 'Lucas Fernandes Garcia', '', 'LUCAS', '123456', '00043', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(44, 'Mauricio Luiz Medeiros de Andrade', '', 'MAURICIO', '123456', '00044', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(45, 'Debora Carneiro Morais', '', 'DEBORA', '123456', '00045', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(46, 'Maria Helena Pontes Carvalho', '', 'HELENA', '123456', '00046', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(47, 'Ozei Luiz da Silva', '', 'OZEI', '123456', '00047', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(48, 'Ana Carolina Pereira de Souza', '', 'ANACAROL', '123456', '00048', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(49, 'José Roberto Marques da Silva', '', 'ROBERTO', '123456', '00049', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(50, 'Thiago Gonçalves da Silva', '', 'THIAGO', '123456', '00050', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(51, 'Nelson da Silva Santos Junior', '', 'NELSON', '123456', '00051', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(52, 'Andrei Muller', '', 'ANDREI', '123456', '00052', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(53, 'Sabrina Alessandra Wolfgramm da Silva', '', 'SABRINA', '123456', '00053', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(54, 'Mariano Oliveira Porto', '', 'MARIANO', '123456', '00054', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(55, 'Joel da Silva Rodrigues', '', 'JOEL', '123456', '00055', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(56, 'Paulo Rafael Damas Albano', '', 'RAFAEL', '123456', '00056', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(57, 'Laiene Tamires da Silva', '', 'LAIENE', '123456', '00057', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(58, 'Jeferson Wasen Paulino', '', 'JEFERSON', '123456', '00058', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(59, 'Cristian Paulo Vieira', '', 'CRISTIAN', '123456', '00059', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(60, 'Ricardo Alexandre Vargas', '', 'RICARDO', '123456', '00060', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(61, 'Cristiane de Jesus Boas', '', 'CRISTIANE', '123456', '00061', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(62, 'Geovane Gonçalves', '', 'GEOVANE', '123456', '00062', '', 0, '0', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(63, 'Rafael de Paula Souza', '', 'RAFA', '123456', '00063', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(64, 'Gabriela Henrique Zambaldi', '', 'GABI', '123456', '00064', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(65, 'Alexandre Fernandes da Silva', '', 'ALEXANDRE', '123456', '00065', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(66, 'Alvaro Elias Gonçalves Filho', '', 'ALVARO', '123456', '00066', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', ''),
(67, 'Joao Paulo Luciano', '', 'JOAO', '123456', '00067', '', 0, 'A', '', 'TXT', '2016-07-03 18:07:46', 0, 0, '0000-00-00 00:00:00', '', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_drh`
--

CREATE TABLE IF NOT EXISTS `user_drh` (
`id_usd` bigint(20) unsigned NOT NULL,
  `usd_fone_1` char(20) NOT NULL,
  `usd_id_us` int(11) NOT NULL,
  `usd_cpf` char(15) NOT NULL,
  `usd_rg` char(15) NOT NULL,
  `usd_rg_emissor` char(20) NOT NULL,
  `usd_rg_dt_emissao` date NOT NULL,
  `usd_pis` char(20) NOT NULL,
  `usd_dt_nasc` date NOT NULL,
  `usd_ct` char(15) NOT NULL,
  `usd_ct_serie` char(15) NOT NULL,
  `usd_dt_admissao` date NOT NULL,
  `usd_dt_demissao` date NOT NULL,
  `usd_cargo` char(30) NOT NULL,
  `usd_departamento` char(30) NOT NULL,
  `usd_empresa` int(11) NOT NULL,
  `usd_logradouro` char(100) NOT NULL,
  `usd_numero` char(20) NOT NULL,
  `usd_complemento` char(20) NOT NULL,
  `usd_cep` char(10) NOT NULL,
  `usd_bairro` char(30) NOT NULL,
  `usd_cidade` char(30) NOT NULL,
  `usd_estado` char(2) NOT NULL,
  `usd_nome_mae` char(100) NOT NULL,
  `usd_nome_pai` char(100) NOT NULL,
  `usd_fone_2` char(20) NOT NULL,
  `usd_fone_3` char(20) NOT NULL,
  `usd_fone_4` char(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `user_drh`
--

INSERT INTO `user_drh` (`id_usd`, `usd_fone_1`, `usd_id_us`, `usd_cpf`, `usd_rg`, `usd_rg_emissor`, `usd_rg_dt_emissao`, `usd_pis`, `usd_dt_nasc`, `usd_ct`, `usd_ct_serie`, `usd_dt_admissao`, `usd_dt_demissao`, `usd_cargo`, `usd_departamento`, `usd_empresa`, `usd_logradouro`, `usd_numero`, `usd_complemento`, `usd_cep`, `usd_bairro`, `usd_cidade`, `usd_estado`, `usd_nome_mae`, `usd_nome_pai`, `usd_fone_2`, `usd_fone_3`, `usd_fone_4`) VALUES
(1, '(41) 0000.0000', 7, '000.000.000-00', '000.000--0', 'SSP', '2016-01-01', 'PIS00000-00', '2016-07-01', 'CT', '1', '2016-07-01', '0000-00-00', 'Administrador', 'Sistemas', 1, 'Rua X', '123', 'Ap.1203', '80.710-000', 'Bigorrilho', 'Curitiba', 'PR', 'Não identificado', 'Não identificado', '', '', ''),
(4, '', 8, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', ''),
(5, '', 21, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', ''),
(6, '', 65, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', ''),
(7, '', 45, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', ''),
(8, '', 48, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', ''),
(9, '', 11, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', ''),
(10, '', 52, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', ''),
(11, '', 59, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', ''),
(12, '', 20, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', ''),
(13, '', 13, '', '', '', '0000-00-00', '', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `_filiais`
--

CREATE TABLE IF NOT EXISTS `_filiais` (
`id_fi` bigint(20) unsigned NOT NULL,
  `fi_razao_social` char(200) NOT NULL,
  `fi_nome_fantasia` char(200) NOT NULL,
  `fi_cnpj` char(20) NOT NULL,
  `fi_ie` char(20) NOT NULL,
  `fi_im` char(20) NOT NULL,
  `fi_logradouro` char(100) NOT NULL,
  `fi_numero` char(20) NOT NULL,
  `fi_complemento` char(20) NOT NULL,
  `fi_bairro` char(30) NOT NULL,
  `fi_cidade` char(30) NOT NULL,
  `fi_estado` char(2) NOT NULL,
  `fi_cep` char(10) NOT NULL,
  `fi_fone_1` char(15) NOT NULL,
  `fi_fone_2` char(15) NOT NULL,
  `fi_email` char(80) NOT NULL,
  `fi_email_cobranca` char(80) NOT NULL,
  `fi_ativo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `_filiais`
--

INSERT INTO `_filiais` (`id_fi`, `fi_razao_social`, `fi_nome_fantasia`, `fi_cnpj`, `fi_ie`, `fi_im`, `fi_logradouro`, `fi_numero`, `fi_complemento`, `fi_bairro`, `fi_cidade`, `fi_estado`, `fi_cep`, `fi_fone_1`, `fi_fone_2`, `fi_email`, `fi_email_cobranca`, `fi_ativo`) VALUES
(1, 'Luvi Comercial Ltda', 'Giga informática - Curitiba', '12.369.270/0001-53', '90529530-62', '', 'Rua Samuel César', '1240', '', 'Agua Verde', 'Curitiba', 'PR', '80.620-220', '(41) 3016-5252', '(41) 7815-0709', 'giga@giga.inf.br', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cc_banco`
--
ALTER TABLE `cc_banco`
 ADD UNIQUE KEY `id_cc` (`id_cc`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
 ADD UNIQUE KEY `id_f` (`id_f`);

--
-- Indexes for table `clientes_contatos`
--
ALTER TABLE `clientes_contatos`
 ADD UNIQUE KEY `id_cc` (`id_cc`);

--
-- Indexes for table `clientes_mensagem`
--
ALTER TABLE `clientes_mensagem`
 ADD UNIQUE KEY `id_msg` (`id_msg`);

--
-- Indexes for table `condicoes_pagamento`
--
ALTER TABLE `condicoes_pagamento`
 ADD UNIQUE KEY `id_pg` (`id_pg`);

--
-- Indexes for table `contato_funcao`
--
ALTER TABLE `contato_funcao`
 ADD UNIQUE KEY `id_ct` (`id_ct`);

--
-- Indexes for table `cx_caixa`
--
ALTER TABLE `cx_caixa`
 ADD UNIQUE KEY `id_cp` (`id_cp`);

--
-- Indexes for table `cx_conta_codigo`
--
ALTER TABLE `cx_conta_codigo`
 ADD UNIQUE KEY `id_cd` (`id_cd`);

--
-- Indexes for table `cx_pagar`
--
ALTER TABLE `cx_pagar`
 ADD UNIQUE KEY `id_cp` (`id_cp`);

--
-- Indexes for table `cx_receber`
--
ALTER TABLE `cx_receber`
 ADD UNIQUE KEY `id_cp` (`id_cp`);

--
-- Indexes for table `logins_log`
--
ALTER TABLE `logins_log`
 ADD UNIQUE KEY `id_ul` (`id_ul`);

--
-- Indexes for table `logins_perfil`
--
ALTER TABLE `logins_perfil`
 ADD UNIQUE KEY `id_usp` (`id_usp`);

--
-- Indexes for table `logins_perfil_ativo`
--
ALTER TABLE `logins_perfil_ativo`
 ADD UNIQUE KEY `id_up` (`id_up`);

--
-- Indexes for table `mensagem`
--
ALTER TABLE `mensagem`
 ADD UNIQUE KEY `id_nw` (`id_nw`);

--
-- Indexes for table `mensagem_own`
--
ALTER TABLE `mensagem_own`
 ADD UNIQUE KEY `id_m` (`id_m`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
 ADD UNIQUE KEY `id_po` (`id_pp`);

--
-- Indexes for table `pedido_itens`
--
ALTER TABLE `pedido_itens`
 ADD UNIQUE KEY `id_pi` (`id_pi`);

--
-- Indexes for table `pedido_situacao`
--
ALTER TABLE `pedido_situacao`
 ADD UNIQUE KEY `id_s` (`id_s`);

--
-- Indexes for table `pedido_tipo`
--
ALTER TABLE `pedido_tipo`
 ADD UNIQUE KEY `id_t` (`id_t`);

--
-- Indexes for table `prazo_entrega`
--
ALTER TABLE `prazo_entrega`
 ADD UNIQUE KEY `id_pz` (`id_pz`);

--
-- Indexes for table `prazo_garantia`
--
ALTER TABLE `prazo_garantia`
 ADD UNIQUE KEY `id_pg` (`id_pga`);

--
-- Indexes for table `prazo_montagem`
--
ALTER TABLE `prazo_montagem`
 ADD UNIQUE KEY `id_pm` (`id_pm`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
 ADD UNIQUE KEY `id_pr` (`id_pr`);

--
-- Indexes for table `produtos_categoria`
--
ALTER TABLE `produtos_categoria`
 ADD UNIQUE KEY `id_pc` (`id_pc`);

--
-- Indexes for table `produtos_historico`
--
ALTER TABLE `produtos_historico`
 ADD UNIQUE KEY `id_ph` (`id_ph`);

--
-- Indexes for table `produtos_historico_tipo`
--
ALTER TABLE `produtos_historico_tipo`
 ADD UNIQUE KEY `id_ht` (`id_ht`);

--
-- Indexes for table `produtos_marca`
--
ALTER TABLE `produtos_marca`
 ADD UNIQUE KEY `id_ma` (`id_ma`);

--
-- Indexes for table `produtos_situacao`
--
ALTER TABLE `produtos_situacao`
 ADD UNIQUE KEY `id_ps` (`id_ps`);

--
-- Indexes for table `produtos_tipo`
--
ALTER TABLE `produtos_tipo`
 ADD UNIQUE KEY `id_prd` (`id_prd`);

--
-- Indexes for table `produto_agenda`
--
ALTER TABLE `produto_agenda`
 ADD UNIQUE KEY `id_ag` (`id_ag`);

--
-- Indexes for table `produto_doc_ged`
--
ALTER TABLE `produto_doc_ged`
 ADD UNIQUE KEY `id_doc` (`id_doc`);

--
-- Indexes for table `produto_doc_ged_tipo`
--
ALTER TABLE `produto_doc_ged_tipo`
 ADD UNIQUE KEY `id_doct` (`id_doct`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD UNIQUE KEY `id_us` (`id_us`);

--
-- Indexes for table `user_drh`
--
ALTER TABLE `user_drh`
 ADD UNIQUE KEY `id_usd` (`id_usd`);

--
-- Indexes for table `_filiais`
--
ALTER TABLE `_filiais`
 ADD UNIQUE KEY `id_f` (`id_fi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cc_banco`
--
ALTER TABLE `cc_banco`
MODIFY `id_cc` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
MODIFY `id_f` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clientes_contatos`
--
ALTER TABLE `clientes_contatos`
MODIFY `id_cc` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clientes_mensagem`
--
ALTER TABLE `clientes_mensagem`
MODIFY `id_msg` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `condicoes_pagamento`
--
ALTER TABLE `condicoes_pagamento`
MODIFY `id_pg` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `contato_funcao`
--
ALTER TABLE `contato_funcao`
MODIFY `id_ct` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cx_caixa`
--
ALTER TABLE `cx_caixa`
MODIFY `id_cp` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cx_conta_codigo`
--
ALTER TABLE `cx_conta_codigo`
MODIFY `id_cd` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `cx_pagar`
--
ALTER TABLE `cx_pagar`
MODIFY `id_cp` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cx_receber`
--
ALTER TABLE `cx_receber`
MODIFY `id_cp` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logins_log`
--
ALTER TABLE `logins_log`
MODIFY `id_ul` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logins_perfil`
--
ALTER TABLE `logins_perfil`
MODIFY `id_usp` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `logins_perfil_ativo`
--
ALTER TABLE `logins_perfil_ativo`
MODIFY `id_up` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mensagem`
--
ALTER TABLE `mensagem`
MODIFY `id_nw` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=191;
--
-- AUTO_INCREMENT for table `mensagem_own`
--
ALTER TABLE `mensagem_own`
MODIFY `id_m` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
MODIFY `id_pp` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pedido_itens`
--
ALTER TABLE `pedido_itens`
MODIFY `id_pi` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pedido_situacao`
--
ALTER TABLE `pedido_situacao`
MODIFY `id_s` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1000;
--
-- AUTO_INCREMENT for table `pedido_tipo`
--
ALTER TABLE `pedido_tipo`
MODIFY `id_t` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `prazo_entrega`
--
ALTER TABLE `prazo_entrega`
MODIFY `id_pz` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prazo_garantia`
--
ALTER TABLE `prazo_garantia`
MODIFY `id_pga` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prazo_montagem`
--
ALTER TABLE `prazo_montagem`
MODIFY `id_pm` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
MODIFY `id_pr` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `produtos_categoria`
--
ALTER TABLE `produtos_categoria`
MODIFY `id_pc` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `produtos_historico`
--
ALTER TABLE `produtos_historico`
MODIFY `id_ph` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `produtos_historico_tipo`
--
ALTER TABLE `produtos_historico_tipo`
MODIFY `id_ht` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `produtos_marca`
--
ALTER TABLE `produtos_marca`
MODIFY `id_ma` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `produtos_situacao`
--
ALTER TABLE `produtos_situacao`
MODIFY `id_ps` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `produtos_tipo`
--
ALTER TABLE `produtos_tipo`
MODIFY `id_prd` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `produto_agenda`
--
ALTER TABLE `produto_agenda`
MODIFY `id_ag` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produto_doc_ged`
--
ALTER TABLE `produto_doc_ged`
MODIFY `id_doc` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produto_doc_ged_tipo`
--
ALTER TABLE `produto_doc_ged_tipo`
MODIFY `id_doct` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id_us` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `user_drh`
--
ALTER TABLE `user_drh`
MODIFY `id_usd` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `_filiais`
--
ALTER TABLE `_filiais`
MODIFY `id_fi` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
