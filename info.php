<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php $TitlePage = 'Informações do Sistema'; $i = 0; ?>
<?php
	if (!checkPermission($PERMISSION, $urlModule, 'item','acessar')) { Redireciona('./index.php'); }
?>
<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-info2"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
			<div class="row">
				<ul class="nav responsive-tab nav-material nav-material-white">
					<li><a class="nav-link" href="./info.php">Informações Básicas</a></li>
					<li><a class="nav-link" href="?phpinfo">PHP Info</a></li>
				</ul>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<div class="row">
			<div class="col-md-12">
				<?php if (isset($_GET['phpinfo'])) { ?>
					<iframe width="100%" height="850" scrolling="auto" seamless="seamless" frameborder="0" src="phpinfo.php"></iframe>
				<?php } else { ?>
					<div class="alert alert-success">
						Atenção, todos os itens abaixo podem ser alterados diretamente no seu servidor de hospedagem e não é nenhuma responsabilidade do Suporte M7Admin realizar essas alterações, por tanto, entre em contato com seu suporte de hospedagem para realizar as modificações.
						<br><br>
						Para alterar o <b>Limite de Upload</b> e <b>Limite de Envio</b>, solicite ao suporte da hospedagem para que seja alterado esse limite das seguintes diretivas do PHP: '<b>upload_max_filesize</b>' e '<b>post_max_size</b>'.
					</div>

					<div class="card">
						<div class="card-header  white">
							<strong>Informações</strong>
						</div>

						<div class="card-body p-0">
							<div class="table-responsive">
								<table class="table table-striped">
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
										<td><?php if(phpversion() >= '5.3' && phpversion() <= '7.2.9') { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>Memória do PHP</td>
										<td>128MB</td>
										<td><?php echo $mem = ini_get('memory_limit');?></td>
										<td><?php if($mem >= 128) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>Limite de Upload</td>
										<td><?php echo '<span class="label label-info">'.ini_get('upload_max_filesize').'</span>'; ?></td>
										<td>Limite de Envio</td>
										<td><?php echo '<span class="label label-info">'.ini_get('post_max_size').'</span>'; ?></td>
									</tr>

									<tr>
										<td>cURL</td>
										<td>On</td>
										<td><?php if(function_exists('curl_init')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(function_exists('curl_init')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>Allow URL fopen</td>
										<td>On</td>
										<td><?php if(ini_get('allow_url_fopen')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(ini_get('allow_url_fopen')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>File Get Contents</td>
										<td>On</td>
										<td><?php if(function_exists('file_get_contents')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(function_exists('file_get_contents')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>PHPMail</td>
										<td>On</td>
										<td><?php if(function_exists('mail')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(function_exists('mail')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>ZIP</td>
										<td>On</td>
										<td><?php if(extension_loaded('zip')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(extension_loaded('zip')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>MBString</td>
										<td>On</td>
										<td><?php if(extension_loaded('mbstring')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(extension_loaded('mbstring')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>Sessão Auto Start</td>
										<td>Off</td>
										<td><?php if(ini_get('session_auto_start')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(!ini_get('session_auto_start')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>Safe Mode</td>
										<td>Off</td>
										<td><?php if(ini_get('safe_mode')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(!ini_get('safe_mode')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>Short Open Tags</td>
										<td>On</td>
										<td><?php if(ini_get('short_open_tag')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(ini_get('short_open_tag')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>Magic Quotes GPC</td>
										<td>Off</td>
										<td><?php if(ini_get('magic_quotes_gpc')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(!ini_get('magic_quotes_gpc')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>Register Globals</td>
										<td>Off</td>
										<td><?php if(ini_get('register_globals')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(!ini_get('register_globals')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>MySQLi</td>
										<td>On</td>
										<td><?php if(extension_loaded('mysqli')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(extension_loaded('mysqli')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>

									<tr>
										<td>XML</td>
										<td>On</td>
										<td><?php if(extension_loaded('libxml')) { echo 'On'; } else { echo 'Off'; } ?></td>
										<td><?php if(extension_loaded('libxml')) { echo '<button type="button" class="btn btn-success"><i class="icon-check"></i></button>'; } else { echo '<button type="button" class="btn btn-danger"><i class="icon-times"></i></button>'; } ?></td>
									</tr>
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