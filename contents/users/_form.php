<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");


if (!$_GET['type']) {
    die;
}
$type = $_GET['type'];

$UsersResult = $session->get('users');

if ($type == 1) {
    $code = $module_add;
    $link = "contents/{$loc}/_cmd.php?type=1";
    $UsersArray = get_AllUsers($UsersResult, $userid, $privilege);
} else if ($type == 2) {
    $code = $module_edit;
    $link = "contents/{$loc}/_cmd.php?type=2";
    $id = $_GET["id"];
    foreach ($UsersResult as $row) {
        if ($id == $row['uid']) {
            $userRow = $row;
            break;
        }
    }
    $link.="&id=$id";
    $TrackersResult = $session->get('trackers');

    $subprivilege = $userRow['upriv'];

// Master parent privilege
    if ($privilege == 1) {
        if ($subprivilege == 1) {
            foreach ($UsersResult as $row) {
                if ($row['upriv'] == 1) {
                    $parentRow[] = $row;
                }
            }
        } else {
            foreach ($UsersResult as $row) {
                if (($row['upriv'] != 4) && ($row['uid'] != $userRow['uid'])) {
                    $parentRow[] = $row;
                }
            }
        }


// admin parent privilege	
    } else if ($privilege == 2) {
        if ($subprivilege == 2) {
            foreach ($UsersResult as $row) {
                if ($row['uid'] == $userRow['umain']) {
                    $parentRow[] = $row;
                }
            }
        } else if ($subprivilege == 3) {
            foreach ($UsersResult as $row) {
                if ($row['upriv'] == 2) {
                    $parentRow[] = $row;
                }
            }
        } else if ($subprivilege == 4) {
            foreach ($UsersResult as $row) {
                if ($row['upriv'] == 2 | $row['upriv'] == 3) {
                    $parentRow[] = $row;
                }
            }
        }

// normal parent privilege
    } else if ($privilege == 3) {

        if ($subprivilege == 3) {
            foreach ($UsersResult as $row) {
                if ($row['upriv'] == 2) {
                    $parentRow[] = $row;
                }
            }
        } else if ($subprivilege == 4) {
            foreach ($UsersResult as $row) {
                if ($row['upriv'] == 3) {
                    $parentRow[] = $row;
                }
            }
        }
// limited parent privilege
    } else if ($privilege == 4) {
        foreach ($UsersResult as $row) {
            if ($row['uid'] == $userRow['umain']) {
                $parentRow[] = $row;
            }
        }
    }
}
?>

<div class="contents ui-widget-content" style="direction:<?php echo text_direction ?>">
    <form id="<?php echo $code ?>form" name="<?php echo $code ?>form" action="<?php echo $link ?>" method="post" target="_self" onSubmit="return <?php echo $code ?>OnSubmit(this);">
        <table width="100%" height="300px" border="0">
            <tr>
                <td width="30%"><label for="<?php echo $code ?>username"><?php echo constant($module . "UserName"); ?></label></td>
                <td width="70%"><span id="spry<?php echo $code ?>username">
                        <input name="<?php echo $code ?>username" type="text"  id="<?php echo $code ?>username"  style="width:100%" title="Required, Min chars is 4, Max chars is 50" value="<?php
                        if ($type == 2) {
                            echo $userRow['uname'];
                        }
                        ?>" maxlength="50" class="inputstyle">
                        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td><label for="<?php echo $code ?>password"><?php echo constant($module . "Password") ?></label></td>
                <td><span id="spry<?php echo $code ?>password">
                        <input name="<?php echo $code ?>password" type="password"  id="<?php echo $code ?>password"style="width:100%" title="Required, Min chars is 4, Max chars is 50"  value="<?php
                        if ($type == 2) {
                            echo $userRow['upass'];
                        }
                        ?>" maxlength="50" class="inputstyle">
                        <span class="passwordRequiredMsg"></span><span class="passwordMinCharsMsg"></span><span class="passwordMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td><label for="<?php echo $code ?>email"><?php echo constant($module . "Email") ?></label></td>
                <td><span id="spry<?php echo $code ?>email">
                        <input type="text" name="<?php echo $code ?>email" id="<?php echo $code ?>email" style="width:100%" value="<?php
                        if ($type == 2) {
                            echo $userRow['uemail'];
                        }
                        ?>" title="Min chars is 5, Max chars is 50, E-mail format" class="inputstyle">
                        <span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td><label for="<?php echo $code ?>parent"><?php echo constant($module . "Parent") ?></label></td>
                <td><select name="<?php echo $code ?>parent" id="<?php echo $code ?>parent" style="width:100%" onChange="Privilegelist(this.value);" >
                        <?php
                        if ($type == 1) {
                            foreach ($UsersArray as $row) {
                                if ($row['upriv'] != 4) {
                                    echo "<option value='$row[uid]'>$row[uname]</option>";
                                }
                            }
                        } else if ($type == 2) {
                            foreach ($parentRow as $row) {
                                if ($userRow["umain"] == $row["uid"]) {
                                    echo "<option value='$row[uid]' selected='selected'>";
                                } else {
                                    echo "<option value ='$row[uid]'>";
                                }
                                echo $row["uname"] . "</option>";
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="<?php echo $code ?>tz"><?php echo constant($module . "TimeZone") ?></label></td>
                <td><select id="<?php echo $code ?>tz" name="<?php echo $code ?>tz" style="width:100%">
                        <?php
                        if ($type == 1) {

                            foreach ($Zonelist as $key => $value) {
                                if ($key == $defaultTimeZone) {
                                    echo "<option value='$key' selected>$value</option>";
                                } else {
                                    echo "<option value='$key'>$value</option>";
                                }
                            }
                        } else if ($type == 2) {
                            foreach ($Zonelist as $key => $value) {
                                if ($key == $userRow['utimezone']) {
                                    echo "<option value='$key' selected>$value</option>";
                                } else {
                                    echo "<option value='$key'>$value</option>";
                                }
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="<?php echo $code ?>privilege"><?php echo constant($module . "Privilege") ?></label></td>
                <td><select name="<?php echo $code ?>privilege" id="<?php echo $code ?>privilege" style="width:100%">
                        <?php
                        if ($type == 2) {
                            while ($priv = current($Privileges)) {
                                if ($userRow["upriv"] == $priv) {
                                    echo "<option value='$priv' selected='selected'>";
                                } else {
                                    echo "<option value='$priv'>";
                                }
                                echo implode(",", array_keys($Privileges, $priv)) . "</option>";
                                next($Privileges);
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><label for="<?php echo $code ?>expiredate"><?php echo constant($module . "ExpireDate") ?></label></td>
                <td><span id="spry<?php echo $code ?>expiredate">
                        <input id="<?php echo $code ?>expiredate" name="<?php echo $code ?>expiredate" type="text" style="width:100%" value="<?php
                        if ($type == 2) {
                            echo $userRow['uexpiredate'];
                        }
                        ?>" title="Date format mm/dd/yyyy" class="inputstyle">
                        <span class="textfieldInvalidFormatMsg"></span></span></td>
            </tr>
            <tr>
                <td><label for="<?php echo $code ?>active"><?php echo constant($module . "Active") ?></label></td>
                <td><select name="<?php echo $code ?>active" id="<?php echo $code ?>active" style="width:260px" >
                        <?php
                        if ($type == 1) {
                            echo "<option value='1' selected='selected'>" . Yes . "</option>";
                            echo "<option value='0'>" . No . "</option>";
                        } else if ($type == 2) {
                            if ($userRow['uactive'] == 1) {
                                echo "<option value='1' selected='selected'>" . Yes . "</option>";
                                echo "<option value='0'>" . No . "</option>";
                            } else {
                                echo "<option value='1'>" . Yes . "</option>";
                                echo "<option value='0' selected='selected'>" . No . "</option>";
                            }
                        }
                        ?>
                    </select></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
            var spry<?php echo $code ?>username = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>username", "none", {minChars:4, maxChars:50});
            var spry<?php echo $code ?>password = new Spry.Widget.ValidationPassword("spry<?php echo $code ?>password", {minChars:4, maxChars:50});
            var spry<?php echo $code ?>email = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>email", "email", {isRequired:false, minChars:5, maxChars:50});
            var spry<?php echo $code ?>expiredate = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>expiredate", "date", {format:"dd/mm/yyyy", isRequired:false});</script>
<script type="text/javascript">
            function disableEdit(){
            $('#<?php echo $code ?>save').hide();
            };
            function enableEdit(){
            $('#<?php echo $code ?>save').show();
            };
            function disableDel(){
            $('#<?php echo $code ?>delete').hide();
            };
            function enableDel(){
            $('#<?php echo $code ?>delete').show();
            };
            function <?php echo $code ?>Response(req){
            ShowMessage(req.xhRequest.responseText);
<?php
if ($type == 2) {
    if ($userid == $userRow['uid']) {
        ?>
                    $('.header-info').load("main/main_header_info.php");
    <?php
    }
}
?>
            $('#rightdiv').hide();
                    $('#rightdiv').load("main/get_menu_trackers.php");
                    $('#rightdiv').delay(1000).show();
                    if (<?php echo $module ?>Dialog.isOpen()){
<?php echo $module ?>Reload();
            }

<?php if ($type == 2) { ?>
    <?php echo $code ?>Close();
<?php } ?>
                }

        function <?php echo $code ?>OnSubmit(form){
        if (Spry.Widget.Form.validate(form) == true){
        Spry.Utils.submitForm(form, <?php echo $code ?>Response);
<?php if ($type == 1) { ?>
            form.reset();
<?php } ?>
        }
        return false;
        }


        function <?php echo $code ?>Save(){
        $('#<?php echo $code ?>form').submit();
        }

        function <?php echo $code ?>Close(){
<?php echo $code ?>Dialog.Close();
        }
<?php if ($type == 2) { ?>
            function <?php echo $code ?>Delete() {
            $.ajax({
            type: 'POST',
                    url:"contents/<?php echo $loc ?>/_cmd.php?type=3&id=" + '<?php echo $id ?>',
                    success: function(data) {
                    $('#rightdiv').load("main/get_menu_trackers.php");
                            if (<?php echo $code ?>Dialog.isOpen()){
    <?php echo $module ?>Reload();
                    }
                    ShowMessage(data);
    <?php echo $code ?>Close();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                    ShowMessage('Timeout contacting server..');
                    }

            });
            };
<?php } ?>


<?php if ($type == 2) { ?>
            $('#<?php echo $code ?>privilege').change(function(e) {
            checkParent($('#<?php echo $code ?>parent').val(), $('#<?php echo $code ?>privilege').val());
            });
                    function checkParent(id, NewPrivilege) {
                    var u = "contents/<?php echo $loc ?>/_checkparent.php?id=" + id;
                            $.ajax({
                            type: 'POST',
                                    url:u,
                                    success: function(data) {
                                    var HasUser =<?php
    if (HasUser($userRow['uid'], $UsersResult)) {
        echo 1;
    } else {
        echo 0;
    };
    ?>;
                                            var currPrivilege =<?php echo $privilege ?>;
                                            var ParentPrivilege = data;
                                            // master change admin user
                                            if (NewPrivilege == 3 && HasUser == 1 && ParentPrivilege == 1 && currPrivilege == 1){
                                    ShowMessage('this user has sub users, you must change them parenties');
                                            disableEdit();
                                            disableDel();
                                    } else if (NewPrivilege == 4 && HasUser == 1 && ParentPrivilege == 1 && currPrivilege == 1){
                                    ShowMessage('this user has sub users, you must change them parenties');
                                            disableEdit();
                                            disableDel();
                                    }
                                    // master change normal user
                                    else if (NewPrivilege == 4 && HasUser == 1 && ParentPrivilege == 2 && currPrivilege == 1) {
                                    ShowMessage('this user has sub users, you must change them parenties');
                                            disableEdit();
                                    }
                                    // master change limited user
                                    else if (NewPrivilege == 4 && HasUser == 1 && ParentPrivilege == 3 && currPrivilege == 1) {
                                    ShowMessage('this user has sub users, you must change them parenties');
                                            disableEdit();
                                            disableDel();
                                    } else if (NewPrivilege == 3 && HasUser == 1 && ParentPrivilege == 3 && currPrivilege == 1){
                                    ShowMessage('this user is limited, you must change his parent');
                                            disableEdit();
                                    } // admin change normal user
                                    else if (NewPrivilege == 4 && HasUser == 1 && ParentPrivilege == 2 && currPrivilege == 2) {
                                    ShowMessage('this user has sub users, you must change them parenties');
                                            disableEdit();
                                            disableDel();
                                    } // admin change limited user    change parent
                                    else if (NewPrivilege == 3 && HasUser == 0 && ParentPrivilege == 3 && currPrivilege == 2) {
                                    ShowMessage('this user is limited, you must change his parent');
                                            disableEdit();
                                            disableDel();
                                    } else{
                                    enableEdit();
                                            enableDel();
                                    }
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    ShowMessage('Timeout contacting server..');
                                    }});
                    };
<?php } ?>

        function <?php echo $code ?>resetForm(){
        document.getElementById('<?php echo $code ?>form').reset();
                $("select#<?php echo $code ?>parent").selectmenu("destroy").selectmenu({width:250});
                $("select#<?php echo $code ?>active").selectmenu("destroy").selectmenu({width:250});
                $("select#<?php echo $code ?>tz").selectmenu("destroy").selectmenu({width:250});
                $("select#<?php echo $code ?>parent").change();
        }

        function Privilegelist(id) {
        $.ajax({
        type: 'POST',
<?php if ($type == 1) { ?>
            url:'contents/users/_privilegelist.php?type=1&id=' + id,
<?php } else if ($type == 2) { ?>
            url:'contents/users/_privilegelist.php?type=2&id=' + id + '&currPrivilege=' + $('#<?php echo $code ?>privilege').val(),
<?php } ?>
        //  timeout: 2000,
        success: function(data) {
        $("#<?php echo $code ?>privilege").html(data);
                $("select#<?php echo $code ?>privilege").selectmenu();
<?php if ($type == 2) { ?>
            checkParent($('#<?php echo $code ?>parent').val(), $('#<?php echo $code ?>privilege').val());
<?php } ?>
        },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                ShowMessage('Timeout contacting server..');
                }
        });
        };
                Privilegelist($('#<?php echo $code ?>parent').val());
<?php if ($type == 1) { ?>
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>save', '<?php echo Save ?>', '<?php echo $code ?>Save', 'save');
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>reset', '<?php echo Reset ?>', '<?php echo $code ?>resetForm', 'reset');
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>close', '<?php echo Close ?>', '<?php echo $code ?>Close', 'close');
<?php } else if ($type == 2) { ?>


    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>save', '<?php echo Save ?>', '<?php echo $code ?>Save', 'save');
    <?php
    $hasUser = HasUser($id, $UsersResult);
    $hasTracker = HasTracker($id, $TrackersResult);
    ?>
    <?php if ($hasUser == false && $hasTracker == false && $userid != $userRow['uid']) { ?>
        <?php echo $code ?>Dialog.addButton('<?php echo $code ?>delete', '<?php echo Delete ?>', '<?php echo $code ?>Delete', 'delete');
    <?php } ?>
    <?php echo $code ?>Dialog.addButton('<?php echo $code ?>close', '<?php echo Close ?>', '<?php echo $code ?>Close', 'close');
<?php } ?>


        $(document).ready(function(e) {
        $("#<?php echo $code ?>expiredate").datepicker({ dateFormat: 'dd/mm/yy' });
                $("select#<?php echo $code ?>parent").selectmenu({width:250});
                $("select#<?php echo $code ?>tz").selectmenu({width:250});
                $("select#<?php echo $code ?>privilege").selectmenu({width:250});
                $("select#<?php echo $code ?>active").selectmenu({width:250});
<?php if ($type == 1) { ?>
    <?php echo $code ?>Dialog.setOption('title', '<?php echo constant($module . "AddUser") ?>');
<?php } else if ($type == 2) { ?>
    <?php echo $code ?>Dialog.setOption('title', '<?php echo constant($module . "EditUser") ?>');
<?php } ?>


<?php
if ($type == 2) {
    if ($userid == $userRow['uid']) {
        ?>
                $('#<?php echo $code ?>expiredate').attr('disabled', true);
                        $('#<?php echo $code ?>privilege').attr('disabled', true);
                        $("select#<?php echo $code ?>active").selectmenu("destroy");
                        $('#<?php echo $code ?>active').attr('disabled', true);
                        $("select#<?php echo $code ?>active").selectmenu({width:250});
        <?php
    }
}
?>
        });
</script> 