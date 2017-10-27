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
		function anexos($id)
			{
				$sql = "select * from produto_agenda
							INNER JOIN produtos ON ag_produto = id_pr
							INNER JOIN produtos_tipo ON id_prd = pr_produto
							WHERE ag_pedido = $id and ag_situacao > 0";
							
				$sql = "select * from produto_agenda
						inner join produtos on id_pr = ag_produto
						inner join produtos_categoria  ON pr_categoria = id_pc						
					where ag_pedido = $id
					";							
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				$sx = '<br>';
				//$sx .= '<tr><th>ITEM 02</th></tr>'.cr()
				$sx .= '<table width="100%" class="table" style="border: 1px solid #000000;">';
				//$sx .= '<tr><td><b>ITEM 02</b></td></tr>';
				$sx .= '<tr><th>Equipamento</th><th>Nº série</th><th>Período de</th><th>Até</th></tr>'.cr();
				
				for ($r=0;$r < count($rlt);$r++)
					{
						$line = $rlt[$r];
						$sx .= '<tr>';
						//$sx .= '<td>'.$line['pc_nome'].'</td>';
                        $sx .= '<td>'.$line['pr_tag'].'</td>';

						$sx .= '<td>'.stodbr($line['ag_data_reserva']).'</td>';
						$sx .= '<td>'.stodbr($line['ag_data_reserva_ate']).'</td>';
						
						$sx .= '</tr>'.cr();
					}
				$sx .= '</table>'.cr();
				$sx .= '<br><br>'.cr();
				//exit;
				return($sx);
			}
		
	}
?>
