<?php

error_reporting(0);
header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once ("../../scripts.php");
include("_start.php");
$Result = $session->get('dbhosts');

$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if (!$sidx)
    $sidx = 1;


$totalrows = isset($_GET['totalrows']) ? $_GET['totalrows'] : false;
if ($totalrows) {
    $limit = $totalrows;
}

$count = count($Result);

// calculate the total pages
if ($count > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}
if ($page > $total_pages) {
    $page = $total_pages;
}
$start = $limit * $page - $limit;
if ($start < 0) {
    $start = 0;
}
if ($sord == 'asc') {
    $sord = SORT_ASC;
} else if ($sord == 'desc') {
    $sord = SORT_DESC;
}
sort_by($sidx, $Result, $sord);
// json
$responce = new stdClass();
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$c = 0;
$responce->cols[$c++] = 'act';
$responce->cols[$c++] = 'dbhostid';
$responce->cols[$c++] = constant($module . "HostName");
$responce->cols[$c++] = constant($module . "IPAddress");
$responce->cols[$c++] = constant($module . "HostUser");

$i = 0;
foreach ($Result as $row) {
    $responce->rows[$i]['id'] = $row['dbhostid'];
    $responce->rows[$i]['cell'] = array(
      '',
      $row['dbhostid'],
      $row['dbhostname'],
      $row['dbhostip'],
      $row['dbhostuser']);
    $i++;
}
echo json_encode($responce);
?>