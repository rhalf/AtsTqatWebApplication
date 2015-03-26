<?php
header('Content-Type: text/css');

$jqpathcss='jquery.mobile-1.3.2/';
$jquerycss=array(
'jquerymobile'=>'jquery.mobile-1.3.2.min.css'
);
foreach ($jquerycss as $css)
{
include("$jqpathcss$css");			
};
?>