<?php
class Financeiro extends CI_Controller {
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

		if (!(isset($data['nocab']))) {
			$this -> load -> view('menus/menu_cab_top', $data);
		} else {
			$this -> load -> view('menus/no_cab_top', $data);
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

	function caixa() {
		$this -> load -> model('financeiros');
		$dia = date("Y-m-d");
		$this -> cab();
		$tela = $this -> financeiros -> caixa_dia($dia);
		$data['content'] = $tela;
		$data['title'] = '';
		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function cpagar($dia = '') {
		$this -> load -> model('financeiros');

		/* Importar */
		//$this->load->model('imports');
		//$this->imports->cpagar();

		if (strlen($dia) == 0) {
			$dia = date("Ymd");
		}
		$this -> cab();
		$data['date'] = $dia;
		$data['saldo'] = $this -> financeiros -> saldo_dia($dia, 1);
		$this -> load -> view('financeiro/navbar_cx', $data);
		$tela = $this -> financeiros -> contas_pagar($dia);
		$data['content'] = $tela;
		$data['title'] = '';
		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function creceber($dia = '') {
		$this -> load -> model('financeiros');

		/* Importar */
		$this -> load -> model('imports');
		//$this->imports->creceber();

		if (strlen($dia) == 0) {
			$dia = date("Ymd");
		}
		$this -> cab();
		$data['date'] = $dia;
		$data['saldo'] = $this -> financeiros -> saldo_dia($dia, 2);
		$this -> load -> view('financeiro/navbar_cr_cx', $data);
		$tela = $this -> financeiros -> contas_receber($dia);
		$data['content'] = $tela;
		$data['title'] = '';
		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function creceber_quitar($id = 0, $chk = '') {
		$this -> load -> model('financeiros');
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_creceber_quitar();
		$form = new form;
		$form -> id = $id;
		$data['content'] = $form -> editar($cp, $this -> financeiros -> table_receber);
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function cpagar_quitar($id = 0, $chk = '') {
		$this -> load -> model('financeiros');
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_cpagar_quitar();
		$form = new form;
		$form -> id = $id;
		$data['content'] = $form -> editar($cp, $this -> financeiros -> table_pagar);
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function cpagar_edit($id = '', $chk = '') {
		$this -> load -> model('financeiros');
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_cpagar_editar();
		$form = new form;
		$form -> id = $id;
		$_POST['dd10'] = get("dd9");
		$data['content'] = $form -> editar($cp, $this -> financeiros -> table_pagar);
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	function creceber_edit($id = '', $chk = '') {
		$this -> load -> model('financeiros');
		$data = array();
		$data['nocab'] = true;
		$this -> cab($data);
		$cp = $this -> financeiros -> cp_creceber_editar();
		$form = new form;
		$form -> id = $id;
		$_POST['dd10'] = get("dd9");
		$data['content'] = $form -> editar($cp, $this -> financeiros -> table_receber);
		$data['title'] = '';
		$this -> load -> view('content', $data);

		if ($form -> saved > 0) {
			echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
			return ('');
		}
	}

	/***************** FISCAL ***********************/
	function fiscal($id = 0) {
		$id = 1;
		$this -> load -> model('invoices');
		$data = array();
		$data = $this -> invoices -> le($id);

		$this -> load -> view('financeiro/invoice_locacao', $data);
	}

	function cpagar_search() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('contas_pagar');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$S80', '', 'Nome do fornecedor', false, true));
		array_push($cp, array('$H', '', '', false, true));
		array_push($cp, array('$D8', '', 'Vencimento inicial', false, true));
		array_push($cp, array('$D8', '', 'Vencimento final', false, true));
		array_push($cp, array('$S20', '', 'Nº boleto', false, true));
		$data['content'] = $form -> editar($cp, '');
		$this -> load -> view('financeiro/search', $data);

		if ($form -> saved > 0) {
			$sx = $this -> financeiros -> busca(1);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function creceber_search() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = msg('contas_receber');
		$form = new form;
		$cp = array();
		array_push($cp, array('$H8', '', '', false, true));
		array_push($cp, array('$S80', '', 'Nome do cliente', false, true));
		array_push($cp, array('$H', '', '', false, true));
		array_push($cp, array('$D8', '', 'Vencimento inicial', false, true));
		array_push($cp, array('$D8', '', 'Vencimento final', false, true));
		array_push($cp, array('$S20', '', 'Nº boleto', false, true));
		$data['content'] = $form -> editar($cp, '');
		$this -> load -> view('financeiro/search', $data);

		if ($form -> saved > 0) {
			$sx = $this -> financeiros -> busca(2);
			$data['content'] = $sx;
			$this -> load -> view('content', $data);
		}
		$this -> footer();
	}

	function relatorio() {
		$this -> load -> model('financeiros');

		$this -> cab();
		$data['title'] = '';
		$menu = array();
		$data['title_menu'] = 'Relatórios';
		array_push($menu, array('Contas a Receber', '__Clientes em aberto', 'ITE', '/financeiro/creceber_abertos'));
		$data['menu'] = $menu;
		$data['content'] = $this -> load -> view('header/main_menu', $data, true);

		$this -> load -> view('content', $data);

		$this -> footer();
	}

	function creceber_abertos() {
		$this -> load -> model('financeiros');

		$this -> cab();


		$this -> footer();
	}

}
?>
