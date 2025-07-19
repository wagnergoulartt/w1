<?php
require_once('./database/config.painel.php');
if(!$_SESSION['node']['id']){ die(); exit(); }

if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item')) {
	Redireciona('./index.php');
}

// Atualizar
	if (isset($_GET['Atualizar'])) {
	    
	    if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'acessar')) {
	Redireciona('./index.php');
}

		if (isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'])){
	        require_once 'database/upload.class.php';
	        $dir_dest = 'css_js/images/logo/';
	        $files = array( );
	        $file = $_FILES['imagem'];
	        $handle = new Upload( $file );
	        if ($handle->uploaded){
	            $handle->file_new_name_body = md5(uniqid($file['name']));
	            $handle->Process($dir_dest);
	            if ($handle->processed){
	                $file_dst_name = $handle->file_dst_name;
	                $Imagem = $handle->file_dst_name;
	                $Atualizar = array('logo' => $Imagem);
	                $Query = DBUpdate('config', $Atualizar);
	            }
	        }
	    }

	    function EditarArquivo($Arquivo, $ItemUm, $ItemDois){
	        $Conteudo = file_get_contents(''.$Arquivo.'');
	        $Subistituicao = str_replace(''.$ItemUm.'', ''.$ItemDois.'', $Conteudo);
	        $ApagaAntigo = unlink($Arquivo);
	        $AbreArquivo = fopen("".$Arquivo."", "a");
	        $GeraNovo = fwrite($AbreArquivo, ''.$Subistituicao.'');
	        fclose($AbreArquivo);
	    }
	    
	    if ($_POST['ssl'] == "S") {
	    	EditarArquivo("./database/config.painel.php","define('FORCAR_SSL','false')","define('FORCAR_SSL','true')");
	    } else {
	    	EditarArquivo("./database/config.painel.php","define('FORCAR_SSL','true')","define('FORCAR_SSL','false')");
	    }
	    if ($_POST['iconesdash'] == "S") {
	    	if (!defined('ICONESDASH')) {
	    		$AbreArquivo = fopen("./database/config.painel.php", "a");
	    		$Escreve = fwrite($AbreArquivo, "\n<?php define('ICONESDASH','true'); ?>");
	    	} else {
	    		$Result = EditarArquivo("./database/config.painel.php","define('ICONESDASH','false')","define('ICONESDASH','true')");
	    	}
	    } else {
	    	if (!defined('ICONESDASH')) {
	    		$AbreArquivo = fopen('./database/config.painel.php', 'a');
	    		$Escreve = fwrite($AbreArquivo, "\n<?php define('ICONESDASH','false'); ?>");
	    	} else {
	    		$Result = EditarArquivo("./database/config.painel.php","define('ICONESDASH','true')","define('ICONESDASH','false')");
	    	}
	    }
	    

	    $nome = $_FILES['background']['name'];
	    $destino = 'css_js/images/background.png';
		$arquivo_tmp = $_FILES['background']['tmp_name'];
		move_uploaded_file( $arquivo_tmp, $destino);

		$Atualizar = array(
			'site_url' 		=> post('site_url'),
			'base_url' 		=> post('base_url'),
			'site_nome' 	=> post('site_nome'),
			'erro' 			=> post('erro'),
			'tema' 			=> post('tema'),
			'cor_blocos' 	=> post('cor_blocos'),
			'menu' 			=> post('menu'),
			'manutencao' 	=> post('manutencao'),
			'paginacao' 	=> post('paginacao'),
			'msg_manutencao'=> post('msg_manutencao'),
			'smtp_servidor' => post('smtp_servidor'),
			'smtp_usuario'   => post('smtp_usuario'),
			'smtp_senha'    => post('smtp_senha'),
			'smtp_porta'    => post('smtp_porta'),
			'site_key'    => post('site_key'),
			'secret_key'    => post('secret_key')
		);

		$Query = DBUpdate('config', $Atualizar);

		if ($Query != 0) {
	        Redireciona('?sucesso');
	    } else {
	        Redireciona('?erro');
	    }
	}
?>