<?php

header("Cache-Control: no-cache, must-revalidate");
$query = "SELECT * FROM `poi_$udb` ;";

$Statment = $CompanyConn->query($query);
$PoisResult = array();
$PoisResult = $Statment->fetchAll(PDO::FETCH_ASSOC);
?>