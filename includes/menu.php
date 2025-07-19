<aside class="main-sidebar fixed offcanvas shadow bg-primary text-white no-b theme-dark" data-toggle='offcanvas'>
  <section class="sidebar">
    <div class="mt-3 mb-3 ml-3 mr-3">
      <a href="./index.php"><img src="css_js/images/logo/<?php echo ConfigPainel('logo'); ?>" /></a>
    </div>

    <ul class="sidebar-menu">
      <li>
        <a href="index.php">
          <i class="icon icon-home"></i> <span><?php echo $txt['painel_admin']; ?></span>
        </a>
      </li>

      <?php if(checkPermission($PERMISSION, 'tarefas', 'item')){ ?>
      <li <?php AtivaMenu('tarefas.php'); ?>>
        <a href="tarefas.php">
          <i class="icon icon-tasks"></i> <span>Gerenciador de Tarefas</span>
        </a>
      </li>
      <?php } ?>
      
      <?php if(checkPermission($PERMISSION, 'estatisticas', 'item', 'acessar')){ ?>
      <li <?php AtivaMenu('estatisticas.php'); ?>>
        <a href="estatisticas.php">
          <i class="icon icon-bar-chart2"></i> <span>Estatistícas</span>
        </a>
      </li>
      <?php } ?>
      
      <?php if(checkPermission($PERMISSION, 'paleta', 'item', 'acessar')){ ?>
      <li <?php AtivaMenu('paleta.php'); ?>>
        <a href="paleta.php">
          <i class="icon icon-palette"></i> <span>Cores Prontas</span>
        </a>
      </li>
      <?php } ?>

      <li class="header light"><strong>MÓDULOS GERENCIÁVEIS</strong></li>

      <?php
      $Query = DBRead('modulos', '*', 'WHERE level = 1 AND status = 1 AND id <> 0 ORDER BY ordem ASC');
      if (is_array($Query)) {
        foreach ($Query as $modulos) {
          if (!empty($modulos['tabela'])) {
            // Verificação de galerias e videos
            if ($modulos['nome'] == 'Galeria de Fotos') {
              $query = "SELECT * FROM " . $modulos['tabela'] . " WHERE tipo = 1";
              $sql = DBExecute($query);
              $QueryCount = mysqli_num_rows($sql);
            } else if ($modulos['nome'] == 'Videos Avulsos') {
              $query = "SELECT * FROM " . $modulos['tabela'] . " WHERE galeria = 0";
              $sql = DBExecute($query);
              $QueryCount = mysqli_num_rows($sql);
            } else if ($modulos['nome'] == 'Galeria de Videos') {
              $query = "SELECT * FROM " . $modulos['tabela'] . " WHERE tipo = 2";
              $sql = DBExecute($query);
              $QueryCount = mysqli_num_rows($sql);
            } else {
              $QueryCount = DBCount($modulos['tabela'], 'id');
            }
          } else {
            $QueryCount = '*';
          }
      ?>

          <?php if(checkPermission($PERMISSION, $modulos['url'])){ ?>
            <li <?php AtivaMenu($modulos['url']); ?>><a href="<?php echo $modulos['url']; ?>">
                <i class="icon <?php echo $modulos['icone']; ?>"></i> <span><?php echo $modulos['nome']; ?> </span> <span class="badge r-3 badge-primary pull-right"><?php echo $QueryCount; ?></span></a>
            </li>
          <?php } ?>
      <?php }
      } else {
        echo '<li><a href="#"> <i style="color: #e84c3d!important" class="icon icon-exclamation-triangle"></i> <span style="color: #e84c3d!important">Nenhum módulo instalado.</span> </a> </li>';
      } ?>

      <?php if (DadosSession('nivel') == 1) { ?>
        <li class="header light mt-3"><strong>Menu do WebMaster</strong></li>
        <?php $MenuWM = DBRead('modulos','*',"WHERE status = 1 AND level = 2 ORDER BY ordem ASC"); if (is_array($MenuWM)) { foreach($MenuWM as $menu){ ?>
          <?php if(checkPermission($PERMISSION, $menu['url'], 'item')){ ?>
          <li <?php AtivaMenu("{$menu['url']}"); ?>> <a href="<?php echo $menu['url']; ?>"> <i></i> <span><?php echo $menu['nome']; ?></span></a> </li>
          <?php } ?>
        <?php } } ?>
      <?php } else { ?>
        <li class="header"></li>
      <?php } ?>
    </ul>
  </section>
</aside>
<div class="has-sidebar-left">
  <div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
      <div class="bg-dark pt-2 pb-2 pl-4 pr-2">
        <a href="#" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" class="paper-nav-toggle paper-nav-white active "><i></i></a>
      </div>
    </div>
  </div>

  <div class="sticky">
    <div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar blue accent-3">
      <div class="relative">
        <a href="#" style="color: #fff; font-size: 25px;" data-toggle="push-menu" class="paper-nav-toggle pp-nav-toggle"><span class="icon-reorder"></span></a>
      </div>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <?php
          // Notificacao de comentarios
          $comentarios = getAllComentarios();
          @$notificacoes = count($comentarios);
          if ($notificacoes) {
          ?>
            <li class="dropdown custom-dropdown notifications-menu">
              <a href="#" class=" nav-link" data-toggle="dropdown" aria-expanded="true">
                <i class="icon-notifications "></i>
                <span class="badge badge-danger badge-mini rounded-circle"><?php echo $notificacoes; ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <li class="header">Você tem <?php echo $notificacoes; ?> notificações</li>
                <li>
                  <ul class="menu">
                    <?php foreach ($comentarios as $comentario) { ?>
                      <li>
                        <a href="blog.php?Comentarios=<?php echo $comentario['blog_id']; ?>">
                          <i class="icon icon-data_usage text-success"></i> Uma notícia foi comentada.
                        </a>
                      </li>
                    <?php } ?>
                  </ul>
                </li>
                <!--<li class="footer p-2 text-center"><a href="#">Ver todas</a></li>-->
              </ul>
            </li>
          <?php } ?>
          <?php if (DadosSession('nivel') == 1) { ?>
            <?php if(checkPermission($PERMISSION, 'configuracoes', 'menu', 'link_suporte')){ ?>
            <!-- <li <?php echo Tooltip('Solicitar suporte', 'bottom'); ?>><a target="_blank" href="https://wacontrol.com.br/suporte-ao-cliente/" class="nav-link"><i class="icon-life-ring"></i></a></li> -->
            <?php } ?>

            <?php if(checkPermission($PERMISSION, 'configuracoes', 'menu', 'codigo_head')){ ?>
            <li <?php echo Tooltip('Código Adicional - Head', 'bottom'); ?>><a href="#" data-toggle="modal" data-target="#codhead" class="nav-link"><i class="icon-code"></i></a></li>
            <?php } ?>
          <?php } ?>
          <?php if (ConfigPainel('site_url')) { ?>
            <?php if(checkPermission($PERMISSION, 'configuracoes', 'menu', 'acessar_site')){ ?>
            <li <?php echo Tooltip('Acessar Site', 'bottom'); ?>><a target="_blank" href="<?php echo ConfigPainel('site_url'); ?>" class="nav-link"><i class="icon-desktop_mac"></i></a></li>
            <?php } ?>
          <?php } ?>
          <?php if (DadosSession('nivel') == 2) { ?>
            <li <?php echo Tooltip('Usuários', 'bottom'); ?>><a href="usuarios.php" class="nav-link"><i class="icon-user"></i></a></li>
          <?php } ?>

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
              <?php if (getAvatar(DadosSession('id')) == '') { ?>
                <img src="css_js/images/usuarios/avatar.png" class="user-image">
              <?php } else { ?>
                <img src="css_js/images/usuarios/<?php echo getAvatar(DadosSession('id')); ?>" class="user-image">
              <?php } ?>
            </a>

            <ul class="dropdown-menu dropdown-menu-right" style="width: 100px;">
              <li>
                <ul class="menu pl-2 pr-2">
                  <!--<li style="padding: 10px 5px;"><a href="perfil.php" style="display: block"><i class="icon icon-user"></i> Meu Perfil</a></li>-->
                  <li style="padding: 10px 5px;"><a href="login.php?logout=sim" style="display: block"><i class="icon icon-exit_to_app"></i> Sair</a></li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>