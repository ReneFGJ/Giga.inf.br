<div class="container nopr">
	<div class="row">
		<div class="col-md-11">
			<span class="small">nome do cliente</span><br>
			<span class="big"><?php echo $f_nome_fantasia; ?> / <?php echo $f_razao_social; ?></span>
		</div>
		<div class="col-md-1 text-right">
			<button class="btn btn-primary" id="cliente_data">
			<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" id="cliente_icone"></span>
			</button>
		</div>
	</div>

	<!------------------------------------------ CNPJ ------------->
	<div class="row" style="margin-top: 10px; display: none;" id="clie01">
		<div class="col-md-4"><span class="small">CNPJ</span><br><span class="big"><?php echo $f_cnpj; ?>&nbsp;</span></div>
		<div class="col-md-4"><span class="small">Insc. Estadual</span><br><span class="big"><?php echo $f_ie; ?>&nbsp;</span></div>
		<div class="col-md-4"><span class="small">Insc. Municipal</span><br><span class="big"><?php echo $f_im; ?>&nbsp;</span></div>
	</div>

	<!------------------------------------------ Endereco ------------->
	<div class="row" style="margin-top: 10px; display: none;" id="clie02">
		<div class="col-md-5"><span class="small">Logradouro</span><br><span class="big"><?php echo $f_logradouro; ?> <?php echo $f_numero; ?> <?php echo $f_complemento; ?></span></div>
		<div class="col-md-2"><span class="small">CEP</span><br><span class="big"><?php echo $f_cep; ?></span></div>
		<div class="col-md-2"><span class="small">Bairro</span><br><span class="big"><?php echo $f_bairro; ?></span></div>
		<div class="col-md-3"><span class="small">Cidade</span><br><span class="big"><?php echo $f_cidade; ?> <?php echo $f_estado; ?></span></div>
	</div>
	<div class="row nopr">
		<div class="col-md-2"><span class="small">Contato</span></div>
		<div class="col-md-2"><span class="small">Função</span></div>		
		<div class="col-md-2"><span class="small">Telefone</span></div>		
		<div class="col-md-2"><span class="small">e-mail</span></div>
	</div>
	<?php
	for ($r=0;$r < count($contacts);$r++)
		{
			echo '<div class="row nopr">'.cr();
			echo '<div class="col-md-2">'.$contacts[$r]['cc_nome'].'</div>';
			echo '<div class="col-md-2">'.$contacts[$r]['ct_nome'].'</div>';
			echo '<div class="col-md-2">'.$contacts[$r]['cc_telefone'].'</div>';
			echo '<div class="col-md-2">'.$contacts[$r]['cc_email'].'</div>';
			echo '</div>'.cr();
		}
	if (count($contacts) == 0)
		{
			echo '<div class="row"><div class="col-md-12"><b><font color="red">Sem contatos registrados</font></div></div>'.cr();
		}
	?>
</div>

<script>
	$("#cliente_data").click(function() {
		$("#cliente_icone").toggleClass("glyphicon-triangle-top");
		$("#cliente_icone").toggleClass("glyphicon-triangle-bottom");
		$("#clie01").toggle("slow");
		$("#clie02").toggle("slow");
		$("#clie03").toggle("slow");
	}); 
</script>