<?php

if(count($_POST)>0){

 $op = new OperationData();
 $op->product_id = $_POST["product_id"] ;
 $op->operation_type_id=OperationTypeData::getByName("entrada")->id;
if(OperationTypeData::getByName("entrada")->name=="entrada"){
	$op->sell_id="NULL";
}
 $op->q= $_POST["q"];

if($_POST["is_oficial"]=="1"){
	$op->is_oficial = 1;
}else{	
	$op->is_oficial = 0;
}

$add = $op->add();
if($op->is_oficial==1){
 print "<script>window.location='index.php?view=history&product_id=$_POST[product_id]';</script>";
}else{
  //[disabled] print "<script>window.location='index.php?view=historyn&product_id=$_POST[product_id]';</script>";

}

}

?>