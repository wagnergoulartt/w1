<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php require_once('controller/permissoes.php'); ?>
<?php $TitlePage = 'Permissões'; ?>
<?php $UrlPage	 = 'permissoes.php'; ?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon user-lock"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>

			<div class="row">
				<ul class="nav responsive-tab nav-material nav-material-white">
					<li><a class="nav-link" href="<?php echo $UrlPage; ?>"><i class="icon icon-list4"></i> Todos Grupos</a></li>
					<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'adicionar')) { ?>
						<li><a class="nav-link" href="?AdicionarItem"><i class="icon icon-plus-circle"></i> Adicionar Grupo</a>
						<?php } ?>
				</ul>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<?php if (isset($_GET['AdicionarItem'])) { ?>
			<?php
			if (!checkPermission($PERMISSION, $urlModule, 'item', 'adicionar')) {
				Redireciona('./index.php');
			}
			?>

			<?php $QueryParams = DBRead("modulos", "*"); ?>
			<form id="PermissionForm" method="post" action="?Adicionar" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header  white">
						<strong>Adicionar Grupo</strong>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Nome do Grupo:</label>
									<input type="text" class="form-control" name="name" placeholder="Nome do Grupo" required>
								</div>
							</div>
							<div class="col-md-12">
								<label class="csscheckbox pull-left right-25px">Marcar/Desmarcar Todos
									<input id="selectAll" type="checkbox">
									<span class="checkmark"></span>
								</label>
								<div class="box-body">
									<?php foreach ($QueryParams as $p) { ?>
										<table class="table table-bordered table-striped">
											<tr>
												<th width="15%">
													<span style="font-size: 15px;"><b>Modulo: </b><?php echo $p['nome']; ?></span>
												</th>
												<th width="50%">Ações</th>
												<!-- <th width="30%">Visualizações¹</th> -->
											</tr>

											<?php $Actions = json_decode($p['acao'], true);
											foreach ($Actions as $key => $value) { ?>
												<tr>
													<td>
														<span style="font-size: 15px;"><b><?php echo strtoupper($key); ?></b></span>
													</td>
													<td>
														<?php foreach ($value as $action) { ?>
															<?php if ($action <> 'ver') : ?>
																<label class="csscheckbox pull-left right-25px"><?= strtoupper($action); ?>
																	<input type="checkbox" name="<?php echo str_replace(['-','.php'], ['_',''], $p['url']); ?>['<?= $key; ?>'][]" id="md_checkbox_adicionar_<?php echo $p['id']; ?>" value="<?= $action; ?>">
																	<span for="md_checkbox_<?php echo $p['id']; ?>" class="checkmark"></span>
																</label>
															<?php endif; ?>
														<?php } ?>
													</td>

													<?php if ($action == 'ver') : ?>
														<!-- <td>
														<label class="csscheckbox pull-left right-25px">Conteúdo do Usuário
															<input type="radio" name="<?php echo str_replace('.php', '', $p['url']); ?>['<?= $key; ?>'][]" id="md_checkbox_ver_<?php echo $p['id']; ?>" value="vuser">
															<span for="md_checkbox_ver_<?php echo $p['id']; ?>" class="checkmark inputradio"></span>
														</label>

														<label class="csscheckbox pull-left right-25px">Todo Conteúdo
															<input type="radio" name="<?php echo str_replace('.php', '', $p['url']); ?>['<?= $key; ?>'][]" id="md_checkbox_ver_<?php echo $p['id']; ?>" value="vall">
															<span for="md_checkbox_ver_<?php echo $p['id']; ?>" class="checkmark inputradio"></span>
														</label>

														<label class="csscheckbox pull-left right-25px">Nenhum
															<input type="radio" id="md_checkbox_ver_<?php echo $p['id']; ?>" value="">
															<span for="md_checkbox_ver_<?php echo $p['id']; ?>" class="checkmark inputradio"></span>
														</label>
													</td> -->
													<?php else : ?>
														<!-- <td></td> -->
													<?php endif; ?>

												</tr>
											<?php } ?>
										</table>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>

					<div class="card-footer white">
						<button class="btn btn-primary float-right">Adicionar Grupo</button>
					</div>

				</div>



			</form>
		<?php } elseif (isset($_GET['EditarItem'])) { ?>
			<?php $id = get('EditarItem');

			if (!checkPermission($PERMISSION, $urlModule, 'item', 'editar')) {
				Redireciona('./index.php');
			}

			$QueryGroups = DBRead('permissions_groups', '*', "WHERE id = '{$id}' {$sql}");
			$QueryParams = DBRead('modulos', '*');
			$listParams = json_decode($QueryGroups[0]['params'], true);

			if (is_array($QueryGroups)) {
				foreach ($QueryGroups as $permissoes) { ?>
					<form id="PermissionForm" method="post" action="?Atualizar=<?php echo $id; ?>" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $QueryGroups[0]['id']; ?>">

						<div class="card">
							<div class="card-header  white">
								<strong>Editar Grupo</strong>
							</div>

							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Nome do Grupo:</label>
											<input type="text" class="form-control" name="name" placeholder="Nome do Grupo" value="<?php echo $permissoes['name']; ?>" required>
										</div>
									</div>
									<div class="col-md-12">
										<label class="csscheckbox pull-left right-25px">Marcar/Desmarcar Todos
											<input id="selectAll" type="checkbox">
											<span class="checkmark"></span>
										</label>
										<div class="box-body">
											<?php if (is_array($QueryParams)) {
												foreach ($QueryParams as $p) { ?>
													<table class="table table-bordered table-striped">
														<tr>
															<th width="15%">
																<span style="font-size: 15px;"><b>Modulo: </b><?php echo $p['nome']; ?></span>
															</th>
															<th width="50%">Ações</th>
															<!-- <th width="30%">Visualizações¹</th> -->
														</tr>

														<?php $Actions = json_decode($p['acao'], true);
														foreach ($Actions as $key => $value) { ?>
															<tr>
																<td>
																	<span style="font-size: 15px;"><b><?php echo strtoupper($key); ?></b></span>
																</td>
																<td>
																	<?php foreach ($value as $action) { ?>
																		<?php if ($action <> 'ver') : ?>
																			<label class="csscheckbox pull-left right-25px"><?= strtoupper($action); ?>
																				<input type="checkbox" name="<?php echo str_replace(['-','.php'], ['_',''], $p['url']); ?>['<?= $key; ?>'][]" id="md_checkbox_adicionar_<?php echo $p['id']; ?>" value="<?= $action; ?>" <?php echo (checkPermission($listParams, $p['url'], $key, $action)) ? 'checked' : ''; ?>>
																				<span for="md_checkbox_<?php echo $p['id']; ?>" class="checkmark"></span>
																			</label>
																		<?php endif; ?>
																	<?php } ?>
																</td>

																<?php if ($action == 'ver') : ?>
																	<!-- <td>
														<label class="csscheckbox pull-left right-25px">Conteúdo do Usuário
															<input type="radio" class="<?php echo str_replace('.php', '', $p['url']); ?>['<?= $key; ?>'][]_ver" name="<?php echo str_replace('.php', '', $p['url']); ?>['<?= $key; ?>'][]" id="md_checkbox_ver_<?php echo $p['id']; ?>" value="vuser" <?php echo (checkPermission($listParams, $p['url'], $key, 'vuser')) ? 'checked' : ''; ?>>
															<span for="md_checkbox_ver_<?php echo $p['id']; ?>" class="checkmark inputradio"></span>
														</label>

														<label class="csscheckbox pull-left right-25px">Todo Conteúdo
															<input type="radio" class="<?php echo str_replace('.php', '', $p['url']); ?>['<?= $key; ?>'][]_ver" name="<?php echo str_replace('.php', '', $p['url']); ?>['<?= $key; ?>'][]" id="md_checkbox_ver_<?php echo $p['id']; ?>" value="vall" <?php echo (checkPermission($listParams, $p['url'], $key, 'vall')) ? 'checked' : ''; ?>>
															<span for="md_checkbox_ver_<?php echo $p['id']; ?>" class="checkmark inputradio"></span>
														</label>

														<input type="button" class="btn btn-xs btn-danger" value="Nenhum" onclick="clearRadioGroup('<?php echo str_replace('.php', '', $p['url']); ?>[\'<?= $key; ?>\'][]_ver');">
													</td> -->
																<?php else : ?>
																	<!-- <td></td> -->
																<?php endif; ?>

															</tr>
														<?php } ?>
													</table>
											<?php }
											} ?>
										</div>
									</div>
								</div>
							</div>

							<div class="card-footer white">
								<button class="btn btn-primary float-right">Atualizar Grupo</button>
							</div>

						</div>



					</form>
			<?php }
			} ?>
		<?php } else { ?>

			<div class="card">
				<div class="card-header white">
					<strong>Grupos do Sistema</strong>
				</div>

				<div class="card-body p-0">
					<div>
						<table class="table table-striped">
							<tr>
								<th>ID</th>
								<th>Nome</th>
								<th width="53px">Ações</th>
							</tr>

							<?php
							$Query = DBRead('permissions_groups', '*', "WHERE id <> 0 {$sql}");
							if (is_array($Query)) {
								foreach ($Query as $permissoes) {
							?>
									<tr>
										<td><?php echo $permissoes['id']; ?></td>
										<td><?php echo $permissoes['name']; ?></td>
										<td>
											<div class="dropdown">
												<a class="" href="#" data-toggle="dropdown">
													<i class="icon-apps blue lighten-2 avatar"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">

													<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'editar')) { ?>
														<a class="dropdown-item" href="?EditarItem=<?php echo $permissoes['id']; ?>"><i class="text-primary icon icon-pencil"></i> Editar</a>
													<?php } ?>

													<?php if ($permissoes['id'] <> 1) : ?>
														<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'deletar')) { ?>
															<a class="dropdown-item" onclick="DeletarItem(<?php echo $permissoes['id']; ?> , 'excluir');" href="#!"><i class="text-danger icon icon-remove"></i> Excluir</a>
														<?php } ?>
													<?php endif; ?>

												</div>
											</div>
										</td>
									</tr>
							<?php }
							} ?>
						</table>
					</div>
				<?php } ?>
				</div>
			</div>
	</div>
</div>

<?php require_once('includes/footer.php'); ?>
<script>
	$("#selectAll").click(function() {
		$("input[type=checkbox]").prop("checked", $(this).prop("checked"));
	});

	$("input[type=checkbox]").click(function() {
		if (!$(this).prop("checked")) {
			$("#selectAll").prop("checked", false);
		}
	});

	function clearRadioGroup(GroupClass) {
		var ele = document.getElementsByClassName(GroupClass);
		for (var i = 0; i < ele.length; i++)
			ele[i].checked = false;
	}
	
	$.fn.formToJson = function () {
		form = $(this);

		var formArray = form.serializeArray();
		var jsonOutput = {};

		$.each(formArray, function (i, element) {
			var elemNameSplit = element['name'].split('[');
			var elemObjName = 'jsonOutput';

			$.each(elemNameSplit, function (nameKey, value) {
				if (nameKey != (elemNameSplit.length - 1)) {
					if (value.slice(value.length - 1) == ']') {
						if (value === ']') {
							elemObjName = elemObjName + '[' + Object.keys(eval(elemObjName)).length + ']';
						} else {
							elemObjName = elemObjName + '[' + value;
						}
					} else {
						elemObjName = elemObjName + '.' + value;
					}

					if (typeof eval(elemObjName) == 'undefined')
						eval(elemObjName + ' = {};');
				} else {
					if (value.slice(value.length - 1) == ']') {
						if (value === ']') {
							eval(elemObjName + '[' + Object.keys(eval(elemObjName)).length + '] = \'' + element['value'].replace("'", "\\'") + '\';');
						} else {
							eval(elemObjName + '[' + value + ' = \'' + element['value'].replace("'", "\\'") + '\';');
						}
					} else {
						eval(elemObjName + '.' + value + ' = \'' + element['value'].replace("'", "\\'") + '\';');
					}
				}
			});
		});

		return jsonOutput;
	}

	$("#PermissionForm").submit(function(e) {

		e.preventDefault();

		var form = $(this);
		var url = form.attr('action');

		var json = JSON.stringify(form.formToJson());
		var b64 = btoa(json);

		$.ajax({
			type: "POST",
			url: url,
			data: {'data':json},
			success: function(data) {
				swal({
					title:'Sucesso!!!',
					text:'O Procedimento foi realizado com sucesso!',
					type:'success',
					button:'Fechar'
				}).then((value) => {
					window.location.href = '';
				});
			}
		});


	});
</script>