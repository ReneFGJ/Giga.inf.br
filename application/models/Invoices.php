<?php
class invoices extends CI_model {
	var $table = 'invoice';
	var $table_item = 'invoice_item';
	var $table_nr = 'invoice_nrs';

	function le($id) {
		$sql = "select * 
						FROM " . $this -> table . "
						LEFT JOIN _filiais on id_fi = iv_filial
						LEFT JOIN clientes on id_f = iv_cliente
						LEFT JOIN " . $this -> table_nr . " on nrs_id = id_iv
						WHERE id_iv = " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
		} else {
			$line = array();
		}
		return ($line);
	}

	function cp($id) {
		$cp = array();
		array_push($cp, array('$H8', 'id_ii', '', false, true));
		array_push($cp, array('$S80', 'ii_periodo', 'Período', true, true));
		array_push($cp, array('$HV', 'ii_invoice', $id, true, true));
		array_push($cp, array('$S80', 'ii_nome', 'Nome do item', true, true));
		array_push($cp, array('$T80:5', 'ii_descricao', 'Descrição', false, true));
		array_push($cp, array('$N8', 'ii_valor', 'Valor', true, true));
		return ($cp);
	}

	function row($id = '') {
		$form = new form;
		$this -> updatex();

		$form -> fd = array('id_iv', 'iv_data', 'iv_numero', 'nrs_nr','f_razao_social', 'iis_descricao', 'iv_cod_op_fiscal');
		$form -> lb = array('id', msg('data'), msg('numero'), msg('recibo'), msg('cliente'), msg('ativo'), msg('op_fiscal'));
		$form -> mk = array('', 'D', 'D', 'D', 'D', 'S');

		$table = '(select * from ' . $this -> table . " 
						LEFT JOIN clientes on iv_cliente = id_f
						LEFT JOIN invoice_situacao on id_iis = iv_situacao
						LEFT JOIN invoice_nrs on nrs_id = id_iv
				  ) as tabela ";

		$form -> tabela = $table;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = false;
		$form -> order = 'id_iv desc';

		$form -> row_edit = base_url('index.php/financeiro/fiscal_new');
		$form -> row_view = base_url('index.php/financeiro/fiscal_ver');
		$form -> row = base_url('index.php/financeiro/fiscal');

		return (row($form, $id));
	}

	function abrir_recibo($cliente, $filial = 1) {
		$sql = "select * from _filiais where id_fi = ".$filial;
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		$line = $rlt[0];
		$aliq = $line['fi_aliquota'];
		
		$sql = "select * from " . $this -> table . " where iv_cliente = $cliente and iv_situacao = 1 ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();

		if (count($rlt) == 0) {
			$data = date("Y-m-d");
			$hora = date("H:i:s");
			$sql = "insert into " . $this -> table . " 
					(
						iv_data, iv_hora, iv_cliente, iv_numero,
						iv_filial, iv_situacao, iv_emissor,
						iv_cod_op_fiscal, iv_iss, iv_icms,
						iv_ipi, iv_aliquota
					)
					values
					(
						'$data','$hora','$cliente','',
						'$filial','1','$filial',
						'LOCACAO',0,0,
						0,$aliq					
					)";
			$rlt = $this -> db -> query($sql);
			$rs = array(1, 'ok');
		} else {
			$line = $rlt[0];
			$editar = '<a href="' . base_url('index.php/financeiro/fiscal_ver/' . $line['id_iv']) . '">aqui</a>';
			$rs = array(0, 'cliente já tem nota em edição - clique ' . $editar . ' para editar');
		}
		return ($rs);
	}

	function ver_itens($data, $ed = true) {
		$id = $data['id_iv'];
		$sit = $data['iv_situacao'];
		$aliquota = $data['iv_aliquota'];
		$sql = "select * from invoice_item where ii_invoice = $id ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$it = 0;
		$vl = 0;
		$sx = '<p class="small">DEVE(M) A ' . UpperCase($data['fi_razao_social']) . ', A IMPORTÂNCIA CITADA CONFORME LOCAÇÃO DO(S) EQUIPAMENTO(S) ABAIXO:</p>';

		$sx .= '<table class="big" width="100%">';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$line['editar'] = $ed;
			$sx .= $this -> load -> view('fiscal/itens', $line, true);
			$it++;
			$vl = $vl + $line['ii_valor'];
		}
		if (count($rlt) == 0) {
			$sx .= '<tr><td><font color="red">Nenhum item informado</font></td></tr>';
		} else {
			$sx .= '<tr><td align="right" colspan="3"><b>Total de ' . $it . ' item(ns) R$ ' . number_format($vl, 2, ',', '.') . '</b></td></tr>';
			$sx .= '<tr><td align="right" colspan="3">Valor aproximado do imposto <b>R$ ' . number_format($vl * ($aliquota / 100), 2, ',', '.') . '</b> Aliquota <b>' . number_format($aliquota, 2, ',', '.') . '%</b></td></tr>';
		}
		$sx .= '</table>';

		if (($sit == 1) and ($ed == true)) {
			$link = base_url('index.php/financeiro/fiscal_edit/0/0/' . $id);
			$link = ' onclick="newxy(\'' . $link . '\',800,500); ';
			$sx .= '<button class="btn btn-primary" ' . $link . '">Inserir novo item</button>';
		}
		return ($sx);

	}

	function updatex() {
		$sql = "update " . $this -> table . " set iv_numero = lpad(id_iv,5,0) where iv_numero = '' or iv_numero is null";
		$this -> db -> query($sql);
		$sql = "update " . $this -> table_nr . " set nrs_nr = lpad(	id_nrs,6,0) where nrs_nr = '' or nrs_nr is null";
		$this -> db -> query($sql);
	}

	function le_last_cliente($id) {
		$sql = "select * from " . $this -> table_nr . " where nrs_cliente = " . $id . " order by id_nrs desc";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$line = $rlt[0];
		return ($line);
	}

	function total_itens($id) {
		$sql = "select count(*) as total from " . $this -> table_item . " where ii_invoice = $id ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) > 0) {
			$total = $rlt[0]['total'];
		} else {
			$total = 0;
		}
		return ($total);
	}

	function cancelar_edicao($id) {
			$sql = "update " . $this -> table . " set iv_situacao = 9 where id_iv = " . $id;
			$rlt = $this -> db -> query($sql);
			return(0);
	}
	
	function ativar_edicao($id) {
			$sql = "update " . $this -> table . " set iv_situacao = 1 where id_iv = " . $id;
			$rlt = $this -> db -> query($sql);
			return(0);
	}	

	function fechar_edicao($id, $cliente) {
		$this -> updatex();

		$sql = "select * from " . $this -> table_nr . " where nrs_id = " . $id;
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) == 0) {
			$sql = "insert into " . $this -> table_nr . " 
				(
					nrs_id, nrs_cliente
				) values (
					$id,$cliente
				)";
			$rlt = $this -> db -> query($sql);

			$this -> updatex();

			$sql = "select * from " . $this -> table_nr . " where nrs_id = " . $id;
			$rlt = $this -> db -> query($sql);
			$rlt = $rlt -> result_array();
		}
		$line = $rlt[0];

		$sql = "update " . $this -> table . " set iv_situacao = 2 where id_iv = " . $id;
		$rlt = $this -> db -> query($sql);

		return ($line['nrs_nr']);
	}

}
