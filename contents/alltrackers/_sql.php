<?php

header("Cache-Control: no-cache, must-revalidate");
$trackersQuery = "SELECT * from trks;";

$TrackersStatment = $Conn->query($trackersQuery);
$TrackersResult = array();
$TrackersResult = $TrackersStatment->fetchAll(PDO::FETCH_ASSOC);
?>