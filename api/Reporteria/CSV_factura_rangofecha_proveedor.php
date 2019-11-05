<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/excel");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
  http_response_code(200);
  echo "You dont have the correct method";
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

  include_once '../../config/database.php';
  include_once '../objects/reporteria.php';
  $database = new Database();
  $db = $database->getConnection();
  $reporteria = new reporteria($db);
  $data = json_decode(file_get_contents("php://input"));
  $reporteria->FechaDesde = $data->desde;
  $reporteria->FechaHasta = $data->hasta;
  $reporteria->IdProveedor = $data->id_proveedor;
  $stmt = $reporteria->facrangofechyprovee();
  $num = $stmt->rowCount();
  if (!empty($rows = $stmt->fetchAll(PDO::FETCH_ASSOC))) {
    $firstRow = $rows[0];
    foreach ($firstRow as $colName => $val) {
      $columnNames[] = $colName;
    }
  }
  $fileName = 'reporteria.csv';
  header('Content-Disposition: attachment; filename="' . $fileName . '"');
  $fp = fopen('php://output', 'w');
  fputcsv($fp, $columnNames);
  foreach ($rows as $row) {
    fputcsv($fp, $row);
  }
  fclose($fp);
} else {
  http_response_code(404);
}
