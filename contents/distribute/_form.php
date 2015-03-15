<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");


$UsersResult = $session->get('users');
$CollResult = $session->get('colls');
$usersArray = get_AllUsers($UsersResult, $userid);

if ($privilege == 1) {
    include(ROOT_DIR . '/connect/connection.php');
    $cmpSQL = "SELECT cmpname,cmpdbname from cmps;";
    $cmpStatment = $Conn->query($cmpSQL);
    $cmpResult = $cmpStatment->fetchAll(PDO::FETCH_ASSOC);
}

function update_rightListOptions($type, $array, $privilege) {
    $options = '';
    /* 	if ($type==0 || $type==1){	
      if ($privilege!=4){
      $options.= "<option class='ui-widget-content' value = '0'>None</option>";
      }
      } */
    foreach ($array as $Row) {
        if ($type == 0) {
            $options.= '<option class=\'ui-widget-content\' value = \'' . $Row["uid"] . '\'>' . $Row["uname"] . '</option>';
        } else if ($type == 1) {
            $options.= '<option class=\'ui-widget-content\' value = \'' . $Row["collid"] . '\' >' . $Row["collname"] . '</option>';
        } else if ($type == 2) {
            $options.= '<option class=\'ui-widget-content\' value = \'' . $Row["cmpdbname"] . '\' >' . $Row["cmpname"] . '</option>';
        }
    }
    return $options;
}
?>

<div class="contents ui-widget-content" style="border:none;overflow:hidden;direction:<?php echo text_direction ?>">
    <form action="contents/distribute/_cmd.php" method="post" target="_self" id="<?php echo $module ?>form" name="<?php echo $module ?>form" onSubmit="return <?php echo $module ?>OnSubmit(this);">
        <table width="100%" border="0">
            <tr>
                <td colspan="1" align="right">Choose distribute method </td>
                <td colspan="2"><select name="td_type" id="td_type" style="width:50%; margin-right:100px" onChange="javascript:updateRightListOptions($(this).val())">
                        <option class='ui-widget-content' value="0" selected>Users</option>
                        <option class='ui-widget-content' value="1">Collections</option>
                        <?php if ($privilege == 1) { ?>
                            <option class='ui-widget-content' value="2">Company</option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            <td width="45%"><select name="td_userlist_left" id="td_userlist_left" style="width:100%" onChange="Trackerslist($('#td_userlist_left').val())">
                    <?php
                    foreach ($usersArray as $UserRow) {
                        echo "<option class='ui-widget-content' value = " . $UserRow["uid"] . ">" . $UserRow["uname"] . "</option>";
                    }
                    ?>
                </select></td>
            <td width="10%"></td>
            <td width="45%"><select name="td_list_right[]" id="td_list_right" style="width:100%" multiple>
                    <?php
                    echo update_rightListOptions(0, $usersArray, $privilege);
                    /* foreach ($UsersResult as $UserRow)
                      {
                      echo "<option class='ui-widget-content' value = " . $UserRow["uid"] . ">" . $UserRow["uname"] . "</option>";
                      } */
                    ?>
                </select></td>
            </tr>
            <tr>
                <td><select class="textareastyle" id="SelectLeft" multiple="multiple" style="height:200px;width:100%">
                    </select></td>
                <td><input id="MoveRight" type="button" value=" >> " />
                    <input id="MoveLeft" type="button" value=" << " /></td>
                <td><select class="textareastyle" id="SelectRight" name="dist[]" multiple="multiple" style="height:200px;width:100%" >
                    </select></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    function <?php echo $module ?>Close() {
<?php echo $module ?>Dialog.Close();
    }

    $(function() {
        $("#dt_close").button({icons: {primary: "ui-icon-close"}});
        $("#dt_reset").button({icons: {primary: "ui-icon-arrowrefresh-1-e"}});

        $("#dt_distribute").button({icons: {primary: "ui-icon-check"}});
        $("#MoveRight").button();
        $("#MoveLeft").button();
        $("#td_userlist_left").selectmenu({width: 260});
        $("#td_type").selectmenu({width: 260});
        //$("#td_list_right").selectmenu({width:260});
    });



    $(function() {
        $("#MoveRight,#MoveLeft").click(function(e) {
            var id = $(event.target).attr("id");
            var selectFrom = id == "MoveRight" ? "#SelectLeft" : "#SelectRight";
            var moveTo = id == "MoveRight" ? "#SelectRight" : "#SelectLeft";

            var selectedItems = $(selectFrom + " :selected").toArray();
            $(moveTo).append(selectedItems);
        })
    });


    function <?php echo $module ?>Save() {
        $('#<?php echo $module ?>form').submit();
    }

    function <?php echo $module ?>Response(req) {
        ShowMessage(req.xhRequest.responseText);
        $('#rightdiv').html(geturl("main/get_menu_trackers.php"));

        $("#lt_reload").click();
    }

    function <?php echo $module ?>OnSubmit(form) {
        if ($('#SelectRight').val() === "" || $('#td_userlist_left').val() === $('#td_userlist_right').val()) {
            $('#TrackerDistOutput').html('Distribute error! ').fadeIn('slow').delay(3000).fadeOut('slow');
        } else {
            if (Spry.Widget.Form.validate(form) == true) {

                Spry.Utils.submitForm(form, <?php echo $module ?>Response);
            }
        }
        return false;

    }

    function Trackerslist(id) {
        var u = 'contents/distribute/_getlist.php?usr=' + id;
        $("#SelectLeft").html('Loading..');
        $.ajax({
            type: 'POST',
            url: u,
            // timeout: timeout,    
            success: function(data) {

                $("#SelectLeft").html(data);
                //window.setTimeout(Privilegelist, 10000);   
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $("#trackers_list").html('Timeout contacting server..');
                //  window.setTimeout(Privilegelist, 60000);    
            }});


    }
    ;

    function reset_trackerDistrbuteform() {
        document.getElementById('TrackersDistForm').reset();
        $("select#td_userlist_left").selectmenu("destroy").selectmenu();
        //$("select#td_list_right").selectmenu("destroy").selectmenu();
        $("select#td_type").selectmenu("destroy").selectmenu();

        //$("#SelectLeft");
        $("#SelectRight").html('');

    }

</script> 
<script type="text/javascript">

    Trackerslist($('#td_userlist_left').val());
    function updateRightListOptions(type) {
        $('#td_list_right').dropdownchecklist("destroy");
        $("#td_list_right").attr("multiple", "multiple");
        $('#td_list_right').empty();
        //$("#td_list_right").selectmenu("destroy");
        if (type == 0) {
            $('#td_list_right').append("<?php echo update_rightListOptions(0, $usersArray, $privilege); ?>");

        } else if (type == 1) {
<?php if (!empty($CollResult)) { ?>
                $('#td_list_right').append("<?php echo update_rightListOptions(1, $CollResult, $privilege); ?>");
<?php } ?>
        }
<?php if ($privilege == 1) { ?>
            else if (type == 2) {
    <?php if (!empty($cmpResult)) { ?>
                    $("#td_list_right").removeAttr('multiple');
                    $('#td_list_right').append("<?php echo update_rightListOptions(2, $cmpResult, $privilege); ?>");
    <?php } ?>

            }
<?php } ?>
        $("#td_list_right").dropdownchecklist({icon: {}, width: 260, maxDropHeight: 150});

    }

    $(document).ready(function() {


<?php echo $module ?>Dialog.addButton('<?php echo $module ?>save', '<?php echo Save ?>', '<?php echo $module ?>Save', 'save');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>close', '<?php echo Close ?>', '<?php echo $module ?>Close', 'close');

<?php echo $module ?>Dialog.setOption('title', '<?php echo Distribute ?>');

        $("#td_list_right").dropdownchecklist({icon: {}, width: 260, maxDropHeight: 150});
    });
</script>