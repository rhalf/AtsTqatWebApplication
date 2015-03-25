<?php

include('../settings.php');
header('Content-Type: text/css');
if (gps_debug == false) {
    $last_modified = filemtime(dirname(__FILE__) . "/CSS.php");
    $expires = 60 * 60 * 24 * 365;

    header('Last-Modified : ' . gmdate('D, d M Y H:i:s \G\M\T', $last_modified));
    header('Cache-Control : max-age=' . $expires . ', must-revalidate');
    header('Expires: ' . gmdate('D, d M Y H:i:s', $last_modified + $expires) . ' GMT');
    if (filter_input(INPUT_SERVER, 'HTTP_IF_MODIFIED_SINCE') !== NULL OR filter_input(INPUT_SERVER, 'HTTP_IF_NONE_MATCH') !== NULL) {
        if (filter_input(INPUT_SERVER, 'HTTP_IF_MODIFIED_SINCE') == gmdate('D, d M Y H:i:s \G\M\T', $last_modified)) {
            header('HTTP/1.0 304 Not Modified');
            return;
        }
    }
}
if (filter_input(INPUT_GET, 'files') === NULL) {
    die;
}

include_once("../connect/func.php");
include('site/main.css');

if (filter_input(INPUT_GET, 'dir') !== NULL) {
    if (filter_input(INPUT_GET, 'dir') == 'rtl') {
        $array = array('rtl.css');
    } else {
        $array = array('ltr.css');
    }
    loadlib('site/', $array);
}



$files = filter_input(INPUT_GET, 'files');
if ($files == 'site' or $files == 'login') {
    $array = array(
      'jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.css',
      'ui.selectmenu/ui.selectmenu/jquery.ui.selectmenu.css',
      'ui.menubar/jquery.ui.menubar.css',
      'dropdown-check-list/ui.dropdownchecklist.themeroller.css',
      'noty/css/jquery.noty.css',
      'noty/css/noty_theme_default.css',
      'ddslick/ddslick.css',
      'blueimp-jQuery-File-Upload-fe29267/css/jquery.fileupload-ui.css'
    );
    loadlib('jquery/', $array);
}

// layout
if ($files == 'site') {
    $array = array(
      'jquery.layout/layout-default-latest.css'
    );
    loadlib('jquery/', $array);
}

if ($files == 'site' or $files == 'login') {
    $array = array(
      'jquery-dialogextend-master/build/jquery.dialogextend.css'
    );
    loadlib('jquery/', $array);
}

if ($files == 'site' or $files == 'login') {
    $array = array(
      'jquery.jqGrid-4.5.2/css/ui.jqgrid.css',
      'jquery.jqGrid-4.5.2/plugins/ui.multiselect.css'
    );
    loadlib('jquery/', $array);
}


if ($files == 'site') {
    $array = array(
      'map.css'
    );
    loadlib('site/', $array);
}

// spry
$array = array(
  'SpryValidationConfirm.css',
  'SpryValidationTextField.css',
  'SpryValidationTextarea.css',
  'SpryValidationSelect.css',
  'SpryValidationPassword.css'
);
loadlib('spry/', $array);
?>