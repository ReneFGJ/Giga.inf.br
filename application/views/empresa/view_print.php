    <div class="row" style="border: 0px solid #000000; border-radius: 3px; padding: 5px 10px;">
        <div class="col-md-2 col-sm-4 col-xs-4">
            <img src="<?php echo base_url('img/logo/' . strzero($id_fi, 4) . '_logo.jpg'); ?>" class="img-responsive">
        </div>
        <div class="col-md-10 col-sm-8 col-sx-8">
            <b><?php echo $fi_razao_social; ?></b><br>
            CNPJ:<?php echo $fi_cnpj; ?> - IE:<?php echo $fi_ie; ?><br>
            <?php
                echo trim($fi_logradouro);
                if (strlen($fi_numero) > 0) {
                    echo ', ' . $fi_numero;
                }
             ?> - <?php echo ucwords(strtolower($fi_cidade)).'/'.$fi_estado;?><br>
             <?php echo 'Fone: ' . $fi_fone_1; ?>
        </div>
    </div>
