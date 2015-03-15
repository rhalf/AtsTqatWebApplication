<?php

header("Cache-Control: no-cache, must-revalidate");
header("content-type:text/html");

//$id=$_GET['id'];  
//1 File could not be accessed
//0 Only external files may be accessed
if (empty($_GET['url'])) {
    exit('File does not exist');
}
$url = $_GET['url'];
$http = substr($url, 0, 7);
if ($http != 'http://') {
    //Possible hacking attempt 
    exit('0');
}
@readfile($url) or exit('1');
?>
