<?php
  if (!file_exists('database/config.php')) {
    Redireciona('setup.php');
  } else {
    require_once ('database/config.php');
  }
  require_once ('database/config.database.php');
  require_once ('database/config.session.php');
  require_once ('includes/funcoes.php');
  require_once ('controller/login.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $txt['entrar_login']; ?> - <?php echo $txt['painel_admin']; ?></title>
  <link rel="shortcut icon" href="img/favicon.png"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="assets/css/app.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <?php if (!empty(ConfigPainel('site_key')) && !empty(ConfigPainel('secret_key'))) { ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <?php } ?>
  <?php $Query = DBRead('config','*'); if (is_array($Query)) { foreach ($Query as $config) { ?>
  <?php if($config['tema'] == 'tema02'){ ?>
  <style type="text/css">
    .height-full {background: #f3f5f8 !important;}
    .paper-card {background: transparent !important; box-shadow: none !important;}
  </style>
  <?php } else if($config['tema'] == 'tema03'){ ?>
  <style type="text/css">
    .white{background: <?php echo $config['menu']; ?> !important}
  </style>
  <?php } ?>
  <style type="text/css">
    <?php
      if(file_exists('css_js/images/background.png')){
        echo ".height-full{background-image: url('css_js/images/background.png') !important}";
      }
    ?>
    a{color: <?php echo $config['cor_blocos']; ?>}
    .btn-primary{background: <?php echo $config['cor_blocos']; ?> !important; border-color: <?php echo $config['cor_blocos']; ?>!important;}
    .form-control-lg:focus, .input-group-lg>.form-control:focus, .input-group-lg>.input-group-addon:focus, .input-group-lg>.input-group-append>.btn:focus, .input-group-lg>.input-group-append>.input-group-text:focus, .input-group-lg>.input-group-prepend>.btn:focus, .input-group-lg>.input-group-prepend>.input-group-text:focus{border-color: <?php echo $config['cor_blocos']; ?>!important}
  </style>
  <?php } } ?>
</head>
<body class="light">
  <div id="app">
    <?php if($config['tema'] == 'tema03'){ ?>
    <div class="page parallel">
      <div class="d-flex row">
        <div class="col-md-3 white">
          <div class="p-5 mt-5">
            <img class="img-responsive" src="css_js/images/logo/<?php echo ConfigPainel('logo'); ?>">
          </div>

          <div class="p-5">
            <p class="p-t-b-20"><?php echo $txt['msg_login']; ?></p>
            <form method="POST" action="login.php">
              <input type="hidden" name="redirect" value="<?php if(!empty($_GET['redirect'])){ echo $_GET['redirect']; } ?>">
              <div class="form-group has-icon">
                <i class="icon-user-o"></i>
                <input type="text" class="form-control form-control-lg" name="login" placeholder="<?php echo $txt['seu_login']; ?>">
              </div>
                
              <div class="form-group has-icon">
                <i class="icon-user-secret"></i>
                <input type="password" class="form-control form-control-lg" name="senha" placeholder="<?php echo $txt['sua_senha']; ?>">
              </div>
                
              <input type="submit" class="btn btn-primary btn-lg btn-block" id="IniciarLogin" onclick="AlteraTexto();" value="<?php echo $txt['iniciar_sessao']; ?>">
              <p class="forget-pass"><a href="#" data-toggle="modal" data-target="#resetarsenha">Esqueceu sua senha?</a></p> 
              <?php if (!empty(ConfigPainel('site_key')) && !empty(ConfigPainel('secret_key'))) { ?>
                  <div class="col-lg-12">
                    <br>  
                      <div class="g-recaptcha" data-sitekey="<?= ConfigPainel('site_key'); ?>"></div>  
                    <br>
                  </div>
                <?php } ?>
            </form>
          </div>
        </div>
        <div class="col-md-9 height-full blue accent-3 align-self-center text-center" data-bg-repeat="false" data-bg-possition="center"></div>
      </div>
    </div>
    <?php } else if($config['tema'] == 'tema04'){ ?>
    <div id="primary" class="blue4 p-t-b-100 height-full responsive-phone">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 text-center">
            <img style="margin-top:40%" class="img-responsive" src="css_js/images/logo/<?php echo ConfigPainel('logo'); ?>">
          </div>

          <div class="col-lg-6 p-t-100">
            <div class="text-white">
              <h1>Bem-vindo</h1>
              <p class="s-18 p-t-b-20 font-weight-lighter"><?php echo $txt['msg_login']; ?></p>
            </div>

            <form method="POST" action="login.php">
            <input type="hidden" name="redirect" value="<?php if(!empty($_GET['redirect'])){ echo $_GET['redirect']; } ?>">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group has-icon">
                    <i class="icon-user-o"></i>
                    <input type="text" class="form-control form-control-lg" name="login" placeholder="<?php echo $txt['seu_login']; ?>">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group has-icon">
                    <i class="icon-user-secret"></i>
                    <input type="password" class="form-control form-control-lg" name="senha" placeholder="<?php echo $txt['sua_senha']; ?>">
                  </div>
                </div>
                <div class="col-lg-12">
                  <input type="submit" class="btn btn-primary btn-lg btn-block btn-block" id="IniciarLogin" onclick="AlteraTexto();" value="<?php echo $txt['iniciar_sessao']; ?>">
                  <p class="forget-pass text-white"><a href="#" data-toggle="modal" data-target="#resetarsenha">Esqueceu sua senha?</a></p>
                </div>
                <?php if (!empty(ConfigPainel('site_key')) && !empty(ConfigPainel('secret_key'))) { ?>
                  <div class="col-lg-12">
                    <br>  
                      <div class="g-recaptcha" data-sitekey="<?= ConfigPainel('site_key'); ?>"></div>  
                    <br>
                  </div>
                <?php } ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php } else { ?>
    <main>
      <div id="primary" class="p-t-b-100 height-full" style="background: #30363d">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 mx-md-auto paper-card" style="background: #272c33">
              <div class="text-center">
                <img class="img-responsive" src="css_js/images/logo/<?php echo ConfigPainel('logo'); ?>">
                <p class="p-t-b-20"><?php echo $txt['msg_login']; ?></p>
              </div>
              
              <form method="POST" action="login.php">
              <input type="hidden" name="redirect" value="<?php if(!empty($_GET['redirect'])){ echo $_GET['redirect']; } ?>">
                <div class="form-group has-icon">
                  <i class="icon-user-o"></i>
                  <input type="text" class="form-control form-control-lg" name="login" placeholder="<?php echo $txt['seu_login']; ?>">
                </div>
                
                <div class="form-group has-icon">
                  <i class="icon-user-secret"></i>
                  <input type="password" class="form-control form-control-lg" name="senha" placeholder="<?php echo $txt['sua_senha']; ?>">
                </div>
                
                <input type="submit" class="btn btn-primary btn-lg btn-block" id="IniciarLogin" onclick="AlteraTexto();" value="<?php echo $txt['iniciar_sessao']; ?>">
                <p class="forget-pass"><a href="#" data-toggle="modal" data-target="#resetarsenha">Esqueceu sua senha?</a></p> 

                <?php if (!empty(ConfigPainel('site_key')) && !empty(ConfigPainel('secret_key'))) { ?>
                  <div class="col-lg-12">
                    <br>  
                      <div class="g-recaptcha" data-sitekey="<?= ConfigPainel('site_key'); ?>"></div>  
                    <br>
                  </div>
                <?php } ?>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php } ?>
  </div>

  <div class="modal fade" id="resetarsenha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="Form" role="form" method="post" class="form" enctype="multipart/form-data" action="login.php">
          <div class="modal-body">
            <p>
              <?php echo $txt['msg_resetar_senha']; ?>
            </p>
            <div class="form-group has-icon">
              <i class="icon-envelope-o"></i>
              <input type="email" class="form-control form-control-lg" name="email" placeholder="<?php echo $txt['seu_email']; ?>">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="reset_senha"><?php echo $txt['enviar']; ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/app.js"></script>
</body>
</html>

<?php
  if (isset($_GET['logout']) == 'true') {
    Sweet('Logout',$txt['logout'], 'info', 'Fechar');
  } elseif (isset($_GET['erro'])) {
    Sweet('Ops!','Verifique novamente os dados inseridos nos campos Login e Senha!', 'error', 'Fechar');
  } elseif (isset($_GET['sucesso']) || isset($_GET['Sucesso'])) {
    Sweet('Sucesso!!!', 'O Procedimento foi realizado com sucesso!', 'success', 'Fechar');
  } elseif (isset($_GET['captcha'])) {
    Sweet('Ops!','Por favor, confirme o captcha!', 'error', 'Fechar');
  }
?>