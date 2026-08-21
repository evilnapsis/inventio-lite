<?php
/**
 * Modelo unificado para Clientes (kind=1) y Proveedores (kind=2).
 */
class PersonData {
	public static $tablename = "person";
	public $id;
	public $image;
	public $name;
	public $lastname;
	public $company;
	public $address1;
	public $address2;
	public $phone1;
	public $phone2;
	public $email1;
	public $email2;
	public $kind;
	public $created_at;

	public function __construct(){
		$this->name = "";
		$this->lastname = "";
		$this->email1 = "";
		$this->image = "";
		$this->created_at = "NOW()";
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add($kind){
		$stmt = self::db()->prepare(
			"insert into ".self::$tablename." (name,lastname,address1,email1,phone1,kind,created_at) ".
			"values (:name,:lastname,:address1,:email1,:phone1,:kind,NOW())"
		);
		$stmt->execute([
			'name' => $this->name,
			'lastname' => $this->lastname,
			'address1' => $this->address1,
			'email1' => $this->email1,
			'phone1' => $this->phone1,
			'kind' => $kind,
		]);
		$this->id = self::db()->lastInsertId();
	}

	public static function delById($id){
		$stmt = self::db()->prepare("delete from ".self::$tablename." where id = :id");
		$stmt->execute(['id' => $id]);
	}
	public function del(){
		self::delById($this->id);
	}

	// partiendo de que ya tenemos creado un objecto PersonData previamente utilizamos el contexto
	public function update(){
		$stmt = self::db()->prepare(
			"update ".self::$tablename." set name=:name, email1=:email1, address1=:address1, ".
			"lastname=:lastname, phone1=:phone1 where id=:id"
		);
		$stmt->execute([
			'name' => $this->name,
			'email1' => $this->email1,
			'address1' => $this->address1,
			'lastname' => $this->lastname,
			'phone1' => $this->phone1,
			'id' => $this->id,
		]);
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

	public static function getClients(){
		return self::getByKind(1);
	}

	public static function getProviders(){
		return self::getByKind(2);
	}

	private static function getByKind($kind){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where kind = :kind order by name, lastname");
		$stmt->execute(['kind' => $kind]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getLike($q){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where name like :q");
		$stmt->execute(['q' => '%'.$q.'%']);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

}

?>
