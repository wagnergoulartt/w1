<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php require_once('controller/configuracoes.php'); ?>
<?php $TitlePage = 'Configurações'; ?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-cog"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<?php $Query = DBRead('config','*'); if (is_array($Query)) { foreach ($Query as $config) {?>
			<form method="post" action="?Atualizar" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header white">
						<strong>Configurações do Sistema</strong>
					</div>

					<div class="card-body">
						<?php
							if(isset($_GET['removerBackground'])){
								if(unlink('css_js/images/background.png')){
									Redireciona('?sucesso');
								}

								Redireciona('?erro');
							}
						?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Titulo do Site:</label>
									<input class="form-control" name="site_nome" value="<?php echo $config['site_nome']; ?>" required>
								</div>

								<div class="form-group">
									<label>URL do Site:</label>
									<input class="form-control" name="site_url" value="<?php echo $config['site_url']; ?>" placeholder="http://www.seusite.com.br/" required>
								</div>

								<div class="form-group">
									<label>URL de Instalação:</label>
									<input class="form-control" name="base_url" value="<?php echo $config['base_url']; ?>" required>
								</div>

								<div class="form-group">
									<label>E-mail:</label>
									<input class="form-control" value="<?php echo $config['email']; ?>" readonly>
								</div>

								<div class="form-group">
									<label>Mostrar Erros:</label>
									<select name="erro" class="form-control">
										<option value="S" <?php Selected($config['erro'],'S'); ?>><?php echo $txt['mostrar_debug']; ?></option>
										<option value="N" <?php Selected($config['erro'],'N'); ?>><?php echo $txt['naomostrar']; ?></option>
									</select>
								</div>

								<div class="form-group">
									<label>Forçar SSL:</label>
									<select name="ssl" class="form-control">
										<option value="S" <?php if (FORCAR_SSL == 'true') { echo "selected"; } ?>>Ativo</option>
										<option value="N" <?php if (FORCAR_SSL == 'false') { echo "selected"; } ?>>Inativo</option>
									</select>
								</div>

								<div class="form-group">
									<label>Mostrar Ícones nos Blocos da Dashboard:</label>
									<select name="iconesdash" class="form-control">
										<option value="S" <?php if (defined('ICONESDASH') && ICONESDASH == 'true') { echo "selected"; } ?>>Ativo</option>
										<option value="N" <?php if (defined('ICONESDASH') && ICONESDASH == 'false') { echo "selected"; } ?>>Inativo</option>
									</select>
								</div>

								<div class="form-group">
									<label>Listagem dos Itens dos Módulos:</label>
									<select name="paginacao" class="form-control">
										<option value="10" <?php if ($config['paginacao'] == '10') { echo "selected"; } ?>>10</option>
										<option value="20" <?php if ($config['paginacao'] == '20') { echo "selected"; } ?>>20</option>
										<option value="30" <?php if ($config['paginacao'] == '30') { echo "selected"; } ?>>30</option>
										<option value="40" <?php if ($config['paginacao'] == '40') { echo "selected"; } ?>>40</option>
										<option value="50" <?php if ($config['paginacao'] == '50') { echo "selected"; } ?>>50</option>
										<option value="75" <?php if ($config['paginacao'] == '75') { echo "selected"; } ?>>75</option>
										<option value="100" <?php if ($config['paginacao'] == '100') { echo "selected"; } ?>>100</option>
									</select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Tela de Login:</label>
									<select name="tema" class="form-control">
										<option value="tema01" <?php Selected($config['tema'],'tema01'); ?>>Tema 01 (Padrão)</option>
										<option value="tema02" <?php Selected($config['tema'],'tema02'); ?>>Tema 02</option>
										<option value="tema03" <?php Selected($config['tema'],'tema03'); ?>>Tema 03</option>
										<option value="tema04" <?php Selected($config['tema'],'tema04'); ?>>Tema 04</option>
									</select>
								</div>

								<div class="form-group">
									<label>Cor Primária:</label>
									<div class="color-picker input-group colorpicker-element focused" name="">
										<input type="text" name="cor_blocos" value="<?php echo $config['cor_blocos']; ?>" class="form-control">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle" style="background-color: rgb(0, 170, 187);"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label>Cor Secundária:</label>
									<div class="color-picker input-group colorpicker-element focused" name="">
										<input type="text" name="menu" value="<?php echo $config['menu']; ?>" class="form-control">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle" style="background-color: rgb(0, 170, 187);"></i>
											</span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label>Logo Atual:</label>
									<p><img src="css_js/images/logo/<?php echo ConfigPainel('logo'); ?>" /></p>
	
									<label>Enviar Logo:</label>
									<input class="form-control" type="file" name="imagem">
								</div>

								<div class="form-group">
									<label>
										Background Login (L1920 x A1080 / FullHD):
										<?php
											if(file_exists('css_js/images/background.png')){
												echo '<a href="?removerBackground">Remover Background</a></a>';
											}
										?>
									</label>
									<input class="form-control" type="file" name="background">
								</div>

								<div class="form-group">
									<label>Modo Manutenção:</label>
									<select class="form-control" name="manutencao">
										<option value="S" <?php Selected($config['manutencao'],'S'); ?>>Ativar</option>
										<option value="N" <?php Selected($config['manutencao'],'N'); ?>>Desativar</option>
									</select>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<label>reCAPTCHA - Chave do Site:</label>
								<input type="text" name="site_key" value="<?php echo $config['site_key']; ?>" class="form-control" />
							</div>
							<div class="col-md-6">
								<label>reCAPTCHA - Chave Secreta:</label>
								<input type="text" name="secret_key" value="<?php echo $config['secret_key']; ?>" class="form-control" />
							</div>
							<div class="col-md-12">
							<center>
								<em>Preencha os dois campos acima com os dados necessários para habilitar o reCAPTCHA na tela de login.</em>
							</center>
							</div>
						</div>
						<hr>

						<div class="row">
							<div class="col-md-12">
								<label>Mensagem de Manutenção:</label>
								<textarea class="form-control" name="msg_manutencao"><?php echo $config['msg_manutencao']; ?></textarea>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Servidor SMTP:</label>
									<input type="text" name="smtp_servidor" value="<?php echo $config['smtp_servidor']; ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>Senha SMTP:</label>
									<input type="text" name="smtp_senha" value="<?php echo $config['smtp_senha']; ?>" class="form-control" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Usuário SMTP:</label>
									<input type="text" name="smtp_usuario" value="<?php echo $config['smtp_usuario']; ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>Porta SMTP:</label>
									<input type="text" name="smtp_porta" value="<?php echo $config['smtp_porta']; ?>" class="form-control" />
								</div>
							</div>
						</div>
					</div>

					<div class="card-footer white">
						<button class="btn btn-primary float-right">Atualizar</button>
					</div>
				</div>
			</form>
		<?php } } ?>
	</div>
</div>
<?php require_once('includes/footer.php'); ?>