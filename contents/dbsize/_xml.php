<?php

header("Cache-Control: no-cache, must-revalidate");
include_once('../../settings.php');
include_once('../../scripts.php');
include("_start.php");
// connection
include (ROOT_DIR . "/connect/connection.php");

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


// calculate the number of rows
//$result = mysql_query("SELECT COUNT(*) AS count FROM cmps");
//$row = mysql_fetch_array($result, MYSQL_ASSOC);
$count = 1;


// calculate the total pages
if ($count > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}
if ($page > $total_pages)
    $page = $total_pages;
$start = $limit * $page - $limit;
if ($start < 0) {
    $start = 0;
}

// companies query
$SQL = "SELECT table_schema,TABLE_NAME, table_rows, data_length, index_length, 
round(((data_length + index_length) / 1024 / 1024),2) 'Size in MB'
FROM information_schema.TABLES WHERE table_schema = '$prefix$dbname';";

$result = $Conn->query($SQL);
$Conn = null;
// json
// $responce->page = $page;
//       $responce->total = $total_pages;
//       $responce->records = $count;
$i = 0;

$responce = new stdClass();
$c = 0;
$responce->cols[$c++] = constant($module . 'Name');
$responce->cols[$c++] = constant($module . 'Schema');
$responce->cols[$c++] = constant($module . 'TableName');
$responce->cols[$c++] = constant($module . 'TableRows');
$responce->cols[$c++] = constant($module . 'DataLength');
$responce->cols[$c++] = constant($module . 'SizeInMB');
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $responce->rows[$i]['id'] = $i;
    $responce->rows[$i]['cell'] = array(
      $row['table_schema'],
      $row['table_schema'],
      $row['TABLE_NAME'],
      $row['table_rows'],
      $row['data_length'],
      $row['Size in MB']);
    $i++;
}
echo json_encode($responce);
?>