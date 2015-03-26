<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
if (file_exists(ROOT_DIR . '/connect/conf.php')) {
    include_once("../../scripts.php");
}
//connection
include (ROOT_DIR . "/connect/connection.php");

// drop master database
$deldatabse = $Conn->query("drop database $prefix$dbname;");
echo "Master database has been deleted";
$Conn = null;
// clean config.php file
$configFile = ROOT_DIR . '/connect/conf.php';
$wconfigFile = fopen($configFile, 'w') or die("can't open file");
$ptag = '';
fwrite($wconfigFile, $ptag);
fclose($wconfigFile);
?>

