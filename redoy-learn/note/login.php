<?php 
if(!isset($_SESSION)){
	session_start();
}
if(isset($_SESSION['u_name'])){
	header("location:index.php");
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	
	<div class="row">
		<div class="col-4 offset-4">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title">
						Login
					</h2>
				</div>
				<div class="body">
					<form action="authenticate.php" style="padding: 30px;" method="POST">
						<?php 
							if(!isset($_SESSION)){
								session_start();
							}
							// var_dump($_SESSION);
							// exit();
							if(isset($_SESSION['error_msg'])){
								if($_SESSION['error_msg']!=''){
						?>		
							<div class="alert alert-danger" role="alert">
							  <?=$_SESSION['error_msg']?>
							</div>	
						<?php
								unset($_SESSION['error_msg']);
								}
							}
						 ?>
						<div class="form-group">
							<label>Username</label>
							<input type="text" id="u_name" name="u_name" class="form-control">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" id="pass" name="password" class="form-control">
						</div>
						<div class="form-group">
							<button onclick="return check()" class="btn btn-success">Login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		 function check(){
		 	var pass= $('#pass').val();
		 	var u_name= $('#u_name').val();
		 	if(u_name.length<4){
		 		alert('Username can not be less than 4 charecters');
		 		return false;
		 	}
		 	if(pass.length<6){
		 		alert('Password can not be less than 6 charecters');
		 		return false;
		 	}
		 	return true;
		 }
	</script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>