<?php
/* -- Metodologia de la API --
  1- Se crea una class con el nombre de la tabla para almacenar todas las funciones que se desean utilizar
  2- Cada funcion lleva el nombre de la accion que realizara a la base de datos
  3 - Se declaran 2 variables primarias
    - $conn que viene siendo la variable de conexion
    - $table_name que es el nombre de la tabla en la base de datos
  4 - se crean variables privadas de todos los campos de la tabla
  5 - se crea una funcion publica que es la que nos conecta a la base de datos */
class tipos_usuario
{
  private $conn;
  private $table_name = "tipos_usuario";

  public $IdTipoUsuario;
  public $Nombre;
  public $Descripcion;
  public $Estado;
  public $estadoTexto;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    /* -- Metodo para un SELECT --
    1- se crea la variable $query donde ira la consulta SELECT que se ejecutara
    2- dentro de la variable se concatena la variable $table_name para hacer referencia a la tabla PADRE
    3- si existiera diferentes JOIN se coloca el nombre de la tabla directamente sin concatenacion
    4- se crea la variable $stmt que contendra todo el proceso de ejecuccion del query
      - se hace el llamado a la conexion y se prepara el query a ejecutar
    5- se ejecuta toda la parte SQL y se retorna la misma variable $stmt */
    $query = "SELECT 
                  tu.IdTipoUsuario, tu.Nombre, tu.Descripcion, if(tu.Estado = 0, 'Disponible','Inactivo')AS estadoTexto
                FROM
                  " . $this->table_name . " tu
                ORDER BY
                  tu.FechaActualizacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function create()
  {
    /* -- Metodo para un CREATE
    1- creamos el query para el INSERT en este caso no utilizamos el metodo VALUES si no el SET ya que colocamos los nombres de los campos junto al dato que recibiran
    2- :Campo es donde especificamos la variable que insertara
    3- creamos $stmt para preparar nuestra query
    4- inicializamos la variable del campo y le decimos que sera igual al tipo htmlcahars y le devolvemos la misma variable
      en este paso unicamente es para descomponer nuestra informacion que sera enviada desde el html y se la otorgamos a la variable
    5- $stmt crea los parametros del set :Campo y le coloca la variable que hemos convertido $this-variable 
    6- ejecutamos $stmt y si todo nos funciona bien nos devolvera true de lo contario no entra en el proceso y nos devolvera false*/
    $query = "INSERT INTO " . $this->table_name . "
              SET
                Nombre = :Nombre,
                Descripcion = :Descripcion,
                Estado = :Estado";
    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->Estado = htmlspecialchars(strip_tags($this->Estado));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':Estado', $this->Estado);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function update()
  {
    /* -- Metodo para un UPDATE --
    1- se crea el query update y se colocan los campos y variables que se utilizaran
    2- $stmt preapra el query para inicializar las variables con los camos
    3- inicializamos la variable del campo y le decimos que sera igual al tipo htmlcahars y le devolvemos la misma variable
      en este paso unicamente es para descomponer nuestra informacion que sera enviada desde el html y se la otorgamos a la variable
    4- OJO en nuestro caso siempre pondremos de ultimo el ID que se utilizara para saber que campo se modificara asi mantendremos un estandar
    5- $stmt crea los parametros del set :Campo y le coloca la variable que hemos convertido $this-variable 
    6- ejecutamos $stmt y si todo nos funciona bien nos devolvera true de lo contario no entra en el proceso y nos devolvera false */
    $query = "UPDATE
                " . $this->table_name . "
              SET
                Nombre=:Nombre,
                Descripcion=:Descripcion
              WHERE
                IdTipoUsuario=:IdTipoUsuario";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':IdTipoUsuario', $this->IdTipoUsuario);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function delete()
  {
    /* -- Metodo para un DELETE --
    1- creamos la query DELETE y colocamos el ID que deseamos eliminar
    2- $stmt prepara la query para su inicializacion
    3- le otorgamos valor a la variable ID
    4- creamos el parametro que esta caso indicamos que es el numero 1 haciendo referencia a la posicion y lo otorgamos el valor de la variable
    5- ejecutamos el query */
    $query = "DELETE FROM " . $this->table_name . " WHERE IdTipoUsuario = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));

    $stmt->bindParam(1, $this->IdTipoUsuario);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function changeState()
  {
    $query = "UPDATE
                " . $this->table_name . "
              SET
                Estado=:Estado
              WHERE
                IdTipoUsuario=:IdTipoUsuario";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdTipoUsuario = htmlspecialchars(strip_tags($this->IdTipoUsuario));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdTipoUsuario', $this->IdTipoUsuario);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
