<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../settings.php");
include_once("../scripts.php");
$GeoFenceResult = $session->get('geofence');
?>
<form id="TrackingReplayform" name="TrackingReplayform" method="post">
    <div id="speeddialog" title="<?php echo Settings ?>">
        <div style="width:100px">
            <div style="float:left;width:100px" align="center"><?php echo ShowSpeed ?></div>
            <div style="float:left;margin:10px 0px 10px 45px"  id="speedslider"></div>
            <div style="float:left;width:100px" id="amount" class="trtd"></div>
        </div>
    </div>

    <div id="trackslider" style="margin-top:5px;margin-bottom:5px;margin-left:15px;margin-right:50px;float: left;width:90%"></div><div align="left" id="pos" class="trtd"></div>
    <table id="TrackingReplaydata"></table>
    <div id="pagerTrackingReplay"></div>
    <button type="button" name="tr_settings" id="tr_settings"><?php echo Settings ?></button>
    <button type="button" name="tr_columns" id="tr_columns"><?php echo Columns ?></button>
    <button type="button" name="tr_play" id="tr_play"><?php echo Play; ?></button>
    <button type="button" name="tr_pause" id="tr_pause"><?php echo Pause ?></button>
    <button type="button" name="tr_stop" id="tr_stop"><?php echo Stop ?></button>
    <button type="button" name="tr_Clear" id="tr_Clear"><?php echo Clear ?></button>
</form>

<script type="text/javascript">

    var gfArray = [];
    var tr_speed = 5000;
    var trint = 0;
    var tr_intv;
    $(function() {
        $("#tr_play").button();
        $("#tr_pause").button();
        $("#tr_stop").button();
        $("#tr_Clear").button();

        $('#tr_stop').attr('disabled', true);
        $('#tr_pause').attr('disabled', true);

        $("#speedslider").slider({
            orientation: "vertical",
            range: "min",
            min: 1,
            max: 10,
            value: 5,
            slide: function(event, ui) {
                tr_speed = (11 - ui.value) * 1000;
                $("#amount").html(11 - ui.value);
                if (trint !== 0) {
                    Pause_tracking_replay();
                    int_tracking_replay();
                }
            }
        });
        $("#amount").html($("#speedslider").slider("value"));
        ///////////

        var trackmax = TrackingReplayArray[0].Paths.length - 1;
        $("#trackslider").slider({
            orientation: "horizontal",
            range: "min",
            min: 0,
            max: trackmax,
            value: trint,
            slide: function(event, ui) {
                goto_tracking_replay(ui.value);
                trint = ui.value;
                $("#pos").html(ui.value);
            }

        });
        $("#pos").html(trint);

    });



    function int_tracking_replay() {
        $('#tr_play').attr('disabled', true);
        $('#tr_pause').removeAttr('disabled');
        $('#tr_stop').removeAttr('disabled');
        tr_intv = setInterval("play_tracking_replay()", tr_speed);
        return false;
    }
    ;

    function play_tracking_replay() {
        //TrackingReplayArray[0].GeoFenceImage = false;
        $('#tr_geofence').html('');
        trint = trint + 1;
        if (trint < TrackingReplayArray[0].Items.length) {
            goto_tracking_replay(trint);
            $("#trackslider").slider("value", trint);
            $("#pos").html(trint);
        } else {
            stop_tracking_replay();
        }
        return false;
    }
    ;


    function Pause_tracking_replay() {
        $('#tr_play').removeAttr('disabled');
        clearInterval(tr_intv);
        return false;
    }
    ;


    function stop_tracking_replay() {
        $('#tr_play').removeAttr('disabled');
        trint = 0;
        clearInterval(tr_intv);
        $("#trackslider").slider("value", trint);
        $("#pos").html(trint);
        goto_tracking_replay(trint);
        return false;
    }
    ;


    function goto_tracking_replay(pos) {
        var tvar = Parse_tvar(TrackingReplayArray[0].Items[pos], TrackingReplayArray[0].Obj);
        TrackingReply.UpdateMarker(tvar);

        if (GeoFenceViewer.ID.length != 0) {
            setTrackingReplayGridvalue(tvar.pos, tvar.geoFArea);
            TrackingReply.ViewGeoFence(tvar.geoFID, tvar.gm_unit, tvar.geoFAlarm);
        }
        if ($("#TrackingReplaydata").jqGrid('getGridParam', 'records') == 0) {
            $("#TrackingReplaydata").addRowData(1, tvar);
        } else {
            $("#TrackingReplaydata").setRowData(1, tvar);
        }
    }
    ;



    setTimeout(function() {
        goto_tracking_replay(0);
    }, 500);

</script>
<script type="text/javascript">
    jQuery().ready(function() {



        var trGrid = $("#TrackingReplaydata");
        trGrid.jqGrid({
            mtype: 'POST',
            datatype: 'local',
            colNames: ['<?php echo DriverName ?>', '<?php echo VehicleReg ?>', '<?php echo SimNo ?>', '<?php echo Unit ?>', '<?php echo Time ?>', '<?php echo Lat ?>', '<?php echo Long ?>', '<?php echo Address ?>', '<?php echo Speed ?>', '<?php echo Direction ?>', '<?php echo Signal ?>', '<?php echo State ?>', '<?php echo Power ?>', '<?php echo Input1 ?>', '<?php echo Input2 ?>', '<?php echo Input3 ?>', '<?php echo Input4 ?>', '<?php echo Input5 ?>', '<?php echo Output1 ?>', '<?php echo Output2 ?>', '<?php echo Output3 ?>', '<?php echo Output4 ?>', '<?php echo Output5 ?>', '<?php echo AD1 ?>', '<?php echo AD2 ?>', '<?php echo Geofence ?>', '<?php echo Mileage ?>', '<?php echo Interval ?>', '<?php echo Overspeed ?>', '<?php echo GPSQSignal ?>', '<?php echo GSMQSignal ?>'],
            colModel: [
                {name: 'tdrivername', index: 'tdrivername', width: 90, align: 'center'},
                {name: 'tvehiclereg', index: 'tvehiclereg', width: 90, align: 'center'},
                {name: 'gm_simno', index: 'gm_simno', width: 90, align: 'center', hidden: true},
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
            pager: $('#pagerTrackingReplay'),
            sortname: 'tvehiclereg',
            rownumWidth: 40,
            rownumbers: true,
            autowidth: true,
            gridview: true,
            autoheight: true,
            width: '100%',
            height: 'auto',
            loadonce: false,
            shrinkToFit: false,
            sortorder: "desc",
            toolbar: [true, "top"],
            ondblClickRow: function(id, iRow, iCol, e) {
                var ret = trGrid.jqGrid('getRowData', iRow);
                var unitLat = ret.gm_lat;
                var unitLng = ret.gm_lng;
                if (MapClass.currMap == 'gmap') {
                    AddressCodeLatLng(unitLat, unitLng);
                    var be = code;
                } else if (MapClass.currMap == 'omap') {
                    osm_AddressCodeLatLng(unitLat, unitLng);
                    var be = osm_code;
                } else if (MapClass.currMap == 'bmap') {
                    bing_tools.AddressCodeLatLng(unitLat, unitLng);
                    var be = bing_tools.bing_code;
                }
                trGrid.jqGrid('setRowData', iRow, {gm_address: be});
            }

        });

        trGrid.jqGrid('navButtonAdd', '#pagerTrackingReplay', {
            caption: "Columns",
            title: "Reorder Columns",
            onClickButton: function() {
                trGrid.jqGrid('columnChooser');
            }
        });
        trGrid.jqGrid('navGrid', '#pagerTrackingReplay', {add: false, edit: false, del: false, search: false});
        $("#t_TrackingReplaydata").append($("#tr_settings"));
        $("#t_TrackingReplaydata").append($("#tr_columns"));
        $("#t_TrackingReplaydata").append($("#tr_play"));
        $("#t_TrackingReplaydata").append($("#tr_pause"));
        $("#t_TrackingReplaydata").append($("#tr_stop"));
        $("#t_TrackingReplaydata").append($("#tr_Clear"));

        $("#tr_play").button({icons: {primary: "ui-icon-play"}});
        $("#tr_pause").button({icons: {primary: "ui-icon-pause"}});
        $("#tr_stop").button({icons: {primary: "ui-icon-stop"}});
        $("#tr_Clear").button({icons: {primary: "ui-icon-trash"}});
        $("#tr_settings").button({icons: {primary: "ui-icon-gear"}});
        $("#tr_columns").button({icons: {primary: "ui-icon-calculator"}});
        $("#tr_columns").click(function(e) {
            trGrid.jqGrid('columnChooser');
            return false;
        });

        $("#tr_Clear").click(function(e) {
            TrackingReply.Clear();
            ResizeSouthPane(30, false);
        });
        $("#tr_play").click(function(e) {
            int_tracking_replay();
        });
        $("#tr_pause").click(function(e) {
            Pause_tracking_replay();
        });
        $("#tr_stop").click(function(e) {
            stop_tracking_replay();
        });
        $("#tr_settings").click(function(e) {
            $('#speeddialog').dialog('open');
            return false;
        });

        $('#t_TrackingReplaydata').css('height', '35px').css('overflow', 'inherit');
    });

    $('#TrackingReplaydata').setGridHeight($('#trackinggrid').height() - 90);
    $('#TrackingReplaydata').setGridWidth($('#trackinggrid').width());




    $("#speeddialog").dialog({
        autoOpen: false,
        hide: 'fade',
        show: 'fade',
        closeOnEscape: true,
        closeText: 'close',
        dialogClass: '',
        draggable: true,
        resizable: false,
        height: 'auto',
        maxHeight: false,
        maxWidth: false,
        minHeight: 150,
        minWidth: 425,
        modal: false
    });

</script>