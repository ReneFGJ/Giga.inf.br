<?php
class produtos extends CI_model {
	var $table = 'produtos';
	var $table_tipo = 'produtos_tipo';
	var $table_tipo_2 = '(select * from produtos_tipo LEFT JOIN produtos_marca ON prd_marca = id_ma) as produtos_tipo ';
	var $table_categoria = 'produtos_categoria';
	var $table_marca = 'produtos_marca';
	var $table_produto = '(SELECT * FROM produtos
							INNER JOIN produtos_tipo ON pr_produto = id_prd
							LEFT JOIN produtos_situacao ON pr_ativo = id_ps
							LEFT JOIN clientes ON pr_cliente = id_f
							LEFT JOIN produtos_marca ON prd_marca = id_ma
							LEFT JOIN _filiais ON pr_filial = id_fi
							LEFT JOIN produtos_categoria ON id_pc = prd_categoria
						   ) as produtos ';
	
	/************************************************************************** PRODUTOS *****************************/	
	function le($id)
		{
			$sql = "select * from ".$this->table_tipo."
						LEFT JOIN produtos_marca ON prd_marca = id_ma
						LEFT JOIN produtos_categoria ON prd_categoria = id_pc
						WHERE id_prd = ".round($id);
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			if (count($rlt) > 0)
				{
					$line = $rlt[0];
					$line['imgs'] = $this->le_imagem($id);					
					return($line);
				} else {
					return(array());
				}
		}
	function le_produto($id)
		{
			$sql = "select * from ".$this->table."
						LEFT JOIN ".$this->table_tipo." ON pr_produto = id_prd
						LEFT JOIN produtos_marca ON prd_marca = id_ma
						LEFT JOIN produtos_categoria ON prd_categoria = id_pc
						LEFT JOIN produtos_situacao ON pr_ativo = id_ps
						LEFT JOIN clientes ON pr_cliente = id_f
						LEFT JOIN _filiais ON pr_filial = id_fi				
						WHERE id_pr = ".round($id);
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			if (count($rlt) > 0)
				{
					$line = $rlt[0];
					$line['imgs'] = $this->le_imagem($id);					
					return($line);
				} else {
					return(array());
				}
		}
	function le_imagem($id)
		{
			$sql = "select * from produto_doc_ged
						INNER JOIN produto_doc_ged_tipo on doc_tipo = id_doct
						WHERE doct_codigo = 'PRODT'
						AND doc_dd0 = ".round($id);
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			return($rlt);
		}
		
	function le_produtos_categoria($id)
		{
			$sql = "select * from produtos_categoria 
					WHERE id_pc = ".$id;
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			$line = $rlt[0];
			return($line);
		}
		
	function cp_item()
		{
		$cp = array();
		array_push($cp, array('$H8', 'id_prd', '', False, True));
		array_push($cp, array('$A', '', 'Dados do produto', False, True));
		array_push($cp, array('$S80', 'pr_nome', 'Nome do produto', True, True));
		array_push($cp, array('$S40', 'pr_serial', 'Nº de Série', False, True));
		array_push($cp, array('$S40', 'pr_patrimonio', 'Nº do patrimonio', False, True));
		$sql = "select * from produtos_marca where ma_ativo = 1 order by ma_nome";
		array_push($cp, array('$Q id_ma:ma_nome:'.$sql, 'pr_marca', 'Marca', True, True));
		$sql = "select * from produtos_categoria where pc_ativo = 1 order by pc_nome";
		array_push($cp, array('$Q id_pc:pc_nome:'.$sql, 'pr_categoria', 'Categoria', True, True));
		array_push($cp, array('$T80:5', 'pr_descricao', 'Dados técnicos / Descrição', False, True));	
			
		$sql = "select * from produtos_situacao where ps_ativo = 1 order by id_ps";
		array_push($cp, array('$Q id_ps:ps_descricao:'.$sql, 'pr_ativo', 'Situação', True, True));
		
		array_push($cp, array('$A', '', 'Fornecedor', False, True));
		array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_ativo = 1 and f_fornecedor=1', 'pr_fornecedor', 'Fornecedor', False, True));
		array_push($cp, array('$S10', 'pr_nf', 'Nota fiscal', False, True));
		array_push($cp, array('$D8', 'pr_nf_data', 'Data NF', False, True));
		array_push($cp, array('$N8', 'pr_vlr_custo', 'Valor de custo', False, True));
		
				
		array_push($cp, array('$B8', '', 'Gravar', False, True));	
		return ($cp);
		}

	function cp_item_patrimonio()
		{
		$cp = array();
		array_push($cp, array('$H8', 'id_prd', '', False, True));
		array_push($cp, array('$A', '', 'Dados do produto', False, True));
		array_push($cp, array('$Q id_prd:prd_nome:select * from produtos_tipo where prd_ativo = 1', 'pr_produto', 'Produto', True, True));
		array_push($cp, array('$S40', 'pr_serial', 'Nº de Série', False, True));
		array_push($cp, array('$S40', 'pr_patrimonio', 'Nº do patrimonio', False, True));
		array_push($cp, array('$S40', 'pr_tag', 'Nº do Tag', False, True));
			
		$sql = "select * from produtos_situacao where ps_ativo = 1 order by id_ps";
		array_push($cp, array('$Q id_ps:ps_descricao:'.$sql, 'pr_ativo', 'Situação', True, True));
		
		array_push($cp, array('$A', '', 'Fornecedor', False, True));
		array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_ativo = 1 and f_fornecedor=1', 'pr_fornecedor', 'Fornecedor', False, True));
		array_push($cp, array('$S10', 'pr_nf', 'Nota fiscal', False, True));
		array_push($cp, array('$D8', 'pr_nf_data', 'Data NF', False, True));
		array_push($cp, array('$N8', 'pr_vlr_custo', 'Valor de custo', False, True));
		
				
		array_push($cp, array('$B8', '', 'Gravar', False, True));	
		return ($cp);
		}
	function cp()
		{
		$cp = array();
		array_push($cp, array('$H8', 'id_prd', '', False, True));
		array_push($cp, array('$A', '', 'Dados do produto', False, True));
		array_push($cp, array('$S80', 'prd_nome', 'Nome do produto', True, True));
		$sql = "select * from produtos_marca where ma_ativo = 1 order by ma_nome";
		array_push($cp, array('$Q id_ma:ma_nome:'.$sql, 'prd_marca', 'Marca', True, True));
		$sql = "select * from produtos_categoria where pc_ativo = 1 order by pc_nome";
		array_push($cp, array('$Q id_pc:pc_nome:'.$sql, 'prd_categoria', 'Categoria', True, True));
		array_push($cp, array('$T80:5', 'prd_descricao', 'Dados técnicos / Descrição', False, True));	
			
		$sql = "select * from produtos_situacao where ps_ativo = 1 order by id_ps";
		array_push($cp, array('$O 1:Ativo&0:Inativo', 'prd_ativo', 'Situação', True, True));

		
				
		array_push($cp, array('$B8', '', 'Gravar', False, True));	
		return ($cp);
		}
	function row($id = '') {
		$form = new form;

		$form -> fd = array('id_prd', 'prd_nome','ma_nome', 'prd_ativo');
		$form -> lb = array('id', msg('pr_descricao'), msg('ma_nome'), msg('pr_ativo'));
		$form -> mk = array('', 'L', 'C', 'C','SN');

		$form -> tabela = $this -> table_tipo_2;
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
		$data['content'] = $form -> editar($cp, $this -> table_tipo);
		$this -> load -> view('content', $data);
		return ($form -> saved);
	}	
	/****************************************************************************************** HISTORICO *********************/
	function inserir_historico($dt)
		{
			$prod = round($dt['id_pr']);
			$user = $_SESSION['id'];
			$hist = $dt['id_hs'];
			$pedi = $dt['nr_pedido'];
			$sql = "insert into produtos_historico 
						(
						ph_produto, ph_historico, ph_log, ph_pedido
						) values (
						$prod,$hist,$user,$pedi
						)";
			$rlt = $this->db->query($sql);
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
		array_push($cp, array('$T80:5', 'pc_desc_basica', 'Descrição Básica', True, True));
		array_push($cp, array('$O 1:SIM&0:NÃO', 'pc_ativo', 'Ativo', True, True));

		return ($cp);
		}

	function row_categoria($id = '') {
		$form = new form;

		$form -> fd = array('id_pc', 'pc_nome', 'pc_codigo', 'pc_ativo');
		$form -> lb = array('id', msg('pc_nome'), msg('pc_codigo'), msg('pc_ativo'));
		$form -> mk = array('', 'L', 'L', 'A');

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
	
	function row_produtos($id = '') {
		$sx = '';
			$sql = 'select * from '.$this->table_produto.' WHERE id_prd = '.round($id);
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			$sx = '<table width="100%" class="table">'.cr();
			$sx .= '<tr>
						<th>descrição</th>
						<th>nº patrimonio</th>
						<th>nº série</th>
						<th>situação</th>
					</tr>';
			for ($r=0;$r < count($rlt);$r++)
				{
					$line = $rlt[$r];
					$link = base_url('index.php/main/produto_view/'.$line['id_pr'].'/'.checkpost_link($line['id_pr']));
					$link = '<a href="'.$link.'">';
					$sx .= '<tr class="'.$line['ps_class'].'">';
					$sx .= '<td>';
					$sx .= $link.$line['prd_nome'].'</a>';
					$sx .= '</td>';
					
					$sx .= '<td>';
					$sx .= $line['pr_patrimonio'];
					$sx .= '</td>';					
					
					$sx .= '<td>';
					$sx .= $line['pr_serial'];
					$sx .= '</td>';
					
					$sx .= '<td>';
					$sx .= $line['ps_descricao'];
					$sx .= '</td>';
					
					
					$sx .= '</tr>'.cr();
				}
			$sx .= '</table>'.cr();
		return ($sx);
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
	function lista_produtos_categoria($id)
		{
			$sql = 'select * from '.$this->table_produto.' WHERE id_pc = '.round($id);
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			$sx = '<table width="100%" class="table">'.cr();
			$sx .= '<tr>
						<th>descrição</th>
						<th>nº patrimonio</th>
						<th>nº série</th>
						<th>situação</th>
					</tr>';
			for ($r=0;$r < count($rlt);$r++)
				{
					$line = $rlt[$r];
					$link = base_url('index.php/main/produto_view/'.$line['id_pr'].'/'.checkpost_link($line['id_pr']));
					$link = '<a href="'.$link.'">';
					$sx .= '<tr class="'.$line['ps_class'].'">';
					$sx .= '<td>';
					$sx .= $link.$line['prd_nome'].'</a>';
					$sx .= '</td>';
					
					$sx .= '<td>';
					$sx .= $line['pr_patrimonio'];
					$sx .= '</td>';					
					
					$sx .= '<td>';
					$sx .= $line['pr_serial'];
					$sx .= '</td>';
					
					$sx .= '<td>';
					$sx .= $line['ps_descricao'];
					$sx .= '</td>';
					
					
					$sx .= '</tr>'.cr();
				}
			$sx .= '</table>'.cr();
			return($sx);
		}
}
?>
