<div class="container nopr">
	<div class="row">
		<div class="col-md-10">
			<span class="small">dados para faturamento</span><br>
			<span class="big"><b><?php echo $f_nome_fantasia;?> / <?php echo $f_razao_social;?></b></span>
		</div>
		<div class="col-md-2 text-right">
			<button class="btn btn-primary" id="cliente_data_2">
			<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" id="cliente_icone_2"></span>
			</button>
			<?php if ($editar==1) { ?>	
			<button class="btn btn-primary" id="cliente_data_3">
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" id="cliente_icone_3a"></span>
			</button>			
			<?php } ?>
		</div>
	</div>

	<!------------------------------------------ CNPJ ------------->
	<div class="row" style="margin-top: 10px; display: none;" id="clie01f">
		<div class="col-md-4"><span class="small">CNPJ</span><br><span class="big"><?php echo $f_cnpj;?>&nbsp;</span></div>
		<div class="col-md-4"><span class="small">Insc. Estadual</span><br><span class="big"><?php echo $f_ie;?>&nbsp;</span></div>
		<div class="col-md-4"><span class="small">Insc. Municipal</span><br><span class="big"><?php echo $f_im;?>&nbsp;</span></div>
	</div>

	<!------------------------------------------ Endereco ------------->
	<div class="row" style="margin-top: 10px; display: none;" id="clie02f">
		<div class="col-md-5"><span class="small">Logradouro</span><br><span class="big"><?php echo $f_logradouro;?> <?php echo $f_numero;?> <?php echo $f_complemento;?></span></div>
		<div class="col-md-2"><span class="small">CEP</span><br><span class="big"><?php echo $f_cep;?></span></div>
		<div class="col-md-2"><span class="small">Bairro</span><br><span class="big"><?php echo $f_bairro;?></span></div>
		<div class="col-md-3"><span class="small">Cidade</span><br><span class="big"><?php echo $f_cidade;?> <?php echo $f_estado;?></span></div>
	</div>
</div>

<script>
	$("#cliente_data_2").click(function() {
		$("#cliente_icone_2").toggleClass( "glyphicon-triangle-top" );
		$("#cliente_icone_2").toggleClass( "glyphicon-triangle-bottom" );
		$("#clie01f").toggle("slow");
		$("#clie02f").toggle("slow");
		$("#clie03f").toggle("slow"); 
	});
	
</script>

<script>
	$("#cliente_data_3").click(function() {
		newxy('<?php echo base_url('index.php/main/cliente_faturamento/'.$id_pp.'/'.checkpost_link($id_pp));?>',800,700);
	});
</script>