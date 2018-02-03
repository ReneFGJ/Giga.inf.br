<div class="container">
	<div class="row">
		<div class="col-md-11">
			<span class="small">nome do cliente</span><br>
			<span class="big"><?php echo $f_nome_fantasia; ?> / <?php echo $f_razao_social; ?></span>
		</div>
		<div class="col-md-1 text-right nopr">
			<button class="btn btn-primary" id="cliente_data">
			<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true" id="cliente_icone"></span>
			</button>
		</div>
	</div>
	<div class="row nopr">
        <div class="col-md-12">
            <a href="<?php echo base_url('index.php/main/clientes_edit/'.$id_f.'/'.checkpost_link($id_f));?>" class="small">editar</a>
        </div>
    </div>
	<!------------------------------------------ CNPJ ------------->
	<div class="row noscreen2" style="margin-top: 10px;" id="clie01">
		<div class="col-md-4 col-xs-4""><span class="small">CNPJ</span><br><span class="big"><?php echo $f_cnpj; ?>&nbsp;</span></div>
		<div class="col-md-4 col-xs-4""><span class="small">Insc. Estadual</span><br><span class="big"><?php echo $f_ie; ?>&nbsp;</span></div>
		<div class="col-md-3 col-xs-3""><span class="small">Insc. Municipal</span><br><span class="big"><?php echo $f_im; ?>&nbsp;</span></div>
		<div class="col-md-1 col-xs-1""><span class="small">N. Cadastr.</span><br><span class="big"><?php echo $id_f; ?>&nbsp;</span></div>
	</div>

	<!------------------------------------------ Endereco ------------->
	<div class="row noscreen2" style="margin-top: 10px;" id="clie02">
		<div class="col-md-5 col-xs-5"><span class="small">Logradouro</span><br><span class="big"><?php echo $f_logradouro; ?> <?php echo $f_numero; ?> <?php echo $f_complemento; ?></span></div>
		<div class="col-md-2 col-xs-2""><span class="small">CEP</span><br><span class="big"><?php echo $f_cep; ?></span></div>
		<div class="col-md-2 col-xs-2""><span class="small">Bairro</span><br><span class="big"><?php echo $f_bairro; ?></span></div>
		<div class="col-md-3 col-xs-3""><span class="small">Cidade</span><br><span class="big"><?php echo $f_cidade; ?> <?php echo $f_estado; ?></span></div>
	</div>
	
	<table class="table" width="100%">
	<tr>
		<td><span class="small">Contato</span></td>
		<td><span class="small">Função</span></td>		
		<td><span class="small">Telefone</span></td>		
		<td><span class="small">e-mail</span></td>
	</tr>
	
	<?php
	for ($r=0;$r < count($contacts);$r++)
		{
			echo '<tr>'.cr();
			echo '<td>'.$contacts[$r]['cc_nome'].'</td>';
			echo '<td>'.$contacts[$r]['ct_nome'].'</td>';
			echo '<td>'.$contacts[$r]['cc_telefone'].'</td>';
			echo '<td>'.$contacts[$r]['cc_email'].'</td>';
			echo '</tr>'.cr();
		}
	if (count($contacts) == 0)
		{
			echo '<tr><td colspan=5><b><font color="red">Sem contatos registrados</font></td></tr>'.cr();
		}
	?>
	</table>
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