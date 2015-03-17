<?php

define('ROOT_DIR', dirname(__FILE__));

//$webroot = 'http://t-qat.net';
$webroot = 'http://127.0.0.1/ats_services_GpsTrackingSystem';

/*
	Modified by: Rhalf Wendel D Caacbay
	Modified on: 20150317
	
	
	Note:
		Prior Version
			$ApplicationVersion = '6.4.0.0';
			$WebSiteVersion = '5.1.0.0';
*/

$ApplicationVersion = '7.0.0.0';
$WebSiteVersion = '7.0.1.0';
$engine = 'mysql';

$active_googlemap = FALSE;
$active_bingmap = FALSE;
$active_ovimap = FALSE;
$active_nokiamap = FALSE;
$active_arcgismap = FALSE;

$default_provider = '2';

$default_deviceType = '5';

$defaultTimeZone = 'Asia/Qatar';

$MaxLogoFileSize = 150000;  // bytes

define('gps_debug', true);
?>