<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<?php
$dt = '';
$tt = '<table width="100%" class="table">';
$tt .= '<tr class="small"><th>descrição</th>
			<th>jan.</th>
			<th>fev.</th>
			<th>mar.</th>
			<th>abr.</th>
			<th>maio</th>
			<th>jun.</th>
			<th>jul.</th>
			<th>ago.</th>
			<th>set.</th>
			<th>out.</th>
			<th>nov.</th>
			<th>dez.</th>
		</tr>';
foreach ($series as $ano => $value) {
	if (strlen($dt) > 0) { $dt .= ', ' . cr();
	}
	$dt .= '{' . cr();
	$dt .= "name: '$ano', " . cr();
	$dt .= "data: [";
	$tt .= '<tr>';
	$tt .= '<td>'.$ano.'</td>';
	for ($r = 1; $r <= 12; $r++) {
		if ($r > 1) { $dt .= ', ';
		}
		$dt .= round($value[$r]);
		$tt .= '<td align="right" width="6%" class="middle">'.number_format($value[$r],2,',','.').'</td>';
	}
	$tt .= '</tr>'.cr();
	$dt .= ']';
	$dt .= '}' . cr();
}
$tt .= '</table>';
?>
<script>
	$(function() {
		$('#container').highcharts({
			chart : {
				type : 'column'
			},
			title : {
				text : 'Relatório Mensal'
			},
			subtitle : {
				text : 'Source: sistema'
			},
			xAxis : {
				categories : ['Jan', 'Feb', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dec'],
				crosshair : true
			},
			yAxis : {
				min : 0,
				title : {
					text : 'Valores (R$)'
				}
			},
			tooltip : {
				headerFormat : '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat : '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
				footerFormat : '</table>',
				shared : true,
				useHTML : true
			},
			plotOptions : {
				column : {
					pointPadding : 0.2,
					borderWidth : 0
				}
			},
			series : [ <?php echo $dt; ?>]
		});
	}); 
</script>
<?php echo $tt; ?>