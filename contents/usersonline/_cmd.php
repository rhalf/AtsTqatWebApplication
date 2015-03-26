<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
if($privilege!=1)die;
include(ROOT_DIR."/connect/connection.php");

$Deletesql="DELETE FROM usersonline";
$Conn->query($Deletesql);

// Close connection
$Conn=null;
?>