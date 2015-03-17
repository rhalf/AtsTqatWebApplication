<?php

define('ROOT_DIR', dirname(__FILE__));
//$webroot = 'http://108.163.190.202';
$webroot = 'http://127.0.0.1/ats_services_gpstrackingsystem';
$ApplicationVersion = '7.0.0.0';
$WebSiteVersion = '7.0.0.0';
$engine = 'mysql';

$active_googlemap = false;
$active_bingmap = false;
$active_ovimap = false;
$active_nokiamap = false;
$active_arcgismap = false;

$default_provider = '2';

$default_deviceType = '5';

$defaultTimeZone = 'Asia/Qatar';

$MaxLogoFileSize = 150000;  // bytes

define('gps_debug', true);
?>