<?php
header('Access-Control-Allow-Origin: *');
require_once('../../database/config.database.php');
require_once('../../database/config.php');
require_once('../../includes/funcoes.php');
$id 	= get('id');
$url 	= explode('_url_', $id);
$Query 	= DBRead('agenda','*',"WHERE id = '{$id}'"); if (is_array($Query)) { foreach ($Query as $agenda) {
	$QueryCat 	= DBRead('c_agenda','*',"WHERE id = '{$agenda['id_categoria']}'"); if (is_array($QueryCat)) { foreach ($QueryCat as $c_agenda) {
		
	}}
}}
?>
<meta property="og:title"              content="<?php echo strip_tags($agenda['titulo']); ?>" />
<meta property="og:image"              content="<?php echo ConfigPainel('base_url'); ?>/wa/agenda/uploads/<?php echo $agenda['imagem']; ?>" />
<meta property="og:description"		   content="<?php echo strip_tags($agenda['conteudo']); ?>">
<?php
	Redireciona($c_agenda['url']);
?>