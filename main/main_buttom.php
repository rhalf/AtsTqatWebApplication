<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../settings.php");
include_once("../scripts.php");
?>
<script type="text/javascript">

    function ClearGridRealTime() {
        $('#rt_edit').hide();
        for (id in RealTimeClass.LiveIDs) {
            var imgID = $(".image" + RealTimeClass.LiveIDs[id]).val();
            $('.img' + RealTimeClass.LiveIDs[id]).removeAttr("src").attr('src', "images/car/icon_" + imgID + "_stop.gif").attr('height', '15px').attr('width', '15px');
            $('.imgreg' + RealTimeClass.LiveIDs[id]).hide();
            $('.imgexp' + RealTimeClass.LiveIDs[id]).hide();
            $('.imgmileagelimit' + RealTimeClass.LiveIDs[id]).hide();

            $('.imgonoff' + RealTimeClass.LiveIDs[id]).removeAttr('src').attr('src', "images/admin/off.png");
            $('.chb' + RealTimeClass.LiveIDs[id]).attr("checked", false);

            $('.checktoggle').children().children().attr('class', 'ui-icon ui-icon-minus');
        }
        RealTimeClass.ClearLive();
        //stop_trackerdata();	
        jQuery("#listtrackersdata").jqGrid("clearGridData", true);
        /*	LiveArr.length=0;
         LiveArrPOS.length=0;
         LiveArrData.length=0;
         LastArr.length=0;
         LastArrData.length=0;
         LastArrPOS.length=0;*/
        /*if (MapClass.currMap=='gmap'){
         DeleteRealTime();
         T1deleteGeoFence();T2deleteGeoFence();	
         }else if (MapClass.currMap=='bmap'){
         
         bDeleteRealTime();		
         }else if (MapClass.currMap=='omap'){
         osm_removeGeoFence();	
         oDeleteRealTime();	
         
         }*/

        RealTimeClass.Remove();
        $('#trackerdatarecordcount').html('<?PHP echo TrackerCount; ?>: ' + jQuery("#listtrackersdata").jqGrid('getGridParam', 'records'));

        $('#ResultRunning').html('');
        $('#ResultParking').html('');
        $('#ResultIdle').html('');
        $('#ResultAlarm').html('');
        $('#ResultLost').html('');

// counting
        $('#RunningSection').text('<?php echo RunningSection; ?>').append("<font size='-3' style='padding-right:40px;float: right;'>" + '0 ' + '<?php echo TrackerCount; ?>' + "</font>");
        $('#ParkingSection').text('<?php echo ParkingSection; ?>').append("<font size='-3' style='padding-right:40px;float: right;'>" + '0 ' + '<?php echo TrackerCount; ?>' + "</font>");
        $('#IdleSection').text('<?php echo IdleSection; ?>').append("<font size='-3' style='padding-right:40px;float: right;'>" + '0 ' + '<?php echo TrackerCount; ?>' + "</font>");
        $('#UrgentSection').text('<?php echo UrgentSection; ?>').append("<font size='-3' style='padding-right:40px;float: right;'>" + '0 ' + '<?php echo TrackerCount; ?>' + "</font>");
        $('#OverSpeedSection').text('<?php echo OverSpeedSection; ?>').append("<font size='-3' style='padding-right:40px;float: right;'>" + '0 ' + '<?php echo TrackerCount; ?>' + "</font>");
        $('#GeoFenceSection').text('<?php echo GeoFenceSection; ?>').append("<font size='-3' style='padding-right:40px;float: right;'>" + '0 ' + '<?php echo TrackerCount; ?>' + "</font>");
        $('#BreakDownSection').text('<?php echo BreakDownSection; ?>').append("<font size='-3' style='padding-right:40px;float: right;'>" + '0 ' + '<?php echo TrackerCount; ?>' + "</font>");
        $('#LostSection').text('<?php echo LostSection; ?>').append("<font size='-3' style='padding-right:40px;float: right;'>" + '0 ' + '<?php echo TrackerCount; ?>' + "</font>");

    }
</script>

<form id="trackersdataform" name="trackersdataform" method="post">

    <table id="listtrackersdata" ></table>
    <div id="pagertrackersdata" style="display:none"></div>
    <button name="rt_edit" id="rt_edit" style="display:none"><?php echo Edit ?></button>
    <button name="rt_columns" id="rt_columns"><?php echo Columns ?></button>
    <button name="rt_resume" id="rt_resume"><?php echo Resume; ?></button>
    <button name="rt_stop" id="rt_stop" ><?php echo Stop ?></button>
    <button name="rt_clear" id="rt_clear"><?php echo Clear ?></button>
    <select name="trackerdatagrb" id="trackerdatagrb" style="width:145px">
        <option value="gm_unit" selected="selected"><?php echo Unit ?></option>
        <option value="gm_signal"><?php echo Signal ?></option>
        <option value="gm_state"><?php echo State ?></option>
        <option value="gm_power"><?php echo Power ?></option>
        <option value="gm_urgent"><?php echo Input1 ?></option>
        <option value="gm_acc"><?php echo Input2 ?></option>
        <option value="gm_custom1"><?php echo Input3 ?></option>
        <option value="gm_door"><?php echo Input4 ?></option>
        <option value="gm_cutoff"><?php echo Output1 ?></option>
        <option value="gm_timeInterval"><?php echo Interval ?></option>
        <option value="gm_overspeed"><?php echo Overspeed ?></option>
        <option value="clear"><?php echo Clear ?></option>
    </select>
    <a id="trackerdatagrblbl"> <?PHP echo GroupBy; ?> </a>
    <a id="trackerdatarecordcount"><?PHP echo TrackerCount; ?>:0</a>
</form>


<script type="text/javascript">
    var rowsToColor = [];
    jQuery().ready(function() {
        var rtGrid = $("#listtrackersdata");

        rtGrid.jqGrid({
            mtype: 'POST',
            datatype: 'local',
            colNames: ['<?php echo DriverName ?>', '<?php echo VehicleReg ?>', '<?php echo Unit ?>', '<?php echo Time ?>', '<?php echo Lat ?>', '<?php echo Long ?>', '<?php echo Address ?>', '<?php echo Speed ?>', '<?php echo Direction ?>', '<?php echo Signal ?>', '<?php echo State ?>', '<?php echo Power ?>', '<?php echo Input1 ?>', '<?php echo Input2 ?>', '<?php echo Input3 ?>', '<?php echo Input4 ?>', '<?php echo Input5 ?>', '<?php echo Output1 ?>', '<?php echo Output2 ?>', '<?php echo Output3 ?>', '<?php echo Output4 ?>', '<?php echo Output5 ?>', '<?php echo AD1 ?>', '<?php echo AD2 ?>', '<?php echo Geofence ?>', '<?php echo Mileage ?>', '<?php echo Interval ?>', '<?php echo Overspeed ?>', '<?php echo GPSQSignal ?>', '<?php echo GSMQSignal ?>'],
            colModel: [
                {name: 'tdrivername', index: 'tdrivername', width: 90, align: 'center'},
                {name: 'tvehiclereg', index: 'tvehiclereg', width: 90, align: 'center'},
                {name: 'gm_unit', index: 'gm_unit', width: 90, align: 'center', hidden: true},
                {name: 'gm_time', index: 'gm_time', width: 110, align: 'center'},
                {name: 'gm_lat', index: 'gm_lat', width: 90, align: 'center', hidden: true},
                {name: 'gm_lng', index: 'gm_lng', width: 90, align: 'center', hidden: true},
                {name: 'gm_address', index: 'gm_address', width: 90, align: 'center'},
                {name: 'gm_speed', index: 'gm_speed', width: 90, align: 'center'},
                {name: 'gm_ori', index: 'gm_ori', width: 90, align: 'center', hidden: true},
                {name: 'gm_signal', index: 'gm_signal', width: 90, align: 'center'},
                {name: 'gm_state', index: 'gm_state', width: 90, align: 'center'},
                {name: 'gm_power', index: 'gm_power', width: 90, align: 'center'},
                {name: 'gm_input1', index: 'gm_input1', width: 90, align: 'center'},
                {name: 'gm_input2', index: 'gm_input2', width: 90, align: 'center'},
                {name: 'gm_input3', index: 'gm_input3', width: 90, align: 'center', hidden: true},
                {name: 'gm_input4', index: 'gm_input4', width: 90, align: 'center', hidden: true},
                {name: 'gm_input5', index: 'gm_input5', width: 90, align: 'center', hidden: true},
                {name: 'gm_output1', index: 'gm_output1', width: 90, align: 'center'},
                {name: 'gm_output2', index: 'gm_output2', width: 90, align: 'center', hidden: true},
                {name: 'gm_output3', index: 'gm_output3', width: 90, align: 'center', hidden: true},
                {name: 'gm_output4', index: 'gm_output4', width: 90, align: 'center', hidden: true},
                {name: 'gm_output5', index: 'gm_output5', width: 90, align: 'center', hidden: true},
                {name: 'gm_fuel', index: 'gm_fuel', width: 90, align: 'center', hidden: true},
                {name: 'gm_AD2', index: 'gm_AD2', width: 90, align: 'center', hidden: true},
                {name: 'gm_geofence', index: 'gm_geofence', width: 90, align: 'center'},
                {name: 'gm_mileage', index: 'gm_mileage', width: 90, align: 'center'},
                {name: 'gm_timeInterval', index: 'gm_timeInterval', width: 90, align: 'center', hidden: true},
                {name: 'gm_overspeed', index: 'gm_overspeed', width: 90, align: 'center', hidden: true},
                {name: 'gm_GPSQSignal', index: 'gm_GPSQSignal', width: 90, align: 'center', hidden: true},
                {name: 'gm_GSMQSignal', index: 'gm_GSMQSignal', width: 90, align: 'center', hidden: true}
            ],
            direction: '<?php echo text_direction ?>',
            rowList: [], // disable page size dropdown 
            pgbuttons: false, // disable page control like next, back button 
            pgtext: null, // disable pager text like 'Page 0 of 10' 
            viewrecords: false, // disable current view record text like 'View 1-10 of 100' 
            rowNum: 10,
            pager: $('#pagertrackersdata'),
            sortname: 'tvehiclereg',
            rownumWidth: 40,
            rownumbers: true,
            autowidth: true,
            gridview: true,
            autoheight: true,
            grouping: true,
            width: '100%',
            height: 'auto',
            loadonce: false,
            shrinkToFit: false,
            sortorder: "desc",
            toolbar: [true, "bottom"],
            ondblClickRow: function(id, iRow, iCol, e) {
                //alert("main bottom");
                var ret = rtGrid.jqGrid('getRowData', iRow);
                var unitLat = ret.gm_lat;
                var unitLng = ret.gm_lng;
                if (MapClass.currMap == 'gmap') {
                    AddressCodeLatLng(unitLat, unitLng);
                    var be = code;
                } else if (MapClass.currMap == 'omap') {
                    osm_AddressCodeLatLng(unitLat, unitLng);
                    var be = osm_code;
                }
                rtGrid.jqGrid('setRowData', iRow, {gm_address: be});
            },
            onSelectRow: function(id) {
                $('#rt_edit').show();
                if (MapClass.currMap == 'gmap') {

                    if (maps[MapClass.currMapID].getZoom() < 11) {
                        maps[MapClass.currMapID].setZoom(16);
                    }
                    var ret = rtGrid.jqGrid('getRowData', id);
                    maps[MapClass.currMapID].setCenter(new google.maps.LatLng(ret.gm_lat, ret.gm_lng));
                } else if (MapClass.currMap == 'omap') {
                    var ret = rtGrid.jqGrid('getRowData', id);
                    var lonlat = new OpenLayers.LonLat(ret.gm_lng, ret.gm_lat).transform(
                            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                            osmmaps[MapClass.currMapID].getProjectionObject()//,
                            //   new OpenLayers.Projection("EPSG:900913")  // to Spherical Mercator Projection
                            );
                    osmmaps[MapClass.currMapID].zoomTo(16);
                    osmmaps[MapClass.currMapID].setCenter(lonlat)
                }
            }

        });

        rtGrid.jqGrid('navButtonAdd', '#pagertrackersdata', {
            caption: "Columns",
            title: "Reorder Columns",
            onClickButton: function() {
                rtGrid.jqGrid('columnChooser');
            }});
        $("#trackerdatagrb").change(function() {
            var vl = $(this).val();
            if (vl) {
                if (vl == "clear") {
                    rtGrid.jqGrid('groupingRemove', true);
                } else {
                    rtGrid.jqGrid('groupingGroupBy', vl);
                }
            }
        });
        rtGrid.jqGrid('navGrid', '#pagertrackersdata', {add: false, edit: false, del: false, search: false});

        var rtTGrid = $("#t_listtrackersdata");
        rtTGrid.append($("#rt_edit"));
        rtTGrid.append($("#rt_columns"));
        rtTGrid.append($("#rt_clear"));
        rtTGrid.append($("#rt_stop"));
        rtTGrid.append($("#rt_resume"));
        rtTGrid.append($("#trackerdatagrblbl"));
        rtTGrid.append($("#trackerdatagrb"));
        rtTGrid.append($("#trackerdatarecordcount"));


        $("#rt_stop").button({icons: {primary: "ui-icon-stop"}});
        $("#rt_resume").button({icons: {primary: "ui-icon-play"}});
        $("#rt_clear").button({icons: {primary: "ui-icon-trash"}});
        $("#rt_columns").button({icons: {primary: "ui-icon-calculator"}});
        $("#rt_edit").button({icons: {primary: "ui-icon-pencil"}});

        $("#rt_edit").click(function() {
            var ret = rtGrid.jqGrid('getGridParam', 'selrow');
            var celValue = rtGrid.jqGrid('getCell', ret, 'gm_unit');
            create_e_tracker(celValue);
            return false;
        });


        $("#rt_columns").click(function() {
            rtGrid.jqGrid('columnChooser');
            return false;
        });


        $("#rt_clear").click(function() {
            ClearGridRealTime();
            return false;
        });

        $("#rt_stop").click(function() {
            RealTimeClass.StopLive();
            return false;
        });

        $("#rt_resume").click(function() {
            RealTimeClass.ResumeLive();
            return false;
        });



        rtGrid.setGridHeight($("#trackinggrid").height() - 90);

        $('#t_listtrackersdata').css('height', '30px');

    });

    function relode_trackers_data() {
        rtGrid.trigger("reloadGrid");
    }
    ;

    function coloring_grid(i, grid) {
        var ids = grid.jqGrid('getDataIDs');
        //for(var i=0;i<ids.length;i++){
        var rowid = ids[i];
        var aData = grid.jqGrid('getRowData', ids[i]);
        if (aData.gm_signal == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_signal', '', {color: 'green'});
        }
        else if (aData.gm_signal == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_signal', '', {color: 'red'});
        }

        if (aData.gm_input1 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_input1', '', {color: 'green'});
        }
        else if (aData.gm_input1 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_input1', '', {color: 'red'});
        }
        else if (aData.gm_input1 == 'n/a') {
            grid.setCell(rowid, 'gm_input1', '', {color: 'gray'});
        }

        if (aData.gm_input2 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_input2', '', {color: 'green'});
        }
        else if (aData.gm_input2 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_input2', '', {color: 'red'});
        }
        else if (aData.gm_input2 == 'n/a') {
            grid.setCell(rowid, 'gm_input2', '', {color: 'gray'});
        }
        
        if (aData.gm_input3 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_input3', '', {color: 'green'});
        }
        else if (aData.gm_input3 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_input3', '', {color: 'red'});
        }
        else if (aData.gm_input3 == 'n/a') {
            grid.setCell(rowid, 'gm_input3', '', {color: 'gray'});
        }

        if (aData.gm_input4 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_input4', '', {color: 'green'});
        }
        else if (aData.gm_input4 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_input4', '', {color: 'red'});
        }
        else if (aData.gm_input4 == 'n/a') {
            grid.setCell(rowid, 'gm_input4', '', {color: 'gray'});
        }

        if (aData.gm_input5 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_input5', '', {color: 'green'});
        }
        else if (aData.gm_input5 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_input5', '', {color: 'red'});
        }
        else if (aData.gm_input5 == 'n/a') {
            grid.setCell(rowid, 'gm_input5', '', {color: 'gray'});
        }

        if (aData.gm_output1 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_output1', '', {color: 'green'});
        }
        else if (aData.gm_output1 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_output1', '', {color: 'red'});
        }
        else if (aData.gm_output1 == 'n/a') {
            grid.setCell(rowid, 'gm_output1', '', {color: 'gray'});
        }

        if (aData.gm_output2 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_output2', '', {color: 'green'});
        }
        else if (aData.gm_output2 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_output2', '', {color: 'red'});
        }
        else if (aData.gm_output2 == 'n/a') {
            grid.setCell(rowid, 'gm_output2', '', {color: 'gray'});
        }

        if (aData.gm_output3 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_output3', '', {color: 'green'});
        }
        else if (aData.gm_output3 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_output3', '', {color: 'red'});
        }
        else if (aData.gm_output3 == 'n/a') {
            grid.setCell(rowid, 'gm_output3', '', {color: 'gray'});
        }


        if (aData.gm_output4 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_output4', '', {color: 'green'});
        }
        else if (aData.gm_output4 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_output4', '', {color: 'red'});
        }
        else if (aData.gm_output4 == 'n/a') {
            grid.setCell(rowid, 'gm_output4', '', {color: 'gray'});
        }

        if (aData.gm_output5 == '<?php echo On; ?>') {
            grid.setCell(rowid, 'gm_output5', '', {color: 'green'});
        }
        else if (aData.gm_output5 == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_output5', '', {color: 'red'});
        }
        else if (aData.gm_output5 == 'n/a') {
            grid.setCell(rowid, 'gm_output5', '', {color: 'gray'});
        }

        // gps state
        if (aData.gm_state == '<?php echo High; ?>') {
            grid.setCell(rowid, 'gm_state', '', {color: 'blue'});
        } else if (aData.gm_state == '<?php echo Short; ?>') {
            grid.setCell(rowid, 'gm_state', '', {color: 'yellow'});
        } else if (aData.gm_state == '<?php echo Normal; ?>') {
            grid.setCell(rowid, 'gm_state', '', {color: 'green'});
        } else if (aData.gm_state == '<?php echo Error; ?>') {
            grid.setCell(rowid, 'gm_state', '', {color: 'red'});
        } else if (aData.gm_state == 'n/a') {
            grid.setCell(rowid, 'gm_state', '', {color: 'gray'});
        }

        // Power
        if (aData.gm_power == '<?php echo Off; ?>') {
            grid.setCell(rowid, 'gm_power', '', {color: 'red'});
        } else if (aData.gm_power == '<?php echo Low; ?>') {
            grid.setCell(rowid, 'gm_power', '', {color: 'yellow'});
        } else if (aData.gm_power == '<?php echo Normal; ?>') {
            grid.setCell(rowid, 'gm_power', '', {color: 'green'});
        } else if (aData.gm_power == '<?php echo Error; ?>') {
            grid.setCell(rowid, 'gm_power', '', {color: 'red'});
        } else if (aData.gm_power == 'n/a') {
            grid.setCell(rowid, 'gm_power', '', {color: 'gray'});
        }


        if (aData.gm_timeInterval == 'n/a') {
            grid.setCell(rowid, 'gm_timeInterval', '', {color: 'gray'});
        }

        if (aData.gm_GPSQSignal == 'n/a') {
            grid.setCell(rowid, 'gm_GPSQSignal', '', {color: 'gray'});
        }

        if (aData.gm_AD2 == 'n/a') {
            grid.setCell(rowid, 'gm_AD2', '', {color: 'gray'});
        }

        //	AddressCodeLatLng(ret.gm_lat,ret.gm_lng);
        //var	be = code;
        //$("#listtrackersdata").jqGrid('setRowData',ids[i],{gm_address:be});
        //	}		



    }

    $().ready(function() {
        $('#layout-south_tabs').tabs({event: "click", fx: {opacity: 'toggle'}, show: function(event, ui) {
                resizeRealtimeGrid();
            }
        });

        $('#layout-south_tabs .ui-tabs-anchor').click(function() {
            myLayout.sizePane('south', 200);
            resizeRealtimeGrid();
        });
        $('#layout-south_tabs .ui-tabs-anchor').dblclick(function() {
            myLayout.sizePane('south', 30);
            resizeRealtimeGrid();
        });

    });

    function resizeRealtimeGrid() {
        $('#listtrackersdata').setGridHeight($('#trackinggrid').height() - 90);
        $('#listtrackersdata').setGridWidth($('#trackinggrid').width());
    }

</script>