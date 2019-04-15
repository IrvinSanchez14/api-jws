<?php /* -- Creacion de conexion --
  1- creamos una clase con el nombre de Database (el nombre puede variar)
  2- colocamos las variables que utilizaremos como privare (host, nombre de la base, usuario de la base, contraseña de la base)
  3- creamos una variable publica con el nombre de la conexion
  4- creamos una funcion publica getConnection() para obtener la conexion de nuestra base
  5- inicializamos la variable conn en null para eliminar cualquier dato en cache de PHP
  6- ejecutamos un try and catch
  7- la variable conn le asignamos todos los parametros a utilizar
  8- utilizamos la metodologia PDO para conectarnos a mysql (existen otras por si quieren investigar)
  9- si la conexion es exitosa nos retorna la variable conexion sin ningun problema si no PDOException nos muestra un error a nivel de conexion con MYSQL */
class Database
{
  private $host = "localhost";
  private $db_name = "tesis";
  private $username = "root";
  private $password = "1234";
  public $conn;
  public function getConnection()
  {
    $this->conn = null;
    try {
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }
    return $this->conn;
  }
}
