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

$boxes = BoxData::getAll();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'HISTORIAL DE CAJA',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(232,232,232);
$pdf->Cell(95,10,'Total',1,0,'C',1);
$pdf->Cell(95,10,'Fecha',1,1,'C',1);

$pdf->SetFont('Arial','',10);
$total_total = 0;

foreach($boxes as $box){
    $sells = SellData::getByBoxId($box->id);
    $total=0;
    foreach($sells as $sell){
        $operations = OperationData::getAllProductsBySellId($sell->id);
        foreach($operations as $operation){
            $product  = $operation->getProduct();
            $total += $operation->q*$product->price_out;
        }
    }
    $total_total += $total;

    $pdf->Cell(95,10,"$ ".number_format($total,2),1,0,'C');
    $pdf->Cell(95,10,$box->created_at,1,1,'C');
}

$pdf->Ln(10);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'TOTAL ACUMULADO: $ '.number_format($total_total,2),0,1,'R');

$pdf->Output();
?>
