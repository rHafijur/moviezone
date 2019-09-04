<?php
/*This is a good practice to define all constants which may be used at different places
*/
//modify suit your A2 database)
//define ('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=mredoy10_moviezone_db");
define ('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=vinh_moviezone_db");
define ('DB_USER', "root");
define ('DB_PASS', "");
define ('MSG_ERR_CONNECTION', "Open connection to the database first");

//maximum number of random movie will be shown
define ('MAX_RANDOM_movie', 9);
//the folder where movie photos are stored
define ('_MOVIE_PHOTO_FOLDER_', "photos/");

//request command messages for client-server communication using AJAX
define ('CMD_REQUEST','request'); //the key to access submitted command via POST or GET
define ('CMD_SHOW_TOP_NAV', 'cmd_show_top_nav'); //create and show top navigation panel
define ('CMD_MOVIE_SELECT_RANDOM', 'cmd_movie_select_random');
define ('CMD_MOVIE_SELECT_ALL', 'cmd_movie_select_all');
define ('CMD_MOVIE_FILTER', 'cmd_movie_filter'); //filter movie by submitted parameters
define ('CMD_MOVIE_FORM', 'cmd_movie_form'); //display movie form
define ('CMD_MOVIE_EDIT_FORM', 'cmd_movie_edit_form'); //display movie form
define ('CMD_SAVE_NEW_MOVIE', 'cmd_save_new_movie'); //Save a new movie to the database
define ('CMD_UPDATE_MOVIE', 'cmd_update_movie'); //update movie to the database
define ('CMD_DELETE_MOVIE', 'cmd_delete_movie'); //update movie to the database
define ('CMD_SHOW_SEARCH_MOVIE_PAGE', 'cmd_show_search_movie_page'); //Show Search movie page

//define error messages
define ('errSuccess', 'SUCCESS'); //no error, command is successfully executed
define ('errAdminRequired', "Login as admin to perform this task");

require_once('moviezone_admin_dba.php');
require_once('moviezone_admin_model.php');
require_once('moviezone_admin_view.php');
require_once('moviezone_admin_controller.php');

?>