<?php
header('Content-Type: text/css');
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