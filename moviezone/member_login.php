<?php
 session_start();
//  var_dump($_SESSION);
//  exit();
 if(isset($_SESSION['member'])){
	 header("location:index.php");
 }
 session_abort();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Member login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="row" style="margin-top:60px">
        <div class="col-4 offset-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                    Member Login
                    </h3>
                </div>
                <div class="card-body">
                    <form action="moviezone_main.php?request=cmd_authentication" method='post'>
                        <div class="alert">
                            <?php
                            if(isset($error)){
                                echo '<span style="color:red">Login faild, please try again</span>';
                            }
                            ?>
                            
                        </div>
                        <div class="form-group">
                            <label for="#user_name">User Name</label>
                            <input type="text" name="user_name" id="user_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="#password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>