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
  include_once '../objects/factura.php';


  $database = new Database();
  $db = $database->getConnection();
  $factura = new Factura($db);
  $data = json_decode(file_get_contents("php://input"));

  if (empty($data->Cabecera->NumeroFactura)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {

    $factura->NoFactura = $data->Cabecera->NumeroFactura;
    $factura->IdProveedor = $data->Cabecera->Proveedor;
    $factura->FechaFactura = date("Y-m-d", strtotime($data->Cabecera->Fecha));
    $factura->FechaIngreso = date("Y-m-d", strtotime($data->Cabecera->Fecha));
    $factura->TipoFactura = $data->Cabecera->TipoFactura;
    $factura->TotalSinIva = $data->Cabecera->SinIva;
    $factura->IVA = $data->Cabecera->IVA;
    $factura->UsuarioCreador = $data->Cabecera->UsuarioCreador;

    if ($factura->createCabecera()) {
      $last_id = $db->lastInsertId();
      if ($last_id > 0) {
        echo json_encode($data);
        if ($factura->createDetalle($last_id, $data->Detalle)) {
          http_response_code(200);
          echo json_encode(
            array("message" => "Datos guardados exitosamente")
          );
        }
      }
    } else {
      http_response_code(200);
      echo json_encode(
        array(
          "flag" => 1,
          "message" => "No se guardaron correctamente los datos."
        )
      );
    }
  }
} else {
  http_response_code(404);
}
