<?php 
if(!isset($_SESSION)){
	session_start();
}
if(!isset($_SESSION['u_name'])){
	header("location:login.php");
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Note App</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<div class="row">
		<div class="col-8 offset-2">
			<div class="card">
				<div class="card-header">
					<h3 class="card-text">Dashboard: <?=$_SESSION['u_name']?></h3>
					<a href="logout.php"><button class="btn btn-primary">logout</button></a>
				</div>
				<div class="card-body">
					welcome, you are successfully logged in!
				</div>
			</div>
		</div>
	</div>
</body>
</html>