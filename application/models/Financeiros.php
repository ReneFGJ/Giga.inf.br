<?php
class financeiros extends CI_model {
	var $table_pagar = 'cx_pagar';
	function cp_cpagar_quitar()
		{
			$cp = array();
			array_push($cp,array('$H8','id_cp','',false,true));
			array_push($cp,array('$S80','cp_historico','Historico',True,true));
			array_push($cp,array('$N8','cp_valor','Valor original',True,False));
			array_push($cp,array('$N8','cp_valor_pago','Valor pago',True,true));
			array_push($cp,array('$Q id_cc:cc_nome:select * from cc_banco where cc_ativo=1','cp_forma_pagamento','Forma pagamento',True,true));
			array_push($cp,array('$S20','cp_img','Imagem',False,true));
			
			array_push($cp,array('$HV','cp_log_pagamento',$_SESSION['id'],True,true));
			array_push($cp,array('$HV','cp_dt_pagamento',date("Y-m-d"),True,true));
			array_push($cp,array('$HV','cp_situacao','2',True,true));			
			
			array_push($cp,array('$B8','','Fechar pagamento',false,true));			
			return($cp);
		}
	
	function contas_pagar($dt) {
		$dt = sonumero($dt);
		$dt = substr($dt, 0, 4) . '-' . substr($dt, 4, 2) . '-' . substr($dt, 6, 2);
		$cp = '*';
		$sql = "select $cp, 1 as tipo from cx_pagar 
							where cp_vencimento >= '$dt'
						order by cp_vencimento, cp_valor desc 
						";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '';
		$saldo = 0;
		$sx = '<table width="100%" class="table">';
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$id = $line['id_cp'];
			
			if (($line['cp_situacao'] == '0') or ($line['cp_situacao'] == '1'))
				{
					$link = '<a href="#" onclick="newwin(\''.base_url('index.php/cx/cpagar_quitar/');
					$link .= '/'.$id.'/'.checkpost_link($id).'\');">';
					} else {
						$link = '';
					}
			
			$sx .= '<tr>';
			//$sx .= '<td>'.$line['cp_situacao'].'</td>';
			$sx .= '<td align="center" class="small">';
			$sx .= substr(sonumero($line['cp_vencimento']), 6, 2);
			$sx .= '/';
			$sx .= substr(sonumero($line['cp_vencimento']), 4, 2);
			$sx .= '</td>';
			
			$sx .= '<td class="middle">';
			$sx .= $link.$line['cp_historico'].'</a>';
			$sx .= '</td>';

			$sx .= '<td class="small">';
			$sx .= $line['cp_parcela'];
			$sx .= '</td>';

			$sx .= '<td>';
			$sx .= '</td>';

			$sx .= '<td class="middle alert-danger" align="right">';
			$sx .= '<b>';
			$sx .= number_format($line['cp_valor'], 2, ',', '.');
			$sx .= '</b>';
			$sx .= '</td>';
			
			$sx .= '</tr>';

		}
		$sx .= '</table>';
		return($sx);
	}

	function caixa_dia($dt) {
		$cp = '*';
		$sql = "select $cp, 1 as tipo from cx_pagar 
							where cp_vencimento = '$dt'
						order by cp_valor desc 
						";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$sx = '';
		$saldo = 0;
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$sx .= '<tr>';
			$sx .= '<td align="center" class="small">';
			$sx .= substr(sonumero($line['cp_vencimento']), 6, 2);
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
			$sx .= number_format($line['cp_valor'], 2, ',', '.');
			$sx .= '</b>';
			$sx .= '</td>';

			/*** saldo *****/
			$saldo = $saldo - $line['cp_valor'];
			if ($saldo < 0) {
				$sx .= '<td class="middle alert-danger" align="right">';
				$sx .= '<b>';
				$sx .= number_format($saldo, 2, ',', '.');
				$sx .= '</b>';
				$sx .= '</td>';
			} else {
				$sx .= '<td class="middle alert-success" align="right">';
				$sx .= '<b>';
				$sx .= number_format($saldo, 2, ',', '.');
				$sx .= '</b>';
				$sx .= '</td>';
			}

			$sx .= '</tr>';
		}
		$data['dados'] = $sx;
		$sx = $this -> load -> view('financeiro/caixa', $data, true);
		return ($sx);
	}

}
?>
