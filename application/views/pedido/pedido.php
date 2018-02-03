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
?><div class="row" class="border_top">
        <div class="col-md-12">
        <?php echo $dados_proposta; ?>
        </div>          
    </div>    


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
	    <div class="col-md-12" >
		<?php echo $dados_condicoes; ?>
		</div>
	</div>

</div>



<div class="npr nopr"><br></div>
<div class="container nopr">
	<div class="col-md-12" >
	    <div class="row" >
		<?php echo $dados_acoes; ?>
		<div class="row" >
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
