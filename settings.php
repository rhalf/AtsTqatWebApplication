<?php

define('ROOT_DIR', dirname(__FILE__));
//$webroot = 'http://108.163.190.202';
$webroot = 'http://127.0.0.1/ats_services_gpstrackingsystem';
$ApplicationVersion = '5.1.0.0';
$WebSiteVersion = '5.1.0.0';
$engine = 'mysql';

$active_googlemap = true;
$active_bingmap = true;
$active_ovimap = true;
$active_nokiamap = true;
$active_arcgismap = true;

$default_provider = '2';

$default_deviceType = '5';

$defaultTimeZone = 'Asia/Qatar';

$MaxLogoFileSize = 150000;  // bytes

define('gps_debug', true);
?>