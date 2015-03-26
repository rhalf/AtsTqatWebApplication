<?php

header("Cache-Control: no-cache, must-revalidate");
header('Content-Type: application/json');
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
if (!is_ajax()) {
    die;
}
if ($privilege != 1) {
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

$TrackersResult = $session->get('alltrackers');
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


$DBHostsResult = $session->get('dbhosts');
$CmpsResult = $session->get('cmps');

sort_by($sidx, $TrackersResult, $sord);
$TrackersArray = array_slice($TrackersResult, $start, $limit);

$responce = new stdClass();
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$responce->cols[0] = 'act';
$c = 0;
$responce->cols[$c++] = 'uid';
$responce->cols[$c++] = constant($module . 'Company');
$responce->cols[$c++] = constant($module . 'VehicleReg');
$responce->cols[$c++] = constant($module . 'DriverName');
$responce->cols[$c++] = constant($module . 'Owner');
$responce->cols[$c++] = constant($module . 'Model');
$responce->cols[$c++] = constant($module . 'Unit');
$responce->cols[$c++] = constant($module . 'SimNo');
$responce->cols[$c++] = constant($module . 'UnitPassword');
$responce->cols[$c++] = constant($module . 'Image');
$responce->cols[$c++] = constant($module . 'Provider');
$responce->cols[$c++] = constant($module . 'Type');
$responce->cols[$c++] = constant($module . 'DBHost');
$responce->cols[$c++] = constant($module . 'CreateDate');
$responce->cols[$c++] = constant($module . 'DBName');
$responce->cols[$c++] = constant($module . 'Inputs');
$responce->cols[$c++] = constant($module . 'SpeedLimit');
$responce->cols[$c++] = constant($module . 'MileageLimit');
$responce->cols[$c++] = constant($module . 'VehicleRegExpiry');
$responce->cols[$c++] = constant($module . 'TrackerExpiry');
$responce->cols[$c++] = constant($module . 'MileageInit');
$responce->cols[$c++] = constant($module . 'IdlingTime');
$responce->cols[$c++] = constant($module . 'Note');
$i = 0;

foreach ($TrackersResult as $row) {
    $responce->rows[$i]['id'] = $row['tid'];

    $responce->rows[$i]['cell'] = array('', $row['tid'], search_AssocArray($CmpsResult, 'cmpdbname', $row['tcmp'], 'cmpdisplayname'), $row['tvehiclereg'], $row['tdrivername'], $row['townername'], $row['tvehiclemodel'], $row['tunit'], $row['tsimno'], $row['tunitpassword'], from_array_keys($Providers, $row['tprovider']), from_array_keys($devices_Type, $row['ttype']), search_AssocArray($DBHostsResult, 'dbhostid', $row['tdbhost'], 'dbhostname'), $row['tcreatedate'], $row['tdbs'], $row['tinputs'], $row['tspeedlimit'], $row['tmileagelimit'], $row['tvehicleregexpiry'], $row['ttrackerexpiry'], $row['tmileageInit'], $row['tidlingtime'], $row['tnote']);
    $i++;
}


echo json_encode($responce);
?>