<?php
$msg_total = '<span class="badge"><?php echo $mensagens_total;?></span>';
if ($mensagens_total == 0)
	{
		$msg_total = '<span>&nbsp;</span>';
	}
if ($pedidos_total == 0)
	{
		$pedidos_total = '<span>&nbsp;</span>';
	} else {
		$pedidos_total = '<span class="badge">'.$pedidos_total.'</span>';		
	}
/***************************** orcamento **********/
$orcamento_total = '<span class="badge">'.$orcamentos_total.'</span>';
if ($orcamentos_total == 0)
	{
		$orcamento_total = '<span>&nbsp;</span>';
	}
/***************************** contato ***********/	
$contatos_total = '<span class="badge">'.$contatos_total.'</span>';
if ($contatos_total == 0)
	{
		$contatos_total = '<span>&nbsp;</span>';
	}
/***************************** contato ***********/	
$labo_total = '<span class="badge">'.$labos_total.'</span>';
if ($labos_total == 0)
	{
		$labo_total = '<span>&nbsp;</span>';
	}
/***************************** contato ***********/	
$onsite_total = '<span class="badge">'.$onsites_total.'</span>';
if ($onsites_total == 0)
	{
		$onsite_total = '<span>&nbsp;</span>';
	}
/***************************** contato ***********/	
$locacao_total = '<span class="badge">'.$locacoes_total.'</span>';
if ($locacoes_total == 0)
	{
		$locacao_total = '<span>&nbsp;</span>';
	}
/***************************** contato ***********/	
if (!isset($finan_total)) { $finan_total = 0; $financeiro = '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>'; }
$fin_total = '<span class="badge">'.$finan_total.'</span>';
if ($finan_total == 0)
	{
		$fin_total = '<span>&nbsp;</span>';
	}	
				
echo $model;	
?>
<div class="container" style="margin-top: 20px;">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active">
			<a href="#home" aria-controls="home" role="tab" data-toggle="tab">Resumo <span>&nbsp;</span></a>
		</li>
		<li role="presentation">
			<a href="#financeiro" aria-controls="financeiro" role="tab" data-toggle="tab">Financeiro <?php echo $fin_total;?></a>
		</li>
		<li role="presentation">
			<a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Mensagens <?php echo $msg_total;?></a>
		</li>
		<li role="presentation">
			<a href="#contatos" aria-controls="contato" role="tab" data-toggle="tab">Contatos <?php echo $contatos_total;?></a>
		</li>
		<li role="presentation">
			<a href="#orcamentos" aria-controls="orcamento" role="tab" data-toggle="tab">Propostas <?php echo $orcamento_total;?></a>
		</li>		
		<li role="presentation">
			<a href="#pedidos" aria-controls="pedido" role="tab" data-toggle="tab">Pedidos <?php echo $pedidos_total;?></a>
		</li>
		<li role="presentation">
			<a href="#locacao" aria-controls="locacao" role="tab" data-toggle="tab">Locações <?php echo $locacao_total;?></a>
		</li>
		<li role="presentation">
			<a href="#laboratorio" aria-controls="laboratorio" role="tab" data-toggle="tab">Serviços Lab. <?php echo $labo_total;?></a>
		</li>
		<li role="presentation">
			<a href="#onsite" aria-controls="onsite" role="tab" data-toggle="tab">Onsite <?php echo $onsite_total;?></a>
		</li>						
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="home">
			<?php echo $resumo;?>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="financeiro">
			<?php echo $financeiro;?>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="messages">
			<?php echo $mensagens;?>
		</div>
		<div role="tabpanel" class="tab-pane" id="contatos">
			<?php echo $contatos;?>
		</div>
		<div role="tabpanel" class="tab-pane" id="pedidos">
			<?php echo $pedidos; ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="orcamentos">
			<?php echo $orcamentos; ?>
		</div>	
		<div role="tabpanel" class="tab-pane" id="locacao">
			<?php echo $locacao; ?>
		</div>	
		<div role="tabpanel" class="tab-pane" id="laboratorio">
			<?php echo $labo; ?>
		</div>	
		<div role="tabpanel" class="tab-pane" id="onsite">
			<?php echo $onsite; ?>
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