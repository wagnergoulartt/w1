<?php
  require_once ('database/config.php');
  require_once ('database/config.database..php');
  require_once ('database/config.session.php');
  require_once ('includes/funcoes.php');
  require_once ('controller/resetar-senha.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Redefinir Senha</title>
    <link rel="shortcut icon" href="img/favicon.png"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="css_js/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css_js/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css_js/dist/css/AdminLTE.min.css">
    <script src="css_js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="css_js/bootstrap/js/bootstrap.min.js"></script>
    <script src="css_js/plugins/sweetalert/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css_js/plugins/sweetalert/sweetalert.css">
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <img src="css_js/images/logo/<?php echo ConfigPainel('logo'); ?>" width="75%">
      </div>
      <div class="login-box-body" style="border-radius:5px;">
        <p class="login-box-msg">Insira sua nova senha!</p>
        
        <form method="POST" action="">

          <div class="form-group has-feedback">
            <input class="hidden" name="nova_senha">
            <input type="hidden" name="token_input" value="<?php echo get('cod'); ?>">
            <input type="password" class="form-control" name="nova_senha" placeholder="Nova Senha" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="repete_senha" placeholder="Repetir Senha" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>

          <div class="row">
            <center>
              <button class="btn btn-primary btn-sm" name="trocar" id="IniciarLogin">Trocar Senha</button>
              <a href="login.php">
                <button class="btn btn-success btn-sm" type="button" id="IniciarLogin">Fazer Login</button>
              </a>
            </center>
          </div>

        </form>

      </div>
    </div>
  </body>
</html>

<?php
  if (isset($_GET['logout']) == 'true') {
    Sweet('Logout',$txt['logout'], 'info', 'Fechar');
  } elseif (isset($_GET['erro'])) {
    Sweet('Ops!','Verifique novamente os dados inseridos nos campos Login e Senha!', 'error', 'Fechar');
  } elseif (isset($_GET['Sucesso']) || isset($_GET['sucesso'])) {
    Sweet('Sucesso!','Procedimento realizado com sucesso!', 'success', 'Fechar');
  } elseif (isset($_GET['Erro']) && $_GET['Erro'] == '1') {
    Sweet('Ops!','O campo nova senha e repetir senha não são iguais. Tente Novamente.', 'error', 'Fechar');
  } elseif (isset($_GET['Erro']) && $_GET['Erro'] == '2') {
    Sweet('Ops!','Esse Token expirou.', 'error', 'Fechar');
  } elseif (isset($_GET['Erro']) && $_GET['Erro'] == '3') {
    Sweet('Ops!','Token Inválido.', 'error', 'Fechar');
  }
?>
<script type="text/javascript"> $('[data-tooltip="tooltip"]').tooltip();</script>