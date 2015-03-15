<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
//include(ROOT_DIR."/connect/connect_master_db.php");


$id=$_GET['id'];
//$newPriv=$_GET['new'];
/* $sql = "select * from usrs where uid='$id'";
    $query = $CompanyConn->query($sql);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row['upriv'] == 1)
    {
      echo 1;
    } else
        if ($row['upriv'] == 2)
        {
       echo  2;
        } else
            if ($row['upriv'] == 3)
            {
       echo  3;
            } else
                if ($row['upriv'] == 4)
                {
        echo  4;
                }
				
$CompanyConn=null;	*/

$UsersResult=$session->get('users');
foreach($UsersResult as $row){
	if($row['uid']==$id){
	   echo	$parentPrivilege=$row['upriv'];	
	   break;
	}
}
?>