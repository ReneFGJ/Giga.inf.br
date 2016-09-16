<?php
			$sx = '';
			/* previsao */
			if ($line['cp_previsao'] == '1') {
				$trc = ' class="warning" ';
			} else {
				$trc = '';
			}

			$id = $line['id_cp'];
			$sit = '';
			if ($line['cp_situacao'] == 1) {
				$sit = '<font onclick="newxy(\'' . base_url('index.php/financeiro/cpagar_quitar/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer;" color="green"><b>$</b></font>';
				$link_edit = '<span onclick="newxy(\'' . base_url('index.php/financeiro/cpagar_edit/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,800);" style="cursor: pointer; color: blue;">';
			} else {
				$link_edit = '';
				$trc = ' class="info" ';
				
				if (perfil('#ADM'))
					{
						$link_edit = '<span onclick="newxy(\'' . base_url('index.php/financeiro/cpagar_contabil_edit/' . $line['id_cp'] . '/' . checkpost_link($line['id_cp'])) . '\',800,600);" style="cursor: pointer; color: blue;">';				
					}
			}

			$sx .= '<tr ' . $trc . '>';
			//$sx .= '<td>'.$line['cp_situacao'].'</td>';
			$sx .= '<td align="center" class="small">';
			$sx .= substr(sonumero($line['cp_vencimento']), 6, 2);
			$sx .= '/';
			$sx .= substr(sonumero($line['cp_vencimento']), 4, 2);
			$sx .= '/';
			$sx .= substr(sonumero($line['cp_vencimento']), 2, 2);			
			$sx .= '</td>';

			$sx .= '<td class="middle">';
			$dados = UpperCase($line['cp_historico']);
			if (strlen($line['f_nome_fantasia']) > 0) {
				$dados = $line['f_nome_fantasia'] . '  - ' . $dados . ' ';
			}
			if (strlen(trim($line['cp_nossonumero'])) > 0) {
				$dados .= ' - Boleto '.$line['cp_nossonumero'];
			}
			$sx .= $link_edit . $dados . '</a>';
			$sx .= '</td>';

			$sx .= '<td class="small">';
			$sx .= $line['cp_pedido'];
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