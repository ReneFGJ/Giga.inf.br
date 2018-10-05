<?php
class Export extends CI_Controller {
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

		$data = array();
		$data['js'] = $js;
		$data['css'] = $css;

		$data['title'] = ':: Giga Informática ::';
		$this -> load -> view('header/header', $data);
		$this -> load -> view('menus/menu_cab_top', $data);

		$this -> load -> model('users');
		$this -> users -> security();
	}

	function footer() {
		$this -> load -> view('header/footer', null);
	}

	function index($tipo='') {
		$this -> cab();
		switch($tipo)
			{
			case 'clientes':
				$this->load->model('clientes');
				$this->clientes->export();				
				break;
			case 'funcionarios':
				break;
			}		
		$this -> footer();
	}
	
}
?>
