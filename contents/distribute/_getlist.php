<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
$TrackerResult=$session->get('trackers');
$UsersResult=$session->get('users');
//include("../connect/connect_master_db.php");

$userid=$_GET['usr'];
$TrackerArray=trackers_array($TrackerResult,$userid,GetPrivilegeByID($userid,$UsersResult));
sort_by('tvehiclereg', $TrackerArray, SORT_ASC);
/*if ($privilege == 1){
$trackersquery= "SELECT `tuser`, `tvehiclereg`,`tdrivername`, `tunit` FROM `trks` where tuser=$userid";
}else if ($privilege == 2) {
$trackersquery = "SELECT `tuser`, `tvehiclereg`,`tdrivername`, `tunit`  FROM `trks` where 
 ((select umain from usrs where uid=`tuser`)='$userid' and (select uid from usrs where uid = `tuser`) <> '$userid')
 or (select uid from usrs where uid =`tuser`)='$userid' 
 or ((select umain from usrs where uid = `tuser`) in (select `uid` from usrs where umain ='$userid') )";
}else if ($privilege == 3){
$trackersquery = "SELECT `tuser`, `tvehiclereg`,`tdrivername`, `tunit`  FROM `trks` where 
 ((select umain from usrs where uid=`tuser`)=(select uid from usrs where uid ='$userid') and (select uid from usrs where uid = `tuser`) <> '$userid')
 or (select uid from usrs where uid =`tuser`)='$userid' ";
	
}else if ($privilege == 4){
$trackersquery = "SELECT `tuser`, `tvehiclereg`,`tdrivername`, `tunit`  FROM `trks` where  (select uid from usrs where uid =`tuser`)='$userid' ";
	
}

    $trackersStatment = $CompanyConn->query($trackersquery);*/
?>
<select id="SelectLeft" multiple="multiple" style="height:200px;width:100%">
          <?php

//while ($TrackerRow = $trackersStatment->fetch(PDO::FETCH_ASSOC))
foreach($TrackerArray as $TrackerRow)
{
    echo "<option value = " . $TrackerRow["tunit"] . ">" . $TrackerRow["tvehiclereg"].' | '. $TrackerRow["tdrivername"]. "</option>";
}
//$CompanyConn=null;
?>
   </select>