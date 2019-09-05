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
			case CMD_SHOW_SEARCH_MOVIE_PAGE: 
				$this->handleMovieSearchPageRequest();
				break;	
			case CMD_MOVIE_FORM: 
				$this->addNewMovieFormRequest();
				break;	
			case CMD_SAVE_NEW_MOVIE: 
				$this->saveNewMovieRequest();
				break;					
			case CMD_MOVIE_EDIT_FORM: 
				$this->editMovieFormRequest();
				break;					
			case CMD_UPDATE_MOVIE: 
				$this->updateMovieRequest();
				break;					
			case CMD_DELETE_MOVIE: 
				$this->deleteMovieRequest();
				break;					
			case CMD_SHOW_SEARCH_MEMBER_PAGE: 
				$this->handleMemberSearchPageRequest();
				break;					
			case CMD_MEMBER_EDIT_FORM: 
				$this->editMemberFormRequest();
				break;					
			case CMD_UPDATE_MEMBER: 
				$this->updateMemberRequest();
				break;					
			case CMD_DELETE_MEMBER: 
				$this->deleteMemberRequest();
				break;					
			default:
				$this->loadAdminHome();
				break;
		}
	}
	/*inserts Movie into database
	*/
	private function saveNewMovieRequest() {
			if(isset($_FILES['poster'])){
				$file_type=$_FILES['poster']['type'];
				$file_name=$_FILES['poster']['name'];
				$file_tmp =$_FILES['poster']['tmp_name'];
				$file_ex=explode('.',$file_name);
				$file_ext=strtolower(end($file_ex));
				$extensions= array("jpeg","jpg","png");
				if(in_array($file_ext,$extensions)=== false){
					$this->view->showError("Invalid File!");
					return;
				}
				move_uploaded_file($file_tmp,"../photos/".$file_name);
			}
			$data=$_POST;
			$data['poster']=$file_name;
			$this->model->saveMovie($data);
			$error = $this->model->getError();
			if (!empty($error)){
				$this->view->showError($error);	
			}else{
				session_start();
				$_SESSION['success_msg']="Movie Added Successfully";
				// session_destroy();
				header("Location: index.php");
			}

	}
	/*Updates Movie
	*/
	private function updateMovieRequest() {
			$data=$_POST;
			$this->model->updateMovie($data);
			$error = $this->model->getError();
			if (!empty($error)){
				$this->view->showError($error);	
			}else{
				session_start();
				$_SESSION['success_msg']="Movie Updated Successfully";
				// session_destroy();
				header("Location: index.php");
			}

	}
	/*Updates member
	*/
	private function updateMemberRequest() {
			$data=$_POST;
			$this->model->updateMember($data);
			$error = $this->model->getError();
			if (!empty($error)){
				$this->view->showError($error);	
			}else{
				session_start();
				$_SESSION['success_msg']="Member Updated Successfully";
				// session_destroy();
				header("Location: index.php");
			}

	}
	/*Deletes Movie
	*/
	private function deleteMovieRequest() {
			$id=$_POST['movie_id'];
			$this->model->deleteMovie($id);
			$error = $this->model->getError();
			if (!empty($error)){
				$this->view->showError($error);	
			}else{
				session_start();
				$_SESSION['success_msg']="Movie Deleted Successfully";
				// session_destroy();
				header("Location: index.php");
			}

	}
	/*Deletes Member
	*/
	private function deleteMemberRequest() {
			$id=$_POST['member_id'];
			$this->model->deleteMember($id);
			$error = $this->model->getError();
			if (!empty($error)){
				$this->view->showError($error);	
			}else{
				session_start();
				$_SESSION['success_msg']="Member Deleted Successfully";
				// session_destroy();
				header("Location: index.php");
			}

	}
	/*Shows Movie insertion form
	*/
	private function handleMovieSearchPageRequest() {
			$movie = $this->model->selectAllMovie();
			$this->view->showMovieSearchPage($movie);
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);	
	}
	/*Shows Movie insertion form
	*/
	private function handleMemberSearchPageRequest() {
			$member = $this->model->selectAllMember();
			$this->view->showMemberSearchPage($member);
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);	
	}
	/*Shows Movie Edit form
	*/
	private function editMovieFormRequest() {
			$movie_id=$_GET['movie_id'];
			$movie = $this->model->selectMovie($movie_id);
			$this->view->editMoviePage($movie);
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);	
	}
	/*Shows member Edit form
	*/
	private function editMemberFormRequest() {
			$member_id=$_GET['member_id'];
			$member = $this->model->selectMember($member_id);
			// var_dump($member);
			// exit();
			$this->view->editMemberPage($member);
			$error = $this->model->getError();
			if (!empty($error))
				$this->view->showError($error);	
	}
	/*Shows Movie insertion form
	*/
	private function addNewMovieFormRequest() {
			$director = $this->model->selectAlldirector();
			$actor = $this->model->selectAllactor();
			$genre = $this->model->selectAllgenre();
			$studio = $this->model->selectAllstudio();
			$this->view->showMovieInsertForm($director,$actor,$genre,$studio);
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
	/*Handles admin home request
	*/
	private function loadAdminHome() {	
		$this->view->showHome();		
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