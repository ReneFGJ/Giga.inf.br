<?php
class contratos extends CI_model
	{
		var $table = 'contrato_modelo';
		function le($id)
			{
				$sql = "select * from ".$this->table." where id_c = 1";
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				if (count($rlt) > 0)
					{
						$line = $rlt[0];
						return($line);
					} else {
						return(array());
					}
			}
		
	}
?>
