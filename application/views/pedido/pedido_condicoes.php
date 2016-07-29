<div class="col-md-12">
	<span class="big"><b>CONDIÇÕES E FORNECIMENTO</b></span>
	<br>
	<br>
</div>

	<?php
	echo '<div class="col-md-6">';
	if (strlen($pg_nome) > 0) { echo 'Condições de pagamento: <b>' . $pg_nome . '</b>' . cr();
	}
	if (strlen($pz_nome) > 0) { echo '<br>Prazo de entrega: <b>' . $pz_nome . '</b>' . cr();
	}
	if (strlen($pga_nome) > 0) { echo '<br>Garantia: <b>' . $pga_nome . '</b>' . cr();
	}
	if ($id_vd > 1) { echo '<br>Validade da proposta: <b>' . $vd_nome . '</b>' . cr();
	}
	if ($pp_periodo_locacao > 0) { echo '<br>Período de locação: <b>' . $pp_periodo_locacao . ' dia(s)</b>' . cr();
	}

	/****************** DADOS DO EVENTO *****************************/
	if (round(substr($pp_dt_ini_evento, 0, 4)) > 2010) {
		echo '<br>Data do evento: <b>' . stodbr($pp_dt_ini_evento) . ' ';
		if (round(substr($pp_dt_fim_evento, 0, 4)) > 2010) {
			echo ' - ' . stodbr($pp_dt_fim_evento);
		}
		echo '</b>' . cr();
	}
	if (strlen($pm_nome) > 0) { echo 'Montagem: <b>' . $pm_nome . '</b>' . cr();
	}
	echo '</div>'.cr();
/***** segunda coluna ***********/	
	if (strlen($pp_obs) > 0) { echo '<div class="col-md-6"><b>Observações</b>:<br>' . mst($pp_obs) . '</div>' . cr();
	}
	
	?>
</div>
