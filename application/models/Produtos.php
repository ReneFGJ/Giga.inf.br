<?php
class produtos extends CI_model {
	var $table = 'produtos';
	var $table_tipo = 'produtos_tipo';
	var $table_tipo_2 = '(select * from produtos_tipo LEFT JOIN produtos_marca ON pr_marca = id_ma) as produtos_tipo ';
	var $table_categoria = 'produtos_categoria';
	var $table_marca = 'produtos_marca';
	var $table_produto = '(SELECT * FROM produtos
							LEFT JOIN produtos_situacao ON pr_ativo = id_ps
							LEFT JOIN clientes ON pr_cliente = id_f
							LEFT JOIN produtos_marca ON pr_marca = id_ma
							LEFT JOIN _filiais ON pr_filial = id_fi
							LEFT JOIN produtos_categoria ON id_pc = pr_categoria
						   ) as produtos ';

	/************************************************************************** PRODUTOS *****************************/
	function le($id) {
		$sql = "select * from " . $this -> table_tipo . "
						LEFT JOIN produtos_marca ON pr_marca = id_ma
						LEFT JOIN produtos_categoria ON pr_categoria = id_pc
						WHERE id_prd = " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			$line['imgs'] = $this -> le_imagem($id);
			return ($line);
		} else {
			return ( array());
		}
	}

	function le_produto($id) {
		/* LEFT JOIN " . $this -> table_tipo . " ON pr_produto = id_prd */
		$sql = "select * from " . $this -> table . "
						LEFT JOIN produtos_marca ON pr_marca = id_ma
						LEFT JOIN produtos_categoria ON pr_categoria = id_pc
						LEFT JOIN produtos_situacao ON pr_ativo = id_ps
						LEFT JOIN clientes ON pr_cliente = id_f
						LEFT JOIN _filiais ON pr_filial = id_fi				
						WHERE id_pr = " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			$line['imgs'] = $this -> le_imagem($id);
			return ($line);
		} else {
			return ( array());
		}
	}

	function le_produto_ean($id) {
		$sql = "select * from " . $this -> table . "
						LEFT JOIN produtos_marca ON pr_marca = id_ma
						LEFT JOIN produtos_categoria ON pr_categoria = id_pc
						LEFT JOIN produtos_situacao ON pr_ativo = id_ps
						LEFT JOIN clientes ON pr_cliente = id_f
						LEFT JOIN _filiais ON pr_filial = id_fi				
						WHERE pr_patrimonio = '" . $id."'";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) > 0) {
			$line = $rlt[0];
			$line['imgs'] = $this -> le_imagem($id);
			return ($line);
		} else {
			return ( array());
		}
	}
		
	function le_imagem($id) {
		$sql = "select * from produto_doc_ged
						INNER JOIN produto_doc_ged_tipo on doc_tipo = id_doct
						WHERE doct_codigo = 'PRODT'
						AND doc_dd0 = " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		return ($rlt);
	}

	function busca($t, $cat) {
		$t = troca($t, ' ', ';');
		$t = splitx(';', $t . ';');
		$wh1 = '';
		$wh2 = '';
		$wh3 = '';
		$wh4 = '';
		for ($r = 0; $r < count($t); $r++) {
			$term = $t[$r];
			if (strlen($term) > 0) {
				if (strlen($wh1) > 0) {
					$wh1 .= ' AND ';
				}
				$wh1 .= " pr_modelo like '%$term%' ";
				if (strlen($wh2) > 0) {
					$wh2 .= ' AND ';
				}
				$wh2 .= " pr_serial like '%$term%' ";
			}
		}
		if (strlen($wh1) == 0) {
			$wh1 = '1=1';
			$wh2 = '1=1';
		}
		if (strlen($cat) > 0) {
			$wh3 = 'AND (id_pc = ' . $cat . ')';
		}
		/* total */
		$sql = "select count(*) as total from produtos
						LEFT JOIN produtos_categoria ON id_pc = pr_categoria
						LEFT JOIN produtos_situacao ON id_ps = pr_ativo
						LEFT JOIN _filiais ON pr_filial = id_fi
						WHERE (($wh1) OR ($wh2)) $wh3
						ORDER BY pc_nome, pr_serial
						LIMIT 100
						";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$total = $rlt[0]['total'];

		$sql = "select * from produtos
						LEFT JOIN produtos_categoria ON id_pc = pr_categoria
						LEFT JOIN produtos_situacao ON id_ps = pr_ativo
						LEFT JOIN _filiais ON pr_filial = id_fi
						WHERE (($wh1) OR ($wh2)) $wh3
						ORDER BY pc_nome, pr_serial
						";

		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table class="table" width="100%">';
		$sx .= '<tr class="middle"><td colspan=9>Total Recuperado ' . $total . '</td></tr>' . cr();
		$sx .= '<tr class="small">' . cr();
		$sx .= '	<th colspan="1" width="2%"><b>#</b></th>' . cr();
		$sx .= '	<th colspan="1" width="33%"><b>Produto</b></th>' . cr();
		$sx .= '	<th colspan="1" width="10%"><b>Serial</b></th>' . cr();
		$sx .= '	<th colspan="2" width="10%"><b>Característica</b></th>' . cr();
		$sx .= '	<th colspan="5" width="45%"><b>Situação / Filial</b></th>' . cr();
		$sx .= '</tr>' . cr();
		$ID = 0;
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$ID++;
			$sx .= '<tr class="' . trim($line['ps_class']) . '">' . cr();
			$sx .= '	<td class="small" >';
			$sx .= strzero($ID, 3) . '. ';
			$sx .= '	</td>' . cr();
			$sx .= '	<td >';
			$sx .= $line['pr_modelo'];
			$sx .= '	</td>' . cr();
			$sx .= '	<td class="middle">';
			$sx .= $line['pr_serial'];
			$sx .= '	</td>' . cr();
			$sx .= '	<td  class="small">';
			$sx .= $line['pc_nome'];
			$sx .= '	</td>' . cr();
			$sx .= '	<td colspan=5 class="small" >';
			$sx .= $line['ps_descricao'];
			$sx .= ' (' . $line['pr_patrimonio'] . ')';
			$sx .= ' - ' . $line['fi_nome_fantasia'] . '&nbsp;';
			$sx .= '	</td>' . cr();
			$sx .= '</tr>' . cr();
		}
		$sx .= '</table>';
		return ($sx);
	}

	function contratos_situacao($sit) {
		$sql = "select * from pedido
						INNER JOIN clientes ON pp_cliente = id_f 
						WHERE pp_tipo_pedido = 3 and pp_situacao = " . $sit . "
					ORDER BY pp_dt_ini_evento
					";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '';
		$sx .= '<table class="table" width="100%">';
		$sx .= '<tr><th>Contrato</th><th>Cliente</th><th>Início Locação</th><th>Fim Locação</th></tr>';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$link = 'index.php/main/locacao_item/' . $line['id_pp'] . '/' . checkpost_link($line['id_pp']);
			$link = '<a href="' . base_url($link) . '" target="_new">';

			$sx .= '<tr>';
			$sx .= '<td>';
			$sx .= $link;
			$sx .= strzero($line['id_pp'], 7) . '/' . $line['pp_ano'];
			$sx .= '</a>';
			$sx .= '</td>';

			$sx .= '<td>';
			$sx .= $line['f_razao_social'];
			$sx .= ' / ';
			$sx .= $line['f_nome_fantasia'];
			$sx .= '</td>';

			$sx .= '<td>';
			$sx .= stodbr($line['pp_dt_ini_evento']);
			$sx .= '</td>';

			$sx .= '<td>';
			$sx .= stodbr($line['pp_dt_fim_evento']);
			$sx .= '</td>';
			$sx .= '</tr>';
		}
		$sx .= '</table>';
		return ($sx);
	}

	function le_produtos_categoria($id) {
		$sql = "select * from produtos_categoria 
					WHERE id_pc = " . $id;
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$line = $rlt[0];
		return ($line);
	}

	function cp_item() {
		$cp = array();
		array_push($cp, array('$H8', 'id_prd', '', False, True));
		array_push($cp, array('$A', '', 'Dados do produto', False, True));
		array_push($cp, array('$S80', 'pr_nome', 'Nome do produto', True, True));
		array_push($cp, array('$S40', 'pr_serial', 'Nº de Série', False, True));
		array_push($cp, array('$S40', 'pr_patrimonio', 'Nº do patrimonio', False, True));
		$sql = "select * from produtos_marca where ma_ativo = 1 order by ma_nome";
		array_push($cp, array('$Q id_ma:ma_nome:' . $sql, 'pr_marca', 'Marca', True, True));
		$sql = "select * from produtos_categoria where pc_ativo = 1 order by pc_nome";
		array_push($cp, array('$Q id_pc:pc_nome:' . $sql, 'pr_categoria', 'Categoria', True, True));
		array_push($cp, array('$T80:5', 'pr_descricao', 'Dados técnicos / Descrição', False, True));

		$sql = "select * from produtos_situacao where ps_ativo = 1 order by id_ps";
		array_push($cp, array('$Q id_ps:ps_descricao:' . $sql, 'pr_ativo', 'Situação', True, True));

		array_push($cp, array('$A', '', 'Fornecedor', False, True));
		array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_ativo = 1 and f_fornecedor=1', 'pr_fornecedor', 'Fornecedor', False, True));
		array_push($cp, array('$S10', 'pr_nf', 'Nota fiscal', False, True));
		array_push($cp, array('$D8', 'pr_nf_data', 'Data NF', False, True));
		array_push($cp, array('$N8', 'pr_vlr_custo', 'Valor de custo', False, True));

		array_push($cp, array('$B8', '', 'Gravar', False, True));
		return ($cp);
	}

	function cp_item_patrimonio() {
		$cp = array();
		array_push($cp, array('$H8', 'id_prd', '', False, True));
		array_push($cp, array('$A', '', 'Dados do produto', False, True));
		array_push($cp, array('$S80', 'pr_modelo', 'Produto', True, True));
		array_push($cp, array('$S40', 'pr_serial', 'Nº de Série', False, True));
		//array_push($cp, array('$S40', 'pr_patrimonio', 'Nº do patrimonio', False, True));
		//array_push($cp, array('$S40', 'pr_tag', 'Nº do Tag', False, True));

		$sql = "select * from produtos_marca where ma_ativo = 1 order by id_ma";
		array_push($cp, array('$Q id_ma:ma_nome:' . $sql, 'pr_marca', 'Marca', True, True));

		$sql = "select * from produtos_categoria where pc_ativo = 1 order by id_pc";
		array_push($cp, array('$Q id_pc:pc_nome:' . $sql, 'pr_categoria', 'Categoria', True, True));

		$sql = "select * from _filiais where fi_ativo = 1 order by id_fi";
		array_push($cp, array('$Q id_fi:fi_nome_fantasia:' . $sql, 'pr_filial', 'Filial', True, True));

		array_push($cp, array('$HV', 'pr_ativo', '1', True, True));

		array_push($cp, array('$A', '', 'Fornecedor', False, True));
		array_push($cp, array('$Q id_f:f_nome_fantasia:select * from clientes where f_ativo = 1 and f_fornecedor=1', 'pr_fornecedor', 'Fornecedor', False, True));
		array_push($cp, array('$S10', 'pr_nf', 'Nota fiscal', False, True));
		array_push($cp, array('$D8', 'pr_nf_data', 'Data NF', False, True));
		array_push($cp, array('$N8', 'pr_vlr_custo', 'Valor de custo', False, True));

		array_push($cp, array('$B8', '', 'Gravar', False, True));
		return ($cp);
	}

	function cp() {
		$cp = array();
		array_push($cp, array('$H8', 'id_prd', '', False, True));
		array_push($cp, array('$A', '', 'Dados do produto', False, True));
		array_push($cp, array('$S80', 'prd_nome', 'Nome do produto', True, True));
		$sql = "select * from produtos_marca where ma_ativo = 1 order by ma_nome";
		array_push($cp, array('$Q id_ma:ma_nome:' . $sql, 'pr_marca', 'Marca', True, True));
		$sql = "select * from produtos_categoria where pc_ativo = 1 order by pc_nome";
		array_push($cp, array('$Q id_pc:pc_nome:' . $sql, 'pr_categoria', 'Categoria', True, True));
		array_push($cp, array('$T80:5', 'prd_descricao', 'Dados técnicos / Descrição', False, True));

		$sql = "select * from produtos_situacao where ps_ativo = 1 order by id_ps";
		array_push($cp, array('$O 1:Ativo&0:Inativo', 'prd_ativo', 'Situação', True, True));

		array_push($cp, array('$B8', '', 'Gravar', False, True));
		return ($cp);
	}

	function row($id = '') {
		$form = new form;

		$form -> fd = array('id_prd', 'prd_nome', 'ma_nome', 'prd_ativo');
		$form -> lb = array('id', msg('pr_descricao'), msg('ma_nome'), msg('pr_ativo'));
		$form -> mk = array('', 'L', 'C', 'C', 'SN');

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
	function inserir_historico($dt) {
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
		$rlt = $this -> db -> query($sql);
	}

	/************************************************************************** PRODUTOS CATEGORIA ****************************/
	function le_categoria($id) {
		$sql = "select * from " . $this -> table_categoria . " where id_pc = " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$line = $rlt[0];
		return ($line);
	}

	function cp_categoria() {
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
	function le_marca($id) {
		$sql = "select * from " . $this -> table_marca . " where id_ma = " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$line = $rlt[0];
		return ($line);
	}

	function cp_marca() {
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
		$sql = 'select * from ' . $this -> table_produto . ' WHERE id_prd = ' . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table width="100%" class="table">' . cr();
		$sx .= '<tr>
						<th>descrição</th>
						<th>nº patrimonio</th>
						<th>nº série</th>
						<th>situação</th>
					</tr>';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$link = base_url('index.php/main/produto_view/' . $line['id_pr'] . '/' . checkpost_link($line['id_pr']));
			$link = '<a href="' . $link . '">';
			$sx .= '<tr class="' . $line['ps_class'] . '">';
			$sx .= '<td>';
			$sx .= $link . $line['prd_nome'] . '</a>';
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

			$sx .= '</tr>' . cr();
		}
		$sx .= '</table>' . cr();
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

	function etiquetas() {
		$sql = "select * from produtos 
						WHERE pr_etiqueta = 1
			";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '';
		$i = 35;
		for ($r = 0; $r < count($rlt); $r = $r + 1) {
			$line = $rlt[$r];
			$mod = trim($line['pr_modelo']);
			$mod2 = '';
			if (strlen($mod) > $i) {
				$mod2 = substr($mod, $i, 30);
				$mod = substr($mod, 0, $i);
			}
			$sx .= 'N' . cr();
			$sx .= 'q816' . cr();
			$sx .= 'Q200,24' . cr();
			$sx .= 'A270,10,0,1,2,2,N,"GiGa"' . cr();
			//$sx .= 'A250,40,0,1,1,2,N,"INFORMATICA"' . cr();
			$sx .= 'A10,110,0,1,1,2,N,"' . $mod . '"' . cr();
			$sx .= 'A10,140,0,1,1,2,N,"' . $mod2 . '"' . cr();
			$sx .= 'A10,170,0,1,1,1,N,"' . $line['pr_serial'] . '"' . cr();
			$sx .= 'B0,0,0,E80,3,7,80,B,"' . $line['pr_patrimonio'] . '"' . cr();

			if (isset($rlt[$r + 1])) {
				$line = $rlt[$r + 1];
				$mod = trim($line['pr_modelo']);
				$mod2 = '';
				if (strlen($mod) > $i) {
					$mod2 = substr($mod, $i, 30);
					$mod = substr($mod, 0, $i);
				}
				$sx .= '' . cr();
				$sx .= 'A690,10,0,1,2,2,N,"GiGa"' . cr();
				//$sx .= 'A670,40,0,1,1,2,N,"INFORMATICA"' . cr();
				$sx .= 'A440,110,0,1,1,2,N,"' . $mod . '"' . cr();
				$sx .= 'A440,140,0,1,1,2,N,"' . $mod2 . '"' . cr();
				$sx .= 'A440,170,0,1,1,1,N,"' . $line['pr_serial'] . '"' . cr();
				$sx .= 'B400,0,0,E80,3,7,80,B,"' . $line['pr_patrimonio'] . '"' . cr();
			}
			$sx .= '' . cr();
			$sx .= 'P1' . cr();
		}
		echo '<pre>' . $sx . '</pre>';
	}

	function lista_produtos_categoria($id) {
		$sql = 'select * from ' . $this -> table_produto . ' WHERE id_pc = ' . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table width="100%" class="table">' . cr();
		$sx .= '<tr>
						<th>descrição</th>
						<th>nº patrimonio</th>
						<th>nº série</th>
						<th>situação</th>
					</tr>';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$link = base_url('index.php/main/produto_view/' . $line['id_pr'] . '/' . checkpost_link($line['id_pr']));
			$link = '<a href="' . $link . '">';
			$sx .= '<tr class="' . $line['ps_class'] . '">';
			$sx .= '<td>';
			$sx .= $link . $line['prd_nome'] . '</a>';
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

			$sx .= '</tr>' . cr();
		}
		$sx .= '</table>' . cr();
		return ($sx);
	}

	function locacao_categorias($id) {
		$sql = "select * from produtos_categoria where pc_ativo = 1 order by pc_nome";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table width="100%" class="table">';
		$sx .= '<tr><th>Categorias</th></tr>';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$link = base_url('index.php/main/locacao_item_novo/' . $id . '/' . $line['id_pc']);
			$link = '<a href="' . $link . '">';
			$sx .= '<tr>';
			$sx .= '<td>';
			$sx .= $link . $line['pc_nome'] . '</a>';
			$sx .= '</td>';
		}		$sx .= '</table>';
		return ($sx);
	}

	function locacao_item($id, $ct) {
		$sql = "SELECT * FROM produtos_categoria 
					INNER JOIN produtos ON pr_categoria = id_pc
					LEFT JOIN produtos_marca ON pr_marca = id_ma 
					LEFT JOIN _filiais ON pr_filial = id_fi
					WHERE pr_categoria = $ct and pr_ativo > 0
					";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table width="100%" class="table">';
		$sx .= '<tr><th>Itens</th><th>Marca</th><th>Serial</th><th>Filial</th></tr>';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$link = base_url('index.php/main/locacao_item_novo/' . $id . '/' . $ct . '/' . $line['id_pr']);
			$link = '<a href="' . $link . '">';
			$sx .= '<tr>';
			$sx .= '<td>';
			$sx .= $link . $line['pc_desc_basica'] . '</a>';
			$sx .= '</td>';
			$sx .= '<td>';
			$sx .= $link . $line['ma_nome'] . '</a>';
			$sx .= '</td>';
			$sx .= '<td>';
			$sx .= $link . $line['pr_serial'] . '</a>';
			$sx .= '</td>';
			$sx .= '<td>';
			$sx .= $link . $line['fi_nome_fantasia'] . '</a>';
			$sx .= '</td>';
		}
		$sx .= '</table>';
		return ($sx);
	}
	/****************** LOGISTICA *************/
	function movimenta_para_estoque($id)
		{
			$user = $_SESSION['id'];
			$sql = "update produtos set
						pr_etiqueta = 0,
						pr_ativo = 1,
						pr_cliente = 0,
						pr_doc = 0
					where id_pr = ".round($id);
			$rlt = $this->db->query($sql); 
			$sql = "insert into produtos_historico
						(
							ph_produto, ph_historico, ph_log,
							ph_pedido
						)
						values
						(
							$id,1,$user,
							0
						)";
			$rlt = $this->db->query($sql);
			return(1);
		}

	function produto_registra($prod, $ped, $d1, $d2, $cliente = 1) {
		$data = date("Y-m-d");
		$hora = date("H:i:s");
		$cliente = 1;
		$res = 0;
		$sit = 1;
		$vend = $_SESSION['id'];
		$sql = "select * from produto_agenda 
						WHERE ";
		$sql = "insert into produto_agenda 
						(ag_produto, ag_data, ag_cliente, 
						ag_vendedor, ag_data_reserva, ag_data_reserva_ate, 
						ag_hora_reserva, ag_reservado, ag_situacao,
						ag_pedido)
						values
						($prod,'$data',$cliente,
						$vend,'$d1','$d2',
						'$hora','$res','$sit',
						$ped
						)
			";
		$rlt = $this -> db -> query($sql);
	}
	
	function produtos_reservados($id)
		{
			$sql = "select * from produto_agenda
						inner join produtos on id_pr = ag_produto
						inner join produtos_categoria  ON pr_categoria = id_pc						
					where ag_pedido = $id
					";
			$rlt = $this->db->query($sql);
			$rlt = $rlt->result_array();
			$sx = '<table class="table" width="100%">';
			$sx .= '<tr class="small">';
			$sx .= '<th>patrimônio</th>';
			$sx .= '<th>descrição</th>';
			$sx .= '<th>serial</th>';
			$sx .= '<th style="text-center" width="10%">início</th>';
			$sx .= '<th style="text-center" width="10%">fim</th>';
			$sx .= '<th style="text-center" width="3%">#</th>';
			$sx .= '</tr>';
			for ($r=0;$r < count($rlt);$r++)
				{
					$line = $rlt[$r];
					$link = 'onclick="newxy(\''.base_url('index.php/main/locacao_item_editar/'.$id.'/'.checkpost_link($id)).'\',800,600);" style="cursor: pointer;" ';
					$sx .= '<tr>';
					
					
					$sx .= '<td align="left">';
					$sx .= $line['pr_patrimonio'];
					$sx .= '</td>';
					
					$sx .= '<td align="left">';
					$sx .= $line['pc_nome'];
					$sx .= '</td>';					

					$sx .= '<td align="left">';
					$sx .= $line['pr_serial'];
					$sx .= '</td>';					
					
					$sx .= '<td align="center">';
					$sx .= stodbr($line['ag_data_reserva']);
					$sx .= '</td>';
					
					$sx .= '<td align="center">';
					$sx .= stodbr($line['ag_data_reserva_ate']);
					$sx .= '</td>';
					
					$sx .= '<td>';
					$sx .= '<span class="glyphicon glyphicon-pencil" aria-hidden="true" '.$link.'></span>';
					$sx .= '</td>';
					
					$sx .= '</tr>';
				}
			$sx .= '</table>';
			return($sx);
		}

	function updatex() {
		$sql = "update produtos set pr_patrimonio = lpad(id_pr,7,0) where pr_patrimonio = '' or pr_patrimonio is null";
		$rlt = $this -> db -> query($sql);
	}

}
?>
