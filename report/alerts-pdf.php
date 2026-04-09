<?php
include "../core/autoload.php";
include "../core/app/autoload.php";
Core::$root="../";

require('../fpdf/fpdf.php');

class PDF extends FPDF
{
function Header()
{
    $this->SetFont('Arial','B',20);
    $this->Cell(80);
    $this->Cell(30,10,'INVENTIO LITE',0,0,'C');
    $this->Ln(20);
}
function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$products = ProductData::getAll();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'ALERTAS DE INVENTARIO',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(232,232,232);
$pdf->Cell(20,10,'ID',1,0,'C',1);
$pdf->Cell(100,10,'Nombre',1,0,'C',1);
$pdf->Cell(35,10,'Minima',1,0,'C',1);
$pdf->Cell(35,10,'Disponible',1,1,'C',1);

$pdf->SetFont('Arial','',10);

foreach($products as $product){
    $q=OperationData::getQYesF($product->id);
    if($q<=$product->inventary_min){
        $pdf->Cell(20,10,$product->id,1,0,'C');
        $pdf->Cell(100,10,utf8_decode($product->name),1,0,'L');
        $pdf->Cell(35,10,$product->inventary_min,1,0,'C');
        $pdf->Cell(35,10,$q,1,1,'C');
    }
}

$pdf->Output();
?>
