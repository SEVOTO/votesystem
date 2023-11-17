<?php
 include 'includes/session.php';
 include 'includes/header.php'; 
require '../../vendor/autoload.php'; // Ruta al archivo autoload de Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $archivo = $_FILES['archivo']['tmp_name'];

    // Leer el archivo Excel y procesar los datos
    if ($archivo) {
        $objPHPExcel = IOFactory::load($archivo);
        $hoja = $objPHPExcel->getActiveSheet();
        $filas = $hoja->getHighestRow();

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

        for ($i = 2; $i <= $filas; $i++) {
            $voters_id = $hoja->getCellByColumnAndRow(1, $i)->getValue();
            $password = $hoja->getCellByColumnAndRow(2, $i)->getValue();
            $firstname = $hoja->getCellByColumnAndRow(3, $i)->getValue();
            $lastname = $hoja->getCellByColumnAndRow(4, $i)->getValue();
            $annio = $hoja->getCellByColumnAndRow(5, $i)->getValue();
            $seccion = $hoja->getCellByColumnAndRow(6, $i)->getValue();
            $photo = $hoja->getCellByColumnAndRow(7, $i)->getValue();

            // Encriptar la contraseña antes de insertarla en la base de datos
            $password = password_hash($password, PASSWORD_DEFAULT);

            // Crear el estudiante en la base de datos
            $sql = "INSERT INTO voters (voters_id, password, firstname, lastname, annio, seccion, photo)
            VALUES ('$voters_id', '$password', '$firstname', '$lastname', '$annio', '$seccion', '$photo')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = 'Voters added successfully';

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No se seleccionó ningún archivo.";
    }
}
header('location: voters.php');
?>
