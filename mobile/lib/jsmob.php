<?php
$files=$_GET['files'];

header("Content-type: text/javascript");
include_once('../../settings.php');
include(ROOT_DIR.'/libraries/site/default.js');

// jquery
if ($files=='site' or $files=='map'){
	$jqpathjs=ROOT_DIR.'/libraries/jquery/jquery-ui-1.10.3/';
	$jqueryjs=array(
		'js/jquery-1.10.2.js',
	);
	foreach ($jqueryjs as $js){
		include("$jqpathjs$js");			
	};
}

if ($files=='site' or $files=='map'){
	$jqaddonpathjs='jquery.mobile-1.3.2/';
	$jqueryaddonjs=array(
		'jquery.mobile-1.3.2.min.js'
	);
	foreach ($jqueryaddonjs as $js){
		include("$jqaddonpathjs$js");			
	};
}

// site
if ($files=='map'){
	$gsitejspath=ROOT_DIR.'/libraries/site/';
	$gsitejs=array(
		'bignum.js',
		'realtime.js',
		'osmmap_func.js',
		'drawing_geofence.js',
		'get_menu_trackers.js',
	);
	foreach ($gsitejs as $js){
		include("$gsitejspath$js");			
	};
}
?>