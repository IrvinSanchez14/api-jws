<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/excel");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  http_response_code(200);
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  http_response_code(200);
  echo "You dont have the correct method";
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {

include_once '../../config/database.php';
include_once '../objects/tipo_producto.php';
 $database = new Database();
 $db = $database->getConnection();
 $TipoProducto = new TipoProducto($db);
 $stmt = $TipoProducto->readAll();
 $num = $stmt->rowCount();
if(!empty($rows= $stmt->fetchAll(PDO::FETCH_ASSOC))){
    $firstRow = $rows[0];
    foreach($firstRow as $colName => $val){
        $columnNames[] = $colName;
    }
}
$fileName = 'TipoProducto.csv';
header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
$fp = fopen('php://output', 'w');
fputcsv($fp, $columnNames);
foreach ($rows as $row) {
    fputcsv($fp, $row);
}
fclose($fp);

}
else {
    http_response_code(404);
  }
  