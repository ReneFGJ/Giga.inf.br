<?php
$fld1 = 'f_razao_social';
$fld2 = 'f_nome_fantasia';
			$sx = '';
			/* previsao */
			if ($line['cp_previsao'] == '1') {
				$trc = ' class="warning" ';
			} else {
				$trc = '';
			}
			
			/* situacao */
			if ($line['cp_situacao'] == 9)
				{
					$trc = ' class="danger" ';
				}

			$id = $line['id_cp'];
			$sit = '';
			if ($line['cp_situacao'] == 1) {
				$sit = '<font onclick="newxy(\'' . base_url('index.php/financeiro/creceber_quitar/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer;" color="green"><b>$</b></font>';
				$link_edit = '<span onclick="newxy(\'' . base_url('index.php/financeiro/creceber_edit/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer; color: blue;">';
			} else {
				$link_edit = '';
				$trc = ' class="info" ';
				
				if (perfil('#ADM'))
					{
						$link_edit = '<span onclick="newxy(\'' . base_url('index.php/financeiro/creceber_contabil_edit/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,600);" style="cursor: pointer; color: blue;">';				
					}
			}

			$sx .= '<tr ' . $trc . '>';
			//$sx .= '<td>'.$line['cp_situacao'].'</td>';
			$linka = base_url('index.php/financeiro/creceber/'.sonumero($line['cp_vencimento']));
			$sx .= '<td align="center" class="small">';
            $sx .= '<a href="'.$linka.'">';
			$sx .= substr(sonumero($line['cp_vencimento']), 6, 2);
			$sx .= '/';
			$sx .= substr(sonumero($line['cp_vencimento']), 4, 2);
			$sx .= '/';
			$sx .= substr(sonumero($line['cp_vencimento']), 2, 2);			
			$sx .= '</a>';
			$sx .= '</td>';

			$sx .= '<td class="middle">';
			$dados = UpperCase($line['cp_historico']);
			$dados2 = '';
			if (strlen($line[$fld1]) > 0) {
				$dados2 = '<a href="'.base_url('index.php/main/cliente/'.$line['id_f'].'/'.checkpost_link($line['id_f'])).'" target="_new">';
				$dados2 .= '<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>';
				$dados2 .= '</a>';
				$dados = $line[$fld1] . '  - ' . $dados . ' ';
			}
			if (strlen(trim($line['cp_nossonumero'])) > 0) {				
				$dados .= ' - Boleto '.$line['cp_nossonumero'];
			}
			$sx .= $dados2.' '.$link_edit . $dados . '</a>';
			$sx .= '</td>';

			$sx .= '<td class="small">';
			$pedido = $line['cp_pedido'];
			if (substr($pedido, 5, 1) == '/') {
				$link = 'http://10.1.1.123:8080/pedidos/pedido_mostra.asp?dd1=' . $pedido;
				$pedido = '<a href="#" onclick="newxy(\'' . $link . '\',800,800);">' . $pedido . '</a>';
			}
			if ((substr($pedido, 7, 1) == '/') and (substr($pedido,0,1) == '0')) {
				$idped = round(substr($pedido,0,7));
				$link = base_url('index.php/main/pedido_mostra/' . round($idped).'/'.checkpost_link($idped));
				$pedido = '<a href="#" onclick="newxy(\'' . $link . '\',800,800);">' . $pedido . '</a>';
			}
			$sx .= $pedido;
			$sx .= '</td>';

			$sx .= '<td class="small">';
			$sx .= $line['cp_parcela'];
			$sx .= '</td>';

			$sx .= '<td align="right">';
			$sx .= '<b>';
			$sx .= number_format($line['cp_valor'], 2, ',', '.');
			$sx .= '</b>';
			$sx .= '</td>';

			$sx .= '<td align="center">';
			$sx .= '<b>';
			$sx .= $sit;
			$sx .= '</b>';
			$sx .= '</td>';

			$sx .= '</tr>';
			
			echo $sx;
?>