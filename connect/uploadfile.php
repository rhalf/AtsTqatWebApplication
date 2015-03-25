<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../settings.php");
include_once("../scripts.php");
if (($privilege == 4) or ($privilege == 3)) {
    die;
}
include(ROOT_DIR."/connect/connect_master_db.php");


if ($_FILES["logofile"]["error"] > 0)
  {
  echo "Error: " . $_FILES["logofile"]["error"] . "<br />";
  }

$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $_FILES["logofile"]["name"]));
if ((($_FILES["logofile"]["type"] == "image/gif")
|| ($_FILES["logofile"]["type"] == "image/jpeg")
|| ($_FILES["logofile"]["type"] == "image/pjpeg")
|| ($_FILES["logofile"]["type"] == "image/png"))
&& ($_FILES["logofile"]["size"] < $MaxLogoFileSize)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["logofile"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["logofile"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["logofile"]["name"] . "<br />";
    echo "Type: " . $_FILES["logofile"]["type"] . "<br />";
    echo "Size: " . ($_FILES["logofile"]["size"] / 1024) . " Kb<br />";
	
	$settings=$session->get('settings');
    if (file_exists(ROOT_DIR."/iupload/" . get_setting('logo',$settings))){
      unlink(ROOT_DIR."/iupload/" . get_setting('logo',$settings));
    }

    if (file_exists(ROOT_DIR."/iupload/" . $_FILES["logofile"]["name"])){
      unlink(ROOT_DIR."/iupload/" . $_FILES["logofile"]["name"]);
    }
	  $filename=uniqid($company).'.'.$extension;
      move_uploaded_file($_FILES["logofile"]["tmp_name"],
      ROOT_DIR."/iupload/" .$filename );
	  
	  $UpdateLogoSQL = "Update settings set `svalue`='$filename' where skey ='logo'";
	  $CompanyConn->query($UpdateLogoSQL);	  
    }
  }
else
  {
  echo "Invalid file";
  }
$session->un_set('settings');  
 $SelectLogoSQL = "Select * from settings";
$settingsStatment=$CompanyConn->query($SelectLogoSQL);	
$settingsResult=$settingsStatment->fetchAll(PDO::FETCH_ASSOC);
$session->set('settings',$settingsResult);
 
$CompanyConn=null;   
?>