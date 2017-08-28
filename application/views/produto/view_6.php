<?php

$img = base_url('img/produto/no_picture-640x480.png');
$img_alterar = '<a href="#" onclick="newwin(\'' . base_url('index.php/main/picture') . '/' . $id_pr . '/PRODT\');" class="small">alterar imagem</a>';
$editar = base_url('index.php/main/produtos_edit/' . $id_pr . '/' . checkpost_link($id_pr));
$editar = '<a href="' . $editar . '" class="small nopr">editar</a><br>';
if (count($imgs) > 0) {
	$img = base_url($imgs[0]['doc_arquivo']);
}
$linkp = base_url('index.php/main/produtos_view/' . $id_pr . '/' . checkpost_link($id_pr));
$linkp = '<a href="' . $linkp . '">';
?>
		
			<span class="small">produto</span><br>
			<span class="superbig"><?php echo $linkp . $pc_desc_basica . '</a>'; ?></span><br>

			<span class="small">marca</span><br>
			<span class="big"><?php echo $ma_nome; ?></span><br>
			
			<span class="small">patrimônio</span><br>
			<span class="big"><?php echo $pr_patrimonio; ?></span><br>

			<span class="small">modelo</span><br>
			<span class="big"><?php echo $pr_modelo; ?></span><br>

			<span class="small">serial</span><br>
			<span class="big"><?php echo $pr_serial; ?></span><br>

			<span class="small">descrição</span><br>
			<a href="<?php echo base_url('index.php/main/produtos_categoria_view/' . $id_pc . '/' . checkpost_link($id_pc)); ?>"><span class="big"><?php echo $pc_nome; ?></span></a><br>
			<hr>
			<span class="small">situação</span><br>	
			<a href="#" class="big"><?php echo mst($ps_descricao); ?></a><br>
			
			<span class="small">localização</span><br>	
			<a href="#" class="big"><?php echo mst($fi_nome_fantasia); ?></a>
			
