<?php
/**
 * operation_type_id: 2 = venta, 1 = "re" (remision/compra) -- ver modulo Repos, sin migrar todavia.
 * add()/add_with_client()/add_re()/add_re_with_client() devuelven [true, insertId] -- ese
 * insertId (indice 1) sigue siendo usado por processre-view.php y processrepos-view.php (legacy).
 */
class SellData {
	public static $tablename = "sell";
	public $id;
	public $person_id;
	public $user_id;
	public $operation_type_id;
	public $box_id;
	public $total;
	public $cash;
	public $discount;
	public $created_at;
	public $date;

	public function __construct(){
		$this->created_at = "NOW()";
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function getPerson(){ return PersonData::getById($this->person_id);}
	public function getUser(){ return UserData::getById($this->user_id);}

	public function add(){
		$stmt = self::db()->prepare(
			"insert into ".self::$tablename." (total,discount,user_id,created_at) values (:total,:discount,:user_id,NOW())"
		);
		$stmt->execute(['total' => $this->total, 'discount' => $this->discount, 'user_id' => $this->user_id]);
		$this->id = self::db()->lastInsertId();
		return [true, $this->id];
	}

	public function add_re(){
		$stmt = self::db()->prepare(
			"insert into ".self::$tablename." (user_id,operation_type_id,created_at) values (:user_id,1,NOW())"
		);
		$stmt->execute(['user_id' => $this->user_id]);
		$this->id = self::db()->lastInsertId();
		return [true, $this->id];
	}

	public function add_with_client(){
		$stmt = self::db()->prepare(
			"insert into ".self::$tablename." (total,discount,person_id,user_id,created_at) values (:total,:discount,:person_id,:user_id,NOW())"
		);
		$stmt->execute(['total' => $this->total, 'discount' => $this->discount, 'person_id' => $this->person_id, 'user_id' => $this->user_id]);
		$this->id = self::db()->lastInsertId();
		return [true, $this->id];
	}

	public function add_re_with_client(){
		$stmt = self::db()->prepare(
			"insert into ".self::$tablename." (person_id,operation_type_id,user_id,created_at) values (:person_id,1,:user_id,NOW())"
		);
		$stmt->execute(['person_id' => $this->person_id, 'user_id' => $this->user_id]);
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

	public function update_box(){
		$stmt = self::db()->prepare("update ".self::$tablename." set box_id = :box_id where id = :id");
		$stmt->execute(['box_id' => $this->box_id, 'id' => $this->id]);
	}

	public static function getById($id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where id = :id");
		$stmt->execute(['id' => $id]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		return $stmt->fetch() ?: null;
	}

	public static function getSells(){
		$stmt = self::db()->query("select * from ".self::$tablename." where operation_type_id=2 order by created_at desc");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getSellsUnBoxed(){
		$stmt = self::db()->query("select * from ".self::$tablename." where operation_type_id=2 and box_id is NULL order by created_at desc");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getByBoxId($id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where operation_type_id=2 and box_id = :id order by created_at desc");
		$stmt->execute(['id' => $id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getRes(){
		$stmt = self::db()->query("select * from ".self::$tablename." where operation_type_id=1 order by created_at desc");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAllByPage($start_from,$limit){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where id <= :start_from limit ".((int)$limit));
		$stmt->execute(['start_from' => (int)$start_from]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAllByDateOp($start,$end,$op){
		$stmt = self::db()->prepare(
			"select * from ".self::$tablename." where date(created_at) >= :start and date(created_at) <= :end and operation_type_id = :op order by created_at desc"
		);
		$stmt->execute(['start' => $start, 'end' => $end, 'op' => $op]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	// Nota: legacy filtraba por "client_id", columna que no existe en `sell` (es person_id) y
	// producia un error SQL cada vez que se usaba. Corregido al migrar Reportes, unico consumidor.
	public static function getAllByDateBCOp($clientid,$start,$end,$op){
		$stmt = self::db()->prepare(
			"select * from ".self::$tablename." where date(created_at) >= :start and date(created_at) <= :end and person_id = :clientid and operation_type_id = :op order by created_at desc"
		);
		$stmt->execute(['start' => $start, 'end' => $end, 'clientid' => $clientid, 'op' => $op]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getSellsLast30Days(){
		$stmt = self::db()->query(
			"select date(created_at) as date, sum(total) as total from ".self::$tablename.
			" where operation_type_id=2 and created_at >= date_sub(now(), interval 30 day) group by date(created_at) order by date(created_at) asc"
		);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

}

?>
