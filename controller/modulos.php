<?php
if(!$_SESSION['node']['id']){ die(); exit(); }

if (!checkPermission($PERMISSION, $urlModule, 'item')) {
	Redireciona('./index.php');
}


// Atualizar
    if (isset($_GET['atualiza_modulo'])) {
        if(!checkPermission($PERMISSION, $urlModule, 'item', 'editar')){ Redireciona('./index.php'); }

        $id = get('atualiza_modulo');
        $AtualizaCliente = array(
            'nome'      => post('nome'),
            'ordem'     => post('ordem')
        );

        $Query = DBUpdate("modulos",$AtualizaCliente,"id = '{$id}'");

        if ($Query) {
            Redireciona('?sucesso');
        } else {
            Redireciona('?erro');
        }
    }

// Ativar
    if (isset($_GET['ativar'])) {
        if(!checkPermission($PERMISSION, $urlModule, 'item', 'editar')){ Redireciona('./index.php'); }

        $id = get('ativar');
        $AtualizaCliente = array(
            'status'      => '1'
        );

        $Query = DBUpdate("modulos",$AtualizaCliente,"id = '{$id}'");
        if ($Query != 0) {
            Redireciona('?sucesso');
        } elseif ($Query == 0) {
            Redireciona('?erro');
        }
    }

// Desativar
    if (isset($_GET['desativar'])) {
        if(!checkPermission($PERMISSION, $urlModule, 'item', 'editar')){ Redireciona('./index.php'); }
        
        $id = get('desativar');
        $AtualizaCliente = array(
            'status'      => '2'
        );

        $Query = DBUpdate("modulos",$AtualizaCliente,"id = '{$id}'");
        if ($Query != 0) {
            Redireciona('?sucesso');
        } else {
            Redireciona('?erro');
        }
    }

    if (isset($_GET['excluir'])) {
		$id = get('excluir');
		
		if(!checkPermission($PERMISSION, $urlModule, 'item', 'deletar')){ Redireciona('./index.php'); }

        $Query = DBRead("modulos","*","WHERE id = '{$id}' AND level = 1");
		unlink("./{$Query[0]['url']}");
		unlink("./controller/{$Query[0]['url']}");
		$Query = DBDelete('modulos',"url = '{$Query[0]['url']}'");

		if ($Query != 0) {
            Redireciona('?sucesso');
        } else {
            Redireciona('?erro');
        }
	}
?>