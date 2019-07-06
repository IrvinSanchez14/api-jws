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

  $user->Nombre = $data->Nombre;
  $user->Email = $data->Email;
  $user->Alias = $data->Alias;
  $user->IdTipoUsuario = $data->IdTipoUsuario;
  $user->Passwd = $data->Passwd;

  if ($user->create()) {
    http_response_code(200);
    echo json_encode(array("message" => "User was created."));
  } else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create user."));
  }
} else {
  http_response_code(404);
}
