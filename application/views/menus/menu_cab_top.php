<?php
$us_nome = $_SESSION['user'];
?>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url('index.php/main'); ?>"><img src="<?php echo base_url('img/logo/logo_png_bw.png'); ?>" height="20"></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
			<li>
			<a href="<?php echo base_url('index.php/main/clientes'); ?>">Clientes</a>
			</li>
			<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Propostas & Pedidos <span class="caret"></span></a>
			<ul class="dropdown-menu">
			<li>
			<a href="<?php echo base_url('index.php/main/menu_pedidos/1'); ?>">Propostas</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/menu_pedidos/2'); ?>">Pedidos de venda</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/menu_pedidos/3'); ?>">Locações</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/menu_pedidos/4'); ?>">Atendimento laboratório</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/menu_pedidos/5'); ?>">Atendimento on-site</a>
			</li>
			</ul>
			</li>

			<!---- Financiero --->
			<?php
			if (perfil("#ADM#FIN")) {
				echo '<li class="dropdown">' . cr();
				echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Financeiro <span class="caret"></span></a>' . cr();
				echo '<ul class="dropdown-menu">' . cr();
				echo '	<li>' . cr();
				echo '		<li><a href="' . base_url('index.php/financeiro/cpagar') . '">Contas a Pagar</a></li>' . cr();
				echo '	</li>' . cr();
				echo '	<li>' . cr();
				echo '		<li><a href="' . base_url('index.php/financeiro/creceber') . '">Contas a Receber</a></li>' . cr();
				echo '	</li>' . cr();
				echo '	<li>' . cr();
				echo '		<li><a href="' . base_url('index.php/financeiro/faturar') . '">Faturar</a></li>' . cr();
				echo '	</li>' . cr();
				echo '	<li>' . cr();
				echo '		<li><a href="' . base_url('index.php/financeiro/relatorio') . '">Relatório</a></li>' . cr();
				echo '	</li>' . cr();
				echo '</ul>' . cr();
			}
			?>

			<!---- Fiscal --->
			<?php
			if (perfil("#FIS#ADM")) {
				echo '<li class="dropdown">' . cr();
				echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Fiscal <span class="caret"></span></a>' . cr();
				echo '<ul class="dropdown-menu">' . cr();
				echo '	<li>' . cr();
				echo '		<li><a href="' . base_url('index.php/financeiro/fiscal') . '">Recibos</a></li>' . cr();
				echo '	</li>' . cr();
				//echo '	<li>' . cr();
				//echo '		<li><a href="' . base_url('index.php/financeiro/creceber') . '">Contas a Receber</a></li>' . cr();
				//echo '	</li>' . cr();
				//echo '	<li>' . cr();
				//echo '		<li><a href="' . base_url('index.php/financeiro/faturar') . '">Faturar</a></li>' . cr();
				//echo '	</li>' . cr();
				echo '</ul>' . cr();
			}
			?>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Equipamentos <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo base_url('index.php/main/produtos'); ?>">Busca produtos</a>
					</li>
					<li>
						<a href="<?php echo base_url('index.php/main/produtos_etiquetas'); ?>">Gerar Etiquetas</a>
					</li>					
				</ul>
			</li>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Locação <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo base_url('index.php/main/locacao'); ?>">Locação</a>
					</li>
				</ul>
			</li>

			<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastro <span class="caret"></span></a>
			<ul class="dropdown-menu">
			<li>
			<a href="<?php echo base_url('index.php/main/clientes'); ?>">Clientes</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/produtos_categoria'); ?>">Produto - Categoria</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/produtos_marca'); ?>">Produtos - Marcas</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/produtos_cadastrar'); ?>">Produto - Equipamento (itens)</a>
			</li>

			<li role="separator" class="divider"></li>
			<li>
			<a href="<?php echo base_url('index.php/main/prazo_entrega'); ?>">Condições - Prazo de entrega</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/prazo_garantia'); ?>">Condições - Prazo de garantia</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/prazo_montagem'); ?>">Condições - Prazo de montagem</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/pedido_validade'); ?>">Condições - Validade da proposta</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/main/condicoes_pagamento'); ?>">Condições - Condições de pagamento</a>
			</li>

			<li role="separator" class="divider"></li>
			<li>
			<a href="<?php echo base_url('index.php/admin/users'); ?>">Usuários do Sistema</a>
			</li>
			<li>
			<a href="<?php echo base_url('index.php/admin/filiais'); ?>">Matriz e Filiais</a>
			</li>
			<?php
			if (perfil("#ADM#GEG")) {
				echo '<li role="separator" class="divider"></li>' . cr();
				echo '<li><a href="' . base_url('index.php/admin/logins') . '">Atribuir Perfil a usuários</a></li>' . cr();
			}
			?>
			</ul>
			<?php
			if (perfil("#ADM")) {
				echo '<li class="dropdown">' . cr();
				echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrador <span class="caret"></span></a>' . cr();
				echo '<ul class="dropdown-menu">' . cr();
				echo '	<li>' . cr();
				echo '		<li><a href="' . base_url('index.php/admin/perfil') . '">Cadastro de Perfis</a></li>' . cr();
				echo '	</li>' . cr();
				echo '	<li>' . cr();
				echo '		<li><a href="' . base_url('index.php/admin/contato_tipo') . '">Cadastro de Tipos de Contato</a></li>' . cr();
				echo '	</li>' . cr();
				echo '	<li>' . cr();
				echo '		<li><a href="' . base_url('index.php/admin/comunicacao_1') . '">Mensagens do Sistema</a></li>' . cr();
				echo '	</li>' . cr();
				echo '	<li>' . cr();
				echo '		<li><a href="' . base_url('index.php/admin/email') . '">E-mail</a></li>' . cr();
				echo '	</li>' . cr();
				echo '</ul>' . cr();
			}
			?>

			</li>
			</ul>
			<!--
			<form class="navbar-form navbar-left" role="search">
			<div class="form-group">
			<input type="text" class="form-control" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-default">
			Submit
			</button>
			</form>
			-->
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $us_nome; ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url('index.php/main/myaccount'); ?>">Meus Dados</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/social/logout'); ?>">Logout</a>
						</li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>