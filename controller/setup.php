<?php
	function VerificaPontuacao($Pontuacao, $Total){
		$Dados = (($Pontuacao / $Total) * 100);
		return $Dados;
	}

	function ProgressBar($Pontuacao){
		if ($Pontuacao <= 25) {
			$Class = "progress-bar-danger";
		} elseif ($Pontuacao >= 26 && $Pontuacao <= 50) {
			$Class = "progress-bar-warning";
		} elseif ($Pontuacao >= 51 && $Pontuacao <= 75) {
			$Class = "progress-bar-info";
		} elseif ($Pontuacao >= 76) {
			$Class = "progress-bar-success";
		}

		return $Class;
	}

  	function ImportaDB($filename, $dblink){
	    $templine = '';
	    $lines = file($filename);
	    foreach ($lines as $line_num => $line) {
	        if (substr($line, 0, 2) != '--' && $line != '') {
	            $templine .= $line;
	            if (substr(trim($line), -1, 1) == ';') {
	                if (!mysqli_query($dblink, $templine)) {
	                    $success = false;
	                }
	                $templine = '';
	            }
	        }
	    }
	}

	function AbreAlerta($mensagem){
        echo "<script>alert('$mensagem')</script>";
    }

    function Redireciona($arquivo){
        echo "<script> window.location = '$arquivo'; </script>";
    }

    function url_get_contents ($Url) {
        if (!function_exists('curl_init')){ 
            die('Ative a Extensão cURL!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

  	if (isset($_GET['InstallDB'])) {

  		if ($_POST['senha'] != $_POST['senhaconfirm']) {
  			AbreAlerta('As senhas não conferem, por favor, tente novamente!');
  			Redireciona('setup.php?step=3');
	  	} else {
		  	$MySQL 		= mysqli_connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], $_POST['dbname']);
		  	mysqli_set_charset($MySQL, 'utf8') or die (mysqli_error($MySQL));

			if ($MySQL) {
		      $result = mysqli_query($MySQL, "CREATE DATABASE `".$_POST['dbname']."`;");
		      
		      $success = true;
		      
			    if ($success){
			          GeraDatabaseConfig($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], $_POST['dbname']);
			     }
			}

			/*$AtivaPainel = file_get_contents('http://api.wacontrol.com.br/api/PainelCliente.php?e='.$_POST['email'].'&u='.str_replace(['http://','https://'], ['',''], $_POST['siteurl']).'&v='.$Versao.'&d='.str_replace('www.', '', $_SERVER['SERVER_NAME']).'');
			
			if ($AtivaPainel == "Cliente Inativo") {
				AbreAlerta('Não foi possível efetuar a instalação, certifique-se que você inseriu o mesmo email que cadastrou em nossa loja no momento da compra do sistema/módulo!\nErro: WACX001');
				echo "<script>javascript:history.back()</script>";
			} else {
				//código abaixo era aqui!
			}*/

			$LimpaConfig = mysqli_query($MySQL, "TRUNCATE config");
			ImportaDB("database/BD.sql", $MySQL);
			$QueryAddUser = "INSERT INTO `usuarios` (`id`, `nome`, `login`, `senha`, `email`, `avatar`, `nivel`, `permissao`, `status`, `token`) VALUES ('1', '".$_POST['usuario']."', '".$_POST['login']."', '".md5($_POST['senha'])."', '".$_POST['email']."', 'avatar.png', '1', '1', '1', '');";
			$QueryUsuarios 	= mysqli_query($MySQL, $QueryAddUser);
			$QueryConfig 	= mysqli_query($MySQL, "INSERT INTO `config` (site_nome, site_url, base_url, email) VALUES ('".$_POST['nomesite']."','".$_POST['urlsite']."','".$_POST['siteurl']."','".$_POST['email']."')");
			Redireciona('setup.php?step=4');
  		} 
  	}
?>