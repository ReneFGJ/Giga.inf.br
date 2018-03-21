<?php
class tranfers extends CI_model {
    function editar($id) {
        $cp = array();
        array_push($cp, array('$H8', 'id_cp', '', false, true));
        array_push($cp, array('$HV', 'cp_filial', '1', true, true));
        array_push($cp, array('$D8', 'cp_vencimento', 'Dt. para transferência', True, true));
        array_push($cp, array('$S80', 'cp_historico', 'Historico', true, true));
        array_push($cp, array('$HV', 'cp_pedido', 'ORDEM', False, true));
        array_push($cp, array('$H8', '', '', False, True));
        array_push($cp, array('$HV', 'cp_parcela', 'ÚNICA', True, True));
        array_push($cp, array('$H8', '', '', False, True));

        array_push($cp, array('$HV', 'cp_doc', 'NRDOC', true, true));
        array_push($cp, array('$HV', 'cp_conta', '25', true, true));
        array_push($cp, array('$Q id_f:f_nome:select id_f,concat(f_razao_social,\' / \',f_nome_fantasia) as f_nome from clientes where f_fornecedor = 1 and f_ativo = 1 order by f_nome', 'cp_fornecedor', 'Fornecedor', False, true));

        array_push($cp, array('$HV', 'cp_situacao', '1', true, true));
        array_push($cp, array('$HV', 'cp_auto', '1', true, true));

        $vlr = get("dd11");
        $vlr = troca($vlr, '.', '');
        $vlr = troca($vlr, ',', '.');
        array_push($cp, array('$N8', 'cp_valor', 'Valor', True, True));
        array_push($cp, array('$HV', 'cp_valor_pago', $vlr, True, true));

        array_push($cp, array('$HV', 'cp_nossonumero', '', False, True));
        array_push($cp, array('$C', 'cp_previsao', 'Previsão (SIM)', False, true));

        if ($id > 0) {
            array_push($cp, array('$C', 'cp_recebivel', 'Título pagável', False, true));
        }

        array_push($cp, array('$B8', '', 'Salvar >>>', false, true));

        $form = new form;
        $tela = $form -> editar($cp, 'cx_pagar');
        IF ($form->saved > 0)
            {
                redirect(base_url('index.php/main/transfer/'));
            }
        return ($tela);
    }

    function acoes() {
        $sx = '<a href="' . base_url('index.php/main/transfer/ed/0') . '" class="btn btn-primary">Solicitar transferência</a>';
        $sx .= '<br>';
        $sx .= '<br>';
        return ($sx);
    }

    function listrq() {
        $sql = "select * from cx_pagar 
                    LEFT JOIN clientes on cp_fornecedor = id_f
                    LEFT JOIN cx_pagar_situacao ON cp_situacao = id_cpa
                            where cp_auto = 1 
                            order by cp_vencimento";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table width="100%" class="table">';
        $sx .= '<tr><th width="10%">venc.</th>
                    <th width="50%">Fornecedor</th>
                    <th width="10%">Valor</th>
                    <th width="20%">Descricação</th>
                    <th width="20%">Situação</th>
                </tr>';
        if (count($rlt) == 0) {
            $sx .= '
                            <div class="alert alert-warning">
                              <strong>Transferência!</strong> Nenhum registo localizado.
                            </div>                        
                        ';
        }
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $situacao = $line['cpa_descricao'];
            $sx .= '<tr class="'.$line['cpa_classe'].'">';
            $linkd = '<a href="'.base_url('index.php/financeiro/cpagar/'.substr(sonumero($line['cp_vencimento']),0,8)).'">';
           
            $sx .= '<td>' . $linkd.stodbr($line['cp_vencimento']).'</a>'. '</td>';
            $linkc = '<a href="'.base_url('index.php/main/cliente/'.$line['id_f'].'/'.checkpost_link($line['id_f'])).'">';
            $sx .= '<td>' . $linkc.trim($line['f_razao_social']).'/'.trim($line['f_nome_fantasia']) .'</a>'. '</td>';
            $sx .= '<td>' . number_format($line['cp_valor'],2,',','.') . '</td>';
            $sx .= '<td>' . trim($line['cp_historico']). '</td>';
            $sx .= '<td>' . $situacao. '</td>';
            $sx .= '</td>' . cr();
        }
        $sx .= '</table>';
        return ($sx);
    }

}
?>
