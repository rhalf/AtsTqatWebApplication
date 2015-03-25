<?php

header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once ("../../scripts.php");
include("_start.php");

if (!isset($_GET['type'])) {
    die;
}
if ($privilege != 1) {
    die;
}

$type = $_GET['type'];

if ($type == 2 or $type == 3) {
    if (!isset($_GET['id'])) {
        die;
    }
    $id = $_GET['id'];
    $cmpsResult = $session->get('cmps');
}
$dbhostResult = $session->get('dbhosts');


if ($type == 1) {
    $code = $module_add;
} else if ($type == 2) {
    $code = $module_edit;
}

include (ROOT_DIR . "/connect/connection.php");

if ($type == 1) {
    $mastername = $username;
    $masterpass = $pass;
    $mastertimezone = $_POST[$code . 'timezone'];
}

if ($type == 2) {
    $mastername = $username;
    $masterpass = $pass;
    $mastertimezone = $_POST[$code . 'timezone'];
    foreach ($cmpsResult as $Row) {
        if ($Row['cmpid'] == $id) {
            $cmpRow = $Row;
            break;
        }
    }

    foreach ($dbhostResult as $Row) {
        if ($Row['dbhostid'] == $cmpRow['cmphost']) {
            $HostRow = $Row;
            break;
        }
    }
}

if ($type == 1) {

    $cmp_date = setTime(time(), $_POST[$code . "timezone"]);
    $cmp_dbname = md5($cmp_date);
    $Array = array(
      '`cmpname`' => $_POST[$code . 'cmpname'],
      '`cmpdisplayname`' => $_POST[$code . 'cmpdisplayname'],
      '`cmphost`' => $_POST[$code . 'cmphost'],
      '`cmpemail`' => $_POST[$code . 'cmpemail'],
      '`cmpphoneno`' => $_POST[$code . 'cmpphoneno'],
      '`cmpmobileno`' => $_POST[$code . 'cmpmobileno'],
      '`cmpaddress`' => $_POST[$code . 'cmpaddress'],
      '`cmpexpiredate`' => $_POST[$code . 'cmpexpiredate'],
      '`cmpcreatedate`' => $cmp_date,
      '`cmpactive`' => $_POST[$code . 'cmpactive'],
      '`cmpdbname`' => $cmp_dbname,
    );
} else if ($type == 2) {
    $Array = array(
      '`cmpname`' => $_POST[$code . 'cmpname'],
      '`cmpdisplayname`' => $_POST[$code . 'cmpdisplayname'],
      '`cmpemail`' => $_POST[$code . 'cmpemail'],
      '`cmpphoneno`' => $_POST[$code . 'cmpphoneno'],
      '`cmpmobileno`' => $_POST[$code . 'cmpmobileno'],
      '`cmpaddress`' => $_POST[$code . 'cmpaddress'],
      '`cmpexpiredate`' => $_POST[$code . 'cmpexpiredate'],
      '`cmpactive`' => $_POST[$code . 'cmpactive'],
    );
}
if ($type == 1) {
    $sql = build_insert('`cmps`', $Array);
} else if ($type == 2) {
    $sql = build_update('`cmps`', $Array, "`cmpid`='$id'");
} else if ($type == 3) {
    $sql = "delete FROM `cmps` WHERE `cmpid`= '$id' ;";
}

$Conn->query($sql);




if ($type == 1) {

    foreach ($dbhostResult as $row) {
        if ($row['dbhostid'] == $_POST[$code . "cmphost"]) {
            $HostRow = $row;
        }
    }

    $CompanyConn = new PDO("$engine:host=$HostRow[dbhostip]", "$HostRow[dbhostuser]", "$HostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND =>
      "SET NAMES utf8"));


    $createdatabasesql = "CREATE DATABASE `" . 'cmp_' . $cmp_dbname .
        "` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

    $CompanyConn->query($createdatabasesql);


    /* --
      -- Database: `tracking`
      --

      -- --------------------------------------------------------

      --
      -- Table structure for table `admin_poi`
      -- */

    $user_date = date('d/m/Y H:i:s', time());

    $user_dbname = md5($user_date);

    $sql = "CREATE TABLE IF NOT EXISTS " . '`cmp_' . $cmp_dbname . "`.`poi_" . $user_dbname .
        "` (";
    $sql .= "  `poi_id` int(11) NOT NULL AUTO_INCREMENT,";
    $sql .= "  `poi_lat` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,";
    $sql .= "  `poi_lon` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,";
    $sql .= " `poi_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,";
    $sql .= " `poi_img` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,";
    $sql .= "  `poi_desc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,";
    $sql .= "  PRIMARY KEY (`poi_id`),";
    $sql .= "UNIQUE KEY `poi_name` (`poi_name`),";
    $sql .= "  KEY `poi_lat` (`poi_lat`),";
    $sql .= "  KEY `poi_lon` (`poi_lon`)";
    $sql .= ") ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";

    $CompanyConn->query($sql);

    /* --
      -- Dumping data for table `admin_poi`
      -- */


    $sql = "CREATE TABLE IF NOT EXISTS " . '`cmp_' . $cmp_dbname . "`.`coll_" . $user_dbname .
        "` (";
    $sql .= "  `collid` int(11) NOT NULL AUTO_INCREMENT,";
    $sql .= "  `collname` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,";
    $sql .= "  `colldesc` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,";
    $sql .= "  PRIMARY KEY (`collid`),";
    $sql .= "UNIQUE KEY `collname` (`collname`),";
    $sql .= "  KEY `colldesc` (`colldesc`)";
    $sql .= ") ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";

    $stmt = $CompanyConn->query($sql);
    if (!$stmt) {
        print_r($CompanyConn->errorInfo());
    }


    $sql = "CREATE TABLE IF NOT EXISTS " . '`cmp_' . $cmp_dbname . "`.`log_" . $user_dbname .
        "` (
`log_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`log_data` VARCHAR(100)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`log_date` VARCHAR(25)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
INDEX (`log_data` ,`log_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";

    $CompanyConn->query($sql);

    /* -- --------------------------------------------------------
      -- Table structure for table `gf`
      -- */

    $sql = "CREATE TABLE IF NOT EXISTS " . '`cmp_' . $cmp_dbname . "`.`gf` (
`gf_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`gf_data` varchar(5000)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`gf_name` varchar(25)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`gf_trks` varchar(1000)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
  UNIQUE KEY `gf_name` (`gf_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";

    $CompanyConn->query($sql);
    /* -- --------------------------------------------------------

      --
      -- Table structure for table `settings` */

    $sql = "CREATE TABLE IF NOT EXISTS `" . 'cmp_' . $cmp_dbname . "`.`settings` (";
    $sql .= '  `sid` int(11) NOT NULL AUTO_INCREMENT,';
    $sql .= '  `skey` varchar(45) COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `svalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  PRIMARY KEY (`sid`),';
    $sql .= '  KEY `skey` (`skey`),';
    $sql .= '  KEY `svalue` (`svalue`)';
    $sql .= ') ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;';


    $CompanyConn->query($sql);

    $sql = "INSERT INTO `" . 'cmp_' . $cmp_dbname .
        "`.`settings` (`skey`, `svalue`) VALUES";
    $sql .= '(\'logo\', \'default\');';

    $CompanyConn->query($sql);



    $sql = "CREATE TABLE IF NOT EXISTS `" . 'cmp_' . $cmp_dbname . "`.`usrs` (";
    $sql .= '  `uid` int(11) NOT NULL AUTO_INCREMENT,';
    $sql .= '  `uname` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `upass` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `uemail` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `umain` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `upriv` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `utimezone` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `ucreatedate` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `uexpiredate` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `uactive` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  `udbs` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,';
    $sql .= '  PRIMARY KEY `uid` (`uid`),';
    $sql .= "UNIQUE KEY `uname` (`uname`),";
    $sql .= "UNIQUE KEY `udbs` (`udbs`),";
    $sql .= '  KEY `upass` (`upass`),';
    $sql .= '  KEY `uemail` (`uemail`),';
    $sql .= '  KEY `umain` (`umain`),';
    $sql .= '  KEY `upriv` (`upriv`),';
    $sql .= '  KEY `utimezone` (`utimezone`),';
    $sql .= '  KEY `ucreatedate` (`ucreatedate`),';
    $sql .= '  KEY `uexpiredate` (`uexpiredate`),';
    $sql .= '  KEY `uactive` (`uactive`)';
    $sql .= ') ENGINE=InnoDB   DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;';


    $CompanyConn->query($sql);

    /* --
      -- Dumping data for table `users`
      -- */


    $sql = "INSERT INTO `" . 'cmp_' . $cmp_dbname .
        "`.`usrs` (`uid`, `uname`, `upass`, `uemail`, `umain`, `upriv`,`utimezone`, `ucreatedate`, `uexpiredate`, `uactive`,`udbs`) VALUES";
    $sql .= '(Null, \'' . $mastername . '\', \'' . $masterpass .
        '\',\'' . $_POST[$code . "cmpemail"] . '\', \'1\', \'1\',\'' . $mastertimezone . '\',\'' .
        $user_date . '\',\'\',\'1\',\'' . $user_dbname . '\');';
    $CompanyConn->query($sql);


    echo 'Add Company Complete';
    $CompanyConn = null;
} else if ($type == 2) {


    $CompanyConn = new PDO("$engine:host=$HostRow[dbhostip];cmp_$cmpRow[cmpdbname]", "$HostRow[dbhostuser]", "$HostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


///////////////////


    $sql = "UPDATE `" . 'cmp_' . $cmpRow['cmpdbname'] .
        "`.`usrs` SET `uname`='$mastername', `upass`='$masterpass', `utimezone`='$mastertimezone' where `upriv`='1' ;";

    $CompanyConn->query($sql);
    echo "Master edited";
    $CompanyConn = null;
} else if ($type == 3) {
    foreach ($cmpsResult as $Row) {
        if ($Row['cmpid'] == $id) {
            $cmpRow = $Row;
        }
    }



    foreach ($dbhostResult as $Row) {
        if ($Row['dbhostid'] == $cmpRow['cmphost']) {
            $HostRow = $Row;
        }
    }


    $CompanyConn = new PDO("$engine:host=$HostRow[dbhostip];cmp_$cmpRow[cmpdbname]", "$HostRow[dbhostuser]", "$HostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


    $drop_company_db = $CompanyConn->query("DROP DATABASE `cmp_" . $cmpRow["cmpdbname"] .
        "`");
    $CompanyConn = null;

    $del_company_record = $Conn->query("delete FROM `cmps` WHERE `cmpid`='$id';");
}


$session->un_set('cmps');
include("_sql.php");
$session->set('cmps', $Result);


echo "Done";

$Conn = null;
?>