<?php
if ($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: *");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../../config/database.php';
  include_once '../objects/produccion.php';

  $database = new Database();
  $db = $database->getConnection();
  $produccion = new Produccion($db);
  $stmt = $produccion->readProduccion();
  $num = $stmt->rowCount();

  if ($num > 0) {
    $products_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $product_item = array(
        "IdPC" => $IdPC,
        "IdCP" => $IdCP,
        "lote" => $lote,
        "IdEstado" => $IdEstado,
        "NombreEstado" => $NombreEstado,
        "FechaCreacion" => $FechaCreacion
      );
      array_push($products_arr, $product_item);
    }
    http_response_code(200);
    echo json_encode($products_arr);
  } else {
    http_response_code(404);
    echo json_encode(
      array("message" => "No se encontraron datos.")
    );
  }
} else {
  http_response_code(404);
}
