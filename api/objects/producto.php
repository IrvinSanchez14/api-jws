<?php
class Producto
{
  private $conn;
  private $table_name = "productos";
  /*
IdProducto
Nombre
Descripcion
*/
  public $IdProducto;
  public $Nombre;
  public $Descripcion;
  public $UsuarioCreador;
  public $UsuarioActualiza;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readAll()
  {
    $query = "SELECT 
                um.IdProducto, um.Nombre, um.Descripcion,tp.Nombre AS tipoProducto, un.Siglas, p.Nombre AS Proveedor, um.FechaCreacion, if(um.Estado = 0, 'Disponible','Inactivo')AS estadoTexto, tp.IdTipoProducto, un.IdUnidadMedida, p.IdProveedor
              FROM
                productos um
              LEFT JOIN 
                tipo_producto tp ON um.IdTipoProducto=tp.IdTipoProducto
              LEFT JOIN 
                unidad_medida un ON um.IdUnidadMedida=un.IdUnidadMedida
              LEFT JOIN 
              proveedores p ON um.IdProveedor=p.IdProveedor
              ORDER BY
                um.FechaCreacion DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
              SET

                Nombre = :Nombre,
                Descripcion = :Descripcion,
                IdTipoProducto=:tipoProducto,
                IdUnidadMedida=:Siglas,
                IdProveedor=:Proveedor,
                UsuarioCreador=:UsuarioCreador";

    $stmt = $this->conn->prepare($query);
    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));
    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));
    $this->UsuarioCreador = htmlspecialchars(strip_tags($this->UsuarioCreador));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':tipoProducto', $this->IdTipoProducto);
    $stmt->bindParam(':Siglas', $this->IdUnidadMedida);
    $stmt->bindParam(':Proveedor', $this->IdProveedor);
    $stmt->bindParam(':UsuarioCreador', $this->UsuarioCreador);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }


  function update()
  {
    $query = "UPDATE
                " . $this->table_name . "
              SET
                Nombre=:Nombre,
                Descripcion=:Descripcion,
                IdTipoProducto=:tipoProducto,
                IdUnidadMedida=:Siglas,
                IdProveedor=:Proveedor,
                UsuarioActualiza=:UsuarioActualiza
              WHERE
                IdProducto=:IdProducto";
    $stmt = $this->conn->prepare($query);

    $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
    $this->Descripcion = htmlspecialchars(strip_tags($this->Descripcion));
    $this->IdTipoProducto = htmlspecialchars(strip_tags($this->IdTipoProducto));
    $this->IdUnidadMedida = htmlspecialchars(strip_tags($this->IdUnidadMedida));
    $this->IdProveedor = htmlspecialchars(strip_tags($this->IdProveedor));
    $this->UsuarioActualiza = htmlspecialchars(strip_tags($this->UsuarioActualiza));
    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));

    $stmt->bindParam(':Nombre', $this->Nombre);
    $stmt->bindParam(':Descripcion', $this->Descripcion);
    $stmt->bindParam(':tipoProducto', $this->IdTipoProducto);
    $stmt->bindParam(':Siglas', $this->IdUnidadMedida);
    $stmt->bindParam(':Proveedor', $this->IdProveedor);
    $stmt->bindParam(':UsuarioActualiza', $this->UsuarioActualiza);
    $stmt->bindParam(':IdProducto', $this->IdProducto);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE IdProducto = ?";
    $stmt = $this->conn->prepare($query);

    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));

    $stmt->bindParam(1, $this->IdProducto);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
  function validatename()
  {
    $query = "SELECT 
                IdProducto, Nombre 
              FROM 
                " . $this->table_name . "
              WHERE 
                Nombre = ? ";

    $stmt = $this->conn->prepare($query);
    $this->NombreP = htmlspecialchars(strip_tags($this->NombreP));
    $stmt->bindParam(1, $this->NombreP);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->IdProducto = $row['IdProducto'];
      $this->Nombre = $row['Nombre'];
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
                IdProducto=:IdProducto";
    $stmt = $this->conn->prepare($query);

    $this->Estado = htmlspecialchars(strip_tags($this->Estado));
    $this->IdProducto = htmlspecialchars(strip_tags($this->IdProducto));

    $stmt->bindParam(':Estado', $this->Estado);
    $stmt->bindParam(':IdProducto', $this->IdProducto);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function enviarEmail( $asunto, $cuerpo)
  { //funcion de enviar email, recibe el email, el nombre, asunto y cuerpo

    require_once '../../login/PHPMailer/PHPMailerAutoload.php'; //lebreria phpmailer se usa para el funcionamiento del envio de correo

    $mail = new PHPMailer();
    $mail->isSMTP(); // protocolo de transferencia de correo
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl'; //habilita la encriptacion SSL
    $mail->Host = 'smtp.gmail.com'; // Servidor GMAIL
    $mail->Port = 465; //puerto

    $mail->Username = 'lapizzeriapassrecovery@gmail.com'; //correo emisor
    $mail->Password = 'lapizzeria2019'; //contraseña del correo del emisor

    $mail->setFrom('lapizzeriapassrecovery@gmail.com', 'La Pizzeria'); //se establece quien envia el correo
    $mail->addAddress('raul.sosa@outlook.com', 'Raul'); //email y nombre del receptor guardados en sus respectivas variables

    $mail->Subject = $asunto; //se configura cual es el asunto del correo
    $mail->Body    = $cuerpo; //se configura cual es el cuerpo del correo
    $mail->IsHTML(true);

    if ($mail->send())
      return true;
    else
      return false;
  }

}
