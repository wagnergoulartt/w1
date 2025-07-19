<?php
	$Versao = '3.4.5';
	require_once ('controller/setup.php');
	$i = 0;

	function GeraDatabaseConfig($dbhost, $dbuser, $dbpass, $dbname, $dbprefix=null){
		$Conf  = "<?php\n";
		$Conf .= "\t//Configurações do Banco\n";
		$Conf .= "\tdefine('DB_HOSTNAME', '".$dbhost."');\n";
		$Conf .= "\tdefine('DB_USERNAME', '".$dbuser."');\n";
		$Conf .= "\tdefine('DB_PASSWORD', '".$dbpass."');\n";
		$Conf .= "\tdefine('DB_DATABASE', '".$dbname."');\n";
		$Conf .= "\tdefine('DB_PREFIX'	, '".$dbprefix."');\n";
		$Conf .= "\tdefine('DB_CHARSET'	, 'utf8');\n";
		$Conf .= "?>\n";

		$ConfFile = 'database/config.php';
		if (is_writable('database/')) {
			$handle = fopen($ConfFile, 'w');
			fwrite($handle, $Conf);
			fclose($handle);
			$success = true;
		} else {
			$success = false;
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Instalação Wacontrol</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="assets/css/app.css">
	<style type="text/css">
	.license { background-color: #FFF; height: 400px; width: 100%; margin: 10px; }
	.form-control{ margin-bottom: 5px; }
	#primary{background: #30363d}
	.paper-card{background: #272c33}
	.card{background: none;}
	.sw-theme-circles>ul.step-anchor:before{background-color: #30363d}
	.sw-theme-circles>ul.step-anchor>li>a{border: 3px solid #30363d}
	.sw-theme-circles>ul.step-anchor>li>a{background: #f5f5f5; min-width: 50px; height: 50px; text-align: center; -webkit-box-shadow: inset 0 0 0 3px #fff!important; box-shadow: inset 0 0 0 3px #fff!important; text-decoration: none; outline-style: none; z-index: 99; color: #999; background: #fff; line-height: 2; font-weight: bold;}
	.sw-theme-circles>ul.step-anchor>li{margin-left: 15%;}
	.card-header{border-bottom: 0}
	.table-striped tbody tr:nth-of-type(odd){background-color: #30363d;}
	.table-bordered{border: 1px solid #30363d;}
	.table-bordered td, .table-bordered th { border: 1px solid #30363d; }
</style>
</head>
<body class="light loaded">
	<div id="app">
		<main>
			<div id="primary" class="p-t-b-100 height-full">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 mx-md-auto paper-card">
							<div class="text-center">
								<img class="img-responsive" src="css_js/images/logo/logo.png">
								<p>Instalação do Wacontrol 3.x</p>
							</div>
							<?php if (!isset($_GET['step']) || $_GET['step'] == '1') { ?>
								<div class="card no-b">
									<div class="card-header  pb-0">
										<div class="stepper sw-main sw-theme-circles" id="smartwizard"
										data-options='{
		
										"theme":"sw-theme-circles",
										"transitionEffect":"fade"
										}'>
											<ul class="nav step-anchor">
												<li><a href="#step-1y">1</a></li>
												<li><a href="#step-2y">2</a></li>
												<li><a href="#step-3y">3</a></li>
												<li><a href="#step-4y">4</a></li>
											</ul>
										</div>
									</div>

									<div class="card-body">
										<h6><b>Configurações do Servidor</b></h6><br>
										<table class="table table-condensed table-bordered table-striped">
											<tr>
												<th>Função / Extensão</th>
												<th>Config. Necessária</th>
												<th>Config. Atual</th>
												<th width="50px">Status</th>
											</tr>

											<tr>
												<td>Versão do PHP</td>
												<td>5.3 ao 7.2</td>
												<td><?php echo phpversion(); ?></td>
												<td><?php if(phpversion() >= '5.3' && phpversion() <= '7.2.9') { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>Memória do PHP</td>
												<td>128MB</td>
												<td><?php echo $mem = ini_get('memory_limit');?></td>
												<td><?php if($mem >= 128) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>cURL</td>
												<td>On</td>
												<td><?php if(function_exists('curl_init')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(function_exists('curl_init')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>Allow URL fopen</td>
												<td>On</td>
												<td><?php if(ini_get('allow_url_fopen')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(ini_get('allow_url_fopen')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>File Get Contents</td>
												<td>On</td>
												<td><?php if(function_exists('file_get_contents')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(function_exists('file_get_contents')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>Sessão Auto Start</td>
												<td>Off</td>
												<td><?php if(ini_get('session_auto_start')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(!ini_get('session_auto_start')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>Safe Mode</td>
												<td>Off</td>
												<td><?php if(ini_get('safe_mode')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(!ini_get('safe_mode')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>Short Open Tags</td>
												<td>On</td>
												<td><?php if(ini_get('short_open_tag')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(ini_get('short_open_tag')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>Magic Quotes GPC</td>
												<td>Off</td>
												<td><?php if(ini_get('magic_quotes_gpc')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(!ini_get('magic_quotes_gpc')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>Register Globals</td>
												<td>Off</td>
												<td><?php if(ini_get('register_globals')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(!ini_get('register_globals')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>PHPMail</td>
												<td>On</td>
												<td><?php if(function_exists('mail')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(function_exists('mail')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { $i = $i + 1; echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>
									
											<tr>
												<td>MySQLi</td>
												<td>On</td>
												<td><?php if(extension_loaded('mysqli')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(extension_loaded('mysqli')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>ZIP</td>
												<td>On</td>
												<td><?php if(extension_loaded('zip')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(extension_loaded('zip')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>

											<tr>
												<td>MBString</td>
												<td>On</td>
												<td><?php if(extension_loaded('mbstring')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(extension_loaded('mbstring')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>
												
											<tr>
												<td>XML</td>
												<td>On</td>
												<td><?php if(extension_loaded('libxml')) { echo 'On'; } else { echo 'Off'; } ?></td>
												<td><?php if(extension_loaded('libxml')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>
										</table>

										<hr>

										<h6><b>Diretórios e Permissões de Arquivos</b></h6><br>
										<table class="table table-condensed table-bordered table-striped">
											<tr>
												<th>Diretório</th>
												<th style="width: 40px">Status</th>
											</tr>

											<tr>
												<td>database</td>
												<td><?php if(is_writable('database')) { $i = $i + 1; echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-close"></i></button>'; } ?></td>
											</tr>
										</table>

										<hr>

										<h6><b>Pontuação / Compatibilidade</b></h6><br>

										<div class="progress">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php echo ProgressBar(substr(VerificaPontuacao($i,'16'),0,4)); ?>" role="progressbar" aria-valuemax="100" style="width: <?php echo VerificaPontuacao($i,'16'); ?>%;">
												<strong><?php echo substr(VerificaPontuacao($i,'16'),0,4); ?> / 100</strong>
											</div>
										</div>
									
										<center>
											<br>
											<button class="btn btn-primary" onclick="document.location.href='setup.php?step=1';">Verificar</button>
											<button class="btn btn-primary" onclick="document.location.href='setup.php?step=2';">Próximo</button>
										</center>
									</div>
								</div>
							<?php } elseif (isset($_GET['step']) && $_GET['step'] == '2') { ?>
								<div class="card no-b">
									<div class="card-header  pb-0">
										<div class="stepper sw-main sw-theme-circles" id="smartwizard"
										data-options='{
		
										"theme":"sw-theme-circles",
										"transitionEffect":"fade"
										}'>
											<ul class="nav step-anchor">
												<li><a href="#step-1y">1</a></li>
												<li class="active"><a href="#step-2y">2</a></li>
												<li><a href="#step-3y">3</a></li>
												<li><a href="#step-4y">4</a></li>
											</ul>
										</div>
									</div>

									<div class="card-body ">
										<iframe src="termos.php" class="license" frameborder="0" scrolling="auto"></iframe>
										<form action="setup.php">
											<input type="hidden" name="step" value="3">
											<label><input type="checkbox" required=""> Sim, eu aceito</label>
											<center>
												<br>
												<a href="javascript:history.back()"><button class="btn btn-primary">Voltar</button></a>
												<button class="btn btn-primary" type="submit">Próximo</button>
											</center>
										</form>
									</div>
								</div>
							<?php } elseif (isset($_GET['step']) && $_GET['step'] == '3') { ?>
								<div class="card no-b">
									<div class="card-header  pb-0">
										<div class="stepper sw-main sw-theme-circles" id="smartwizard"
										data-options='{
		
										"theme":"sw-theme-circles",
										"transitionEffect":"fade"
										}'>
											<ul class="nav step-anchor">
												<li><a href="#step-1y">1</a></li>
												<li class="active"><a href="#step-2y">2</a></li>
												<li class="active"><a href="#step-3y">3</a></li>
												<li><a href="#step-4y">4</a></li>
											</ul>
										</div>
									</div>

									<div class="card-body">
										<form method="post" action="?InstallDB">
											<h6><b>1. MySQL - Configuração do Banco de Dados</b></h6><hr>

											<div class="form-group row">
												<label class="col-sm-3 control-label">MySQL Host:</label>
												<div class="col-sm-9">
													<input class="form-control" name="dbhost" value="localhost" required>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-3 control-label">Usuário MySQL:</label>
												<div class="col-sm-9">
													<input class="form-control" name="dbuser" required>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-3 control-label">Senha MySQL:</label>
												<div class="col-sm-9">
													<input class="form-control" name="dbpass">
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-3 control-label">Nome do Banco MySQL:</label>
												<div class="col-sm-9">
													<input class="form-control" name="dbname" required>
												</div>
											</div>
												
											<h6><b>2. Configuração Comum</b></h6><hr>

											<div class="form-group row">
												<label class="col-sm-3 control-label">Nome do Site:</label>
												<div class="col-sm-9">
													<input class="form-control" name="nomesite" required>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-3 control-label">URL do Site:</label>
												<div class="col-sm-9">
													<input class="form-control" name="urlsite" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/'; ?>" required>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-3 control-label">URL de Instalação:</label>
												<div class="col-sm-9">
													<input class="form-control" name="siteurl" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).'/'; ?>" required>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-3 control-label">E-mail:</label>
												<div class="col-sm-9">
													<input class="form-control" name="email" required>
													<em>Mesmo e-mail cadastrado em nossa loja de módulos.</em>
												</div>
											</div>

											<h6><b>3. Configuração do Administrador</b></h6><hr>

											<div class="form-group row">
												<label class="col-sm-3 control-label">Nome do Usuário:</label>
												<div class="col-sm-9">
													<input class="form-control" name="usuario" required>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-3 control-label">Login:</label>
												<div class="col-sm-9">
													<input class="form-control" name="login" required>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-3 control-label">Senha:</label>
												<div class="col-sm-9">
													<input class="form-control" type="password" name="senha" required>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-3 control-label">Senha[confimação]:</label>
												<div class="col-sm-9">
													<input class="form-control" type="password" name="senhaconfirm" required>
												</div>
											</div>

											<center>
												<a class="btn btn-primary" href="javascript:history.back()">Voltar</a>
												<button class="btn btn-primary">Próximo</button>
											</center>
										</form>
									</div>
								</div>
							<?php } elseif (isset($_GET['step']) && $_GET['step'] == '4') { ?>
								<div class="card no-b">
									<div class="card-header  pb-0">
										<div class="stepper sw-main sw-theme-circles" id="smartwizard"
										data-options='{
		
										"theme":"sw-theme-circles",
										"transitionEffect":"fade"
										}'>
											<ul class="nav step-anchor">
												<li><a href="#step-1y">1</a></li>
												<li class="active"><a href="#step-2y">2</a></li>
												<li class="active"><a href="#step-3y">3</a></li>
												<li class="active"><a href="#step-4y">4</a></li>
											</ul>
										</div>
									</div>

									<div class="card-body">
										<div>
											<h4><b>Instalação realizada com sucesso!</b></h4>
											<p>Foi enviado um e-mail com licença de acesso ao painel de controle, verifique a caixa de e-mail(Entrada e SPAM) informada anteriormente.</p>
											<p>Agora você poderá utilizar o WACONTROL, em caso de dúvidas entre em contato com o suporte: <b>contato@wacontrol.com.br</b></p>
										</div>

										<center>
											<button class="btn btn-primary" onclick="document.location.href='login.php?finish';">Realizar Login</button>
										</center>
									</div>
								</div>
							<?php } ?>

							<div class="box-footer">
								<center>
									Todos os Direitos Reservados a Wacontrol
								</center>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	<script src="assets/js/app.js"></script>
</body>
</html>