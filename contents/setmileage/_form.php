<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if (!isset($_GET["id"]))
    die;

include (ROOT_DIR . "/connect/connection.php");


$id = $_GET["id"];

$link = "contents/{$loc}/_cmd.php?id='$id'";


$TrackersResult = $session->get('trackers');
$DBHostResult = $session->get('dbhosts');

foreach ($TrackersResult as $row) {
    if ($id == $row['tunit']) {
        $TrackerRow = $row;
    }
}

foreach ($DBHostResult as $row) {
    if ($row['dbhostid'] == $TrackerRow['tdbhost']) {
        $DBHostRow = $row;
    }
}

$trackerDatabase = $TrackerRow["tdbs"];


$trackerConn = new PDO("$engine:host=$DBHostRow[dbhostip];dbname=trk_$trackerDatabase", "$DBHostRow[dbhostuser]", "$DBHostRow[dbhostpassword]", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$MileageSql = "select `gm_mileage` from `gps_$trackerDatabase` 
	order by gm_id desc limit 0, 1;";

$MileageStatment = $trackerConn->query($MileageSql);
$MileageResult = $MileageStatment->fetch(PDO::FETCH_ASSOC);
if ($MileageResult['gm_mileage'] == '') {
    $currMileage = 0;
} else {
    $currMileage = $MileageResult['gm_mileage'];
}

$trackerConn = null;
?>
<div class="ui-widget-content" style="border:none;direction:<?php echo text_direction ?>">
    <form id="<?php echo $module ?>form" name="<?php echo $module ?>form" action="<?php echo $link ?>" method="post" target="_self" onSubmit="return <?php echo $module ?>OnSubmit(this);">
        <table width="100%" border="0" style="margin-top:5px;margin-left:5px">
            <tr>
                <td width="150" height="24"><?php echo constant($module . 'InitialValue'); ?></td>
                <td width="100"><span id="spry<?php echo $module ?>initvalue">
                        <input name="<?php echo $module ?>initvalue" type="text"  id="<?php echo $module ?>initvalue" class="inputstyle"  style="width:90%" value="<?php echo $TrackerRow['tmileageInit']; ?>" title="Required">
                        <span class="textfieldRequiredMsg"></span></span></td>
            </tr>
            <tr>
                <td width="150" height="24"><?php echo constant($module . 'AbsoluteMileage') ?></td>
                <td width="100"><?php echo floatval($currMileage) - floatval($TrackerRow['tmileagereset']); ?></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    var spry<?php echo $module ?>initvalue = new Spry.Widget.ValidationTextField("spry<?php echo $module ?>initvalue");
</script>
<script type="text/javascript">
    function <?php echo $module ?>Close() {
<?php echo $module ?>Dialog.Close();
            }
            ;

            function <?php echo $module ?>Save() {
                $('#<?php echo $module ?>form').submit();
            }
            ;

            function <?php echo $module ?>Response(req) {
                ShowMessage(req.xhRequest.responseText);
                $('.mileage' +<?php echo $id ?>).val($('#<?php echo $module ?>initvalue').val());
<?php echo $module ?>Close();
            }
            function <?php echo $module ?>OnSubmit(form) {
                if (Spry.Widget.Form.validate(form) == true) {
                    Spry.Utils.submitForm(form, <?php echo $module ?>Response);
                }
                return false;
            }
            ;


            function <?php echo $module ?>Reset_tozero() {
                var u = 'contents/setmileage/_cmd.php?id=' +<?php echo $id ?> + '&reset=' +<?php echo $currMileage ?>;
//  $("#atdiv_image").html('Loading..');   
                $.ajax({
                    type: 'POST',
                    url: u,
                    // timeout: 2000,    
                    success: function(data) {
                        $('#rightdiv').html(geturl("main/get_menu_trackers.php"));
<?php echo $module ?>Close();
                                //window.setTimeout(Privilegelist, 10000);   
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                // $("#atdiv_image").html('Timeout contacting server..');     
                                //  window.setTimeout(Privilegelist, 60000);    
                            }});


                    }
                    ;



                    $(function() {

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>save', '<?php echo Save ?>', '<?php echo $module ?>Save', 'save');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>reset', '<?php echo Reset ?>', '<?php echo $module ?>Reset_tozero', '');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>close', '<?php echo Close ?>', '<?php echo $module ?>Close', 'close');

<?php echo $module ?>Dialog.setOption('title', '<?php echo SetMileage ?>');
            });
</script>
