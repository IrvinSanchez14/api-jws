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
  include_once '../objects/sucursales.php';


  $database = new Database();
  $db = $database->getConnection();
  $sucursales = new Sucursales($db);
  $data = json_decode(file_get_contents("php://input"));

  if (empty($data->Nombre)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {
    $sucursales->NombreSU = $data->Nombre;

    if(!$sucursales->validateNSucu()){
    $sucursales->IdEmpresa = "0";
    $sucursales->Nombre = $data->Nombre;
    $sucursales->Direccion = $data->Direccion;
    $sucursales->Telefono = $data->Telefono;
    $sucursales->UsuarioCreador = $data->UsuarioCreador;
    $sucursales->Estado = "0";

    if ($sucursales->create()) {
      http_response_code(200);
      echo json_encode(
        array(
          "flag" => 0,
          "message" => "Datos guardados exitosamente en Sucursale."
          )
      );
    } else{
      http_response_code(200);
      echo json_encode(
        array(
          "flag" => 1,
          "message" => "No se guardaron correctamente los datos."
          )
      );
    }
  } 
  else {
      http_response_code(200);
      echo json_encode(
        array(
          "flag" => 2,
          "message" => "Nombre ya existe en la base de datos."
          )
      );
    }
  }
} else {
  http_response_code(404);
}

