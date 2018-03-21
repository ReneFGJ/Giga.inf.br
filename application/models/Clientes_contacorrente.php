<?php
class clientes_contacorrente extends CI_model
    {
        function cp($idc,$id)
            {
                $cp = array();
                array_push($cp,array('$H8','id_ccc','',false,false));
                array_push($cp,array('$HV','ccc_cliente',$idc,true,true));
                array_push($cp,array('$S20','ccc_banco','Banco',true,true));
                array_push($cp,array('$S20','ccc_ag','Agência',true,true));
                array_push($cp,array('$S40','ccc_conta','Conta Corrente',true,true));
                array_push($cp,array('$S100','ccc_titular','Titular',true,true));
                array_push($cp,array('$S50','ccc_titular_cpf','CPF',false,true));
                array_push($cp,array('$O 0:Não informado&1:Conta Corrente&2:Poupança','ccc_tipo','Tipo CC',false,true));
                array_push($cp,array('$O 1:Ativo&0:Inativo','ccc_situacao','Situação',true,true));
                return($cp);
            }
        function mostracc($id)
            {
                $sql = "select * from cliente_conta_corrente 
                        where ccc_situacao = 1 and ccc_cliente = ".round($id);
                $rlt = $this->db->query($sql);
                $rlt = $rlt->result_array();
                $sx = '';
                for ($r=0;$r < count($rlt);$r++)
                    {
                        $sx .= '<div class="col-md-4">';
                        $line = $rlt[$r];
                        $sx .= 'Banco: '.$line['ccc_banco'];

                        $sx .= '<br>';
                        $sx .= 'Ag.:'.$line['ccc_ag'];

                        $sx .= '<br>';
                        $sx .= 'CC:'.$line['ccc_conta'];

                        $sx .= '<br>';
                        $sx .= 'Títular:'.$line['ccc_titular'];

                        $sx .= '<br>';
                        $sx .= 'Titular (CPF):'.$line['ccc_titular_cpf'];
                        $sx .= '</div>';
                    }
                return($sx);
            } 
        function cc_novo($id)
            {
                $sx = '<br>';
                $sx .= '<a href="#" onclick="newxy(\''.base_url('index.php/main/cc/'.$id.'/0').'\',800,600);" class="btn btn-primary">';
                $sx .= 'Cadastrar Conta Corrente';
                $sx .= '</a><br><br>';
                return($sx);
            }
                    
            
        function listcc($id)
            {
                $sql = "select * from cliente_conta_corrente 
                            where ccc_situacao = 1 and ccc_cliente = ".round($id);
                $rlt = $this->db->query($sql);
                $rlt = $rlt->result_array();
                $sx = '<table width="100%" class="table">';
                $sx .= '<tr><th colspan=6>Dados Bancários</th></tr>';
                $sx .= '<tr class="small">
                            <th width="4%">Banco</th>
                            <th width="10%">Agência</th>
                            <th width="10%">Conta</th>
                            <th width="15%">Tipo</th>
                            <th width="40%">Titular</th>
                            <th width="15%">CPF</th>
                            <th width="1%"></th>
                        </tr>';
                for ($r=0;$r < count($rlt);$r++)
                    {
                        $line = $rlt[$r];
                        $sx .= '<tr>';
                        $sx .= '<td>';
                        $sx .= $line['ccc_banco'];
                        $sx .= '</td>';

                        $sx .= '<td>';
                        $sx .= $line['ccc_ag'];
                        $sx .= '</td>';

                        $sx .= '<td>';
                        $sx .= $line['ccc_conta'];
                        $sx .= '</td>';

                        $sx .= '<td>';
                        $sx .= msg('cc_tipo_'.$line['ccc_tipo']);
                        $sx .= '</td>';

                        $sx .= '<td>';
                        $sx .= $line['ccc_titular'];
                        $sx .= '</td>';

                        $sx .= '<td>';
                        $sx .= $line['ccc_titular_cpf'];
                        $sx .= '</td>';

                        if (perfil("#ADM"))
                            {
                                $sx .= '<td>';
                                $sx .= '<a href="#" onclick="newxy(\''.base_url('index.php/main/cc/'.$id.'/'.$line['id_ccc']).'\',800,600);">';
                                $sx .= '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
                                $sx .= '</a>';
                                $sx .= '</td>';
                            }

                        $sx .= '</tr>';     
                    }
                $sx .= '</table>';
                if (count($rlt) == 0) { $sx = '';}
                return($sx);
            }      
    }
?>
