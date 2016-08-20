<?php
class prazos_montagem extends CI_Model {
	var $table = 'prazo_montagem';
	function row($form) {
		$form -> fd = array('id_pm', 'pm_nome',  'pm_ativo');
		$form -> lb = array('id', msg('pm_nome'), msg('pm_ativo'));
		$form -> mk = array('', 'L', 'A');
		return ($form);
	}

	function cp($id = '') {
		$cp = array();
		array_push($cp, array('$H8', 'id_pm', '', false, true));
		array_push($cp, array('$S80', 'pm_nome', msg('vd_nome'), true, true));
		array_push($cp, array('$HV', 'pm_seq', '0', false, true));
		array_push($cp, array('$O 1:Ativo&0:Inativo', 'pm_ativo', 'Situação', true, true));
		array_push($cp, array('$B8', '', msg('save'), false, true));
		return ($cp);
	}

}
?>
