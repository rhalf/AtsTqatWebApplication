<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

$GeoFenceResult = $session->get('geofence');
?>
<script type="text/javascript">
    GeoFenceViewer.Clear();
<?php foreach ($GeoFenceResult as $gf_row) { ?>
        GeoFenceViewer.Name.push('<?php echo $gf_row["gf_name"] ?>');
        GeoFenceViewer.ID.push('<?php echo $gf_row["gf_id"] ?>');
        GeoFenceViewer.Data.push('<?php echo $gf_row["gf_data"] ?>');
<?php } ?>

    $('#<?php echo $module ?>_list').change(function() {
        var gfSelOption = $('#<?php echo $module ?>_list option:selected');
        var gfOption = $('#<?php echo $module ?>_list option');
        if (gfSelOption.length == 1) {
<?php if ($privilege != 4) { ?>
                $('#<?php echo $module ?>_btn_edit').show();
<?php } ?>
        } else {
            $('#<?php echo $module ?>_btn_edit').hide();
        }
        if (gfSelOption.length != gfOption.length) {
            $('#<?php echo $module ?>checktoggle').attr('class', 'ui-icon ui-icon-minus');
        } else {
            $('#<?php echo $module ?>checktoggle').attr('class', 'ui-icon ui-icon-check');
        }
        get_geofence_data();

    })
    $('#<?php echo $module ?>_list').dblclick(function() {
        if ($('#<?php echo $module ?>_list option:selected').length == 1) {
            $('#<?php echo $module ?>_btn_edit').click();
        }
    });

    $('#<?php echo $module ?>_list').click(function() {
        $('#<?php echo $module ?>_list').change();
    })


    function finish_adding_geofence() {
        if (MapClass.currMap == 'gmap') {
            $('#<?php echo $module_add ?>polyarr').val(DrawingGeoFence.Paths.toString());
        }
        DrawingGeoFence.reset();
    }

    function finish_editing_geofence() {
        if (MapClass.currMap == 'gmap') {
            if (DrawingGeoFence.geoPathsArr.toString() != '') {
                $('#<?php echo $module_edit ?>polyarr').val(DrawingGeoFence.Paths.toString());
            }
        }
        DrawingGeoFence.reset();
    }

    $(function() {
        $('input[name=<?php echo $module ?>_search]').keyup(function() {
            selectAllGeoFences(false);
            var $this = $(this);
            if ($this.val() != '') {
                $("#<?php echo $module ?>_list").find('option:contains(' + $this.val() + ')').attr("selected", "selected");
                $('#<?php echo $module ?>_list').change();
            }
        });
        build_menus();
    });



    function selectAllGeoFences(selectable) {
        for (var i = 0; i < $('#<?php echo $module ?>_list option').length; i++) {
            if (selectable == true) {
                $('#<?php echo $module ?>_list option:eq(' + i + ')').prop('selected', true);
            } else {
                $('#<?php echo $module ?>_list option:eq(' + i + ')').prop('selected', false);
            }

        }
        if (selectable == true) {
            $('#<?php echo $module ?>checktoggle').attr('class', 'ui-icon ui-icon-check');
        } else {
            $('#<?php echo $module ?>checktoggle').attr('class', 'ui-icon ui-icon-minus')
        }
        $('#<?php echo $module ?>_list').change();
    }

    function toggleselectGeoFences() {
        for (var i = 0; i < $('#<?php echo $module ?>_list option').length; i++) {
            if ($('#<?php echo $module ?>_list option:eq(' + i + ')').is(':selected')) {
                $('#<?php echo $module ?>_list option:eq(' + i + ')').prop('selected', false);

            } else {
                $('#<?php echo $module ?>_list option:eq(' + i + ')').prop('selected', true);
            }
        }
        $('#<?php echo $module ?>_list').change();
        $('#<?php echo $module ?>checktoggle').attr('class', 'ui-icon ui-icon-transferthick-e-w');

    }


    function get_geofence_data() {
        for (var i = 0; i < $('#<?php echo $module ?>_list option').length; i++) {
            if ($('#<?php echo $module ?>_list option:eq(' + i + ')').is(':selected')) {
                GeoFenceViewer.setPolygonCenter(GeoFenceViewer.ID[i])
                GeoFenceViewer.View(GeoFenceViewer.ID[i], true, false);
            } else {
                GeoFenceViewer.View(GeoFenceViewer.ID[i], false, false);
            }
        }
        if ($('#<?php echo $module ?>_list option:selected').length == 1) {
            $('#<?php echo $module_edit ?>name').val(GeoFenceViewer.Name[GeoFenceViewer.ID.indexOf($('#<?php echo $module ?>_list option:selected').val())]);
            $('#<?php echo $module_edit ?>id').val($('#<?php echo $module ?>_list option:selected').val());
            $('#<?php echo $module_edit ?>polyarr').val(GeoFenceViewer.Data[GeoFenceViewer.ID.indexOf($('#<?php echo $module ?>_list option:selected').val())]);
        }
    }
</script>

<div class="contents ui-widget-content" style="direction:<?php echo text_direction ?>">  
    <table width="100%" height="100%" border="0">
        <tr>
            <td><input type="text" name="<?php echo $module ?>_search" id="<?php echo $module ?>_search" style="width:100%" placeholder="<?php echo SearchTip ?>" class="search ui-state-default" /></td>
            <td><div>
                    <div style="height:26px">
                        <button style="height:26px;width:35px;vertical-align:top" class="checktoggle"><span id="<?php echo $module ?>checktoggle" class="ui-icon ui-icon-minus"></span></button>
                        <button style="height:26px;width:25px;vertical-align:top" class="select"></button>
                    </div>
                    <ul style="text-align:center">
                        <li class="ui-widget-content" style="border:none;" onclick="selectAllGeoFences(true)"><a href="#"><?php echo CheckAll ?></a></li>
                        <li class="ui-widget-content" style="border:none" onclick="selectAllGeoFences(false)"><a href="#"><?php echo UncheckAll ?></a></li>
                        <li class="ui-widget-content" style="border:none" onclick="toggleselectGeoFences();"><a href="#"><?php echo CheckInvert ?></a></li>
                    </ul>
                </div></td>
        </tr>
        <tr>
            <td colspan="2"><div>
                    <select name="<?php echo $module ?>_list" size="8" multiple="multiple" id="<?php echo $module ?>_list" style="width:100%" class="textareastyle">
                        <?php
                        foreach ($GeoFenceResult as $gf_row) {
                            echo "<option value = '" . $gf_row["gf_id"] . "' selected='selected'>";
                            echo $gf_row["gf_name"] . "</option>";
                        }
                        ?>
                    </select>
                </div></td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    if (MapClass.currMap == 'omap') {
        var tryViewGF = setInterval(function() {
            if (typeof (osmmaps[MapClass.currMapID]) !== 'undefined') {
                GeoFenceViewer.CreateAll();
                selectAllGeoFences(true);
                clearInterval(tryViewGF);
            }
        }, 2000);

    } else if (MapClass.currMap == 'gmap') {
        var tryViewGF = setInterval(function() {
            if (typeof (maps[MapClass.currMapID]) !== 'undefined') {
                GeoFenceViewer.CreateAll();
                selectAllGeoFences(true);
                clearInterval(tryViewGF);
            }
        }, 2000);
    } else if (MapClass.currMap == 'bmap') {
        var tryViewGF = setInterval(function() {
            if (typeof (bmaps[MapClass.currMapID]) !== 'undefined') {
                GeoFenceViewer.CreateAll();
                selectAllGeoFences(true);
                clearInterval(tryViewGF);
            }
        }, 2000);
    }




    //GeoFenceViewer.CreateAll();
    //if (typeof(selectAllPois)=== "function"){
    //	selectAllPois(true);
    //}

</script>