<?php
include "../core/autoload.php";
include "../core/app/model/BoxData.php";
include "../core/app/model/SellData.php";
include "../core/app/model/PersonData.php";
include "../core/app/model/OperationData.php";
include "../core/app/model/ProductData.php";

require_once '../PhpWord/Autoloader.php';
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

Autoloader::register();

$word = new  PhpOffice\PhpWord\PhpWord();
$clients = PersonData::getClients();


$section1 = $word->AddSection();
$section1->addText("HISTORIAL DE CAJA",array("size"=>22,"bold"=>true,"align"=>"right"));

$boxes = BoxData::getAll();
$products = SellData::getSellsUnBoxed();


$styleTable = array('borderSize' => 6, 'borderColor' => '888888', 'cellMargin' => 40);
$styleFirstRow = array('borderBottomColor' => '0000FF', 'bgColor' => 'AAAAAA');

$table1 = $section1->addTable("table1");
$table1->addRow();
$table1->addCell()->addText("Total");
$table1->addCell()->addText("Fecha");
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




$table1->addRow();
$table1->addCell(5000)->addText("$ ".number_format($total,2,".",","));
$table1->addCell(2500)->addText($box->created_at);

}
$section1->addText("");
$section1->addText("Total: $".number_format($total_total,2,".",","),array("size"=>22));
$word->addTableStyle('table1', $styleTable,$styleFirstRow);
/// datos bancarios

$filename = "boxhistory-".time().".docx";
#$word->setReadDataOnly(true);
$word->save($filename,"Word2007");
//chmod($filename,0444);
header("Content-Disposition: attachment; filename='$filename'");
readfile($filename); // or echo file_get_contents($filename);
unlink($filename);  // remove temp file



?>