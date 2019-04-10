<?php
class exports extends CI_model {
    function cpagar($off='') {
        $size = 10000;
        if (strlen($off) == 0) {
            $sx = '';
            $sql = "select count(*) as total from cx_pagar
                    left join _filiais ON cp_filial = id_fi
                    left join cx_conta_codigo ON id_cd = cp_conta";
            $rlt = $this -> db -> query($sql);
            $rlt = $rlt -> result_array();
            $total = $rlt[0]['total'];
            $i = 0;
            $sx .= '<h1>Contas a Pagar</h1><ul>';
            while ($total > $size)
                {
                    $total = $total - $size;
                    $sx .= '<li>'.'<a href="'.base_url('index.php/export/contas/cpagar/'.$i).'">Parte #'.($i+1).'</a></li>';
                    $i++;
                }
            $sx .= '</ul>';
            return($sx);
            exit;
        }
        $size = 10000;        
        $offset = (round($off)+1) * $size;
        $sql = "select * from cx_pagar
                    left join _filiais ON cp_filial = id_fi
                    left join cx_conta_codigo ON id_cd = cp_conta 
                            order by cp_vencimento 
                            limit 10000 offset $offset";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table>';
        $sx .= '<tr><td colspan=10>Offset '.$off.' ('.$offset.')</td></tr>'.cr();
        $line = $rlt[0];
        $sx .= '<tr>' . cr();
        foreach ($line as $key => $value) {
            $sx .= '<th>' . $key . '</th>' . cr();
        }
        $sx .= '</tr>' . cr();

        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $sx .= '<tr>' . cr();
            foreach ($line as $key => $value) {
                $value = utf8_decode((string)$value);
                $sx .= '<td>' . $value . '</td>' . cr();
            }
            $sx .= '</tr>' . cr();
        }
        $sx .= '</table>' . cr();
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Content-Disposition: attachment; filename=Giga_CPAGAR_" . date("Y-m-d H:i") . "_part".strzero($off+1,3).".xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        return ($sx);
    }

    function creceber($off = '') {
        $size = 10000;
        if (strlen($off) == 0) {
            $sx = '';
            $sql = "select count(*) as total from cx_receber
                    left join _filiais ON cp_filial = id_fi
                    left join cx_conta_codigo ON id_cd = cp_conta";
            $rlt = $this -> db -> query($sql);
            $rlt = $rlt -> result_array();
            $total = $rlt[0]['total'];
            $i = 0;
            $sx .= '<h1>Contas a Receber</h1><ul>';
            while ($total > $size)
                {
                    $total = $total - $size;
                    $sx .= '<li>'.'<a href="'.base_url('index.php/export/contas/creceber/'.$i).'">Parte #'.($i+1).'</a></li>';
                    $i++;
                }
            $sx .= '</ul>';
            return($sx);
            exit;
        }
        $size = 10000;        
        $offset = (round($off)+1) * $size;
        $sql = "select * from cx_receber
                    left join _filiais ON cp_filial = id_fi
                    left join cx_conta_codigo ON id_cd = cp_conta 
                            order by cp_vencimento 
                            limit 10000 offset $offset";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<table>';
        $sx .= '<tr><td colspan=10>Offset '.$off.' ('.$offset.')</td></tr>'.cr();
        $line = $rlt[0];
        $sx .= '<tr>' . cr();
        foreach ($line as $key => $value) {
            $sx .= '<th>' . $key . '</th>' . cr();
        }
        $sx .= '</tr>' . cr();

        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $sx .= '<tr>' . cr();
            foreach ($line as $key => $value) {
                $value = utf8_decode((string)$value);
                $sx .= '<td>' . $value . '</td>' . cr();
            }
            $sx .= '</tr>' . cr();
        }
        $sx .= '</table>' . cr();
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Content-Disposition: attachment; filename=Giga_CRECEBER_" . date("Y-m-d H:i") . "_part".strzero($off+1,3).".xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        return ($sx);
    }

}
?>
