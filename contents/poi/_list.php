<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

$PoisResult = $session->get('pois');
?>
<script type="text/javascript">
    MarkerPOI._clear();
<?php foreach ($PoisResult as $row) { ?>
        MarkerPOI.id.push('<?php echo $row["poi_id"] ?>');
        MarkerPOI.lat.push('<?php echo $row["poi_lat"] ?>');
        MarkerPOI.lon.push('<?php echo $row["poi_lon"] ?>');
        MarkerPOI.name.push('<?php echo $row["poi_name"] ?>');
        MarkerPOI.image.push('<?php echo $row["poi_img"] ?>');
        MarkerPOI.desc.push('<?php echo $row["poi_desc"] ?>');
<?php } ?>


    $('#<?php echo $module ?>_list').change(function() {
        var SelOption = $('#<?php echo $module ?>_list option:selected');
        var Option = $('#<?php echo $module ?>_list option');
        if (SelOption.length == 1) {
            $('#<?php echo $module ?>_btn_edit').show();
        } else {
            $('#<?php echo $module ?>_btn_edit').hide();
        }
        if (SelOption.length != Option.length) {
            $('#<?php echo $module ?>checktoggle').attr('class', 'ui-icon ui-icon-minus');
        } else {
            $('#<?php echo $module ?>checktoggle').attr('class', 'ui-icon ui-icon-check');
        }
        get_all_poi();

    })
    $('#<?php echo $module ?>_list').dblclick(function() {
        if ($('#<?php echo $module ?>_list option:selected').length == 1) {
            $('#<?php echo $module ?>_btn_edit').click();
        }
    });

    $('#<?php echo $module ?>_list').click(function() {
        $('#<?php echo $module ?>_list').change();
    })


    function selectAllPois(selectable) {
        for (var i = 0; i < $('#<?php echo $module ?>_list option').length; i++) {
            if (selectable) {
                $('#<?php echo $module ?>_list option:eq(' + i + ')').prop('selected', true);
            } else {
                $('#<?php echo $module ?>_list option:eq(' + i + ')').prop('selected', false);
            }
        }
        if (selectable == true) {
            $('#<?php echo $module ?>checktoggle').attr('class', 'ui-icon ui-icon-check');
        } else {
            $('#<?php echo $module ?>checktoggle').attr('class', 'ui-icon ui-icon-minus');
        }
        $('#<?php echo $module ?>_list').change();
    }

    function toggleselectPois() {
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

    function get_poi_data(poi_id) {
        var POIX = MarkerPOI.id.indexOf(poi_id);
        $('#<?php echo $module_edit ?>id').val(poi_id);
        $('#<?php echo $module_edit ?>name').val(MarkerPOI.name[POIX]);
        $('#<?php echo $module_edit ?>img').val(MarkerPOI.image[POIX]);
        $('#<?php echo $module_edit ?>image').ddslick('select', {index: MarkerPOI.image[POIX]});
        $('#<?php echo $module_edit ?>lat').val(MarkerPOI.lat[POIX]);
        $('#<?php echo $module_edit ?>long').val(MarkerPOI.lon[POIX]);
        $('#<?php echo $module_edit ?>desc').val(MarkerPOI.desc[POIX]);
    }
    ;


    $(function() {
        $('input[name=poi_search]').keyup(function() {
            selectAllPois(false);
            var $this = $(this);
            if ($this.val() != '') {
                $("#<?php echo $module ?>_list").find('option:contains(' + $this.val() + ')').attr("selected", "selected");
                $('#<?php echo $module ?>_list').change();
            }
        });
        build_menus();
    });



    function get_all_poi() {
        MarkerPOI._delete();
        for (i in MarkerPOI.id) {
            if ($('#<?php echo $module ?>_list option:eq(' + i + ')').is(':selected')) {
                var POIX = MarkerPOI.id.indexOf($('#<?php echo $module ?>_list option:eq(' + i + ')').val());
                MarkerPOI._view(MarkerPOI.lat[POIX], MarkerPOI.lon[POIX], MarkerPOI.name[POIX], MarkerPOI.image[POIX]);
            }
        }


    }
    ;


    if (MapClass.currMap == 'omap') {
        var tryViewPOI = setInterval(function() {
            if (typeof (osmmaps[MapClass.currMapID]) !== 'undefined') {
                selectAllPois(true);
                clearInterval(tryViewPOI);
            }
        }, 2000);
    } else if (MapClass.currMap == 'gmap') {
        selectAllPois(true);
    } else if (MapClass.currMap == 'bmap') {
        selectAllPois(true);
    }

</script>

<div class="contents ui-widget-content" style="direction:<?php echo text_direction ?>">  
    <table width="100%" height="100%" border="0">
        <tr>
            <td><input type="text" name="poi_search" id="poi_search" style="width:100%" placeholder="<?php echo SearchTip ?>" class="search ui-state-default" /></td>
            <td><div>
                    <div style="height:26px">
                        <button style="height:26px;width:35px;vertical-align:top" class="checktoggle"><span id="<?php echo $module ?>checktoggle" class="ui-icon ui-icon-minus"></span></button>
                        <button style="height:26px;width:25px;vertical-align:top" class="select"></button>
                    </div>
                    <ul style="text-align:center">
                        <li class="ui-widget-content" style="border:none;" onclick="selectAllPois(true)"><a href="#"><?php echo CheckAll ?></a></li>
                        <li class="ui-widget-content" style="border:none" onclick="selectAllPois(false)"><a href="#"><?php echo UncheckAll ?></a></li>
                        <li class="ui-widget-content" style="border:none" onclick="toggleselectPois();"><a href="#"><?php echo CheckInvert ?></a></li>
                    </ul>
                </div></td>
        </tr>
        <tr>
            <td colspan="2"><div>
                    <select name="<?php echo $module ?>_list" size="8" multiple="multiple" id="<?php echo $module ?>_list" style="width:100%" class="textareastyle">
                        <?php
                        foreach ($PoisResult as $row) {
                            echo "<option value = " . $row["poi_id"] . ">";
                            echo $row["poi_name"] . "</option>";
                        }
                        ?>
                    </select>
                </div></td>
        </tr>
    </table>
</div>