<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../settings.php");
include_once("../scripts.php");
?>
<div class="header-logo">
    <div class="header-image">
    </div>
    <div class="header-title">
        <h1><a id="aboutbtn" href="javascript:void(0);"><?PHP echo Title; ?></a></h1>
    </div>
</div>
<div class="header-menu">

    <div style="float:left">
        <div style="position:fixed;direction:<?PHP echo text_direction; ?>">
            <ul id="mainMenubar" style="width:100%;" class="menubar ui-corner-top">
                <?php if ($privilege == 1) { ?>
                    <li> <a href="javascript:void(0);"><?php echo System ?></a>
                        <ul>
                            <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/company.png" /></span><a id="companiesMnuItem" href="javascript:void(0);"><?PHP echo Companies; ?></a></li>
                            <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/db.png" /></span><a id="dbhostsMnuItem" href="javascript:void(0);"><?PHP echo DBHosts; ?></a></li>
                            <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/http.png" /></span><a id="httphostsMnuItem" href="javascript:void(0);"><?PHP echo HTTPHosts; ?></a></li>
                            <li></li>
                            <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/trackers.png" /></span><a id="alltrackersMnuItem" href="javascript:void(0);"><?PHP echo AllTrackers; ?></a></li>
                            <li></li>                
                            <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/database.png" /></span><a id="dbsizeMnuItem" href="javascript:void(0);"><?PHP echo DBSize; ?></a></li>
                            <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/info.png" /></span><a id="serverstatusMnuItem" href="javascript:void(0);"><?php echo ServerStatus ?></a></li>
                            <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/online.png" /></span><a id="usersonlineMnuItem" href="javascript:void(0);"><?php echo UsersOnline ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
                <li> <a href="javascript:void(0);"><?php echo Administration ?></a>
                    <ul>
                        <?php if ($privilege != 4) { ?>
                            <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/users.png" /></span> <a id="usersMnuItem" href="javascript:void(0);"><?php echo Users ?></a>
                                <ul>
                                    <li><a id="newUserMnuItem" href="javascript:void(0);"><?php echo NewUser ?></a></li>
                                    <li><a id="allUsersMnuItem" href="javascript:void(0);"><?php echo ShowAllUsers ?></a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/collections.png" /></span><a id="collectionsMnuItem" href="javascript:void(0);"><?php echo Collections ?></a></li>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/trackers.png" /></span> <a id="trackersMnuItem" href="javascript:void(0);"><?php echo Trackers ?></a>
                            <ul>
                                <?php if ($privilege == 1) { ?>
                                    <li><a id="newTrkMnuItem" href="javascript:void(0);"><?php echo AddTracker ?></a></li>
                                <?php } ?> 
                                <li><a id="allTrksMnuItem" href="javascript:void(0);"><?php echo ShowAllTrackers ?></a></li>
                                <?php if ($privilege != 4) { ?>
                                    <li><a id="distributeMnuItem" href="javascript:void(0);"><?php echo Distribute ?></a></li> 
                                <?php } ?>                   
                            </ul>
                        </li>
                        <li></li>
                        <li><a id="myAccountMnuItem" href="javascript:void(0);"><?php echo MyAccount ?></a></li>
                        <li><a id="companyAccountMnuItem" href="javascript:void(0);"><?php echo CompanyInfo ?></a></li>
                        <li></li>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/commands.png" /></span><a id="commandsMnuItem" href="javascript:void(0);"><?php echo Commands ?></a></li>
                        <li></li>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/options.png" /></span><a id="optionsMnuItem" href="javascript:void(0);"><?php echo Options ?></a></li>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/themes.png" /></span><a id="themesMnuItem" href="javascript:void(0);"><?php echo Themes ?></a></li>
                        <li></li>
                        <li><a id="logoutMnuItem" href="javascript:void(0);"><?php echo Logout ?></a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);"><?php echo MapTools ?></a>
                    <ul>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/map.png" /></span><a id="mapManagerMnuItem" href="javascript:void(0);"><?php echo MapsManager ?></a></li>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/maptools.png" /></span><a id="mapToolsMnuItem" href="javascript:void(0);"><?php echo MapTools ?></a></li>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/geofences.png" /></span><a id="geoFencesMnuItem" href="javascript:void(0);"><?php echo Geofences ?></a></li>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/pois.png" /></span><a id="poisMnuItem" href="javascript:void(0);"><?php echo Pois ?></a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);"><?php echo Reports ?></a>
                    <ul>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/historical.png" /></span><a id="historicalMnuItem" href="javascript:void(0);"><?php echo HistoricalReport ?></a></li>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/log.png" /></span><a id="logMnuItem" href="javascript:void(0);"><?php echo LogReport ?></a></li>
                        <li><span class="menu-span-image"><img width="16px" height="16px" src="images/admin/download.png" /></span><a id="downloadMnuItem" href="javascript:void(0);"><?php echo Download ?></a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);"><?php echo Help ?></a>
                    <ul>
                        <li><a id="iconsChartMnuItem" href="javascript:void(0);"><?php echo IconsChart; ?></a></li>
                        <li><a id="aboutMnuItem" href="javascript:void(0);"><?php echo About ?></a></li>
                    </ul>
                </li>
                <li>
            </ul>
        </div>
    </div>
</div>
<div class="header-info"></div>

<script type="text/javascript">
    $(function() {

        $("#mainMenubar").menubar({
            autoExpand: true,
            menuIcon: true,
            buttons: true
        });
        $('#allUsersMnuItem').click(function(e) {
            create_users();
            return false;
        });

        $('#usersMnuItem').click(function(e) {
            create_users();
            return false;
        });

        $('#newUserMnuItem').click(function(e) {
            create_a_user();
            return false;
        });

        $('#collectionsMnuItem').click(function(e) {
            create_colls();
            return false;
        });

        $('#trackersMnuItem').click(function(e) {
            create_trackers();
            return false;
        });

        $('#allTrksMnuItem').click(function(e) {
            create_trackers();
            return false;
        });
<?php if ($privilege == 1) { ?>
            $('#newTrkMnuItem').click(function(e) {
                create_a_tracker();
                return false;
            });
<?php } ?>

        $("#iconsChartMnuItem").click(function() {
            create_iconschart();
            return false;
        });

        $('#companyAccountMnuItem,#cmpinfo').click(function(e) {
            create_companyinfo();
            return false;
        });

        $("#aboutMnuItem,#aboutbtn,#imagebtn").click(function() {
            create_about();
            return false;
        });

        $("#myAccountMnuItem,#curruserbtn").click(function() {
            create_e_user('<?php echo $userid ?>');
            return false;
        });

        $("#commandsMnuItem").click(function() {
            create_commands();
            return false;
        });

        $("#optionsMnuItem").click(function() {
            optionsDialog.Open();
            return false;
        });


        $("#historicalMnuItem").click(function() {
            create_historicalreport();
        });


        $("#downloadMnuItem").click(function() {
            create_download();
            return false;
        });

        $("#logMnuItem").click(function() {
            create_logreport();
            return false;
        });

        $("#logoutMnuItem").click(function() {
            window.location = 'connect/userlogout.php';
            ;
        });

        $('#mapManagerMnuItem').click(function(e) {
            mapsmanagerDialog.Open();
            return false;
        });
<?php if ($privilege != 4) { ?>
            $('#distributeMnuItem').click(function(e) {
                create_distribute();
                return false;
            });
<?php } ?>

        $('#poisMnuItem').click(function(e) {
            poisDialog.Open();
            return false;
        });

        $('#geoFencesMnuItem').click(function(e) {
            geofencesDialog.Open();
            return false;
        });

        $('#mapToolsMnuItem').click(function(e) {
            if (MapClass.currMap == 'gmap') {
                create_googlemaptools();
            } else if (MapClass.currMap == 'omap') {
                create_osmmaptools();
            } else if (MapClass.currMap == 'bmap') {
                create_bingmaptools();
            }
            return false;
        });

<?php if ($privilege == 1) { ?>
            $('#companiesMnuItem').click(function(e) {
                create_cmps();
                return false;
            });

            $('#dbhostsMnuItem').click(function(e) {
                create_dbhosts();
                return false;
            });

            $('#httphostsMnuItem').click(function(e) {
                create_httphosts();
                return false;
            });

            $('#alltrackersMnuItem').click(function(e) {
                create_alltrackers();
                return false;
            });

            $('#dbsizeMnuItem').click(function(e) {
                create_dbsize();
                return false;
            });

            $('#serverstatusMnuItem').click(function(e) {
                create_serverstatus();
                return false;
            });

            $('#usersonlineMnuItem').click(function(e) {
                create_usersonline();
                return false;
            });
<?php } ?>
        create_options();
        create_geofences();
        create_pois();
        create_mapsmanager();
        $("#themesMnuItem").gcjs_themeswitcher_dialog.gcjs_m_add_theme({theme: "Dark (Default)", pic: "theme_90_black.png", file: "black/theme.php"});
        $("#themesMnuItem").gcjs_themeswitcher_dialog.gcjs_m_add_theme({theme: "Crystal Ice Blue", pic: "theme_90_white.png", file: "white/theme.php"});
       
        /*     
                Modified by: Mary Ann Lacerona
                Date Modified: 20150324

                Note: 
                        Added Theme
        */       
        $("#themesMnuItem").gcjs_themeswitcher_dialog.gcjs_m_add_theme({theme: "Steel Chrome Grey", pic: "theme_90_smoothness.png", file: "smoothness/theme.php"});
        /*     
                Modified by: Mary Ann Lacerona
                Date Modified: 20150331

                Note: 
                        Added Theme
        */  
        $("#themesMnuItem").gcjs_themeswitcher_dialog.gcjs_m_add_theme({theme: "Coffee Brown", pic: "theme_90_humanity.png", file: "humanity/theme.php"});
        $("#themesMnuItem").gcjs_themeswitcher_dialog({s_title: "Select Theme", number_pics: 1, url_gallery: "libraries/jquery/themes_switcher/themes/theme_gallery/", url_css: "libraries/jquery/themes_switcher/themes/theme_css/"});

        $("#theme_close").button({icons: {primary: "ui-icon-close"}});

    });

    $(document).ready(function() {
        build_menus();
<?php if (text_direction == 'rtl') { ?>
            $('.ui-icon-carat-1-e').removeClass('ui-icon-carat-1-e').addClass('ui-icon-carat-1-w');
<?php } ?>
        $('.header-info').load("main/main_header_info.php");
        $('.header-image').load("main/main_header_image.php");

    });
    CheckUserOnline();
    setInterval(function() {
        CheckUserOnline();
    }, 120000);
</script>