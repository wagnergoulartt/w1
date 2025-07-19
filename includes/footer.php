	</div>

	<script src="assets/js/app.js"></script>
	<script type="text/javascript" src="css_js/plugins/clipboard.min.js"></script>
	<script type="text/javascript" src="css_js/wacontrol.js"></script>
	<script src="css_js/plugins/tinymce/js/tinymce/tinymce.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>
	<script src="assets/plugins/forms/js/fonts.js"></script>
	<script type="text/javascript">
		$("select").each(function(){ 
			$(this).find('option[value="'+$(this).data("selected")+'"]').prop('selected', true); 
		});
	
		$(document).ready(function() {
			$(".select_fontfamily").higooglefonts();
		});
	</script>
	<script type="text/javascript">
		var $info = $('.tooltips');
		$info.each( function () {
			var dataInfo = $(this).data("tooltip");
			$( this ).append('<span class="inner" >' + dataInfo + '</span>');
		});
	</script>
	<script>
		tinymce.init({
			selector: '.tinymce',
			height: 500,
			language: 'pt_BR',
			toolbar: 'style-p style-h1 style-h2 style-h3',
			plugins: 'emoticons spellchecker fullpage print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount  imagetools contextmenu colorpicker textpattern help',
			toolbar1: 'fontselect fontsizeselect | bold italic strikethrough forecolor backcolor | link numlist bullist outdent indent removeformat | image emoticons fullpage spellchecker media | alignleft aligncenter alignright alignjustify ',
			image_advtab: true,
			imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
			fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
			content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tinymce.com/css/codepen.min.css'
			],
			relative_urls : false,
			fullpage_hide_in_source_view: true,
			remove_script_host : false,
			convert_urls : true,
			images_upload_url: 'uploads.php',
			images_upload_handler: function (blobInfo, success, failure) {
				var xhr, formData;
				xhr = new XMLHttpRequest();
				xhr.withCredentials = false;
				xhr.open('POST', 'uploads.php');
				xhr.onload = function() {
					var json;
					if (xhr.status != 200) {
						failure('HTTP Error: ' + xhr.status);
						return;
					}

					json = JSON.parse(xhr.responseText);
					if (!json || typeof json.location != 'string') {
						failure('Invalid JSON: ' + xhr.responseText);
						return;
					}

					success(json.location);
				};

				formData = new FormData();
				formData.append('file', blobInfo.blob(), blobInfo.filename());
				xhr.send(formData);
			},
		});
	</script>

	<?php
		if (isset($_GET['sucesso']) || isset($_GET['Sucesso'])) {
			Sweet('Sucesso!!!', 'O Procedimento foi realizado com sucesso!', 'success', 'Fechar');
		} elseif (isset($_GET['erro']) || isset($_GET['Erro'])) {
			Sweet('Oops!!!', 'Ocorreu um erro ao tentar executar este procedimento!', 'error', 'Fechar');
		}

		if (isset($_GET['DeleteSetup'])) {
			@unlink('wacontrol.php');
			@unlink('setup.php');
			@unlink('termos.php');
			@unlink('database/BD.sql');
			@unlink('controller/setup.php');
			Redireciona('index.php?Sucesso');
		}

		if (file_exists('setup.php') || file_exists('termos.php') || file_exists('database/BD.sql') || file_exists('controller/setup.php')) {
			Sweet('Atenção!!!', 'Ainda existe arquivos da instalação, clique no botão abaixo para exclui-los!', 'info', 'Deletar arquivos da instalação', 'index.php?DeleteSetup');
		}
	?>

	<script type="text/javascript">
		$(window).on('load',function(){
			$('#modalLicenca').modal('show');
		});

		function DeletarItem(id, get){
			swal({   
				title: "Você tem certeza?",   
				text: "Deseja realmente deletar este item?",   
				type: "warning",
				buttons: {
					cancel: "Não",
					confirm: {text: "Sim", className: "btn-primary",},
				},
				closeOnCancel: false
			}).then(function(isConfirm) {  
				if (isConfirm) {  
					window.location = '?'+get+'='+id;   
				} else {     
					swal("Cancelado", "O procedimento foi cancelado :)", "error");   
				} 
			});
		}
	</script>
</body>
</html>
<div class="modal fade" id="reportarbug" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content b-0">
			<form method="post" action="" id="ajax_form" enctype="multipart/form-data">
				<input type="hidden" name="url" value="<?php echo ConfigPainel('base_url'); ?>" readonly>
				<input type="hidden" name="versao" value="<?php echo ConfigPainel('versao'); ?>">
				<input type="hidden" name="email" value="<?php echo ConfigPainel('email'); ?>">
				<div class="modal-header r-0 bg-primary">
					<h6 class="modal-title text-white" id="exampleModalLabel"><?php echo $txt['reportar_bug']; ?></h6>
					<a href="#" data-dismiss="modal" aria-label="Close" class="paper-nav-toggle paper-nav-white active"><i></i></a>
				</div>

				<div class="modal-body">
					<div class="alert alert-info">Iremos lhe responder no email de configuração do painel WACONTROL, para isto deve ser um email cadastrado em nossa loja para receber o devido suporte!</div>

					<div class="form-group">
						<label><?php echo $txt['titulo_bug']; ?></label>
						<input class="form-control" name="titulo" required>
					</div>

					<div class="form-group">
						<label><?php echo $txt['seu_nome']; ?></label>
						<input class="form-control" name="nome" required>
					</div>

					<div class="form-group">
						<label><?php echo $txt['modulo_bug']; ?></label>
						<select class="form-control" name="modulo">
							<?php $Query = DBRead('modulos','*','ORDER BY nome ASC'); if (is_array($Query)) { foreach ($Query as $modulos) { ?>
							<option value="<?php echo $modulos['nome']; ?>"><?php echo $modulos['nome']; ?></option>
							<?php } } ?>
							<option value="Menu do WebMaster">Menu do WebMaster</option>
						</select>
					</div>

					<div class="form-group">
						<label><?php echo $txt['detalhe_bug']; ?></label>
						<textarea class="form-control" rows="5" name="bug" required></textarea>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary l-s-1 s-12 text-uppercase"><?php echo $txt['reportar_bug']; ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="codhead" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content b-0">
			<div class="modal-header r-0 bg-primary">
				<h6 class="modal-title text-white" id="exampleModalLabel">Código Adicional - HEAD</h6>
				<a href="#" data-dismiss="modal" aria-label="Close" class="paper-nav-toggle paper-nav-white active"><i></i></a>
			</div>
			<div class="modal-body">
				<div class="alert alert-info">O código abaixo é um conjunto de lib que são necessários para o bom funcionamento do sistema.</div>
				<textarea class="form-control" rows="13" readonly style="font-size: 12px;">
<?php echo "<!-- Códigos Adicional -->\n"; ?>
<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/fancybox/jquery.fancybox.css?v=2.1.5" />
<script src="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/jquery.min.js"></script>
<script src="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/vue.min.js"></script>
<script src="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/owl/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/owl/owl.theme.default.min.css">
<script type="text/javascript" src="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/owl/owl.carousel.min.js"></script>
<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/animate.css">
<script type="text/javascript" src="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/css_js/wow.min.js"></script>
<script>new WOW().init();</script>
<?php echo "<!-- Códigos dos Módulos -->\n"; ?>
<script type="text/javascript" src="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/wacontrol-js.php?v=<?php echo ConfigPainel('versao'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/wacontrol-css.php?v=<?php echo ConfigPainel('versao'); ?>">
				</textarea>
			</div>
		</div>
	</div>
</div>