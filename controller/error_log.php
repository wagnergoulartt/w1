<?php
if(!$_SESSION['node']['id']){ die(); exit(); }

if (!checkPermission($PERMISSION, $urlModule, 'item')) {
	Redireciona('./index.php');
}


// Limpa Logs do Painel
if (isset($_GET['limpar_log_painel'])) {
  if(!checkPermission($PERMISSION, $urlModule, 'item', 'acessar')){ Redireciona('./index.php'); }
  unlink('error_log');
    Redireciona('?sucesso');
}

// Limpa Logs dos Modulos
if (isset($_GET['limpar_log_modulos'])) {
  if(!checkPermission($PERMISSION, $urlModule, 'item', 'acessar')){ Redireciona('./index.php'); }
  unlink('wa/error_log');
    Redireciona('?sucesso');
}
?>