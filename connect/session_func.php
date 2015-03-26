<?php

$session = system_sessions::getInstance();

if (!$session->isLoggedIn()) {
    if (isset($mobileVersion) && $mobileVersion = true) {
        header("Location: $webroot/mobile/login.php");
    } else {
        header("Location: $webroot/login.php");
    }
    exit();
}


$userid = $session->get('userid');
$username = $session->get('userName');
$pass = $session->get('userPass');
$companyDB = $session->get('userCmpdb');
$company = $session->get('userCmp');
$CompanyDisplay = $session->get('userCmpDisplay');
$timezone = $session->get('timezone');
$language = $session->get('language');
$privilege = $session->get('priv');
$udb = $session->get('udb');

/*
  if ($session->is_set('grouping')) {
  $grouping = $session->get('grouping');
  } else {
  if($privilege==1){
  $grouping = '1';
  $session->set('grouping','1');
  }else{
  $grouping = '1';
  $session->set('grouping','1');
  }
  } */
?>