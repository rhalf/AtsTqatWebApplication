<?php

header("Cache-Control: no-cache, must-revalidate");
$subusersquery = "SELECT * from usrs order by uid;";
$UsersStatment = $CompanyConn->query($subusersquery);
$UsersResult = array();
$UsersResult = $UsersStatment->fetchAll(PDO::FETCH_ASSOC);
?>