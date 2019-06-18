<?php

	require_once('connect.php');

	if (isset($_POST) & !empty($_POST)) {

		$checkemailSql = "SELECT email FROM user";
		$res           = mysqli_query($connection, $checkemailSql);

		while ($r = mysqli_fetch_assoc($res)) {
			if ($r['email'] == $_POST['email']) {
				$fmsg = "Sorry. User with this email already exisit.";
				$error = true;
			}
		}

		$fname      = $_POST['fname'];
		$lname      = $_POST['lname'];
		$pword      = $_POST['pword'];
		$contactnum = $_POST['contactnum'];
		$email      = $_POST['email'];

		
		if (isset($email) && empty($email)) {
			$fmsg = "Please enter email";
			$error = true;
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$fmsg = "Invalid email";
			$error = true;
		}

		$SelSql = "SELECT * FROM user order by user_id DESC";
		$res    = mysqli_query($connection, $SelSql);
		$r      = mysqli_fetch_assoc($res);
		$id     = $r['user_id'] + 1;
		

		if (!isset($error)) {

//			$pword = md5($_POST['pword']);
			$pword = $_POST['pword'];

			$insertSql = "INSERT INTO user(user_id, firstname, lastname,password, email, contact_number,role) VALUES($id,'$fname','$lname', '$pword','$email','$contactnum','general')";

			$res = mysqli_query($connection, $insertSql);

			if ($res) {
				$success = true;
			} else {
				$fmsg = "Failed to register data." . $insertSql;
			}
		}
	}
?>


<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="YourQS">
        <meta name="author" content="aspire2international">
        <link href="bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
		<title>YourQS</title>
		
		 
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
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        
		
		
		<div class="topnav" id="myTopnav">
			<a class="active">New User</a>
			  <a href="admin.php">User List</a>
			<a href="login.php?lgout=1">Logout</a>
		  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
			<i class="fa fa-bars"></i>
		  </a>
		</div>
		
		
	<div class="limiter">
		<div class="container-reg100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<form class="login100-form validate-form" action="register.php" method="post" name="regform">
					
					<span class="login100-form-title p-b-43">
						Register User
					</span>
					
							<div class="wrap-input100 rs1 validate-input" data-validate = "First Name is required">
								<input class="input100" type="text" name="fname">
								<span class="label-input100">First Name</span>
							</div>
							<div class="wrap-input100 rs2 validate-input" data-validate = "Last Name is required">
								<input class="input100" type="text" name="lname">
								<span class="label-input100">Last Name</span>
							</div>
							<div class="wrap-input100 rs2 validate-input" data-validate = "Valid Email is required">
								<input class="input100" type="email" name="email" id="email">
								<span class="label-input100">Email</span>
							</div>		
					
							<div class="wrap-input100 rs2 validate-input" data-validate = "Valid Contact Number is required">
								<input class="input100" type="text" name="contactnum">
								<span class="label-input100">Contact Number</span>
							</div>
							<div class="wrap-input100 rs2 validate-input" data-validate="Password is required">
								<input class="input100" type="password" name="pword" id="pword">
								<span class="label-input100">Password</span>
							</div>
							<div class="wrap-input100 rs2 validate-input" data-validate="Confirm  Password is required">
								<input class="input100" type="password" name="cnpword" id="cpword">
								<span class="label-input100">Confirm Password</span>
							</div>
							<div class="container-login100-form-btn">
								<button class="login100-form-btn" name="register">
									Register
								</button>
							</div>
				</form>
			</div>
		</div>
	</div>
		<script>
		 <?php if(isset($success)){ ?>
			var user  = "<?php echo $email ?>";
			var pw = "<?php echo $pword ?>";
			var msg  = "Username:"+ user+" Password:"+ pw +"";
			swal("Successfully Registered!", msg, "success");
		<?php }else if(isset($fmsg)){ ?>
			var msg = "<?php echo $fmsg ?>";
			swal("Registration Failed!",msg,"error");
			<?php } ?>
			
			
			function myFunction() {
				var x = document.getElementById("myTopnav");
				if (x.className === "topnav") {
					x.className += " responsive";
				} else {
					x.className = "topnav";
				}
			}
			
			// Wait for the DOM to be ready
	
		</script>
		
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
	<script src="test1.js"></script>
    </body>
</html>