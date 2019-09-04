  <?php
/*-------------------------------------------------------------------------------------------------
@Module: movie_zone.php
This server-side main module interacts with UI to process user's requests

@Author: Md redoy
@Modified by: 
@Date:05/08/2019
--------------------------------------------------------------------------------------------------*/
session_start();
if(!isset($_SESSION['admin'])){
	header('location:login.php');
}
session_abort();
require_once('moviezone_admin_config.php'); 

/*initialize the model and view
*/
$model = new MovieZoneAdminModel();
$view = new MovieZoneAdminView();
$controller = new MovieZoneAdminController($model, $view);
/*interacts with UI via GET/POST methods and process all requests
*/
if (!empty($_REQUEST[CMD_REQUEST])) { //check if there is a request to process
	$request = $_REQUEST[CMD_REQUEST];	
	$controller->processRequest($request);
}
?>