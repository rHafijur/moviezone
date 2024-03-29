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
		print "<h2>Admin Home</h2><h3>".$_SESSION['admin']."</h3><h4>$msg</h4>";
		$_SESSION['success_msg']='';
	}
	/*Displays all movie list
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
	/*Displays all movie list
	*/
	public function showMemberSearchPage($members) {
		$count= count($members);
		$mem="";
		foreach ($members as $m) {
			$mem.="<option value='".$m['member_id']."'>".$m['surname']."-".$m['other_name']."</option>";
		}

		$html=file_get_contents('html/select_member.html');
		$html= str_replace('__count__',$count,$html);
		$html= str_replace('__member__',$mem,$html);
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
	/*Displays Movie insertion form
	*/
	public function editMoviePage($movie) {


		$formHtml= file_get_contents('html/edit_movie_form.html');
		$formHtml=str_replace("__id__", $movie['movie_id'], $formHtml);
		$formHtml=str_replace("__title__", $movie['title'], $formHtml);
		$formHtml=str_replace("__year__", $movie['year'], $formHtml);
		$formHtml=str_replace("__tag__", $movie['tagline'], $formHtml);
		$formHtml=str_replace('value="'.$movie['rental_period'].'"','value="'.$movie['rental_period'].'" selected',$formHtml);
		$formHtml=str_replace("__drp__", $movie['DVD_rental_price'], $formHtml);
		$formHtml=str_replace("__dpp__", $movie['DVD_purchase_price'], $formHtml);
		$formHtml=str_replace("__dis__", $movie['numDVD'], $formHtml);
		$formHtml=str_replace("__dr__", $movie['numDVDout'], $formHtml);
		$formHtml=str_replace("__brp__", $movie['BluRay_rental_price'], $formHtml);
		$formHtml=str_replace("__bpp__", $movie['BluRay_purchase_price'], $formHtml);
		$formHtml=str_replace("__bis__", $movie['numBluRay'], $formHtml);
		$formHtml=str_replace("__br__", $movie['numBluRayOut'], $formHtml);
		// $formHtml=str_replace("__director__", $dir, $formHtml);
		// $formHtml=str_replace("__actor__", $act, $formHtml);
		// $formHtml=str_replace("__studio__", $std, $formHtml);
		print $formHtml;
	}
	public function editMemberPage($member) {
		// var_dump($member);
		// exit();

		$formHtml= file_get_contents('html/edit_member_form.html');
		$formHtml=str_replace("__member_id__", $member['member_id'], $formHtml);
		$formHtml=str_replace("__surname__", $member['surname'], $formHtml);
		$formHtml=str_replace("__other_name__", $member['other_name'], $formHtml);
		$formHtml=str_replace("__username__", $member['username'], $formHtml);
		$formHtml=str_replace("__join_date__", $member['join_date'], $formHtml);
		$formHtml=str_replace("__email__", $member['email'], $formHtml);
		$formHtml=str_replace("__mobile__", $member['mobile'], $formHtml);
		$formHtml=str_replace("__landline__", $member['landline'], $formHtml);
		$formHtml=str_replace("__street__", $member['street'], $formHtml);
		$formHtml=str_replace("__suburb__", $member['suburb'], $formHtml);
		$formHtml=str_replace("__postcode__", $member['postcode'], $formHtml);
		$formHtml=str_replace("__occupation__", $member['occupation'], $formHtml);
		$formHtml=str_replace("__password__", $member['password'], $formHtml);
		// $formHtml=str_replace("__director__", $dir, $formHtml);
		// $formHtml=str_replace("__actor__", $act, $formHtml);
		// $formHtml=str_replace("__studio__", $std, $formHtml);
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