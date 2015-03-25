<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
if (!is_form()) {
    die;
}
if ($privilege == 4) {
    die;
}

include(ROOT_DIR . "/connect/connection.php");


$CompanyInfoArray = array(
  '`cmpdisplayname`' => $_POST['ci_displayname'],
  '`cmpemail`' => $_POST['ci_email'],
  '`cmpphoneno`' => $_POST['ci_phoneno'],
  '`cmpmobileno`' => $_POST['ci_mobileno'],
  '`cmpaddress`' => $_POST['ci_address'],
);

$sql = build_update('`cmps`', $CompanyInfoArray, "`cmpdbname`='$companyDB'");

$session->set('userCmpDisplay', $_POST['ci_displayname']);
$Conn->query($sql);
$Conn = null;
echo "Company Info Edited<br>";
?>