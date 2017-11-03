<div class="col-md-6">
	<form method="post">
		<div class="input-group">
			<input name="dd1" id="dd1" type="text" class="form-control" placeholder="Código...">
			<span class="input-group-btn">
				<input type="submit" class="btn btn-secondary" name="acao" value="Go!" />
			</span>
		</div>
	</form>
</div>
<div class="col-md-6">
	<?php echo $dados_produto;?>
</div>

<script>
    $("#dd1").focus();
</script>