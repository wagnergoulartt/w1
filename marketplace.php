<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php require_once('controller/marketplace-api.php'); ?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-shopping_basket"></i> Loja de Módulos</h4>
				</div>
			</div>
			<div class="row">
				<ul class="nav responsive-tab nav-material nav-material-white">
					<li><a class="nav-link filter-button" href="#" data-filter="all">Todos</a></li>
					<li><a class="nav-link filter-button" href="#" data-filter="ModDisponivel">Módulos Disponíveis</a></li>
					<li><a class="nav-link filter-button" href="#" data-filter="ModAtualizacao">Atualizações Disponíveis</a></li>
					<li><a class="nav-link filter-button" href="#" data-filter="ModInstalado">Módulos Instalados</a></li>
					<li><a class="nav-link filter-button" href="#" data-filter="ModBreve">Pré-Lançamento</a></li>
					<li><a class="nav-link filter-button" href="#" data-filter="ModOutros">Outros Módulos</a></li>
				</ul>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<div class="row">
			<?php if ($Mods) {
				foreach ($Mods as $Mod) { ?>
					<?php if (!empty($Mod['url']) && VerificaModInstalado($Mod['url']) == false) { ?>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 filter ModDisponivel" style="background-color:transparent; margin-bottom:25px;">
							<div class="card">
								<?php if (!empty($Mod['versao']) || $Mod['versao'] <> NULL) : ?>
									<div class="card-header white"><strong> <?php echo $Mod['nome']; ?> <span class="badge badge-success float-right">Disponível</span></strong></div>
								<?php else : ?>
									<div class="card-header white"><strong> <?php echo $Mod['nome']; ?> <span class="badge badge-warning float-right">Indisponível para a versão <?= ConfigPainel('versao'); ?></span></strong></div>
								<?php endif; ?>

								<div class="card-body p-0">
									<img class="img-fluid" src="https://api.wacontrol.com.br/imagens/<?php echo str_replace('.php', '.jpg', $Mod['url']) ?>" />

									<ul class="list-group list-group-flush no-b">
										<li class="list-group-item">
											<i class="icon icon-calendar text-blue"></i>Atualizado em: <?php echo date('d/m/Y', strtotime($Mod['data_atualizacao'])); ?>
										</li>
									</ul>
								</div>

								<div class="card-footer white text-center">
									<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'acessar')) { ?>
										<?php if (!empty($Mod['versao']) || $Mod['versao'] <> NULL) : ?>
											<a class="btn btn-sm btn-success tooltips" href="#!" onclick="DownloadMod('<?php echo $Mod['id']; ?>','<?php echo $Mod['url']; ?>');" data-tooltip="Baixar módulo"><i class="icon-download"></i></a>
										<?php endif; ?>
									<?php } ?>
									<a class="btn btn-sm btn-danger tooltips" target="_blank" href="//www.youtube.com/watch?v=<?php echo $Mod['videoaula']; ?>" data-tooltip="Assistir video aula"><i class="icon-youtube-play"></i></a>
									<a class="btn btn-sm btn-primary tooltips" href="#!" data-toggle="modal" data-target="#DetalhesMod<?php echo $Mod['id']; ?>" data-tooltip="Detalhes do módulo"><i class="icon-note-text"></i></a>
									<a class="btn btn-sm btn-primary tooltips" target="_blank" href="<?php echo $Mod['loja']; ?>" data-tooltip="Comprar módulo"><i class="icon-shopping_cart"></i></a>
								</div>
							</div>
						</div>
					<?php } ?>
			<?php }
			} ?>

			<?php if ($Mods) {
				foreach ($Mods as $Mod) {
					$Mod['data_atualizacao'] = (empty($Mod['data_atualizacao'])) ? date("Y-m-d") : $Mod['data_atualizacao'];
					$Mod['url'] = (empty($Mod['url'])) ? NULL : $Mod['url'];
					?>
					<?php $Query = DBRead('modulos', 'url, data_atualizacao', "WHERE url = '{$Mod['url']}' AND data_atualizacao < '{$Mod['data_atualizacao']}'");
					if (is_array($Query)) {
						foreach ($Query as $modulos) {
					?>
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 filter ModAtualizacao" style="background-color:transparent; margin-bottom:25px;">
								<div class="card">
									<?php if (!empty($Mod['versao']) || $Mod['versao'] <> NULL) : ?>
										<div class="card-header white"><strong> <?php echo $Mod['nome']; ?> <span class="badge badge-success float-right">Desatualizado</span></strong></div>
									<?php else : ?>
										<div class="card-header white"><strong> <?php echo $Mod['nome']; ?> <span class="badge badge-warning float-right">Indisponível para a versão <?= ConfigPainel('versao'); ?></span></strong></div>
									<?php endif; ?>
									<div class="card-body p-0">
										<img class="img-fluid" src="https://api.wacontrol.com.br/imagens/<?php echo str_replace('.php', '.jpg', $Mod['url']) ?>" />

										<ul class="list-group list-group-flush no-b">
											<li class="list-group-item">
												<i class="icon icon-calendar text-blue"></i>Atualizado em: <?php echo date('d/m/Y', strtotime($Mod['data_atualizacao'])); ?>
											</li>
										</ul>
									</div>

									<div class="card-footer white text-center">
										<?php if (checkPermission($PERMISSION, $urlModule, 'item', 'acessar')) { ?>
											<?php if (!empty($Mod['versao']) || $Mod['versao'] <> NULL) : ?>
												<a class="btn btn-sm btn-success tooltips" href="#!" onclick="DownloadMod('<?php echo $Mod['id']; ?>','<?php echo $Mod['url']; ?>');" data-tooltip="Atualizar módulo"><i class="icon-refresh"></i></a>
											<?php endif; ?>
										<?php } ?>
										<a class="btn btn-sm btn-danger tooltips" target="_blank" href="//www.youtube.com/watch?v=<?php echo $Mod['videoaula']; ?>" data-tooltip="Assistir video aula"><i class="icon-youtube-play"></i></a>
										<a class="btn btn-sm btn-primary tooltips" href="#!" data-toggle="modal" data-target="#DetalhesMod<?php echo $Mod['id']; ?>" data-tooltip="Detalhes do módulo"><i class="icon-note-text"></i></a>
										<a class="btn btn-sm btn-primary tooltips" target="_blank" href="<?php echo $Mod['loja']; ?>" data-tooltip="Comprar módulo"><i class="icon-shopping_cart"></i></a>
									</div>
								</div>
							</div>
					<?php }
					} ?>
			<?php }
			} ?>

			<?php if ($ModsOutros) {
				foreach ($ModsOutros as $Mod) { ?>
					<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 filter ModOutros" style="background-color:transparent; margin-bottom:25px;">
						<div class="card">
							<div class="card-header white"><strong> <?php echo $Mod['nome']; ?> <span class="badge badge-primary float-right">Disponível na Loja</span></strong></div>
							<div class="card-body p-0">
								<img class="img-fluid" src="https://api.wacontrol.com.br/imagens/<?php echo str_replace('.php', '.jpg', $Mod['url']) ?>" />

								<ul class="list-group list-group-flush no-b">
									<li class="list-group-item">
										<i class="icon icon-calendar text-blue"></i>Atualizado em: <?php echo date('d/m/Y', strtotime($Mod['data_atualizacao'])); ?>
									</li>
								</ul>
							</div>

							<div class="card-footer white text-center">
								<a class="btn btn-sm btn-primary tooltips" target="_blank" href="<?php echo $Mod['loja']; ?>" data-tooltip="Comprar módulo"><i class="icon-shopping_cart"></i></a>
							</div>
						</div>
					</div>
			<?php }
			} ?>

			<?php if ($ModsBreve) {
				foreach ($ModsBreve as $Mod) { ?>
					<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 filter ModBreve" style="background-color:transparent; margin-bottom:25px;">
						<div class="card">
							<div class="card-header white"><strong> <?php echo $Mod['nome']; ?> <span class="badge badge-warning float-right">Em Breve</span></strong></div>
							<div class="card-body p-0">
								<img class="img-fluid" src="https://api.wacontrol.com.br/imagens/<?php echo str_replace('.php', '.jpg', $Mod['url']) ?>" />
							</div>

							<div class="card-footer white text-center">
								<a class="btn btn-sm btn-primary tooltips" target="_blank" href="<?php echo $Mod['loja'] ?? ''; ?>" data-tooltip="Comprar módulo"><i class="icon-shopping_cart"></i></a>
							</div>
						</div>
					</div>
			<?php }
			} ?>
		</div>
	</div>
</div>
<?php require_once('includes/footer.php'); ?>

<?php if (!$Mods) {
	Sweet('Atenção!!!', 'Não foi Possível localizar o cliente/módulos em nossa loja, por favor entre em contato conosco', 'info');
} ?>

<?php if ($Mods) {
	foreach ($Mods as $Mod) {  ?>
		<div class="modal fade" id="DetalhesMod<?php echo $Mod['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content b-0">
					<div class="modal-header r-0 bg-yellow">
						<h6 class="modal-title text-white" id="exampleModalLabel"><i class="icon <?php echo $Mod['icone']; ?>"></i> <?php echo $Mod['nome']; ?></h6>
						<a href="#" data-dismiss="modal" aria-label="Close" class="paper-nav-toggle paper-nav-white active"><i></i></a>
					</div>

					<div class="modal-body InstallModStatus<?php echo $Mod['id']; ?>">
						<?php if (!empty($Mod['atualizacoes'])) { ?>
							<strong>Atualizações:</strong>
							<p><?php echo nl2br($Mod['atualizacoes']); ?></p>
						<?php } ?>
					</div>

					<div class="modal-footer">

					</div>
				</div>
			</div>
		</div>
<?php }
} ?>
<script>
	function DownloadMod(Id, ModDownload) {
		$("#DetalhesMod" + Id).modal()
		$.ajax({
			type: "GET",
			dataType: "json",
			cache: false,
			url: 'controller/marketplace.php?Download=' + ModDownload + '&id=' + Id,
			beforeSend: function(data) {
				$('.InstallModStatus' + Id).html('Iniciando Instalação...<br>\n');
			},
			success: function(data) {
				if (data.status == 'success') {
					$("#DetalhesMod" + Id).hide();
					swal({
						title: `${data.msg}`,
						icon: `${data.status}`,
					});
					location.reload();
				} else {
					$("#DetalhesMod" + Id).hide();
					swal({
					    icon: `${data.status}`,
                        title: `${data.msg}`,
                        button: `${data.button}` ?? 'Ok'
                    }).then((value) => {
                        window.location.href = `${data.link}` ?? 'marketplace.php';
                    });
				}
			}
		});
	}
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".filter-button").click(function() {
			var value = $(this).attr('data-filter');
			if (value == "all") {
				$('.filter').show('1000');
			} else {
				$(".filter").not('.' + value).hide('3000');
				$('.filter').filter('.' + value).show('3000');
			}
		});

		if ($(".filter-button").removeClass("active")) {
			$(this).removeClass("active");
		}

		$(this).addClass("active");
	});
</script>