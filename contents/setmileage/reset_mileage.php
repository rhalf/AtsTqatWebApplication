<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
//include("connect_master_db.php");


$uin = $_GET["un"];
$trackersql = "select `tdrivername`,`tvehiclereg`,`tmileageInit`,`tdbhost`,`tdbs` from `trks` where tunit='$uin'";
$trackerStatment = $CompanyConn->query($trackersql);
$trackerdata = $trackerStatment->fetch(PDO::FETCH_ASSOC);
//$CompanyConn=null;

include ("connection.php");
$get_tracker_host = "select * from `dbhosts` where dbhostid='" . $trackerdata['tdbhost'] .
    "'";
$get_tracker_host_Statment = $Conn->query($get_tracker_host);
$Conn = null;

$get_tracker_host_row = $get_tracker_host_Statment->fetch(PDO::FETCH_ASSOC);


$trackerConn = new PDO("$engine:host=$get_tracker_host_row[dbhostname];dbname=trk_$trackerdata[tdbs]", "$get_tracker_host_row[dbhostuser]", "$get_tracker_host_row[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));



$trackerDatabase = $trackerdata["tdbs"];
$MileageSql = "select `gm_mileage` from `gps_$trackerDatabase` 
	order by gm_id desc limit 0, 1;";

$MileageStatment = $trackerConn->query($MileageSql);
$MileageResult = $MileageStatment->fetch(PDO::FETCH_ASSOC);
$trackerConn = null;
// get values

$currMileage = $MileageResult['gm_mileage'];
if ($currMileage == '') {
    $ResetMileage = '0';
} else {
    $ResetMileage = $currMileage;
}

include("connect_master_db.php");

$GPSsql = "UPDATE `trks` SET 
`tmileagereset`='$ResetMileage',
`tmileageInit`='0'  
	where tunit=$uin;";

$CompanyConn->query($GPSsql);

echo "One value edited";
$CompanyConn = null;


include ("connection.php");
$GPSsql = "UPDATE `trks` SET 
`tmileagereset`='$ResetMileage',
`tmileageInit`='0' 
	where tunit=$uin;";

$Conn->query($GPSsql);
$Conn = null;
?>