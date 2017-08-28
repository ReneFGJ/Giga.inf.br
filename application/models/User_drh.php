<?php
class user_drh extends CI_Model {
	var $table = 'user_drh';

	function le($id, $fld = 'id') {
		$sql = "select * from " . $this -> table;
		$sql .= " left join _filiais ON usd_empresa = id_fi "; 
		$sql .= ' where usd_id_us = ' . round($id);

		$rlt = $this -> db -> query($sql);
		$rlt = $rlt -> result_array();
		if (count($rlt) == 0) {
			$sql = "insert into " . $this -> table . " (usd_id_us) values ($id)";
			$rlt = $this -> db -> query($sql);

			return ( array());
		} else {
			return ($rlt[0]);
		}
	}

	function cp($id) {
		$cp = array();
		array_push($cp, array('$H8', 'usd_id_us', $id, False, True));
        array_push($cp, array('$HV', 'usd_id_us', $id, False, True));
        
        array_push($cp, array('$A', '', 'Filiação', False, True));
        array_push($cp, array('$S80', 'usd_nome_pai', 'Nome do pai', False, True));
        array_push($cp, array('$S80', 'usd_nome_mae', 'Nome da mãe', False, True));
        array_push($cp, array('$D80', 'usd_nascimento', 'Data nascimento', False, True));
        
        array_push($cp, array('$A', '', 'Dados na empresa', False, True));
        $sql = "SELECT * FROM _filiais where fi_ativo = 1";
        array_push($cp, array('$Q id_fi:fi_nome_fantasia:'.$sql, 'usd_empresa', 'Empresa', False, True));
        array_push($cp, array('$S80', 'usd_cargo', 'Cargo', False, True));
        array_push($cp, array('$S80', 'usd_departamento', 'Departamento', False, True));
        array_push($cp, array('$D8', 'usd_dt_admissao', 'Dt. admissão', False, True));
        array_push($cp, array('$D8', 'usd_dt_demissao', 'Dt. demissão', False, True));
        
        array_push($cp, array('$A', '', 'Documentos pessoais', False, True));
        array_push($cp, array('$S50', 'usd_cpf', 'Número do CPF', False, True));
        array_push($cp, array('$S80', 'usd_rg', 'RG nº', False, True));
        array_push($cp, array('$S80', 'usd_rg_emissor', 'RG emissor', False, True));
        array_push($cp, array('$S80', 'usd_rg_dt_emissao', 'Dt. emissão RG', False, True));
        array_push($cp, array('$S80', 'usd_pis', 'Número do PIS', False, True));
        array_push($cp, array('$S80', 'usd_dt_nasc', 'Data de nascimento', False, True));
        array_push($cp, array('$S80', 'usd_ct', 'Carteira de trabalho Nº', False, True));
        array_push($cp, array('$S80', 'usd_ct_serie', 'Carteira/Série', False, True));

        array_push($cp, array('$A', '', 'Endereço pessoal', False, True));
        array_push($cp, array('$S80', 'usd_logradouro', 'Endereço', False, True));
        array_push($cp, array('$S80', 'usd_numero', 'Número', False, True));
        array_push($cp, array('$S80', 'usd_complemento', 'Complemento', False, True));
        array_push($cp, array('$S80', 'usd_cep', 'CEP', False, True));
        array_push($cp, array('$S80', 'usd_bairro', 'Bairro', False, True));
        array_push($cp, array('$S80', 'usd_cidade', 'Cidade', False, True));
        array_push($cp, array('$UF', 'usd_estado', 'Estado', False, True));
        
        array_push($cp, array('$A', '', 'Contato telefonico', False, True));
        array_push($cp, array('$S80', 'usd_fone_1', 'Telefone (cel.)', False, True));
        array_push($cp, array('$S80', 'usd_fone_2', 'Telefone (casa)', False, True));
        array_push($cp, array('$S80', 'usd_fone_3', 'Telefone (pais)', False, True));
        array_push($cp, array('$S80', 'usd_fone_4', 'Telefone (outros)', False, True));
        
        array_push($cp, array('$B', '', 'Gravar dados', False, True));
		return ($cp);
	}

    function aniversariantes()
        {
            $sql = "select * from user_drh
                        INNER JOIN users ON id_us = usd_id_us  
                        where EXTRACT(MONTH FROM usd_nascimento) = '".date("m")."' 
                        order by usd_nascimento";
            $rlt = $this->db->query($sql);
            $rlt = $rlt->result_array();
            $sx = '<div class="col-md-12"><h2>Aniversariantes do mês</h2></div>'.cr();
            for ($r=0;$r < count($rlt);$r++)
                {
                    $line = $rlt[$r];
                    $img = 'photo-'.strzero($line['id_us'],5).'.jpg';
                    $filename = 'img/picture/'.$img;
                    if (file_exists($filename))
                        {
                            
                        } else {
                            $img = 'img-no-picture.png';        
                        }
                    $sx .= '<div class="col-md-2 text-center">';
                    $sx .= '<img src="'.base_url('img/picture/'.$img).'" class="img-responsive">'.cr();
                    $sx .= '<h4>'.$line['us_nome'].'</h4>'.cr();
                    $sx .= substr(stodbr($line['usd_nascimento']),0,5).cr();
                    $sx .= '</div>';
                }
            if (count($rlt) == 0) { $sx = ''; }
            return($sx);
        }

}
