<?php
class pedidos_validade extends CI_Model {
	var $table = 'pedido_validade';
	function row($form) {
		$form -> fd = array('id_vd', 'vd_nome',  'vd_ativo');
		$form -> lb = array('id', msg('vd_nome'), msg('vd_ativo'));
		$form -> mk = array('', 'L', 'A');
		return ($form);
	}

	function cp($id = '') {
		$cp = array();
		array_push($cp, array('$H8', 'id_vd', '', false, true));
		array_push($cp, array('$S80', 'vd_nome', msg('vd_nome'), true, true));
		array_push($cp, array('$HV', 'vd_visivel', '1', false, true));
		array_push($cp, array('$O 1:Ativo&0:Inativo', 'vd_ativo', 'Situação', true, true));
		array_push($cp, array('$B8', '', msg('save'), false, true));
		return ($cp);
	}

}
?>
