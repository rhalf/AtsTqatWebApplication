<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if (!$_GET['type']) {
    die;
}
$type = $_GET['type'];
;

if ($type == 1) {
    $code = $module_add;
} else if ($type == 2) {
    $code = $module_edit;
}

if ($type == 1) {
    if (!is_form()) {
        die;
    }
    if (!isset($_POST[$code . 'tz'])) {
        die;
    }
    if ($privilege >= $_POST[$code . 'privilege']) {
        die;
    }
} else if ($type == 2) {
    if (!is_form()) {
        die;
    }
    if (!isset($_GET['id'])) {
        die;
    }
    if (isset($_POST[$code . 'privilege'])) {
        if (($privilege >= $_POST[$code . 'privilege'])) {
            die;
        }
    }
    if (($privilege == 4)) {
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
    $UsersResult = $session->get('users');

    foreach ($UsersResult as $row) {
        if ($row['uid'] == $id) {
            $userRow = $row;
            break;
        }
    }
    if (($privilege >= $userRow['upriv']) || ($privilege == 4)) {
        die;
    }
}

include(ROOT_DIR . "/connect/connect_master_db.php");

if ($type == 1) {
    $user_date = setTime(time(), $timezone);
    $user_dbname = md5($user_date);
    $auname = $_POST[$code . 'username'];
    $aupass = $_POST[$code . 'password'];
    $auemail = $_POST[$code . 'email'];
    $Array = array(
      '`uname`' => $auname,
      '`upass`' => md5($aupass),
      '`uemail`' => $auemail,
      '`umain`' => $_POST[$code . 'parent'],
      '`upriv`' => $_POST[$code . 'privilege'],
      '`utimezone`' => $_POST[$code . 'tz'],
      '`uexpiredate`' => $_POST[$code . 'expiredate'],
      '`uactive`' => $_POST[$code . 'active'],
      '`ucreatedate`' => $user_date,
      '`udbs`' => $user_dbname
    );
    $sql = build_insert('`usrs`', $Array);
} else if ($type == 2) {
    $UsersResult = $session->get('users');

    foreach ($UsersResult as $row) {
        if ($row['uid'] == $id) {
            $userRow = $row;
            break;
        }
    }

    if ($userRow['upass'] == $_POST[$code . 'password']) {
        $passwd = $userRow['upass'];
    } else {
        $passwd = md5($_POST[$code . 'password']);
    }

    if (!isset($_POST[$code . "privilege"])) {
        $Array = array(
          '`uname`' => $_POST[$code . 'username'],
          '`upass`' => $passwd,
          '`uemail`' => $_POST[$code . 'email'],
          '`umain`' => $_POST[$code . 'parent'],
          '`utimezone`' => $_POST[$code . 'tz']
        );
    } else {
        $Array = array(
          '`uname`' => $_POST[$code . 'username'],
          '`upass`' => $passwd,
          '`uemail`' => $_POST[$code . 'email'],
          '`umain`' => $_POST[$code . 'parent'],
          '`upriv`' => $_POST[$code . 'privilege'],
          '`utimezone`' => $_POST[$code . 'tz'],
          '`uexpiredate`' => $_POST[$code . 'expiredate'],
          '`uactive`' => $_POST[$code . 'active']
        );
    }
    $sql = build_update('`usrs`', $Array, "`uid`='$id'");
} else if ($type == 3) {
    $sql = "delete FROM `usrs` WHERE `uid`= '$id' ;";
}

$statment = $CompanyConn->query($sql);


if ($type == 1) {
    $Collsql = "CREATE TABLE IF NOT EXISTS `coll_" . $user_dbname .
        "` (";
    $Collsql .= "  `collid` int(11) NOT NULL AUTO_INCREMENT,";
    $Collsql .= "  `collname` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,";
    $Collsql .= "  `colldesc` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,";
    $Collsql .= "  PRIMARY KEY (`collid`),";
    $Collsql .= "UNIQUE KEY `collname` (`collname`),";
    $Collsql .= "  KEY `colldesc` (`colldesc`)";
    $Collsql .= ") ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
    $statment = $CompanyConn->query($Collsql);

    $sql_createpoi = 'CREATE TABLE IF NOT EXISTS `poi_' . $user_dbname . '` (' .
        '`poi_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,' .
        ' `poi_lat` VARCHAR( 20)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL  ,' .
        ' `poi_lon` VARCHAR( 20)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL  ,' .
        ' `poi_name` VARCHAR( 50)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL  ,' .
        ' `poi_desc` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL  ,' .
        ' `poi_img` VARCHAR( 11)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL  ,' .
        'UNIQUE KEY `poi_name` (`poi_name`),' .
        ' KEY `poi_lat` (`poi_lat`),' .
        ' KEY `poi_lon` (`poi_lon`)' .
        ') ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;';

    $statment = $CompanyConn->query($sql_createpoi);

    $sql_createlog = 'CREATE TABLE IF NOT EXISTS `log_' . $user_dbname . '` (' .
        '`log_id` TINYINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,' .
        '`log_data` VARCHAR( 100)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,' .
        '`log_date` VARCHAR( 25)CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,' .
        'INDEX (`log_data` ,`log_date`) ' . ') ENGINE=InnoDB ;';

    $statment = $CompanyConn->query($sql_createlog);
} else if ($type == 2) {
    $session->set('timezone', $_POST[$code . 'tz']);

    if (($privilege == 1) && !isset($_POST[$code . 'privilege'])) {
        $dbhostResult = $session->get('dbhosts');
        $cmpResult = $session->get('cmps');
        foreach ($cmpResult as $cmp) {
            foreach ($dbhostResult as $dbhost) {
                if ($cmp['cmphost'] == $dbhost['dbhostid']) {
                    $dbhostRow = $dbhost;
                }
            }
            $cmpConn = new PDO("$engine:host=$dbhostRow[dbhostip];dbname=cmp_$cmp[cmpdbname]", "$dbhostRow[dbhostuser]", "$dbhostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $Array = array(
              '`uname`' => $_POST[$code . 'username'],
              '`upass`' => $passwd
            );
            $sql = build_update('`usrs`', $Array, "`uid`='$userid' and `upriv`='$privilege'");
            $cmpConn->query($sql);
            $cmpConn = null;
        }
    }
    $Conn = null;

    if (!isset($_POST[$code . "privilege"])) {
        if ($userRow['upass'] != $passwd || $username != $_POST[$code . 'username']) {
            $session->logout();
            ?>
            <script type="text/javascript">
                window.location = "<?php echo $webroot ?>" + "/index.php";
            </script>
            <?php
        }
    }
} else if ($type == 3) {

    $CompanyConn->query("drop table `coll_$userRow[udbs]`;");

    $CompanyConn->query("drop table `poi_$userRow[udbs]`;");

    $CompanyConn->query("drop table `log_$userRow[udbs]`;");
}


$session->un_set('users');
include("_sql.php");
$session->set('users', $UsersResult);

echo 'Done';
$CompanyConn = null;
?>