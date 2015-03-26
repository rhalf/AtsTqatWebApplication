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

		$sCompanyDatabase = 'cmp_'. $aResult['tcmp'];

		//Query and Connection 2
		$sDriver = "$engine:host=$dbhost;dbname=$sCompanyDatabase";
		

		$cCompanyDatabase = new PDO($sDriver,$sUsername,$sPassword);
		$sQuery = 	'SELECT '. $sCompanyDatabase .'.usrs.uemail, '. $sCompanyDatabase .'.usrs.uname ' .
					'FROM ' . $sCompanyDatabase . '.usrs;';


		$cQuery  = $cCompanyDatabase->prepare($sQuery);

		$cQuery->execute();

		while ( $aRow = $cQuery->fetch(PDO::FETCH_ASSOC)) {

			$sEmailMessage = "Dear " . $aRow['uname'] . ",\r\n\r\n" .
							"\tDetails of a unit with Tracker ID : ". $sTrackee . " is listed below." . "\r\n\r\n" .
							"\tTracker ID\t\t: " . $sTrackee . "\r\n" .
							"\tTracker DriverName\t: " . $sTrackeeDriver . "\r\n" .
							"\tTracker VehicleReg\t: " . $sTrackeeVehicleReg . "\r\n\r\n" .
							"\t======================================================" . "\r\n\r\n" .

							"\tTracker Mileage\t\t: " . $sTrackeeMileage . "\r\n" .
							"\tTracker Time\t\t: " . $sTrackeeTime . "\r\n" .
							"\tTracker Speed\t\t: " . $sTrackeeSpeed . "\r\n" .
							"\tTracker Signal\t\t: " . $sTrackeeSignal . "\r\n" .
							"\tTracker Geofence\t: " . $sTrackeeGeofence . "\r\n" .
							"\tTracker Ordinates\t: " . $sTrackeeLatitude. ", " . $sTrackeeLongitude . "\r\n" .
							"\tTracker Address\t\t: " . $sTrackeeAddress . "\r\n\r\n" .
							"\t======================================================" . "\r\n\r\n" .
							"\tLost Tracker\t\t: " . $sAlarmLost . "\r\n" .
							"\tUrgent\t\t\t: " . $sAlarmUrgent . "\r\n" .
							"\tACC\t\t\t: " . $sAlarmAcc . "\r\n" .
							"\tGeofence\t\t: " . $sAlarmGeofence . "\r\n" .
							"\tExp. Registration\t: " . $sAlarmExpiration . "\r\n" .
							"\tOverspeeding\t\t: " . $sAlarmLost . "\r\n\r\n" .
							"\t======================================================" . "\r\n\r\n" .
							"\tPlease do not reply to this email." . "\r\n" .
							"\tThis is an Electronic Generated email." . "\r\n\r\n" .

							"Regards,\r\n" .
							"www.t-qat.net\r\n";
			email($aRow['uemail'],"T-QAT E-ALERT (Tracker ID: " . $sTrackee . ")" , $sEmailMessage );
		}

		//echo json_encode($cQuery->fetchAll(PDO::FETCH_ASSOC));
		
	} catch (PDOExcemption $cExcemption) {
		echo "Database failed.";
		die;
	}



	function email($sSendTo, $sSubject, $sMessage ) {
		$sMessage = wordwrap($sMessage, 70, "\r\n");
		mail($sSendTo, $sSubject, $sMessage);
	}

?>