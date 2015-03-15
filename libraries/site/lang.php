<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
header("Content-type: text/javascript");
?>
var Auto_LBL='<?php echo Auto; ?>';
var OFF_LBL='<?php echo Off; ?>';
var ON_LBL ='<?php echo On; ?>';
var HIGH_LBL= '<?php echo High; ?>';
var SHORT_LBL= '<?php echo Short; ?>';
var NORMAL_LBL='<?php echo Normal; ?>';
var ERROR_LBL = '<?php echo Error; ?>';
var LOW_LBL= '<?php echo Low; ?>';
var TimeZone=<?php echo getTimezoneOffset($timezone) / 60 / 60 ?>;
var VEHICLEREG_LBL='<?php echo VehicleReg?>';
var TRACKERCOUNT_LBL='<?PHP echo TrackerCount;?>';

var RUNNINGMODE_LBL='<?php echo RunningMode?>'
var PARKINGMODE_LBL='<?php echo ParkingMode?>'
var IDLEMODE_LBL='<?php echo IdleMode?>'
var URGENTMODE_LBL='<?php echo UrgentAlarmMode?>'
var GEOFENCEMODE_LBL='<?php echo geoFenceAlarmMode?>'
var OVERSPEEDMODE_LBL='<?php echo OverSpeedAlarmMode?>'
var BREAKDOWNMODE_LBL='<?php echo BreakDownAlarmMode?>'
var LOSTMODE_LBL='<?php echo LostMode?>';

var RUNNINGSECTION_LBL='<?php echo RunningSection;?>'
var PARKINGSECTION_LBL='<?php echo ParkingSection;?>'
var IDLESECTION_LBL='<?php echo IdleSection;?>'
var URGENTSECTION_LBL='<?php echo UrgentSection;?>'
var OVERSPEEDSECTION_LBL='<?php echo OverSpeedSection;?>'
var GEOFENCESECTION_LBL='<?php echo GeoFenceSection;?>'
var BREAKDOWNSECTION_LBL='<?php echo BreakDownSection;?>'
var LOSTSECTION_LBL='<?php echo LostSection;?>'


var MAP_LBL='<?php echo Map?>';
var TRACKINGREPLAY_LBL='<?php echo TrackingReplay?>';
var EDIT_LBL='<?php echo Edit?>';
var LOCATE_LBL='<?php echo Locate?>';
var SETMILEAGE_LBL='<?php echo SetMileage?>';
var LASTPOSITION_LBL='<?php echo LastMsg?>';