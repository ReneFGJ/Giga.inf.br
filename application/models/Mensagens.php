<?php
class mensagens extends CI_model
	{
		var $table = 'clientes_mensagem';
		function resumo($id)
			{
				$sql = "select count(*) as total from ".$this->table." where msg_cliente_id = $id";
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				return($rlt[0]['total']);
			}
	}
