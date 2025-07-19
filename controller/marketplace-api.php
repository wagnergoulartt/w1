<?php
	$JsonModulosCliente = url_get_contents('http://api.wacontrol.com.br/api/modulos.php?v='.ConfigPainel('versao').'&email='.ConfigPainel('email'));
	$JsonModulosOutros = url_get_contents('http://api.wacontrol.com.br/api/modulos_novos.php?email='.ConfigPainel('email'));
	$JsonModulosBreve = url_get_contents('http://api.wacontrol.com.br/api/modulos_breve.php?email='.ConfigPainel('email'));
	function VerificaModInstalado($Modulo){
		if (file_exists('./'.$Modulo.'')) {
			return true;
		} else {
			return false;
		}
	}
	$Mods = json_decode($JsonModulosCliente, TRUE);
	$ModsOutros = json_decode($JsonModulosOutros, TRUE);
	$ModsBreve = json_decode($JsonModulosBreve, TRUE);
?>