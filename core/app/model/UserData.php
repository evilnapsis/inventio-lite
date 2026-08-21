<?php
class UserData {
	public static $tablename = "user";
	public $id;
	public $name;
	public $lastname;
	public $username;
	public $email;
	public $password;
	public $image;
	public $is_active;
	public $is_admin;
	public $created_at;

	public function __construct(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add(){
		$stmt = self::db()->prepare(
			"insert into ".self::$tablename." (name,lastname,username,email,is_admin,password,created_at) ".
			"values (:name,:lastname,:username,:email,:is_admin,:password,NOW())"
		);
		$stmt->execute([
			'name' => $this->name,
			'lastname' => $this->lastname,
			'username' => $this->username,
			'email' => $this->email,
			'is_admin' => $this->is_admin ?: 0,
			'password' => $this->password,
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

	// partiendo de que ya tenemos creado un objecto UserData previamente utilizamos el contexto
	public function update(){
		$stmt = self::db()->prepare(
			"update ".self::$tablename." set name=:name, email=:email, username=:username, ".
			"lastname=:lastname, is_active=:is_active, is_admin=:is_admin where id=:id"
		);
		$stmt->execute([
			'name' => $this->name,
			'email' => $this->email,
			'username' => $this->username,
			'lastname' => $this->lastname,
			'is_active' => $this->is_active ?: 0,
			'is_admin' => $this->is_admin ?: 0,
			'id' => $this->id,
		]);
	}

	public function update_passwd(){
		$stmt = self::db()->prepare("update ".self::$tablename." set password=:password where id = :id");
		$stmt->execute(['password' => $this->password, 'id' => $this->id]);
	}

	public static function getById($id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where id = :id");
		$stmt->execute(['id' => $id]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		return $stmt->fetch() ?: null;
	}

	public static function getByMail($mail){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where email = :email");
		$stmt->execute(['email' => $mail]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		return $stmt->fetch() ?: null;
	}

	public static function getAll(){
		$stmt = self::db()->query("select * from ".self::$tablename);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getLike($q){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where name like :q");
		$stmt->execute(['q' => '%'.$q.'%']);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

}

?>
