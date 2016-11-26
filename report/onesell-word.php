<?php
include "../core/autoload.php";
include "../core/app/model/PersonData.php";
include "../core/app/model/UserData.php";
include "../core/app/model/SellData.php";
include "../core/app/model/OperationData.php";
include "../core/app/model/OperationTypeData.php";
include "../core/app/model/ProductData.php";

require_once '../PhpWord/Autoloader.php';
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

Autoloader::register();

$word = new  PhpOffice\PhpWord\PhpWord();

$sell = SellData::getById($_GET["id"]);
$operations = OperationData::getAllProductsBySellId($_GET["id"]);
if($sell->person_id!=null){ $client = $sell->getPerson();}
$user = $sell->getUser();


$section1 = $word->AddSection();
$section1->addText("RESUMEN DE VENTA",array("size"=>22,"bold"=>true,"align"=>"right"));


$styleTable = array('borderSize' => 6, 'borderColor' => '888888', 'cellMargin' => 40);
$styleFirstRow = array('borderBottomColor' => '0000FF', 'bgColor' => 'AAAAAA');

$total=0;

$table1 = $section1->addTable("table1");
$table1->addRow();
$table1->addCell(3000)->addText("Atendido por");
$table1->addCell(9000)->addText($user->name." ".$user->lastname);

if($sell->person_id!=null){
	$table1->addRow();
$table1->addCell()->addText("Cliente");
$table1->addCell()->addText($client->name." ".$client->lastname);
}
$section1->addText("");

$table2 = $section1->addTable("table2");
$table2->addRow();
$table2->addCell(1000)->addText("Codigo");
$table2->addCell(1000)->addText("Cantidad");
$table2->addCell(6000)->addText("Nombre del producto");
$table2->addCell(1000)->addText("P.U");
$table2->addCell(2000)->addText("Total");

foreach($operations as $operation){
	$product = $operation->getProduct();
	$table2->addRow();
$table2->addCell()->addText($product->id);
$table2->addCell()->addText($operation->q);
$table2->addCell()->addText($product->name);
$table2->addCell()->addText("$".number_format($product->price_out,2,".",","));
$table2->addCell()->addText("$".number_format($operation->q*$product->price_out,2,".",","));
$total+=$operation->q*$product->price_out;
}

$section1->addText("");
$section1->addText("Total: $".number_format($total,2,".",","),array("size"=>20));

$word->addTableStyle('table1', $styleTable);
$word->addTableStyle('table2', $styleTable,$styleFirstRow);


/// datos bancarios

$filename = "onesell-".time().".docx";
#$word->setReadDataOnly(true);
$word->save($filename,"Word2007");
//chmod($filename,0444);
header("Content-Disposition: attachment; filename='$filename'");
readfile($filename); // or echo file_get_contents($filename);
unlink($filename);  // remove temp file



?>