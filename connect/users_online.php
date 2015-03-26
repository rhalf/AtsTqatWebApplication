<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../settings.php");
include_once("../scripts.php");
include("connection.php");


$session=$session->getID();
$time=time();
//$time_check=$time-600; //SET TIME 10 Minute
$userIP=getIP();


$Getsql="SELECT * FROM usersonline WHERE session='$session'";
$Getresult=$Conn->query($Getsql);


$count=$Getresult->rowCount();
if($count=="0"){

$Insertsql="INSERT INTO usersonline(id,username,company,privilege,session, time,ip,starttime)VALUES(NULL,'$username','$company','$privilege','$session', '$time','$userIP','$time')";
$Insertresult=$Conn->query($Insertsql);
}

else {
$Updatesql="UPDATE usersonline SET time='$time',ip='$userIP' WHERE session = '$session'";
$Updateresult=$Conn->query($Updatesql);
}


// if over 10 minute, delete session 
//$Deletesql="DELETE FROM usersonline WHERE time<$time_check";
//$Deleteresult4=$Conn->query($Deletesql);

// Close connection
$Conn=null;
?>