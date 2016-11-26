<?php
// IpLogger
// la funcion de esta clase es :
// obtener la ip del cliente que nos esta visitando y conocer si es un visitante
// o es un usuario registrado.
// >>> en caso de ser visitante, su actividad se registrara como visitante
// dicha informacion se eliminara ca 3 dias
// >>> en caso de ser un usuario registrado, se registrara su actividad
// entonces cuando este usuario visite el perfil de otro, solo se apuntara en visitas 1vez cada 24horas.
// la infomacion de usuarios registrados no se eliminara.

class IpLogger {

public static function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) // encaso de que la ip sea compartida
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) // encaso de provenir de un proxy
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
   
    return $_SERVER['REMOTE_ADDR'];
}

public static function addIP(){
	if(UserLogged::isLogged()){
		if(!self::verifyIP()){
		$con = Database::getCon();
		$sql = "insert into iplog (user_id,realip,created_at) value(".Session::getUID().",\"".self::getRealIP()."\",".time().")";
		$con->query($sql);
		return $con->insert_id;
		}
	}else {
		return false;
	}
}

public static function getIPLogId(){
	$con = Database::getCon();
$sql = "select * from iplog where realip=\"".self::getRealIP()."\" and user_id=".Session::getUID()." order by created_at desc limit 1";
	$query = $con->query($sql);
	$ca = 0;
	$id=0;
	while($r=$query->fetch_array()){
//		$found = true ;
		$ca = $r['created_at'];
		$id = $r['id'];
	}
		$found=false;
		$ca2 = $ca + (24)*3600;
		if(time()>=$ca2){
			$found=true;
		}

		if($found==true){
			// si es mayor enonces generaremos un id nuevo
			$id = self::addIP();
		}else {

		}
		return array("id"=>$id,"ca"=>$ca);

}

public static function verifyIP(){
	$con = Database::getCon();
	$sql = "select * from iplog where realip=\"".self::getRealIP()."\" and user_id=".Session::getUID();
	$query = $con->query($sql);
	$found=false;
	$ca = "" ;
	while($r=$query->fetch_array()){
		$found = true ;
		$ca = $r['created_at'];
	}

	if($found==true){
		$ca2 = $ca + (24)*3600;
		if(time()>=$ca2){
			$found=false;
		}
	}
	return $found;
}

}
?>