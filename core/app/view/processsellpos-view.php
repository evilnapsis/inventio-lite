<?php
if(isset($_SESSION["cart"])){
	$cart = $_SESSION["cart"];
	if(count($cart)>0){
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){
			$q = OperationData::getQYesF($c["product_id"]);
			if($c["q"]<=$q){
                $num_succ++;
			}else{
				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}
		}

        if($num_succ==count($cart)){
            $process = true;
        }

        if($process==false){
            $error_msg = "";
            foreach($errors as $e){
                $error_msg .= $e["message"] . " ";
            }
            $_SESSION["error"] = $error_msg;
            print "<script>window.location='index.php?view=sellpos';</script>";
        }

		if($process==true){
			$sell = new SellData();
			$sell->user_id = $_SESSION["user_id"];
			$sell->total = $_POST["total"];
			$sell->discount = $_POST["discount"];
            if(isset($_POST["client_id"]) && $_POST["client_id"]!=""){
                $sell->person_id=$_POST["client_id"];
                $s = $sell->add_with_client();
            }else{
                $s = $sell->add();
            }

            foreach($cart as  $c){
                $op = new OperationData();
                $op->product_id = $c["product_id"] ;
                $op->operation_type_id=OperationTypeData::getByName("salida")->id;
                $op->sell_id=$s[1];
                $op->q= $c["q"];
                $op->add();			 		
            }
            unset($_SESSION["cart"]);
            $_SESSION["success"] = "Venta POS procesada correctamente";
            print "<script>window.location='index.php?view=onesell&id=$s[1]';</script>";
		}
	}
}
?>
