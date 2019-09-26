<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  http_response_code(200);
  echo "You dont have the correct method";
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
  http_response_code(200);
  include_once '../../config/database.php';
  include_once '../objects/producto.php';

  $database = new Database();
  $db = $database->getConnection();
  $Producto = new Producto($db);
  $stmt = $Producto->readAll();
  $num = $stmt->rowCount();

  if ($num > 0) {
    $products_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $product_item = array(
        "IdProducto" => (int) $IdProducto,
        "Nombre" => $Nombre,
        "Descripcion" => $Descripcion,
        "tipoProducto" => $tipoProducto,
        "Siglas" => $Siglas,
        "Proveedor" => $Proveedor,
        "Estado" => $estadoTexto,
        "IdTipoProducto" => $IdTipoProducto,
        "IdUnidadMedida" => $IdUnidadMedida,
        "IdProveedor" => $IdProveedor
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
