<?php
// This file is part of the Brapci Software. 
// 
// Copyright 2015, UFPR. All rights reserved. You can redistribute it and/or modify
// Brapci under the terms of the Brapci License as published by UFPR, which
// restricts commercial use of the Software. 
// 
// Brapci is distributed in the hope that it will be useful, but WITHOUT ANY
// WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
// PARTICULAR PURPOSE. See the ProEthos License for more details. 
// 
// You should have received a copy of the Brapci License along with the Brapci
// Software. If not, see
// https://github.com/ReneFGJ/Brapci/tree/master//LICENSE.txt 
/* @author: Rene Faustino Gabriel Junior <renefgj@gmail.com>
 * @date: 2015-12-01
 */
if (!function_exists(('msg')))
	{
		function msg($t)
			{
				$CI = &get_instance();
				if (strlen($CI->lang->line($t)) > 0)
					{
						return($CI->lang->line($t));
					} else {
						return($t);
					}
			}
	}
/* Login */
$lang['login_enter'] = 'Entar';
$lang['login_name'] = 'Informe seu login';
$lang['login_password'] = 'Informe sua senha';
$lang['login_enter'] = 'Entar';
$lang['login_social'] = 'Logue com uma conta existente (recomendado)';
$lang['your_passoword'] = 'sua senha';
$lang['edit_person_data'] = 'Editar dados pessoais';

$lang['contas_receber_relatorio'] = 'Relatório de Contas a Receber';

$lang['bt_new'] = 'novo';
$lang['bt_search'] = 'busca';
$lang['bt_clear'] = 'limpa filtro';

$lang['proposta_nova'] = 'nova proposta';
$lang['not_register'] = 'nenhum registro';

$lang['contas_pagar'] = 'Contas a Pagar';
$lang['contas_receber'] = 'Contas a Receber';

$lang['msg_subject'] = 'Assunto';
$lang['msg_content'] = 'Conteúdo';
$lang['submit'] = 'Enviar';

$lang['situacao_0'] = 'Disponível';
$lang['situacao_1'] = 'Reservado';
$lang['situacao_2'] = 'Locado';
$lang['situacao_3'] = 'Devolvido(*)';


$lang['situacao_9'] = 'Cancelado';

$lang['cc_tipo_1'] = 'Conta Corrente';
$lang['cc_tipo_2'] = 'Poupança';
$lang['cc_tipo_0'] = 'sem conta';
?>
