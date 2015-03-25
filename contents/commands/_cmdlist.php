<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
if (!isset($_GET['type'])) {
    die;
}
$type = $_GET['type'];

if ($type == '1' || $type == '2' || $type == '3') {
    echo "<option value ='0' selected='selected'>" . Select . "</option>";
    echo "<option value ='1'>" . constant($module . 'Locate') . "</option>";
    echo "<option value ='2'>" . constant($module . 'SetTimeInterval') . "</option>";
    echo "<option value ='3'>" . constant($module . 'SetOverSpeed') . "</option>";
    echo "<option value ='4'>" . constant($module . 'EngineOff') . "</option>";
    echo "<option value ='5'>" . constant($module . 'EngineOn') . "</option>";
    echo "<option value ='6'>" . constant($module . 'Reboot') . "</option>";
    echo "<option value ='7'>" . constant($module . 'CancelAlarm') . "</option>";
} else if ($type == '4') {
    echo "<option value ='0' selected='selected'>" . Select . "</option>";
    echo "<option value ='1'>" . constant($module . 'Locate') . "</option>";
    echo "<option value ='2'>" . constant($module . 'SetTimeInterval') . "</option>";
    echo "<option value ='3'>" . constant($module . 'SetOverSpeed') . "</option>";
    echo "<option value ='4'>" . constant($module . 'EngineOff') . "</option>";
    echo "<option value ='5'>" . constant($module . 'EngineOn') . "</option>";
    echo "<option value ='6'>" . constant($module . 'Reboot') . "</option>";
} else if ($type == '5') {
    echo "<option value ='0' selected='selected'>" . Select . "</option>";
    echo "<option value ='1'>" . constant($module . 'Locate') . "</option>";
    echo "<option value ='2'>" . constant($module . 'SetTimeInterval') . "</option>";
    echo "<option value ='3'>" . constant($module . 'SetOverSpeed') . "</option>";
    echo "<option value ='4'>" . constant($module . 'EngineOff') . "</option>";
    echo "<option value ='5'>" . constant($module . 'EngineOn') . "</option>";
    echo "<option value ='6'>" . constant($module . 'Reboot') . "</option>";
} else if ($type == '6') {
    echo "<option value ='0' selected='selected'>" . Select . "</option>";
    echo "<option value ='1'>" . constant($module . 'Locate') . "</option>";
    echo "<option value ='2'>" . constant($module . 'SetTimeInterval') . "</option>";
    echo "<option value ='3'>" . constant($module . 'SetOverSpeed') . "</option>";
    echo "<option value ='4'>" . constant($module . 'EngineOff') . "</option>";
    echo "<option value ='5'>" . constant($module . 'EngineOn') . "</option>";
    echo "<option value ='6'>" . constant($module . 'Reboot') . "</option>";
} else if ($type == '7') {
    echo "<option value ='0' selected='selected'>" . Select . "</option>";
    echo "<option value ='1'>" . constant($module . 'Locate') . "</option>";
    echo "<option value ='2'>" . constant($module . 'SetTimeInterval') . "</option>";
    echo "<option value ='3'>" . constant($module . 'SetOverSpeed') . "</option>";
    echo "<option value ='4'>" . constant($module . 'Reboot') . "</option>";
} else if ($type == '8') {
    echo "<option value ='0' selected='selected'>" . Select . "</option>";
    echo "<option value ='1'>" . constant($module . 'Locate') . "</option>";
    echo "<option value ='2'>" . constant($module . 'SetTimeInterval') . "</option>";
    echo "<option value ='3'>" . constant($module . 'SetOverSpeed') . "</option>";
    echo "<option value ='4'>" . constant($module . 'EngineOff') . "</option>";
    echo "<option value ='5'>" . constant($module . 'EngineOn') . "</option>";
    echo "<option value ='6'>" . constant($module . 'Reboot') . "</option>";
} else if ($type == '9') {
    echo "<option value ='0' selected='selected'>" . Select . "</option>";
}
?>
