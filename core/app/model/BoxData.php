<?php
/**
 * Modelo para representar las sesiones y cortes de caja registrados en la base de datos.
 */
class BoxData {
	public static $tablename = "box";
	public $id;
	public $created_at;

	public function __construct(){
		$this->created_at = "NOW()";
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add(){
		$stmt = self::db()->prepare("insert into ".self::$tablename." (created_at) values (NOW())");
		$stmt->execute();
		$this->id = self::db()->lastInsertId();
		return [true, $this->id];
	}

	public static function delById($id){
		$stmt = self::db()->prepare("delete from ".self::$tablename." where id = :id");
		$stmt->execute(['id' => $id]);
	}
	public function del(){
		self::delById($this->id);
	}

	public static function getById($id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where id = :id");
		$stmt->execute(['id' => $id]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		return $stmt->fetch() ?: null;
	}

	public static function getAll(){
		$stmt = self::db()->query("select * from ".self::$tablename);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

}

?>
