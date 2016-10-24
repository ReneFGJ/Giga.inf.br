<?php
if (strlen($f_razao_social) == 0)
	{
		$f_razao_social = '<font color="red">Não informado no sistema</font>';
	}
?>
<table width="100%">
	
	<tr>
		<td align="right" width="15%">Sacado</td>
		<td width="1%">&nbsp;</td>
		<td><b><font size=3><?php echo $f_razao_social;?></font></b></td></tr>
	</tr>

	<tr>
		<td align="right" width="15%">Vencimento</td>
		<td width="1%">&nbsp;</td>
		<td><b><font size=3><?php echo stodbr($cp_vencimento);?></font></b></td></tr>
	</tr>
	
	<tr>
		<td align="right" width="15%">Valor</td>
		<td width="1%">&nbsp;</td>
		<td><b><font size=3><?php echo number_format($cp_valor,2,',','.');?></font></b></td></tr>
	</tr>	
	
	<tr>
		<td align="right" width="15%">Pedido</td>
		<td width="1%">&nbsp;</td>
		<td><b><font size=3><?php echo $cp_pedido.' '.$cp_doc;?></font></b></td></tr>
	</tr>	
	
	<tr>
		<td align="right" width="15%">Histórico</td>
		<td width="1%">&nbsp;</td>
		<td><b><font size=3><?php echo $cp_historico;?></font></b></td></tr>
	</tr>		

	<tr>
		<td align="right" width="15%">Forma / Boleto</td>
		<td width="1%">&nbsp;</td>
		<td><b><font size=3><?php echo $cp_nossonumero;?></font></b></td></tr>
	</tr>		

	<tr>
		<td align="right" width="15%">Parcela</td>
		<td width="1%">&nbsp;</td>
		<td><b><font size=3><?php echo $cp_parcela;?></font></b></td></tr>
	</tr>
	<tr>
		<td align="right" width="15%">Contato</td>
		<td width="1%">&nbsp;</td>
		<td><b><font size=3><?php echo $contatos;?></font></b></td></tr>
	</tr>

</table>
<br><br>