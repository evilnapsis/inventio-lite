<?php
class BitacoraData {
	public static $tablename = "bitacora";
	public $id, $description, $user_id, $module, $action, $created_at ;

	public function __construct(){

		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (description,user_id,module,action,created_at) ";
		$sql .= "value (\"$this->description\",\"$this->user_id\",\"$this->module\",\"$this->action\",$this->created_at)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set description=\"$this->description\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BitacoraData());

	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where module like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());

	}

}

?>