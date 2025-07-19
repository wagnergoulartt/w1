<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php require_once('controller/error_log.php'); ?>
<?php $TitlePage = 'Log de Erros'; ?>
<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-error"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<div class="card no-b">
			<div class="card-header white pb-0">
				<div class="d-flex justify-content-between">
					<div class="align-self-center">
						<ul class="nav nav-pills mb-3" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" id="w4--tab1" data-toggle="tab" href="#w4-tab1" role="tab" aria-controls="tab1" aria-expanded="true" aria-selected="false"><?php echo $txt['log_erro_painel']; ?></a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="w4--tab2" data-toggle="tab" href="#w4-tab2" role="tab" aria-controls="tab2" aria-selected="true"><?php echo $txt['log_erro_modulos']; ?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="card-body no-p">
				<div class="tab-content">
					<div class="tab-pane fade active show" id="w4-tab1" role="tabpanel" aria-labelledby="w4-tab1">
						<?php
							$filename = 'error_log';
							if (file_exists($filename)) {
						?>
								<form id="Form" action="error_log.php?limpar_log_painel=true" method="post" class="form-group">
									<textarea wrap="off" rows="15" readonly class="form-control"><?php include 'error_log'; ?></textarea>
									<br>
									<p style="text-align: right">
									<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'acessar')) { ?>
										<button class="btn btn-danger" style="margin-left: 30px;"><?php echo $txt['limpa_log']; ?></button>
										<?php } ?>
									</p>
								</form>
							<?php } else { echo "<textarea wrap='off' rows='15' readonly class='form-control'>".$txt['nenhum_erro']."</textarea>"; } ?>
					</div>

					<div class="tab-pane fade" id="w4-tab2" role="tabpanel" aria-labelledby="w4-tab2">
						<?php
							$filename = 'wa/error_log';
							if (file_exists($filename)) {
						?>
								<form id="Form" action="error_log.php?limpar_log_modulos=true" method="post" class="form-group">
									<textarea wrap="off" rows="15" readonly class="form-control"><?php include 'wa/error_log'; ?></textarea>
									<br>
									<p style="text-align: right">
									<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'acessar')) { ?>
										<button class="btn btn-danger" style="margin-left: 30px;"><?php echo $txt['limpa_log']; ?></button>
									<?php } ?>
									</p>
								</form>
						<?php } else { echo "<textarea wrap='off' rows='15' readonly class='form-control'>".$txt['nenhum_erro']."</textarea>"; } ?>
					</div>
				</div>
			</div>
		</div>
  	</div>
</div>
<?php require_once('includes/footer.php'); ?>