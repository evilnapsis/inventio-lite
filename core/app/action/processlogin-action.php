<?php

// define('LBROOT',getcwd()); // LegoBox Root ... the server root
// include("core/controller/Database.php");

if(!isset($_SESSION["user_id"])) {
    $user = $_POST['username'];
    $pass = sha1(md5($_POST['password']));

    $base = new Database();
    $con = $base->connect();

    // Prepare the query
    $stmt = $con->prepare("
        SELECT * FROM user 
        WHERE (email = ? OR username = ?) 
        AND password = ? 
        AND is_active = 1
    ");

    // Bind parameters
    $stmt->bind_param("sss", $user, $user, $pass);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();
    $found = false;
    $userid = null;

    while($r = $result->fetch_assoc()){
        $found = true;
        $userid = $r['id'];
    }

    // Close statement
    $stmt->close();
}

if($found==true) {
//	session_start();
//	print $userid;
	$_SESSION['user_id']=$userid ;
//	setcookie('userid',$userid);
//	print $_SESSION['userid'];
	print "Cargando ... $user";
	print "<script>window.location='index.php?view=home';</script>";
}else {
	print "<script>window.location='index.php?view=login';</script>";
}

}else{
	print "<script>window.location='index.php?view=home';</script>";
	
}
?>