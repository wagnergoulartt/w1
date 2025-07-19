<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/javascript');
require_once('../includes/funcoes.php');
require_once('../database/config.php');
require_once('../database/config.database.php');
require_once('../database/config.painel.php');
?>

if(location.hostname != '127.0.0.1'){
var UrlAtual = window.location.href;
<?php if (FORCAR_SSL == 'true') {
	echo "if (location.protocol == 'http:'){location.href = location.href.replace(/^http:/, 'https:');}";
} ?>
if (window.location.protocol == 'http:') { if (!UrlAtual.match("http://www.")) {var UrlAtual = UrlAtual.replace("http://", ""); window.location = 'http://www.'+UrlAtual;} };
if (window.location.protocol == 'https:') { if (!UrlAtual.match("https://www.")) {var UrlAtual = UrlAtual.replace("https://", ""); window.location = "https://www."+UrlAtual+"";} };
};

<!-- Codigo Adicional -->
var UrlPainel = '<?php echo ConfigPainel('base_url'); ?>';

<!-- Codigo dos Modulos -->
<?php $Query = DBRead('modulos', 'cod_head', "WHERE status = '1' AND cod_head != '' ORDER BY ordem ASC");
if (is_array($Query)) {
	foreach ($Query as $modulo) {
		if (file_exists("{$modulo['cod_head']}")) {
			echo url_get_contents('' . ConfigPainel('base_url') . 'wa/' . $modulo['cod_head'] . '');
			echo "\n";
		}
	}
} ?>

<?php if (ESTATISTICAS_WEBMASTER == 'true' || ESTATISTICAS_ADMIN == 'true' || ESTATISTICAS_EDITOR == 'true') { ?>
	var scripts = document.getElementsByTagName("script");
	var script_location = scripts[scripts.length-1].src;
	script_location = script_location.substring(0, script_location.lastIndexOf("/"));

	var tracker_holder = document.createElement('div');
	tracker_holder.innerHTML = "<iframe src=\"<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/analytics/analytics.php?url=" + encodeURIComponent(window.location.href) + "&referrer=" + encodeURIComponent(document.referrer) + "\" style=\"position:fixed; left:-1px; top:-1px; width:1px; height:1px; display:none; border:none; outline:none;\" width=\"1px\" height=\"1px\"></iframe>";
	document.getElementsByTagName('head')[0].appendChild(tracker_holder);
<?php } ?>