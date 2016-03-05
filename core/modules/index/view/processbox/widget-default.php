<?php
$sells = SellData::getSellsUnBoxed();

if(count($sells)){
	$box = new BoxData();
	$b = $box->add();
	foreach($sells as $sell){
		$sell->box_id = $b[1];
		$sell->update_box();
	}
	Core::redir("./index.php?view=b&id=".$b[1]);
}

?>