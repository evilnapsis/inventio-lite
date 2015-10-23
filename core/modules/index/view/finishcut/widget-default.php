<?php
$current = CutData::getCurrent();

if($current!=null){
	$current->update();
}
	print "<script>window.location='index.php?view=cuts';</script>";

?>