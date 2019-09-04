<?php
/*dbAdapter: this module acts as the database abstraction layer for the application
@Author: md redoy
@Modify by:
@Version: 1.0
*/

/*Connection paramaters
*/
require_once('moviezone_admin_config.php'); 

/* DBAdpater class performs all required CRUD functions for the application
*/
class AdminDBAdaper {
	/*local variables
	*/	
	private $dbConnectionString;
	private $dbUser;
	private $dbPassword;
	private $dbConn; //holds connection object
	private $dbError; //holds last error message
	
	/* The class constructor
	*/	
	public function __construct($dbConnectionString, $dbUser, $dbPassword) {
		$this->dbConnectionString = $dbConnectionString;
		$this->dbUser = $dbUser;
		$this->dbPassword = $dbPassword;
	}	
	/*Opens connection to the database
	*/
	public function dbOpen() {
		try {
			$this->dbConn = new PDO($this->dbConnectionString, $this->dbUser, $this->dbPassword);
			// set the PDO error mode to exception
			$this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbError = null;
		}
		catch(PDOException $e) {
			$this->dbError = $e->getMessage();
			$this->dbConn = null;
		}
	}
	/*Closes connection to the database
	*/
	public function dbClose() {
		//in PDO assigning null to the connection object closes the connection
		$this->dbConn = null;
	}
	/*Return last database error
	*/
	public function lastError() {
		return $this->dbError;
	}
	/*Creates required tables in the database if not already created
	  @return: TRUE if successful and FALSE otherwise
	*/
	
	/*------------------------------------------------------------------------------------------- 
                              DATABASE MANIPULATION FUNCTIONS
	-------------------------------------------------------------------------------------------*/

	/*Helper function:
	Build SQL AND conditional clause from the array of condition paramaters
	*/
	protected function sqlBuildConditionalClause($params, $condition) {
		$clause = "";
		$and = false; //so we know when to add AND in the sql statement	
		if ($params != null) {
			foreach ($params as $key => $value) {
				$op = '='; //comparison operator
				if ($key == 'studio')
					$op = '<=';
				if (!empty($value)) {
					if ($and){
						$clause = $clause." $condition $key $op '$value'";
					} else {
						//the first AND condition
						$clause = "WHERE $key $op '$value'";
						$and = true;
					}			
				}
			}
		}
		
		return $clause;
	}

	protected function sqlBuildConditionalClause2($params, $condition) {
		$clause = "";
		$and = false; //so we know when to add AND in the sql statement	
		if ($params != null) {
			foreach ($params as $key => $value) {
				$op = '='; //comparison operator
				if($key=='director_id'){
					$key="director";
					$smt = $this->dbConn->prepare(
						"SELECT director_name from director where director_id='$value'");							  				
					//Execute the query
					$smt->execute();
					$result = $smt->fetchAll(PDO::FETCH_ASSOC);
					$value=$result[0]['director_name'];
					// var_dump($result);
					// exit();
				}
				if($key=='actor_id'){
					$key="star1";
					$smt = $this->dbConn->prepare(
						"SELECT actor_name from actor where actor_id='$value'");							  				
					//Execute the query
					$smt->execute();
					$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
					$value=$result[0]['actor_name'];
					// var_dump($result);
					// exit();
				}
				if($key=='genre_id'){
					$key="genre";
					$smt = $this->dbConn->prepare(
						"SELECT genre_name from genre where genre_id='$value'");							  				
					//Execute the query
					$smt->execute();
					$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
					$value=$result[0]['genre_name'];
					// var_dump($result);
					// exit();
				}
				if (!empty($value)) {
					if ($and){
						$clause = $clause." $condition $key $op '$value'";
					} else {
						//the first AND condition
						$clause = "WHERE $key $op '$value'";
						$and = true;
					}			
				}
			}
		}
		
		return $clause;
	}
	
		
	/*Create Director
	@return: an director id
	*/
	public function CreateDirector($director) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					"INSERT into director(director_name) values ('$director')");							  				
				//Execute the query
				$smt->execute();
				$smt = $this->dbConn->prepare(
					"SELECT director_id from director order by director_id desc limit 1");							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);
				$result =$result[0]['director_id'];
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}
	/*Create Genre
	@return: an Genre id
	*/
	public function CreateGenre($genre) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					"INSERT into genre(genre_name) values ('$genre')");							  				
				//Execute the query
				$smt->execute();
				$smt = $this->dbConn->prepare(
					"SELECT genre_id from genre order by genre_id desc limit 1");							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);
				$result =$result[0]['genre_id'];
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}
	/*Create Studio
	@return: an Studio id
	*/
	public function CreateStudio($studio) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					"INSERT into studio(studio_name) values ('$studio')");							  				
				//Execute the query
				$smt->execute();
				$smt = $this->dbConn->prepare(
					"SELECT studio_id from studio order by studio_id desc limit 1");							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);
				$result =$result[0]['studio_id'];
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}
	/*Create Actor
	@return: an Actor id
	*/
	public function CreateActor($actor) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					"INSERT into actor(actor_name) values ('$actor')");							  				
				//Execute the query
				$smt->execute();
				$smt = $this->dbConn->prepare(
					"SELECT actor_id from actor order by actor_id desc limit 1");							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);
				$result =$result[0]['actor_id'];
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}
		
	/*Insert Movie to the database

	*/
	public function saveMovie($data) {
		$result = null;
		$title=$data['title'];
		$year=$data['year'];
		$tag_line=$data['tag_line'];
		$plot=$data['plot'];
		$director=$data['director'];
		$new_director=$data['new_director'];
		if($new_director!=""){
			$director= $this->CreateDirector($new_director);
		}
		$studio=$data['studio'];
		$new_studio=$data['new_studio'];
		if($new_studio!=""){
			$studio= $this->CreateStudio($new_studio);
		}
		$genre=$data['genre'];
		$new_genre=$data['new_genre'];
		if($new_genre!=""){
			$genre= $this->CreateGenre($new_genre);
		}
		$classification=$data['classification'];
		if($data['new_classification']!=''){
			$classification=$data['new_classification'];
		}
		$rental_period=$data['rental_period'];
		$dvd_rental_price=$data['dvd_rental_price'];
		$dvd_purchase_price=$data['dvd_purchase_price'];
		$dvd_in_stock=$data['dvd_in_stock'];
		$dvd_rented=$data['dvd_rented'];
		$blue_rental_price=$data['blue_rental_price'];
		$blue_purchase_price=$data['blue_purchase_price'];
		$blue_in_stock=$data['blue_in_stock'];
		$blue_rented=$data['blue_rented'];
		$poster=$data['poster'];
		$star1=$data['1st_star'];
		if($data['star1']!=""){
			$star1=$this->CreateActor($data['star1']);
		}
		$star2=$data['2nd_star'];
		if($data['star2']!=""){
			$star2=$this->CreateActor($data['star2']);
		}
		$star3=$data['3rd_star'];
		if($data['star3']!=""){
			$star3=$this->CreateActor($data['star3']);
		}
		$costar1=$data['1st_costar'];
		if($data['costar1']!=""){
			$costar1=$this->CreateActor($data['costar1']);
		}
		$costar2=$data['2nd_costar'];
		if($data['costar2']!=""){
			$costar2=$this->CreateActor($data['costar2']);
		}
		$costar3=$data['3rd_costar'];
		if($data['costar3']!=""){
			$costar3=$this->CreateActor($data['costar3']);
		}
		// exit();
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					"INSERT into movie(title, tagline, plot, thumbpath, director_id, studio_id, genre_id, classification, rental_period, year, DVD_rental_price, DVD_purchase_price, numDVD, numDVDout, BluRay_rental_price, BluRay_purchase_price, numBluRay, numBluRayOut)
					values('$title', '$tag_line', '$plot','$poster', $director, $studio, $genre, '$classification', '$rental_period', $year, $dvd_rental_price,$dvd_purchase_price, $dvd_in_stock, $dvd_rented,$blue_rental_price,$blue_purchase_price,$blue_in_stock,$blue_rented)
					");							  				
				//Execute the query
				$smt->execute();

				$smt = $this->dbConn->prepare("SELECT movie_id from movie order by movie_id desc limit 1");	
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);
				$movie_id=$result[0]['movie_id'];
				
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);

				//Assign Stars to the movie

				if($star1!=""){
					$smt = $this->dbConn->prepare("INSERT into movie_actor(movie_id,actor_id,role) values ('$movie_id','$star1','star1')");	
					$smt->execute();
				}
				if($star2!=""){
					$smt = $this->dbConn->prepare("INSERT into movie_actor(movie_id,actor_id,role) values ('$movie_id','$star2','star2')");	
					$smt->execute();
				}
				if($star3!=""){
					$smt = $this->dbConn->prepare("INSERT into movie_actor(movie_id,actor_id,role) values ('$movie_id','$star3','star3')");	
					$smt->execute();
				}
				if($costar1!=""){
					$smt = $this->dbConn->prepare("INSERT into movie_actor(movie_id,actor_id,role) values ('$movie_id','$costar1','costar1')");	
					$smt->execute();
				}
				if($costar2!=""){
					$smt = $this->dbConn->prepare("INSERT into movie_actor(movie_id,actor_id,role) values ('$movie_id','$costar2','costar2')");	
					$smt->execute();
				}
				if($costar3!=""){
					$smt = $this->dbConn->prepare("INSERT into movie_actor(movie_id,actor_id,role) values ('$movie_id','$costar3','costar3')");	
					$smt->execute();
				}
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		
	}

	public function updateMovie($data) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$rental_period=$data['rental_period'];
				$dvd_rental_price=$data['dvd_rental_price'];
				$dvd_purchase_price=$data['dvd_purchase_price'];
				$dvd_in_stock=$data['dvd_in_stock'];
				$dvd_rented=$data['dvd_rented'];
				$blue_rental_price=$data['blue_rental_price'];
				$blue_purchase_price=$data['blue_purchase_price'];
				$blue_in_stock=$data['blue_in_stock'];
				$blue_rented=$data['blue_rented'];
				$id=$data['movie_id'];
				$smt = $this->dbConn->prepare(
					"UPDATE movie set  
					rental_period ='$rental_period',
					DVD_rental_price='$dvd_rental_price',
					DVD_purchase_price='$dvd_purchase_price',
					numDVD='$dvd_in_stock',
					numDVDout='$dvd_rented',
					BluRay_rental_price='$blue_rental_price',
					BluRay_purchase_price='$blue_purchase_price',
					numBluRay='$blue_in_stock',
					numBluRayOut='$blue_rented'
					where movie_id=$id
					");	
				$smt->execute();						  				
				//Execute the query
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}	
	}
	public function deleteMovie($id) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				
				$smt = $this->dbConn->prepare(
					"DELETE from movie
					where movie_id=$id
					");	
				$smt->execute();						  				
				//Execute the query
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}	
	}
	/*Select all existing movie from the movie table
	@return: an array of matched movie
	*/
	public function movieSelectAll() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					'SELECT movie_id, title, thumbpath, studio, director, star1,star2,star3,costar1,costar2,costar3, year, tagline, genre FROM movie_detail_view');							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}

	/*Select a movie from the movie table
	@param: $id - the id with the movie will be selected
	@return: an array of matched movie
	*/
	public function movieSelectById($id) { 
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
				"SELECT * 
					FROM movie 
					where movie_id= $id");
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result[0];			
	}
	/*Select ramdom movie from the movie table
	@param: $max - the maximum number of movie will be selected
	@return: an array of matched movie (default 1 movie)
	*/
	public function movieSelectRandom($max=10) { 
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
				"SELECT movie_id, title, thumbpath, studio, director, star1,star2,star3,costar1,costar2,costar3, year, tagline, genre 
					FROM movie_detail_view 
					ORDER BY RAND() 
					LIMIT $max");
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}
	
	/*Select an existing movie from the movie table
	@param $condition: is an associative array of movie's details you want to match
	@return: an array of matched movie
	*/
	public function movieFilter($condition) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$sql = 'SELECT movie_id, title, thumbpath, studio, director, star1,star2,star3,costar1,costar2,costar3, year, tagline, genre FROM movie_detail_view '
						.$this->sqlBuildConditionalClause2($condition, 'AND');	
				// var_dump($sql);
				// exit();
				$smt = $this->dbConn->prepare($sql);							  
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;		
	}	
	

	/*Select all existing states from the genre table
	@return: an array of genre with column name as the keys;
	*/
	public function genreSelectAll() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare('SELECT * FROM genre');							  
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}
	

	/*Select all existing director from the  director table
	@return: an array of director with column name as the keys;
	*/
	public function directorSelectAll() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare('SELECT * FROM director');
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}
	

		/*Select all existing studio from the  studio table
	@return: an array of studio with column name as the keys;
	*/
	public function studioSelectAll() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare('SELECT * FROM studio');
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}
	
	/*Select all existing body type from the bodytypes table
	@return: an array of body type with column name as the keys;
	*/
	public function actorSelectAll() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare('SELECT * FROM actor');							  
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}
}

/*---------------------------------------------------------------------------------------------- 
                                         TEST FUNCTIONS
 ----------------------------------------------------------------------------------------------*/

 //Your task: implement the test function to test each function in this dbAdapter

 
/*Tests database functions
*/
function testDBA() {
	$dbAdapter = new DBAdaper(DB_CONNECTION_STRING, DB_USER, DB_PASS);
	
	$movie = array(
	'photo' => '1250744226twilight.jpg',
	'studio_id`' => 1,	
	'movie_id' => 1,
	'director_id' => 1,
	'actor_id' => 1,
	'tagline' => 'When you can live forever what do you live for?',
	'year' => 2007,
	'genre_id' => 2,
	'title' => "Twilight"
	);

	$dbAdapter->dbOpen();
	$dbAdapter->dbCreate();
	
//	$result = $dbAdapter->movieSelectRandom(200);	
//	$result = $dbAdapter->movieSelectAll();	
//	$result = $dbAdapter->movieFilter($movie);	

//	$result = $dbAdapter->genreSelectAll();	
//	$result = $dbAdapter->directorSelectAll();	
//	$result = $dbAdapter->actorSelectAll();	

	if ($result != null)		
		print_r($result);
	else
		echo $dbAdapter->lastError();
	$dbAdapter->dbClose();
}

//execute the test
//testDBA();

?>