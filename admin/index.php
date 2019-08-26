 <?php 
/*-------------------------------------------------------------------------------------------------
@Module: index.php
This server-side module provides main UI for the application (admin part)

@Author: md redoy
@Modified by: 
@Date: 05/08/2019
-------------------------------------------------------------------------------------------------*/
require_once('moviezone_admin_main.php');
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/moviezone_admin.css">
	<script src="js/ajax.js"></script>
	<script src="js/moviezone_admin.js"></script>
</head>

<body>
<div id="id_container">
	<header>
		<h1>MOVIE ZONE</h1>
	</header>
	<!-- left navigation area -->
	<div id="id_left">
		<!-- load the navigation panel by embedding php code -->
		<?php $controller->loadLeftNavPanel()?>
	</div>
	<!-- right area -->	
	<div id="id_right">
		<!-- top navigation area -->
		<div id="id_topnav">			
			<!-- the top navigation panel is loaded on demand using Ajax (see js code) -->
		</div>
		<div id="id_content"></div>
	</div>
	<!-- footer area -->
	<footer>Copyright &copy; MD ASHRAFUL ALAM REDOY </footer>
</div>
</body>
</html>