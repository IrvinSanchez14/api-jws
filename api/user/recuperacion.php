<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: *");
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
    if (empty($data->Email)) {
      echo json_encode(
        array("message" => "EMPTY")
      );
    } else {
    $user->Email = $data->Email;

    if ($user->emailExists()) {
      http_response_code(200);
      $token = $user->generateToken();
      $user->generaTokenPass($user->IdUsuario, $token);
      $url = 'http://localhost/login/cambia_pass.php?user_id='.$user->IdUsuario.'&token='.$token;
      echo json_encode(
        array(
          "message" => "recuperacion",
          "url" => $url,
        )
      );
    } else {
      http_response_code(404);
      echo json_encode(
        array("Error" => "Email no existe en la base de datos")
      );
    }
  }
} else {
  http_response_code(404);}