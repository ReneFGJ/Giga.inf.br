<?php
class imports extends CI_model
	{
	function cpagar()
		{
			$file = '_temp/cpagar.txt';
			$rlt = fopen($file,'r+');
			$txt = '';
			while (!feof($rlt))
				{
					$txt .= fread($rlt,1024);
				}
			fclose($rlt);
			$txt = ' '.utf8_encode($txt);
//			echo '<pre>'.$txt.'</pre>';
		$txt = troca($txt,';',':');
		$txt = troca($txt,chr(13),';').';';
		//echo '<pre>'.$txt.'</pre>';
		
		$sql = "select * from cx_conta_codigo";
		$rlt = $this->db->query($sql);
		$rlt = $rlt->result_array();
		$conta = array();
		for ($r=0;$r < count($rlt);$r++)
			{
				$line = $rlt[$r];
				$cod = $line['cd_codigo'];
				$id = $line['id_cd'];
				$conta[$cod] = $id;
			}
		
		$tot = 0;
		$sql = "delete from cx_pagar where 1=1";
		$rrr = $this->db->query($sql);
		
		while ((strpos($txt,';')) and ($tot < 100000000))
			{
				$tot++;
				$pos = strpos($txt,';');			
				$ln = substr($txt,0,$pos);
				$ln = troca($ln,',','.');
				$ln = troca($ln,'||',';');
				$lns = splitx(';',$ln);
				if (isset($lns[0]) and (substr($lns[0],0,2) == '20'))
				{
					$d1 = substr($lns[0],0,4).'-'.substr($lns[0],4,2).'-'.substr($lns[0],6,2);
					$d2 = substr($lns[1],0,4).'-'.substr($lns[1],4,2).'-'.substr($lns[1],6,2);
					$vlr = $lns[2];
					$cod = $lns[3];
					$cod_i = $conta[$cod];
					$doc = $lns[4];
					$desc = $lns[8];
					$parc = $lns[7];
					$prev = 0;
					echo $d1.'|'.$d2.'|'.$vlr;
					$sql = "insert into cx_pagar
							(
							cp_data, cp_vencimento, cp_doc,
							cp_valor, cp_valor_pago, cp_conta,
							cp_contal_old, cp_pedido, cp_dt_pagamento,
							cp_situacao, cp_historico, cp_parcela,
							cp_previsao 
							) value (
							'$d1','$d2','$doc',
							'$vlr','$vlr',$cod_i,
							'$cod','$doc','$d2',
							'2','$desc','$parc',
							'$prev')";
					$rrr = $this->db->query($sql);
				}
				$txt = substr($txt,$pos+1,strlen($txt));
			}
				
		}	
		
	}
?>
