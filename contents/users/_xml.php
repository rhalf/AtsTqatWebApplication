<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
header('Content-Type: application/json');

if (!is_ajax()) {
    die;
}

if ((filter_input(INPUT_GET, 'page') === NULL ) or
        (filter_input(INPUT_GET, 'rows') === NULL ) or
        (filter_input(INPUT_GET, 'sord') === NULL )) {
    die;
}


$page = filter_input(INPUT_GET, 'page'); // get the requested page
$limit = filter_input(INPUT_GET, 'rows'); // get how many rows we want to have into the grid

$sord = filter_input(INPUT_GET, 'sord'); // get the direction
if (filter_input(INPUT_GET, 'sidx') === NULL) {
    $sidx = 1;
} else {
    $sidx = filter_input(INPUT_GET, 'sidx'); // get index row - i.e. user click to sort  
}

$totalrows = filter_input(INPUT_GET, 'totalrows') !== NULL ? filter_input(INPUT_GET, 'totalrows') : false;
if ($totalrows) {
    $limit = $totalrows;
}


$UsersResult = $session->get('users');
$usersArray = get_allUsers($UsersResult, $userid, $privilege);
$count = count($usersArray);

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

sort_by($sidx, $usersArray, $sord);
$usersArray = array_slice($usersArray, $start, $limit);

// json
$responce = new stdClass();
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$c = 0;
$responce->cols[$c++] = 'act';
$responce->cols[$c++] = 'uid';
$responce->cols[$c++] = constant($module . 'UserName');
$responce->cols[$c++] = constant($module . 'Email');
$responce->cols[$c++] = constant($module . 'Parent');
$responce->cols[$c++] = constant($module . 'Privilege');
$responce->cols[$c++] = constant($module . 'TimeZone');
$responce->cols[$c++] = constant($module . 'DateAdded');
$responce->cols[$c++] = constant($module . 'ExpireDate');
$responce->cols[$c++] = constant($module . 'Active');

$i = 0;
foreach ($usersArray as $row) {
    $responce->rows[$i]['id'] = $row['uid'];
    if ($privilege == 1) {
        $responce->rows[$i]['cell'] = array('', $row['uid'], $row['uname'], $row['uemail'], search_AssocArray($UsersResult, 'uid', $row['umain'], 'uname'), from_array_keys($Privileges, $row['upriv']), $row['utimezone'], $row['ucreatedate'], $row['uexpiredate'], $row['uactive']);
    } else if ($privilege == 4) {
        $responce->rows[$i]['cell'] = array($row['uid'], $row['uname'], $row['uemail'], search_AssocArray($UsersResult, 'uid', $row['umain'], 'uname'), from_array_keys($Privileges, $row['upriv']), $row['utimezone'], $row['uexpiredate'], $row['uactive']);
    } else {
        $responce->rows[$i]['cell'] = array('', $row['uid'], $row['uname'], $row['uemail'], search_AssocArray($UsersResult, 'uid', $row['umain'], 'uname'), from_array_keys($Privileges, $row['upriv']), $row['utimezone'], $row['uexpiredate'], $row['uactive']);
    }
    $i++;
}
echo json_encode($responce);
?>
