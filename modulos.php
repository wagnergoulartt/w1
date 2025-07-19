<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php require_once('controller/modulos.php'); ?>
<?php $TitlePage = 'Gerenciar Módulos'; ?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-puzzle-piece"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<div class="row">
			<div class="col-md-12">
				<?php if (isset($_GET['editar'])) { $editar = get('editar'); ?>
				<?php $Query = DBRead('modulos','*',"WHERE id = '{$editar}'"); if (is_array($Query)) { foreach ($Query as $modulos) { ?>
					<form method="post" action="?atualiza_modulo=<?php echo $editar; ?>" enctype="multipart/form-data">
						<div class="card">
							<div class="card-header  white">
								<strong>Informações</strong>
							</div>

							<div class="card-body">
								<div class="form-group">
									<label><?php echo $txt['nome_modulo_editar']; ?></label>
									<input class="form-control" name="nome" value="<?php echo $modulos['nome']; ?>">
								</div>

								<div class="form-group">
									<label><?php echo $txt['ordem_modulo_editar']; ?></label>
									<input class="form-control" type="number" name="ordem" value="<?php echo $modulos['ordem']; ?>">
								</div>
							</div>

							<div class="card-footer white">
								<button class="btn btn-primary float-right"><?php echo $txt['btn_salvar']; ?></button>
							</div>
						</div>
					</form>
				<?php } } ?>
				<?php } else { ?>
				<div class="card">
					<div class="card-header  white">
						<strong>Usuários do Sistema</strong>
					</div>

					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-striped">
								<tr>
									<th width="10px">ID</th>
									<th><?php echo $txt['tabela_titulo']; ?></th>
									<th><?php echo $txt['ordem_modulo']; ?></th>
									<th width="100px"><?php echo $txt['status']; ?></th>
									<th width="53px"><?php echo $txt['tabela_acoes']; ?></th>
								</tr>

								<?php $Query = DBRead('modulos','*',"WHERE level = '1'"); if (is_array($Query)) { foreach ($Query as $modulos) { ?>
									<tr>
										<td><?php echo $modulos['id']; ?></td>
										<td><?php echo $modulos['nome']; ?></td>
										<td><?php echo $modulos['ordem']; ?></td>
										<td>
										<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'editar')) { ?>
											<?php if ($modulos['status'] == 1) { ?>
											<a href="?desativar=<?php echo $modulos['id']; ?>" class="btn btn-success"><i class="icon-check"></i></a>
											<?php } else { ?>
											<a href="?ativar=<?php echo $modulos['id']; ?>" class="btn btn-danger"><i class="icon-times"></i></a>
											<?php } ?>
										<?php } ?>
										</td>
										<td>
											<div class="dropdown">
												<a class="" href="#" data-toggle="dropdown">
													<i class="icon-apps blue lighten-2 avatar"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
												<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'editar')) { ?>
													<a class="dropdown-item" href="?editar=<?php echo $modulos['id']; ?>"><i class="text-primary icon icon-pencil"></i> Editar</a>
												<?php } ?>
												<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'deletar')) { ?>
													<a onclick="DeletarItem(<?php echo $modulos['id']; ?> , 'excluir');" href="#!" class="dropdown-item"><i class="text-danger icon icon-remove"></i> Excluir</a>
												<?php } ?>
												</div>
											</div>
										</td>
									</tr>
								<?php } } ?>
							</table>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php require_once('includes/footer.php'); ?>