<?php
	set_time_limit(0);
    require_once ('../database/config.php');
    require_once ('../database/config.database.php');
    require_once ('../database/upload.class.php');
    require_once ('../includes/funcoes.php');

// Ordenar
	if(isset($_GET['ordenar'])) {
		print_r($_POST);
		$idArray = explode(",", $_POST['ids']); 
		$count = 1; 
		foreach ($idArray as $id){ 
			$Atualizar = array('ordem' => $count);
			$Query = DBUpdate('galeria_imagem', $Atualizar, "imagem_id = '{$id}'");
            $count ++;     
        }
	}