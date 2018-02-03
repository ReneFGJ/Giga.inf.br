<span style="text-decoration: underline; font-size: 100%;">Mesmos dados do cliente</b></span>
<?php if ($editar==1) { ?>
<div class="col-md-1 text-right nopr">
	<button class="btn btn-primary" id="cliente_icone_3">
	<span class="glyphicon glyphicon-pencil" aria-hidden="true" id="cliente_icone_3a"></span>
	</button>
</div>
<?php } ?>
<script>
	$("#cliente_icone_3").click(function() {
		newxy('<?php echo base_url('index.php/main/cliente_faturamento/'.$id_pp.'/'.checkpost_link($id_pp));?>',800,700);
	});
</script>