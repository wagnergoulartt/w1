<?php
if(!$_SESSION['node']['id']){ die(); exit(); }

if (!checkPermission($PERMISSION, $urlModule, 'item')) {
	Redireciona('./index.php');
}

$sql = "";
if (checkPermission($PERMISSION, $urlModule, 'item', 'vuser')) {
	$sql = "AND created_by = " . DadosSession('id') . "";
}


// Status do Usuário
	function StatusUsuario($Status){
		if ($Status == 1) {
			echo '<span class="label label-info">Ativo</span>';
		} elseif ($Status == 2) {
			echo '<span class="label label-danger">Inativo</span>';
		}
	}

// Nivel do Usuário
	function NivelUsuario($Status){
		$query = DBRead("permissions_groups",'*',"WHERE id = '{$Status}'");
		echo $query[0]['name'];
	}

// Adicionar
	if (isset($_GET['Adicionar'])) {
		if(!checkPermission($PERMISSION, $urlModule, 'item', 'adicionar')){ Redireciona('./index.php'); }

		if (isset($_POST['login']) && !empty($_POST['login'])) {
			$Login = post('login');
			$Query = DBCount('usuarios','login',"WHERE login = '{$Login}'");
				if ($Query >= 1) {
					AbreAlerta('Este login já está sendo usado por outro usuário');
					Redireciona('?adicionar');
				} else {
					if (isset($_POST['email']) && !empty($_POST['email'])) {
						$Email = post('email');
						$Query = DBCount('usuarios','email',"WHERE email = '{$Email}'");
							if ($Query >= 1) {
								AbreAlerta('Este email já está sendo usado por outro usuário');
								Redireciona('?adicionar');
							} else {
								if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])){
							        require_once 'database/upload.class.php';
							        $dir_dest = 'css_js/images/usuarios/';
							        $files = array( );
							        $file = $_FILES['avatar'];
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

								$Adicionar = array(
									'nome' 		=> post('nome'),
									'login' 	=> post('login'),
									'senha' 	=> md5(post('senha')),
									'email' 	=> post('email'),
									'avatar' 	=> $Imagem,
									'permissao' => post('permissao'),
									'nivel' 	=> 1,
									'status' 	=> post('status'),
									'sobre'     => post('sobre')
								);

								$Query = DBCreate('usuarios', $Adicionar);

								if ($Query != 0) {
							        Redireciona('?sucesso');
							    } else {
							        Redireciona('?erro');
							    }
							}
						}
					}
				}
		}

// Atualizar
	if (isset($_GET['Atualizar'])) {
		$id = get('Atualizar');

		if(!checkPermission($PERMISSION, $urlModule, 'item', 'editar')){ Redireciona('./index.php'); }

		if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])){
	        require_once 'database/upload.class.php';
	        $dir_dest = 'css_js/images/usuarios/';
	        $files = array( );
	        $file = $_FILES['avatar'];
	        $handle = new Upload( $file );
	        if ($handle->uploaded){
	            $handle->file_new_name_body = md5(uniqid($file['name']));
	            $handle->Process($dir_dest);
	            if ($handle->processed){
	                $file_dst_name = $handle->file_dst_name;
	                $Imagem = $handle->file_dst_name;
	                $Atualizar = array('avatar' => $Imagem);
	                $Query = DBUpdate('usuarios', $Atualizar, "id = '{$id}' {$sql}");
	                @unlink($dir_dest.post('imagem_atual'));
	            }
	        }
	    }

		if (isset($_POST['senha']) && !empty($_POST['senha'])) {
			$Atualizar = array(
				'nome' 		=> post('nome'),
				'login' 	=> post('login'),
				'senha' 	=> md5(post('senha')),
				'email' 	=> post('email'),
				'permissao' => post('permissao'),
				'nivel' 	=> 1,
				'status' 	=> post('status'),
				'sobre'     => post('sobre')
			);
		} else {
			$Atualizar = array(
				'nome' 		=> post('nome'),
				'login' 	=> post('login'),
				'email' 	=> post('email'),
				'permissao' => post('permissao'),
				'nivel' 	=> 1,
				'status' 	=> post('status'),
				'sobre'     => post('sobre')
			);
		}

		$Query = DBUpdate('usuarios', $Atualizar, "id = '{$id}' {$sql}");

		if ($Query != 0) {
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

	    $Query = DBUpdate("usuarios",$AtualizaCliente,"id = '{$id}' {$sql}");
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

        $Query = DBUpdate("usuarios",$AtualizaCliente,"id = '{$id}' {$sql}");
        if ($Query != 0) {
            Redireciona('?sucesso');
        } else {
            Redireciona('?erro');
        }
    }

// Excluir
    if (isset($_GET['excluir'])) {
		$id = get('excluir');
		
		if(!checkPermission($PERMISSION, $urlModule, 'item', 'deletar')){ Redireciona('./index.php'); }

		
		$Query = DBDelete('usuarios',"id = '{$id}' {$sql}");

		if ($Query != 0) {
            Redireciona('?sucesso');
        } else {
            Redireciona('?erro');
        }
	}
?>