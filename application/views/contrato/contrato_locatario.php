<br>
<table width="100%" cellpadding=5  style="border: 1px solid #000000;">
	<tr><td colspan=2><h4>LOCATÁRIO</h4></td></tr>
	<tr><td width="20%" align="right">Razão Social </td>
		<td><b><?php echo $f_razao_social;?></b></td>
	</tr>
    <tr><td width="20%" align="right">Nome Fantasia</td>
        <td><b><?php echo $f_nome_fantasia;?></b></td>
    </tr>
  	<tr><td align="right">CPF/CNPJ </td>
		<td><b><?php echo $f_cnpj;?></b></td>
	</tr>	
	<tr><td align="right">Endereço </td>
		<td><b><?php echo $f_logradouro.', '.$f_numero.' '.$f_complemento;?></b></td>
	</tr>
	<tr><td align="right"></td>
		<td><b><?php echo $f_bairro.', '.$f_cidade.'-'.$f_estado;?></b></td>
	</tr>		
</table>
<br>