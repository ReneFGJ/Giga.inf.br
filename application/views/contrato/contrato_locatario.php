<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h3><?php echo $title;?></h3>
    </div>
</div>

<div class="row">
    <div class="col-md-2 col-sm-3 col-xs-3 text-right">
        Razão Social
    </div>
    <div class="col-md-10 col-sm-9 col-xs-9">
        <b><?php echo $f_razao_social;?></b>
    </div>
</div>
<?php if ($f_razao_social != $f_nome_fantasia) { ?>
<div class="row">
    <div class="col-md-2 col-sm-3 col-xs-3 text-right">
        Nome Fantasia
    </div>
    <div class="col-md-10 col-sm-9 col-xs-9">
        <?php echo ucfirst(strtolower($f_nome_fantasia));?>
    </div>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-2 col-sm-3 col-xs-3 text-right">
        CPF/CNPJ
    </div>
    <div class="col-md-10 col-sm-9 col-xs-9">
        <?php echo $f_cnpj;?>
    </div>
</div>

<div class="row">
    <div class="col-md-2 col-sm-3 col-xs-3 text-right">
        Endereço
    </div>
    <div class="col-md-10 col-sm-9 col-xs-9">
        <b><?php echo ucfirst(strtolower($f_logradouro.', '.$f_numero.' '.$f_complemento));?></b>
    </div>
</div>
<br>
