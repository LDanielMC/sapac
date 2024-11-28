<?php
include 'plantilla.php';
include '../../../modelo/db.php';

$pdf = new PDF('P', 'mm', 'letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Contar el total de registros por estatus
$estatuses = ['Activo', 'Inactivo'];
$totales = [];

foreach ($estatuses as $estatus) {
    $query_count = "SELECT COUNT(*) as total FROM empleado INNER JOIN contrato ON empleado.idEmp = contrato.idEmp WHERE contrato.estatus = '$estatus'";
    $result_count = mysqli_query($conn, $query_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $totales[$estatus] = $row_count['total'];
}

// Mostrar totales al inicio del PDF
$pdf->Cell(0, 10, 'Totales por estatus:', 0, 1, 'C');
foreach ($totales as $estatus => $total) {
    $pdf->Cell(0, 10, "$estatus: $total", 0, 1, 'C');
}

// Crear tablas para cada estatus
foreach ($estatuses as $estatus) {
    $pdf->AddPage();
    $pdf->Cell(0, 10, "Tabla para estatus: $estatus", 0, 1, 'C');
    $pdf->SetFillColor(220, 220, 220);
    $pdf->SetFont('Arial', 'B', 12);

    // Encabezados de la tabla
    $pdf->Cell(50, 6, 'IDB', 1, 0, 'C', true);
    $pdf->Cell(50, 6, 'Nombre', 1, 0, 'C', true);
    $pdf->Cell(50, 6, 'Apellido', 1, 0, 'C', true);
    $pdf->Cell(40, 6, 'Estatus', 1, 1, 'C', true);

    // Obtener registros del estatus actual
    $query = "SELECT empleado.idEmp, empleado.nombre, empleado.apellidop, contrato.estatus 
        FROM empleado INNER JOIN contrato ON empleado.idEmp = contrato.idEmp 
        WHERE contrato.estatus = '$estatus'";
    $resultado = mysqli_query($conn, $query);

    $pdf->SetFont('Arial', '', 12);
    while ($row = mysqli_fetch_assoc($resultado)) {
        $pdf->Cell(50, 6, $row['idEmp'], 1, 0, 'C');
        $x = $pdf->GetX(); // Posición X para la siguiente celda
        $y = $pdf->GetY(); // Posición Y actual

        // Nombre (MultiCell para saltos de línea)
        $pdf->MultiCell(50, 6, utf8_decode($row['nombre']), 1, 'C');
        $pdf->SetXY($x + 50, $y); // Ajustar posición para continuar con la siguiente celda

        // Apellido (MultiCell para saltos de línea)
        $pdf->MultiCell(50, 6, utf8_decode($row['apellidop']), 1, 'C');
        $pdf->SetXY($x + 100, $y); // Ajustar posición para continuar con la siguiente celda

        // Estatus
        $pdf->Cell(40, 6, $row['estatus'], 1, 1, 'C');
    }
}

$pdf->Output();
?>
