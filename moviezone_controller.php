<?php
/*-------------------------------------------------------------------------------------------------
@Module: moviezone_controller.php
This server-side module provides all required functionality to format and display movie in html

@Author: md redoy)
@Modified by: 
@Date: 04/08/2019
--------------------------------------------------------------------------------------------------*/
require_once('moviezone_config.php'); 

class MovieZoneController {
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
		$studio = $this->model->selectAllstudio();
		if (($director != null) && ($actor != null) && ($genre != null)) {
			$this->view->topNavPanel($director, $actor, $genre, $studio);
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
			case CMD_JOIN_MEMBER: 
				$this->loadJoinMemberPage();
				break;					
			case CMD_SAVE_MEMBER: 
				$this->saveMember();
				break;
			case CMD_AUTHENTICATION: 
				$this->authenticate();
				break;				
			case CMD_BOOK_MOVIE: 
				$stat= $this->bookMovie();
				if($stat==-1){
					header('location:index.php?page=checkout');
				}else{
					header('location:index.php');
				}
				break;				
			case CMD_CHECKOUT: 
				$this->checkout();
				break;				
			default:
				$this->handleSelectRandomMovieRequest();
				break;
		}
	}
	/*insert a member to the database
	*/
	private function saveMember() {
		$movie = $this->model->saveMember($_POST);
			$error = $this->model->getError();
			if (!empty($error)){
				$this->view->showError($error);
			}else{
				session_start();
				$_SESSION['success']='Member Joined successfully';
				session_abort();
				header('location:index.php');
			}
				
	}
	/*authenticate a member
	*/
	private function authenticate() {
		$user = $this->model->authenticate($_POST);
			$error = $this->model->getError();
			if (!empty($error)){
				$this->view->showError($error);
			}else{
				if(count($user)>0){
					session_start();
					$_SESSION['member']=$user[0]['username'];
					// session_abort();
					// var_dump($_SESSION['member']);
					// exit();
					header('location:index.php');
				}else{
					header('location:member_login.php');
				}
			}
				
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
	private function checkout() {
		$movie = $this->model->checkout();
		if ($movie != null) {
			$this->view->bookMovies($movie);
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
	private function bookMovie(){
		$movies=[];
		if(isset($_COOKIE['movies'])){
			$movies=$_COOKIE['movies'];
			$movies=json_decode($movies);
			if(count($movies)>4){
				 return -1;
			}
			foreach($movies as $movie){
				if($movie==$_GET['movie_id']){
					return;
				}
			}
		}
		$movies[]=$_GET['movie_id'];
		setcookie('movies', json_encode($movies), time() + (86400 * 30));
	}
	/*Loads member join page
	*/
	private function loadJoinMemberPage() {
		$this->view->loadJoinMemberPage();
	}
}
?>