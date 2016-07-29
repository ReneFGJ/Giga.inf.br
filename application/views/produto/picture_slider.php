<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	<!-- Controls -->
	<a class="left carousel-control-2" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
	<a class="right carousel-control-2" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
	<a href="#" onclick="newwin('<?php echo base_url('index.php/main/picture').'/'.$id_prd.'/1';?>');" >alterar imagem</a>	
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<?php
		for ($r=0;$r < count($imgs);$r++)
			{
				$class = '';
				if ($r == 0) { $class = 'active'; }
				echo '<li data-target="#carousel-example-generic" data-slide-to="0" class="'.$class.'"></li>'.cr();
			}
		?>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<?php
			for ($r = 0; $r < count($imgs); $r++) {
				$class = '';
				if ($r == 0) { $class = "active";
				}
				echo '<div class="item ' . $class . '">' . cr();
				echo '<img src="' . base_url($imgs[$r]['doc_arquivo']) . '" class="img-thumbnail img-responsive" >' . cr();
				echo '</div>' . cr();
			}
		?>
	</div>

</div>