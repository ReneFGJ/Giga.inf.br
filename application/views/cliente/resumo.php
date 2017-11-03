<div class="row">
	<div class="col-xs-3">Resumo comercial</div>
	<div class="col-xs-3">Resumo técnico</div>
	<div class="col-xs-3">Resumo financeiro</div>
	<div class="col-xs-3"><h4>Cadastro</h4>
    <?php
        $link = '';
        $linka = '';
        if (perfil("#ADM#FIN")) {
            $link = '<a href="#" onclick="newwin(\''.base_url('index.php/financeiro/credito_liberar/'.$id_f.'/'.checkpost_link($id_f)).'\',600,600);">';
            $linka = '</a>';
        }
        switch($f_situacao)
            {
            case '1':
                echo $link.'<span class="btn btn-danger">Em análise</span>'.$linka;
                break;
            case '2':
                echo $link.'<span class="btn btn-primary">Aprovado</span>'.$linka;
                break;
            case '9':
                echo $link.'<span class="btn btn-danger">Não Aprovado</span>'.$linka;
                break;
            default:
                echo $link.'<span class="btn btn-primary">'.$f_situacao.'</span>'.$linka;
                break;                
            }
    ?>
    </div>
</div>
<br><br><br><br><br><br>