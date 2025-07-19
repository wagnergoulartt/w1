<?php
if(!$_SESSION['node']['id']){ die(); exit(); }

if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'])) { Redireciona('./index.php'); }

// Adicionar Item
	if (isset($_GET['Adicionar'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'post', 'adicionar')){ Redireciona('./index.php'); }
		if (isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'])){
	        require_once 'database/upload.class.php';
	        $dir_dest = 'wa/blog/uploads/';
	        $files = array( );
	        $file = $_FILES['imagem'];
	        $handle = new Upload( $file );
	        if ($handle->uploaded){
	            $handle->file_new_name_body = md5(uniqid($file['name']));
	            $handle->Process($dir_dest);
	            if ($handle->processed){
	                $file_dst_name = $handle->file_dst_name;
	                $Imagem = $handle->file_dst_name;
	            }
	        }
	    }

	    $ConteudoPost = str_replace("<img alt='' src='", "<img alt='' class='img-responsive' src='", post('conteudo',false));
	    $ConteudoPost = str_replace("<img src='", "<img class='img-responsive' src='", $ConteudoPost);

		$Adicionar = array(
			'titulo' 	=> post('titulo'),
			'resumo' 	=> post('resumo'),
			'conteudo' 	=> $ConteudoPost,
			'imagem' 	=> $Imagem,
			'data' 		=> post('data'),
			'autor' 	=> DadosSession('id'),
			'id_categoria' => post('id_categoria'),
			'url' => post('url'),
			'tags' => post('tags'),
			'status' 	=> post('status')
		);
		//$Adicionar['created_by'] = DadosSession('id');

		$QueryBlog = DBCreate('blog', $Adicionar, true);

		if ($QueryBlog != 0) {
			file_get_contents(''.ConfigPainel('base_url').'/controller/blog.atualiza.matriz.php?id='.post('id_categoria').'');
	        Redireciona('?sucesso');
	    } else {
	        Redireciona('?erro');
	    }
	}
// Atualizar Item
	if (isset($_GET['Atualizar'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'post', 'editar')){ Redireciona('./index.php'); }

		$id = get('Atualizar');
		if (isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'])){
	        require_once 'database/upload.class.php';
	        $dir_dest = 'wa/blog/uploads/';
	        $files = array( );
	        $file = $_FILES['imagem'];
	        $handle = new Upload( $file );
	        if ($handle->uploaded){
	            $handle->file_new_name_body = md5(uniqid($file['name']));
	            $handle->Process($dir_dest);
	            if ($handle->processed){
	                $file_dst_name = $handle->file_dst_name;
	                $Imagem = $handle->file_dst_name;
	                $Atualizar = array('imagem' => $Imagem);
	                $Query = DBUpdate('blog', $Atualizar, "id = '{$id}'");
	                @unlink($dir_dest.post('imagem_atual'));
	            }
	        }
	    }

	    $ConteudoPost = str_replace("<img alt='' src='", "<img alt='' class='img-responsive' src='", post('conteudo',false));
	    $ConteudoPost = str_replace("<img src='", "<img class='img-responsive' src='", $ConteudoPost);

		$Atualizar = array(
			'titulo' 	=> post('titulo'),
			'resumo' 	=> post('resumo'),
			'conteudo' 	=> $ConteudoPost,
			'data' 		=> post('data'),
			'autor' 	=> DadosSession('id'),
			'id_categoria' => post('id_categoria'),
			'url' => post('url'),
			'tags' => post('tags'),
			'status' 	=> post('status')
		);

		$Query = DBUpdate('blog', $Atualizar, "id = '{$id}'");


		if ($Query != 0) {
			file_get_contents(''.ConfigPainel('base_url').'/controller/blog.atualiza.matriz.php?id='.post('id_categoria').'');
	        Redireciona('?sucesso');
	    } else {
	        Redireciona('?erro');
	    }
	}
//Duplica Item
	if (isset($_GET['Duplicar'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'post', 'adicionar')){ Redireciona('./index.php'); }

		$id = get('Duplicar');

		$Query = DBRead('blog','*',"WHERE id = '{$id}' LIMIT 1");
		$Query = $Query[0];
		unset($Query['id']);

		$Query = DBCreate('blog', $Query, true);
		
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

		$Query = DBRead('c_blog','*',"WHERE id = '{$id}' LIMIT 1");
		$Query = $Query[0];
		unset($Query['id']);

		$Query = DBCreate('c_blog', $Query, true);
		
		if ($Query != 0) {
	        Redireciona('?EditarCategoria='.$Query.'&sucesso');
	    } else {
	        Redireciona('?erro');
	    }
	}
// Excluir Item
    if (isset($_GET['DeletarItem'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'post', 'deletar')){ Redireciona('./index.php'); }

    	$id = get('DeletarItem');
		$QueryItem = DBRead('blog','*',"WHERE id = '{$id}'");
		@unlink("../".$QueryItem[0]['url'].'-'.$id.".html");
		$Query = DBDelete('blog',"id = '{$id}'");
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
			'comentarios' 		=> post('comentarios'),
			'ativa_paginacao' 		=> post('ativa_paginacao'),
			'cor_txt_btn' 	=> post('cor_txt_btn'),
			'carousel'      => post('carousel'),
			'cor_carousel'  => post('cor_carousel')
		);
		$Query = DBCreate('c_blog', $Adicionar);
		if ($Query != 0) {
	        Redireciona('?Implementacao&sucesso');
	    } else {
	        Redireciona('?Implementacao&erro');
	    }
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
			'comentarios' 		=> post('comentarios'),
			'ativa_paginacao' 		=> post('ativa_paginacao'),
			'cor_txt_btn' 	=> post('cor_txt_btn'),
			'carousel'      => post('carousel'),
			'cor_carousel'  => post('cor_carousel')
		);
		//$Adicionar['created_by'] = DadosSession('id');
		$Query = DBUpdate('c_blog', $Adicionar, "id = '{$id}'");
		if ($Query != 0) {
			$atualizarMatriz = '<script>AtualizaMatriz('.$id.')</script>';
	    } else {
	        Redireciona('?Implementacao&erro');
	    }
	}
// Excluir Categoria
	if (isset($_GET['DeletarCategoria'])) {
		if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'deletar')){ Redireciona('./index.php'); }

    	$id = get('DeletarCategoria');
		$Query = DBDelete('c_blog',"id = '{$id}'");
		if ($Query != 0) {
            Redireciona('?Implementacao&sucesso');
        } else {
            Redireciona('?Implementacao&erro');
        }
	}
?>