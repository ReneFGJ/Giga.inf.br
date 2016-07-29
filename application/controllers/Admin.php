<?php
class Admin extends CI_controller {
	function __construct() {
		global $dd, $acao;
		parent::__construct();
		$this -> lang -> load("app", "portuguese");
		$this -> load -> helper('form_sisdoc');
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

	function fc($op = '') {
		if ($op == 'install') {
			$this -> users -> create_admin_user();
		}
	}

	/********************************************************************** perfil *********************/
	function perfil($id = '', $chk = '') {
		/* Load Models */
		$this -> load -> model('logins');

		$this -> cab();
		$data = array();

		$form = new form;
		$form -> tabela = $this -> logins -> table_perfil;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = true;
		$form = $this -> logins -> row_perfil($form);

		$form -> row_edit = base_url('index.php/admin/perfil_edit');
		$form -> row_view = base_url('index.php/perfil/view');
		$form -> row = base_url('index.php/perfil');

		$tela['tela'] = row($form, $id);

		$this -> load -> view('form/form', $tela);
	}

	function perfil_edit($id = 0, $check = '') {
		/* Load Models */
		$this -> load -> model('logins');
		$cp = $this -> logins -> cp_perfil();
		$data = array();

		$this -> cab();

		$form = new form;
		$form -> id = $id;

		$tela = $form -> editar($cp, $this -> logins -> table_perfil);
		$data['title'] = msg('Label_editar_perfil');
		$data['tela'] = $tela;
		$this -> load -> view('form/form', $data);

		/* Salva */
		if ($form -> saved > 0) {
			redirect(base_url('index.php/admin/perfil'));
		}
	}

	function logins($id = 0) {
		$this -> load -> model('logins');
		$this -> cab();
		$data = array();

		$form = new form;
		$form -> tabela = $this -> logins -> tabela;
		$form -> see = true;
		$form = $this -> logins -> row($form);

		$form -> row_edit = base_url('index.php/admin/logins_edit/');
		$form -> row_view = base_url('index.php/admin/logins_view/');
		$form -> row = base_url('index.php/admin/logins/');

		$tela['tela'] = row($form, $id);
		$url = base_url('author');

		$tela['title'] = $this -> lang -> line('title_admin');

		$this -> load -> view('form/form', $tela);
	}

	function logins_view($id = 0, $check = '', $act = '', $id_act = 0) {
		/* Load Models */
		$this -> load -> model('logins');

		$this -> cab();

		/* Se acao EXCLUIR */
		if ($act == 'del') {
			$data = $this -> logins -> perfil_desassociar($id_act);
		}

		$data = array();

		if (!checkpost_link($id) == $check) {
			redirect("index.php/main");
		}

		$data = $this -> logins -> le($id);
		$this -> load -> view('auth_social/login_show', $data);

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
			$this -> $model -> updatex();
			redirect(base_url('index.php/admin/users'));
		}
	}

	/*********************************************************************** MATRIZ E FILIAIS *********************/
	function filial($id = 0) {
		/* Load Model */
		$model = 'empresas';
		$this -> load -> model($model);

		$data = $this -> $model -> le($id);

		/* Controller */
		$this -> cab();
		$data['title'] = $data['fi_nome_fantasia'];
		$data['content'] = $this -> load -> view('empresa/view', $data, true);
		$this -> load -> view('content', $data);
	}

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
			$this -> $model -> updatex();
			redirect(base_url('index.php/admin/filiais'));
		}
	}

	function user($id, $chk = '') {
		$this -> cab();
		$data['title'] = '';
		$data['content'] = $this -> users -> my_account($id);
		$this -> load -> view('content', $data);
	}

	/***************************** comunicacao ***************************************/
	function mensagens_edit($id = 0, $chk = '') {
		/* Load Models */
		$this -> load -> model('ics');
		$cp = $this -> ics -> cp();

		$this -> cab();
		$data = array();

		$form = new form;
		$form -> id = $id;

		$tela = $form -> editar($cp, $this -> ics -> tabela);
		$data['title'] = msg('mensagens_title');
		$data['tela'] = $tela;
		$this -> load -> view('form/form', $data);

		/* Salva */
		if ($form -> saved > 0) {
			redirect(base_url('index.php/admin/comunicacao_1'));
		}
	}

	function comunicacao_1($id = 0, $gr = 0, $tp = 0) {
		/* Load Models */
		$this -> load -> model('ics');

		$this -> cab();
		$data = array();

		/* Lista de Mensagens do Sistema */
		$form = new form;
		$form -> tabela = $this -> ics -> tabela;
		$form -> see = true;
		$form -> edit = true;
		$form -> novo = true;
		$form -> order = ' nw_ref ';
		$form = $this -> ics -> row($form);

		$form -> row_edit = base_url('index.php/admin/mensagens_edit');
		$form -> row_view = '';
		$form -> row = base_url('index.php/admin/comunicacao_1/');

		$data['content'] = row($form, $id);
		$data['title'] = msg('messagem_cadastradas');

		$this -> load -> view('content', $data);

	}

}
?>
