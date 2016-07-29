<?php
if (isset($title)) { echo '<h1>'.$title.'</h1>'; }
?>
<form id="upload" method="post" enctype="multipart/form-data">
	<fieldset>
		<legend>
			Arquivo para Upload
		</legend>
		<span id="post">
			<input type="file" name="arquivo" id="arquivo" />
		</span>
		<input type="submit" value="enviar arquivo" name="acao" id="idbotao" />
		<BR>
	</fieldset>
</form>