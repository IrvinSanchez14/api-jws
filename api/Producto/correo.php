<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../../config/database.php';
  include_once '../objects/user.php';
  include_once '../objects/producto.php';
  
  $database = new Database();
  $db = $database->getConnection();
  //$user = new User($db);
  $Producto = new Producto($db);
  $stmt = $Producto->readAll();
  $num = $stmt->rowCount();

    
    http_response_code(200);
      $asunto = 'Lista de productos';
      if ($num > 0) {
        $cuerpo = '<table border="0.5"  ><tr style=" background-color: #4CAF50; color: white;"><th align="center">ID</th><th align="center">Nombre</th><th align="center">Descripcion</th></tr>';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $cuerpo .= '<tr><td align="center">' . $IdProducto . '</td><td align="center">' . $Nombre . '</td><td align="center">' . $Descripcion . '</td></tr>';
        }
        $cuerpo .= "</table>";
      } 

      if ($Producto->enviarEmail($asunto, $cuerpo)) {
        echo json_encode(
          array(
            "flag" => 0,
            "message" => "Correo enviado exitosamente.",
            //"url" => $url,
          ),
          JSON_UNESCAPED_SLASHES
        );
      } else {
        http_response_code(400);
        echo json_encode(
          array(
            "flag" => 1,
            "Error" => "Problema al momento de enviar el Email, por favor intentelo mas tarde"
          ) 
        );
      }
    