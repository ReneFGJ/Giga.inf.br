            <span style="text-decoration: underline; font-size: 150%;"><?php echo $f_nome_fantasia;?></span>
            <br>
            CNPJ: <?php echo $f_cnpj;?> - IE: <?php echo $f_ie;?>
            <br><?php echo $f_logradouro;?> <?php echo $f_complemento;?> - <?php echo $f_bairro;?>
            <?php echo $f_cidade;?>-<?php echo $f_estado;?> - CEP: <?php echo $f_cep;?>
            <br>Telefone: <?php echo $f_fone_1;?>
            <?php if ($editar==1) { ?><span id="cliente_icone_3" class="glyphicon glyphicon-pencil nopr" aria-hidden="true" id="cliente_icone_3a"></span><?php } ?> 

<script>
    $("#cliente_icone_3").click(function() {
        newxy('<?php echo base_url('index.php/main/cliente_faturamento/'.$id_pp.'/'.checkpost_link($id_pp));?>',800,700);
    });
</script>