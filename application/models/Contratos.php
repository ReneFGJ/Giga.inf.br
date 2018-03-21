<?php
class contratos extends CI_model
	{
		var $table = 'contrato_modelo';
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
