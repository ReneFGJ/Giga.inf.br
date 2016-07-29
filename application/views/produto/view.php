<?php

$img = base_url('img/produto/no_picture-640x480.png');
$img_alterar = '<a href="#" onclick="newwin(\''.base_url('index.php/main/picture').'/'.$id_prd.'/PRODT\');" class="small">alterar imagem</a>';
$editar = base_url('index.php/main/produtos_edit/'.$id_prd.'/'.checkpost_link($id_prd));
$editar = '<a href="'.$editar.'" class="small nopr">editar</a><br>';
if (count($imgs) > 0)
	{
		$img = base_url($imgs[0]['doc_arquivo']);		
	}
$linkp = base_url('index.php/main/produtos_view/'.$id_prd.'/'.checkpost_link($id_prd));
$linkp = '<a href="'.$linkp.'">';
?>
<div class="container">
	<div class="row">
		<div class="col-sm-2 col-md-3">			
			<?php echo $imagens;?>
		</div>
		<div class="col-sm-10 col-md-5">
			
			<span class="small">produto</span><br>
			<span class="superbig"><?php echo $linkp.$prd_nome.'</a>';?></span><br>
			<?php echo $editar;?><br>

			<span class="small">marca</span><br>
			<span class="big"><?php echo $ma_nome;?></span><br>

			<span class="small">categoria</span><br>
			<a href="<?php echo base_url('index.php/main/produtos_categoria_view/'.$id_pc.'/'.checkpost_link($id_pc));?>"><span class="big"><?php echo $pc_nome;?></span></a><br>
			
		</div>
		<div class="col-sm-12 col-md-4">
			<?php echo mst($prd_descricao);?>
		</div>
	</div>
</div>
