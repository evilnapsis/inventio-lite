<?php
class Database {
	public static $db;
	public static $con;
	public $user;
	public $pass;
	public $host;
	public $ddbb;
	function Database(){
		$this->user="root";$this->pass="";$this->host="localhost";$this->ddbb="inventiolite";
	}

	function connect(){
		$this->user="root";$this->pass="";$this->host="localhost";$this->ddbb="inventiolite";
		$con = new mysqli($this->host,$this->user,$this->pass,$this->ddbb);
		$con->query("set sql_mode=''");
		return $con;
	}

	public static function getCon(){
		if(self::$con==null && self::$db==null){
			self::$db = new Database();
			self::$con = self::$db->connect();
		}
		return self::$con;
	}
	
}
?>
