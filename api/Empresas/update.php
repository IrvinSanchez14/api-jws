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
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
  http_response_code(200);
  include_once '../../config/database.php';
  include_once '../objects/empresa.php';

  $database = new Database();
  $db = $database->getConnection();
  $empresa = new Empresas($db);
  $data = json_decode(file_get_contents("php://input"));


  $empresa->IdEmpresa = $data->IdEmpresa;
  $empresa->Nombre = $data->Nombre;
  $empresa->Razon_Social = $data->Razon_Social;
  $empresa->Direccion = $data->Direccion;
  $empresa->Telefono = $data->Telefono;
  $empresa->Correo = $data->Correo;
  $empresa->UsuarioActualiza = $data->UsuarioActualiza;



  if ($empresa->update()) {
    http_response_code(200);
    echo json_encode(
      array("message" => "Datos guardados exitosamente en Empresa.")
    );
  } else {
    http_response_code(404);
    echo json_encode(
      array("message" => "No se guardaron correctamente los datos.")
    );
  }
} else {
  http_response_code(404);
}
