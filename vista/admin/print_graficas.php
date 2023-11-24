<?php

require_once('../../vendor/tecnickcom/tcpdf/tcpdf.php');
// Crea un nuevo objeto de tipo TCPDF
$pdf = new TCPDF();

// Agrega una página
$pdf->AddPage();

// Captura el contenido de la vista
ob_start();
include 'vista_graficas.php';
$html = ob_get_clean();

// Escribe el contenido de la vista en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Genera el archivo PDF
$pdf->Output('vista_graficas.pdf', 'F');