<?php

// connect master
include ("connection.php");

// get cmp data
$companysql = "select `cmphost`,`cmpdbname`,`cmpdisplayname`,`cmpactive`,`cmpexpiredate` from `cmps` where `cmpname`='$company'";

$cmpStatment = $Conn->query($companysql);
if ($cmpStatment->rowCount() == 0) {
    $try = $session->get('try');
    $try++;
    $session->set('try', $try);


    die(WrongCredentials);
}


$companydata = $cmpStatment->fetch(PDO::FETCH_ASSOC);
$CmpDisplay = $companydata['cmpdisplayname'];

// check active
if ($companydata['cmpactive'] == '0') {
    die(CompanyAccountDeactivated);
}

// check expiry
$cmp_expire_date_state = user_expire_date($companydata['cmpexpiredate']);
if ($cmp_expire_date_state == 1) {
    die(CompanyAccountExpired);
} else if ($cmp_expire_date_state == 2) {
    $cmp_left_days = user_left_days($companydata['cmpexpiredate']);
    $session->set('cmp_left_days', $cmp_left_days);
}

// get host
$companyHostSql = "select * from `dbhosts` where dbhostid='" . $companydata['cmphost'] . "'";

$companyHostStatment = $Conn->query($companyHostSql);

$companyHostRow = $companyHostStatment->fetch(PDO::FETCH_ASSOC);


// connect cmp

//try {
$CompanyConn = new PDO("$engine:host=$companyHostRow[dbhostip];dbname=cmp_$companydata[cmpdbname]", "$companyHostRow[dbhostuser]", "$companyHostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
//} catch (PDOException $cExcemption) {
//	echo $cExcemption->getMessage();
//}
// close master
$Conn = null;
?>			
