<?php
class invoices extends CI_model
	{
		var $table = 'invoice';
		function le($id)
			{
				$sql = "select * 
						FROM ".$this->table."
						LEFT JOIN _filiais on id_fi = iv_filial
						LEFT JOIN clientes on id_f = iv_cliente
						WHERE id_iv = ".round($id);
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				if (count($rlt) > 0)
					{
						$line = $rlt[0];
					} else {
						$line = array();
					}
				return($line);				
			}
	}
