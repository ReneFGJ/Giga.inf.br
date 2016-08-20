<?php
class prazos_garantia extends CI_Model {
	var $table = 'prazo_garantia';
	function row($form) {
		$form -> fd = array('id_pga', 'pga_nome',  'pga_ativo');
		$form -> lb = array('id', msg('pga_nome'), msg('pga_ativo'));
		$form -> mk = array('', 'L', 'A');
		return ($form);
	}

	function cp($id = '') {
		$cp = array();
		array_push($cp, array('$H8', 'id_pga', '', false, true));
		array_push($cp, array('$S80', 'pga_nome', msg('vd_nome'), true, true));
		array_push($cp, array('$HV', 'pga_seq', '0', false, true));
		array_push($cp, array('$O 1:Ativo&0:Inativo', 'pga_ativo', 'Situação', true, true));
		array_push($cp, array('$B8', '', msg('save'), false, true));
		return ($cp);
	}

}
?>
