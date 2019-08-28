<?php
/*-------------------------------------------------------------------------------------------------
@Module: moviezone_view.php
This server-side module provides all required functionality to format and display movie in html

@Author: md redoy
@Modified by: 
@Date: 05/08/2019
--------------------------------------------------------------------------------------------------*/

class MovieZoneAdminView {
	/*Class contructor: performs any initialization
	*/
	public function __construct() {		
	}
	
	/*Class destructor: performs any deinitialiation
	*/		
	public function __destruct() {		
	}
	
	/*Creates left navigation panel
	*/
	public function leftNavPanel() {
		print file_get_contents('html/leftnav.html');
	}



	
	/*Creates top navigation panel
	*/	
	public function topNavPanel($director, $actor, $genre) {
		print "
		<div style='color: #0e5968; float:left;'>
			<div class='topnav'>
			<label for='director'><b>Search by Director:</b></label><br>
			<select name='director' id='id_director' onchange='movieFilterChanged();'>
				<option value='all'>Select all</option>
		";
		//------------------
		foreach ($director as $director) {			
			print "<option value='".$director['director_id']."'>".$director['director_name']."</option>";
		}
		print "
			</select>
			</div>
			<div class='topnav'>
			<label for='actor'><b>Search by Actor:</b></label><br>
			<select name='actor' id='id_actor' onchange='movieFilterChanged();'>
				<option value='all'>Select all</option>			
		";
		//------------------
		foreach ($actor as $actor) {			
			print "<option value='".$actor['actor_id']."'>".$actor['actor_name']."</option>";
		}	
		print "
			</select>
			</div>
			<div class='topnav'>
			<label for='genre'><b>Seach by Genre:</b></label><br>
			<select name='genre' id='id_genre' onchange='movieFilterChanged();'>
				<option value='all'>Select all</option>
		";
		//------------------
		foreach ($genre as $genre) {			
			print "<option value='".$genre['genre_id']."'>".$genre['genre_name']."</option>";
		}		
		print "
			</select>
			</div>
			<div class='topnav'>
			<label for='studio'><b>Search by Studio:</b></label><br>
			<select name='studio' id='id_studio' onchange='movieFilterChanged();'>
				<option value='all'>Select all</option>
		";
		//------------------
		foreach ($studio as $studio) {			
			print "<option value='".$studio['studio_id']."'>".$studio['studio_name']."</option>";
		}
	}
	
	/*Displays error message
	*/
	public function showError($error) {
		print "<h2>Error: $error</h2>";
	}
	/*Displays Admin home
	*/
	public function showHome() {
		session_start();
		$msg="";
		if(isset($_SESSION['success_msg']) && $_SESSION['success_msg']!=''){
			$msg=$_SESSION['success_msg'];
		}
		print "<h2>Admin Home</h2><h4>$msg</h4>";
		$_SESSION['success_msg']='';
	}
	/*Displays Admin home
	*/
	public function showMovieSearchPage($movie) {
		$count= count($movie);
		$mov="";
		foreach ($movie as $m) {
			$mov.="<option value='".$m['movie_id']."'>".$m['title']."-".$m['year']."</option>";
		}

		$html=file_get_contents('html/select_movie.html');
		$html= str_replace('__count__',$count,$html);
		$html= str_replace('__movie__',$mov,$html);
		print $html;
	}
	/*Displays Movie insertion form
	*/
	public function showMovieInsertForm($director,$actor,$genre,$studio) {
		$dir="";
		$act="";
		$gen="";
		$std="";
		foreach ($director as $d) {
			$dir.="<option value='".$d['director_id']."'>".$d['director_name']."</option>";
		}
		foreach ($actor as $a) {
			$act.="<option value='".$a['actor_id']."'>".$a['actor_name']."</option>";
		}

		foreach ($genre as $g) {
			$gen.="<option value='".$g['genre_id']."'>".$g['genre_name']."</option>";
		}
		foreach ($studio as $s) {
			$std.="<option value='".$s['studio_id']."'>".$s['studio_name']."</option>";
		}

		$formHtml= file_get_contents('html/add_movie_form.html');
		$formHtml=str_replace("__genre__", $gen, $formHtml);
		$formHtml=str_replace("__director__", $dir, $formHtml);
		$formHtml=str_replace("__actor__", $act, $formHtml);
		$formHtml=str_replace("__studio__", $std, $formHtml);
		print $formHtml;
	}
	/*Displays an array of movie
	*/
	public function showmovie($movie_array) {
		if (!empty($movie_array)) {
			foreach ($movie_array as $movie) {
				$this->printMovieInHtml($movie);
			}
		}
	}
	
	/*Format a movie into html
	*/
	private function printmovieInHtml($movie) {
		//print_r($movie);
		
		if (empty($movie['thumbpath'])) {
			$photo = _MOVIE_PHOTO_FOLDER_."default.jpg";
		} else {
			$photo = _MOVIE_PHOTO_FOLDER_.$movie['thumbpath'];
		}
		$studio = $movie['studio'];
		$director = $movie['director'];
		$actor = $movie['star1'];		
		$year = $movie['year'];
		$tagline = $movie['tagline'];		
		$genre = $movie['genre'];
		$title = $movie['title'];
		print "
		<div class='movie_card'>	
			<div class='title'>$title</div>
			<div class='photo_container'>
				<img src= '$photo' alt='car photo' class='photo'>
			</div>
			<div class='content'>
				<b>Studio: \$$studio</b><br>
				Director: $director<br>
				Actor: $actor<br>
				Year: $year<br>
				Tagline: $tagline<br>
				Genre: $genre<br>
			</div>
		</div>
		";
	}	
}
?>