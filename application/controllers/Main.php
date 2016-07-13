<?php
class Main extends CI_Controller {
	function __construct() {
		global $dd, $acao;
		parent::__construct();
		$this -> lang -> load("app", "portuguese");
		$this -> load -> helper('form_sisdoc');

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

		if (!(isset($data['nocab'])))
			{
				$this -> load -> view('menus/menu_cab_top', $data);
			}

		$this -> load -> model('users');
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
	function menu_pedidos() {
		$id_us = $_SESSION['id'];
		$model = "propostas";
		$this -> load -> model($model);

		$this -> cab();
		$tela = $this -> $model -> propostas_abertas($id_us);
		$data['title'] = 'Propostas Abertas';
		$data['content'] = $tela;
		$this -> load -> view('content', $data);
		$this -> footer();
	}

	/****************************************** PROPOSTA *********************/
	function proposta_nova_inserir($id = 0) {
		$this -> load -> model('propostas');
		$idp = $this -> propostas -> proposta_nova($id);
		redirect(base_url('index.php/main/proposta_editar/' . $idp . '/' . checkpost_link($id)));
	}

	function proposta_editar($id) {
		$editar = 1;
		/* Load Model */
		$this -> load -> model('clientes');
		$this -> load -> model('propostas');

		$data = $this -> propostas -> le($id);
		$id_cliente = $data['pp_cliente'];

		/* Salva item */
		$acao = get("acao");
		if (strlen($acao) > 0) {
			switch (get("dd1")) {
				case 'ITEM' :
					$dd0 = get("dd0");
					$cp = $this -> propostas -> cp_item($dd0, $id);
					$form = new form;
					$form -> id = $dd0;
					$form -> editar($cp, $this -> propostas -> table_item);
					break;
				case 'CONDICOES' :
					print_r($_POST);
					$dd0 = get("dd0");
					$cp = $this -> propostas -> cp_condicoes($dd0, $id);
					$form = new form;
					$form -> id = $dd0;
					$form -> editar($cp, $this -> propostas -> table);
			}
			redirect(base_url('index.php/main/proposta_editar/' . $id . '/' . checkpost_link($id)));
		}
		/***************************************************************************************************************************/
		$client = $this -> clientes -> le($id_cliente);
		$this -> cab();
		$data['dados_cliente'] = $this -> load -> view('cliente/show', $client, true);

		$data['id_pp'] = $id;
		$data['dados_item_form'] = $this -> propostas -> form_item_novo(0, $id);
		$data['dados_item'] = $this -> propostas -> proposta_items($id, $editar);
		$data['dados_proposta'] = $this -> load -> view('proposta/proposta_header', $data, true);
		$data['dados_item'] .= $this -> load -> view('proposta/proposta_item', $data, true);
		$data['dados_condicoes'] = $this -> propostas -> proposta_condicoes($id, $editar);
		$data['dados_acoes'] = $this -> propostas -> proposta_acoes($data);
		$this -> load -> view('proposta/proposta', $data);
	}

	function proposta($id, $chk = '') {
		$editar = 0;
		/* Load Model */
		$this -> load -> model('clientes');
		$this -> load -> model('propostas');

		$data = $this -> propostas -> le($id);
		$id_cliente = $data['pp_cliente'];

		$client = $this -> clientes -> le($id_cliente);
		$this -> cab();
		$data['dados_cliente'] = $this -> load -> view('cliente/show', $client, true);
		$data['dados_proposta'] = $this -> load -> view('proposta/proposta_header', $data, true);
		$data['id_pp'] = $id;
		$data['dados_item'] = $this -> propostas -> proposta_items($id);
		$data['dados_acoes'] = $this -> propostas -> proposta_acoes($data);

		//$data['dados_item'] .= $this -> load -> view('proposta/proposta_item', $data, true);
		$data['dados_condicoes'] = $this -> propostas -> proposta_condicoes($id, $editar);
		$this -> load -> view('proposta/proposta', $data);
	}

	function proposta_finalizar($id,$chk='')
		{
			$this -> load -> model('propostas');
			$this->propostas->proposta_finalizar($id);
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
		$this -> load -> model('propostas');

		/* Controller */
		$this -> cab();
		$data = $this -> clientes -> le($id);

		/* orcamento / proposta */
		$data['orcamentos_total'] = $this -> propostas -> resumo($id);
		$data['orcamentos'] = $this -> propostas -> lista_por_cliente($id);
		$data['orcamentos'] .= $this -> propostas -> botao_nova_proposta($id);

		$data['contatos'] = $this -> clientes -> contatos($id);
		$data['contatos'] .= $this -> clientes -> novo_contato($id);
		$data['contatos_total'] = $this -> clientes -> contatos_total($id);
		
		$data['mensagens'] = $this -> mensagens -> mostra_mensagens($id);
		$data['mensagens'] .= $this -> mensagens -> nova_mensagem($id);
		$data['mensagens_total'] = $this -> mensagens -> mensagens_total($id);		

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
	
	function cliente_contato_edit($id,$idc=0)
		{
			$this->load->model('clientes');
			$param = array('nocab'=>True);
			$this->cab($param);
			
			/* EDIT */
			$form = new form;
			$form->id = $id;
			$cp = $this->clientes->cp_contatos($id,$idc);
			$tela = $form->editar($cp,$this->clientes->table_contatos);
			$tela = '<table width="100%"><tr><td>'.$tela.'</td></tr></table>';
			$data['content'] = $tela;
			$data['title'] = '';
			$this->load->view('content',$data);
			
			if ($form->saved > 0)
				{
					$data['content'] = '<script> wclose(); </script>';
					$this->load->view('content',$data);
				}
		}

	/************************************************************************* PRODUTOS CATEGORIA *****************/
	function estoque() {
		/* Load Model */
		$model = 'produtos';
		$this -> load -> model('produtos');

		/* Controller */
		$this -> cab();

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
		$this -> load -> model('users');

		$this -> cab();
		$data['title'] = '';
		$data['content'] = $this -> users -> my_account($id);
		$this -> load -> view('content', $data);
	}

}
?>
