<?php
class users extends CI_model {
	var $table = 'users';

	function cp($id) {
		$cp = array();
		array_push($cp, array('$H8', 'id_us', '', False, True));
		array_push($cp, array('$S80', 'us_nome', 'Nome', True, True));
		if ($id == 0)
			{
				array_push($cp, array('$S80', 'us_email', 'login/email', True, True));
				array_push($cp, array('$P20', '', 'Senha', True, True));
			}
		array_push($cp, array('$HV', 'us_password', md5(get("dd3")), True, True));
		array_push($cp, array('$O 1:SIM&0:NÃO', 'us_ativo', 'Ativo', True, True));
		return ($cp);
	}

	function create_admin_user() {
		$dt = array();
		$dt['us_nome'] = 'Super User Admin';
		$dt['us_email'] = 'admin';
		$dt['us_password'] = md5('admin');
		$dt['us_autenticador'] = 'MD5';
		$this -> insert_new_user($dt);
	}
	
	function row($id='') {
		$form = new form;

		$form -> fd = array('id_us', 'us_nome', 'us_badge');
		$form -> lb = array('id', msg('us_name'), msg('us_cracha'));
		$form -> mk = array('', 'L', 'L', 'L');		
		
		$form -> tabela = $this -> table;
		$form -> see = true;
		$form -> novo = true;
		$form -> edit = true;

		$form -> row_edit = base_url('index.php/admin/user_edit');
		$form -> row_view = base_url('index.php/admin/user');
		$form -> row = base_url('index.php/admin/users');

		return (row($form, $id));
	}

	function editar($id,$chk)
		{
			$form = new form;
			$form->id = $id;
			$cp = $this->cp($id);
			$data['title'] = '';
			$data['content'] = $form->editar($cp,$this->table);
			$this->load->view('content',$data);
			return($form->saved);			
		}	

	function insert_new_user($data) {
		$email = $data['us_email'];
		$nome = $data['us_nome'];
		$senha = $data['us_password'];
		$auth = $data['us_autenticador'];

		$sql = "select * from " . $this -> table . " where us_email = '$email' ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) == 0) {
			$sql = "insert into " . $this -> table . " 
					(us_nome, us_email, us_password, us_ativo, us_autenticador,
					us_perfil, us_perfil_check)
					values
					('$nome','$email','$senha','1', '$auth',
					'','')
					";
			$this -> db -> query($sql);
			$this -> updatex();
			$this -> update_perfil_check($data);
		}
	}

	function le($id, $fld = 'id') {
		$sql = "select * from " . $this -> table;
		switch($fld) {
			case 'id' :
				$sql .= ' where id_us = ' . round($id);
				break;
			case 'login' :
				$sql .= " where us_email = '$id' ";
				break;
			default :
				$sql .= ' where id_us = ' . round($id);
				break;
		}
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) == 0) {
			return ( array());
		} else {
			return ($rlt[0]);
		}

	}

	function updatex() {
		$sql = "update " . $this -> table . " set us_badge = lpad(id_us,8,0) where us_badge = '' or us_badge is null ";
		$this -> db -> query($sql);
	}

	function update_perfil_check($data) {
		if (isset($data['us_email'])) {
			$usr = $this -> le($data['us_email'], 'login');
			$id = $usr['id_us'];
			$pass = $usr['us_password'];
			$perfil = $usr['us_perfil'];
			$check = md5($id . $perfil);
			$sql = "update " . $this -> table . " set us_perfil_check = '$check' where id_us = $id ";
			$rlt = $this -> db -> query($sql);
			return ('1');
		}
		if (isset($data['id_us'])) {
			$usr = $this -> le($data['id_us'], 'id');
			$id = $usr['id_us'];
			$pass = $usr['us_password'];
			$perfil = $usr['us_perfil'];
			$check = md5($id . $perfil);
			$sql = "update  " . $this -> table . " set us_perfil_check = '$check' where id_us = $id ";
			$rlt = $this -> db -> query($sql);
			return ('1');
		}
	}

	/****************** Security login ****************/
	function security() {
		$ok = 0;
		if (isset($_SESSION['id'])) {
			$id = round($_SESSION['id']);
			if ($id > 0) {
				return ('');
			}
		}
		redirect(base_url('index.php/social/login'));
	}

	function security_logout() {
		$data = array('id' => '', 'user' => '', 'email' => '', 'image' => '', 'perfil' => '');
		$this -> session -> set_userdata($data);
	}

	function security_login($login = '', $pass = '') {
		$sql = "select * from " . $this -> table . " where us_email = '$login' ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();

		if (count($rlt) > 0) {
			$dd2 = md5($pass);
			$line = $rlt[0];
			$dd3 = $line['us_password'];

			if ($dd2 == $dd3) {
				/* Salva session */
				$ss_id = $line['id_us'];
				$ss_user = $line['us_nome'];
				$ss_email = $line['us_email'];
				$ss_image = $line['us_image'];
				$ss_perfil = $line['us_perfil'];
				$data = array('id' => $ss_id, 'user' => $ss_user, 'email' => $ss_email, 'image' => $ss_image, 'perfil' => $ss_perfil);
				$this -> session -> set_userdata($data);
				return (1);
			} else {
				return (0);
			}
		}
	}

}
?>
