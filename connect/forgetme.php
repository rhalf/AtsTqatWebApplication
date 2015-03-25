<?php

include_once('../settings.php');
include(ROOT_DIR . '/libraries/Classes/System_boot.php');
$cookie = new system_cookies;
$cookie->delete('tqat');
if (filter_input(INPUT_GET, 'mob') === NULL) {
    header("Location: $webroot/mobile/login.php");
} else {
    header("Location: $webroot/index.php");
}
?> 
