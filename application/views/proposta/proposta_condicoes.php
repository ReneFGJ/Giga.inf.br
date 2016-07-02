<div class="container">
	<span class="big"><b>CONDIÇÕES E FORNECIMENTO</b></span>
	<br>
	<br>
	<?php

	if (strlen($pg_nome) > 0) { echo '<div class="row"><div class="col-md-12">Condições de pagamento: <b>' . $pg_nome . '</b></div></div>' . cr();
	}
	if (strlen($pz_nome) > 0) { echo '<div class="row"><div class="col-md-12">Prazo de entrega: <b>' . $pz_nome . '</b></div></div>' . cr();
	}
	if (strlen($pga_nome) > 0) { echo '<div class="row"><div class="col-md-12">Garantia: <b>' . $pga_nome . '</b></div></div>' . cr();
	}
	if (strlen($vd_nome) > 0) { echo '<div class="row"><div class="col-md-12">Validade da proposta: <b>' . $vd_nome . '</b></div></div>' . cr();
	}
	if ($pp_periodo_locacao > 0) { echo '<div class="row"><div class="col-md-12">Período de locação: <b>' . $pp_periodo_locacao . ' dia(s)</b></div></div>' . cr();
	}
	if (round(substr($pp_dt_ini_evento, 0, 4)) > 2010) {
		echo '<div class="row"><div class="col-md-12">Data do evento: <b>' . stodbr($pp_dt_ini_evento) . ' ';
		if (round(substr($pp_dt_fim_evento, 0, 4)) > 2010) {
			echo ' - '.stodbr($pp_dt_fim_evento);
		}
		echo '</b></div></div>' . cr();
	}
	if (strlen($pm_nome) > 0) { echo '<div class="row"><div class="col-md-12">Montagem: <b>' . $pm_nome . '</b></div></div>' . cr();
	}

	?>
</div>