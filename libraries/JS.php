<?php

include('../settings.php');
header("Content-type: text/javascript");
if (gps_debug == false) {
    $last_modified = filemtime(dirname(__FILE__) . "/JS.php");
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

ob_start();

include_once("../connect/func.php");

if (filter_input(INPUT_GET, 'files') === NULL) {
    die;
}
$files = filter_input(INPUT_GET, 'files');


$includeSession = false;
include('site/default.js');

// jquery
if ($files == 'site' or $files == 'login') {
    $array = array(
      'js/jquery-1.10.2.js',
      'js/jquery-ui-1.10.3.custom.min.js'
    );
    loadlib('jquery/jquery-ui-1.10.3/', $array);
}

// cookie
if ($files == 'site' or $files == 'login') {
    $array = array(
      'cookie' => 'jquery.cookie/jquery.cookie.js'
    );
    loadlib('jquery/', $array);
}

// layout
if ($files == 'site') {
    $array = array(
      'jquery.layout/jquery.layout-latest.min.js',
      'jquery.layout/myLayout.js'
    );
    loadlib('jquery/', $array);
}

if ($files == 'site' or $files == 'login') {
    $array = array(
      'jquery-dialogextend-master/build/jquery.dialogextend.js',
      'blueimp-jQuery-File-Upload-fe29267/js/jquery.fileupload.js'
    );
    loadlib('jquery/', $array);
}


if ($files == 'site' or $files == 'login') {
    $array = array(
      'jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.js',
      'ui.selectmenu/ui.selectmenu/jquery.ui.selectmenu.js',
      'ui.menubar/jquery.ui.menubar.js',
      'dropdown-check-list/ui.dropdownchecklist.min.js',
      'jQueryRotate/jQueryRotate.2.1.js',
      'noty/js/jquery.noty.js',
      'themes_switcher/themes/jquery.gcjs_themeswitcher_dialog.min.js',
      'ddslick/jquery.ddslick.js',
    );
    loadlib('jquery/', $array);
}

// google map
if ($files == 'site' && $active_googlemap) {
    $array = array(
      'maplabel.js',
      'googlemap_func.js'
    );
    loadlib('site/', $array);

    $_array = array(
      'google-maps-utility-library-v3/google_map_min/richmarker/richmarker-compiled.js'
    );
    loadlib('map/', $_array);
}

if ($files == 'site') {
    $array = array(
      'realtime_src.js',
      'poi_src.js',
      'drawing_geofence_src.js',
      'get_menu_trackers.js',
    );
    loadlib('site/', $array);
}


// site
if ($files == 'site') {
    $array = array(
      'jscolor/jscolor.js'
    );
    loadlib('', $array);
}


// site
if ($files == 'site') {
    $array = array(
      'bignum.js',
      'osmmap_func.js',
      'osmmap_func_ecma.js',
      'tabs.js',
      'tracking_replay.js'
    );
    loadlib('site/', $array);
}

if ($files == 'site' && $active_bingmap) {
    $array = array(
      'bingmap_func.js'
    );
    loadlib('site/', $array);
}


include('site/users.js');
include('site/module.js');





// grid
if ($files == 'site' or $files == 'login') {
    if (filter_input(INPUT_GET, 'lang') !== NULL) {
        $lng = filter_input(INPUT_GET, 'lang');
    } else {
        $lng = 'en';
    }
    $array = array(
      "js/i18n/grid.locale-{$lng}.js",
      'plugins/ui.multiselect.js',
      'js/jquery.jqGrid.min.js',
      'plugins/jquery.tablednd.js'
    );
    loadlib('jquery/jquery.jqGrid-4.5.2/', $array);
}


// spry
$array = array(
  'SpryData.js',
  'SpryUtils.js',
  'SpryValidationConfirm.js',
  'SpryValidationTextField.js',
  'SpryValidationPassword.js',
  'SpryValidationCheckbox.js',
  'SpryValidationRadio.js',
  'SpryValidationSelect.js',
  'SpryValidationTextarea.js'
);
loadlib('spry/', $array);

if ($files == 'site') {
    $di = new RecursiveDirectoryIterator(ROOT_DIR . '/contents');
    foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
        if ($file->isFile()) {
            if ($file->getFilename() == '_js.php') {
                include_once($filename);
            }
        }
    }
}


ob_end_flush();
?>