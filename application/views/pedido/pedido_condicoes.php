<div class="container">
	<div class="row">
		<div class="col-md-12">
			<span class="big"><b>CONDIÇÕES E FORNECIMENTO</b></span>
			<br>
			<br>
		</div>

		<?php
        echo '<div class="col-md-6">';
        if (strlen($pg_nome) > 0) { echo 'Condições de pagamento: <b>' . $pg_nome . '</b>' . cr();
        }
        if (strlen($pz_nome) > 0) { echo '<br>Condições de entrega: <b>' . $pz_nome . '</b>' . cr();
        }
        if (strlen($pga_nome) > 0) { echo '<br>Garantia: <b>' . $pga_nome . '</b>' . cr();
        }
        if (strlen($pp_bv) > 0) { echo '<div class="nopr">BV: <b>' . number_format($pp_bv, 2, ',', '.') . '</b></div>' . cr();
        }

        if ($id_vd > 1) { echo '<br>Validade da proposta: <b>' . $vd_nome . '</b>' . cr();
        }
        if ($pp_periodo_locacao > 0) { echo '<br>Período de locação: <b>' . $pp_periodo_locacao . ' dia(s)</b>' . cr();
        }

        /****************** DADOS DO EVENTO *****************************/
        if (round(substr($pp_dt_ini_evento, 0, 4)) > 2010) {
            echo '<div class="row"><div class="col-md-12">Data de entrega: <b>' . stodbr($pp_dt_ini_evento) . '</b>' . ' ';
            if (isset($pp_entrega_hora)) {
                echo '<br>Horário de entrega: <b>' . ($pp_entrega_hora) . '</b>';
            }            
            if (round(substr($pp_dt_fim_evento, 0, 4)) > 2010) {
                echo '<br>Data da retirada: <b>' . stodbr($pp_dt_fim_evento) . '</b>';
            }
            if (isset($pp_dt_fim_evento_hora)) {
                echo '<br>Horário de devolução: <b>' . ($pp_dt_fim_evento_hora) . '</b>';
            }
            echo '</b></div></div>' . cr();
        }
        if (strlen($pm_nome) > 0) { echo 'Montagem: <b>' . $pm_nome . '</b>' . cr();
        }
        echo '</div>' . cr();
        /***** segunda coluna ***********/
        if (strlen($pp_obs) > 0) { echo '<div class="col-md-6"><b>Observações</b>:<br>' . mst($pp_obs) . '</div>' . cr();
        }
    ?>
	</div>
</div>
</div>
