<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
?>
<div id='<?php echo $module ?>tabs' style="height:100%;width:100%;padding:0 0 0 0;margin:0 0 0 0;overflow:hidden">
    <ul style="-moz-border-radius-bottomleft: 0; -moz-border-radius-bottomright: 0;width:100%;padding:0 0 0 0;margin:0 0 0 0">
        <li><a href="#<?php echo $module ?>drawing">Drawing</a></li>
        <li><a href="#<?php echo $module ?>coloring">Coloring</a></li>
        <li><a href="#<?php echo $module ?>direction">Directions</a></li>
    </ul>
    <div id="<?php echo $module ?>drawing" style="height:215px">
        <table width="100%" border="0">
            <tr>
                <td width="24%">
                    <select name="<?php echo $module ?>SelectTools" id="<?php echo $module ?>SelectTools" style="width:200px">
                        <option class="ui-widget-content" value="0">Navigate</option>
                        <option class="ui-widget-content" value="1">Markers</option>
                        <option class="ui-widget-content" value="2">MarkersLine</option>
                        <option class="ui-widget-content" value="3">Line</option>
                        <option class="ui-widget-content" value="4">Point</option>
                        <option class="ui-widget-content" value="5">Polygon</option>
                        <option class="ui-widget-content" value="6">Ruler</option>
                        <option class="ui-widget-content" value="7">Direction</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="left" valign="middle"><div id="AreaMeter"></div></td>
            <tr>
                <td align="left" valign="middle" ><div id="AreaKM"></div></td>
            </tr>
            <tr>
                <td align="left" valign="middle"><div id="AreaFeet"></div></td>
            </tr>
            <tr>
                <td align="left" valign="middle"><div id="AreaMile"></div></td>
            </tr>
        </table>
    </div>
    <div id="<?php echo $module ?>coloring" style="height:215px">
        <table>
            <tr>
                <td align="left" valign="middle">Radius</td>
                <td align="left" valign="middle" ><input type="text" name="bRadius" id="bRadius" value="10" class="inputstyle"/></td>
            </tr>
            <tr>
                <td align="left" valign="middle">Fill color</td>
                <td align="left" valign="middle"><input class="color inputstyle" id="bfillColor" name="bfillColor" value="FF3414" /></td>
            </tr>
            <tr>
                <td align="left" valign="middle">Stroke color</td>
                <td align="left" valign="middle"><input class="color inputstyle" id="bstrokecolor" name="bstrokecolor" value="BF9643" /></td>
            </tr>
            <tr>
                <td align="left" valign="middle">Stroke opacity</td>
                <td align="left" valign="middle"><input type="text" name="bstrokeopacity" id="bstrokeopacity" value=".5" class="inputstyle"/></td>
            </tr>
            <tr>
                <td align="left" valign="middle">Fill opacity</td>
                <td align="left" valign="middle"><input type="text" name="bfillopacity" id="bfillopacity" value=".5" class="inputstyle"/></td>
            </tr>
            <tr>
                <td align="left" valign="middle">Stroke width</td>
                <td align="left" valign="middle"><input type="text" name="bstrokewidth" id="bstrokewidth" value="5" class="inputstyle"/></td>
            </tr>
        </table>
    </div>
    <div id="<?php echo $module ?>direction" style="height:215px;overflow: auto;">
        <div id="<?php echo $module ?>directions_panel"></div>
    </div>
</div>
</div>
<script type="text/javascript">
    $('#<?php echo $module ?>tabs').tabs({event: "click", fx: {opacity: 'toggle'}});
    $("select#<?php echo $module ?>SelectTools").selectmenu();

    function <?php echo $module ?>hide_tools(hide) {
        if (hide) {
            $('#<?php echo $module ?>hide').hide();
            $('#<?php echo $module ?>show').hide();
            $('#<?php echo $module ?>delete').hide();
        } else {
            $('#<?php echo $module ?>hide').show();
            $('#<?php echo $module ?>show').show();
            $('#<?php echo $module ?>delete').show();
        }

    }

    function <?php echo $module ?>Close() {
<?php echo $module ?>Dialog.Close();
    }

    function clear_googleAreaControl() {
        $('#<?php echo $module ?>AreaMeter').html("");
        $('#<?php echo $module ?>AreaKM').html("");
        $('#<?php echo $module ?>AreaFeet').html("");
        $('#<?php echo $module ?>AreaMile').html("");
    }

    $('#<?php echo $module ?>SelectTools').change(function() {
        clear_googleAreaControl();
        var idx = $(this).val();
        switch (idx) {
            case "0":
                bing_tools.Disable();
<?php echo $module ?>hide_tools(true);
                break;
            case "1":
<?php echo $module ?>hide_tools(false);
                bing_tools.EnableMarkerOnly();
                break;
            case "2":
<?php echo $module ?>hide_tools(false);
                bing_tools.EnableMarkerPoly();
                break;
            case "3":
<?php echo $module ?>hide_tools(false);
                bing_tools.EnablePolyOnly();
                break;
            case "4":
<?php echo $module ?>hide_tools(false);
                bing_tools.EnableCircles();
                break;
            case "5":
<?php echo $module ?>hide_tools(false);
                bing_tools.EnablePolygons();
                break;
            case "6":
<?php echo $module ?>hide_tools(false);
                google_tools.EnableRuler();
                break;
            case "7":
<?php echo $module ?>hide_tools(false);
                google_tools.EnableDirection();
                break;
        }


    });


    function <?php echo $module ?>Delete() {
        bing_tools.Disable();
        var idx = $('#<?php echo $module ?>SelectTools').val();
        switch (idx) {
            case "0":
                bing_tools.Disable();
                break;
            case "1":
                bing_tools.opeMarkersOnly(3);
                break;
            case "2":
                bing_tools.opeMarkerPoly(3);
                break;
            case "3":
                bing_tools.opePolyOnly(3);
                break;
            case "4":
                bing_tools.opeCircles(3);
                break;
            case "5":
                bing_tools.opePolygons(3);
                break;
            case "6":
                google_tools.opeRuler(3);
                break;
            case "7":
                google_tools.opeDirections(3);
                break;
        }
    }

    function <?php echo $module ?>Hide() {
        var idx = $('#<?php echo $module ?>SelectTools').val();
        switch (idx) {
            case "0":
                bing_tools.Disable();
                break;
            case "1":
                bing_tools.opeMarkersOnly(2);
                break;
            case "2":
                bing_tools.opeMarkerPoly(2);
                break;
            case "3":
                bing_tools.opePolyOnly(2);
                break;
            case "4":
                bing_tools.opeCircles(2);
                break;
            case "5":
                bing_tools.opePolygons(2);
                break;
            case "6":
                google_tools.opeRuler(2);
                break;
            case "7":
                google_tools.opeDirections(2);
                break;
        }
    }

    function <?php echo $module ?>Show() {
        var idx = $('#<?php echo $module ?>SelectTools').val();
        switch (idx) {
            case "0":
                bing_tools.Disable();
                break;
            case "1":
                bing_tools.opeMarkersOnly(1);
                break;
            case "2":
                bing_tools.opeMarkerPoly(1);
                break;
            case "3":
                bing_tools.opePolyOnly(1);
                break;
            case "4":
                bing_tools.opeCircles(1);
                break;
            case "5":
                bing_tools.opePolygons(1);
                break;
            case "6":
                google_tools.opeRuler(1);
                break;
            case "7":
                google_tools.opeDirections(1);
                break;
        }
    }



    $(function() {
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>delete', 'delete', '<?php echo $module ?>Delete', 'delete');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>show', 'show', '<?php echo $module ?>Show', 'show');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>hide', 'hide', '<?php echo $module ?>Hide', 'hide');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>close', '<?php echo Close ?>', '<?php echo $module ?>Close', 'close');


        var fillColor = new jscolor.color(document.getElementById('bfillColor'), {});
        fillColor.fromString('FF3414');
        var strokecolor = new jscolor.color(document.getElementById('bstrokecolor'), {});
        strokecolor.fromString('8F9643');

        $('#<?php echo $module ?>groupby').selectmenu();
        $('.ui-pg-selbox').selectmenu({width: 75});
        $('.ui-pg-input').css('height', '30px');

<?php echo $module ?>Dialog.setOption('title', '<?php echo MapTools ?>');

    });
<?php echo $module ?>hide_tools(true);
</script>