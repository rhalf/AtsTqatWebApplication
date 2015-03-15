<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if (!$_GET['type']) {
    die;
}
$type = $_GET['type'];

$Result = $session->get('colls');

if ($type == 1) {
    $code = $module_add;
    $link = 'contents/collections/_cmd.php?type=1';
} else if ($type == 2) {
    $code = $module_edit;
    $link = 'contents/collections/_cmd.php?type=2';
}

$settings = $session->get('settings');
$grouping = get_setting('grouping_' . $userid, $settings);
?>
<div class="contents ui-widget-content" style="height:100%;direction:<?php echo text_direction ?>">
    <form id="<?php echo $code ?>form" name="<?php echo $code ?>form" action="<?php echo $link ?>" method="post" target="_self" onSubmit="return <?php echo $code ?>OnSubmit(this);">
        <table width="100%" border="0">
            <tr>
                <td width="20%" height="34"><label for="<?php echo $code ?>name"><?php echo constant($module . 'Name'); ?></label></td>
                <td width="80%"><span id="spry<?php echo $code ?>name">
                        <input name="<?php echo $code ?>name" type="text"  id="<?php echo $code ?>name"  style="width:100%" title="Required, Min chars is 4, Max chars is 50" value="" maxlength="50" class="inputstyle">
                        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td height="34"><label for="<?php echo $code ?>desc"><?php echo constant($module . 'Description'); ?></label></td>
                <td><textarea class="textareastyle" name="<?php echo $code ?>desc" id="<?php echo $code ?>desc" cols="45" rows="5"><?php
                        //if ($type==2){
                        //echo $collRow['colldesc'];	
                        //}
                        ?></textarea><input name="<?php echo $code ?>id" id="<?php echo $code ?>id" type="hidden"  value="" ></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    var spry<?php echo $code ?>name = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>name", "none", {minChars: 4, maxChars: 50});
</script>
<script type="text/javascript">
    function <?php echo $code ?>Response(req) {
        ShowMessage(req.xhRequest.responseText);
        $('#<?php echo $module ?>_list_tab').html(geturl('contents/collections/_list.php'));
<?php if ($grouping == 3) { ?>
            $('#rightdiv').html(geturl("main/get_menu_trackers.php"));
<?php } ?>
    }
    function <?php echo $code ?>OnSubmit(form) {

        if (Spry.Widget.Form.validate(form) == true) {
            Spry.Utils.submitForm(form, <?php echo $code ?>Response);
            form.reset();


        }
        return false;

    }
</script>
