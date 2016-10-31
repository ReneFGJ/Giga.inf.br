<?php
$dd1 = get("dd1");
$dd2 = get("dd2");
?>
<form method="post">
<div class="row">
	<div class="col-lg-12">
		
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Pesquisar por ...." name="dd1" value="<?php echo $dd1;?>">
				<span class="input-group-btn">
					<input type="submit" name="acao"  class="btn btn-default" value="Procurar!">
				</span>
			</div><!-- /input-group -->
		
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->
<br>
<div class="row">
	<div class="col-lg-12">	
		<font class="supersmall"><?php echo msg('categoria');?></font>	
				<select class="form-control" name="dd2" call="form-control">
					<option value=""  style="width: 100%;">::Todas as categorias</option>
					<?php
					$sql = "select * from produtos_categoria where pc_ativo = 1 order by pc_nome ";
					$rlt = $this->db->query($sql);
					$rlt = $rlt->result_array();
					for ($r=0;$r < count($rlt);$r++)
						{
							$line = $rlt[$r];
							$sel = '';
							if ($dd2 == $line['id_pc']) { $sel = 'selected'; }
							echo '<option value="'.$line['id_pc'].'"  style="width: 100%;" '.$sel.'>'.$line['pc_nome'].'</option>'.cr();		
						}
					?>
				</select>		
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->
</form>
<br>