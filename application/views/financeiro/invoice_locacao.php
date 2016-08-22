<style>
	.small {
		font-size: 10px;
		font-family: Arial, Helvetica, sans-serif;
	}
	.middle {
		font-size: 12px;
		font-family: Arial, Helvetica, sans-serif;
	}
	.big {
		font-size: 18px;
		font-family: Arial, Helvetica, sans-serif;
	}
	.superbig {
		font-size: 22px;
		font-family: Arial, Helvetica, sans-serif;
	}	
</style>
<table width="800" align="center">
	<tr valign="top">
		<td width="25%" align="center">
			<img src="<?php echo base_url('img/logo/logo_jpg.jpg');?>">
		</td>
		<td width="50%" align="center">
			<font class="big"><b><?php echo UpperCase($fi_razao_social); ?></b></font>
			<br>
			<br>
			<font class="middle">CNPJ:<?php echo UpperCase($fi_cnpj); ?> - IE: <?php echo UpperCase($fi_ie); ?></font>
			<br>
			<br>
			<font class="middle">
				<?php
				echo $fi_logradouro;
				if (strlen(trim($fi_numero))) { echo ', ' . $fi_numero;
				}
				if (strlen(trim($fi_complemento))) { echo ', ' . $fi_complemento;
				}
				if (strlen(trim($fi_bairro))) { echo ' - ' . $fi_bairro;
				}
				?>
			</font>
			<br>
			<font class="middle">
				<?php
				echo 'CEP: ' . mask_cep($fi_cep);
				echo ' - ' . ($fi_cidade);
				echo ', ' . ($fi_estado);
				?>
				<br>
				<?php echo $fi_fone_1; ?>
				<br>
				<br>
				<b><?php echo $fi_site; ?></b>
				-
				<?php echo $fi_email; ?>
			</font>
			
			
		</td>
		<td width="25%" align="center">
			<font class="big">RECIBO DE LOCAÇÃO DE BENS MÓVEIS</font>
			<hr>
				<font class="middle">
				1º VIA - DESTINATÁRIO
				</font>
			<hr>
			<font class="superbig">Nº <?php echo strzero($id_iv,6);?></font>
		</td>
	</tr>
	<tr><td colspan=3><hr></td></tr>
</table>
<!-- dados do cliente -->
<table width="800" align="center" border=0>
	<tr>
		<td colspan=2>
			<font class="big">DESTINATÁRIO / REMETENTE</font>			
		</td>
		<td width="20"><font class="small" align="right">Data emissão</font></td>
	</tr>
	<tr valign="top">
		<td class="small" align="right" width="100">Razão Social:</td>
		<td class="big">
		<b><?php echo $f_razao_social; ?></b>
		</td>		
		<td width="20" class="big"><?php echo stodbr($iv_data);?></td>
	</tr>
	<tr valign="top">
		<td class="small" align="right">Endereço:</td>
		<td class="big">
		<?php
		echo trim($f_logradouro);
		if (strlen(trim($f_numero))) { echo ', ' . $f_numero;
		}
		if (strlen(trim($f_complemento))) { echo ', ' . $f_complemento;
		}
		?>
		</td>
		<td width="20"><font class="small" align="right">Hora emissão</font></td>
	</tr>	
	<tr valign="top">
		<td class="small" align="right">Cidade/UF:</td>
		<td class="big">
		<?php
		echo trim($f_cidade);
		if (strlen(trim($f_estado))) { echo ', ' . $f_estado;
		}
		if (strlen($f_cep) > 0) {
			echo ' - CEP: ' . mask_cep($f_cep);
		}
		?></td>
		<td width="20" class="big"><?php echo substr($iv_hora,0,5);?></td>
	</tr>
	<tr valign="top">
		<td class="small" align="right">CNPJ:</td>
		<td class="big">
		<?php
		echo trim($f_cnpj);
		?>
		</td>
	</tr>
	<tr valign="top">
		<td class="small" align="right">IE:</td>
		<td class="big">
		<?php
		echo trim($f_ie);
		?>
		</td>
	</tr>
	</table>
