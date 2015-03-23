<?php
<<<<<<< HEAD
//20150323
=======

//Modified by chini
>>>>>>> origin/master
header("Cache-Control: no-cache, must-revalidate");
include_once("settings.php");
include_once("scripts.php");

include(ROOT_DIR . "/connect/mobile_check.php");
include(ROOT_DIR . "/connect/connect_master_db.php");
include(ROOT_DIR . "/contents/users/_sql.php");

include(ROOT_DIR . "/contents/collections/_sql.php");

include(ROOT_DIR . "/contents/geofence/_sql.php");
$session->set('users', $UsersResult);
$session->set('colls', $CollResult);

$session->set('geofence', $GeoFenceResult);

include(ROOT_DIR . "/contents/poi/_sql.php");
$session->set('pois', $PoisResult);



$SettingsSQL = "Select * from settings";
$settingsStatment = $CompanyConn->query($SettingsSQL);
$settingsResult = $settingsStatment->fetchAll(PDO::FETCH_ASSOC);
$session->set('settings', $settingsResult);


$CompanyConn = null;

include(ROOT_DIR . "/connect/connection.php");
include(ROOT_DIR . "/contents/trackers/_sql.php");
$session->set('trackers', $TrackersResult);

include(ROOT_DIR . "/contents/dbhost/_sql.php");
$session->set('dbhosts', $Result);
include(ROOT_DIR . "/contents/httphost/_sql.php");
$session->set('httphosts', $Result);

if ($privilege == 1) {
    include(ROOT_DIR . "/contents/companies/_sql.php");
    $session->set('cmps', $Result);
    include(ROOT_DIR . "/contents/alltrackers/_sql.php");
    $session->set('alltrackers', $TrackersResult);
}
?>
<!DOCTYPE HTML>

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="images/admin/favicon.ico" type="image/x-icon" />
    <title><?PHP echo Title; ?></title>
    <script type="text/javascript" src="libraries/map/OpenLayers-2.12/OpenLayers.js"></script>
    <?php if ($active_googlemap) { ?>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;libraries=geometry&language=<?php echo $_SESSION['language']; ?>"></script>
    <?php } ?>
    <?php if ($active_bingmap) { ?>
        <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
    <?php } ?>
    <link type="text/css" href="libraries/CSS.php?files=site&dir=<?php echo text_direction ?>" rel="stylesheet">
    <script type="text/javascript" src="libraries/site/lang.php"></script>
    <script type="text/javascript" src="libraries/JS.php?files=site&lang=<?php echo $language ?>"></script>
    <?php if ($active_ovimap) { ?> 
        <script src="http://api.maps.ovi.com/jsl.js" type="text/javascript" charset="utf-8">
        </script>
    <?php } ?>
    <?php if ($active_nokiamap) { ?> 
        <script src="http://js.api.here.com/se/2.5.3/jsl.js?with=all" type="text/javascript" charset="utf-8">
        </script>
    <?php } ?>
    <?php if ($active_arcgismap) { ?>   
        <link rel="stylesheet" href="http://js.arcgis.com/3.7/js/esri/css/esri.css">
        <script src="http://js.arcgis.com/3.7/"></script>
    <?php } ?>
</head>
<body onload="hideLoadingLayer();
            create_map_tab(default_mapLabel, DefaultSettings.default_map, 'normal');">
    <div id="loading_layer"><img src="images/admin/loading.gif" alt="" width="550" height="400" border="0" /></div>
    <!--layout-center-->
    <div class="ui-layout-center" style="padding:0 0 0 0;margin:0 0 0 0;overflow:hidden" >
        <div id="maptabs" class="fulldiv" style="overflow:hidden">
            <ul id="ulmaps" style="width:100%;padding:0 0 0 0;margin:0 0 0 0">
            </ul>
        </div>
    </div>
    <!--layout-north-->
    <div id="maintop" class="ui-layout-north ui-state-default" style="padding:0 0 0 0;margin:0 0 0 0;height:80px;overflow:hidden"> </div>
    <!--layout-south-->
    <div class="ui-layout-south" style="height:100%;width:100%;padding:0 0 0 0;margin:0 0 0 0;overflow-x:hidden">
        <div id="layout-south_tabs" style="height:100%;width:100%;padding:0 0 0 0;margin:0 0 0 0;overflow:hidden">
            <ul style="width:100%;padding:0 0 0 0;margin:0 0 0 0">
                <li><a href="#trackinggrid" onClick="resizeRealtimeGrid();"><?php echo Realtime; ?></a></li>
                <li id="treplayli" style="display:none" ><a href="#treplay"><?php echo TrackingReplay; ?></a></li>
            </ul>
            <div id="trackinggrid" align="center" style="height:100%;width:100%;padding:0 0 0 0;margin:0 0 0 0"> </div>
            <div id="treplay" align="center" style="height:100%;width:100%;padding:0 0 0 0;margin:0 0 0 0"> </div>
        </div>
    </div>

    <!--layout-east-->
    <div class="ui-layout-east ui-state-default" style="padding:0 0 0 0;margin:0 0 0 0;width:100%;height:100%;overflow:hidden" >
        <div id="rightdiv" style="width:100%;height:100%;padding:0 0 0 0;margin:0 0 0 0;overflow:hidden"></div>
    </div>
</body>
</html>
<script type="text/javascript">
    InitSite();
</script>