<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
if (!isset($_GET['id'])) {
    die;
}
if (!isset($_GET['type'])) {
    die;
}
$uid = $_GET['id'];
$type = $_GET['type'];

$TrackersResult = $session->get('trackers');

$TrackersArray = trackers_array($TrackersResult, $uid, $privilege);

foreach ($TrackersArray as $row) {
    $users = explode(',', $row['tusers']);
    if ($row['ttype'] == $type && in_array($uid, $users)) {
        echo "<option value = " . $row["tunit"] . ">" . $row["tvehiclereg"] . ' | ' . $row["tdrivername"] . "</option>";
    }
}
?>
