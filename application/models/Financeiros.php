<?php
class financeiros extends CI_model {
	var $table_pagar = 'cx_pagar';
	var $table_receber = 'cx_receber';

	function calendario($date, $tipo) {
		$dt = $date;
		$date = substr($date, 0, 4) . '-' . substr($date, 4, 2);
		if ($tipo == '1') {
			$table = 'cx_pagar';
			$lk = 'cpagar';
		} else {
			$table = 'cx_receber';
			$lk = 'creceber';
		}
		$wh = '';
		$sx = '';
		$ano1 = get("dd1");
		$wh .= " AND (cp_vencimento >= '" . $date . "-01') ";
		$wh .= " AND (cp_vencimento <= '" . $date . "-31') ";

		$sqlx = "select sum(cp_valor) as valor, cp_vencimento from $table 
							where (1=1) $wh AND (cp_situacao <> 9)
							GROUP BY cp_vencimento
							ORDER BY cp_vencimento ";

		$rlt = $this -> db -> query($sqlx);
		$rlt = $rlt -> result_array();

		$di = mktime(0, 0, 0, substr($dt, 4, 2), 1, substr($dt, 0, 4));

		$sx = '<table class="small">';
		$sx .= '<tr><td colspan=7 align="center">' . meses(date("m", $di)) . ' / '.date("Y",$di).'</td></tr>';
		$sx .= '<tr><th>dom.</th><th>seg.</th><th>ter.</th><th>qua.</th><th>qui.</th><th>sex.</th><th>sab.</th></tr>' . cr();

		$wd = 0;

		$wd = date("w", $di);
		if ($wd > 0) {
			$sx .= '<tr>';
			for ($r = 0; $r < $wd; $r++) {
				$sx .= '<td>-</td>';
			}
		} else {
			$wd = 8;
		}
		$cal = array();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$day = round(substr(sonumero($line['cp_vencimento']), 6, 2));
			$cal[$day] = $line['valor'];
		}

		$do = $di;
		$i = 0;
		while (date("m", $do) == date("m", $di)) {
			$day = round(date("d", $do));
			
			if (isset($cal[$day])) {
				$valor = $cal[$day];
				$vlr = $cal[$day];
			} else {
				$valor = 0;
				$vlr = 0;
			}
			$valor = number_format($valor, 2, ',', '.');
			$cor = ' bgcolor="white" ';
			if ($vlr > 10000) {
				$cor = ' bgcolor="#c0c0ff" ';
			}
			if ($vlr > 30000) {
				$cor = ' bgcolor="#ffffc0" ';
			}
			if ($vlr > 50000) {
				$cor = ' bgcolor="#ffc0c0" ';
			}
			$link = '<a href="' . base_url('index.php/financeiro/' . $lk . '/' . date("Ymd", $do)) . '" title="' . $valor . '">';
			$i++;
			$sx .= '<td align="center" ' . $cor . '>';
			$sx .= $link;
			$sx .= date("d", $do);
			$sx .= '</a>';
			$sx .= '</td>';

			if (date("w", $do) == 6) {
				$sx .= '</tr><tr>';
			}
			if ($i > 40) { exit ;
			}
			$do = $do + 25 * 60 * 59;
		}
		$sx .= '</table>';

		return ($sx);
	}

	function resumo($id = 0) {
		$sql = "select sum(cp_valor) as total, count(*) as titulos 
						FROM " . $this -> table_receber . " 
						WHERE cp_fornecedor = $id and cp_situacao = 1";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			return ($line);
		}
		return ( array('total' => 0, 'titulus' => 0));
	}

	function lista_por_cliente($id = 0) {
		$sql = "select * 
						FROM " . $this -> table_receber . " 
							left join cx_pagar_situacao on id_cpa = cp_situacao
						WHERE cp_fornecedor = $id and cp_situacao = 1";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table width="100%" class="table" border=1>';
		$sx .= '<tr><th width="5%">venc.</th>
					<th width="57%">histórico</th>
					<th width="5%">pedido</th>
					<th width="10%">parcela</th>
					<th width="10%">valor</th>
					<th width="10%">situacao</th>
					<th width="3%">#</th>
				</tr>' . cr();
		$saldo = 0;
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			/* Situacao */

			/* previsao */
			if ($line['cp_previsao'] == '1') {
				$trc = ' class="warning" ';
			} else {
				$trc = '';
			}

			$id = $line['id_cp'];
			$sit = '';
			$link_edit = '';
			if (perfil("#ADM#FCP")) {
				if ($line['cp_situacao'] == 1) {
					$sit = '<font onclick="newxy(\'' . base_url('index.php/financeiro/creceber_quitar/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer;" color="green"><b>$</b></font>';
					$link_edit = '<span onclick="newxy(\'' . base_url('index.php/financeiro/creceber_edit/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer; color: blue;">';
				} else {
					$link_edit = '';
					$trc = ' class="info" ';
				}
			}

			$sx .= '<tr ' . $trc . '>';
			//$sx .= '<td>'.$line['cp_situacao'].'</td>';
			$sx .= '<td align="center" class="small">';
			$sx .= substr(sonumero($line['cp_vencimento']), 6, 2);
			$sx .= '/';
			$sx .= substr(sonumero($line['cp_vencimento']), 4, 2);
			$sx .= '</td>';

			$sx .= '<td class="middle">';
			$sx .= $link_edit . UpperCase($line['cp_historico']) . '</a>';
			$sx .= '</td>';

			/******** PEDIDO **********/
			$sx .= '<td class="small">';

			$pedido = $line['cp_pedido'];
			if (substr($pedido, 5, 1) == '/') {
				$link = 'http://10.1.1.123:8080/pedidos/pedido_mostra.asp?dd1=' . $pedido;
				$pedido = '<a href="#" onclick="newxy(\'' . $link . '\',800,800);">' . $pedido . '</a>';
			}
			$sx .= $pedido;
			$sx .= '</td>';

			$sx .= '<td class="small">';
			$sx .= $line['cp_parcela'];
			$sx .= '</td>';

			$sx .= '<td align="right">';
			$sx .= '<b>';
			$sx .= number_format($line['cp_valor'], 2, ',', '.');
			$sx .= '</b>';
			$sx .= '</td>';

			$saldo = $saldo + $line['cp_valor'];

			$sx .= '<td class="middle ' . $line['cpa_classe'] . '" align="right">';
			$sx .= '<b>';
			$sx .= $line['cpa_descricao'];
			$sx .= '</b>';
			$sx .= '</td>';

			$sx .= '<td align="center">';
			$sx .= '<b>';
			$sx .= $sit;
			$sx .= '</b>';
			$sx .= '</td>';

			$sx .= '</tr>';

		}
		$sx .= '</table>';
		return ($sx);
	}

	function saldo_dia($dt, $tipo = '1') {
		if ($tipo == '1') {
			$tabela = 'cx_pagar';
		} else {
			$tabela = 'cx_receber';
		}
		$dt = sonumero($dt);
		$dt = substr($dt, 0, 4) . '-' . substr($dt, 4, 2) . '-' . substr($dt, 6, 2);
		$cp = '*';
		$sql = "select sum(cp_valor) as total from $tabela 
							where cp_vencimento = '$dt'
						order by cp_vencimento, cp_valor desc 
						";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		return ($rlt[0]['total']);
	}

	function cp_cpagar_quitar() {
		$cp = array();
		array_push($cp, array('$H8', 'id_cp', '', false, true));
		array_push($cp, array('$S80', 'cp_historico', 'Historico', True, true));
		array_push($cp, array('$N8', 'cp_valor', 'Valor original', True, False));
		array_push($cp, array('$N8', 'cp_valor_pago', 'Valor pago', True, true));
		array_push($cp, array('$Q id_cc:cc_nome:select * from cc_banco where cc_ativo=1', 'cp_forma_pagamento', 'Forma pagamento', True, true));
		array_push($cp, array('$S20', 'cp_img', 'Imagem', False, true));

		array_push($cp, array('$HV', 'cp_log_pagamento', $_SESSION['id'], True, true));
		array_push($cp, array('$HV', 'cp_dt_pagamento', date("Y-m-d"), True, true));
		array_push($cp, array('$HV', 'cp_situacao', '2', True, true));

		array_push($cp, array('$B8', '', 'Fechar pagamento', false, true));
		return ($cp);
	}

	function cp_creceber_contabil_editar() {
		$cp = array();
		array_push($cp, array('$H8', 'id_cp', '', false, true));
		array_push($cp, array('$S80', 'cp_historico', 'Historico', True, true));
		array_push($cp, array('$N8', 'cp_valor', 'Valor original', True, False));
		array_push($cp, array('$N8', 'cp_valor_pago', 'Valor pago', True, true));
		//array_push($cp, array('$Q id_cc:cc_nome:select * from cc_banco where cc_ativo=1', 'cp_forma_pagamento', 'Forma pagamento', True, true));
		//array_push($cp, array('$S20', 'cp_img', 'Imagem', False, true));

		array_push($cp, array('$Q id_cpa:cpa_descricao:select * from cx_pagar_situacao where cpa_ativo', 'cp_situacao', 'situação', True, true));
		array_push($cp, array('$Q id_cd:cd_descricao:select * from cx_conta_codigo where cd_cpage = 2', 'cp_conta', 'Conta', False, true));

		array_push($cp, array('$B8', '', 'Fechar pagamento', false, true));
		return ($cp);
	}

	function cp_cpagar_contabil_editar() {
		$cp = array();
		array_push($cp, array('$H8', 'id_cp', '', false, true));
		array_push($cp, array('$S80', 'cp_historico', 'Historico', True, true));
		array_push($cp, array('$N8', 'cp_valor', 'Valor original', True, False));
		array_push($cp, array('$N8', 'cp_valor_pago', 'Valor pago', True, true));
		array_push($cp, array('$Q id_cc:cc_nome:select * from cc_banco where cc_ativo=1', 'cp_forma_pagamento', 'Forma pagamento', True, true));
		array_push($cp, array('$S20', 'cp_img', 'Imagem', False, true));

		array_push($cp, array('$Q id_cpa:cpa_descricao:select * from cx_pagar_situacao where cpa_ativo', 'cp_situacao', 'situação', True, true));
		array_push($cp, array('$Q id_cd:cd_descricao:select * from cx_conta_codigo where cd_cpage = 1', 'cp_conta', 'Conta', False, true));

		array_push($cp, array('$B8', '', 'Fechar pagamento', false, true));
		return ($cp);
	}

	function cp_creceber_quitar() {
		$cp = array();
		array_push($cp, array('$H8', 'id_cp', '', false, true));
		array_push($cp, array('$S80', 'cp_historico', 'Historico', True, true));
		array_push($cp, array('$N8', 'cp_valor', 'Valor original', True, False));
		array_push($cp, array('$N8', 'cp_valor_pago', 'Valor pago', True, true));
		array_push($cp, array('$Q id_cc:cc_nome:select * from cc_banco where cc_ativo=1', 'cp_forma_pagamento', 'Forma pagamento', True, true));
		array_push($cp, array('$S20', 'cp_img', 'Imagem', False, true));

		array_push($cp, array('$HV', 'cp_log_pagamento', $_SESSION['id'], True, true));
		array_push($cp, array('$HV', 'cp_dt_pagamento', date("Y-m-d"), True, true));
		array_push($cp, array('$HV', 'cp_situacao', '2', True, true));

		array_push($cp, array('$B8', '', 'Fechar pagamento', false, true));
		return ($cp);
	}

	function cp_cpagar_editar($id = 0) {
		$cp = array();
		array_push($cp, array('$H8', 'id_cp', '', false, true));
		array_push($cp, array('$D8', 'cp_vencimento', 'Vencimento', True, true));
		array_push($cp, array('$S80', 'cp_historico', 'Historico', True, true));
		array_push($cp, array('$S80', 'cp_pedido', 'Pedido', True, true));
		if ($id == 0)
		{
			array_push($cp, array('$A5', '', 'Parcelas', False, True));	
			array_push($cp, array('$[1-48]', 'cp_parcela', 'Total de Parcelas', True, True));	
			array_push($cp, array('$O 0:Único&m:Mensal&d:diario&w:Semanal', '', 'Próximos vencimentos', True, True));	
		} else {
			array_push($cp, array('$H8', '', '', False, True));	
			array_push($cp, array('$S80', '', 'cp_parcela', True, True));
			array_push($cp, array('$H8', '', '', False, True));						
		}
		
		array_push($cp, array('$S80', 'cp_doc', 'Documento', False, true));
		array_push($cp, array('$Q id_cd:cd_descricao:select * from cx_conta_codigo where cd_cpage = 1', 'cp_conta', 'Conta', False, true));
		array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_fornecedor = 1 and f_ativo = 1', 'cp_fornecedor', 'Fornecedor', False, true));

		array_push($cp, array('$HV', 'cp_situacao', '1', true, true));

		array_push($cp, array('$N8', 'cp_valor', 'Valor', True, True));
		array_push($cp, array('$HV', 'cp_valor_pago', get("dd11"), True, true));

		array_push($cp, array('$S80', 'cp_nossonumero', 'Cod.Barras / Nosso Nº', False, True));
		array_push($cp, array('$C', 'cp_previsao', 'Previsão (SIM)', False, true));

		array_push($cp, array('$B8', '', 'Salvar >>>', false, true));
		return ($cp);
	}

	function cp_creceber_editar($id = 0) {
		$cp = array();
		array_push($cp, array('$H8', 'id_cp', '', false, true));
		array_push($cp, array('$D8', 'cp_vencimento', 'Vencimento', True, true));
		array_push($cp, array('$S80', 'cp_historico', 'Historico', True, true));
		array_push($cp, array('$S80', 'cp_pedido', 'Pedido', True, true));

		if ($id == 0)
		{
			array_push($cp, array('$A5', '', 'Parcelas', False, True));	
			array_push($cp, array('$[1-48]', 'cp_parcela', 'Total de Parcelas', True, True));	
			array_push($cp, array('$O 0:Único&m:Mensal&d:diario&w:Semanal', '', 'Próximos vencimentos', True, True));	
		} else {
			array_push($cp, array('$H8', '', '', False, True));	
			array_push($cp, array('$S80', '', 'cp_parcela', True, True));
			array_push($cp, array('$H8', '', '', False, True));						
		}

		array_push($cp, array('$S80', 'cp_doc', 'Documento', False, true));
		array_push($cp, array('$Q id_cd:cd_descricao:select * from cx_conta_codigo where cd_cpage = 2', 'cp_conta', 'Conta', False, true));
		array_push($cp, array('$Q id_f:f_nome:select id_f, concat(f_nome_fantasia,\' - \',f_razao_social) as f_nome from clientes where f_ativo = 1', 'cp_fornecedor', 'Sacado', False, true));
		//array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_ativo = 1', 'cp_fornecedor', 'Sacado', False, true));

		//array_push($cp, array('$Q id_cpa:cpa_descricao:select * from cx_pagar_situacao where cpa_ativo = 1', 'cp_situacao', 'Situação', true, true));
		array_push($cp, array('$HV', 'cp_situacao', '1', true, true));

		array_push($cp, array('$N8', 'cp_valor', 'Valor', True, True));
		array_push($cp, array('$HV', 'cp_valor_pago', get("dd11"), True, true));

		array_push($cp, array('$S80', 'cp_nossonumero', 'Cod.Barras / Nosso Nº', False, True));
		array_push($cp, array('$C', 'cp_previsao', 'Previsão (SIM)', False, true));
		
		

		array_push($cp, array('$B8', '', 'Salvar >>>', false, true));
		return ($cp);
	}

	function contas_receber($dt) {
		$dt = sonumero($dt);
		$dt = substr($dt, 0, 4) . '-' . substr($dt, 4, 2) . '-' . substr($dt, 6, 2);
		$cp = '*';

		$sql = "select $cp, 1 as tipo from cx_receber 
							left join clientes ON id_f = cp_fornecedor
							where cp_vencimento = '$dt' and cp_situacao <> 9
						order by cp_vencimento, cp_valor desc 
						";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '';
		$saldo = 0;
		$sx = '<table width="100%" class="table" border=1>';
		$sx .= '<tr><th width="5%">venc.</th>
					<th width="57%">histórico</th>
					<th width="5%">pedido</th>
					<th width="10%">parcela</th>
					<th width="10%">valor</th>
					<th width="3%">#</th>
				</tr>' . cr();
		$saldo = 0;
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			/* previsao */
			if ($line['cp_previsao'] == '1') {
				$trc = ' class="warning" ';
			} else {
				$trc = '';
			}

			$id = $line['id_cp'];
			$sit = '';
			if ($line['cp_situacao'] == 1) {
				$sit = '<font onclick="newxy(\'' . base_url('index.php/financeiro/creceber_quitar/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer;" color="green"><b>$</b></font>';
				$link_edit = '<span onclick="newxy(\'' . base_url('index.php/financeiro/creceber_edit/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer; color: blue;">';
			} else {
				$link_edit = '';
				$trc = ' class="info" ';
			}

			$sx .= '<tr ' . $trc . '>';
			//$sx .= '<td>'.$line['cp_situacao'].'</td>';
			$sx .= '<td align="center" class="small">'.$line['cp_situacao'];
			$sx .= substr(sonumero($line['cp_vencimento']), 6, 2);
			$sx .= '/';
			$sx .= substr(sonumero($line['cp_vencimento']), 4, 2);
			$sx .= '</td>';

			$sx .= '<td class="middle">';
			$dados = UpperCase($line['cp_historico']);
			if (strlen($line['f_nome_fantasia']) > 0) {
				$dados = $line['f_nome_fantasia'] . '  - ' . $dados . ' ';
			}
			if (strlen(trim($line['cp_nossonumero'])) > 0) {
				$dados .= ' - Boleto ' . $line['cp_nossonumero'];
			}
			$sx .= $link_edit . $dados . '</a>';
			$sx .= '</td>';

			/******** PEDIDO **********/
			$sx .= '<td class="small">';

			$pedido = $line['cp_pedido'];
			if (substr($pedido, 5, 1) == '/') {
				$link = 'http://10.1.1.123:8080/pedidos/pedido_mostra.asp?dd1=' . $pedido;
				$pedido = '<a href="#" onclick="newxy(\'' . $link . '\',800,800);">' . $pedido . '</a>';
			}
			$sx .= $pedido;
			$sx .= '</td>';

			$sx .= '<td class="small">';
			$sx .= $line['cp_parcela'];
			$sx .= '</td>';

			$sx .= '<td align="right">';
			$sx .= '<b>';
			$sx .= number_format($line['cp_valor'], 2, ',', '.');
			$sx .= '</b>';
			$sx .= '</td>';

			$saldo = $saldo + $line['cp_valor'];

			$sx .= '<td align="center">';
			$sx .= '<b>';
			$sx .= $sit;
			$sx .= '</b>';
			$sx .= '</td>';

			$sx .= '</tr>';

		}
		$sx .= '</table>';
		return ($sx);
	}

	function contas_pagar($dt) {
		$dt = sonumero($dt);
		$dt = substr($dt, 0, 4) . '-' . substr($dt, 4, 2) . '-' . substr($dt, 6, 2);
		$cp = '*';
		$sql = "select $cp, 1 as tipo from cx_pagar 
							left join clientes ON id_f = cp_fornecedor
							where cp_vencimento = '$dt' and cp_situacao <> 9
						order by cp_vencimento, cp_valor desc 
						";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '';
		$saldo = 0;
		$sx = '<table width="100%" class="table" border=1>';
		$sx .= '<tr><th width="5%">venc.</th>
					<th width="62%">histórico</th>
					<th width="5%">pedido</th>
					<th width="5%">parc.</th>
					<th width="10%">valor</th>
					<th width="3%">#</th>
				</tr>' . cr();
		$saldo = 0;
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			/* previsao */
			if ($line['cp_previsao'] == '1') {
				$trc = ' class="warning" ';
			} else {
				$trc = '';
			}

			$id = $line['id_cp'];
			$sit = '';
			if ($line['cp_situacao'] == 1) {
				$sit = '<font onclick="newxy(\'' . base_url('index.php/financeiro/cpagar_quitar/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer;" color="green"><b>$</b></font>';
				$link_edit = '<span onclick="newxy(\'' . base_url('index.php/financeiro/cpagar_edit/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer; color: blue;">';
			} else {
				$link_edit = '';
				$trc = ' class="info" ';
			}

			$sx .= '<tr ' . $trc . '>';
			//$sx .= '<td>'.$line['cp_situacao'].'</td>';
			$sx .= '<td align="center" class="small">';
			$sx .= substr(sonumero($line['cp_vencimento']), 6, 2);
			$sx .= '/';
			$sx .= substr(sonumero($line['cp_vencimento']), 4, 2);
			$sx .= '</td>';

			$sx .= '<td class="middle">';
			$dados = UpperCase($line['cp_historico']);
			if (strlen($line['f_nome_fantasia']) > 0) {
				$dados = $line['f_nome_fantasia'] . '  - ' . $dados . ' ';
			}
			if (strlen(trim($line['cp_nossonumero'])) > 0) {
				$dados .= ' - Boleto ' . $line['cp_nossonumero'];
			}
			$sx .= $link_edit . $dados . '</a>';
			$sx .= '</td>';

			$sx .= '<td class="small">';
			$sx .= $line['cp_pedido'];
			$sx .= '</td>';

			$sx .= '<td class="small">';
			$sx .= $line['cp_parcela'];
			$sx .= '</td>';

			$sx .= '<td align="right">';
			$sx .= '<b>';
			$sx .= number_format($line['cp_valor'], 2, ',', '.');
			$sx .= '</b>';
			$sx .= '</td>';

			$saldo = $saldo - $line['cp_valor'];

			$sx .= '<td align="center">';
			$sx .= '<b>';
			$sx .= $sit;
			$sx .= '</b>';
			$sx .= '</td>';

			$sx .= '</tr>';

		}
		$sx .= '</table>';
		return ($sx);
	}

	function caixa_dia($dt) {
		$cp = '*';
		$sql = "select $cp, 1 as tipo from cx_pagar 
							where cp_vencimento = '$dt'
						order by cp_valor desc 
						";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '';
		$saldo = 0;
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$sx .= '<tr>';
			$sx .= '<td align="center" class="small">';
			$sx .= substr(sonumero($line['cp_vencimento']), 6, 2);
			$sx .= '</td>';

			$sx .= '<td class="middle">';
			$sx .= $line['cp_historico'];
			$sx .= '</td>';

			$sx .= '<td class="small">';
			$sx .= $line['cp_parcela'];
			$sx .= '</td>';

			$sx .= '<td>';
			$sx .= '</td>';

			$sx .= '<td class="middle alert-danger" align="right">';
			$sx .= '<b>';
			$sx .= number_format($line['cp_valor'], 2, ',', '.');
			$sx .= '</b>';
			$sx .= '</td>';

			/*** saldo *****/
			$saldo = $saldo - $line['cp_valor'];
			if ($saldo < 0) {
				$sx .= '<td class="middle alert-danger" align="right">';
				$sx .= '<b>';
				$sx .= number_format($saldo, 2, ',', '.');
				$sx .= '</b>';
				$sx .= '</td>';
			} else {
				$sx .= '<td class="middle alert-success" align="right">';
				$sx .= '<b>';
				$sx .= number_format($saldo, 2, ',', '.');
				$sx .= '</b>';
				$sx .= '</td>';
			}

			$sx .= '</tr>';
		}
		$data['dados'] = $sx;
		$sx = $this -> load -> view('financeiro/caixa', $data, true);
		return ($sx);
	}

	function financeiro_relatorio($tipo) {
		$table = $this -> table_pagar;
		if ($tipo == 2) {
			$table = $this -> table_receber;
		}
		$wh = '';
		$sx = '';
		$ano1 = get("dd1");
		$ano2 = get("dd2");
		$wh .= " AND (cp_vencimento >= '" . $ano1 . "-01-01') ";
		$wh .= " AND (cp_vencimento <= '" . $ano2 . "-12-31') ";

		$sqlx = "select count(*) as itens, sum(cp_valor) as valor, substring(cp_vencimento,1,7) as ano from $table 
							left join clientes ON id_f = cp_fornecedor
							where (1=1) $wh AND cp_situacao = 2
							GROUP BY ano
							ORDER BY ano ";
		$rlt = $this -> db -> query($sqlx);
		$rlt = $rlt -> result_array();
		$ser = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$series = array();
		if (count($rlt) > 0) {
			for ($r = 0; $r < count($rlt); $r++) {
				$line = $rlt[$r];
				$ano = substr($line['ano'], 0, 4);
				if (!isset($series[$ano])) { $series[$ano] = $ser;
				}
				$mes = round(substr($line['ano'], 5, 2));
				$series[$ano][$mes] = $line['valor'];

				//$tot = round($line['itens']);
			}

			$data['series'] = $series;
			$sx .= $this -> load -> view('highcharts/bars.php', $data, true);
		}
		return ($sx);
	}

	function financeiro_abertos($tipo) {
		$table = $this -> table_pagar;
		$dt1 = date("Y-m-d");
		$dt2 = "2099-01-01";
		$wh = '';

		if ($tipo == 2) {
			$table = $this -> table_receber;
		}

		/* Data */
		$t3 = trim(get("dd1"));
		if (strlen($t3) > 0) {
			$t3 = brtos($t3);
			$t3 = sonumero($t3);
			$t3 = substr($t3, 0, 4) . '-' . substr($t3, 4, 2) . '-' . substr($t3, 6, 2);
			$wh .= " AND (cp_vencimento >='" . $t3 . "') 
						";
		} else {
			$t3 = date("Y-m-d");
			$wh .= " AND (cp_vencimento >='" . $t3 . "') ";
		}
		$t4 = trim(get("dd2"));
		if (strlen($t4) > 0) {
			$t4 = brtos($t4);
			$t4 = sonumero($t4);
			$t4 = substr($t4, 0, 4) . '-' . substr($t4, 4, 2) . '-' . substr($t4, 6, 2);
			$wh .= " AND (cp_vencimento <='" . $t4 . "') ";
		}

		/* Situacao */
		$t5 = get("dd3");
		if (strlen($t5) > 0) {
			switch($t5) {
				case 'A' :
					$wh .= ' AND (cp_situacao = 1) ';
					break;
				case 'P' :
					$wh .= ' AND (cp_situacao = 2) ';
					break;
			}
		}

		$sql = "select * from $table 
							left join clientes ON id_f = cp_fornecedor
							where 1=1
							$wh
						order by cp_vencimento, cp_valor desc 
						limit 200
						";

		/* SALDO */
		$sx = '';
		$sqlx = "select count(*) as itens, sum(cp_valor) as valor from $table 
							left join clientes ON id_f = cp_fornecedor
							where (1=1) $wh ";
		$rlt = $this -> db -> query($sqlx);
		$rlt = $rlt -> result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			$vlr = number_format($line['valor'], 2, ',', '.');
			$tot = round($line['itens']);
			$sx .= '<table width="100%" class="table" border=1>';
			$sx .= '<tr><td>Valor ' . $vlr . ' (' . $tot . ')' . '</td></tr>';
			$sx .= '</table>';
		}

		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx .= '<br><table width="100%" class="table" border=1>';
		$sx .= '<tr><th width="5%">venc.</th>
					<th width="62%">histórico</th>
					<th width="5%">pedido</th>
					<th width="5%">parc.</th>
					<th width="10%">valor</th>
					<th width="3%">#</th>
				</tr>' . cr();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$data['line'] = $line;
			if ($tipo == 1) {
				$sx .= $this -> load -> view('financeiro/row_pagar', $data, true);
			}
			if ($tipo == 2) {
				$sx .= $this -> load -> view('financeiro/row_receber', $data, true);
			}
		}
		$sx .= '</table>';
		return ($sx);
	}

	function busca($tipo) {

		$dt1 = date("Y-m-d");
		$dt2 = "2099-01-01";
		$t7 = troca(get("dd7"), '.', '');
		$t7 = round(troca($t7, ',', '.'));
		$t8 = troca(get("dd8"), '.', '');
		$t8 = round(troca($t8, ',', '.'));
		
		$t10 = get("dd10");

		$table = $this -> table_pagar;
		if ($tipo == 2) {
			$table = $this -> table_receber;
		}
		/* busca */
		$t1 = trim(get("dd1"));
		$wh = '';
		if (strlen($t1) > 0) {
			$wh .= " AND 
						(
							(cp_historico like '%" . $t1 . "%') 
							OR
							(f_razao_social like '%" . $t1 . "%') 
							OR
							(f_nome_fantasia like '%" . $t1 . "%') 
						)
						";
		}
		/* Valores */
		if ($t7 > 0) {
			$wh .= " AND (cp_valor >= $t7) ";
		}
		if ($t8 > 0) {
			$wh .= " AND (cp_valor <= $t8) ";
		}
		/* Tipos */
		if (strlen($t10) > 0)
			{
				switch ($t10)
					{
					case '2':
						$wh .= ' AND (cp_situacao = 1)';
						break;
					case '3':
						$wh .= " AND (cp_vencimento < '".date("Y-m-d")."' and cp_situacao = 1)";
						break;						
					case '4':
						$wh .= ' AND (cp_situacao = 2)';
						break;						
					}
			}
		/* Boleto */
		$t5 = trim(get("dd5"));
		if (strlen($t5) > 0) {
			$wh .= " AND 
						(
							(cp_nossonumero like '%" . $t5 . "%') 
							or 
							(cp_doc like '%" . $t5 . "%')
							or
							(cp_pedido like '%" . $t5 . "%')
						)
						";
		}

		/* Data */
		$t3 = trim(get("dd3"));
		if (strlen($t3) > 0) {
			$t3 = brtos($t3);
			$t3 = sonumero($t3);
			$t3 = substr($t3, 0, 4) . '-' . substr($t3, 4, 2) . '-' . substr($t3, 6, 2);
			$wh .= " AND (cp_vencimento >='" . $t3 . "') 
						";
		} else {
			$t3 = date("Y-m-d");
			$t3 = '2000-01-01';
			$wh .= " AND (cp_vencimento >='" . $t3 . "') ";
		}
		$t4 = trim(get("dd4"));
		if (strlen($t4) > 0) {
			$t4 = brtos($t4);
			$t4 = sonumero($t4);
			$t4 = substr($t4, 0, 4) . '-' . substr($t4, 4, 2) . '-' . substr($t4, 6, 2);
			$wh .= " AND (cp_vencimento <='" . $t4 . "') ";
		}
		
		/************* resumos */
		$sx = '';
		$sql = "select count(*) as itens, sum(cp_valor) as total from $table 
					left join clientes ON id_f = cp_fornecedor
					where 1=1 $wh";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		
		$sx .= '<h3>('.$rlt[0]['itens'].') itens, valor '.number_format($rlt[0]['total']).'</h3>';

		$sql = "select * from $table 
							left join clientes ON id_f = cp_fornecedor
							where 1=1
							$wh
						order by cp_vencimento desc, cp_valor desc 
						limit 150
						";

		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx .= '<br><table width="100%" class="table" border=1>';
		$sx .= '<tr><th width="5%">venc.</th>
					<th width="62%">histórico</th>
					<th width="5%">pedido</th>
					<th width="5%">parc.</th>
					<th width="10%">valor</th>
					<th width="3%">#</th>
				</tr>' . cr();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$data['line'] = $line;
			if ($tipo == 1) {
				$sx .= $this -> load -> view('financeiro/row_pagar', $data, true);
			}
			if ($tipo == 2) {
				$sx .= $this -> load -> view('financeiro/row_receber', $data, true);
			}
		}
		$sx .= '</table>';
		return ($sx);
	}

	function financeiro_comparacao() {
		$table = $this -> table_pagar;
		$wh = '';
		$sx = '';
		$ano1 = get("dd1");
		$wh .= " AND (cp_vencimento >= '" . $ano1 . "-01-01') ";
		$wh .= " AND (cp_vencimento <= '" . $ano1 . "-12-31') ";

		$sqlx = "select count(*) as itens, sum(cp_valor) as valor, substring(cp_vencimento,1,7) as ano from $table 
							left join clientes ON id_f = cp_fornecedor
							where (1=1) $wh AND cp_situacao = 2
							GROUP BY ano
							ORDER BY ano ";
		$rlt = $this -> db -> query($sqlx);
		$rlt = $rlt -> result_array();
		$ser = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$series = array();
		if (count($rlt) > 0) {
			for ($r = 0; $r < count($rlt); $r++) {
				$line = $rlt[$r];
				$ano = substr($line['ano'], 0, 4);
				if (!isset($series['pago'])) { $series['pago'] = $ser;
				}
				$mes = round(substr($line['ano'], 5, 2));
				$series['pago'][$mes] = $line['valor'];

				//$tot = round($line['itens']);
			}
		}

		$table = $this -> table_receber;
		$sx = '';

		$sqlx = "select count(*) as itens, sum(cp_valor) as valor, substring(cp_vencimento,1,7) as ano from $table 
							left join clientes ON id_f = cp_fornecedor
							where (1=1) $wh AND cp_situacao = 2
							GROUP BY ano
							ORDER BY ano ";
		$rlt = $this -> db -> query($sqlx);
		$rlt = $rlt -> result_array();

		if (count($rlt) > 0) {
			for ($r = 0; $r < count($rlt); $r++) {
				$line = $rlt[$r];
				$ano = substr($line['ano'], 0, 4);
				if (!isset($series['receber'])) { $series['receber'] = $ser;
				}
				$mes = round(substr($line['ano'], 5, 2));
				$series['receber'][$mes] = $line['valor'];

				//$tot = round($line['itens']);
			}
		}

		$data['series'] = $series;
		$sx .= $this -> load -> view('highcharts/bars.php', $data, true);

		return ($sx);
	}

	function razao_acompanhamento($ano, $mes) {
		$table = $this -> table_pagar;
		$wh = '';
		$sx = '';
		$ano1 = get("dd1");
		$wh .= " AND (cp_vencimento >= '" . $ano1 . "-" . strzero($mes, 2) . "-01') ";
		$wh .= " AND (cp_vencimento <= '" . $ano1 . "-" . strzero($mes, 2) . "-31') ";

		$sqlx = "select count(*) as itens, sum(cp_valor) as valor, id_cd, cd_cod_contabil, cd_descricao, cd_codigo from $table 
							left join cx_conta_codigo on cp_conta = id_cd
							where (1=1) $wh AND cp_situacao = 2
							GROUP BY id_cd, cd_cod_contabil, cd_descricao, cd_codigo
							ORDER BY cd_cod_contabil, cd_descricao ";
		$rlt = $this -> db -> query($sqlx);
		$rlt = $rlt -> result_array();

		$sx = '<table class="table" width="100%">';
		$sx .= '<tr>
				<th width="15%">Código contábil</th>
				<th width="55%">Descrição</th>
				<th width-"15%">Saldo conta</th>
				<th width="15%" align="right">Acumulado</th>
				</tr>';
		$saldo = 0;
		if (count($rlt) > 0) {
			for ($r = 0; $r < count($rlt); $r++) {
				$line = $rlt[$r];
				$data = $ano . '-' . strzero($mes, 2);
				$link = '<a href="' . base_url('index.php/financeiro/contabil_detalhado/' . $line['id_cd'] . '/' . $data) . '" target="_new">';
				$saldo = $saldo + $line['valor'];
				$sx .= '<tr>';
				$sx .= '<td>' . $link . $line['cd_cod_contabil'] . '</a></td>';
				$sx .= '<td>' . $link . $line['cd_descricao'] . '</a></td>';
				$sx .= '<td align="right">' . number_format($line['valor'], 2, ',', '.') . '</td>';
				$sx .= '<td align="right">' . number_format($saldo, 2, ',', '.') . '</td>';
				$sx .= '</tr>';
			}
		}
		$table = $this -> table_receber;

		$sqlx = "select count(*) as itens, sum(cp_valor) as valor, id_cd, cd_cod_contabil, cd_descricao, cd_codigo from $table 
							left join cx_conta_codigo on cp_conta = id_cd
							where (1=1) $wh AND cp_situacao = 2
							GROUP BY id_cd, cd_cod_contabil, cd_descricao, cd_codigo
							ORDER BY cd_cod_contabil, cd_descricao ";
		$rlt = $this -> db -> query($sqlx);
		$rlt = $rlt -> result_array();

		if (count($rlt) > 0) {
			for ($r = 0; $r < count($rlt); $r++) {
				$line = $rlt[$r];
				$data = $ano . '-' . strzero($mes, 2);
				$link = '<a href="' . base_url('index.php/financeiro/contabil_detalhado/' . $line['id_cd'] . '/' . $data) . '" target="_new">';
				$saldo = $saldo - $line['valor'];
				$sx .= '<tr>';
				$sx .= '<td>' . $link . $line['cd_cod_contabil'] . '</a></td>';
				$sx .= '<td>' . $link . $line['cd_descricao'] . '</a></td>';
				$sx .= '<td align="right">-' . number_format($line['valor'], 2, ',', '.') . '</td>';
				$sx .= '<td align="right">' . number_format($saldo, 2, ',', '.') . '</td>';
				$sx .= '</tr>';
			}
		}

		$sx .= '</table>';
		return ($sx);
	}

	function razao_detalhado_acompanhamento($ct, $date) {
		$table = $this -> table_pagar;
		$wh = '';
		$sx = '';
		$ano1 = get("dd1");
		$wh .= " AND (cp_vencimento >= '" . $date . "-01') ";
		$wh .= " AND (cp_vencimento <= '" . $date . "-31') ";
		$wh .= " AND (id_cd = $ct) ";

		$sqlx = "select * from $table 
							left join cx_conta_codigo on cp_conta = id_cd
							left join clientes ON id_f = cp_fornecedor
							where (1=1) $wh AND (cp_situacao = 2)
							ORDER BY cd_cod_contabil, cd_descricao ";
		$rlt = $this -> db -> query($sqlx);
		$rlt = $rlt -> result_array();

		$sx = '<table class="table" width="100%">';
		$sx .= '<tr><th width="5%">venc.</th>
					<th width="62%">histórico</th>
					<th width="5%">pedido</th>
					<th width="5%">parc.</th>
					<th width="10%">valor</th>
					<th width="3%">#</th>
				</tr>' . cr();
		$saldo = 0;
		if (count($rlt) > 0) {
			for ($r = 0; $r < count($rlt); $r++) {
				$line = $rlt[$r];
				$data['line'] = $line;
				$sx .= $this -> load -> view('financeiro/row_pagar', $data, true);
			}
			$sx .= '</table>';
			return ($sx);
		}
	}

}
?>
