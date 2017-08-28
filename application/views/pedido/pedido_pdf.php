<table width="100%" border="1" cellspacing="2" cellpadding="2">
    <tr>
        <td align="right"><?php echo $t_descricao;?> <?php echo 'Nº '. strzero($id_pp,6);?></td>
    </tr>
</table>
<br><br>
<table border="0" cellpadding="0" cellspacing="0">
 <tr>
  <th colspan="2" align="center">DADOS DO CLIENTE E FATURAMENTO</th>
 </tr>
 
 <tr><td colspan="2"><br></td></tr>
 <tr>
  <th colspan="1" align="left">DADOS DO CLIENTE</th>
  <th colspan="1" align="left">DADOS PARA FATURAMENTO</th>
 </tr>

 <tr>
  <td><?php 
                $dado = $dados_cliente;
                echo '<b>'.trim($dado['f_nome_fantasia']).'</b>';
                
                echo '<br/>';
                $cnpj = $dado['f_cnpj'];
                $ie = $dado['f_ie'];
                if (strlen($cnpj) > 12)
                    {
                        echo 'CNPJ: '.mask_cpf($cnpj).'<br>';
                        if (strlen($ie) > 0) { echo 'IE: '.$ie.'<br>';}
                    } else {
                        if (strlen($cnpj) > 8)
                            {
                                echo 'CPF: '.mask_cpf($cnpj).'<br>';
                                if (strlen($ie) > 0) { echo 'RG: '.$ie.'<br>';}
                            }
                    }
      ?>
  </td>
  </tr><tr>      
  <td><?php
                echo trim($dado['f_logradouro']);            
                /* numero */
                if (strlen($dado['f_numero'])) { echo ', '.trim($dado['f_numero']);}            
                /* complemento */
                if (strlen($dado['f_complemento'])) { echo ' - '.trim($dado['f_complemento']);}
      ?>
  </td>
  </tr><tr>
  <td><?php                
                echo trim($dado['f_cidade']);
                echo '-'.trim($dado['f_estado']);
                if (strlen($dado['f_cep']) > 4)
                    {
                        echo ' - CEP: '.substr(trim($dado['f_cep']),0,2).'.'.substr($dado['f_cep'],2,3).'-'.substr($dado['f_cep'],5,3);        
                    }
                
                
              
            ?>
  </td>
  <td>
      
  </td>
 </tr>
</table>
<br><br>
<?php
    /* itens do pedido */
    $dados_item = troca($dados_item,'class="table"','');
    echo $dados_item;
?>