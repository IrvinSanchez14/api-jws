<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
  include_once '../config/database.php';
  include_once 'objects/user.php';
  include_once '../config/core.php';
  include_once '../libs/BeforeValidException.php';
  include_once '../libs/ExpiredException.php';
  include_once '../libs/SignatureInvalidException.php';
  include_once '../libs/JWT.php';
  use \Firebase\JWT\JWT;
  
  $database = new Database();
  $db = $database->getConnection();
  $user = new User($db);

  $data = json_decode(file_get_contents("php://input"));
  $user->email = $data->email;
  $email_exists = $user->emailExists();
  // password_verify verifica si la contrasena del formulario es la misma nos pide dos parametros
  // el primero es la contrasena del formulario
  // el segundo es la contrasena encriptada del usuario
  if ($email_exists && password_verify($data->password, $user->password)) {
    $token = array(
      "iss" => $iss,
      "aud" => $aud,
      "iat" => $iat,
      "nbf" => $nbf,
      "exp" => $exp,
      "data" => array(
          "id" => $user->id,
          "firstname" => $user->firstname,
          "lastname" => $user->lastname,
          "email" => $user->email
      )
    );
    http_response_code(200);
    $jwt = JWT::encode($token, $key);
    echo json_encode(
      array(
        "message" => "Successful login.",
        "jwt" => $jwt
      )
    );
  } else {
    http_response_code(401);
    echo json_encode(array("message" => "Login failed."));
  }

?>

