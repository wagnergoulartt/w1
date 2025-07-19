<?php
if(!$_SESSION['node']['id']){ die(); exit(); }
if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'])) { Redireciona('./index.php'); }

	function AddImagemUpload($Input, $Caminho){
		if (isset($_FILES[''.$Input.'']) && !empty($_FILES[''.$Input.'']['name'])){
	    	require_once 'database/upload.class.php';
	        $dir_dest = ''.$Caminho.'';
	        $files = array( );
	        $file = $_FILES[''.$Input.''];
	        $handle = new Upload( $file );
	        if ($handle->uploaded){
	            $handle->file_new_name_body = md5(uniqid($file['name']));
	            $handle->Process($dir_dest);
	            if ($handle->processed){
	                $file_dst_name = $handle->file_dst_name;
	                $Imagem = $handle->file_dst_name;
	                return $Imagem;
	            }
	        }
	    }
	}
	function UpdateImagemUpload($Input, $InputAntigo, $Caminho, $Tabela, $Id){
		if (isset($_FILES[''.$Input.'']) && !empty($_FILES[''.$Input.'']['name'])){
	        require_once 'database/upload.class.php';
	        $dir_dest = ''.$Caminho.'';
	        $files = array( );
	        $file = $_FILES[''.$Input.''];
	        $handle = new Upload( $file );
	        if ($handle->uploaded){
	            $handle->file_new_name_body = md5(uniqid($file['name']));
	            $handle->Process($dir_dest);
	            if ($handle->processed){
	                $file_dst_name = $handle->file_dst_name;
	                $Imagem = $handle->file_dst_name;
	                $Atualizar = array(''.$Input.'' => $Imagem);
	                $Query = DBUpdate(''.$Tabela.'', $Atualizar, "id = '{$Id}'");
	                @unlink($dir_dest.post(''.$InputAntigo.''));
	            }
	        }
	    }
	}
// Adicionar Item
	if (isset($_GET['Adicionar'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'adicionar')){ Redireciona('./index.php'); }

		$Adicionar = array(
			'titulo' 		=> post('titulo'),
			'conteudo' 		=> post('conteudo'),
			'dataI' 		=> post('dataI'),
			'horaI' 		=> post('horaI'),
			'dataT' 		=> post('dataT'),
			'horaT' 		=> post('horaT'),
			'local' 		=> post('local'),
			'imagem' 		=> AddImagemUpload('imagem', 'wa/agenda/uploads/'),
			'id_categoria' 	=> post('id_categoria'),
			'resumo'        => post('resumo'),
			'url'           => post('url'),
			'status'        => post('status')
		);
		$Query = DBCreate('agenda', $Adicionar);
		if ($Query) {
			file_get_contents(''.ConfigPainel('base_url').'/controller/agenda.atualiza.matriz.php?id='.post('id_categoria').'');
			Redireciona('?sucesso');
		} else {
			Redireciona('?erro');
		}
	}
// Atualizar Item
	if (isset($_GET['Atualizar'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'editar')){ Redireciona('./index.php'); }

		$id = get('Atualizar');
		UpdateImagemUpload('imagem', 'imagem_atual', 'wa/agenda/uploads/', 'agenda', $id);
		$Atualizar = array(
			'titulo' 		=> post('titulo'),
			'conteudo' 		=> post('conteudo'),
			'dataI' 		=> post('dataI'),
			'horaI' 		=> post('horaI'),
			'dataT' 		=> post('dataT'),
			'horaT' 		=> post('horaT'),
			'local' 		=> post('local'),
			'id_categoria' 	=> post('id_categoria'),
			'resumo'        => post('resumo'),
			'url'           => post('url'),
			'status'        => post('status')
		);
		$Query = DBUpdate('agenda', $Atualizar, "id = '{$id}'");
		if ($Query) {
			file_get_contents(''.ConfigPainel('base_url').'/controller/agenda.atualiza.matriz.php?id='.post('id_categoria').'');
			Redireciona('?sucesso'); 
		} else {
			Redireciona('?erro'); 
		}
	}
// Excluir Item
    if (isset($_GET['DeletarItem'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'deletar')){ Redireciona('./index.php'); }

    	$id = get('DeletarItem');
		$Query = DBDelete('agenda',"id = '{$id}'");
		if ($Query != 0) {
            Redireciona('?sucesso');
        } else {
            Redireciona('?erro');
        }
	}
// Adicionar Categoria
	if (isset($_GET['AddCategoria'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'adicionar')){ Redireciona('./index.php'); }

		$Adicionar = array(
			'categoria' 	=> post('categoria'),
			'paginacao' 	=> post('paginacao'),
			'background' 	=> post('background'),
			'ordenar_por' 	=> post('ordenar_por'),
			'asc_desc' 		=> post('asc_desc'),
			'modelo' 		=> post('modelo'),
			'colunas'       => post('colunas'),
			'cor_fonte' 	=> post('cor_fonte'),
			'cor_titulo' 	=> post('cor_titulo'),
			'cor_btn' 		=> post('cor_btn'),
			'efeito' 		=> post('efeito'),
			'matriz' 		=> post('matriz'),
			'ativa_paginacao'=> post('ativa_paginacao'),
			'cor_txt_btn' 	=> post('cor_txt_btn'),
			'carousel'      => post('carousel'),
			'cor_carousel'  => post('cor_carousel')
		);
		$Query = DBCreate('c_agenda', $Adicionar);
		if ($Query) { Redireciona('?Implementacao&sucesso'); } else { Redireciona('?Implementacao&erro'); }
	}
// Atualizar Categoria
	if (isset($_GET['AtualizarCategoria'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'editar')){ Redireciona('./index.php'); }

		$id = get('AtualizarCategoria');
		$Adicionar = array(
			'categoria' 	=> post('categoria'),
			'paginacao' 	=> post('paginacao'),
			'background' 	=> post('background'),
			'ordenar_por' 	=> post('ordenar_por'),
			'asc_desc' 		=> post('asc_desc'),
			'modelo' 		=> post('modelo'),
			'colunas'       => post('colunas'),
			'cor_fonte' 	=> post('cor_fonte'),
			'cor_titulo' 	=> post('cor_titulo'),
			'cor_btn' 		=> post('cor_btn'),
			'efeito' 		=> post('efeito'),
			'matriz' 		=> post('matriz'),
			'ativa_paginacao'=> post('ativa_paginacao'),
			'cor_txt_btn' 	=> post('cor_txt_btn'),
			'carousel'      => post('carousel'),
			'cor_carousel'  => post('cor_carousel')
		);
		$Query = DBUpdate('c_agenda', $Adicionar, "id = '{$id}'");
		if ($Query) { Redireciona('?Implementacao&sucesso'); } else { Redireciona('?erro'); }
	}
// Excluir Categoria
	if (isset($_GET['DeletarCategoria'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'deletar')){ Redireciona('./index.php'); }

    	$id = get('DeletarCategoria');
		$Query = DBDelete('c_agenda',"id = '{$id}'");
		if ($Query != 0) {
            Redireciona('?Implementacao&sucesso');
        } else {
            Redireciona('?Implementacao&erro');
        }
	}
//Duplica Item
	if (isset($_GET['Duplicar'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'evento', 'adicionar')){ Redireciona('./index.php'); }

		$id = get('Duplicar');

		$Query = DBRead('agenda','*',"WHERE id = '{$id}' LIMIT 1");
		$Query = $Query[0];
		unset($Query['id']);

		$Query = DBCreate('agenda', $Query, true);
		
		if ($Query != 0) {
	        Redireciona('?EditarItem='.$Query.'&sucesso');
	    } else {
	        Redireciona('?erro');
	    }
	}
//Duplica Item
	if (isset($_GET['DuplicarCategoria'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'adicionar')){ Redireciona('./index.php'); }

		$id = get('DuplicarCategoria');

		$Query = DBRead('c_agenda','*',"WHERE id = '{$id}' LIMIT 1");
		$Query = $Query[0];
		unset($Query['id']);

		$Query = DBCreate('c_agenda', $Query, true);
		
		if ($Query != 0) {
	        Redireciona('?Implementacao&EditarCategoria='.$Query.'&sucesso');
	    } else {
	        Redireciona('?Implementacao&erro');
	    }
	}