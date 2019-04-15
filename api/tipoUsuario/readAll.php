<?php /* -- Funcionamiento del llamado a la API readALL --
1- colocamos un IF para identificar que tipo de metodo esperamos al momento de llamar a la API
  --- Tipos de Metodos ---
    GET - Lo utilizamos unicamente cuando realizamos consultas SELECT ya sea para llamar todos los datos o uno en especifico (metodo por URL)
    POST - lo utilizamos unicamente cuando realizamos consultas INSERT los datos son enviados por medio de un JSON
    PUT - Lo utilizamos unicamente cuando realizamos consultas UPDATE los datos son enviador por medio de un JSON
    DELETE - Lo utilizamos unicamente cuando realizamos consultas DELETE los datos son enviados por medio de un JSON */
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  /* -- Cabeceras y librerias --
  1- header() o cabeceras son las que necesitaremos para otorgarle permisos a nuestra API para poder ser consultado externamente sin ellas la API no podra devolver datos
  2- "Access-Control-Allow-Origin: *" -- Esta cabecera da los permisos de control a los usuarios que nosotros queramos en este caso colocamos el * porque todos tendran acceso a ella
  3- "Content-Type: application/json; charset=UTF-8" -- especificamos de que tipo sera nuesta api en este caso indicamos que sera JSON es decir recibira y devolvera JSON
  4-  "Access-Control-Allow-Methods: GET" -- Especificamos el metodo que utilizaremos en nuestra api en este momento sera el GET
  5- "Access-Control-Max-Age: 360" -- indicamos el tiempo maximo que tendra la api de devolver un dato
  6- "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With" -- cabeceras que los navegadors solicitan para el acceso a ella
  7- luego de las cabeceras incluimos las librerias o archivos que utilizaremos en este caso solo necesiamos el de la base de datos y el archivo donde esta nuestra clase tipoUsuario
  */
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../../config/database.php';
  include_once '../objects/tipoUsuario.php';
  /* -- Logica de la API --
  1- creamos un objeto que contendra nuestra Database()
  2- creamos una variable que contendra la funcion getConnection() que es la que nos da la conexion hacia la base de datos
  3- Creamos un objeto que contendra la clase de nuestra API tipos_usuario() y dentro de ella mandamos como parametro la conexion a la base de datos
  4- creamos la variable $stmt y le asignamos el objeto de nuestra clase y buscamos la funcion readAll() la cual contiene nuestra consulta
  5- cremos la variable num donde colocamos la funcion rowCOunt() unicamente la utilizamos para saber la cantidad de datos que existen almacenados
  6- creamos un IF donde colocamos que si num es mayor a 0 nos creara los datos si no es que no existen datos aun esa tabla */

  $database = new Database();
  $db = $database->getConnection();
  $tipoUsuario = new tipos_usuario($db);
  $stmt = $tipoUsuario->readAll();
  $num = $stmt->rowCount();

  if ($num > 0) {
    /*-- creacion del resultado de la API --
    1- creamos una variable que sera igual a un array()
    2- ejecutamos while para recorrer al $stmt donde $row obtendra todos los registros
      utilizamos el metodo fetch que es mas rapido que fetchAll para obtener todos los datos
      luego dentro de ella llamamos a la clase PDO que es el metodo por el cual hemos construido nuestra API y le decimos que ejecute la extraccion de la data del query
    3- extraemos $row para obtener todos los datos de la consulta por separado para no utilizar $row['nombre_campo']
    4- creamos una nueva variable que contendra un array con los datos que hemos sacado de $row
    5- hacemos push al primmer array que creamos y le pushamos (termino calle) el nuevo array 
      PUSH - este termino lo utilizamos muchas veces es el unico que permite insertar informacion en un array que ya se aya creado UNICAMENTE A UN ARRAY OJO CON ESO
    6- mandamos un http_response_code(200) donde indicamos que el status es OK
    7- mostramos los datos pero antes convertimos el array en JSON con la funcion json_encode()
    8- si el if del num esta malo nos devolvera un http_response_code(404) el cual el status es fail y un array con un mensaje de error
    9- SI el if del metodo seleccionado no se cumple nos devovlera un http_response_code (404) con un status FAIL*/
    $products_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $product_item = array(
        "IdTipoUsuario" => $IdTipoUsuario,
        "Nombre" => $Nombre,
        "Descripcion" => $Descripcion,
        "Estado" => $Estado
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
