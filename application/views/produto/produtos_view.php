<br>
<div class="container">
	<h3>Produtos</h3>
	<?php echo $row;?>
<?php
if (perfil("#GER"))
	{
		$link = ' onclick="newxy(\''.base_url('index.php/main/produto_item/?prod='.$id_prd).'\',800,800);" ';
		echo '<span class="btn btn-default" '.$link.'>Novo Item</span>';
	}
?>		
</div>



