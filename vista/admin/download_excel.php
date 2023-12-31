<?php
require '../../vendor/autoload.php'; // Ruta al archivo autoload de Composer

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "votesystem";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT voters_id, password, firstname, lastname, annio, seccion, photo FROM voters";
$result = $conn->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Agregar encabezados de columnas
$sheet->setCellValue('A1', 'Cedula');
$sheet->setCellValue('B1', 'Contraseña');
$sheet->setCellValue('C1', 'Nombre');
$sheet->setCellValue('D1', 'Apellido');
$sheet->setCellValue('E1', 'año');
$sheet->setCellValue('F1', 'seccion');
$sheet->setCellValue('G1', 'foto');

$i = 2; 

$writer = new Xlsx($spreadsheet);

// Crear un nombre de archivo único
$fileName = 'Carga Masiva-' . time() . '.xlsx';

// Redirigir al archivo de descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename=' . $fileName);
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>