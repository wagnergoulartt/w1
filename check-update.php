<?php 
	require_once('includes/funcoes.php');
	require_once ('database/config.php');
	require_once ('database/config.database..php');
	require_once ('database/config.session.php');
	require_once ('includes/funcoes.php');
	require_once('controller/check_update.php');
?>

<?php CheckAutoUpdate(); ?>

<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header  white">
				<strong>Versão Atual</strong>
			</div>

			<div class="card-body p-0">
				<div class="text-center bg-light b-b p-3">
					<h3 class="my-3"><?php echo ConfigPainel('versao'); ?></h3>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="card">
			<div class="card-header  white">
				<strong>Versão Disponível</strong>
			</div>

			<div class="card-body p-0">
				<div class="text-center bg-light b-b p-3">
					<h3 class="my-3"><?php VersaoDisponivel(); ?></h3>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3"></div>
</div>

<?php
if (empty($_REQUEST['_'])) {
	Redireciona('./check_update.php');
}
?>