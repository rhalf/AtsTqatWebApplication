<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");


if (!isset($_REQUEST['cmd_unit'])) {
    die;
}
if (!isset($_REQUEST['cmd_value'])) {
    die;
}
if (!isset($_REQUEST['vehiclereg'])) {
    die;
}
if (!isset($_REQUEST['cmd'])) {
    die;
}

if ($privilege == 4) {
    die;
}


$id = $_REQUEST['cmd_unit'];

$TrackersResult = $session->get('trackers');
$HTTPHostResult = $session->get('httphosts');

foreach ($TrackersResult as $row) {
    if ($id == $row['tunit']) {
        $TrackerRow = $row;
        break;
    }
}

foreach ($HTTPHostResult as $row) {
    if ($row['httphostid'] == $TrackerRow['thttphost']) {
        $HTTPHostRow = $row;
        break;
    }
}

$type = $TrackerRow['ttype'];

$host = $HTTPHostRow['httphostip'];
$cmdport = $HTTPHostRow['cmdport'];

$cmd = $_REQUEST['cmd'];
$val = $_REQUEST['cmd_value'];
?>
<script type="text/javascript">
    function Set_Command(aurl) {
        $.ajax({
            // type: 'POST',    
            url: aurl + '&callback=?',
            dataType: "json",
        }).done(function(data) {
            ShowMessage('Command Sent');
        });
    }
    ;

    var aurl = 'http://<?php echo $host . ':' . $cmdport ?>?id=<?php echo $id ?>&type=<?php echo $type ?>&cmd=<?php echo $cmd ?>&val=<?php echo $val ?>';
//var aurl='contents/commands/_send.php?url=http://<?php // echo $host.':'.$cmdport  ?>?id=<?php // echo $id  ?>&type=<?php // echo $type ?>&cmd=<?php // echo $cmd ?>&val=<?php // echo $val ?>';
    Set_Command(aurl);
</script>
<?php
include(ROOT_DIR . "/connect/connect_master_db.php");

$log_date = date('d/m/Y H:i:s', time());
$cmdname = $_REQUEST['cmdname'];
$vehiclereg = $_REQUEST['vehiclereg'];

$sql = "INSERT INTO `log_$udb` (`log_id`, `log_data`, `log_date`) VALUES (NULL ,'Send $cmdname to $vehiclereg at ','$log_date');";
$CompanyConn->query($sql);
echo "One log added";
?>