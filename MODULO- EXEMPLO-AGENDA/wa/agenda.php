<?php
	require_once('../includes/funcoes.php');
	require_once('../database/config.php');
	require_once('../database/config.database.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css_js/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css_js/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css_js/fancybox/jquery.fancybox.css?v=2.1.5" />
	<style>
		body{ background-color: transparent; overflow-x: hidden; }
		.fancybox-overlay { background: transparent; }
		.fade.in { opacity: 1; background-color: transparent;}
		.fade { background-color: transparent;}
		.gallery{ display: inline-block; margin-top: 10px;}
	</style>
	<!-- JS -->
	<?php if (isset($_GET['Wa4'])) { ?>
	<script>var VersaoWA = 'Wa4';</script>
	<?php } ?>
	<script src="css_js/jquery.min.js"></script>
	<script src="css_js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
	<script src="agenda/agenda.js"></script>
</head>
<body>
	<div class="col-lg-12">
		<div id="AgendaEventosWA<?php echo get('id'); ?>" data-categoria="<?php echo get('id'); ?>" data-painel="<?php echo ConfigPainel('base_url'); ?>"></div>
		<script>AgendaEventos(<?php echo get('id'); ?>,1);</script>
	</div>
</body>
</html>