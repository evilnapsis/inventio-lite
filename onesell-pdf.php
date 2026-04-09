<?php
include "core/autoload.php";
include "core/app/model/SellData.php";
include "core/app/model/OperationData.php";
include "core/app/model/ProductData.php";
include "core/app/model/PersonData.php";
include "core/app/model/UserData.php";

require('fpdf/fpdf.php');

if(isset($_GET["id"]) && $_GET["id"]!=""){
    $sell = SellData::getById($_GET["id"]);
    $operations = OperationData::getAllProductsBySellId($_GET["id"]);
    $total = 0;

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
    $pdf->Cell(0,10,'RESUMEN DE VENTA #'.$sell->id,0,1,'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial','B',10);
    if($sell->person_id!=""){
        $client = $sell->getPerson();
        $pdf->Cell(30,10,'Cliente: ',0,0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,10,utf8_decode($client->name." ".$client->lastname),0,1);
    }
    if($sell->user_id!=""){
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(30,10,'Atendido por: ',0,0);
        $pdf->SetFont('Arial','',10);
        $user = $sell->getUser();
        $pdf->Cell(0,10,utf8_decode($user->name." ".$user->lastname),0,1);
    }
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(30,10,'Fecha: ',0,0);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,10,$sell->created_at,0,1);
    $pdf->Ln(5);

    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(232,232,232);
    $pdf->Cell(20,10,'Cod',1,0,'C',1);
    $pdf->Cell(20,10,'Cant',1,0,'C',1);
    $pdf->Cell(80,10,'Producto',1,0,'C',1);
    $pdf->Cell(35,10,'Precio U.',1,0,'C',1);
    $pdf->Cell(35,10,'Total',1,1,'C',1);

    $pdf->SetFont('Arial','',10);
    foreach($operations as $operation){
        $product = $operation->getProduct();
        $pdf->Cell(20,10,$product->id,1,0,'C');
        $pdf->Cell(20,10,$operation->q,1,0,'C');
        $pdf->Cell(80,10,utf8_decode($product->name),1,0,'L');
        $pdf->Cell(35,10,"$ ".number_format($product->price_out,2),1,0,'R');
        $op_total = $operation->q * $product->price_out;
        $pdf->Cell(35,10,"$ ".number_format($op_total,2),1,1,'R');
        $total += $op_total;
    }

    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(155,10,'Descuento: ',0,0,'R');
    $pdf->Cell(35,10,"$ ".number_format($sell->discount,2),1,1,'R');
    
    $pdf->Cell(155,10,'Subtotal: ',0,0,'R');
    $pdf->Cell(35,10,"$ ".number_format($total,2),1,1,'R');

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(155,10,'TOTAL: ',0,0,'R');
    $pdf->SetFillColor(200,255,200);
    $pdf->Cell(35,10,"$ ".number_format($total-$sell->discount,2),1,1,'R',1);

    $pdf->Output();
}
?>
