<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

$CollResult = $session->get('colls');
?>

<script type="text/javascript">
    var collidArray = [];
    var collnameArray = [];
    var colldescArray = [];

    collidArray.length = 0;
    collnameArray.length = 0;
    colldescArray.length = 0;
<?php
foreach ($CollResult as $row) {
    ?>
        collidArray.push('<?php echo $row['collid'] ?>');
        collnameArray.push('<?php echo $row['collname'] ?>');
        colldescArray.push('<?php echo $row['colldesc'] ?>');
<?php } ?>



    $('#<?php echo $module ?>_list').click(function() {
        var collSelOption = $('#<?php echo $module ?>_list option:selected');
        var collOption = $('#<?php echo $module ?>_list option');
        if (collSelOption.length == 1) {
            $('#<?php echo $module ?>_btn_edit').show();
            get_coll_data(collSelOption.val());
        } else {
            $('#<?php echo $module ?>_btn_edit').hide();
        }

    });

    $('#<?php echo $module ?>_list').dblclick(function() {
        var collSelOption = $('#<?php echo $module ?>_list option:selected');
        if (collSelOption.length == 1) {
            $('#<?php echo $module ?>_btn_edit').click();
        }
    });



    $(function() {
        $('input[name=Coll_search]').keypress(function() {
            var $this = $(this);
            if ($this.val() != '') {
                $("select[id=<?php echo $module ?>_list]").find('option:contains(' + $this.val() + ')').removeAttr('selected').attr("selected", "selected");
                $('#<?php echo $module ?>_list').click();
            }
        });
    });


    function get_coll_data(value) {
        for (i in collidArray) {
            if (value == collidArray[i]) {
                $('#<?php echo $module_edit; ?>id').val(collidArray[i]);
                $('#<?php echo $module_edit; ?>name').val(collnameArray[collidArray.indexOf(collidArray[i])]);
                $('#<?php echo $module_edit; ?>desc').html(colldescArray[collidArray.indexOf(collidArray[i])]);
            }
        }

    }

</script>
<div class="contents ui-widget-content" style="direction:<?php echo text_direction ?>">
    <table width="100%" height="175" border="0">
        <tr>
            <td width="100%" align="left">
                <input placeholder="<?php echo SearchTip ?>" class="search ui-state-default" name="Coll_search" id="Coll_search" type="text" style="width:100%"/></td>
        </tr>
        <tr>
            <td width="100%" colspan="2" align="left">
                <select name="<?php echo $module ?>_list" size="7" id="<?php echo $module ?>_list" style="width:100%" class="textareastyle">

                    <?php
//while ($coll_row =$CollResultrow->fetch(PDO::FETCH_ASSOC))
                    if (!empty($CollResult)) {
                        foreach ($CollResult as $CollRow) {
                            echo "<option value = " . $CollRow["collid"] . " >";
                            echo $CollRow["collname"] . "</option>";
                        }
                    }
                    ?>
                </select></td>
        </tr>
    </table>
</div>