<?php
class financeiros extends CI_model {
	var $table_pagar = 'cx_pagar';
	var $table_receber = 'cx_receber';

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
					<th width="10%">fatura</th>
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

			$sx .= '<td class="middle '.$line['cpa_classe'].'" align="right">';
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
		array_push($cp, array('$S80', 'cp_parcela', 'Parcela', True, true));
		array_push($cp, array('$S80', 'cp_doc', 'Documento', False, true));
		array_push($cp, array('$Q id_cd:cd_descricao:select * from cx_conta_codigo where cd_cpage = 1', 'cp_conta', 'Conta', False, true));
		array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_fornecedor = 1', 'cp_fornecedor', 'Fornecedor', False, true));

		array_push($cp, array('$Q id_cpa:cpa_descricao:select * from cx_pagar_situacao where cpa_ativo = 1', 'cp_situacao', 'Situação', true, true));

		array_push($cp, array('$N8', 'cp_valor', 'Valor', True, True));
		array_push($cp, array('$HV', 'cp_valor_pago', get("dd10"), True, true));

		array_push($cp, array('$S80', 'cp_nossonumero', 'Cod.Barras', False, True));
		array_push($cp, array('$O 1:SIM&0:NÃO', 'cp_previsao', 'Previsão', True, true));

		array_push($cp, array('$B8', '', 'Salvar >>>', false, true));
		return ($cp);
	}

	function cp_creceber_editar($id = 0) {
		$cp = array();
		array_push($cp, array('$H8', 'id_cp', '', false, true));
		array_push($cp, array('$D8', 'cp_vencimento', 'Vencimento', True, true));
		array_push($cp, array('$S80', 'cp_historico', 'Historico', True, true));
		array_push($cp, array('$S80', 'cp_pedido', 'Pedido', True, true));
		array_push($cp, array('$S80', 'cp_parcela', 'Parcela', False, true));
		array_push($cp, array('$S80', 'cp_doc', 'Documento', False, true));
		array_push($cp, array('$Q id_cd:cd_descricao:select * from cx_conta_codigo where cd_cpage = 2', 'cp_conta', 'Conta', False, true));
		array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_ativo = 1', 'cp_fornecedor', 'Sacado', False, true));

		array_push($cp, array('$Q id_cpa:cpa_descricao:select * from cx_pagar_situacao where cpa_ativo = 1', 'cp_situacao', 'Situação', true, true));

		array_push($cp, array('$N8', 'cp_valor', 'Valor', True, True));
		array_push($cp, array('$HV', 'cp_valor_pago', get("dd10"), True, true));

		array_push($cp, array('$S80', 'cp_nossonumero', 'Cod.Barras', False, True));
		array_push($cp, array('$O 1:SIM&0:NÃO', 'cp_previsao', 'Previsão', True, true));

		array_push($cp, array('$B8', '', 'Salvar >>>', false, true));
		return ($cp);
	}

	function contas_receber($dt) {
		$dt = sonumero($dt);
		$dt = substr($dt, 0, 4) . '-' . substr($dt, 4, 2) . '-' . substr($dt, 6, 2);
		$cp = '*';
		$sql = "select $cp, 1 as tipo from cx_receber 
							where cp_vencimento = '$dt'
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
					<th width="10%">fatura</th>
					<th width="10%">valor</th>
					<th width="10%">saldo</th>
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

			$sx .= '<td class="middle alert-success" align="right">';
			$sx .= '<b>';
			$sx .= number_format($saldo, 2, ',', '.');
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

	function contas_pagar($dt) {
		$dt = sonumero($dt);
		$dt = substr($dt, 0, 4) . '-' . substr($dt, 4, 2) . '-' . substr($dt, 6, 2);
		$cp = '*';
		$sql = "select $cp, 1 as tipo from cx_pagar 
							where cp_vencimento = '$dt'
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
					<th width="10%">saldo</th>
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
			$sx .= $link_edit . UpperCase($line['cp_historico']) . '</a>';
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

			$sx .= '<td class="middle alert-danger" align="right">';
			$sx .= '<b>';
			$sx .= number_format($saldo, 2, ',', '.');
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

}
?>
