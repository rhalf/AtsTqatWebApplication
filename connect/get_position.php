<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../settings.php");
include_once("../scripts.php");

if (filter_input(INPUT_GET, "uin") === NULL) {
    die;
}
if (filter_input(INPUT_GET, "type") === NULL) {
    die;
}

$id = filter_input(INPUT_GET, "uin");
$type = filter_input(INPUT_GET, "type");

$TrackersResult = $session->get('trackers');
$DBHostResult = $session->get('dbhosts');

$TrackerRow = array();
foreach ($TrackersResult as $row) {
    if ($id == $row['tunit']) {
        $TrackerRow = $row;
        break;
    }
}

if (empty($TrackerRow)) {
    die;
}

$dbHostRow = array();
foreach ($DBHostResult as $row) {
    if ($row['dbhostid'] == $TrackerRow['tdbhost']) {
        $dbHostRow = $row;
        break;
    }
}
if (empty($dbHostRow)) {
    die;
}

$trackerConn = new PDO("$engine:host=$dbHostRow[dbhostip];dbname=trk_$TrackerRow[tdbs]", "$dbHostRow[dbhostuser]", "$dbHostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$trackerDatabase = $TrackerRow["tdbs"];

$sql = "select
	`gm_time` ,
	`gm_lat` ,
	`gm_lng` ,
	`gm_speed` ,
	`gm_ori` ,
	`gm_mileage`,
	`gm_data`
	from `gps_{$trackerDatabase}` order by gm_time desc limit 0, 1;";

$Statment = $trackerConn->query($sql);
while ($row = $Statment->fetch(PDO::FETCH_ASSOC)) {
    $variable = "{" .
            "tdrivername:'" . $TrackerRow['tdrivername'] . "' , " .
            "tvehiclereg:'" . $TrackerRow['tvehiclereg'] . "' , " .
            "gm_unit:'" . $id . "' , " .
            "gm_time:'" . $row['gm_time'] . "' , " .
            "gm_lat:'" . $row['gm_lat'] . "' , " .
            "gm_lng:'" . $row['gm_lng'] . "' , " .
            "gm_address:'' , " .
            "gm_speed:'" . $row['gm_speed'] . "' , " .
            "gm_ori:'" . $row['gm_ori'] . "' , " .
            "gm_mileage:'" . $row['gm_mileage'] . "' , " .
            "gm_data:'" . $row['gm_data'] . "'  " .
            "}";
    echo $variable;
}
$trackerConn = null;
?>