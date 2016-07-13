<?php
class imports extends CI_model {
	function cpagar() {
		$file = '_temp/cpagar.txt';
		$rlt = fopen($file, 'r+');
		$txt = '';
		while (!feof($rlt)) {
			$txt .= fread($rlt, 1024);
		}
		fclose($rlt);
		$txt = ' ' . utf8_encode($txt);
		//			echo '<pre>'.$txt.'</pre>';
		$txt = troca($txt, ';', ':');
		$txt = troca($txt, chr(13), ';') . ';';
		//echo '<pre>'.$txt.'</pre>';

		$sql = "select * from cx_conta_codigo";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$conta = array();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$cod = $line['cd_codigo'];
			$id = $line['id_cd'];
			$conta[$cod] = $id;
		}

		$tot = 0;
		$sql = "delete from cx_pagar where 1=1";
		$rrr = $this -> db -> query($sql);

		while ((strpos($txt, ';')) and ($tot < 100000000)) {
			$tot++;
			$pos = strpos($txt, ';');
			$ln = substr($txt, 0, $pos);
			$ln = troca($ln, ',', '.');
			$ln = troca($ln, '||', ';');
			$lns = splitx(';', $ln);
			if (isset($lns[0]) and (substr($lns[0], 0, 2) == '20')) {
				$d1 = substr($lns[0], 0, 4) . '-' . substr($lns[0], 4, 2) . '-' . substr($lns[0], 6, 2);
				$d2 = substr($lns[1], 0, 4) . '-' . substr($lns[1], 4, 2) . '-' . substr($lns[1], 6, 2);
				$vlr = $lns[2];
				$cod = $lns[3];
				$cod_i = $conta[$cod];
				$doc = $lns[4];
				$desc = $lns[8];
				$parc = $lns[7];
				$prev = 0;
				echo $d1 . '|' . $d2 . '|' . $vlr;
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
				$rrr = $this -> db -> query($sql);
			}
			$txt = substr($txt, $pos + 1, strlen($txt));
		}

	}

	function usuarios() {
		$file = '_temp/usuarios.txt';
		$rlt = fopen($file, 'r+');
		$txt = '';
		while (!feof($rlt)) {
			$txt .= fread($rlt, 1024);
		}
		fclose($rlt);
		$txt = ' ' . utf8_encode($txt);
		//			echo '<pre>'.$txt.'</pre>';
		$txt = troca($txt, ';', ':');
		$txt = troca($txt, chr(13), ';') . ';';
		//echo '<pre>'.$txt.'</pre>';
		$tot = 0;
		while ((strpos($txt, ';')) and ($tot < 100000000)) {
			$tot++;
			$pos = strpos($txt, ';');
			$ln = substr($txt, 0, $pos);
			$ln = troca($ln, ',', '.');
			$ln = troca($ln, '||', ';');
			$lns = splitx(';', $ln);
			$login = $lns['0'];
			$sql = "select * from users where us_login = '$login' ";
			$rlt = $this -> db -> query($sql);
			$rlt = $rlt -> result_array();

			if (count($rlt) == 0) {
				$d1 = substr($lns[0], 0, 4) . '-' . substr($lns[0], 4, 2) . '-' . substr($lns[0], 6, 2);
				$d2 = substr($lns[1], 0, 4) . '-' . substr($lns[1], 4, 2) . '-' . substr($lns[1], 6, 2);
				$nome = nbr_autor($lns[1], 7);
				$genero = substr($lns[11], 0, 1);
				echo '<br>' . $nome;
				if ($lns[8] == 'A') {
					$ativo = 1;
				} else {
					$ativo = 0;
				}
				$sql = "insert into users
							(
							us_nome, us_login, us_password,
							us_badge, us_ativo, us_genero,
							us_autenticador, us_perfil 
							) value (
							'$nome','$login','123456',
							'','$ativo','$genero',
							'TXT',''
							)";
				$rrr = $this -> db -> query($sql);
			}
			$txt = substr($txt, $pos + 1, strlen($txt));
		}

	}

	function fornecedores() {
		$sql = "select * from users";
		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		$users = array();
		for ($r = 0; $r < count($rlt); $r++) {
			$line = $rlt[$r];
			$cod = $line['us_login'];
			$id = $line['id_us'];
			$users[$cod] = $id;
		}

		$file = '_temp/fornecedores.txt';
		$rlt = fopen($file, 'r+');
		$txt = '';
		while (!feof($rlt)) {
			$txt .= fread($rlt, 1024);
		}
		fclose($rlt);
		$txt = ' ' . utf8_encode($txt);
		$txt = troca($txt, "'", "´");
		//			echo '<pre>'.$txt.'</pre>';
		$txt = troca($txt, ';', ':');
		$txt = troca($txt, chr(13), ';') . ';';
		$txt = utf8_decode($txt);
		//echo '<pre>'.$txt.'</pre>';
		$tot = 0;
		$sx = '';
		while ((strpos($txt, ';')) and ($tot < 6000)) {
			$tot++;
			$pos = strpos($txt, ';');
			$ln = substr($txt, 0, $pos);
			$ln = troca($ln, ',', '.');
			$ln = troca($ln, '|| ||', '||-||');
			$ln = troca($ln, '|| ||', '||-||');
			$ln = troca($ln, '||', '; ');
			$lns = splitx(';', $ln);

			$nome = $lns['0'];
			$sql = "select * from clientes where f_razao_social = '$nome' ";
			$rlt = $this -> db -> query($sql);
			$rlt = $rlt -> result_array();

			if (count($rlt) == 0) {
				if (count($lns) != 16) {
					echo '<hr>';
					print_r($lns);
					exit;
				} else {

					$nome = nbr_autor($lns[0], 7);
					$nome_fantasia = nbr_autor($lns[1], 7);
					$cod = $lns[2];
					$vend = $lns[3];
					$cnpj = $lns[4];
					$ie = $lns[5];	
					$cep = $lns[6];
					$bairro = $lns[7];
					$cidade = $lns[8];
					$estado = $lns[9];						
					$endereco = $lns[10];				
					$fone = $lns[11];
					$fone2 = $lns[12];
					$email = strtolower($lns[13]);
					

					if (($vend == '-') or ($vend == '') or ($vend == '0')) {
						$vendor = 0;
					} else {
						if (!isset($users[$vend])) {
							$vendor = 0;
						} else {
							$vendor = $users[$vend];
						}

					}

					//echo '<br>'.$nome;
					//print_r($lns);
					$sql = "insert into clientes
							(
								f_razao_social, f_nome_fantasia, f_cnpj,
								f_ie, f_im, f_logradouro,
								f_numero, f_complemento, f_bairro,
								
								f_cidade, f_estado, f_cep,
								f_fone_1, f_fone_2, f_email,
								f_email_cobranca, f_ativo, f_obs,
								
								f_vendor, f_tipo
							) value (
								'$nome','$nome_fantasia','$cnpj',
								'$ie','','$endereco',
								'','','$bairro',
								
								'$cidade','$estado','$cep',
								'$fone','$fone2','$email',
								'',1,'',
								
								'$vendor', 1
							)";
					$sx .= '<br>' . $nome . ' (<font color="green">importado</font>)';
					$rrr = $this -> db -> query($sql);
				}
			}
			$txt = substr($txt, $pos + 1, strlen($txt));
		}
		return ($sx);
	}

}
?>
