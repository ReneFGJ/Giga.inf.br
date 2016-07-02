<?php
class Cx extends CI_Controller {
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

	function index() {
		$this -> cab();
		$this -> load -> view('home', null);
		$this -> footer();
	}
	
	function caixa()
		{
		$this->load->model('financeiros');
		$dia = date("Y-m-d");
		$this -> cab();
		$tela = $this->financeiros->caixa_dia($dia);
		$data['content'] = $tela;
		$data['title'] = '';
		$this->load->view('content',$data);
		
		$this -> footer();			
		}
}
?>
