<?php
	if(!$_SESSION['node']['id']){ die(); exit(); }

	if (!checkPermission($PERMISSION, $urlModule, 'item')) {
		Redireciona('./index.php');
	}

	$sqlitem = "";
	if (checkPermission($PERMISSION, $urlModule, 'item', 'vuser')) {
		$sqlitem = "AND created_by = " . DadosSession('id') . "";
	}

	$sqlbloco = "";
	if (checkPermission($PERMISSION, $urlModule, 'bloco', 'vuser')) {
		$sqlbloco = "AND created_by = " . DadosSession('id') . "";
	}

	if(isset($_GET['addBloco'])){
		if(!checkPermission($PERMISSION, $urlModule, 'bloco', 'adicionar')){ Redireciona('./index.php'); }

		$Adicionar = array(
			'nome' => post('nome'),
			'classe' => post('classe'),
			'ordem' => post('ordem'),
		);

		$Query = DBCreate('tarefas_categorias', $Adicionar);
		if ($Query != 0) {
			Redireciona('?sucesso');
		} else {
			Redireciona('?erro');
		}
	}

	if(isset($_GET['editBloco'])){
		if(!checkPermission($PERMISSION, $urlModule, 'bloco', 'editar')){ Redireciona('./index.php'); }

		$id = get('editBloco');
		$Atualizar = array(
			'nome' => post('nome'),
			'classe' => post('classe'),
			'ordem' => post('ordem'),
		);

		$Query = DBUpdate('tarefas_categorias', $Atualizar, "id = '{$id}' {$sqlbloco}");
		if ($Query != 0) {
			Redireciona('tarefas.php?blocos&sucesso');
		} else {
			Redireciona('tarefas.php?blocos&');
		}
	}

	if(isset($_GET['addTarefa'])){
		if(!checkPermission($PERMISSION, $urlModule, 'item', 'adicionar')){ Redireciona('./index.php'); }

		$id = get('addTarefa');
		$Adicionar = array(
			'titulo' => post('titulo'),
			'conteudo' => post('conteudo'),
			'data' => post('data'),
			'label' => post('label'),
			'cor' => post('cor'),
			'categoria' => $id,
			'status' => 1
		);

		$Query = DBCreate('tarefas', $Adicionar);
		if ($Query != 0) {
			Redireciona('tarefas.php?sucesso');
		} else {
			Redireciona('tarefas.php?erro');
		}
	}

	if(isset($_GET['eddTarefa'])){
		if(!checkPermission($PERMISSION, $urlModule, 'item', 'editar')){ Redireciona('./index.php'); }

		$id = get('eddTarefa');
		$Atualizar = array(
			'titulo' => post('titulo'),
			'conteudo' => post('conteudo'),
			'data' => post('data'),
			'label' => post('label'),
			'cor' => post('cor'),
			'status' => post('status')
		);

		$Query = DBUpdate('tarefas', $Atualizar, "id = '{$id}' {$sqlitem}");
		if ($Query != 0) {
			Redireciona('tarefas.php?sucesso');
		} else {
			Redireciona('tarefas.php?erro');
		}
	}

	if(isset($_GET['attTarefa'])){
		if(!checkPermission($PERMISSION, $urlModule, 'item', 'editar')){ Redireciona('./index.php'); }

		$id = get('attTarefa');
		$Atualizar = array(
			'status' => 0
		);

		$Query = DBUpdate('tarefas', $Atualizar, "id = '{$id}' {$sqlitem}");
		if ($Query != 0) {
			Redireciona('tarefas.php?sucesso');
		} else {
			Redireciona('tarefas.php?erro');
		}
	}

	if (isset($_GET['excluir'])) {
		if(!checkPermission($PERMISSION, $urlModule, 'bloco', 'deletar')){ Redireciona('./index.php'); }

		$id = get('excluir');
		$Query = DBDelete('tarefas',"categoria = '{$id}'");
		
		if ($Query != 0) {
			$Query = DBDelete('tarefas_categorias',"id = '{$id}' {$sqlbloco}");
			if($Query != 0){
				Redireciona('?sucesso');
			}
		} else {
			Redireciona('?erro');
		}
	}

	if (isset($_GET['excluirTarefa'])) {
		if(!checkPermission($PERMISSION, $urlModule, 'item', 'deletar')){ Redireciona('./index.php'); }

		$id = get('excluirTarefa');
		$Query = DBDelete('tarefas',"id = '{$id}' {$sqlitem}");

		if ($Query != 0) {
			Redireciona('?sucesso');
		} else {
			Redireciona('?erro');
		}
	}
?>