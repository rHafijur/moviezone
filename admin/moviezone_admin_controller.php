<?php
/*-------------------------------------------------------------------------------------------------
@Module: moviezone_controller.php
This server-side module provides all required functionality to format and display movie in html

@Author: md redoy)
@Modified by: 
@Date: 04/08/2019
--------------------------------------------------------------------------------------------------*/
require_once('moviezone_admin_config.php'); 

class MovieZoneAdminController {
	private $model;
	private $view;
	
	/*Class contructor
	*/
	public function __construct($model, $view) {
		$this->model = $model;
		$this->view = $view;
	}
	/*Class destructor
	*/	
	public function __destruct() {
		$this->model = null;
		$this->view = null;
	}
	/*Loads left navigation panel*/
	public function loadLeftNavPanel() {
		$this->view->leftNavPanel();
	}

	/*Loads top navigation panel*/
	public function loadTopNavPanel() {
		$director = $this->model->selectAlldirector();
		$actor = $this->model->selectAllactor();
		$genre = $this->model->selectAllgenre();
		if (($director != null) && ($actor != null) && ($genre != null)) {
			$this->view->topNavPanel($director, $actor, $genre);
		}
		else {
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);
		}
	}	
	/*Processes user requests and call the corresponding functions
	  The request and data are submitted via POST or GET methods
	*/
	public function processRequest($request) {
		switch ($request) {
			case CMD_SHOW_TOP_NAV: 
				$this->loadTopNavPanel();
				break;			
			case CMD_MOVIE_SELECT_ALL: 
				$this->handleSelectAllMovieRequest();
				break;
			case CMD_MOVIE_SELECT_RANDOM: 
				$this->handleSelectRandomMovieRequest();
				break;
			case CMD_MOVIE_FILTER: 
				$this->handleFilterMovieRequest();
				break;	
			case CMD_MOVIE_FORM: 
				$this->addNewMovieFormRequest();
				break;					
			default:
				$this->handleSelectRandomMovieRequest();
				break;
		}
	}
	/*Shows Movie insertion form
	*/
	private function addNewMovieFormRequest() {
			$this->view->showMovieInsertForm();
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);	
	}
	/*Handles select all movie request
	*/
	private function handleSelectAllMovieRequest() {
		$movie = $this->model->selectAllmovie();
		if ($movie != null) {
			$this->view->showmovie($movie);
		} else {
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);
		}		
	}
	/*Handles select random movie request
	*/
	private function handleSelectRandomMovieRequest() {
		$movie = $this->model->selectRandomMovie(MAX_RANDOM_movie);
		if ($movie != null) {
			$this->view->showmovie($movie);
		} else {
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);
		}		
	}
	/*Handles filter movie request
	*/
	private function handleFilterMovieRequest() {		
		$condition = array();		
		if (!empty($_REQUEST['director']))
			$condition['director_id'] = $_REQUEST['director']; //submitted is director id and not director name
		if (!empty($_REQUEST['actor']))
			$condition['actor_id'] = $_REQUEST['actor']; //submitted is actor id and not actor name
		if (!empty($_REQUEST['genre']))
			$condition['genre_id'] = $_REQUEST['genre']; //submitted is genre id and not genre name
		if (!empty($_REQUEST['studio']))
			$condition['studio'] = $_REQUEST['studio']; //submitted is studio id and not studio name
		//call the dbAdapter function
		$movie = $this->model->filtermovie($condition);
		if ($movie != null) {
			$this->view->showmovie($movie);
		} else {
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);
		}
	}
}
?>