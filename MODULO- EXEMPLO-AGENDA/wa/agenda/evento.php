<?php
    header('Access-Control-Allow-Origin: *');
    require_once('../../includes/funcoes.php');
    require_once('../../database/config.database.php');
    require_once('../../database/config.php');
    $id = get('id');
    $categoria = get('categoria');
    $back      = get('back');
    $Query = DBRead('c_agenda','*',"WHERE id = '{$categoria}'");
    if (is_array($Query)) { foreach ($Query as $c_dados) {
        $TituloCategoria    = $c_dados['categoria'];
        $ColunasCategoria   = $c_dados['colunas'];
        $Cor_Titulo         = $c_dados['cor_titulo'];
        $Cor_Conteudo       = $c_dados['cor_conteudo'];
        $Cor_DiaMes         = $c_dados['cor_dia_mes'];
        $Cor_Informacoes    = $c_dados['cor_informacoes'];
        $Cor_Background1    = $c_dados['cor_background1'];
        $Cor_Background2    = $c_dados['cor_background2'];
        $MostrarDetalhes    = $c_dados['mostrar_detalhes'];
        $p                  = $c_dados['paginacao'];
        $OrdenarPor         = $c_dados['ordenar_por'];
        $AscDesc            = $c_dados['asc_desc'];
        $ManterEventos      = $c_dados['manter_eventos'];
        $Modal              = $c_dados['modal'];
    } }
    $Query = DBRead('agenda','*',"WHERE id = '{$id}'");
    function MesExtenso($Mes){
        switch ($Mes) {
            case '01':
             return 'JANEIRO';
            break;
            case '02':
             return 'FEVEREIRO';
            break;
            case '03':
             return 'MARÇO';
            break;
            case '04':
             return 'ABRIL';
            break;
            case '05':
             return 'MAIO';
            break;
            case '06':
             return 'JUNHO';
            break;
            case '07':
             return 'JULHO';
            break;
            case '08':
             return 'AGOSTO';
            break;
            case '09':
             return 'SETEMBRO';
            break;
            case '10':
             return 'OUTUBRO';
            break;
            case '11':
             return 'NOVEMBRO';
            break;
            case '12':
             return 'DEZEMBRO';
            break;
        }
    }
?>
<style>
    .fancybox-inner{overflow-x:hidden !important;}
</style>
<style>#conteudo img{max-width: 100%; margin:5px;}</style>
<div class="row" style="padding:15px;">
    <?php if (is_array($Query)) { foreach ($Query as $dados) { ?>
    <?php
        $Data = $dados['data'];
        $Data = explode('-',$Data);
        $Hora = $dados['hora'];
        $Hora = explode(":", $Hora);
    ?>
    <?php if ($Modal == "N") { ?>
    <div class="col-md-12" style="z-index:99999;">
        <div class="pull-right">
            <button class="btn btn-xs btn-default" onclick="AgendaEventos(<?php echo get('categoria'); ?>, <?php echo $back; ?>);"><i class='fa fa-chevron-left'></i> Voltar</button>
        </div>
    </div>
    <?php } ?>
    
    <?php if (empty($dados['imagem'])) { ?>
        <div class="col-md-12">
            <h4 style="color:<?php echo $Cor_Titulo; ?>;"><b><?php echo $dados['titulo']; ?></b></h4>
            <p style="color:<?php echo $Cor_Conteudo; ?>;">
                Dia <?php echo $Data[2]; ?> de <?php echo MesExtenso($Data[1]); ?> de <?php echo $Data[0]; ?> às <?php echo $Hora[0].':'.$Hora[1]; ?><br>
                Local <?php echo $dados['local']; ?>
            </p>
            <hr>
            <p style="color:<?php echo $Cor_Conteudo; ?>;">
                <?php echo $dados['conteudo']; ?>
            </p>
        </div>
    <?php } else { ?>
    <div class="col-md-3">
        <img class="img-responsive" src="<?php echo ConfigPainel('base_url'); ?>/wa/agenda/uploads/<?php echo $dados['imagem']; ?>">
    </div>
    <div class="col-md-9" id="conteudo">
        <h4 style="color:<?php echo $Cor_Titulo; ?>;"><b><?php echo $dados['titulo']; ?></b></h4>
        <p style="color:<?php echo $Cor_Conteudo; ?>;">
            Dia <?php echo $Data[2]; ?> de <?php echo MesExtenso($Data[1]); ?> de <?php echo $Data[0]; ?> às <?php echo $Hora[0].':'.$Hora[1]; ?><br>
            Local <?php echo $dados['local']; ?>
        </p>
        <hr>
        <p>
            <?php echo $dados['conteudo']; ?>
        </p>

        <hr>
    <label style="color: <?php echo $Cor_Titulo; ?>;">Compartilhe:</label>
    <a class="btn btn-primary btn-xs" style="text-decoration:none; background-color:#3b5998; border:0px;" href="javascript:void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u=<?php echo ConfigPainel('base_url'); ?>/wa/agenda/share.php?id=<?php echo $id; ?>_url_<?php echo EncurtarUrl($c_dados['url']); ?>','Compartilhar', 'toolbar=0, status=0, width=650, height=450');">
        <i class="fa fa-facebook"></i> Facebook
    </a>
    <a class="btn btn-primary btn-xs" style="text-decoration:none; background-color:#00aced; border:0px;" href="javascript:void(0);" onclick="window.open('https://twitter.com/home?status=<?php echo $dados['titulo']; ?> <?php echo EncurtarUrl($c_dados['url']); ?>','Compartilhar', 'toolbar=0, status=0, width=650, height=450');">
        <i class="fa fa-twitter"></i> Twitter
    </a>
    <a class="btn btn-primary btn-xs  hidden-md hidden-sm hidden-lg whatsapp" data-text="<?php echo $dados['titulo']; ?>" data-link="<?php echo $c_dados['url']; ?>" style="text-decoration:none;background-color:#20a114; border:0px;">
        <i class="fa fa-whatsapp"></i> Whatsapp
    </a>
    </div>
    <?php } ?>
    <?php } } ?>
</div>
