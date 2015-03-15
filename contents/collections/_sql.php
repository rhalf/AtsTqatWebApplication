<?php

header("Cache-Control: no-cache, must-revalidate");
$Collquery = "SELECT * FROM `coll_$udb` ;";

$CollStatment = $CompanyConn->query($Collquery);
$CollResult = array();
$CollResult = $CollStatment->fetchAll(PDO::FETCH_ASSOC);
?>