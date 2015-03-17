<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");

if (filter_input(INPUT_GET, "id") === null) {
    die;
}
$id = filter_input(INPUT_GET, "id");

$UsersResult = $session->get('users');
foreach ($UsersResult as $row) {
    if ($row['uid'] == $id) {
        echo $parentPrivilege = $row['upriv'];
        break;
    }
}
?>