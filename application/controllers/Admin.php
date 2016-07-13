<?php
class Admin extends CI_controller {
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

	function fc($op = '') {
		if ($op == 'install') {
			$this -> load -> model('users');
			$this -> users -> create_admin_user();
		}
	}
	/*********************************************************************** USERS *********************/
	function users() {
		/* Load Model */
		$model = 'users';
		$this -> load -> model($model);
		
		/* Controller */
		$this -> cab();
		$data = array();
		$data['title'] = 'Usuários do sistema';
		$data['content'] = $this -> $model -> row();
		$this -> load -> view('content', $data);
	}
	
	function user_edit($id = 0, $chk = '') {
		/* Load Model */
		$model = 'users';
		$this -> load -> model($model);

		/* Controller */
		$this -> cab();
		$saved = $this -> $model -> editar($id, $chk);
		$this -> footer();

		/****************/
		if ($saved > 0) {
			$this->$model->updatex();
			redirect(base_url('index.php/admin/users'));
		}
	}
	
	/*********************************************************************** MATRIZ E FILIAIS *********************/
	function filiais() {
		/* Load Model */
		$model = 'empresas';
		$this -> load -> model($model);
		
		/* Controller */
		$this -> cab();
		$data = array();
		$data['title'] = 'Matriz e Filiais';
		$data['content'] = $this -> $model -> row();
		$this -> load -> view('content', $data);
	}
	
	function filiais_edit($id = 0, $chk = '') {
		/* Load Model */
		$model = 'empresas';
		$this -> load -> model($model);

		/* Controller */
		$this -> cab();
		$saved = $this -> $model -> editar($id, $chk);
		$this -> footer();

		/****************/
		if ($saved > 0) {
			$this->$model->updatex();
			redirect(base_url('index.php/admin/filiais'));
		}
	}

	function user($id,$chk='')
		{
			$this->load->model('users');
			$this -> cab();
			$data['title'] = '';
			$data['content'] = $this->users->my_account($id);
			$this->load->view('content',$data);
		}
}
?>
