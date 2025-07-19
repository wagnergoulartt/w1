<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php require_once('controller/usuarios.php'); ?>
<?php $TitlePage = 'Usuários'; ?>
<?php $UrlPage	 = 'usuarios.php'; ?>
<?php $NumWM = DBCount('usuarios','id','WHERE permissao = 1'); ?>
<?php $NumADM = DBCount('usuarios','id','WHERE nivel <> 1'); ?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-users"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>

			<div class="row">
				<ul class="nav responsive-tab nav-material nav-material-white">
					<li><a class="nav-link" href="<?php echo $UrlPage; ?>"><i class="icon icon-list4"></i> Todos Usuários</a></li>
					<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'adicionar')) { ?>
						<li><a class="nav-link" href="?AdicionarItem"><i class="icon icon-plus-circle"></i> Adicionar Usuário</a>
					<?php } ?>
				</ul>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<?php if(isset($_GET['AdicionarItem'])){ if(!checkPermission($PERMISSION, $urlModule, 'item', 'adicionar')){ Redireciona('./index.php'); } ?>
			<form method="post" action="?Adicionar" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header  white">
						<strong>Adicionar Usuário</strong>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Nome:</label>
									<input class="form-control" name="nome" required>
								</div>

								<div class="form-group">
									<label>Login:</label>
									<input class="form-control" name="login" required>
								</div>

								<div class="form-group">
									<label>Senha:</label>
									<input class="form-control" name="senha" required>
								</div>

								<div class="form-group">
									<label>E-mail:</label>
									<input class="form-control" name="email" required>
								</div>

								<div class="form-group">
									<label>Sobre o autor:</label>
									<textarea class="form-control" name="sobre"></textarea>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Grupo do Usuário:</label>
									<select class="form-control" name="permissao" required>
										<?php $query = DBRead("permissions_groups",'*'); if (is_array($query)) { foreach ($query as $group) { ?>
										<option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
										<?php } } ?>
									</select>
								</div>

								<div class="form-group">
									<label>Avatar:</label>
									<input class="form-control" name="avatar" type="file">
								</div>

								<div class="form-group">
									<label>Status:</label>
									<select class="form-control" name="status" required>
										<option value="1">Ativo</option>
										<option value="2">Inativo</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="card-footer white">
						<button class="btn btn-primary float-right">Adicionar Usuário</button>
					</div>
				</div>
			</form>
		<?php } elseif(isset($_GET['EditarItem'])){ ?>
			<?php
				if(!checkPermission($PERMISSION, $urlModule, 'item', 'editar')){ Redireciona('./index.php'); }

				$id = get('EditarItem'); $Query = DBRead('usuarios','*',"WHERE id = '{$id}' {$sql}"); if (is_array($Query)) { foreach ($Query as $usuarios) { ?>
				<form method="post" action="?Atualizar=<?php echo $usuarios['id']; ?>" enctype="multipart/form-data">
					<div class="card">
						<div class="card-header  white">
							<strong>Editar Usuário</strong>
						</div>

						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Nome:</label>
										<input class="form-control" name="nome" value="<?php echo $usuarios['nome']; ?>" required>
									</div>

									<div class="form-group">
										<label>Login:</label>
										<input class="form-control" name="login" value="<?php echo $usuarios['login']; ?>" required>
									</div>

									<div class="form-group">
										<label>Senha:</label>
										<input class="form-control" name="senha">
									</div>

									<div class="form-group">
										<label>E-mail:</label>
										<input class="form-control" name="email" value="<?php echo $usuarios['email']; ?>" required>
									</div>

									<div class="form-group">
										<label>Sobre o autor:</label>
										<textarea class="form-control" name="sobre"><?php echo $usuarios['sobre']; ?></textarea>
									</div>
								</div>

								<div class="col-md-6">

									<div class="form-group">
										<label>Grupo do Usuário:</label>
										<select class="form-control" name="permissao" required>
											<?php $query = DBRead("permissions_groups",'*'); if (is_array($query)) { foreach ($query as $group) { ?>
											<option value="<?php echo $group['id']; ?>" <?php Selected($usuarios['permissao'], $group['id']); ?>><?php echo $group['name']; ?></option>
											<?php } } ?>
										</select>
									</div>
									

					            	<div class="form-group">
					            		<label><?php echo $txt['avatar_usuario']; ?></label>
					            		<input type="file" name="avatar" class="form-control"/>
					            	</div>

					            	<div class="form-group">
					            		<label><?php echo $txt['avataratual_usuario']; ?>:</label><br>
					            		<?php if ($usuarios['avatar'] == '') { ?>
					            			<img src="css_js/images/usuarios/avatar.png" width="100px" height="100px" />
					            		<?php } else { ?>
					            			<img src="css_js/images/usuarios/<?php echo $usuarios['avatar']; ?>" width="100px" height="100px" />
					            		<?php } ?>

					            		<input type="hidden" name="avatar_atual" value="<?php echo $usuarios['avatar']; ?>"/>
					            	</div>

									<div class="form-group">
										<label>Status:</label>
										<select class="form-control" name="status" required>
											<option value="1">Ativo</option>
											<option value="2">Inativo</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="card-footer white">
							<button class="btn btn-primary float-right">Atualizar Usuário</button>
						</div>
					</div>
					</form>
				<?php } } ?>
			<?php } else { ?>
				<div class="card">
					<div class="card-header white">
						<strong>Usuários do Sistema</strong>
					</div>

					<div class="card-body p-0">
						<div >
							<table class="table table-striped">
								<tr>
									<th>ID</th>
									<th>Nome</th>
									<th>Login</th>
									<th>E-mail</th>
									<th>Grupo</th>
									<th>Status</th>
									<th width="53px">Ações</th>
								</tr>

								<?php
									$Query = DBRead('usuarios','*',"WHERE id <> 0 {$sql}");

									if (is_array($Query)) { foreach ($Query as $usuarios) {
								?>
									<tr>
										<td><?php echo $usuarios['id']; ?></td>
										<td><?php echo $usuarios['nome']; ?></td>
										<td><?php echo $usuarios['login']; ?></td>
										<td><?php echo $usuarios['email']; ?></td>
										<td><?php NivelUsuario($usuarios['permissao']); ?></td>
										<td><?php StatusUsuario($usuarios['status']); ?></td>
										<td>
											<div class="dropdown">
												<a class="" href="#" data-toggle="dropdown">
													<i class="icon-apps blue lighten-2 avatar"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">

													<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'editar')) { ?>
													<a class="dropdown-item" href="?EditarItem=<?php echo $usuarios['id']; ?>"><i class="text-primary icon icon-pencil"></i> Editar</a>
													<?php } ?>

													<?php if(DadosSession('id') <> $usuarios['id']): ?>
													<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'editar')) { ?>
													<?php if ($usuarios['status'] == 1) { ?>
														<a class="dropdown-item" href="?desativar=<?php echo $usuarios['id']; ?>">Desativar</a>
													<?php } else { ?>
														<a class="dropdown-item" href="?ativar=<?php echo $usuarios['id']; ?>">Ativar</a>
													<?php } ?>
													<?php } ?>
													<?php endif; ?>
													
													<?php if(DadosSession('id') <> $usuarios['id']): ?>
													<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'deletar')) { ?>
														<a onclick="DeletarItem(<?php echo $usuarios['id']; ?> , 'excluir');" href="#!" class="dropdown-item"><i class="text-danger icon icon-remove"></i> Excluir</a>
													<?php } ?>
													<?php endif; ?>
												</div>
											</div>
										</td>
									</tr>
								<?php } } ?>
							</table>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>

<?php require_once('includes/footer.php'); ?>