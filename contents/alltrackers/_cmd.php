<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
if ($privilege != 1) {
    die;
}
if (!$_GET['type']) {
    die;
}
$type = $_GET['type'];

if ($type == 1) {
    $code = $module_add;
} else if ($type == 2) {
    $code = $module_edit;
}

$TrackersResult = $session->get('alltrackers');
$dbhostResult = $session->get('dbhosts');

if ($type == 1) {
    if (!is_form()) {
        die;
    }
} else if ($type == 2) {
    if (!is_form()) {
        die;
    }
    if (!isset($_GET['id'])) {
        die;
    }
    $id = $_GET['id'];
} else if ($type == 3) {
    if (!is_ajax()) {
        die;
    }
    if (!isset($_GET['id'])) {
        die;
    }
    $id = $_GET['id'];
    foreach ($TrackersResult as $row) {
        if ($row['tunit'] == $id) {
            $trackerRow = $row;
            break;
        }
    }
}
include (ROOT_DIR . "/connect/connection.php");
if ($type == 1 or $type == 2) {

    /* emails */

    $newEmails = $userid;

    /* users */
    $newUsers = $userid;


    /* collections */
    $new_Array = array('id' => $userid, 'value' => "");

    $newCollections[] = $new_Array;


    if ($type == 1) {
        $tracker_date = setTime(time(), $timezone);
        $tracker_dbname = md5($tracker_date);

        $Array = array(
            '`tcmp`' => $_POST[$code . 'company'],
            '`tvehiclereg`' => $_POST[$code . 'vehiclereg'],
            '`tdrivername`' => $_POST[$code . 'drivername'],
            '`townername`' => $_POST[$code . 'ownername'],
            '`tvehiclemodel`' => $_POST[$code . 'model'],
            '`tsimno`' => $_POST[$code . 'simno'],
            '`tsimsr`' => $_POST[$code . 'simsr'],
            '`tunit`' => $_POST[$code . 'unit'],
            '`tprovider`' => $_POST[$code . 'provider'],
            '`ttype`' => $_POST[$code . 'type'],
            '`tunitpassword`' => $_POST[$code . 'unitpassword'],
            '`timg`' => $_POST[$code . 'img'],
            '`tdbhost`' => $_POST[$code . 'dbhost'],
            '`tcreatedate`' => $tracker_date,
            '`tdbs`' => $tracker_dbname,
            '`tusers`' => implode(',', $newUsers),
            '`tcollections`' => json_encode($newCollections),
            '`thttphost`' => $_POST[$code . 'httphost'],
            '`tmileageInit`' => $_POST[$code . 'initialmileage'],
            '`temails`' => implode(',', $newEmails),
            '`tspeedlimit`' => $_POST[$code . 'overspeed'],
            '`tmileagelimit`' => $_POST[$code . 'mileagelimit'],
            '`tvehicleregexpiry`' => $_POST[$code . 'vehicleregexpiry'],
            '`tnote`' => $_POST[$code . 'note'],
            '`ttrackerexpiry`' => $_POST[$code . 'trackerexpiry'],
            '`tinputs`' => $_POST[$code . 'inputs'],
            '`tidlingtime`' => $_POST[$code . 'IdlingTime'],
            '`tmileagereset`' => '0'
        );
    } else if ($type == 2) {
        include(ROOT_DIR . '/connect/connection.php');
        $Array = array(
            '`tcmp`' => $_POST[$code . 'company'],
            '`tvehiclereg`' => $_POST[$code . 'vehiclereg'],
            '`tdrivername`' => $_POST[$code . 'drivername'],
            '`townername`' => $_POST[$code . 'ownername'],
            '`tvehiclemodel`' => $_POST[$code . 'model'],
            '`tsimno`' => $_POST[$code . 'simno'],
            '`tsimsr`' => $_POST[$code . 'simsr'],
            '`tunit`' => $_POST[$code . 'unit'],
            '`tprovider`' => $_POST[$code . 'provider'],
            '`ttype`' => $_POST[$code . 'type'],
            '`tunitpassword`' => $_POST[$code . 'unitpassword'],
            '`timg`' => $_POST[$code . 'img'],
            //'`tusers`'=>implode(',',$newUsers),
            //'`tcollections`'=>json_encode($newCollections),
            '`tdbhost`' => $_POST[$code . 'dbhost'],
            '`thttphost`' => $_POST[$code . 'httphost'],
            '`tmileageInit`' => $_POST[$code . 'initialmileage'],
            //'`temails`'=>implode(',',$newEmails),
            '`tspeedlimit`' => $_POST[$code . 'overspeed'],
            '`tmileagelimit`' => $_POST[$code . 'mileagelimit'],
            '`tvehicleregexpiry`' => $_POST[$code . 'vehicleregexpiry'],
            '`tnote`' => $_POST[$code . 'note'],
            '`ttrackerexpiry`' => $_POST[$code . 'trackerexpiry'],
            '`tinputs`' => $_POST[$code . 'inputs'],
            '`tidlingtime`' => $_POST[$code . 'IdlingTime']
        );
    }
}

if ($type == 1) {
    $sql = build_insert('`trks`', $Array);
} else if ($type == 2) {
    $sql = build_update('`trks`', $Array, "`tunit`='$id'");
} else if ($type == 3) {
    $sql = "delete FROM `trks` WHERE `tunit`='$id';";
}

$Conn->query($sql);

if ($type == 1) {
    foreach ($dbhostResult as $dbhost) {
        if ($_POST[$code . 'dbhost'] == $dbhost['dbhostid']) {
            $dbhostRow = $dbhost;
            break;
        }
    }


    $trackerConn = new PDO("$engine:host=$dbhostRow[dbhostip]", "$dbhostRow[dbhostuser]", "$dbhostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $sqlCreateDB = 'CREATE DATABASE `trk_' . $tracker_dbname . '` DEFAULT CHARACTER SET utf8 COLLATE ' . 'utf8_general_ci;';
    $trackerConn->query($sqlCreateDB);

    $sqlCreateTpl = 'CREATE TABLE IF NOT EXISTS `trk_' . $tracker_dbname . '`.`gps_' . $tracker_dbname .
            '` (' . '`gm_id` int(11) NOT NULL AUTO_INCREMENT,' .
            '`gm_time` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,' .
            '`gm_lat` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,' .
            '`gm_lng` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,' .
            '`gm_speed` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,' .
            '`gm_ori` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,' .
            '`gm_mileage` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,' .
            '`gm_data` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,' .
            '`gm_lasttime` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,' .
            ' PRIMARY KEY `gm_id` (`gm_id`),' .
            ' KEY `gm_time` (`gm_time`),' .
            ' KEY `gm_lat` (`gm_lat`),' .
            ' KEY `gm_lng` (`gm_lng`),' .
            ' KEY `gm_speed` (`gm_speed`),' .
            ' KEY `gm_ori` (`gm_ori`),' .
            ' KEY `gm_mileage` (`gm_mileage`),' .
            ' KEY `gm_lasttime` (`gm_lasttime`)' .
            ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;';

    $trackerConn->query($sqlCreateTpl);
    $trackerConn = null;
}
if ($type == 3) {
    $sql = "DROP DATABASE `trk_" . $trackerRow['tdbs'] . "`";
}
$Conn->query($sql);

$session->un_set('alltrackers');
include("_sql.php");
$session->set('alltrackers', $TrackersResult);

if ($type == 1 or $type == 2) {
    if ($companyDB == $_POST[$code . 'company']) {
        $session->un_set('trackers');
        include(ROOT_DIR . "/contents/trackers/_sql.php");
        $session->set('trackers', $TrackersResult);
    }
} else if ($type == 3) {
    if ($trackerRow['tcmp'] == $companyDB) {
        $session->un_set('trackers');
        include(ROOT_DIR . "/contents/trackers/_sql.php");
        $session->set('trackers', $TrackersResult);
    }
}

echo "Done";
$Conn = null;
?>