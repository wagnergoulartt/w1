<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php require_once('controller/tarefas.php'); ?>
<?php $TitlePage = 'Gerenciar de Tarefas'; ?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-tasks"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<?php if(isset($_GET['blocos'])){ ?>
			<p>
				<a href="tarefas.php" class="btn btn-sm btn-primary"><i class="icon icon-angle-left"></i>Voltar</a>
				<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'adicionar')) { ?>
				<a href="?adicionar" class="btn btn-sm btn-primary"><i class="icon icon-plus"></i>Cadastrar Bloco</a>
				<?php } ?>
			</p>
			<div class="card">
				<div class="card-header  white">
					<strong style="margin-top: 5px; display: inline-block;">Blocos de Tarefas</strong>
				</div>

				<?php if(DBRead('tarefas_categorias','*', "WHERE id <> 0 {$sqlbloco}")){ ?>
				<div class="card-body p-0">
					<div>
						<table class="table table-striped">
							<tr>
								<th>ID</th>
								<th>Nome</th>
								<th>Cor</th>
								<th>Ordem</th>
								<th width="53px">Ações</th>
							</tr>

							<?php foreach (DBRead('tarefas_categorias','*', "WHERE id <> 0 {$sqlbloco} ORDER BY ordem ASC") as $categorias) { ?>
							<tr>
								<td><?php echo $categorias['id']; ?></td>
								<td><?php echo $categorias['nome']; ?></td>
								<td><span class="avatar avatar-lg circle" style="background: <?php echo $categorias['classe']; ?>; border-color: <?php echo $categorias['classe']; ?>;"></span></td>
								<td><?php echo $categorias['ordem']; ?></td>
								<td>
									<div class="dropdown">
										<a class="" href="#" data-toggle="dropdown">
											<i class="icon-apps blue lighten-2 avatar"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
											<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'editar')) { ?>
											<a class="dropdown-item" href="?editar=<?php echo $categorias['id']; ?>"><i class="text-primary icon icon-pencil"></i> Editar</a>
											<?php } ?>
											<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'deletar')) { ?>
											<a class="dropdown-item" onclick="DeletarItem(<?php echo $categorias['id']; ?> , 'excluir');" href="#!"><i class="text-danger icon icon-remove"></i> Excluir</a>
											<?php } ?>
										</div>
									</div>
								</td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
				<?php } else { ?>
					<div class="card-body">
						<div class="alert alert-info">Nenhum bloco de tarefas cadastrados até o momento, <a href="?adicionar">clique aqui</a> para cadastrar um.</div>
					</div>
				<?php } ?>
			</div>
		<?php } else if(isset($_GET['adicionar'])){ if(!checkPermission($PERMISSION, $urlModule, 'bloco', 'adicionar')){ Redireciona('./index.php'); } ?>
		<form method="post" action="?addBloco" enctype="multipart/form-data">
			<p>
				<a href="tarefas.php?blocos" class="btn btn-sm btn-primary"><i class="icon icon-angle-left"></i>Voltar</a>
			</p>
			<div class="card">
				<div class="card-header  white">
					<strong>Cadastrar Bloco</strong>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Nome do Bloco:</label>
								<input class="form-control" name="nome" required="">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Ordenar:</label>
								<input class="form-control" name="ordem" required="" value="">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Cor do Bloco:</label>
								<div class="color-picker input-group colorpicker-element focused" name="cor">
									<input type="text" name="classe" value="#00AABB" class="form-control">
									<span class="input-group-append">
										<span class="input-group-text add-on white">
											<i class="circle" style="background-color: rgb(0, 170, 187);"></i>
										</span>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer white">
					<button class="btn btn-primary float-right">Cadastrar</button>
				</div>
			</div>
		</form>
		<?php } else if(isset($_GET['editar'])){ if(!checkPermission($PERMISSION, $urlModule, 'bloco', 'editar')){ Redireciona('./index.php'); } ?>
			<?php $id = get('editar'); $Query = DBRead('tarefas_categorias','*',"WHERE id = '{$id}'"); if (is_array($Query)) { foreach ($Query as $categoria) { ?>
			<form method="post" action="?editBloco=<?php echo $id; ?>" enctype="multipart/form-data">
			<p>
				<a href="tarefas.php?blocos" class="btn btn-sm btn-primary"><i class="icon icon-angle-left"></i>Voltar</a>
			</p>
			<div class="card">
				<div class="card-header  white">
					<strong>Editar Bloco:</strong> <?php echo $categoria['nome']; ?>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Nome do Bloco:</label>
								<input class="form-control" name="nome" required="" value="<?php echo $categoria['nome']; ?>">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Ordenar:</label>
								<input class="form-control" name="ordem" required="" value="<?php echo $categoria['ordem']; ?>">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Cor do Bloco:</label>
								<div class="color-picker input-group colorpicker-element focused" name="cor">
									<input type="text" name="classe" value="<?php echo $categoria['classe']; ?>" class="form-control">
									<span class="input-group-append">
										<span class="input-group-text add-on white">
											<i class="circle" style="background-color: rgb(0, 170, 187);"></i>
										</span>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer white">
					<button class="btn btn-primary float-right">Editar</button>
				</div>
			</div>
			</form>
		<?php } } } else { ?>
			<p><a href="?blocos" class="btn btn-sm btn-primary"><i class="icon icon-tasks"></i>Blocos de Tarefa</a></p>
			<div class="row">
			<?php if(DBRead('tarefas_categorias','*', 'ORDER BY ordem ASC')){ foreach (DBRead('tarefas_categorias','*', "WHERE id <> 0 {$sqlbloco} ORDER BY ordem ASC") as $categorias) { ?>
				<div class="col-md-4">
					<div class="card bg-light mb-3">
						<div class="card-header" style="background: <?php echo $categorias['classe']; ?>;border-color: <?php echo $categorias['classe']; ?>; color: #fff;"><?php echo $categorias['nome']; ?> 
							<div class="float-right">
								<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'adicionar')) { ?>
									<a href="#" class="text-white" data-toggle="modal" data-target="#tarefa<?php echo $categorias['id']; ?>"><i class="icon icon-plus"></i></a>
								<?php } ?>
								<?php if (checkPermission($PERMISSION, $urlModule, 'bloco', 'deletar')) { ?>
								<a class="text-white" style="margin-left: 10px" onclick="DeletarItem(<?php echo $categorias['id']; ?> , 'excluir');" href="#!"><i class="icon-remove"></i></a>
								<?php } ?>
							</div>
						</div>
						<div class="card-body p-0">
							<div class="card todo-widget no-b">
								<div class="card-header white">
									<h6>TAREFAS</h6>
								</div>

								<div class="card-body p-0 slimScroll" data-height="250">
									<ul class="list-group list-group-striped no-b">
										<?php $id = $categorias['id']; $query = DBRead('tarefas','*', "WHERE categoria = {$id} {$sqlbloco}");  if (is_array($query)) { foreach ($query as $tarefas) { ?>
										<li class="list-group-item list-group-item-action <?php if($tarefas['status'] == 0){echo 'done';} ?>">
											<span class="float-right">
												<?php if($tarefas['status'] == 1){ ?>
													<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'editar')) { ?>
														<a href="?attTarefa=<?php echo $tarefas['id']; ?>" class="btn btn-sm btn-primary"><i style="color: #fff;" class="icon-check"></i></a>
													<?php } ?>
												<?php } ?>
												<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'editar')) { ?>
													<a href="?editarTarefa=<?php echo $tarefas['id']; ?>" class="btn btn-sm btn-primary"><i style="color: #fff;" class="icon-edit"></i></a>
												<?php } ?>
												<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'deletar')) { ?>
													<a onclick="DeletarItem(<?php echo $tarefas['id']; ?> , 'excluirTarefa');" href="#!" class="btn btn-sm btn-danger"><i style="color: #fff;" class="icon-remove"></i></a>
												<?php } ?>
											</span> 

											<?php echo $tarefas['titulo']; ?>
											<span class="badge badge-primary r-3 ml-3" style="background: <?php echo $tarefas['cor']; ?> !important"><?php echo $tarefas['label']; ?></span>
											<br>
											<small><?php echo $tarefas['conteudo']; ?></small>
										</li>
										<?php } } ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="tarefa<?php echo $categorias['id']; ?>" class="modal fade" role="dialog">
					<form method="post" action="?addTarefa=<?php echo $categorias['id']; ?>" enctype="multipart/form-data">
					<div class="modal-dialog">
						<div class="modal-content b-0">
							<div class="modal-header r-0 bg-primary">
								<h6 class="modal-title text-white">Adicionar Tarefa</h6>
								<a href="#" data-dismiss="modal" aria-label="Close" class="paper-nav-toggle paper-nav-white active"><i></i></a>
							</div>

							<div class="modal-body">
								<div class="form-group">
									<label>Nome</label>
									<input type="text" name="titulo" class="form-control">
								</div>

								<div class="form-group">
									<label>Descrição</label>
									<input type="text" name="conteudo" class="form-control">
								</div>

								<div class="form-group">
									<label>Data</label>
									<div class="input-group">
										<input type="text" name="data" class="date-time-picker form-control" data-options='{"timepicker":false, "format":"Y-m-d"}' value="<?php echo date('Y-m-d'); ?>"/>
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="icon-calendar"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label>Etiqueta</label>
									<input type="text" name="label" class="form-control">
								</div>

								<div class="form-group">
									<label>Cor da Etiqueta</label>
									<div class="color-picker input-group">
										<input type="text" value="#00AABB" class="form-control" name="cor" />
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
									</div>
								</div>
							</div>

							<div class="modal-footer">
								<button type="submit" class="btn btn-primary" type="submit">Adicionar</button>
							</div>
						</div>
					</div>
					</form>
                </div>
                <?php } } ?>
				<?php if(isset($_GET['editarTarefa'])){ ?>
				<div id="editarTarefa" class="modal fade" role="dialog">
					<?php $id = $_GET['editarTarefa']; $query = DBRead('tarefas','*', "WHERE id = ".$id);  if (is_array($query)) { foreach ($query as $tarefas) { ?>
					<form method="post" action="?eddTarefa=<?php echo $id; ?>" enctype="multipart/form-data">
					<div class="modal-dialog">
						<div class="modal-content b-0">
							<div class="modal-header r-0 bg-primary">
								<h6 class="modal-title text-white">Editar Tarefa</h6>
								<a href="#" data-dismiss="modal" aria-label="Close" class="paper-nav-toggle paper-nav-white active"><i></i></a>
							</div>

							<div class="modal-body">
								<div class="form-group">
									<label>Nome</label>
									<input type="text" name="titulo" class="form-control" value="<?php echo $tarefas['titulo']; ?>">
								</div>

								<div class="form-group">
									<label>Descrição</label>
									<input type="text" name="conteudo" class="form-control" value="<?php echo $tarefas['conteudo']; ?>">
								</div>

								<div class="form-group">
									<label>Data</label>
									<div class="input-group">
										<input type="text" name="data" class="date-time-picker form-control" data-options='{"timepicker":false, "format":"Y-m-d"}' value="<?php echo $tarefas['data']; ?>"/>
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="icon-calendar"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label>Etiqueta</label>
									<input type="text" name="label" class="form-control" value="<?php echo $tarefas['label']; ?>">
								</div>

								<div class="form-group">
									<label>Status</label>
									<select name="status" class="form-control">
										<option value="1" <?php if($tarefas['status'] == 1){echo "selected";} ?>>Aberto</option>
										<option value="0" <?php if($tarefas['status'] == 0){echo "selected";} ?>>Finalizado</option>
									</select>
								</div>

								<div class="form-group">
									<label>Cor da Etiqueta</label>
									<div class="color-picker input-group">
										<input type="text" class="form-control" name="cor" value="<?php echo $tarefas['cor']; ?>" />
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
									</div>
								</div>
							</div>

							<div class="modal-footer">
								<button type="submit" class="btn btn-primary" type="submit">Editar</button>
							</div>
						</div>
					</div>
					</form>
					<?php } ?>
				</div>
				<?php } ?>
			<?php } ?>
			</div>
    	<?php } ?>
	</div>
</div>

<?php require_once('includes/footer.php'); ?>
<script type="text/javascript">
$(window).on('load',function(){$('#editarTarefa').modal('show');});
</script>