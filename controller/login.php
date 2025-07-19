<?php
$DefineLang = DefineLang('m7admin.php');
if (file_exists($DefineLang)) { require_once $DefineLang; }

if (isset($_GET['logout']) && !empty($_GET['logout'])) {
    $sid = new Session;
    $sid->start();
    $sid->destroy();
}

if (isset($_POST['g-recaptcha-response'])) {
  $captcha_data = $_POST['g-recaptcha-response'];

  $resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".ConfigPainel('secret_key')."&response=".$captcha_data."&remoteip=".$_SERVER['REMOTE_ADDR']);
  $resposta = json_decode($resposta, true);

  if (!$resposta['success']) {
    Redireciona('?captcha');
    return false;
  }
}

if (isset($_POST['login']) && isset($_POST['senha']) && !empty($_POST['login']) && !empty($_POST['senha'])) {
    $login = mysqli_real_escape_string(DBConnect(), post('login'));
    $senha = md5(post('senha'));

      $Query = DBRead('usuarios', '*', "WHERE login = '{$login}' AND senha = '{$senha}' AND status = '1' LIMIT 1");
      $Count = DBCount('usuarios', '*', "WHERE login = '{$login}' AND senha = '{$senha}' AND status = '1' LIMIT 1");
      if ($Count == 1) {
          foreach ($Query as $usuario) {
              $sid = new Session;
              $sid->start();
              $sid->init(36000);
              $sid->addNode('start', date('d/m/Y - h:i'));
              $sid->addNode('id', (int)$usuario['id']);
              $sid->addNode('nome', $usuario['nome']);
              $sid->addNode('login', $usuario['login']);
              $sid->addNode('email', $usuario['email']);
              $sid->addNode('avatar', $usuario['avatar']);
              $sid->addNode('nivel', $usuario['nivel']);
              $sid->addNode('permissao', $usuario['permissao']);
              if (!empty($_POST['redirect'])) {
                Redireciona($_POST['redirect']);
              } else {
                Redireciona('index.php');
              }
          }
      } else {
        $LoginCript = base64_encode(post('login'));
        $SenhaCript = base64_encode(post('senha'));
        Redireciona('login.php?erro='.$LoginCript.'&pass='.$SenhaCript);
      }

}

if (isset($_GET['erro']) && !empty($_GET['erro'])) {

  $headers  = "Atenção foi registrado uma tentativa de login que falhou no seu painel: <b>".ConfigPainel('site_nome')."</b><br>\n";
  $headers .= "Detalhes: <br>\n";
  $headers .= "Data e Hora: ".date('d/m/Y')." às ". date('h:i')."<br>\n";
  $headers .= "Login Usado: ".base64_decode($_GET['erro'])."<br>\n";
  $headers .= "Senha Usado: ".base64_decode($_GET['pass'])."<br>\n";
  $headers .= "IP do Usuário: <a target='_blank' href='http://who.is/whois-ip/ip-address/".$_SERVER["REMOTE_ADDR"]."'>".$_SERVER["REMOTE_ADDR"]."</a> <br>\n";

  require_once("controller/class.phpmailer/class.phpmailer.php");
  $mail = new PHPMailer();
  $mail->IsMail(true);
  $mail->IsHTML(true);
  $mail->CharSet = 'UTF-8';
  $mail->From = ConfigPainel('email');
  $mail->FromName = ConfigPainel('site_nome');
  $mail->AddAddress(ConfigPainel('email'));
  $mail->Subject = ConfigPainel('site_nome')." | "."Tentativa de login!";
  $mail->Body = $headers;
  $mail->AltBody = strip_tags($headers);
  if($mail->Send()){
    //Enviado
  } else {
    //Erro
  }
}

if(isset($_POST['email'])){
  function geraToken($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';
    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;
    if ($simbolos) $caracteres .= $simb;
    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
    $rand = mt_rand(1, $len);
    $retorno .= $caracteres[$rand-1];
    }
    return $retorno;
  }

    $email = post('email');

    $QueryNum = DBCount('usuarios','email',"WHERE email = '{$email}'");
    if ($QueryNum >= 1) {
    $Query = DBRead('usuarios','email',"WHERE email = '{$email}'"); if (is_array($Query)) { foreach ($Query as $usuario) {
        $email_cliente = $usuario['email'];
    } }
  
    $token = geraToken(10, true, true, false);
    $Atualiza = array('token' => $token, );
    $Query = DBUpdate('usuarios',$Atualiza,"email = '{$email}'");

  $assunto = "Senha - Painel Administrativo";

  $mensagem  = 'Você solicitou a alteração da sua senha do painel '.ConfigPainel('nome_site').'. Clique no link abaixo para realizar a troca da sua senha.<br>';
  $mensagem .= '<a href="'.ConfigPainel('base_url')."/resetar-senha.php?cod=".$token.'" target="_blank">Redefinir Senha</a><br>';
  $mensagem .= 'ou copie e cole o link abaixo no seu navegador:<br> '.ConfigPainel('base_url')."/resetar-senha.php?cod=".$token.'';
  $mensagem .= '<br>Atenção: Caso não tenha solicitado a redefinição da senha, ignore essa mensagem.';

  require_once("controller/class.phpmailer/class.phpmailer.php");
  $mail = new PHPMailer;
  $mail->IsMail(true);
  $mail->IsHTML(true);
  $mail->CharSet = 'UTF-8';
  $mail->From = ConfigPainel('email');
  $mail->FromName = ConfigPainel('site_nome');
  $mail->AddAddress($email);
  $mail->Subject = ConfigPainel('site_nome')." | "."Senha - Painel Administrativo";
  $mail->Body = $mensagem;
  $mail->AltBody = strip_tags($mensagem);
  if($mail->Send()){
    AbreAlerta('Geramos um Token para a troca da senha. Confira seu email');
  } else {
    AbreAlerta('Erro');
  }
  
  } else {
    AbreAlerta('Esse email não existe no banco de dados.');
  }
}
?>