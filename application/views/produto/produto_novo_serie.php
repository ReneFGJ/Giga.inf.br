<?php if ($ok == 1) { ?>
<div class="alert alert-success">
  <strong>Successo!</strong> Incluído item <?php echo $dd7.'/'.$dd8;?>!
</div>
<?php } ?>
<form method="post">
    <input type="hidden" name="dd0" value="<?php echo $dd0;?>" />
    <input type="hidden" name="dd2" value="<?php echo $dd2;?>" />
    <input type="hidden" name="dd3" value="<?php echo $dd3;?>" />
    <input type="hidden" name="dd4" value="<?php echo $dd4;?>" />
    <input type="hidden" name="dd5" value="<?php echo $dd5;?>" />
    Nº de Série
    <input type="text" name="dd7" value="" class="form-control" />
    Nº do patrimonio
    <input type="text" name="dd8" value="" class="form-control" />
    Observação do produtos
    <textarea rows=5 name="dd10" class="form-control"><?php echo $dd10;?></textarea>
    <input type="hidden" name="dd9" value="<?php echo $dd9;?>" />
    <input type="hidden" name="dd11" value="<?php echo $dd11;?>" />
    <input type="hidden" name="dd12" value="<?php echo $dd12;?>" />
    <input type="hidden" name="dd13" value="<?php echo $dd13;?>" />
    <input type="hidden" name="dd16" value="<?php echo $dd16;?>" />
    <input type="hidden" name="dd17" value="<?php echo $dd17;?>" />
    <input type="hidden" name="dd18" value="<?php echo $dd18;?>" />
    <input type="hidden" name="dd19" value="<?php echo $dd19;?>" />
    <input type="submit" name="acao" value="Gravar" />
</form>
