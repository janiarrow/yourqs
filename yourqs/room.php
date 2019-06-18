<?php

	session_start();

	if (!isset($_SESSION['username'])) {
		header("Location: error.php");
	}

	require_once('connect.php');

	if(isset($_GET['delrid']) && !empty($_GET['delrid'])){
		
		$roomid = $_GET['delrid'];
		
		$selectSql = "SELECT * FROM room WHERE room_id=$roomid";
		$res       = mysqli_query($connection, $selectSql);
		$rmRS      = mysqli_fetch_assoc($res);
		$projid = $rmRS['project_id'];
		
		$delSql = "DELETE FROM room WHERE room_id=$roomid";
		
		$res = mysqli_query($connection, $delSql);

		if ($res) {
			$fmsg = "Room deleted successfully. Redirecting to Project";
		} else {
			$fmsg = "Failed to delete the room";
		}
		
	}else if(isset($_GET['extid']) && !empty($_GET['extid'])){
		
		$extid = $_GET['extid'];
		
		$selectSql = "SELECT * FROM exterior_scope WHERE exterior_id=$extid";
		$res       = mysqli_query($connection, $selectSql);
		$eRS      = mysqli_fetch_assoc($res);
		$projid 	  = $eRS['project_id'];
		
		$delSql = "DELETE FROM exterior_scope WHERE exterior_id=$extid";
		
		$res = mysqli_query($connection, $delSql);

		if ($res) {
			$fmsg = "Exterior deleted successfully. Redirecting to Project";
		} else {
			$fmsg = "Failed to delete the Exterior";
		}
		
	}else if(isset($_GET['roomid']) && !empty($_GET['roomid'])){
	
		$roomid = $_GET['roomid'];
		
		$SelSql = "SELECT * FROM room WHERE room_id=$roomid";
		$res   = mysqli_query($connection, $SelSql);
		$rmRS     = mysqli_fetch_assoc($res);
		
		$roomname  = $rmRS['room_name'];
		$projid = $rmRS['project_id'];
	
		$SelSql = "SELECT * FROM description WHERE room_id=$roomid";
		$res   = mysqli_query($connection, $SelSql);
		$descRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM subtrades WHERE room_id=$roomid";
		$res   = mysqli_query($connection, $SelSql);
		$subRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM windows_doors WHERE room_id=$roomid";
		$res   = mysqli_query($connection, $SelSql);
		$winRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM joinery WHERE room_id=$roomid";
		$res   = mysqli_query($connection, $SelSql);
		$jRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM other WHERE room_id=$roomid";
		$res   = mysqli_query($connection, $SelSql);
		$otherRS     = mysqli_fetch_assoc($res);
		
		
//		rooms
		$selectSql = "SELECT * FROM room WHERE project_id=$projid ";
		$roomRS     = mysqli_query($connection, $selectSql);
		
//		exterior
		$selectSql = "SELECT * FROM exterior_scope WHERE project_id=$projid ";
		$exteriorRS    = mysqli_query($connection, $selectSql);
		
	}else if (isset($_POST) && !empty($_POST)) {
		
		if (isset($_POST) && !empty($_POST['projid'])) {
			$projid = $_POST['projid'];
		
		}else if(isset($_POST['save']) || isset($_POST['edit'])){
        
        // Room details
//        echo 'inserting new room data';
        
		if(isset($_POST['save'])){
			$SelSql = "SELECT room_id FROM room order by room_id DESC";
			$save   = mysqli_query($connection, $SelSql);
			$p      = mysqli_fetch_assoc($save);
			$id     = $p['room_id'] + 1;
		}else{
			$id     = $_POST['roomid'];
		}

        //	Room details
			$projid      = $_POST['projectid'];

			$room_name      = $_POST['room_name'];
			$carpet_protection   = $_POST['carpet_protection'];
			$scotia_type   = $_POST['scotia_type'];
			$window_architrave   = $_POST['window_architrave'];
			$skirting_type   = $_POST['skirting_type'];
			$door_architrave   = $_POST['door_architrave'];
			$allow_extra_hours   = $_POST['allow_extra_hours'];
			
			if($scotia_type=='Specify'){
				$scotia_type = $_POST['specify_scotia_type'];
			}
			
			if($window_architrave=='Specify'){
				$window_architrave = $_POST['specify_window_architrave'];
			}
			
			if($skirting_type=='Specify'){
				$skirting_type = $_POST['specify_skirting_type'];
			}
			
			if($door_architrave=='Specify'){
				$door_architrave = $_POST['specify_door_architrave'];
			}
			
			
		if(isset($_POST['save'])){

			$insertSql = "INSERT INTO room(project_id,room_id,room_name,carpet_protection,scotia_type,window_architrave,skirting_type,door_architrave,allow_extra_hours) VALUES($projid,$id,'$room_name','$carpet_protection','$scotia_type','$window_architrave','$skirting_type','$door_architrave','$allow_extra_hours')";
	
		}else{
			
			$insertSql = "UPDATE room SET room_name='$room_name',carpet_protection='$carpet_protection',scotia_type='$scotia_type',window_architrave='$window_architrave',skirting_type='$skirting_type',door_architrave='$door_architrave',allow_extra_hours='$allow_extra_hours' WHERE room_id=$id";
		}
//		echo $insertSql;
		$save = mysqli_query($connection, $insertSql);		
	
        // Description of work
        
		$walls_demolition = $_POST['walls_demolition'];
		$walls_renovation = $_POST['walls_renovation'];
		$ceiliing_demolition = $_POST['ceiliing_demolition'];
		$ceiling_renovation  = $_POST['ceiling_renovation'];
		$floor_demolition  = $_POST['floor_demolition'];
        $floor_renovation  = $_POST['floor_renovation'];
        $floor_covering  = $_POST['floor_covering'];
			
			if($floor_covering=='other'){
				 $floor_covering  = $_POST['specify_floor_covering'];
			}
			
		if(isset($_POST['save'])){
			$insertSql = "INSERT INTO description(project_id,room_id,walls_demolition,walls_renovation,ceiliing_demolition,ceiling_renovation,floor_demolition,floor_renovation,floor_covering) VALUES($projid ,$id,'$walls_demolition' ,'$walls_renovation','$ceiliing_demolition','$ceiling_renovation' ,'$floor_demolition','$floor_renovation','$floor_covering')";
		}else{
			$insertSql = "UPDATE description SET walls_demolition='$walls_demolition',walls_renovation='$walls_renovation',ceiliing_demolition='$ceiliing_demolition',ceiling_renovation='$ceiling_renovation',floor_demolition='$floor_demolition',floor_renovation='$floor_renovation',floor_covering='$floor_covering' WHERE room_id=$id";
		}
        
//			echo $insertSql;
		$save = mysqli_query($connection, $insertSql);

		$lights    = $_POST['lights'];
		$electrical  = $_POST['electrical'];
		$plumbing    = $_POST['plumbing'];
		$painting    = $_POST['painting'];
		$paint_prep   = $_POST['paint_prep'];
		$comments     = $_POST['scomments'];
		
//		Subtrades
		if(isset($_POST['save'])){
			$insertSql = "INSERT INTO subtrades(project_id,room_id,lights,electrical,plumbing,painting,paint_prep,comments) 
			   VALUES($projid,$id,'$lights','$electrical','$plumbing','$painting','$paint_prep','$comments')";
		}else{
			$insertSql = "UPDATE subtrades SET lights='$lights',electrical='$electrical',plumbing=,'$plumbing',painting=,'$painting',paint_prep=,'$paint_prep',comments='$comments' WHERE room_id=$id";
		}
			//echo $insertSql;
		$save = mysqli_query($connection, $insertSql);
		
		//Windows and doors

		$windows_demolition = $_POST['windows_demolition'];
		$windows_renovation = $_POST['windows_renovation'];
		$window_type        = $_POST['window_type'];
		$doors_demolition   = $_POST['doors_demolition'];
		$doors_renovation   = $_POST['doors_renovation'];
		$doors_type         = $_POST['doors_type'];
        $comments         = $_POST['wcomments'];
			
		if($doors_type=='Other'){
			$doors_type         = $_POST['specify_doors_type'];
		}
		
		if(isset($_POST['save'])){
			$insertSql = "INSERT INTO windows_doors(project_id,room_id,windows_demolition,windows_renovation,window_type,doors_demolition,doors_renovation,doors_type,comments) 
			VALUES($projid,$id, '$windows_demolition','$windows_renovation', '$window_type','$doors_demolition','$doors_renovation' ,'$doors_type','$comments')";
		}else{
			$insertSql = "UPDATE windows_doors SET windows_demolition='$windows_demolition',windows_renovation='$windows_renovation', window_type='$window_type',doors_demolition='$doors_demolition',doors_renovation='$doors_renovation' ,doors_type='$doors_type',comments='$comments' WHERE room_id=$id";
		}
//echo $insertSql;
		$save = mysqli_query($connection, $insertSql);

		//Joinery
		
		$joinery_demolition      = $_POST['joinery_demolition'];
		$joinery_renovation = $_POST['joinery_renovation'];
		$new_type        = $_POST['new_type']; 
        $allowance        = $_POST['allowance'];  
        $comments        = $_POST['jcomments'];    
            
		if(isset($_POST['save'])){
			$insertSql = "INSERT INTO joinery(project_id,room_id,joinery_demolition,joinery_renovation,new_type,allowance,comments) 
				   VALUES($projid,$id,'$joinery_demolition','$joinery_renovation','$new_type',$allowance,'$comments')";
		}else{
			$insertSql = "UPDATE joinery SET joinery_demolition='$joinery_demolition',joinery_renovation='$joinery_renovation',new_type='$new_type',allowance=$allowance,comments ='$comments' WHERE room_id=$id";
		}
//        echo $insertSql;
        $save = mysqli_query($connection, $insertSql);
        
        // Other
        
        $other_demolition      = $_POST['joinery_demolition'];
		$other_renovation = $_POST['joinery_renovation'];
        $allowance        = $_POST['oallowance'];  
        $comments        = $_POST['otcomments'];    
            
		if(isset($_POST['save'])){
			$insertSql = "INSERT INTO other(project_id,room_id,other_demolition,other_renovation,allowance,comments) 
			   VALUES($projid,$id,'$other_demolition','$other_renovation','$allowance','$comments')";
		}else{
			$insertSql = "UPDATE other SET other_demolition='$other_demolition',other_renovation='$other_renovation',allowance='$allowance',comments='$comments' WHERE room_id=$id";
		}
//        echo $insertSql;
         $save = mysqli_query($connection, $insertSql);
        
		 $success = true;
			
			
		$SelSql = "SELECT * FROM room WHERE room_id=$id";
		$res   = mysqli_query($connection, $SelSql);
		$rmRS     = mysqli_fetch_assoc($res);
		
		$roomname  = $rmRS['room_name'];
		$projid = $rmRS['project_id'];
	
		$SelSql = "SELECT * FROM description WHERE room_id=$id";
		$res   = mysqli_query($connection, $SelSql);
		$descRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM subtrades WHERE room_id=$id";
		$res   = mysqli_query($connection, $SelSql);
		$subRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM windows_doors WHERE room_id=$id";
		$res   = mysqli_query($connection, $SelSql);
		$winRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM joinery WHERE room_id=$id";
		$res   = mysqli_query($connection, $SelSql);
		$jRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM other WHERE room_id=$id";
		$res   = mysqli_query($connection, $SelSql);
		$otherRS     = mysqli_fetch_assoc($res);
		
//		rooms
		$selectSql = "SELECT * FROM room WHERE project_id=$projid";
		$roomRS     = mysqli_query($connection, $selectSql);
		
//		exterior
		$selectSql = "SELECT * FROM exterior_scope WHERE project_id=$projid";
		$exteriorRS    = mysqli_query($connection, $selectSql);
		
	  }
		
	}

?>

<html>
	
	<head>
         <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="YourQS">
        <meta name="author" content="aspire2international">

		<link rel="stylesheet" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v3.0.1/dist/bootstrap-float-label.min.css"/>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		
<!--		<link href="bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">-->
		<script src="bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
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
		<link rel="stylesheet" type="text/css" href="css/form.css">
	<!--===============================================================================================-->
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
	<body>
		
		<div class="topnav" id="myTopnav">
<!--			<a class="active" data-toggle="dropdown">Project</a>-->
<!--			<div class="dropdown-menu">-->
				<a class="active" data-toggle="modal" href="#roomoption">Room</a>
				<a class="" data-toggle="modal" href="#extoption">Exterior</a>
<!--			</div>-->
<!--		  <a href="index.php">Project List</a>-->
			<a href="login.php?lgout=1">Logout</a>
			<a href="javascript:void(0);" class="icon" onclick="myFunction()">
			<i class="fa fa-bars"></i>
			</a>		  
		</div>
		
		<nav aria-label="breadcrumb" id="myTopnav">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Project List</a></li>
			  <li class="breadcrumb-item"><a href="project.php?id=<?php echo $projid; ?>">Project</a></li>
			<li class="breadcrumb-item" aria-current="page">Room <?php if(isset($roomname) && !empty($roomname)) echo " - ".$roomname; ?></li>
		  </ol>
		</nav>
		
		<div class="modal fade" id="roomoption">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Room List</h4>
					  <button type="button" class="close" data-dismiss="modal">&times;</button>	
					</div>
					<div class="modal-body">
						<form action="room.php" method="post">
						<?php if(isset($roomRS)) { ?>
						
							
						<div class="table-responsive-sm">
							<table class="table table-hover table-borderless table-sm">
							  <tbody>
							 <?php while($rooms = mysqli_fetch_assoc($roomRS)){?>
								<tr>
								   <td scope="row" width="90%">
									   <a onclick="editroom('<?php echo $rooms['room_id']; ?>')" class="btn btn-block"><?php echo $rooms['room_name']; ?></a>
									</td>
									<td scope="row" width="10%">
										<a onclick="delroom('<?php echo $rooms['room_id']; ?>')"  class="btn btn-sm"> <img width="40" height="30" src="images/icons/Recycle_Bin_Full.png"></a>
									 </td>
								</tr>
								  <input type="hidden" name="projid" value="<?php echo $rooms['project_id']; ?>"/>
								   <?php } ?>
							</table>
						</div>
						 <?php } ?>
							<input type="hidden" name="projid" value="<?php echo $projid; ?>"/>
							<button class="btn btn-primary btn-block">New Room</button>
							</form>
					</div>
				  </div>
				</div>
			  </div>
		
			  <div class="modal fade" id="extoption">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Exterior List</h4>
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<?php if(isset($exteriorRS)) { ?>
						<form action="exterior.php" method="post">
						<div class="table-responsive-sm">
							<table class="table table-hover table-borderless table-sm">
							  <tbody>
								  <?php while($exterior = mysqli_fetch_assoc($exteriorRS)){?>
								<tr>
								   <td width="90%">
									   <a onclick="editext('<?php echo $exterior['exterior_id']; ?>')" class="btn btn-block"><?php echo $exterior['name']; ?></a>
									</td>
									<td width="10%">
										<a onclick="delext('<?php echo $exterior['exterior_id']; ?>')"  class="btn btn-sm"> <img width="40" height="30" src="images/icons/Recycle_Bin_Full.png"></a>
									</td>
								</tr>
								  <input type="hidden" name="projid" value="<?php echo $exterior['project_id']; ?>"/>
								  <?php } ?>
							</table>
						</div>
						 <?php } ?>
							<input type="hidden" name="projid" value="<?php echo $projid; ?>"/>
							<button class="btn btn-primary btn-block">New Exterior</button>
							</form>
					</div>
				  </div>
				</div>
			  </div>
			  
		
		
		<form action="room.php" method="POST" name="roomform" class="bootstrap-form needs-validation" novalidate>
		<div id="accordion">
			
		  <div class="card">
			<div class="card-header" id="headingOne">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					Room Details
				</button>
			  </h5>
			</div>

			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			  <div class="card-body">
                  
				  <form>
				  	<span class="form-group has-float-label">
						<input class="form-control" type="text" name="room_name" placeholder=" " value="<?php if(isset($rmRS['room_name'])) echo $rmRS['room_name']; ?>"/>
						<label>Room Name</label>
<!--
						 <div class="invalid-feedback">
							Please enter valid Room Name
						  </div>
-->
					  </span>
					   <span>
						  <input class="form-control" type="hidden" name="projectid" placeholder=" " value="<?php echo $projid; ?>"/>
					  </span>
                     <span class="form-group has-float-label">
						 <select class="form-control" name="carpet_protection">
						  <option <?php if(isset($rmRS['carpet_protection']) && $rmRS['carpet_protection']=='Yes'){ ?> selected <?php } ?>>Yes</option>
						  <option <?php if(isset($rmRS['carpet_protection']) && $rmRS['carpet_protection']=='No'){ ?> selected <?php } ?>>No</option>
						</select>
						<label>Carpet protection</label>
					  </span> 
                      
					 <span class="form-group has-float-label">
						 <select class="form-control" name="scotia_type" id="scotia_type">
						  <option <?php if(isset($rmRS['scotia_type']) && $rmRS['scotia_type']=='None'){ ?> selected <?php } ?>>None</option>
						  <option <?php if(isset($rmRS['scotia_type']) && $rmRS['scotia_type']=='Square'){ ?> selected <?php } ?>>Square Stop</option>
						  <option <?php if(isset($rmRS['scotia_type']) && $rmRS['scotia_type']=='Specify'){ ?> selected <?php } ?>>Specify</option>
						</select>
						<label>Scotia Type</label>
					 </span>
					  <span class="form-group has-float-label"  id="specify_scotia_type">
						  <input class="form-control" type="text" name="specify_scotia_type" placeholder=" " value="<?php if(isset($rmRS['scotia_type'])) echo $rmRS['scotia_type']; ?>"/>
						<label>Specify Scotia Type</label>
<!--
						  <div class="invalid-feedback">
							Please enter valid Scotia Type
						  </div>
-->
					  </span>
					  <span class="form-group has-float-label">
						 <select class="form-control" name="window_architrave" id="window_architrave">
						  <option <?php if(isset($rmRS['window_architrave']) && $rmRS['window_architrave']=='None'){ ?> selected <?php } ?>>None</option>
						  <option <?php if(isset($rmRS['window_architrave']) && $rmRS['window_architrave']=='Specify'){ ?> selected <?php } ?>>Specify</option>
						</select>
						<label>Window Architrave</label>
					  </span>
					  <span class="form-group has-float-label"  id="specify_window_architrave">
						  <input class="form-control" type="text" name="specify_window_architrave" placeholder=" " value="<?php if(isset($rmRS['window_architrave'])) echo $rmRS['window_architrave']; ?>"/>
						<label>Specify Window Architrave</label>
<!--
						   <div class="invalid-feedback">
							Please enter valid Window Architrave
						  </div>
-->
					  </span>
					  
					  <span class="form-group has-float-label">
						 <select class="form-control"  name="skirting_type" id="skirting_type">
						  <option <?php if(isset($rmRS['skirting_type']) && $rmRS['skirting_type']=='None'){ ?> selected <?php } ?>>None</option>
						  <option <?php if(isset($rmRS['skirting_type']) && $rmRS['skirting_type']=='Specify'){ ?> selected <?php } ?>>Specify</option>
						</select>
						<label>Skirting Type</label>
					  </span>
					  <span class="form-group has-float-label"  id="specify_skirting_type">
						  <input class="form-control" type="text" name="specify_skirting_type" placeholder=" " value="<?php if(isset($rmRS['skirting_type'])) echo $rmRS['skirting_type']; ?>"/>
						<label>Specify Skirting Type</label>
<!--
						    <div class="invalid-feedback">
							Please enter valid Skirting Type
						  </div>
-->
					  </span>
					  <span class="form-group has-float-label">
						 <select class="form-control" name="door_architrave" id="door_architrave">
						  <option <?php if(isset($rmRS['door_architrave']) && $rmRS['door_architrave']=='None'){ ?> selected <?php } ?>>None</option>
						  <option <?php if(isset($rmRS['door_architrave']) && $rmRS['door_architrave']=='Specify'){ ?> selected <?php } ?>>Specify</option>
						</select>
						<label>Door Architrave</label>
						 
					  </span>
					   <span class="form-group has-float-label"  id="specify_door_architrave">
						  <input class="form-control" type="text" name="specify_door_architrave" placeholder=" " value="<?php if(isset($rmRS['door_architrave'])) echo $rmRS['door_architrave']; ?>"/>
						<label>Specify Door Architrave</label>
<!--
						    <div class="invalid-feedback">
							Please enter valid Door Architrave
						  </div>
-->
					  </span>
					  <span class="form-group has-float-label">
						<input class="form-control" type="text" name="allow_extra_hours" placeholder=" " value="<?php if(isset($rmRS['allow_extra_hours'])) echo $rmRS['allow_extra_hours']; ?>"/>
						<label>Allow Extra Hours</label>
<!--
						  <div class="invalid-feedback">
							Please enter valid Allow Extra Hours
						  </div>
-->
					  </span>
				  </form>
			  </div>
			</div>
		  </div>
		  <div class="card">
			<div class="card-header" id="headingTwo">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
				 Description of work
				</button>
			  </h5>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
			  <div class="card-body">
			 
				 <span class="form-group has-float-label">
						 <textarea data-autoresize rows="1" class="form-control" type="text" id="walls_demolition" name="walls_demolition" placeholder=" " ><?php if(isset($descRS['walls_demolition'])) echo $descRS['walls_demolition']; ?></textarea>
						<label>Walls - Demolition</label>
<!--
					  <div class="invalid-feedback">
							Please enter valid description of Walls - Demolition 
						  </div>
-->
					  </span>
				 <span class="form-group has-float-label">
						 <textarea data-autoresize rows="1" class="form-control" type="text" id="walls_renovation" name="walls_renovation" placeholder=" " ><?php if(isset($descRS['walls_renovation'])) echo $descRS['walls_renovation']; ?></textarea>
						<label>Walls - Renovation</label>
<!--
					 <div class="invalid-feedback">
							Please enter valid description of Walls - Renovation 
						  </div>
-->
					  </span>
				 <span class="form-group has-float-label">
						<textarea data-autoresize rows="1"  class="form-control" type="text" id="ceiliing_demolition" name="ceiliing_demolition" placeholder=" " ><?php if(isset($descRS['ceiliing_demolition'])) echo $descRS['ceiliing_demolition']; ?></textarea>
						<label>Ceiling - Demolition</label>
<!--
					 <div class="invalid-feedback">
							Please enter valid description of Ceiling - Demolition
						  </div>
-->
					  </span>
				 <span class="form-group has-float-label">
						<textarea data-autoresize rows="1"  class="form-control" type="text" id="ceiling_renovation" name="ceiling_renovation" placeholder=" " ><?php if(isset($descRS['ceiling_renovation'])) echo $descRS['ceiling_renovation']; ?></textarea>
						<label>Ceiling - Renovation</label>
<!--
					  <div class="invalid-feedback">
							Please enter valid description of Ceiling - Renovation
						  </div>
-->
					  </span>
				  <span class="form-group has-float-label">
						<textarea data-autoresize rows="1" class="form-control" type="text" id="floor_demolition" name="floor_demolition" placeholder=" " ><?php if(isset($descRS['floor_demolition'])) echo $descRS['floor_demolition']; ?></textarea>
						<label>Floor - Demolition</label>
<!--
					    <div class="invalid-feedback">
							Please enter valid description of Floor - Demolition
						  </div>
-->
					  </span>
				 <span class="form-group has-float-label">
						<textarea data-autoresize rows="1" class="form-control" type="text" id="floor_renovation" name="floor_renovation" placeholder=" " ><?php if(isset($descRS['floor_renovation'])) echo $descRS['floor_renovation']; ?></textarea>
						<label>Floor - Renovation</label>
<!--
					  <div class="invalid-feedback">
							Please enter valid description of Floor - Renovation
						  </div>
-->
					  </span>
				 <span class="form-group has-float-label">
						<select class="form-control" id="floor_covering" name="floor_covering">
						   <option <?php if(isset($descRS['floor_covering']) && $descRS['floor_covering']=='Existing'){ ?> selected <?php } ?>>None or Existing</option>
						  <option <?php if(isset($descRS['floor_covering']) && $descRS['floor_covering']=='Carpet'){ ?> selected <?php } ?>>Carpet</option>
						  <option <?php if(isset($descRS['floor_covering']) && $descRS['floor_covering']=='Vinyl'){ ?> selected <?php } ?>>Vinyl</option>
							<option <?php if(isset($descRS['floor_covering']) && $descRS['floor_covering']=='Tiles'){ ?> selected <?php } ?>>Tiles</option>
						  <option <?php if(isset($descRS['floor_covering']) && $descRS['floor_covering']=='Ovelay'){ ?> selected <?php } ?>>Timber Ovelay</option>
							 <option <?php if(isset($descRS['floor_covering']) && $descRS['floor_covering']=='other'){ ?> selected <?php } ?>>other</option>
						</select>
						<label>Floor Covering</label>
				  </span>
				  <span class="form-group has-float-label"  id="specify_floor_covering">
						  <input class="form-control" type="text" name="specify_floor_covering" placeholder=" " value="<?php if(isset($descRS['floor_covering'])) echo $descRS['floor_covering']; ?>"/>
						<label>Other Floor Covering</label>
<!--
					  <div class="invalid-feedback">
							Please enter valid Other Floor Covering
						  </div>
-->
					  </span>
			  </div>
			</div>
		  </div>
		  <div class="card">
			<div class="card-header" id="headingThree">
			  <h5 class="mb-0">
				<button class="btn btn-link  btn-lg collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
				  Sub Trades
				</button>
			  </h5>
			</div>
    
			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
			  <div class="card-body">
					 <span class="form-group has-float-label">
						<input class="form-control" type="text" id="lights" name="lights" placeholder=" " value="<?php if(isset($subRS['lights'])) echo $subRS['lights']; ?>"/>
						<label>Lights</label>
<!--
						 <div class="invalid-feedback">
							Please enter valid Lights
						  </div>
-->
					  </span>
					  <span class="form-group has-float-label">
						<input class="form-control" type="text" id="electrical" name="electrical" placeholder=" " value="<?php if(isset($subRS['electrical'])) echo $subRS['electrical']; ?>"/>
						<label>Electrical</label>
<!--
						  <div class="invalid-feedback">
							Please enter valid Electrical
						  </div>
-->
					  </span>
					 
						<span class="form-group has-float-label">
						<select class="form-control" id="plumbing" name="plumbing">
						  <option <?php if(isset($subRS['plumbing']) && $subRS['plumbing']=='Bath'){ ?> selected <?php } ?>>Bath</option>
						  <option <?php if(isset($subRS['plumbing']) && $subRS['plumbing']=='Vanity'){ ?> selected <?php } ?>>Vanity</option>
						  <option <?php if(isset($subRS['plumbing']) && $subRS['plumbing']=='Toilet'){ ?> selected <?php } ?>>Toilet</option>
						  <option <?php if(isset($subRS['plumbing']) && $subRS['plumbing']=='Laundry Tub'){ ?> selected <?php } ?>>Laundry Tub</option>
						  <option <?php if(isset($subRS['plumbing']) && $subRS['plumbing']=='HWC'){ ?> selected <?php } ?>>HWC</option>
						  <option <?php if(isset($subRS['plumbing']) && $subRS['plumbing']=='Kitchen Sink'){ ?> selected <?php } ?>>Kitchen Sink</option>
						 <option <?php if(isset($subRS['plumbing']) && $subRS['plumbing']=='other'){ ?> selected <?php } ?>>other</option>
						</select>
						<label>Plumbing</label>
					  </span>
					 
					 <span class="form-group has-float-label">
						<select class="form-control" id="painting" name="painting">
						   <option <?php if(isset($subRS['painting']) && $subRS['painting']=='Walls'){ ?> selected <?php } ?>>Walls</option>
						  <option <?php if(isset($subRS['painting']) && $subRS['painting']=='Ceiling'){ ?> selected <?php } ?>>Ceiling</option>
						  <option <?php if(isset($subRS['painting']) && $subRS['painting']=='Windows'){ ?> selected <?php } ?>>Windows</option>
							<option <?php if(isset($subRS['painting']) && $subRS['painting']=='Door'){ ?> selected <?php } ?>>Door</option>
						  <option <?php if(isset($subRS['painting']) && $subRS['painting']=='Floor'){ ?> selected <?php } ?>>Floor</option>
						</select>
						<label <?php if(isset($subRS['painting']) && $subRS['painting']=='Painting'){ ?> selected <?php } ?>>Painting</label>
					  </span>
					 
					 <span class="form-group has-float-label">
						<select class="form-control" id="paint_prep" name="paint_prep">
						   <option <?php if(isset($subRS['paint_prep']) && $subRS['paint_prep']=='Minor'){ ?> selected <?php } ?>>Minor</option>
						  <option <?php if(isset($subRS['paint_prep']) && $subRS['paint_prep']=='Moderate'){ ?> selected <?php } ?>>Moderate</option>
						  <option <?php if(isset($subRS['paint_prep']) && $subRS['paint_prep']=='Significant'){ ?> selected <?php } ?>>Significant</option>
						</select>
						<label>Paint Prep</label>
					  </span>
					 <span class="form-group has-float-label">
						 <textarea data-autoresize rows="1"  class="form-control" type="text" id="comments" name="scomments" placeholder=" " ><?php if(isset($subRS['comments'])) echo $subRS['comments']; ?></textarea>
						<label>Comments</label>
<!--
						  <div class="invalid-feedback">
							Please enter valid comment on sub trades
						  </div>
-->
					  </span>
			  </div>
			</div>
			</div>
			<div class="card">
			<div class="card-header" id="headingFour">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				  Windows and Doors
				</button>
			  </h5>
			</div>
			<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
			  <div class="card-body">
				
				  
				  <span class="form-group has-float-label">
						<input class="form-control" type="text" id="windows_demolition" name="windows_demolition" placeholder=" " value="<?php if(isset($winRS['windows_demolition'])) echo $winRS['windows_demolition']; ?>"/>
						<label>Windows Demolition</label>
<!--
					  <div class="invalid-feedback">
							Please enter valid input for Windows Demolition
						  </div>
-->
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="text" id="windows_renovation" name="windows_renovation" placeholder=" " value="<?php if(isset($winRS['windows_renovation'])) echo $winRS['windows_renovation']; ?>"/>
						<label>Windows Renovation</label>
<!--
						<div class="invalid-feedback">
							Please enter valid input for Windows Renovation
						  </div>
-->
					  </span>
					 <span class="form-group has-float-label">
						<select class="form-control" id="window_type" name="window_type">
						   <option <?php if(isset($winRS['window_type']) && $winRS['window_type']=='Relocated'){ ?> selected <?php } ?>>Relocated</option>
						  <option <?php if(isset($winRS['window_type']) && $winRS['window_type']=='Timber Frame'){ ?> selected <?php } ?>>Timber Frame</option>
						  <option <?php if(isset($winRS['window_type']) && $winRS['window_type']=='Aluminium Frame'){ ?> selected <?php } ?>>Aluminium Frame</option>
						</select>
						<label>Window Type</label>
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="text" id="doors_demolition" name="doors_demolition" placeholder=" " value="<?php if(isset($winRS['doors_demolition'])) echo $winRS['doors_demolition']; ?>"/>
						<label>Doors Demolition</label>
<!--
						<div class="invalid-feedback">
							Please enter valid input for Doors Demolition
						  </div>
-->
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="text" id="doors_renovation" name="doors_renovation" placeholder=" " value="<?php if(isset($winRS['doors_renovation'])) echo $winRS['doors_renovation']; ?>"/>
						<label>Doors Renovation</label>
<!--
						<div class="invalid-feedback">
							Please enter valid input for Doors Renovation
						  </div>
-->
					  </span>
					 <span class="form-group has-float-label">
						<select class="form-control" id="doors_type" name="doors_type">
						   <option <?php if(isset($winRS['doors_type']) && $winRS['doors_type']=='Relocated'){ ?> selected <?php } ?>>Relocated</option>
						  <option <?php if(isset($winRS['doors_type']) && $winRS['doors_type']=='MDF PQ'){ ?> selected <?php } ?>>MDF PQ</option>
						  <option <?php if(isset($winRS['doors_type']) && $winRS['doors_type']=='Timber'){ ?> selected <?php } ?>>Timber</option>
							<option <?php if(isset($winRS['doors_type']) && $winRS['doors_type']=='Glass'){ ?> selected <?php } ?>>Glass</option>
						  <option <?php if(isset($winRS['doors_type']) && $winRS['doors_type']=='Other'){ ?> selected <?php } ?>>Other</option>
						</select>
						<label>Doors Type</label>
					  </span>
				    <span class="form-group has-float-label"  id="specify_doors_type">
						  <input class="form-control" type="text" name="specify_doors_type" placeholder=" " value="<?php if(isset($winRS['doors_type'])) echo $winRS['doors_type']; ?>"/>
						<label>Other Doors Type</label>
					  </span>
					<span class="form-group has-float-label">
						<textarea data-autoresize rows="1"  class="form-control" type="text" id="comments" name="wcomments" placeholder=" "><?php if(isset($winRS['comments'])) echo $winRS['comments']; ?></textarea>
						<label>Comments</label>
<!--
						<div class="invalid-feedback">
							Please enter valid input for comment on windows and doors
						  </div>
-->
					  </span>
				  
			  </div>
			</div>
			</div>
			<div class="card">
			<div class="card-header" id="headingFive">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				 Joinery
				</button>
			  </h5>
			</div>
			<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
			  <div class="card-body">
				
				  
				  <span class="form-group has-float-label">
						<input class="form-control" type="text" id="joinery_demolition" name="joinery_demolition" placeholder=" " value="<?php if(isset($jRS['joinery_demolition'])) echo $jRS['joinery_demolition']; ?>"/>
						<label>Joinery Demolition</label>
<!--
					  <div class="invalid-feedback">
							Please enter valid input Joinery Demolition
						  </div>
-->
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="text" id="joinery_renovation" name="joinery_renovation" placeholder=" " value="<?php if(isset($jRS['joinery_renovation'])) echo $jRS['joinery_renovation']; ?>"/>
						<label>Joinery Renovation</label>
<!--
						<div class="invalid-feedback">
							Please enter valid input Joinery Renovation
						  </div>
-->
					  </span>
					<span class="form-group has-float-label">
						<select class="form-control" id="new_type" name="new_type">
						   <option <?php if(isset($jRS['new_type']) && $jRS['new_type']=='Kitchen'){ ?> selected <?php } ?>>Kitchen</option>
						  <option <?php if(isset($jRS['new_type']) && $jRS['new_type']=='Laundry'){ ?> selected <?php } ?>>Laundry</option>
						  <option <?php if(isset($jRS['new_type']) && $jRS['new_type']=='Wardrobe'){ ?> selected <?php } ?>>Wardrobe</option>
						  <option <?php if(isset($jRS['new_type']) && $jRS['new_type']=='Other'){ ?> selected <?php } ?>>Other</option>
						</select>
						<label>New Type</label>
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="allowance" name="allowance" placeholder=" " value="<?php if(isset($jRS['allowance'])) echo $jRS['allowance']; ?>"/>
						<label>Allowance</label>
<!--
						<div class="invalid-feedback">
							Please enter valid input for Allowance
						  </div>
-->
					  </span>
					<span class="form-group has-float-label">
						<textarea data-autoresize rows="1"  class="form-control" type="text" id="comments" name="jcomments" placeholder=" " ><?php if(isset($jRS['comments'])) echo $jRS['comments']; ?></textarea>
						<label>Comments</label>
<!--
						<div class="invalid-feedback">
							Please enter valid comment on Joinery
						  </div>
-->
					  </span>
				  
			  </div>
			</div>
				</div>
			<div class="card">
			<div class="card-header" id="headingEight">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
				  Other
				</button>
			  </h5>
			</div>
			<div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
			  <div class="card-body">
				
				  
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"  class="form-control" type="text" id="other_demolition" name="other_demolition" placeholder=" " ><?php if(isset($otherRS['other_demolition'])) echo $otherRS['other_demolition']; ?></textarea>
						<label>Other Demolition</label>
<!--
					  <div class="invalid-feedback">
							Please enter valid input for Other Demolition
						  </div>
-->
					  </span>
					<span class="form-group has-float-label">
						<textarea data-autoresize rows="1"  class="form-control" type="text" id="other_renovation" name="other_renovation" placeholder=" " ><?php if(isset($otherRS['other_renovation'])) echo $otherRS['other_renovation']; ?></textarea>
						<label>Other Renovation</label>
<!--
						 <div class="invalid-feedback">
							Please enter valid input for Other Renovation
						  </div>
-->
					  </span>
					<span class="form-group has-float-label">
						<textarea data-autoresize rows="1"  class="form-control" type="text" id="oallowance" name="oallowance" placeholder=" " ><?php if(isset($otherRS['allowance'])) echo $otherRS['allowance']; ?></textarea>
						<label>Allowance</label>
<!--
						<div class="invalid-feedback">
							Please enter valid input for Allowance
						  </div>
-->
					  </span>
					<span class="form-group has-float-label">
						<textarea data-autoresize rows="1"  class="form-control" type="text" id="comments" name="otcomments" placeholder=" " ><?php if(isset($otherRS['comments'])) echo $otherRS['comments']; ?></textarea>
						<label>Comments</label>
<!--
						<div class="invalid-feedback">
							Please enter valid input Comments
						  </div>
-->
					  </span>
				  <span>
				  	<input type="hidden" name="roomid" value="<?php if(isset($_GET['roomid'])) echo $_GET['roomid']; ?>" />
				  </span>
			  </div>
			</div>
		  </div>
			
		
		<br />
		<div class="text-center">
			<button class="btn btn-primary btn-lg" <?php if(isset($_GET['roomid'])){ ?> name="edit" <?php } else{ ?> name="save" <?php } ?>    >Save Room</button>
		</div>
			<br />
            </div>
            </form>
		<br />
		
	</body>
	
	
	<script>
		 <?php if(isset($success)){ ?>
			swal("Saved!", "Room is saved successfully", "success");
		<?php } ?>
		
		 <?php if(isset($fmsg)){ ?>
			swal("<?php echo $fmsg ?>");
			window.location="project.php?id="+<?php echo $projid; ?>;
		<?php } ?>
			
		function myFunction() {
			var x = document.getElementById("myTopnav");
			if (x.className === "topnav") {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
		}
		
		function delroom(roomid){
			
			swal({
				  title: "Are you sure?",
				  text: "Are you sure you want to delete this room?",
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
							
						window.location="room.php?delrid="+roomid;
						  break;
					}
				
				});
			
		}
		
		function delext(extid){
			
			swal({
				  title: "Are you sure?",
				  text: "Are you sure you want to delete this exterior?",
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
							
						window.location="room.php?extid="+extid;
						  break;
					}
				
				});
			
		}
		
			
		function editroom(roomid){
			
			window.location="room.php?roomid="+roomid;
						  
		}
		
		function editext(extid){
			
			window.location="exterior.php?eid="+extid;
						  
		}
		
		
		$(document).ready(function() {
			$("#specify_scotia_type").hide();
			$("#specify_window_architrave").hide();
			$("#specify_skirting_type").hide();
			$("#specify_door_architrave").hide();
			$("#specify_floor_covering").hide();
			$("#specify_doors_type").hide();
			
			$("#scotia_type").on("change", function() {
				if ($(this).val() === "Specify") {
					$("#specify_scotia_type").show();
				}
				else {
					$("#specify_scotia_type").hide();
				}
			});
			
			$("#window_architrave").on("change", function() {
				if ($(this).val() === "Specify") {
					$("#specify_window_architrave").show();
				}
				else {
					$("#specify_window_architrave").hide();
				}
			});
			
			$("#skirting_type").on("change", function() {
				if ($(this).val() === "Specify") {
					$("#specify_skirting_type").show();
				}
				else {
					$("#specify_skirting_type").hide();
				}
			});
			$("#door_architrave").on("change", function() {
				if ($(this).val() === "Specify") {
					$("#specify_door_architrave").show();
				}
				else {
					$("#specify_door_architrave").hide();
				}
			});
			$("#floor_covering").on("change", function() {
				if ($(this).val() === "other") {
					$("#specify_floor_covering").show();
				}
				else {
					$("#specify_floor_covering").hide();
				}
			});
			$("#doors_type").on("change", function() {
				if ($(this).val() === "Other") {
					$("#specify_doors_type").show();
				}
				else {
					$("#specify_doors_type").hide();
				}
			});
		});
		
		jQuery.each(jQuery('textarea[data-autoresize]'), function() {
			var offset = this.offsetHeight - this.clientHeight;

			var resizeTextarea = function(el) {
				jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
			};
			jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
		});
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
	
	 <script src="Bootstrap-4-Form-Validator/js/validator.js"></script>
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>