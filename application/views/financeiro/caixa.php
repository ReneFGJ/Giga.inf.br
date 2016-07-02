<div class="container">
	<h1>Controle diário de caixa</h1>
	<div class="row big">
		<div class="col-md-10 text-right">Abertura de Caixa</div>
		<div class="col-md-2  text-right alert-info"><?php echo number_format(0,2,',','.');?></div>
	</div>
	<br>
	<table width="100%" class="table">
		<tr align="center" class="small">
			<th width="5%">dia</th>
			<th width="60%">histórico</th>
			<th width="5%">parcela</th>
			<th width="10%">entrada</th>
			<th width="10%">saída</th>
			<th width="10%">saldo</th>
		</tr>
		<?php echo $dados;?>
	</table>
	
</div>
