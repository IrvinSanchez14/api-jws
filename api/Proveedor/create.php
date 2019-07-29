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
  include_once '../../config/database.php';
  include_once '../objects/proveedor.php';


  $database = new Database();
  $db = $database->getConnection();
  $proveedor = new Proveedor($db);
  $data = json_decode(file_get_contents("php://input"));


  if (empty($data->Nombre)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {
    $proveedor->Nombre = $data->Nombre;
    $proveedor->Direccion = $data->Direccion;
    $proveedor->Telefono = $data->Telefono;
    $proveedor->Razo_Social = $data->Razo_Social;
    $proveedor->Tipo = $data->Tipo;
    $proveedor->Nombre_Contacto = $data->Nombre_Contacto;
    $proveedor->Email = $data->Email;
    $proveedor->DUI = $data->DUI;
    $proveedor->NIT = $data->NIT;
    $proveedor->NRC = $data->NRC;
    $proveedor->Estado = "0";
    
    $proveedor->UsuarioCreador = $data->UsuarioCreador;

    if ($proveedor->create()) {
      http_response_code(200);
      echo json_encode(
        array("message" => "Datos creados exitosamente en Proveedores.")
      );
    } else {
      http_response_code(404);
      echo json_encode(
        array("message" => "No se guardaron correctamente los datos.")
      );
    }
  }
} else {
  http_response_code(404);
}
