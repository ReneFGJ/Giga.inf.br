<?php
class logins extends CI_Model {
	var $tabela = 'users';
	var $table_perfil = 'logins_perfil';
	function row($obj) {
		$obj -> fd = array('id_us', 'us_nome', 'us_login', 'us_ativo');
		$obj -> lb = array('ID', 'Nome', 'Login', 'Ativo');
		$obj -> mk = array('', 'L', 'L', 'A');
		return ($obj);
	}

	function atualiza_perfil($id) {
		$sql = "select * from logins_perfil_ativo 
						inner join logins_perfil on id_usp = up_perfil
						where up_user = $id; ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$perf = '';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$perf .= trim($line['usp_codigo']);
		}
		$sql = "update " . $this -> tabela . " set us_perfil = '$perf' where id_us = " . $id;
		$this -> db -> query($sql);
		return ($perf);
	}

	function le($id = 0) {
		$sql = "select * from " . $this -> tabela . " where id_us = " . round($id);
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array($rlt);

		if (count($rlt) > 0) {
			$dadosUsuario = $rlt[0];
		} else {
			$dadosUsuario = array();
		}

		$dadosUsuario['us_perfil_list'] = $this -> perfil_list($id);

		$dadosUsuario['us_perfil_associar'] = $this -> perfil_associar($id);

		return ($dadosUsuario);
	}

	function associar_perfil_usuario($id, $perfil) {
		$sql = "select * from logins_perfil_ativo where up_user = $id and up_perfil = $perfil ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();

		$data = date("Y-m-d");

		if (count($rlt) == 0) {
			$sql = "insert into logins_perfil_ativo (
							up_perfil, up_data, up_data_end,
							up_ativo, up_user
							) values (
							'$perfil','$data','0000-00-00',
							1,$id
							) ";
			$xrlt = $this -> db -> query($sql);
		} else {
			$line = $rlt[0];
			$ipd = $line['id_up'];
			$sql = "update logins_perfil_ativo 
							set up_ativo = 1, up_data_end = '0000-00-00' 
					where id_up = $ipd ;";
			$xrlt = $this -> db -> query($sql);
		}
		$this -> atualiza_perfil($id);
		return (1);
	}

	function perfil_desassociar($id) {
		$data = date("Y-m-d");
		$sql = "update logins_perfil_ativo 
							set up_ativo = 0, up_data_end = $data 
					where id_up = $id ;";
		$rlt = $this -> db -> query($sql);
		$this -> atualiza_perfil($id);
	}

	function perfil_associar($id) {
		$acao = $this -> input -> post('acao');
		$dd9 = $this -> input -> post('dd9');
		if ((strlen($acao) > 0) and (strlen($dd9) > 0)) {
			$this -> associar_perfil_usuario($id, $dd9);
			redirect(base_url('index.php/admin/logins_view/' . $id . '/' . checkpost_link($id)));
		}

		$sql = "select * from logins_perfil
						left join logins_perfil_ativo on (up_user = $id and up_perfil = id_usp and up_ativo = 1)
						where up_user is null
						order by usp_descricao ";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array($rlt);
		$sx = form_open(base_url('index.php/admin/logins_view/' . $id . '/' . checkpost_link($id)));
		$sx .= '<select name="dd9" size=10 style="width: 500px;">' . chr(13) . chr(10);
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$sx .= '<option value="' . $line['id_usp'] . '">';
			$sx .= $line['usp_descricao'];
			$sx .= '</option>';
		}
		$sx .= '</select>' . chr(13) . chr(10);
		$sx .= '<BR>';
		$data = array('name' => 'acao', 'id' => 'acao', 'value' => msg('associar_perfil') . ' >>>');
		$sx .= form_submit($data);
		$sx .= form_close();
		return ($sx);
	}

	function perfil_list($id) {
		$sql = "select * from logins_perfil_ativo
						inner join logins_perfil on up_perfil = id_usp
						where up_ativo = 1 and up_user = $id
						order by usp_descricao 
					";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '<table width="500" class="lt2">';
		$sx .= '<tr>
						<th class="borderb1" width="60%">' . msg('profile') . '</th>
						<th class="borderb1" width="20%">' . msg('id') . '</th>
						<th class="borderb1" width="20%">' . msg('update') . '</th>
						<th class="borderb1" width="20%">' . msg('acao') . '</th>
						';
		$to = 0;
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$to++;
			$sx .= '<tr>';
			$sx .= '<td>';
			$sx .= $line['usp_descricao'];
			$sx .= '</td>';
			$sx .= '<td align="center">';
			$sx .= $line['usp_codigo'];
			$sx .= '</td>';
			$sx .= '<td align="center">';
			$sx .= stodbr($line['up_data']);
			$sx .= '</td>';

			$link = base_url('index.php/admin/logins_view/' . $id . '/' . checkpost_link($id . 'DEL', $line['id_up']) . '/del/' . $line['id_up']);
			$link_excluir = '<a href="' . $link . '" class="lt1 link">' . msg('excluir') . '</a>';
			$sx .= '<td align="center">';
			$sx .= $link_excluir;
			$sx .= '</td>';
		}
		if ($to == 0) {
			$sx .= '<tr><td>' . msg('empty') . '</td></tr>';
		}
		$sx .= '</table>';
		return ($sx);
	}

	function row_perfil($obj) {
		$obj -> fd = array('id_usp', 'usp_codigo', 'usp_descricao', 'usp_ativo');
		$obj -> lb = array('id', msg('Label_perfil_codigo'), msg('Label_perfil_descricao'), msg('Label_perfil_status'));
		$obj -> mk = array('', 'L', 'L', 'A');
		return ($obj);
	}

	function cp_perfil() {

		//$sql_idioma = 'select * from idioma where 1 = 1 order by i_nome';

		$cp = array();
		array_push($cp, array('$H8', 'id_usp', '', False, True));
		array_push($cp, array('$S4', 'usp_codigo', msg('Label_perfil_codigo'), True, True));
		array_push($cp, array('$S50', 'usp_descricao', msg('Label_perfil_descricao'), false, True));
		array_push($cp, array('$O 1:SIM&0:NÃO', 'usp_ativo', msg('Label_perfil_status'), false, True));
		array_push($cp, array('$B', '', msg('enviar'), false, True));

		return ($cp);
	}

	function le_perfil($id = 0) {
		$sql = "select * from " . $this -> tabela . " 
					where id_usp = " . $id;

		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array($rlt);
		$data = $rlt[0];

		return ($data);
	}

}
?>