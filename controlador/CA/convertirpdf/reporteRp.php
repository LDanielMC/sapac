<?php
include 'plantilla.php';
include '../../../modelo/db.php';

$pdf = new PDF('P', 'mm', 'letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Contar el total de registros por estatus
$estatuses = ['Sin entregar', 'Pendiente', 'Aceptada', 'Rechazada'];
$totales = [];

foreach ($estatuses as $estatus) {
    $query_count = "SELECT COUNT(*) as total FROM entrega WHERE estado='$estatus'";
    $result_count = mysqli_query($conn, $query_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $totales[$estatus] = $row_count['total'];
}

// Mostrar totales al inicio del PDF

foreach ($totales as $estatus => $total) {
    $pdf->Cell(0, 10, "$estatus: $total", 0, 1, 'C');
}

// Crear tablas para cada estatus
foreach ($estatuses as $estatus) {
    $pdf->AddPage();
    $pdf->Cell(0, 10, "Tabla para estado: $estatus", 0, 1, 'C');
    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(65, 6, 'IDE', 1, 0, 'C', true);
    $pdf->Cell(65, 6, 'feEn', 1, 0, 'C', true);
    $pdf->Cell(65, 6, 'Estado', 1, 1, 'C', true);

    // Obtener registros del estatus actual
    $query = "SELECT idE,feEn, estado FROM entrega WHERE estado='$estatus'";
    $resultado = mysqli_query($conn, $query);

    $pdf->SetFont('Arial', '', 12);
    while ($row = mysqli_fetch_assoc($resultado)) {
        // Ajustando las columnas idE, feEn y estado con MultiCell para texto largo
        $pdf->Cell(30, 6, $row['idE'], 1, 0, 'C'); // IDE

        // feEn (MultiCell para saltos de línea)
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell(60, 6, utf8_decode($row['feEn']), 1, 'L');
        $pdf->SetXY($x + 60, $y); // Ajustar posición para la siguiente celda

        // estado (MultiCell para saltos de línea)
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell(60, 6, utf8_decode($row['estado']), 1, 'L');
        $pdf->SetXY($x + 60 + 30, $y); // Ajustar posición para la siguiente fila

    }
}

$pdf->Output();
?>
