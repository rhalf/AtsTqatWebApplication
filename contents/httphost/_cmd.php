<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once ("../../scripts.php");
include("_start.php");

if(!isset($_GET['type']))die;
if($privilege!=1)die;
$type=$_GET['type'];

if ($type==2 or $type==3){
	if (!isset($_GET['id']))die;
	$id=$_GET['id'];
}

if($type==1){
$code=$module_add;	
}else if ($type==2){
$code=$module_edit;	
}

include (ROOT_DIR."/connect/connection.php");

if($type==1 or $type==2){	
$Array=array(
'`httphostname`'=> $_POST[$code.'hostname'],
'`httphostip`'=> $_POST[$code.'hostip'],
'`httpport`'=>$_POST[$code.'liveport'],
'`cmdport`'=>$_POST[$code.'cmdport']
);
}
if ($type==1){
$sql=build_insert('`httphosts`',$Array);
}else if($type==2){
$sql=build_update('`httphosts`',$Array,"`httphostid`='$id'");	
}else if($type==3){
$sql="delete FROM `httphosts` WHERE `httphostid`= '$id' ;";	
}

$Conn->query($sql);

$session->un_set('httphosts');
include("_sql.php");
$session->set('httphosts',$Result);


echo "One host edited";
$Conn=null;

?>