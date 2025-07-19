<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php $TitlePage = 'Estatistícas'; ?>

<?php
	if (!checkPermission($PERMISSION, $urlModule, 'item')) {
		Redireciona('./index.php');
	}
?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-bar-chart2"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<?php
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

		if ($Estatisticas == 'true') {
			require_once('analytics/dashboard.php');
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header white">
						<h6 style='font-weight: bold'>Estatísticas em Tempo Real</h6>
					</div>

					<div class="card-body p-o">
						<iframe src="analytics/realtime/admin.php?color=<?php echo ConfigPainel('cor_blocos'); ?>" style="position:relative; left:0; top:0; width:100%; height:600px; overflow:hidden; border:none; outline:none; box-sizing:border-box;" width="100%" height="600px" scrolling="no"></iframe>
					</div>
				</div>
			</div>
		</div>

		<div class="row row-eq-height my-3">
			<div class="col-md-3">
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
			
			<div class="col-md-3">
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
			</div>

			<div class="col-md-3">
				<div class="card">
                    <div class="card-header white">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center">
                                <strong>PÁGINAS MAIS ACESSADAS</strong>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                    	<ul class="social mb-0">
                    		<?php
                    			$i = 1;
                    			foreach($paginas as $pag) {
                    				if($pag[1] > 0 && $i <= 8){
                    		?>
                    		<li><small><?php echo $pag[0]; ?></small><span class="float-right mt-2 font-weight-bold"><span class="badge badge-primary r-5"><?php echo $pag[1]; ?></span></span></li>
                    		<?php $i++; } } ?>
                    	</ul>
                    </div>
                </div>
		</div>
		<?php } ?>
	</div>
</div>

<?php require_once('includes/footer.php'); ?>