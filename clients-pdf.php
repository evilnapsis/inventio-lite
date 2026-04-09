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

$clients = PersonData::getClients();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'DIRECTORIO DE CLIENTES',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(232,232,232);
$pdf->Cell(15,10,'ID',1,0,'C',1);
$pdf->Cell(65,10,'Nombre',1,0,'C',1);
$pdf->Cell(60,10,'Direccion',1,0,'C',1);
$pdf->Cell(50,10,'Telefono',1,1,'C',1);

$pdf->SetFont('Arial','',10);

foreach($clients as $client){
    $pdf->Cell(15,10,$client->id,1,0,'C');
    $pdf->Cell(65,10,utf8_decode($client->name." ".$client->lastname),1,0,'L');
    $pdf->Cell(60,10,utf8_decode($client->address1),1,0,'L');
    $pdf->Cell(50,10,$client->phone1,1,1,'L');
}

$pdf->Output();
?>
