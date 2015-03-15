<?php

header("Cache-Control: no-cache, must-revalidate");
header('Content-Type: application/json');
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if (!isset($_GET['id'])) {
    die;
}
$id = $_GET["id"];

include(ROOT_DIR . "/connect/connection.php");

$TrackersResult = $session->get('trackers');
$DBHostResult = $session->get('dbhosts');

foreach ($TrackersResult as $row) {
    if ($id == $row['tunit']) {
        $TrackerRow = $row;
    }
}

foreach ($DBHostResult as $row) {
    if ($row['dbhostid'] == $TrackerRow['tdbhost']) {
        $DBHostRow = $row;
    }
}
$trackerDatabase = $TrackerRow["tdbs"];
$type = $TrackerRow["ttype"];

$trackerConn = new PDO("$engine:host=$DBHostRow[dbhostip];dbname=trk_$trackerDatabase", "$DBHostRow[dbhostuser]", "$DBHostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


$fdate = ($_GET['fdate'] / 1000);
$tdate = ($_GET['tdate'] / 1000);


$page = $_REQUEST['page']; // get the requested page
$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord = $_REQUEST['sord']; // get the direction
if (!$sidx) {
    $sidx = 1;
}


$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
if ($totalrows) {
    $limit = $totalrows;
}


$Statment = $trackerConn->query("SELECT COUNT(*) AS count FROM " . ".gps_" . $trackerDatabase . " where `gm_time` BETWEEN  '" . $fdate . "' and '" . $tdate . "' ");
$row = $Statment->fetch(PDO::FETCH_ASSOC);
$count = $row['count'];


if ($count > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}
if ($page > $total_pages) {
    $page = $total_pages;
}
$start = $limit * $page - $limit; // do not put $limit*($page - 1)
if ($start < 0) {
    $start = 0;
}


$GPSsql = "select
`gm_id`,
`gm_time` ,
`gm_lat` ,
`gm_lng` ,
`gm_speed` ,
`gm_ori` ,
`gm_mileage`,
`gm_data`
from `gps_" . $trackerDatabase . "` where `gm_time` BETWEEN  '" . $fdate . "' and '" . $tdate . "'ORDER BY $sidx $sord LIMIT $start , $limit ";




$GPSStatment = $trackerConn->query($GPSsql);
$trackerConn = null;

$responce = new stdClass();
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

$c = 0;
$responce->cols[$c++] = Time;
$responce->cols[$c++] = Lat;
$responce->cols[$c++] = Long;
$responce->cols[$c++] = Address;
$responce->cols[$c++] = Speed;
$responce->cols[$c++] = Direction;
$responce->cols[$c++] = Signal;
$responce->cols[$c++] = State;
$responce->cols[$c++] = Power;
$responce->cols[$c++] = Input1;
$responce->cols[$c++] = Input2;
$responce->cols[$c++] = Input3;
$responce->cols[$c++] = Input4;
$responce->cols[$c++] = Input5;
$responce->cols[$c++] = Output1;
$responce->cols[$c++] = Output2;
$responce->cols[$c++] = Output3;
$responce->cols[$c++] = Output4;
$responce->cols[$c++] = Output5;
$responce->cols[$c++] = AD1;
$responce->cols[$c++] = AD2;
$responce->cols[$c++] = Geofence;
$responce->cols[$c++] = Mileage;
$responce->cols[$c++] = Interval;
$responce->cols[$c++] = Overspeed;
$responce->cols[$c++] = GPSQSignal;
$responce->cols[$c++] = GSMQSignal;


$i = 0;
while ($GPSRow = $GPSStatment->fetch(PDO::FETCH_ASSOC)) {

    if ($type == '1' || $type == '2' || $type == '3' || $type == '4') {
        $gm_time = setTime($GPSRow['gm_time'], $timezone);
        $gm_lat = $GPSRow['gm_lat'];
        $gm_lng = $GPSRow['gm_lng'];
        $gm_address = '';
        $gm_speed = $GPSRow['gm_speed'];
        $gm_ori = $GPSRow['gm_ori'];
        $gm_mileage = $GPSRow['gm_mileage'];
        $gm_overspeed = '';
        $gm_geofence = '';

        $DataArray = explode(',', $GPSRow['gm_data']);

        $gm_input5 = 'n/a';
        $gm_output2 = 'n/a';
        $gm_output3 = 'n/a';
        $gm_output4 = 'n/a';
        $gm_output5 = 'n/a';
        $gm_AD1 = 'n/a';
        $gm_AD2 = 'n/a';

        switch ($DataArray[0]) {
            case '0':$gm_signal = Off;
                break;
            case '1':$gm_signal = On;
                break;
        };
        switch ($DataArray[1]) {
            case '1':$gm_power = Normal;
                break;
            case '2':$gm_power = Off;
                break;
            case '3':$gm_power = Low;
                break;
            case '4':$gm_power = Error;
                break;
        };
        switch ($DataArray[2]) {
            case '1':$gm_state = High;
                break;
            case '2':$gm_state = Short;
                break;
            case '3':$gm_state = Normal;
                break;
            case '4':$gm_state = Error;
                break;
        };
        $gm_interval = $DataArray[3];
        $gm_GPSQSignal = $DataArray[4];
        $gm_GSMQSignal = $DataArray[5];

        switch ($DataArray[9]) {
            case '0':$gm_output1 = Off;
                break;
            case '1':$gm_output1 = On;
                break;
        };
        switch ($DataArray[14]) {
            case '0':$gm_input1 = Off;
                break;
            case '1':$gm_input1 = On;
                break;
        };

        switch ($DataArray[15]) {
            case '0':$gm_input2 = Off;
                break;
            case '1':$gm_input2 = On;
                break;
        };
        switch ($DataArray[16]) {
            case '0':$gm_input3 = Off;
                break;
            case '1':$gm_input3 = On;
                break;
        };
        switch ($DataArray[17]) {
            case '0':$gm_input4 = Off;
                break;
            case '1':$gm_input4 = On;
                break;
        };
        $responce->rows[$i]['id'] = $GPSRow['gm_id'];
        $responce->rows[$i]['cell'] = array(
          $gm_time,
          $gm_lat,
          $gm_lng,
          $gm_address,
          $gm_speed,
          $gm_ori,
          $gm_signal,
          $gm_state,
          $gm_power,
          $gm_input1,
          $gm_input2,
          $gm_input3,
          $gm_input4,
          $gm_input5,
          $gm_output1,
          $gm_output2,
          $gm_output3,
          $gm_output4,
          $gm_output5,
          $gm_AD1,
          $gm_AD2,
          $gm_geofence,
          $gm_mileage,
          $gm_interval,
          $gm_overspeed,
          $gm_GPSQSignal,
          $gm_GSMQSignal,
        );
        $i++;
    } else if ($type == '5') {
        $gm_time = setTime($GPSRow['gm_time'], $timezone);
        $gm_lat = $GPSRow['gm_lat'];
        $gm_lng = $GPSRow['gm_lng'];
        $gm_address = '';
        $gm_speed = $GPSRow['gm_speed'];
        $gm_ori = $GPSRow['gm_ori'];
        $gm_mileage = $GPSRow['gm_mileage'];
        $gm_overspeed = '';
        $gm_geofence = '';

        $DataArray = explode(',', $GPSRow['gm_data']);

        $gm_state = $DataArray[1];
        $gm_GPSQSignal = $DataArray[2];
        $gm_GSMQSignal = $DataArray[3];
        $gm_AD1 = $DataArray[25];
        $gm_power = 'n/a';
        $gm_input3 = 'n/a';
        $gm_input4 = 'n/a';
        $gm_input5 = 'n/a';
        $gm_output2 = 'n/a';
        $gm_output3 = 'n/a';
        $gm_output4 = 'n/a';
        $gm_output5 = 'n/a';
        $gm_AD2 = 'n/a';
        $gm_interval = 'n/a';
        switch ($DataArray[0]) {
            case '0':$gm_signal = Off;
                break;
            case '1':$gm_signal = On;
                break;
        };
        switch ($DataArray[17]) {
            case '0':$gm_input1 = Off;
                break;
            case '1':$gm_input1 = On;
                break;
        };
        switch ($DataArray[18]) {
            case '0':$gm_input2 = Off;
                break;
            case '1':$gm_input2 = On;
                break;
        };
        switch ($DataArray[9]) {
            case '1':$gm_output1 = Off;
                break;
            case '0':$gm_output1 = On;
                break;
        };
        $responce->rows[$i]['id'] = $GPSRow['gm_id'];
        $responce->rows[$i]['cell'] = array(
          $gm_time,
          $gm_lat,
          $gm_lng,
          $gm_address,
          $gm_speed,
          $gm_ori,
          $gm_signal,
          $gm_state,
          $gm_power,
          $gm_input1,
          $gm_input2,
          $gm_input3,
          $gm_input4,
          $gm_input5,
          $gm_output1,
          $gm_output2,
          $gm_output3,
          $gm_output4,
          $gm_output5,
          $gm_AD1,
          $gm_AD2,
          $gm_geofence,
          $gm_mileage,
          $gm_interval,
          $gm_overspeed,
          $gm_GPSQSignal,
          $gm_GSMQSignal,
        );
        $i++;
    } else if ($type == '6') {
        $gm_time = setTime($GPSRow['gm_time'], $timezone);
        $gm_lat = $GPSRow['gm_lat'];
        $gm_lng = $GPSRow['gm_lng'];
        $gm_address = '';
        $gm_speed = $GPSRow['gm_speed'];
        $gm_ori = $GPSRow['gm_ori'];
        $gm_mileage = $GPSRow['gm_mileage'];
        $gm_overspeed = '';
        $gm_geofence = '';

        $ElemInps = $TrackerRow['tinputs'];
        $DataArray = explode('|', $GPSRow['gm_data']);
        $gm_state = $DataArray[8];
        $gm_GSMQSignal = $DataArray[6];
        $gmAD = explode(',', $DataArray[4]);
        $gm_AD1 = $gmAD[0];
        $gm_AD2 = $gmAD[1];
        $gm_power = 'n/a';
        $gm_interval = 'n/a';
        $gm_GPSQSignal = 'n/a';
        switch ($DataArray[0]) {
            case '0':$gm_signal = Off;
                break;
            case '1':$gm_signal = On;
                break;
        };
        switch (substr($DataArray[3], 7, 1)) {
            case '0':$gm_input1 = Off;
                break;
            case '1':$gm_input1 = On;
                break;
        };
        //  check inputs
        if ($ElemInps == '25') {
            switch (substr($DataArray[3], 6, 1)) {
                case '0':$gm_input5 = On;
                    break;
                case '1':$gm_input5 = Off;
                    break;
            };

            switch (substr($DataArray[3], 3, 1)) {
                case '0':$gm_input2 = Off;
                    break;
                case '1':$gm_input2 = On;
                    break;
            };
        } else {
            switch (substr($DataArray[3], 6, 1)) {
                case '0':$gm_input2 = On;
                    break;
                case '1':$gm_input2 = Off;
                    break;
            };

            switch (substr($DataArray[3], 3, 1)) {
                case '0':$gm_input5 = Off;
                    break;
                case '1':$gm_input5 = On;
                    break;
            };
        }// end check inputs

        switch (substr($DataArray[3], 5, 1)) {
            case '0':$gm_input3 = On;
                break;
            case '1':$gm_input3 = Off;
                break;
        };
        switch (substr($DataArray[3], 4, 1)) {
            case '0':$gm_input4 = Off;
                break;
            case '1':$gm_input4 = On;
                break;
        };
        switch (substr($DataArray[3], 15, 1)) {
            case '0':$gm_output1 = On;
                break;
            case '1':$gm_output1 = Off;
                break;
        };
        switch (substr($DataArray[3], 14, 1)) {
            case '0':$gm_output2 = On;
                break;
            case '1':$gm_output2 = Off;
                break;
        };
        switch (substr($DataArray[3], 13, 1)) {
            case '0':$gm_output3 = On;
                break;
            case '1':$gm_output3 = Off;
                break;
        };
        switch (substr($DataArray[3], 12, 1)) {
            case '0':$gm_output4 = On;
                break;
            case '1':$gm_output4 = Off;
                break;
        };
        switch (substr($DataArray[3], 11, 1)) {
            case '0':$gm_output5 = On;
                break;
            case '1':$gm_output5 = Off;
                break;
        };
        $responce->rows[$i]['id'] = $GPSRow['gm_id'];
        $responce->rows[$i]['cell'] = array(
          $gm_time,
          $gm_lat,
          $gm_lng,
          $gm_address,
          $gm_speed,
          $gm_ori,
          $gm_signal,
          $gm_state,
          $gm_power,
          $gm_input1,
          $gm_input2,
          $gm_input3,
          $gm_input4,
          $gm_input5,
          $gm_output1,
          $gm_output2,
          $gm_output3,
          $gm_output4,
          $gm_output5,
          $gm_AD1,
          $gm_AD2,
          $gm_geofence,
          $gm_mileage,
          $gm_interval,
          $gm_overspeed,
          $gm_GPSQSignal,
          $gm_GSMQSignal,
        );
        $i++;
    } else if ($type == '7') {
        $gm_time = setTime($GPSRow['gm_time'], $timezone);
        $gm_lat = $GPSRow['gm_lat'];
        $gm_lng = $GPSRow['gm_lng'];
        $gm_address = '';
        $gm_speed = $GPSRow['gm_speed'];
        $gm_ori = $GPSRow['gm_ori'];
        $gm_mileage = $GPSRow['gm_mileage'];
        $gm_overspeed = '';
        $gm_geofence = '';

        $DataArray = explode(',', $GPSRow['gm_data']);

        $gm_state = $DataArray[1];
        $gm_GPSQSignal = $DataArray[2];
        $gm_GSMQSignal = $DataArray[3];
        $gm_AD1 = $DataArray[25];
        $gm_power = 'n/a';
        $gm_input2 = 'n/a';
        $gm_input3 = 'n/a';
        $gm_input4 = 'n/a';
        $gm_input5 = 'n/a';
        $gm_output1 = 'n/a';
        $gm_output2 = 'n/a';
        $gm_output3 = 'n/a';
        $gm_output4 = 'n/a';
        $gm_output5 = 'n/a';
        $gm_AD2 = 'n/a';
        $gm_interval = 'n/a';
        switch ($DataArray[0]) {
            case '0':$gm_signal = Off;
                break;
            case '1':$gm_signal = On;
                break;
        };
        switch ($DataArray[17]) {
            case '0':$gm_input1 = Off;
                break;
            case '1':$gm_input1 = On;
                break;
        };
        $responce->rows[$i]['id'] = $GPSRow['gm_id'];
        $responce->rows[$i]['cell'] = array(
          $gm_time,
          $gm_lat,
          $gm_lng,
          $gm_address,
          $gm_speed,
          $gm_ori,
          $gm_signal,
          $gm_state,
          $gm_power,
          $gm_input1,
          $gm_input2,
          $gm_input3,
          $gm_input4,
          $gm_input5,
          $gm_output1,
          $gm_output2,
          $gm_output3,
          $gm_output4,
          $gm_output5,
          $gm_AD1,
          $gm_AD2,
          $gm_geofence,
          $gm_mileage,
          $gm_interval,
          $gm_overspeed,
          $gm_GPSQSignal,
          $gm_GSMQSignal,
        );
        $i++;
    } else if ($type == '8') {
        $gm_time = setTime($GPSRow['gm_time'], $timezone);
        $gm_lat = $GPSRow['gm_lat'];
        $gm_lng = $GPSRow['gm_lng'];
        $gm_address = '';
        $gm_speed = $GPSRow['gm_speed'];
        $gm_ori = $GPSRow['gm_ori'];
        $gm_mileage = $GPSRow['gm_mileage'];
        $gm_overspeed = '';
        $gm_geofence = '';
        $ElemInps = $TrackerRow['tinputs'];
        $DataArray = explode(',', $GPSRow['gm_data']);

        $gm_state = $DataArray[1];
        $gm_GPSQSignal = $DataArray[2];
        $gm_GSMQSignal = $DataArray[3];
        $gm_AD1 = $DataArray[25];
        $gm_power = 'n/a';
        $gm_input3 = 'n/a';
        $gm_input4 = 'n/a';
        $gm_input5 = 'n/a';
        $gm_output2 = 'n/a';
        $gm_output3 = 'n/a';
        $gm_output4 = 'n/a';
        $gm_output5 = 'n/a';
        $gm_AD2 = 'n/a';
        $gm_interval = 'n/a';
        switch ($DataArray[0]) {
            case '0':$gm_signal = Off;
                break;
            case '1':$gm_signal = On;
                break;
        };
        switch ($DataArray[17]) {
            case '0':$gm_input1 = Off;
                break;
            case '1':$gm_input1 = On;
                break;
        };
        //  check inputs
        if ($ElemInps == '23') {
            switch ($DataArray[19]) {
                case '1':$gm_input2 = On;
                    break;
                case '0':$gm_input2 = Off;
                    break;
            };

            switch ($DataArray[18]) {
                case '0':$gm_input3 = Off;
                    break;
                case '1':$gm_input3 = On;
                    break;
            };
        } else {
            switch ($DataArray[18]) {
                case '1':$gm_input2 = On;
                    break;
                case '0':$gm_input2 = Off;
                    break;
            };

            switch ($DataArray[19]) {
                case '0':$gm_input3 = Off;
                    break;
                case '1':$gm_input3 = On;
                    break;
            };
        }// end check inputs
        switch ($DataArray[9]) {
            case '1':$gm_output1 = Off;
                break;
            case '0':$gm_output1 = On;
                break;
        };
        switch ($DataArray[8]) {
            case '1':$gm_output2 = Off;
                break;
            case '0':$gm_output2 = On;
                break;
        };
        switch ($DataArray[7]) {
            case '1':$gm_output3 = Off;
                break;
            case '0':$gm_output3 = On;
                break;
        };
        $responce->rows[$i]['id'] = $GPSRow['gm_id'];
        $responce->rows[$i]['cell'] = array(
          $gm_time,
          $gm_lat,
          $gm_lng,
          $gm_address,
          $gm_speed,
          $gm_ori,
          $gm_signal,
          $gm_state,
          $gm_power,
          $gm_input1,
          $gm_input2,
          $gm_input3,
          $gm_input4,
          $gm_input5,
          $gm_output1,
          $gm_output2,
          $gm_output3,
          $gm_output4,
          $gm_output5,
          $gm_AD1,
          $gm_AD2,
          $gm_geofence,
          $gm_mileage,
          $gm_interval,
          $gm_overspeed,
          $gm_GPSQSignal,
          $gm_GSMQSignal,
        );
        $i++;
    } else if ($type == '9') {
        $gm_time = setTime($GPSRow['gm_time'], $timezone);
        $gm_lat = $GPSRow['gm_lat'];
        $gm_lng = $GPSRow['gm_lng'];
        $gm_address = '';
        $gm_speed = $GPSRow['gm_speed'];
        $gm_ori = $GPSRow['gm_ori'];
        $gm_mileage = $GPSRow['gm_mileage'];
        $gm_overspeed = '';
        $gm_geofence = '';

        $DataArray = explode(',', $GPSRow['gm_data']);

        if ($DataArray[2] == '81') {
            $gm_input1 = On;
        } else {
            $gm_input1 = Off;
        };

        $gm_state = $DataArray[2];
        $gm_GPSQSignal = 'n/a';
        $gm_GSMQSignal = 'n/a';
        $gm_AD1 = 'n/a';
        $gm_power = 'n/a';
        $gm_input3 = 'n/a';
        $gm_input4 = 'n/a';
        $gm_input5 = 'n/a';
        $gm_output2 = 'n/a';
        $gm_output3 = 'n/a';
        $gm_output4 = 'n/a';
        $gm_output5 = 'n/a';
        $gm_AD2 = 'n/a';
        $gm_interval = 'n/a';

        if (($gm_lat) !== 0 && $gm_lng !== 0) {
            $gm_signal = On;
        } else {
            $gm_signal = Off;
        };

        switch (substr($DataArray[1], 1, 1)) {
            case '0':$gm_input2 = Off;
                break;
            case '1':$gm_input2 = On;
                break;
        };

        switch (substr($DataArray[1], 0, 1)) {
            case '1':$gm_output1 = On;
                break;
            case '0':$gm_output1 = Off;
                break;
        };
        $responce->rows[$i]['id'] = $GPSRow['gm_id'];
        $responce->rows[$i]['cell'] = array(
          $gm_time,
          $gm_lat,
          $gm_lng,
          $gm_address,
          $gm_speed,
          $gm_ori,
          $gm_signal,
          $gm_state,
          $gm_power,
          $gm_input1,
          $gm_input2,
          $gm_input3,
          $gm_input4,
          $gm_input5,
          $gm_output1,
          $gm_output2,
          $gm_output3,
          $gm_output4,
          $gm_output5,
          $gm_AD1,
          $gm_AD2,
          $gm_geofence,
          $gm_mileage,
          $gm_interval,
          $gm_overspeed,
          $gm_GPSQSignal,
          $gm_GSMQSignal,
        );
        $i++;
    }
}
echo json_encode($responce);
?>