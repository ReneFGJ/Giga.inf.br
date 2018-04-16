<?php
class contratos extends CI_model
	{
		var $table = 'contrato_modelo';
        
        function baixa_produto($id)
            {
                $sx = '';
                $sql = "select * from produto_agenda 
                            INNER JOIN produtos ON id_pr = ag_produto
                            INNER JOIN produtos_categoria ON id_pc = pr_categoria
                            INNER JOIN clientes ON id_f = ag_cliente
                            where ag_produto = $id 
                            and (ag_situacao = 1 or ag_situacao = 2)";
                $rlt = $this->db->query($sql);
                $rlt = $rlt->result_array();
                if (count($rlt) == 0)
                    {
                        $data['erro'] = 'Produto não localizado ou não fornecido';
                        $sx .= $this->load->view('alert',$data,true);
                        return($sx);
                    }
                $sx = '<table class="table" width="100%">';
                $sx .= '<tr>
                            <th width="7%">Pedido</th>
                            <th width="7%">BarCode</th>
                            <th width="10%">Retirada</th>
                            <th width="7%">Descrição</th>
                            <th width="10%">Modelo</th>
                            <th width="50%">Cliente</th>
                        </tr>';
                for ($r=0;$r < count($rlt);$r++)
                    {
                        $line = $rlt[$r];
                        $user_id = $_SESSION['id'];
                        $data = date("Y-m-d");
                        $hora = date("H:i:s");
                        $ped = $line['ag_pedido'];
                        $sql = "update produto_agenda set 
                                    ag_devolucao = '$data',
                                    ag_devolucao_hora = '$hora',
                                    ag_situacao = 3,
                                    ag_devolucao_log = $user_id
                                where id_ag = ".$line['id_ag'];
                                $zrlt = $this->db->query($sql);

                        $sx .= '<tr>';
                        //print_r($line);
                        $sx .= '<td>'.$line['ag_pedido'].'</td>';
                        $sx .= '<td>'.$line['pr_patrimonio'].'</td>';
                        $sx .= '<td>'.stodbr($line['ag_data_reserva']).'</td>';                        
                        $sx .= '<td>'.$line['pc_nome'].'</td>';
                        $sx .= '<td>'.$line['pr_modelo'].'</td>';
                        $sx .= '<td>'.$line['f_nome_fantasia'].'</td>';
                        
                        $sx .= '</tr>';
                        $pedido = $line['ag_pedido'];
                    }
                $sx .= '</table>';
                    
                $sql = "select count(*) as total from produto_agenda 
                            where ag_pedido = $pedido 
                            and (ag_situacao = 1 or ag_situacao = 2)";
                $rlt = $this->db->query($sql);
                $rlt = $rlt->result_array();
                $line = $rlt[0];
                if ($line['total'] > 0)
                    {
                        $sx .= '<div class="col-md-12 big">Restam '.$line['total'].' item(ns)</div>';
                    } else {
                        $this->pedidos->pedido_altera_status($pedido,7,900);
                        $this->produtos->itens_atualiza_status($pedido,2,3);                        
                    }
                                    
                return($sx);
            }
		function le($id)
			{
				$sql = "select * from ".$this->table." where id_c = 1";
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				if (count($rlt) > 0)
					{
						$line = $rlt[0];
						return($line);
					} else {
						return(array());
					}
			}
		function anexos($id,$sit='')
			{
                $wh = '';
			    if (strlen($sit) > 0)
                    {
                        $wh = " AND (ag_situacao = '$sit' )";
                    }
				$sql = "select * from produto_agenda
						inner join produtos on id_pr = ag_produto
						inner join produto_nome ON pr_produto = id_pn						
					where ag_pedido = $id $wh
					order by ag_data_reserva, pr_produto, pr_patrimonio
					";							
				$rlt = $this->db->query($sql);
				$rlt = $rlt->result_array();
				$sx = '<br>';
				//$sx .= '<tr><th>ITEM 02</th></tr>'.cr()
				$sx .= '<table width="100%" class="table" style="border: 1px solid #000000;">';
				//$sx .= '<tr><td><b>ITEM 02</b></td></tr>';
				$sx .= '<tr><th width="10%">Patrimonio</th>
				            <th>Descricao</th>
				            <th width="10%">Período</th>
				            <th width="10%">Até</th>
				            </tr>'.cr();
				
				for ($r=0;$r < count($rlt);$r++)
					{
						$line = $rlt[$r];
						$sx .= '<tr>';
                        $sx .= '<td>'.UpperCase($line['pr_patrimonio']).'</td>';
                        
                        $sx .= '<td>'.$line['pn_descricao'].'</td>';

						$sx .= '<td>'.stodbr($line['ag_data_reserva']).'</td>';
						$sx .= '<td>'.stodbr($line['ag_data_reserva_ate']).'</td>';
						
						$sx .= '</tr>'.cr();
					}
				$sx .= '</table>'.cr();
				$sx .= '<br><br>'.cr();
				//exit;
				return($sx);
			}
        function anexos_table($id,$sit='',$cp='')
            {
                $wh = '';
                if (strlen($sit) > 0)
                    {
                        $wh = " AND (ag_situacao = '$sit' )";
                    }
                $sql = "select * from produto_agenda
                        inner join produtos on id_pr = ag_produto
                        inner join produto_nome ON pr_produto = id_pn
                        inner join produtos_marca ON pr_marca = id_ma                       
                    where ag_pedido = $id $wh
                    order by ag_data_reserva, pr_produto, pr_patrimonio
                    ";   
                      
                $rlt = $this->db->query($sql);
                $rlt = $rlt->result_array();
                $sx = '<br>';

                $xd1 = '';
                $xd2 = '';
                $xds = '';
                $x = 0;
                $tot = 0;
                $pr1 = array();
                $pr2 = array();
                $pr3 = array();
                $pr4 = array();
                for ($r=0;$r < count($rlt);$r++)
                    {
                        $line = $rlt[$r];
                        $d1 = $line['ag_data_reserva'];
                        $d2 = $line['ag_data_reserva_ate'];
                        $ds = $line['pn_descricao'].' - '.$line['pr_modelo'].' - '.$line['ma_nome'];
                        
                        if (isset($pr1[$ds]))
                            {
                                $pr1[$ds] = $pr1[$ds] + 1;
                                $pr2[$ds] .= ', '.$cp.UpperCase($line['pr_patrimonio']);
                            } else {
                                $pr1[$ds] = 1;
                                $pr2[$ds] = UpperCase($line['pr_patrimonio']);
                            }
                    }
                $sx = '<h3>Locação: '.stodbr($d1).' até '.stodbr($d2).'</h3>';
                $sx .= '<table width=100% class="table">';
                $sx .= '<tr><th width="5%">qt.</th>
                            <th width="60%">produto</th>
                            <th width="35%">barcod</th>
                            </tr>';
                $it = 0;
                foreach ($pr1 as $key => $value) {
                    $sx .= '<tr>';
                    $sx .= '<td>'.$value.'</td>';
                    //$sx .= '<td>'.(($it++)+1).'</td>';
                    $sx .= '<td>'.$key.'</td>';
                    
                    $sx .= '<td>'.$pr2[$key].'</td>';
                }
                $sx .= '</table>';
                return($sx);
            }
        function anexos_simple($id,$sit='',$cp='')
            {
                $wh = '';
                if (strlen($sit) > 0)
                    {
                        $wh = " AND (ag_situacao = '$sit' )";
                    }
                $sql = "select * from produto_agenda
                        inner join produtos on id_pr = ag_produto
                        inner join produto_nome ON pr_produto = id_pn
                        inner join produtos_marca ON pr_marca = id_ma                       
                    where ag_pedido = $id $wh
                    order by ag_data_reserva, pr_produto, pr_patrimonio
                    ";                          
                $rlt = $this->db->query($sql);
                $rlt = $rlt->result_array();
                $sx = '<br>';

                $xd1 = '';
                $xd2 = '';
                $xds = '';
                $x = 0;
                $tot = 0;
                for ($r=0;$r < count($rlt);$r++)
                    {
                        $line = $rlt[$r];
                        $d1 = $line['ag_data_reserva'];
                        $d2 = $line['ag_data_reserva_ate'];
                        $ds = $line['pn_descricao'].' '.$line['pr_modelo'].' '.$line['ma_nome'];
                        if (($d1 != $xd1) or ($d2 != $xd2))
                            {
                                if ($tot > 0)
                                    { $sx .= ' <b>Total:'.$tot.' item(ns)</b>'; }
                                $xd1 = $d1;
                                $xd2 = $d2;
                                $sx .= '<h5><b>Perídodo: '.stodbr($xd1).' - '.stodbr($xd2).'</b></h5>';                                
                                $sx .= $ds.':';
                                $xds = $ds;
                                $x = 0;
                                $tot = 0;
                            }
                        if ($ds != $xds)
                            {
                                if ($tot > 0)
                                    { $sx .= ' <b>Total:'.$tot.' item(ns)</b><br>'; }
                                $sx .= '<br>'.$ds.':<br>';
                                $xds = $ds;
                                $x = 0;
                                $tot = 0;
                            }
                        if ($x > 0) { $sx .= ', '; }
                        $tot++;
                        $sx .= ' '.$cp.UpperCase($line['pr_patrimonio']);
                        //$sx .= '('.$line['pr_serial'].')';
                        $x++;
                    }
                if ($tot > 0)
                    { $sx .= ' <b>Total:'.$tot.' item(ns)</b>'; }
                $sx .= '<br><br>'.cr();
                //exit;
                return($sx);
            }
		
	}
?>
