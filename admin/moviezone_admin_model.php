<?php
/*-------------------------------------------------------------------------------------------------
@Module: moviezone_model.php
This server-side module provides all required functionality i.e. to select, update, delete movie

@Author: md redoy
@Modified by: 
@Date: 04/08/2019
--------------------------------------------------------------------------------------------------*/
require_once('moviezone_admin_config.php'); 

class MovieZoneAdminModel {
	private $error;
	private $dbAdapter;
	
	/* Add initialization code here
	*/
	public function __construct() {
		$this->dbAdapter = new AdminDBAdaper(DB_CONNECTION_STRING, DB_USER, DB_PASS);
		/* uncomment to create the database tables for the first time
		$this->dbAdapter->dbOpen();
		$this->dbAdapter->dbCreate();
		$this->dbAdapter->dbClose();
		*/
	}
	
	/* Add code to free any unused resource
	*/	
	public function __destruct() {
		$this->dbAdapter->dbClose();
	}
	
	/*Returns last error
	*/
	public function getError() {
		return $this->error;
	}
	
	/*Selects all movie from the database
	*/
	public function selectAllMovie() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->movieSelectAll();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}
	
	/*Filter movie from the database
	*/
	public function filterMovie($condition) {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->movieFilter($condition);
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}	
	
	/*Selects randomly a $max number of movie from the database
	*/
	public function selectRandomMovie($max) {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->movieSelectRandom($max);
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}
	
	/*Return the list of genre
	*/
	public function selectAllgenre() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->genreSelectAll();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;		
	}
	
		/*Return the list of studio
	*/
	public function selectAllstudio() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->studioSelectAll();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;		
	}
	
	/*Return the list of director
	*/
	public function selectAlldirector() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->directorSelectAll();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;		
	}
	
	/*Return the list of actor
	*/
	public function selectAllactor() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->actorSelectAll();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;		
	}	
}
?>