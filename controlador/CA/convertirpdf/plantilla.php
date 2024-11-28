<?php
	require 'fpdf/fpdf.php';
	
	class PDF extends FPDF
	{
		function Header()
		{
			$this->SetFont('Arial','B',24);
			$this->Cell(40);
			$this->Cell(120,30,'Totales por estatus:',0,0,'C');
			$this->Ln(40);
		}
		
		function Footer()
		{
			
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}		
	}
?>