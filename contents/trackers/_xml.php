<?php

header("Cache-Control: no-cache, must-revalidate");
header('Content-Type: application/json');
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
if (!is_ajax()) {
    die;
}

$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if (!$sidx) {
    $sidx = 1;
}


$totalrows = isset($_GET['totalrows']) ? $_GET['totalrows'] : false;
if ($totalrows) {
    $limit = $totalrows;
}
if ($privilege == 1) {
    $DBHostsResult = $session->get('dbhosts');
}
$TrackersResult = $session->get('trackers');
$count = count(trackers_array($TrackersResult, $userid, $privilege));


// calculate the total pages for the query
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
if ($sord == 'asc') {
    $sord = SORT_ASC;
} else if ($sord == 'desc') {
    $sord = SORT_DESC;
}
$TrackersArray = trackers_array($TrackersResult, $userid, $privilege);
sort_by($sidx, $TrackersArray, $sord);
$TrackersArray = array_slice($TrackersArray, $start, $limit);

$responce = new stdClass();
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$c = 0;
$responce->cols[$c++] = 'act';
$responce->cols[$c++] = 'tid';
$responce->cols[$c++] = constant($module . 'VehicleReg');
$responce->cols[$c++] = constant($module . 'DriverName');
$responce->cols[$c++] = constant($module . 'Owner');
$responce->cols[$c++] = constant($module . 'Model');
$responce->cols[$c++] = constant($module . 'Unit');
$responce->cols[$c++] = constant($module . 'SimNo');
if ($privilege == 1) {
    $responce->cols[$c++] = constant($module . 'UnitPassword');
    $responce->cols[$c++] = constant($module . 'Provider');
    $responce->cols[$c++] = constant($module . 'Type');
    $responce->cols[$c++] = constant($module . 'DBHost');
    $responce->cols[$c++] = constant($module . 'CreateDate');
    $responce->cols[$c++] = constant($module . 'DBName');
    $responce->cols[$c++] = constant($module . 'Inputs');
}
$responce->cols[$c++] = constant($module . 'SpeedLimit');
$responce->cols[$c++] = constant($module . 'MileageLimit');
$responce->cols[$c++] = constant($module . 'VehicleRegExpiry');
$responce->cols[$c++] = constant($module . 'TrackerExpiry');
$responce->cols[$c++] = constant($module . 'MileageInit');
$responce->cols[$c++] = constant($module . 'IdlingTime');
$responce->cols[$c++] = constant($module . 'Note');
$i = 0;

foreach ($TrackersArray as $row) {
    $responce->rows[$i]['id'] = $row['tid'];
    if ($privilege == 1) {
        $responce->rows[$i]['cell'] = array('', $row['tid'], $row['tvehiclereg'], $row['tdrivername'], $row['townername'], $row['tvehiclemodel'], $row['tunit'], $row['tsimno'], $row['tunitpassword'], from_array_keys($Providers, $row['tprovider']), from_array_keys($devices_Type, $row['ttype']), search_AssocArray($DBHostsResult, 'dbhostid', $row['tdbhost'], 'dbhostname'), $row['tcreatedate'], $row['tdbs'], $row['tinputs'], $row['tspeedlimit'], $row['tmileagelimit'], $row['tvehicleregexpiry'], $row['ttrackerexpiry'], $row['tmileageInit'], $row['tidlingtime'], $row['tnote']);
    } else {
        $responce->rows[$i]['cell'] = array('', $row['tid'], $row['tvehiclereg'], $row['tdrivername'], $row['townername'], $row['tvehiclemodel'], $row['tunit'], $row['tsimno'], $row['tspeedlimit'], $row['tmileagelimit'], $row['tvehicleregexpiry'], $row['ttrackerexpiry'], $row['tmileageInit'], $row['tidlingtime'], $row['tnote']);
    }

    $i++;
}


echo json_encode($responce);
?>