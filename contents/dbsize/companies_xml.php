<?php

header("Cache-Control: no-cache, must-revalidate");
include_once('../../settings.php');
include_once('../../scripts.php');
include("_start.php");
$CompaniesResult = $session->get('cmps');
$DBHostsResult = $session->get('dbhosts');
// connection
//include (ROOT_DIR."/connect/connection.php");

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
//$result = $Conn->query("SELECT COUNT(*) AS count FROM cmps");
//$row = $result->fetch(PDO::FETCH_ASSOC);
//$count = $row['count'] * 6;
$count = count($CompaniesResult) * 6;

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

// companies query
$i = 0;
//$SQL = "SELECT `cmpname`,`cmpdbname`,`cmphost` FROM `cmps`;";
//$result = $Conn->query($SQL);
//$Conn = null;
//while ($row = $result->fetch(PDO::FETCH_ASSOC)){
//include (ROOT_DIR."/connect/connection.php");

$responce = new stdClass();
$c = 0;
$responce->cols[$c++] = constant($module . 'Name');
$responce->cols[$c++] = constant($module . 'Schema');
$responce->cols[$c++] = constant($module . 'TableName');
$responce->cols[$c++] = constant($module . 'TableRows');
$responce->cols[$c++] = constant($module . 'DataLength');
$responce->cols[$c++] = constant($module . 'SizeInMB');
foreach ($CompaniesResult as $row) {
    //$get_company_host = "select * from `dbhosts` where `dbhostid`='" . $row['cmphost'] .
    //    "'";
    //$get_company_host_query = $Conn->query($get_company_host);
    //$get_company_host_row = $get_company_host_query->fetch(PDO::FETCH_ASSOC);
    foreach ($DBHostsResult as $dbrow) {
        if ($row['cmphost'] == $dbrow['dbhostid']) {
            $dbhostRow = $dbrow;
        }
    }

    $companyconn = new PDO("$engine:host=$dbhostRow[dbhostip];", "$dbhostRow[dbhostuser]", "$dbhostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND =>
      "SET NAMES utf8"));


    // companies query
    $SQLdbSize = "SELECT table_schema,TABLE_NAME, table_rows, data_length, index_length, 
round(((data_length + index_length) / 1024 / 1024),2) 'Size in MB'
FROM information_schema.TABLES WHERE table_schema = 'cmp_" . $row["cmpdbname"] .
        "'";
    $resultdbSize = $companyconn->query($SQLdbSize);
    $companyconn = null;
    // json
    //  $responce->page = $page;
    //       $responce->total = $total_pages;
    //       $responce->records = $count;

    while ($rowdbSize = $resultdbSize->fetch(PDO::FETCH_ASSOC)) {
        $responce->rows[$i]['id'] = $i;
        $responce->rows[$i]['cell'] = array(
          $row["cmpname"],
          $rowdbSize['table_schema'],
          $rowdbSize['TABLE_NAME'],
          $rowdbSize['table_rows'],
          $rowdbSize['data_length'],
          $rowdbSize['Size in MB']);
        $i++;
    }
}
//$Conn = null;
echo json_encode($responce);
?>