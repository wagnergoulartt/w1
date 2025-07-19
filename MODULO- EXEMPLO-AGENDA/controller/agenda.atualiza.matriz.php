<?php
	set_time_limit(0);
    require_once ('../database/config.php');
    require_once ('../database/config.database.php');
    require_once ('../database/upload.class.php');
    require_once ('../includes/funcoes.php');
    $id = get('id');
    $QueryCategoria = DBRead('c_agenda','*',"WHERE id = '{$id}'");
    $Conteudo = file_get_contents($QueryCategoria[0]['matriz']);
    $Query 	= DBRead('agenda','*',"WHERE id_categoria = '{$id}'");
    if (is_array($Query)) { foreach ($Query as $agenda) {

    	$ConteudoPost = str_replace("<img alt='' src='", "<img alt='' class='img-responsive' src='", $agenda['conteudo']);
    	$ConteudoPost = str_replace("<img src='", "<img class='img-responsive' src='", $ConteudoPost);
    	
	    // Prepara as saidas
	    $autor = $agenda['autor'];
	    $DadosAutor = DBRead('usuarios','*',"WHERE id = '{$autor}'");
	    $Subistituicao = str_replace('[WAC_AGENDA_TITULO]', ''.$agenda['titulo'].'', $Conteudo);
	    $Subistituicao = str_replace('[WAC_AGENDA_CONTEUDO]', '<style>img{max-width: 100%; height: auto;}</style>'.$ConteudoPost.'', $Subistituicao);
	    $Subistituicao = str_replace('[WAC_AGENDA_URL]', ''.ConfigPainel('site_url').'/'.$agenda['url'].'-'.$agenda['id'].'.html', $Subistituicao);
	    $Subistituicao = str_replace('[WAC_AGENDA_RESUMO]', ''.$agenda['resumo'].'', $Subistituicao);
	    $Subistituicao = str_replace('[WAC_AGENDA_DATA_INICIO]', ''.date('d/m/Y', strtotime($agenda['dataI'])).'', $Subistituicao);
	    $Subistituicao = str_replace('[WAC_AGENDA_DATA_TERMINO]', ''.date('d/m/Y', strtotime($agenda['dataT'])).'', $Subistituicao);
	    $Subistituicao = str_replace('[WAC_AGENDA_HORA_INICIO]', ''.date('H:i', strtotime($agenda['horaI'])), $Subistituicao);
	    $Subistituicao = str_replace('[WAC_AGENDA_HORA_TERMINO]', ''.date('H:i', strtotime($agenda['horaT'])), $Subistituicao);
	    $Subistituicao = str_replace('https:'.RemoveHttpS($QueryCategoria[0]['matriz']).'', ''.ConfigPainel('site_url').$agenda['url'].'-'.$agenda['id'].'.html', $Subistituicao);
	    $Subistituicao = str_replace('http:'.RemoveHttpS($QueryCategoria[0]['matriz']).'', ''.ConfigPainel('site_url').$agenda['url'].'-'.$agenda['id'].'.html', $Subistituicao);
	    
	    $id = $agenda['id'];
	    if (!empty($agenda['imagem'])) {
	    	$Subistituicao = str_replace('[WAC_AGENDA_IMAGEM]', '<img class="img-responsive" src="'.ConfigPainel('base_url').'/wa/agenda/uploads/'.$agenda['imagem'].'" />', $Subistituicao);
	    	$Subistituicao = str_replace('[WAC_AGENDA_IMAGEM_URL]', ''.ConfigPainel('base_url').'/wa/agenda/uploads/'.$agenda['imagem'].'', $Subistituicao);

	    	$Subistituicao = str_replace('[WAC_AGENDA_IMAGEM_650]', '<div style="height: 650px; overflow: hidden;display: flex; display: -webkit-flex; justify-content: center; align-items: center;"> <img class="img-responsive" src="'.ConfigPainel('base_url').'/wa/agenda/uploads/'.$agenda['imagem'].'" /></div>', $Subistituicao);
	    	$Subistituicao = str_replace('[WAC_AGENDA_IMAGEM_450]', '<div style="height: 450px; overflow: hidden;display: flex; display: -webkit-flex; justify-content: center; align-items: center;"> <img class="img-responsive" src="'.ConfigPainel('base_url').'/wa/agenda/uploads/'.$agenda['imagem'].'" /></div>', $Subistituicao);
	    	$Subistituicao = str_replace('[WAC_AGENDA_IMAGEM_250]', '<div style="height: 250px; overflow: hidden;display: flex; display: -webkit-flex; justify-content: center; align-items: center;"> <img class="img-responsive" src="'.ConfigPainel('base_url').'/wa/agenda/uploads/'.$agenda['imagem'].'" /> </div>', $Subistituicao);
	    } else {
	    	$Subistituicao = str_replace('[WAC_AGENDA_IMAGEM]', '<img class="img-responsive" src="'.ConfigPainel('base_url').'/wa/noimg.png" />', $Subistituicao);
	    	$Subistituicao = str_replace('[WAC_AGENDA_IMAGEM_URL]', ''.ConfigPainel('base_url').'/wa/noimg.png', $Subistituicao);
	    }
	    $Subistituicao = str_replace('[WAC_AGENDA_CATEGORIA]', ''.$QueryCategoria[0]['categoria'].'', $Subistituicao);

	    $Subistituicao = str_replace('[WAC_AGENDA_COMPARTILHAR]', '<div class="sharethis-inline-share-buttons"></div><script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=59ef9f0acc58690012e4b693&product=custom-share-buttons"></script>', $Subistituicao);

	    $caminho = explode('/',ConfigPainel('site_url'));
	    if($caminho[3]){
			@unlink("../../".$caminho[3].'/'.$agenda['url'].'-'.$agenda['id'].".html");
			$AbreArquivo = fopen("../../".$caminho[3].'/'.$agenda['url'].'-'.$agenda['id'].".html", "a");
			$GeraNovo = fwrite($AbreArquivo, ''.$Subistituicao.'');
			fclose($AbreArquivo);
		} else {
			@unlink("../../".$agenda['url'].'-'.$agenda['id'].".html");
			$AbreArquivo = fopen("../../".$agenda['url'].'-'.$agenda['id'].".html", "a");
			$GeraNovo = fwrite($AbreArquivo, ''.$Subistituicao.'');
			fclose($AbreArquivo);
		}
	}}
?>