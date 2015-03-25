<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include(ROOT_DIR . "/languages/en.php");
include("_start.php");
?>
<div class="contents ui-widget-content">
    <form method="post" id="<?php echo $module ?>form" name= "<?php echo $module ?>form" target="_self" action="" onSubmit="return <?php echo $module ?>onSubmit(this);">
        <table width="100%" height="100%" border="0">
            <tr>
                <td class="ui-state-default" colspan="2" align="center" >Database Configuration</td>
            </tr>
            <tr>
                <td >Database Name</td>
                <td><span id="spry<?php echo $module ?>databasename">
                        <input name="<?php echo $module ?>databasename" type="text" id="<?php echo $module ?>databasename" style="width:100%" maxlength="50" title="Required, Min chars is 4, Max chars is 50" class="inputstyle" />
                        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td>Prefix</td>
                <td><span id="spry<?php echo $module ?>prefix">
                        <input name="<?php echo $module ?>prefix" type="text" id="<?php echo $module ?>prefix" style="width:100%" maxlength="10" title="Min chars is 1, Max chars is 10" class="inputstyle" />
                        <span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td>Host</td>
                <td><span id="spry<?php echo $module ?>host">
                        <input name="<?php echo $module ?>host" type="text" id="<?php echo $module ?>host" style="width:100%" maxlength="50" title="Required, Min chars is 4, Max chars is 50" class="inputstyle"/>
                        <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span></span></td>
            </tr>
            <tr>
                <td>Host User</td>
                <td><span id="spry<?php echo $module ?>hostuser">
                        <input name="<?php echo $module ?>hostuser" type="text" id="<?php echo $module ?>hostuser" style="width:100%" maxlength="50" title="Required, Min chars is 4, Max chars is 50" class="inputstyle" />
                        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td>Host Password</td>
                <td><span id="spry<?php echo $module ?>hostpassword">
                        <input name="<?php echo $module ?>hostpassword" type="password" id="<?php echo $module ?>hostpassword" style="width:100%" maxlength="50" title="Required, Min chars is 4, Max chars is 50" class="inputstyle" />
                        <span class="passwordRequiredMsg"></span><span class="passwordMaxCharsMsg"></span><span class="passwordMinCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td class="ui-state-default" colspan="2" align="center">Primery Account</td>
            </tr>
            <tr>
                <td>IP Address</td>
                <td><span id="spry<?php echo $module ?>ipaddress">
                        <input name="<?php echo $module ?>ipaddress" type="text" id="<?php echo $module ?>ipaddress" style="width:100%" maxlength="50" title="Required, Min chars is 4, Max chars is 50" class="inputstyle"/>
                        <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span></span></td>
            </tr>
            <tr>
                <td>Company Account</td>
                <td><span id="spry<?php echo $module ?>companyname">
                        <input name="<?php echo $module ?>companyname" type="text" id="<?php echo $module ?>companyname" style="width:100%" maxlength="50" title="Required, Min chars is 3, Max chars is 50" class="inputstyle"/>
                        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td>Master Name</td>
                <td><span id="spry<?php echo $module ?>mastername">
                        <input name="<?php echo $module ?>mastername" type="text" id="<?php echo $module ?>mastername" style="width:100%" maxlength="50" title="Required, Min chars is 4, Max chars is 50" class="inputstyle" />
                        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
            </tr>
            <tr>
                <td>Master Password</td>
                <td><span id="spry<?php echo $module ?>masterpassword">
                        <input name="<?php echo $module ?>masterpassword" type="password" id="<?php echo $module ?>masterpassword" style="width:100%" maxlength="50" title="Required, Min chars is 4, Max chars is 50" class="inputstyle" />
                        <span class="passwordRequiredMsg"></span><span class="passwordMaxCharsMsg"></span><span class="passwordMinCharsMsg"></span></span></td>

            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    var spry<?php echo $module ?>databasename = new Spry.Widget.ValidationTextField("spry<?php echo $module ?>databasename", "none", {minChars: 4, maxChars: 50});
    var spry<?php echo $module ?>host = new Spry.Widget.ValidationTextField("spry<?php echo $module ?>host", "ip");
    var spry<?php echo $module ?>hostuser = new Spry.Widget.ValidationTextField("spry<?php echo $module ?>hostuser", "none", {minChars: 4, maxChars: 50});
    var spry<?php echo $module ?>hostpassword = new Spry.Widget.ValidationPassword("spry<?php echo $module ?>hostpassword", {maxChars: 50, minChars: 4});
    var spry<?php echo $module ?>prefix = new Spry.Widget.ValidationTextField("spry<?php echo $module ?>prefix", "none", {minChars: 1, maxChars: 10, isRequired: false});
    var spry<?php echo $module ?>ipaddress = new Spry.Widget.ValidationTextField("spry<?php echo $module ?>ipaddress", "ip");
    var spry<?php echo $module ?>masterpassword = new Spry.Widget.ValidationPassword("spry<?php echo $module ?>masterpassword", {maxChars: 50, minChars: 4});
    var spry<?php echo $module ?>mastername = new Spry.Widget.ValidationTextField("spry<?php echo $module ?>mastername", "none", {minChars: 4, maxChars: 50});
    var spry<?php echo $module ?>companyname = new Spry.Widget.ValidationTextField("spry<?php echo $module ?>companyname", "none", {minChars: 3, maxChars: 50});
</script>
<script type="text/javascript">

    function <?php echo $module ?>response(req) {
        ShowMessage(req.xhRequest.responseText);
        location.reload();
    }
    ;

    function <?php echo $module ?>onSubmit(form) {
        if (Spry.Widget.Form.validate(form) == true) {

            Spry.Utils.submitForm(form, <?php echo $module ?>response);
            form.reset();
        }
        return false;
    }
    ;

    function <?php echo $module ?>install() {
        document.<?php echo $module ?>form.action = 'contents/setup/_cmd.php';
        $('#<?php echo $module ?>form').submit();
    }

    function <?php echo $module ?>reset() {
        $('#<?php echo $module ?>form')[0].reset();
    }

</script>
<script type="text/javascript">
    $(document).ready(function(e) {

<?php echo $module ?>Dialog.addButton('<?php echo $module ?>install', 'install', '<?php echo $module ?>install', 'save');
<?php echo $module ?>Dialog.addButton('<?php echo $module ?>reset', '<?php echo Reset ?>', '<?php echo $module ?>reset', 'reset');

<?php echo $module ?>Dialog.setOption('title', 'Setup');

            });
</script>