<?php
$us_nome = $_SESSION['user'];
?>
<nav class="navbar navbar-default">
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
				<li>
					<a href="<?php echo base_url('index.php/main/menu_pedidos'); ?>">Propostas & Pedidos</a>
				</li>
				<li>
					<a href="<?php echo base_url('index.php/main/estoque'); ?>">Estoque</a>
				</li>				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Financeiro <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo base_url('index.php/cx/caixa'); ?>">Caixa</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/cx/cpagar'); ?>">Contas a Pagar</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/cx/creceber'); ?>">Contas a Receber</a>
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
							<a href="<?php echo base_url('index.php/main/produtos'); ?>">Produtos</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/main/produtos_categoria'); ?>">Produtos - Categoria</a>
						</li>
						<li>
							<a href="<?php echo base_url('index.php/main/produtos_marca'); ?>">Produtos - Marcas</a>
						</li>
				</li>
				<li>
					<a href="<?php echo base_url('index.php/admin/users'); ?>">Usuários do Sistema</a>
				</li>
				<li>
					<a href="<?php echo base_url('index.php/admin/filiais'); ?>">Matriz e Filiais</a>
				</li>
				<li role="separator" class="divider"></li>
				<li>
					<a href="#">Separated link</a>
				</li>
				<li role="separator" class="divider"></li>
				<li>
					<a href="#">Usuários</a>
				</li>
			</ul>
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
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<?php echo $us_nome; ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>
							<a href="#">Meus Dados</a>
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