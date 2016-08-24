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
		<div class="col-md-12">
			<?php
			echo $content;
			?>			
		</div>
	</div>
</div>