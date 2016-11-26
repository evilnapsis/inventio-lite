<?php
include "../core/autoload.php";
include "../core/app/model/ProductData.php";
include "../core/app/model/CategoryData.php";
include "../core/app/model/OperationData.php";
include "../core/app/model/OperationTypeData.php";

require_once '../PhpWord/Autoloader.php';
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

Autoloader::register();

$word = new  PhpOffice\PhpWord\PhpWord();
$product = ProductData::getById($_GET["id"]);
$operations = OperationData::getAllByProductId($product->id);
$entradas = OperationData::GetInputQYesF($product->id);
$disponibles = OperationData::GetQYesF($product->id);
$salidas = -1*OperationData::GetOutputQYesF($product->id);


$section1 = $word->AddSection();
$section1->addText($product->name,array("size"=>22,"bold"=>true,"align"=>"right"));
$section1->addText("Historial del Producto",array("size"=>14,"bold"=>true,"align"=>"right"));


$styleTable = array('borderSize' => 6, 'borderColor' => '888888', 'cellMargin' => 40);
$styleFirstRow = array('borderBottomColor' => '0000FF', 'bgColor' => 'AAAAAA');

$table0 = $section1->addTable("table0");
$table0->addRow();
$table0->addCell()->addText("Entradas");
$table0->addCell()->addText("Disponibles");
$table0->addCell()->addText("Salidas");
$table0->addRow();
$table0->addCell(4000)->addText($entradas);
$table0->addCell(4000)->addText($disponibles);
$table0->addCell(4000)->addText($salidas);

$word->addTableStyle('table0', $styleTable,$styleFirstRow);
$section1->addText("");

$table1 = $section1->addTable("table1");
$table1->addRow();
$table1->addCell()->addText("Cantidad");
$table1->addCell()->addText("Tipo");
$table1->addCell()->addText("Fecha");
foreach($operations as $operation){
$table1->addRow();
$table1->addCell(4000)->addText($operation->q);
$table1->addCell(4000)->addText($operation->getOperationType()->name);
$table1->addCell(4000)->addText($operation->created_at);
}

$word->addTableStyle('table1', $styleTable,$styleFirstRow);
/// datos bancarios

$filename = "history-".time().".docx";
#$word->setReadDataOnly(true);
$word->save($filename,"Word2007");
//chmod($filename,0444);
header("Content-Disposition: attachment; filename='$filename'");
readfile($filename); // or echo file_get_contents($filename);
unlink($filename);  // remove temp file



?>