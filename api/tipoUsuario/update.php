
<?php /* -- Funcionamiento del llamado a la API readALL --
1- colocamos un IF para identificar que tipo de metodo esperamos al momento de llamar a la API
  --- Tipos de Metodos ---
    GET - Lo utilizamos unicamente cuando realizamos consultas SELECT ya sea para llamar todos los datos o uno en especifico (metodo por URL)
    POST - lo utilizamos unicamente cuando realizamos consultas INSERT los datos son enviados por medio de un JSON
    PUT - Lo utilizamos unicamente cuando realizamos consultas UPDATE los datos son enviador por medio de un JSON
    DELETE - Lo utilizamos unicamente cuando realizamos consultas DELETE los datos son enviados por medio de un JSON */
if ($_SERVER['REQUEST_METHOD'] == "PUT") {
  /* -- Cabeceras y librerias --
  1- header() o cabeceras son las que necesitaremos para otorgarle permisos a nuestra API para poder ser consultado externamente sin ellas la API no podra devolver datos
  2- "Access-Control-Allow-Origin: *" -- Esta cabecera da los permisos de control a los usuarios que nosotros queramos en este caso colocamos el * porque todos tendran acceso a ella
  3- "Content-Type: application/json; charset=UTF-8" -- especificamos de que tipo sera nuesta api en este caso indicamos que sera JSON es decir recibira y devolvera JSON
  4-  "Access-Control-Allow-Methods: PUT" -- Especificamos el metodo que utilizaremos en nuestra api en este momento sera el PUT
  5- "Access-Control-Max-Age: 360" -- indicamos el tiempo maximo que tendra la api de devolver un dato
  6- "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With" -- cabeceras que los navegadors solicitan para el acceso a ella
  7- luego de las cabeceras incluimos las librerias o archivos que utilizaremos en este caso solo necesiamos el de la base de datos y el archivo donde esta nuestra clase tipoUsuario
  */
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: PUT");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once '../../config/database.php';
  include_once '../objects/tipoUsuario.php';
  /* -- Logica de la API --
  1- creamos un objeto que contendra nuestra Database()
  2- creamos una variable que contendra la funcion getConnection() que es la que nos da la conexion hacia la base de datos
  3- Creamos un objeto que contendra la clase de nuestra API tipos_usuario() y dentro de ella mandamos como parametro la conexion a la base de datos
  4- creamos una variable donde recibiremos los datos que son enviados atraves del formulario y lo convertiremos en un JSON con la funcion json_decode() */

  $database = new Database();
  $db = $database->getConnection();
  $tipoUsuario = new tipos_usuario($db);
  $data = json_decode(file_get_contents("php://input"));
  /* -- Creacion de los datos a modificar --
  1- el objeto tipoUsuario se le otorga el valor por cada campo que la tabla a insertar contenga
  2- les asignamos la variable publica de nuestra clase la cual es asignada al objeto anterior
  3- igualamos esto a la $data que hemos descompuesto y lo separamos por el nombre que le ayamos colocado a nuestro campo en el formulario
  ATENCION!!! -- para un mejor desarrollo en la aplicacion tanto del lado de la API como del lado del cliente llamar a nuestras variables y campos del formulario igual a los de la base de datos para no perder la logica al momento de su traslado a la base
  4- se crea un IF donde le colocamos la funcion update() la cual esta en nuestra clase y si devuelve un valor true ejecuta que el usuario es creado si no un error tendremos en el aplicativo */

  $tipoUsuario->IdTipoUsuario = $data->IdTipoUsuario;

  $tipoUsuario->Nombre = $data->Nombre;
  $tipoUsuario->Descripcion = $data->Descripcion;
  $tipoUsuario->Estado = $data->Estado;

  if ($tipoUsuario->update()) {
    http_response_code(200);
    echo json_encode(
      array("message" => "Datos guardados exitosamente en tipoUSuario.")
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