<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include("_start.php");
include_once(ROOT_DIR . "/connect/func.php");
if (file_exists(ROOT_DIR . '/connect/conf.php')) {
    include (ROOT_DIR . '/libraries/Classes/System_boot.php');
    include (ROOT_DIR . "/connect/session_func.php");
}

$databasename = $_POST[$module . "databasename"];
$prefix = $_POST[$module . "prefix"];
$host = $_POST[$module . "host"];
$hostuser = $_POST[$module . "hostuser"];
$hostpassword = $_POST[$module . "hostpassword"];
$ipaddress = $_POST[$module . "ipaddress"];
$companyname = $_POST[$module . "companyname"];
$mastername = $_POST[$module . "mastername"];
$masterpassword = $_POST[$module . "masterpassword"];

$install_conn = new PDO("$engine:host=$host", "$hostuser", "$hostpassword", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$install_sql = "CREATE DATABASE `{$prefix}{$databasename}` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

$install_statment = $install_conn->query($install_sql);
if (!$install_statment) {
    print_r($install_conn->errorInfo());
}
$install_conn->query("use `{$prefix}{$databasename}`");
/* cmps */
$cmps_sql = "CREATE TABLE IF NOT EXISTS `{$prefix}{$databasename}`.`cmps` (
`cmpid` int(11) NOT NULL AUTO_INCREMENT,
`cmpname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`cmpdisplayname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
`cmphost` varchar(50) COLLATE utf8_unicode_ci NOT NULL,  
`cmpemail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`cmpphoneno` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`cmpmobileno` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`cmpaddress` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`cmpactive` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
`cmpexpiredate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,	
`cmpcreatedate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`cmpdbname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,						  
PRIMARY KEY (`cmpid`),
UNIQUE KEY `companyname` (`cmpname`),
KEY `cmphost` (`cmphost`),
KEY `cmpemail` (`cmpemail`),
KEY `cmpphoneno` (`cmpphoneno`),
KEY `cmpmobileno` (`cmpmobileno`),
KEY `cmpaddress` (`cmpaddress`),
KEY `cmpactive` (`cmpactive`),
KEY `cmpexpiredate` (`cmpexpiredate`),
KEY `cmpcreatedate` (`cmpcreatedate`),
KEY `cmpdbname` (`cmpdbname`),
KEY `cmpdisplayname` (`cmpdisplayname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

$stmt = $install_conn->query($cmps_sql);
if (!$stmt) {
    print_r($install_conn->errorInfo());
}
/* dbhosts */
$hosts_sql = "CREATE TABLE IF NOT EXISTS `{$prefix}{$databasename}`.`dbhosts` (
`dbhostid` int(11) NOT NULL AUTO_INCREMENT,
`dbhostname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`dbhostip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`dbhostuser` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`dbhostpassword` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (`dbhostid`),
UNIQUE KEY `dbhostname` (`dbhostname`),
KEY `dbhostip` (`dbhostip`),
KEY `dbhostuser` (`dbhostuser`),
KEY `dbhostpassword` (`dbhostpassword`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

$stmt = $install_conn->query($hosts_sql);
if (!$stmt) {
    print_r($install_conn->errorInfo());
}
/* tcphosts */
/* $hosts_sql = "CREATE TABLE IF NOT EXISTS `{$prefix}{$databasename}`.`tcphosts` (
  `tcphostid` int(11) NOT NULL AUTO_INCREMENT,
  `tcphostname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tcphostip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tcpcmdport` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`tcphostid`),
  KEY `tcpcmdport` (`tcpcmdport`),
  KEY `tcphostname` (`tcphostname`),
  KEY `tcphostip` (`tcphostip`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

  $stmt=$install_conn->query($hosts_sql);
  if (!$stmt){
  print_r($install_conn->errorInfo());
  } */
/* httphosts */
$hosts_sql = "CREATE TABLE IF NOT EXISTS `{$prefix}{$databasename}`.`httphosts` (
`httphostid` int(11) NOT NULL AUTO_INCREMENT,
`httphostname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`httphostip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`httpport` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
`cmdport` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`httphostid`),
  KEY `httpport` (`httpport`),
  KEY `cmdport` (`cmdport`),
  KEY `httphostname` (`httphostname`),  
  KEY `httphostip` (`httphostip`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

$stmt = $install_conn->query($hosts_sql);
if (!$stmt) {
    print_r($install_conn->errorInfo());
}

/* protocols */
$protocols_sql = "CREATE TABLE IF NOT EXISTS `{$prefix}{$databasename}`.`protocols` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pmodel` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `pport` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `pconnection` smallint(6) NOT NULL,
  `pdesc` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pmodel_UNIQUE` (`pmodel`),
  UNIQUE KEY `pport_UNIQUE` (`pport`),
  KEY `pmodel` (`pmodel`),
  KEY `pport` (`pport`),
  KEY `pconnection` (`pconnection`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$stmt = $install_conn->query($protocols_sql);
if (!$stmt) {
    print_r($install_conn->errorInfo());
}

/* trks */
$trks_sql = "CREATE TABLE IF NOT EXISTS `{$prefix}{$databasename}`.`trks` (
`tid` int(11) NOT NULL AUTO_INCREMENT,
`tcmp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`tvehiclereg` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`tdrivername` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`townername` varchar(50) COLLATE utf8_unicode_ci NULL,
`tvehiclemodel` varchar(50) COLLATE utf8_unicode_ci NULL,
`tsimno` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`tsimsr` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`tunit` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`tprovider` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
`ttype` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
`tunitpassword` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
`timg` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
`tdbhost` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`thttphost` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`tdbs` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`tusers` TEXT COLLATE utf8_unicode_ci NULL, 
`tcollections` TEXT COLLATE utf8_unicode_ci NULL, 
`tcreatedate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`temails` varchar(100) COLLATE utf8_unicode_ci NULL,
`tmileageInit` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' ,
`tspeedlimit` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '80' ,
`tmileagelimit` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '5000',
`ttrackerexpiry` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`tvehicleregexpiry` varchar(50) COLLATE utf8_unicode_ci NULL,
`tinputs` varchar(50) COLLATE utf8_unicode_ci NULL,
`tidlingtime`  varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '5',
`tmileagereset` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' ,
`tnote` varchar(100) COLLATE utf8_unicode_ci NULL,
PRIMARY KEY (`tid`),
UNIQUE KEY `tunit` (`tunit`),
UNIQUE KEY `tdbs` (`tdbs`),
KEY `tvehiclereg` (`tvehiclereg`),
KEY `tdrivername` (`tdrivername`),
KEY `townername` (`townername`),
KEY `tvehiclemodel` (`tvehiclemodel`),
KEY `tsimno` (`tsimno`),
KEY `tsimsr` (`tsimsr`),
KEY `tprovider` (`tprovider`),
KEY `tdbhost` (`tdbhost`),
KEY `thttphost` (`thttphost`),
KEY `tcreatedate` (`tcreatedate`),  
KEY `ttype` (`ttype`),
KEY `tunitpassword` (`tunitpassword`),
KEY `timg` (`timg`),
KEY `tcmp` (`tcmp`),
KEY `temails` (`temails`),
KEY `tmileageInit` (`tmileageInit`),
KEY `tspeedlimit` (`tspeedlimit`),
KEY `tmileagelimit` (`tmileagelimit`),
KEY `ttrackerexpiry` (`ttrackerexpiry`),
KEY `tvehicleregexpiry` (`tvehicleregexpiry`),
KEY `tidlingtime` (`tidlingtime`),
KEY `tinputs` (`tinputs`),
KEY `tmileagereset` (`tmileagereset`),
KEY `tnote` (`tnote`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
$stmt = $install_conn->query($trks_sql);
if (!$stmt) {
    print_r($install_conn->errorInfo());
}
/* usersonline */
$usersonline_sql = "CREATE TABLE IF NOT EXISTS `{$prefix}{$databasename}`.`usersonline` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`company` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`privilege` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
`session` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`time` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`starttime` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `username` (`username`),
KEY `company` (`company`),
KEY `privilege` (`privilege`),
KEY `session` (`session`),
KEY `time` (`time`),
KEY `ip` (`ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

$stmt = $install_conn->query($usersonline_sql);
if (!$stmt) {
    print_r($install_conn->errorInfo());
}


/* Primary company */
$cmp_date = setTime(time(), $defaultTimeZone);
$cmp_dbname = md5($cmp_date);




$sql = "INSERT INTO `{$prefix}{$databasename}`.`dbhosts` (`dbhostname`, `dbhostip`,`dbhostuser`,`dbhostpassword`) VALUES";
$sql .= "('default', '$ipaddress','$hostuser','$hostpassword');";

$install_conn->query($sql);


$sql = "INSERT INTO `{$prefix}{$databasename}`.`httphosts` (`httphostname`, `httphostip`,`httpport`,`cmdport`) VALUES";
$sql .= "('default', '$ipaddress','8000','8001');";

$install_conn->query($sql);


$Array = array(
    '`cmpname`' => $companyname,
    '`cmpdisplayname`' => $companyname,
    '`cmphost`' => '1',
    '`cmpemail`' => '',
    '`cmpphoneno`' => '',
    '`cmpmobileno`' => '',
    '`cmpaddress`' => '',
    '`cmpexpiredate`' => '',
    '`cmpcreatedate`' => $cmp_date,
    '`cmpactive`' => '1',
    '`cmpdbname`' => $cmp_dbname,
);

$sql = build_insert('`cmps`', $Array);
$install_conn->query($sql);


$CompanyConn = new PDO("$engine:host=$ipaddress", "$hostuser", "$hostpassword", array(PDO::MYSQL_ATTR_INIT_COMMAND =>
    "SET NAMES utf8"));


$createdatabasesql = "CREATE DATABASE `" . 'cmp_' . $cmp_dbname .
        "` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

$CompanyConn->query($createdatabasesql);

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
$sql .= '(Null, \'' . $mastername . '\', \'' . md5($masterpassword) .
        '\',\'\', \'1\', \'1\',\'' . $defaultTimeZone . '\',\'' .
        $user_date . '\',\'\',\'1\',\'' . $user_dbname . '\');';
$CompanyConn->query($sql);


echo 'Add Company Complete';
$CompanyConn = null;

$install_conn = null;

// Write config file settings
$configFile = ROOT_DIR . "/connect/conf.php";
$wconfigFile = fopen($configFile, 'w') or die("can't open file");
$ptag = '<?php ';
$vengine = '$engine=\'mysql\';';
$vdbhost = '$dbhost =\'' . $_POST[$module . "host"] . '\';';
$vdbuser = '$dbuser =\'' . $_POST[$module . "hostuser"] . '\';';
$vdbpass = '$dbpass =\'' . $_POST[$module . "hostpassword"] . '\';';
$vdbname = '$dbname =\'' . $_POST[$module . "databasename"] . '\';';
$vprefix = '$prefix =\'' . $_POST[$module . "prefix"] . '\';';
$ltag = ' ?>';
fwrite($wconfigFile, $ptag);
fwrite($wconfigFile, $vengine);
fwrite($wconfigFile, $vdbhost);
fwrite($wconfigFile, $vdbuser);
fwrite($wconfigFile, $vdbpass);
fwrite($wconfigFile, $vdbname);
fwrite($wconfigFile, $vprefix);
fwrite($wconfigFile, $ltag);
fclose($wconfigFile);
if (file_exists(ROOT_DIR . '/connect/conf.php')) {
    echo "Setup Complete";
}
?>