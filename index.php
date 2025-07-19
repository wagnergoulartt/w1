<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>

<?php
if (isset($_GET['AtualizaLicenca'])) {
	$Atualizar = array(
		'licenca' 	=> post('licenca')
	);
	$Query = DBUpdate('config', $Atualizar);
	Redireciona('index.php');
}
//Atualização no Index
?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon-box"></i> <?php echo ConfigPainel('site_nome'); ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<?php if (ConfigPainel('site_url') == null && DadosSession('nivel') == 1) { ?>
			<div class="alert alert-danger">
				<strong>Atenção:</strong> Vá até "Menu do WebMaster > Configurações" e no campo "URL do Site:" cadastre a URL onde o site está publicado.
			</div>
		<?php } ?>

		<?php if (isset($_GET['Licenca'])){ ?>
			<div class="modal fade" id="modalLicenca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content b-0">
						<form method="post" action="?AtualizaLicenca" enctype="multipart/form-data">
							<div class="modal-header r-0 bg-primary">
								<h6 class="modal-title text-white" id="exampleModalLabel">Licença Wacontrol</h6>
							</div>
							<div class="modal-body">
								<div class="alert alert-info">Esta chave foi enviada para seu e-mail no momento da instalação.</div>

								<div class="form-group">
									<label>Chave:</label>
									<input class="form-control" name="licenca" value="<?php echo ConfigPainel('licenca'); ?>" required>
								</div>
							</div>

							<div class="modal-footer">
								<button type="submit" class="btn btn-primary l-s-1 s-12 text-uppercase">Atualizar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isset($_GET['Ativar'])){ ?>
			<div class="modal fade" id="modalLicenca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content b-0">
						<form >
							<div class="modal-header r-0 bg-primary">
								<h6 class="modal-title text-white" id="exampleModalLabel">Licença Wacontrol</h6>
							</div>
							<?php  if(isset($_GET['Status']) && $_GET['Status'] == 'pendente'){ ?>
							<div class="modal-body">
								<div class="alert alert-info">Localizamos no nosso sistema que a sua fatura está em aberto, caso já tenha efetuado o pagamento pedimos que aguarde até que todos os dados do pagamento sejam processados.</div>
							</div>
							<div class="modal-footer"></div>
							<?php }else {?>
							<div class="modal-body">
								<div class="alert alert-info">Sua Licença não está ativa, é necessário realizar o pagamento para ativá-la</div>
							</div>
							<div class="modal-footer">
								<a href="https://api.wacontrol.com.br/api/MercadoPago/?base=<?php echo RemoveHttpS(ConfigPainel('base_url')) ?>&origin=<?php echo $_SERVER['SERVER_NAME']?>&token=<?php echo ConfigPainel('licenca')?>"><button type="button" class="btn btn-primary l-s-1 s-12 text-uppercase">Efetuar o pagamento</button></a>
							</div>
							<?php } ?>
						</form>
					</div>
				</div>
			</div>
	    <?php }else if(isset($_GET['status']) && $_GET['status'] == 'approved'){ ?>
		    <div class="modal fade" id="modalLicenca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content b-0">
						<form >
							<div class="modal-header r-0 bg-primary">
								<h6 class="modal-title text-white" id="exampleModalLabel">Licença Wacontrol</h6>
							</div>
							<div class="modal-body">
								<div class="alert alert-info">Licença está ativa.</div>
							</div>
							<div class="modal-footer"></div>
						</form>
					</div>
				</div>
			</div>
	    <?php } if(ICONESDASH == 'true'){ ?>
		<div class="animated fadeInUpShort">
			<div class="lightSlider" data-item="6" data-item-xl="4" data-item-md="2" data-item-sm="1" data-pause="7000" data-pager="false" data-auto="true" data-loop="true">
				<?php $Query = DBRead('modulos','*','WHERE status = 1 AND id <> 0 AND level = 1 ORDER BY ordem ASC'); if (is_array($Query)) { foreach ($Query as $modulos) {
					if (!empty($modulos['tabela'])) { $QueryCount = DBCount($modulos['tabela'], 'id',"WHERE id <> 0"); } else { $QueryCount = '*'; } ?>

					<?php if (checkPermission($PERMISSION, $modulos['url'])) {?>
						<div>
							<div class="white text-center p-4">
								<h6 class="mb-3"><?php echo $modulos['nome']; ?></h6>
								<i class="<?php echo $modulos['icone']; ?> s-48 text-primary"></i>
								<div class="mt-3">
									<a class="btn btn-primary btn-sm" href="<?php echo $modulos['url']; ?>">Iniciar</a>
								</div>
							</div>
						</div>
				<?php } } } ?>
			</div>
		</div>
		<?php
		}
		
		if (checkPermission($PERMISSION, 'estatisticas', 'item', 'acessar')) {
			switch (DadosSession('nivel')) {
				case '1':
				$Estatisticas = ESTATISTICAS_WEBMASTER;
				break;

				case '2':
				$Estatisticas = ESTATISTICAS_ADMIN;
				break;

				case '3':
				$Estatisticas = ESTATISTICAS_EDITOR;
				break;

				default:
				$Estatisticas = 'false';
				break;
			}
		}
		?>

		<?php 
		if (checkPermission($PERMISSION, 'estatisticas', 'item', 'acessar')) {
			if ($Estatisticas == 'true') {
				require_once('analytics/dashboard.php'); 
		?>
		<div class="row row-eq-height my-3">
			<div class="col-md-4">
				<div class="card">
					<div class="card-header white">
						<strong>NAVEGADORES</strong>
					</div>
					<div class="card-body">
						<ul class="social">
							<li>
								<a href="#" class="mr-3">
									<img src="analytics/img/chrome.png" width="32px">
								</a> Google Chrome
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_browsers[0], $total_pageviews); ?>%</span></span>
							</li>

							<li>
								<a href="#" class=" mr-3">
									<img src="analytics/img/firefox.png" width="32px">
								</a> Mozilla Firefox
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_browsers[1], $total_pageviews); ?>%</span></span>
							</li>

							<li>
								<a href="#" class=" mr-3">
									<img src="analytics/img/internet-explorer.png" width="32px">
								</a> Internet Explorer
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_browsers[2], $total_pageviews); ?>%</span></span>
							</li>

							<li>
								<a href="#" class="mr-3">
									<img src="analytics/img/safari.png" width="32px">
								</a> Safari
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_browsers[3], $total_pageviews); ?>%</span></span>
							</li>

							<li>
								<a href="#" class=" mr-3">
									<img src="analytics/img/outros.png" width="32px">
								</a> Outros
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_browsers[4], $total_pageviews); ?>%</span></span>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card">
					<div class="card-header white">
						<strong>SISTEMAS OPERACIONAIS</strong>
					</div>
					<div class="card-body">
						<ul class="social">
							<li>
								<a href="#" class="mr-3">
									<img src="analytics/img/windows.png" width="32px">
								</a> Windows
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_oss[0], $total_pageviews); ?>%</span></span>
							</li>

							<li>
								<a href="#" class=" mr-3">
									<img src="analytics/img/macos.png" width="32px">
								</a> Mac OS
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_oss[1], $total_pageviews); ?>%</span></span>
							</li>

							<li>
								<a href="#" class=" mr-3">
									<img src="analytics/img/linux.png" width="32px">
								</a> Linux
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_oss[2], $total_pageviews); ?>%</span></span>
							</li>

							<li>
								<a href="#" class="mr-3">
									<img src="analytics/img/apple.png" width="32px">
								</a> iOS
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_oss[3], $total_pageviews); ?>%</span></span>
							</li>

							<li>
								<a href="#" class=" mr-3">
									<img src="analytics/img/android.png" width="32px">
								</a> Android
								<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo PegaValores($total_oss[4], $total_pageviews); ?>%</span></span>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="col-md-5">
				<div class="card">
                    <div class="card-header white" style="padding: 5px 5px 5px 20px;">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center">
                                <strong>ESTATISTÍCAS</strong>
                            </div>
                            <div class="align-self-center">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="w4--tab1" data-toggle="tab" href="#w4-tab1" role="tab" aria-controls="tab1" aria-expanded="true" aria-selected="false">Tudo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="w4--tab2" data-toggle="tab" href="#w4-tab2" role="tab" aria-controls="tab2" aria-selected="true">7 Dias</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="w4--tab3" data-toggle="tab" href="#w4-tab3" role="tab" aria-controls="tab3" aria-selected="false">30 Dias</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade" id="w4-tab1" role="tabpanel" aria-labelledby="w4-tab1">
                            	<ul class="social mb-0">
                            		<li>
                            			<a href="#" class="bg-primary mr-3">
                            				<i class="icon-users"></i>
                            			</a> Visitantes
                            			<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo $total_visitors; ?></span></span>
                            		</li>

                            		<li>
                            			<a href="#" class="bg-primary mr-3">
                            				<i class="icon-eye"></i>
                            			</a> Pageviews
                            			<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo $total_pageviews; ?></span></span>
                            		</li>
                            	</ul>
                            </div>

                            <div class="tab-pane fade active show" id="w4-tab2" role="tabpanel" aria-labelledby="w4-tab2">
                            	<ul class="social mb-0">
                            		<li>
                            			<a href="#" class="bg-primary mr-3">
                            				<i class="icon-users"></i>
                            			</a> Visitantes em 7 Dias
                            			<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo $seven_days_visitors; ?></span></span>
                            		</li>

                            		<li>
                            			<a href="#" class="bg-primary mr-3">
                            				<i class="icon-eye"></i>
                            			</a> Pageviews em 7 Dias
                            			<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo $seven_days_pageviews; ?></span></span>
                            		</li>
                            	</ul>
                            </div>

                            <div class="tab-pane fade" id="w4-tab3" role="tabpanel" aria-labelledby="w4-tab3">
                            	<ul class="social mb-0">
                            		<li>
                            			<a href="#" class="bg-primary mr-3">
                            				<i class="icon-users"></i>
                            			</a> Visitantes em 30 Dias
                            			<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo $thirty_days_visitors; ?></span></span>
                            		</li>

                            		<li>
                            			<a href="#" class="bg-primary mr-3">
                            				<i class="icon-eye"></i>
                            			</a> Pageviews em 30 Dias
                            			<span class="float-right mt-2 font-weight-bold"><span class="badge badge-warning r-5"><?php echo $thirty_days_pageviews; ?></span></span>
                            		</li>
                            	</ul>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
				<!-- <div class="card">
					<div class="card-header white">
						<strong>FEED DE NOTICIAS</strong>
					</div>
					<div class="card-body p-0">
						<ul class="list-group list-group-flush">
							<?php
								$json = file_get_contents("https://api.wacontrol.com.br/novidades.php");   
								$json_output = json_decode($json, true);
								foreach($json_output as $item){
									echo '<li class="list-group-item"><a href="'.$item['conteudo'].'" target="_blank"><i class="icon icon-newspaper-o text-primary"></i> '.$item['titulo'].'</a></li>';
								}
							?>
						</ul>
					</div>
				</div> -->
			</div>
		</div>
		<?php } } ?>
	</div>

<?php
	require_once('includes/footer.php');
	require_once('controller/check-update.php');
?>
	<div id="notificacao" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content b-0">
				<div class="modal-header r-0 bg-primary">
					<h6 class="modal-title text-white">Você tem tarefa(s) para hoje</h6>
					<a href="#" data-dismiss="modal" aria-label="Close" class="paper-nav-toggle paper-nav-white active"><i></i></a>
				</div>

				<div class="modal-body">
					<ul class="list-group list-group-striped no-b">
					<?php
						$query = DBRead('tarefas','*', "WHERE data = '".date('Y-m-d')."' AND status = 1");
						if (is_array($query)) {
							foreach ($query as $tarefas) {
					?>
						<li class="list-group-item list-group-item-action <?php if($tarefas['status'] == 0){echo 'done';} ?>">
							<?php echo $tarefas['titulo']; ?>
							<span class="badge badge-primary r-3 ml-3" style="background: <?php echo $tarefas['cor']; ?> !important"><?php echo $tarefas['label']; ?></span>
							<br>
							<small><?php echo $tarefas['conteudo']; ?></small>
						</li>
					<?php
							}
						}
					?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php if (is_array($query)) { ?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#notificacao').modal('show');
    });
</script>
<?php } ?>
