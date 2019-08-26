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
  include_once '../objects/estado.php';
  /**
   * IdEstado
   * Nombre
   * Descripcion
   * IdEstadoAnterior
   * IdEstadoSiguiente
   */

  $database = new Database();
  $db = $database->getConnection();
  $Estado = new Estados($db);
  $data = json_decode(file_get_contents("php://input"));

  if (empty($data->Nombre)) {
    echo json_encode(
      array("message" => "EMPTY")
    );
  } else {
    $Estado->NombreES = $data->Nombre;

    if(!$Estado->validateNestado()){
    $Estado->Nombre = $data->Nombre;
    $Estado->Descripcion = $data->Descripcion;
    $Estado->IdEstadoAnterior = $data->IdEstadoAnterior;
    $Estado->IdEstadoSiguiente = $data->IdEstadoSiguiente;
    $Estado->UsuarioCreador = $data->UsuarioCreador;


    if ($Estado->create()) {
      http_response_code(200);
      echo json_encode(
        array(
          "flag" => 0,
          "message" => "Datos guardados exitosamente en Estado."
          )
      );
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
  else {
    http_response_code(200);
    echo json_encode(
      array(
        "flag" => 2,
        "message" => "Nombre de estado ya existe en la base de datos."
        )
    );
  }
 }
} else {
  http_response_code(404);
}
