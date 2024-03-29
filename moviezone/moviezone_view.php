<?php
/*-------------------------------------------------------------------------------------------------
@Module: moviezone_view.php
This server-side module provides all required functionality to format and display movie in html

@Author: md redoy
@Modified by: 
@Date: 05/08/2019
--------------------------------------------------------------------------------------------------*/

class MovieZoneView {
	/*Class contructor: performs any initialization
	*/
	public function __construct() {		
	}
	
	/*Class destructor: performs any deinitialiation
	*/		
	public function __destruct() {		
	}
	public function showHome(){
		print file_get_contents('html/home.html');
	}
	public function showContact(){
		print file_get_contents('html/home.html');
	}
	public function showTechzone(){
		print file_get_contents('html/home.html');
	}
	/*Creates left navigation panel
	*/
	public function leftNavPanel() {
		print file_get_contents('html/leftnav.html');
	}
	
	/*Creates top navigation panel
	*/	
	public function topNavPanel($director, $actor, $genre, $studio) {
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
	
	/*Displays an array of movie
	*/
	public function showmovie($movie_array) {
		if (!empty($movie_array)) {
			foreach ($movie_array as $movie) {
				$this->printMovieInHtml($movie);
			}
		}
	}
	public function bookMovies($movie_array) {
		if (!empty($movie_array)) {
			print count($movie_array)." movies selected <br>
								<h3>Checkout</h3>
								This module is currently being built and has not yet been completed
You have chosen the following movies to be booked/purchased:
			";
			foreach ($movie_array as $movie) {
				$this->printBookedMovieInHtml($movie);
			}
		}
	}
	/*Displays an array of movie
	*/
	public function loadJoinMemberPage() {
		$html=file_get_contents("html/join_member.html");
		print $html;
	}

	private function printBookedMovieInHtml($movie){
		if (empty($movie['thumbpath'])) {
			$photo = _MOVIE_PHOTO_FOLDER_."default.jpg";
		} else {
			$photo = _MOVIE_PHOTO_FOLDER_.$movie['thumbpath'];
		}
		$movie_id = $movie['movie_id'];
		$title = $movie['title'];
		$year = $movie['year'];
		$tagline = $movie['tagline'];
		print '
		<div class="row">
	<div class="col">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Movie '.$movie_id.' information</h3>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-9">
					<ul class="list-group">
						<li class="list-group-item"><storng>Title:</strong> '.$title.'</li>
						<li class="list-group-item"><storng>Year:</strong> '.$year.'</li>
						<li class="list-group-item"><storng>Tagline:</strong> '.$tagline.'</li>
					</ul>
				</div>
				<div class="col-3">
				<img src="'.$photo.'" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
		';
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
		$book_button="";
		$btn_text='Rent/Purchase';
		if(!isset($_SESSION)){
			session_start();
		}
		if(isset($_SESSION['member'])){
			if($movie['numDVD']==0){
				$btn_text='Only BluRay available';
			}elseif($movie['numBluRay']==0){
				$btn_text='Only DVD available';
			}
			if(isset($_COOKIE['movies'])){
				$movs=json_decode($_COOKIE['movies']);
				foreach($movs as $mov){
					if($mov==$movie['movie_id']){
						$btn_text="Already selected";
						break;
					}
				}
			}
			$book_button='
			<a href="moviezone_main.php?request=cmd_book_movie&movie_id='.$movie['movie_id'].'">
				<button class="btn-secondary">'.$btn_text.'</button>
			</a>
			';
			if($movie['numDVD']==0&&$movie['numBluRay']==0){
				$book_button='
				<button class="btn-secondary">Movie Not available</button>
				';
			}
		}
		print "
		<div class='movie_card'>	
			<div class='title'>$title</div>
			".$book_button."
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
