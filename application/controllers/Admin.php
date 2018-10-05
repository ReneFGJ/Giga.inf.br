<?php
class Admin extends CI_controller {
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

    function fc($op = '') {
        if ($op == 'install') {
            $this -> users -> create_admin_user();
        }
    }
	
	function export($tipo='') {
		
		switch($tipo)
			{
			case 'clientes':	
				$this->load->model('clientes');
				$this->clientes->export();				
				break;
			case 'funcionarios':
				break;
			default:
				$this -> cab();
			}		
		$this -> footer();
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

    /********************************************************************** perfil *********************/
    function contato_tipo($id = '', $chk = '') {
        /* Load Models */
        $this -> load -> model('clientes');

        $this -> cab();
        $data = array();

        $tela['tela'] = $this -> clientes -> row_contatos_tipo($id);
        $this -> load -> view('form/form', $tela);
    }

    function contato_tipo_edit($id = 0, $check = '') {
        /* Load Models */
        $this -> load -> model('clientes');
        $cp = $this -> clientes -> cp_contatos_tipo();
        $data = array();

        $this -> cab();

        $form = new form;
        $form -> id = $id;

        $tela = $form -> editar($cp, $this -> clientes -> table_contatos_tipo);
        $data['title'] = msg('clientes');
        $data['tela'] = $tela;
        $this -> load -> view('form/form', $data);

        /* Salva */
        if ($form -> saved > 0) {
            redirect(base_url('index.php/admin/contato_tipo'));
        }
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
    function users($id = 0) {
        /* Load Model */
        $model = 'users';
        $this -> load -> model($model);

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Usuários do sistema';
        $data['content'] = 'Relatórios: <a href="' . base_url('index.php/admin/users_list') . '">funcionários</a> |';
        $data['content'] .= $this -> $model -> row($id);
        $this -> load -> view('content', $data);
    }

    function users_list($id = '') {
        /* Load Model */
        $model = 'users';
        $this -> load -> model($model);

        /* Controller */
        $this -> cab();
        $data = array();
        $data['title'] = 'Funcionários';
        $data['content'] = $this -> $model -> user_list($id);
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

    function image($tp = '', $id = '') {
        /* Controller */
        $data['nocab'] = true;
        $this -> cab($data);

        $tela = '<form method="post" enctype="multipart/form-data">
                    Select image to upload:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload Image" name="submit">
                </form>';
        $data['title'] = 'Updaload de Imagem';

        $target_dir = "img/logo/";
        switch($tp)
            {
            case '1':
                $target_file = $target_dir . strzero($id, 4) . '_logo.jpg';
                break;
            case '2':
                $target_file = $target_dir . strzero($id, 3) . '_carimbo-logo.jpg';
                break;
            default:
                echo "OPS, Erro de tipo";
                exit;        
            }
        
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $tela = "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $tela .=  "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                } else {
                    $tela .=  "Sorry, there was an error uploading your file.";
                }

            } else {
                $tela = "File is not an image.";
                $uploadOk = 0;
            }
        }
        $data['content'] = $tela;
        $this -> load -> view('content', $data);
    }

    /*********************************************************************** MATRIZ E FILIAIS *********************/
    function filial($id = 0) {
        /* Load Model */
        $this -> load -> model('Users');

        $model = 'empresas';
        $this -> load -> model($model);

        $data = $this -> $model -> le($id);

        /* Controller */
        $this -> cab();
        $data['title'] = $data['fi_nome_fantasia'];
        $data['content'] = $this -> load -> view('empresa/view', $data, true);
        $this -> load -> view('content', $data);

        /************** cabecalho */
        $data['title'] = 'Cabeçalhos';
        $tela = '<table width="100%">';
        $tela .= '<tr valign="top">';
        $tela .= '<td width="50%">';
        $link = '<a href="#" onclick="newxy(\'' . base_url('index.php/admin/image/1/' . $id) . '\',800,600);">';
        $tela .= $link . 'uploda de imagem' . '</a><br>';
        $tela .= '<img src="' . base_url('img/logo/' . strzero($id, 4) . '_logo.jpg') . '">';
        $tela .= '</td>';
        $tela .= '<td width="50%">';
        $link = '<a href="#" onclick="newxy(\'' . base_url('index.php/admin/image/2/' . $id) . '\',800,600);">';
        $tela .= $link . 'uploda de imagem' . '</a><br>';
        $tela .= '<img height="200" src="' . base_url('img/logo/' . strzero($id, 3) . '_carimbo-logo.jpg') . '">';
        $tela .= '</td>';
        $tela .= '</tr>';
        $tela .= '</table>';

        $data['content'] = $tela;
        $this -> load -> view('content', $data);

        $data['title'] = 'Funcionários';
        $data['content'] = $this -> users -> user_list($id);
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
        $this -> load -> model('users');
        $this -> users -> le($id);

        $this -> cab();
        $data['title'] = '';
        $data['content'] = $this -> users -> my_account($id);

        $tela = '';
        $data['content'] .= $tela;
        $this -> load -> view('content', $data);
    }

    function user_drh_edit($id = '', $chk = '') {
        if (strlen($id) == 0) {
            $id = $_SESSION['id'];
            $chk = checkpost_link($id);
        }

        $this -> load -> model('users');
        $this -> load -> model('user_drh');
        $this -> cab();
        $data = $this -> users -> le($id);
        $data['title'] = '';

        $tela = 'Acesso não permitido!';
        if ((perfil("#ADM#DRH")) or ($id == $_SESISSION['id'])) {
            $tabela = 'user_drh';
            $cp = $this -> user_drh -> cp($id);
            $form = new form;
            $form -> id = $id;

            $tela = $this -> load -> view('user/user_simple', $data, true);
            $tela .= $form -> editar($cp, $tabela);
            $data['content'] = $tela;
            $this -> load -> view('content', $data);

            if ($form -> saved > 0) {
                redirect(base_url('index.php/admin/user/' . $id . '/' . $chk));
            }

        }
    }

    function user_reset_password($id = 0, $chk = '') {
        if (perfil("#ADM#DRH")) {
            $this -> cab();
            $data['title'] = '';

            $data['content'] = $this -> users -> reset_password($id);
            $this -> load -> view('content', $data);
        } else {
            redirect(base_url('index.php/main'));
        }

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

    function email() {
        $this -> cab();
        $data['title'] = 'Teste de e-mail';

        $cp = array();
        array_push($cp, array('$H8', 'id_m', '', false, true));
        array_push($cp, array('$S80', 'smtp_host', 'STMP Host', true, true));
        array_push($cp, array('$S80', 'smtp_user', 'User name', true, true));
        array_push($cp, array('$S80', 'smtp_pass', 'User Pass', true, true));
        $op = 'smtp:smtp';
        array_push($cp, array('$O ' . $op, 'smtp_protocol', 'Protocolos', true, true));
        $op = '25:25&465:465&587:587';
        array_push($cp, array('$O ' . $op, 'smtp_port', 'Port', true, true));
        $op = 'smtp:smtp';
        array_push($cp, array('$O ' . $op, 'mailtype', 'Tipo', true, true));
        $form = new form;
        $form -> id = 1;
        $tela = $form -> editar($cp, 'mensagem_own');

        /***********************/
        if ($form -> saved > 0) {
            $email = 'renefgj@gmail.com';
            $para = array($email);
            enviaremail($para, 'Teste', 'Teste de e-mail', 1);
            $tela .= '<div>email de teste enviado para ' . $email . '</div>';
        }

        $data['content'] = $tela;
        $this -> load -> view('content', $data);
        $this -> footer();
    }

    function comunicacao_view($id = '') {
        /* Load Models */
        $this -> load -> model('ics');

        $this -> cab();
        $data = array();

        $data = $this -> ics -> le($id);
        $this -> load -> view('ics/view', $data);
        $this -> footer();
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
        $form -> row_view = base_url('index.php/admin/comunicacao_view/');
        $form -> row = base_url('index.php/admin/comunicacao_1/');

        $data['content'] = row($form, $id);
        $data['title'] = msg('messagem_cadastradas');

        $this -> load -> view('content', $data);

    }

}
?>
