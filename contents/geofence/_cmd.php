<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if (!$_GET['type']) {
    die;
}
$type = $_GET['type'];

if ($type == 1) {
    $code = $module_add;
} else if ($type == 2 or $type == 3) {
    $code = $module_edit;
}

$gname = $_POST[$code . 'name'];
$gpolyarr = $_POST[$code . 'polyarr'];

if ($gpolyarr == '') {
    die;
}
if (count(explode('),(', $gpolyarr)) < 3) {
    die;
}

if ($type == 1) {
    if (!is_form()) {
        
    }die;
} else if ($type == 2) {
    if (!is_form()) {
        die;
    }
    if (!isset($_POST[$code . 'id'])) {
        die;
    }
    $id = $_POST[$code . 'id'];
} else if ($type == 3) {
    if (!is_ajax()) {
        die;
    }
    if (!isset($_GET['id'])) {
        die;
    }
    $id = $_GET['id'];
    $Result = $session->get('pois');

    foreach ($Result as $row) {
        if ($row['poi_id'] == $id) {
            $poiRow = $row;
        }
    }
}

include(ROOT_DIR . "/connect/connect_master_db.php");

if ($type == 1 or $type == 2) {
    $Array = array(
      '`gf_name`' => $gname,
      '`gf_data`' => $gpolyarr,
      '`gf_trks`' => ''
    );
}

if ($type == 1) {
    $sql = build_insert("`gf`", $Array);
} else if ($type == 2) {
    $sql = build_update("`gf`", $Array, "`gf_id`=$id");
} else if ($type == 3) {
    $sql = "delete from `gf` WHERE `gf_id`=$id";
}
$CompanyConn->query($sql);

$session->un_set('geofence');
include("_sql.php");
$session->set('geofence', $GeoFenceResult);

echo "Geo-Fence Edited<br>";
$CompanyConn = null;
?>