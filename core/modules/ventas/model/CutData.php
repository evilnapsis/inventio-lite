<?php
class CutData {
	public static $tablename = "cut";

	public function CutData(){
		$this->finished_at = "";
		$this->user_id = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (created_at) ";
		$sql .= "value ($this->created_at)";
		return Executor::doit($sql);
	}

	public function update(){
		$sql ="update ".self::$tablename." set finished_at=NOW() where id=$this->id";
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


	public static function getById($id){
		 $sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new CutData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->finished_at = $r['finished_at'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function remainDays(){
		$day_of_cut= "06";
		$breakp = -1;
		for($i=0;$i<4;$i++){
			$dx = date("d",time()+$i*86400);
			if($dx==$day_of_cut){
				$breakp = $i;

			}
		}
		return $breakp;
	}

	public static function DayCut(){
		$breakp = self::remainDays();
		if($breakp>1){
			echo "<p class='alert alert-info'><i class='glyphicon glyphicon-time'></i> Faltan <b>".$breakp." Dias</b> para la fecha de corte, Tome las medidas necesarias.</p>";
		}else if($breakp==1){
			echo "<p class='alert alert-info'><i class='glyphicon glyphicon-time'></i> Se le recuerda que este es el ultimo dia que se trabajara con el corte actual. a partir de el dia de mañana todas las operaciones de entrada-salida se reiniciaran de nuevo. </p>";

		}else if($breakp==0){
			echo "<p class='alert alert-warning'><i class='glyphicon glyphicon-time'></i> Se le recuerda que se esta trabajando sobre un nuevo corte, todas las nuevas operaciones seran registradas en el nuevo corte apartior de hoy..</p>";

		}

	}

	public static function getCut(){
		self::DayCut();
		if(self::getCurrent()!=null){
 		    echo "<p class='alert alert-success'> Se esta trabajando sobre el corte iniciado la fecha (AAAA-MM-DD HH:MM:SS): <b>".self::getCurrent()->created_at."</b></p>";
		}else{
			echo "<p class='alert alert-warning'>Bienvenido al sistema, para iniciar debes crear un cortes, se ha configurado para que los cortes se creen automaticamente todos los dias <b>1ro</b> de cada Mes.</p>";
		}
	}


	public static function getCurrent(){
    	$sql = "select * from ".self::$tablename." where finished_at is NULL";
		$query = Executor::doit($sql);
		$found = null;
		$data = new CutData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->finished_at = $r['finished_at'];
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
			$array[$cnt] = new CutData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->finished_at = $r['finished_at'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id>=$start_from limit $limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CutData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->finished_at = $r['finished_at'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}



}

?>