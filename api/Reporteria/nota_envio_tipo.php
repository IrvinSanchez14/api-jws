<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Request-Headers: *");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
  http_response_code(200);
  echo "You dont have the correct method";
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  http_response_code(200);
  include_once '../../config/database.php';
  include_once '../objects/reporteria.php';
  $database = new Database();
  $db = $database->getConnection();
  $reporteria = new reporteria($db);
  $data = json_decode(file_get_contents("php://input"));
  $reporteria->FechaDesde = $data->desde;
  $reporteria->FechaHasta = $data->hasta;
  $reporteria->IdTipoProducto = $data->id_tipo;
  $reporteria->IdSucursal = $data->id_sucursal;
  $stmt = $reporteria->nota_envio_portipo();

  if ($stmt) {
    $products_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $product_item = array(
        "lote" => $lote,
        "Producto" => $Producto,
        "porcionNombre" => $porcionNombre,
        "Cantidad" => $Cantidad,
        "FechaVencimiento" => $FechaVencimiento,
        "Sucursal" => $Sucursal
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
