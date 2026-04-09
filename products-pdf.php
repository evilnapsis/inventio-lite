<?php
include "core/autoload.php";
include "core/app/model/ProductData.php";
include "core/app/model/CategoryData.php";

require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    //$this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',20);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'INVENTIO LITE',0,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$products = ProductData::getAll();

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'LISTADO DE PRODUCTOS',0,1,'C');
$pdf->Ln(5);

// Cabecera de la tabla
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(232,232,232);
$pdf->Cell(20,10,'ID',1,0,'C',1);
$pdf->Cell(80,10,'Nombre',1,0,'C',1);
$pdf->Cell(30,10,'Precio',1,0,'C',1);
$pdf->Cell(30,10,'Categoria',1,0,'C',1);
$pdf->Cell(30,10,'Activo',1,1,'C',1);

$pdf->SetFont('Arial','',10);

foreach($products as $product){
    $pdf->Cell(20,10,$product->id,1,0,'C');
    $pdf->Cell(80,10,utf8_decode($product->name),1,0,'L');
    $pdf->Cell(30,10,"$ ".number_format($product->price_out,2),1,0,'R');
    
    $category = "---";
    if($product->category_id!=null){
        $category = $product->getCategory()->name;
    }
    $pdf->Cell(30,10,utf8_decode($category),1,0,'C');
    
    $active = $product->is_active ? "Si" : "No";
    $pdf->Cell(30,10,$active,1,1,'C');
}

$pdf->Output();
?>
