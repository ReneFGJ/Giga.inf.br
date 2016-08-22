<?php
$data = mktime(0,0,0,substr($date,4,2),substr($date,6,2),substr($date,0,4));
$day = 24*60*60;
$lk_prev30 = base_url('index.php/financeiro/creceber/'.date("Ymd",$data-$day*30));
$lk_prev7 = base_url('index.php/financeiro/creceber/'.date("Ymd",$data-$day*7));
$lk_prev1 = base_url('index.php/financeiro/creceber/'.date("Ymd",$data-$day));
$lk_today = base_url('index.php/financeiro/creceber/'.date("Ymd"));
$lk_next1 = base_url('index.php/financeiro/creceber/'.date("Ymd",$data+$day));
$lk_next7 = base_url('index.php/financeiro/creceber/'.date("Ymd",$data+$day*7));
$lk_next30 = base_url('index.php/financeiro/creceber/'.date("Ymd",$data+$day*30));
$lk_new = '#" onclick="newxy(\''.base_url('index.php/financeiro/creceber_edit/0/0').'\',800,800);';
$lk_refresh = base_url('index.php/financeiro/creceber/'.$date);

$week_day = name_weekday(date("w",$data));

?>
<div class="container">
	<div class="row">
		<div class="col-md-2 text-center" >
			<span class="superbig"><?php echo stodbr($date);?></span>
			<br>
			<span class="big"><?php echo $week_day;?></span>
		</div>
		<div class="col-md-1" >
			Resumo
			<span class="xxxbig"><?php echo number_format($saldo,2,',','.');?></span>
		</div>
		<div class="col-md-6">
			<table align="center">
				<tr align="center">
					<td style="padding: 10px;"><a href="<?php echo $lk_prev30;?>"><span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="<?php echo $lk_prev7;?>"><span class="glyphicon glyphicon-backward" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="<?php echo $lk_prev1;?>"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="<?php echo $lk_today;?>">HOJE</a></td>
					<td style="padding: 10px;"><a href="<?php echo $lk_next1;?>"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="<?php echo $lk_next7;?>"><span class="glyphicon glyphicon-forward" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="<?php echo $lk_next30;?>"><span class="glyphicon glyphicon-fast-forward" aria-hidden="true"></span></a></td>
				</tr>
			</table>

			<table align="center">
				<tr>
					<td style="padding: 10px;"><a href="<?php echo $lk_new;?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="#"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="<?php echo $lk_refresh;?>"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="#"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="#"><span class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></span></a></td>
					<td style="padding: 10px;"><a href="#"><span class="glyphicon glyphicon-sort-by-alphabet-alt" aria-hidden="true"></span></a></td>

				</tr>
			</table>
		</div>
		<div class="col-md-1" >
			
		</div>
		<div class="col-md-2" >
			Calendario
		</div>
	</div>
</div>
<br>
