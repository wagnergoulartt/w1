<?php
if (!$_SESSION['node']['id']) {
	die();
	exit();
}

/*VERICA SE O USUÁRIO TEM PERMISSÃO PARA ACESSAR O CONTROLADOR*/
if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'])) { Redireciona('./index.php'); }

/*GERA UM COMPLEMENTO PARA A QUERY CASO O GRUPO DO USUÁRIO TENHA PERMISSÃO APENAS PARA QUE ELE POSSA GERENCIAR O CONTEÚDO QUE ELE MESMO CRIOU*/
$sql = "";
if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'vuser')) {
	$sql = "AND created_by = " . DadosSession('id') . "";
}

// Adicionar
if (isset($_GET['Adicionar'])) {
	$ArrayData = $_POST['data'];
	$ArrayData = json_decode($ArrayData, TRUE);

	if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'adicionar')){
		Redireciona('./index.php');
	}

	$Name = $ArrayData['name'];
	unset($ArrayData['name']);

	$json = json_encode($ArrayData);
	unset($ArrayData);
	$ArrayData['params'] = $json;
	$ArrayData['name']	=	$Name;

	$ArrayData['created_by'] = DadosSession('id');

	$Query = DBCreate('permissions_groups', $ArrayData, true);
	
	if ($Query != 0) {
		Redireciona('?sucesso');
	} else {
		Redireciona('?erro=groups');
	}
}

// Atualizar
if (isset($_GET['Atualizar'])) {
	$id = get('Atualizar');

	if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'editar')){
		Redireciona('./index.php');
	}
    
	$ArrayData = $_POST['data'];
	$ArrayData = json_decode($ArrayData, TRUE);

	$Name = $ArrayData['name'];
	unset($ArrayData['name']);
	unset($ArrayData['id']);

	$json = json_encode($ArrayData);
	unset($ArrayData);
	$ArrayData['name']	=	$Name;
	$ArrayData['params'] = $json;
	$ArrayData['created_by'] = DadosSession('id');

	$Query = DBUpdate('permissions_groups', $ArrayData, "id = '{$id}'");

	if ($Query != 0) {
		Redireciona('?EditarItem='.$id);
	} else {
		Redireciona('?erro');
	}
	
}


// Excluir
if (isset($_GET['excluir'])) {
	$id = get('excluir');

	/*VERICA SE O USUÁRIO TEM PERMISSÃO PARA EXECUTAR A AÇÃO NO CONTROLADOR*/
	if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'deletar')){
		Redireciona('./index.php');
	}

	$Query = DBDelete('permissions_groups', "id = '{$id}' {$sql}");

	if ($Query != 0) {
		//Redireciona('?sucesso');
	} else {
		Redireciona('?erro');
	}
}
