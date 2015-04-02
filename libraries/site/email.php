<?php
	/*
		Company Name:	Advanced Technologies and Solutions
		Project Name: 	Gps Tracking System
		File Name:		Email.php

		Created by:		Rhalf Wendel D Caacbay
		Created on:		20150324

		Modified by:	
		Modified on:

		Note:
			Used for sending Email Alerts;


	*/

	header("Cache-Control: no-cache, must-revalidate");
	include_once("../../connect/conf.php");

	if (!isset($_POST['trackee'])) {
	    die;
	}


	$sTrackee = $_POST['trackee']; 

	$sAlarmLost = $_POST['alarmLost'];
	$sAlarmUrgent = $_POST['alarmUrgent'];
	$sAlarmAcc = $_POST['alarmAcc'];
	$sAlarmGeofence = $_POST['alarmGeofence'];
	$sAlarmRegistration = $_POST['alarmRegistration'];
	$sAlarmExpiration = $_POST['alarmExpiration'];
	$sAlarmOverSpeeding = $_POST['alarmOverSpeeding'];

	$sTrackeeMileage = $_POST['trackeeMileage'];
	$sTrackeeTime = $_POST['trackeeTime'];
	$sTrackeeSpeed = $_POST['trackeeSpeed'];
	$sTrackeeDegrees = $_POST['trackeeDegrees'];
	$sTrackeeSignal = $_POST['trackeeSignal'];
	$sTrackeeLatitude = $_POST['trackeeLatitude'];
	$sTrackeeLongitude = $_POST['trackeeLongitude'];
	$sTrackeeGeofence = $_POST['trackeeGeofence'];
	$sTrackeeAddress = $_POST['trackeeAddress'];
	
	$sTrackeeVehicleReg = $_POST['trackeeVehicleReg'];
	$sTrackeeDriver	=	$_POST['trackeeDriver'];
	
	try {
		$sUsername = "$dbuser";
		$sPassword = "$dbpass";

		//Query And Connection 1
		//$sDriver = 'mysql:host=108.163.190.202;port=3306;dbname=dbt_tracking_master';
		$sDriver = "$engine:host=$dbhost;dbname=$prefix$dbname";
	
		$cMainDatabase = new PDO($sDriver,$sUsername,$sPassword,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

		$sQuery = 	'SELECT dbt_tracking_master.trks.tcmp ' .
					'FROM dbt_tracking_master.trks ' .
					'WHERE dbt_tracking_master.trks.tunit = :trackee;';

		$cQuery  = $cMainDatabase->prepare($sQuery);
		$cQuery->bindParam(':trackee',$sTrackee);
		$cQuery->execute();

		$aResult = $cQuery->fetch();
		unset($cQuery);
		
		if ($aResult['tcmp'] == "") {
			echo "Company is Null";
			die;
		}

		$sCompanyDatabase = 'cmp_'. $aResult['tcmp'];

		//Query and Connection 2
		$sDriver = "$engine:host=$dbhost;dbname=$sCompanyDatabase";
		

		$cCompanyDatabase = new PDO($sDriver,$sUsername,$sPassword);
		$sQuery = 	'SELECT '. $sCompanyDatabase .'.usrs.uemail, '. $sCompanyDatabase .'.usrs.uname ' .
					'FROM ' . $sCompanyDatabase . '.usrs;';


		$cQuery  = $cCompanyDatabase->prepare($sQuery);

		$cQuery->execute();

		while ( $aRow = $cQuery->fetch(PDO::FETCH_ASSOC)) {

			$sEmailMessage = "Dear " . $aRow['uname'] . ',<br /><br />' .
							'<span >Details of a unit with Tracker ID :' . $sTrackee . ' is listed below.</span><br /><br />' .
							
							
							'<table border="1">' .
							'<tr><th colspan="2">Tracker Details</th></tr>' .
							'<tr><td>Tracker ID</td><td>' . $sTrackee . '</td></tr>' .
							'<tr><td>Driver Name</td><td>' . $sTrackeeDriver . '</td></tr>' .
							'<tr><td>Tracker Vehicle Registration</td><td>' . $sTrackeeVehicleReg . '</td></tr>' .
							'</table><br />'.

							'<table border="1">' .
							'<tr><th colspan="2">Tracker Readings</th></tr>' .
							'<tr><td>Total Distance</td><td>' . $sTrackeeMileage . '</td></tr>' .
							'<tr><td>Time</td><td>' .  $sTrackeeTime . '</td></tr>' .
							'<tr><td>Speed</td><td>' .  $sTrackeeSpeed . '</td></tr>' .
							'<tr><td>Signal</td><td>' . $sTrackeeSignal . '</td></tr>' .
							/*'<tr><td>Geofence</td><td>' . $sTrackeeGeofence . '</td></tr>' . */
							'<tr><td>Latitude, Longitude</td><td>' .  $sTrackeeLatitude. ", " . $sTrackeeLongitude . '</td></tr>' .
							'<tr><td>Address</td><td>' . $sTrackeeAddress . '</td></tr>' .
							'</table><br />' .
							
							
							
							/*
							'<table border="1">' .
							"\tLost Tracker\t\t: " . $sAlarmLost . "\r\n" .
							"\tUrgent\t\t\t: " . $sAlarmUrgent . "\r\n" .
							"\tACC\t\t\t: " . $sAlarmAcc . "\r\n" .
							"\tGeofence\t\t: " . $sAlarmGeofence . "\r\n" .
							"\tExp. Registration\t: " . $sAlarmExpiration . "\r\n" .
							"\tOverspeeding\t\t: " . $sAlarmLost . "\r\n\r\n" .
							'</table>' .
							*/
							
							'<span >Please do not reply to this email.</span><br />' .
							'<span >This is electronically generated email.</span><br /><br />' .
							"Regards, <br />"  .
							"<a href='http://www.t-qat.net'>www.t-qat.net<a />" .
							'<style>'.
							'span { padding-left: 20px; }' .
							'table { margin-left: 20px; border: 1px solid #000; }' .
							'td { width: 400; height: auto; }' .
							'</style>';
							
			if ($aRow['uemail']!="") {
				email($aRow['uemail'],"T-QAT E-ALERT (Tracker ID: " . $sTrackee . ")" , $sEmailMessage );
			}
			
		}

		//echo json_encode($cQuery->fetchAll(PDO::FETCH_ASSOC));
		
	} catch (PDOExcemption $cExcemption) {
		echo "Database failed.";
		die;
	}



	function email($sSendTo, $sSubject, $sMessage ) {

		//$sMessage = wordwrap($sMessage, 70, "\r\n");

		require_once ($_SERVER['DOCUMENT_ROOT'].'/libraries/PHPMailer/PHPMailerAutoload.php');

		
		//Create a new PHPMailer instance
		$mail = new PHPMailer(true);
		try {
			//Set who the message is to be sent from
			$mail->setFrom('tqat@ats-qatar.com', 'T-QAT');
 			$mail->addReplyTo('support@ats-qatar.com', 'Support');
			//Set who the message is to be sent to
			$mail->addAddress($sSendTo,$sSendTo);
			//Set the subject line
			$mail->Subject = $sSubject;
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML($sMessage);
			//Replace the plain text body with one created manually
			$mail->AltBody = 'This is a plain-text message body';
			//Attach an image file
			//$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/Ats_services_GpsTrackingSystem/libraries/PHPMailer/images/phpmailer_mini.png');
			$mail->send();
		} catch (phpmailerException $e) {
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
		}
	}
?>