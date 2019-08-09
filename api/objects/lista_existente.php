<?php
class lista_existente
{
  private $conn;
  private $table_name = "lista_existente";

  public $Sucursal;
  public $Fecha;
  public $IdListaExistene;
  public $Estado;
  public $UsuarioCreador;
  public $IdProducto;
  public $IdPorcion;
  public $Cantidad;

  public function __construct($db)
  {
    $this->conn = $db;
  }


  function create()
  {
    $query = "INSERT INTO lista_existente
              SET
                IdSucursal = :Sucursal,
                FechaPedido=:Fecha,
                IdEstado=:Estado,
                UsuarioCreador=:UsuarioCreador";

    $stmt = $this->conn->prepare($query);
    $this->IdSucursal = htmlspecialchars(strip_tags($this->IdSucursal));
    $this->FechaPedido = htmlspecialchars(strip_tags($this->FechaPedido));
    $this->IdEstado = htmlspecialchars(strip_tags($this->IdEstado));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':Sucursal', $this->IdSucursal);
    $stmt->bindParam(':Fecha', $this->FechaPedido);
    $stmt->bindParam(':Estado', $this->IdEstado);
    $stmt->bindParam(':UsuarioCreador', $this->UsuarioCreador);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  function createDetalle($id, $array)
  {
    $query = "INSERT INTO lista_existente_detalle
              SET
                IdListaExistene = :IdListaExistene,
                IdProducto=:IdProducto,
                IdPorcion=:IdPorcion,
                Cantidad=:Cantidad";

    $stmt = $this->conn->prepare($query);
    $i = 0;
    $len = count($array);
    foreach ($array as $item) {

      $stmt->bindValue(':IdListaExistene', $id);
      $stmt->bindValue(':IdProducto', $item->IdProducto);
      $stmt->bindValue(':IdPorcion', $item->IdPorcion);
      $stmt->bindValue(':Cantidad', $item->Cantidad);
      if ($stmt->execute()) { } else {
        $arr = $stmt->errorInfo();
        print_r($arr);
      }
      if ($i == $len - 1) {
        return true;
      }
      $i++;
    }
  }
}
