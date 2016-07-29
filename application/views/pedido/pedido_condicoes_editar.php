<div class="col-md-12" style="margin-top: 20px;">
	<span class="btn btn-primary nopr" id="condicoes_botao_show"> Editar condições </span>
	<span class="btn btn-default nopr" id="condicoes_botao_cancel" style="display: none;"> Cancelar </span>
</div>

<script>
	$("#condicoes_botao_show").click(function() {
		$("#condicoes_botao_show").toggle();
		$("#condicoes_botao_cancel").toggle();
		$("#condicoes").toggle("slow");
		$("#condicoes_editar").toggle("slow");
	});
	$("#condicoes_botao_cancel").click(function() {
		$("#condicoes_botao_show").toggle();
		$("#condicoes_botao_cancel").toggle();
		$("#condicoes").toggle("slow");
		$("#condicoes_editar").toggle("slow");
	});	 
</script>
