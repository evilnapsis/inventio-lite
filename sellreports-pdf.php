<?php
include "core/autoload.php";
include "core/app/autoload.php";

require('fpdf/fpdf.php');

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

$operations = array();

if(isset($_GET["sd"]) && isset($_GET["ed"]) && $_GET["sd"]!="" && $_GET["ed"]!=""){
    if($_GET["client_id"]==""){
        $operations = SellData::getAllByDateOp($_GET["sd"],$_GET["ed"],2);
    }
    else{
        $operations = SellData::getAllByDateBCOp($_GET["client_id"],$_GET["sd"],$_GET["ed"],2);
    } 
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'REPORTE DE VENTAS',0,1,'C');

if(isset($_GET["sd"]) && isset($_GET["ed"])){
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,10,'Rango de fechas: '.$_GET["sd"].' al '.$_GET["ed"],0,1,'C');
}

if($_GET["client_id"]!=""){
    $client = PersonData::getById($_GET["client_id"]);
    $pdf->Cell(0,10,'Cliente: '.$client->name." ".$client->lastname,0,1,'C');
}

$pdf->Ln(5);

if(count($operations)>0){
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(232,232,232);
    $pdf->Cell(20,10,'ID',1,0,'C',1);
    $pdf->Cell(40,10,'Subtotal',1,0,'C',1);
    $pdf->Cell(40,10,'Descuento',1,0,'C',1);
    $pdf->Cell(40,10,'Total',1,0,'C',1);
    $pdf->Cell(50,10,'Fecha',1,1,'C',1);

    $pdf->SetFont('Arial','',10);
    $supertotal = 0;
    foreach($operations as $operation){
        $pdf->Cell(20,10,$operation->id,1,0,'C');
        $pdf->Cell(40,10,"$ ".number_format($operation->total,2),1,0,'R');
        $pdf->Cell(40,10,"$ ".number_format($operation->discount,2),1,0,'R');
        $total = $operation->total-$operation->discount;
        $pdf->Cell(40,10,"$ ".number_format($total,2),1,0,'R');
        $pdf->Cell(50,10,$operation->created_at,1,1,'C');
        $supertotal += $total;
    }
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(190,10,'TOTAL DE VENTAS: $ '.number_format($supertotal,2),0,1,'R');
} else {
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(0,10,'No se encontraron resultados para el rango y cliente seleccionados.',0,1,'C');
}

$pdf->Output();
?>
