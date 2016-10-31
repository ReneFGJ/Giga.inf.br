<div class="container">
	<div class="row">
		<div class="col-md-4">
			<h1>Locação</h1>
		</div>
	</div>
</div>
<br>
<?php
if (isset($locacoes_aberto))
{
	echo '<div class="container"><div class="row">'.$locacoes_aberto.'</div></div><br>'.cr();
}
if (isset($locacoes_em_locacao))
{
	echo '<div class="container"><div class="row">'.$locacoes_em_locacao.'</div></div><br>'.cr();
}
?>
