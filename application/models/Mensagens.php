<?php
class mensagens extends CI_model
	{
		var $table = 'clientes_mensagem';
		function mensagens_total($id)
			{
				$sql = "select count(*) as total from ".$this->table." where msg_cliente_id = $id";
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				return($rlt[0]['total']);
			}
		function mostra_mensagens($id)
			{
				$sql = "select * from ".$this->table." where msg_cliente_id = $id";
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				$sx = '<table class="table" width="100%">';
				$sx .= '<tr class="small">
							<th width="10%">data</th>
							<th width="75%">conteúdo</th>
							<th width="20%">responsável</th>
						</tr>
						';
				for ($r=0;$r < count($rlt); $r++)
					{
						print_r($rlt);
					}	
				if (count($rlt) == 0)
					{
						$sx .= '<tr class="middle"><td colspan=10><font color="red">sem mensagens</td></tr>';
					}
				$sx .= '</table>';
				return($sx);			
			}
	function nova_mensagem($id)
		{
			$sx = '<button type="button" class="btn btn-primary" aria-label="Left Align" onclick="newwin(\''.base_url('index.php/main/cliente_mensagem_edit/0/'.$id).'\');">';
			$sx .= 'nova mensagem';
			$sx .= '</button>';
			return($sx);
		}			
	}
