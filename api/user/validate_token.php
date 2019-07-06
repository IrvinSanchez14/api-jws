<?php

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
  include_once '../../config/core.php';
  include_once '../../libs/BeforeValidException.php';
  include_once '../../libs/ExpiredException.php';
  include_once '../../libs/SignatureInvalidException.php';
  include_once '../../libs/JWT.php';
  use \Firebase\JWT\JWT;
  //file_get_contents -> trae todo el contenido de la informacion de una ruta u objeto especifico en este caso del formulario que enviamos
  // se envia un objeto JSON para ser consultado y luego transformado en un array y codificado a un JSON
  $data = json_decode(file_get_contents("php://input")); 
  // si data->jwt existe que me regrese el token y si no que lo envie vacio.
  $jwt = isset($data->jwt) ? $data->jwt : "";
  // si jwt no esta vacio
  if ($jwt) {
    try {
      //decodificamos jwt con la JWT y la funcion decode
      $decoded = JWT::decode($jwt, $key, array('HS256'));
      http_response_code(200);
      echo json_encode(array(
          "message" => "Access granted.",
          "data" => $decoded->data
      ));
    } catch (Exception $e) {
      //mostramos error si ocurre al momemto de decodificarlo
      http_response_code(401);
      echo json_encode(array(
          "message" => "Access denied.",
          "error" => $e->getMessage()
    ));
    }
  } else {
    http_response_code(401);
    echo json_encode(array("message" => "Access denied."));
  }
