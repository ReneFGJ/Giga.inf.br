<?php
$msg_total = '<span class="badge"><?php echo $mensagens_total;?></span>';
if ($mensagens_total == 0)
	{
		$msg_total = '<span>&nbsp;</span>';
	}
if ($contatos_total == 0)
	{
		$contatos_total = '<span>&nbsp;</span>';
	} else {
		$contatos_total = '<span class="badge">'.$contatos_total.'</span>';		
	}
/***************************** orcamento **********/
$orcamento_total = '<span class="badge">'.$orcamentos_total.'</span>';
if ($orcamentos_total == 0)
	{
		$orcamento_total = '<span>&nbsp;</span>';
	}
?>
<div class="container" style="margin-top: 20px;">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active">
			<a href="#home" aria-controls="home" role="tab" data-toggle="tab">Resumo <span>&nbsp;</span></a>
		</li>
		<li role="presentation">
			<a href="#financeiro" aria-controls="financeiro" role="tab" data-toggle="tab">Financeiro <span class="badge">42</span></a>
		</li>
		<li role="presentation">
			<a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Mensagens <?php echo $msg_total;?></a>
		</li>
		<li role="presentation">
			<a href="#contatos" aria-controls="contato" role="tab" data-toggle="tab">Contatos <?php echo $contatos_total;?></a>
		</li>
		<li role="presentation">
			<a href="#pedidos" aria-controls="pedido" role="tab" data-toggle="tab">Pedidos <span class="badge">42</span></a>
		</li>
		<li role="presentation">
			<a href="#orcamentos" aria-controls="orcamento" role="tab" data-toggle="tab">Propostas Abertas <?php echo $orcamento_total;?></a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade" id="home">
			..1.
		</div>
		<div role="tabpanel" class="tab-pane fade" id="financeiro">
			..2.
		</div>
		<div role="tabpanel" class="tab-pane fade" id="messages">
			<?php echo $mensagens;?>
		</div>
		<div role="tabpanel" class="tab-pane" id="contatos">
			<?php echo $contatos;?>
		</div>
		<div role="tabpanel" class="tab-pane" id="pedidos">
			..5.
		</div>
		<div role="tabpanel" class="tab-pane" id="orcamentos">
			<?php echo $orcamentos; ?>
		</div>				
	</div>

</div>

<script>
	$('#myTabs a[href="#profile"]').tab('show')// Select tab by name
	$('#myTabs a:first').tab('show')// Select first tab
	$('#myTabs a:last').tab('show')// Select last tab
	$('#myTabs li:eq(2) a').tab('show')// Select third tab (0-indexed)

	$('#myTabs a').click(function(e) {
		e.preventDefault()
		$(this).tab('show')
	})
</script>