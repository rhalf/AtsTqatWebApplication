<?php
include_once("../settings.php");
include_once("../scripts.php");

if (filter_input(INPUT_GET, 'id') === NULL) {
    die;
}
$un = filter_input(INPUT_GET, 'id');
echo "<ul style='width:200px;padding-left:5px;border-radius:5px'>";
echo "  <li style='background: none;margin-top:3px;margin-bottom:3px'>";
echo "    <table width='100%' border='0'>";
echo "      <tr>";
echo "        <td><a class='mapchooser' href='javascript:void(0)' ></a></td>";
echo "        <td><select class='section-map select{$un}' onchange='setTrackerMap('" . $un . "',$(this).val())' style='width:98%'>";
echo "          </select></td>";
echo "      </tr>";
echo "    </table>";
echo "  </li>";
echo "  <li style='background:none;margin-top:3px;margin-bottom:3px'>";
echo "    <button class='abutton treplay' type='button' value='' style='width:98%;height:25px' >";
echo "    <div style='padding-left:5px ;float:left;vertical-align:middle' align='center'></div>";
echo "    <span class='ui-icon ui-icon-video' style='float:right'></span></button>";
echo "  </li>";
if ($privilege != 4) {
    echo "  <li style='background: none;margin-top:3px;margin-bottom:3px'>";
    echo "    <button class='abutton tedit' type='button' onclick=\"javascript:EditTracker('{$un}')\" value='' style='width:98%;height:25px' >";
    echo "    <div style='padding-left:5px;float:left; vertical-align:middle' align='center'></div>";
    echo "    <span class='ui-icon ui-icon-pencil' style='float:right'></span></button>";
    echo "  </li>";
}
if ($privilege != 4) {
    echo "  <li style='background: none;margin-top:3px;margin-bottom:3px'>";
    echo "    <button class='abutton tlocate' type='button'  value='' style='width:98%;height:25px'>";
    echo "    <div style='padding-left:5px;float:left; vertical-align:middle' align='center'></div>";
    echo "    <span class='ui-icon ui-icon-pin-s' style='float:right'></span></button>";
    echo "  </li>";
}
if ($privilege != 4) {
    echo "  <li style='background: none;margin-top:3px;margin-bottom:3px'>";
    echo "    <button class='abutton tmileage' type='button' value=''style='width:98%;height:25px'>";
    echo "    <div style='padding-left:5px;float:left; vertical-align:middle' align='center'></div>";
    echo "    <span class='ui-icon ui-icon-flag' style='float:right'></span></button>";
    echo "  </li>";
}
echo "</ul>";
?>
<script type="text/javascript">
    $('.abutton').button();
    $('.mapchooser').html(MAP_LBL);
    $('.treplay').find('.ui-button-text').find('div').html(TRACKINGREPLAY_LBL);
    $('.tedit').find('.ui-button-text').find('div').html(EDIT_LBL);
    $('.tlocate').find('.ui-button-text').find('div').html(LOCATE_LBL);
    $('.tmileage').find('.ui-button-text').find('div').html(SETMILEAGE_LBL);
    $('.uedit').find('.ui-button-text').find('div').html(EDIT_LBL);
    getMapOptions();

    $('.treplay').click(function(e) {
        create_trackingreplay('<?php echo $un ?>');
    });

    $('.tmileage').click(function(e) {
        create_setmileage('<?php echo $un ?>');
    });

    $('.tlocate').click(function(e) {
        var un = '<?php echo $un ?>';
        var data = {
            cmd_unit: un,
            cmdname: "Locate",
            cmd_value: "",
            vehiclereg: $('.u' + un).html(),
            cmd: getCommand($('.type' + un).val(), '1')
        };
        $.ajax({
            type: "POST",
            url: "contents/commands/_parse.php",
            data: data,
            success: function(data) {
                eval($(data).text());
                ShowMessage('Message Sent');
            }
        });

    });
</script>