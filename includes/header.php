<?php
	if (!file_exists('database/config.php')) {
		header("Location:setup.php");
	} else {
		require_once ('database/config.php');
	}
	require_once ('database/config.session.php');
	$sid = new Session;
	$sid->start();
	
	require_once ('database/config.painel.php');
	require_once ('database/config.database..php');
	require_once ('includes/funcoes.php');
	
	if (!$sid->check()){
		Redireciona('login.php');
	}
	

	$DefineLang = DefineLang('m7admin.php');
	if (file_exists($DefineLang)) {
		require_once $DefineLang;
	}
	
	if(file_exists('./database.sql')){
	    function ImportaDB($filename, $dblink){
		    $templine = '';
		    $lines = file($filename);
		    foreach ($lines as $line_num => $line) {
		        if (substr($line, 0, 2) != '--' && $line != '') {
		            $templine .= $line;
		            if (substr(trim($line), -1, 1) == ';') {
		                if (!mysqli_query($dblink, $templine)) {
		                    $success = false;
		                }
		                $templine = '';
		            }
		        }
		    }
		}
		ImportaDB('./database.sql', DBConnect());
		@unlink('./database.sql');
	}

	$PERMISSION = GetPermissionsUser();
	$urlModule = $_SERVER['SCRIPT_NAME'];
	$urlModule = explode('/', $urlModule);
	$urlModule = end($urlModule);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $txt['painel_admin']; ?></title>
	<meta name="robots" content="noindex">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="assets/css/app.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" href="assets/plugins/forms/css/fonts.css">
	<script>
		if(location.hostname != '127.0.0.1'){
      <?php if(FORCAR_SSL == 'true'): ?>
        if (location.protocol == 'http:'){location.href = location.href.replace(/^http:/, 'https:');}
      <?php endif; ?>
		};
	</script>
	<?php $Query = DBRead('config','*'); if (is_array($Query)) { foreach ($Query as $config) { ?>
	<style type="text/css">
		.bfh-selectbox .bfh-selectbox-options{width: 100%}
		.swal-button {background-color: <?php echo $config['cor_blocos']; ?> !important; color: #fff !important;}
		.lobilist-danger{border-bottom: 1px solid #ed5564; background-color: #ed5564;}
		.lobilist-success{border-bottom: 1px solid #7dc855; background-color: #7dc855}
		.lobilist-warning{border-bottom: 1px solid #fcce54; background-color: #fcce54}
		.lobilist-info{border-bottom: 1px solid #ffc500; background-color: #ffc500;}
		.lobilist-primary{border-bottom: 1px solid #003260; background-color: #004484}
		.social li a{color: #fff !important}
		.nav-pills .nav-link.active, .nav-pills .show>.nav-link{background: <?php echo $config['cor_blocos']; ?> !important; color: #fff !important}
		.list-group-item a, .nav-pills .nav-link{color: #999 !important;}
		.text-primary{color: <?php echo $config['cor_blocos']; ?> !important;}
		.btn-primary, .bg-primary, .toast-primary, .blue.lighten-2, .offcanvas .sidebar-menu>li.active:after{background: <?php echo $config['cor_blocos']; ?> !important; border-color: <?php echo $config['cor_blocos']; ?> !important;}
		.blue.accent-3{background: <?php echo $config['cor_blocos']; ?> !important}
		.theme-dark .card, .theme-dark .list-group-item, .theme-dark .main-sidebar, .theme-dark .navbar, .theme-dark.body, .theme-dark.card, .theme-dark.main-sidebar, .theme-dark.navbar{background: <?php echo $config['menu']; ?> !important}
		aside .sidebar-menu li a{color: #86939e !important;}
		.theme-dark .card-header .white, .theme-dark .light, .theme-dark .sidebar-menu li a:hover, .theme-dark .table-hover tbody tr:hover {background: rgba(0, 0, 0, 0.18);}
		.badge-primary, .badge-warning{background: <?php echo $config['cor_blocos']; ?> !important; color: #fff !important;},
		.navbar-dark .navbar-nav .nav-link {color: rgba(255,255,255,.5) !important;}
		.csscheckbox {
    position: relative;
    padding-left: 25px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 12px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
	margin-right: 15px;
}
.csscheckbox input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
}
.csscheckbox:hover input ~ .checkmark {
  background-color: #ccc;
}
.csscheckbox input:checked ~ .checkmark {
  background-color: #2196F3;
}
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}
.csscheckbox input:checked ~ .checkmark:after {
  display: block;
}
.csscheckbox .checkmark:after {
  left: 7px;
  top: 4px;
  width: 7px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.csscheckbox .inputradio{
  border-radius: 50px;
}
.hidden{
	display: none;
}
	</style>
	<?php } } ?>
</head>

<body class="light">
	<div id="app">