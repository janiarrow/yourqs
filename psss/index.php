<?php

	if (isset($_POST['signinbtn']) && !empty($_POST['username']) && !empty($_POST['pword'])) {
		
		if (empty($_POST['username']) || empty($_POST['pword'])) {

			$error = "Username or Password is Empty";

		} else {
			
				require_once('./connect.php');

				$user = $_POST['username'];
//				$pass = md5($_POST['pword']);
				$pass =$_POST['pword'];

				$checkSelQuery = "SELECT * FROM user WHERE password='$pass' AND email='$user'";

				$res = mysqli_query($connection, $checkSelQuery);

				$rows = mysqli_num_rows($res);
			
				if ($rows == 1) {

					session_start();

					$_SESSION['username'] = $user;
					
					while ($r = mysqli_fetch_assoc($res)) {
						
						$_SESSION['userid'] = $r['user_id'];
						
						if ($r['role'] == 'admin') {
							header("Location: admin.php");
						} else {
							header("Location: home.php");
						}
					}

				} else {
					$error = "Invalid email or password. Please check and try login again.";
				}

		}
	}else if (isset($_GET['lgout']) && !empty($_GET['lgout'])) {
		session_start();
		session_destroy();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
 
    
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

	   <meta name="description" content="YourQS">
        <meta name="author" content="aspire2international">
        <link href="bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
		<title>YourQS</title>
 
	</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<form class="login100-form validate-form" action="index.php" method="post" name="logform">
					<span class="login100-form-title p-b-43">
						Login
					</span>
					
					<?php if(isset($error)){ ?>
						<div class="alert alert-danger">
							<center>
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
								<strong>Login Error!</strong> <br /> <?php echo $error; ?>  
							</center>
						</div>
					<?php } ?>					
						
					<div class="wrap-input100 rs1 validate-input" data-validate = "Username is required">
						<input class="input100" type="text" name="username">
						<span class="label-input100">Email</span>
					</div>					
					
					<div class="wrap-input100 rs2 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="pword" id="pword">
						<span class="label-input100">Password</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="signinbtn">
							Sign in
						</button>
					</div>
					
<!--
					<div class="text-center w-full p-t-23">
						<a href="#" class="txt1">
							Forgot password?
						</a>
					</div>
-->
				</form>
			</div>
		</div>
	</div>
	
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>