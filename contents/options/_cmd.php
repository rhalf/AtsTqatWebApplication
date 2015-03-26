<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if (!is_form()) die;

include(ROOT_DIR."/connect/connect_master_db.php");

$settings=$session->get('settings');

/* Notification*/
 $narray=array(
	'ntrunning'=>isset($_POST['ntrunning'])?1:0,
	'ntparking'=>isset($_POST['ntparking'])?1:0,
	'ntidle'=>isset($_POST['ntidle'])?1:0,
	'ntoverspeed'=>isset($_POST['ntoverspeed'])?1:0,
	'nturgent'=>isset($_POST['nturgent'])?1:0,
	'ntgeofence'=>isset($_POST['ntgeofence'])?1:0,
	'ntlost'=>isset($_POST['ntlost'])?1:0,
	'ntbreakdown'=>isset($_POST['ntbreakdown'])?1:0,
 );

	$Array=array(
	 '`skey`'=>'notification_'.$userid,
	 '`svalue`'=>json_encode($narray)
	);
	
if(get_setting('notification_'.$userid,$settings)==''){
	$sql=build_insert("`settings`",$Array);	
}else{
	$sql = build_update("`settings`",$Array,"`skey`='notification_{$userid}'");
}
$CompanyConn->query($sql);

/*Grouping*/
$Array=array(
 '`skey`'=>'grouping_'.$userid,
 '`svalue`'=>isset($_POST['TGroupingBy'])?$_POST['TGroupingBy']:-1
);
	
if(get_setting('grouping_'.$userid,$settings)==''){
	$sql=build_insert("`settings`",$Array);	
}else{
	$sql = build_update("`settings`",$Array,"`skey`='grouping_{$userid}'");
}
$CompanyConn->query($sql);	

/*iconcaption*/
$Array=array(
 '`skey`'=>'iconcaption_'.$userid,
 '`svalue`'=>isset($_POST['iconcaption'])?$_POST['iconcaption']:-1
);
	
if(get_setting('iconcaption_'.$userid,$settings)==''){
	$sql=build_insert("`settings`",$Array);	
}else{
	$sql = build_update("`settings`",$Array,"`skey`='iconcaption_{$userid}'");
}
$CompanyConn->query($sql);	


/*TrkConnected*/
$Array=array(
 '`skey`'=>'TrkConnected_'.$userid,
 '`svalue`'=>isset($_POST['TrkConnected'])?1:0
);
	
if(get_setting('TrkConnected_'.$userid,$settings)==''){
	$sql=build_insert("`settings`",$Array);	
}else{
	$sql = build_update("`settings`",$Array,"`skey`='TrkConnected_{$userid}'");
}
$CompanyConn->query($sql);

/*ExcludeData*/
$Array=array(
 '`skey`'=>'ExcludeData_'.$userid,
 '`svalue`'=>isset($_POST['ExcludeData'])?1:0
);
	
if(get_setting('ExcludeData_'.$userid,$settings)==''){
	$sql=build_insert("`settings`",$Array);	
}else{
	$sql = build_update("`settings`",$Array,"`skey`='ExcludeData_{$userid}'");
}
$CompanyConn->query($sql);

	
/*gf_displaycheck*/
$Array=array(
 '`skey`'=>'gf_displaycheck_'.$userid,
 '`svalue`'=>isset($_POST['gf_displaycheck'])?1:0
);
	
if(get_setting('gf_displaycheck_'.$userid,$settings)==''){
	$sql=build_insert("`settings`",$Array);	
}else{
	$sql = build_update("`settings`",$Array,"`skey`='gf_displaycheck_{$userid}'");
}
$CompanyConn->query($sql);


$session->un_set('settings');
$SettingsSQL = "Select * from settings";
$settingsStatment=$CompanyConn->query($SettingsSQL);	
$settingsResult=$settingsStatment->fetchAll(PDO::FETCH_ASSOC);
$session->set('settings',$settingsResult);	


echo "Options Saved<br>";
$CompanyConn=null;

?>