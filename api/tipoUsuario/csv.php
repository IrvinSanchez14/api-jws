 <?php
 include_once '../../config/database.php';
 include_once '../objects/tipoUsuario.php';
 $database = new Database();
 $db = $database->getConnection();
 $tipoUsuario = new tipos_usuario($db);
 $stmt = $tipoUsuario->readAll();
 $num = $stmt->rowCount();
if(!empty($rows= $stmt->fetchAll(PDO::FETCH_ASSOC))){
    $firstRow = $rows[0];
    foreach($firstRow as $colName => $val){
        $columnNames[] = $colName;
    }
}
$fileName = 'TipoUsuario.csv';
header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
$fp = fopen('php://output', 'w');
fputcsv($fp, $columnNames);
foreach ($rows as $row) {
    fputcsv($fp, $row);
}
fclose($fp);