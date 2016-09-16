<?php
global $header_fiscal;

if (!isset($header_fiscal))
	{
		echo '<tr class="small">';
		echo '<th width="10%">Período</th>';
		echo '<th width="70%">Descrição dos itens locados</th>';
		echo '<th width="20%">Valor Total (R$)</th>';
		echo '</tr>';
		$header_fiscal = true;
	}
	
echo '<tr >';
echo '<td  style="border: 1px solid #000000;">'.$ii_periodo.'</td>'.cr();
echo '<td style="border: 1px solid #000000;">'.$ii_nome.''.cr();
if (strlen($ii_descricao) > 0)
	{
		echo '<br><font class="small">'.mst($ii_descricao).'</font>'.cr();
	}
echo '</td>';
echo '<td align="right" style="border: 1px solid #000000;">'.number_format($ii_valor,2,',','.').'</td>'.cr();
if (isset($editar) and ($editar==true))
{
	$link = base_url('index.php/financeiro/fiscal_edit/'.$id_ii.'/'.$id_ii.'/' . $ii_invoice);
	$linko = ' onclick="newxy(\'' . $link . '\',800,500); "';
	
	$link = '<span class="glyphicon glyphicon-pencil" '.$linko.' aria-hidden="true"></span>';
	$link = '<a href="#">'.$link.'</a>';
	echo '<td style="border: 1px solid #000000;">'.$link.''.cr();	
}
echo '</tr>';
?>
