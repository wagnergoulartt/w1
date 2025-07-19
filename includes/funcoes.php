<?php
// URL Amigavel
    function UrlAmigavel($str){
        $str = strtolower(utf8_decode($str)); $i=1;
        $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
        $str = preg_replace("/([^a-z0-9])/",'-',utf8_encode($str));
        while($i>0) $str = str_replace('--','-',$str,$i);
        if (substr($str, -1) == '-') $str = substr($str, 0, -1);
        return $str;
    }

// SQL Injection
    function antiInject($tmp_mix){
        if(is_array($tmp_mix)){
            foreach($tmp_mix as $k => $v){
                $tmp_mix[$k] = antiInject($v);
            }
            return $tmp_mix;
        } else {
            $tmp_mix = preg_replace(mb_sql_regcase("/(%0a|%0d|Content-Type:|bcc:| to:|cc:|Autoreply:|insert |delete |where|drop table|show tables|--|\\\\)/"), "", $tmp_mix);
            $tmp_mix = preg_replace("/<script.*?\/script>/s", "", $tmp_mix);
            $tmp_mix = str_replace('"',"'",$tmp_mix);
            $tmp_mix = trim($tmp_mix);
            $search = array('--','--','CDATA','<![CDATA[');
            $replace = '';
            $tmp_mix = str_ireplace($search,$replace,$tmp_mix);
            return $tmp_mix;
        }
    }

    function mb_sql_regcase($tmp_string,$tmp_encoding = 'utf-8'){
        $max = mb_strlen($tmp_string,$tmp_encoding);
        $tmp_return = '';
        for($i=0;$i<$max;$i++){
            $char = mb_substr($tmp_string,$i,1,$tmp_encoding);
            $up = mb_strtoupper($char,$tmp_encoding);
            $low = mb_strtolower($char,$tmp_encoding);
            $tmp_return .= ($up!=$low)?'['.$up.$low.']' : $char;
        }
        return $tmp_return;
    }

    function get($tmp_index,$useAntiInjection = true){
        return (isset($_GET[$tmp_index]))?(($useAntiInjection)?antiInject($_GET[$tmp_index]):$_GET[$tmp_index]):'';
    }

    function post($tmp_index,$useAntiInjection = true){
        return (isset($_POST[$tmp_index]))?(($useAntiInjection)?antiInject($_POST[$tmp_index]):$_POST[$tmp_index]):'';
    }

// Seleciona o option
    function Selected($query, $value = null){
        if ($query == $value) { echo "selected"; }
    }

// Cria tooltip
    function Tooltip($txttooltip, $position){
        echo "data-tooltip='tooltip' data-placement='$position' title='$txttooltip'";
    }

// Ativa menu
    function AtivaMenu($menulink){
        $url = $_SERVER['REQUEST_URI'];
        if(strpos($url, $menulink) == true)  echo 'class="active"';
    }
    function AtivaSubMenu($menulink){
        $url = $_SERVER['REQUEST_URI'];
        if(strpos($url, $menulink) == true)  echo ' active';
    }

// Abrir Mensagem de Alerta
    function AbreAlerta($mensagem){
        echo "<script>alert('$mensagem')</script>";
    }

// Sweet Alert
    function Sweet($Titulo, $Texto, $Tipo, $Button = '', $Link = ''){
        if($Button != '' && $Link != ''){
           echo "
           <script>
            swal({
                title:'".$Titulo."',
                text:'".$Texto."',
                type:'".$Tipo."',
                button:'".$Button."'
            }).then((value) => {
                window.location.href = '".$Link."';
            });
            </script>";  
        } else {
           echo "
           <script>
            swal({
                title:'".$Titulo."',
                text:'".$Texto."',
                type:'".$Tipo."',
                buttons: {confirm: {text: 'Ok', className: 'btn-primary'}}
            });
            </script>";   
        }

    }

// Pegar Avatar do Usuario
    function getAvatar($id){
        $Query = DBRead('usuarios', '*', "WHERE id = '{$id}' LIMIT 1");
        if (is_array($Query)) { 
            foreach ($Query as $usuario) {
                return $usuario['avatar'];
            }
        }

        return '';
    }

// Abre AlertaBootstrap
    function AbreAlertaBoot($class, $msg){
        echo "<div class='col-md-12'><div class='box-header' style='border-bottom: 0px solid #f4f4f4;'><div class='alert alert-$class' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <center>$msg</center>
        </div></div></div>";
    }

// Limita Quantidade de Caracteres
    function LimitarTexto($texto, $limite, $final = null, $quebra = false){
       $tamanho = strlen($texto);
       if($tamanho <= $limite){
          $texto;
       } else {
          if($quebra == true){
             $texto = trim(substr($texto, 0, $limite))."...";
          } else {
             $ultimo_espaco = strrpos(substr($texto, 0, $limite), " ");
             $texto = trim(substr($texto, 0, $ultimo_espaco))."...";
          }
       }
       return $texto;
    }

// Apaga Diretório
    function ExcluiDir($Dir){
        if ($dd = opendir($Dir)) {
            while (false !== ($Arq = readdir($dd))) {
                if($Arq != "." && $Arq != ".."){
                    $Path = "$Dir/$Arq";
                    if(is_dir($Path)){
                        ExcluiDir($Path);
                    } elseif(is_file($Path)) {
                        unlink($Path);
                    }
                }
            }
                closedir($dd);
            }
            rmdir($Dir);
    }

// Redireciona com Javascript
    function Redireciona($arquivo){
        echo "<script> window.location = '$arquivo'; </script>";
        return false;
    }

// Pega o Titulo do Módulo
    function PegaTituloModulo($url){
        $query = mysql_query("SELECT nome FROM modulos WHERE url = '{$url}'"); $modulos = mysql_fetch_assoc($query);
        echo $modulos['nome'];
    }

// Mostrar Erro
    function MostraErro(){
        $query = mysql_query("SELECT erro FROM config"); $config = mysql_fetch_assoc($query);
        if ($config['erro'] != "S") {
            return ini_set('display_errors', 0);
        }
    }

// Verifica se tem categoria cadastrada
    function VerificaCategoria($tabela){
        $Query = DBCount("{$tabela}",'id','WHERE id > 0');
        if (!$Query >= 1) {
            AbreAlerta('Nenhuma categoria foi criada, por favor adicione uma nova categoria.');
            Redireciona('?AdicionarCategoria');
        }
    }

// Url do Painel Admin
    function UrlSite(){
        $query = mysql_query("SELECT base_url FROM config"); $config = mysql_fetch_assoc($query);
        return $config['base_url'];
    }

// Paginação dos Módulos Lógica
    function QueryPaginacao($cmd, $p){
        $pag = (isset($_GET['pag']))? $_GET['pag'] : 1;
        $query = mysql_query($cmd);
        $total = mysql_num_rows($query);
        $registros = $p;
        $numPaginas = ceil($total/$registros);
        $inicio = ($registros*$pag)-$registros;
        $cmd = "".$cmd." LIMIT $inicio, $registros";
        $query = mysql_query($cmd);
        $total = mysql_num_rows($query);

        $Dados = array(
            'query'         => $query, 
            'numPaginas'    => $numPaginas
        );

        return $Dados;
    }

// Paginação dos Módulos HTML
    function PaginacaoHMTL($Arquivo, $numPaginas, $GetPag, $PaginacaoJS){
        $HTML  =    "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">";
        $HTML .=    "<center>";
        $HTML .=    "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
                    if (isset($_GET['pag'])) { $i = $_GET['pag']; } else { $i = 1; }
                    if ($i <= '1') {
        $HTML .=     "<button type=\"hidden\" class=\"btn btn-default btn-sm hidden\" disabled>Anterior</button>";
                    } elseif ($i >= '2') { $i = $i - '1';
        $HTML .=    "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"".$PaginacaoJS."('$Arquivo','$i')\">Anterior</button>";
                    }
                    if (isset($_GET['pag'])) { $i = $_GET['pag']; } else { $i = '1'; }
                    if ($numPaginas >= '1' && $numPaginas < '9') { $numPaginas = '0'.$numPaginas; } elseif ($numPaginas > '9') { $numPaginas = $numPaginas; }
                    if ($i >= '1' && $i <= '9') {
        $HTML .=    "<button type=\"button\" class=\"btn btn-default btn-sm\" disabled>Página 0".$i." de ".$numPaginas."</button>";
                    } elseif ($i > '9') {
        $HTML .=    "<button type=\"button\" class=\"btn btn-default btn-sm\" disabled>Página ".$i." de ".$numPaginas."</button>";
                    }

                    if (isset($_GET['pag'])) { $i = $_GET['pag']; } else { $i = '1'; }
                    if ($i >= 1 && $i < $numPaginas) { $i++;
        $HTML .=    "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"".$PaginacaoJS."('$Arquivo','$i')\">Próximo</button>";
                    } elseif ($i == $numPaginas) {
        $HTML .=    "<button type=\"button\" class=\"btn btn-default btn-sm hidden\" disabled>Próximo</button>";
                    }
        $HTML .=    "</div>";
        $HTML .=    "</center>";
        $HTML .=    "<br>";
        $HTML .=    "</div>";

        return $HTML;
    }
// Dados do Painel
    function ConfigPainel($Item){
        $Query = DBRead('config','*'); foreach ($Query as $Config) {
            return $Config["{$Item}"];
        }
    }

// Dados Session
    function DadosSession($Item){
        return $_SESSION['node']["{$Item}"];
    }

// Define a Linguagem do Painel
    function DefineLang($arquivo){
        $Idioma = ConfigPainel('idioma');
        $diretorio_idioma = 'lang/'.$Idioma.'/'.$arquivo.'';
        if (file_exists($diretorio_idioma)) {
            return $diretorio_idioma;
        } else {
            echo "<meta charset='utf-8'>";
            AbreAlerta('Atenção!!!\nO Arquivo de Tradução Não foi Encontrado!\nPor favor verifique novamente qual idioma você escolheu e se o pacote está instalado na pasta lang!');
            error_reporting(0);
            ini_set("display_errors", 0 );
        }
    }

// Verifica se o usuário tem permissão para acessar o módulo
    function VerificaPermissao($URL){
        $IDUsuario = DadosSession('id');

        $Query = DBRead('usuarios','permissao',"WHERE id = '{$IDUsuario}'"); if (is_array($Query)) { foreach ($Query as $usuarios) {
            $ModulosPermitidos = $usuarios['permissao'];
            if (empty($ModulosPermitidos)) {
                return true;
            } elseif (!empty($ModulosPermitidos)) {
                if (strpos($ModulosPermitidos, $URL) !== false) {
                    return true;
                } else {
                    return false;
                }
            }
        }}
    }

// Retorna o nome do autor
    function getAutor($id){
        $Query = DBRead('usuarios','nome',"WHERE id = '{$id}'");
        if (is_array($Query)) {
            foreach ($Query as $usuarios) {
                return $usuarios['nome'];
            }
        }

        return 'admin';
    }

// Retorna a quantidade de comentários do blog
    function getComentarios($id){
        $Query = DBRead('comentario','*',"WHERE blog_id = '{$id}'");
        if (is_array($Query)) {
            return $Query;
        }

        return ''; 
    }

// Retorna o ID do blog de um comentário
    function getBlogComentario($id){
        $Query = DBRead('comentario','*',"WHERE id = '{$id}'");
        if (is_array($Query)) {
            $ids = $Query[0]['blog_id'];
            $q = DBRead('blog','*',"WHERE id = '{$ids}'");
            if(is_array($q)){
                return $q[0]['id_categoria'];
            }
        }

        return ''; 
    }

// Retorna os comentários a serem aprovados
    function getAllComentarios(){
        $Query = DBRead('comentario','*',"WHERE ativo = 0");
        if (is_array($Query)) {
            return $Query;
        }
    }  


// Modo de Manutenção
    function ModoManutencao(){
        $Query = DBRead('config','manutencao'); if (is_array($Query)){
            foreach ($Query as $config) {
                if ($config['manutencao'] == 'S') {
                    $Result = true;
                } elseif ($config['manutencao']) {
                    $Result = false;
                }
            }

            return $Result;
        }
    }

// Status
    function Status($Status){
        if ($Status == 1) {
            echo '<span class="label label-info">Ativo</span>';
        } elseif ($Status == 2) {
            echo '<span class="label label-danger">Inativo</span>';
        }
    }

// Categoria do Item
    function VerificaCategoriaItem($Item, $Tabela){
        $Query = DBRead("{$Tabela}",'categoria',"WHERE id = '{$Item}'"); if (is_array($Query)) { foreach ($Query as $categoria) {
            echo $categoria['categoria'];
        } }
    }

// Gera Iframe
    function GeraIframe($Id, $CodWA){
        echo "<iframe id='iFrameNoticiasIntegrado".$Id."' width='100%' height='100%' scrolling='auto' frameborder='0' src='".$CodWA."' allowfullscreen></iframe>";
    }

// Encurtar URL
    function EncurtarUrl($url){

        /*
        $file = url_get_contents("http://migre.me/api.json?url=$url");
        $file = json_decode($file);

        return $file->migre;
        */
        return $url;

    }
// Desencurtar URL
    function DesencurtarURL($url){

        /*
        $file = urlencode($url);

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, "http://migre.me/api_redirect2.xml?url=$url");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);

        $file = simplexml_load_string($data);
        return $file->url;
        */
        return $url;
    }
// Pega os Dados do Módulo
    function DadosMod($Item = null){
        if ($Item != null) {
            $UrlMod = $_SERVER['PHP_SELF'];
            $UrlMod = explode('/', $UrlMod);
            $UrlMod = end($UrlMod);

            $Query = DBRead('modulos','*',"WHERE url = '{$UrlMod}'"); foreach ($Query as $Dados) {
                return $Dados["{$Item}"];
            }
        }
    }

//Pega Dados da URL
function url_get_contents($Url)
{

    if (function_exists('curl_version')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    } else {
        $output = file_get_contents($Url, true);
        return $output;
    }
}

//Remove HTTP e HTTPS
    function RemoveHttpS($Link){
        $disallowed = array('http://', 'https://');
        foreach($disallowed as $d) {
            if(strpos($Link, $d) === 0) {
                $Link = str_replace($d, '', $Link);
            }
        }
       return '//'.$Link;
    }
//GeraPaginaçãoAjax
    function GeraPaginacaoAjax($Arquivo){
        echo '<script type="text/javascript">
            $(function () {
              $("#DataTableAjax").DataTable({
                "pageLength": '.ConfigPainel('paginacao').',
                "processing": true,
                "serverSide": true,
                "ajax": "controller/'.$Arquivo.'",
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "aLengthMenu": [ [5, 10, 15, 20, 25, 30, 35, -1], [5, 10, 15, 20, 25, 30, 35, "Todos"] ],
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "Mostrar _MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
              });
            });
        </script>';
    }

    function PermissionUser($page, $action = null){
        global $PERMISSION;
        $ArrayPermission = $PERMISSION;
        if (array_key_exists($page, $ArrayPermission)) {
            if ($ArrayPermission[$page] == null) {
                return false;
            } else {
                if ($action <> null) {
                    $ArrayPermission = explode(',', $ArrayPermission[$page]);
                    if (in_array($action, $ArrayPermission)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    function GetPermissionsUser(){
        if (DadosSession('id')) {
            global $database;
            $id = DadosSession('id');
            $Query = DBRead('usuarios','*',"WHERE id = {$id}")[0];
            $permission = $Query['permissao'];
            $QueryPermission = DBRead('permissions_groups','*',"WHERE id = '{$permission}'")[0];
            return $QueryPermission['params'];
        }
    }

    function getModules($level){
        global $database;
        if (is_numeric($level)) {
            return $database->fetchAll("SELECT * FROM modulos WHERE level = '{$level}' ORDER BY id ASC");
        } else {
            return $database->fetchRow("SELECT * FROM modulos WHERE name = '{$level}' ORDER BY id ASC");
        }
    }

    function getViewUser($permission){
        if ($permission <> 'vall') {
            return DadosSession('id');
        } else {
            return false;
        }
    }

    function checkPermission($permissoes, $modulo, $key = null, $value = null){
        if(strstr($modulo, "/")){
            $modulo = explode('/', $modulo);
            $modulo = end($modulo);
        }
        
        $modulo = str_replace(['/', '.php'], ['', ''], $modulo);

        if (!is_array($permissoes)) {
            $permissoes = json_decode($permissoes, JSON_UNESCAPED_UNICODE);
        }

        if (array_key_exists($modulo, $permissoes)) {
            if (!empty($key) && $key <> null) {
                if (array_key_exists("{$key}", $permissoes[$modulo])) {
                    if ($value) {
                        if (in_array($value, $permissoes[$modulo]["{$key}"])) {
                            return true;
                        }
                    } else {
                        return true;
                    }
                }
            } else {
                return true;
            }
        } else {
            return false;
        }

    }
?>