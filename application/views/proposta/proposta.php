<div class="container">
	<table width="100%">
		<tr>
			<th width="65"></th>
			<th></th>
		</tr>
		<tr valign="top" class="nopr">
			<td class="bg_item_0"><span class="textoVertical superbig roboto pad5">nr</span></td>
			<td class="pad5"><?php echo $dados_proposta;?></td>
		</tr>	
		<tr valign="top" class="noscreen">
			<td class="pad5" colspan=2>A<br><b><?php echo $f_nome_fantasia;?></b>
				<br><br>
				Venho por meio desta apresentar proposta comercial do(s) seguinte(s) item(ns):
				<br>				
			</td>
		</tr>			
		<tr valign="top" class="nopr">
			<td class="bg_item_1"><span class="textoVertical superbig roboto pad5">cliente</span></td>
			<td class="pad5"><?php echo $dados_cliente;?></td>
		</tr>
		<tr valign="top">
			<td class="bg_item_2 nopr"><span class="textoVertical superbig roboto pad5">itens</span></td>
			<td class="pad5"><div  style="min-height: 100px;">
				<?php echo $dados_item;?>
			</div></td>
		</tr>
		<tr valign="top">
			<td class="bg_item_3 nopr"><span class="textoVertical superbig roboto pad5">condições</span></td>
			<td class="pad5"><div  style="min-height: 100px;">
				<?php echo $dados_condicoes;?>
			</div></td>			
		</tr>
	</table>
</div>
