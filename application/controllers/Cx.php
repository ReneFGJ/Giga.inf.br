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
	function cpagar($dia='')
		{
		$this->load->model('financeiros');
		if (strlen($dia) == 0)
			{
				$dia = date("Ymd");
			}
		$this -> cab();
		$this->load->view('financeiro/navbar_cx',null);
		$tela = $this->financeiros->contas_pagar($dia);
		$data['content'] = $tela;
		$data['title'] = '';
		$this->load->view('content',$data);
		
		$this -> footer();			
		}
	function cpagar_quitar($id=0,$chk='')
		{
			$this->load->model('financeiros');
			$data = array();
			$data['nocab'] = true;
			$this->cab($data);
			$cp = $this->financeiros->cp_cpagar_quitar();
			$form = new form;
			$form->id = $id;
			$data['content'] = $form->editar($cp,$this->financeiros->table_pagar);
			$data['title'] = '';
			$this->load->view('content',$data);

			if ($form->saved > 0)
				{
					echo '
					<script> 
						window.opener.location.reload();
						close();
					</script>';
					return('');
				}
		}
}
?>
