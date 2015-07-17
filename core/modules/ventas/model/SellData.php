<?php
class SellData {
	public static $tablename = "sell";

	public function SellData(){
		$this->created_at = "NOW()";
	}

	public function getPerson(){ return PersonData::getById($this->person_id);}
	public function getUser(){ return UserData::getById($this->user_id);}

	public function add(){
		$sql = "insert into ".self::$tablename." (user_id,created_at) ";
		echo $sql .= "value ($this->user_id,$this->created_at)";
		return Executor::doit($sql);
	}

	public function add_with_client(){
		$sql = "insert into ".self::$tablename." (person_id,user_id,created_at) ";
		echo $sql .= "value ($this->person_id,$this->user_id,$this->created_at)";
		return Executor::doit($sql);
	}


	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id){
		 $sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new SellData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->user_id = $r['user_id'];
			$data->person_id = $r['person_id'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}



	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SellData();
			$array[$cnt]->id = $r['id'];
		$array[$cnt]->person_id = $r['person_id'];
			$array[$cnt]->user_id = $r['user_id'];
				$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id<=$start_from limit $limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SellData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->person_id = $r['person_id'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


}

?>