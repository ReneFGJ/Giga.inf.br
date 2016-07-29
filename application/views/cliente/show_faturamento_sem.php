<div class="container nopr">
	<div class="row">
		<div class="col-md-11">
			<span class="small">dados para faturamento</span><br>
			<span class="big"><b>Mesmos dados do cliente</b></span>
		</div>
		<?php if ($editar==1) { ?>
		<div class="col-md-1 text-right">
			<button class="btn btn-primary" id="cliente_icone_3">
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" id="cliente_icone_3a"></span>
			</button>
		</div>
		<?php } ?>
	</div>
</div>

<script>
	$("#cliente_icone_3").click(function() {
		newxy('<?php echo base_url('index.php/main/cliente_faturamento/'.$id_pp.'/'.checkpost_link($id_pp));?>',800,700);
	});
</script>