<?php
$nav = array();
$nav[0]['day'] = date("Y-m-d");
$nav[0]['value'] = 210;
$nav[0]['weekday'] = 'Segunda-feira';

for ($r = 0; $r < 12; $r++) {
	if (isset($nav[$r]['day'])) {

	} else {
		$nav[$r]['day'] = (date("Y-m-d"));
		$nav[$r]['value'] = 0;
		$nav[$r]['weekday'] = 'Segunda-feira';
	}
}
?>
<div class="container">
	<div class="row">
		<?php
		$data = mktime(0,0,0,date("m"),date("d"),date("Y"));
				
		for ($r = 0; $r < count($nav); $r++) {
			$data2 = 7 * 24 * 60;
			$day = $data + $data2;			
			$link = '<a href="'.base_url('index.php/cx/cpagar/'.sonumero($nav[$r]['day'])).'">';
			echo '<div class="col-md-2 text-center alert-danger" style="height: 80px; margin: 5px;">';
			echo $link.'<span class="big">' . $nav[$r]['day'] . '</span>'.'</a>';
			echo '<br>';
			echo '<span class="small">'.number_format($nav[$r]['value'],2,',','.').'</span>';
			echo '<br>';
			echo '<span class="small">'.$nav[$r]['weekday'].'</span>';
			echo '</div>';
		}
		?>
	</div>
</div>

