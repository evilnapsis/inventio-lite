<?php
include "../core/autoload.php";
include "../core/app/autoload.php";
Core::$root="../";

require('../fpdf/fpdf.php');

if(isset($_GET["id"]) && $_GET["id"]!=""){
    $product = ProductData::getById($_GET["id"]);
    $operations = OperationData::getAllByProductId($product->id);
    $entradas = OperationData::GetInputQYesF($product->id);
    $disponibles = OperationData::GetQYesF($product->id);
    $salidas = -1*OperationData::GetOutputQYesF($product->id);

    class PDF extends FPDF {
        function Header() {
            $this->SetFont('Arial','B',20);
            $this->Cell(80);
            $this->Cell(30,10,'INVENTIO LITE',0,0,'C');
            $this->Ln(20);
        }
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,utf8_decode('HISTORIAL DEL PRODUCTO: '.$product->name),0,1,'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(232,232,232);
    $pdf->Cell(63,10,'Entradas',1,0,'C',1);
    $pdf->Cell(63,10,'Disponibles',1,0,'C',1);
    $pdf->Cell(64,10,'Salidas',1,1,'C',1);
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(63,10,$entradas,1,0,'C');
    $pdf->Cell(63,10,$disponibles,1,0,'C');
    $pdf->Cell(64,10,$salidas,1,1,'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,10,'Cantidad',1,0,'C',1);
    $pdf->Cell(60,10,'Tipo',1,0,'C',1);
    $pdf->Cell(90,10,'Fecha',1,1,'C',1);

    $pdf->SetFont('Arial','',10);
    foreach($operations as $operation){
        $pdf->Cell(40,10,$operation->q,1,0,'C');
        $pdf->Cell(60,10,$operation->getOperationType()->name,1,0,'C');
        $pdf->Cell(90,10,$operation->created_at,1,1,'C');
    }

    $pdf->Output();
}
?>
