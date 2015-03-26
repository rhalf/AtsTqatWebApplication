<?php
header("Cache-Control: no-cache, must-revalidate");
$Query = "SELECT * from httphosts";
$Statment = $Conn->query($Query);
$Result=array();
$Result = $Statment->fetchAll(PDO::FETCH_ASSOC);
?>