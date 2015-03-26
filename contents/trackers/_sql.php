<?php

header("Cache-Control: no-cache, must-revalidate");
$trackersQuery = "SELECT * from trks where `tcmp`='$companyDB';";

$TrackersStatment = $Conn->query($trackersQuery);
$TrackersResult = array();
$TrackersResult = $TrackersStatment->fetchAll(PDO::FETCH_ASSOC);
?>