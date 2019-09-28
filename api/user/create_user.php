<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
  http_response_code(200);
  echo "You dont have the correct method";
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  http_response_code(200);

  include_once '../../config/database.php';
  include_once '../objects/user.php';

  $database = new Database();
  $db = $database->getConnection();
  $user = new User($db);
  $data = json_decode(file_get_contents("php://input"));
  $passRandom = $user->randomPassword();

  $user->Nombre = $data->Nombre;
  $user->Email = $data->Email;
  $user->Alias = $data->Alias;
  $user->IdTipoUsuario = $data->IdTipoUsuario;
  $user->Passwd = $passRandom;
  $user->Estado = "0";
  $user->activacion = "1";
  $user->IdSucursal = $data->IdSucursal;
  $user->UsuarioCreador = $data->UsuarioCreador;

  if ($user->create()) {
    http_response_code(200);
    $last_id = $db->lastInsertId();
    $user->IdUsuario = $last_id;
    $user->IdSucursal = $data->valueSelectSucursal;
    if ($user->createUsuarioSucursal()) {
      $asunto = 'Creaction de Cuenta - Sistema La Pizzeria';
      echo json_encode($asunto);
      $cuerpo = "Hola $data->Nombre: <br /><br />Tu cuenta en el sistema de La Pizzeria a sido creado correctamente.<br /> Tu contraseña temporal es " . $passRandom . ".<br />
    ATENCION!! al momento de ingresar al sistema con tu usuario y contraseña temporal se te solicitara cambiar la contraseña por motivos de personalizar tu usuario.";
      if ($user->enviarEmail($data->Email, $data->Nombre, $asunto, $cuerpo)) {
        echo json_encode(
          array(
            "message" => "User Was Created"
          )
        );
      } else {
        echo json_encode(
          array("ErrorSMTP" => "Problema al momento de enviar el EMAIL")
        );
      }
    }
  } else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create user."));
  }
} else {
  http_response_code(404);
}
