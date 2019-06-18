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
	
	}else if(isset($_GET['eid']) && !empty($_GET['eid'])){
		
		$eid = $_GET['eid'];
		
		$SelSql = "SELECT * FROM exterior_scope WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$exRS     = mysqli_fetch_assoc($res);
		$extname = $exRS['name'];
		
		$SelSql = "SELECT * FROM roof WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$roofRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM gutter WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$gutterRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM downpile WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$pipeRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM fascia WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$fsRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM deck WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$deckRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM handrail WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$hrRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM paving WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$pvRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM driveway WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$dwRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM fencing WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$fencingRS     = mysqli_fetch_assoc($res);
		
		$SelSql = "SELECT * FROM ext_other WHERE exterior_id=$eid";
		$res   = mysqli_query($connection, $SelSql);
		$otherRS     = mysqli_fetch_assoc($res);
		
		
		$projid = $exRS['project_id'];
		
		//rooms
		$selectSql = "SELECT * FROM room WHERE project_id=$projid ";
		$roomRS     = mysqli_query($connection, $selectSql);
		
		//exterior
		$selectSql = "SELECT * FROM exterior_scope WHERE project_id=$projid ";
		$exteriorRS    = mysqli_query($connection, $selectSql);
		
		
	}else if (isset($_POST) && !empty($_POST)) {
		
		if (isset($_POST) && !empty($_POST['projid'])) {
			
			$projid = $_POST['projid'];
		
		}else if(isset($_POST['save']) || isset($_POST['edit'])){
			
			if(isset($_POST['save'])){
				$SelSql = "SELECT exterior_id FROM exterior_scope order by exterior_id DESC";
				$save   = mysqli_query($connection, $SelSql);
				$p      = mysqli_fetch_assoc($save);
				$exterior_id     = $p['exterior_id'] + 1;
			}else{
				$exterior_id     = $_POST['exterior_id'];
			}
			
			$project_id = $_POST['projectid'];
			$projid = $_POST['projectid'];
			$id = $_POST['projectid'];
			
			$name   = $_POST['name'];
			$cladding_type = $_POST['cladding_type'];
			$cladding_details = $_POST['cladding_details'];
			$exwork_required   = $_POST['exwork_required'];    

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO exterior_scope(project_id,exterior_id,name,cladding_type,cladding_details,work_required) VALUES($project_id,$exterior_id,'$name','$cladding_type','$cladding_details','$exwork_required')";
			}else{
				$insertSql = "UPDATE exterior_scope SET name='$name',cladding_type='$cladding_type',cladding_details='$cladding_details',work_required='$exwork_required' WHERE exterior_id=$exterior_id";
			}
			//echo $insertSql;
			$save = mysqli_query($connection, $insertSql);
	
			// Roof

			$pitch   = $_POST['pitch'];
			$cladding_type = $_POST['rfcladding_type'];
			$work_required   = $_POST['work_required'];    

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO roof(project_id,exterior_id,pitch,cladding_type,work_required) VALUES($project_id,$exterior_id,'$pitch','$cladding_type','$work_required')";
			}else{
				$insertSql = "UPDATE roof SET pitch='$pitch',cladding_type='$cladding_type',work_required='$work_required' WHERE exterior_id=$exterior_id";
			}
//			echo $insertSql;
			$save = mysqli_query($connection, $insertSql);
			
			//Gutter

			$gutter_material   = $_POST['gutter_material'];
			$profile = $_POST['profile'];
			$comment   = $_POST['gcomment'];    

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO gutter(project_id,exterior_id,gutter_material,profile,comment) VALUES($project_id,$exterior_id,'$gutter_material','$profile','$comment')";
			}else{
				$insertSql = "UPDATE gutter SET gutter_material='$gutter_material',profile='$profile',comment='$comment' WHERE exterior_id=$exterior_id";
			}
			//echo $insertSql;
			$save = mysqli_query($connection, $insertSql);

			//Downpipe

			$dmaterial   = $_POST['dmaterial'];
			$dprofile = $_POST['dprofile'];
			$dwork_required   = $_POST['dwreq'];    

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO downpile(project_id,exterior_id,material,profile,work_required) VALUES($project_id,$exterior_id,'$dmaterial','$dprofile','$dwork_required')";
			}else{
				$insertSql = "UPDATE downpile SET material='$dmaterial', profile='$dprofile', work_required='$dwork_required' WHERE exterior_id=$exterior_id";
			}
//			echo $insertSql;
			$save = mysqli_query($connection, $insertSql);

			//Fascia
			$fascia_type   = $_POST['fasciatype'];
			$fcwork_required   = $_POST['fcwre'];    

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO fascia(project_id,exterior_id,fascia_type,work_required) VALUES($project_id,$exterior_id,'$fascia_type','$fcwork_required')";
			}else{
				$insertSql = "UPDATE fascia SET fascia_type='$fascia_type', work_required='$fcwork_required' WHERE exterior_id=$exterior_id";
			}
			//echo $insertSql;
			$save = mysqli_query($connection, $insertSql);

			//Deck
			$deck_demolation   = $_POST['deck_demolation'];
			$deck_renovation   = $_POST['deck_renovation'];   
			$decking_material   = $_POST['decking_material'];  
			$decking_size  = $_POST['decking_size'];  
			
			if($decking_size=='Other'){
				$decking_size  = $_POST['specify_decking_size'];  
			}

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO deck(project_id,exterior_id,deck_demolation,deck_renovation,decking_material,decking_size) VALUES($project_id,$exterior_id,'$deck_demolation','$deck_renovation','$decking_material','$decking_size')";
			}else{
				$insertSql = "UPDATE deck SET deck_demolation='$deck_demolation',deck_renovation='$deck_renovation',decking_material='$decking_material',decking_size='$decking_size' WHERE exterior_id=$exterior_id";
			}
			//echo $insertSql;
			$save = mysqli_query($connection, $insertSql);

			//Handrail
			$type   = $_POST['hdtype'];
			$handrail_demolation   = $_POST['handrail_demolation'];
			$handrail_renovation  = $_POST['handrail_renovation'];

			if(isset($_POST['save'])){

				$insertSql = "INSERT INTO handrail(project_id,exterior_id,type,handrail_demolation,handrail_renovation) VALUES($project_id,$exterior_id,'$type','$handrail_demolation','$handrail_renovation')";
			}else{
				$insertSql = "UPDATE handrail SET type='$type',handrail_demolation='$handrail_demolation',handrail_renovation='$handrail_renovation' WHERE exterior_id=$exterior_id";
			}
//	echo $insertSql;
			$save = mysqli_query($connection, $insertSql);

			//Paving 
			$paving_type  = $_POST['paving_type'];
			$paving_demolation   = $_POST['paving_demolation'];   
			$paving_renovation   = $_POST['paving_renovation'];   

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO paving(project_id,exterior_id,paving_type,paving_demolation,paving_renovation) VALUES($project_id,$exterior_id,'$paving_type','$paving_demolation','$paving_renovation')";
			}else{
				$insertSql = "UPDATE paving SET paving_type='$paving_type',paving_demolation='$paving_demolation',paving_renovation='$paving_renovation' WHERE exterior_id=$exterior_id";
			}
//			echo $insertSql;
			$save = mysqli_query($connection, $insertSql);

	//Driveway

			$type = $_POST['drivewaytype'];
			$driveway_demolation   = $_POST['driveway_demolation'];   
			$driveway_renovation   = $_POST['driveway_renovation'];   

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO driveway(project_id,exterior_id,type,driveway_demolation,driveway_renovation) VALUES($project_id,$exterior_id,'$type','$driveway_demolation','$driveway_renovation')";
			}else{
				$insertSql = "UPDATE driveway SET type='$type',driveway_demolation='$driveway_demolation',driveway_renovation='$driveway_renovation'  WHERE exterior_id=$exterior_id";
			}
			//echo $insertSql;
			$save = mysqli_query($connection, $insertSql);
			//Fencing

			$fencing_type = $_POST['fencing_type'];
			$fencing_demolation   = $_POST['fencing_demolation'];   
			$fencing_renovation   = $_POST['fencing_renovation'];   

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO fencing(project_id,exterior_id,fencing_type,demolation,renovation) VALUES($project_id,$exterior_id,'$fencing_type','$fencing_demolation','$fencing_renovation')";
			}else{
				$insertSql = "UPDATE fencing SET fencing_type='$fencing_type',demolation='$fencing_demolation',renovation='$fencing_renovation' WHERE exterior_id=$exterior_id";
			}
			//echo $insertSql;
			$save = mysqli_query($connection, $insertSql);
	
			//Other

			$other_demolition   = $_POST['other_demolition'];
			$other_renovation  = $_POST['other_renovation'];   
			$othercomments  = $_POST['other_comment'];  

			if(isset($_POST['save'])){
				$insertSql = "INSERT INTO ext_other(project_id,exterior_id,demolation,renovation,comment) VALUES($project_id,$exterior_id,'$other_demolition','$other_renovation','$othercomments')";
			}else{
				$insertSql = "UPDATE ext_other SET demolation='$other_demolition',renovation='$other_renovation',comment='$othercomments' WHERE exterior_id=$exterior_id";
			}
			//echo $insertSql;
			$save = mysqli_query($connection, $insertSql);
    
			$success = true;
			
			
		}
		
		//rooms
			$selectSql = "SELECT * FROM room WHERE project_id=$projid";
			$roomRS     = mysqli_query($connection, $selectSql);

			//exterior
			$selectSql = "SELECT * FROM exterior_scope WHERE project_id=$projid";
			$exteriorRS    = mysqli_query($connection, $selectSql);
		
	}
?>


<html>
	<style>

</style>
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
		
		<link href="bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">
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
			<a class="active" data-toggle="modal" href="#extoption">Exterior</a>
			<a class="" data-toggle="modal" href="#roomoption">Room</a>
			<a href="index.php?lgout=1">Logout</a>
			<a href="javascript:void(0);" class="icon" onclick="myFunction()">
			<i class="fa fa-bars"></i>
			</a>		  
		</div>
		
		<nav aria-label="breadcrumb" id="myTopnav">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="home.php">Project List</a></li>
			  <li class="breadcrumb-item"><a href="project.php?id=<?php echo $projid; ?>">Project</a></li>
			<li class="breadcrumb-item" aria-current="page">Exterior <?php if(isset($extname) && !empty($extname)) echo " - ".$extname; ?></li>
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
						<form action="room.php" method="post" >

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
		
		
		<form action="exterior.php" method="POST" name="extform" class="bootstrap-form needs-validation" novalidate>
		<div id="accordion">
		  <div class="card">
			<div class="card-header" id="headingOne">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					Exterior Details
				</button>
			  </h5>
			</div>

			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			  <div class="card-body">
					  <span class="form-group has-float-label">
						<input class="form-control" type="text" id="name" name="name" placeholder=" " value="<?php if(isset($exRS['name'])) echo $exRS['name']; ?>"/>
						<label>Name</label>
					  </span>
					  <span>
						  <input class="form-control" type="hidden" name="projectid" placeholder=" " value="<?php echo $projid; ?>"/>
					  </span>
				   <span>
						  <input class="form-control" type="hidden" name="exterior_id" placeholder=" " value="<?php if(isset($_GET['eid'])) echo $_GET['eid']; ?>"/>
					  </span>
				  
				  
				  	<span class="form-group has-float-label">
						<select class="form-control" id="cladding_type" name="cladding_type">
						  <option <?php if(isset($exRS['cladding_type']) && $exRS['cladding_type']=='Weatherboard'){ ?> selected <?php } ?>>Weatherboard</option>
						  <option <?php if(isset($exRS['cladding_type']) && $exRS['cladding_type']=='Monolithic'){ ?> selected <?php } ?>>Monolithic</option>
						  <option <?php if(isset($exRS['cladding_type']) && $exRS['cladding_type']=='Brick'){ ?> selected <?php } ?>>Brick</option>
							<option <?php if(isset($exRS['cladding_type']) && $exRS['cladding_type']=='Other'){ ?> selected <?php } ?>>Other</option>
                            
						</select>
						<label>Cladding Type</label>
					  </span>
					  <span class="form-group has-float-label">
						  <textarea data-autoresize rows="1"   class="form-control" type="text" id="cladding_details" name="cladding_details" placeholder=" " ><?php if(isset($exRS['cladding_details'])) echo $exRS['cladding_details']; ?></textarea>
						<label>Cladding Details</label>
					  </span>
					  <span class="form-group has-float-label">
						  <textarea data-autoresize rows="1"   class="form-control" type="text" id="example-text-input" placeholder=" " name="exwork_required"><?php if(isset($exRS['work_required'])) echo $exRS['work_required']; ?></textarea>
						<label>Work Required</label>
					  </span>
			  </div>
			</div>
		  </div>
		  <div class="card">
			<div class="card-header" id="headingTwo">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				Roof
				</button>
			  </h5>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
			  <div class="card-body">
				 <span class="form-group has-float-label">
					 <textarea data-autoresize rows="1"   class="form-control" type="text" id="pitch" name="pitch" placeholder=" "><?php if(isset($roofRS['pitch'])) echo $roofRS['pitch']; ?></textarea>
						<label>Pitch</label>
					  </span>
				  	<span class="form-group has-float-label">
						<select class="form-control" id="exampleSelect1" name="rfcladding_type">
						  <option <?php if(isset($roofRS['cladding_type']) && $roofRS['cladding_type']=='Longrun'){ ?> selected <?php } ?>>Longrun</option>
						  <option <?php if(isset($roofRS['cladding_type']) && $roofRS['cladding_type']=='Masonry Tile'){ ?> selected <?php } ?>>Masonry Tile</option>
						  <option <?php if(isset($roofRS['cladding_type']) && $roofRS['cladding_type']=='Metal Tile'){ ?> selected <?php } ?>>Metal Tile</option>
							<option <?php if(isset($roofRS['cladding_type']) && $roofRS['cladding_type']=='Other'){ ?> selected <?php } ?>>Other</option>
						</select>
						<label>Cladding Type</label>
					  </span>
					  <span class="form-group has-float-label">
						  <textarea data-autoresize rows="1"   class="form-control" type="text" id="example-text-input" name="work_required" placeholder=" " ><?php if(isset($roofRS['work_required'])) echo $roofRS['work_required']; ?></textarea>
						<label>Work Required</label>
					  </span>
			  </div>
			</div>
		  </div>
		  <div class="card">
			<div class="card-header" id="headingThree">
			  <h5 class="mb-0">
				<button class="btn btn-link  btn-lg collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				  Gutter
				</button>
			  </h5>
			</div>
			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
			  <div class="card-body">
						<span class="form-group has-float-label">
						<select class="form-control" id="gutter_material" name="gutter_material">
						  <option <?php if(isset($gutterRS['gutter_material']) && $gutterRS['gutter_material']=='Plastic'){ ?> selected <?php } ?>>Plastic</option>
						  <option <?php if(isset($gutterRS['gutter_material']) && $gutterRS['gutter_material']=='Steel'){ ?> selected <?php } ?>>Steel</option>
							<option <?php if(isset($gutterRS['gutter_material']) && $gutterRS['gutter_material']=='Coper'){ ?> selected <?php } ?>>Coper</option>
						</select>
						<label>Gutter Material</label>
					  </span>
				  	<span class="form-group has-float-label">
						<select class="form-control" id="profile" name="profile">
						  <option <?php if(isset($gutterRS['profile']) && $gutterRS['profile']=='Classic'){ ?> selected <?php } ?>>Classic</option>
						  <option  <?php if(isset($gutterRS['profile']) && $gutterRS['profile']=='Quad'){ ?> selected <?php } ?>>Quad</option>
						  <option  <?php if(isset($gutterRS['profile']) && $gutterRS['profile']=='Box'){ ?> selected <?php } ?>>Box</option>
							<option  <?php if(isset($gutterRS['profile']) && $gutterRS['profile']=='Other'){ ?> selected <?php } ?>>Other</option>
						</select>
						<label>Profile</label>
					  </span>
					  <span class="form-group has-float-label">
						  <textarea data-autoresize rows="1" class="form-control" type="text" id="gcomment" name="gcomment" placeholder=" " ><?php if(isset($gutterRS['comment'])) echo $gutterRS['comment']; ?></textarea>
						<label>Comment</label>
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingFour">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				  Downpipe
				</button>
			  </h5>
			</div>
			<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
			  <div class="card-body">
				<span class="form-group has-float-label">
						<select class="form-control" id="dmaterial" name="dmaterial">
						  <option <?php if(isset($pipeRS['material']) && $pipeRS['material']=='Plastic'){ ?> selected <?php } ?>>Plastic</option>
						  <option <?php if(isset($pipeRS['material']) && $pipeRS['material']=='Steel'){ ?> selected <?php } ?>>Steel</option>
						  <option <?php if(isset($pipeRS['material']) && $pipeRS['material']=='Coper'){ ?> selected <?php } ?>>Coper</option>
						</select>
						<label>Material</label>
					  </span>
				  	<span class="form-group has-float-label">
						<select class="form-control" id="dprofile" name="dprofile">
						  <option  <?php if(isset($pipeRS['profile']) && $pipeRS['profile']=='Round 80'){ ?> selected <?php } ?>>Round 80</option>
						  <option <?php if(isset($pipeRS['profile']) && $pipeRS['profile']=='Round 60'){ ?> selected <?php } ?>>Round 60</option>
						  <option <?php if(isset($pipeRS['profile']) && $pipeRS['profile']=='Rectangle'){ ?> selected <?php } ?>>Rectangle</option>
						</select>
						<label>Profile</label>
					  </span>
					  <span class="form-group has-float-label">
						  <textarea data-autoresize rows="1"   class="form-control" type="text" id="dwreq" name="dwreq" placeholder=" " ><?php if(isset($pipeRS['work_required'])) echo $pipeRS['work_required']; ?></textarea>
						<label>Work Required</label>
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingFive">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				 Fascia
				</button>
			  </h5>
			</div>
			<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
			  <div class="card-body">
					<span class="form-group has-float-label">
						<select class="form-control" id="fasciatype" name="fasciatype">
						  <option <?php if(isset($fsRS['fascia_type']) && $fsRS['fascia_type']=='Pine 150x25'){ ?> selected <?php } ?>>Pine 150x25</option>
						  <option <?php if(isset($fsRS['fascia_type']) && $fsRS['fascia_type']=='Pine 200x25'){ ?> selected <?php } ?>>Pine 200x25</option>
						  <option <?php if(isset($fsRS['fascia_type']) && $fsRS['fascia_type']=='Cedar 150x25'){ ?> selected <?php } ?>>Cedar 150x25</option>
						  <option <?php if(isset($fsRS['fascia_type']) && $fsRS['fascia_type']=='Cedar 200x25'){ ?> selected <?php } ?>>Cedar 200x25</option>
						  <option <?php if(isset($fsRS['fascia_type']) && $fsRS['fascia_type']=='Metal 136'){ ?> selected <?php } ?>>Metal 136</option>
						  <option <?php if(isset($fsRS['fascia_type']) && $fsRS['fascia_type']=='Metal 150'){ ?> selected <?php } ?>>Metal 150</option>
						  <option <?php if(isset($fsRS['fascia_type']) && $fsRS['fascia_type']=='Metal 180'){ ?> selected <?php } ?>>Metal 180</option>
						</select>
						<label>Fascia Type</label>
					  </span>
					  <span class="form-group has-float-label">
						  <textarea data-autoresize rows="1"   class="form-control" type="text" id="fcwre" name="fcwre" placeholder=" " ><?php if(isset($fsRS['work_required'])) echo $fsRS['work_required']; ?></textarea>
						<label>Work Required</label>
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingSix">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
				  Deck
				</button>
			  </h5>
			</div>
			<div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
			  <div class="card-body">
				<span class="form-group has-float-label">
					<textarea data-autoresize rows="1"   class="form-control" type="text" id="deck_demolation" name="deck_demolation" placeholder=" " ><?php if(isset($deckRS['deck_demolation'])) echo $deckRS['deck_demolation']; ?></textarea>
						<label>Deck Demolition</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="deck_renovation" name="deck_renovation"  placeholder=" "><?php if(isset($deckRS['deck_renovation'])) echo $deckRS['deck_renovation']; ?></textarea>
						<label>Deck Renovation</label>
					  </span>
				  <span class="form-group has-float-label">
						<select class="form-control" id="decking_material" name="decking_material">
						  <option <?php if(isset($deckRS['decking_material']) && $deckRS['decking_material']=='Pine 150x25'){ ?> selected <?php } ?>>Pine 150x25</option>
						  <option <?php if(isset($deckRS['decking_material']) && $deckRS['decking_material']=='Pine 200x25'){ ?> selected <?php } ?>>Pine 200x25</option>
						  <option <?php if(isset($deckRS['decking_material']) && $deckRS['decking_material']=='Cedar 150x25'){ ?> selected <?php } ?>>Cedar 150x25</option>
						  <option <?php if(isset($deckRS['decking_material']) && $deckRS['decking_material']=='Cedar 200x25'){ ?> selected <?php } ?>>Cedar 200x25</option>
						  <option <?php if(isset($deckRS['decking_material']) && $deckRS['decking_material']=='Metal 136'){ ?> selected <?php } ?>>Metal 136</option>
						  <option <?php if(isset($deckRS['decking_material']) && $deckRS['decking_material']=='Metal 150'){ ?> selected <?php } ?>>Metal 150</option>
						  <option <?php if(isset($deckRS['decking_material']) && $deckRS['decking_material']=='Metal 180'){ ?> selected <?php } ?>>Metal 180</option>
						</select>
						<label>Decking Material</label>
					  </span>
				  <span class="form-group has-float-label">
						<select class="form-control" id="decking_size" name="decking_size">
						  <option <?php if(isset($deckRS['decking_size']) && $deckRS['decking_size']=='100x40'){ ?> selected <?php } ?>>100x40</option>
						  <option <?php if(isset($deckRS['decking_size']) && $deckRS['decking_size']=='150x40'){ ?> selected <?php } ?>>150x40</option>
						  <option <?php if(isset($deckRS['decking_size']) && $deckRS['decking_size']=='Other'){ ?> selected <?php } ?>>Other</option>
						</select>
						<label>Decking Size</label>
					  </span>
				  <span class="form-group has-float-label"  id="specify_decking_size">
						  <input class="form-control" type="text" name="specify_decking_size" placeholder=" " value="<?php if(isset($deckRS['decking_size']))  echo $deckRS['decking_size']; ?>"/>
						<label>Other Decking Size</label>
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingSeven">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
				 Handrail
				</button>
			  </h5>
			</div>
			<div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
			  <div class="card-body">
				<span class="form-group has-float-label">
						<select class="form-control" id="hdtype" name="hdtype"> 
						  <option <?php if(isset($hrRS['type']) && $hrRS['type']=='Timber'){ ?> selected <?php } ?>>Timber</option>
						  <option <?php if(isset($hrRS['type']) && $hrRS['type']=='Glass'){ ?> selected <?php } ?>>Glass</option>
						  <option <?php if(isset($hrRS['type']) && $hrRS['type']=='Other'){ ?> selected <?php } ?>>Other</option>
						</select>
						<label>Type</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="example-text-input" placeholder=" " name="handrail_demolation" ><?php if(isset($hrRS['handrail_demolation'])) echo $hrRS['handrail_demolation']; ?></textarea>
						<label>Handrail Demolition</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="example-text-input" placeholder=" " name="handrail_renovation"><?php if(isset($hrRS['handrail_renovation'])) echo $hrRS['handrail_renovation']; ?></textarea>
						<label>Handrail Renovation</label>
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingEight">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
				 Paving
				</button>
			  </h5>
			</div>
			<div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
			  <div class="card-body">
				<span class="form-group has-float-label">
						<select class="form-control" id="paving_type" name="paving_type">
						  <option <?php if(isset($pvRS['paving_type']) && $pvRS['paving_type']=='Concrete'){ ?> selected <?php } ?>>Concrete</option>
						  <option <?php if(isset($pvRS['paving_type']) && $pvRS['paving_type']=='Cobbles'){ ?> selected <?php } ?>>Cobbles</option>
						</select>
						<label>Paving Type</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="paving_demolation" name="paving_demolation" placeholder=" " ><?php if(isset($pvRS['paving_demolation'])) echo $pvRS['paving_demolation']; ?></textarea>
						<label>Paving Demolition</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="paving_renovation" name="paving_renovation" placeholder=" "><?php if(isset($pvRS['paving_renovation'])) echo $pvRS['paving_renovation']; ?></textarea>
						<label>Paving Renovation</label>
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingNine">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
				 Driveway
				</button>
			  </h5>
			</div>
			<div id="collapseNine" class="collapse" aria-labelledby="collapseNine" data-parent="#accordion">
			  <div class="card-body">
				<span class="form-group has-float-label">
						<select class="form-control" id="drivewaytype" name="drivewaytype">
						  <option <?php if(isset($dwRS['type']) && $dwRS['type']=='Concrete'){ ?> selected <?php } ?>>Concrete</option>
						  <option <?php if(isset($dwRS['type']) && $dwRS['type']=='Cobbles'){ ?> selected <?php } ?>>Cobbles</option>
						</select>
						<label>Type</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="driveway_demolation" name="driveway_demolation" placeholder=" "><?php if(isset($dwRS['driveway_demolation'])) echo $dwRS['driveway_demolation']; ?></textarea>
						<label>Driveway Demolition</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="driveway_renovation"  name="driveway_renovation" placeholder=" "><?php if(isset($dwRS['driveway_renovation'])) echo $dwRS['driveway_renovation']; ?></textarea>
						<label>Driveway Renovation</label>
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingTen">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
				 Fencing
				</button>
			  </h5>
			</div>
			<div id="collapseTen" class="collapse" aria-labelledby="collapseTen" data-parent="#accordion">
			  <div class="card-body">
				<span class="form-group has-float-label">
						<select class="form-control" id="fencing_type" name="fencing_type">
						  <option <?php if(isset($fencingRS['fencing_type']) && $fencingRS['fencing_type']=='Timber Pailing'){ ?> selected <?php } ?>>Timber Pailing</option>
						  <option <?php if(isset($fencingRS['fencing_type']) && $fencingRS['fencing_type']=='Other'){ ?> selected <?php } ?>>Other</option>
						</select>
						<label>Fencing Type</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="fencing_demolation" name="fencing_demolation" placeholder=" " ><?php if(isset($fencingRS['demolation'])) echo $fencingRS['demolation']; ?></textarea>
						<label>Fencing Demolition</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="fencing_renovation" name="fencing_renovation" placeholder=" "><?php if(isset($fencingRS['renovation'])) echo $fencingRS['renovation']; ?></textarea>
						<label>Fencing Renovation</label>
					  </span>
			  </div>
			</div>
		  </div>
			
			
			<div class="card">
			<div class="card-header" id="headingEleven">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
				  Other
				</button>
			  </h5>
			</div>
			<div id="collapseEleven" class="collapse" aria-labelledby="collapseEleven" data-parent="#accordion">
			  <div class="card-body">
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="other_demolition" name="other_demolition" placeholder=" " ><?php if(isset($otherRS['demolation'])) echo $otherRS['demolation']; ?></textarea>
						<label>Demolition</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"   class="form-control" type="text" id="other_renovation" name="other_renovation" placeholder=" "><?php if(isset($otherRS['renovation'])) echo $otherRS['renovation']; ?></textarea>
						<label>Renovation</label>
					  </span>
				  <span class="form-group has-float-label">
					  <textarea data-autoresize rows="1"  class="form-control" type="text" id="other_comment" name="other_comment" placeholder=" "><?php if(isset($otherRS['comment'])) echo $otherRS['comment']; ?></textarea>
						<label>Comment</label>
					  </span>
			  </div>
			</div>
		  </div>
		<br />
		<div class="text-center">
			<button class="btn btn-primary btn-lg" <?php if(isset($_GET['eid'])){ ?> name="edit" <?php } else{ ?> name="save" <?php } ?>   >Save Exterior</button>
		</div>
		<br />
		</div>
        </form>
		<br />
	</body>	
	
	<script>
	 <?php if(isset($success)){ ?>
			swal("Saved!", "Exterior is saved successfully", "success");
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
							
						window.location="exterior.php?extid="+extid;
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
			$("#specify_decking_size").hide();
			
			$("#decking_size").on("change", function() {
				
				if ($(this).val() === "Other") {
					$("#specify_decking_size").show();
				}
				else {
					$("#specify_decking_size").hide();
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