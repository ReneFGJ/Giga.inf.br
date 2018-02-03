<div class="container">
    <div class="row" class="border_top noscreen" style="border-bottom: 1px solid #000000;">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <span class="small">dados do cliente</span><br>
            <span style="text-decoration: underline; font-size: 150%;"><?php echo $f_nome_fantasia;?></span>
            <br>
            CNPJ: <?php echo $f_cnpj;?> - IE: <?php echo $f_ie;?>
            <br><?php echo $f_logradouro;?> <?php echo $f_complemento;?> - <?php echo $f_bairro;?>
            <?php echo $f_cidade;?>-<?php echo $f_estado;?> - CEP: <?php echo $f_cep;?>
            <br>Telefone: <?php echo $f_fone_1;?>           
        </div>

        <div class="col-md-6 col-sm-6 col-xs-6">
            <span class="small">dados para faturamento</span><br>
            <?php echo $dados_faturamento;?>
        </div>
    </div>
</div>
