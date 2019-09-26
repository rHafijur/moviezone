<?php 
if(!isset($_SESSION)){
	session_start();
}
if(isset($_POST['u_name'])){

	$uname=$_POST['u_name'];
	$password=$_POST['password'];

	$users=[
		[
			'uname'=>'redoy',
			'password'=>'654321',
		],
		[
			'uname'=>'hafijur',
			'password'=>'123456',
		]
	];

	$is_matched=false;
	foreach($users as $user){
		if($user['uname']==$uname && $user['password']==$password){
			$is_matched=true;
		}
	}
	if($is_matched==true){
		$_SESSION['u_name']=$uname;
		header('location:index.php');
	}else{
		$_SESSION['error_msg']="Wrong information, please try again!";
		header('location:login.php');
	}
}

 ?>