<br>
<table width="100%" cellpadding=5 style="border: 1px solid #000000;">
	<tr><td colspan=2><h4>LOCADOR</h4></td></tr>
	<tr><td width="20%" align="right">Razão Social </td>
		<td><b><?php echo $fi_razao_social;?></b></td>
	</tr>
	<tr><td align="right">CPF/CNPJ </td>
		<td><b><?php echo $fi_cnpj;?></b></td>
	</tr>	
	<tr><td align="right">Endereço </td>
		<td><b><?php echo $fi_logradouro.', '.$fi_numero.' '.$fi_complemento;?></b></td>
	</tr>
	<tr><td align="right"></td>
		<td><b><?php echo $fi_bairro.', '.$fi_cidade.'-'.$fi_estado;?></b></td>
	</tr>			
</table>
<br>