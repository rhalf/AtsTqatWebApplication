<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
if (!$_GET['type']) {
    die;
}
$type = $_GET['type'];

$Result = $session->get('pois');

if ($type == 1) {
    $code = $module_add;
    $link = 'contents/poi/_cmd.php?type=1';
} else if ($type == 2) {
    $code = $module_edit;
    $link = 'contents/poi/_cmd.php?type=2';
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#<?php echo $code ?>image').html(getPOIOptions());
        $('#<?php echo $code ?>image').ddslick({
            width: 75,
            height: 150,
            onSelected: function(data) {
                $('#<?php echo $code ?>img').val(data.selectedData.value);
            }
        });
        $('.dd-options').css('position', 'fixed');
    })

    function <?php echo $code ?>Response(req) {
        ShowMessage(req.xhRequest.responseText);
<?php if ($type == 2) { ?>
            $('#<?php echo $module ?>_list_a').click();
            $('#<?php echo $module ?>_edit_li').hide();
<?php } ?>
        $('#<?php echo $module ?>_list_tab').html(geturl('contents/poi/_list.php'));

    }
    function <?php echo $code ?>OnSubmit(form) {
        if (Spry.Widget.Form.validate(form) == true) {

            Spry.Utils.submitForm(form, <?php echo $code ?>Response);
            MarkerPOI.reset();
            MarkerPOI.Delete();
            if (MapClass.currMap == 'gmap') {
                //DeletePOILocation();
                //deleteMarkersPOI();
            } else if (MapClass.currMap == 'omap') {
                //	poiLayer.clearMarkers();
                //DrawPOILayer.clearMarkers();
            }
            form.reset();
        }
        return false;
    }

    function del_poi(id) {
        var u = 'contents/poi/_cmd.php?type=3&id=' + id;
        $.ajax({
            type: 'POST',
            url: u,
            success: function(data) {
                ShowMessage(data);
                MarkerPOI.reset();
                MarkerPOI.delete();
                if (MapClass.currMap == 'gmap') {
                    //DeletePOILocation();
                    //deleteMarkersPOI();
                } else if (MapClass.currMap == 'omap') {
                    //poiLayer.clearMarkers();

                }
                $('#<?php echo $module ?>_List_a').click();
                $('#<?php echo $module ?>_edit_li').hide();
                $('#<?php echo $module ?>_list_tab').html(geturl('contents/poi/_list.php'));
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                ShowMessage('Timeout contacting server..');
            }});
    }
    ;

</script>

<div class="contents ui-widget-content" style="height:100%;direction:<?php echo text_direction ?>">
    <form method="post" id="<?php echo $code ?>form" name= "<?php echo $code ?>form" target="_self" action="<?php echo $link ?>" onSubmit="return <?php echo $code ?>OnSubmit(this);">
        <table width="100%" height="100%" border="0">
            <tr>
                <td width="20%" height="26"><?php echo constant($module . 'Name') ?></td>
                <td width="60%"><span id="spry<?php echo $code ?>name">
                        <input name="<?php echo $code ?>name" type="text" id="<?php echo $code ?>name" style="width:100%" maxlength="50" value="" class="inputstyle" />
                        <span class="textfieldRequiredMsg"></span></span></td>
                <td width="20%"><select style="width:100%" name="<?php echo $code ?>image" id="<?php echo $code ?>image">
                    </select></td>

            <tr>
                <td height="70"><?php echo constant($module . 'Description'); ?></td>
                <td><div style="height:100%">
                        <textarea name="<?php echo $code ?>desc" id="<?php echo $code ?>desc" cols="14" rows="4" class="textareastyle"></textarea>
                    </div></td>
                <td>
                    <input id="<?php echo $code ?>id" name="<?php echo $code ?>id" type="hidden" value=""/>
                    <input id="<?php echo $code ?>long" name="<?php echo $code ?>long" type="hidden" value=""/>
                    <input name="<?php echo $code ?>lat" type="hidden" id="<?php echo $code ?>lat" value=""/>
                    <input name="<?php echo $code ?>img" type="hidden" id="<?php echo $code ?>img"/></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    var spry<?php echo $code ?>name = new Spry.Widget.ValidationTextField("spry<?php echo $code ?>name");
</script>