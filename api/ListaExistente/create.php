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
  include_once '../objects/lista_existente.php';
  include_once '../funcionesG/funciones.php';


  $database = new Database();
  $db = $database->getConnection();
  $lista = new lista_existente($db);
  $email = new FuncionesGenerales($db);
  $data = json_decode(file_get_contents("php://input"));
  $stmt = $lista->verAdministradores();
  $num = $stmt->rowCount();

  if (empty($data->Sucursal)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {
    $lista->IdSucursal = $data->Sucursal;
    $lista->IdEstado = 1;
    $lista->UsuarioCreador = $data->UsuarioCreador;


    if ($lista->create()) {
      $last_id = $db->lastInsertId();
      if ($last_id > 0) {
        if ($lista->createDetalle($last_id, $data->lista)) {
          http_response_code(200);
          if ($num > 0) {
            $vaar = '';
            $products_arr = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $product_item = array(
                $Email,
              );
              array_push($products_arr, $product_item);
            }
            if ($email->enviarEmailVarios($products_arr, 'lista existente', 'hola lista')) {
              echo json_encode(
                array("message" => "Datos guardados exitosamente")
              );
            } else {
              echo json_encode(
                array("message" => "Error al momento de enviar los correos")
              );
            }
          }
        }
      }
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
