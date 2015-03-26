<?php

include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

/*  
    Modified by: Rhalf Wendel D Caacbay
    Modified on: 20150318
    
    Note:
        *Remarks
            -Fixed! used the defined ROOT_DIR instead
            -Created $filename and compare
*/

if (!isset($_GET['file'])) {
    die;
}

$filename =  $_GET['file'];
$path = ROOT_DIR . "/";


if (strpos($filename,'fmr') === false) {
    $path = ROOT_DIR . "/fmr/$ApplicationVersion/";
} 

$fullPath = $path . $filename;

echo $fullPath;

if (file_exists($fullPath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($fullPath));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fullPath));
    ob_clean();
    flush();
    readfile($fullPath);
    exit;
}
?>