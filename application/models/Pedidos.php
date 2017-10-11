<?php
class pedidos extends CI_model {
	var $table = 'pedido';
	var $table_item = 'pedido_itens';

	function cp_item($id, $id_pp) {
		$id_us = $_SESSION['id'];
		$cp = array();
		array_push($cp, array('$H8', 'id_pi', '', False, True));
		array_push($cp, array('$HV', '', 'ITEM', True, True));
		array_push($cp, array('$S80', 'pi_produto', 'Produto', True, True));
		array_push($cp, array('$T80:3', 'pi_descricao', 'Descrição', False, True));
		array_push($cp, array('$N8', 'pi_quant', 'Quantidade', False, True));
		array_push($cp, array('$N8', 'pi_valor_unit', 'Vlr. Unitário', False, True));
		array_push($cp, array('$[0-800]', 'pi_qt_diarias', 'Período de locação', False, True));

		if ($id == 0) {
			array_push($cp, array('$HV', 'pi_vendor', $id_us, False, True));
			array_push($cp, array('$HV', 'pi_ativo', '1', False, True));
			array_push($cp, array('$HV', 'pi_seq', '0', False, True));
			array_push($cp, array('$HV', 'pi_nr', $id_pp, False, True));
		} else {
			array_push($cp, array('$O 1:Não&0:Sim', 'pi_ativo', 'Excluir', False, True));
		}
		array_push($cp, array('$B8', '', 'Gravar', False, True));
		return ($cp);
	}

	function cp_condicoes($id = 0) {
		global $ddi;
		$ddi = 0;
		$cp = array();
		array_push($cp, array('$H8', 'id_pp', '', False, True));
		array_push($cp, array('$HV', '', 'CONDICOES', True, True));

		/* CONDICOES DE PAGAMENTO */
		$sql = "select * from condicoes_pagamento where pg_ativo = 1 order by pg_seq ";
		array_push($cp, array('$Q id_pg:pg_nome:' . $sql, 'pp_condicoes', 'Condições de pagamento', False, True));

		/* PRAZO DE ENTREGA */
		$sql = "select * from prazo_entrega where pz_ativo = 1 order by pz_seq ";
		array_push($cp, array('$Q id_pz:pz_nome:' . $sql, 'pp_prazo_entrega', 'Prazo de entrega', False, True));

		/* VALIDADE DA pedido */
		//$sql = "select * from pedido_validade where vd_ativo = 1 order by vd_seq ";
		//array_push($cp, array('$Q id_vd:vd_nome:'.$sql, 'pp_validade_ppdido', 'Validade da pedido', False, True));
		array_push($cp, array('$HV' . $sql, 'pp_validade_ppdido', 1, False, True));

		/* GARANTIA */
		$sql = "select * from prazo_garantia where pga_ativo = 1 order by pga_seq ";
		array_push($cp, array('$Q id_pga:pga_nome:' . $sql, 'pp_garantia', 'Garantia', False, True));

		/* MONTAGEM */
		$sql = "select * from prazo_montagem where pm_ativo = 1 order by pm_seq ";
		array_push($cp, array('$Q id_pm:pm_nome:' . $sql, 'pp_montagem', 'Montagem', False, True));

		/* SOBRE O EVENTO */
		//array_push($cp, array('$[0-800]', 'pp_periodo_locacao', 'Período de locação (dias)', False, True));
		array_push($cp, array('$D8', 'pp_dt_ini_evento', 'Dt. de entrega', False, True));
		array_push($cp, array('$D8', 'pp_dt_fim_evento', 'Dt. de devolução', False, True));
		$op = '';
		for ($r=0;$r < 24;$r++)
			{
				for ($y=0;$y < 60;$y=$y+30)
					{
						$op .= '&';
						$op .= strzero($r,2).'h'.strzero($y,2);
						$op .= ':';
						$op .= strzero($r,2).'h'.strzero($y,2);		
					}
			}
		array_push($cp, array('$O '.$op, 'pp_dt_fim_evento_hora', 'Prev. da Hora de devolução', False, True));

		array_push($cp, array('$T80:5', 'pp_obs', 'Observações', False, True));

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
					LEFT JOIN pedido_validade ON id_vd = pp_validade_ppdido AND vd_visivel = 1
					LEFT JOIN pedido_tipo ON id_t = pp_tipo_pedido	
					LEFT JOIN clientes on pp_cliente = id_f				
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
			$cp = $this -> pedidos -> cp_item($id, $id_pp);
			$tela = $form -> editar($cp, 'pedido_itens');

			if ($form -> saved > 0) {
				echo 'SAVED';
				redirect(base_url('index.php/main/pedido_editar/' . $id_pp));
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
			$cp = $this -> pedidos -> cp_item($id, $id_pp);
			$tela = $form -> editar($cp, 'pedido_itens');

			if ($form -> saved > 0) {
				echo 'SAVED';
				redirect(base_url('index.php/main/pedido_editar/' . $id_pp));
			}
			return ($tela);
		}
		return ('');
	}

	function resumo($id, $tipo = '2') {
		$sql = "select count(*) as total from " . $this -> table . " 
					where (pp_situacao > 0) and (pp_situacao < 99) and (pp_cliente = $id)
					AND pp_tipo_pedido = $tipo ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		return ($rlt[0]['total']);
	}

	function botao_novo_pedido($id) {
		$sx = '';
		$sx .= '<div class="row">';

		$sql = "select * from pedido_tipo order by id_t";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx .= '<div class="col-md-12">';
		$sx .= '<ul>';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$sx .= '<li>';
			$sx .= '<a href="' . base_url('index.php/main/pedido_novo_inserir/' . $id . '/' . checkpost_link($id) . '/' . $line['id_t']) . '" class="superbig">';
			$sx .= $line['t_descricao'];
			$sx .= '</a>' . cr();
			$sx .= '</li>';

		}
		$sx .= '</ul>';
		$sx .= '</div>';
		$sx .= '</div>';

		$data = array();
		$data['pedido_tipo'] = $sx;
		$sx = $this -> load -> view('pedido/pedidos_novo_tipo', $data, true);
		return ($sx);
	}

	function updatex() {
		$sql = "update " . $this -> table . " set pp_nr = lpad(id_pp,7,0) where pp_nr = 0 or pp_nr is null";
		$rlt = $this -> db -> query($sql);
		return ('');
	}

	function lista_por_cliente($id, $tipo = '1') {
		$id_us = $_SESSION['id'];

		$sql = "select * from " . $this -> table . " 
					INNER JOIN users on pp_vendor = id_us
					LEFT JOIN pedido_tipo on id_t = pp_tipo_pedido
					LEFT JOIN pedido_situacao ON pp_situacao = id_s
					WHERE (pp_cliente = $id) and (pp_tipo_pedido = $tipo)
					order by pp_situacao, pp_data";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table width="100%" class="table">' . cr();
		$sx .= '<tr class="small">
					<th width="2%">#</th>
					<th width="8%">data</th>
					<th width="10%">nr.</th>
					<th width="25%">descrição</th>
					<th width="35%">vendedor</th>
					<th width="20%">situação</th>
					<th width="20%">vlr.total</th>
				</tr>' . cr();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$data = sonumero($line['pp_data']);
			$desc = $line['t_descricao'];
			$valor = $line['pp_valor'];
			$situacao = $line['s_descricao'];
			$tipo_class = trim($line['s_class']);

			$link = '<a href="' . base_url('index.php/main/pedido/' . $line['id_pp'] . '/' . checkpost_link($line['id_pp'])) . '">';
			$sx .= '<tr class="middle ' . $tipo_class . '">';
			$sx .= '<td align="center">' . ($r + 1) . '</td>';
			$sx .= '<td align="center">' . stodbr($data) . '</td>';
			$sx .= '<td align="center">' . $link . $line['pp_nr'] . '/' . $line['pp_ano'] . '</a>' . '</td>';
			$sx .= '<td align="left">' . $desc . '</td>';
			$sx .= '<td align="left">' . $line['us_nome'] . '</td>';
			$sx .= '<td align="left">' . $situacao . '</td>';
			$sx .= '<td align="right">' . number_format($valor, 2, ',', '.') . '</td>';
			if ($id_us == $line['pp_vendor']) {
				$link = '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
				$link = '<a href="' . base_url('index.php/main/pedido_editar/' . $line['id_pp'] . '/' . checkpost_link($line['id_pp'])) . '">' . $link . '</a>';
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

	function pedido_condicoes($id, $editar) {
		if ($editar == 1) {
			$prop = $this -> le($id);
			$tela = '<div id="condicoes">';
			$tela .= $this -> load -> view('pedido/pedido_condicoes', $prop, true);
			$tela .= $this -> load -> view('pedido/pedido_condicoes_editar', $prop, true);
			$tela .= '</div>';

			$tela .= '<div id="condicoes_editar" style="display: none;">';
			$cp = $this -> cp_condicoes();
			$form = new form;
			$form -> id = $id;
			$tela .= $form -> editar($cp, $this -> table);
			$tela .= '</div>';

			return ($tela);
		} else {
			$prop = $this -> le($id);
			$tela = $this -> load -> view('pedido/pedido_condicoes', $prop, true);
			return ($tela);
		}
	}

	function pedido_novo($id, $tipo) {
		$id_us = $_SESSION['id'];
		$data = date('Y-m-d H:i:s');
		$ano = substr(date("Y"), 2, 2);
		$sql = "insert into " . $this -> table . " 
					(pp_cliente, pp_vendor, pp_situacao, pp_data, pp_ano, pp_tipo_pedido)
					value
					($id, $id_us,'1','$data','$ano',$tipo)";
		$rlt = $this -> db -> query($sql);
		$this -> updatex();

		$sql = "select * from " . $this -> table . " where pp_cliente = $id and pp_data = '$data' ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();

		$id = $rlt[0]['id_pp'];
		return ($id);
	}

	function pedido_items($id, $edit = 0) {
		global $ddi;
		$id_us = $_SESSION['id'];
		$sql = "select * from " . $this -> table_item . " 
					WHERE (pi_nr = $id) and (pi_ativo = 1)
					order by pi_seq";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sxf = '';
		$sx = '<div class="col-md-12">';
		$sx .= '<table width="100%" class="table">' . cr();
		$sx .= '<tr style="font-size: 75%; border-top: 1px solid #000000;" valign="center">
					<th width="2%" style="border-bottom: 1px solid #808080;"><b>#</b></th>
					<th width="60%" style="border-bottom: 1px solid #808080;"><b>produto / serviço</b></th>
					<th width="8%" style="border-bottom: 1px solid #808080;"><b>quant.</b></th>
					<th width="10%" style="border-bottom: 1px solid #808080;" class="locacao"><b>diárias</b></th>
					<th width="10%" style="border-bottom: 1px solid #808080;" align="center"><b>vlr.unit.<br>/ diária</b></th>
					<th width="15%" style="border-bottom: 1px solid #808080;"><b>vlr.total</b></th>					
					<th width="1%" class="nopr">&nbsp;</th>
				</tr>' . cr();
		$tot1 = 0;
		$tot2 = 0;
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
            $comp = '';
            if ($r/2 == round($r/2))
                {
                    $comp = ' style="background-color: #e8e8e8;"';
                }
			$sx .= '<tr class="middle" '.$comp.'>';
			$sx .= '<td align="center"><sup>' . ($r + 1) . '</sup></td>';
			$sx .= '<td align="left" class="big">' . $line['pi_produto'] . '</td>';
			$sx .= '<td align="right"><b>' . number_format($line['pi_quant'], 0, ',', '.') . '</b></td>';
            if ($line['pi_qt_diarias'] > 0)
                {
			         $sx .= '<td align="center">' . number_format($line['pi_qt_diarias'], 0, ',', '.') . '</td>';
			    } else {
			         $sx .= '<td></td>';         
			    }
			$sx .= '<td align="right">' . number_format($line['pi_valor_unit'], 2, ',', '.') . '</td>';
			$vd = $line['pi_qt_diarias'];
			if ($vd == 0) { $vd = 1;
			}
			$sx .= '<td align="right" class="big"><b>' . number_format($vd * $line['pi_quant'] * $line['pi_valor_unit'], 2, ',', '.') . '</b></td>';
			if (($id_us == $line['pi_vendor']) and ($edit == 1)) {
				$link = '<button type="button" class="btn btn-primary" 
							onclick="item_editar(' . $line['id_pi'] . ',' . $id . ');"
							style="mouse: pointer;">';
				$link .= '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
				$link .= '</button>';
				$sx .= '<td align="right" class="nopr">' . $link . '</td>';
			}
			$sx .= '</tr>' . cr();

			$tot1 = $tot1 + $line['pi_quant'];
			$tot2 = $tot2 + ($line['pi_quant'] * $line['pi_valor_unit'] * $vd);

			if (strlen($line['pi_descricao']) > 0) {
				$sx .= '<tr style="font-size: 75%"><td></td><td><i>' . mst($line['pi_descricao']) . '</i></td></tr>';
			}

		}
		if (count($rlt) == 0) {
			$sx .= '<tr><td colspan="10"><font class="red">' . msg('not_register') . '</font></td></tr>' . cr();
		} else {
			$sx .= '<tr><td colspan="3" align="left" style="border-top: 1px solid #808080;"></td>';
			$sx .= '<td align="right" colspan=2 style="border-top: 1px solid #808080;">total</td>';
            $sx .= '<td colspan="2" align="right" style="background-color: #d0d0d0; border-top: 1px solid #808080;"><b>R$ ' . number_format($tot2, 2, ',', '.') . '</b></td>';
            $sx .= '</tr>' . cr();
		}
		$sx .= '</table>' . cr();
        if ($edit==1)
        {
    		$sx .= '<script> function item_editar($it,$id)
    			{
    				newwin("' . base_url('index.php/main/pedido_item_editar') . '" + "/" + $it + "/" + $id + "/' . checkpost_link($id) . '");
    			} </script>' . cr();
		}
		$sx .= $sxf;
		$sx .= '</div>';
		return ($sx);
	}

	function mostra_lista_detalhes($id_us, $pp_tipo_pedido, $pp_situacao) {
		$wh = '';
		if ($id_us > 0) {
			$wh = " WHERE pp_vendor = " . round($id_us);
		}
		if (strlen($pp_situacao) > 0) {
			if (strlen($wh) == 0)
				{
					$wh .= ' WHERE ';
				} else {
					$wh .= ' AND ';
				}
			$wh .= "  (pp_situacao = $pp_situacao) ";
		}
        $wh .= " and  (pp_situacao <> 9) ";
		if ($pp_tipo_pedido > 0)
			{
				$wh .= " AND pp_tipo_pedido = $pp_tipo_pedido ";
			}
		$sql = "select * from " . $this -> table . " 
					LEFT JOIN users on pp_vendor = id_us
					LEFT JOIN clientes on pp_cliente = id_f
					LEFT JOIN pedido_situacao ON pp_situacao = id_s
					LEFT JOIN pedido_tipo on id_t = pp_tipo_pedido
					$wh 
					ORDER BY id_pp desc, pp_situacao ";
		
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();

		$sx = '<table width="100%" class="table">' . cr();
		$sx .= '<tr class="small">
					<th width="2%">#</th>
					<th width="8%">data</th>
					<th width="10%">nr.</th>
					<th width="25%">descrição</th>
					<th width="35%">cliente</th>
					<th width="20%">situação</th>
					<th width="20%">vlr.total</th>
					<th>&nbsp;</th>
				</tr>' . cr();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$data = sonumero($line['pp_data']);
			$desc = $line['t_descricao'];
			$valor = $line['pp_valor'];
			$situacao = $line['s_descricao'];
			$tipo_class = trim($line['s_class']);

			$link = '<a href="' . base_url('index.php/main/pedido/' . $line['id_pp'] . '/' . checkpost_link($line['id_pp'])) . '">';
			$sx .= '<tr class="middle ' . $tipo_class . '">';
			$sx .= '<td align="center">' . ($r + 1) . '</td>';
			$sx .= '<td align="center">' . stodbr($data) . '</td>';
			$sx .= '<td align="center">' . $link . $line['pp_nr'] . '/' . $line['pp_ano'] . '</a>' . '</td>';
			$sx .= '<td align="left">' . $desc . '</td>';
			$sx .= '<td align="left">' . $line['f_nome_fantasia'] . '</td>';
			$sx .= '<td align="left">' . $situacao . '</td>';
			$sx .= '<td align="right">' . number_format($valor, 2, ',', '.') . '</td>';
			if ($id_us == $line['pp_vendor']) {
				$link = '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
				$link = '<a href="' . base_url('index.php/main/pedido_editar/' . $line['id_pp'] . '/' . checkpost_link($line['id_pp'])) . '">' . $link . '</a>';
				$sx .= '<td align="center">' . $link . '</td>';
			}
			$sx .= '</tr>' . cr();
		}
		if (count($rlt) == 0) {
			$sx .= '<tr><td colspan="10"><font class="red">' . msg('not_register') . '</font></td></tr>' . cr();
		}
		$sx .= '</table>' . cr();
		//$sx .= '</div>';
		return ($sx);
	}

	function pedidos_abertas_resumo($id_us, $pp_tipo_pedido = '2') {
		$wh = ' WHERE pp_tipo_pedido = ' . $pp_tipo_pedido;
		if ($id_us > 0) {
			$wh = " WHERE pp_vendor = " . round($id_us);
		}
		if ($pp_tipo_pedido > 0)
			{
				$wh .= " AND pp_tipo_pedido = $pp_tipo_pedido ";
			}		
		$sql = "select count(*) as total, s_class, pp_tipo_pedido, s_descricao, pp_situacao from " . $this -> table . " 
					INNER JOIN users on pp_vendor = id_us
					INNER JOIN clientes on pp_cliente = id_f
					INNER JOIN pedido_situacao ON pp_situacao = id_s
					$wh 
					GROUP BY s_class, pp_tipo_pedido, s_descricao, pp_situacao
					ORDER BY pp_situacao ";

		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();

		$sx = '';
		$mtz = array();

		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$sit = $line['pp_situacao'];
			$tipo_class = trim($line['s_class']);
			$link = '<a href="' . base_url('index.php/main/menu_pedidos/' . $pp_tipo_pedido . '/' . $sit) . '">';
			$sx .= $link . '<div class="col-sm-2 text-center ' . $tipo_class . ' pad5" style="margin-right: 5px; border-radius: 10px; border: 1px solid;">' . $line['s_descricao'] . '<br><span class="xxxbig">' . $line['total'] . '</span>' . '</div>' . '</a>' . cr();

		}

		if (count($rlt) == 0) {
			$sx .= '
				<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				  <span class="sr-only">Error:</span>
				 Não foi localizado nenhum item
				</div>' . cr();
		}
		//$sx .= '</div>';
		return ($sx);
	}

	function pedido_finalizar($id) {
		$sql = "update " . $this -> table . " set pp_situacao = 2 where id_pp = " . $id;
		$this -> db -> query($sql);
		return ('');
	}
    
    function pedido_cancelar($id) {
        $sql = "update " . $this -> table . " set pp_situacao = 9 where id_pp = " . $id;
        $this -> db -> query($sql);
        return ('');
    }    

	function pedido_acoes($data) {
		$sit = $data['pp_situacao'];
		$id = $data['id_pp'];
		$ac = array();
		$sx = '';
		switch ($sit) {
			case '0' :
				$sx .= '<div class="col-md-12">
									<span class="btn btn-primary nopr" onclick="confirmar_finalizar();">Fechar pedido</span>																
									&nbsp;
									<span class="btn btn-default nopr" onclick="confirmar_cancelar();">Cancelar pedido/orçamento</span>
									
							</div>
							<script>
							function confirmar_cancelar()
								{
								if (confirmar() > 0)
									{
										window.location= "' . base_url('index.php/main/pedido_cancelar/' . $id . '/' . checkpost_link($id)) . '";
									}
								}
							function confirmar_finalizar()
								{
								if (confirmar("Finalizar Pedido?") > 0)
									{
										window.location= "' . base_url('index.php/main/confirmar_finalizar/' . $id . '/' . checkpost_link($id)) . '";
									}
								}								
							</script>
							
							';
				break;
			case '1' :
				$sx .= '<div class="col-md-12">																
									<a href="' . base_url('index.php/main/pedido_editar/' . $id . '/' . checkpost_link($id)) . '" class="btn btn-primary nopr">Enviar para edição </a>
							</div>';
				break;
			case '2':
				$sx .= '<div class="col-md-2">																
									<a href="' . base_url('index.php/main/pedido_editar/' . $id . '/' . checkpost_link($id)) . '" class="btn btn-primary nopr">Enviar para edição </a>
							</div>';
				$sx .= '<div class="col-md-2">	
									<span class="btn btn-default nopr" onclick="confirmar_email();">Enviar email para cliente</span>															
							</div>'.cr();
				$sx .= '<div class="col-md-2">	
									<span class="btn btn-default nopr" onclick="imprimir();">Imprimir</span>															
							</div>'.cr();							
				$sx .= '<script>
							function imprimir()
								{
									window.print();
								}
							function confirmar_email()
								{
								if (confirmar() > 0)
									{
										window.location= "' . base_url('index.php/main/pedido_enviar_email/' . $id . '/' . checkpost_link($id)) . '";
									}
								}								
							</script>';
				break;
			default :
				$sx .= 'Ação: '.$sit;
				break;
		}
		return ($sx);
	}

	function contatos_do_pedido($ped, $clie, $editar = 0) {

 
	    
		$sx = '';
		$ped = round($ped);
		$sql = "select * from clientes_contatos 
						LEFT JOIN pedido_contato ON id_cc = pct_id_contato AND pct_id_pp = $ped
						LEFT JOIN contato_funcao ON cc_funcao = id_ct
						where cc_cliente_id = $clie 
						order by cc_nome ";

		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '';
		/************************ script ******************/
		$sx .= '
			<script>
			function markit($id,$this)
				{
				var $vlr = $this.checked;
				$.ajax({
				  url: "' . base_url('index.php/main/pedido_set_contato/' . $ped . '/') . '",
				  data: { pedido: "' . $ped . '", contato: $id, value: $vlr },
				  context: document.body
				}).done(function($rst) {
				  
				});
				}
			</script>
			';

		/************************ table ******************/
		$sx .= '<table class="table">';
		$sx .= '<tr>
						<th class="nopr">#</th>
						<th>Nome</th>
						<th>Função</th>
						<th>Telefone</th>
						<th>e-mail</th>
					</tr>
					';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$check = '';
			$class = 'nopr';
			if ($line['pct_ativo'] == '1') {
				$check = 'checked';
				$class = '';
			}
			$sx .= '<tr class="'.$class.'">';
			$sx .= '<td class="nopr"><input type="checkbox" onclick="markit(' . $line['id_cc'] . ',this);" ' . $check . '></td>';
			$sx .= '<td>' . $line['cc_nome'] . '</td>';
			$sx .= '<td>' . $line['ct_nome'] . '</td>';
			$sx .= '<td>' . mask_fone($line['cc_telefone']) . '</td>';
			$sx .= '<td>' . $line['cc_email'] . '</td>';
		}
		$sx .= '</table>';

		return ($sx);
	}
    function pedido_pdf($id)
        {   
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Giga Informática');
        $pdf->SetTitle('Orçamento');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        // set default header data
        $logo_img = '../../../img/logo/logo_jpg.jpg';
        $PDF_HEADER_LOGO_WIDTH = 15;
        $PDF_HEADER_TITLE = 'Giga Informática';
        $PDF_HEADER_STRING = 'Filial - Curitiba';
        $pdf->SetHeaderData($logo_img, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
        
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $PDF_MARGIN_LEFT = PDF_MARGIN_LEFT;
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER+10);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // ---------------------------------------------------------
        
        // set font
        $pdf->SetFont('Courier', '', 10);
        
        // add a page
        $pdf->AddPage(); 
        
        $pdf->writeHTML($this->mostra_pedido_html($id), true, false, true, false, '');
        
        //Close and output PDF document
        $pdf->Output('giga_'.strzero($id,7).'.pdf', 'I');           
        }
    function mostra_pedido_html($id)
    {
        $editar = 0;
        $data = $this -> pedidos -> le($id);
        $id_cliente = $data['pp_cliente'];
        $id_cliente_f = $data['pp_cliente_faturamento'];
        $data['dados_cliente'] = $this -> clientes -> le($id_cliente);


        /***************************************************************************************************************************/
        //$this -> cab();

        if ($data['pp_cliente_faturamento'] > 0) {
            $data['dados_faturamento'] = $this -> clientes -> le($id_cliente_f);
        } else {
            $data['dados_faturamento'] = 'Mesmo do cliente';
        }

        $data['id_pp'] = $id;
        $data['dados_item_form'] = $this -> pedidos -> form_item_novo(0, $id);
        $data['dados_item'] = $this -> pedidos -> pedido_items($id, $editar);                
        //$data['dados_item'] .= $this -> load -> view('pedido/pedido_item', $data, true);
        
        $data['dados_proposta'] = $this -> load -> view('pedido/pedido_header', $data, true);
        $data['dados_condicoes'] = $this -> pedidos -> pedido_condicoes($id, $editar);

        /* contatos do pedido */
        $data['contatos'] = $this -> pedidos -> contatos_do_pedido($id, $id_cliente, $editar);
        
        /* habilita cancelamento */
        $data['pp_situacao'] = 0;
        $data['dados_acoes'] = $this -> pedidos -> pedido_acoes($data);
        

        $sx = $this -> load -> view('pedido/pedido_pdf', $data, true);
        return($sx);
    }

}
?>
