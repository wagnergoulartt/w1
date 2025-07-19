<?php
  if(isset($_POST['trocar']) && !empty($_POST['token_input'])){
  $token = post('token_input');
  $nova_senha = post('nova_senha');
  $repete_senha = post('repete_senha');
  
  $Query = DBRead('usuarios', '*', "WHERE token = '{$token}'");
  if (is_array($Query)) {
    foreach ($Query as $usuario) {
      $NomeUsuario  = $usuario['nome'];
      $LoginUsuario = $usuario['login'];
      $SenhaUsuario = post('nova_senha');
      $EmailUsuario = $usuario['email'];
    }
  }

  $QueryNum = DBCount('usuarios', '*', "WHERE token = '{$token}'");
  if ($QueryNum == 1) {
    if($nova_senha == $repete_senha){
      $nova_senha = md5($nova_senha);
      $Atualiza = array(
        'senha' =>  $nova_senha,
        'token' => '' 
      );
      $Query = DBUpdate('usuarios',$Atualiza, "token = '{$token}'");
      if ($Query) {

          $headers .= "Olá ".$NomeUsuario.", sua senha foi alterada com sucesso através da recuperação de senha do site : <b>".ConfigPainel('site_nome')."</b><br>\n";
          $headers .= "Dados de Acesso Atualizados: <br>\n";
          $headers .= "Login: ".$LoginUsuario."<br>\n";
          $headers .= "Nova Senha: ".$SenhaUsuario."<br>\n";
          $headers .= "Email: ".$EmailUsuario."<br>\n";

          require_once("controller/class.phpmailer/class.phpmailer.php");
          $mail = new PHPMailer();
          $mail->IsMail(true);
          $mail->IsHTML(true);
          $mail->CharSet = 'UTF-8';
          $mail->From = ConfigPainel('email');
          $mail->FromName = ConfigPainel('site_nome');
          $mail->AddAddress($EmailUsuario);
          $mail->Subject = ConfigPainel('site_nome')." | "."Senha Atualizada!";
          $mail->Body = $headers;
          $mail->AltBody = strip_tags($headers);
          if($mail->Send()){
            Redireciona('login.php?Sucesso');
          } else {
            //Erro
          }
        
      } 
    } else {
      Sweet('Ops!','O campo nova senha e repetir senha não são iguais. Tente Novamente.', 'error', 'Fechar');
    }
  } else {
    Sweet('Ops!','Esse Token expirou.', 'error', 'Fechar');
  }
    
  } else {
    if(isset($_POST['trocar'])){
      Sweet('Ops!','Token Inválido.', 'error', 'Fechar');
    }
  }
?>