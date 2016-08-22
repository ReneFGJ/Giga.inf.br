<?php
class Main extends CI_Controller {
	function __construct() {
		global $dd, $acao;
		parent::__construct();
		$this -> lang -> load("app", "portuguese");
		$this -> load -> helper('form_sisdoc');
		$this -> load -> helper('email');
		$this -> load -> model('users');

		date_default_timezone_set('America/Sao_Paulo');
	}

	function cab($data = array()) {
		$js = array();
		$css = array();
		array_push($js, 'form_sisdoc.js');
		array_push($js, 'jquery-ui.min.js');

		$data['js'] = $js;
		$data['css'] = $css;

		$data['title'] = ':: Giga Informática ::';
		$this -> load -> view('header/header', $data);
		$this -> load -> view('header/header_print', $data);

		if (!(isset($data['nocab']))) {
			$this -> load -> view('menus/menu_cab_top', $data);
		} else {
			$this -> load -> view('header/header_nomargin.php', null);
		}

		$this -> users -> security();
	}

	function footer() {
		$this -> load -> view('header/footer', null);
	}

	function index() {
		$this -> cab();
		$this -> load -> view('home', null);
		$this -> footer();
	}

	/****************************************** PEDIDOS *********************/
	function menu_pedidos($tipo = '', $situacao = '') {
		$id_us = $_SESSION['id'];
		if (strlen($tipo) == 0) {
			$tipo = '1';
		}
		$model = "pedidos";
		$this -> load -> model($model);

		$this -> cab();

		/* Pedidos */
		$tela = $this -> $model -> pedidos_abertas_resumo($id_us, $tipo);
		switch($tipo) {
			case '1' :
				$data['title'] = 'Resumo dos Orçamentos';
				break;
			case '2' :
				$data['title'] = 'Resumo dos Pedidos';
				break;
			case '3' :
				$data['title'] = 'Resumo dos Pedidos de locação';
				break;
			case '4' :
				$data['title'] = 'Resumo das ordem de serviço - Laboratório';
				break;
			case '5' :
				$data['title'] = 'Resumo das ordem de atendimento - onsite';
				break;
			default :
				$data['title'] = 'Resumo';
				break;
		}

		$data['content'] = $tela;
		$this -> load -> view('content', $data);

		if ((strlen($tipo) > 0) and (strlen($situacao) > 0)) {
			$data['br'] = true;
			$data['content'] = $this -> $model -> mostra_lista_detalhes($id_us, $tipo, $situacao);
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	/****************************************** PEDIDOS *********************/
	function menu_orcamentos($tipo = '', $situacao = '') {
		$id_us = $_SESSION['id'];
		$model = "pedidos";
		$this -> load -> model($model);

		$this -> cab();

		/* Pedidos */
		$tela = $this -> $model -> pedidos_abertas_resumo($id_us, '1');
		$data['title'] = 'Resumo dos Orçamentos';
		$data['content'] = $tela;
		$this -> load -> view('content', $data);

		if ((strlen($tipo) > 0) and (strlen($situacao) > 0)) {
			$data['content'] = $this -> $model -> mostra_lista_detalhes($id_us, $tipo, $situacao);
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	/****************************************** PEDIDO *********************/
	function pedido_set_contato($ped) {
		$dd1 = round(get("pedido"));
		$dd2 = round(get("contato"));
		$dd3 = get("value");
		echo '===>' . $dd3;
		if (($dd3 == 'True') or ($dd3 == 'true')) { $dd3 = 1;
		} else { $dd3 = 0;
		}

		$sql = "select * from pedido_contato 
						WHERE pct_id_pp = $dd1
						AND pct_id_contato = $dd2 ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) == 0) {
			$sql = "insert into pedido_contato
							(
								pct_id_pp, 	pct_id_contato, pct_ativo
							) values (
								$dd1,$dd2,$dd3
							)";
			$rlt = $this -> db -> query($sql);
		} else {
			$line = $rlt[0];
			$sql = "update pedido_contato 
						set pct_ativo = $dd3
						where id_pct = " . $line['id_pct'];
			$rlt = $this -> db -> query($sql);
			echo $sql;
		}
	}

	function pedido_novo_inserir($id = 0, $chk = '', $tipo = 2) {
		$this -> load -> model('pedidos');
		$idp = $this -> pedidos -> pedido_novo($id, $tipo);
		redirect(base_url('index.php/main/pedido_editar/' . $idp . '/' . checkpost_link($id)));
	}

	function pedido_editar($id) {
		$editar = 1;
		/* Load Model */
		$this -> load -> model('clientes');
		$this -> load -> model('pedidos');

		$data = $this -> pedidos -> le($id);
		$id_cliente = $data['pp_cliente'];
		$id_cliente_f = $data['pp_cliente_faturamento'];
		$client = $this -> clientes -> le($id_cliente);

		/* Salva item */
		$acao = get("acao");
		if (strlen($acao) > 0) {
			switch (get("dd1")) {
				case 'CONDICOES' :
					print_r($_POST);
					$dd0 = get("dd0");
					$cp = $this -> pedidos -> cp_condicoes($dd0, $id);
					$form = new form;
					$form -> id = $dd0;
					$form -> editar($cp, $this -> pedidos -> table);
					if ($form -> saved > 0) {
						redirect(base_url('index.php/main/pedido_editar/' . $id . '/' . checkpost_link($id)));
					}
					break;
			}

		}
		/***************************************************************************************************************************/

		$this -> cab();

		$data['dados_cliente'] = $this -> load -> view('cliente/show', $client, true);
		if ($data['pp_cliente_faturamento'] > 0) {
			$client_f = $this -> clientes -> le($id_cliente_f);
			$client_f['id_pp'] = $id;
			$client_f['editar'] = $editar;
			$data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento', $client_f, true);
		} else {
			$client_f['id_pp'] = $id;
			$client_f['editar'] = $editar;
			$data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento_sem', $client_f, true);
		}

		$data['id_pp'] = $id;
		$data['dados_item_form'] = $this -> pedidos -> form_item_novo(0, $id);
		$data['dados_item'] = $this -> pedidos -> pedido_items($id, $editar);
		$data['dados_proposta'] = $this -> load -> view('pedido/pedido_header', $data, true);
		$data['dados_item'] .= $this -> load -> view('pedido/pedido_item', $data, true);
		$data['dados_condicoes'] = $this -> pedidos -> pedido_condicoes($id, $editar);

		$data['contatos'] = $this -> pedidos -> contatos_do_pedido($id, $id_cliente, $editar);
		/* habilita cancelamento */
		$data['pp_situacao'] = 0;

		$data['dados_acoes'] = $this -> pedidos -> pedido_acoes($data);
		$this -> load -> view('pedido/pedido', $data);
	}

	function pedido_item_editar($id, $ped, $chk) {
		$this -> load -> model('pedidos');

		$data['nocab'] = true;
		$this -> cab($data);

		$cp = $this -> pedidos -> cp_item($id, $ped);
		$form = new form;
		$form -> id = $id;
		$tela = $form -> editar($cp, $this -> pedidos -> table_item);

		if ($form -> saved > 0) {
			$data['title'] = '';
			$data['content'] = '<script> wclose(); </script>';
			$this -> load -> view('content', $data);
		} else {
			$data['content'] = $tela;
			$data['title'] = '';
			$this -> load -> view('content', $data);
		}
	}

	function pedido($id, $chk = '') {
		$editar = 0;
		/* Load Model */
		$this -> load -> model('clientes');
		$this -> load -> model('pedidos');
		$this -> load -> model('ics');

		$data = $this -> pedidos -> le($id);
		$id_cliente = $data['pp_cliente'];
		$id_cliente_f = $data['pp_cliente_faturamento'];

		$client = $this -> clientes -> le($id_cliente);
		$this -> cab();

		$client['data'] = data_completa($data['pp_data']);

		$txt = $this -> ics -> busca('PED_' . $data['pp_tipo_pedido'], $client);
		$data['cab'] = $txt['nw_texto'];

		$data['dados_cliente'] = $this -> load -> view('cliente/show', $client, true);
		if ($data['pp_cliente_faturamento'] > 0) {
			$client_f = $this -> clientes -> le($id_cliente_f);
			$client_f['id_pp'] = $id;
			$client_f['editar'] = $editar;
			$data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento', $client_f, true);
		} else {
			$client_f['id_pp'] = $id;
			$client_f['editar'] = $editar;
			$data['dados_faturamento'] = $this -> load -> view('cliente/show_faturamento_sem', $client_f, true);
		}
		$data['dados_proposta'] = $this -> load -> view('pedido/pedido_header', $data, true);
		$data['id_pp'] = $id;
		$data['dados_item'] = $this -> pedidos -> pedido_items($id);
		$data['dados_acoes'] = $this -> pedidos -> pedido_acoes($data);

		//$data['dados_item'] .= $this -> load -> view('proposta/proposta_item', $data, true);
		$data['dados_condicoes'] = $this -> pedidos -> pedido_condicoes($id, $editar);
		$this -> load -> view('pedido/pedido', $data);
	}

	function cliente_faturamento($id, $chk = '') {
		$data = array();
		$data['clie_sel'] = $id;
		$data['clie_chk'] = $chk;
		$this -> session -> set_userdata($data);
		redirect(base_url('index.php/main/cliente_faturamento_sel'));
	}

	function cliente_faturamento_confirma($id = '', $chk = '') {
		$data['nocab'] = true;
		$this -> cab($data);
		$idc = $_SESSION['clie_sel'];
		$sql = "update pedido set pp_cliente_faturamento = " . round($id) . " where id_pp = " . round($idc);
		$this -> db -> query($sql);

		$data['content'] = '<script> wclose(); </script>';
		$data['title'] = 'Sucesso';
		$this -> load -> view('content', $data);
	}

	function cliente_faturamento_sel($npag = '') {
		/* Load Model */
		$this -> load -> model("clientes");
		if (!isset($_SESSION['clie_sel'])) {
			echo 'Erro de sessão';
			return ('');
		}
		$idc = $_SESSION['clie_sel'];
		$data['nocab'] = true;
		$this -> cab($data);

		$form = new form;

		$form -> fd = array('id_f', 'f_nome_fantasia', 'f_razao_social', 'f_estado');
		$form -> lb = array('id', msg('f_nome_fantasia'), msg('f_razao_social'), msg('f_estado'));
		$form -> mk = array('', 'L', 'L', 'L');
		$form -> pre_where = ' f_ativo = 1 ';

		$form -> tabela = $this -> clientes -> table;
		$form -> see = True;
		$form -> novo = false;
		$form -> edit = false;
		$form -> npag = $npag;

		$form -> row_view = base_url('index.php/main/cliente_faturamento_confirma/');
		$form -> row = base_url('index.php/main/cliente_faturamento_sel/');

		$data = array();
		$data['title'] = 'Clientes para faturamento';
		$data['content'] = row($form, $npag);
		$this -> load -> view('content', $data);

	}

	function confirmar_finalizar($id, $chk = '') {
		$this -> load -> model('pedidos');
		$this -> pedidos -> pedido_finalizar($id);
		redirect(base_url('index.php/main/menu_pedidos'));
	}

	/****************************************** CLIENTES *********************/
	function clientes($id = '') {
		/* Load Model */
		$this -> load -> model('clientes');

		/* Controller */
		$this -> cab();
		$data = array();
		$data['title'] = 'Clientes cadastrados';
		$data['content'] = $this -> clientes -> row();
		$this -> load -> view('content', $data);
	}

	function cliente($id = 0, $chk = '') {
		/* Load Model */
		$this -> load -> model('clientes');
		$this -> load -> model('mensagens');
		$this -> load -> model('pedidos');
		$this -> load -> model('financeiros');

		/* Controller */
		$this -> cab();
		$data = $this -> clientes -> le($id);

		$data['model'] = $this -> pedidos -> botao_novo_pedido($id);
		
		/* financeiro */
		$fin = $this -> financeiros -> resumo($id, 1);
		$data['finan_total'] = $fin['titulos'];
		$data['finan_valor'] = number_format($fin['total'],2,',','.');
		$data['financeiro'] = $this -> financeiros -> lista_por_cliente($id, 1);
		//$data['financeiro_resumo'] = $this -> financeiros -> resumo_cliente($id, 1);	

		/* orcamento / proposta */
		$data['orcamentos_total'] = $this -> pedidos -> resumo($id, 1);
		$data['orcamentos'] = $this -> pedidos -> lista_por_cliente($id, 1);
		$data['orcamentos'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

		/* pedido */
		$data['pedidos_total'] = $this -> pedidos -> resumo($id, 2);
		$data['pedidos'] = $this -> pedidos -> lista_por_cliente($id, 2);
		$data['pedidos'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

		/* locacao */
		$data['locacoes_total'] = $this -> pedidos -> resumo($id, 3);
		$data['locacao'] = $this -> pedidos -> lista_por_cliente($id, 3);
		$data['locacao'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

		/* onsite */
		$data['onsites_total'] = $this -> pedidos -> resumo($id, 5);
		$data['onsite'] = $this -> pedidos -> lista_por_cliente($id, 5);
		$data['onsite'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

		/* labo */
		$data['labos_total'] = $this -> pedidos -> resumo($id, 4);
		$data['labo'] = $this -> pedidos -> lista_por_cliente($id, 4);
		$data['labo'] .= $this -> load -> view('pedido/pedido_botao_novo', null, true);

		$data['contatos'] = $this -> clientes -> contatos($id);
		$data['contatos'] .= $this -> clientes -> novo_contato($id);
		$data['contatos_total'] = $this -> clientes -> contatos_total($id);

		$data['mensagens'] = $this -> mensagens -> mostra_mensagens($id);
		$data['mensagens'] .= $this -> mensagens -> nova_mensagem($id);
		$data['mensagens_total'] = $this -> mensagens -> mensagens_total($id);

		/* resumo */
		$data['resumo'] = $this -> load -> view('cliente/resumo', $data, true);

		$this -> load -> view('cliente/show', $data);
		$this -> load -> view('cliente/show_about', $data);
		$this -> footer();
	}

	function clientes_edit($id = 0, $chk = '') {
		/* Load Model */
		$this -> load -> model('clientes');

		/* Controller */
		$this -> cab();
		$saved = $this -> clientes -> editar($id, $chk);
		$this -> footer();

		/****************/
		if ($saved > 0) {
			redirect(base_url('index.php/main/clientes'));
		}
	}

	function cliente_contato_edit($id, $idc = 0) {
		$this -> load -> model('clientes');
		$param = array('nocab' => True);
		$this -> cab($param);

		/* EDIT */
		$form = new form;
		$form -> id = $id;
		$cp = $this -> clientes -> cp_contatos($id, $idc);
		$tela = $form -> editar($cp, $this -> clientes -> table_contatos);
		$tela = '<table width="100%"><tr><td>' . $tela . '</td></tr></table>';
		$data['content'] = $tela;
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			$data['content'] = '<script> wclose(); </script>';
			$this -> load -> view('content', $data);
		}
	}

	/************************************************************************* PRODUTOS CATEGORIA *****************/
	function locacao() {
		/* Load Model */
		$model = 'produtos';
		$this -> load -> model('produtos');

		/* Controller */
		$this -> cab();
		$data = array();

		$this -> load -> view('locacao/resumo', $data);
		$this -> footer();

	}

	/************************************************************************** PICTURE ***************************/
	function picture($id) {
		$data['nocab'] = true;
		$this -> cab($data);

		$this -> load -> model('geds');
		$this -> geds -> tabela = 'produto_doc_ged';
		$this -> geds -> page = base_url('index.php/main/picture/' . $id . '/PRODT');
		$this -> geds -> extension = array('.jpg', '.png');

		$this -> load -> model('produtos');
		$data = $this -> produtos -> le($id);

		$tela = $this -> geds -> form($id, '');
		$data['content_form'] = $tela;
		$data['title'] = '';
		$this -> load -> view('produto/picture', $data);
	}

	/************************************************************************* PRODUTOS ***************************/
	function produtos() {
		/* Load Model */
		$model = 'produtos';
		$this -> load -> model('produtos');

		/* Controller */
		$this -> cab();
		$data = array();
		$data['title'] = 'Cadastro de produtos';
		$data['content'] = $this -> $model -> row();
		$this -> load -> view('content', $data);
		$this -> footer();
	}

	function produtos_view($id) {
		/* Load Model */
		$model = 'produtos';
		$this -> load -> model('produtos');

		/* Controller */
		$this -> cab();
		$data = $this -> produtos -> le($id);

		$data['imagens'] = $this -> load -> view('produto/picture_slider', $data, true);

		$this -> load -> view('produto/view', $data);

		$data['row'] = $this -> produtos -> row_produtos($id);

		$this -> load -> view('produto/produtos_view', $data);

		$this -> footer();
	}

	function produtos_edit($id = 0, $chk = '') {
		$modal = 'produtos';
		/* Load Model */
		$this -> load -> model($modal);

		/* Controller */
		$this -> cab();
		$saved = $this -> $modal -> editar($id, $chk);
		$this -> footer();

		/****************/
		if ($saved > 0) {
			redirect(base_url('index.php/main/produtos'));
		}
	}

	/************************************************************************* PRODUTOS CATEGORIA *****************/
	function produtos_categoria() {
		/* Load Model */
		$model = 'produtos';
		$this -> load -> model('produtos');

		/* Controller */
		$this -> cab();
		$data = array();
		$data['title'] = 'Categorias de produtos';
		$data['content'] = $this -> $model -> row_categoria();
		$this -> load -> view('content', $data);
		$this -> footer();
	}

	function produtos_categoria_edit($id = 0, $chk = '') {
		$modal = 'produtos';
		/* Load Model */
		$this -> load -> model($modal);

		/* Controller */
		$this -> cab();
		$saved = $this -> $modal -> editar_categoria($id, $chk);
		$this -> footer();

		/****************/
		if ($saved > 0) {
			redirect(base_url('index.php/main/produtos_categoria'));
		}
	}

	function produtos_categoria_view($id, $chk) {
		/* Load Model */
		$model = 'produtos';
		$this -> load -> model($model);

		/* Controller */
		$this -> cab();
		$data = $this -> $model -> le_categoria($id);
		$this -> load -> view('categoria/show', $data);

		$data['title'] = '';
		$data['content'] = $this -> produtos -> lista_produtos_categoria($id);
		$data['content'] .= $this -> load -> view('produto/produto_novo', $data, True);

		$this -> load -> view('content', $data);
		$this -> footer();
	}

	/************************************************************************* PRODUTOS MARC *****************/
	function produtos_marca() {
		/* Load Model */
		$model = 'produtos';
		$this -> load -> model('produtos');

		/* Controller */
		$this -> cab();
		$data = array();
		$data['title'] = 'Marca dos produtos';
		$data['content'] = $this -> $model -> row_marcas();
		$this -> load -> view('content', $data);
		$this -> footer();
	}

	function produtos_marca_edit($id = 0, $chk = '') {
		$modal = 'produtos';
		/* Load Model */
		$this -> load -> model($modal);

		/* Controller */
		$this -> cab();
		$saved = $this -> $modal -> editar_marca($id, $chk);
		$this -> footer();

		/****************/
		if ($saved > 0) {
			redirect(base_url('index.php/main/produtos_marca'));
		}
	}

	function produtos_marca_view($id, $chk) {
		/* Load Model */
		$model = 'produtos';
		$this -> load -> model($model);

		/* Controller */
		$this -> cab();
		$data = $this -> $model -> le_marca($id);
		$this -> load -> view('marca/show', $data);
	}

	function myaccount() {
		$id = $_SESSION['id'];

		$this -> cab();
		$data['title'] = '';
		$data['content'] = $this -> users -> my_account($id);
		$this -> load -> view('content', $data);
	}

	function change_password() {
		$id = $_SESSION['id'];

		$this -> cab();
		$data['title'] = '';

		$data['content'] = $this -> users -> change_password($id);
		$this -> load -> view('content', $data);
	}

	function change_my_sign() {
		$id = $_SESSION['id'];

		$this -> cab();
		$data['title'] = '';

		$data['content'] = $this -> users -> change_sign($id);
		$this -> load -> view('content', $data);
	}

	function produto_item($id = '') {
		$this -> load -> model('produtos');
		$data['nocab'] = true;
		$this -> cab($data);

		$cp = $this -> produtos -> cp_item_patrimonio();
		$form = new form;
		$form -> id = $id;
		$tela = $form -> editar($cp, $this -> produtos -> table);
		$_POST['dd2'] = get("prod");

		if ($form -> saved > 0) {
			$data['title'] = '';
			$data['content'] = '<script> wclose(); </script>';
			$this -> load -> view('content', $data);
		} else {
			$data['content'] = $tela;
			$data['title'] = '';
			$this -> load -> view('content', $data);
		}
	}

	function produto_view($id = '') {
		/* Load Model */
		$model = 'produtos';
		$this -> load -> model('produtos');

		/* Controller */
		$this -> cab();
		$data = $this -> produtos -> le_produto($id);

		$data['imagens'] = $this -> load -> view('produto/picture_slider', $data, true);

		$this -> load -> view('produto/view', $data);

		$data['row'] = $this -> produtos -> row_produtos($id);

		$this -> load -> view('produto/produtos_detalhes', $data);

		$data['content'] = 'x';
		$data['title'] = 'Histórico do produto';
		$this -> load -> view('content', $data);

		$this -> footer();
	}

	/********************************* mensagem *********************/
	function cliente_mensagem_edit($id, $cliente) {
		$this -> load -> model('mensagens');
		$this -> load -> model('clientes');

		$data['nocab'] = true;
		$this -> cab($data);

		$cp = $this -> mensagens -> cp($cliente);
		$form = new form;
		$form -> id = $id;
		$data['content'] = $form -> editar($cp, $this -> mensagens -> table);
		$data['title'] = msg('mensagens');
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			if (get("dd5") == '1') {
				$assunto = utf8_decode(get("dd3"));
				$text = utf8_decode(get("dd4"));
				$de = 1;
				$anexos = array();
				$this -> clientes -> enviaremail_cliente($cliente, $assunto, $text, $de, $anexos);
			}
			$data['content'] .= '<script> wclose(); </script>';
			$this -> load -> view('content', $data);
		}
	}
/************** prazo de entrega ************************/
	function prazo_entrega($npag = '') {
		$model = 'prazos_entrega';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$form = $this->$model->row($form);

		$form -> tabela = $this -> $model -> table;
		$form -> see = False;
		$form -> novo = true;
		$form -> edit = true;
		$form -> npag = $npag;

		$form -> row = base_url('index.php/main/'.$model.'/');
		$form -> row_edit = base_url('index.php/main/'.$model.'_edit/');

		$data = array();
		$data['title'] = msg('tit_'.$model);
		$data['content'] = row($form, $npag);
		$this -> load -> view('content', $data);
	}
	
	function prazos_entrega_edit($id = '', $chk = '') {
		$model = 'prazos_entrega';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$cp = $this->$model->cp($id);
		$form->cp = $cp;
		
		$form -> tabela = $this -> $model -> table;
		$form->id = $id;
		
		$data['content'] = $form->editar($cp,$form -> tabela);

		$data['title'] = msg('tit_'.$model);
		$this -> load -> view('content', $data);
		
		if ($form->saved > 0)
			{
				redirect(base_url('index.php/main/prazo_entrega'));
			}
	}
	
/************** prazo de garantia ************************/
	function prazo_garantia($npag = '') {
		$model = 'prazos_garantia';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$form = $this->$model->row($form);

		$form -> tabela = $this -> $model -> table;
		$form -> see = False;
		$form -> novo = true;
		$form -> edit = true;
		$form -> npag = $npag;

		$form -> row = base_url('index.php/main/'.$model.'/');
		$form -> row_edit = base_url('index.php/main/'.$model.'_edit/');

		$data = array();
		$data['title'] = msg('tit_'.$model);
		$data['content'] = row($form, $npag);
		$this -> load -> view('content', $data);
	}
	
	function prazos_garantia_edit($id = '', $chk = '') {
		$model = 'prazos_garantia';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$cp = $this->$model->cp($id);
		$form->cp = $cp;
		$form->id = $id;
		
		$form -> tabela = $this -> $model -> table;
		
		$data['content'] = $form->editar($cp,$form -> tabela);

		$data['title'] = msg('tit_'.$model);
		$this -> load -> view('content', $data);
		
		if ($form->saved > 0)
			{
				redirect(base_url('index.php/main/prazo_garantia'));
			}
	}
/************** prazo_montagem ************************/
	function prazo_montagem($npag = '') {
		$model = 'prazos_montagem';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$form = $this->$model->row($form);

		$form -> tabela = $this -> $model -> table;
		$form -> see = False;
		$form -> novo = true;
		$form -> edit = true;
		$form -> npag = $npag;

		$form -> row = base_url('index.php/main/'.$model.'/');
		$form -> row_edit = base_url('index.php/main/'.$model.'_edit/');

		$data = array();
		$data['title'] = msg('tit_'.$model);
		$data['content'] = row($form, $npag);
		$this -> load -> view('content', $data);
	}
	
	function prazos_montagem_edit($id = '', $chk = '') {
		$model = 'prazos_montagem';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$cp = $this->$model->cp($id);
		$form->cp = $cp;
		
		$form -> tabela = $this -> $model -> table;
		$form->id = $id;
		
		$data['content'] = $form->editar($cp,$form -> tabela);

		$data['title'] = msg('tit_'.$model);
		$this -> load -> view('content', $data);
		
		if ($form->saved > 0)
			{
				redirect(base_url('index.php/main/prazo_montagem'));
			}
	}
	
/************** pedido_validade ************************/
	function pedido_validade($npag = '') {
		$model = 'pedidos_validade';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$form = $this->$model->row($form);

		$form -> tabela = $this -> $model -> table;
		$form -> see = False;
		$form -> novo = true;
		$form -> edit = true;
		$form -> npag = $npag;

		$form -> row = base_url('index.php/main/'.$model.'/');
		$form -> row_edit = base_url('index.php/main/'.$model.'_edit/');

		$data = array();
		$data['title'] = msg('tit_'.$model);
		$data['content'] = row($form, $npag);
		$this -> load -> view('content', $data);
	}
	
	function pedidos_validade_edit($id = '', $chk = '') {
		$model = 'pedidos_validade';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$cp = $this->$model->cp($id);
		$form->cp = $cp;
		
		$form -> tabela = $this -> $model -> table;
		$form->id = $id;
		
		$data['content'] = $form->editar($cp,$form -> tabela);

		$data['title'] = msg('tit_'.$model);
		$this -> load -> view('content', $data);
		
		if ($form->saved > 0)
			{
				redirect(base_url('index.php/main/pedido_validade'));
			}
	}	
/************** condicoes_pagamento ************************/
	function condicoes_pagamento($npag = '') {
		$model = 'condicoes_pagamento';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$form = $this->$model->row($form);

		$form -> tabela = $this -> $model -> table;
		$form -> see = False;
		$form -> novo = true;
		$form -> edit = true;
		$form -> npag = $npag;

		$form -> row = base_url('index.php/main/'.$model.'/');
		$form -> row_edit = base_url('index.php/main/'.$model.'_edit/');

		$data = array();
		$data['title'] = msg('tit_'.$model);
		$data['content'] = row($form, $npag);
		$this -> load -> view('content', $data);
	}
	
	function condicoes_pagamento_edit($id = '', $chk = '') {
		$model = 'condicoes_pagamento';
		$this -> load -> model($model);
		/* Load Model */
		$this -> cab();
		
		$form = new form;
		$cp = $this->$model->cp($id);
		$form->cp = $cp;
		
		$form -> tabela = $this -> $model -> table;
		$form->id = $id;
		
		$data['content'] = $form->editar($cp,$form -> tabela);

		$data['title'] = msg('tit_'.$model);
		$this -> load -> view('content', $data);
		
		if ($form->saved > 0)
			{
				redirect(base_url('index.php/main/condicoes_pagamento'));
			}
	}	
}
?>
