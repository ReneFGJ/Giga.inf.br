<?php
$pict = 'img/picture/photo-' . $us_badge . '.jpg';
if (!file_exists($pict)) {
	$picture = base_url('img/picture/img-no-picture.png');
} else {
	$picture = base_url($pict);
}
?>

	<div class="row">
		<div class="col-md-4">
			<img id="profile-picture" class="person-graphic win-color-bg-10" alt=""
			src="<?php echo $picture; ?>">
			
			<br><br>
			<font class="small">nome</font><br>
			<font class="big"><?php echo $us_nome; ?></font>
			
			<br><br>
			<font class="small">telefone</font><br>
			<font class="big"><?php echo $usd_fone_1 . ' ' . $usd_fone_2; ?></font>			
			
			<br><br>
			<font class="small">e-mail</font><br>
			<font class="big"><?php echo $us_email; ?></font>
			
			<br><br>
			<font class="small">login</font><br>
			<font class="middle"><?php echo $us_login; ?></font>			

			<hr>
			<?php
			if ($id_us == $_SESSION['id']) {
				echo '<ul class="item_menu">' . cr();
				echo '<li><a href="' . base_url('index.php/main/change_password') . '" class="middle">Alterar senha</a></li>';
				echo '<li><a href="' . base_url('index.php/main/change_my_email') . '" class="middle">Alterar e-mail</a></li>';
				echo '<li><a href="#" class="middle">Alterar dados pessoais</a></li>';
				echo '</ul>' . cr();
			}
			?>
		</div>
		
		<div class="col-md-8">
			<font class="xxxbig roboto"><b><?php echo $us_nome; ?></b></font>
		</div>
		<div class="col-md-4">	
			<?php if (isset($content)) { echo $content; } ?>	
		</div>
	</div>

