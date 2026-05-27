<?php
include "../core/autoload.php";
include "../core/app/autoload.php";
Core::$root="../";

require('../fpdf/fpdf.php');

if(isset($_GET["id"]) && $_GET["id"]!=""){
    $sell = SellData::getById($_GET["id"]);
    $operations = OperationData::getAllProductsBySellId($_GET["id"]);
    
    // Fetch store name
    $title_config = ConfigurationData::getByShort("title");
    $store_name = $title_config ? $title_config->val : "INVENTIO LITE";
    
    // Calculate page height dynamically
    $item_count = count($operations);
    $page_height = 55 + ($item_count * 6) + 25; // base + items + footer/totals
    if ($page_height < 100) { $page_height = 100; }
    
    $pdf = new FPDF('P', 'mm', array(80, $page_height));
    $pdf->SetMargins(4, 4, 4);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
    
    // Title / Header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(72, 6, utf8_decode($store_name), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(72, 4, 'RESUMEN DE COMPRA #' . $sell->id, 0, 1, 'C');
    $pdf->Cell(72, 4, $sell->created_at, 0, 1, 'C');
    
    $pdf->Cell(72, 2, '---------------------------------------------------------', 0, 1, 'C');
    
    // Provider & operator
    $pdf->SetFont('Arial', '', 8);
    if($sell->person_id!=""){
        $provider = $sell->getPerson();
        $pdf->Cell(72, 4, utf8_decode('Proveedor: ' . $provider->name . ' ' . $provider->lastname), 0, 1);
    }
    if($sell->user_id!=""){
        $user = $sell->getUser();
        $pdf->Cell(72, 4, utf8_decode('Encargado: ' . $user->name . ' ' . $user->lastname), 0, 1);
    }
    
    $pdf->Cell(72, 2, '---------------------------------------------------------', 0, 1, 'C');
    
    // Table Header
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(8, 4, 'Cant', 0, 0);
    $pdf->Cell(38, 4, 'Producto', 0, 0);
    $pdf->Cell(13, 4, 'P.U.', 0, 0, 'R');
    $pdf->Cell(13, 4, 'Total', 0, 1, 'R');
    
    $pdf->Cell(72, 1, '---------------------------------------------------------', 0, 1, 'C');
    
    // Items
    $pdf->SetFont('Arial', '', 8);
    $total = 0;
    foreach($operations as $operation){
        $product = $operation->getProduct();
        $op_total = $operation->q * $product->price_in;
        $total += $op_total;
        
        $pdf->Cell(8, 4, $operation->q, 0, 0);
        $prod_name = utf8_decode($product->name);
        if (strlen($prod_name) > 22) {
            $prod_name = substr($prod_name, 0, 20) . '..';
        }
        $pdf->Cell(38, 4, $prod_name, 0, 0);
        $pdf->Cell(13, 4, '$' . number_format($product->price_in, 1), 0, 0, 'R');
        $pdf->Cell(13, 4, '$' . number_format($op_total, 1), 0, 1, 'R');
    }
    
    $pdf->Cell(72, 2, '---------------------------------------------------------', 0, 1, 'C');
    
    // Totals
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(45, 5, 'TOTAL COMPRA:', 0, 0, 'R');
    $pdf->Cell(27, 5, '$' . number_format($total, 2), 0, 1, 'R');
    
    $pdf->Cell(72, 2, '---------------------------------------------------------', 0, 1, 'C');
    
    // Footer
    $pdf->SetFont('Arial', 'I', 7);
    $pdf->Cell(72, 3, utf8_decode('Resumen de compra para control interno.'), 0, 1, 'C');
    
    $pdf->Output();
}
?>
