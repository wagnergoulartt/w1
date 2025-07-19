<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php $TitlePage = 'Idiomas'; ?>
<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-globe"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<div class="card">
			<div class="card-header  white">
				<strong>Idiomas do Sistema</strong>
			</div>

			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th><strong>ID</strong></th>
								<th><strong>Favicon</strong></th>
								<th><strong>Titulo</strong></th>
								<th><strong>Diretório</strong></th>
							</tr>
						</thead>

						<tbody>
							<?php $Query = DBRead('idioma','*'); if (is_array($Query)) { foreach ($Query as $idioma) { ?>
								<tr>
									<td><?php echo $idioma['id']; ?></td>
									<td><img src="wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/css_js/images/idioma/<?php echo $idioma['imagem']; ?>&w=25&q=100" /></td>
									<td><?php echo $idioma['titulo']; ?></td>
									<td><?php echo $idioma['diretorio']; ?></td>
								</tr>
							<?php } } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once('includes/footer.php'); ?>