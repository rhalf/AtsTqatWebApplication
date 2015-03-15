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

if ($type == 1) {
    if (!is_form()) {
        die;
    }
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
    $Result = $session->get('colls');

    foreach ($Result as $row) {
        if ($row['collid'] == $id) {
            $collRow = $row;
            break;
        }
    }
}

include(ROOT_DIR . "/connect/connect_master_db.php");

if ($type == 1 or $type == 2) {
    $Array = array(
      '`collname`' => $_POST[$code . 'name'],
      '`colldesc`' => $_POST[$code . 'desc']
    );
}

if ($type == 1) {
    $sql = build_insert("`coll_{$udb}`", $Array);
} else if ($type == 2) {
    $sql = build_update("`coll_{$udb}`", $Array, "`collid`=$id");
} else if ($type == 3) {
    $sql = "delete from `coll_$udb` WHERE `collid`=$id";
}
$CompanyConn->query($sql);

$session->un_set('colls');
include("_sql.php");
$session->set('colls', $CollResult);

echo "Done";
$CompanyConn = null;
?>