<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
?>
<div>Are you sure?</div>
<script type="text/javascript">
    $(function() {
        ConfirmDialog.addButton('ConfirmOk', '<?php echo Ok ?>', 'ConfirmOk', 'save');
        ConfirmDialog.addButton('ConfirmClose', '<?php echo Close ?>', 'ConfirmClose', 'close'
                );
        ConfirmDialog.setOption('title', 'Confirm');

    });

    function ConfirmOk() {
        Spry.Utils.submitForm(document.forms['<?php echo $module ?>form'], <?php echo $module ?>Response);
<?php echo $module ?>Reset();
        ConfirmDialog.Close();
    }
    function ConfirmClose() {
<?php echo $module ?>Reset();
        ConfirmDialog.Close();
    }

</script>