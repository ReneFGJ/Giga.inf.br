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
			
            <br><br>
            <font class="small">Data nascimento</font><br>
            <font class="middle"><?php echo stodbr($usd_nascimento); ?></font>						

			<hr>
			<?php
			if ($id_us == $_SESSION['id']) {
				echo '<ul class="item_menu">' . cr();
				echo '<li><a href="' . base_url('index.php/main/change_password') . '" class="middle">Alterar senha</a></li>';
				echo '<li><a href="' . base_url('index.php/main/change_my_email') . '" class="middle">Alterar e-mail</a></li>';
				echo '<li><a href="' . base_url('index.php/admin/user_drh_edit') . '" class="middle">Atualizar dados pessoais</a></li>';
				echo '<li><a href="' . base_url('index.php/main/change_my_sign') . '" class="middle">Atualizar assinatura comercial</a></li>';
				echo '<li><a href="' . base_url('index.php/main/change_my_picture/'.$id_us.'/'.checkpost_link($id_us)) . '" class="middle">Atualizar fotografia</a></li>';
				echo '</ul>' . cr();
			}
			if (perfil("#ADM#DRH"))
				{
				echo '<ul class="item_menu">' . cr();
				echo '<li><a href="' . base_url('index.php/admin/user_reset_password/'.$id_us.'/'.checkpost_link($id_us)) . '" class="middle">Gerar nova senha</a></li>';
                echo '<li><a href="'.base_url('index.php/admin/user_drh_edit/'.$id_us.'/'.checkpost_link($id_us)).'" class="middle">'.msg('edit_person_data').'</a></li>';
                echo '<li><a href="' . base_url('index.php/main/change_my_picture/'.$id_us.'/'.checkpost_link($id_us)) . '" class="middle">Atualizar fotografia</a></li>';                                
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
            <br>            
            <font class="small">Carteira de Motorista</font><br>
            <font class="middle"><?php
            echo $usd_cnh;
            if (strlen($usd_cnh_cat)) { echo ', Categoria: ' . $usd_cnh_cat;
            }
            ?>&nbsp;</font>
            <br><br>
            <font class="small">Título de eleitor</font><br>
            <font class="middle"><?php
            echo $usd_te;
            if (strlen($usd_te_zona)) { echo ', Zona: ' . $usd_te_zona; }
            if (strlen($usd_te_secao)) { echo ', Seção: ' . $usd_te_secao; }
            
            ?>&nbsp;</font>

		</div>
		<div class="col-md-4">
			<br>
			<font class="small">Nome do Pai</font><br>
			<font class="middle"><?php echo $usd_nome_pai; ?>&nbsp;</font><br>
			<font class="small">Nome da Mãe</font><br>
			<font class="middle"><?php echo $usd_nome_mae; ?>&nbsp;</font><br>
            <font class="small">Estado cívil</font><br>
            <font class="middle"><?php echo $usd_estado_civel; ?>&nbsp;</font><br>
            <font class="small">Filhos</font><br>
            <font class="middle"><?php echo $usd_filhos; ?>&nbsp;</font><br>
            <font class="small">Escolaridade</font><br>
            <font class="middle"><?php echo $usd_escolaridade; ?>&nbsp;</font><br>
						
			<hr>
			<font class="small">Empresa</font><br>
			<font class="middle"><?php echo $fi_razao_social; ?>&nbsp;</font><br>
			<font class="small">Cargo / departamento</font><br>
			<font class="middle"><?php echo $usd_cargo . ' / ' . $usd_departamento; ?>&nbsp;</font><br>
			<font class="small">Dt. adminssão / demissão</font><br>
			<font class="middle"><?php echo stodbr($usd_dt_admissao); ?>&nbsp;</font> - <?php echo stodbr($usd_dt_demissao); ?>&nbsp;</font><br>
			<font class="small">Crachá</font><br>
			<font class="middle"><?php echo($us_badge); ?>&nbsp;</font><br>		
			
			<h4>Dados bancários</h4>
            <font class="small">Banco</font><br>
            <font class="middle"><?php echo $usd_banco; ?>&nbsp;</font><br>
            <font class="small">Agência</font><br>
            <font class="middle"><?php echo $usd_ag; ?>&nbsp;</font><br>
            <font class="small">Conta Corrente</font><br>
            <font class="middle"><?php echo $usd_cc.' - '.msg('cc_tipo_'.$usd_cc_tipo); ?></font><br>
				
		</div>
	</div>

