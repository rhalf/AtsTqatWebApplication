<?php
$last_modified = filemtime(dirname(__FILE__)."/theme.php");
$expires =  60 * 60 * 24*365;
header('Content-Type: text/css');
header('Last-Modified : '.gmdate('D, d M Y H:i:s \G\M\T', $last_modified));
header('Cache-Control : max-age='.$expires.', must-revalidate');
header('Expires: '. gmdate('D, d M Y H:i:s',  $last_modified+$expires).' GMT');
if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) OR isset($_SERVER['HTTP_IF_NONE_MATCH'])) 
{
	if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == gmdate('D, d M Y H:i:s \G\M\T', $last_modified)) 
	{
		header('HTTP/1.0 304 Not Modified');
		return;
	}
} 
// theme
$array=array(	
	'jquery.ui.theme.min.css',
	'jquery.ui.core.min.css',
	'jquery.ui.accordion.min.css',
	'jquery.ui.autocomplete.min.css',
	'jquery.ui.button.min.css',
	'jquery.ui.datepicker.min.css',
	'jquery.ui.dialog.min.css',
	'jquery.ui.menu.min.css',
	'jquery.ui.progressbar.min.css',
	'jquery.ui.resizable.min.css',
	'jquery.ui.selectable.min.css',
	'jquery.ui.slider.min.css',
	'jquery.ui.spinner.min.css',
	'jquery.ui.tabs.min.css',
	'jquery.ui.tooltip.min.css',
);
	foreach ($array as $js){
		include("minified/$js");			
	};

?>