<?php

header("Cache-Control: no-cache, must-revalidate");
header('Content-Type: application/json');
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");



if ((filter_input(INPUT_GET, 'uin') === NULL) or (filter_input(INPUT_GET, 'exclude') === NULL)) {
    die;
}

$uin = filter_input(INPUT_GET, 'uin');
$exclude = filter_input(INPUT_GET, 'exclude');

$settings = $session->get('settings');

$grouping = get_setting('grouping_' . $userid, $settings);

if ($privilege == 1) {
    if ($grouping == 0) {
        $TrackersResult = $session->get('alltrackers');
    } else {
        $TrackersResult = $session->get('trackers');
    }
} else {
    $TrackersResult = $session->get('trackers');
}
$DBHostResult = $session->get('dbhosts');


$TrackerRow = array();
foreach ($TrackersResult as $row) {
    if ($uin == $row['tunit']) {
        $TrackerRow = $row;
        break;
    }
}
if (empty($TrackerRow)) {
    die;
}
$DBHostRow = array();
foreach ($DBHostResult as $row) {
    if ($row['dbhostid'] == $TrackerRow['tdbhost']) {
        $DBHostRow = $row;
        break;
    }
}
if (empty($DBHostRow)) {
    die;
}

$type = $TrackerRow["ttype"];

$trackerDatabase = $TrackerRow["tdbs"];


$trackerConn = new PDO("$engine:host=$DBHostRow[dbhostip];dbname=trk_$trackerDatabase", "$DBHostRow[dbhostuser]", "$DBHostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));



$fdate = ($_GET['fdate'] / 1000);
$tdate = ($_GET['tdate'] / 1000);
$GPSsql = "select 
	`gm_id`,
	`gm_time` ,
	`gm_lat` ,
	`gm_lng` ,
	CAST(`gm_speed` AS DECIMAL(4,0)) as gm_speed ,
	CAST(`gm_ori` AS DECIMAL(4,0)) as gm_ori ,
	`gm_data` ,
	`gm_mileage`
	from `gps_" .
        $trackerDatabase . "`
where `gm_time` BETWEEN  '" . $fdate . "' and '" . $tdate . "'
	 order by gm_time asc ";

$GPSStatment = $trackerConn->query($GPSsql);
$trackerConn = null;
$responce = new stdClass();
$i = 0;
while ($GPSRow = $GPSStatment->fetch(PDO::FETCH_ASSOC)) {
    if ($type == '1' || $type == '2' || $type == '3' || $type == '4') {
        if ($exclude == '1') {
            $checkArray = explode(',', $GPSRow['gm_data']);
            if ($checkArray[0] == '0' || (float) $GPSRow['gm_lat'] == 0 || (float) $GPSRow['gm_lng'] == 0) {
                $exc = true;
            } else {
                $exc = false;
            }
        } else {
            $exc = false;
        }
    } else if ($type == '5') {
        if ($exclude == '1') {
            $checkArray = explode(',', $GPSRow['gm_data']);
            if ($checkArray[0] == '0' || (float) $checkArray[5] > 4 || (float) $checkArray[2] < 4 || (float) $GPSRow['gm_lat'] == 0 || (float) $GPSRow['gm_lng'] == 0) {
                $exc = true;
            } else {
                $exc = false;
            }
        } else {
            $exc = false;
        }
    } else if ($type == '6') {
        if ($exclude == '1') {
            $checkArray = explode('|', $GPSRow['gm_data']);
            if ($checkArray[0] == '0' || (float) $checkArray[1] > 4 || (float) $GPSRow['gm_lat'] == 0 || (float) $GPSRow['gm_lng'] == 0) {
                $exc = true;
            } else {
                $exc = false;
            }
        } else {
            $exc = false;
        }
    } else if ($type == '7') {
        if ($exclude == '1') {
            $checkArray = explode(',', $GPSRow['gm_data']);
            if ($checkArray[0] == '0' || (float) $checkArray[5] > 4 || (float) $checkArray[2] < 4 || (float) $GPSRow['gm_lat'] == 0 || (float) $GPSRow['gm_lng'] == 0) {
                $exc = true;
            } else {
                $exc = false;
            }
        } else {
            $exc = false;
        }
    } else if ($type == '8') {
        if ($exclude == '1') {
            $checkArray = explode(',', $GPSRow['gm_data']);
            if ($checkArray[0] == '0' || (float) $checkArray[5] > 4 || (float) $checkArray[2] < 4 || (float) $GPSRow['gm_lat'] == 0 || (float) $GPSRow['gm_lng'] == 0) {
                $exc = true;
            } else {
                $exc = false;
            }
        } else {
            $exc = false;
        }
    } else if ($type == '9') {
        if ($exclude == '1') {
            $checkArray = explode(',', $GPSRow['gm_data']);
            if ((float) $GPSRow['gm_lat'] == 0 || (float) $GPSRow['gm_lng'] == 0) {
                $exc = true;
            } else {
                $exc = false;
            }
        } else {
            $exc = false;
        }
    }else if ($type == '10') {
        if ($exclude == '1') {
            $checkArray = explode(',', $GPSRow['gm_data']);
            if ((float) $GPSRow['gm_lat'] == 0 || (float) $GPSRow['gm_lng'] == 0) {
                $exc = true;
            } else {
                $exc = false;
            }
        } else {
            $exc = false;
        }
    }
    if ($exc == false) {
        $responce->rows[$i]['cell'] = array(
            "tdrivername:'" . $TrackerRow['tdrivername'] . "' , " .
            "tvehiclereg:'" . $TrackerRow['tvehiclereg'] . "' , " .
            "gm_time:'" . $GPSRow['gm_time'] . "' , " .
            "gm_lat:'" . $GPSRow['gm_lat'] . "' , " .
            "gm_lng:'" . $GPSRow['gm_lng'] . "' , " .
            "gm_address:'' , " .
            "gm_speed:'" . $GPSRow['gm_speed'] . "' , " .
            "gm_ori:'" . $GPSRow['gm_ori'] . "' , " .
            "gm_mileage:'" . $GPSRow['gm_mileage'] . "' , " .
            "gm_data:'" . $GPSRow['gm_data'] . "'  "
        );
    }
    $i++;
}
echo json_encode($responce);
?>