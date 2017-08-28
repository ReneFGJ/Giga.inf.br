<?php
$class = '';

	switch($pp_tipo_pedido)
		{
		case '1':
			$class = 'nopr';
			break;
		case '2':
			break;
		case '3':
			break;
		case '4':
			break;
		case '5':
			break;
		default:
			$class = 'nopr';
			break;
		}
?>
<div class="container">
	<div class="row" class="border_top">
		<div class="col-md-12" style="background-color: <?php echo $t_cor;?>">
			<h3><?php echo $t_descricao;?> <?php echo 'Nº '. strzero($id_pp,6);?></h3>
		</div>
	</div>
	<div class="row" class="border_top">
		<?php echo $dados_proposta; ?>		
	</div>
	
	<div class="row noscreen">
		<div class="col-md-12">
		<?php if (isset($cab)) { echo $cab; } ?>
		</div>
	</div>	
</div>
<div class="npr nopr"><br></div>
<div class="container <?php echo $class;?>">
	<div class="row">
		<?php echo $dados_faturamento; ?>
	</div>	
	<div class="row">
		<?php echo $dados_cliente; ?>
	</div>
</div>
<div class="npr nopr"><br></div>
<div class="container">
	<div class="row">
		<?php echo $dados_item; ?>
	</div>
</div>
<div class="npr nopr"><br></div>
<div class="container">
	<div class="row">
		<?php echo $dados_condicoes; ?>
	</div>

</div>

<?php if ((isset($contatos)) and (strlen($contatos) > 0)) { ?>
<div class="npr nopr"><br></div>
<div class="container">
	<div class="row" >
	    <div class="col-md-12">
		<h3 class="nopr">Contatos</h3>
		<?php echo $contatos; ?>
		</div>
	</div>
</div>
<?php } ?>

<div class="npr nopr"><br></div>
<div class="container">
	<div class="row" >
		<?php echo $dados_acoes; ?>
	</div>
</div>

<div class="container noscreen">
	<div class="row">
		<div class="col-md-12">
			Atenciosamente,<br>
			<span class="middle"><b><?php echo $_SESSION['user'];?></b></span>
		</div>
	</div>	
</div>
