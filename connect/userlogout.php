 <?php
include_once('../settings.php');
include(ROOT_DIR.'/libraries/Classes/System_boot.php');

include(ROOT_DIR."/connect/session_func.php");

$session->logout();
if (isset($_GET['mob'])){
header("Location: $webroot/mobile/login.php");	
}else{
header("Location: $webroot/index.php");
	}

?> 
