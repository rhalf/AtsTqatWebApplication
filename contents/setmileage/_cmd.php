<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
//include(ROOT_DIR."/connect/connect_master_db.php");

$id = $_GET['id'];

include (ROOT_DIR . "/connect/connection.php");
if (isset($_GET['reset'])) {
    $Array = array(
      '`tmileageInit`' => $_POST[$module . 'sm_initvalue'],
      '`tmileagereset`' => $_GET['reset'],
    );
} else {
    $Array = array(
      '`tmileageInit`' => $_POST[$module . 'sm_initvalue']
    );
}
/*    $GPSsql = "UPDATE `trks` SET 
  `tmileageInit`='$_POST[sm_initvalue]'
  where tunit=$un;";

  $CompanyConn->query($GPSsql);

  echo "One value edited";
  $CompanyConn=null; */


$sql = build_update('`usrs`', $Array, "`tunit`='$id'");
$Conn->query($sql);

$Conn = null;
?>