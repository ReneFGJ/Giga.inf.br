<?php
class prazos_entrega extends CI_Model {
	var $table = 'prazo_entrega';
	function row($form) {
		$form -> fd = array('id_pz', 'pz_nome', 'pz_ativo');
		$form -> lb = array('id', msg('pz_nome'), msg('pz_ativo'));
		$form -> mk = array('', 'L', 'A');
		return ($form);
	}

	function cp($id = '') {
		$cp = array();
		array_push($cp, array('$H8', 'id_pz', '', false, true));
		array_push($cp, array('$S80', 'pz_nome', msg('pz_nome'), true, true));
		array_push($cp, array('$HV', 'pz_seq', '0', false, true));
		array_push($cp, array('$O 1:Ativo&0:Inativo', 'pz_visivel', 'Situação', true, true));
		array_push($cp, array('$B8', '', msg('save'), false, true));
		return ($cp);
	}

}
?>
