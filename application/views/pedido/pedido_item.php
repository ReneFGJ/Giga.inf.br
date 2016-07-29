<div class="col-md-12" class="nopr">
	<button type="button" class="btn btn-primary nopr" onclick="novoitem();">
		Incluir novo item
	</button>	
</div>
<script>
	function novoitem()
	{
	newwin('<?php echo base_url('index.php/main/pedido_item_editar/0/' . $id_pp . '/' . checkpost_link($id_pp)); ?>');
	}
</script>