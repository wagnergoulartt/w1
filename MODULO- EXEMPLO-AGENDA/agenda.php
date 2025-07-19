<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php require_once('controller/agenda.php'); ?>
<?php $TitlePage = 'Agenda de Eventos'; ?>
<?php $UrlPage	 = 'agenda.php'; ?>
<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-calendar"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<p>
			<a class="btn btn-sm btn-primary" href="<?php echo $UrlPage; ?>">Eventos Cadastrados</a>
			<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'adicionar')) { ?>
				<a class="btn btn-sm btn-primary" href="?AdicionarItem">Cadastrar Evento</a>
			<?php } ?>
			<?php if (DadosSession('nivel') == 1) { ?>
				<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'adicionar')) { ?>
					<a class="btn btn-sm btn-primary" href="?AdicionarCategoria">Cadastrar Categoria</a>
				<?php } ?>

				<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'adicionar') || checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'editar') || checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'deletar')) { ?>
				<a class="btn btn-sm btn-primary" href="?Implementacao">Categorias/Implementação</a>
				<?php } ?>
				<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'codigo', 'acessar')) { ?>
				<button class="btn btn-sm behance text-white" data-toggle="modal" data-target="#Ajuda"><i class="icon-question-circle"></i></button>
<?php } ?>
			<?php } ?>
		</p>

		<?php if (isset($_GET['AdicionarItem'])) {
			if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'adicionar')) {
				Redireciona('./index.php');
			}
			VerificaCategoria('c_agenda');
		?>
			<form method="post" action="?Adicionar" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header  white">
						<strong>Cadastrar Item</strong>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Titulo:</label>
									<input class="form-control basic-usage" name="titulo" required>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Data:</label>
											<input class="form-control" type="date" name="dataI" value="<?php echo date('Y-m-d'); ?>" required>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Hora:</label>
											<input class="form-control" type="time" name="horaI">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Data de Término:</label>
											<input class="form-control" type="date" name="dataT" value="<?php echo date('Y-m-d'); ?>">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Hora de Término:</label>
											<input class="form-control" type="time" name="horaT">
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Categoria:</label>
									<select class="form-control custom-select" name="id_categoria">
										<?php $Query = DBRead('c_agenda', '*', 'WHERE id > 0 ORDER BY categoria ASC');
										if (is_array($Query)) {
											foreach ($Query as $c_agenda) { ?>
												<option value="<?php echo $c_agenda['id']; ?>"><?php echo $c_agenda['categoria']; ?></option>
										<?php }
										} ?>
									</select>
								</div>

								<div class="form-group">
									<label>Imagem:</label>
									<input class="form-control" type="file" name="imagem" required>
								</div>

								<div class="form-group">
									<label>Status:</label>
									<select class="form-control custom-select" name="status">
										<option value="1">Ativo</option>
										<option value="2">Inativo</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>URL Amigável:</label>
									<input class="form-control" name="url" id="permalink">
								</div>

								<div class="form-group">
									<label>Resumo: <em>Max. 250 Caracteres</em></label>
									<textarea class="form-control" name="resumo" maxlength="250" required></textarea>
								</div>

								<div class="form-group">
									<label>Conteúdo:</label>
									<textarea class="form-control tinymce" name="conteudo"></textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="card-footer white">
						<button class="btn btn-primary float-right" type="submit">Adicionar</button>
					</div>
				</div>
			</form>
		<?php } elseif (isset($_GET['EditarItem'])) {
			if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'editar')) {
				Redireciona('./index.php');
			} ?>
			<?php $id = get('EditarItem');
			$Query = DBRead('agenda', '*', "WHERE id = '{$id}'");
			if (is_array($Query)) {
				foreach ($Query as $agenda) { ?>
					<form method="post" action="?Atualizar=<?php echo $id; ?>" enctype="multipart/form-data">
						<div class="card">
							<div class="card-header  white">
								<strong>Editar Item</strong>
							</div>

							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Titulo:</label>
											<input class="form-control basic-usage" name="titulo" value="<?php echo $agenda['titulo']; ?>" required>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Data de Inicio:</label>
													<input class="form-control" type="date" name="dataI" value="<?php echo $agenda['dataI']; ?>" required>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Hora de Inicio:</label>
													<input class="form-control" type="time" name="horaI" value="<?php echo $agenda['horaI']; ?>">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Data de Término:</label>
													<input class="form-control" type="date" name="dataT" value="<?php echo $agenda['dataT']; ?>">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Hora de Término:</label>
													<input class="form-control" type="time" name="horaT" value="<?php echo $agenda['horaT']; ?>">
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Categoria:</label>
											<select class="form-control custom-select" name="id_categoria">
												<?php $Query = DBRead('c_agenda', '*', 'WHERE id > 0 ORDER BY categoria ASC');
												if (is_array($Query)) {
													foreach ($Query as $c_agenda) { ?>
														<option value="<?php echo $c_agenda['id']; ?>" <?php Selected($agenda['id_categoria'], $c_agenda['id']); ?>><?php echo $c_agenda['categoria']; ?></option>
												<?php }
												} ?>
											</select>
										</div>

										<div class="form-group">
											<label>Atualizar Imagem:</label>
											<input class="form-control" type="file" name="imagem">
											<!--<input class="hidden" name="imagem_atual" value="<?php echo $agenda['imagem']; ?>">-->
										</div>

										<div class="form-group">
											<label>Status:</label>
											<select class="form-control custom-select" name="status">
												<option value="1" <?php Selected($agenda['status'], '1'); ?>>Ativo</option>
												<option value="2" <?php Selected($agenda['status'], '2'); ?>>Inativo</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>URL Amigável:</label>
											<input class="form-control" name="url" id="permalink" value="<?php echo $agenda['url']; ?>">
										</div>

										<div class="form-group">
											<label>Resumo: <em>Max. 250 Caracteres</em></label>
											<textarea class="form-control" name="resumo" maxlength="250" required><?php echo $agenda['resumo']; ?></textarea>
										</div>

										<div class="form-group">
											<label>Conteúdo:</label>
											<textarea class="form-control tinymce" name="conteudo"><?php echo $agenda['conteudo']; ?></textarea>
										</div>
									</div>
								</div>
							</div>

							<div class="card-footer white">
								<button class="btn btn-primary float-right" type="submit">Atualizar</button>
							</div>
						</div>
					</form>
			<?php }
			} ?>
		<?php } elseif (isset($_GET['AdicionarCategoria'])) {
			if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'adicionar')) {
				Redireciona('./index.php');
			} ?>
			<form method="post" action="?AddCategoria" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header  white">
						<strong>Cadastrar Categoria</strong>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Titulo:</label>
									<input class="form-control" name="categoria">
								</div>

								<div class="form-group">
									<label>Ordernar por:</label>
									<select class="form-control custom-select" name="ordenar_por">
										<option value="id">ID (Ordem de Criação)</option>
										<option value="titulo">Titulo</option>
										<option value="dataI">Data</option>
									</select>
								</div>

								<div class="form-group">
									<label>Ordem de Exibição:</label>
									<select class="form-control custom-select" name="asc_desc">
										<option value="ASC">Crescente (Menor > Maior)</option>
										<option value="DESC">Decrescente (Maior > Menor)</option>
									</select>
								</div>

								<div class="form-group">
									<label>Estilos:</label>
									<select class="form-control custom-select" name="modelo">
										<option value="modelo-1">Estilo 01</option>
										<option value="modelo-2">Estilo 02 </option>
										<option value="modelo-3">Estilo 03</option>
										<option value="modelo-4">Estilo 04</option>
									</select>
								</div>

								<div class="form-group">
									<label>Colunas:</label>
									<select class="form-control custom-select" name="colunas">
										<option value="2">2 Colunas</option>
										<option value="3">3 Colunas</option>
										<option value="4">4 Colunas</option>
									</select>
								</div>

								<div class="form-group">
									<label>Mostrar Paginação:</label>
									<select class="form-control custom-select" name="ativa_paginacao">
										<option value="S">Sim</option>
										<option value="N">Não</option>
									</select>
								</div>

								<div class="form-group">
									<label>Link da Matriz:</label>
									<input type="url" class="form-control" name="matriz" required>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Cor background texto no índice:</label>
									<div class="color-picker input-group colorpicker-element focused">
										<input type="text" value="#00AABB" name="background" class="form-control">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle" style="background-color: rgb(0, 170, 187);"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label>Cor texto resumo na pag índice:</label>
									<div class="color-picker input-group colorpicker-element focused">
										<input type="text" value="#00AABB" name="cor_fonte" class="form-control">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle" style="background-color: rgb(0, 170, 187);"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label>Cor texto titulo na pag índice:</label>
									<div class="color-picker input-group colorpicker-element focused">
										<input type="text" value="#00AABB" name="cor_titulo" class="form-control">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle" style="background-color: rgb(0, 170, 187);"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group hidden">
									<label>Cor do Botão:</label>
									<div class="color-picker input-group colorpicker-element focused">
										<input type="text" name="cor_btn" value="#00AABB" class="form-control">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle" style="background-color: rgb(0, 170, 187);"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group hidden">
									<label>Cor seta carousel:</label>
									<div class="color-picker input-group colorpicker-element focused">
										<input type="text" value="#00AABB" name="cor_carousel" class="form-control">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle" style="background-color: rgb(0, 170, 187);"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group <?php if (DadosSession('nivel') <> 1) { ?>hidden<?php } ?>">
									<label>Efeito de Entrada do Módulo:</label>
									<select name="efeito" required class="form-control custom-select">
										<option value="none">Nenhum</option>
										<option value="tc-animation-slide-top">Slide Top</option>
										<option value="tc-animation-slide-right">Slide Right</option>
										<option value="tc-animation-slide-bottom">Slide Bottom</option>
										<option value="tc-animation-slide-left">Slide Left</option>
										<option value="tc-animation-scale-up">Scale Up</option>
										<option value="tc-animation-scale-down">Scale Down</option>
										<option value="tc-animation-scale">Scale</option>
										<option value="tc-animation-shake">Shake</option>
										<option value="tc-animation-rotate">Rotate</option>
									</select>
								</div>

								<div class="form-group">
									<label>Paginação:</label>
									<input class="form-control" type="number" name="paginacao" min="1" required>
								</div>

								<div class="form-group">
									<label>Carousel: <em>Carousel: Essa função só funciona com o estilo 1. É necessário ter 6 post’s ou mais</em></label>
									<select class="form-control custom-select" name="carousel">
										<option value="1">Ativo</option>
										<option value="2">Inativo</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="card-footer white">
						<button class="btn btn-primary float-right" type="submit">Adicionar</button>
					</div>
				</div>
			</form>
		<?php } elseif (isset($_GET['EditarCategoria'])) {
			if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'editar')) {
				Redireciona('./index.php');
			} ?>
			<?php $id = get('EditarCategoria');
			$Query = DBRead('c_agenda', '*', "WHERE id = '{$id}'");
			if (is_array($Query)) {
				foreach ($Query as $c_agenda) { ?>
					<form method="post" action="?AtualizarCategoria=<?php echo $id; ?>">
						<div class="card">
							<div class="card-header  white">
								<strong>Editar Categoria</strong>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Titulo:</label>
											<input class="form-control" name="categoria" value="<?php echo $c_agenda['categoria']; ?>">
										</div>

										<div class="form-group">
											<label>Ordernar por:</label>
											<select class="form-control custom-select" name="ordenar_por">
												<option value="id" <?php Selected($c_agenda['ordenar_por'], 'id'); ?>>ID (Ordem de Criação)</option>
												<option value="titulo" <?php Selected($c_agenda['ordenar_por'], 'titulo'); ?>>Titulo</option>
												<option value="dataI" <?php Selected($c_agenda['ordenar_por'], 'dataI'); ?>>Data</option>
											</select>
										</div>

										<div class="form-group">
											<label>Ordem de Exibição:</label>
											<select class="form-control custom-select" name="asc_desc">
												<option value="ASC" <?php Selected($c_agenda['asc_desc'], 'ASC'); ?>>Crescente (Menor > Maior)</option>
												<option value="DESC" <?php Selected($c_agenda['asc_desc'], 'DESC'); ?>>Decrescente (Maior > Menor)</option>
											</select>
										</div>

										<div class="form-group">
											<label>Estilos:</label>
											<select class="form-control custom-select" name="modelo">
												<option value="modelo-1" <?php Selected($c_agenda['modelo'], 'modelo-1'); ?>>Estilo 01</option>
												<option value="modelo-2" <?php Selected($c_agenda['modelo'], 'modelo-2'); ?>>Estilo 02</option>
												<option value="modelo-3" <?php Selected($c_agenda['modelo'], 'modelo-3'); ?>>Estilo 03</option>
												<option value="modelo-4" <?php Selected($c_agenda['modelo'], 'modelo-4'); ?>>Estilo 04</option>
											</select>
										</div>

										<div class="form-group">
											<label>Colunas:</label>
											<select class="form-control custom-select" name="colunas">
												<option value="2" <?php Selected($c_agenda['colunas'], '2'); ?>>2 Colunas</option>
												<option value="3" <?php Selected($c_agenda['colunas'], '3'); ?>>3 Colunas</option>
												<option value="4" <?php Selected($c_agenda['colunas'], '4'); ?>>4 Colunas</option>
											</select>
										</div>

										<div class="form-group">
											<label>Mostrar Paginação:</label>
											<select class="form-control custom-select" name="ativa_paginacao">
												<option value="S" <?php Selected($c_agenda['ativa_paginacao'], 'S'); ?>>Sim</option>
												<option value="N" <?php Selected($c_agenda['ativa_paginacao'], 'N'); ?>>Não</option>
											</select>
										</div>

										<?php if ($c_agenda['id'] <> '0') { ?>
										<div class="form-group">
											<label>Link da Matriz:</label>
											<input type="url" class="form-control" name="matriz" value="<?php echo $c_agenda['matriz']; ?>">
										</div>
										<?php } ?>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Cor background texto no índice:</label>
											<div class="color-picker input-group colorpicker-element focused">
												<input type="text" name="background" value="<?php echo $c_agenda['background']; ?>" class="form-control">
												<span class="input-group-append">
													<span class="input-group-text add-on white">
														<i class="circle" style="background-color: <?php echo $c_agenda['background']; ?>;"></i>
													</span>
												</span>
											</div>
										</div>

										<div class="form-group">
											<label>Cor texto resumo na pag índice:</label>
											<div class="color-picker input-group colorpicker-element focused">
												<input type="text" name="cor_fonte" value="<?php echo $c_agenda['cor_fonte']; ?>" class="form-control">
												<span class="input-group-append">
													<span class="input-group-text add-on white">
														<i class="circle" style="background-color: <?php echo $c_agenda['cor_fonte']; ?>;"></i>
													</span>
												</span>
											</div>
										</div>

										<div class="form-group">
											<label>Cor texto titulo na pag índice:</label>
											<div class="color-picker input-group colorpicker-element focused">
												<input type="text" name="cor_titulo" value="<?php echo $c_agenda['cor_titulo']; ?>" class="form-control">
												<span class="input-group-append">
													<span class="input-group-text add-on white">
														<i class="circle" style="background-color: <?php echo $c_agenda['cor_titulo']; ?>"></i>
													</span>
												</span>
											</div>
										</div>

										<div class="form-group hidden">
											<label>Cor do Botão:</label>
											<div class="color-picker input-group colorpicker-element focused">
												<input type="text" name="cor_btn" value="<?php echo $c_agenda['cor_btn']; ?>" class="form-control">
												<span class="input-group-append">
													<span class="input-group-text add-on white">
														<i class="circle" style="background-color: <?php echo $c_agenda['cor_btn']; ?>;"></i>
													</span>
												</span>
											</div>
										</div>

										<div class="form-group">
											<label>Cor da seta carousel:</label>
											<div class="color-picker input-group colorpicker-element focused">
												<input type="text" name="cor_carousel" value="<?php echo $c_agenda['cor_carousel']; ?>" class="form-control">
												<span class="input-group-append">
													<span class="input-group-text add-on white">
														<i class="circle" style="background-color: <?php echo $c_agenda['cor_carousel']; ?>;"></i>
													</span>
												</span>
											</div>
										</div>

										<div class="form-group <?php if (DadosSession('nivel') <> 1) { ?>hidden<?php } ?>">
											<label>Efeito de Entrada do Módulo:</label>
											<select name="efeito" required class="form-control custom-select">
												<option value="none">Nenhum</option>
												<option value="tc-animation-slide-top" <?php Selected($c_agenda['efeito'], 'tc-animation-slide-top'); ?>>Slide Top</option>
												<option value="tc-animation-slide-right" <?php Selected($c_agenda['efeito'], 'tc-animation-slide-right'); ?>>Slide Right</option>
												<option value="tc-animation-slide-bottom" <?php Selected($c_agenda['efeito'], 'tc-animation-slide-bottom'); ?>>Slide Bottom</option>
												<option value="tc-animation-slide-left" <?php Selected($c_agenda['efeito'], 'tc-animation-slide-left'); ?>>Slide Left</option>
												<option value="tc-animation-scale-up" <?php Selected($c_agenda['efeito'], 'tc-animation-scale-up'); ?>>Scale Up</option>
												<option value="tc-animation-scale-down" <?php Selected($c_agenda['efeito'], 'tc-animation-scale-down'); ?>>Scale Down</option>
												<option value="tc-animation-scale" <?php Selected($c_agenda['efeito'], 'tc-animation-scale'); ?>>Scale</option>
												<option value="tc-animation-shake" <?php Selected($c_agenda['efeito'], 'tc-animation-shake'); ?>>Shake</option>
												<option value="tc-animation-rotate" <?php Selected($c_agenda['efeito'], 'tc-animation-rotate'); ?>>Rotate</option>
											</select>
										</div>

										<div class="form-group">
											<label>Paginação:</label>
											<input class="form-control" type="number" name="paginacao" value="<?php echo $c_agenda['paginacao']; ?>" min="1" required>
										</div>

										<div class="form-group">
											<label>Carousel: <em>Carousel: Essa função só funciona com o estilo 1. É necessário ter 6 post’s ou mais</em></label>
											<select class="form-control custom-select" name="carousel">
												<option value="1" <?php Selected($c_agenda['carousel'], '1'); ?>>Ativo</option>
												<option value="2" <?php Selected($c_agenda['carousel'], '2'); ?>>Inativo</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer white">
								<button class="btn btn-primary float-right" type="submit">Atualizar</button>
							</div>
						</div>
	</div>
	</form>
<?php }
			} ?>
<?php } elseif (isset($_GET['Implementacao'])) { ?>
	<div class="card">
		<div class="card-header  white">
			<strong>Categorias / Implementação</strong>
		</div>
		<div class="card-body p-0">
			<div>
				<table class="table table-striped">
					<tr>
						<th>ID</th>
						<th>Titulo</th>
						<?php if (DadosSession('nivel') == 1) { ?>
							<th>Implementação WA5</th>
						<?php } ?>
						<th width="53px">Ações</th>
					</tr>

					<?php $Query = DBRead('c_agenda', '*');
					if (is_array($Query)) {
						foreach ($Query as $c_agenda) { ?>
							<?php
							$CodSite = '<div id="AgendaEventosWA' . $c_agenda['id'] . '" data-categoria="' . $c_agenda['id'] . '" data-painel="' . RemoveHttpS(ConfigPainel('base_url')) . '"></div>' . "\n";
							$CodSite .= '<script>AgendaEventos(' . $c_agenda['id'] . ',1,"true");</script>';
							$CodSiteWA4 = '<iframe width="100%" height="100%" scrolling="auto" seamless="seamless" frameborder="0" src="' . RemoveHttpS(ConfigPainel('base_url')) . '/wa/agenda.php?id=' . $c_agenda['id'] . '&Wa4"></iframe>';
							?>

							<tr>
								<td><?php echo $c_agenda['id']; ?></td>
								<td><?php echo $c_agenda['categoria']; ?></td>
								<?php if (DadosSession('nivel') == 1) { ?>
									<td>
										<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'codigo', 'acessar')) { ?>
											<button id="btnCopiarCodSite<?php echo $c_agenda['id']; ?>" class="btn btn-primary btn-xs" onclick="CopiadoCodSite(<?php echo $c_agenda['id']; ?>)" data-clipboard-text='<?php echo $CodSite; ?>'>
												<i class="icon icon-code"></i> Copiar Cód. do Site
											</button>
										<?php } ?>
									</td>
								<?php } ?>
								<td>
									<div class="dropdown">
										<a class="" href="#" data-toggle="dropdown">
											<i class="icon-apps blue lighten-2 avatar"></i>
										</a>

										<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
											<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'editar')) { ?>
												<a class="dropdown-item" href="?EditarCategoria=<?php echo $c_agenda['id']; ?>"><i class="text-primary icon icon-pencil"></i> Editar</a>
											<?php } ?>
											<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'adicionar')) { ?>
												<a class="dropdown-item" href="?DuplicarCategoria=<?php echo $c_agenda['id']; ?>"><i class="text-primary icon icon-clone"></i> Duplicar</a>
											<?php } ?>
											
											<?php if ($c_agenda['id'] != '0') { ?>
												<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'matriz', 'acessar')) { ?>
													<a class="dropdown-item" onclick="AtualizaMatriz(<?php echo $c_agenda['id']; ?>)" href="#!"><i class="text-success icon icon-refresh"></i> Atualizar Matriz</a>
												<?php } ?>
												<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'deletar')) { ?>
													<a class="dropdown-item" onclick="DeletarItem(<?php echo $c_agenda['id']; ?>, 'DeletarCategoria');" href="#!"><i class="text-danger icon icon-remove"></i> Excluir</a>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</td>
							</tr>
					<?php }
					} ?>
				</table>
			</div>
		<?php } else { ?>
			<div class="card">
				<div class="card-header  white">
					<strong>Itens Cadastrados</strong>
				</div>

				<?php $Query = DBRead('agenda', '*');
				if (is_array($Query)) { ?>
					<div class="card-body p-0">
						<div>
							<table class="table table-striped">
								<tr>
									<th>ID</th>
									<th>Imagem</th>
									<th>Titulo</th>
									<th>Categoria</th>
									<th>Data</th>
									<th>Status</th>
									<th width="53px">Ações</th>
								</tr>

								<?php foreach ($Query as $agenda) { ?>
									<tr>
										<td><?php echo $agenda['id']; ?></td>
										<td><img class="user_avatar no-b no-p r-5" src="<?php echo ConfigPainel('base_url'); ?>/wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/wa/agenda/uploads/<?php echo $agenda['imagem']; ?>&w=60" /></td>
										<td><?php echo LimitarTexto($agenda['titulo'], '80', '...'); ?></td>
										<td><?php echo VerificaCategoriaItem($agenda['id_categoria'], 'c_agenda'); ?></td>
										<td><?php echo $agenda['dataI']; ?></td>
										<td><?php Status($agenda['status']); ?></td>
										<td>
											<div class="dropdown">
												<a class="" href="#" data-toggle="dropdown">
													<i class="icon-apps blue lighten-2 avatar"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
													<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'editar')) { ?>
														<a class="dropdown-item" href="?EditarItem=<?php echo $agenda['id']; ?>"><i class="text-primary icon icon-pencil"></i> Editar</a>
													<?php } ?>
													<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'adicionar')) { ?>
														<a class="dropdown-item" href="?Duplicar=<?php echo $agenda['id']; ?>"><i class="text-primary icon icon-clone"></i> Duplicar</a>
													<?php } ?>
													<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'deletar')) { ?>
														<a class="dropdown-item" onclick="DeletarItem(<?php echo $agenda['id']; ?>, 'DeletarItem');" href="#!"><i class="text-danger icon icon-remove"></i> Excluir</a>
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
						<div class="alert alert-info">Nenhum item cadastrado até o momento, <a href="?AdicionarItem">clique aqui</a> para cadastar.</div>
					</div>
			<?php }
			} ?>
			</div>
		</div>
	</div>

	<?php require_once('includes/footer.php'); ?>
	<div class="modal fade" id="Ajuda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content b-0">
				<div class="modal-header r-0 bg-primary">
					<h6 class="modal-title text-white" id="exampleModalLabel">Informações de Sobre o Módulo</h6>
					<a href="#" data-dismiss="modal" aria-label="Close" class="paper-nav-toggle paper-nav-white active"><i></i></a>
				</div>

				<div class="modal-body">
					<p>
						1- Recomendamos desativar efeitos parallax em páginas onde o módulo será integrado.<br>
						2- Caso queira usar mais de uma categorias por página, a opção compartilhar do facebook poderá não funcionar corretamente.<br>
						3- Bloqueie o acesso somente as páginas matrizes pelo robots.txt para que não sejam indexadas.<br>
						4- A função carrousel funciona apenas no Estilo 01 e é preciso ter no mínimo 5 postagens cadastradas.<br>

						<hr>

						<p><b>Tags de Integração:</b></p>
						<table class="table table-bordered table-striped">
							<tr>
								<th>Referencia</th>
								<th>Tag</th>
							</tr>

							<tr>
								<td>Titulo</td>
								<td>[WAC_AGENDA_TITULO]</td>
							</tr>

							<tr>
								<td>Conteúdo</td>
								<td>[WAC_AGENDA_CONTEUDO]</td>
							</tr>

							<tr>
								<td>Categoria</td>
								<td>[WAC_AGENDA_CATEGORIA]</td>
							</tr>

							<tr>
								<td>Url</td>
								<td>[WAC_AGENDA_URL]</td>
							</tr>

							<tr>
								<td>Resumo</td>
								<td>[WAC_AGENDA_RESUMO]</td>
							</tr>

							<tr>
								<td>Imagem</td>
								<td>[WAC_AGENDA_IMAGEM]</td>
							</tr>

							<tr>
								<td>Imagem Grande</td>
								<td>[WAC_AGENDA_IMAGEM_650]</td>
							</tr>

							<tr>
								<td>Imagem Média</td>
								<td>[WAC_AGENDA_IMAGEM_450]</td>
							</tr>

							<tr>
								<td>Imagem Pequena</td>
								<td>[WAC_AGENDA_IMAGEM_250]</td>
							</tr>

							<tr>
								<td>Url da Imagem</td>
								<td>[WAC_AGENDA_IMAGEM_URL]</td>
							</tr>

							<tr>
								<td>Data de Inicio</td>
								<td>[WAC_AGENDA_DATA_INICIO]</td>
							</tr>

							<tr>
								<td>Hora de Inicio</td>
								<td>[WAC_AGENDA_HORA_INICIO]</td>
							</tr>

							<tr>
								<td>Data de Término</td>
								<td>[WAC_AGENDA_DATA_TERMINO]</td>
							</tr>

							<tr>
								<td>Hora de Término</td>
								<td>[WAC_AGENDA_HORA_TERMINO]</td>
							</tr>

							<tr>
								<td>Compartilhar Evento</td>
								<td>[WAC_AGENDA_COMPARTILHAR]</td>
							</tr>
						</table>

						<p>Tags do Facebook SEO (Inserir nas Propriedades da Página em Custom meta tags):</b></p>
						<textarea class="form-control" rows="5" readonly>
<meta property="og:title" content="[WAC_AGENDA_TITULO]" />
<meta property="og:url" content="[WAC_AGENDA_URL]" />
<meta property="og:image" content="[WAC_AGENDA_IMAGEM_URL]" />
<meta property="og:description" content="[WAC_AGENDA_RESUMO]" />
					</textarea>

						<br>

						<em>Atenção: Incluir no local desejado na página matriz usando o código HTML.</em>
						<p><b>Boas Práticas para uma boa indexação (SEO):</b></p>
						Tente utilizar esses dados como base para criar as postagens de modo que elas sejam bem indexadas pelo google:<br>
						Titulo: Máx de 90 Caracteres<br>
						Palavras Chaves: Máx de 200 Caracteres<br>
						Resumo: Máx de 160 Caracteres<br>
				</div>
				</p>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="css_js/speakingurl.min.js"></script>
	<script type="text/javascript" src="css_js/jquery.stringtoslug.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".basic-usage").stringToSlug({
				setEvents: 'keyup keydown blur',
				getPut: '#permalink',
				space: '-',
				prefix: '',
				suffix: '',
				replace: '',
				AND: 'and',
				options: {},
				callback: false
			});
		});
	</script>
	<script type="text/javascript">
		function AtualizaMatriz(id) {
			$.ajax({
				type: "GET",
				cache: false,
				url: "controller/agenda.atualiza.matriz.php?id=" + id + "",
				beforeSend: function(data) {
					swal({
						title: 'Aguarde!',
						text: 'Estamos gerando as postagens atualizadas.\nNão recarregue a página até a mensagem de sucesso.',
						type: "info",
						html: true,
						showConfirmButton: true
					});
				},
				complete: function(data) {
					swal("Postagens Atualizadas!", "Matrizes atualizadas com sucesso!", "success")
				}
			});
		}
	</script>
	<script type="text/javascript">
		$("[rel=tooltip]").tooltip({
			html: true,
			placement: 'top'
		});
	</script>

	<?php
	if (@$atualizarMatriz) {
		echo $atualizarMatriz;
		Redireciona('?Implementacao&sucesso');
	}

	// Excluir Comentario
	if (isset($_GET['DeletarComentario'])) {
		$id = get('DeletarComentario');
		$Query = DBDelete('comentario', "id = '{$id}'");
		if ($Query != 0) {
			echo '<script>AtualizaMatriz(' . getagendaComentario(getComentarios($id)) . ')</script>';
			Redireciona('?Comentarios=' . $_GET['Comentarios'] . '&sucesso');
		} else {
			Redireciona('?erro');
		}
	}

	// Atualizar Status
	if (isset($_GET['mostrar'])) {
		$id = $_GET['mostrar'];
		$Atualizar = array('ativo' => 1,);
		if (DBUpdate('comentario', $Atualizar, "id = '{$id}'")) {
			print_r(getComentarios($id));
			echo '<script>AtualizaMatriz(' . getagendaComentario($id) . ')</script>';
			Redireciona('?Comentarios=' . $_GET['Comentarios'] . '&sucesso');
		} else {
			Redireciona('?erro');
		}
	}

	if (isset($_GET['ocultar'])) {
		$id = $_GET['ocultar'];
		$Atualizar = array('ativo' => 0,);
		if (DBUpdate('comentario', $Atualizar, "id = '{$id}'")) {
			print_r(getComentarios($id));
			echo '<script>AtualizaMatriz(' . getagendaComentario($id) . ')</script>';
			Redireciona('?Comentarios=' . $_GET['Comentarios'] . '&sucesso');
		} else {
			Redireciona('?erro');
		}
	}
	?>