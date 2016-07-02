<?php
class produtos extends CI_model {
	var $table = 'produtos';
	var $table_categoria = 'produtos_categoria';
	var $table_marca = 'produtos_marca';
	var $table_produto = '(select * from produtos INNER JOIN produtos_marca ON id_ma = pr_marca) as produtos ';
	
	/************************************************************************** PRODUTOS *****************************/	
	function cp()
		{
		$cp = array();
		array_push($cp, array('$H8', 'id_pr', '', False, True));
		array_push($cp, array('$S80', 'pr_nome', 'Nome do produto', True, True));
		$sql = "select * from produtos_marca where ma_ativo = 1 order by ma_nome";
		array_push($cp, array('$Q id_ma:ma_nome:'.$sql, 'pr_marca', 'Marca', True, True));
		$sql = "select * from produtos_categoria where pc_ativo = 1 order by pc_nome";
		array_push($cp, array('$Q id_pc:pc_nome:'.$sql, 'pr_categoria', 'Categoria', True, True));
		array_push($cp, array('$T80:5', 'pr_descricao', 'Dados técnicos / Descrição', True, True));		
		array_push($cp, array('$O 1:SIM&0:NÃO', 'pr_ativo', 'Ativo', True, True));
		
			

		return ($cp);
		}
	function row($id = '') {
		$form = new form;

		$form -> fd = array('id_pr', 'pr_nome', 'ma_nome', 'pr_ativo');
		$form -> lb = array('id', msg('pr_descricao'), msg('pr_codigo'), msg('pr_ativo'));
		$form -> mk = array('', 'L', 'L', 'L');

		$form -> tabela = $this -> table_produto;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = true;

		$form -> row_edit = base_url('index.php/main/produtos_edit');
		$form -> row_view = base_url('index.php/main/produtos_view');
		$form -> row = base_url('index.php/main/produtos');

		return (row($form, $id));
	}	
	function editar($id, $chk) {
		$form = new form;
		$form -> id = $id;
		$cp = $this -> cp();
		$data['title'] = '';
		$data['content'] = $form -> editar($cp, $this -> table_categoria);
		$this -> load -> view('content', $data);
		return ($form -> saved);
	}	

	/************************************************************************** PRODUTOS CATEGORIA ****************************/
	function le_categoria($id)
		{
			$sql = "select * from ".$this->table_categoria." where id_pc = ".round($id);
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			$line = $rlt[0];
			return($line);
		}
			
	function cp_categoria()
		{
		$cp = array();
		array_push($cp, array('$H8', 'id_pc', '', False, True));
		array_push($cp, array('$S80', 'pc_nome', 'Nome da categoria', True, True));
		array_push($cp, array('$S80', 'pc_codigo', 'Código', True, True));		
		array_push($cp, array('$O 1:SIM&0:NÃO', 'pc_ativo', 'Ativo', True, True));

		return ($cp);
		}

	function row_categoria($id = '') {
		$form = new form;

		$form -> fd = array('id_pc', 'pc_nome', 'pc_codigo', 'pc_ativo');
		$form -> lb = array('id', msg('pc_nome'), msg('pc_codigo'), msg('pc_ativo'));
		$form -> mk = array('', 'L', 'L', 'L');

		$form -> tabela = $this -> table_categoria;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = true;

		$form -> row_edit = base_url('index.php/main/produtos_categoria_edit');
		$form -> row_view = base_url('index.php/main/produtos_categoria_view');
		$form -> row = base_url('index.php/main/produtos_categoria');

		return (row($form, $id));
	}

	function editar_categoria($id, $chk) {
		$form = new form;
		$form -> id = $id;
		$cp = $this -> cp_categoria();
		$data['title'] = '';
		$data['content'] = $form -> editar($cp, $this -> table_categoria);
		$this -> load -> view('content', $data);
		return ($form -> saved);
	}
/************************************************************************** PRODUTOS MARCA ****************************/
	function le_marca($id)
		{
			$sql = "select * from ".$this->table_marca." where id_ma = ".round($id);
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			$line = $rlt[0];
			return($line);
		}
	function cp_marca()
		{
		$cp = array();
		array_push($cp, array('$H8', 'id_ma', '', False, True));
		array_push($cp, array('$S80', 'ma_nome', 'Nome da marca', True, True));
		array_push($cp, array('$S80', 'ma_logo', 'Link logotipo', false, True));		
		array_push($cp, array('$O 1:SIM&0:NÃO', 'ma_ativo', 'Ativo', True, True));
		array_push($cp, array('$B8', '', 'Gravar', false, True));

		return ($cp);
		}

	function row_marcas($id = '') {
		$form = new form;

		$form -> fd = array('id_ma', 'ma_nome', 'ma_logo', 'ma_ativo');
		$form -> lb = array('id', msg('ma_nome'), msg('ma_logo'), msg('ma_ativo'));
		$form -> mk = array('', 'L', 'L', 'L');

		$form -> tabela = $this -> table_marca;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = true;

		$form -> row_edit = base_url('index.php/main/produtos_marca_edit');
		$form -> row_view = base_url('index.php/main/produtos_marca_view');
		$form -> row = base_url('index.php/main/produtos_marca');

		return (row($form, $id));
	}

	function editar_marca($id, $chk) {
		$form = new form;
		$form -> id = $id;
		$cp = $this -> cp_marca();
		$data['title'] = '';
		$data['content'] = $form -> editar($cp, $this -> table_marca);
		$this -> load -> view('content', $data);
		return ($form -> saved);
	}
}
?>
