<?php
if ($result == 0) {
	$result_it = '';
	$result_view = 'style="display: block;" ';
} else {
	$result_it = '<span class="glyphicon glyphicon-triangle-bottom btn-primary" style="padding: 10px; border-radius: 10px;" aria-hidden="true" id="icones2"></span>';
	//$result_it .= '<span class="glyphicon glyphicon-triangle-bottom btn-primary" style="display: none; padding: 10px; border-radius: 10px;" aria-hidden="true" id="icones1"></span>';
	$result_view = 'style="display: none;" ';
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php
			if (isset($title)) {
				echo '<h3>' . $title . '</h3>';
			}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-11">
			<div id="buscas_form" <?php echo $result_view; ?>>
				<?php
				echo $content;
				?>
			</div>
		</div>
		<div class="col-md-1">
			<?php
			echo $result_it;
			?>
		</div>
	</div>
</div>

<script>
	$("#icones2").click(function() {
		$("#icones2").toggle();
		$("#buscas_form").fadeIn("slow");
	});
</script>