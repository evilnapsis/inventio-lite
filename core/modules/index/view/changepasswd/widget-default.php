<?php


if(isset($_SESSION["user_id"])){
	$user = UserData::getById($_SESSION["user_id"]);
	$password = sha1(md5($_POST["password"]));
	if($password==$user->password){
		$user->password = sha1(md5($_POST["newpassword"]));
		$user->update_passwd();
		setcookie("password_updated","true");
		print "<script>window.location='logout.php';</script>";
	}else{
		print "<script>window.location='index.php?view=security&msg=invalidpasswd';</script>";		
	}

}else {
		print "<script>window.location='index.php';</script>";
}


?>