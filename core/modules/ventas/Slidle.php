<?php


// esta clase esta hecha para crear funciones generales que ayuden a minificar el codigo.

class Slidle {

	public static $user = null;
	public static $posts = null;

	public static function isValid(){
		if(Session::getUID()!=""){ return true; }
		return false;
	}

	public static function renderUserCard(){

	$name = self::$user->name;	
	$lastname = self::$user->lastname;
	$num_posts = count(self::$posts);
	$loveds = count(LoveData::getAllByUserId(self::$user->id));
		print <<<RRR
		 <h2>$name $lastname</h2>
			<a href="index.php?view=newpost" class="btn btn-lg btn-block btn-default"><i class='glyphicon glyphicon-file'></i> Nuevo Slide</a>
			<br><table class="table table-bordered" style="background:white;">
			<tr>
				<td colspan="4" style="background:#333;color:white;font-weight:bold;">Estadisticas</td>
			</tr>
			<tr>
				<td>Slidles
				<center><h2>$num_posts</h2></center>
				</td>
				<td>Loved
				<center><h2>$loveds</h2></center>
				</td>
				<td>Siguendo</td>
				<td>Seguidores</td>
			</tr>
		</table>
RRR;
	}

	public static function renderSlidles(){
		if(count(self::$posts)>0){
			$posts10 = PostData::get10ByUserId(self::$user->id);
			$last_id = null;

			// recorremos todos los posts
			foreach($posts10 as $post){
				$post_id = $post->id;
				$post_title = $post->title;
				$post_content = $post->content;
				$theme = ThemeData::getById($post->theme_id);
				$header_background_color = $theme->header_background_color;
				$header_text_color = $theme->header_text_color;
				$body_background_color = $theme->body_background_color;
				$body_text_color = $theme->body_text_color;
				$content = $post_content;
				$buttons = "";
				$love_button = "";
				$user_id = self::$user->id;

				$loved  = LoveData::LoveId($post->id);

				if($loved==true){
					$love_button = '<button class="btn btn-danger"><i class="glyphicon glyphicon-heart"></i> Love It</button>';
				}else{
					$love_button = <<<LLL
<button id="loveit-$post_id" class="btn btn-default "><i class="glyphicon glyphicon-heart"></i> Love It</button>
<script>
$("#loveit-"+"$post_id").click(function(){
	xhr = new XMLHttpRequest();
	xhr.open("POST","index.php?view=loveit"+"&postid=$post_id",false);
	xhr.send();
	console.log(xhr.responseText);
	$("#loveit-"+"$post_id").removeClass("btn-default");
	$("#loveit-"+"$post_id").addClass("btn-danger");
});
</script>
LLL;
				}

				if($post->image==null){
					$content = $post_content;
				}
				$buttons .= '<button id="reslidle-$post_id" class="btn btn-default "><i class="glyphicon glyphicon-th-large"></i> Reslidle It</button> ';
				$buttons .= $love_button;

				print <<<XXX
				<div class="row">
					<div class="col-md-12">
						<div class="slide" style="box-shadow:-1px 1px 10px #999;">
							<div class="header" style="background:$header_background_color;color:$header_text_color;padding:10px;">

								<div class="btn-group pull-right">
								  <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
								<i class="glyphicon glyphicon-chevron-down"></i>
								  </button>
								  <ul class="dropdown-menu" role="menu">
								    <li><a href="index.php?view=post&id=$post_id" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> Ver</a></li>
								    <li><a href="index.php?view=editpost&id=$post_id"><i class="glyphicon glyphicon-pencil"></i> Editar</a></li>
								    <li class="divider"></li>
								    <li><a href="#"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
								  </ul>
								</div>
			
							<div style="font-size:26px;">$post_title</div>
							</div>

							<div class="body" style="background:$body_background_color;color:$theme->body_text_color;padding:10px;font-size:18px;font-wieght:none;">
							<p>$content</p>
							<div class='pull-right'>
							$buttons
							</div>
							<div class='clearfix'></div>

							</div>

						</div>	
						<br>				
					</div>
				</div>


XXX;
			$last_id  = $post_id;
			}/// aqui termina el foreach

				if(count(self::$posts)>10){
				print "<div id='more-1'><button id='btn-more-1' class='btn btn-default btn-lg btn-block'><i class='glyphicon glyphicon-refresh'></i> Cargar mas ...</button></div>";
print <<<MMM
			<script>
				$("#btn-more-1").click(function(){
					xhr = new XMLHttpRequest();
					xhr.open("GET","loadsldl.php?uid=$user_id&from=$last_id&ref=2",false);
					xhr.send();
					$("#more-1").html(xhr.responseText);
				});
			</script>
MMM;
}
		}
	}


	////////////////////////////////////////////////////////////////////////////////////////////////
	public static function renderSearch(){
		if(count(self::$posts)>0){
			$last_id = null;

			// recorremos todos los posts
			foreach(self::$posts as $post){
				$post_id = $post->id;
				$post_title = $post->title;
				$post_content = $post->content;
				$theme = ThemeData::getById($post->theme_id);
				$header_background_color = $theme->header_background_color;
				$header_text_color = $theme->header_text_color;
				$body_background_color = $theme->body_background_color;
				$body_text_color = $theme->body_text_color;
				$content = $post_content;
				$buttons = "";
				$love_button = "";
				$user_id = Session::getUID();

				$loved  =  false; //LoveData::LoveId($post->id);

				if($loved==true){
					$love_button = '<button class="btn btn-danger"><i class="glyphicon glyphicon-heart"></i> Love It</button>';
				}else{
					$love_button = <<<LLL
<button id="loveit-$post_id" class="btn btn-default "><i class="glyphicon glyphicon-heart"></i> Love It</button>
<script>
$("#loveit-"+"$post_id").click(function(){
	xhr = new XMLHttpRequest();
	xhr.open("POST","index.php?view=loveit"+"&postid=$post_id",false);
	xhr.send();
	console.log(xhr.responseText);
	$("#loveit-"+"$post_id").removeClass("btn-default");
	$("#loveit-"+"$post_id").addClass("btn-danger");
});
</script>
LLL;
				}

				if($post->image==null){
					$content = $post_content;
				}
				$buttons .= '<button id="reslidle-$post_id" class="btn btn-default "><i class="glyphicon glyphicon-th-large"></i> Reslidle It</button> ';
				$buttons .= $love_button;

				print <<<XXX
				<div class="row">
					<div class="col-md-12">
						<div class="slide" style="box-shadow:-1px 1px 10px #999;">
							<div class="header" style="background:$header_background_color;color:$header_text_color;padding:10px;">

								<div class="btn-group pull-right">
								  <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
								<i class="glyphicon glyphicon-chevron-down"></i>
								  </button>
								  <ul class="dropdown-menu" role="menu">
								    <li><a href="index.php?view=post&id=$post_id" target="_blank"><i class="glyphicon glyphicon-eye-open"></i> Ver</a></li>
								    <li><a href="index.php?view=editpost&id=$post_id"><i class="glyphicon glyphicon-pencil"></i> Editar</a></li>
								    <li class="divider"></li>
								    <li><a href="#"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
								  </ul>
								</div>
			
							<div style="font-size:26px;">$post_title</div>
							</div>

							<div class="body" style="background:$body_background_color;color:$theme->body_text_color;padding:10px;font-size:18px;font-wieght:none;">
							<p>$content</p>
							<div class='pull-right'>
							$buttons
							</div>
							<div class='clearfix'></div>

							</div>

						</div>	
						<br>				
					</div>
				</div>


XXX;
			$last_id  = $post_id;
			}/// aqui termina el foreach

				if(count(self::$posts)>10){
				print "<div id='more-1'><button id='btn-more-1' class='btn btn-default btn-lg btn-block'><i class='glyphicon glyphicon-refresh'></i> Cargar mas ...</button></div>";
print <<<MMM
			<script>
				$("#btn-more-1").click(function(){
					xhr = new XMLHttpRequest();
					xhr.open("GET","loadsldl.php?uid=$user_id&from=$last_id&ref=2",false);
					xhr.send();
					$("#more-1").html(xhr.responseText);
				});
			</script>
MMM;
}
		}else {
			echo "<div class='jumbotron' style='background:#e74c3c;color:white;'><h2>No hay resultados.</h2><p>No hay resultados de su peticion de busqueda,le recomendamos verificar sus palabras clave.</p></div>";
		}
	}

}


?>