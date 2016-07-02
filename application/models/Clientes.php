<?php
class clientes extends CI_Model {
	var $table = 'clientes';
	
	function le($id)
		{
			$sql = "select * from ".$this->table." where id_f = ".round($id);
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			if (count($rlt) > 0)
				{
					return($rlt[0]);
				} else {
					return(array());
				}
		}

	function cp() {
		$cp = array();
		array_push($cp, array('$H8', 'id_f', '', False, True));
		array_push($cp, array('$O 1:Pessoa Juridica&2:Pessoa Física', 'f_tipo', 'Tipo', True, True));
		array_push($cp, array('$S12', 'f_cnpj', 'CNPJ/CPF', False, True));
		array_push($cp, array('$S80', 'f_nome_fantasia', 'Nome Fantasia', True, True));
		array_push($cp, array('$S80', 'f_razao_social', 'Razão Social / Nome completo', True, True));		
		array_push($cp, array('$S15', 'f_ie', 'Inscrição Estadual', False, True));
		array_push($cp, array('$S15', 'f_im', 'Inscrição Municipal', False, True));
		array_push($cp, array('$O 1:SIM&0:NÃO', 'f_ativo', 'Ativo', True, True));

		array_push($cp, array('$S15', 'f_cep', 'CEP', False, True));
		array_push($cp, array('$S80', 'f_logradouro', 'Logradouro', False, True));
		array_push($cp, array('$S15', 'f_numero', 'Número', False, True));
		array_push($cp, array('$S15', 'f_complemento', 'Complemento', False, True));
		
		array_push($cp, array('$S25', 'f_bairro', 'Bairro', False, True));
		array_push($cp, array('$S25', 'f_cidade', 'Cidade', False, True));
		array_push($cp, array('$UF', 'f_estado', 'Estado', False, True));
		
		array_push($cp, array('$S15', 'f_fone_1', 'Telefone:', False, True));
		array_push($cp, array('$S15', 'f_fone_2', 'Telefone:', False, True));
		array_push($cp, array('$S80', 'f_email', 'e-mail:', False, True));		

		array_push($cp, array('$T80:5', 'f_obs', 'Observações', False, True));
		return ($cp);
	}

	function row($id='') {
		$form = new form;

		$form -> fd = array('id_f', 'f_nome_fantasia', 'f_razao_social', 'f_estado');
		$form -> lb = array('id', msg('f_nome_fantasia'), msg('f_razao_social'), msg('f_estado'));
		$form -> mk = array('', 'L', 'L', 'L');		
		
		$form -> tabela = $this -> table;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = true;

		$form -> row_edit = base_url('index.php/main/clientes_edit');
		$form -> row_view = base_url('index.php/main/cliente');
		$form -> row = base_url('index.php/main/clientes');

		return (row($form, $id));
	}

	function editar($id,$chk)
		{
			$form = new form;
			$form->id = $id;
			$cp = $this->cp();
			$data['title'] = '';
			$data['content'] = $form->editar($cp,$this->table);
			$this->load->view('content',$data);
			return($form->saved);			
		}

}
