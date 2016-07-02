<?php
class financeiros extends CI_model
	{
		function caixa_dia($dt)
			{
				$cp = '*';
				$sql = "select $cp, 1 as tipo from cx_pagar 
							where cp_vencimento = '$dt'
						order by cp_valor desc 
						";
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				$sx = '';
				$saldo = 0;
				for ($r=0;$r < count($rlt);$r++)
					{
						$line = $rlt[$r];
						$sx .= '<tr>';
						$sx .= '<td align="center" class="small">';
						$sx .= substr(sonumero($line['cp_vencimento']),6,2);
						$sx .= '</td>';
												
						$sx .= '<td class="middle">';
						$sx .= $line['cp_historico'];
						$sx .= '</td>';
						
						$sx .= '<td class="small">';
						$sx .= $line['cp_parcela'];
						$sx .= '</td>';
						
						$sx .= '<td>';
						$sx .= '</td>';		
						
						$sx .= '<td class="middle alert-danger" align="right">';
						$sx .= '<b>';
						$sx .= number_format($line['cp_valor'],2,',','.');
						$sx .= '</b>';
						$sx .= '</td>';
						
						/*** saldo *****/
						$saldo = $saldo - $line['cp_valor'];
						if ($saldo < 0)
							{										
								$sx .= '<td class="middle alert-danger" align="right">';
								$sx .= '<b>';
								$sx .= number_format($saldo,2,',','.');
								$sx .= '</b>';
								$sx .= '</td>';
							} else {
								$sx .= '<td class="middle alert-success" align="right">';
								$sx .= '<b>';
								$sx .= number_format($saldo,2,',','.');
								$sx .= '</b>';
								$sx .= '</td>';								
							}
						
						$sx .= '</tr>';
					}
				$data['dados'] = $sx;
				$sx = $this -> load -> view('financeiro/caixa', $data,true);
				return($sx);				
			}
	}
?>
