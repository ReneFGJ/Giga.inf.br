<?php
class condicoes_pagamento extends CI_Model {
	var $table = 'condicoes_pagamento';
	function row($form) {
		$form -> fd = array('id_pg', 'pg_nome',  'pg_ativo');
		$form -> lb = array('id', msg('pg_nome'), msg('pg_ativo'));
		$form -> mk = array('', 'L', 'A');
		return ($form);
	}

	function cp($id = '') {
		$cp = array();
		array_push($cp, array('$H8', 'id_pg', '', false, true));
		array_push($cp, array('$S80', 'pg_nome', msg('pg_nome'), true, true));
		array_push($cp, array('$HV', 'pg_visivel', '1', false, true));
		array_push($cp, array('$O 1:Ativo&0:Inativo', 'pg_ativo', 'Situação', true, true));
		array_push($cp, array('$B8', '', msg('save'), false, true));
		return ($cp);
	}

}
?>
