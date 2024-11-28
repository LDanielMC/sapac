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
    $query_count = "SELECT COUNT(*) as total FROM recepcion WHERE estado='$estatus'";
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
    $pdf->Cell(65, 6, 'IDR', 1, 0, 'C', true);
    $pdf->Cell(65, 6, 'feREnt', 1, 0, 'C', true);
    $pdf->Cell(65, 6, 'Estado', 1, 1, 'C', true);

    // Obtener registros del estatus actual
    $query = "SELECT idR, feREnt, estado FROM recepcion WHERE estado='$estatus'";
    $resultado = mysqli_query($conn, $query);

    $pdf->SetFont('Arial', '', 12);
    while ($row = mysqli_fetch_assoc($resultado)) {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Cell(65, 6, utf8_decode($row['idR']), 1, 0, 'C'); // IDR
        
        // Fecha de recepción (MultiCell)
        $x = $pdf->GetX();
        $pdf->MultiCell(65, 6, utf8_decode($row['feREnt']), 1, 'C');
        $pdf->SetXY($x + 65, $y); // Ajustar posición después del MultiCell
        
        // Estado (MultiCell)
        $x = $pdf->GetX();
        $pdf->MultiCell(65, 6, utf8_decode($row['estado']), 1, 'C');
        $pdf->SetXY($x + 65 + 65, $y); // Ajustar posición después del MultiCell
        $pdf->Ln(); // Siguiente fila
        
    }
}

$pdf->Output();
?>
