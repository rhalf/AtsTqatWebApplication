<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../settings.php");
include_once("../scripts.php");
if (($privilege == 4) or ($privilege == 3)) {
    die;
}
include(ROOT_DIR."/connect/connect_master_db.php");

$settings=$session->get('settings');
    if (file_exists(ROOT_DIR."/iupload/" . get_setting('logo',$settings))){
      unlink(ROOT_DIR."/iupload/" . get_setting('logo',$settings));
    }
  

$ResetLogoSQL = "Update settings set `svalue`='default' where `skey` ='logo'";		
$CompanyConn->query($ResetLogoSQL);	

$session->un_set('settings');  
 $SelectLogoSQL = "Select * from settings";
$settingsStatment=$CompanyConn->query($SelectLogoSQL);	
$settingsResult=$settingsStatment->fetchAll(PDO::FETCH_ASSOC);
$session->set('settings',$settingsResult);
			
$CompanyConn=null;		
?>