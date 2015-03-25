<?php

header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once ("../../scripts.php");
include("_start.php");

if (!isset($_GET['type'])) {
    die;
}
if ($privilege != 1) {
    die;
}
$type = $_GET['type'];

if ($type == 2 or $type == 3) {
    if (!isset($_GET['id'])) {
        die;
    }
    $id = $_GET['id'];
}

if ($type == 1) {
    $code = $module_add;
} else if ($type == 2) {
    $code = $module_edit;
}

include (ROOT_DIR . "/connect/connection.php");

if ($type == 1 or $type == 2) {
    $dbhostArray = array(
      '`dbhostname`' => $_POST[$code . 'hostname'],
      '`dbhostip`' => $_POST[$code . 'hostip'],
      '`dbhostuser`' => $_POST[$code . 'hostuser'],
      '`dbhostpassword`' => $_POST[$code . 'hostpassword']
    );
}
if ($type == 1) {
    $sql = build_insert('`dbhosts`', $dbhostArray);
} else if ($type == 2) {
    $sql = build_update('`dbhosts`', $dbhostArray, "`dbhostid`='$id'");
} else if ($type == 3) {
    $sql = "delete FROM `dbhosts` WHERE `dbhostid`= '$id' ;";
}

$Conn->query($sql);

$session->un_set('dbhosts');
include("_sql.php");
$session->set('dbhosts', $Result);


echo "One host edited";
$Conn = null;
?>