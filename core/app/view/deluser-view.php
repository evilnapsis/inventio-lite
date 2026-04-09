<?php

$user = UserData::getById($_GET["id"]);

// evitamos que el usuario logeado se elimine a si mismo por si acaso se accede por URL
if($user->id != $_SESSION["user_id"]){
	$user->del();
}

Core::redir("./index.php?view=users");

?>
