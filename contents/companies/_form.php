<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if (!$_GET['type']) {
    die;
}
$type = $_GET['type'];

if ($type == 1) {
    $code = $module_add;
    $link = "contents/{$loc}/_cmd.php?type=1";
} else if ($type == 2) {
    if (!isset($_GET['id'])) {
        die;
    }
    $id = $_GET["id"];
    $code = $module_edit;
    $link = "contents/{$loc}/_cmd.php?type=2";
    $Result = $session->get('cmps');
    foreach ($Result as $row) {
        if ($id == $row['cmpid']) {
            $companyRow = $row;
            break;
        }
    }
    $link.="&id=$id";
}
$allTrackersResult = $session->get('alltrackers');
$dbhostsResult = $session->get('dbhosts');
?>
<div class="contents ui-widget-content" style="direction:<?php echo text_direction ?>">
    <form method="post" id="<?php echo $code ?>form" name= "<?php echo $code ?>form" target="_self" action="<?php echo $link ?>" onSubmit="return <?php echo $code ?>OnSubmit(this);">
        <table width="100%" height="161" border="0">
            <tr>
                <td width="15%" height="24"><?php echo constant($module . 'Account'); ?></td>
                <td width="30%"><span id="spry<?php echo $code ?>cmpname">
                        <input name="<?php echo $code ?>cmpname" type="text" id="<?php echo $code ?>cmpname" style="width:100%" value="<?php
                        if ($type == 2) {
                            echo $companyRow['cmpname'];
                        }
                        ?>" maxlength="50" title="Required, Min chars is 3, Max chars is 50" class="inputstyle"/>
                        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
                <td width="10%" rowspan="6"></td>
                <td width="15%" height="24"><?php echo constant($module . 'DisplayName') ?></td>
                <td width="30%"><span id="spry<?php echo $code ?>cmpdisplayname">
                        <input name="<?php echo $code ?>cmpdisplayname" type="text" id="<?php echo $code ?>cmpdisplayname" style="width:100%" value="<?php
                        if ($type == 2) {
                            echo $companyRow['cmpdisplayname'];
                        }
                        ?>" maxlength="50" title="Required, Min chars is 3, Max chars is 100"class="inputstyle" />
                        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td width="102" height="24"><?php echo constant($module . 'Email') ?></td>
                <td width="148"><span id="spry<?php echo $code ?>cmpemail">
                        <input name="<?php echo $code ?>cmpemail" type="text" id="<?php echo $code ?>cmpemail" style="width:100%" maxlength="50"value="<?php
                        if ($type == 2) {
                            echo $companyRow['cmpemail'];
                        }
                        ?>" title="Min chars is 5, Max chars is 50, E-mail format" class="inputstyle"/>
                    </span></td>
                <td width="83" height="24"><?php echo constant($module . 'PhoneNo') ?></td>
                <td width="146"><input name="<?php echo $code ?>cmpphoneno" type="text" id="<?php echo $code ?>cmpphoneno" style="width:100%" maxlength="50"value="<?php
                    if ($type == 2) {
                        echo $companyRow['cmpphoneno'];
                    }
                    ?>"class="inputstyle"/></td>
            </tr>
            <tr>
                <td width="102" height="24"><?php echo constant($module . 'Address') ?></td>
                <td width="148"><input name="<?php echo $code ?>cmpaddress" type="text" id="<?php echo $code ?>cmpaddress" style="width:100%" maxlength="50"value="<?php
                    if ($type == 2) {
                        echo $companyRow['cmpaddress'];
                    }
                    ?>"class="inputstyle" /></td>
                <td width="83" height="24"><?php echo constant($module . 'MobileNo') ?></td>
                <td width="146"><input name="<?php echo $code ?>cmpmobileno" type="text" id="<?php echo $code ?>cmpmobileno" style="width:100%" maxlength="50" value="<?php
                    if ($type == 2) {
                        echo $companyRow['cmpmobileno'];
                    }
                    ?>"class="inputstyle"/></td>
            </tr>
            <tr>


            </tr>
            <tr>
                <td width="102" height="24"><?php echo constant($module . 'DBHost') ?></td>
                <td width="148"><select name="<?php echo $code ?>cmphost" id="<?php echo $code ?>cmphost" style="width:100%" <?php
                    if ($type == 2) {
                        echo 'disabled';
                    }
                    ?> >
                                            <?php
                                            if ($type == 1) {
                                                foreach ($dbhostsResult as $hostrow) {
                                                    echo "<option value = " . $hostrow["dbhostid"] . " >";
                                                    echo $hostrow["dbhostname"] . "</option>";
                                                }
                                            } else if ($type == 2) {
                                                foreach ($dbhostsResult as $hostrow) {
                                                    if ($companyRow["cmphost"] == $hostrow["dbhostid"]) {
                                                        echo "<option value = " . $hostrow["dbhostid"] .
                                                        " selected='selected'>";
                                                    } else {
                                                        echo "<option value = " . $hostrow["dbhostid"] . " >";
                                                    }
                                                    echo $hostrow["dbhostname"] . "</option>";
                                                }
                                                echo "</select>";
                                                echo "</label>";
                                            }
                                            ?>
                    </select></td>
                <td width="83" height="24"><?php echo constant($module . 'Active') ?></td>
                <td width="146"><select name="<?php echo $code ?>cmpactive" id="<?php echo $code ?>cmpactive" style="width:100%">
                        <?php
                        if ($type == 1) {
                            echo "<option class='ui-widget-content' value='1' selected='selected'>" . Yes . "</option>";
                            echo "<option class='ui-widget-content' value='0'>" . No . "</option>";
                        } else if ($type == 2) {
                            if ($companyRow['cmpactive'] == 1) {
                                echo "<option class='ui-widget-content' value='1' selected='selected'>" . Yes . "</option>";
                                echo "<option class='ui-widget-content' value='0'>" . No . "</option>";
                            } else {
                                echo "<option class='ui-widget-content' value='1'>" . Yes . "</option>";
                                echo "<option class='ui-widget-content' value='0' selected='selected'>" . No . "</option>";
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><?php echo constant($module . 'TimeZone') ?></td>
                <td>
                    <select id="<?php echo $code ?>timezone" name="<?php echo $code ?>timezone" style="width:100%">
                        <?php
                        foreach ($Zonelist as $key => $value) {
                            if ($key == $defaultTimeZone) {
                                echo '<option class="ui-widget-content" value="' . $key . '" selected>' . $value . '</option>';
                            } else {
                                echo '<option class="ui-widget-content" value="' . $key . '">' . $value . '</option>';
                            }
                        }
                        ?>
                    </select>   

                </td>
                <td><?php echo constant($module . 'ExpireDate') ?>
                </td>
                <td><span id="spry<?php echo $code ?>cmpexpiredate">
                        <input name="<?php echo $code ?>cmpexpiredate" type="text" id="<?php echo $code ?>cmpexpiredate" style="width:100%" maxlength="50"value="<?php
                        if ($type == 2) {
                            echo $companyRow['cmpexpiredate'];
                        }
                        ?>" title="Date format dd/mm/yyyy"class="inputstyle" />
                        <span class="textfieldInvalidFormatMsg"></span></span>
                </td>
        </table>
    </form>
</div>
<script type="text/javascript">
    var spry<?php echo $code ?>cmpname = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>cmpname", "none", {minChars: 3, maxChars: 50});
    var spry<?php echo $code ?>cmpexpiredate = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>cmpexpiredate", "date", {isRequired: false, format: "dd/mm/yyyy"});
    var spry<?php echo $code ?>cmpdisplayname = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>cmpdisplayname", "none", {minChars: 3, maxChars: 100});
    var spry<?php echo $code ?>cmpemail = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>cmpemail", "none", {isRequired: false});
</script>
<script type="text/javascript">
    function <?php echo $code ?>Close() {
<?php echo $code ?>Dialog.Close();
    }

    function <?php echo $code ?>Save() {
        $('#<?php echo $code ?>form').submit();
    }

    function <?php echo $code ?>resetForm() {
        $('#<?php echo $code ?>form')[0].reset();
    }

    function <?php echo $code ?>Resize() {
    }

    function <?php echo $code ?>Response(req) {
        ShowMessage(req.xhRequest.responseText);
        if (<?php echo $module ?>Dialog.isOpen()) {
<?php echo $module ?>Reload();
        }
<?php if ($type == 1) { ?>
    <?php echo $code ?>resetForm();
<?php } else if ($type == 2) { ?>
    <?php echo $code ?>Dialog.Close();
<?php } ?>
        }
        function <?php echo $code ?>OnSubmit(form) {
            if (Spry.Widget.Form.validate(form) == true) {

                Spry.Utils.submitForm(form, <?php echo $code ?>Response);
            }
            return false;
        }
<?php if ($type == 2) { ?>
            function <?php echo $code ?>Delete() {
                var u = 'contents/<?php echo $loc ?>/_cmd.php?type=3&id=' + '<?php echo $id ?>';
                $.ajax({
                    type: 'POST',
                    url: u,
                    success: function(data) {
                        ShowMessage(data);
    <?php echo $code ?>Close();
                        if (<?php echo $module ?>Dialog.isOpen()) {
    <?php echo $module ?>Reload();
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        ShowMessage('Timeout contacting server..');
                    }});
            }
            ;
<?php } ?>
</script>
<script type="text/javascript">
    $(document).ready(function(e) {

        $("select#<?php echo $code ?>timezone").selectmenu({width: 200});
        $("select#<?php echo $code ?>cmphost").selectmenu({width: 200});
        $("select#<?php echo $code ?>cmpactive").selectmenu({width: 200});
        $("#<?php echo $code ?>cmpexpiredate").datepicker({dateFormat: 'dd/mm/yy'});


<?php if ($type == 1) { ?>
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>add', '<?php echo Save ?>', '<?php echo $code ?>Save', 'save');
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>reset', '<?php echo Reset ?>', '<?php echo $code ?>resetForm', 'reset');
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>close', '<?php echo Close ?>', '<?php echo $code ?>Close', 'close');
    <?php echo $code ?>Dialog.setOption('title', '<?php echo AddCompany ?>');
<?php } else if ($type == 2) { ?>
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>add', '<?php echo Save ?>', '<?php echo $code ?>Save', 'save');
    <?php if ($companyDB != $companyRow['cmpdbname']) { ?>
        <?php if (cmpHasTracker($companyRow['cmpdbname'], $allTrackersResult) == false) { ?>
            <?php echo $code ?>Dialog.addButton('<?php echo $code ?>delete', '<?php echo Delete ?>', '<?php echo $code ?>Delete', 'delete');
        <?php } ?>
    <?php } ?>
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>close', '<?php echo Close ?>', '<?php echo $code ?>Close', 'close');
    <?php echo $code ?>Dialog.setOption('title', '<?php echo EditCompany ?>');
<?php } ?>

        });

</script>