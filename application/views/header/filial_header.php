<div class="container noscreen">
    <div class="row" class="border_top noscreen" style="border-bottom: 1px solid #000000;">
        <div class="col-md-3 col-sm-3 col-xs-3 text-center">
            <?php
            echo '<img src="'.base_url('img/logo/'.strzero($pp_filial,4).'_logo.jpg').'" class="img-responsive">';
            ?>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-7">
            <h4><?php echo $fi_nome_fantasia;?></h4>
            CNPJ: <?php echo $fi_cnpj;?> - IE: <?php echo $fi_ie;?>
            <br><?php echo $fi_logradouro;?> <?php echo $fi_complemento;?> - <?php echo $fi_bairro;?>
            <?php echo $fi_cidade;?>-<?php echo $fi_estado;?> - CEP: <?php echo $fi_cep;?>
            <br>Telefone: <?php echo $fi_fone_1;?> - <?php echo $fi_site;?> - E-mail: <?php echo $fi_email;?>           
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2 text-right">
            <?php echo $t_descricao; ?><br>
            <b><?php echo strzero(sonumero($id_pp),7).'/'.substr($pp_data,2,2);?></b>
        </div>
    </div>
</div>