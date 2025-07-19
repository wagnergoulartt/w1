<?php
    header('Access-Control-Allow-Origin: *');
    require_once('../../includes/funcoes.php');
    require_once('../../database/config.database.php');
    require_once('../../database/config.php');
    $categoria = get('id');
    $id = get('id');
    $pag = (isset($_GET['pag']))? $_GET['pag'] : 1;
    $Query = DBRead('c_agenda','*',"WHERE id = '{$categoria}'");
    if (is_array($Query)) { foreach ($Query as $c_agenda) {
        $categoria = $c_agenda['id'];
        $nomeCategoria = $c_agenda['categoria'];
        $p  = $c_agenda['paginacao'];
        $ordenar_por = $c_agenda['ordenar_por'];
        $asc_desc    = $c_agenda['asc_desc'];
        $background  = $c_agenda['background'];
        $cor_fonte   = $c_agenda['cor_fonte'];
        $cor_titulo  = $c_agenda['cor_titulo'];
        $cor_btn     = $c_agenda['cor_btn'];
        $cor_txt_btn = $c_agenda['cor_txt_btn'];
        $modelo      = $c_agenda['modelo'];
        $colunas     = $c_agenda['colunas'];
        $carousel    = $c_agenda['carousel'];
        $cor_carousel = $c_agenda['cor_carousel'];
        $ativa_paginacao = $c_agenda['ativa_paginacao'];
    }}

    $data_atual = date('Y-m-d');
    $colunas = 12 / $colunas;

    if ($id != '0') {
        if($carousel == 1) {
            $QueryNum = DBCount('agenda','*',"WHERE '{$data_atual}' <= dataT AND id_categoria = '{$id}' AND status = '1' ORDER BY {$ordenar_por} {$asc_desc}");
        } else {
            $QueryNum = DBCount('agenda','*',"WHERE '{$data_atual}' <= dataT AND id_categoria = '{$id}' AND status = '1' ORDER BY {$ordenar_por} {$asc_desc}");
        }
    } else {
        if($carousel == 1) {
            $QueryNum = DBCount('agenda','*',"WHERE '{$data_atual}' <= dataT AND status = '1' ORDER BY {$ordenar_por} {$asc_desc}");
        } else {
            $QueryNum = DBCount('agenda','*',"WHERE '{$data_atual}' <= dataT AND status = '1' ORDER BY {$ordenar_por} {$asc_desc}");
        }
    }

    $pag = (isset($_GET['pag']))? $_GET['pag'] : 1;
    $registros = $p;
    $numPaginas = ceil($QueryNum/$registros);
    $inicio = ($registros*$pag)-$registros;

    if ($id != '0') {
        if($carousel == 1) {
            $Query = DBRead('agenda','*',"WHERE '{$data_atual}' <= dataT AND id_categoria = '{$id}' AND status = '1' ORDER BY {$ordenar_por} {$asc_desc}");
        } else {
            $Query = DBRead('agenda','*',"WHERE '{$data_atual}' <= dataT AND id_categoria = '{$id}' AND status = '1' ORDER BY {$ordenar_por} {$asc_desc} LIMIT {$inicio}, {$registros}");
        }
    } else {
        if($carousel == 1) {
            $Query = DBRead('agenda','*',"WHERE '{$data_atual}' <= dataT AND status = '1' ORDER BY {$ordenar_por} {$asc_desc}");
        } else {
            $Query = DBRead('agenda','*',"WHERE '{$data_atual}' <= dataT AND status = '1' ORDER BY {$ordenar_por} {$asc_desc} LIMIT {$inicio}, {$registros}");
        }
    }

    function MesExtenso($Mes){
        switch ($Mes) {
            case '01': return 'Janeiro'; break;
            case '02': return 'Fevereiro'; break;
            case '03': return 'Março'; break;
            case '04': return 'Abril'; break;
            case '05': return 'Maio'; break;
            case '06': return 'Junho'; break;
            case '07': return 'Julho'; break;
            case '08': return 'Agosto'; break;
            case '09': return 'Setembro'; break;
            case '10': return 'Outubro'; break;
            case '11': return 'Novembro'; break;
            case '12': return 'Dezembro'; break;
        }
    }

    function MesExtensoAbreviado($Mes){
        switch ($Mes) {
            case '01': return 'Jan'; break;
            case '02': return 'Fev'; break;
            case '03': return 'Mar'; break;
            case '04': return 'Abr'; break;
            case '05': return 'Mai'; break;
            case '06': return 'Jun'; break;
            case '07': return 'Jul'; break;
            case '08': return 'Ago'; break;
            case '09': return 'Set'; break;
            case '10': return 'Out'; break;
            case '11': return 'Nov'; break;
            case '12': return 'Dez'; break;
        }
    }
?>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/epack/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/epack/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/epack/css/elements/post-grid.css">
<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/epack/css/elements/animate.css">
<?php if ($modelo == 'modelo-1') { ?>
<style>
.style-two<?php echo $id; ?> {color: #ffffff;float: left;font-size: 16px;margin: 10px 1%;overflow: hidden;position: relative;text-align: left;width: 100%;}
.style-two<?php echo $id; ?> * {-webkit-box-sizing: border-box;box-sizing: border-box;-webkit-transition: all 0.25s ease;transition: all 0.25s ease;}
.style-two<?php echo $id; ?> img { max-width: 100%;vertical-align: top;position: relative;}
.style-two<?php echo $id; ?> figcaption {padding: 0px 25px 50px;position: absolute;bottom: 0;z-index: 1;width: 100%;}
.style-two<?php echo $id; ?> figcaption:before {position: absolute;top: 0;bottom: 0;left: 0;right: 0;content: '';background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,rgba(0,0,0,0)),color-stop(30%,rgba(0,0,0,.2)),color-stop(100%,rgba(0,0,0,.75)));background: -webkit-linear-gradient(top,rgba(0,0,0,0) 0%,rgba(0,0,0,.2) 30%,rgba(0,0,0,.75) 100%);background: -o-linear-gradient(top,rgba(0,0,0,0) 0%,rgba(0,0,0,.2) 30%,rgba(0,0,0,.75) 100%);background: -ms-linear-gradient(top,rgba(0,0,0,0) 0%,rgba(0,0,0,.2) 30%,rgba(0,0,0,.75) 100%);background: linear-gradient(to bottom,rgba(0,0,0,0) 0%,rgba(0,0,0,.2) 30%,rgb(0, 0, 0) 100%);pointer-events: none; backface-visibility: hidden;-webkit-backface-visibility: hidden; z-index: -1;}
.style-two<?php echo $id; ?> .date {background-color: #fff; border-radius: 50%; color: #700877; font-size: 18px; font-weight: 700; min-height: 48px; min-width: 48px; padding: 10px 0; position: absolute; right: 10px; text-align: center; text-transform: uppercase; top: 10px;}
.style-two<?php echo $id; ?> .date span { display: block;line-height: 14px;}
.style-two<?php echo $id; ?> .date .month { font-size: 11px;}
.style-two<?php echo $id; ?> h3, .style-two<?php echo $id; ?> p {margin: 0; padding: 0;}
.style-two<?php echo $id; ?> h3 {display: inline-block; font-weight: 700;letter-spacing: -0.4px; margin-bottom: 5px;font-size: 20px;}
.style-two<?php echo $id; ?> p { font-size: 0.8em;line-height: 1.6em; margin-bottom: 0px;}
.style-two<?php echo $id; ?> a { left: 0; right: 0; top: 0; bottom: 0; position: absolute; z-index: 1;}
.style-two<?php echo $id; ?>:hover img, .style-two<?php echo $id; ?>.hover img { -webkit-transform: scale(1.1); transform: scale(1.1);}
</style>
<?php } ?>
<?php if($carousel == 1) { $colunas = '12'; ?>
<style>
    <?php if($cor_carousel){echo '.owl-carousel .owl-dot, .owl-carousel .owl-nav .owl-next, .owl-carousel .owl-nav .owl-prev{color:'.$cor_carousel.'}';}?>
    .owl-nav{position: absolute; bottom: 50%;width: 100%;}
    .owl-prev{left: -20px; position: absolute; font-size: 30px; color: #fff;}
    .owl-next{right: -20px; position: absolute; font-size: 30px; color: #fff;}
  @media only screen and (max-width: 600px) {
  .owl-prev{left: 0px; position: absolute; font-size: 30px; color: #fff;}
  .owl-next{right: 0px; position: absolute; font-size: 30px; color: #fff;}
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script type="text/javascript">
$('.owl-carousel').owlCarousel({
    loop:true,
    items:4,
    margin:10,
    nav:true,
    autoplay:true,
    autoplayTimeout:2000,
    autoplayHoverPause:true,
    responsiveClass:true,
    responsive:{
      0:{
        items:1,
        nav:true
      },
      600:{
        items:3,
        nav:false
      },
      1000:{
        items:4,
        nav:true,
        loop:false
      }
    },
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
})
</script>
<?php } ?>

<div class="tc-carousel-style1 <?php if($carousel == '1') { echo 'owl-carousel'; } ?>">
<?php
if ($modelo == 'modelo-1') { if (is_array($Query)) { foreach ($Query as $blog) {
	$Data = $blog['dataI'];
	$Data = explode('-',$Data);
?>
<div class="col-md-<?php echo $colunas; ?> wow <?php echo $c_agenda['efeito']; ?>">
    <figure class="style-two<?php echo $id; ?>">
        <div class="image">
            <div class="post-thumb-overlay"></div>
            <?php if (!empty($blog['imagem'])) { ?>
            <img src="<?php echo ConfigPainel('base_url'); ?>/wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/wa/agenda/uploads/<?php echo $blog['imagem']; ?>&w=700&h=876&q=90" />
            <?php } else { ?>
            <img src="<?php echo ConfigPainel('base_url'); ?>/wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/wa/noimg.png&w=700&h=876&q=90" />
            <?php } ?>

            <div class="date" style="background-color: <?php echo $background; ?>;">
                <span class="day" style="color:#fff;"><?php echo $Data[2]; ?></span>
                <span class="month" style="color:#fff;"><?php echo MesExtensoAbreviado($Data[1]); ?></span>
            </div>
        </div>

        <figcaption>
            <span class="badge badge-primary" style="background-color: <?php echo $background; ?>;"><?php echo $nomeCategoria; ?></span><br>
            <h3 style="color:<?php echo $cor_titulo; ?>;"><?php echo LimitarTexto($blog['titulo'],'40','...'); ?></h3>
            <p style="position: absolute; width: 100%;">
                <a style="text-decoration: none;background: none; color: <?php echo $cor_btn; ?>; border: none; padding: 0; font-size: 16px; font-family: 'Roboto', sans-serif;" href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>" class="readon pill">Saiba Mais</a>
            </p>
        </figcaption>

        <a href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>"></a>
    </figure>
</div>
<?php }}} ?>
</div>
<?php
if ($modelo == 'modelo-2') { if (is_array($Query)) { echo '<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
<div class="tc-post-grid-style1">'; foreach ($Query as $blog) {
    $Data = $blog['dataI'];
    $Data = explode('-',$Data);
?>
    <div class="col-md-<?php echo $colunas; ?> owl item <?php echo $c_agenda['efeito']; ?>">
        <div class="post-grid-item">
            <div class="post-grid-img" style="height: 270px;display: flex; display: -webkit-flex; justify-content: center; align-items: center; overflow: hidden;">
                <a href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>">
                    <?php if (!empty($blog['imagem'])) { ?>
                        <img src="<?php echo ConfigPainel('base_url'); ?>/wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/wa/agenda/uploads/<?php echo $blog['imagem']; ?>&w=700&h=876&q=90" />
                    <?php } else { ?>
                        <img src="<?php echo ConfigPainel('base_url'); ?>/wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/wa/noimg.png&w=700&h=876&q=90" />
                    <?php } ?>
                </a>
            </div>

            <div class="post-grid-content" style="background-color: <?php echo $background; ?>; box-shadow: 0 5px 15px 0 rgba(0,0,0,.05); border-radius: 5px;border-top-left-radius: 0; border-top-right-radius: 0; border: none;">
                <div class="post-grid-head">
                    <ul class="post-grid-meta">
                        <li style="margin-bottom:10px; color:<?php echo $cor_fonte; ?>;font-family: 'Roboto', sans-serif; text-transform: none; font-size: 13px;"><i class="fa fa-calendar" style="color: #000; opacity: 0.5; margin-right: 5px; font-size: 20px;"></i> <?php echo $Data[2]; ?> de <?php echo MesExtenso($Data[1]); ?> de <?php echo $Data[0]; ?></li>
                        <li style="margin-bottom:10px; color:<?php echo $cor_fonte; ?>;font-family: 'Roboto', sans-serif; text-transform: none; font-size: 13px;"><i class="fa fa-folder" style="color: #000; opacity: 0.5; margin-right: 5px; font-size: 20px;"></i> <?php echo $nomeCategoria ?></li>
                    </ul>

                    <h3 class="post-grid-title" style="text-transform: none; font-size: 24px; font-weight: 700;">
                        <a style="color:<?php echo $cor_titulo; ?>;" href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>"><?php echo LimitarTexto($blog['titulo'],'40','...'); ?></a>
                    </h3>
                </div>
                
                <div class="post-grid-desc">
                    <p style="font-family: 'Roboto', sans-serif; line-height: 26px;color:<?php echo $cor_fonte; ?>;"><?php echo LimitarTexto($blog['resumo'],'90','...'); ?></p>
                </div>
                
                <div class="post-grid-footer">
                    <a style="text-decoration: none;background: none; color: <?php echo $cor_btn; ?>; border: none; padding: 0; font-size: 16px; font-weight: 700; font-family: 'Roboto', sans-serif;" href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>" class="readon pill">Continue Lendo</a>
                </div>
            </div>
        </div>
    </div>
    <?php } echo '</div>'; } } ?>

    <?php
        if ($modelo == 'modelo-3') { if (is_array($Query)) { echo '<link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet"><div class="tc-post-grid-style2">'; foreach ($Query as $blog) {
    	$Data = $blog['dataI'];
    	$Data = explode('-',$Data);
    ?>

    <div class="col-md-<?php echo $colunas; ?> item wow <?php echo $c_agenda['efeito']; ?>">
        <div class="post-grid-item">
            <div class="post-grid-img" style="height: 270px;display: flex; display: -webkit-flex; justify-content: center; align-items: center; overflow: hidden;">
                <a href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>">
                    <?php if (!empty($blog['imagem'])) { ?>
                        <img src="<?php echo ConfigPainel('base_url'); ?>/wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/wa/agenda/uploads/<?php echo $blog['imagem']; ?>&w=700&h=876&q=90" />
                    <?php } else { ?>
                        <img src="<?php echo ConfigPainel('base_url'); ?>/wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/wa/noimg.png&w=700&h=876&q=90" />
                    <?php } ?>
                </a>
            </div>

            <div class="post-grid-content" style="background-color:#fff; border: none; position: relative; padding: 0">
            	<div style="width: 100%;position: absolute; top: -70px; ">
                    <div style="background: <?php echo $background; ?>; width: 80px; height: 80px; text-align: center; vertical-align: middle; line-height: 23px; padding: 10px; border-radius: 50%; color: #fff; font-weight: bold; margin: 0 auto; border: 5px solid #fff; left: 35%; font-size: 23px;font-family: 'Roboto', sans-serif;"><?php echo $Data[2]; ?><span style="display: block; text-transform: uppercase; font-size: 15px;display: block;"><?php echo MesExtensoAbreviado($Data[1]); ?></span></div>
                </div>

                <div class="post-grid-head" style="margin-top: 30px; padding: 10px;">
                    <span class="badge badge-primary" style="background-color: <?php echo $background; ?>;"><?php echo $nomeCategoria; ?></span><br>
                    <h3 class="post-grid-title">
                        <a style="display: block; margin-top: 20px; text-align: center; font-weight: bold;color:<?php echo $cor_titulo; ?>;" href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>"><?php echo LimitarTexto($blog['titulo'],'40','...'); ?></a>
                    </h3>
                </div>
                
                <div class="post-grid-desc" style="padding: 10px;">
                    <p style="text-align: center; font-size: 15px;color:<?php echo $cor_fonte; ?>;"><?php echo LimitarTexto($blog['resumo'],'150','...'); ?></p>
                </div>
                
                <div class="post-grid-footer" style="padding: 10px;">
                    <a style="text-decoration: none; color: <?php echo $cor_btn; ?>; font-size: 14px; font-weight: bold; text-transform: uppercase; border: 2px solid <?php echo $cor_btn; ?>; padding: 8px; border-radius: 5px; float: none; display: block; text-align: center; margin: 20px;" href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>" class="readon pill">Saiba Mais</a>
                </div>
            </div>
        </div>
    </div>
    <?php } echo '</div>'; } } ?>

    <?php
        if ($modelo == 'modelo-4') { if (is_array($Query)) { echo '<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
<div class="tc-post-grid-style3">'; foreach ($Query as $blog) {
        $Data = $blog['dataI'];
        $Data = explode('-',$Data);
    ?>

    <div class="col-md-12 wow <?php echo $c_agenda['efeito']; ?>">
        <div class="post-grid-item" style="border-radius: 10px; overflow: hidden; box-shadow: 0 1px 5px rgba(0, 0, 0, 0.25);">
            <div class="row">
                <div class="col-md-3" style="padding: 0;">
                    <div class="post-grid-img" style="height: 270px; overflow: hidden;margin: 0;">
                        <a href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>">
                            <?php if (!empty($blog['imagem'])) { ?>
                                <img src="<?php echo ConfigPainel('base_url'); ?>/wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/wa/agenda/uploads/<?php echo $blog['imagem']; ?>&w=700&h=876&q=90" />
                            <?php } else { ?>
                                <img src="<?php echo ConfigPainel('base_url'); ?>/wa/thumb.php?src=<?php echo ConfigPainel('base_url'); ?>/wa/noimg.png&w=700&h=876&q=90" />
                            <?php } ?>
                        </a>
                        <div class="post-date" style="font-family: 'Montserrat', sans-serif; font-weight: bold; font-size: 14px; text-transform: uppercase;">
                            <?php echo $Data[2]; ?> de <?php echo MesExtenso($Data[1]); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-9" style="padding: 0;">
                    <div class="post-grid-content" style="margin: 0;height: 270px;background-color: <?php echo $background; ?>; border-color: <?php echo $background; ?>">
                        <div class="post-grid-head">
                            <span class="badge badge-primary" style="background-color: <?php echo $background; ?>;"><?php echo $nomeCategoria; ?></span><br>
                            <h3 class="post-grid-title">
                                <a style="color:<?php echo $cor_titulo; ?>;font-weight: bold; font-family: 'Montserrat', sans-serif; font-size: 24px; text-decoration: none;" href="<?php echo ConfigPainel('site_url').'/'.$blog['url'].'-'.$blog['id'].'.html'; ?>"><?php echo LimitarTexto($blog['titulo'],'40','...'); ?></a>
                            </h3>
                        </div>
                        
                        <div class="post-grid-desc">
                            <p style="font-family: 'Montserrat', sans-serif; font-size: 15px; text-align: justify;color:<?php echo $cor_fonte; ?>;"><?php echo $blog['resumo']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } echo '</div>'; } } ?>

<?php if($ativa_paginacao == 'S'){ $GetPag = "?id=".$categoria."&p=".$p; ?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
    <center>
        <div class="btn-group" role="group" aria-label="...">
            <?php if (isset($_GET['pag'])) { $i = $_GET['pag']; } else { $i = 1; } ?>
            <?php if ($i <= '1') { ?>
                <button type="hidden" class="btn btn-default btn-sm hidden" disabled>Anterior</button>
            <?php } elseif ($i >= '2') { $i = $i - '1'; ?>
                <button type="button" class="btn btn-default btn-sm" onclick="PaginacaoAgenda('agenda.php','<?php echo $categoria; ?>','<?php echo $i; ?>');">Anterior</button>
            <?php } ?>
            <?php if (isset($_GET['pag'])) { $i = $_GET['pag']; } else { $i = '1'; } ?>
            <?php if ($numPaginas >= '1' && $numPaginas < '9') { $numPaginas = '0'.$numPaginas; } elseif ($numPaginas > '9') { $numPaginas = $numPaginas; } ?>
            <?php if ($i >= '1' && $i <= '9') { ?>
                <button type="button" class="btn btn-default btn-sm" disabled>Página 0<?php echo $i; ?> de <?php echo $numPaginas; ?></button>
            <?php } elseif ($i > '9') { ?>
                <button type="button" class="btn btn-default btn-sm" disabled>Página <?php echo $i; ?> de <?php echo $numPaginas; ?></button>
            <?php } ?>
            <?php if (isset($_GET['pag'])) { $i = $_GET['pag']; } else { $i = '1'; } ?>
            <?php if ($i >= 1 && $i < $numPaginas) { $i++; ?>
                <button type="button" class="btn btn-default btn-sm" onclick="PaginacaoAgenda('agenda.php','<?php echo $categoria; ?>','<?php echo $i; ?>');">Próximo</button>
            <?php } elseif ($i == $numPaginas) { ?>
                <button type="button" class="btn btn-default btn-sm hidden" disabled>Próximo</button>
            <?php } ?>
        </div>
    </center>
    <br>
</div>
<?php } ?>