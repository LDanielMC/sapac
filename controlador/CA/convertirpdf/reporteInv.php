<?php
include 'plantilla.php';
include '../../../modelo/db.php';

$pdf = new PDF('P', 'mm', 'letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Contar el total de registros por estatus
$estatuses = ['Finalizada', 'En proceso'];
$totales = [];

foreach ($estatuses as $estatus) {
    $query_count = "SELECT COUNT(*) as total FROM investigacion WHERE estatus='$estatus'";
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
    $pdf->Cell(0, 10, "Tabla para estatus: $estatus", 0, 1, 'C');
    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(65, 6, 'IDB', 1, 0, 'C', true);
    $pdf->Cell(65, 6, 'Motivo', 1, 0, 'C', true);
    $pdf->Cell(65, 6, 'Estatus', 1, 1, 'C', true);

    // Obtener registros del estatus actual
    $query = "SELECT idI,titulo, responsable, estatus FROM investigacion WHERE estatus='$estatus'";
    $resultado = mysqli_query($conn, $query);

    $pdf->SetFont('Arial', '', 12);
    while ($row = mysqli_fetch_assoc($resultado)) {
        // IDB
        $pdf->Cell(20, 6, $row['idI'], 1, 0, 'C');

        // Título (MultiCell para manejar texto largo)
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell(90, 6, utf8_decode($row['titulo']), 1, 'L');
        $pdf->SetXY($x + 90, $y);

        // Responsable (MultiCell para manejar texto largo)
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell(50, 6, utf8_decode($row['responsable']), 1, 'L');
        $pdf->SetXY($x + 50, $y);

        // Estatus
        $pdf->Cell(30, 6, utf8_decode($row['estatus']), 1, 1, 'C');
            }
}

$pdf->Output();
?>
