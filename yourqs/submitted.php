<?php

	session_start();

	if (!isset($_SESSION['username'])) {
		header("Location: error.php");
	}

	require_once('./connect.php');


// Include the main TCPDF library (search for installation path).
	require_once('TCPDF-master/examples/tcpdf_include.php');
	include('TCPDF-master/tcpdf.php');

	// Extend the TCPDF class to create custom Header and Footer
	class MYPDF extends TCPDF {

		//Page header
		public function Header() {
			// Logo
			$image_file = './images/YourQS_Logof.jpg';
			$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			$this->SetFont('helvetica', 'B', 20);
			// Title
			$this->Cell(0, 15, 'YourQS Project', 0, false, 'C', 0, '', 0, false, 'M', 'M');
			
		}

		// Page footer
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
			$this->SetFont('helvetica', 'I', 8);
			// Page number
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}

	function modify($str) {
			return ucwords(str_replace("_", " ", $str));
	}	

	if (isset($_GET) & !empty($_GET['subpid'])) {

		$uid = $_SESSION['userid'];
		$id = $_GET['subpid'];
		
		$selectSql = "SELECT email FROM user WHERE user_id=$uid ;";
		$res       = mysqli_query($connection, $selectSql);
		$uRS       = mysqli_fetch_assoc($res);
		$toaddress  = $uRS['email'];
		
		$selectSql = "SELECT email FROM user WHERE role='admin' ;";
		$res       = mysqli_query($connection, $selectSql);
		$uRS       = mysqli_fetch_assoc($res);
		$ccaddress  = $uRS['email'];
		
		//project 
		$selectSql = "SELECT * FROM project WHERE project_id=$id AND user_id=$uid ;";
		$res       = mysqli_query($connection, $selectSql);
		$pRS       = mysqli_fetch_assoc($res);
		$project_name  = $pRS['project_name'];
		$date  = $pRS['date'];
		$last_updated = $pRS['last_updated'];
		
		$msg = '<h1>congratulations!</h1><br /><h2>YourQS Project Submission  '.$project_name.' </h2><hr>
		<p>
		The project details are submitted on '.$date.'
		<br/><p>
		You can find more details in the attached PDF document. This will be considered as the final details of the submitted project. But you can always go back to Submitted Projects section to update and resubmit the same project to discard this submission.</p>';
		
		//		Address
		$selectSql = "SELECT * FROM project_address WHERE project_id=$id ;";
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
		
		

		
		//PDF
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($toaddress);
		$pdf->SetTitle('YourQS Project'.$project_name);
		
		
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}


		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', 'B', 14);

		// add a page
		$pdf->AddPage();
		
		$pdf->Write(0, 'Congratulations! You have submitted YourQS Project', '', 0, 'L', true, 0, false, false, 0);
		
		// set font
		$pdf->SetFont('helvetica', '', 10);
				

		// set the table to print
		$tbl = "<br /><br /><div style=\"color:#2b6ca3;\">
		
			<table style=\"border:2px solid #e87511;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#EA8228\"><td colspan=\"3\"><b>Project Details</b></td></tr>
			<tr>
			<td>Project Name</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$project_name</td></tr>
			<tr><td>Created Date</td><td width=\"20\">:</td><td width=\"60%\">$date</td></tr>
			<tr><td>Created User </td><td width=\"20\">:</td><td width=\"60%\">$toaddress</td></tr>
			</table></div>";

		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// set font
		$pdf->SetFont('helvetica', '', 10);

		
		$tbl = "<div style=\"color:#2b6ca3;\">
		
		<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Address</b></td></tr>
		";
		
		$address_cols = array_keys($addressRS);
		
		for($i=0; $i<sizeof($address_cols); $i++){
			
			if($address_cols[$i]!='project_id'){
				$col = modify($address_cols[$i]);
				$val = $addressRS[$address_cols[$i]];
				
				$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
			}
			
		}
		
		$tbl = $tbl. "</table></div>";
		
		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 10);
		
		
		$tbl = "<div style=\"color:#2b6ca3;\">
		<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Site Arrangement</b></td></tr>";
		
		$st_cols = array_keys($siteArrRS);
		
		for($i=0; $i<sizeof($st_cols); $i++){

			if($st_cols[$i]!='project_id'){
				$col = modify($st_cols[$i]);
				$val = $siteArrRS[$st_cols[$i]];
				
				$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
			}
			
		}
		
		$tbl = $tbl. "</table> <div>";
		
		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');

		// ---------------------------------------------------------
		
		
		// set font
		$pdf->SetFont('helvetica', '', 10);

		$tbl = "<div style=\"color:#2b6ca3;\">
		<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Safety Requirements</b></td></tr>";
		
		$sft_cols = array_keys($safetyreqRS);
		
		for($i=0; $i<sizeof($sft_cols); $i++){
			
			if($sft_cols[$i]!='project_id'){
				$col = modify($sft_cols[$i]);
				$val = $safetyreqRS[$sft_cols[$i]];
				
				$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
			}
			
		}
		
		$tbl = $tbl. "</table> <div>";
		
		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');

// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont('helvetica', '', 10);

		// add a page
		$pdf->AddPage();
		
		$tbl = "<div style=\"color:#2b6ca3;\">
		<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>People and Pricing</b></td></tr>";
		
		$pp_cols = array_keys($ppRS);
		
		for($i=0; $i<sizeof($pp_cols); $i++){
			
			if($pp_cols[$i]!='project_id'){
				$col = modify($pp_cols[$i]);
				$val = $ppRS[$pp_cols[$i]];
				
				$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
			}
			
		}
		
		$tbl = $tbl. "</table> <div>";
		
		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 10);
		
		$tbl = "<div style=\"color:#2b6ca3;\">
		<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Markups</b></td></tr>";
		
		$mk_cols = array_keys($markupRS);
		
		for($i=0; $i<sizeof($mk_cols); $i++){
			
			if($mk_cols[$i]!='project_id'){
				$col = modify($mk_cols[$i]);
				$val = $markupRS[$mk_cols[$i]];
				
				$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
			}
			
		}
		
		$tbl = $tbl. "</table> <div>";
		
		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 10);
		
		$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Allowances and Insurance</b></td></tr>";
		
		$allins_cols = array_keys($allowancesInsRS);
		
		for($i=0; $i<sizeof($allins_cols); $i++){
			
			if($allins_cols[$i]!='project_id'){
				$col = modify($allins_cols[$i]);
				$val = $allowancesInsRS[$allins_cols[$i]];
				
				$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
			}
			
		}
		
		$tbl = $tbl. "</table> <div>";
		
		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont('helvetica', '', 10);

		$tbl = "<div style=\"color:#2b6ca3;\">
		<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Professional Service Allowances Required</b></td></tr>";
		
		$proservall_cols = array_keys($proservRS);
		
		for($i=0; $i<sizeof($proservall_cols); $i++){
			
			if($proservall_cols[$i]!='project_id'){
				$col = modify($proservall_cols[$i]);
				$val = $proservRS[$proservall_cols[$i]];
				
				$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
			}
			
		}
		
		$tbl = $tbl. "</table> <div>";
		
		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont('helvetica', '', 10);

		$tbl = "<div style=\"color:#2b6ca3;\">
		<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Allowances Quality Specification</b></td></tr>";
		
		$allq_cols = array_keys($allowQualityspecRS);
		
		for($i=0; $i<sizeof($allq_cols); $i++){
			
			if($allq_cols[$i]!='project_id'){
				$col = modify($allq_cols[$i]);
				$val = $allowQualityspecRS[$allq_cols[$i]];
				
				$tbl = $tbl. "<tr><td> $col</td><td  width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
			}
			
		}
		
		$tbl = $tbl. "</table> <div>";
		
		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 10);
		
		$tbl = "<div style=\"color:#2b6ca3;\">
		<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Services</b></td></tr>";
		
		$service_cols = array_keys($servicesRS);
		
		for($i=0; $i<sizeof($service_cols); $i++){
			
			if($service_cols[$i]!='project_id'){
				$col = modify($service_cols[$i]);
				$val = $servicesRS[$service_cols[$i]];
				
				$tbl = $tbl. "<tr><td> $col</td><td  width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
			}
			
		}
		
		$tbl = $tbl. "</table> <div>";
		
		// print table using Write()
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// ---------------------------Rooms------------------------------

		
		
		//		rooms
		$selectSql = "SELECT * FROM room WHERE project_id=$id ";
		$roomRS     = mysqli_query($connection, $selectSql);
		
		while($rooms = mysqli_fetch_assoc($roomRS)){
			
			$roomid = $rooms['room_id'];
			
			$selectSql = "SELECT * FROM room WHERE room_id=$roomid";
			$res     = mysqli_query($connection, $selectSql);
			$rmRS     = mysqli_fetch_assoc($res);
			
			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<br /><br /><div style=\"color:#2b6ca3;\">
				<table style=\"border:2px solid #e87511;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#EA8228\"><td colspan=\"3\"><b>Rooms Details</b></td></tr>";

			$room_cols = array_keys($rmRS);

			for($i=0; $i<sizeof($room_cols); $i++){

				if($room_cols[$i]!='project_id' & $room_cols[$i]!='room_id'){
					$col = modify($room_cols[$i]);
					$val = $rmRS[$room_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td  width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');
			
			$SelSql = "SELECT * FROM description WHERE room_id=$roomid";
			$res   = mysqli_query($connection, $SelSql);
			$descRS     = mysqli_fetch_assoc($res);
			

			// set font
			$pdf->SetFont('helvetica', '', 10);

				
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Description of work</b></td></tr>";

			$desc_cols = array_keys($descRS);

			for($i=0; $i<sizeof($desc_cols); $i++){

				if($desc_cols[$i]!='project_id' & $desc_cols[$i]!='room_id'){
					$col = modify($desc_cols[$i]);
					$val = $descRS[$desc_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td  width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM subtrades WHERE room_id=$roomid";
			$res   = mysqli_query($connection, $SelSql);
			$subRS     = mysqli_fetch_assoc($res);
		

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Sub Trades</b></td></tr>";

			$sub_cols = array_keys($subRS);

			for($i=0; $i<sizeof($service_cols); $i++){

				if($sub_cols[$i]!='project_id' & $sub_cols[$i]!='room_id'){
					$col = modify($sub_cols[$i]);
					$val = $subRS[$sub_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td  width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');


			$SelSql = "SELECT * FROM windows_doors WHERE room_id=$roomid";
			$res   = mysqli_query($connection, $SelSql);
			$winRS     = mysqli_fetch_assoc($res);
		

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Windows and Doors</b></td></tr>";

			$win_cols = array_keys($winRS);

			for($i=0; $i<sizeof($win_cols); $i++){

				if($win_cols[$i]!='project_id' & $win_cols[$i]!='room_id'){
					$col = modify($win_cols[$i]);
					$val = $winRS[$win_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td  width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM joinery WHERE room_id=$roomid";
			$res   = mysqli_query($connection, $SelSql);
			$jRS     = mysqli_fetch_assoc($res);
			
			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Joinery</b></td></tr>";

			$joinery_cols = array_keys($jRS);

			for($i=0; $i<sizeof($joinery_cols); $i++){

				if($joinery_cols[$i]!='project_id' & $joinery_cols[$i]!='room_id'){
					$col = modify($joinery_cols[$i]);
					$val = $jRS[$joinery_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td  width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM other WHERE room_id=$roomid";
			$res   = mysqli_query($connection, $SelSql);
			$otherRS     = mysqli_fetch_assoc($res);
			

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Other</b></td></tr>";

			$roomother_cols = array_keys($otherRS);

			for($i=0; $i<sizeof($roomother_cols); $i++){

				if($roomother_cols[$i]!='project_id' & $roomother_cols[$i]!='room_id'){
					$col = modify($roomother_cols[$i]);
					$val = $otherRS[$roomother_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td  width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}
		
//		==============================Exterior===================
		
//		exterior
		$selectSql = "SELECT * FROM exterior_scope WHERE project_id=$id ";
		$exteriorRS    = mysqli_query($connection, $selectSql);
		
		while($exterior = mysqli_fetch_assoc($exteriorRS)){
			
			$eid = $exterior['exterior_id'];
			
			$SelSql = "SELECT * FROM exterior_scope WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$exRS     = mysqli_fetch_assoc($res);
			

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<br /><br /><div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #e87511;\" cellpadding=\"5\">
		<tr color=\"black\" bgcolor=\"#EA8228\"><td colspan=\"3\"><b>Exterior Details</b></td></tr>";

			$ext_cols = array_keys($exRS);

			for($i=0; $i<sizeof($ext_cols); $i++){

				if($ext_cols[$i]!='project_id' & $ext_cols[$i]!='exterior_id'){
					$col = modify($ext_cols[$i]);
					$val = $exRS[$ext_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM roof WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$roofRS     = mysqli_fetch_assoc($res);
			

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Roof</b></td></tr>";

			$roof_cols = array_keys($roofRS);

			for($i=0; $i<sizeof($roof_cols); $i++){

				if($roof_cols[$i]!='project_id' & $roof_cols[$i]!='exterior_id'){
					$col = modify($roof_cols[$i]);
					$val = $roofRS[$roof_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM gutter WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$gutterRS     = mysqli_fetch_assoc($res);
			
			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Gutter</b></td></tr>";

			$gutter_cols = array_keys($gutterRS);

			for($i=0; $i<sizeof($gutter_cols); $i++){

				if($gutter_cols[$i]!='project_id' & $gutter_cols[$i]!='exterior_id'){
					$col = modify($gutter_cols[$i]);
					$val = $gutterRS[$gutter_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM downpile WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$pipeRS     = mysqli_fetch_assoc($res);
			

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Downpipe</b></td></tr>";

			$pipe_cols = array_keys($pipeRS);

			for($i=0; $i<sizeof($pipe_cols); $i++){

				if($pipe_cols[$i]!='project_id' & $pipe_cols[$i]!='exterior_id'){
					$col = modify($pipe_cols[$i]);
					$val = $pipeRS[$pipe_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM fascia WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$fsRS     = mysqli_fetch_assoc($res);
			
			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Fascia</b></td></tr>";

			$fsc_cols = array_keys($fsRS);

			for($i=0; $i<sizeof($fsc_cols); $i++){

				if($fsc_cols[$i]!='project_id' & $fsc_cols[$i]!='exterior_id'){
					$col = modify($fsc_cols[$i]);
					$val = $fsRS[$fsc_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');


			$SelSql = "SELECT * FROM deck WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$deckRS     = mysqli_fetch_assoc($res);
			

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Deck</b></td></tr>";

			$deck_cols = array_keys($deckRS);

			for($i=0; $i<sizeof($deck_cols); $i++){

				if($deck_cols[$i]!='project_id' & $deck_cols[$i]!='exterior_id'){
					$col = modify($deck_cols[$i]);
					$val = $deckRS[$deck_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM handrail WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$hrRS     = mysqli_fetch_assoc($res);

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Handrail</b></td></tr>";
			
			$hdr_cols = array_keys($hrRS);

			for($i=0; $i<sizeof($hdr_cols); $i++){

				if($hdr_cols[$i]!='project_id' & $hdr_cols[$i]!='exterior_id'){
					$col = modify($hdr_cols[$i]);
					$val = $hrRS[$hdr_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM paving WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$pvRS     = mysqli_fetch_assoc($res);
			

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Paving</b></td></tr>";

			$pav_cols = array_keys($pvRS);

			for($i=0; $i<sizeof($pav_cols); $i++){

				if($pav_cols[$i]!='project_id' & $pav_cols[$i]!='exterior_id'){
					$col = modify($pav_cols[$i]);
					$val = $pvRS[$pav_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM driveway WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$dwRS     = mysqli_fetch_assoc($res);
			
			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Driveway</b></td></tr>";

			$drivway_cols = array_keys($dwRS);

			for($i=0; $i<sizeof($drivway_cols); $i++){

				if($drivway_cols[$i]!='project_id' & $drivway_cols[$i]!='exterior_id'){
					$col = modify($drivway_cols[$i]);
					$val = $dwRS[$drivway_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');
		

			// set font
			$pdf->SetFont('helvetica', '', 10);

			$SelSql = "SELECT * FROM fencing WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$fencingRS     = mysqli_fetch_assoc($res);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Fencing</b></td></tr>";

			$drivway_cols = array_keys($dwRS);

			for($i=0; $i<sizeof($drivway_cols); $i++){

				if($drivway_cols[$i]!='project_id' & $drivway_cols[$i]!='exterior_id'){
					$col = modify($drivway_cols[$i]);
					$val = $dwRS[$drivway_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');

			$SelSql = "SELECT * FROM ext_other WHERE exterior_id=$eid";
			$res   = mysqli_query($connection, $SelSql);
			$otherRS     = mysqli_fetch_assoc($res);
			

			// set font
			$pdf->SetFont('helvetica', '', 10);
			
			$tbl = "<div style=\"color:#2b6ca3;\">
			<table style=\"border:2px solid #2b6ca3;\" cellpadding=\"5\">
			<tr color=\"black\" bgcolor=\"#2b6ca3\"><td colspan=\"3\"><b>Other</b></td></tr>";

			$extother_cols = array_keys($otherRS);

			for($i=0; $i<sizeof($extother_cols); $i++){

				if($extother_cols[$i]!='project_id' & $extother_cols[$i]!='exterior_id'){
					$col = modify($extother_cols[$i]);
					$val = $otherRS[$extother_cols[$i]];

					$tbl = $tbl. "<tr><td> $col</td><td width=\"20\">:</td><td width=\"60%\" align=\"left\">$val</td></tr>";	
				}

			}

			$tbl = $tbl. "</table> <div>";

			// print table using Write()
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}
		
		
//		------------------------------------------------------------
		//Close and output PDF document
		$pdf->Output('pdf/'.$project_name.'_'.$uid.'_'.$id.'.pdf', 'F');
		
//		echo file_exists('pdf/'.$project_name.'_'.$uid.'_'.$id.'.pdf');
		
		//email 
		if (file_exists('pdf/'.$project_name.'_'.$uid.'_'.$id.'.pdf')) {
		
			require 'PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  // smtp-mail.outlook.com Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'rentacarcomp@gmail.com';                 //yib00002bn@aspire2student.ac.nz SMTP username
			$mail->Password = 'Janithri_123456';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to

			$mail->From='rentacarcomp@gmail.com';
			$mail->FromName='YourQS';
			$mail->addAddress($toaddress, 'User');     
			$mail->addAddress($ccaddress, 'Admin');     
			$mail->isHTML(true);         

			$mail->addAttachment('pdf/'.$project_name.'_'.$uid.'_'.$id.'.pdf');

			$mail->Subject = 'YourQS Project Submitted';
			$mail->Body    = $msg;

			$mail->AltBody = 'This is an email notification for submitted project ';

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				$emsg = "Mailer Error: ". $mail->ErrorInfo;
				
			} else {

				$success = 'true';
				$emsg = "Project is submitted successfully";

				$UpdateSql = "UPDATE project SET status='submitted' WHERE project_id=$id; ";

				$res = mysqli_query($connection, $UpdateSql);

			}
		}else{
			$emsg = "Error in PDF output. Please refresh and try again.";
		}
	}


	$usrid = $_SESSION['userid'];
	$query   = "SELECT * FROM project WHERE user_id=$usrid AND status ='submitted' order by date ASC ";
	$records = mysqli_query($connection, $query);
	
?>

<html>

	<head>
        <meta charset="utf-8">
        <meta name="description" content="YourQS">
        <meta name="author" content="aspire2international">
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

	<link rel="stylesheet" href="https://cdn.rawgit.com/tonystar/bootstrap-float-label/v3.0.1/dist/bootstrap-float-label.min.css"/>
		 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<title>YourQS</title>
    </head>
	<body>
		
		<div class="topnav" id="myTopnav">
			<a href="" class="active">Submitted Projects</a>
			<a href="index.php">Project List</a>
			<a href="#" data-toggle="modal" data-target="#projName">New Project</a>
			<a href="login.php?lgout=1">Logout</a>
			  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
			<i class="fa fa-bars"></i>
		  </a>
		</div>
		
		
			  <!-- The Modal -->
			  <div class="modal fade" id="projName">
				<div class="modal-dialog">
				  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">New Project</h4>
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
				<form action="project.php" method="post">
					<div class="modal-body">						
						<span class="form-group has-float-label">
							<input class="form-control" type="text" id="projname" name="projname" placeholder=" "/>
							<label>Project Name</label>
						  </span>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button class="btn btn-primary">Start</button>
					</div>
					</form>
				  </div>
				</div>
			  </div>				
				
		
		<div class="limiter">
		
			<div class="container-index100">
				
				<div class="wrap-login100 p-b-160 p-t-50">
			<span class="login100-form-title p-b-43">
						 YourQS Projects
			</span>
					
			<div class="table-responsive">
			  <table class="table table-hover table-striped">
				  <thead>
				   <tr>
					   
					    </tr>
					  </thead>
				  <tbody>
					  <?php
						 while($project = mysqli_fetch_assoc($records)){
						  ?>
					   <tr>
						   
					  <td scope="row"><a href="project.php?id=<?php echo $project['project_id']; ?>"> 
					    <?php echo $project['project_name']." <br />".$project['date']; ?> </a></td>
						   
						   
					   <td scope="row"> <small><a onclick="submitpj('<?php echo $project['project_id']; ?>')" class="btn btn-success btn-block btn-md" >Re-Submit</a></small></td>
					  </tr>
						   <?php }?>
				  </tbody>
			  </table>
			</div>
					   
			</div>
		</div>
		</div>
		<script>
		
			 <?php if(isset($fmsg)){ ?>
				swal("<?php echo $fmsg ?>");
			<?php } ?>
			
			function submitpj(pid){
			
			swal({
				  title: "Project Submission",
				  text: "Are you sure you want to submit this project?",
				  icon: "warning",
				  buttons:  {
					submit: "Yes",
					cancel: "No",
				  },
				  dangerMode: true,
				})
				.then((value) => {
				
					switch (value) {

					case "submit":
							
						window.location="submitted.php?subpid="+pid;
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
		
	</body>
</html>