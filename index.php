 <?php 
/*-------------------------------------------------------------------------------------------------
@Module: index.php
This server-side module provides main UI for the application (admin part)

@Author: md redoy
@Modified by: 
@Date: 05/08/2019
-------------------------------------------------------------------------------------------------*/
require_once('moviezone_main.php');
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/moviezone.css">
	<script src="js/ajax.js"></script>
	<script src="js/moviezone.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>

<body>
<div id="id_container">
	<header>
		<h1>MOVIE ZONE</h1>
	</header>
	<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="#">Features</a>
      <a class="nav-item nav-link" href="#">Pricing</a>
      <a class="nav-item nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
    </div>
  </div>
</nav>
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
		<div>
		<?php
			session_start();
			if(isset($_SESSION['member'])){
				print "<h2>Member: ".$_SESSION['member']."</h2>";
			}
			session_abort();
			?>
		</div>
		<div id="id_content"></div>
		<?php
		session_start();
		if(isset($_SESSION['success']) && $_SESSION['success']!=''){
			print '<h3 style="color:green">'.$_SESSION['success'].'</h3>';
		}
		$_SESSION['success']='';
		session_abort();
		?>
	</div>
	<!-- footer area -->
	<footer>Copyright &copy; MD ASHRAFUL ALAM REDOY </footer>
</div>
</body>
</html>