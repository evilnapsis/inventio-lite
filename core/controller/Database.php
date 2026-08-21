<?php
class Database {
	public static $db;
	public static $con;
	public static $pdo;

	public $user, $pass, $host, $ddbb;

	function __construct(){
		$this->user="root";$this->pass="";$this->host="localhost";$this->ddbb="inventiolite";
	}

	function connect(){
		$con = new mysqli($this->host,$this->user,$this->pass,$this->ddbb);
		$con->query("set sql_mode=''");
		return $con;
	}

	function connectPdo(){
		$dsn = "mysql:host={$this->host};dbname={$this->ddbb};charset=utf8mb4";
		$pdo = new PDO($dsn, $this->user, $this->pass, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
		]);
		return $pdo;
	}

	public static function getCon(){
		if(self::$con==null){
			if(self::$db==null){
				self::$db = new Database();
			}
			self::$con = self::$db->connect();
		}
		return self::$con;
	}

	public static function getPdo(){
		if(self::$pdo==null){
			if(self::$db==null){
				self::$db = new Database();
			}
			self::$pdo = self::$db->connectPdo();
		}
		return self::$pdo;
	}

}
?>
