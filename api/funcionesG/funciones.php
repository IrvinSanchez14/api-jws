<?php
class FuncionesGenerales
{
  function enviarEmailVarios($email, $asunto, $cuerpo)
  { //funcion de enviar email, recibe el email, el nombre, asunto y cuerpo

    require_once '../../login/PHPMailer/PHPMailerAutoload.php'; //lebreria phpmailer se usa para el funcionamiento del envio de correo

    $mail = new PHPMailer();
    $mail->isSMTP(); // protocolo de transferencia de correo
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl'; //habilita la encriptacion SSL
    $mail->Host = 'smtp.gmail.com'; // Servidor GMAIL
    $mail->Port = 465; //puerto

    $mail->Username = 'lapizzeriapassrecovery@gmail.com'; //correo emisor
    $mail->Password = 'lapizzeria2019'; //contraseña del correo del emisor

    $mail->setFrom('lapizzeriapassrecovery@gmail.com', 'La Pizzeria'); //se establece quien envia el correo
    foreach ($email as $Email => $value) {
      $irvin = implode(",", $value);
      $mail->addAddress($irvin);
    }


    //email y nombre del receptor guardados en sus respectivas variables

    $mail->Subject = $asunto; //se configura cual es el asunto del correo
    $mail->Body    = $cuerpo; //se configura cual es el cuerpo del correo
    $mail->IsHTML(true);

    if ($mail->send())
      return true;
    else
      return false;
  }
}
