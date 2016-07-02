<?php
	$img = '';
	if (strlen($ma_logo) > 0)
		{
			$img = '<img src="'.base_url($ma_logo).'" height="100">';
		}
?>
<div class="container">
	<div class="row">
		<div class="col-md-10"><span class="small">Marca</span><br><span class="superbig"><?php echo $ma_nome;?></span></div>
		<div class="col-md-2"><?php echo $img;?></div>
	</div>
</div>
