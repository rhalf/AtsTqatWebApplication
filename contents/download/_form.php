<?php
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
?>
<div class="contents ui-widget-content">
    <table width="100%" border="0" align="left">
        <tr>
            <td align="left" width="90%"><input name="download32x" id="download32x" type="button" value="Download 32bit" onclick="javascript:download('/32/setup.exe')" /></td>
        </tr>
        <tr>
            <td align="left"><input name="download64x" id="download64x" type="button" value="Download 64bit" onclick="javascript:download('/64/setup.exe')" /></td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    function <?php echo $module ?>Close() {
<?php echo $module ?>Dialog.Close();

    }
    ;

    $(function() {
        $('#downloadBtn').button();
        $("#download32x").button();
        $("#download64x").button();


<?php echo $module ?>Dialog.addButton('<?php echo $module ?>close', '<?php echo Close ?>', '<?php echo $module ?>Close', 'close');

<?php echo $module ?>Dialog.setOption('title', '<?php echo Download ?>');

    });
</script>