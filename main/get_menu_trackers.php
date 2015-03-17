<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../settings.php");
include_once("../scripts.php");

$settings = $session->get('settings');

$grouping = get_setting('grouping_' . $userid, $settings);

if ($grouping == '') {
    if ($privilege == 1) {
        $grouping = '0';
    } else {
        $grouping = '1';
    }
}

$CollectionsResult = $session->get('colls');
$UsersResult = $session->get('users');
$TrackersResult = $session->get('trackers');
$HTTPHostsResult = $session->get('httphosts');


if ($privilege == 1) {
    $cmpsResult = $session->get('cmps');
    $alltrksResult = $session->get('alltrackers');
}
?>
<script type="text/javascript">
    var grouping = '<?php echo $grouping ?>';
    Http.Clear();
<?php foreach ($HTTPHostsResult as $row) { ?>
        Http.add('<?php echo $row['httphostid'] ?>', '<?php echo $row['httphostname'] ?>', '<?php echo $row['httphostip'] ?>', '<?php echo $row['httpport'] ?>', '<?php echo $row['cmdport'] ?>');
 <?php } ?>   
</script>

<script type="text/javascript">
    $('#searchbox').keyup(function() {
        search_trackers();
    });

    $(document).ready(function() {
        $("#accordion_trackers").accordion({
            autoHeight: true,
            navigation: true,
            collapsible: true,
            animate: {duration: 50}
        });
    });
    build_popups();


    $(document).ready(function() {
        build_menus();
    });

</script>
<!--top div-->
<div class="ui-state-default" style="height:65px;">
    <div align="center"  style="height:100%;">
        <table width="100%" border="0">
            <tr>
                <td width="75%" align="center" valign="middle"><div style="width:100%">
                        <select name="search_user" id="search_user" style="width:100%;margin:0 0 0 0">
                            <?php
                            if ($grouping == "0") {
                                if ($privilege == 1) {
                                    echo "<option value = '-1'>" . SelectUser . "</option>";
                                    foreach ($cmpsResult as $row) {
                                        echo "<option value = " . $row["cmpid"] . ">" . $row["cmpdisplayname"] . "</option>";
                                    }
                                }
                            } else if ($grouping == "1") {
                                echo "<option value = '-1'>" . SelectUser . "</option>";
                                if ($privilege == 1 or $privilege == 2 or $privilege == 3) {
                                    echo "<option value = '0'>" . $username . "</option>";
                                }
                                foreach ($UsersResult as $row) {
                                    if ($row["uid"] !== $userid) {
                                        echo "<option value = " . $row["uid"] . ">" . $row["uname"] . "</option>";
                                    }
                                }
                            } else if ($grouping == "2") {
                                echo "<option value = '-1'>" . Selectstate . "</option>";
                                echo "<option value = '0'>" . RunningSection . "</option>";
                                echo "<option value = '1'>" . ParkingSection . "</option>";
                                echo "<option value = '2'>" . IdleSection . "</option>";
                                echo "<option value = '3'>" . AlarmSection . "</option>";
                                echo "<option value = '4'>" . LostSection . "</option>";
                                echo "<option value = '5'>" . AllSection . "</option>";
                            } else if ($grouping == "3") {
                                echo "<option value = '-1'>" . SelectCollection . "</option>";
                                foreach ($CollectionsResult as $row) {
                                    echo "<option value = " . $row["collid"] . ">" . $row["collname"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div></td>
                <td width="65px" align="right" valign="middle"><div>
                        <div style="height:26px">
                            <button style="height:26px;width:35px;vertical-align:top" class="checktoggle"><span id="topcheck" class="ui-icon ui-icon-minus"></span></button>
                            <button style="height:26px;width:25px;vertical-align:top" class="select"></button>
                        </div>
                        <ul style="text-align:center">
                            <li class="ui-widget-content" style="border:none;" onclick="$('#topcheck').attr('class', 'ui-icon ui-icon-check');
                                    SearchSectionCheck(true, 'alltrackers');"><a class="checkall" href="#"></a></li>
                            <li class="ui-widget-content" style="border:none" onclick="$('#topcheck').attr('class', 'ui-icon ui-icon-minus');
                                    ClearGridRealTime();
                                    SearchSectionCheck(false, 'alltrackers')"><a class="uncheckall" href="#"></a></li>
                            <li class="ui-widget-content" style="border:none" onclick="$('#topcheck').attr('class', 'ui-icon ui-icon-transferthick-e-w');
                                    ClearGridRealTime();
                                    SearchSectionCheck(-1, 'alltrackers')"><a class="checkinvert" href="#"></a></li>
                        </ul>
                    </div></td>
            </tr>
        </table>
        <div style='width:100%;height:100%;padding-left:0;padding-right:0px'>
            <div style="width:100%" >
                <table width='100%' border='0'>
                    <tr>
                        <td align='left' style='padding:0;margin:0' width='10%'>
                            <span class="ui-icon ui-icon-wrench" style="float:left"></span>

                            <div class="ui-widget-content section-popup" style="position:fixed;border-radius:5px;direction:<?php echo text_direction ?>">
                                <ul style="width:200px;padding-left:5px">
                                    <li style="background:none">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td><a class="mapchooser" href="#" ></a></td>
                                                <td>
                                                    <select class="section-map" onchange="setSectionMap(0, $(this).val())" style='width:150px'>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                </ul>      
                            </div> 

                        </td>
                        <td align='left' style='padding:0;margin:0'>
                            <input placeholder="<?php echo SearchTip ?>" class="search ui-state-default" name="searchbox" id="searchbox" type="text" style="width:100%;direction:<?php echo text_direction ?>" onkeypress="DoSearch();" />
                        </td>
                        <td width="65px" align="center"><div>
                                <div style="height:26px">
                                    <button style="height:26px;width:35px;vertical-align:top" class="checktoggle">
                                        <span id="searchcheck" class="ui-icon ui-icon-minus"></span></button>
                                    <button style="height:26px;width:25px;vertical-align:top" class="select"></button>
                                </div>
                                <ul>
                                    <li class="ui-widget-content" style="border:none" onclick="$('#searchcheck').attr('class', 'ui-icon ui-icon-check');
                                            SearchSectionCheck(true, 'resultsearch');"><a class="checkall" href="#"></a></li>
                                    <li class="ui-widget-content" style="border:none" onclick="$('#searchcheck').attr('class', 'ui-icon ui-icon-minus');
                                            SearchSectionCheck(false, 'resultsearch');
                                            ClearGridRealTime();"><a class="uncheckall" href="#"></a></li>
                                    <li class="ui-widget-content" style="border:none" onclick="$('#searchcheck').attr('class', 'ui-icon ui-icon-transferthick-e-w');
                                            SearchSectionCheck(-1, 'resultsearch');
                                            ClearGridRealTime();"><a class="checkinvert" href="#"></a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!--end top div-->

<div id="alltrackers" class="ui-widget-content" style="height:85%;overflow:auto">
    <table class="fulldiv" width="100%" height="100%" border="0" >
        <tr style="height:100%;width:100%">
            <td align="left" colspan="2" valign="top" scope="col" style="overflow:auto" ><form id="tracker_tree_form" name="tracker_tree_form" style="overflow:auto" onsubmit="return false;">
                    <!--search div-->
                    <div class="fulldiv">
                        <div id="resultsearch" style="width:100%;height:100%"> </div>
                    </div>
                    <!--end search div-->
                    <div class="fulldiv" id="accordion_trackers" style="width:100%;height:100% !important;overflow-y:auto;overflow-x:hidden;border:none">
                        <?php
                        if ($grouping == "0") {
                            if ($privilege == 1) {
                                $trksArray = array();
                                foreach ($cmpsResult as $cmp) {
                                    $trksArray = array();
                                    foreach ($alltrksResult as $tracker) {
                                        if ($cmp['cmpdbname'] == $tracker['tcmp']) {
                                            $trksArray[] = $tracker;
                                        }
                                    }
                                    $trksCount = count($trksArray);
                                    echo AddSection($cmp['cmpdisplayname'], $cmp['cmpid'], $trksCount, TrackerCount, 0, $privilege);
                                    echo "</div></div>";
                                }
                            }
                        } else if ($grouping == "1") {
                            ?>
                            <!--user div-->
                            <?php
                            $TrackersArray = trackers_array($TrackersResult, $userid, $privilege);
                            $user_num_rows = count($TrackersArray);
                            echo AddSection($username, $userid, $user_num_rows, TrackerCount, 1, $privilege);

                            foreach ($TrackersArray as $row) {
                                echo CreateTracker($row, $privilege);
                            }
                            echo "</div></div>";
                            ?>
                            <!--end userid div--> 
                            <!--end user div--> 
                            <!--sub users div-->
                            <?php
                            $subusersArray = get_subUsers($UsersResult, $userid);
                            foreach ($subusersArray as $subuserrow) {
                                $subuserid = $subuserrow["uid"];
                                $subusername = $subuserrow["uname"];
                                $subusers_trackersArray = trackers_array($TrackersResult, $subuserid, $subuserrow["upriv"]);
                                $subusers_trackersCount = count($subusers_trackersArray);
                                echo AddSection($subusername, $subuserid, $subusers_trackersCount, TrackerCount, 1, $privilege);
                                foreach ($subusers_trackersArray as $st) {
                                    echo CreateTracker($st, $privilege);
                                }
                                echo "</div></div>";
                            }
                            ?>
                            <!--end subuserid div--> 
                            <!--end sub users div--> 
                            <!--end user grouping -->
                            <?php
                        } else if ($grouping == '2') {

                            echo AddSection(RunningSection, 'Running', 0, TrackerCount, 2, $privilege);
                            echo "</div></div>";
                            echo AddSection(ParkingSection, 'Parking', 0, TrackerCount, 2, $privilege);
                            echo "</div></div>";
                            echo AddSection(IdleSection, 'Idle', 0, TrackerCount, 2, $privilege);
                            echo "</div></div>";
                            echo AddSection(OverSpeedSection, 'OverSpeed', 0, TrackerCount, 2, $privilege);
                            echo "</div></div>";
                            echo AddSection(UrgentSection, 'Urgent', 0, TrackerCount, 2, $privilege);
                            echo "</div></div>";
                            echo AddSection(GeoFenceSection, 'GeoFence', 0, TrackerCount, 2, $privilege);
                            echo "</div></div>";
                            echo AddSection(BreakDownSection, 'BreakDown', 0, TrackerCount, 2, $privilege);
                            echo "</div></div>";
                            echo AddSection(LostSection, 'Lost', 0, TrackerCount, 2, $privilege);
                            echo "</div></div>";

                            $Trackers_num_rows = count($TrackersResult);
                            echo AddSection(AllSection, 'All', $Trackers_num_rows, TrackerCount, 2, $privilege);
                            foreach ($TrackersResult as $TR) {
                                echo CreateTracker($TR, $privilege);
                            }

                            echo "</div></div>";
                        } else if ($grouping == '3') {

                            foreach ($CollectionsResult as $row) {
                                $collid = $row["collid"];
                                $collname = $row["collname"];
                                $collection_trackersArray = trackers_coll_array($TrackersResult, $collid, $userid);
                                $collection_trackersCount = count($collection_trackersArray);
                                echo AddSection($collname, $collid, $collection_trackersCount, TrackerCount, 1, $privilege);
                                foreach ($collection_trackersArray as $st) {
                                    echo CreateTracker($st, $privilege);
                                }
                                echo "</div></div>";
                            }
                        }
                        ?>
                    </div>
                </form></td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    getMapOptions();
    $('.abutton').button();
    $("select#search_user").selectmenu({width: 224});

    $('select#search_user').change(function() {
        $('#accordion_trackers').accordion('option', "active", this.selectedIndex - 1);

    });

    $(document).ready(function() {
        if (RealTimeClass.LiveIDs.length > 0) {
            for (i in RealTimeClass.LiveIDs) {
                $('.chb' + RealTimeClass.LiveIDs[i]).prop('checked', true);
            }
        }
        $('.chb').bind('change', function() {
            setCheck($(this).attr('class').split(' ')[0], $(this).is(':checked'));
            RealTimeClass.AddLive($(this).val());
        }
        );
    });

    function EditUser(id) {
<?php if ($grouping == 0) { ?>
            create_e_cmps(id);
<?php } else { ?>
            create_e_user(id);
<?php } ?>
    }
    ;

    function EditTracker(id) {
<?php if ($grouping == 0) { ?>
            create_e_alltracker(id);
<?php } else { ?>
            create_e_tracker(id);
<?php } ?>
    }
    ;

    $('.mapchooser').html(MAP_LBL);
    $('.treplay').find('.ui-button-text').find('div').html(TRACKINGREPLAY_LBL);
    $('.tedit').find('.ui-button-text').find('div').html(EDIT_LBL);
    $('.tlocate').find('.ui-button-text').find('div').html(LOCATE_LBL);
    $('.tmileage').find('.ui-button-text').find('div').html(SETMILEAGE_LBL);
    $('.uedit').find('.ui-button-text').find('div').html(EDIT_LBL);


    $('.checkall').html('<?php echo CheckAll ?>');
    $('.uncheckall').html('<?php echo UncheckAll ?>');
    $('.checkinvert').html('<?php echo CheckInvert ?>');

    $('.loadmore').click(function(e) {
        var id = $(this).attr('class').split(' ')[2].split('load')[1];
        var count = $(this).val();
        $('.load' + id).val(parseInt($('.load' + id).val()) + 20);
        LoadMore(id, count);
    });


    $('.context').bind('click', function(e) {
        var id = $(this).attr('class').split(' ')[1].split('context')[1];
        $('.tpopup' + id).html(geturl('connect/_tracker_popup.php?id=' + id));
    });
</script>