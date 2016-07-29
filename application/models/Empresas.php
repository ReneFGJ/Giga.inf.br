<?php
class empresas extends CI_model {
	var $table = '_filiais';

	function cp($id) {
		$cp = array();
		array_push($cp, array('$H8', 'id_fi', '', False, True));
		array_push($cp, array('$S80', 'fi_razao_social', 'Razão Social', True, True));
		array_push($cp, array('$S80', 'fi_nome_fantasia', 'Nome Fantasia', True, True));
		array_push($cp, array('$S20', 'fi_cnpj', 'CNPJ', True, True));
		array_push($cp, array('$S20', 'fi_ie', 'Inscrição Estadual', False, True));
		array_push($cp, array('$S20', 'fi_im', 'Inscrição Municipal', False, True));
		array_push($cp, array('$S80', 'fi_logradouro', 'Endereço', False, True));
		array_push($cp, array('$S8', 'fi_numero', 'Número', False, True));
		array_push($cp, array('$S15', 'fi_complemento', 'Complemento', False, True));
		
		array_push($cp, array('$S25', 'fi_bairro', 'Bairro', False, True));
		array_push($cp, array('$S25', 'fi_cidade', 'Cidade', False, True));
		array_push($cp, array('$UF', 'fi_estado', 'Estado', False, True));
		
		array_push($cp, array('$S8', 'fi_cep', 'CEP', False, True));
		
		array_push($cp, array('$S15', 'fi_fone_1', 'Telefone:', False, True));
		array_push($cp, array('$S15', 'fi_fone_2', 'Telefone:', False, True));
		array_push($cp, array('$S80', 'fi_email', 'e-mail:', False, True));
		//array_push($cp, array('$S8', 'fi_email', 'e-mail financeiro:', False, True));
		
		array_push($cp, array('$O 1:SIM&0:NÃO', 'fi_ativo', 'Ativo', True, True));
		return ($cp);
	}

	function row($id='') {
		$form = new form;

		$form -> fd = array('id_fi', 'fi_nome_fantasia', 'fi_razao_social');
		$form -> lb = array('id', msg('fi_nome_fantasia'), msg('fi_razao_social'));
		$form -> mk = array('', 'L', 'L', 'L');		
		
		$form -> tabela = $this -> table;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = true;

		$form -> row_edit = base_url('index.php/admin/filiais_edit');
		$form -> row_view = base_url('index.php/admin/filial');
		$form -> row = base_url('index.php/admin/filiais');

		return (row($form, $id));
	}

	function editar($id,$chk)
		{
			$form = new form;
			$form->id = $id;
			$cp = $this->cp($id);
			$data['title'] = '';
			$data['content'] = $form->editar($cp,$this->table);
			$this->load->view('content',$data);
			return($form->saved);			
		}	

	function updatex()
		{
			return('');
		}

	function le($id, $fld = 'id') {
		$sql = "select * from " . $this -> table;
		switch($fld) {
			default :
				$sql .= ' where id_fi = ' . round($id);
				break;
		}
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) == 0) {
			return ( array());
		} else {
			return ($rlt[0]);
		}

	}
}
?>
