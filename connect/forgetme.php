<?php

include_once('../settings.php');
include(ROOT_DIR . '/libraries/Classes/System_boot.php');
$cookie = new system_cookies;
$cookie->delete('tqat');
if (isset($_GET['mob'])) {
    header("Location: $webroot/mobile/login.php");
} else {
    header("Location: $webroot/index.php");
}
?> 
