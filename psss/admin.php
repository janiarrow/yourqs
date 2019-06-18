<?php

//	session_start();
//
//	if (isset($_SESSION['username'])) {
//		$welcomemsg = " - " . $_SESSION['username'];
//	} else {
//		header("Location: ../error.php");
//	}

	require_once('./connect.php');

	if (isset($_GET) & !empty($_GET['id'])) {
		
		$uid = $_GET['id'];
		
		
		$delSql = "DELETE FROM user WHERE user_id=$uid";
		
		$res = mysqli_query($connection, $delSql);

		if ($res) {
			$fmsg = "User deleted successfully";
		} else {
			$fmsg = "Failed to delete the user";
		}
		
	}

	$record_per_page = 10;
	$page            = '';

	if (isset($_GET["page"])) {
		$page = $_GET["page"];
	} else {
		$page = 1;
	}

	$start_from = ($page - 1) * $record_per_page;

	$query   = "SELECT * FROM user order by user_id ASC ";
//LIMIT $start_from, $record_per_page
	$records = mysqli_query($connection, $query);
	
?>

<html>

	<head>
        <meta charset="utf-8">
        <meta name="description" content="YourQS">
        <meta name="author" content="aspire2international">
<!--
        <link href="bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">		
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
-->
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
			<a class="active">User List</a>
			<a href="register.php" >New User</a>
			<a href="index.php?lgout=1">Logout</a>
		  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
			<i class="fa fa-bars"></i>
		  </a>
		</div>
	
	<div class="limiter">
		<div class="container-admin100">
			<div class="wrap-login100 p-b-160 p-t-50">
			<span class="login100-form-title p-b-43">
						User Accounts
			</span>
			
			
			<div class="table-responsive">
			  <table class="table table-hover table-striped">
				  <thead>
				   <tr>
				  </tr>
					  </thead>
				  <tbody>
					  <?php
						 while($user = mysqli_fetch_assoc($records)){
						  ?>
					<tr class="rowX">
					  <td scope="row"><a href="register.php"> <?php echo $user['firstname']." ".$user['lastname'];?> </a></td>
					  <td scope="row"><?php echo $user['email'];?></td>
					  <td><a onclick="delclick('<?php echo $user['user_id']; ?>')"  class="btn btn-sm">  <img width="35" height="25" src="images/icons/Recycle_Bin_Full.png">
							</a></td>
					</tr>
					  
					   <?php }?>
				  </tbody>
			  </table>
			</div>
			
		</div>
		</div>
	 </div>
	</body>
	
	<script>
		
		
		 <?php if(isset($fmsg)){ ?>
			swal("<?php echo $fmsg ?>");
		<?php } ?>
		
		function delclick(uid){
			
			swal({
				  title: "Are you sure?",
				  text: "Are you sure you want to delete this user?",
				  icon: "warning",
				  buttons:  {
					remove: "Yes",
					cancel: "No",
				  },
				  dangerMode: true,
				})
				.then((value) => {
				
					switch (value) {

					case "remove":
							
						window.location="admin.php?id="+uid;
						  break;

					}
				
				});
			
		}
	
		function myFunction() {
			var x = document.getElementById("myTopnav");
			if (x.className === "topnav") {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
		}
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
	
	
</html>