<?php
class Import extends CI_Controller {
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

	function index() {
		$this -> cab();
		$this -> load -> view('menus/menu_import', null);
		$this -> footer();
	}
	
	function cpagar() {
		$this -> cab();
		$this->load->model("imports");
		
		$this->imports->cpagar();
		
		$this -> footer();
	}
	
	function creceber() {
		$this -> cab();
		$this->load->model("imports");
		
		$this->imports->creceber();
		
		$this -> footer();
	}
		
	function usuarios() {
		$this -> cab();
		$this->load->model("imports");
		
		$this->imports->usuarios();
		
		$this -> footer();
	}
	function fornecedores() {
		$this -> cab();
		$this->load->model("imports");
		
		$data['content'] = $this->imports->fornecedores();
		$data['title'] = '';
		$this->load->view('content',$data);
		
		$this -> footer();
	}			
}
?>
