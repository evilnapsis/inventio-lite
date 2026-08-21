<?php
/**
 * Modelo para el registro de movimientos de almacén (entradas y salidas de stock).
 */
class OperationData {
	public static $tablename = "operation";
	public $id;
	public $product_id;
	public $q;
	public $operation_type_id;
	public $sell_id;
	public $created_at;

	public function __construct(){
		$this->product_id = "";
		$this->q = "";
		$this->operation_type_id = "";
		$this->created_at = "NOW()";
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add(){
		$stmt = self::db()->prepare(
			"insert into ".self::$tablename." (product_id,q,operation_type_id,sell_id,created_at) ".
			"values (:product_id,:q,:operation_type_id,:sell_id,NOW())"
		);
		$stmt->execute([
			'product_id' => $this->product_id,
			'q' => $this->q,
			'operation_type_id' => $this->operation_type_id,
			'sell_id' => $this->sell_id,
		]);
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

	// partiendo de que ya tenemos creado un objecto OperationData previamente utilizamos el contexto
	public function update(){
		$stmt = self::db()->prepare("update ".self::$tablename." set product_id=:product_id, q=:q where id=:id");
		$stmt->execute(['product_id' => $this->product_id, 'q' => $this->q, 'id' => $this->id]);
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

	public static function getAllByDateOfficial($start,$end){
		if ($start == $end) {
			$stmt = self::db()->prepare("select * from ".self::$tablename." where date(created_at) = :start order by created_at desc");
			$stmt->execute(['start' => $start]);
		} else {
			$stmt = self::db()->prepare("select * from ".self::$tablename." where date(created_at) >= :start and date(created_at) <= :end order by created_at desc");
			$stmt->execute(['start' => $start, 'end' => $end]);
		}
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAllByDateOfficialBP($product, $start,$end){
		if ($start == $end) {
			$stmt = self::db()->prepare("select * from ".self::$tablename." where date(created_at) = :start order by created_at desc");
			$stmt->execute(['start' => $start]);
		} else {
			$stmt = self::db()->prepare("select * from ".self::$tablename." where date(created_at) >= :start and date(created_at) <= :end and product_id = :product order by created_at desc");
			$stmt->execute(['start' => $start, 'end' => $end, 'product' => $product]);
		}
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public function getProduct(){ return ProductData::getById($this->product_id);}
	public function getOperationtype(){ return OperationTypeData::getById($this->operation_type_id);}

	public static function getQYesF($product_id){
		$q=0;
		$operations = self::getAllByProductId($product_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
				if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
				else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		return $q;
	}

	public static function getAllByProductIdCutId($product_id,$cut_id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where product_id = :product_id and cut_id = :cut_id order by created_at desc");
		$stmt->execute(['product_id' => $product_id, 'cut_id' => $cut_id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAllByProductId($product_id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where product_id = :product_id order by created_at desc");
		$stmt->execute(['product_id' => $product_id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAllByProductIdCutIdOficial($product_id,$cut_id){
		return self::getAllByProductIdCutId($product_id, $cut_id);
	}

	public static function getAllProductsBySellId($sell_id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where sell_id = :sell_id order by created_at desc");
		$stmt->execute(['sell_id' => $sell_id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAllByProductIdCutIdYesF($product_id,$cut_id){
		return self::getAllByProductIdCutId($product_id, $cut_id);
	}

	public static function getOutputQ($product_id,$cut_id){
		$q=0;
		$operations = self::getOutputByProductIdCutId($product_id,$cut_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		return $q;
	}

	public static function getOutputQYesF($product_id){
		$q=0;
		$operations = self::getOutputByProductId($product_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		return $q;
	}

	public static function getInputQYesF($product_id){
		$q=0;
		$operations = self::getInputByProductId($product_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
		}
		return $q;
	}

	public static function getOutputByProductIdCutId($product_id,$cut_id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where product_id = :product_id and cut_id = :cut_id and operation_type_id=2 order by created_at desc");
		$stmt->execute(['product_id' => $product_id, 'cut_id' => $cut_id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getOutputByProductId($product_id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where product_id = :product_id and operation_type_id=2 order by created_at desc");
		$stmt->execute(['product_id' => $product_id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getInputQ($product_id,$cut_id){
		$q=0;
		$operations = self::getInputByProductIdCutId($product_id,$cut_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		return $q;
	}

	public static function getInputByProductIdCutId($product_id,$cut_id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where product_id = :product_id and cut_id = :cut_id and operation_type_id=1 order by created_at desc");
		$stmt->execute(['product_id' => $product_id, 'cut_id' => $cut_id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getInputByProductId($product_id){
		$stmt = self::db()->prepare("select * from ".self::$tablename." where product_id = :product_id and operation_type_id=1 order by created_at desc");
		$stmt->execute(['product_id' => $product_id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getInputByProductIdCutIdYesF($product_id,$cut_id){
		return self::getInputByProductIdCutId($product_id, $cut_id);
	}

}

?>
