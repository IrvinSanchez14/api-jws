<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
    include_once '../../config/database.php';
    include_once '../objects/proveedor.php';


    $database = new Database();
    $db = $database->getConnection();
    $proveedores = new proveedores($db);
    $data = json_decode(file_get_contents("php://input"));

    if (empty($data->IdProveedor)) {
        echo json_encode(
          array("message" => "EMPTY")
        );
      } else {
        $proveedores->IdProveedor = $data->IdProveedor;
        $proveedores->Nombre = $data->Nombre;
        $proveedores->Direccion = $data->Direccion;
        $proveedores->Telefono = $data->Telefono;
        $proveedores->Razo_Social = $data->Razo_Social;
        $proveedores->Tipo = $data->Tipo;
        $proveedores->Nombre_Contacto = $data->Nombre_Contacto;
        $proveedores->Email = $data->Email;
        $proveedores->DUI = $data->DUI;
        $proveedores->NIT = $data->NIT;
        $proveedores->NRC = $data->NRC;
        $proveedores->Estado = "0";

        if ($proveedores->create()) {
          http_response_code(200);
          echo json_encode(
            array("message" => "Datos creados exitosamente en Proveedores.")
          );
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
  