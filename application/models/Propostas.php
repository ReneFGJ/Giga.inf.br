<?php
class propostas extends CI_model {
	var $table = 'pedido';
	var $table_item = 'pedido_itens';

	function cp_item($id, $id_pp) {
		$id_us = $_SESSION['id'];
		$cp = array();
		array_push($cp, array('$H8', 'id_pi', '', False, True));
		array_push($cp, array('$HV', '', 'ITEM', True, True));
		array_push($cp, array('$S80', 'pi_produto', 'Produto', True, True));
		array_push($cp, array('$N8', 'pi_quant', 'Quantidade', False, True));
		array_push($cp, array('$N8', 'pi_valor_unit', 'Vlr. Unitário', False, True));
		array_push($cp, array('$T80:6', 'pi_descricao', 'Descricao', False, True));
		if ($id == 0) {
			array_push($cp, array('$HV', 'pi_vendor', $id_us, False, True));
			array_push($cp, array('$HV', 'pi_ativo', '1', False, True));
			array_push($cp, array('$HV', 'pi_seq', '0', False, True));
			array_push($cp, array('$HV', 'pi_nr', $id_pp, False, True));
		} else {
			array_push($cp, array('$O 1:Não&0:Sim', 'pi_ativo', 'Excluir', False, True));
		}
		array_push($cp, array('$B8', '', '', False, True));
		return ($cp);
	}
	
	function cp_condicoes($id=0)
		{
		global $ddi;
		$ddi = 0;
		$cp = array();
		array_push($cp, array('$H8', 'id_pp', '', False, True));
		array_push($cp, array('$HV', '', 'CONDICOES', True, True));
		
		/* CONDICOES DE PAGAMENTO */
		$sql = "select * from condicoes_pagamento where pg_ativo = 1 order by pg_seq ";
		array_push($cp, array('$Q id_pg:pg_nome:'.$sql, 'pp_condicoes', 'Condições de pagamento', False, True));
		
		/* PRAZO DE ENTREGA */
		$sql = "select * from prazo_entrega where pz_ativo = 1 order by pz_seq ";
		array_push($cp, array('$Q id_pz:pz_nome:'.$sql, 'pp_prazo_entrega', 'Prazo de entrega', False, True));
		
		/* VALIDADE DA PROPOSTA */		
		$sql = "select * from pedido_validade where vd_ativo = 1 order by vd_seq ";
		array_push($cp, array('$Q id_vd:vd_nome:'.$sql, 'pp_validade_proposta', 'Validade da proposta', False, True));
		
		/* GARANTIA */
		$sql = "select * from prazo_garantia where pga_ativo = 1 order by pga_seq ";
		array_push($cp, array('$Q id_pga:pga_nome:'.$sql, 'pp_garantia', 'Garantia', False, True));
		
		/* MONTAGEM */
		$sql = "select * from prazo_montagem where pm_ativo = 1 order by pm_seq ";
		array_push($cp, array('$Q id_pm:pm_nome:'.$sql, 'pp_montagem', 'Montagem', False, True));
		
		
		/* SOBRE O EVENTO */
		array_push($cp, array('$[0-800]', 'pp_periodo_locacao', 'Período de locação (dias)', False, True));
		array_push($cp, array('$D8', 'pp_dt_ini_evento', 'Dt. início evento', False, True));
		array_push($cp, array('$D8', 'pp_dt_fim_evento', 'Dt. final do evento', False, True));
		
		array_push($cp, array('$B8', '', 'Gravar >>>', False, True));
		
		return ($cp);			
		}

	function le($id) {
		$sql = "select * from " . $this -> table . "
					INNER JOIN users on id_us = pp_vendor 
					LEFT JOIN condicoes_pagamento ON id_pg = pp_condicoes AND pg_visivel = 1
					LEFT JOIN prazo_garantia ON id_pga = pp_garantia AND pga_visivel = 1
					LEFT JOIN prazo_entrega ON id_pz = pp_prazo_entrega AND pz_visivel = 1
					LEFT JOIN prazo_montagem ON id_pm = pp_montagem AND pm_visivel = 1
					LEFT JOIN pedido_validade ON id_vd = pp_validade_proposta AND vd_visivel = 1
					
					WHERE id_pp = " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			return ($line);
		} else {
			return ( array());
		}
	}

	function form_item($id, $id_pp) {
		global $ddi;
		$ddi = 0;
		$dd0 = round("0" . get("dd0"));
		if ($id > 0) {
			$form = new form;
			$form -> id = $id;
			$cp = $this -> propostas -> cp_item($id, $id_pp);
			$tela = $form -> editar($cp, 'proposta_itens');

			if ($form -> saved > 0) {
				echo 'SAVED';
				redirect(base_url('index.php/main/proposta_editar/' . $id_pp));
			}
			return ($tela);
		}
		return ('');
	}

	function form_item_novo($id, $id_pp) {
		global $ddi;
		$dd0 = round("0" . get("dd0"));
		$ddi = 0;
		if (($id == 0) and ($dd0 == 0)) {
			$form = new form;
			$form -> id = $id;
			$cp = $this -> propostas -> cp_item($id, $id_pp);
			$tela = $form -> editar($cp, 'proposta_itens');

			if ($form -> saved > 0) {
				echo 'SAVED';
				redirect(base_url('index.php/main/proposta_editar/' . $id_pp));
			}
			return ($tela);
		}
		return ('');
	}

	function resumo($id) {
		$sql = "select count(*) as total from " . $this -> table . " where (pp_situacao = 0 or pp_situacao = 1) and (pp_cliente = $id)";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		return ($rlt[0]['total']);
	}

	function botao_nova_proposta($id) {
		$sx = '<a href="' . base_url('index.php/main/proposta_nova_inserir/' . $id . '/' . checkpost_link($id)) . '">';
		$sx .= '<button type="button" class="btn btn-primary">';
		$sx .= msg('proposta_nova');
		$sx .= '</button>';
		$sx .= '</a>' . cr();
		return ($sx);
	}

	function updatex() {
		$sql = "update " . $this -> table . " set pp_nr = lpad(id_pp,7,0) where pp_nr = 0 or pp_nr is null";
		$rlt = $this -> db -> query($sql);
		return ('');
	}

	function lista_por_cliente($id) {
		$id_us = $_SESSION['id'];

		$sql = "select * from " . $this -> table . " 
					INNER JOIN users on pp_vendor = id_us
					WHERE (pp_cliente = $id)
					order by pp_situacao, pp_data";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table width="100%" class="table">' . cr();
		$sx .= '<tr class="small">
					<th width="2%">#</th>
					<th width="8%">data</th>
					<th width="10%">nr.</th>
					<th width="35%">descrição</th>
					<th width="25%">vendedor</th>
					<th width="20%">situação</th>
					<th width="20%">vlr.total</th>
				</tr>' . cr();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$data = sonumero($line['pp_data']);
			$desc = 'Proposta';
			$valor = 0;
			$situacao = 'em edição';
			$desc = 'Pedido';
			$link = '<a href="' . base_url('index.php/main/proposta/' . $line['id_pp'] . '/' . checkpost_link($line['id_pp'])) . '">';
			$sx .= '<tr class="middle">';
			$sx .= '<td align="center">' . ($r + 1) . '</td>';
			$sx .= '<td align="center">' . stodbr($data) . '</td>';
			$sx .= '<td align="center">' . $link . $line['pp_nr'] . '/' . $line['pp_ano'] . '</a>' . '</td>';
			$sx .= '<td align="left">' . $desc . '</td>';
			$sx .= '<td align="left">' . $line['us_nome'] . '</td>';
			$sx .= '<td align="left">' . $situacao . '</td>';
			$sx .= '<td align="right">' . number_format($valor, 2, ',', '.') . '</td>';
			if ($id_us == $line['pp_vendor']) {
				$link = '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
				$link = '<a href="' . base_url('index.php/main/proposta_editar/' . $line['id_pp'] . '/' . checkpost_link($line['id_pp'])) . '">' . $link . '</a>';
				$sx .= '<td align="center">' . $link . '</td>';
			}
			$sx .= '</tr>' . cr();
		}
		if (count($rlt) == 0) {
			$sx .= '<tr><td colspan="10"><font class="red">' . msg('not_register') . '</font></td></tr>' . cr();
		}
		$sx .= '</table>' . cr();
		return ($sx);
	}

	function proposta_condicoes($id,$editar)
		{
			if ($editar == 1)
				{
					$cp = $this->cp_condicoes();
					$form = new form;
					$form->id = $id;
					$tela = $form->editar($cp,$this->table);
					return($tela);
				} else {
					$prop = $this->le($id);
					$tela = $this->load->view('proposta/proposta_condicoes',$prop,true);
					return($tela);
				}
		}

	function proposta_nova($id) {
		$id_us = $_SESSION['id'];
		$data = date('Y-m-d H:i:s');
		$ano = substr(date("Y"), 2, 2);
		$sql = "insert into " . $this -> table . " 
					(pp_cliente, pp_vendor, pp_situacao, pp_data, pp_ano)
					value
					($id, $id_us,'0','$data','$ano')";
		$rlt = $this -> db -> query($sql);
		$this -> updatex();

		$sql = "select * from " . $this -> table . " where pp_cliente = $id and pp_data = '$data' ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();

		$id = $rlt[0]['id_pp'];
		return ($id);
	}

	function proposta_items($id, $edit = 0) {
		global $ddi;
		$id_us = $_SESSION['id'];
		$sql = "select * from " . $this -> table_item . " 
					WHERE (pi_nr = $id) and (pi_ativo = 1)
					order by pi_seq";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sxf = '';
		$sx = '<table width="100%" class="table">' . cr();
		$sx .= '<tr class="small">
					<th width="2%">#</th>
					<th width="70%">produto</th>
					<th width="8%">quant.</th>
					<th width="10%">vlr.unitário</th>
					<th width="10%">vlr.total</th>
				</tr>' . cr();
		$tot1 = 0;
		$tot2 = 0;
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];

			$sx .= '<tr class="middle">';
			$sx .= '<td align="center">' . ($r + 1) . '</td>';
			$sx .= '<td align="left" class="big">' . $line['pi_produto'] . '</td>';
			$sx .= '<td align="right"><b>' . number_format($line['pi_quant'], 1, ',', '.') . '</b></td>';
			$sx .= '<td align="right">' . number_format($line['pi_valor_unit'], 2, ',', '.') . '</td>';
			$sx .= '<td align="right" class="big"><b>' . number_format($line['pi_quant'] * $line['pi_valor_unit'], 2, ',', '.') . '</b></td>';
			if (($id_us == $line['pi_vendor']) and ($edit == 1)) {
				$link = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#item_editar_' . $line['id_pi'] . '" style="mouse: pointer;">';
				$link .= '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
				$link .= '</button>';
				$sx .= '<td align="center">' . $link . '</td>';
			}
			$sx .= '</tr>' . cr();
			
			$tot1 = $tot1 + $line['pi_quant'];
			$tot2 = $tot2 + ($line['pi_quant'] * $line['pi_valor_unit']);

			if (strlen($line['pi_descricao']) > 0) {
				$sx .= '<tr class="small"><td></td><td>' . mst($line['pi_descricao']) . '</td></tr>';
			}
			$data = array();
			$ddi = 0;
			$data['dados_item_form'] = $this -> form_item($line['id_pi'], $line['pi_nr']);
			$data['id_pp'] = $line['pi_nr'];
			$data['id_pi'] = $line['id_pi'];
			if ($edit == 1) {
				$sxf .= $this -> load -> view('proposta/proposta_item_editar.php', $data, true);
			}
		}
		if (count($rlt) == 0) {
			$sx .= '<tr><td colspan="10"><font class="red">' . msg('not_register') . '</font></td></tr>' . cr();
		} else {
			$sx .= '<tr><td colspan="10" align="right"><b>' . $tot1. ' itens, total da proposta R$ '.number_format($tot2,2,',','.').'</b></td></tr>' . cr();
		}
		$sx .= '</table>' . cr();

		$sx .= $sxf;
		return ($sx);
	}

	function propostas_abertas($id_us) {
		$sql = "select * from " . $this -> table . " 
					INNER JOIN users on pp_vendor = id_us
					INNER JOIN clientes on pp_cliente = id_f
					WHERE pp_vendor = " . round($id_us) . "
					AND ((pp_situacao = 0) OR (pp_situacao = 1))
					AND (pp_tipo_pedido = 1)
					ORDER BY pp_data desc ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<div class="container">';
		$sx .= '<div class="row">';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$tipo = $line['pp_situacao'];
			
			switch ($tipo)
				{
				case '0':
					$tipo = 'alert-danger';
					break;
				case '1':
					$tipo = 'alert-success';
					break;
				}
			
			$validade = $line['pp_validade_proposta'];
			$link = base_url('index.php/main/proposta/' . $line['id_pp'] . '/' . checkpost_link($line['id_pp']));
			$sx .= '<a href="' . $link . '">';
			//$sx .= '<div class="col-md-3 painel alert alert-danger">';
			$sx .= '<div class="col-md-3">';
			$sx .= '<button class="alert '.$tipo.' painel">';
			$sx .= '<span class="small" >' . stodbr($line['pp_data']) . '</span>';
			$sx .= '<br>';
			$sx .= '<span class="small" >Proposta nº ' . round($line['pp_nr']) . '/' . $line['pp_ano'] . '</span>';

			$sx .= '<br>';
			$sx .= '<span class="big" >' . $line['f_nome_fantasia'] . '</span>';

			$sx .= '<br>';
			$sx .= '<span class="small" >Vendedor: ' . $line['us_nome'] . '</span>';
			$sx .= '</button>';
			$sx .= '</div>';
			$sx .= '</a>';
			$sx .= cr();
		}
		$sx .= '</div>';
		$sx .= '</div>';
		return ($sx);
	}
	function proposta_finalizar($id)
		{
			$sql = "update ".$this->table." set pp_situacao = 1 where id_pp = ".$id;
			$this->db->query($sql);
			return('');
		}
	function proposta_acoes($data)
		{
			$sit = $data['pp_situacao'];
			$id = $data['id_pp'];
			$ac = array();
			$sx = '';
			switch ($sit)
				{
				case '0':
					$sx .= '<div class="row">
								<div class="col-md-12">
									<a href="'.base_url('index.php/main/proposta_finalizar/'.$id.'/'.checkpost_link($id)).'" class="btn btn-primary nopr">Finalizar edição</a>
									&nbsp;																	
									<a href="'.base_url('index.php/main/proposta_editar/'.$id.'/'.checkpost_link($id)).'" class="btn btn-primary nopr">Editar proposta</a>
									&nbsp;
									<a href="#" class="btn btn-default">Cancelar proposta</a>
									&nbsp;

								</div>
							</div>';
					break;
				default:
					break;		
				}
			return($sx);
		}

}
?>
