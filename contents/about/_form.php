<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
?>
<div class="contents ui-widget-content">
    <div style="float:right">
        <img src="images/admin/logo.png" height="100px" width="133px"/>
    </div>
    <div style="float:left">
        <p><?php echo ABOUTDESC; ?></p>
    </div>
</div>
<script type="text/javascript">
<?php echo $module ?>Dialog.setOption('title', '<?php echo About ?>');
</script>