<?php

include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
$path = $_SERVER['DOCUMENT_ROOT'] . "/fmr/$ApplicationVersion/";
if (!isset($_GET['file'])) {
    die;
}
$fullPath = $path . $_GET['file'];
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