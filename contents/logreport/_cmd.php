 <?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
include(ROOT_DIR."/connect/connect_master_db.php");

if ($privilege != 1 )die;

$CompanyConn->query("Delete  from `log_$udb`;");
echo "Done";

$CompanyConn=null;
?>