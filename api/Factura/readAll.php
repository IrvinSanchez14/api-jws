<?php
if ($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../../config/database.php';
  include_once '../objects/factura.php';

  $database = new Database();
  $db = $database->getConnection();
  $factura = new Factura($db);
  $stmt = $factura->readLotes();
  $num = $stmt->rowCount();

  if ($num > 0) {
    $products_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $product_item = array(
        "IdCP" => $IdCP,
        "IdEstado" => $IdEstado,
        "NombreEstado" => $NombreEstado,
        "Lote" => $Lote,
        "NoFactura" => $NoFactura,
        "IdProveedor" => $IdProveedor,
        "NombreProveedor" => $NombreProveedor,
        "FechaCreacion" => $FechaCreacion
      );
      array_push($products_arr, $product_item);
    }
    http_response_code(200);
    echo json_encode($products_arr);
  } else {
    http_response_code(200);
    echo json_encode(
      array("error" => "No se encontraron datos.")
    );
  }
} else {
  http_response_code(404);
}
