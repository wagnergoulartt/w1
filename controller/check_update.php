<?php
	function DownloadRemoteFile($Url, $Nome){
		if (!copy('http://'.$Url, $Nome)) {
			echo "Ocorreu um Erro ao Tentar Baixar o Arquivo!";
		} else {
			echo "Baixando...";
		}
	}

	function CheckAutoUpdate(){
		$Get = url_get_contents('http://api.wacontrol.com.br/api/AutoUpdateNew.php?Versao='.ConfigPainel('versao').'&Data='.urlencode(ConfigPainel('date_update')));
		echo $Get;
	}

	function VersaoDisponivel(){
		$Get = url_get_contents('http://api.wacontrol.com.br/api/LastVersion.php');
		echo $Get;
	}

	if (isset($_GET['Download']) && !empty($_GET['Download'])) {
		$download = filter_input(INPUT_GET, "Download", FILTER_SANITIZE_STRING);
		DownloadRemoteFile("api.wacontrol.com.br/api/AutoUpdate/patch/{$download}", $download);

		$zip = new ZipArchive;
        if ($zip->open("{$download}") === TRUE) {
            $zip->extractTo('./');
			$zip->close();
			@unlink("{$download}");
			echo '<script>InstalarPatch();</script>';
        } else {
            Redireciona('?ErroAoInstalar');
        }
	}

	function backupSystem(){
		$folder = "backup/";
		$archive_name = "backup_".date('d-m-Y_').ConfigPainel('versao').".sql";
		$archive = $folder . '/' . $archive_name;
		$open = fopen("{$archive}", "w");

		$db = DB_DATABASE;
		$sql1 = DBExecute("SHOW TABLES FROM {$db}");

		while ($ver = mysqli_fetch_row($sql1)) {
			$tabela = $ver[0];
			$sql2 = mysqli_query(DBConnect(), "SHOW CREATE TABLE $tabela");
			while ($ver2=mysqli_fetch_row($sql2)) {
				fwrite($open, "-- Estrutura da Tabela: '{$tabela}' -- \n");
				$pp = fwrite($open, "DROP TABLE IF EXISTS {$tabela}; \n $ver2[1]; \n\n-- Dados da Tabela '$tabela' --\n");
				$sql3 = mysqli_query(DBConnect(),"SELECT * FROM $tabela");

				while($ver3 = mysqli_fetch_row($sql3)) {
					$ver3 = str_replace("'", "\`", $ver3);
					$grava = "INSERT INTO {$tabela} VALUES ('";
					$grava .= implode("', '", $ver3);
					$grava .= "');\n";
					fwrite($open, $grava);
				}

				fwrite($open, "\n\n");
			}
		}

		if(file_exists($archive)){
			return true;
		} else {
			return false;
		}
	}

	if (isset($_GET['InstalarPatch'])) {
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
    	if (file_exists('backup/')) {
    		backupSystem();
    	} else {
    		mkdir('backup/');
    	}
    	ImportaDB('database.sql', DBConnect());
    	@unlink('database.sql');
	}
?>