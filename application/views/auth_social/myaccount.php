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
			<br>
			<font class="small">Endereço</font><br>
			<font class="middle"><?php echo $usd_logradouro . ' ' . $usd_numero . ' ' . $usd_complemento; ?>&nbsp;</font><br>
			<font class="small">Bairro / CEP</font><br>
			<font class="middle"><?php echo $usd_bairro . ' - ' . $usd_cep; ?>&nbsp;</font><br>
			<font class="small">Cidade / Estado</font><br>
			<font class="middle"><?php echo $usd_cidade . ' - ' . $usd_estado; ?>&nbsp;</font><br>			
			
			<hr>
			<font class="small">CPF</font><br>
			<font class="middle"><?php echo mask_cpf($usd_cpf); ?>&nbsp;</font><br>
			<font class="small">RG</font><br>
			<font class="middle"><?php echo $usd_rg . ' ' . $usd_rg_emissor . ' ' . stodbr($usd_rg_dt_emissao); ?>&nbsp;</font><br>
			<font class="small">PIS</font><br>
			<font class="middle"><?php echo $usd_pis; ?>&nbsp;</font><br>
			<font class="small">Carteira de Trabalho</font><br>
			<font class="middle"><?php
			echo $usd_ct . ' ';
			if (strlen($usd_ct_serie)) { echo ', Série: ' . $usd_ct_serie;
			}
			?>&nbsp;</font>
		</div>
		<div class="col-md-4">
			<br>
			<font class="small">Nome do Pai</font><br>
			<font class="middle"><?php echo $usd_nome_pai; ?>&nbsp;</font><br>
			<font class="small">Nome da Mãe</font><br>
			<font class="middle"><?php echo $usd_nome_mae; ?>&nbsp;</font><br>
						
			<hr>
			<font class="small">Empresa</font><br>
			<font class="middle"><?php echo $fi_razao_social; ?>&nbsp;</font><br>
			<font class="small">Cargo / departamento</font><br>
			<font class="middle"><?php echo $usd_cargo . ' / ' . $usd_departamento; ?>&nbsp;</font><br>
			<font class="small">Dt. adminssão</font><br>
			<font class="middle"><?php echo stodbr($usd_dt_admissao); ?>&nbsp;</font><br>
			<font class="small">Crachá</font><br>
			<font class="middle"><?php echo($us_badge); ?>&nbsp;</font><br>			
		</div>
	</div>
