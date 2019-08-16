<?php

use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Request-Headers: *");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
  http_response_code(200);
  echo "You dont have the correct method";
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  http_response_code(200);
  include_once '../../config/database.php';
  include_once '../objects/user.php';
  include_once '../../config/core.php';
  include_once '../../libs/BeforeValidException.php';
  include_once '../../libs/ExpiredException.php';
  include_once '../../libs/SignatureInvalidException.php';
  include_once '../../libs/JWT.php';

  $database = new Database();
  $db = $database->getConnection();
  $user = new User($db);
  $data = json_decode(file_get_contents("php://input"));
  $user->Email = $data->Email;
  $email_exists = $user->emailExists();

  if ($email_exists && password_verify($data->Passwd, $user->Passwd)) {
    $token = array(
      "iss" => $iss,
      "aud" => $aud,
      "iat" => $iat,
      "nbf" => $nbf,
      "exp" => $exp,
      "data" => array(
        "IdUsuario" => $user->IdUsuario,
        "Nombre" => $user->Nombre,
        "Alias" => $user->Alias,
        "Passws" => $user->Passwd
      )
    );
    http_response_code(200);
    $JWT = new JWT();
    $jwt = $JWT->encode($token, $key);

    if ($user->activacion == '1') {
      http_response_code(200);
      echo json_encode(
        array(
          "error" => "Tu cuenta no a sido activada.",
          "activacion" => $user->activacion,
          "IdUsuario" => $user->IdUsuario,
        )
      );
    } else {

      echo json_encode(
        array(
          "message" => "Successful login.",
          "jwt" => $jwt,
          "activacion" => $user->activacion,
          "user" => array(
            "IdUsuario" => $user->IdUsuario,
            "Nombre" => $user->Nombre,
            "IdTipoUsuario" => $user->IdTipoUsuario,
          )
        )
      );
    }
  } else {
    http_response_code(200);
    echo json_encode(array(
      "message" => "Login failed.",
      "error" => "Usuario y contraseña erronea",
    ));
  }
} else {
  http_response_code(404);
}
