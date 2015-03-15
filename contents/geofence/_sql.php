<?php

header("Cache-Control: no-cache, must-revalidate");
$gfquery = "SELECT * FROM `gf` ;";

$GeoFenceStatment = $CompanyConn->query($gfquery);
$GeoFenceResult = $GeoFenceStatment->fetchAll(PDO::FETCH_ASSOC);
?>