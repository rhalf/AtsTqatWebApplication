<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
$UsersResult = $session->get('users');
$link = "contents/$loc/_parse.php";
?>
<div class="contents ui-widget-content" style="width:100%;direction:<?php echo text_direction ?>">
    <form method="post" id="<?php echo $module ?>form" name= "<?php echo $module ?>form" target="_self" action="<?php echo $link; ?>" onSubmit="return <?php echo $module ?>OnSubmit(this);">
        <table width="100%" height="85%" border="0">
            <tr>
                <td width="20%"><?php echo Type ?></td>
                <td width="20%"><select name="typefilter" id="typefilter" style="width:200px" onchange="getCmdslist($('#typefilter').val());
                        getTrackerslist($('#usersfilter').val(), $('#typefilter').val())">
                                            <?php
                                            foreach ($devices_Type as $device_Type => $value) {
                                                $selected = ($value == $default_deviceType) ? ' SELECTED' : '';
                                                echo '<option value="' . $value . '"' . $selected . '>' . $device_Type . '</option>';
                                            }
                                            ?>
                    </select></td>
                <td width="10%">
                    <input name="cmdname" id="cmdname" type="hidden" value="" />
                    <input name="vehiclereg" id="vehiclereg" type="hidden" value="" />
                    <input name="cmd" id="cmd" type="hidden" value="" /></td>
                <td width="50%">&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo Command ?></td>
                <td><span id="sprycmdtype">
                        <select name="cmdtype" id="cmdtype" style="width:200px;" onchange="$('#cmdname').val(document.getElementById('cmdtype').options[document.getElementById('cmdtype').selectedIndex].text)">
                        </select>
                    </span></td>
                <td><div id="valcmdlbl" ><?php echo Value ?></div></td>
                <td align="left">
                    <div id="valcmd" ><span id="sprycmd_value">
                            <input class="inputstyle" name="cmd_value" type="text" id="cmd_value" style="width:75px" value="" />
                            <span class="textfieldMaxValueMsg"></span></span></div>
                    </span></td>
            </tr>
            <tr height="35px">
                <td><?php echo User ?></td>
                <td><select name="usersfilter" id="usersfilter" style="width:200px" onchange="getTrackerslist($('#usersfilter').val(), $('#typefilter').val())">
                        <?php
                        foreach ($UsersResult as $row) {
                            if ($userid == $row["uid"]) {
                                echo "<option value = " . $row["uid"] . " selected='selected'>";
                            } else {
                                echo "<option value = " . $row["uid"] . ">";
                            }
                            echo $row["uname"] . "</option>";
                        }
                        ?>
                    </select></td>
                <td colspan="2" rowspan="6" valign="top"><div id="cmddesc"></div></td>
            </tr>
            <tr height="35px">
                <td>&nbsp;</td>
                <td><input placeholder="<?php echo SearchTip ?>" class="search ui-state-default" name="vehicle_search" id="vehicle_search" type="text" style="width:100%" /></td>
            </tr>
            <tr>
                <td valign="top"><?php echo Vehicles ?></td>
                <td rowspan="4" valign="top"><span id="sprycmd_unit">
                        <select class="textareastyle" name="cmd_unit" size="10" id="cmd_unit" style="width:200px" title="Please select an item.">
                        </select>
                        <span class="selectRequiredMsg"></span></span></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
            </tr>
        </table>
    </form>
</div>
<div id="Confirm_dialog"></div>
<script type="text/javascript">
    $('#valcmd').hide();
    $('#valcmdlbl').hide();

    $(function() {

        $("#cmdtype").selectmenu({
            width: 200,
            change: function() {
                commandControl();
            }
        });
        $('#cmd_unit').change(function(e) {
            $('#vehiclereg').val(document.getElementById('cmd_unit').options[document.getElementById('cmd_unit').selectedIndex].text);
        });


        $('#usersfilter').selectmenu();
        $('#typefilter').selectmenu();
        $('input[name=vehicle_search]').keyup(function() {
            var $this = $(this);
            if ($this.val() != '') {
                $("#cmd_unit").find('option:contains(' + $this.val() + ')').attr("selected", "selected");
            }
        });

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>Send', '<?php echo Send ?>', '<?php echo $module ?>Send', 'save');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>Reset', '<?php echo Reset ?>', '<?php echo $module ?>Reset', 'reset');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>close', '<?php echo Close ?>', '<?php echo $module ?>Close', 'close');

<?php echo $module ?>Dialog.setOption('title', '<?php echo Commands ?>');

    });

    function <?php echo $module ?>Close() {
<?php echo $module ?>Dialog.Close();
    }
    ;

    function <?php echo $module ?>Send() {
        $('#<?php echo $module ?>form').submit();
    }
    ;

    function <?php echo $module ?>Response(req) {
        ShowMessage(req.xhRequest.responseText);
    }
    ;

    function <?php echo $module ?>OnSubmit(form) {
        if (Spry.Widget.Form.validate(form) == true) {
            var needconfirm = false;
            var type = $('#typefilter').val();
            var cmdtype = $('#cmdtype').val();
            if (type == '1' || type == '2' || type == '3') {
                if (cmdtype == '4' || cmdtype == '5') {
                    needconfirm = true
                }
            } else if (type == '4') {
                if (cmdtype == '4' || cmdtype == '5') {
                    needconfirm = true
                }
            } else if (type == '5') {
                if (cmdtype == '4' || cmdtype == '5') {
                    needconfirm = true
                }
            } else if (type == '6') {
                if (cmdtype == '4' || cmdtype == '5') {
                    needconfirm = true
                }
            } else if (type == '7') {

            } else if (type == '8') {
                if (cmdtype == '4' || cmdtype == '5') {
                    needconfirm = true
                }
            }
            if (needconfirm) {
                ConfirmationDialog();
            } else {
                Spry.Utils.submitForm(form, <?php echo $module ?>Response);
<?php echo $module ?>Reset();
            }
        }
        return false;
    }
    ;

    function <?php echo $module ?>Reset() {
        $('#<?php echo $module ?>form')[0].reset();
        $("#cmdtype").selectmenu("destroy");
        $("#cmdtype").selectmenu({
            width: 200,
            change: function() {
                commandControl();
            }
        });
        $('#usersfilter').selectmenu("destroy").selectmenu();
        $('#typefilter').selectmenu("destroy").selectmenu();
        $('#valcmd').hide();
        $('#valcmdlbl').hide();
        $('#cmddesc').html('');
        getCmdslist($('#typefilter').val());
        getTrackerslist(<?php echo $userid ?>, $('#typefilter').val());

    }





    function getTrackerslist(id, type) {
        var u = 'contents/commands/_getlist.php?id=' + id + '&type=' + type;
        $.ajax({
            type: 'POST',
            url: u,
            success: function(data) {

                $("#cmd_unit").html(data);

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                ShowMessage('Timeout contacting server..');
            }});
    }
    ;

    function getCmdslist(type) {
        var u = 'contents/commands/_cmdlist.php?type=' + type;
        $.ajax({
            type: 'POST',
            url: u,
            success: function(data) {
                $("#cmdtype").selectmenu("destroy").empty();
                $("#cmdtype").html(data);
                $("#cmdtype").selectmenu({
                    width: 200,
                    change: function() {
                        commandControl();
                    }
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                ShowMessage('Timeout contacting server..');
            }});
    }
    ;

    function commandControl() {
        var type = $('#typefilter').val();
        var cmdtype = $('#cmdtype').val();
        $('#cmddesc').html('');
        $('#cmd_value').val('');
        $('#valcmd').hide();
        $('#valcmdlbl').hide();
        $('#cmd').val(getCommand(type, cmdtype));
        var sprycmd_value = Spry.Widget.Utils.destroyWidgets('sprycmd_value');
        //type 1,2,3
        if (type == '1' || type == '2' || type == '3') {
            if (cmdtype == '1') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            } else if (cmdtype == '2') {
                $('#cmd_value').val('10');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 10, maxValue: 65535});
                $('#cmddesc').html('Interval=value seconds<br />\
                        Max Value=65535');
            } else if (cmdtype == '3') {
                $('#valcmd').show();
                $('#valcmdlbl').show();
                $('#cmd_value').val('80');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 255});
                $('#cmddesc').html('speed=0 cancel speed alarm<br /> \
                        speed limit=value km/h<br />\
                        Max Value=255');
            } else if (cmdtype == '4') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            } else if (cmdtype == '5') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            } else if (cmdtype == '6') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            }
            //type 4				
        } else if (type == '4') {
            if (cmdtype == '1') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            } else if (cmdtype == '2') {
                $('#cmd_value').val('1');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 65535});
                $('#cmddesc').html('Interval=00 stop tracking by Time interval<br /> \
                        Interval=value * 10 seconds<br />\
                        Max Value=65535');

            } else if (cmdtype == '3') {
                $('#valcmd').show();
                $('#valcmdlbl').show();
                $('#cmd_value').val('80');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 255});
                $('#cmddesc').html('speed=0 cancel speed alarm<br /> \
                        speed limit=value km/h<br />\
                        Max Value=200');
            } else if (cmdtype == '4') {
                $('#cmd_value').val('1');
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: true});
            } else if (cmdtype == '5') {
                $('#cmd_value').val('0');
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: true});
            } else if (cmdtype == '6') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            }
            //type 5	
        } else if (type == '5') {
            if (cmdtype == '1') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            } else if (cmdtype == '2') {
                $('#cmd_value').val('1');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 65535});
                $('#cmddesc').html('Interval=0 stop tracking by Time interval<br /> \
                        Interval=value * 10 seconds<br />\
                        Max Value=65535');
            } else if (cmdtype == '3') {
                $('#cmd_value').val('80');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 255});
                $('#cmddesc').html('speed=0 cancel speed alarm<br /> \
                        speed limit=value km/h<br />\
                        Max Value=255');
            } else if (cmdtype == '4') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: true});
                $('#cmd_value').val('0,1');
            } else if (cmdtype == '5') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: true});
                $('#cmd_value').val('0,0');
            } else if (cmdtype == '6') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            }
            //type 6		
        } else if (type == '6') {
            if (cmdtype == '1') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            } else if (cmdtype == '2') {
                $('#cmd_value').val('1');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 65535});
                $('#cmddesc').html('Interval=0 stop tracking by Time interval<br /> \
                        Interval=value * 10 seconds<br />\
                        Max Value=65535');
            } else if (cmdtype == '3') {
                $('#cmd_value').val('80');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 255});
                $('#cmddesc').html('speed=0 cancel speed alarm<br /> \
                        speed limit=value km/h<br />\
                        Max Value=255');
            } else if (cmdtype == '4') {
                $('#cmd_value').val('0100000000');
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: true});
            } else if (cmdtype == '5') {
                $('#cmd_value').val('0000000000');
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: true});
            } else if (cmdtype == '6') {
                $('#cmd_value').val('');
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            }
            //type 7			
        } else if (type == '7') {
            if (cmdtype == '1') {
                $('#cmd_value').val('');
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            } else if (cmdtype == '2') {
                $('#cmd_value').val('1');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 65535});
                $('#cmddesc').html('Interval=0 stop tracking by Time interval<br /> \
                        Interval=value * 10 seconds<br />\
                        Max Value=65535');
            } else if (cmdtype == '3') {
                $('#cmd_value').val('80');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 255});
                $('#cmddesc').html('speed=0 cancel speed alarm<br /> \
                        speed limit=value km/h<br />\
                        Max Value=255');
            } else if (cmdtype == '4') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            }
            //type 8			
        } else if (type == '8') {
            if (cmdtype == '1') {
                $('#cmd_value').val('');
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            } else if (cmdtype == '2') {
                $('#cmd_value').val('1');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 65535});
                $('#cmddesc').html('Interval=0 stop tracking by Time interval<br /> \
                        Interval=value * 10 seconds<br />\
                        Max Value=65535');
            } else if (cmdtype == '3') {
                $('#cmd_value').val('80');
                $('#valcmd').show();
                $('#valcmdlbl').show();
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "integer", {isRequired: true, minValue: 0, maxValue: 255});
                $('#cmddesc').html('speed=0 cancel speed alarm<br /> \
                        speed limit=value km/h<br />\
                        Max Value=255');
            } else if (cmdtype == '4') {
                $('#cmd_value').val('0,10000');
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: true});
            } else if (cmdtype == '5') {
                $('#cmd_value').val('0,00000');
            } else if (cmdtype == '6') {
                spryDestroy(sprycmd_value);
                var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
            }
        }
    }

    getTrackerslist(<?php echo $userid ?>, $('#typefilter').val());
    getCmdslist($('#typefilter').val());
    var sprycmdtype = new Spry.Widget.ValidationSelect("sprycmdtype", {invalidValue: "0", isRequired: false});
    var sprycmd_value = new Spry.Widget.ValidationTextField("sprycmd_value", "none", {isRequired: false});
    var sprycmd_unit = new Spry.Widget.ValidationSelect("sprycmd_unit");
</script>