<?php
if (!isset($ac)) { $ac = 0;
}

if ($ac == 1) {
	if ($itens > 0)
		{
			echo '<a href="#" class="btn btn-primary" id="finalizar">Finalizar edição </a>' . cr();
			echo ' | ' . cr();
		}
	echo '<a href="#" class="btn btn-default" id="cancelar">Cancelar Recibo </a>' . cr();
	echo '
		<script>
		$("#finalizar").click(function() {
			if (confirmar())
				{
					var $lk = "' . base_url('index.php/financeiro/fiscal_fechar/' . $id_iv . '/' . checkpost_link($id_iv)) . '";
					window.location= $lk; 
				}
		});
		$("#cancelar").click(function() {
			if (confirmar())
				{
					var $lk = "' . base_url('index.php/financeiro/fiscal_cancelar/' . $id_iv . '/' . checkpost_link($id_iv)) . '";
					window.location= $lk; 
				}
		});
		</script>
		';
}
if ($ac == 2) {
	echo '<a href="' . base_url('index.php/financeiro/fiscal_pdf/' . $id_iv . '/' . checkpost_link($id_iv)) . '" class="btn btn-primary">Imprimir Recibo</a>' . cr();
	
	if (perfil("#ADM"))
	{
		echo ' | ';
		echo '<a href="' . base_url('index.php/financeiro/fiscal_editar/' . $id_iv . '/' . checkpost_link($id_iv)) . '" class="btn btn-default">Voltar para Edição</a>' . cr();	
	}
}

if ($ac == 9) {
	echo '<h1><font color="red">Cancelado !!!</font></h1>' . cr();
}
?>
