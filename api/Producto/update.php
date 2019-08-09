
<?php
if ($_SERVER['REQUEST_METHOD'] == "PUT"  || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: PUT");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../../config/database.php';
  include_once '../objects/producto.php';

  $database = new Database();
  $db = $database->getConnection();
  $Producto = new Producto($db);
  $data = json_decode(file_get_contents("php://input"));
  $Producto->IdProducto = $data->IdProducto;
  $Producto->Nombre = $data->Nombre;
  $Producto->Descripcion = $data->Descripcion;
  $Producto->IdTipoProducto = $data->tipoProducto;
  $Producto->IdUnidadMedida = $data->Siglas;
  $Producto->IdProveedor = $data->Proveedor;
  $Producto->UsuarioActualiza = $data->UsuarioActualiza;

  if ($Producto->update()) {
    echo json_encode($data);
    http_response_code(200);
    echo json_encode(
      array("message" => "Datos guardados exitosamente en Productos.")
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
?>