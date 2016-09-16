<?php if (isset($pdf)) { ?>
<style>
	.small {
		font-size: 8px;
		font-family: Arial, Helvetica, sans-serif;
	}
	.middle {
		font-size: 10px;
		font-family: Arial, Helvetica, sans-serif;
	}
	.big {
		font-size: 12px;
		font-family: Arial, Helvetica, sans-serif;
	}
	.superbig {
		font-size: 15px;
		font-family: Arial, Helvetica, sans-serif;
	}
	p {
		font-size: 10px;
		font-family: Arial, Helvetica, sans-serif;
	}
</style>
<?php } else { ?>
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
<?php } ?>
<table width="100%" align="center">
	<tr valign="top">
		<td width="25%" align="center">
			<img src="<?php echo base_url('img/logo/logo_jpg.jpg'); ?>">
		</td>
		<td width="50%" align="center">
			<font class="big"><b><?php echo UpperCase($fi_razao_social); ?></b></font>
			<br>
			<font class="middle">CNPJ:<?php echo Mask_CPF($fi_cnpj); ?> - IE: <?php echo UpperCase($fi_ie); ?></font>
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
			<br>--------------------<br>
				<font class="middle">
				1º VIA - DESTINATÁRIO
				</font>
			<br>--------------------<br>
			<font class="superbig">Nº <?php echo $nrs_nr; ?></font>
		</td>
	</tr>
</table>
<!-- dados do cliente -->
<table width="100%" align="center" border=1 style="border: 1px solid #000000;">
	<tr>
		<td width="80%" height="1">
			<table width="100%">
				<tr>
					<td class="big" align="center" colspan="2">
						<b>DESTINATÁRIO
						/	
						REMETENTE</b>	
					</td>		
				</tr>
			<tr valign="top">
				<td class="small" align="right" width="20%">Razão Social:</td>
				<td class="big" align="left" width="80%">
				<?php echo $f_razao_social; ?>
				</td>		
			</tr>
			<tr valign="top">
				<td class="small" align="right">Endereço:</td>
				<td class="big" align="left">
				<?php
				echo trim($f_logradouro);
				if (strlen(trim($f_numero))) { echo ', ' . $f_numero;
				}
				if (strlen(trim($f_complemento))) { echo ', ' . $f_complemento;
				}
				?>
				</td>	
			</tr>	
			<tr valign="top">
				<td class="small" align="right">Cidade/UF:</td>
				<td class="big" align="left">
				<?php
				echo trim($f_cidade);
				if (strlen(trim($f_estado))) { echo ', ' . $f_estado;
				}
				if (strlen($f_cep) > 0) {
					echo ' - CEP: ' . mask_cep($f_cep);
				}
				?></td>							
			</tr>
			<tr valign="top">
				<td class="small" align="right">CNPJ:</td>
				<td class="big" align="left">
				<?php
				echo mask_cpf($f_cnpj);
				?>
				</td>
			</tr>
			<tr valign="top">
				<td class="small" align="right">IE:</td>
				<td class="big" align="left">
				<?php
				echo trim($f_ie);
				?>
				</td>
			</tr>
		</table>
		</td>
		<!------------->
		<td width="20%" align="right" class="middle">
		<font class="small">Data emissão</font>
			<br><?php echo stodbr($iv_data); ?>	
			
			<br><font class="small">Hora emissão</font>
			<?php echo substr($iv_hora, 0, 5); ?>
		</td>
	</tr>
	</table>
