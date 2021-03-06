<?php
class clientes extends CI_Model {
	var $table = 'clientes';
	var $table_contatos = 'clientes_contatos';
	var $table_contatos_tipo = 'contato_funcao';

	function le($id) {
		$sql = "select * from " . $this -> table . "					 
						WHERE id_f = " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			/* contato */
			$sql = "select * from clientes_contatos 
						INNER JOIN contato_funcao ON cc_funcao = id_ct
						WHERE cc_cliente_id = " . $id;
			$rlc = $this -> db -> query($sql);
			$rlc = $rlc -> result_array();
			$line['contacts'] = $rlc;
			return ($line);
		} else {
			return ( array());
		}
	}
	
	function export()
		{
			/*
				header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
				header("Content-type:   application/x-msexcel; charset=utf-8");
				header("Content-Disposition: attachment; filename=clientes_giga.xls"); 
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);			 
			 */	
							
			$sql = "select * from clientes order by f_razao_social";
			$sql = "select * from clientes_contatos order by cc_cliente_id";
			$sql = "select * from users";
			$sql = "select * from user_drh";
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			$sx = '<table>';
			$sx .= '<tr>';
			foreach ($rlt[0] as $key => $value) {
				$sx .= '<th>'.$key.'</th>';				
			}
			$sx .= '</tr>';
			for ($r=0;$r < count($rlt);$r++)
				{
					$line = $rlt[$r];
					$sx .= '<tr>';
					foreach ($rlt[0] as $key => $value) {
						$sx .= '<td>'.$line[$key].'</td>';
					}
					$sx .= '</tr>';
				}
			$sx .= '</table>';
			echo $sx;
			return($sx);
		}

	function le_contatos($id) {
		$sql = "select * from " . $this -> table_contatos . " 
					left join contato_funcao ON id_ct = cc_funcao
					where cc_ativo = 1 and cc_cliente_id	= " . round($id);

		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		return ($rlt);
	}

	function cp() {
		$cp = array();
		array_push($cp, array('$H8', 'id_f', '', False, True));
		array_push($cp, array('$A', '', 'Dados do cliente/fornecedor', False, True));
		array_push($cp, array('$O 1:Pessoa Juridica&2:Pessoa Física', 'f_tipo', 'Tipo', True, True));
		array_push($cp, array('$S12', 'f_cnpj', 'CNPJ/CPF', False, True));
		array_push($cp, array('$S80', 'f_nome_fantasia', 'Nome Fantasia', True, True));
		array_push($cp, array('$S80', 'f_razao_social', 'Razão Social / Nome completo', True, True));
		array_push($cp, array('$S15', 'f_ie', 'Inscrição Estadual', False, True));
		array_push($cp, array('$S15', 'f_im', 'Inscrição Municipal', False, True));
		array_push($cp, array('$O 1:SIM&0:NÃO', 'f_ativo', 'Ativo', True, True));

		array_push($cp, array('$A', '', 'Endereço', False, True));
		array_push($cp, array('$S15', 'f_cep', 'CEP', False, True));
		array_push($cp, array('$S80', 'f_logradouro', 'Logradouro', False, True));
		array_push($cp, array('$S15', 'f_numero', 'Número', False, True));
		array_push($cp, array('$S15', 'f_complemento', 'Complemento', False, True));

		array_push($cp, array('$S25', 'f_bairro', 'Bairro', False, True));
		array_push($cp, array('$S25', 'f_cidade', 'Cidade', False, True));
		array_push($cp, array('$UF', 'f_estado', 'Estado', False, True));

		//array_push($cp, array('$S15', 'f_fone_1', 'Telefone:', False, True));
		//array_push($cp, array('$S15', 'f_fone_2', 'Telefone:', False, True));
		//array_push($cp, array('$S80', 'f_email', 'e-mail:', False, True));

		array_push($cp, array('$T80:5', 'f_obs', 'Observações', False, True));

		array_push($cp, array('$A', '', 'Fornecedor', False, True));
		array_push($cp, array('$O 1:SIM&0:NÃO', 'f_fornecedor', 'Fornecedor', True, True));

		array_push($cp, array('$B', '', 'Gravar', False, True));

		return ($cp);
	}

	function cp_contatos($id, $idc) {
		$cp = array();
		array_push($cp, array('$H8', 'id_cc', '', False, True));
		array_push($cp, array('$S80', 'cc_nome', 'Nome do contato', True, True));
		array_push($cp, array('$Q id_ct:ct_nome:select * from contato_funcao where ct_ativo = 1', 'cc_funcao', 'Função', False, True));
		array_push($cp, array('$S80', 'cc_telefone', 'Telefone', False, True));
		array_push($cp, array('$S80', 'cc_email', 'e-mail', False, True));

		if ($id == 0) {
			array_push($cp, array('$HV', 'cc_cliente_id', $idc, True, True));
			array_push($cp, array('$HV', 'cc_ativo', 1, True, True));
		} else {
			array_push($cp, array('$O 1:Ativo&0:Inativo', 'cc_ativo', 'Ativo', True, True));
		}
		array_push($cp, array('$M', '', 'Para mais de um e-mail, utilize ";"', False, True));
		array_push($cp, array('$B', '', 'Gravar', False, True));
		return ($cp);
	}

	function cp_contatos_tipo($id = 0, $idc = '') {
		$cp = array();
		array_push($cp, array('$H8', 'id_ct', '', False, True));
		array_push($cp, array('$S80', 'ct_nome', 'Função', True, True));

		if ($id == 0) {
			array_push($cp, array('$HV', 'ct_ativo', 1, True, True));
		} else {
			array_push($cp, array('$O 1:Ativo&0:Inativo', 'ct_ativo', 'Ativo', True, True));
		}
		array_push($cp, array('$B', '', 'Gravar', False, True));
		return ($cp);
	}

	function row($id = '', $param = array()) {
		$form = new form;

		$form -> fd = array('id_f','id_f', 'f_nome_fantasia', 'f_razao_social', 'f_estado');
		$form -> lb = array('id','Cod', msg('f_nome_fantasia'), msg('f_razao_social'), msg('f_estado'));
		$form -> mk = array('', 'L', 'L', 'L');
		$form -> pre_where = ' f_ativo = 1 ';

		$form -> tabela = $this -> table;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = true;
		$form -> pre_where = 'f_ativo = 1';

		$form -> row_edit = base_url('index.php/main/clientes_edit');
		$form -> row_view = base_url('index.php/main/cliente');
		$form -> row = base_url('index.php/main/clientes');

		return (row($form, $id));
	}

	function row_contatos_tipo($id = 0, $param = array()) {
		$form = new form;

		$form -> fd = array('id_ct', 'ct_nome', 'ct_ativo');
		$form -> lb = array('id', msg('ct_nome'), msg('ct_ativo'));
		$form -> mk = array('', 'L', 'A');
		$form -> pre_where = ' ct_ativo = 1 ';

		$form -> tabela = $this -> table_contatos_tipo;
		$form -> see = false;
		$form -> novo = true;
		$form -> edit = true;

		$form -> row_edit = base_url('index.php/admin/contato_tipo_edit');
		$form -> row = base_url('index.php/main/clientes');

		return (row($form, $id));
	}

	function editar($id, $chk) {
		$form = new form;
		$form -> id = $id;
		$cp = $this -> cp();
		$data['title'] = 'Dados dos Clientes';
		$data['content'] = $form -> editar($cp, $this -> table);
		$this -> load -> view('content', $data);
		return ($form -> saved);
	}

	function contatos($id, $edit = 1) {
		$sql = "select * from " . $this -> table_contatos . " 
					left join contato_funcao ON id_ct = cc_funcao
					where cc_ativo = 1 and cc_cliente_id	= " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table class="table middle" width="100%">';
        $sx .= '<tr><th colspan=5">Contatos</th></tr>';		
        $sx .= '<tr class="small">
						<th>nome</th>
						<th>tipo</th>
						<th>telefone</th>
						<th>e-mail</th>';
						if ($edit==1) { $sx .= '<th>editar</th>'; }
		$sx .= '</tr>';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$bx = '<button type="button" class="btn btn-primary" aria-label="Left Align" onclick="newwin(\'' . base_url('index.php/main/cliente_contato_edit/' . $line['id_cc'] . '/' . $id) . '\');">';
			$bx .= '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
			$bx .= '</button>';

			$sx .= '<tr>';
			$sx .= '<td>' . $line['cc_nome'] . '</td>';
			$sx .= '<td>' . $line['ct_nome'] . '</td>';
			$sx .= '<td>' . mask_fone($line['cc_telefone']) . '</td>';
			$sx .= '<td>' . $line['cc_email'] . '</td>';
			if ($edit == 1) {
				$sx .= '<td>' . $bx . '</td>';
			}
		}
		if (count($rlt) == 0)
			{
				$sx .= '<tr><td colspan=5><font color="red">Sem contatos registrados</td></tr>';
			}	
		$sx .= '</table>';
		return ($sx);
	}

	function contatos_total($id) {
		$sql = "select count(*) as total from " . $this -> table_contatos . " 
					where cc_ativo = 1 and cc_cliente_id	= " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) > 0) {
			return ($rlt[0]['total']);
		} else {
			return (0);
		}
		return ($sx);
	}

	function novo_contato($id) {
		$sx = '<button type="button" class="btn btn-primary" aria-label="Left Align" onclick="newwin(\'' . base_url('index.php/main/cliente_contato_edit/0/' . $id) . '\');">';
		$sx .= 'novo contato';
		$sx .= '</button>';
		return ($sx);
	}

	function enviaremail_cliente($cliente = 0, $assunto = '', $texto = '', $de = 1, $anexos = array()) {
		$id_us = round($_SESSION['id']);
		$us = $this -> users -> le($id_us);
		$email = trim($us['us_email']);
		$para = array();
		if (strlen($email) > 5) {
			array_push($para, $email);
		}

		$sql = "select * from clientes_contatos 
						WHERE cc_cliente_id = $cliente
							AND cc_ativo = 1 ";

		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();

		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$email = trim($rlt[$r]['cc_email']);
			if (strlen($email) > 5) {
				array_push($para, $email);
			}
		}
		enviaremail($para, $assunto, $texto, $de);
	}

}
