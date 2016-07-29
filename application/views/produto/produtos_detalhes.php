<br>
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<span class="small">serial</span><br>
			<span class="superbig"><?php echo $pr_serial;?>&nbsp;</span><br>
			
			<span class="small">Nº patrimonio</span><br>
			<span class="superbig"><?php echo $pr_patrimonio;?>&nbsp;</span><br>
			
			<span class="small">Nº tag</span><br>
			<span class="superbig"><?php echo $pr_tag;?>&nbsp;</span><br>	
			
			<span class="small">dados da compra</span><br>
			<span class="superbig"><?php echo stodbr($pr_nf_data);?>&nbsp;<?php echo $pr_nf;?></span><br>					
		</div>
		<div class="col-md-8">
			<span class="small">guarda da filial</span><br>
			<span class="superbig"><?php echo $fi_nome_fantasia;?>&nbsp;</span><br>
			
			<span class="small">Situação do produto</span><br>
			<button class="big <?php echo $ps_class;?>"><?php echo $ps_descricao;?>&nbsp;</button><br>
			<br>
			<span class="small">cliente</span><br>
			<span class="superbig"><?php echo $f_nome_fantasia;?>&nbsp;</span><br>	
			
			<span class="small">data de fornecimento</span><br>
			<span class="superbig"><?php echo stodbr($pr_cliente_dt);?>&nbsp;</span><br>	
		</div>
	</div>
</div>
<br>
