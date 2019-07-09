<?php
if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../objects/proveedor.php';

$database = new Database();
$db = $database->getConnection();
$IdProveedor = new Proveedor($db);
$data = json_decode(file_get_contents("php://input"));

$IdProveedor->IdProveedor = $data->IdProveedor;

  if ($IdProveedor->delete()) {
    http_response_code(200);
    echo json_encode(
      array("message" => "Datos guardados exitosamente en Proveedores.")
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