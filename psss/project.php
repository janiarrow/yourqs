<?php

	session_start();

	if (!isset($_SESSION['username'])) {
		header("Location: error.php");
	}

	require_once('connect.php');


	if(isset($_GET['roomid']) && !empty($_GET['roomid'])){
		
		$roomid = $_GET['roomid'];
		
		$selectSql = "SELECT * FROM room WHERE room_id=$roomid";
		$res       = mysqli_query($connection, $selectSql);
		$rmRS      = mysqli_fetch_assoc($res);
		$projid = $rmRS['project_id'];
		
		$delSql = "DELETE FROM room WHERE room_id=$roomid";
		
		$res = mysqli_query($connection, $delSql);

		if ($res) {
			$fmsg = "Room deleted successfully";
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
			$fmsg = "Exterior deleted successfully";
		} else {
			$fmsg = "Failed to delete the Exterior";
		}
		
	}else if(isset($_GET['id']) && !empty($_GET['id'])){
		
		//retrieve all project details
		
		$id = $_GET['id'];
		$projid = $_GET['id'];
		
//		Project details
		$selectSql = "SELECT * FROM project WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$projRS      = mysqli_fetch_assoc($res);
		$projname = $projRS['project_name'];
		
//		Address
		$selectSql = "SELECT * FROM project_address WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$addressRS      = mysqli_fetch_assoc($res);
		
//		site_arrangement
		$selectSql = "SELECT * FROM site_arrangement WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$siteArrRS      = mysqli_fetch_assoc($res);
		
//		safety_requirements
		$selectSql = "SELECT * FROM safety_requirements WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$safetyreqRS      = mysqli_fetch_assoc($res);
		
//		people_and_pricing
		$selectSql = "SELECT * FROM people_and_pricing WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$ppRS      = mysqli_fetch_assoc($res);
		
//		mark_ups
		$selectSql = "SELECT * FROM `mark-ups` WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$markupRS      = mysqli_fetch_assoc($res);
		
//		allowances_and_insurance
		$selectSql = "SELECT * FROM allowances_and_insurance WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$allowancesInsRS      = mysqli_fetch_assoc($res);
		
//		Professional Service Allowances
		$selectSql = "SELECT * FROM `professional_service_allowances` WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$proservRS      = mysqli_fetch_assoc($res);
		
//		allowance_quality_specification
		$selectSql = "SELECT * FROM allowance_quality_specification WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$allowQualityspecRS      = mysqli_fetch_assoc($res);
		
//		Services
		$selectSql = "SELECT * FROM services WHERE project_id=$id ";
		$res    = mysqli_query($connection, $selectSql);
		$servicesRS      = mysqli_fetch_assoc($res);
		
		
//		rooms
		$selectSql = "SELECT * FROM room WHERE project_id=$id ";
		$roomRS     = mysqli_query($connection, $selectSql);
		
		
//		exterior
		$selectSql = "SELECT * FROM exterior_scope WHERE project_id=$id ";
		$exteriorRS    = mysqli_query($connection, $selectSql);
		
		
	}else if (isset($_POST) && !empty($_POST)) {

		if (isset($_POST) && !empty($_POST['projname'])) {
		
			$projname = $_POST['projname'];
			
		
		}else if(isset($_POST['save']) || isset($_POST['edit'])){
			
			//Add New Project
//			echo 'inserting or updating project data';
			$uid = $_SESSION['userid'];
			
			$projectname = $_POST['projectname'];
			$projname = $_POST['projectname'];
			
			if(empty($_POST['sitesign']) | empty($_POST['ppe']) | empty($_POST['hns']) | empty($_POST['firstaid']) | 			empty($_POST['siltfence']) | empty($_POST['security'])  | empty($_POST['scaffolding']) | empty($_POST['fallin']) ){
				
				$errvalidate = "Please input safety requirements details";
				
			}else if(empty($_POST['plans']) | empty($_POST['engineer']) | empty($_POST['estimating']) | empty($_POST['geotechnical']) | 			empty($_POST['surveyor']) | empty($_POST['council']) ){
				
				$errvalidate = "Please input professional service allowances required";
				
			}else{
				

				if(isset($_POST['save'])){
					$SelSql = "SELECT project_id FROM project order by project_id DESC";
					$save   = mysqli_query($connection, $SelSql);
					$p      = mysqli_fetch_assoc($save);
					$id     = $p['project_id'] + 1;
				}else{
					$id     = $_POST['projid'];
				}

				if(isset($_POST['save'])){

					$insertSql = "INSERT INTO project(project_id,project_name,user_id,date,status,last_updated) VALUES($id,'$projectname',$uid,current_date(),'pending',current_date()) ; ";

				}else{
					$insertSql = "UPDATE project SET last_updated = current_date() WHERE project_id=$id AND user_id=$uid; ";
				}

				$save = mysqli_query($connection, $insertSql);

				if(!$save){
					echo 'Error project!'.$insertSql;//<script type="text/javascript"> sqlerror(); </script>
					return;
				}

	//		Address

				$city   = $_POST['city'];
				$street = $_POST['street'];
				$suburb = $_POST['suburb'];


				if(isset($_POST['save'])){
					$insertSql = "INSERT INTO project_address(project_id,city,street,suburb) VALUES($id,'$city','$street','$suburb')";
				}else{
					$insertSql = "UPDATE project_address SET city='$city',street='$street',suburb='$suburb' WHERE project_id=$id";
				}

				$save = mysqli_query($connection, $insertSql);
				if(!$save){
					echo 'error address'.$insertSql;//<script type="text/javascript">','sqlerror();', '</script>
					return;
				}

				//		Site Arrangement
				$site_access = $_POST['site_access'];
				$space       = $_POST['space'];
				$living      = $_POST['living'];
				$comment     = $_POST['comment'];

			

				if(isset($_POST['save'])){
					$insertSql = "INSERT INTO site_arrangement(project_id,site_access,space_for_material_storage,living_arragements,comment) 
					   VALUES($id,'$site_access','$space','$living','$comment')";
				}else{
					$insertSql = "UPDATE site_arrangement SET site_access='$site_access',space_for_material_storage='$space',living_arragements='$living',comment='$comment' WHERE  project_id=$id)";
				}

				$save = mysqli_query($connection, $insertSql);

	//		Safety Requirements



				$sitesign    = $_POST['sitesign'];
				$ppe         = $_POST['ppe'];
				$hns         = $_POST['hns'];
				$firstaid    = $_POST['firstaid'];
				$siltfence   = $_POST['siltfence'];
				$security    = $_POST['security'];
				$sacffolding = $_POST['scaffolding'];
				$fallin      = $_POST['fallin'];
				$comment     = $_POST['sfcomment'];



			   if(isset($_POST['save'])){
					$insertSql = "INSERT INTO safety_requirements(project_id,site_sign,ppe_allowance,`h_&_s_system`,first_aid_kit,silt_fence,security_fencing,scaffolding,fall_in_protection,comment) 
				   VALUES($id,'$sitesign','$ppe','$hns','$firstaid','$siltfence','$security','$sacffolding','$fallin','$comment')";
			   }else{
				   $insertSql = "UPDATE safety_requirements SET site_sign='$sitesign',ppe_allowance='$ppe',`h_&_s_system`='$hns',first_aid_kit='$firstaid',silt_fence='$siltfence',security_fencing='$security',scaffolding='$sacffolding',fall_in_protection='$fallin',comment='$comment' WHERE project_id =$id";
			   }

				$save = mysqli_query($connection, $insertSql);

	//People and Pricing

				$builder       = $_POST['builder'];
				$bhour         = $_POST['bhour'];
				$supervision   = $_POST['supervision'];
				$shour         = $_POST['shour'];
				$adminisration = $_POST['adminisration'];
				$ahour         = $_POST['ahour'];
				$travel        = $_POST['travel'];
				$trate         = $_POST['trate'];
				$toilet        = $_POST['toilet'];
				$recovery      = $_POST['recovery'];


				if(isset($_POST['save'])){
					$insertSql = "INSERT INTO people_and_pricing(project_id,no_builders,builder_hourly_rate,supervision,supervision_hourly_rate,adminisration,administration_hourly_rate,travel_distance,travel_km_rate,portable_toilet_hire,plant_maint_recovery) VALUES($id, '$builder','$bhour','$supervision','$shour', '$adminisration','$ahour','$travel','$trate','$toilet','$recovery')";
				}else{
					$insertSql = "UPDATE people_and_pricing SET no_builders='$builder',builder_hourly_rate='$bhour',supervision='$supervision',supervision_hourly_rate='$shour', adminisration='$adminisration',administration_hourly_rate='$ahour',travel_distance='$travel',travel_km_rate='$trate',portable_toilet_hire='$toilet',plant_maint_recovery='$recovery' WHERE project_id=$id";
				}

				$save = mysqli_query($connection, $insertSql);

	//Markup
				$labour      = $_POST['labour'];
				$materials      = $_POST['materials'];
				$subcontractors = $_POST['subcontractors'];
				$comment        = $_POST['markupcomment'];

			   if(isset($_POST['save'])){
					$insertSql = "INSERT INTO `mark-ups`(project_id,labour,materials,subcontractors,comment) 
					   VALUES($id,'$labour','$materials','$subcontractors','$comment')";
			   }else{
					   $insertSql = "UPDATE `mark-ups` SET materials='$materials',subcontractors='$subcontractors',comment='$comment',labour='$labour' WHERE project_id=$id)";
			   }

				$save = mysqli_query($connection, $insertSql);

	//		Allowances and Insurance

				$pduration = $_POST['pduration'];
				$insurance = $_POST['insuarance'];
				$guarantee = $_POST['guarantee'];
				$pvalue    = $_POST['pvalue'];
				$acost     = $_POST['acost'];

				 if(isset($_POST['save'])){
					$insertSql = "INSERT INTO allowances_and_insurance(project_id,estimated_project_duration,all_risk_insurance,building_guarantee,approx_project_value,administration_costs) VALUES($id, '$pduration', '$insurance','$guarantee','$pvalue','$acost')";
				 }else{
					 $insertSql = "UPDATE allowances_and_insurance SET estimated_project_duration='$pduration', all_risk_insurance='$insurance',building_guarantee='$guarantee',approx_project_value='$pvalue',administration_costs='$acost' WHERE project_id=$id";
				 }

				$save = mysqli_query($connection, $insertSql);


		//		Professional Service Allowance

				$plans        = $_POST['plans'];
				$engineer     = $_POST['engineer'];
				$estimating   = $_POST['estimating'];
				$geotechnical = $_POST['geotechnical'];
				$surveyor 	  = $_POST['surveyor'];
				$council      = $_POST['council'];

				if(isset($_POST['save'])){
					$insertSql = "INSERT INTO professional_service_allowances(project_id,plans,engineer,estimating,geotechnical,surveyor,council_fees) 
					   VALUES($id,'$plans','$engineer','$estimating','$geotechnical','$surveyor','$council')";
				}else{
					$insertSql = "UPDATE professional_service_allowances SET plans='$plans',engineer='$engineer',estimating='$estimating',geotechnical='$geotechnical',surveyor='$surveyor',council_fees= '$council' WHERE project_id =$id";
				}

				$save = mysqli_query($connection, $insertSql);


		//		Allowances Quality Specification


				$plumbing   = $_POST['plumbing'];
				$electrical = $_POST['electrical'];
				$pinterior  = $_POST['pinterior'];
				$interiord  = $_POST['interiord'];
				$door       = $_POST['door'];
				$exterior   = $_POST['exterior'];

				if(isset($_POST['save'])){
					$insertSql = "INSERT INTO allowance_quality_specification(project_id,plumbing,electrical,painting_interior,interior_doors,`door_h/w`,painting_exterior) 
					   VALUES($id,'$plumbing','$electrical','$pinterior','$interiord','$door','$exterior')";
				}else{
					$insertSql = "UPDATE allowance_quality_specification SET plumbing='$plumbing',electrical='$electrical',painting_interior=,'$pinterior',interior_doors=,'$interiord',`door_h/w`=,'$door',painting_exterior='$exterior  WHERE project_id=$id";
				}

				$save = mysqli_query($connection, $insertSql);

				$water      = $_POST['water'];
				$electrical = $_POST['electrical'];
				$sewerage   = $_POST['sewerage'];
				$storm      = $_POST['storm'];
				$tpower     = $_POST['tpower'];
				$twater     = $_POST['twater'];

		//		Services

			   if(isset($_POST['save'])){
				$insertSql = "INSERT INTO services(project_id,water,electrical,sewerage,storm_water,temporary_power,temporary_water) 
				   VALUES($id,'$water','$electrical','$sewerage','$storm','$tpower','$twater')";
			   }else{
				   $insertSql = "UPDATE services SET water='$water',electrical='$electrical',sewerage='$sewerage',storm_water='$storm',temporary_power='$tpower',temporary_water='$twater' WHERE project_id=$id";
			   }

	//			echo $insertSql;
				$save = mysqli_query($connection, $insertSql);
				$success = true;
				
				

		//		Project details
				$selectSql = "SELECT * FROM project WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$projRS      = mysqli_fetch_assoc($res);
				$projname = $projRS['project_name'];

		//		Address
				$selectSql = "SELECT * FROM project_address WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$addressRS      = mysqli_fetch_assoc($res);

		//		site_arrangement
				$selectSql = "SELECT * FROM site_arrangement WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$siteArrRS      = mysqli_fetch_assoc($res);

		//		safety_requirements
				$selectSql = "SELECT * FROM safety_requirements WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$safetyreqRS      = mysqli_fetch_assoc($res);

		//		people_and_pricing
				$selectSql = "SELECT * FROM people_and_pricing WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$ppRS      = mysqli_fetch_assoc($res);

		//		mark_ups
				$selectSql = "SELECT * FROM `mark-ups` WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$markupRS      = mysqli_fetch_assoc($res);

		//		allowances_and_insurance
				$selectSql = "SELECT * FROM allowances_and_insurance WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$allowancesInsRS      = mysqli_fetch_assoc($res);

		//		Professional Service Allowances
				$selectSql = "SELECT * FROM `professional_service_allowances` WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$proservRS      = mysqli_fetch_assoc($res);

		//		allowance_quality_specification
				$selectSql = "SELECT * FROM allowance_quality_specification WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$allowQualityspecRS      = mysqli_fetch_assoc($res);

		//		Services
				$selectSql = "SELECT * FROM services WHERE project_id=$id ";
				$res    = mysqli_query($connection, $selectSql);
				$servicesRS      = mysqli_fetch_assoc($res);


		//		rooms
				$selectSql = "SELECT * FROM room WHERE project_id=$id ";
				$roomRS     = mysqli_query($connection, $selectSql);


		//		exterior
				$selectSql = "SELECT * FROM exterior_scope WHERE project_id=$id ";
				$exteriorRS    = mysqli_query($connection, $selectSql);

				}
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
		
		<link href="bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">
		<script src="bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<title>YourQS</title>		
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
		<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
		<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
		<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
		<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
		<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
		<link rel="stylesheet" type="text/css" href="css/util.css">
		<link rel="stylesheet" type="text/css" href="css/form.css">
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
	<body>
		
			
		<div class="topnav responsive" id="myTopnav">
			 <div class="active dropdown">
				<button class=" dropbtn">Project 
				  <i class="fa fa-caret-down"></i>
				</button>
				<div class="dropdown-content">
				  <a data-toggle="modal" href="#roomoption">Room</a>
				<a data-toggle="modal" href="#extoption">Exterior</a>
				</div>
			  </div>
			
			<a href="index.php?lgout=1">Logout</a>
				
			<a href="javascript:void(0);" class="icon" onclick="myFunction()">
			<i class="fa fa-bars"></i>
			</a>		  
		</div>
		<nav aria-label="breadcrumb" id="myTopnav">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="home.php">Project List</a></li>
			<li class="breadcrumb-item" aria-current="page">Project - <?php echo $projname; ?></li>
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
								<input type="hidden" name="projid" value="<?php echo $id; ?>"/>
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
							<input type="hidden" name="projid" value="<?php echo $id; ?>"/>
								<button class="btn btn-primary btn-block">New Exterior</button>
							</form>
					</div>
				  </div>
				</div>
			  </div>
		
		
		<form action="project.php" method="POST" name="proform" class="bootstrap-form needs-validation" novalidate>
		<div id="accordion">
            
		  <div class="card">
			<div class="card-header" id="headingOne">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					Address
				</button>
			  </h5>
			</div>
			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
			  <div class="card-body">
				  <form>
				  	<span class="form-group has-float-label">
						<input class="form-control" type="text" name="street" placeholder=" " value="<?php if(isset($addressRS['street'])) echo $addressRS['street']; ?>" required/>
						<label>Street</label>
						 <div class="invalid-feedback">
							Please enter valid steet name
						  </div>
					  </span>             
					  <span>
						  <input class="form-control" type="hidden" name="projectname" placeholder=" " value="<?php echo $projname; ?>"/>
					  </span>
					   <span>
						  <input class="form-control" type="hidden" name="projid" placeholder=" " value="<?php if(isset($projid)) echo $projid; ?>"/>
					  </span>
					  <span class="form-group has-float-label">
						<input class="form-control" type="text"  name="suburb" placeholder=" " value="<?php if(isset($addressRS['suburb'])) echo $addressRS['suburb']; ?>" required/>
						<label>Suburb</label>
						  <div class="invalid-feedback">
							Please enter valid suburb name
						  </div>
					  </span>
					  <span class="form-group has-float-label">
						<input class="form-control" type="text"  name="city" placeholder=" " value="<?php if(isset($addressRS['city'])) echo $addressRS['city']; ?>" required/>
						<label>City</label>
						  <div class="invalid-feedback">
							Please enter valid city name
						  </div>
					  </span>
				  </form>
			  </div>
			</div>
		  </div>
		  <div class="card">
			<div class="card-header" id="headingTwo">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed"  type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				 Site Arrangement
				</button>
			  </h5>
			</div>
			<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
			  <div class="card-body">
			 
				 <span class="form-group has-float-label">
						 <select class="form-control" id="site_access" name="site_access">
							  <option <?php if(isset($siteArrRS['site_access']) && $siteArrRS['site_access']=='Good'){ ?> selected <?php } ?>>Good</option>
							  <option <?php if(isset($siteArrRS['site_access']) && $siteArrRS['site_access']=='Bad'){ ?> selected <?php } ?>>Bad</option>
							  <option <?php if(isset($siteArrRS['site_access']) && $siteArrRS['site_access']=='Very Bad'){ ?> selected <?php } ?>>Very Bad</option>
						</select>
						<label>Site Access</label>
					  </span>
				 <span class="form-group has-float-label">
						<select class="form-control" name="space">
						 <option <?php if(isset($siteArrRS['space_for_material_storage']) && $siteArrRS['space_for_material_storage']=='None'){ ?> selected <?php } ?>>None</option>
						  <option <?php if(isset($siteArrRS['space_for_material_storage']) && $siteArrRS['space_for_material_storage']=='Good'){ ?> selected <?php } ?>>Good</option>
						  <option <?php if(isset($siteArrRS['space_for_material_storage']) && $siteArrRS['space_for_material_storage']=='Bad'){ ?> selected <?php } ?>>Bad</option>
						</select>
						<label>Space for material storage</label>
					  </span>
				 <span class="form-group has-float-label">
						<select class="form-control"  id="living" name="living">
						 <option <?php if(isset($siteArrRS['living_arragements']) && $siteArrRS['living_arragements']=='Vacated'){ ?> selected <?php } ?>>Vacated </option>
							<option <?php if(isset($siteArrRS['living_arragements']) && $siteArrRS['living_arragements']=='Nights at home') { ?> selected <?php } ?>>Nights at home </option>
						  <option <?php if(isset($siteArrRS['living_arragements']) && $siteArrRS['living_arragements']=='Nights and days at home'){ ?> selected <?php } ?> >Nights and days at home</option>
						</select>
						<label>Living Arrangements</label>
					  </span>
				 <span class="form-group has-float-label">
					
					<textarea data-autoresize class="form-control" rows="1" id="comment" name="comment" placeholder=" " ><?php if(isset($siteArrRS['comment'])) echo $siteArrRS['comment']; ?></textarea>
					  <label>Comment</label>
					 <div class="invalid-feedback">
							Please enter your comment
						  </div>
					  </span>
				  
			  </div>
			</div>
		  </div>
		  <div class="card">
			<div class="card-header" id="headingThree">
			  <h5 class="mb-0">
				<button class="btn btn-link  btn-lg collapsed"  type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				  Safety Requirements
				</button>
			  </h5>
			</div>
			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
			  <div class="card-body">
					 <div class="radio">
						<label class="col-5">Site Sign</label>
<!--				 <input type="checkbox" data-toggle="toggle" unchecked data-on="Yes" data-off="No" data-width="100">		-->
					 	<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input  type="radio" name="sitesign" id="sitesign" value="Yes"  <?php if(isset($safetyreqRS['site_sign']) && $safetyreqRS['site_sign']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input type="radio" name="sitesign" id="sitesign" value="No" <?php if(isset($safetyreqRS['site_sign']) && $safetyreqRS['site_sign']=='No'){ ?> checked <?php } ?> >
								 No  
							</label>
						  </div>
						 <div class="invalid-feedback">
							You must select an option
						  </div>
						 </div>
				  
					 <br />
					 <label class="col-5">PPE Allowance</label>
						<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="ppe" id="ppe" value="Yes" <?php if(isset($safetyreqRS['ppe_allowance']) && $safetyreqRS['ppe_allowance']=='Yes'){ ?> checked <?php } ?>checked >
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="ppe" id="ppe" value="No" <?php if(isset($safetyreqRS['ppe_allowance']) && $safetyreqRS['ppe_allowance']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
				  <div class="invalid-feedback">
							You must select an option
						  </div>
					 <br />
					 <label class="col-5">H & S System</label>
						<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="hns" id="exampleRadios5" value="Yes" <?php if(isset($safetyreqRS['h_&_s_system']) && $safetyreqRS['h_&_s_system']=='Yes'){ ?> checked <?php } ?>>checked
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="hns" id="exampleRadios6" value="No" <?php if(isset($safetyreqRS['h_&_s_system']) && $safetyreqRS['h_&_s_system']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
					 <br />
					 <label class="col-5">First Aid Kit</label>
						<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="firstaid" id="exampleRadios7" value="Yes" <?php if(isset($safetyreqRS['first_aid_kit']) && $safetyreqRS['first_aid_kit']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="firstaid" id="exampleRadios8" value="No" <?php if(isset($safetyreqRS['first_aid_kit']) && $safetyreqRS['first_aid_kit']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
					 <br />
					 <label class="col-5">Silt Fence</label>
						<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="siltfence" id="exampleRadios9" value="Yes" <?php if(isset($safetyreqRS['silt_fence']) && $safetyreqRS['silt_fence']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="siltfence" id="exampleRadios10" value="No" <?php if(isset($safetyreqRS['silt_fence']) && $safetyreqRS['silt_fence']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
					 
					  <span class="form-group has-float-label">
						<select class="form-control" id="exampleSelect1" name="security">
						  <option <?php if(isset($safetyreqRS['security_fencing']) && $safetyreqRS['security_fencing']=='None'){ ?> selected <?php } ?>>None</option>
						  <option <?php if(isset($safetyreqRS['security_fencing']) && $safetyreqRS['security_fencing']=='Front'){ ?> selected <?php } ?>>Front</option>
						  <option <?php if(isset($safetyreqRS['security_fencing']) && $safetyreqRS['security_fencing']=='Side 1'){ ?> selected <?php } ?>>Side 1</option>
						  <option <?php if(isset($safetyreqRS['security_fencing']) && $safetyreqRS['security_fencing']=='Side 2'){ ?> selected <?php } ?>>Side 2</option>
						  <option <?php if(isset($safetyreqRS['security_fencing']) && $safetyreqRS['security_fencing']=='Back'){ ?> selected <?php } ?>>Back</option>
						</select>
						<label>Security Fencing</label>
					  </span>
					  <span class="form-group has-float-label">
						<select class="form-control" id="exampleSelect2" name="scaffolding">
						  <option <?php if(isset($safetyreqRS['scaffolding']) && $safetyreqRS['scaffolding']=='None'){ ?> selected <?php } ?>>None</option>
						  <option <?php if(isset($safetyreqRS['scaffolding']) && $safetyreqRS['scaffolding']=='Front'){ ?> selected <?php } ?>>Front</option>
						  <option <?php if(isset($safetyreqRS['scaffolding']) && $safetyreqRS['scaffolding']=='Side 1'){ ?> selected <?php } ?>>Side 1</option>
						  <option <?php if(isset($safetyreqRS['scaffolding']) && $safetyreqRS['scaffolding']=='Side 2'){ ?> selected <?php } ?>>Side 2</option>
						  <option <?php if(isset($safetyreqRS['scaffolding']) && $safetyreqRS['scaffolding']=='Back'){ ?> selected <?php } ?>>Back</option>
						</select>
						<label>Scaffolding</label>
					  </span>
					  <span class="form-group has-float-label">
						<select class="form-control" id="exampleSelect3" name="fallin">
						  <option <?php if(isset($safetyreqRS['fall_in_protection']) && $safetyreqRS['fall_in_protection']=='None'){ ?> selected <?php } ?>>None</option>
						  <option <?php if(isset($safetyreqRS['fall_in_protection']) && $safetyreqRS['fall_in_protection']=='Safety Nets'){ ?> selected <?php } ?>>Safety Nets</option>
						  <option <?php if(isset($safetyreqRS['fall_in_protection']) && $safetyreqRS['fall_in_protection']=='Bags'){ ?> selected <?php } ?>>Bags</option>
						  <option <?php if(isset($siteArrRS['fall_in_protection']) && $safetyreqRS['fall_in_protection']=='Other'){ ?> selected <?php } ?>>Other</option>
						</select>
						<label>Fall-in Protection</label>
					  </span>
					   <span class="form-group has-float-label">
						<textarea data-autoresize class="form-control"  rows="1" name="sfcomment" placeholder=" " ><?php if(isset($safetyreqRS['comment'])) echo $safetyreqRS['comment']; ?></textarea>
						   
						<label>Comment</label>
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingFour">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed"   type="button"  data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
				  People and Pricing
				</button>
			  </h5>
			</div>
			<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
			  <div class="card-body">
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="input1" name="builder" placeholder=" " value="<?php if(isset($ppRS['no_builders'])) echo $ppRS['no_builders'];  ?>"/>
						<label>No builders</label>
						 <div class="invalid-feedback">
							Please enter valid No of builders
						  </div>
					  </span>
					
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="input2" name="bhour" placeholder=" " value="<?php if(isset($ppRS['builder_hourly_rate'])) echo $ppRS['builder_hourly_rate'];  ?>"/>
						<label>Builder hourly rate</label>
						 <div class="invalid-feedback">
							Please enter valid Builder hourly rate
						  </div>
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="number" onkeydown="javascript: return event.keyCode == 69 ? false : true" id="input3" name="supervision" placeholder=" " value="<?php if(isset($ppRS['supervision'])) echo $ppRS['supervision'];  ?>"/>
						<label>Supervision Hours Per Week</label>
						 <div class="invalid-feedback">
							Please enter valid Supervision Hours Per Week
						  </div>
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="number" onkeydown="javascript: return event.keyCode == 69 ? false : true"  id="input4" name="shour" placeholder=" " value="<?php if(isset($ppRS['supervision_hourly_rate'])) echo $ppRS['supervision_hourly_rate'];  ?>"/>
						<label>Supervision Hourly Rate</label>
						<div class="invalid-feedback">
							Please enter valid upervision Hourly Rate
						  </div>
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="input5" name="adminisration" placeholder=" " value="<?php if(isset($ppRS['adminisration'])) echo $ppRS['adminisration'];  ?>"/>
						<label>Administration Hours Per Week</label>
						<div class="invalid-feedback">
							Please enter valid Administration Hours Per Week
						  </div>
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="input6" name="ahour" placeholder=" " value="<?php if(isset($ppRS['administration_hourly_rate'])) echo $ppRS['administration_hourly_rate'];  ?>"/>
						<label>Administration Hourly Rate</label>
						<div class="invalid-feedback">
							Please enter valid Administration Hourly Rate
						  </div>
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="input7" name="travel" placeholder=" " value="<?php if(isset($ppRS['travel_distance'])) echo $ppRS['travel_distance'];  ?>"/>
						<label>Travel Distance</label>
						<div class="invalid-feedback">
							Please enter valid Travel Distance
						  </div>
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="input8" name="trate" placeholder=" " value="<?php if(isset($ppRS['travel_km_rate'])) echo $ppRS['travel_km_rate'];  ?>"/>
						<label>Travel km Rate</label>
						<div class="invalid-feedback">
							Please enter valid Travel km Rate
						  </div>
					  </span>
					
						<label class="col-5">Portable Toilet Hire</label>
						<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="toilet" id="toilet" value="Yes" <?php if(isset($ppRS['portable_toilet_hire']) && $ppRS['portable_toilet_hire']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
							
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="toilet" id="toilet" value="No" <?php if(isset($ppRS['portable_toilet_hire']) && $ppRS['portable_toilet_hire']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
					  
					<span class="form-group has-float-label">
						<input class="form-control" type="text" id="recovery" name="recovery" placeholder=" " value="<?php if(isset($ppRS['plant_maint_recovery'])) echo $ppRS['plant_maint_recovery'];  ?>"/>
						<label>Plant Maintenance Recovery</label>
						<div class="invalid-feedback">
							Please enter valid Plant Maintenance Recovery
						  </div>
				  	</span>
					
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingFive">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed"   type="button"  data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
				 Markups
				</button>
			  </h5>
			</div>
			<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
			  <div class="card-body">
				  
				  
				  <span class="form-group has-float-label">
						<input class="form-control" type="number" id="labour" name="labour" placeholder=" "  value="<?php if(isset($markupRS['labour'])) echo $markupRS['labour'];  ?>"/>
						<label>Labour</label>
					  <div class="invalid-feedback">
							Please enter valid Labour
						  </div>
					  </span>
					
						<span class="form-group has-float-label">
						<input class="form-control" type="number" id="materials" name="materials" placeholder=" "  value="<?php if(isset($markupRS['materials'])) echo $markupRS['materials'];  ?>"/>
						<label>Materials</label>
							  <div class="invalid-feedback">
							Please enter valid Materials
						  </div>
					  </span>
					
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="subcontractors" name="subcontractors" placeholder=" "  value="<?php if(isset($markupRS['subcontractors'])) echo $markupRS['subcontractors'];  ?>"/>
						<label>Subcontractors</label>
						  <div class="invalid-feedback">
							Please enter valid Subcontractors
						  </div>
					  </span>
					<span class="form-group has-float-label">
						<textarea data-autoresize class="form-control"  rows="1" id="comment" name="markupcomment" placeholder=" " ><?php if(isset($markupRS['comment'])) echo $markupRS['comment'];  ?></textarea>
						<label>Comment</label>
						
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingSix">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed"   type="button"  data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
				  Allowances and Insurance
				</button>
			  </h5>
			</div>
			<div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
			  <div class="card-body">
						<span class="form-group has-float-label">
						<input class="form-control" type="number" id="input1" name="pduration" placeholder=" " value="<?php if(isset($allowancesInsRS['estimated_project_duration'])) echo $allowancesInsRS['estimated_project_duration'];  ?>"/>
						<label>Estimated Project Duration</label>
							 <div class="invalid-feedback">
							Please enter valid Estimated Project Duration
						  </div>
					  </span>
					
						 <label class="col-5">All Risk Insurance</label>
						  <div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="insuarance" id="insuarance" value="Yes" <?php if(isset($allowancesInsRS['all_risk_insurance']) && $allowancesInsRS['all_risk_insurance']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="insuarance" id="insuarance" value="No" <?php if(isset($allowancesInsRS['all_risk_insurance']) && $allowancesInsRS['all_risk_insurance']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
				  
					<span class="form-group has-float-label">
						
						<select class="form-control" id="exampleSelect3" name="guarantee">
						  <option <?php if(isset($allowancesInsRS['building_guarantee']) && $allowancesInsRS['building_guarantee']=='None'){ ?> selected <?php } ?>>None</option>
						  <option <?php if(isset($allowancesInsRS['building_guarantee']) && $allowancesInsRS['building_guarantee']=='Basic'){ ?> selected <?php } ?>>Basic</option>
						  <option <?php if(isset($allowancesInsRS['building_guarantee']) && $allowancesInsRS['building_guarantee']=='Standard'){ ?> selected <?php } ?>>Standard</option>
						  <option <?php if(isset($allowancesInsRS['building_guarantee']) && $allowancesInsRS['building_guarantee']=='Premium'){ ?> selected <?php } ?>>Premium</option>
						</select>
						<label>Building Guarantee</label>
						
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="input4" name="pvalue" placeholder=" " value="<?php if(isset($allowancesInsRS['approx_project_value'])) echo $allowancesInsRS['approx_project_value'];  ?>"/>
						<label>Expected Project Value</label>
						 <div class="invalid-feedback">
							Please enter valid Expected Project Value
						  </div>
					  </span>
					<span class="form-group has-float-label">
						<input class="form-control" type="number" id="input5" name="acost" placeholder=" " value="<?php if(isset($allowancesInsRS['administration_costs'])) echo $allowancesInsRS['administration_costs'];  ?>"/>
						<label>Administration Costs Per Week</label>
						 <div class="invalid-feedback">
							Please enter valid Administration Costs Per Week
						  </div>
					  </span>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingSeven">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed"   type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
				  Professional Service Allowances Required
				</button>
			  </h5>
			</div>
			<div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
			  <div class="card-body">
						
				   <label class="col-5">Plans</label>
						  <div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="plans" id="plans" value="Yes" <?php if(isset($proservRS['plans']) && $proservRS['plans']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="plans" id="plans" value="No" <?php if(isset($proservRS['plans']) && $proservRS['plans']=='No'){ ?>  <?php } ?>>
								 No  
							</label>
						  </div>
				  <br />
				   <label class="col-5">Engineer</label>
						  <div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="engineer" id="engineer" value="Yes" <?php if(isset($proservRS['engineer']) && $proservRS['engineer']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
									<input class="form-check-input" type="radio" name="engineer" id="engineer" value="No" <?php if(isset($proservRS['engineer']) && $proservRS['engineer']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
				  <br />
				  <label class="col-5">Estimating</label>
						  <div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="estimating" id="estimating" value="Yes" <?php if(isset($proservRS['estimating']) && $proservRS['estimating']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
									<input class="form-check-input" type="radio" name="estimating" id="estimating" value="No" <?php if(isset($proservRS['estimating']) && $proservRS['estimating']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
					
					
					<br />
					  <label class="col-5">Geotechnical</label>
						  <div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="geotechnical" id="geotechnical" value="Yes" <?php if(isset($proservRS['geotechnical']) && $proservRS['geotechnical']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="geotechnical" id="geotechnical" value="No" <?php if(isset($proservRS['geotechnical']) && $proservRS['geotechnical']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
				  <br />
				  <label class="col-5">Surveyor</label>
						  <div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="surveyor" id="surveyor" value="Yes" <?php if(isset($proservRS['surveyor']) && $proservRS['surveyor']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="surveyor" id="surveyor" value="No" <?php if(isset($proservRS['surveyor']) && $proservRS['surveyor']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
				  <br />
				  <label class="col-5">Council Fees</label>
						  <div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="council" id="council" value="Yes" <?php if(isset($proservRS['council_fees']) && $proservRS['council_fees']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="council" id="council" value="No" <?php if(isset($proservRS['council_fees']) && $proservRS['council_fees']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
			  </div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingEight">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed"   type="button"  data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
				  Allowances Quality Specification
				</button>
			  </h5>
			</div>
			<div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
				<div class="card-body">
				<span class="form-group has-float-label">
						<select class="form-control" id="Select1" name="plumbing">
						  <option <?php if(isset($allowQualityspecRS['plumbing']) && $allowQualityspecRS['plumbing']=='Owner'){ ?> selected <?php } ?>>Owner</option>
						  <option <?php if(isset($allowQualityspecRS['plumbing']) && $allowQualityspecRS['plumbing']=='Basic'){ ?> selected <?php } ?>>Basic</option>
						  <option <?php if(isset($allowQualityspecRS['plumbing']) && $allowQualityspecRS['plumbing']=='Standard'){ ?> selected <?php } ?>>Standard</option>
						  <option <?php if(isset($allowQualityspecRS['plumbing']) && $allowQualityspecRS['plumbing']=='Premium'){ ?> selected <?php } ?>>Premium</option>
						</select>
						<label>Plumbing</label>
					  </span>
				<span class="form-group has-float-label">
						<select class="form-control" id="Select2" name="electrical">
						  <option <?php if(isset($allowQualityspecRS['electrical']) && $allowQualityspecRS['electrical']=='Owner'){ ?> selected <?php } ?>>Owner</option>
						  <option <?php if(isset($allowQualityspecRS['electrical']) && $allowQualityspecRS['electrical']=='Basic'){ ?> selected <?php } ?>>Basic</option>
						  <option <?php if(isset($allowQualityspecRS['electrical']) && $allowQualityspecRS['electrical']=='Standard'){ ?> selected <?php } ?>>Standard</option>
						  <option <?php if(isset($allowQualityspecRS['electrical']) && $allowQualityspecRS['electrical']=='Premium'){ ?> selected <?php } ?>>Premium</option>
						</select>
						<label>Electrical</label>
					  </span>
				<span class="form-group has-float-label">
						<select class="form-control" id="Select3" name="pinterior">
						  <option <?php if(isset($allowQualityspecRS['painting_interior']) && $allowQualityspecRS['painting_interior']=='Owner'){ ?> selected <?php } ?>>Owner</option>
						  <option <?php if(isset($allowQualityspecRS['painting_interior']) && $allowQualityspecRS['painting_interior']=='In house'){ ?> selected <?php } ?>>In house</option>
						  <option <?php if(isset($allowQualityspecRS['painting_interior']) && $allowQualityspecRS['painting_interior']=='Subcontract'){ ?> selected <?php } ?>>Subcontract</option>
						</select>
						<label>Painting Interior</label>
					  </span>
				<span class="form-group has-float-label">
						<select class="form-control" id="Select4" name="interiord">
						  <option <?php if(isset($allowQualityspecRS['interior_doors']) && $allowQualityspecRS['interior_doors']=='Owner'){ ?> selected <?php } ?>>Owner</option>
						  <option <?php if(isset($allowQualityspecRS['interior_doors']) && $allowQualityspecRS['interior_doors']=='Basic'){ ?> selected <?php } ?>>Basic</option>
						  <option <?php if(isset($allowQualityspecRS['interior_doors']) && $allowQualityspecRS['interior_doors']=='Standard'){ ?> selected <?php } ?>>Standard</option>
						  <option <?php if(isset($allowQualityspecRS['interior_doors']) && $allowQualityspecRS['interior_doors']=='Premium'){ ?> selected <?php } ?>>Premium</option>
						</select>
						<label>Interior Doors</label>
					  </span>
				<span class="form-group has-float-label">
						<select class="form-control" id="Select5" name="door">
						  <option <?php if(isset($allowQualityspecRS['door_h/w']) && $allowQualityspecRS['door_h/w']=='Owner'){ ?> selected <?php } ?>>Owner</option>
						  <option <?php if(isset($allowQualityspecRS['door_h/w']) && $allowQualityspecRS['door_h/w']=='Basic'){ ?> selected <?php } ?>>Basic</option>
						  <option <?php if(isset($allowQualityspecRS['door_h/w']) && $allowQualityspecRS['door_h/w']=='Standard'){ ?> selected <?php } ?>>Standard</option>
						  <option <?php if(isset($allowQualityspecRS['door_h/w']) && $allowQualityspecRS['door_h/w']=='Premium'){ ?> selected <?php } ?>>Premium</option>
						</select>
						<label>Door H/W</label>
					  </span>
					<span class="form-group has-float-label">
						<select class="form-control" id="Select6" name="exterior">
						   <option <?php if(isset($allowQualityspecRS['painting_exterior']) && $allowQualityspecRS['painting_exterior']=='Owner'){ ?> selected <?php } ?>>Owner</option>
						  <option <?php if(isset($allowQualityspecRS['painting_exterior']) && $allowQualityspecRS['painting_exterior']=='In house'){ ?> selected <?php } ?>>In house</option>
						  <option <?php if(isset($allowQualityspecRS['painting_exterior']) && $allowQualityspecRS['painting_exterior']=='Subcontract'){ ?> selected <?php } ?>>Subcontract</option>
						</select>
						<label>Painting Exterior</label>
					  </span>
				</div>
			</div>
		  </div>
			<div class="card">
			<div class="card-header" id="headingNine">
			  <h5 class="mb-0">
				<button class="btn btn-link btn-lg collapsed"   type="button"  data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
				  Services
				</button>
			  </h5>
			</div>
			<div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
			  <div class="card-body">
				 <div class="card-body">
				<label class="col-5">Water</label>
					 	<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="water" id="water" value="Existing" <?php if(isset($servicesRS['water']) && $servicesRS['water']=='Existing'){ ?> checked <?php } ?>>
								 Existing  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="water" id="water" value="New" <?php if(isset($servicesRS['water']) && $servicesRS['water']=='New'){ ?> checked <?php } ?>>
								 New  
							</label>
						  </div>
					 <br />
				  <label class="col-5">Electrical</label>
					 	<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="electrical" id="electrical" value="Existing" <?php if(isset($servicesRS['electrical']) && $servicesRS['electrical']=='Existing'){ ?> checked <?php } ?>>
								 Existing  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="electrical" id="electrical" value="New" <?php if(isset($servicesRS['electrical']) && $servicesRS['electrical']=='New'){ ?> checked <?php } ?>>
								 New  
							</label>
						  </div>
				  
					 <br />
				  <label class="col-5">Sewerage</label>
					 	<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="sewerage" id="sewerage" value="Existing" <?php if(isset($servicesRS['sewerage']) && $servicesRS['sewerage']=='Existing'){ ?> checked <?php } ?>>
								 Existing  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="sewerage" id="sewerage" value="New" <?php if(isset($servicesRS['sewerage']) && $servicesRS['sewerage']=='New'){ ?> checked <?php } ?>>
								 New  
							</label>
						  </div>
					 <br />
				   <label class="col-5">Storm Water</label>
					 	<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="storm" id="storm" value="Existing" <?php if(isset($servicesRS['storm_water']) && $servicesRS['storm_water']=='Existing'){ ?> checked <?php } ?>>
								 Existing  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="storm" id="storm" value="New" <?php if(isset($servicesRS['storm_water']) && $servicesRS['storm_water']=='New'){ ?> checked <?php } ?> >
								 New  
							</label>
						  </div>
					 <br />
				   <label class="col-5">Temporary Power</label>
					 	<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="tpower" id="tpower" value="Yes" <?php if(isset($servicesRS['temporary_power']) && $servicesRS['temporary_power']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="tpower" id="tpower" value="No" <?php if(isset($servicesRS['temporary_power']) && $servicesRS['temporary_power']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
					 <br />
				   <label class="col-5">Temporary Water</label>
					 	<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="twater" id="twater" value="Yes" <?php if(isset($servicesRS['temporary_water']) && $servicesRS['temporary_water']=='Yes'){ ?> checked <?php } ?>>
								 Yes  
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<label class="form-check-label form-check-inline">
								<input class="form-check-input" type="radio" name="twater" id="twater" value="No" <?php if(isset($servicesRS['temporary_water']) && $servicesRS['temporary_water']=='No'){ ?> checked <?php } ?>>
								 No  
							</label>
						  </div>
					 <br />
			  </div>
			  </div>
			</div>
		  </div>
		
		<br />
		<div class="text-center">
			<button class="btn btn-primary btn-lg" <?php if(isset($_GET['id'])){ ?> name="edit" <?php } else{ ?> name="save" <?php } ?>    >Save Project</button>
		</div>
		<br />  </div>
        </form>
          
	</body>
	
	<script>

		 <?php if(isset($errvalidate)){ ?>
			swal("Error!", "<?php echo $errvalidate ?>", "error");
		<?php } ?>
		
		 <?php if(isset($success)){ ?>
			swal("Saved!", "Project is saved successfully", "success");
		<?php } ?>
		
		 <?php if(isset($fmsg)){ ?>
			swal("<?php echo $fmsg ?>");
			window.location="project.php?id="+<?php echo $projid; ?>;
		<?php } ?>
		
	function myFunction() {
		var x = document.getElementById("myTopnav");
//		if (x.className === "topnav") {
			x.className += " responsive";
//		} else {
//			x.className = "topnav";
//		}
	}
		
		function sqlerror(){
			swal("Error!", "Error in saving Project", "error");
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
							
						window.location="project.php?roomid="+roomid;
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
							
						window.location="project.php?extid="+extid;
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
<!--	<script src="vendor/bootstrap/js/popper.js"></script>-->
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->

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