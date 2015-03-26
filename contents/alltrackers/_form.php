<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if (!$_GET['type']) {
    die;
}
$type = $_GET['type'];

$cmpsResult = $session->get('cmps');

if ($type == 1) {
    $code = $module_add;
    $link = 'contents/alltrackers/_cmd.php?type=1';
    //$link='contents/alltrackers/_cmd_test.php?type=1';	
} else if ($type == 2) {
    $code = $module_edit;
    $link = 'contents/alltrackers/_cmd.php?type=2';
    $id = $_GET["id"];
    $TrackersResult = $session->get('alltrackers');
    foreach ($TrackersResult as $row) {
        if ($row['tunit'] == $id) {
            $TrackerRow = $row;
            break;
        }
    }
    $link.="&id=$id";
    //$UsersArray=users_array($UsersResult,$userid,$privilege);
}


//$UsersResult=$session->get('users');
//$TrackersResult=$session->get('trackers');
//$CollResult=$session->get('colls');
$DBHostResult = $session->get('dbhosts');
//$TCPHostResult=$session->get('tcphosts');
$HTTPHostResult = $session->get('httphosts');

//$usersArray=users_array($UsersResult,$userid,$privilege);
//include (ROOT_DIR."/contents/connect/connection.php");
/* foreach ($TrackersResult as $row){
  if($row['tunit']==$_GET["un"]){
  $TrackerRow=$row;
  }
  } */

//$trackersquery = "SELECT * FROM trks where tunit='" .$_GET["un"] ."'";
//$TRStatment = $Conn->query($trackersquery);
//$TRResult = $TRStatment->fetch(PDO::FETCH_ASSOC);
//$Conn=null;
?>
<div>
    <form action="<?php echo $link ?>" method="post" target="_self" id="<?php echo $code ?>form" name="<?php echo $code ?>form" onSubmit="return <?php echo $code ?>OnSubmit(this);" >
        <div id="<?php echo $code ?>tabs" style="height:100%;width:99.5%;padding:0 0 0 0;margin:0 0 0 0" >
            <ul style="-moz-border-radius-bottomleft: 0; -moz-border-radius-bottomright: 0;width:100%;padding:0 0 0 0;margin:0 0 0 0">
                <li><a href="#<?php echo $code ?>_general_tabs"><?php echo General ?></a></li>
                <li><a href="#<?php echo $code ?>_params_tabs"><?php echo Parameters ?></a></li>
                <?php if ($privilege == 1) { ?>
                    <li><a href="#<?php echo $code ?>_config_tabs"><?php echo Configuration ?></a></li>
                <?php } ?>
            </ul>
            <div id="<?php echo $code ?>_general_tabs" style="height:200px;direction:<?php echo text_direction ?>" >
                <table width="100%" border="0">
                    <tr>
                        <td width="15%"><?php echo constant($module . 'Company'); ?></td>
                        <td width="30%"><select style="width:100%" name="<?php echo $code ?>company" id="<?php echo $code ?>company">
                                <?php
                                if ($type == 1) {
                                    foreach ($cmpsResult as $row) {
                                        echo "<option class=\"ui-widget-content\" value = " . $row["cmpdbname"] . ">" . $row["cmpdisplayname"] .
                                        "</option>";
                                    }
                                } else if ($type == 2) {
                                    foreach ($cmpsResult as $row) {
                                        if ($TrackerRow["tcmp"] == $row["cmpdbname"]) {
                                            echo "<option class=\"ui-widget-content\" value = " . $row["cmpdbname"] . " selected='selected'>";
                                        } else {
                                            echo "<option class=\"ui-widget-content\" value = " . $row["cmpdbname"] . " >";
                                        }
                                        echo $row["cmpdisplayname"] . "</option>";
                                    }
                                }
                                ?>
                            </select></td>
                        <td width="5%" rowspan="5"></td>
                        <td width="15%"><?php echo constant($module . 'DriverName'); ?></td>
                        <td width="30%"><span id="spry<?php echo $code ?>drivername">
                                <input type="text" name="<?php echo $code ?>drivername" id="<?php echo $code ?>drivername" class="inputstyle" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['tdrivername'];
                                }
                                ?>" style="width:100%" title="Required, Max chars: 50, Min chars: 3">
                                <span class="textfieldRequiredMsg"></span><span class="textfieldMaxCharsMsg"></span><span class="textfieldMinCharsMsg"></span></span></td>
                    </tr>
                    <tr>
                        <td><?php echo constant($module . 'VehicleReg'); ?></td>
                        <td><span id="spry<?php echo $code ?>vehiclereg">
                                <input name="<?php echo $code ?>vehiclereg" type="text" class="inputstyle" id="<?php echo $code ?>vehiclereg"  style="width:100%" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['tvehiclereg'];
                                }
                                ?>" title="Required, Max chars: 50, Min chars: 3" />
                                <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
                        <td><?php echo constant($module . 'Owner') ?></td>
                        <td><span id="spry<?php echo $code ?>ownername">
                                <input type="text" name="<?php echo $code ?>ownername" id="<?php echo $code ?>ownername" class="inputstyle" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['townername'];
                                }
                                ?>" style="width:100%" title="Max chars: 50" >
                                <span class="textfieldMaxCharsMsg"></span></span></td>
                    </tr>
                    <tr>
                        <td><?php echo constant($module . 'Model'); ?></td>
                        <td><span id="spry<?php echo $code ?>model">
                                <input type="text" name="<?php echo $code ?>model" id="<?php echo $code ?>model" class="inputstyle" style="width:100%" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['tvehiclemodel'];
                                }
                                ?>" title="Max chars: 50" />
                                <span class="textfieldMaxCharsMsg"></span></span></td>
                        <td height="24"><?php echo constant($module . 'Image'); ?></td>
                        <td><select style="width:100%" name="<?php echo $code ?>imagelist" id="<?php echo $code ?>imagelist">
                            </select>
                            <input type="hidden" name="<?php echo $code ?>img" id="<?php echo $code ?>img" value="<?php
                            if ($type == 2) {
                                echo $TrackerRow["timg"];
                            } else if ($type == 1) {
                                echo '0';
                            }
                            ?>" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div id="<?php echo $code ?>_params_tabs" style="height:200px;direction:<?php echo text_direction ?>">
                <table width="100%" border="0">     
                    <tr>
                        <td width="15%"><?php echo constant($module . 'SpeedLimit'); ?></td>
                        <td width="30%"><span id="spry<?php echo $code ?>overspeed">
                                <input type="text" name="<?php echo $code ?>overspeed" id="<?php echo $code ?>overspeed" class="inputstyle" style="width:100%" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['tspeedlimit'];
                                }
                                ?>" title="Required, Max chars: 3, Min chars: 2, Max value: 255, Min value: 10">
                                <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span><span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinValueMsg"></span><span class="textfieldMaxValueMsg"></span></span></td>

                        <td width="5%" rowspan="5"></td>	  
                        <td width="15%"><?php echo constant($module . 'MileageLimit') ?></td>
                        <td width="30%"><span id="spry<?php echo $code ?>mileagelimit">
                                <input type="text" name="<?php echo $code ?>mileagelimit" id="<?php echo $code ?>mileagelimit" class="inputstyle" style="width:100%" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['tmileagelimit'];
                                }
                                ?>" title="Required, Max chars: 6, Min chars: 4, Max value: 100000, Min value: 1000">
                                <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span><span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinValueMsg"></span><span class="textfieldMaxValueMsg"></span></span></td>
                    </tr>
                    <tr>
                        <td><?php echo constant($module . 'VehicleRegExpiry') ?></td>
                        <td><span id="spry<?php echo $code ?>vehicleregexpiry">
                                <input type="text" name="<?php echo $code ?>vehicleregexpiry" id="<?php echo $code ?>vehicleregexpiry" class="inputstyle" style="width:100%" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['tvehicleregexpiry'];
                                }
                                ?>" title="Date format: dd/mm/yyyy">
                                <span class="textfieldInvalidFormatMsg"></span></span></td>
                        <?php if ($privilege == 1) { ?>   
                            <td><?php echo constant($module . 'TrackerExpiry') ?></td>
                            <td><span id="spry<?php echo $code ?>trackerexpiry">
                                    <input type="text" name="<?php echo $code ?>trackerexpiry" id="<?php echo $code ?>trackerexpiry" class="inputstyle" style="width:100%" value="<?php
                                    if ($type == 2) {
                                        echo $TrackerRow['ttrackerexpiry'];
                                    }
                                    ?>" title="Required, Date format: dd/mm/yyyy">
                                    <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span></span></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td><?php echo constant($module . 'MileageInit') ?></td>
                        <td><span id="spry<?php echo $code ?>initialmileage">
                                <input type="text" name="<?php echo $code ?>initialmileage" id="<?php echo $code ?>initialmileage" class="inputstyle" style="width:100%" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['tmileageInit'];
                                }
                                ?>" title="Required, Max chars: 11, Min chars: 1">
                                <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span><span class="textfieldInvalidFormatMsg"></span></span></td>
                        <?php if ($privilege == 1) { ?>
                            <td><?php echo Inputs ?></td>
                            <td><input type="text" name="<?php echo $code ?>inputs" id="<?php echo $code ?>inputs" class="inputstyle" style="width:100%" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['tinputs'];
                                }
                                ?>" title="Max chars: 50"></td>
                            <?php } ?>
                    </tr>
                    <tr>
                        <td><?php echo constant($module . 'IdlingTime') ?></td>
                        <td><span id="spry<?php echo $code ?>IdlingTime">
                                <input type="text" name="<?php echo $code ?>IdlingTime" id="<?php echo $code ?>IdlingTime" class="inputstyle" style="width:100%" value="<?php
                                if ($type == 2) {
                                    echo $TrackerRow['tidlingtime'];
                                }
                                ?>" title="Required, Max chars: 11, Min chars: 1">
                                <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
                        <td><?php echo constant($module . 'Note') ?></td>
                        <td rowspan="2"><span style="width:100%;height:100%">
                                <textarea style="width:100%;height:100%" name="<?php echo $code ?>note" id="<?php echo $code ?>note" cols="25" rows="3" title="Max chars: 100" class="textareastyle"><?php
                                    if ($type == 2) {
                                        echo $TrackerRow['tnote'];
                                    }
                                    ?>
                                </textarea>
                            </span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
            <?php if ($privilege == 1) { ?>
                <div id="<?php echo $code ?>_config_tabs" style="height:200px;direction:<?php echo text_direction ?>">
                    <table width="100%" border="0">
                        <tr>
                            <td width="15%"><?php echo constant($module . 'Type') ?></td>
                            <td width="30%"><div style="width:100%">
                                    <select name="<?php echo $code ?>type" id="<?php echo $code ?>type" style="width:168px">
                                        <?php
                                        if ($type == 1) {
                                            foreach ($devices_Type as $device_Type => $value) {
                                                $selected = ($value == $default_deviceType) ? ' SELECTED' : '';
                                                echo '<option class="ui-widget-content" value="' . $value . '"' . $selected . '>' . $device_Type . '</option>';
                                            }
                                        } else if ($type == 2) {
                                            foreach ($devices_Type as $device_Type => $value) {
                                                $selected = ($value == $TrackerRow['ttype']) ? ' SELECTED' : '';
                                                echo '<option class="ui-widget-content" value="' . $value . '"' . $selected . '>' . $device_Type . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div></td>
                            <td width="5%" rowspan="4"></td>	
                            <td width="15%"><?php echo constant($module . 'Unit') ?></td>
                            <td width="30%"><span id="spry<?php echo $code ?>unit">
                                    <input name="<?php echo $code ?>unit" type="text" id="<?php echo $code ?>unit" class="inputstyle" style="width:100%" value="<?php
                                    if ($type == 2) {
                                        echo $TrackerRow['tunit'];
                                    }
                                    ?>" title="Required, Max chars: 50, Min chars: 3">
                                    <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
                        </tr>
                        <tr>
                            <td><?php echo constant($module . 'SimNo') ?></td>
                            <td><span id="spry<?php echo $code ?>simno">
                                    <input type="text" name="<?php echo $code ?>simno" id="<?php echo $code ?>simno" class="inputstyle" value="<?php
                                    if ($type == 2) {
                                        echo $TrackerRow['tsimno'];
                                    }
                                    ?>" style="width:100%" title="Required, Max chars: 50, Min chars: 3">
                                    <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
                            <td><?php echo constant($module . 'Provider') ?></td>
                            <td><div style="width:100%">
                                    <select id="<?php echo $code ?>provider" name="<?php echo $code ?>provider" class="inputstyle" style="width:168px">
                                        <?php
                                        if ($type == 1) {
                                            foreach ($Providers as $provider => $value) {
                                                $selected = ($value == $default_provider) ? ' SELECTED' : '';
                                                echo '<option class="ui-widget-content" value="' . $value . '"' . $selected . '>' . $provider . '</option>';
                                            }
                                        } else if ($type == 2) {
                                            foreach ($Providers as $provider => $value) {
                                                $selected = ($value == $TrackerRow['tprovider']) ? ' SELECTED' : '';
                                                echo '<option class="ui-widget-content" value="' . $value . '"' . $selected . '>' . $provider . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div></td>
                        </tr>
                        <tr>
                            <td><?php echo constant($module . 'SimSR') ?></td>
                            <td><span id="spry<?php echo $code ?>simsr">
                                    <input type="text" name="<?php echo $code ?>simsr" id="<?php echo $code ?>simsr" class="inputstyle" value="<?php
                                    if ($type == 2) {
                                        echo $TrackerRow['tsimno'];
                                    }
                                    ?>" style="width:100%" title="Required, Max chars: 50, Min chars: 3">
                                    <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
                            <td><?php echo constant($module . 'UnitPassword') ?></td>
                            <td><span id="spry<?php echo $code ?>unitpassword">
                                    <input name="<?php echo $code ?>unitpassword" type="text" id="<?php echo $code ?>unitpassword" class="inputstyle" style="width:100%;" value="<?php
                                    if ($type == 2) {
                                        echo $TrackerRow['tunitpassword'];
                                    }
                                    ?>" maxlength="6" title="Required, Max chars: 11, Min chars: 1" />
                                    <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
                        </tr>
                        <tr>
                            <td><?php echo constant($module . 'DBHost') ?></td>
                            <td><div style="width:100%">
                                    <select name="<?php echo $code ?>dbhost" id="<?php echo $code ?>dbhost" style="width:168px">
                                        <?php
                                        if ($type == 1) {
                                            foreach ($DBHostResult as $row) {
                                                echo "<option class=\"ui-widget-content\" value = " . $row["dbhostid"] . ">" . $row["dbhostname"] .
                                                "</option>";
                                            }
                                        } else if ($type == 2) {
                                            foreach ($DBHostResult as $row) {
                                                if ($TrackerRow["tdbhost"] == $row["dbhostid"]) {
                                                    echo "<option class=\"ui-widget-content\" value = " . $row["dbhostid"] . " selected='selected'>";
                                                } else {
                                                    echo "<option class=\"ui-widget-content\" value = " . $row["dbhostid"] . " >";
                                                }
                                                echo $row["dbhostname"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div></td>
                            <td><?php echo constant($module . 'HTTPPort') ?></td>
                            <td><select name="<?php echo $code ?>httphost" id="<?php echo $code ?>httphost" style="width:168px">
                                    <?php
                                    if ($type == 1) {
                                        foreach ($HTTPHostResult as $row) {
                                            echo "<option class=\"ui-widget-content\" value = " . $row["httphostid"] . ">" . $row["httphostname"] .
                                            "</option>";
                                        }
                                    } else if ($type == 2) {
                                        foreach ($HTTPHostResult as $row) {
                                            if ($row["httphostid"] == $TrackerRow["thttphost"]) {
                                                $selected = 'selected';
                                            } else {
                                                $selected = '';
                                            }
                                            echo "<option class=\"ui-widget-content\" value = " . $row["httphostid"] . " $selected>" . $row["httphostname"] . " </option>";
                                        }
                                    }
                                    ?>
                                </select></td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        </div>
    </form>
</div>
<script type="text/javascript">
    var spry<?php echo $code ?>drivername = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>drivername", "none", {maxChars: 50, minChars: 3});
    var spry<?php echo $code ?>unit = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>unit", "none", {minChars: 3, maxChars: 50});
    var spry<?php echo $code ?>simno = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>simno", "integer", {minChars: 3, maxChars: 50});
    var spry<?php echo $code ?>ownername = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>ownername", "none", {maxChars: 50, isRequired: false});
    var spry<?php echo $code ?>overspeed = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>overspeed", "integer", {minChars: 2, maxChars: 3, minValue: 10, maxValue: 255});
    var spry<?php echo $code ?>vehicleregexpiry = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>vehicleregexpiry", "date", {format: "dd/mm/yyyy", isRequired: false});
    var spry<?php echo $code ?>mileagelimit = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>mileagelimit", "integer", {minChars: 4, maxChars: 6, minValue: 1000, maxValue: 100000});
    var spry<?php echo $code ?>trackerexpiry = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>trackerexpiry", "date", {format: "dd/mm/yyyy"});
    var spry<?php echo $code ?>initialmileage = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>initialmileage", "integer", {minChars: 1, maxChars: 11});
    var spry<?php echo $code ?>IdlingTime = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>IdlingTime", "integer", {minChars: 1, maxChars: 11});
    var spry<?php echo $code ?>simsr = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>simsr", "integer", {minChars: 3, maxChars: 50});
    var spry<?php echo $code ?>model = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>model", "none", {maxChars: 50, isRequired: false});
    var spry<?php echo $code ?>vehiclereg = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>vehiclereg", "none", {minChars: 3, maxChars: 50});
    var spry<?php echo $code ?>unitpassword = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>unitpassword", "integer", {minChars: 1, maxChars: 11});
</script>
<script type="text/javascript">

    function <?php echo $code ?>Save() {
        $('#<?php echo $code ?>form').submit();
    }

    function <?php echo $code ?>Close() {
<?php echo $code ?>Dialog.Close();
    }

    function <?php echo $code ?>resetForm() {
        document.getElementById('<?php echo $code ?>form').reset();
        $('#<?php echo $code ?>_imagelist').ddslick('select', {index: 0});
    }
</script>
<script type="text/javascript">
<?php
if ($type == 2) {
    ?>
        function <?php echo $code ?>Delete() {
            var u = 'contents/alltrackers/_cmd.php?type=3&id=' + '<?php echo $id ?>';
            $("#EditTrackerOutput").html('Loading..');
            $.ajax({
                type: 'POST',
                url: u,
                //   timeout: 2000,    
                success: function(data) {
                    $('#rightdiv').load("main/get_menu_trackers.php");
                    if (<?php echo $module ?>Dialog.isOpen()) {
    <?php echo $module ?>Reload();

                        }
                        ShowMessage(data);
    <?php echo $code ?>Close();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        ShowMessage('Timeout contacting server..');
                        //	  window.setTimeout(update, 60000);    
                    }});
            }
            ;
    <?php
}
?>

        function <?php echo $code ?>Response(req) {
            ShowMessage(req.xhRequest.responseText);
            $('#rightdiv').hide();
            $('#rightdiv').html(geturl("main/get_menu_trackers.php"));
            $('#rightdiv').delay(1000).show();

            if (<?php echo $module ?>Dialog.isOpen()) {
<?php echo $module ?>Reload();
            }
<?php echo $code ?>resetForm();
<?php if ($type == 2) { ?>
    <?php echo $code ?>Close();
<?php } ?>
        }
        ;

        function <?php echo $code ?>OnSubmit(form) {
            if (Spry.Widget.Form.validate(form) == true) {
                Spry.Utils.submitForm(form, <?php echo $code ?>Response);
            }
            return false;
        }
        ;

        $(document).ready(function() {
<?php if ($type == 1) { ?>

                $('#<?php echo $code ?>unitpassword').val('000000');
                $('#<?php echo $code ?>speedlimit').val('80');
                $('#<?php echo $code ?>initialmileage').val('0');
                $('#<?php echo $code ?>overspeed').val('80');
                $('#<?php echo $code ?>IdlingTime').val('5');
                $('#<?php echo $code ?>mileagelimit').val('5000');
                $('#<?php echo $code ?>trackerexpiry').val('<?php echo date("j/n/Y"); ?>');
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>add', '<?php echo Save ?>', '<?php echo $code ?>Save', 'save');
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>reset', '<?php echo Reset ?>', '<?php echo $code ?>resetForm', 'reset');
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>close', '<?php echo Close ?>', '<?php echo $code ?>Close', 'close');
<?php } else if ($type == 2) { ?>
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>add', '<?php echo Save ?>', '<?php echo $code ?>Save', 'save');
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>delete', '<?php echo Delete ?>', '<?php echo $code ?>Delete', 'delete');
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>close', '<?php echo Close ?>', '<?php echo $code ?>Close', 'close');
<?php } ?>


            $("#<?php echo $code ?>vehicleregexpiry").datepicker({dateFormat: 'dd/mm/yy'});
            $("#<?php echo $code ?>trackerexpiry").datepicker({dateFormat: 'dd/mm/yy'});
            $("select#<?php echo $code ?>company").selectmenu({width: 170});
            $("#<?php echo $code ?>tabs").tabs();
            $("select#<?php echo $code ?>type").selectmenu({width: 170});
            $("select#<?php echo $code ?>dbhost").selectmenu({width: 170});
            $("select#<?php echo $code ?>httphost").selectmenu({width: 170});
            $("select#<?php echo $code ?>provider").selectmenu({width: 170});

            $('#<?php echo $code ?>imagelist').html(getIconsOptions());
            $('#<?php echo $code ?>imagelist').ddslick({
                width: 80,
                height: 100,
                onSelected: function(data) {
                    $('#<?php echo $code ?>img').val(data.selectedData.value);
                    $('.dd-selected-image').width(32);
                    $('.dd-selected-image').height(32);
                }

            });
            $('.dd-option-image').width(32);
            $('.dd-option-image').height(32);
            $('.dd-selected-image').width(32);
            $('.dd-selected-image').height(32);


//$("#<?php // echo $code     ?>tabs" ).tabs("option", "heightStyle", "fill" );
            $('.dd-options').css('position', 'fixed');

<?php if ($type == 1) { ?>
    <?php echo $code ?>Dialog.setOption('title', '<?php echo AddTracker ?>');
<?php } else if ($type == 2) { ?>
    <?php echo $code ?>Dialog.setOption('title', '<?php echo EditTracker ?>');
<?php } ?>
        });

</script>