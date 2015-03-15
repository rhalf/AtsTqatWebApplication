<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
include(ROOT_DIR . "/connect/connection.php");

$CompanyInfoStatment = $Conn->query("SELECT cmpname,cmpemail,cmpphoneno,cmpmobileno,cmpaddress,cmpdisplayname FROM cmps where cmpdbname='$companyDB'");
$CompanyInfoStatmentRow = $CompanyInfoStatment->fetch(PDO::FETCH_ASSOC);

$CompanyConn = null;

$code = $module;
?>
<script type="text/javascript">
    $(function() {

<?php echo $code ?>Dialog.addButton('<?php echo $code ?>save', '<?php echo Save ?>', '<?php echo $code ?>Save', 'save');
<?php echo $code ?>Dialog.addButton('<?php echo $code ?>close', '<?php echo Close ?>', '<?php echo $code ?>Close', 'close');
    });
</script>

<script type="text/javascript">


    function <?php echo $code ?>Response(req) {
        ShowMessage(req.xhRequest.responseText);
        $('.header-info').html(geturl("main/main_header_info.php"));
<?php echo $code ?>Close();
            }

            function <?php echo $code ?>OnSubmit(form) {
                if (Spry.Widget.Form.validate(form) == true) {
                    Spry.Utils.submitForm(form, <?php echo $code ?>Response);
                }
                return false;
            }
            function <?php echo $code ?>Save() {
                $('#<?php echo $code ?>form').submit();
            }

            function <?php echo $code ?>Close() {
<?php echo $code ?>Dialog.Close();
            }
<?php echo $code ?>Dialog.setOption('title', '<?php echo CompanyInfo ?>');
</script>
<div class="contents ui-widget-content" style="direction:<?php echo text_direction ?>">
    <form id="<?php echo $code ?>form" name="<?php echo $code ?>form" action="contents/companyinfo/_cmd.php" method="post" target="_self" onSubmit="return <?php echo $code ?>OnSubmit(this);">
        <table width="100%" border="0">
            <tr>
                <td width="93" height="34"><label for="ci_name"><?php echo constant($module . 'Account'); ?></label></a></td>
                <td width="260"><span id="spryci_name">
                        <input name="ci_name" type="text"  id="ci_name"  style="width:90%" title="Required, Min chars is 4, Max chars is 50" value="<?php
                        echo $CompanyInfoStatmentRow['cmpname'];
                        ?>" maxlength="50" class="inputstyle" disabled="disabled" />
                        <span class="textfieldRequiredMsg"></span></span></td>
            </tr>
            <tr>
                <td width="93" height="34"><label for="ci_dispalyname"><?php echo constant($module . 'DisplayName') ?></label></td>
                <td width="260"><span id="spryci_displayname">
                        <input name="ci_displayname" type="text"  id="ci_displayname"style="width:90%" title="Required, Min chars is 4, Max chars is 50"  value="<?php
                        echo $CompanyInfoStatmentRow['cmpdisplayname'];
                        ?>" maxlength="50" class="inputstyle" />
                        <span class="textfieldRequiredMsg"></span></span></td>
            </tr>
            <tr>
                <td width="93" height="34"><label for="ci_email"><?php echo constant($module . 'Email') ?></label></td>
                <td width="260"><span id="spryci_email">
                        <input type="text" name="ci_email" id="ci_email" style="width:90%" value="<?php
                               echo $CompanyInfoStatmentRow['cmpemail'];
                        ?>" title="Min chars is 5, Max chars is 50, E-mail format" class="inputstyle" />
                        <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span></span></td>
            </tr>
            <tr>
                <td width="93" height="34"><label for="ci_phoneno"><?php echo constant($module . 'PhoneNo') ?></label></td>
                <td width="260"><input type="text" name="ci_phoneno" id="ci_phoneno" style="width:90%" value="<?php
                               echo $CompanyInfoStatmentRow['cmpphoneno'];
                               ?>" title="Min chars is 5, Max chars is 50, E-mail format" class="inputstyle"></td>
            </tr>
            <tr>
                <td width="93" height="34"><label for="ci_mobileno"><?php echo constant($module . 'MobileNo') ?></label></td>
                <td width="260"><input type="text" name="ci_mobileno" id="ci_mobileno" style="width:90%" value="<?php
                    echo $CompanyInfoStatmentRow['cmpmobileno'];
                    ?>" title="Min chars is 5, Max chars is 50, E-mail format" class="inputstyle"></td>
            </tr>
            <tr>
                <td width="93" height="34"><label for="ci_address"><?php echo constant($module . 'Address') ?></label></td>
                <td width="260"><textarea name="ci_address" class="inputstyle" id="ci_address" style="width:90%" title="Min chars is 5, Max chars is 50, E-mail format"><?php
                    echo $CompanyInfoStatmentRow['cmpaddress'];
                    ?>
                    </textarea></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    var spryci_name = new Spry.Widget.ValidationTextField("spryci_name");
    var spryci_displayname = new Spry.Widget.ValidationTextField("spryci_displayname");
    var spryci_email = new Spry.Widget.ValidationTextField("spryci_email", "email");
</script>
